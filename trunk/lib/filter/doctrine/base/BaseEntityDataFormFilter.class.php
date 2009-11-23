<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * EntityData filter form base class.
 *
 * @package    filters
 * @subpackage EntityData *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseEntityDataFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'Entity', 'add_empty' => true)),
      'version'         => new sfWidgetFormFilterInput(),
      'name'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'version_comment' => new sfWidgetFormFilterInput(),
      'description'     => new sfWidgetFormFilterInput(),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'entity_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Entity', 'column' => 'id')),
      'version'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'version_comment' => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'created_by'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('entity_data_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityData';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'entity_id'       => 'ForeignKey',
      'version'         => 'Number',
      'name'            => 'Text',
      'created_at'      => 'Date',
      'version_comment' => 'Text',
      'description'     => 'Text',
      'created_by'      => 'ForeignKey',
    );
  }
}