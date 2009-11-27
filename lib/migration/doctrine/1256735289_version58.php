<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version58 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('entity_index', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             'keyword' => 
             array(
              'type' => 'string',
              'length' => '200',
              'primary' => '1',
             ),
             'field' => 
             array(
              'type' => 'string',
              'length' => '50',
              'primary' => '1',
             ),
             'position' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' => 
             array(
              0 => 'id',
              1 => 'keyword',
              2 => 'field',
              3 => 'position',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('entity_alias_index', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             'keyword' => 
             array(
              'type' => 'string',
              'length' => '200',
              'primary' => '1',
             ),
             'field' => 
             array(
              'type' => 'string',
              'length' => '50',
              'primary' => '1',
             ),
             'position' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'primary' => '1',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' => 
             array(
              0 => 'id',
              1 => 'keyword',
              2 => 'field',
              3 => 'position',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('entity_index');
        $this->dropTable('entity_alias_index');
    }
}