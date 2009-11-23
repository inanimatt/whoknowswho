<?php

/**
 * EntityVersion form base class.
 *
 * @method EntityVersion getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'entity_type_id'   => new sfWidgetFormInputText(),
      'is_locked'        => new sfWidgetFormInputText(),
      'superceded_by_id' => new sfWidgetFormInputText(),
      'authority_id'     => new sfWidgetFormInputText(),
      'created_by'       => new sfWidgetFormInputText(),
      'name'             => new sfWidgetFormInputText(),
      'subtitle'         => new sfWidgetFormInputText(),
      'version_comment'  => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'photo_url'        => new sfWidgetFormInputText(),
      'photo_caption'    => new sfWidgetFormInputText(),
      'photo_licence'    => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'views'            => new sfWidgetFormInputText(),
      'interest'         => new sfWidgetFormInputText(),
      'connectedness'    => new sfWidgetFormInputText(),
      'slug'             => new sfWidgetFormInputText(),
      'version'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entity_type_id'   => new sfValidatorInteger(),
      'is_locked'        => new sfValidatorInteger(array('required' => false)),
      'superceded_by_id' => new sfValidatorInteger(array('required' => false)),
      'authority_id'     => new sfValidatorInteger(array('required' => false)),
      'created_by'       => new sfValidatorInteger(array('required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'subtitle'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version_comment'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'      => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'photo_url'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_caption'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_licence'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'views'            => new sfValidatorInteger(array('required' => false)),
      'interest'         => new sfValidatorInteger(array('required' => false)),
      'connectedness'    => new sfValidatorInteger(array('required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'version', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityVersion';
  }

}
