<?php

/**
 * EntityCreationQueue form base class.
 *
 * @method EntityCreationQueue getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseEntityCreationQueueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'entity_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'add_empty' => true)),
      'mp_info'    => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'person'     => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'))),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entity_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entity'), 'required' => false)),
      'mp_info'    => new sfValidatorChoice(array('choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'), 'required' => false)),
      'person'     => new sfValidatorChoice(array('choices' => array('pending' => 'pending', 'active' => 'active', 'done' => 'done'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'EntityCreationQueue', 'column' => array('entity_id')))
    );

    $this->widgetSchema->setNameFormat('entity_creation_queue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntityCreationQueue';
  }

}
