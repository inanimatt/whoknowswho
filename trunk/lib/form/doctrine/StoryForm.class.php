<?php

/**
 * Story form.
 *
 * @package    form
 * @subpackage Story
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class StoryForm extends BaseStoryForm
{
  public function configure()
  {
    $this->widgetSchema['is_public'] = new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(0 => 'No', 1 => 'Yes') ));
    
    unset($this->widgetSchema['facts_list']);
    unset($this->widgetSchema['related_stories_list']);
    unset($this->widgetSchema['story_list']);
    
    unset($this->validatorSchema['facts_list']);
    unset($this->validatorSchema['related_stories_list']);
    unset($this->validatorSchema['story_list']);
    
    
    $o =$this->getObject();
    $sr = $o['Rating'];

    $ratingForm = new StoryRatingForm($sr);
    unset($ratingForm['story_id']);
        
    $this->embedForm('StoryRating', $ratingForm);
    
    
    $this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCE(array(
      'width'  => 650,
      'height' => 450,
      'config' => 'theme_advanced_disable: "image,cleanup,help"',
    ));
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
  }
}