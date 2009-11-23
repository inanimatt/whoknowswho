<?php

/**
 * search actions.
 *
 * @package    c4foaf
 * @subpackage search
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class searchActions extends sfActions
{
  
  protected function returnResultId($item)
  {
    return $item['id'];
  }
  
  protected function returnEntityId($item)
  {
    return $item['a_entity_id'];
  }
  
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $format = $this->getRequestParameter('format');
    $page = intval($this->getRequestParameter('page',1));
    $filter = strip_tags($this->getRequestParameter('filter', ''));
    $page_length = 10;

    $terms = strip_tags($this->getRequestParameter('q'));
    if (!trim($terms))
    {
      return sfView::ERROR;
    }
    
    $this->terms = $terms;

    // Run the terms through the analyzer to get the stems
    if (function_exists('stem_english')) {
      $stemmer = new Tui_Doctrine_Search_Analyzer_Stemming();
      $terms = join($stemmer->analyze($terms), ' ');
    }

    // Do the search on entity
    if ($filter == 'stories') {
      $entity_ids = array();
    }
    else
    {
      $ids = Doctrine::getTable('Entity')->search($terms);
      $entity_ids = array_map(array($this,'returnResultId'), $ids);

      // Search entity aliases, and resolve them to entity ids
      $ids = Doctrine::getTable('EntityAlias')->search($terms);
      $entity_alias_ids = array_map(array($this,'returnResultId'), $ids);
    
      if ($entity_alias_ids) {
        $q = Doctrine_Query::create()->select('a.entity_id')->from('EntityAlias a')->whereIn('a.id', $entity_alias_ids)->execute(null,Doctrine::HYDRATE_SCALAR);
        $entity_ids_aliased = array_map(array($this, 'returnEntityId'), $q);
    
        $entity_ids = array_unique(array_merge($entity_ids, $entity_ids_aliased));
      }
    }


    
    // Search stories unless filter exists
    if ($filter == 'entities') {
      $story_ids = array();
    }
    else {
      $ids = Doctrine::getTable('Story')->search($terms);
      $story_ids = array_map(array($this,'returnResultId'), $ids);
    }
    

    /* Paging
     * Chunk the id arrays, reduce the set of entity and story ids to the
     * ones for the current page, then retrieve those
     */
    $entity_pages = array_chunk($entity_ids, $page_length);
    if (isset($entity_pages[$page -1])) {
      $fetch_entity_ids = $entity_pages[$page -1];
    } else {
      $fetch_entity_ids = array();
    }

    
    // Now look at the last entity page, and see how many story items to show on that page
    $last_entity_page = end($entity_pages);
    $story_page_1_length = $page_length - count($last_entity_page);
    
    $story_page_1 = false;
    if ($story_page_1_length) {
      $story_page_1 = array_splice($story_ids, 0, $story_page_1_length);
    }
    
    // Create story pages from the rest of the results, then prepend the first page if it exists
    $story_pages = array_chunk($story_ids, $page_length);
    if ($story_page_1)
    {
      array_unshift($story_pages, $story_page_1);
    }

    // On the last page of entities? Show the first page of story_ids
    if ($fetch_entity_ids == $last_entity_page) {
      $fetch_story_ids = $story_page_1;
    } elseif (!$fetch_entity_ids && $story_pages) {
      
      $p = $page - count($entity_pages);
      if ($p > 0 && isset($story_pages[$p]))
      {
        $fetch_story_ids = $story_pages[$p];
      } else {
        $fetch_story_ids = array();
      }
    } else {
      $fetch_story_ids = array();
    }

    // Search info
    $routing = sfContext::getInstance()->getRouting();
    $uri = $routing->getCurrentInternalUri(true).'&q='.$this->terms;
    $uri_no_filter = $uri;
    if ($filter) {
      $uri .= '&filter=' . $filter;
    }
    $this->url           = sfContext::getInstance()->getController()->genUrl($uri);
    $this->url_no_filter = sfContext::getInstance()->getController()->genUrl($uri_no_filter);
    $this->filter        = $filter;
    $this->num_results   = count($entity_ids) + count($story_ids) + (isset($story_page_1) ? count($story_page_1) : 0);
    $this->page          = $page;
    $this->num_pages     = ceil($this->num_results / $page_length);
    $this->showing       = ($page_length * ($page -1) +1) . '-'. (($page_length * ($page-1)) +count($fetch_story_ids) + count($fetch_entity_ids));

    
    if ($this->page == 1) {
      $this->previous_page = 1;
    }
    else {
      $this->previous_page = $this->page -1;
    }

    if ($this->page == $this->num_pages) {
      $this->next_page = $this->num_pages;
    }
    else {
      $this->next_page = $this->page +1;
    }
    
    if ($this->page - 3 > 0) {
      $this->lowrange = $this->page -3;
    }
    else {
      $this->lowrange = 1;
    }
    
    if ($page + 3 < $this->num_pages) {
      $this->highrange = $this->page +3;
    }
    else {
      $this->highrange = $this->num_pages;
    }
    
    // Retrieve entity objects unless filter exists
    if ($filter == 'stories') {
      $this->entities = array();
    }
    else {
      if ($fetch_entity_ids) {
        $this->entities = Doctrine_Query::create()
          ->select('e.*, et.*')
          ->from('Entity e, e.EntityType et, e.Aliases a')
          ->whereIn('e.id', $fetch_entity_ids)
          ->execute();
      } 
      else {
        $this->entities = array();
      }      
    }
 
    // Retrieve story objects unless filter exists
    if ($filter == 'entities') {
      $this->stories = array();
    }
    else {
      if ($fetch_story_ids) {
        $q = Doctrine_Query::create()
          ->select('s.*, sr.*, c.username as author')
          ->from('Story s, s.Rating sr, s.Creator c')
          ->whereIn('s.id', $fetch_story_ids);
        $this->stories = $q->execute();
      } 
      else {
        $this->stories = array();
      }      
    }

    
    
    
    
    // Output template
    if ('html' != $format) {
      
      return $this->forward('errors', 'notYetImplemented');
      $this->getResponse()->setContentType('text/javascript');
      return $this->renderText(json_encode($stories));
    }

  }
}
