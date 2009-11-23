<?php

require_once dirname(__FILE__).'/../lib/entityGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entityGeneratorHelper.class.php';

/**
 * entity actions.
 *
 * @package    c4foaf
 * @subpackage entity
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class entityActions extends autoEntityActions
{
  
  public function executeAjax($request)
  {
    $this->getResponse()->setContentType('application/json');

    $entities = EntityTable::retrieveForSelect($request->getParameter('q'), $request->getParameter('limit'));

    return $this->renderText(json_encode($entities));
  }
  
  
  
  
  public function executeEdit(sfWebRequest $request) {
    $this->entity = $this->getRoute()->getObject();
    $this->form = new EntityForm($this->entity, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  
  
  public function executeNew(sfWebRequest $request) {
    $this->entity = new Entity();
    $this->entity['Creator'] = $this->getUser()->getGuardUser();
    
    $this->form = new EntityForm($this->entity, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  
}
