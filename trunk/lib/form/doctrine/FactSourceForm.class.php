<?php

/**
 * FactSource form.
 *
 * @package    form
 * @subpackage FactSource
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class FactSourceForm extends BaseFactSourceForm
{
  public function configure()
  {
    
    $this->widgetSchema['fact_id'] = new sfWidgetFormInputText();
    $this->widgetSchema['is_supporting'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(1 => 'Yes', 0 => 'No') ));
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);

  }
}