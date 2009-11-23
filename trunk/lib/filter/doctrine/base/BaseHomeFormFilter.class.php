<?php

/**
 * Home filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseHomeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'is_active'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'feature_html'          => new sfWidgetFormFilterInput(),
      'feature_copy_intro'    => new sfWidgetFormFilterInput(),
      'feature_copy_extended' => new sfWidgetFormFilterInput(),
      'callout_html'          => new sfWidgetFormFilterInput(),
      'story1_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story1'), 'add_empty' => true)),
      'story1_image_url'      => new sfWidgetFormFilterInput(),
      'story2_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story2'), 'add_empty' => true)),
      'story2_image_url'      => new sfWidgetFormFilterInput(),
      'story3_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story3'), 'add_empty' => true)),
      'story3_image_url'      => new sfWidgetFormFilterInput(),
      'story4_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story4'), 'add_empty' => true)),
      'story4_image_url'      => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'is_active'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'feature_html'          => new sfValidatorPass(array('required' => false)),
      'feature_copy_intro'    => new sfValidatorPass(array('required' => false)),
      'feature_copy_extended' => new sfValidatorPass(array('required' => false)),
      'callout_html'          => new sfValidatorPass(array('required' => false)),
      'story1_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story1'), 'column' => 'id')),
      'story1_image_url'      => new sfValidatorPass(array('required' => false)),
      'story2_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story2'), 'column' => 'id')),
      'story2_image_url'      => new sfValidatorPass(array('required' => false)),
      'story3_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story3'), 'column' => 'id')),
      'story3_image_url'      => new sfValidatorPass(array('required' => false)),
      'story4_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story4'), 'column' => 'id')),
      'story4_image_url'      => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('home_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Home';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'is_active'             => 'Boolean',
      'feature_html'          => 'Text',
      'feature_copy_intro'    => 'Text',
      'feature_copy_extended' => 'Text',
      'callout_html'          => 'Text',
      'story1_id'             => 'ForeignKey',
      'story1_image_url'      => 'Text',
      'story2_id'             => 'ForeignKey',
      'story2_image_url'      => 'Text',
      'story3_id'             => 'ForeignKey',
      'story3_image_url'      => 'Text',
      'story4_id'             => 'ForeignKey',
      'story4_image_url'      => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
