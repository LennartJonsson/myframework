<?php
/**
* Site configuration, this file is changed by user per site.
*
*/

/*
* Set level of error reporting
*/
error_reporting(-1);
ini_set('display_errors', 1);

/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$mfw->config['debug']['display-framework'] = false;
$mfw->config['debug']['session'] = false;
$mfw->config['debug']['timer'] = true;
$mfw->config['debug']['db-num-queries'] = false;
$mfw->config['debug']['db-queries'] = false;

/**
 * Set database(s).
 */
$mfw->config['database'][0]['dsn'] = 'sqlite:' . MFW_SITE_PATH . '/data/.ht.sqlite';

/**
* What type of urls should be used?
*
* default      = 0      => index.php/controller/method/arg1/arg2/arg3
* clean        = 1      => controller/method/arg1/arg2/arg3
* querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
*/
$mfw->config['url_type'] = 1;

/**
* Set a base_url to use another than the default calculated
*/
$mfw->config['base_url'] = null;

/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$mfw->config['hashing_algorithm'] = 'sha1salt';

/**
 * Allow or disallow creation of new user accounts.
 */
$mfw->config['create_new_users'] = true;

/*
* Define session name
*/
$mfw->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$mfw->config['session_key']  = 'mfw';

/*
* Define server timezone
*/
$mfw->config['timezone'] = 'Europe/Stockholm';

/*
* Define internal character encoding
*/
$mfw->config['character_encoding'] = 'UTF-8';

/*
* Define language
*/
$mfw->config['language'] = 'en';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example:
* the url 'developer/dump' would instantiate the controller with the key "developer", that is
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $mfw->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$mfw->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'theme'     => array('enabled' => true,'class' => 'CCTheme'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'content'   => array('enabled' => true,'class' => 'CCContent'),
  'blog'      => array('enabled' => true,'class' => 'CCBlog'),
  'page'      => array('enabled' => true,'class' => 'CCPage'),
  'user'      => array('enabled' => true,'class' => 'CCUser'),
  'acp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'module'    => array('enabled' => true,'class' => 'CCModules'),
  'my'        => array('enabled' => true,'class' => 'CCMycontroller'),
  'setting'   => array('enabled' => true,'class' => 'CCSetting'),
  );

/**
* Define a routing table for urls.
*
* Route custom urls to a defined controller/method/arguments
*/
$mfw->config['routing'] = array(
  'home' => array('enabled' => true, 'url' => 'index/index'),
);

if ( datadirectorywritable() && settingsconfigurationfileexist() )
  require(settingsconfigurationfile());
else
{
  $FaviconLogo = "";
  $FooterText = "";
  $MenuTitleAbout = 'Tjosan!';
  $MenuTitleBlog = 'Jokkmokks';
  $MenuTitleGuestbook = 'Jokke';
}

/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $mfw->config['theme'].
 */
$mfw->config['menus'] = array(
  'navbar' => array(
    'home'      => array('label'=>'Home', 'url'=>'home'),
    'modules'   => array('label'=>'Modules', 'url'=>'module'),
    'content'   => array('label'=>'Content', 'url'=>'content'),
    'guestbook' => array('label'=>'Guestbook', 'url'=>'guestbook'),
    'blog'      => array('label'=>'Blog', 'url'=>'blog'),
    'setting'   => array('label'=>'Setting', 'url'=>'setting'),
  ),
  'my-navbar' => array(
    'home'      => array('label'=>$MenuTitleAbout, 'url'=>'my'),
    'blog'      => array('label'=>$MenuTitleBlog, 'url'=>'my/blog'),
    'guestbook' => array('label'=>$MenuTitleGuestbook, 'url'=>'my/guestbook'),
    'setting'   => array('label'=>'Settings', 'url'=>'my/setting'),
  ),
);

/**
 * Settings for the theme. The theme may have a parent theme.
 *
 * When a parent theme is used the parent's functions.php will be included before the current
 * theme's functions.php. The parent stylesheet can be included in the current stylesheet
 * by an @import clause. See site/themes/mytheme for an example of a child/parent theme.
 * Template files can reside in the parent or current theme, the CMyFrameWork::ThemeEngineRender()
 * looks for the template-file in the current theme first, then it looks in the parent theme.
 *
 * There are two useful theme helpers defined in themes/functions.php.
 *  theme_url($url): Prepends the current theme url to $url to make an absolute url. 
 *  theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url. 
 *
 * path: Path to current theme, relativly MFW_INSTALL_PATH, for example themes/grid or site/themes/mytheme.
 * parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
 * stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
 * template_file: Set the default template file, defaults to default.tpl.php.
 * regions: Array with all regions that the theme supports.
 * menu_to_region: Array mapping menus to regions.
 * data: Array with data that is made available to the template file as variables. 
 * 
 * The name of the stylesheet is also appended to the data-array, as 'stylesheet' and made 
 * available to the template files.
 */
$mfw->config['theme'] = array(
  'path'            => 'site/themes/mytheme',
  'parent'          => 'themes/grid',
  'stylesheet'      => 'style.php',
  'template_file'   => 'index.tpl.php',
  'regions' => array('navbar', 'flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','triptych-first','triptych-middle','triptych-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
  'menu_to_region' => array('my-navbar'=>'navbar'),
  'data' => array(
    'header' => 'MyFrameWork',
    'slogan' => 'A PHP-based MVC-inspired CMF',
    'favicon' => $FaviconLogo,
    'logo' => $FaviconLogo,
    'logo_width'  => FaviconLogoWidth,
    'logo_height' => FaviconLogoHeight,
    'footer' => '<p>' . $FooterText . '</p>',
  ),
);
