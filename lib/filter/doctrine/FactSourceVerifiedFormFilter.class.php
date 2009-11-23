<?php

/**
 * FactSourceVerified filter form.
 *
 * @package    filters
 * @subpackage FactSourceVerified *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class FactSourceVerifiedFormFilter extends BaseFactSourceVerifiedFormFilter
{
  public function configure()
  {
    $this->widgetSchema['fact_source_id'] = new sfWidgetFormInput();
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
    
  }
}