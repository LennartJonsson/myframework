<?php
/**
* A blog controller to display a blog-like list of all content labelled as "post".
*
* @package MyFrameWorkCore
*/
class CCBlog extends CObject implements IController
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Display all content of the type "post".
   */
  public function Index()
  {
    $content = new CMContent();
    $this->views->SetTitle('Blog');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
		  'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'title', 'order-order'=>'DESC')),
		));
  }

  /**
   * Edit a selected content, or prepare to create new content if argument is missing.
   *
   * @param id integer the id of the content.
   */
  public function Edit($id=null)
  {
    $content = new CCContent();
    $content->Edit($id,'blog','post','plain');
  }

  /**
   * Create new content.
   */
  public function Create()
  {
    $content = new CCContent();
    $content->Edit(null,'blog','post','plain');
  }

  /**
   * View a selected content.
   *
   * @param id integer the id of the content.
   */
  public function View($id)
  {
    $page = new CCPage();
    $page->View($id,'blog');
  }
}

