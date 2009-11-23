<?php

abstract class foafRecord extends sfDoctrineRecord
{
    public function save(Doctrine_Connection $conn = null)
    {
      $conn = Doctrine_Manager::getInstance()->getConnection('master');
      parent::save($conn);
    }
}