<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addentityversion extends Doctrine_Migration
{
	public function up()
	{
		$this->createTable('entity_version', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 8,
             ),
             'entity_type_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 4,
             ),
             'is_locked' => 
             array(
              'type' => 'integer',
              'default' => '0',
              'notnull' => true,
              'length' => 1,
             ),
             'superceded_by_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'authority_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'created_by' => 
             array(
              'type' => 'integer',
              'length' => 4,
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'version_comment' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'description' => 
             array(
              'type' => 'string',
              'length' => 2147483647,
             ),
             'version' => 
             array(
              'primary' => true,
              'type' => 'integer',
              'length' => 8,
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'version',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
	}

	public function down()
	{
		$this->dropTable('entity_version');
	}
}