<?php

/**
 * EntityActionRequired filter form base class.
 *
 * @package    c4foaf
 * @subpackage filter
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityActionRequiredFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'needs_external_links' => new sfWidgetFormFilterInput(),
      'needs_wiki_page'      => new sfWidgetFormFilterInput(),
      'needs_description'    => new sfWidgetFormFilterInput(),
      'needs_facts'          => new sfWidgetFormFilterInput(),
      'needs_subtitle'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'needs_external_links' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'needs_wiki_page'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'needs_description'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'needs_facts'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'needs_subtitle'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('entity_action_required_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityActionRequired';
  }

  public function getFields()
  {
    return array(
      'entity_id'            => 'Number',
      'needs_external_links' => 'Number',
      'needs_wiki_page'      => 'Number',
      'needs_description'    => 'Number',
      'needs_facts'          => 'Number',
      'needs_subtitle'       => 'Number',
    );
  }
}
