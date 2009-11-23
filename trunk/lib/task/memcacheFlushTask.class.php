<?php

class maintenanceFlushmemcacheTask extends sfBaseTask
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

    $this->namespace        = 'memcache';
    $this->name             = 'flush';
    $this->briefDescription = 'Reset the memcached server(s)';
    $this->detailedDescription = <<<EOF
The [memcache:flush|INFO] task clears all cache data from the memcached server(s).
Call it with:

  [php symfony maintenance:flush-memcache|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    print "Flushing cache...".PHP_EOL;
    tuiCacheHandler::getInstance()->flush();
  }
}
