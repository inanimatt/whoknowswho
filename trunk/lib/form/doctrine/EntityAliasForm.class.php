<?php

/**
 * EntityAlias form.
 *
 * @package    form
 * @subpackage EntityAlias
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EntityAliasForm extends BaseEntityAliasForm
{
  public function configure()
  {
    
    $this->widgetSchema['entity_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['entity_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
  }
}