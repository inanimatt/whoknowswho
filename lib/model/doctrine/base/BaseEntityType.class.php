<?php

/**
 * BaseEntityType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $url_slug
 * @property string $description
 * @property Doctrine_Collection $Entities
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getTitle()       Returns the current record's "title" value
 * @method string              getUrlSlug()     Returns the current record's "url_slug" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method Doctrine_Collection getEntities()    Returns the current record's "Entities" collection
 * @method EntityType          setId()          Sets the current record's "id" value
 * @method EntityType          setTitle()       Sets the current record's "title" value
 * @method EntityType          setUrlSlug()     Sets the current record's "url_slug" value
 * @method EntityType          setDescription() Sets the current record's "description" value
 * @method EntityType          setEntities()    Sets the current record's "Entities" collection
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseEntityType extends FoafRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('entity_type');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('url_slug', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '32',
             ));
        $this->hasColumn('description', 'string', 2147483647, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '2147483647',
             ));


        $this->index('slug_idx', array(
             'fields' => 
             array(
              0 => 'url_slug',
             ),
             'type' => 'unique',
             ));
        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Entity as Entities', array(
             'local' => 'id',
             'foreign' => 'entity_type_id'));
    }
}