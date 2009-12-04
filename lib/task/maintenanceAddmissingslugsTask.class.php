<?php

class maintenanceAddmissingslugsTask extends sfBaseTask
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
    $this->name             = 'add-missing-slugs';
    $this->briefDescription = 'Add missing URL slugs to stories, entities';
    $this->detailedDescription = <<<EOF
The [maintenance:add-missing-slugs|INFO] task creates URL slugs for
entities and stories that don't have them. This DOES NOT create new 
EntityVersion or StoryVersion rows (because it doesn't hydrate objects).

Call it with:

  [php symfony maintenance:add-missing-slugs|INFO]
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

    $s = Doctrine_Query::create()
          ->select('s.id, s.title')
          ->from('Story s')
          ->where('s.slug IS NULL')
          ->execute(null, Doctrine::HYDRATE_ARRAY);
    
    $stmt = $connection->prepare('UPDATE story SET slug = :slug WHERE id = :id');
    foreach($s as $row) {
      $stmt->bindValue(':id', $row['id']);
      $stmt->bindValue(':slug', tuiWikiUrl::urlize($row['title']));
      $stmt->execute();
    }
    
    $e = Doctrine_Query::create()
          ->select('e.id, e.name')
          ->from('Entity e')
          ->where('e.slug IS NULL')
          ->execute(null, Doctrine::HYDRATE_ARRAY);
    
    $stmt = $connection->prepare('UPDATE entity SET slug = :slug WHERE id = :id');
    foreach($e as $row) {
      $slug = tuiWikiUrl::urlize($row['name']);
      
      $stmt->bindValue(':id', $row['id']);
      $stmt->bindValue(':slug', $slug);
      try {
        $stmt->execute();
      } catch (Exception $except) {
        $counter = 1;
        $fixed = false;
        while(++$counter < 20) {
          try {
            $stmt->bindValue(':id', $row['id']);
            $stmt->bindValue(':slug', $slug.'_('.$counter.')');
            $stmt->execute();
            $fixed = true;
            break;
          } catch (Exception $except) {
            continue;
          }
        }
        if (!$fixed) {
          throw new sfCommandException('Too many collisions on entity '.$row['name'].' id:'.$row['id']);
        }
        
      }
    }
    
  }
}
