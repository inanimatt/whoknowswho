<?php

/**
 * FactSource filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactSourceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fact_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fact'), 'add_empty' => true)),
      'url'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'source_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SourceType'), 'add_empty' => true)),
      'is_supporting'  => new sfWidgetFormFilterInput(),
      'title'          => new sfWidgetFormFilterInput(),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'fact_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Fact'), 'column' => 'id')),
      'url'            => new sfValidatorPass(array('required' => false)),
      'source_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SourceType'), 'column' => 'id')),
      'is_supporting'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'title'          => new sfValidatorPass(array('required' => false)),
      'created_by'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('fact_source_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FactSource';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'fact_id'        => 'ForeignKey',
      'url'            => 'Text',
      'source_type_id' => 'ForeignKey',
      'is_supporting'  => 'Number',
      'title'          => 'Text',
      'created_by'     => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
