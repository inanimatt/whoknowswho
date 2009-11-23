<?php

class maintenanceReindexTask extends sfBaseTask
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
    $this->name             = 'reindex';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [maintenance:reindex|INFO] task updates the search index.
Call it with:

  [php symfony maintenance:reindex|INFO]
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

    // add your code here
    $storyTable = Doctrine::getTable('Story');
    $storyTable->batchUpdateIndex();
    
    $entityTable = Doctrine::getTable('Entity');
    $entityTable->batchUpdateIndex();
    
    $entityAliasTable = Doctrine::getTable('EntityAlias');
    $entityAliasTable->batchUpdateIndex();
    
    
  }
}
