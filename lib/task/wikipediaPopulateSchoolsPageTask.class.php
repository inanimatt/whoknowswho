<?php

class wikipediaPopulateSchoolsPageTask extends sfBaseTask
{
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),

    ));

    $this->namespace           = 'wikipedia';
    $this->name                = 'populateSchoolsPage';
    $this->briefDescription    = 'Finds schools with no wikipedia page and adds it if possible';
    $this->detailedDescription = <<<EOF
The [wikipedia:populateSchoolsPage|INFO] task uses the name of the school
and checks if a wikipedia page exists. If so it adds this information to the database
as an EntityUrl object.

Call it with:

  [php symfony wikipedia:populateSchoolsPage]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $creator = PluginsfGuardUserTable::retrieveByUsername('isc_bot');
    $url_type = 'wikipedia';
    $title = 'Wikipedia page';
    
    if (!$creator) {
      throw new sfCommandException("Couldn't find isc_bot user.");
    }
    
    //Retrieve all schools
    $q = Doctrine_Query::create()
      ->select('e.*')
      ->from('Entity e, e.EntityType et')
      ->where('et.title = ?', 'School');
    
    $schools = $q->fetchArray();
    
    //for each school, check if it has a wikipedia url
    foreach ($schools as $school) {
    	
      $q2 = Doctrine_Query::create()
        ->select('eu.*')
        ->from('EntityUrl eu')
        ->where('eu.entity_id = ?', $school['id'])
        ->andWhere('eu.urltype = ?', $url_type)
        ->andWhere('eu.title = ?', $title); 
      
      $wikipediaurl = $q2->fetchArray();
      
      //checks to see if the wikipedia url has already been added
      if (!$wikipediaurl) {
      	
      	//OK, if we get to here, there is no current wikipedia entry
      	//what's the 1st letter? then can check approprite file for entry
      	$firstletter = strtolower(substr($school['name'], 0, 1));
      	
      	$dumpfile = sfConfig::get('sf_root_dir').'/data/wikipedia_article_names/'.$firstletter.'_articles.txt';
      	
        $file = file_get_contents($dumpfile);
        
        //check $file for school name, if it exists add it
        if(stripos($file, $school['name'])) {

          //entry exists so add EntityUrl entry
          $baseurl = 'http://en.wikipedia.org/wiki/';
          $wikifiedname = str_replace(" ", "_", $school['name']);
          $url = $baseurl . $wikifiedname;
          
          $eu = new EntityUrl;
          $eu->set('entity_id', $school['id'])
            ->set('url', $url)
            ->set('title', $title)
            ->set('urltype', $url_type)
            ->set('created_by', $creator['id']);

          $eu->save();
          $eu->free();
          
          print 'Added wikipedia page for ' . $school['name'] . "\n";
        }
        else {
          print 'No wikipedia page found for ' . $school['name'] . "\n";
        }
      }
    }   
  }
}
