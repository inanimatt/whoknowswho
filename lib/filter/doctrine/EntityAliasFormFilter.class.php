<?php

/**
 * EntityAlias filter form.
 *
 * @package    filters
 * @subpackage EntityAlias *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class EntityAliasFormFilter extends BaseEntityAliasFormFilter
{
  public function configure()
  {
    $this->widgetSchema['entity_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['entity_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => 'entity/ajax' ));
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
    
    
  }
}