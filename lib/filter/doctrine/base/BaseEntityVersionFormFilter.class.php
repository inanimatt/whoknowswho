<?php

/**
 * EntityVersion filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_type_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_locked'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'superceded_by_id' => new sfWidgetFormFilterInput(),
      'authority_id'     => new sfWidgetFormFilterInput(),
      'created_by'       => new sfWidgetFormFilterInput(),
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitle'         => new sfWidgetFormFilterInput(),
      'version_comment'  => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'photo_url'        => new sfWidgetFormFilterInput(),
      'photo_caption'    => new sfWidgetFormFilterInput(),
      'photo_licence'    => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'views'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'interest'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'connectedness'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'entity_type_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_locked'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'superceded_by_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'authority_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_by'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'             => new sfValidatorPass(array('required' => false)),
      'subtitle'         => new sfValidatorPass(array('required' => false)),
      'version_comment'  => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'photo_url'        => new sfValidatorPass(array('required' => false)),
      'photo_caption'    => new sfValidatorPass(array('required' => false)),
      'photo_licence'    => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'views'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'interest'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'connectedness'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slug'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityVersion';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'entity_type_id'   => 'Number',
      'is_locked'        => 'Number',
      'superceded_by_id' => 'Number',
      'authority_id'     => 'Number',
      'created_by'       => 'Number',
      'name'             => 'Text',
      'subtitle'         => 'Text',
      'version_comment'  => 'Text',
      'description'      => 'Text',
      'photo_url'        => 'Text',
      'photo_caption'    => 'Text',
      'photo_licence'    => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'views'            => 'Number',
      'interest'         => 'Number',
      'connectedness'    => 'Number',
      'slug'             => 'Text',
      'version'          => 'Number',
    );
  }
}
