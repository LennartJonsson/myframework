<?php
/**
 * A form to login the user profile.
 * 
 * @package MyFrameWorkCore
 */
class CFormUserLogin extends CForm
{

  /**
   * Constructor
   */
  public function __construct($object)
  {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym'));
    $this->AddElement(new CFormElementPassword('password'));
    $this->AddElement(new CFormElementSubmit('login', array('callback'=>array($object, 'DoLogin'))));

    $this->SetValidation('acronym', array('not_empty'));
    $this->SetValidation('password', array('not_empty'));
  }
}
