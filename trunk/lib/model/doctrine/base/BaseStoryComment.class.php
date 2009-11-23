<?php

/**
 * BaseStoryComment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $story_id
 * @property integer $created_by
 * @property string $confirmation_token
 * @property integer $email_confirmed
 * @property integer $comment_approved
 * @property integer $story_version
 * @property string $comment
 * @property string $email
 * @property string $username
 * @property sfGuardUser $Creator
 * @property Story $Story
 * 
 * @method integer      getId()                 Returns the current record's "id" value
 * @method integer      getStoryId()            Returns the current record's "story_id" value
 * @method integer      getCreatedBy()          Returns the current record's "created_by" value
 * @method string       getConfirmationToken()  Returns the current record's "confirmation_token" value
 * @method integer      getEmailConfirmed()     Returns the current record's "email_confirmed" value
 * @method integer      getCommentApproved()    Returns the current record's "comment_approved" value
 * @method integer      getStoryVersion()       Returns the current record's "story_version" value
 * @method string       getComment()            Returns the current record's "comment" value
 * @method string       getEmail()              Returns the current record's "email" value
 * @method string       getUsername()           Returns the current record's "username" value
 * @method sfGuardUser  getCreator()            Returns the current record's "Creator" value
 * @method Story        getStory()              Returns the current record's "Story" value
 * @method StoryComment setId()                 Sets the current record's "id" value
 * @method StoryComment setStoryId()            Sets the current record's "story_id" value
 * @method StoryComment setCreatedBy()          Sets the current record's "created_by" value
 * @method StoryComment setConfirmationToken()  Sets the current record's "confirmation_token" value
 * @method StoryComment setEmailConfirmed()     Sets the current record's "email_confirmed" value
 * @method StoryComment setCommentApproved()    Sets the current record's "comment_approved" value
 * @method StoryComment setStoryVersion()       Sets the current record's "story_version" value
 * @method StoryComment setComment()            Sets the current record's "comment" value
 * @method StoryComment setEmail()              Sets the current record's "email" value
 * @method StoryComment setUsername()           Sets the current record's "username" value
 * @method StoryComment setCreator()            Sets the current record's "Creator" value
 * @method StoryComment setStory()              Sets the current record's "Story" value
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
abstract class BaseStoryComment extends FoafRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('story_comment');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '8',
             ));
        $this->hasColumn('story_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '8',
             ));
        $this->hasColumn('created_by', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('confirmation_token', 'string', 8, array(
             'type' => 'string',
             'default' => '0',
             'notnull' => true,
             'length' => '8',
             ));
        $this->hasColumn('email_confirmed', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '1',
             ));
        $this->hasColumn('comment_approved', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '1',
             ));
        $this->hasColumn('story_version', 'integer', 8, array(
             'type' => 'integer',
             'length' => '8',
             ));
        $this->hasColumn('comment', 'string', 1000, array(
             'type' => 'string',
             'length' => '1000',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('username', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as Creator', array(
             'local' => 'created_by',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $this->hasOne('Story', array(
             'local' => 'story_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}