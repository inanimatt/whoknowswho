<?php

class tuiValidatorDate extends sfValidatorBase
{
  protected function doClean($value)
  {
    if (!is_array($value) || !isset($value['day']) || !isset($value['month']) || !isset($value['year']))
    {
      throw new sfValidatorError($this, 'invalid_input', array('value' => $value, ));
    }

    // Some partial dates are not okay
    if (!$value['year'] && ($value['day'] || $value['month']))
    {
      throw new sfValidatorError($this, 'format_error', array('value' => $value, ));
    }
    
    if ($value['year'] && $value['day'] && !$value['month'])
    {
      throw new sfValidatorError($this, 'format_error', array('value' => $value, ));
    }
    
    // Blank dates are okay
    if (!$value['year'] && !$value['month'] && !$value['day']) 
    {
      return null;
    }
    
    if ($value['day'] && !in_array($value['day'], range(1,31)))
    {
      throw new sfValidatorError($this, 'invalid_range', array('value' => $value, ));
    }
    
    if ($value['month'] && !in_array($value['month'], range(1,12)))
    {
      throw new sfValidatorError($this, 'invalid_range', array('value' => $value, ));
    }
    
    if ($value['year'] && !in_array($value['year'], range(0,9999)))
    {
      throw new sfValidatorError($this, 'invalid_range', array('value' => $value, ));
    }
    
    $output = sprintf('%04d-%02d-%02d',$value['year'],$value['month'],$value['day']);
    
    return $output;
  }
 
  protected function configure ($options = array(), $messages = array())
  {
    // Set defaults
    $this->addOption('allow_partial', true);

    $this->addMessage('format_error', 'Only YYYY, YYYY-MM, or YYYY-MM-DD dates are allowed.');
    $this->addMessage('invalid_input', 'Form input invalid (should be array).');
    $this->addMessage('invalid_range', 'Invalid month or day range.');

    return true;
  }
}