<?php

class Storyentityversionviews extends Doctrine_Migration_Base
{
	public function up()
	{
	  
    $this->addColumn('story_version', 'views', 'integer', array('type' => 'integer', 'length' => 8, 'notnull' => true, 'default' => 0));
    $this->addColumn('entity_version', 'views', 'integer', array('type' => 'integer', 'length' => 8, 'notnull' => true, 'default' => 0));
	}

	public function down()
	{
    $this->removeColumn('story_version', 'views');
    $this->removeColumn('entity_version', 'views');
    
	}
}
