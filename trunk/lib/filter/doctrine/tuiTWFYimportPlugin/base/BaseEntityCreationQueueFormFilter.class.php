<?php

/**
 * EntityCreationQueue filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityCreationQueueFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'add_empty' => true)),
      'mp_info'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'person'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'entity_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entity'), 'column' => 'id')),
      'mp_info'    => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'person'     => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('entity_creation_queue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityCreationQueue';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'entity_id'  => 'ForeignKey',
      'mp_info'    => 'Enum',
      'person'     => 'Enum',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
