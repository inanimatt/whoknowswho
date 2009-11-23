<?php

/**
 * StoryFact filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseStoryFactFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'primary_entity' => new sfWidgetFormChoice(array('choices' => array('' => '', 'entity' => 'entity', 'related' => 'related'))),
      'story_order'    => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'primary_entity' => new sfValidatorChoice(array('required' => false, 'choices' => array('entity' => 'entity', 'related' => 'related'))),
      'story_order'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_fact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StoryFact';
  }

  public function getFields()
  {
    return array(
      'story_id'       => 'Number',
      'fact_id'        => 'Number',
      'primary_entity' => 'Enum',
      'story_order'    => 'Number',
      'description'    => 'Text',
    );
  }
}
