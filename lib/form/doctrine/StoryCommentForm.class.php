<?php

/**
 * StoryComment form.
 *
 * @package    form
 * @subpackage StoryComment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class StoryCommentForm extends BaseStoryCommentForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );

    $this->widgetSchema['comment_approved'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array('1' => 'Yes', '0' => 'No') ));
    $this->widgetSchema['email_confirmed'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array('1' => 'Yes', '0' => 'No') ));

    $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
      'public_key' => '6LfgDgkAAAAAANgr2FJEzJXDZrsoEXwdLKy_x73j'
    ));
    
    //$this->widgetSchema['email_again'] = new sfWidgetFormInput();
    
    $this->validatorSchema['comment'] = new sfValidatorString(array('max_length' => 1000, 'required' => true));
    
    $this->validatorSchema['email'] = new sfValidatorAnd(array(
      $this->validatorSchema['email'],
      new sfValidatorEmail(),
    ));
    
    $this->validatorSchema['username'] = new sfValidatorAnd(array(
      $this->validatorSchema['username'],
      new sfValidatorString(array('max_length' => 32, 'required' => true)),
    )); 

    //$this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('email', '==', 'email_again'));

    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
  }
  
  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
  
    if (!$object->getConfirmationToken()) {
      $object->setConfirmationToken(sprintf('%08X', crc32('+{}"?|{?FR}"'.microtime())));
    }

    if (!$object->getEmailConfirmed()) {
      $object->setEmailConfirmed(0);
    }
    
    if (!$object->getCommentApproved()) {
      $object->setCommentApproved(0);
    }
    
    $object->setComment(strip_tags($object->getComment()));
    $object->setUsername(strip_tags($object->getUsername()));
    
    return $object;
  }
}