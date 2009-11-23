<?php

/**
 * ContactMessages form base class.
 *
 * @method ContactMessages getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseContactMessagesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'message_type' => new sfWidgetFormInputText(),
      'name'         => new sfWidgetFormInputText(),
      'email'        => new sfWidgetFormInputText(),
      'message'      => new sfWidgetFormTextarea(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'message_type' => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 32)),
      'email'        => new sfValidatorString(array('max_length' => 255)),
      'message'      => new sfValidatorString(array('max_length' => 1000)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('contact_messages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactMessages';
  }

}
