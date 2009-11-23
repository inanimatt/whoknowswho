<?php

/**
 * Story filter form.
 *
 * @package    filters
 * @subpackage Story *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class StoryFormFilter extends BaseStoryFormFilter
{
  public function configure()
  {
    $this->widgetSchema['is_public'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(1 => 'Yes', 0 => 'No') ));
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
    
    
  }
}