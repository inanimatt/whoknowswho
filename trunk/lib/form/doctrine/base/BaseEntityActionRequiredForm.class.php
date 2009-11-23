<?php

/**
 * EntityActionRequired form base class.
 *
 * @method EntityActionRequired getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityActionRequiredForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'entity_id'            => new sfWidgetFormInputHidden(),
      'needs_external_links' => new sfWidgetFormInputText(),
      'needs_wiki_page'      => new sfWidgetFormInputText(),
      'needs_description'    => new sfWidgetFormInputText(),
      'needs_facts'          => new sfWidgetFormInputText(),
      'needs_subtitle'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'entity_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'entity_id', 'required' => false)),
      'needs_external_links' => new sfValidatorInteger(array('required' => false)),
      'needs_wiki_page'      => new sfValidatorInteger(array('required' => false)),
      'needs_description'    => new sfValidatorInteger(array('required' => false)),
      'needs_facts'          => new sfValidatorInteger(array('required' => false)),
      'needs_subtitle'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entity_action_required[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityActionRequired';
  }

}
