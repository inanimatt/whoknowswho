<?php

/**
 * StoryFact form base class.
 *
 * @method StoryFact getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryFactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'story_id'       => new sfWidgetFormInputHidden(),
      'fact_id'        => new sfWidgetFormInputHidden(),
      'primary_entity' => new sfWidgetFormChoice(array('choices' => array('entity' => 'entity', 'related' => 'related'))),
      'story_order'    => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'story_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'story_id', 'required' => false)),
      'fact_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'fact_id', 'required' => false)),
      'primary_entity' => new sfValidatorChoice(array('choices' => array('entity' => 'entity', 'related' => 'related'), 'required' => false)),
      'story_order'    => new sfValidatorInteger(array('required' => false)),
      'description'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_fact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryFact';
  }

}
