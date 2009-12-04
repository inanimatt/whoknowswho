<?php

class tuiCronUtils
{
  
  /* This method exists to prevent multiple servers in the farm performing 
   * scheduled maintenance tasks more often than required. First, the task
   * sleeps for a random interval to limit race-conditions, then it queries
   * the memcache for the last time this event was run. If it was within 
   * 20 seconds of the last run, the method will return false and the 
   * calling task should stop processing.
   * 
   * It's important to note that this doesn't stop events running more than
   * once, just less than lots. It's to prevent database write-stampedes,
   * not to ensure that tasks only ever run once at a time. If this is even
   * slightly important to you, use something else (like a database, or a
   * dedicated task-running server).
   */
  public static function claimSlot($taskname)
  {
    usleep(mt_rand(0,150000));
    
    if (false !== tuiCacheHandler::getInstance()->get('cron-block-'.$taskname))
    {
      return false;
    }
    
    tuiCacheHandler::getInstance()->set('cron-block-'.$taskname, 'busy', 20);
    return true;
  }
  
  
}