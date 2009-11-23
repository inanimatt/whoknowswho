<?php

/**
 * FactSource form base class.
 *
 * @method FactSource getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactSourceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'fact_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fact'), 'add_empty' => false)),
      'url'            => new sfWidgetFormTextarea(),
      'source_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SourceType'), 'add_empty' => false)),
      'is_supporting'  => new sfWidgetFormInputText(),
      'title'          => new sfWidgetFormInputText(),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'fact_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Fact'))),
      'url'            => new sfValidatorString(array('max_length' => 1024)),
      'source_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SourceType'))),
      'is_supporting'  => new sfValidatorInteger(array('required' => false)),
      'title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('fact_source[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FactSource';
  }

}
