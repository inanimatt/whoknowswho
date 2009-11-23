<?php

/**
 * DisambiguationEntity form base class.
 *
 * @method DisambiguationEntity getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseDisambiguationEntityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'disambiguation_id' => new sfWidgetFormInputHidden(),
      'entity_id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'disambiguation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'disambiguation_id', 'required' => false)),
      'entity_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'entity_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('disambiguation_entity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DisambiguationEntity';
  }

}
