<?php

require_once dirname(__FILE__).'/../lib/homeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/homeGeneratorHelper.class.php';

/**
 * home actions.
 *
 * @package    c4foaf
 * @subpackage home
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends autoHomeActions
{
  
  public function executePreview($request)
  {
    $url = 'http://'.str_replace('/','',$_SERVER['HTTP_HOST']).'/preview/'.intval($this->getRequestParameter('id'));
    $this->redirect($url);
  }
  
}
