<?php

class factCreateTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('entity1', sfCommandArgument::REQUIRED, 'Entity 1'),
      new sfCommandArgument('title', sfCommandArgument::REQUIRED, 'fact title'),
      new sfCommandArgument('entity2', sfCommandArgument::REQUIRED, 'Entity 2'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
      // add your own options here
    ));

    $this->namespace        = 'fact';
    $this->name             = 'create';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [fact:create|INFO] task does things.
Call it with:

  [php symfony fact:create|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // add your code here
    $f = new Fact;
    $f['fact_type_id'] = 1;
    $f['entity_id'] = $this->getEntityOrCreate($arguments['entity1']);
    $f['related_entity_id'] = $this->getEntityOrCreate($arguments['entity2']);
    $f['title'] = $arguments['title'];
    $f->save();
    $f->free();
  }
  
  
  protected function getEntityOrCreate($name)
  {
    $q = Doctrine_Query::create()
          ->select('e.id')
          ->from('Entity e')
          ->where('e.name = ?', $name)
          ->orWhere('e.slug = ?', $name)
          ->execute(null,Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    if (!$q) 
    {
      $q = new Entity;
      $q['name'] = $name;
      $q['created_by'] = 1;
      $q['entity_type_id'] = 1;
      $q->save();
      $q = $q->getId();
    }
    return $q;
  }
  
}
