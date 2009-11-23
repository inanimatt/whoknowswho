<?php

class maintenanceCheckEntitiesTask extends sfBaseTask
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
    $this->name             = 'check-entities';
    $this->briefDescription = 'Check entity information completeness and update the entity_action_required table.';
    $this->detailedDescription = <<<EOF
The [maintenance:check-entities|INFO] task checks the completeness of each
entity in the database, and updates a table reflecting the tasks that need
performing for that entity (such as adding a Wikipedia URL).

Call it with:

  [php symfony maintenance:check-entities|INFO]
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

    $doctrineConnection = Doctrine_Manager::connection();

    $action = array();

    // No wikipedia URL
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('e.id NOT IN (SELECT u.entity_id FROM EntityUrl u WHERE u.urltype = ?)')
          ->execute(array('wikipedia'), Doctrine::HYDRATE_NONE);

    foreach($q as $r) {
      $action[ $r[0] ] = array('entity_id' => $r[0], 'needs_wiki_page' => 0, 'needs_external_links' => 0, 'needs_description' => 0, 'needs_facts' => 0, 'needs_subtitle' => 0);
      $action[ $r[0] ]['needs_external_links'] = 1;
    }


    // No URLs apart from wikipedia ones
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('e.id NOT IN (SELECT u.entity_id FROM EntityUrl u WHERE u.urltype != ?)')
          ->execute(array('wikipedia'), Doctrine::HYDRATE_NONE);
    
    foreach($q as $r) {
      if (!isset($action[ $r[0] ])) {
        $action[ $r[0] ] = array('entity_id' => $r[0], 'needs_wiki_page' => 0, 'needs_external_links' => 0, 'needs_description' => 0, 'needs_facts' => 0, 'needs_subtitle' => 0);
      }
      $action[ $r[0] ]['needs_external_links'] = 1;
    }

    
    // Description required
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('description IS NULL')
          ->orWhere('description = ""')
          ->execute(array(), Doctrine::HYDRATE_NONE);
    
    foreach($q as $r) {
      if (!isset($action[ $r[0] ])) {
        $action[ $r[0] ] = array('entity_id' => $r[0], 'needs_wiki_page' => 0, 'needs_external_links' => 0, 'needs_description' => 0, 'needs_facts' => 0, 'needs_subtitle' => 0);
      }
      $action[ $r[0] ]['needs_description'] = 1;
    }
    
    // Description required
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('subtitle IS NULL')
          ->orWhere('subtitle = ""')
          ->execute(array(), Doctrine::HYDRATE_NONE);
    
    foreach($q as $r) {
      if (!isset($action[ $r[0] ])) {
        $action[ $r[0] ] = array('entity_id' => $r[0], 'needs_wiki_page' => 0, 'needs_external_links' => 0, 'needs_description' => 0, 'needs_facts' => 0, 'needs_subtitle' => 0);
      }
      $action[ $r[0] ]['needs_subtitle'] = 1;
    }
    
    
    // Facts required
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('e.id NOT IN (SELECT f.entity_id FROM Fact f)')
          ->execute(array(), Doctrine::HYDRATE_NONE);
    
    foreach($q as $r) {
      if (!isset($action[ $r[0] ])) {
        $action[ $r[0] ] = array('entity_id' => $r[0], 'needs_wiki_page' => 0, 'needs_external_links' => 0, 'needs_description' => 0, 'needs_facts' => 0, 'needs_subtitle' => 0);
      }
      $action[ $r[0] ]['needs_facts'] = 1;
    }
    
    
    // Replace the entity action required table
    Doctrine_Query::create()->delete('EntityActionRequired ear')->execute();

    // Use PDO, since we don't need objects here
    $stmt = $connection->prepare('INSERT INTO entity_action_required (entity_id, needs_wiki_page, needs_external_links, needs_description, needs_facts, needs_subtitle) VALUES (:entity_id, :needs_wiki_page, :needs_external_links, :needs_description, :needs_facts, :needs_subtitle)');

    foreach($action as $data)
    {
      foreach($data as $key => $value)
      {
        $stmt->bindValue(':'.$key, $value);
      }
      $stmt->execute();
    }
  }
}
