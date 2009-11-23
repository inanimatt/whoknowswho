<?php

/**
 * FactActionRequired filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactActionRequiredFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'needs_sources'     => new sfWidgetFormFilterInput(),
      'needs_description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'needs_sources'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'needs_description' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('fact_action_required_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FactActionRequired';
  }

  public function getFields()
  {
    return array(
      'fact_id'           => 'Number',
      'needs_sources'     => 'Number',
      'needs_description' => 'Number',
    );
  }
}
