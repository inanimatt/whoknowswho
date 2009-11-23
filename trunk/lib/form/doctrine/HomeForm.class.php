<?php

/**
 * Home form.
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HomeForm extends BaseHomeForm
{
  public function configure()
  {
    $this->widgetSchema['feature_html']->setAttribute('rows', 25);
    $this->widgetSchema['feature_copy_intro']->setAttribute('rows', 15);
    $this->widgetSchema['feature_copy_extended']->setAttribute('rows', 15);
    $this->widgetSchema['callout_html']->setAttribute('rows', 15);

    $this->widgetSchema['feature_html']->setAttribute('cols', 80);
    $this->widgetSchema['feature_copy_intro']->setAttribute('cols', 80);
    $this->widgetSchema['feature_copy_extended']->setAttribute('cols', 80);
    $this->widgetSchema['callout_html']->setAttribute('cols', 80);

    $this->widgetSchema['feature_html']->setAttribute('style', 'font-family:monospace');
    $this->widgetSchema['feature_copy_intro']->setAttribute('style', 'font-family:monospace');
    $this->widgetSchema['feature_copy_extended']->setAttribute('style', 'font-family:monospace');
    $this->widgetSchema['callout_html']->setAttribute('style', 'font-family:monospace');

    
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
        
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
        
    
  }
}
