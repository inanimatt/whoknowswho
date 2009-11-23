<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  
  
  public function executeAjax($request)
  {
    $this->getResponse()->setContentType('application/json');

    $entities = sfGuardUserTable::retrieveForSelect($request->getParameter('q'), $request->getParameter('limit'));

    return $this->renderText(json_encode($entities));
  }
  
  
  
  
  
}
