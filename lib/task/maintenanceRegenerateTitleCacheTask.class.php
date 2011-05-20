<?php

class maintenanceRegenerateTitleCacheTask extends sfBaseTask
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
    $this->name             = 'regenerateTitleCache';
    $this->briefDescription = 'Rebuild the A-Z story title cache';
    $this->detailedDescription = <<<EOF
The [maintenance:regenerateTitleCache|INFO] task rebuilds the cache table
used to do quick next/previous lookups. It should be run periodically as a
scheduled task.

Call it with:

  [php symfony maintenance:regenerateTitleCache|INFO]
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

    $sql = "DROP TABLE if exists nextprev_az";
    $connection->exec($sql);
    
    $sql = "CREATE TABLE nextprev_az ( id integer(8) not null auto_increment primary key, sid integer(8) not null, title varchar(255) not null, slug varchar(255) not null ) character set utf8";
    $connection->exec($sql);

    $sql = "INSERT INTO nextprev_az (id, sid, title, slug) SELECT null, id, title, slug FROM story";
    $connection->exec($sql);
  }
}
