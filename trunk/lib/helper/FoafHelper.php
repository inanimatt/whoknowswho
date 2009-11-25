<?php

function foaf_image($source, $absolute = false)
{
  return _compute_public_path($source, 'images', 'png', $absolute);
}


function rating_stars($rating)
{
  $rating = round($rating);

  $on  = $rating;
  $off = 5-$rating;

  $out = '';
  while($on) {
    $out .= '<li class="star-on"><a href="#" class="offset-text">'.$on--.'</a></li>'.PHP_EOL;
  }
  
  while($off) {
    $out .= '<li class="star-off"><a href="#" class="offset-text">'.$off--.'</a></li>'.PHP_EOL;
            
  }
  
  return $out;
}

function rating_word($rating)
{
  $rating = round($rating);
  switch($rating) 
  {
    case 0: return 'Unrated';
    case 1: return 'So what?';
    case 2: return 'Obvious';
    case 3: return 'Interesting';
    case 4: return 'Surprising';
    case 5: return 'Wow';
  }


}


function foaf_story_filter($text, $version)
{
  // Cache hit?
  if ($cache = tuiCacheHandler::getInstance()->get($version)) { return $cache; }
  
  // Miss - refilter.
  $ref_obj = new tuiStoryReferenceFilter;

  $text = preg_replace_callback('/\[[rR][eE][fF]([^\]]+)\]/', array($ref_obj,'lookup'), $text);

  if ($refs = $ref_obj->getReflist()) {
    $text .= '<div class="divider">Dotted divider</div><div class="story-refblock">';
    $text .= '<p><strong>References</strong></p>';
    $text .= $refs;
    $text .= '</div>';
  }
  
  // Update the cache
  tuiCacheHandler::getInstance()->set($version, $text);

  return $text;
}


class tuiStoryReferenceFilter
{
  protected $refs = array();
  protected $refnum = 1;
  
  public function lookup($match)
  {
    if (!isset($this->refs[$match[1]]))
    {
      $this->refs[$match[1]] = $this->refnum++;
    }
    
    return '<span class="story-ref">[<a href="#ref-'.$this->refs[$match[1]].'">'.$this->refs[$match[1]].'</a>]</span>';
  }
  
  public function getReflist()
  {
    if (!count($this->refs)) return '';
    
    $out = '<ol class="story-reflist">'.PHP_EOL;
    foreach($this->refs as $url => $num) 
    {
      $out .= '<li id="ref-'.$num.'"><a href="'.$url.'">'.$this->shortenUrl($url).'</a></li>';
    }
    $out .= '</ol>'.PHP_EOL;
    
    
    $out = tuiHTMLFilter::clean($out);
    return $out;
  }
  
  public function shortenUrl($url) {
    $slash = strpos($url, '/', 9);
    if (false !== $slash) 
    {
      $url = substr($url, 0, $slash+1).'<span class="story-ref-path">'.substr($url,$slash+1,30).'…</span>';
    }

    return $url;
  }
}


function entityCache($id) {
  static $cache = array();
  if (!isset($cache[$id])) {
    $cache[$id] = Doctrine::getTable('Entity')->retrieveCached($id);
  }
  return $cache[$id];
}


function shortenTitle($title) {
  if (strlen($title) > 45)
  {
    // Truncate
    $title = substr($title, 0, 45);
    // Tidy up
    $title = substr($title, 0, strrpos($title, ' ')).'…';
  }

  return $title;
}
