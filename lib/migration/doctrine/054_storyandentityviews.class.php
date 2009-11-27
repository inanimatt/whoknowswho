<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Storyandentityviews extends Doctrine_Migration
{
	public function up()
	{
    $this->addColumn('story', 'views', 'integer', array('type' => 'integer', 'length' => 8, 'notnull' => true, 'default' => 0));
    $this->addColumn('entity', 'views', 'integer', array('type' => 'integer', 'length' => 8, 'notnull' => true, 'default' => 0));
	}

	public function down()
	{
    $this->removeColumn('story', 'views');
    $this->removeColumn('entity', 'views');
    
	}
}