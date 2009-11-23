<?php

require_once dirname(__FILE__).'/../lib/storyGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/storyGeneratorHelper.class.php';

/**
 * story actions.
 *
 * @package    c4foaf
 * @subpackage story
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class storyActions extends autoStoryActions
{
  
  public function executeAjax($request)
  {
    $this->getResponse()->setContentType('application/json');

    $stories = StoryTable::retrieveForSelect($request->getParameter('q'), $request->getParameter('limit'));

    return $this->renderText(json_encode($stories));
  }
  
  
  public function executeNew(sfWebRequest $request)
  {
    $this->story = new Story;
    $this->story['Creator'] = $this->getUser()->getGuardUser();
    $this->story['is_public'] = 1;
    
    $this->form = new StoryForm($this->story);
  }
  
}
