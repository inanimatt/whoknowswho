<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Updateentity extends Doctrine_Migration
{
	public function up() {
	
    $this->addColumn('entity', 'photo_url', 'string',  array(
         'type' => 'string',
         'length' => '255',
         ));
    $this->addColumn('entity', 'photo_caption', 'string',  array(
         'type' => 'string',
         'length' => '255',
         ));
    $this->addColumn('entity', 'photo_license', 'string',  array(
         'type' => 'string',
         'length' => '255',
         ));
	}

	public function down()
	{
    throw new Doctrine_Migration_IrreversibleMigrationException(
                'The remove column operation cannot be undone!'
            );
            
    // But in case you want to do it anyway....
    $this->removeColumn('entity', 'photo_url');
    $this->removeColumn('entity', 'photo_caption');
    $this->removeColumn('entity', 'photo_license');
	}
}