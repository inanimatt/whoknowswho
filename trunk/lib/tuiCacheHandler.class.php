<?php


// Memcache singleton
class tuiCacheHandler
{
  static $instance = null;
  static $hosts = null;
  protected $memcache = null;
  protected $timeout = null;


  // Make the constructor private so that we force use of the singleton
  protected function __construct()
  {
    $hosts = self::getServers();
    
    $this->memcache = new Memcache;
    foreach($hosts as $h) 
    {
      $this->memcache->addServer($h);
    }
    
    $this->timeout = sfConfig::get('app_tuicachehandler_timeout',null);
  }


  // Fetch the cache handler singleton 
  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new tuiCacheHandler;
    }

    return self::$instance;
  }
 
 
 
  // Scalr maintains a list of host IPs for the server farm in /etc/aws/hosts/<rolename>
  // Return the list of memcached servers.
  public static function getServers() {
    
    if (null == self::$hosts) {
      self::$hosts = array();

      // Read the config file
      $hosts_file = sfConfig::get('sf_config_dir').'/hosts-memcached';
      
      $hosts = (array) file($hosts_file);
      foreach($hosts as $key => &$value)
      {
        // Skip blank lines
        if (!$value = trim($value))
        {
          unset($hosts[$key]);
          continue;
        }

        // Skip commented lines
        if ('#' == $value[0]) 
        {
          unset($hosts[$key]);
          continue;
        }

        // If line begins with / then treat it as a scalr aws path
        if ('/' == $value[0])
        {
          
          // Running on scalr, use its host list
          if (is_dir($value))
          {
            foreach(new DirectoryIterator($value) as $entry)
            {
              if ($entry->isDot()) { continue; }

              self::$hosts[] = $entry->getFilename();
            }
          }
          continue;
        }

        // Otherwise treat it as a server address

        self::$hosts[] = $value;
      }
      
      sort(self::$hosts);
    }

    return self::$hosts;
  }
  
  
  
  public function get($key)
  {
    return $this->memcache->get($key);
  }
  
  
  public function set($key, $content, $timeout = null)
  {
    if (is_null($timeout))
    {
      $timeout = $this->timeout;
    }
    
    return $this->memcache->set($key, $content, null, $timeout);
  }


  public function flush()
  {
    return $this->memcache->flush();
  }
  
  public function getHandler()
  {
    return $this->memcache;
  }
}