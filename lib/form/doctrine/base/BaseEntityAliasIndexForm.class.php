<?php

/**
 * EntityAliasIndex form base class.
 *
 * @method EntityAliasIndex getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityAliasIndexForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'keyword'  => new sfWidgetFormInputHidden(),
      'field'    => new sfWidgetFormInputHidden(),
      'position' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'keyword'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'keyword', 'required' => false)),
      'field'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'field', 'required' => false)),
      'position' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'position', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_alias_index[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityAliasIndex';
  }

}
