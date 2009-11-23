<?php

require_once dirname(__FILE__).'/../lib/fact_source_verifiedGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/fact_source_verifiedGeneratorHelper.class.php';

/**
 * fact_source_verified actions.
 *
 * @package    c4foaf
 * @subpackage fact_source_verified
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class fact_source_verifiedActions extends autoFact_source_verifiedActions
{
  
  public function executeEdit(sfWebRequest $request) {
    $this->fact_source_verified = $this->getRoute()->getObject();
    $this->form = new FactSourceVerifiedForm($this->fact_source_verified, array('sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  public function executeNew(sfWebRequest $request) {
    $this->fact_source_verified = new FactSourceVerified();
    $this->form = new FactSourceVerifiedForm($this->fact_source_verified, array('sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
}
