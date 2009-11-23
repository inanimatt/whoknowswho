<?php

/**
 * StoryComment filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryCommentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'story_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'confirmation_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_confirmed'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment_approved'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'story_version'      => new sfWidgetFormFilterInput(),
      'comment'            => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(),
      'username'           => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'story_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story'), 'column' => 'id')),
      'created_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'confirmation_token' => new sfValidatorPass(array('required' => false)),
      'email_confirmed'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comment_approved'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'story_version'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comment'            => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'username'           => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('story_comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryComment';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'story_id'           => 'ForeignKey',
      'created_by'         => 'ForeignKey',
      'confirmation_token' => 'Text',
      'email_confirmed'    => 'Number',
      'comment_approved'   => 'Number',
      'story_version'      => 'Number',
      'comment'            => 'Text',
      'email'              => 'Text',
      'username'           => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
