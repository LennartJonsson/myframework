<?php
/**
* A user controller to manage settings.
*
* @package MyFrameWorkCore
*/
class CCSetting extends CObject implements IController
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Show a listing of all setting.
   */
  public function Index()
  {
    $setting = new CMSetting();
    $this->views->SetTitle('Settings Controller');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
		  'settings' => $setting->ListAll(),
		));
  }

  /**
   * Edit a selected setting.
   *
   * @param key string the key of the setting.
   */
  public function Edit($key=null)
  {
    if ( $key === null )
    {
      $this->RedirectToController();
    }
    $setting = new CMSetting($key);
    $form = new CFormSetting($setting);
    $status = $form->Check();
    if($status === false)
    {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('edit', $key);
    }
    else
    if($status === true)
    {
      $this->RedirectToController('edit', $setting['key']);
    }

    $this->views->SetTitle("Edit setting: ".htmlEnt($setting['key']));
    $this->views->AddInclude(__DIR__ . '/edit.tpl.php', array(
		  'user'=>$this->user,
		  'setting'=>$setting,
		  'form'=>$form,
		));
  }

  /**
   * Init the settings database.
   */
  public function Init()
  {
    $setting = new CMSetting();
    $setting->Manage('install');
    $this->RedirectToController();
  }
}
