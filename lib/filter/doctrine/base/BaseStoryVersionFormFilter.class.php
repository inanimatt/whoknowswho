<?php

/**
 * StoryVersion filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'story_type_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_public'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_by'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitle'        => new sfWidgetFormFilterInput(),
      'version_comment' => new sfWidgetFormFilterInput(),
      'description'     => new sfWidgetFormFilterInput(),
      'photo_url'       => new sfWidgetFormFilterInput(),
      'photo_caption'   => new sfWidgetFormFilterInput(),
      'photo_licence'   => new sfWidgetFormFilterInput(),
      'teaser'          => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'views'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'interest'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'story_type_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_public'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_by'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'title'           => new sfValidatorPass(array('required' => false)),
      'subtitle'        => new sfValidatorPass(array('required' => false)),
      'version_comment' => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'photo_url'       => new sfValidatorPass(array('required' => false)),
      'photo_caption'   => new sfValidatorPass(array('required' => false)),
      'photo_licence'   => new sfValidatorPass(array('required' => false)),
      'teaser'          => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'views'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'interest'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slug'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryVersion';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'story_type_id'   => 'Number',
      'is_public'       => 'Number',
      'created_by'      => 'Number',
      'title'           => 'Text',
      'subtitle'        => 'Text',
      'version_comment' => 'Text',
      'description'     => 'Text',
      'photo_url'       => 'Text',
      'photo_caption'   => 'Text',
      'photo_licence'   => 'Text',
      'teaser'          => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'views'           => 'Number',
      'interest'        => 'Number',
      'slug'            => 'Text',
      'version'         => 'Number',
    );
  }
}
