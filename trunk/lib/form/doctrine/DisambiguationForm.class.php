<?php

/**
 * Disambiguation form.
 *
 * @package    form
 * @subpackage Disambiguation
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class DisambiguationForm extends BaseDisambiguationForm
{
  public function configure()
  {
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
  }
}