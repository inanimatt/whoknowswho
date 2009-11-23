<?php

/**
 * entity actions.
 *
 * @package    c4foaf
 * @subpackage entity
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class entityActions extends sfActions
{
 /**
  * Shared URL-checking and canonicalisation (ooh, nice word)
  *
  * @param sfRequest $request A request object
  */
  public function preExecute()
  {

    $this->type   = $this->getRequestParameter('entity_type');

    // Entity-type list pages don't give an entity, so skip this step.
    if ('index' == $this->getActionName()) 
    {
      return;
    }
    
    $this->format = $this->getRequestParameter('format');
    $this->id     = $this->getRequestParameter('id');
    
    // Get the entity (and redirect if necessary)
    
    $this->entity = Doctrine_Query::create()
          ->select('e.*, et.*, a.*')
          ->from('Entity e, e.EntityType et, e.Aliases a')
          ->where(is_numeric($this->id) ? 'e.id = ?' : 'e.slug = ?')
          ->fetchOne(array($this->id));
    
    $this->forward404Unless($this->entity);
    

    $routing = sfContext::getInstance()->getRouting();
    $uri = $routing->getCurrentInternalUri(true);

    // Redirect numeric to slug - but allow incorrectness in API calls
    if (('html' == $this->format) && is_numeric($this->id))
    {
      $uri = str_replace('id='.$this->id, 'id='.$this->entity['slug'], $uri);
      $uri = str_replace('entity_type='.$this->type, 'entity_type='.$this->entity['EntityType']['url_slug'], $uri);
      return $this->redirect($uri, 302); // Found
    }
    
    // Redirect to canonical capitalisation - but allow incorrectness in API calls
    $redirect = false;
    if (('html' == $this->format) && $this->id != $this->entity['slug'])
    {
      $uri = str_replace('id='.$this->id, 'id='.$this->entity['slug'], $uri);
      $redirect = true;
    }
    
    // Redirect if type is incorrect - but allow incorrectness in API calls
    if (('html' == $this->format) && ($this->type != $this->entity['EntityType']['url_slug']))
    {
      $uri = str_replace('entity_type='.$this->type, 'entity_type='.$this->entity['EntityType']['url_slug'], $uri);
      $redirect = true;
    }

    if ($redirect)
    {
      return $this->redirect($uri, 301); // Moved permanently
    }


  }


  public function executeIndex(sfWebRequest $request)
  {
    $e = $this->entity;
    $this->strippedurl = sfContext::getInstance()->getController()->genUrl(sfContext::getInstance()->getRouting()->getCurrentInternalUri());
    $orderby = $this->getRequestParameter('orderby');
    $order = $this->getRequestParameter('order');
    $resultsPerPage = 10;
    $currentPage = intval($this->getRequestParameter('page', 1));

    $this->entity_type = Doctrine_Query::create()->from('EntityType et')->where('et.url_slug = ?', $this->type)->fetchOne();
    $this->forward404Unless($this->entity_type);
    
    // Set page title
    $this->getResponse()->setTitle(ucfirst($e['EntityType']['url_slug']).' • Who Knows Who');

    // Man, this is excessively anal. 
    switch ($orderby) {
      case "name":
        $orderbysafe = 'name';
        $orderbyurltext = 'orderby=name';
        break;
      case "connectedness":
        $orderbysafe = 'connectedness';
        $orderbyurltext = 'orderby=connectedness';
        break;
      case "interest":
        $orderbysafe = 'interest';
        $orderbyurltext = 'orderby=interest';
        break;
      default:
        $orderbysafe = 'name';
        $orderbyurltext = '';
    }
    
    switch ($order) {
      case "ASC":
        $ordersafe = 'ASC';
        $orderurltext = '&order=ASC';
        break;
      case "DESC":
        $ordersafe = 'DESC';
        $orderurltext = '&order=DESC';
        break;
      default:
        $ordersafe = 'ASC';
        $orderurltext = '';
    }
    
    $this->url = $this->getController()->genUrl('@entity_list?entity_type='.$this->entity_type['url_slug']);
    $this->url .= '?' . $orderbyurltext . $orderurltext.'&page=';
    
    $q = Doctrine_Query::create()
      ->select('e.*, et.*')
      ->from('Entity e, e.EntityType et')
      ->where('et.url_slug = ?', $this->type)
      ->orderBy($orderbysafe . ' '. $ordersafe);
      
    $this->pager = new sfDoctrinePager('entity', $resultsPerPage);
    $this->pager->setQuery($q);
    $this->pager->setPage($currentPage);
    $this->pager->init();
    
  }
  
  
  public function executeView(sfWebRequest $request)
  {
    $e = $this->entity;
    
    // Set page title
    $this->getResponse()->setTitle($e['name'].' • '.ucfirst($e['EntityType']['url_slug']).' • Who Knows Who');
    

    // Get connections
    
    $connections = array('personal' => $e->getConnections('personal', 4, Doctrine::HYDRATE_RECORD), 
                         'other' => $e->getConnections('other', 4, Doctrine::HYDRATE_RECORD), 
                         'count' => array('personal' => $e->countConnections('personal'), 'other' => $e->countConnections('other'), 'total' => $e->countConnections())
                        );

    $this->entity = $e;
    $this->connections  = $connections;

    //get facts
    $this->facts = $e->getInterestingFacts();
    
    //get education facts
    $this->education_facts = $e->getEducationFacts();
    
    //get employment facts
    $this->employment_facts = $e->getEmploymentFacts();   
    
    //get links
    $this->links = $e->getLinks();  
    
    $this->stories = Doctrine::getTable('Story')->retrieveByEntity($e->getId(), 3, StoryTable::SORT_BY_RATING);
    foreach($this->stories as $s)
    {
      if (!$s->getRating() instanceof StoryRating)
      {
        $s->setRating(new StoryRating);
      }
    }

    // Increment views
    $views_cache = 'entity-views-'.$e->getId();
    $views_list = tuiCacheHandler::getInstance()->get('entity-views-list');
    if (!$views_list) { $views_list = array(); }
    
    if (in_array($e->getId(), $views_list)) {
      tuiCacheHandler::getInstance()->getHandler()->increment($views_cache);
    } else {
      $views_list[] = $e->getId();
      tuiCacheHandler::getInstance()->set('entity-views-list', $views_list, 0); // Don't expire
      tuiCacheHandler::getInstance()->set($views_cache, 1, 0); // Don't expire
    }
    

    // Output template
    if ('xml' == $this->format) {
      return $this->forward('errors', 'notYetImplemented');
    }   
    elseif ('html' != $this->format) {
      
      return $this->forward('errors', 'notYetImplemented');
      // $this->getResponse()->setContentType('text/javascript');
      // return $this->renderText(json_encode($this->entity));
    }


  }
  
  

  public function executeMap(sfWebRequest $request)
  {
    if ('html' == $this->format)
    {
      // Set page title
      $this->getResponse()->setTitle('The map of '. $this->entity['name'].' • '.ucfirst($this->entity['EntityType']['url_slug']).' • Who Knows Who');

      $this->mapUrl = $this->entity->getMapUrl('xml');
      return sfView::SUCCESS; // Show the HTML page containing the map
    }
    
    //get facts
    $facts = $this->entity->getFacts();
    $this->all_connections = $this->entity->getAllConnections();   
  
    $distances = array();
    foreach($facts as $f)
    {
      $operative_entity = ($f['Entity']['id'] == $this->entity->getId()) ? $f['RelatedEntity']['id'] : $f['Entity']['id'];
      if (isset($distances[$operative_entity])) {
        $distances[$operative_entity]++;
      } else {
        $distances[$operative_entity] = 1;
      }
    }
    $this->distances = $distances;
  
  
    // Add mutual relationships between results
    $entities = array();
    foreach($this->all_connections as $e)
    {
      $entities[] = $e['id'];
    }
    
    if ($entities) {
      foreach(Doctrine::getTable('Fact')->retrieveConnectionsByEntities($entities) as $f)
      {
        $facts[] = $f;
      }
      $this->facts = $facts;
    }
    
    // Crazy XML/JSON shit
    // $this->format
    if ('json' == $this->format)
    {
      return $this->forward('errors', 'notYetImplemented');
    }
    
    if ('xml' ==  $this->format)
    {
   
      
      $this->getResponse()->setContentType('text/xml');
      $this->setTemplate('xml');
      
    }
    
  
  }
  
  
  // This action exists here to benefit from the Entity preExecute, so don't move it even if you think it doesn't belong here.
  public function executeListStoriesByEntity(sfWebRequest $request)
  {
    return $this->forward('stories','index');
  }
 
  /* This one's a bit awkward in my mind - the HTML and XML appear to show different things.
   * The XML view lists Fact objects, while the HTML shows Entities with a 
   * "what's the connection?" callout that calls the Ajax version of this with 
   * the 'related_id' clause. In effect it's the same thing, but it might not feel like it.
   */
 
  public function executeConnections(sfWebRequest $request)
  {
    if ($related_id = $this->getRequestParameter('related_id'))
    {
      if (!is_numeric($related_id))
      {
        $result = Doctrine_Query::create()->select('e.id')->from('Entity e')->where('e.slug = ?', $related_id)->fetchOne(null, Doctrine::HYDRATE_ARRAY);
        if ($result && isset($result['id']))
        {
          $related_id = $result['id'];
        }
        
        $this->forward404Unless($related_id);
      }      
    }


    if ('xml' == $this->format || 'ajax' == $this->format)
    {
      // Get all direct relationships to the current entity (or between two entities)
      if ($related_id) 
      {
        $this->facts = $this->entity->getConnectionsTo($related_id, Doctrine::HYDRATE_RECORD);
      }
      else
      {
        $this->facts = $this->entity->getFacts(Doctrine::HYDRATE_RECORD);
      }
    }
    
    
    if ('xml' == $this->format)
    {
      $this->getResponse()->setContentType('text/xml');
      $this->setTemplate('connectionsXML');
      $this->setLayout(false);
      return sfView::SUCCESS;
    }

    if ('ajax' == $this->format)
    {
      $this->setTemplate('connectionsAjax');
      $this->setLayout(false);
      return sfView::SUCCESS;
    }


    if ('html' == $this->format)
    {
      
      if ($related_id)
      {
        $this->facts = $this->entity->getConnectionsTo($related_id, Doctrine::HYDRATE_RECORD);
        $this->setTemplate('connectionsAjax');
        return sfView::SUCCESS;
      }

      // Set page title
      $this->getResponse()->setTitle('Connections for '.$this->entity['name'].' • '.ucfirst($this->entity['EntityType']['url_slug']).' • Who Knows Who');

      $this->strippedurl = sfContext::getInstance()->getController()->genUrl(sfContext::getInstance()->getRouting()->getCurrentInternalUri());
      $orderby = $this->getRequestParameter('orderby');
      $order = $this->getRequestParameter('order');

	  switch ($orderby) {
	    case "name":
	      $orderbysafe = 'name';
	      $orderbyurltext = 'orderby=name';
	      break;
	    case "connectedness":
	      $orderbysafe = 'connectedness';
	      $orderbyurltext = 'orderby=connectedness';
	      break;
	    case "interest":
	      $orderbysafe = 'interest';
	      $orderbyurltext = 'orderby=interest';
	      break;
	    default:
	      $orderbysafe = 'name';
	      $orderbyurltext = '';
	  }
	    
	  switch ($order) {
	    case "ASC":
	      $ordersafe = 'ASC';
	      $orderurltext = '&order=ASC';
	      break;
	    case "DESC":
	      $ordersafe = 'DESC';
	      $orderurltext = '&order=DESC';
	      break;
	    default:
	      $ordersafe = 'ASC';
	      $orderurltext = '';
	  }      
	  
	  $this->url = $this->entity->getConnectionsUrl();
      $this->url .= '?' . $orderbyurltext . $orderurltext.'&page=';
	  
	  
      $q = Doctrine::getTable('Entity')->getAllConnectionsQuery($this->entity->getId());
      $q->orderBy($orderbysafe . ' '. $ordersafe);; // FIXME: should be user-configurable
      
      $resultsPerPage = 10;
      $currentPage = intval($this->getRequestParameter('page', 1));
      
      $this->pager = new sfDoctrinePager('entity', $resultsPerPage);
      $this->pager->setQuery($q);
      $this->pager->setPage($currentPage);
      $this->pager->init();
      return sfView::SUCCESS;
    }
    
    if ('json' == $this->format)
    {
      return $this->forward('errors', 'notYetImplemented');
    }
    

    
  }
 


  public function executeInterestingFacts(sfWebRequest $request)
  {

    switch($this->format)
    {
      case 'xml':
        // $this->getResponse()->setContentType('text/xml');
        // $this->setTemplate('InterestingFactsXML');
        // $this->setLayout(false);
        return $this->forward('errors', 'notYetImplemented');
        // Intentionally not 'break'ing here.

      case 'html':
        $limit = 0;
        $offset = 0;
        // Set page title
        $this->getResponse()->setTitle('Interesting facts for '.$this->entity['name'].' • '.ucfirst($this->entity['EntityType']['url_slug']).' • Who Knows Who');
        
        break;

      case 'ajax':
        $this->setTemplate('interestingFactsAjax');
        $this->setLayout(false);
        $limit = 0;
        $offset = 10;
        break;

      case 'json':
        return $this->forward('errors', 'notYetImplemented');
    }
    
    
    $this->facts = $this->entity->getInterestingFacts($limit, $offset, Doctrine::HYDRATE_RECORD);
    return sfView::SUCCESS;
    
  }
 


  public function executeQuickInfo(sfWebRequest $request)
  {


    if ('html' == $this->format)
    {
      return $this->forward('errors', 'notYetImplemented');
    }
    
    if ('json' == $this->format)
    {
      return $this->forward('errors', 'notYetImplemented');
    }
    
    if ('xml' == $this->format)
    {
      $this->getResponse()->setContentType('text/xml');
      $this->setTemplate('quickInfoXML');
      $this->setLayout(false);
      return sfView::SUCCESS;
    }
    
  }
 
 
  
}
