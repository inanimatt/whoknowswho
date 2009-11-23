<?php

/**
 * Fact form.
 *
 * @package    form
 * @subpackage Fact
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class FactForm extends BaseFactForm
{
  public function configure()
  {
    
    $this->widgetSchema['start'] = new tuiWidgetFormJQueryDate(array(
      'config' => '{"yearRange":"1900:'.date('Y').'","changeYear":true,"changeMonth":true,minDate: new Date(1900,1,1),maxDate: "+5y"}',
    ));
    
    
    $years = range(date('Y'),date('Y') - 128);    
    
    $this->widgetSchema['start']->setOption('years', array_combine($years, $years));
    
    $this->widgetSchema['end'] = new tuiWidgetFormJQueryDate(array(
      'config' => '{"yearRange":"'.$years[0].':'.date('Y').'","changeYear":true,"changeMonth":true,minDate: new Date('.$years[0].',1,1),maxDate: "+5y"}',
    ));
    $this->widgetSchema['end']->setOption('years', array_combine($years, $years));
 
 
    $this->widgetSchema['entity_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['entity_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
 
    $this->widgetSchema['related_entity_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['related_entity_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
 
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));
 
    $o =$this->getObject();
    $fs = $o['Sources'][0];
    $fs['Creator'] = sfContext::getInstance()->getUser()->getGuardUser();

    $sourceForm = new FactSourceForm($fs, array('sfguardurl' => $this->getOption('sfguardurl')));
    unset($sourceForm['fact_id']);
    unset($sourceForm['created_at']);
    unset($sourceForm['updated_at']);
        
    $this->embedForm('FactSource', $sourceForm);
 
 
    // Disable stupid date validator that won't allow fucking partial dates properly
    $this->validatorSchema['start'] = new tuiValidatorDate(array('allow_partial' => true));
    $this->validatorSchema['end']   = new tuiValidatorDate(array('allow_partial' => true));
 
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
    unset($this->widgetSchema['stories_list']);
    unset($this->validatorSchema['stories_list']);
 
    
  }
  
  
}