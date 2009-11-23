<?php

class tuiTWFYImportTask extends sfDoctrineBaseTask
{


  protected function configure()
  {
    
    $this->addArguments(array(
      new sfCommandArgument('method', sfCommandArgument::OPTIONAL, 'The API method (e.g. getMPs, getLords...)', 'getMPs'),
      new sfCommandArgument('date', sfCommandArgument::OPTIONAL, 'Get the list as it was on this date', null),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      
    ));

    $this->namespace = 'twfy';
    $this->name = 'import';
    $this->briefDescription = 'Import people from TheyWorkForYou.com';

    $this->detailedDescription = <<<EOF
The [twfy:import|INFO] task uses the TheyWorkForYou API to retrieve a list
of MPs, Lords, MSPs, etc, and adds new Entities to the database. It also 
creates EntityURLs with the ForeignId field set to prevent duplication. 

  [./symfony twfy:import getMPs|INFO]

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
    
    
    
    
    // Retrieve list
    $mp_list_url = sprintf('http://www.theyworkforyou.com/api/%s?key=%s&output=php',$arguments['method'],$key);
    if ($arguments['date']) {
      $mp_list_url .= '&date='.urlencode($arguments['date']);
    }

    $list = unserialize(tuiTWFYRequest::get($mp_list_url));

    if (!is_array($list)) 
    {
      throw new sfCommandException('Unexpected result format.');
    }
    
    
    
    
    // Get creator and entity type 'constants'
    
    $creator = PluginsfGuardUserTable::retrieveByUsername('twfy_bot');
    $entity_type = Doctrine::getTable('EntityType')->findOneByTitle('Person');
    
    if (!$creator) {
      throw new sfCommandException("Couldn't find twfy_bot user.");
    }
    
    if (!$entity_type) {
      throw new sfCommandException("Couldn't find Person type.");
    }

    
    
    
    
    // Step through the list and create entities.
    
    foreach($list as $person) 
    {
      
      print utf8_encode($person['name']);
      
      // Skip if the person exists (unambiguously from this source)
      $q = Doctrine_Query::create()
            ->select('eu.*')
            ->from('EntityUrl eu')
            ->where('eu.urltype = ?', 'theyworkforyou')
            ->andWhere('eu.foreign_id = ?', $person['person_id']);

      $result = $q->execute()->getFirst();
            
      if ($result) {
        print "...found, skipping".PHP_EOL;
        continue;
      }
      
      print "...not found, creating";
      
      // Otherwise create entity
      
      $j = new EntityCreationQueue;
      $e = $j['Entity']->set('EntityType', $entity_type)
            ->set('created_by', $creator['id'])
            ->set('name', utf8_encode($person['name']))
            ->set('version_comment', 'Auto-generation by TWFYBot');
      
      $u = new EntityUrl;
      $u->set('title', 'TheyWorkForYou profile')
        ->set('foreign_id', $person['person_id'])
        ->set('urltype', 'theyworkforyou')
        ->set('url', sprintf('http://www.theyworkforyou.com/mp/?pid=%d', $person['person_id']))
        ->set('created_by', $creator['id']);
      $e->Urls[] = $u;
        
      
      try {
       $j->save();
      } catch (Exception $e) {
        print "...error:".PHP_EOL;
        throw $e;
      }
      
      print "...done.".PHP_EOL;
      
    }
    
    
    
  }
  
  
}
