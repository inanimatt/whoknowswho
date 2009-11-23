<?php

/**
 * EntityUrl form.
 *
 * @package    form
 * @subpackage EntityUrl
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class EntityUrlForm extends BaseEntityUrlForm
{
  public function configure()
  {
    $this->widgetSchema['entity_id']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['entity_id']->setOption('renderer_options', array('model' => 'Entity', 'url' => $this->getOption('url'), ));
 
    $this->widgetSchema['created_by']->setOption('renderer_class', 'sfWidgetFormDoctrineJQueryAutocompleter');
    $this->widgetSchema['created_by']->setOption('renderer_options', array('model' => 'sfGuardUser', 'url' => $this->getOption('sfguardurl'), ));
    
    // $this->widgetSchema->setHelp('urltype','');
    $this->widgetSchema['urltype'] = new sfWidgetFormChoice(array('expanded' => false, 'choices' => 
        array('wikipedia' => 'Wikipedia', 
              'theyworkforyou' => 'TheyWorkForYou (foreign id is person-id)', 
              'bbc_profile' => 'BBC MP Profile', 
              'guardian_mp_summary' => 'Guardian MP summary', 
              'personal' => 'Personal web-site', 
              'news_article_primary' => 'News article (directly about the Entity)', 
              'news_article_secondary' => 'News article (indirectly about the Entity, or features the Entity)',
              'other' => 'Other', 
              
             ) 
        )
      );
    
    // Disable validation on the update dates, since they're fiddled by the model
    unset($this->widgetSchema['created_at']);
    unset($this->widgetSchema['updated_at']);
    unset($this->validatorSchema['created_at']);
    unset($this->validatorSchema['updated_at']);
    
    
    $o =$this->getObject();
    $fs = $o['Verifications'][0];
    $fs['Creator'] = sfContext::getInstance()->getUser()->getGuardUser();
    
    $sourceForm = new EntityUrlVerifiedForm($fs, array('sfguardurl' => $this->getOption('sfguardurl')));
    unset($sourceForm['entity_url_id']);
    unset($sourceForm['created_at']);
    unset($sourceForm['updated_at']);
        
    $this->embedForm('EntityUrlVerified', $sourceForm);
    
    
  }
}