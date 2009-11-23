<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * EntityClass filter form base class.
 *
 * @package    filters
 * @subpackage EntityClass *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseEntityClassFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(),
      'entities_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Entity')),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'entities_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Entity', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_class_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addEntitiesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.EntityEntityClass EntityEntityClass')
          ->andWhereIn('EntityEntityClass.entity_id', $values);
  }

  public function getModelName()
  {
    return 'EntityClass';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'entities_list' => 'ManyKey',
    );
  }
}