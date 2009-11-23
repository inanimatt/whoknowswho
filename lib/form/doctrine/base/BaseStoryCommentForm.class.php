<?php

/**
 * StoryComment form base class.
 *
 * @method StoryComment getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'story_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => false)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'confirmation_token' => new sfWidgetFormInputText(),
      'email_confirmed'    => new sfWidgetFormInputText(),
      'comment_approved'   => new sfWidgetFormInputText(),
      'story_version'      => new sfWidgetFormInputText(),
      'comment'            => new sfWidgetFormTextarea(),
      'email'              => new sfWidgetFormInputText(),
      'username'           => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'story_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story'))),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'confirmation_token' => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'email_confirmed'    => new sfValidatorInteger(array('required' => false)),
      'comment_approved'   => new sfValidatorInteger(array('required' => false)),
      'story_version'      => new sfValidatorInteger(array('required' => false)),
      'comment'            => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'username'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('story_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryComment';
  }

}
