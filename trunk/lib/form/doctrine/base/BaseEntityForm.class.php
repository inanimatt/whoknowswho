<?php

/**
 * Entity form base class.
 *
 * @method Entity getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'entity_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntityType'), 'add_empty' => false)),
      'is_locked'           => new sfWidgetFormInputText(),
      'superceded_by_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SupercededBy'), 'add_empty' => true)),
      'authority_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'name'                => new sfWidgetFormInputText(),
      'subtitle'            => new sfWidgetFormInputText(),
      'version_comment'     => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormTextarea(),
      'photo_url'           => new sfWidgetFormInputText(),
      'photo_caption'       => new sfWidgetFormInputText(),
      'photo_licence'       => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'views'               => new sfWidgetFormInputText(),
      'interest'            => new sfWidgetFormInputText(),
      'connectedness'       => new sfWidgetFormInputText(),
      'slug'                => new sfWidgetFormInputText(),
      'version'             => new sfWidgetFormInputText(),
      'disambiguation_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Disambiguation')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entity_type_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EntityType'))),
      'is_locked'           => new sfValidatorInteger(array('required' => false)),
      'superceded_by_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SupercededBy'), 'required' => false)),
      'authority_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'required' => false)),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'subtitle'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version_comment'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'         => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'photo_url'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_caption'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_licence'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'views'               => new sfValidatorInteger(array('required' => false)),
      'interest'            => new sfValidatorInteger(array('required' => false)),
      'connectedness'       => new sfValidatorInteger(array('required' => false)),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'version'             => new sfValidatorInteger(array('required' => false)),
      'disambiguation_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Disambiguation', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Entity', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('entity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entity';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['disambiguation_list']))
    {
      $this->setDefault('disambiguation_list', $this->object->Disambiguation->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDisambiguationList($con);

    parent::doSave($con);
  }

  public function saveDisambiguationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['disambiguation_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Disambiguation->getPrimaryKeys();
    $values = $this->getValue('disambiguation_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Disambiguation', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Disambiguation', array_values($link));
    }
  }

}
