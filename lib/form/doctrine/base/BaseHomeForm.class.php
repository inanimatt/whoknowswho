<?php

/**
 * Home form base class.
 *
 * @method Home getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseHomeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'is_active'             => new sfWidgetFormInputCheckbox(),
      'feature_html'          => new sfWidgetFormTextarea(),
      'feature_copy_intro'    => new sfWidgetFormTextarea(),
      'feature_copy_extended' => new sfWidgetFormTextarea(),
      'callout_html'          => new sfWidgetFormTextarea(),
      'story1_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story1'), 'add_empty' => true)),
      'story1_image_url'      => new sfWidgetFormInputText(),
      'story2_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story2'), 'add_empty' => true)),
      'story2_image_url'      => new sfWidgetFormInputText(),
      'story3_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story3'), 'add_empty' => true)),
      'story3_image_url'      => new sfWidgetFormInputText(),
      'story4_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story4'), 'add_empty' => true)),
      'story4_image_url'      => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'is_active'             => new sfValidatorBoolean(array('required' => false)),
      'feature_html'          => new sfValidatorString(array('max_length' => 10240, 'required' => false)),
      'feature_copy_intro'    => new sfValidatorString(array('max_length' => 10240, 'required' => false)),
      'feature_copy_extended' => new sfValidatorString(array('max_length' => 10240, 'required' => false)),
      'callout_html'          => new sfValidatorString(array('max_length' => 10240, 'required' => false)),
      'story1_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story1'), 'required' => false)),
      'story1_image_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'story2_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story2'), 'required' => false)),
      'story2_image_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'story3_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story3'), 'required' => false)),
      'story3_image_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'story4_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story4'), 'required' => false)),
      'story4_image_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('home[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Home';
  }

}
