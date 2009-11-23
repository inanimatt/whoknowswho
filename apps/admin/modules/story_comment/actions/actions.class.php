<?php

require_once dirname(__FILE__).'/../lib/story_commentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/story_commentGeneratorHelper.class.php';

/**
 * story_comment actions.
 *
 * @package    c4foaf
 * @subpackage story_comment
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class story_commentActions extends autoStory_commentActions
{
  
  
  public function executeEdit(sfWebRequest $request) {
    $this->story_comment = $this->getRoute()->getObject();
    $this->form = new StoryCommentForm($this->story_comment, array('storyurl' => $this->getController()->genUrl('story/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }


  public function executeNew(sfWebRequest $request) {
    $this->story_comment = new StoryComment();
    $this->form = new StoryCommentForm($this->story_comment, array('storyurl' => $this->getController()->genUrl('story/ajax'), 'sfguardurl' => $this->getController()->genUrl('sfGuardAuth/ajax')));
  }
  
  public function executeApproveComment($request)
  {
  	$story_comment = Doctrine::getTable('StoryComment')->findOneById($request->getParameter('id'));
    $story_comment->setCreatedBy($this->getUser()->getGuardUser()->getId());
    $story_comment->setCommentApproved(1);
    $story_comment->save();
 
    $this->getUser()->setFlash('notice', 'Comment has been approved.'); 
    $this->redirect('story_comment');
  }
}
