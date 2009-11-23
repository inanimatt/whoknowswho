<?php

class Tui_Doctrine_Search_Analyzer_Stemming extends Doctrine_Search_Analyzer_Utf8
{
  
  public function analyze($text)
  {
    
    // First run the UTF-8 analyzer. This will do a lot of tidying on 
    // the text and remove stopwords, so we only need to do the stemming
    $text = parent::analyze($text);
    
    foreach ($text as &$keyword) {
      $keyword = stem_english($keyword);
    }
    
    return $text;
  }
}