<?php

class defaultActions extends sfActions
{ 
  public function executeIndex(sfWebRequest $request)
  {

    // Get most-viewed entities
    $this->most_viewed = Doctrine::getTable('Entity')->retrieveMostViewed(10);

    // Get the active homepage object
    $this->content = Doctrine_Query::create()
                        ->select('h.*, s1.*, s2.*, s3.*, s4.*, s1r.*, s2r.*, s3r.*, s4r.*')
                        ->from('Home h, h.Story1 s1, h.Story2 s2, h.Story3 s3, h.Story4 s4, s1.Rating s1r, s2.Rating s2r, s3.Rating s3r, s4.Rating s4r')
                        ->where('h.is_active = ?', 1)
                        ->orderBy('h.updated_at DESC, h.is_active DESC')
                        ->fetchOne();
    if (!$this->content)
    {
      $this->content = new Home;
    }

  }

  public function executePreview(sfWebRequest $request)
  {
    // Get most-viewed entities
    $this->most_viewed = Doctrine::getTable('Entity')->retrieveMostViewed(10);

    // Get the active homepage object
    $this->content = Doctrine_Query::create()
                        ->select('h.*, s1.*, s2.*, s3.*, s4.*, s1r.*, s2r.*, s3r.*, s4r.*')
                        ->from('Home h, h.Story1 s1, h.Story2 s2, h.Story3 s3, h.Story4 s4, s1.Rating s1r, s2.Rating s2r, s3.Rating s3r, s4.Rating s4r')
                        ->where('h.id = ?', $this->getRequestParameter('id'))
                        ->fetchOne();
    $this->setTemplate('index');
  }
  
  public function executeContact(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple sites
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'General enquiry'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }
  
  public function executeSuggest(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple sites
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'Suggestion story'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }
  
  public function executeSuggestConnection(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple sites
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'Suggest connection'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }
  
  public function executeSuggestFact(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple sites
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'Suggest fact'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }
  
  public function executeReport(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple sites
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'Error report'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }

  public function executeReportComment(sfWebRequest $request)
  {
    $this->form = new ContactMessagesForm();
    
    //form type is used so we can use the same form for multiple contact types
    $this->form->setWidget('message_type', new sfWidgetFormInputHidden());
    $this->form->setDefaults(array(
      'message_type' => 'Comment report'
    ));
        
    $this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
    $this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    
    if ($request->isMethod('post')) {
      $this->processForm($request, $this->form);
    }
  }
    
  public function executeThankyou(sfWebRequest $request)
  {

  }

  public function executeAbout(sfWebRequest $request)
  {

  }

  public function executeRules(sfWebRequest $request)
  {

  }

  public function executeTerms(sfWebRequest $request)
  {

  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $captcha = array(
      'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
      'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
    );

    $form->bind(array_merge($request->getParameter($form->getName()), array('captcha' => $captcha)));
 
    if ($form->isValid())
    {
      $form->save();
      
      $this->redirect('@thankyou');
    }
  }  
}
