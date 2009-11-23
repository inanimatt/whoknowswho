<?php

require_once dirname(__FILE__).'/../lib/factGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/factGeneratorHelper.class.php';

/**
 * fact actions.
 *
 * @package    c4foaf
 * @subpackage fact
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class factActions extends autoFactActions
{
  
  
  public function executeEdit(sfWebRequest $request) {
    $this->fact = $this->getRoute()->getObject();
    $this->form = new FactForm($this->fact, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }


  public function executeNew(sfWebRequest $request) {
    $this->fact = new Fact();
    $this->fact['Creator'] = $this->getUser()->getGuardUser();
    $this->form = new FactForm($this->fact, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
}
