<?php

/**
 * StoryRating form base class.
 *
 * @method StoryRating getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryRatingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'story_id'     => new sfWidgetFormInputHidden(),
      '1_votes'      => new sfWidgetFormInputText(),
      '2_votes'      => new sfWidgetFormInputText(),
      '3_votes'      => new sfWidgetFormInputText(),
      '4_votes'      => new sfWidgetFormInputText(),
      '5_votes'      => new sfWidgetFormInputText(),
      'average_vote' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'story_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'story_id', 'required' => false)),
      '1_votes'      => new sfValidatorInteger(array('required' => false)),
      '2_votes'      => new sfValidatorInteger(array('required' => false)),
      '3_votes'      => new sfValidatorInteger(array('required' => false)),
      '4_votes'      => new sfValidatorInteger(array('required' => false)),
      '5_votes'      => new sfValidatorInteger(array('required' => false)),
      'average_vote' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_rating[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryRating';
  }

}
