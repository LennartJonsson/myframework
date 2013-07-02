<?php
/**
* A form to manage content.
*
* @package MyFrameWorkCore
*/
class CFormContent extends CForm
{

  /**
   * Properties
   */
  private $content;

  /**
   * Constructor
   */
  public function __construct($content)
  {
    parent::__construct();
    $this->content = $content;
    $idset = isset($content['id']);
    $about_me = false;
    if ( $idset )
      $about_me = ( ( $content['key'] == 'about' ) && ( $content['type'] == 'page' ) );
    $save = $idset ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])));
    $this->AddElement(new CFormElementText('title', array('value'=>$content['title'])));
    $this->AddElement(new CFormElementText('key', array('value'=>$content['key'])));
    $this->AddElement(new CFormElementTextarea('data', array('label'=>'Content:', 'value'=>$content['data'])));
    $this->AddElement(new CFormElementText('type', array('readonly'=>true, 'value'=>$content['type'])));
    $this->AddElement(new CFormElementText('filter', array('readonly'=>true, 'value'=>$content['filter'])));
    $this->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content))));
    if ( $idset && ! $about_me )
      $this->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($content))));

    $this->SetValidation('title', array('not_empty'));
    $this->SetValidation('key', array('not_empty'));
  }
 

  /**
   * Callback to save the form content to database.
   */
  public function DoSave($form, $content)
  {
    $content['id']    = $form['id']['value'];
    $content['title'] = $form['title']['value'];
    $content['key']   = $form['key']['value'];
    $content['data']  = $form['data']['value'];
    $content['type']  = $form['type']['value'];
    $content['filter'] = $form['filter']['value'];
    return $content->Save();
  }
  
  /**
   * Callback to delete the content.
   */
  public function DoDelete($form, $content)
  {
    $content['id'] = $form['id']['value'];
    $blog = ( $content['type'] == 'post' );
    $content->Delete();
    if ( $blog )
      CMyFrameWork::Instance()->RedirectTo('my/blog');
    else
      CMyFrameWork::Instance()->RedirectTo('content');
  }
}
