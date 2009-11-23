<?php

/**
 * Disambiguation form base class.
 *
 * @method Disambiguation getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseDisambiguationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'title'         => new sfWidgetFormInputText(),
      'created_by'    => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'entities_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Entity')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'title'         => new sfValidatorString(array('max_length' => 255)),
      'created_by'    => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'entities_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Entity', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('disambiguation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Disambiguation';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['entities_list']))
    {
      $this->setDefault('entities_list', $this->object->Entities->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveEntitiesList($con);

    parent::doSave($con);
  }

  public function saveEntitiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['entities_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Entities->getPrimaryKeys();
    $values = $this->getValue('entities_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Entities', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Entities', array_values($link));
    }
  }

}
