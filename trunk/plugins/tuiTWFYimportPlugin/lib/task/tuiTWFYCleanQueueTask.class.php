<?php

class tuiTWFYCleanQueueTask extends sfDoctrineBaseTask
{


  protected function configure()
  {
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      
    ));

    $this->namespace = 'twfy';
    $this->name = 'clean-queue';
    $this->briefDescription = 'Clean entity creation queue';

    $this->detailedDescription = <<<EOF
The [twfy:clean-queue|INFO] task removes finished entries from the 
EntityCreationQueue table.
EOF;
    
    
  }
  
  
  
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    
    
    $q = Doctrine_Query::create()
      ->delete()
      ->from('EntityCreationQueue')
      ->where('mp_info = ?', 'done')
      ->andWhere('person = ?', 'done')
      ->execute();
    
    echo 'Done';
    
  }
  
  
}
