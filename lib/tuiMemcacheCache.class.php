<?php


// Memcache singleton
class tuiMemcacheCache extends sfMemcacheCache
{

  public function initialize($options = array())
  {
    $options['memcache'] = tuiCacheHandler::getInstance()->getHandler();
    return parent::initialize($options);
  }


}