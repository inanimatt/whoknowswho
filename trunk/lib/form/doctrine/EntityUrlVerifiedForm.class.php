<?php

/**
 * EntityUrlVerified form.
 *
 * @package    form
 * @subpackage EntityUrlVerified
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EntityUrlVerifiedForm extends BaseEntityUrlVerifiedForm
{
  public function configure()
  {
    $this->widgetSchema['entity_url_id'] = new sfWidgetFormInputText();
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));
 
    $this->widgetSchema['score'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(1 => 'Valid and correct', 0 => "Don't know", -1 => 'Invalid, incorrect, or file not found' ) ));
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
  }
}