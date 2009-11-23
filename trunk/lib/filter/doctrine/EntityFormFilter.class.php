<?php

/**
 * Entity filter form.
 *
 * @package    filters
 * @subpackage Entity *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class EntityFormFilter extends BaseEntityFormFilter
{
  public function configure()
  {
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
    
  }
}