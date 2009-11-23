<?php

/**
 * stories actions.
 *
 * @package    c4foaf
 * @subpackage stories
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class storiesActions extends sfActions
{
  
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
    {
      
      
      $format = $this->getRequestParameter('format');
      $currentPage = intval($this->getRequestParameter('page', 1));
      $resultsPerPage = 5;

    

      // Entity-context stuff:
      $this->type   = $this->getRequestParameter('entity_type', false);
      $this->format = $this->getRequestParameter('format');
      $this->id     = $this->getRequestParameter('id', false);

      if ($this->id && $this->type) {
        // Get the entity (and redirect if necessary)
      
        $this->entity = Doctrine_Query::create()
              ->select('e.*, et.*')
              ->from('Entity e, e.EntityType et')
              ->where(is_numeric($this->id) ? 'e.id = ?' : 'e.slug = ?')
              ->fetchOne(array($this->id));

        $this->forward404Unless($this->entity);


        $routing = sfContext::getInstance()->getRouting();
        $uri = $routing->getCurrentInternalUri(true);

        // Redirect numeric to slug
        if (is_numeric($this->id) && ('html' == $this->format))
        {
          $uri = str_replace('id='.$this->id, 'id='.$this->entity['slug'], $uri);
          return $this->redirect($uri, 302); // Found
        }

        // Redirect to canonical capitalisation
        $redirect = false;
        if ($this->id != $this->entity['slug'])
        {
          $uri = str_replace('id='.$this->id, 'id='.$this->entity['slug'], $uri);
          $redirect = true;
        }

        // Redirect if type is incorrect
        if (('html' == $this->format) && ($this->type != $this->entity['EntityType']['url_slug']))
        {
          $uri = str_replace('entity_type='.$this->type, 'entity_type='.$this->entity['EntityType']['url_slug'], $uri);
          $redirect = true;
        }

        if ($redirect)
        {
          return $this->redirect($uri, 301); // Moved permanently
        }
        
        $q = Doctrine_Query::create()
              ->select('s.*, c.username as author')
              ->from('Story s, s.Facts f, s.Creator c')
              ->where('f.entity_id = ?', $this->entity['id'])
              ->orWhere('f.related_entity_id = ?', $this->entity['id'])
              ->orderBy('s.title ASC');
              
        $this->title = $this->entity['name'] . ' stories';
      }
      else
      {
        $this->title = 'Stories';
        $this->entity = false;
        
        $q = Doctrine_Query::create()
              ->select('s.*, c.username as author')
              ->from('Story s, s.Creator c')
              ->orderBy('s.title ASC');        
      }
      
      
      // List stories, link through to editor
      $this->pager = new sfDoctrinePager('Story', $resultsPerPage);
      $this->pager->setQuery($q);
      $this->pager->setPage($currentPage);
      $this->pager->init();

      
      
      if ($format != 'html') {
        return $this->forward('errors', 'notYetImplemented');
        // $this->getResponse()->setContentType('text/javascript');
        // return $this->renderText(json_encode($stories));
      }
    }




    public function executeView(sfWebRequest $request)
    {
      $format = $this->getRequestParameter('format');
      $id     = $this->getRequestParameter('id');
      
      // Showing in entity context? We need to show different next & prev in that case
      $entity_id = $this->getRequestParameter('entity_id', false);
      $this->context_entity = $entity_id ? Doctrine::getTable('Entity')->retrieveCached($entity_id) : false;
      
      // Get the story (and redirect if necessary)
      $this->story = Doctrine_Query::create()
                      ->select('s.*, u.*, r.*, sf.*, f.*, e.*, re.*, fs.*, et1.*, et2.*')
                      ->from('Story s, s.Creator u, s.Rating r, s.StoryFacts sf, sf.Fact f, f.Entity e, f.RelatedEntity re, f.Sources fs, e.EntityType et1, re.EntityType et2')
                      ->where(is_numeric($id) ? 's.id = ?' : 's.slug = ?')
                      ->orderBy('sf.story_order ASC')
                      ->fetchOne(array($id));
        
      // For web requests, forward numeric requests to the canonical named version
      if (is_numeric($id) && ('html' == $format))
      {
        return $this->redirect('@story_view?id='.$this->story['slug'], 301);
      }


      $this->forward404Unless($this->story);
      $this->getResponse()->setTitle($this->story['title'].' • Stories • Who Knows Who');
      
      if (!$this->story->getRating() instanceof StoryRating)
      {
        $this->story->setRating(new StoryRating);
      }
      $this->rating = round($this->story->getRating()->getAverageVote());
      
      // Increment views
      $views_cache = 'story-views-'.$this->story->getId();
      $views_list = tuiCacheHandler::getInstance()->get('story-views-list');
      if (!$views_list) { $views_list = array(); }

      if (in_array($this->story->getId(), $views_list)) {
        tuiCacheHandler::getInstance()->getHandler()->increment($views_cache);
      } else {
        $views_list[] = $this->story->getId();
        tuiCacheHandler::getInstance()->set('story-views-list', $views_list, 0); // Don't expire
        tuiCacheHandler::getInstance()->set($views_cache, 1, 0); // Don't expire
      }
      
      
      if ('html' != $format) {
        if ('plain' == $format)
        {
          $this->setTemplate('viewPlain');
          return sfView::SUCCESS;
        }
        
        return $this->forward('errors', 'notYetImplemented');
        // $this->getResponse()->setContentType('text/javascript');
        // return $this->renderText(json_encode($stories));
      }

    }

    
      
    
    public function executeViewByEntity(sfWebRequest $request)
    {
      return $this->forward('stories','view');
    }
    
    
  
}
