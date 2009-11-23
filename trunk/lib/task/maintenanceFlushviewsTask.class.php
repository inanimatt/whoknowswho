<?php

class maintenanceFlushviewsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      // add your own options here
    ));

    $this->namespace        = 'maintenance';
    $this->name             = 'flush-views';
    $this->briefDescription = 'Write entity views from memcache to database';
    $this->detailedDescription = <<<EOF
The [maintenance:flush-views|INFO] task increments the 'view' entries for
stories and entities with data stored in the memory cache.
Call it with:

  [php symfony maintenance:flush-views|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    if (!tuiCronUtils::claimSlot('update-interest'))
    {
      exit;
    }
    
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $cache = tuiCacheHandler::getInstance();

    $entity_list = $cache->get('entity-views-list');
    if ($entity_list)
    {
      $stmt = $connection->prepare('UPDATE entity SET views = views + :views WHERE id = :entity_id');
      $count = 0;
      foreach($entity_list as $entry)
      {
        $views = $cache->get('entity-views-'.$entry);
        if ($views) 
        {
          $count += $views;
          $stmt->bindValue(':entity_id', $entry);
          $stmt->bindValue(':views', $views);
          $stmt->execute();
          $cache->getHandler()->delete('entity-views-'.$entry);
        }
      }

      $cache->set('entity-views-list', array());
    }
    

    $entity_list = $cache->get('story-views-list');
    if ($entity_list)
    {
      $stmt = $connection->prepare('UPDATE story SET views = views + :views WHERE id = :story_id');
      $count = 0;
      foreach($entity_list as $entry)
      {
        $views = $cache->get('story-views-'.$entry);
        if ($views) 
        {
          $count += $views;
          $stmt->bindValue(':story_id', $entry);
          $stmt->bindValue(':views', $views);
          $stmt->execute();
          $cache->getHandler()->delete('story-views-'.$entry);
        }
      }

      $cache->set('story-views-list', array());
    }
    
    
  }
}
