<?php

/**
 * Entity form.
 *
 * @package    form
 * @subpackage Entity
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EntityForm extends BaseEntityForm
{
  public function configure()
  {
    
    
    $this->widgetSchema['superceded_by_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['superceded_by_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
 
    $this->widgetSchema['authority_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['authority_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
 
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));

    $this->widgetSchema['is_locked'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(0 => 'No', 1 => 'Yes') ));
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
    
    unset($this->widgetSchema['disambiguation_list']);
    unset($this->validatorSchema['disambiguation_list']);
    
    
  }
}