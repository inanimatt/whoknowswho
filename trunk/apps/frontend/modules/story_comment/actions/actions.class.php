<?php

/**
 * story_comment actions.
 *
 * @package    c4foaf
 * @subpackage story_comment
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class story_commentActions extends sfActions
{
  public function executeConfirm(sfWebRequest $request)
  {
    $this->forward404Unless($token = $this->getRequestParameter('token'));
    
    $this->forward404Unless(
      $this->story_comment = Doctrine_Query::create()
        ->select('sc.*')
        ->from('StoryComment sc')
        ->where('sc.confirmation_token = ?', $token)
        ->fetchOne());
    
    $this->story_comment->setEmailConfirmed('1');
    $this->story_comment->save();
    $this->story_comment->free();
  }
  
  public function executeGetAllComments(sfWebRequest $request)
  {
    $this->forward404Unless($story_id = $this->getRequestParameter('id'));
    
    $this->story_comments = Doctrine::getTable('StoryComment')
    ->createQuery('sc')
    ->where('sc.story_id = ?', $story_id)
    ->andWhere('sc.comment_approved = ?', 1)
    ->orderBy('id')
    ->offset('5')
    ->execute(null, Doctrine::HYDRATE_ARRAY);	  
  }
}
