<?php

/**
 * Entity filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_type_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntityType'), 'add_empty' => true)),
      'is_locked'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'superceded_by_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SupercededBy'), 'add_empty' => true)),
      'authority_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitle'            => new sfWidgetFormFilterInput(),
      'version_comment'     => new sfWidgetFormFilterInput(),
      'description'         => new sfWidgetFormFilterInput(),
      'photo_url'           => new sfWidgetFormFilterInput(),
      'photo_caption'       => new sfWidgetFormFilterInput(),
      'photo_licence'       => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'views'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'interest'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'connectedness'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                => new sfWidgetFormFilterInput(),
      'version'             => new sfWidgetFormFilterInput(),
      'disambiguation_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Disambiguation')),
    ));

    $this->setValidators(array(
      'entity_type_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EntityType'), 'column' => 'id')),
      'is_locked'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'superceded_by_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SupercededBy'), 'column' => 'id')),
      'authority_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'created_by'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'name'                => new sfValidatorPass(array('required' => false)),
      'subtitle'            => new sfValidatorPass(array('required' => false)),
      'version_comment'     => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'photo_url'           => new sfValidatorPass(array('required' => false)),
      'photo_caption'       => new sfValidatorPass(array('required' => false)),
      'photo_licence'       => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'views'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'interest'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'connectedness'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slug'                => new sfValidatorPass(array('required' => false)),
      'version'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'disambiguation_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Disambiguation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDisambiguationListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.DisambiguationEntity DisambiguationEntity')
          ->andWhereIn('DisambiguationEntity.disambiguation_id', $values);
  }

  public function getModelName()
  {
    return 'Entity';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'entity_type_id'      => 'ForeignKey',
      'is_locked'           => 'Number',
      'superceded_by_id'    => 'ForeignKey',
      'authority_id'        => 'ForeignKey',
      'created_by'          => 'ForeignKey',
      'name'                => 'Text',
      'subtitle'            => 'Text',
      'version_comment'     => 'Text',
      'description'         => 'Text',
      'photo_url'           => 'Text',
      'photo_caption'       => 'Text',
      'photo_licence'       => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'views'               => 'Number',
      'interest'            => 'Number',
      'connectedness'       => 'Number',
      'slug'                => 'Text',
      'version'             => 'Number',
      'disambiguation_list' => 'ManyKey',
    );
  }
}
