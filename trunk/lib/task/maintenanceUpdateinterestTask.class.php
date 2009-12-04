<?php

class maintenanceUpdateinterestTask extends sfBaseTask
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
    $this->name             = 'update-interest';
    $this->briefDescription = 'Update interest field on entities and stories';
    $this->detailedDescription = <<<EOF
The [maintenance:entity-interest|INFO] task does things.
Call it with:

  [php symfony maintenance:entity-interest|INFO]
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

    // Calculate percentage of current page against highest viewcount
    $max = $connection->query('SELECT MAX(views) FROM entity')->fetchColumn();

    if (!$max)
    {
      throw new Exception('maintenance:update-interest task failed - entity max-views query returned no data');
    }
    
    $stmt = $connection->prepare('UPDATE entity SET interest = round((views / :max) * 100) WHERE views > 0');
    $stmt->bindValue(':max', $max);
    $stmt->execute();
    
    
    
    // Calculate percentage of current page against highest viewcount
    $max = $connection->query('SELECT MAX(views) FROM story')->fetchColumn();

    if (!$max)
    {
      throw new Exception('maintenance:update-interest task failed - story max-views query returned no data');
    }
    
    $stmt = $connection->prepare('UPDATE story SET interest = round((views / :max) * 100) WHERE views > 0');
    $stmt->bindValue(':max', $max);
    $stmt->execute();
  }
}
