<?php

/**
 * Fact form base class.
 *
 * @method Fact getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'entity_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'add_empty' => false)),
      'title'             => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormTextarea(),
      'related_entity_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RelatedEntity'), 'add_empty' => true)),
      'start'             => new sfWidgetFormDate(),
      'end'               => new sfWidgetFormDate(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'fact_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FactType'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'stories_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Story')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entity_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'))),
      'title'             => new sfValidatorString(array('max_length' => 255)),
      'description'       => new sfValidatorString(array('max_length' => 2147483647)),
      'related_entity_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RelatedEntity'), 'required' => false)),
      'start'             => new sfValidatorDate(array('required' => false)),
      'end'               => new sfValidatorDate(array('required' => false)),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'fact_type_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FactType'), 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'stories_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Story', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fact';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['stories_list']))
    {
      $this->setDefault('stories_list', $this->object->Stories->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveStoriesList($con);

    parent::doSave($con);
  }

  public function saveStoriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['stories_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Stories->getPrimaryKeys();
    $values = $this->getValue('stories_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Stories', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Stories', array_values($link));
    }
  }

}
