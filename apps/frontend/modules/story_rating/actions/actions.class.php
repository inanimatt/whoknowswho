<?php

/**
 * story_rating actions.
 *
 * @package    c4foaf
 * @subpackage story_rating
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class story_ratingActions extends sfActions
{
  public function executeUpdate(sfWebRequest $request)
  {
    //$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        
    $this->forward404Unless($score = $request->getParameter('score'));
    $this->forward404Unless($story_rating = Doctrine::getTable('StoryRating')->find($request->getParameter('story_id')), sprintf('Object story_rating does not exist (%s).', $request->getParameter('story_id')));
    
    switch ($score) {
      case 1:
        $votecount = $story_rating->get1Votes();
        $votecount ++;
        $story_rating->set1Votes($votecount);
        break;
      case 2:
        $votecount = $story_rating->get2Votes();
        $votecount ++;
        $story_rating->set2Votes($votecount);
        break;
      case 3:
        $votecount = $story_rating->get3Votes();
        $votecount ++;
        $story_rating->set3Votes($votecount);
        break;
      case 4:
        $votecount = $story_rating->get4Votes();
        $votecount ++;
        $story_rating->set4Votes($votecount);
        break;
      case 5:
        $votecount = $story_rating->get5Votes();
        $votecount ++;
        $story_rating->set5Votes($votecount);
        break;
    }

    $story_rating->save();
    
    //return average vote so we can update page element after each vote
    $this->getResponse()->setContent($story_rating->getAverageVote());
    
    $story_rating->free();
    
    return sfView::NONE;
  }
}
