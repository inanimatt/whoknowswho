<?php

/**
 * ContactMessages form.
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id$
 */
class ContactMessagesForm extends BaseContactMessagesForm
{
  public function configure()
  {
    $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'], new sfValidatorEmail()));
    
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
  }
  
  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    
    $object->setMessage(strip_tags($object->getMessage()));
    $object->setName(strip_tags($object->getName()));
    
    return $object;
  }
}
