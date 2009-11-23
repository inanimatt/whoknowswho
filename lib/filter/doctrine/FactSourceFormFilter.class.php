<?php

/**
 * FactSource filter form.
 *
 * @package    filters
 * @subpackage FactSource *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class FactSourceFormFilter extends BaseFactSourceFormFilter
{
  public function configure()
  {
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
    
    $this->widgetSchema['is_supporting'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(1 => 'Yes', 0 => 'No') ));
    
  }
}