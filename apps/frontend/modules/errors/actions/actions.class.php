<?php

/**
 * errors actions.
 *
 * @package    c4foaf
 * @subpackage errors
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class errorsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  

  public function executeNotYetImplemented(sfWebRequest $request)
  {
    $format = $this->getRequestParameter('format');
    
    if ($format == 'xml')
    {
      $this->getResponse()->setContentType('application/xml;charset=utf-8');
      $this->setLayout(false);
      $this->setTemplate('notYetImplementedXML');
      return sfView::SUCCESS;
    }
    
    if ($format == 'json')
    {
      $this->getResponse()->setContentType('text/javascript;charset=utf-8');
      $this->setLayout(false);

      $error = array('error' => array('type' => 'Not yet implemented', 'description' => 'Sorry, please be patient.'));
      return $this->renderText(json_encode($error));
    }
    
  }
  

  public function executeError404(sfWebRequest $request)
  {
    
  }
  
  
}
