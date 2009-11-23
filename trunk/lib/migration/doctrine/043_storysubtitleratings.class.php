<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Storysubtitleratings extends Doctrine_Migration
{
	public function up()
	{
    
    $this->addColumn('story', 'subtitle', 'string', array('type' => 'string', 'length' => 255, ));
    
    $columns = array('story_id' => array('type' => 'integer', 'primary' => true, 'length' => '8'),
                     '1_votes' => array('type' => 'integer', 'notnull' => true, 'default' => 0),
                     '2_votes' => array('type' => 'integer', 'notnull' => true, 'default' => 0),
                     '3_votes' => array('type' => 'integer', 'notnull' => true, 'default' => 0),
                     '4_votes' => array('type' => 'integer', 'notnull' => true, 'default' => 0),
                     '5_votes' => array('type' => 'integer', 'notnull' => true, 'default' => 0),
                     'average_vote' => array('type' => 'float', 'notnull' => true, 'default' => 0)
                    );

    $options = array('type' => 'INNODB','charset' => 'utf8');

    $this->createTable('story_rating', $columns, $options);



    $definition = array('local'         => 'story_id',
                        'foreign'       => 'id',
                        'foreignTable'  => 'story',
                        'onDelete'      => 'CASCADE'
                    );

    $this->createForeignKey('story_rating', $definition);
    


	}

	public function down()
	{

    $this->removeColumn('story', 'subtitle');
    $this->dropTable('story_rating');

	}
}