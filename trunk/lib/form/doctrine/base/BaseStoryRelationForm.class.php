<?php

/**
 * StoryRelation form base class.
 *
 * @method StoryRelation getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryRelationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'story_id'         => new sfWidgetFormInputHidden(),
      'related_story_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'story_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'story_id', 'required' => false)),
      'related_story_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'related_story_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_relation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryRelation';
  }

}
