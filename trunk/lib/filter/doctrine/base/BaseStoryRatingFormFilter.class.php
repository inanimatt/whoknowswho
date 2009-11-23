<?php

/**
 * StoryRating filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryRatingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      '1_votes'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '2_votes'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '3_votes'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '4_votes'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '5_votes'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'average_vote' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      '1_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      '2_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      '3_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      '4_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      '5_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'average_vote' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('story_rating_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryRating';
  }

  public function getFields()
  {
    return array(
      'story_id'     => 'Number',
      '1_votes'      => 'Number',
      '2_votes'      => 'Number',
      '3_votes'      => 'Number',
      '4_votes'      => 'Number',
      '5_votes'      => 'Number',
      'average_vote' => 'Number',
    );
  }
}
