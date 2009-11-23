<?php

class tuiDoctrineSearchListener extends Doctrine_EventListener
{
  
  public function postConnect(Doctrine_Event $e)
  {
    if (function_exists('stem_english')) {
      $entity_table = Doctrine_Core::getTable('Entity');
      $entity_table->getTemplate('Doctrine_Template_Searchable')
                   ->getPlugin()
                   ->setOption('analyzer', new Tui_Doctrine_Search_Analyzer_Stemming);
    
      $story_table = Doctrine_Core::getTable('Story');
      $story_table->getTemplate('Doctrine_Template_Searchable')
                  ->getPlugin()
                  ->setOption('analyzer', new Tui_Doctrine_Search_Analyzer_Stemming);
    
      $alias_table = Doctrine_Core::getTable('EntityAlias');
      $alias_table->getTemplate('Doctrine_Template_Searchable')
                  ->getPlugin()
                  ->setOption('analyzer', new Tui_Doctrine_Search_Analyzer_Stemming);
    }
  }
}