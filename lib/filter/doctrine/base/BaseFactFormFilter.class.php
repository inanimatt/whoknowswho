<?php

/**
 * Fact filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'add_empty' => true)),
      'title'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'related_entity_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RelatedEntity'), 'add_empty' => true)),
      'start'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'fact_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FactType'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'stories_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Story')),
    ));

    $this->setValidators(array(
      'entity_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entity'), 'column' => 'id')),
      'title'             => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'related_entity_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RelatedEntity'), 'column' => 'id')),
      'start'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'end'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'created_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'fact_type_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FactType'), 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'stories_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Story', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addStoriesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.StoryFact StoryFact')
          ->andWhereIn('StoryFact.story_id', $values);
  }

  public function getModelName()
  {
    return 'Fact';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'entity_id'         => 'ForeignKey',
      'title'             => 'Text',
      'description'       => 'Text',
      'related_entity_id' => 'ForeignKey',
      'start'             => 'Date',
      'end'               => 'Date',
      'created_by'        => 'ForeignKey',
      'fact_type_id'      => 'ForeignKey',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'stories_list'      => 'ManyKey',
    );
  }
}
