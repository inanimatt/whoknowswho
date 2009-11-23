<?php

/**
 * story_edit actions.
 *
 * @package    c4foaf
 * @subpackage story_edit
 * @author     Tui Interactive Media
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class story_editActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $currentPage = intval($this->getRequestParameter('page', 1));
    $resultsPerPage = 25;
    
    
    // List stories, link through to editor
    $this->pager = new Doctrine_Pager(Doctrine_Query::create()
                                      ->from('Story s, s.Creator')
                                      ->orderBy('s.title DESC'),
                                     $currentPage,
                                     $resultsPerPage
                                    );
    $this->stories = $this->pager->execute();

  }
  
  
  public function executeView()
  {
    $id = $this->getRequestParameter('id');
    $this->story = Doctrine_Query::create()
                    ->select('s.*, u.*, r.*, sf.*, f.*, e.*, re.*, fs.*, et1.*, et2.*')
                    ->from('Story s, s.Creator u, s.Rating r, s.StoryFacts sf, sf.Fact f, f.Entity e, f.RelatedEntity re, f.Sources fs, e.EntityType et1, re.EntityType et2')
                    ->where(is_numeric($id) ? 's.id = ?' : 's.slug = ?')
                    ->orderBy('sf.story_order ASC')
                    ->fetchOne(array($id));
    $this->forward404Unless($this->story);
    
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {
      
      // Update StoryFact objects
      $story_facts = array();
      foreach($this->story->getStoryFacts() as $sf)
      {
        $story_facts[$sf['fact_id']] = $sf;
      }
      
      $form_data = $this->getRequestParameter('story_fact',array());
      foreach($form_data as $fid => $data)
      {
        if (!isset($story_facts[$fid])) continue; // Discard nonsense

        if (isset($data['delete']) && $data['delete'] == 1)
        {
          Doctrine_Query::create()->from('StoryFact sf')->where('sf.story_id = ?', $this->story['id'])->andWhere('sf.fact_id = ?', $fid)->delete()->execute();
          unset($story_facts[$fid]);
          continue;
        }
        $story_facts[$fid]->set('description', strip_tags($data['description']));
        $story_facts[$fid]->set('primary_entity', ($data['primary_entity'] == 'entity') ? 'entity' : 'related');
        $story_facts[$fid]->set('story_order', intval($data['story_order']));
        $story_facts[$fid]->save();
      }

      return $this->redirect('story_edit/view?id='.$this->story['id']);
      
    }
    
    
  }
  


  public function executeFind()
  {
    if ($this->getRequest()->getMethod() != sfRequest::POST) 
    {
      $this->message = 'You can only get to this page through the search form on the story editor, sorry.';
      return sfView::ERROR;
    }

    $this->story = Doctrine::getTable('Story')->find($this->getRequestParameter('id'));
    $this->forward404Unless($this->story);

    // Find facts by entity
    $name = trim(strip_tags($this->getRequestParameter('entity',false)));
    if (!$name || strlen($name) < 3) {
      $this->message = 'You must provide a search term (minimum 3 letters)';
      return sfView::ERROR;
    }
    $name_query = sprintf('%%%s%%', $name);
    
    $this->result = Doctrine_Query::create()
              ->select('f.*, e.*, re.*, ft.*')
              ->from('Fact f, f.Entity e, f.RelatedEntity re, e.Aliases ea, re.Aliases rea, f.FactType ft')
              ->where('re.name LIKE ?', $name_query)
              ->orWhere('e.name LIKE ?', $name_query)
              ->orWhere('ea.name LIKE ?', $name_query)
              ->orWhere('rea.name LIKE ?', $name_query)
              ->orderBy('f.title')
              ->limit(50);
    
    
  }
  
  
    
    
    
    
  public function executeAdd()
  {
    if ($this->getRequest()->getMethod() != sfRequest::POST) 
    {
      return sfView::ERROR;
    }

    $story = Doctrine::getTable('Story')->find($this->getRequestParameter('story'));
    $fact  = Doctrine::getTable('Fact')->find($this->getRequestParameter('fid'));
    $this->forward404Unless($story && $fact);

    $sf = new StoryFact;
    $sf['story_id']    = $story['id'];
    $sf['fact_id']     = $fact['id'];
    $sf['description'] = $fact['title'];

    $sf->save();
    
    return $this->redirect('story_edit/view?id='.$story['id']);
    
    
  }
  
  
  
  
  
  
  
  
}
