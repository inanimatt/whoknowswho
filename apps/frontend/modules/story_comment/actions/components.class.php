<?php

class story_commentComponents extends sfComponents
{
	public function executeComments(sfWebRequest $request)
	{
		$this->form = new StoryCommentForm();

		$this->form->setWidget('story_id', new sfWidgetFormInputHidden());
		$this->form->setWidget('confirmation_token', new sfWidgetFormInputHidden());
		$this->form->setWidget('story_version', new sfWidgetFormInputHidden());
		$this->form->setDefaults(array(
					'story_id' => $this->story_id,
					'story_version' => $this->story_version,
		));
		
		$this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
        $this->form->setWidget('terms', new sfWidgetFormInputCheckbox(array('value_attribute_value' => 'checked')));
		
		
		$this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
    	$this->form->setValidator('terms', new sfValidatorChoice(array('choices' => array('checked'))));
		
		unset(
			$this->form['created_by'],
			$this->form['email_confirmed'],
			$this->form['comment_approved']
		);

		if ($request->isMethod('post')) {
				
			$captcha = array(
      			'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
      			'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
			);

			$this->form->bind(array_merge($request->getParameter($this->form->getName()), array('captcha' => $captcha)));
		
			if ($this->form->isValid())
			{  
			    $this->form->save();

			    $token = sprintf('%08X', crc32('+{}"?|{?FR}"'.microtime()));
			    $sc = $this->form->getObject();
			    $sc->setConfirmationToken($token);
			    $sc->save();

			    $confirm_url = url_for('@story_comment_confirm', true).'?token='.$token;
			    
                // send an email
                $message = $this->getMailer()->composeAndSend(
                array(sfConfig::get('app_email_from_address') => sfConfig::get('app_email_from_name')),
                $this->form->getValue('email'),
        		'Confirm email address for comment',
        		<<<EOF

Please confirm your email address by clicking on the link below.

{$confirm_url}

Who Knows Who.
EOF
      );
      
				$this->getUser()->setFlash('comment_submitted', 'Thank you, your comment has been submitted and is now awaiting assessment from our moderators.');

			
				
				//Need to create a new form again since we can't redirect from a component
				//and this will reset the form
				unset($this->form);
				
				$this->form = new StoryCommentForm();

				$this->form->setWidget('story_id', new sfWidgetFormInputHidden());
				$this->form->setWidget('story_version', new sfWidgetFormInputHidden());
				$this->form->setDefaults(array(
					'story_id' => $this->story_id,
					'story_version' => $this->story_version,
				));

	        	$this->form->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
                $this->form->setWidget('terms', new sfWidgetFormInputCheckbox(array('value_attribute_value' => 'checked')));
		
		
        		$this->form->setValidator('captcha', new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key'))));
            	$this->form->setValidator('terms', new sfValidatorChoice(array('choices' => array('checked'))));
    		
				unset(
					$this->form['created_by'],
					$this->form['confirmation_token'],
					$this->form['email_confirmed'],
					$this->form['comment_approved']
				);
			}
		}

		$c = Doctrine_Query::create()
		->from('StoryComment sc')
		->select("count(sc.id) as num")
		->where('sc.story_id = ?', $this->story_id)
		->andWhere('sc.comment_approved = ?', 1)
		->fetchOne(null, Doctrine::HYDRATE_ARRAY);

		$this->total_comments = $c['num'];

		$this->story_comments = Doctrine::getTable('StoryComment')
		->createQuery('sc')
		->where('sc.story_id = ?', $this->story_id)
		->andWhere('sc.comment_approved = ?', 1)
		->orderBy('id')
		->limit('5')
		->execute(null, Doctrine::HYDRATE_ARRAY);
	}
}