<?php

require_once dirname(__FILE__).'/../lib/entity_aliasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/entity_aliasGeneratorHelper.class.php';

/**
 * entity_alias actions.
 *
 * @package    c4foaf
 * @subpackage entity_alias
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class entity_aliasActions extends autoEntity_aliasActions
{
  
  public function executeEdit(sfWebRequest $request) {
    $this->entity_alias = $this->getRoute()->getObject();
    $this->form = new EntityAliasForm($this->entity_alias, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }


  public function executeNew(sfWebRequest $request) {
    $this->entity_alias = new EntityAlias();
    $this->entity_alias['Creator'] = $this->getUser()->getGuardUser();
    
    $this->form = new EntityAliasForm($this->entity_alias, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  
}
