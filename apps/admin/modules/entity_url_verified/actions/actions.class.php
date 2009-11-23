<?php

require_once dirname(__FILE__).'/../lib/entity_url_verifiedGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entity_url_verifiedGeneratorHelper.class.php';

/**
 * entity_url_verified actions.
 *
 * @package    c4foaf
 * @subpackage entity_url_verified
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class entity_url_verifiedActions extends autoEntity_url_verifiedActions
{
  
  
  public function executeEdit(sfWebRequest $request) {
    $this->entity_url_verified = $this->getRoute()->getObject();
    $this->form = new EntityUrlVerifiedForm($this->entity_url_verified, array('sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  public function executeNew(sfWebRequest $request) {
    $this->entity_url_verified = new EntityUrlVerified();
    $this->form = new EntityUrlVerifiedForm($this->entity_url_verified, array('sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
}
