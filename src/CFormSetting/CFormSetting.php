<?php
/**
* A form to manage setting.
*
* @package MyFrameWorkCore
*/
class CFormSetting extends CForm
{

  /**
   * Properties
   */
  private $setting;

  /**
   * Constructor
   */
  public function __construct($setting)
  {
    parent::__construct();
    $this->setting = $setting;
    $this->AddElement(new CFormElementText('key', array('readonly'=>true, 'value'=>$setting['key'])));
    if ( $setting['type'] == 'menu' )
      $this->AddElement(new CFormElementText('value', array('value'=>$setting['value'])));
    else
    if ( $setting['type'] == 'color' )
      $this->AddElement(new CFormElementOption($setting['type'], array('value'=>$setting['value'])));
    else
    if ( $setting['type'] == 'image' )
      $this->AddElement(new CFormElementOption($setting['type'], array('value'=>$setting['value'])));
    else
    if ( in_array( $setting['type'], array('bodyfont','headerfont') ) )
      $this->AddElement(new CFormElementOption($setting['type'], array('value'=>$setting['value'])));
    else
    if ( $setting['type'] == 'numeric' )
    {
      $this->AddElement(new CFormElementText('value', array('value'=>$setting['value'])));
      $this->SetValidation('value', array('not_empty','numeric'));
    }
    else
    {
      $this->AddElement(new CFormElementText('value', array('value'=>$setting['value'])));
      $this->SetValidation('value', array('not_empty'));
    }
    $this->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($setting))));
  }

  /**
   * Callback to save the form setting to database.
   */
  public function DoSave($form, $setting)
  {
    if ( in_array( $setting['type'], array('color','image','bodyfont','headerfont') ) )
      $value = $_POST['optionvalue'];
    else
      $value = $form['value']['value'];
    $setting['key']   = $form['key']['value'];
    $setting['value'] = $value;
    return $setting->Save();
  }
}
