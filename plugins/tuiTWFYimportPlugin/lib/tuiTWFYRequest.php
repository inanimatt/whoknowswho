<?php

class tuiTWFYRequest
{
  const FORCE_REFRESH            = true;
  const OK                       = true;
  const TOO_SOON                 = false;

  protected static $last_request = null;




  public static function get($url)
  {
    // Never make more requests than the rate limit - if there's been a request any sooner than the threshold, then sleep
    $min_time = self::getTimer() + sfConfig::get('app_twfy_api_rate', 1);
    $current_time = microtime(true);
    if ($current_time < $min_time) {
      // We need to wait. Find out how long, then usleep()
      usleep(($min_time - $current_time) * 1000000);
    }
    

    $ttl = 86400; // DEBUG: cache for a day


    return self::httpGet($url, 86400);
    
  }
  



  
  public static function getTimer()
  {
    $time = self::$last_request;
    self::$last_request = microtime(true);
    return self::$last_request;
  }





  protected static function httpGet($url, $ttl = 0) 
  {
    $cache_file = sprintf('%s/twfy-cache-%08X.dat',sfConfig::get('sf_app_cache_dir'),crc32($url));
    $cache_exists = is_readable($cache_file);

    if ($ttl && $cache_exists && 
        (filemtime($cache_file) > (time() - $ttl))
       ) 
    {
      return file_get_contents($cache_file);
    }

    /* Need to regenerate the cache. First thing to do here is update the 
     * modification time on the cache file so that no one else tries to 
     * update the cache while we're updating it.
     */
    touch($cache_file);
    clearstatcache();


    /* Set up the cURL pointer. It's important to set a User-Agent that's 
     * unique to you, and provides contact details in case your script is 
     * misbehaving and a server owner needs to contact you. More than that, 
     * it's just the polite thing to do. Follow the format below.
     */
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_TIMEOUT, 15);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT, 
                'tuiTWFYImport/0.9  (http://www.tui.co.uk/; matt@tui.co.uk)');


    /* If we've got a cache, do the web a favour and make a conditional HTTP
     * request. What this means is that if the server supports it, it will 
     * tell us if nothing has changed - this means we can reuse the cache for
     * a while, and the request is returned faster.
     */
    if ($cache_exists) {
      curl_setopt($c, CURLOPT_TIMECONDITION, CURL_TIMECOND_IFMODSINCE);
      curl_setopt($c, CURLOPT_TIMEVALUE, filemtime($cache_file));
    }


    /* Make the request and check the result. */
    $content = curl_exec($c);
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    // Document unmodified? Return the cache file
    if ($cache_exists && ($status == 304)) { 
      return file_get_contents($cache_file);
    }

    /* You could be more forgiving of errors here. I've chosen to fail hard
     * because at least it'll be obvious when something goes wrong. 
     */
    if ($status != 200) { 
      throw new Exception(sprintf('Unexpected HTTP return code %d', $status));
    }


    /* If everything is fine, save the new cache file, make sure it's
     * world-readable, and writable by the server
     */
    file_put_contents($cache_file, $content);
    chmod($cache_file, 0644);
    return $content;
  }
  
}
