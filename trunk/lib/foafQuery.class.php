<?php

class FoafQuery extends Doctrine_Query
{
  public function preQuery()
  {
    
      // If this is a select query then set connection to one of the slaves
      if ($this->getType() == Doctrine_Query::SELECT) {
          $this->_conn = Doctrine_Manager::getInstance()->getConnection('slave');
      // All other queries are writes so they need to go to the master
      } else {
          $this->_conn = Doctrine_Manager::getInstance()->getConnection('master');
      }
  }
  
}