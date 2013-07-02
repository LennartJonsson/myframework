<?php
/**
* Standard controller layout.
*
* @package MyFrameWorkCore
*/
class CCIndex extends CObject implements IController
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Implementing interface IController. All controllers must have an index action.
   */
  public function Index()
  {
    $StartPageTitle = startpagetitle();
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $this->views->SetTitle($StartPageTitle);
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary');
//    $this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array('controllers'=>$controllers), 'sidebar');
  }
}
