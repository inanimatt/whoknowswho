<?php

require_once dirname(__FILE__).'/../lib/fact_commentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/fact_commentGeneratorHelper.class.php';

/**
 * fact_comment_comment actions.
 *
 * @package    c4foaf
 * @subpackage fact_comment_comment
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class fact_commentActions extends autoFact_commentActions
{  
  
  public function executeEdit(sfWebRequest $request) {
    $this->fact_comment = $this->getRoute()->getObject();
    $this->form = new FactCommentForm($this->fact_comment, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }


  public function executeNew(sfWebRequest $request) {
    $this->fact_comment = new FactComment();
    $this->form = new FactCommentForm($this->fact_comment, array('url' => $this->getController()->genUrl('entity/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
}
