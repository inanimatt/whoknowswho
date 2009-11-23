<?php


/* This algorithm is pretty weak. It's a vague approximation of eigenvector centrality, but needs much work */

/* Scaling tips/ideas
 * use temporary tables to store connectedness - the first two queries could be a select into union
 * once the score table is created, can batch the second pass using limit and offset
 */ 


class maintenanceUpdateconnectednessTask extends sfBaseTask
{
  protected $max = null;
  
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
    $this->name             = 'update-connectedness';
    $this->briefDescription = 'Recalculate the connectedness field for all entities';
    $this->detailedDescription = <<<EOF
The [maintenance:update-connectedness|INFO] task recalculates the connectedness
field for all entities.
Call it with:

  [php symfony maintenance:update-connectedness|INFO]
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

    /*
     *- pass 1:
     *  - per person, number of connections
     *- pass 2:
     *  - per person's connection, add to score based on their number of connections
     */

    // Initial connection counts:
    // select entity_id, count(distinct(related_entity_id)) from fact where entity_id is not null and related_entity_id is not null group by entity_id;
    // select related_entity_id, count(distinct(entity_id)) from fact where entity_id is not null and related_entity_id is not null group by related_entity_id;
    
    $entity_connections = array();
    $sql = 'select entity_id, count(distinct(related_entity_id)) from fact where entity_id is not null and related_entity_id is not null group by entity_id';
    foreach($connection->query($sql) as $row)
    {
      $entity_connections[$row[0]] = $row[1];
    }

    $sql = 'select related_entity_id, count(distinct(entity_id)) from fact where entity_id is not null and related_entity_id is not null group by related_entity_id';
    foreach($connection->query($sql) as $row)
    {
      if (!isset($entity_connections[$row[0]])) 
      {
        $entity_connections[$row[0]] = 0;
      }
      
      $entity_connections[$row[0]] += $row[1];
    }


    // Second pass: for each entity, get list of connections per entity. Add half the connectedness of each to the current entity's connectedness.
    $stmt = $connection->prepare('select distinct if(:id = entity_id, related_entity_id, entity_id) from fact where (entity_id = :id and related_entity_id is not null) or (entity_id is not null and related_entity_id = :id)');
    foreach($entity_connections as $id => $connectedness)
    {
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      while($row = $stmt->fetch())
      {
        $entity_connections[$id] += ($entity_connections[$row[0]] / 2);
      }
    }
    
    
    
    // Final step, find the highest score and normalise all scores as percentages of it.
    
    $entity_connections = array_map('log10', $entity_connections);

    $this->max = max($entity_connections);

    $entity_connections = array_map(array($this, 'getPercentage'), $entity_connections);


    $connectedness = $id = null;
    $stmt = $connection->prepare('UPDATE entity SET connectedness = :connectedness WHERE id = :id');
    $stmt->bindParam(':connectedness', $connectedness);
    $stmt->bindParam(':id', $id);
    foreach($entity_connections as $id => $connectedness) 
    {
      $stmt->execute();
    }
  }
  
  
  public function getPercentage($value)
  {
    return intval(ceil(($value / $this->max) * 100));
  }
  
}
