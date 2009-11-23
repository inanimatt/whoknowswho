<?php

/**
 * FactActionRequired form base class.
 *
 * @method FactActionRequired getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactActionRequiredForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fact_id'           => new sfWidgetFormInputHidden(),
      'needs_sources'     => new sfWidgetFormInputText(),
      'needs_description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'fact_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'fact_id', 'required' => false)),
      'needs_sources'     => new sfValidatorInteger(array('required' => false)),
      'needs_description' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fact_action_required[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FactActionRequired';
  }

}
