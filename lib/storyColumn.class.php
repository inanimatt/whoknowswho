<?php

class StoryColumn
{
  protected $entries = array();
  protected $story_facts = array();
  
  
  public function __construct($story_facts) {
    // Store facts
    $this->story_facts = $story_facts;
  }
  



  public function render()
  {
    if (!$this->story_facts)
    {
      return '';
    }
    
    // Build $this->entries
    $this->buildColumn();
    
    
    // Render HTML
    $out = '';
    foreach($this->entries as $e) {
      $out .= $e->render();
    } 
    
    
    // Return it
    return $out;
  }




  protected function buildColumn()
  {
    //Foreach story_fact+fact
    //  Are both entities the same as the previous column entry?
    //    Add the fact to the previous entry
    //
    //  Is the first entity (from story_fact entity_order) the same as the last entity (from story_fact entity_order) in the previous entry
    //    New entry features no first entity, just story_fact, secondary entity
    //
    //  Otherwise
    //    New entry (first entity, story fact, second entity)
    
    foreach($this->story_facts as $sf)
    {
      end($this->entries);
      $latest = current($this->entries);

      if ($sf['primary_entity'] == 'entity')
      {
        $primary   = $sf['Fact']['Entity'];
        $secondary = $sf['Fact']['RelatedEntity'];
      }
      else
      {
        $primary   = $sf['Fact']['RelatedEntity'];
        $secondary = $sf['Fact']['Entity'];
      }


      if ($latest) {
        //  Are both entities the same as the previous column entry?
        //    Add the fact to the previous entry
        if ($latest->primary == $primary && $latest->secondary == $secondary)
        {
          $latest->facts[] = $sf;
          continue;
        }
      
        //  Is the first entity (from story_fact entity_order) the same as the last entity (from story_fact entity_order) in the previous entry
        //    New entry features no first entity, just story_fact, secondary entity
        if ($latest->secondary == $primary)
        {
          $entry = new StoryColumnEntry($primary, $sf, $secondary);
          $entry->hidePrimary = true;
          $this->entries[] = $entry;
          continue;
        }
        
        // Is the first entity the same as the first entity from the previous entry?
        //   Skip first entity in new entry, amend fact text (add 'and')
        if ($latest->primary == $primary)
        {
          $sf['description'] = $sf['description'];
          $entry = new StoryColumnEntry($primary, $sf, $secondary);
          $entry->hidePrimary = true;
          $this->entries[] = $entry;
          continue;
        }
        
      }
      
      //  Otherwise
      //    New entry (first entity, story fact, second entity)
      $entry = new StoryColumnEntry($primary, $sf, $secondary);
      $this->entries[] = $entry;
    }
    
    
  }



 
}




class StoryColumnEntry
{
  public $primary   = null;
  public $secondary = null;
  public $facts     = array();
  
  public $hidePrimary   = false;
  public $hideSecondary = false;
  
  
  public function __construct($primary, $story_fact, $secondary) {
    $this->primary   = $primary;
    $this->secondary = $secondary;
    $this->facts[]   = $story_fact;
  }
  
  
  public function render()
  {
    $out = '';

    if ($this->primary && !$this->hidePrimary) 
    {
      $out .= $this->renderSeparator();
    }

    if (!$this->hidePrimary)
    {
      $out .= $this->renderEntity($this->primary);
    }
    
    $fact_out = array_map(array($this,'renderFact'), $this->facts);
    
    $out .= join($this->renderAnd(), $fact_out);
    
    if ($this->secondary && !$this->hideSecondary)
    {
      $out .= $this->renderEntity($this->secondary);
    }
    

    return $out;
  }
   
  public function renderEntity($e)
  {
    // $avatar = foaf_image('/static/images/site/grey_square.gif');
    $e['name']        = htmlspecialchars($e['name'], ENT_COMPAT, 'UTF-8');
    $e['subtitle']    = htmlspecialchars($e['subtitle'], ENT_COMPAT, 'UTF-8');
    $e['description'] = htmlspecialchars($e['description'], ENT_COMPAT, 'UTF-8');

    $avatar           = htmlspecialchars($e->getPhotoUrlMedium(), ENT_COMPAT, 'UTF-8');
    $link             = $e->getUrl();
    $map_link         = $e->getMapUrl();
    $stories_link     = $e->getStoriesUrl();
    
    $out =<<<EOT
    <div class="span-6 block-007">
      <div class="span-2"><img src="{$avatar}" alt="{$e['name']}"></div>
      <div class="span-4 last">
        <h4><a href="{$link}">{$e['name']}</a></h4>
        <h4 class="grey">{$e['subtitle']}</h4>
        <p>{$e['description']}</p>    
        <ul class="view-map-stories clearfix">
          <li><a href="{$map_link}" class="divider">View on map</a></li>
          <li><a href="{$stories_link}">More stories</a></li>
        </ul>                               
      </div>
    </div><!--block-007-->
EOT;
    
    return $out;
  }
  
  
  public function renderFact($sf)
  {
    $sf['description'] = htmlspecialchars($sf['description'], ENT_COMPAT, 'UTF-8');
    $sf['Fact']['description'] = htmlspecialchars($sf['Fact']['description'], ENT_COMPAT, 'UTF-8');
    
    $out =<<<EOT
      <div class="span-6 showmore-6"></div>

	  <!--STORY ITEM-->
      <div class="span-6 block-006">
				<div class="span-6 block-040">
					<div class="icon">
						<a href="#" class="closed">icon</a>
					</div>
					<h4 class="entity-list">
						{$sf['description']}
					</h4>
				</div>
				<!--block-040-->
				<div class="clearfix offset-text">&nbsp;</div>
				<div class="spacer">&nbsp;</div>
				<div class="story-clip">
					<p>{$sf['Fact']['description']}</p>  

        	<dl class="sources clearfix">
            <dt>sources - </dt>
EOT;
    foreach($sf['Fact']['Sources'] as $s) {
      $out .= '<dd><a href="'.$s['url'].'">'.$s['title'].'</a></dd>'.PHP_EOL;
    }

    $out .=<<<EOT
						</dl>
					</div>
				</div><!--block-006-->

      <div class="span-6 showless-6"></div>
EOT;
    return $out;
  }
  
  
	
	
	
												
																
																
															
	
	
	
	
	
  public function renderAnd()
  {
    $out =<<<EOT
          <div class="span-6 block-048"><h4>and</h4></div>
EOT;
    return $out;
  }
  
  public function renderSeparator()
  {
    return '<div class="span-6 showbar-6"></div>';
  }
  
}
