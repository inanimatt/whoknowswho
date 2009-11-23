<?php

require_once dirname(__FILE__).'/../lib/fact_sourceGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/fact_sourceGeneratorHelper.class.php';

/**
 * fact_source actions.
 *
 * @package    c4foaf
 * @subpackage fact_source
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class fact_sourceActions extends autoFact_sourceActions
{
  
  public function executeEdit(sfWebRequest $request) {
    $this->fact_source = $this->getRoute()->getObject();
    $this->form = new FactSourceForm($this->fact_source, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  public function executeNew(sfWebRequest $request) {
    $this->fact_source = new FactSource();
    $this->fact_source['Creator'] = $this->getUser()->getGuardUser();
    
    $this->fact_source['fact_id'] = $this->getRequestParameter('fact_id',null);
    
    $this->form = new FactSourceForm($this->fact_source, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  
  
}
