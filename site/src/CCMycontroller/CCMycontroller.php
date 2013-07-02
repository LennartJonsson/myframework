<?php
/**
 * Sample controller for a site builder.
 */
class CCMycontroller extends CObject implements IController
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * The page about me
   */
  public function Index()
  {
    $content = new CMContent(5);
    $this->views->SetTitle('About me');
    $this->views->AddInclude(__DIR__ . '/page.tpl.php', array(
		  'content' => $content,
		));
  }

  /**
   * The blog.
   */
  public function Blog()
  {
    $content = new CMContent();
    $this->views->SetTitle('Blog');
    $this->views->AddInclude(__DIR__ . '/blog.tpl.php', array(
		  'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
		));
  }

  /**
   * The guestbook.
   */
  public function Guestbook()
  {
    $guestbook = new CMGuestbook();
    $form = new CFormMyGuestbook($guestbook);
    $status = $form->Check();
    if($status === false)
    {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToControllerMethod();
    }
    else if($status === true)
    {
      $this->RedirectToControllerMethod();
    }
   
    $this->views->SetTitle('Guestbook');
    $this->views->AddInclude(__DIR__ . '/guestbook.tpl.php', array(
	    'entries'=>$guestbook->ReadAll(),
	    'form'=>$form,
	 ));
  }

  /**
   * Settings.
   */
  public function Setting()
  {
    $setting = new CMSetting();
    $this->views->SetTitle('Settings');
    $this->views->AddInclude(__DIR__ . '/setting.tpl.php', array(
		  'settings' => $setting->ListAll(),
		));
  }
}

/**
* Form for the guestbook
*/
class CFormMyGuestbook extends CForm
{

  /**
   * Properties
   */
  private $object;

  /**
   * Constructor
   */
  public function __construct($object)
  {
    parent::__construct();
    $this->object = $object;
    $this->AddElement(new CFormElementTextarea('data', array('label'=>'Add entry:')));
    $this->AddElement(new CFormElementSubmit('add', array('callback'=>array($this, 'DoAdd'), 'callback-args'=>array($object))));
  }

  /**
   * Callback to add the form content to database.
   */
  public function DoAdd($form, $object)
  {
    return $object->Add(strip_tags($form['data']['value']));
  }
}
