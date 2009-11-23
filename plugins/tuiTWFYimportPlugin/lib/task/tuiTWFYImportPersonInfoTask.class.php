<?php

class tuiTWFYImportPersonInfoTask extends sfDoctrineBaseTask
{


  protected function configure()
  {
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      
    ));

    $this->namespace = 'twfy';
    $this->name = 'person-info';
    $this->briefDescription = 'Add info from getPerson to newly imported people';

    $this->detailedDescription = <<<EOF
The [twfy:person-info|INFO] task uses the TheyWorkForYou API to retrieve
a number of fields from TWFY's data store to enrich newly created Entities.
Currently we process the following fields from getPerson:
 - house (1: commons, 2: lords, etc)
 - party
 - title + first_name + last_name
 - entered_house
 - left_house
 
These are added as Fact objects.

Because getPerson only retrieves one person at a time, this method can take
some time to do an import. The rate-limit is 1 hit per second (configurable
in app.yml).

This task works only on Entities in the EntityCreationQueue table which
have the 'person' field set to 'pending'.

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
    $employment_type = Doctrine::getTable('FactType')->findOneByType('Employment');
    $source_type = Doctrine::getTable('SourceType')->findOneByType('Public record');
    
    
    if (!$creator) {
      throw new sfCommandException("Couldn't find twfy_bot user.");
    }
    
    if (!$employment_type) {
      throw new sfCommandException("Couldn't find 'Employment' fact type.");
    }
    
    if (!$source_type) {
      throw new sfCommandException("Couldn't find 'Public record' source type.");
    }
    
    
    // Fetch queue + Entity
    $q = Doctrine_Query::create()
          ->select('q.*, e.*, u.*')
          ->from('EntityCreationQueue q')
          ->innerJoin('q.Entity e')
          ->innerJoin('e.Urls u with u.urltype = ?', 'theyworkforyou')
          ->where('q.person = ?', 'pending');

    foreach($q->execute() as $q)
    {

      print 'getPerson for '.$q['Entity']['name'];

      $person_id = $q['Entity']['Urls'][0]['foreign_id'];
      print ' [person_id: '.$person_id.']';
      
      // Update queue - active
      $q['person'] = 'active';
      $q->save();

      // Make request, check result
      $url = sprintf('http://www.theyworkforyou.com/api/getPerson?output=php&key=%s&id=%d', $key, $person_id);
      $person_info = unserialize(tuiTWFYRequest::get($url));
      
      if (!is_array($person_info)) {
        throw new sfCommandException('Invalid response for person_id '.$person_id);
      }
      
      
      // Set up aliases and offices
      $names = array($q['Entity']['name']);
      foreach($q['Entity']['Aliases'] as $a)
      {
        $names[] = $a['name'];
      }
      
      
      $offices = array();
      
      
      // Step through results.
      foreach($person_info as $i)
      {
        // Check name/aliases
        $name = utf8_encode(sprintf('%s %s', $i['first_name'], $i['last_name']));
        if (!in_array($name, $names))
        {
          echo PHP_EOL.'  Generating alias: '.$name.PHP_EOL;
          $a = new EntityAlias;
          $a->set('entity_id', $q['Entity']['id'])
            ->set('created_by', $creator['id'])
            ->set('name', $name);
          $a->save();

          $names[] = $name;
        }
        
        // Create MP fact
        if ($i['house'] == 1 && $i['constituency'])
        {
          $f = new Fact;
          $f->set('entity_id', $q['Entity']['id'])
            ->set('created_by', $creator['id'])
            ->set('fact_type_id', $employment_type['id'])
            ->set('description', "{$i['party']} MP for {$i['constituency']}")
            ->set('start', date_create($i['entered_house'])->format('Y-m-d'));

          if ($i['party'] && $i['party'] != 'Independent')
          {
            $party = $this->getEntityOrCreate($i['party'], 'party');
            $f->set('related_entity_id', $party['id']);
          } 

          if ($i['left_house'] && $i['left_house'] != '9999-12-31')
          {
            $f->set('title', "was MP for {$i['constituency']}");
            $f->set('end', date_create($i['left_house'])->format('Y-m-d'));
          } else {
            $f->set('title', "is MP for {$i['constituency']}");
            
          }
          
          
          $f->save();
          
          // Fact source
          $fs = new FactSource;
          $fs->set('fact_id', $f['id'])
             ->set('url', 'http://www.theyworkforyou.com/mp/?pid='.$person_id)
             ->set('source_type_id', $source_type['id'])
             ->set('is_supporting', true)
             ->set('title', 'TheyWorkForYou: '.$q['Entity']['name'])
             ->set('created_by', $creator['id']);

          $fs->save();
          

        }
        
        
        // Create Lord fact
        if ($i['house'] == 2)
        {
          $f = new Fact;
          $f->set('entity_id', $q['Entity']['id'])
            ->set('created_by', $creator['id'])
            ->set('fact_type_id', $employment_type['id'])
            ->set('title', "{$i['party']} Peer")
            ->set('description', "{$i['party']} Peer")
            ->set('start', date_create($i['entered_house'])->format('Y-m-d'));
          if ($i['left_house'] && $i['left_house'] != '9999-12-31')
          {
            $f->set('end', date_create($i['left_house'])->format('Y-m-d'));
          }
          if ($i['party'] && $i['party'] != 'Independent')
          {
            $party = $this->getEntityOrCreate($i['party'], 'party');
            $f->set('related_entity_id', $party['id']);
          }
          
          $f->save();
          
          // Fact source
          $fs = new FactSource;
          $fs->set('fact_id', $f['id'])
             ->set('url', 'http://www.theyworkforyou.com/peer/?pid='.$person_id)
             ->set('source_type_id', $source_type['id'])
             ->set('is_supporting', true)
             ->set('title', 'TheyWorkForYou: '.$q['Entity']['name'])
             ->set('created_by', $creator['id']);

          $fs->save();
                  
        }
        
        
        // Create Offices
        if (isset($i['office']) && count($i['office']))
        {
          foreach($i['office'] as $o)
          {
            if (in_array($o['moffice_id'], $offices)) 
            {
              continue; // Skip it, we already have it
            }

            $f = new Fact;
            $f->set('entity_id', $q['Entity']['id'])
              ->set('fact_type_id', $employment_type['id'])
              ->set('created_by', $creator['id'])
              ->set('title', 'is a member'.$o['dept'].($o['position'] ? " ({$o['position']}) of" : ' of'))
              ->set('description', 'Member of: '.$o['dept'].($o['position'] ? " ({$o['position']})" : ''))
              ->set('start', date_create($o['from_date'])->format('Y-m-d'));
            $committee = $this->getEntityOrCreate($o['dept'], 'committee');
            $f->set('related_entity_id', $committee['id']);
            if ($o['to_date'] && $o['to_date'] != '9999-12-31')
            {
              $f->set('end', date_create($i['to_date'])->format('Y-m-d'));
            }
            $f->save();
            
            $fs = new FactSource;
            $fs->set('fact_id', $f['id'])
               ->set('url', 'http://www.theyworkforyou.com/mp/?pid='.$person_id)
               ->set('source_type_id', $source_type['id'])
               ->set('is_supporting', true)
               ->set('title', 'TheyWorkForYou: '.$q['Entity']['name'])
               ->set('creator_id', $creator['id']);

            $fs->save();
            
          }
          
        }
        
        
      }
      
      
      // Update queue - done
      $q['person'] = 'done';
      $q->save();
      print PHP_EOL;
    }

    
  }
  
  
  
  private function getEntityOrCreate($name, $type = 'party')
  {
    $thing = Doctrine::getTable('Entity')->findOneByName($name);
    if ($thing) { return $thing; }
    
    $thing = new Entity;
    $thing['name'] = $name;
    $thing['Creator'] = PluginsfGuardUserTable::retrieveByUsername('twfy_bot');
    
    if ($type == 'party')
    {
      $thing['EntityType'] = Doctrine::getTable('EntityType')->findOneByTitle('Political party');
    } elseif ($type == 'committee') {
      $thing['EntityType'] = Doctrine::getTable('EntityType')->findOneByTitle('Committee');
    }

    $thing->save();
    
    return $thing;
  }
  
}
