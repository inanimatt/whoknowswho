<?php

/**
 * EntityUrl form base class.
 *
 * @method EntityUrl getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityUrlForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'entity_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'add_empty' => false)),
      'url'        => new sfWidgetFormTextarea(),
      'title'      => new sfWidgetFormTextarea(),
      'urltype'    => new sfWidgetFormInputText(),
      'created_by' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'foreign_id' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entity_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'))),
      'url'        => new sfValidatorString(array('max_length' => 2147483647)),
      'title'      => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'urltype'    => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'created_by' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'foreign_id' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('entity_url[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityUrl';
  }

}
