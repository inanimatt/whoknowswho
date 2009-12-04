<?php

class maintenanceCheckFactsTask extends sfBaseTask
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
    $this->name             = 'check-facts';
    $this->briefDescription = 'Check fact information completeness and update the fact_action_required table.';
    $this->detailedDescription = <<<EOF
The [maintenance:check-facts|INFO] task checks the completeness of each
fact in the database, and updates a table reflecting the tasks that need
performing for that fact (such as adding supporting sources).

Call it with:

  [php symfony maintenance:check-facts|INFO]
EOF;
  }
  
  
  

  protected function execute($arguments = array(), $options = array())
  {
    if (!tuiCronUtils::claimSlot($this->name))
    {
      exit;
    }
    
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $doctrineConnection = Doctrine_Manager::connection();

    $action = array();

    // No supporting sources
    $q = Doctrine_Query::create()
          ->select('f.id')
          ->from('Fact f')
          ->where('f.id NOT IN (SELECT fs.fact_id FROM FactSource fs WHERE fs.is_supporting = ?)')
          ->execute(array(1), Doctrine::HYDRATE_NONE);

    foreach($q as $r) {
      $action[ $r[0] ] = array('fact_id' => $r[0], 'needs_sources' => 0, 'needs_description' => 0);
      $action[ $r[0] ]['needs_sources'] = 1;
    }


    
    // Description required
    $q = Doctrine_Query::create()
          ->select('f.id')
          ->from('Fact f')
          ->where('f.description IS NULL')
          ->orWhere('f.description = ?')
          ->execute(array(''), Doctrine::HYDRATE_NONE);
    
    foreach($q as $r) {
      if (!isset($action[ $r[0] ])) {
        $action[ $r[0] ] = array('fact_id' => $r[0], 'needs_sources' => 0, 'needs_description' => 0);
      }
      $action[ $r[0] ]['needs_description'] = 1;
    }
    



    
    // Replace the entity action required table
    Doctrine_Query::create()->delete('FactActionRequired far')->execute();

    // Use PDO, since we don't need objects here
    $stmt = $connection->prepare('INSERT INTO fact_action_required (fact_id, needs_sources, needs_description) VALUES (:fact_id, :needs_sources, :needs_description)');

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
