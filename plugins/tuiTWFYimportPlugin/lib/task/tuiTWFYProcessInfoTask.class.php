<?php

class tuiTWFYProcessInfoTask extends sfDoctrineBaseTask
{


  protected function configure()
  {
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      
    ));

    $this->namespace = 'twfy';
    $this->name = 'process-info';
    $this->briefDescription = 'Add info from getMPsInfo to newly imported people';

    $this->detailedDescription = <<<EOF
The [twfy:process-info|INFO] task uses the TheyWorkForYou API to retrieve
a number of fields from TWFY's data store to enrich newly created Entities.
Currently we process the following fields from getMPsInfo:
 - date_of_birth
 - bbc_profile_url
 - guardian_mp_summary
 - mp_website
 - wikipedia_url
These are added as Fact or EntityURL objects.

This task works only on Entities in the EntityCreationQueue table which
have the mp_info field set to 'pending'.

The application config must have the API key set under app_twfy_apikey
EOF;
    
    
  }
  
  
  
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    
    // config:
    
    $key = sfConfig::get('app_twfy_api_key',null);
    if (!$key)
    {
      throw new sfCommandException('API Key not found');
    }
    
    // Get creator  'constants'
    
    $creator = PluginsfGuardUserTable::retrieveByUsername('twfy_bot');
    $dob_fact_type = Doctrine::getTable('FactType')->findOneByType('Biographical/Historical');
    $source_type = Doctrine::getTable('SourceType')->findOneByType('Public record');
    
    
    if (!$creator) {
      throw new sfCommandException("Couldn't find twfy_bot user.");
    }
    
    if (!$dob_fact_type) {
      throw new sfCommandException("Couldn't find 'Biographical/Historical' fact type.");
    }
    
    
    
    // Get (up to) 50 Entities to update. 
    // select eu.* from entity_url eu join entity_creation_queue q on eu.entity_id = q.entity_id where q.mp_info = 'pending' limit 50
    // $q = new Doctrine_RawSql();
    // $q->select('{eu.*}, {q.*}')
    //   ->from('entity_url eu INNER JOIN entity_creation_queue q ON eu.entity_id = q.entity_id')
    //   ->where('q.mp_info = ?', 'pending')
    //   ->andWhere('eu.urltype = ?', 'theyworkforyou')
    //   ->andWhere('eu.foreign_id IS NOT null')
    //   ->addComponent('eu', 'EntityUrl')
    //   ->addComponent('q', 'EntityCreationQueue')
    //   ->limit(50);
    
    $q = Doctrine_Query::create()
          ->select('q.*, e.*')
          ->from('EntityCreationQueue q')
          ->leftJoin('q.Entity e')
          ->where('q.mp_info = ?', 'pending')
          ->limit(50);
    
    
    $person_ids_to_entity_ids = array();
    $queue = array();
    foreach($q->execute() as $queue_item)
    {
      $queue[ $queue_item['Entity']['id'] ] = $queue_item;
      
      // Use the TWFY entity URL to get the person_id
      foreach($queue_item['Entity']['Urls'] as $u) {
        if ($u['urltype'] == 'theyworkforyou' && $u['foreign_id']) {
          $person_ids_to_entity_ids[$u['foreign_id']] = $u['entity_id'];
          break;
        }
      }
      
      $queue_item['mp_info'] = 'active';
      $queue_item->save();
      
    }
    
    
    if (!count($person_ids_to_entity_ids)) {
      print 'Nothing to do.'.PHP_EOL;
      exit;
    }
    
    print "Processing ".count($person_ids_to_entity_ids).PHP_EOL;
    
    
    
    // Fetch info 
    $url = sprintf('http://www.theyworkforyou.com/api/getMPsInfo?key=%s&output=php&id=%s&fields=bbc_profile_url,date_of_birth,guardian_mp_summary,mp_website,wikipedia_url',$key,join(',',array_keys($person_ids_to_entity_ids)));

    $person_info = unserialize(tuiTWFYRequest::get($url));
    
    
    if (!is_array($person_info)) 
    {
      throw new sfCommandException('Unexpected result format.');
    }
    
    foreach($person_info as $pid => $pdata)
    {
      $entity_id = $person_ids_to_entity_ids[$pid];
      $queue_item = $queue[$entity_id];
      
      
      if (!isset($pdata['by_member_id'])) {
        $pdata['by_member_id'] = array($pdata);
      }
      
      foreach($pdata['by_member_id'] as $p)
      {
      
      
        // Create URLs
        if (isset($p['bbc_profile_url']))
        {
          $u = new EntityUrl;
          $u->set('title', 'BBC MP Profile')
            ->set('urltype', 'bbc_profile')
            ->set('url', $p['bbc_profile_url'])
            ->set('entity_id', $queue_item['Entity']['id'])
            ->set('created_by', $creator['id']);
          $u->save();
        }


        if (isset($p['guardian_mp_summary']))
        {
          $u = new EntityUrl;
          $u->set('title', 'Guardian MP Summary')
            ->set('urltype', 'guardian_mp_summary')
            ->set('url', $p['guardian_mp_summary'])
            ->set('entity_id', $queue_item['Entity']['id'])
            ->set('created_by', $creator['id']);
          $u->save();
        }
      
        if (isset($p['wikipedia_url']))
        {
          $u = new EntityUrl;
          $u->set('title', 'Wikipedia page')
            ->set('urltype', 'wikipedia')
            ->set('url', $p['wikipedia_url'])
            ->set('entity_id', $queue_item['Entity']['id'])
            ->set('created_by', $creator['id']);
          $u->save();
        }

            
        if (isset($p['mp_website']))
        {
          $u = new EntityUrl;
          $u->set('title', 'Personal site')
            ->set('urltype', 'personal')
            ->set('url', $p['mp_website'])
            ->set('entity_id', $queue_item['Entity']['id'])
            ->set('created_by', $creator['id']);
          $u->save();
        }

            
        // Create Facts
        if (isset($p['date_of_birth']))
        {
          $f = new Fact;
          $f->set('title', 'was born: '.$p['date_of_birth'])
            ->set('start', date_create(str_replace(',','',$p['date_of_birth']))->format('Y-m-d'))
            ->set('fact_type_id', $dob_fact_type['id'])
            ->set('created_by', $creator['id'])
            ->set('description', sprintf("%s was born on %s", $queue_item['Entity']['name'], date_create(str_replace(',','',$p['date_of_birth']))->format('l jS F Y')))
            ->set('Entity', $queue_item['Entity']);
          $f->save();
          

          $fs = new FactSource;
          $fs->set('url', 'http://www.theyworkforyou.com/mp/?pid='.$pid)
             ->set('fact_id', $f['id'])
             ->set('source_type_id', $source_type['id'])
             ->set('is_supporting', true)
             ->set('title', 'TheyWorkForYou: '.$queue_item['Entity']['name'])
             ->set('created_by', $creator['id']);

          $fs->save();
           
        }
       
       
      }
      
      // Update queue status
      
      $queue_item['mp_info'] = 'done';
      $queue_item->save();

    }
    

    
    
  }
  
  
}
