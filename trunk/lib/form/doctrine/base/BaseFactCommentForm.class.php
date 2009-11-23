<?php

/**
 * FactComment form base class.
 *
 * @method FactComment getObject() Returns the current form's model object
 *
 * @package    c4foaf
 * @subpackage form
 * @author     Tui Interactive Media
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseFactCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'fact_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fact'), 'add_empty' => false)),
      'fact_score'    => new sfWidgetFormInputText(),
      'comment_score' => new sfWidgetFormInputText(),
      'created_by'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => false)),
      'comment'       => new sfWidgetFormTextarea(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'fact_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Fact'))),
      'fact_score'    => new sfValidatorInteger(array('required' => false)),
      'comment_score' => new sfValidatorInteger(array('required' => false)),
      'created_by'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'))),
      'comment'       => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('fact_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FactComment';
  }

}
