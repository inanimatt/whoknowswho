<?php

require_once dirname(__FILE__).'/../lib/entity_urlGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entity_urlGeneratorHelper.class.php';

/**
 * entity_url actions.
 *
 * @package    c4foaf
 * @subpackage entity_url
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class entity_urlActions extends autoEntity_urlActions
{
  
  
  
  public function executeEdit(sfWebRequest $request) {
    $this->entity_url = $this->getRoute()->getObject();
    $this->form = new EntityUrlForm($this->entity_url, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  public function executeNew(sfWebRequest $request) {
    $this->entity_url = new EntityUrl();
    $this->entity_url->set('Creator', $this->getUser()->getGuardUser());
    $this->form = new EntityUrlForm($this->entity_url, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
}
