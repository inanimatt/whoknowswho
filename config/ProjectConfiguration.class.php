<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
require_once dirname(__FILE__).'/../lib/tuiCacheHandler.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enablePlugins(array('sfDoctrinePlugin', 'sfDoctrineGuardPlugin','sfFormExtraPlugin','tuiTWFYimportPlugin'));
  }
  
  
  /**
  * Configure the Doctrine engine
  **/
  public function configureDoctrine(Doctrine_Manager $manager)
  {
    // Switch off annoying as hell doctrine validation, symfony's own is plenty already.
    $manager->setAttribute(Doctrine::ATTR_VALIDATE, Doctrine::VALIDATE_NONE);

    // Now set up the Doctrine Query cache
    $servers = array();
    $hosts = tuiCacheHandler::getServers();
    foreach($hosts as $h)
    {
      if (!$h = trim($h)) continue;
      $servers[] = array('host' => $h, 'port' => 11211, 'persistent' => true);
    }

    $manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, new Doctrine_Cache_Memcache(array('servers' => $servers, 'compression' => false)));
    // $manager->setAttribute(Doctrine::ATTR_QUERY_CACHE_LIFESPAN, 300);

    
    
    // Configure custom query and custom table classes
    $manager->setAttribute(Doctrine::ATTR_QUERY_CLASS, 'FoafQuery');
    $options = array('baseClassName' => 'FoafRecord');
    sfConfig::set('doctrine_model_builder_options', $options);    
  }



  public function configureDoctrineConnection(Doctrine_Connection $conn)
  {
    $conn->addListener(new tuiDoctrineSearchListener());
  }
  
}
