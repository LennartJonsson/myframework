<?php
/**
 * All requests routed through here. This is an overview of what actually happens during
 * a request.
 *
 * @package MyFrameWorkCore
 */

//
// Phase: Bootstrap
//
define('MFW_INSTALL_PATH', dirname(__FILE__));
define('MFW_SITE_PATH', MFW_INSTALL_PATH . '/site');
define('MFW_URL_PATH',rtrim($_SERVER['REQUEST_URI'], "/"));
define('FaviconLogoWidth', 80);
define('FaviconLogoHeight', 80);

require(MFW_INSTALL_PATH.'/src/bootstrap.php');

$mfw = CMyFrameWork::Instance();

if ( datadirectorywritable() && ( settingsconfigurationfileexist() == false ) )
{
  $setting = new CMSetting();
  $setting->Manage('install');
  $setting->WriteSettingConfigFile();
}

//
// Phase: Frontcontroller route
//
$mfw->FrontControllerRoute();

//
// Phase: Theme engine render
//
$mfw->ThemeEngineRender();

