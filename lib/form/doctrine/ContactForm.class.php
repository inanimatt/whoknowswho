<?php

/**
 * StoryComment form.
 *
 * @package    form
 * @subpackage StoryComment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ContactForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormInputText(),
      'email'          => new sfWidgetFormInputText(),
      'comment'     => new sfWidgetFormTextarea()
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorString(array('max_length' => 32, 'required' => true)),
      'email'          => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'comment'     => new sfValidatorString(array('max_length' => 1000, 'required' => true))
    ));

    $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'], new sfValidatorEmail()));
    
    $this->widgetSchema->setNameFormat('contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }
  
  public function updateObject($values = null)
  {

  }
}
