<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addsfguardrememberkey extends Doctrine_Migration
{
	public function up()
	{
		$this->createTable('sf_guard_remember_key', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 4,
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'length' => 4,
             ),
             'remember_key' => 
             array(
              'type' => 'string',
              'length' => 32,
             ),
             'ip_address' => 
             array(
              'type' => 'string',
              'primary' => true,
              'length' => 50,
             ),
             'created_at' => 
             array(
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'ip_address',
             ),
             ));
	}

	public function down()
	{
		$this->dropTable('sf_guard_remember_key');
	}
}