<?php

/**
 * Story form base class.
 *
 * @method Story getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'story_type_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StoryType'), 'add_empty' => false)),
      'is_public'            => new sfWidgetFormInputText(),
      'created_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => false)),
      'title'                => new sfWidgetFormInputText(),
      'subtitle'             => new sfWidgetFormInputText(),
      'version_comment'      => new sfWidgetFormInputText(),
      'description'          => new sfWidgetFormTextarea(),
      'photo_url'            => new sfWidgetFormInputText(),
      'photo_caption'        => new sfWidgetFormInputText(),
      'photo_licence'        => new sfWidgetFormInputText(),
      'teaser'               => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'views'                => new sfWidgetFormInputText(),
      'interest'             => new sfWidgetFormInputText(),
      'slug'                 => new sfWidgetFormInputText(),
      'version'              => new sfWidgetFormInputText(),
      'facts_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Fact')),
      'related_stories_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Story')),
      'story_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Story')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'story_type_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('StoryType'))),
      'is_public'            => new sfValidatorInteger(array('required' => false)),
      'created_by'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'))),
      'title'                => new sfValidatorString(array('max_length' => 255)),
      'subtitle'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version_comment'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'          => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'photo_url'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_caption'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_licence'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'teaser'               => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'views'                => new sfValidatorInteger(array('required' => false)),
      'interest'             => new sfValidatorInteger(array('required' => false)),
      'slug'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version'              => new sfValidatorInteger(array('required' => false)),
      'facts_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Fact', 'required' => false)),
      'related_stories_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Story', 'required' => false)),
      'story_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Story', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Story', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('story[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Story';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['facts_list']))
    {
      $this->setDefault('facts_list', $this->object->Facts->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['related_stories_list']))
    {
      $this->setDefault('related_stories_list', $this->object->RelatedStories->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['story_list']))
    {
      $this->setDefault('story_list', $this->object->Story->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveFactsList($con);
    $this->saveRelatedStoriesList($con);
    $this->saveStoryList($con);

    parent::doSave($con);
  }

  public function saveFactsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['facts_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Facts->getPrimaryKeys();
    $values = $this->getValue('facts_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Facts', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Facts', array_values($link));
    }
  }

  public function saveRelatedStoriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['related_stories_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->RelatedStories->getPrimaryKeys();
    $values = $this->getValue('related_stories_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('RelatedStories', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('RelatedStories', array_values($link));
    }
  }

  public function saveStoryList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['story_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Story->getPrimaryKeys();
    $values = $this->getValue('story_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Story', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Story', array_values($link));
    }
  }

}
