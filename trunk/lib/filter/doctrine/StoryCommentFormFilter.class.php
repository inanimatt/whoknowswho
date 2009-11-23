<?php

/**
 * StoryComment filter form.
 *
 * @package    filters
 * @subpackage StoryComment *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class StoryCommentFormFilter extends BaseStoryCommentFormFilter
{
  public function configure()
  {
    
    $this->widgetSchema['story_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['story_id']->setOption('renderer_options', array('model' => 'Story', 'url' => 'story/ajax' ));
    
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => 'sfGuardAuth/ajax' ));
        
  }
}