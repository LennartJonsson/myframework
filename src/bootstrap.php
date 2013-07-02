<?php
/**
 * Bootstrapping, setting up and loading the core.
 *
 * @package MyFrameWorkCore
 */

/**
 * Enable auto-load of class declarations.
 */
function autoload($aClassName)
{
  $classFile = "/src/{$aClassName}/{$aClassName}.php";
  $file1 = MFW_SITE_PATH . $classFile;
  $file2 = MFW_INSTALL_PATH . $classFile;
  if(is_file($file1))
  {
    require_once($file1);
  }
  elseif(is_file($file2))
  {
    require_once($file2);
  }
}
spl_autoload_register('autoload');

/**
 * Set a default exception handler and enable logging in it.
 */
function exceptionHandler($e)
{
  echo "MyFrameWork: Uncaught exception: <p>" . $e->getMessage() . "</p><pre>" . $e->getTraceAsString(), "</pre>";
}
set_exception_handler('exceptionHandler');

/**
 * Helper, include a file and store it in a string. Make $vars available to the included file.
 */
function getIncludeContents($filename, $vars=array())
{
  if (is_file($filename))
  {
    ob_start();
    extract($vars);
    include $filename;
    return ob_get_clean();
  }
  return false;
}

/**
 * Helper, wrap html_entites with correct character encoding
 */
function htmlent( $str, $flags = ENT_COMPAT )
{
  return htmlentities($str, $flags, CMyFrameWork::Instance()->CharacterEncoding());
}

/**
 * Helper, convert all HTML entities to their applicable characters
 */
function htmldec( $str, $flags = ENT_COMPAT )
{
  return html_entity_decode($str, $flags, CMyFrameWork::Instance()->CharacterEncoding());
}

/**
 * Helper, write setting config file
 */
function writesettingconfigfile()
{
  // Create contents
    $setting = new CMSetting();
    $setting->WriteSettingConfigFile();
}

/**
 * Helper, interval formatting of times. Needs PHP5.3. 
 *
 * All times in database is UTC so this function assumes the starttime to be in UTC, if not otherwise
 * stated.
 *
 * Copied from http://php.net/manual/en/dateinterval.format.php#96768
 * Modified (mos) to use timezones.
 * A sweet interval formatting, will use the two biggest interval parts.
 * On small intervals, you get minutes and seconds.
 * On big intervals, you get months and days.
 * Only the two biggest parts are used.
 *
 * @param DateTime|string $start
 * @param DateTimeZone|string|null $startTimeZone
 * @param DateTime|string|null $end
 * @param DateTimeZone|string|null $endTimeZone
 * @return string
 */
function formatDateTimeDiff($start, $startTimeZone=null, $end=null, $endTimeZone=null)
{
  if(!($start instanceof DateTime))
  {
    if($startTimeZone instanceof DateTimeZone)
    {
      $start = new DateTime($start, $startTimeZone);
    }
    else if(is_null($startTimeZone))
    {
      $start = new DateTime($start);
    }
    else
    {
      $start = new DateTime($start, new DateTimeZone($startTimeZone));
    }
  }
  
  if($end === null)
  {
    $end = new DateTime();
  }
  
  if(!($end instanceof DateTime))
  {
    if($endTimeZone instanceof DateTimeZone)
    {
      $end = new DateTime($end, $endTimeZone);
    }
    else if(is_null($endTimeZone))
    {
      $end = new DateTime($end);
    }
    else
    {
      $end = new DateTime($end, new DateTimeZone($endTimeZone));
    }
  }
  
  $interval = $end->diff($start);
  $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
  //$doPlural = create_function('$nb,$str', 'return $nb>1?$str."s":$str;'); // adds plurals
  
  $format = array();
  if($interval->y !== 0)
  {
    $format[] = "%y ".$doPlural($interval->y, "year");
  }
  if($interval->m !== 0)
  {
    $format[] = "%m ".$doPlural($interval->m, "month");
  }
  if($interval->d !== 0)
  {
    $format[] = "%d ".$doPlural($interval->d, "day");
  }
  if($interval->h !== 0)
  {
    $format[] = "%h ".$doPlural($interval->h, "hour");
  }
  if($interval->i !== 0)
  {
    $format[] = "%i ".$doPlural($interval->i, "minute");
  }
  if(!count($format))
  {
      return "less than a minute";
  }
  if($interval->s !== 0)
  {
    $format[] = "%s ".$doPlural($interval->s, "second");
  }
  
  if($interval->s !== 0)
  {
    if(!count($format))
    {
      return "less than a minute";
    }
    else
    {
      $format[] = "%s ".$doPlural($interval->s, "second");
    }
  }

  // We use the two biggest parts
  if(count($format) > 1)
  {
    $format = array_shift($format)." and ".array_shift($format);
  }
  else
  {
    $format = array_pop($format);
  }

  // Prepend 'since ' or whatever you like
  return $interval->format($format);
}

/**
 * Helper, make clickable links from URLs in text.
 */
function makeClickable($text)
{
  return preg_replace_callback(
    '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', 
    create_function(
      '$matches',
      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
    ),
    $text
  );
}

/**
 * Helper, BBCode formatting converting to HTML.
 *
 * @param string text The text to be converted.
 *
 * @returns string the formatted text.
 */
function bbcode2html($text)
{
  $search = array( 
    '/\[b\](.*?)\[\/b\]/is', 
    '/\[i\](.*?)\[\/i\]/is', 
    '/\[u\](.*?)\[\/u\]/is', 
    '/\[img\](https?.*?)\[\/img\]/is', 
    '/\[url\](https?.*?)\[\/url\]/is', 
    '/\[url=(https?.*?)\](.*?)\[\/url\]/is' 
    );   
  $replace = array( 
    '<strong>$1</strong>', 
    '<em>$1</em>', 
    '<u>$1</u>', 
    '<img src="$1" />', 
    '<a href="$1">$1</a>', 
    '<a href="$1">$2</a>' 
    );     
  return preg_replace($search, $replace, $text);
}

/**
 * Helper, draws a colored table cell. displays an image of the setting value
 *
 * @param string value The setting value.
 * @param string type The type: 'color','image','text'.
 *
 * @returns string The html code for the corresponding type: a colored table cell for color, an image for image, nothing for text.
 */
function displaysettingvalue($value,$type)
{
  $html = '';
  if($type == 'color')
    $html = '<table style="border: 1px solid #000000; background:#' . getcolorvalue($value) . '"><tr><td></td></tr></table>';
  else
  if($type == 'image')
    $html .= '<img src=' . theme_url($value) . ' alt=' . $value . ' /><br/><br/>';
  $html .= "\n";
  return $html;
}

/**
 * Helper, gets the name of the data directory.
 *
 * @returns string the name of the data directory.
 */
function datadirectory()
{
  $data_directory = MFW_SITE_PATH . '/data';
  return $data_directory;
}

/**
 * Helper, checks if the data directory is writable.
 *
 * @returns boolean true if the data directory is writable.
 */
function datadirectorywritable()
{
  return ( is_writable( datadirectory() ) == true );
}

/**
 * Helper, gets the name of the settings configuration file.
 *
 * @returns string name of the settings configuration file.
 */
function settingsconfigurationfile()
{
  $settings_config_file = datadirectory() . '/settings_config.php';
  return $settings_config_file;
}

/**
 * Helper, checks if the settings configuration file in the data directory exists.
 *
 * @returns boolean true if the settings configuration file exists.
 */
function settingsconfigurationfileexist()
{
  return ( file_exists( settingsconfigurationfile() ) == true );
}

$Colors = array( 
 
// Colors  as  they  are  defined  in  HTML  3.2 
            "black"=>array( "red"=>0x00,  "green"=>0x00,  "blue"=>0x00), 
            "maroon"=>array( "red"=>0x80,  "green"=>0x00,  "blue"=>0x00), 
            "green"=>array( "red"=>0x00,  "green"=>0x80,  "blue"=>0x00), 
            "olive"=>array( "red"=>0x80,  "green"=>0x80,  "blue"=>0x00), 
            "navy"=>array( "red"=>0x00,  "green"=>0x00,  "blue"=>0x80), 
            "purple"=>array( "red"=>0x80,  "green"=>0x00,  "blue"=>0x80), 
            "teal"=>array( "red"=>0x00,  "green"=>0x80,  "blue"=>0x80), 
            "gray"=>array( "red"=>0x80,  "green"=>0x80,  "blue"=>0x80), 
            "silver"=>array( "red"=>0xC0,  "green"=>0xC0,  "blue"=>0xC0), 
            "red"=>array( "red"=>0xFF,  "green"=>0x00,  "blue"=>0x00), 
            "lime"=>array( "red"=>0x00,  "green"=>0xFF,  "blue"=>0x00), 
            "yellow"=>array( "red"=>0xFF,  "green"=>0xFF,  "blue"=>0x00), 
            "blue"=>array( "red"=>0x00,  "green"=>0x00,  "blue"=>0xFF), 
            "fuchsia"=>array( "red"=>0xFF,  "green"=>0x00,  "blue"=>0xFF), 
            "aqua"=>array( "red"=>0x00,  "green"=>0xFF,  "blue"=>0xFF), 
            "white"=>array( "red"=>0xFF,  "green"=>0xFF,  "blue"=>0xFF), 
 
//  Additional  colors  as  they  are  used  by  Netscape  and  IE 
            "aliceblue"=>array( "red"=>0xF0,  "green"=>0xF8,  "blue"=>0xFF), 
            "antiquewhite"=>array( "red"=>0xFA,  "green"=>0xEB,  "blue"=>0xD7), 
            "aquamarine"=>array( "red"=>0x7F,  "green"=>0xFF,  "blue"=>0xD4), 
            "azure"=>array( "red"=>0xF0,  "green"=>0xFF,  "blue"=>0xFF), 
            "beige"=>array( "red"=>0xF5,  "green"=>0xF5,  "blue"=>0xDC), 
            "blueviolet"=>array( "red"=>0x8A,  "green"=>0x2B,  "blue"=>0xE2), 
            "brown"=>array( "red"=>0xA5,  "green"=>0x2A,  "blue"=>0x2A), 
            "burlywood"=>array( "red"=>0xDE,  "green"=>0xB8,  "blue"=>0x87), 
            "cadetblue"=>array( "red"=>0x5F,  "green"=>0x9E,  "blue"=>0xA0), 
            "chartreuse"=>array( "red"=>0x7F,  "green"=>0xFF,  "blue"=>0x00), 
            "chocolate"=>array( "red"=>0xD2,  "green"=>0x69,  "blue"=>0x1E), 
            "coral"=>array( "red"=>0xFF,  "green"=>0x7F,  "blue"=>0x50), 
            "cornflowerblue"=>array( "red"=>0x64,  "green"=>0x95,  "blue"=>0xED), 
            "cornsilk"=>array( "red"=>0xFF,  "green"=>0xF8,  "blue"=>0xDC), 
            "crimson"=>array( "red"=>0xDC,  "green"=>0x14,  "blue"=>0x3C), 
            "darkblue"=>array( "red"=>0x00,  "green"=>0x00,  "blue"=>0x8B), 
            "darkcyan"=>array( "red"=>0x00,  "green"=>0x8B,  "blue"=>0x8B), 
            "darkgoldenrod"=>array( "red"=>0xB8,  "green"=>0x86,  "blue"=>0x0B), 
            "darkgray"=>array( "red"=>0xA9,  "green"=>0xA9,  "blue"=>0xA9), 
            "darkgreen"=>array( "red"=>0x00,  "green"=>0x64,  "blue"=>0x00), 
            "darkkhaki"=>array( "red"=>0xBD,  "green"=>0xB7,  "blue"=>0x6B), 
            "darkmagenta"=>array( "red"=>0x8B,  "green"=>0x00,  "blue"=>0x8B), 
            "darkolivegreen"=>array( "red"=>0x55,  "green"=>0x6B,  "blue"=>0x2F), 
            "darkorange"=>array( "red"=>0xFF,  "green"=>0x8C,  "blue"=>0x00), 
            "darkorchid"=>array( "red"=>0x99,  "green"=>0x32,  "blue"=>0xCC), 
            "darkred"=>array( "red"=>0x8B,  "green"=>0x00,  "blue"=>0x00), 
            "darksalmon"=>array( "red"=>0xE9,  "green"=>0x96,  "blue"=>0x7A), 
            "darkseagreen"=>array( "red"=>0x8F,  "green"=>0xBC,  "blue"=>0x8F), 
            "darkslateblue"=>array( "red"=>0x48,  "green"=>0x3D,  "blue"=>0x8B), 
            "darkslategray"=>array( "red"=>0x2F,  "green"=>0x4F,  "blue"=>0x4F), 
            "darkturquoise"=>array( "red"=>0x00,  "green"=>0xCE,  "blue"=>0xD1), 
            "darkviolet"=>array( "red"=>0x94,  "green"=>0x00,  "blue"=>0xD3), 
            "deeppink"=>array( "red"=>0xFF,  "green"=>0x14,  "blue"=>0x93), 
            "deepskyblue"=>array( "red"=>0x00,  "green"=>0xBF,  "blue"=>0xFF), 
            "dimgray"=>array( "red"=>0x69,  "green"=>0x69,  "blue"=>0x69), 
            "dodgerblue"=>array( "red"=>0x1E,  "green"=>0x90,  "blue"=>0xFF), 
            "firebrick"=>array( "red"=>0xB2,  "green"=>0x22,  "blue"=>0x22), 
            "floralwhite"=>array( "red"=>0xFF,  "green"=>0xFA,  "blue"=>0xF0), 
            "forestgreen"=>array( "red"=>0x22,  "green"=>0x8B,  "blue"=>0x22), 
            "gainsboro"=>array( "red"=>0xDC,  "green"=>0xDC,  "blue"=>0xDC), 
            "ghostwhite"=>array( "red"=>0xF8,  "green"=>0xF8,  "blue"=>0xFF), 
            "gold"=>array( "red"=>0xFF,  "green"=>0xD7,  "blue"=>0x00), 
            "goldenrod"=>array( "red"=>0xDA,  "green"=>0xA5,  "blue"=>0x20), 
            "greenyellow"=>array( "red"=>0xAD,  "green"=>0xFF,  "blue"=>0x2F), 
            "honeydew"=>array( "red"=>0xF0,  "green"=>0xFF,  "blue"=>0xF0), 
            "hotpink"=>array( "red"=>0xFF,  "green"=>0x69,  "blue"=>0xB4), 
            "indianred"=>array( "red"=>0xCD,  "green"=>0x5C,  "blue"=>0x5C), 
            "indigo"=>array( "red"=>0x4B,  "green"=>0x00,  "blue"=>0x82), 
            "ivory"=>array( "red"=>0xFF,  "green"=>0xFF,  "blue"=>0xF0), 
            "khaki"=>array( "red"=>0xF0,  "green"=>0xE6,  "blue"=>0x8C), 
            "lavender"=>array( "red"=>0xE6,  "green"=>0xE6,  "blue"=>0xFA), 
            "lavenderblush"=>array( "red"=>0xFF,  "green"=>0xF0,  "blue"=>0xF5), 
            "lawngreen"=>array( "red"=>0x7C,  "green"=>0xFC,  "blue"=>0x00), 
            "lemonchiffon"=>array( "red"=>0xFF,  "green"=>0xFA,  "blue"=>0xCD), 
            "lightblue"=>array( "red"=>0xAD,  "green"=>0xD8,  "blue"=>0xE6), 
            "lightcoral"=>array( "red"=>0xF0,  "green"=>0x80,  "blue"=>0x80), 
            "lightcyan"=>array( "red"=>0xE0,  "green"=>0xFF,  "blue"=>0xFF), 
            "lightgoldenrodyellow"=>array( "red"=>0xFA,  "green"=>0xFA,  "blue"=>0xD2), 
            "lightgreen"=>array( "red"=>0x90,  "green"=>0xEE,  "blue"=>0x90), 
            "lightgrey"=>array( "red"=>0xD3,  "green"=>0xD3,  "blue"=>0xD3), 
            "lightpink"=>array( "red"=>0xFF,  "green"=>0xB6,  "blue"=>0xC1), 
            "lightsalmon"=>array( "red"=>0xFF,  "green"=>0xA0,  "blue"=>0x7A), 
            "lightseagreen"=>array( "red"=>0x20,  "green"=>0xB2,  "blue"=>0xAA), 
            "lightskyblue"=>array( "red"=>0x87,  "green"=>0xCE,  "blue"=>0xFA), 
            "lightslategray"=>array( "red"=>0x77,  "green"=>0x88,  "blue"=>0x99), 
            "lightsteelblue"=>array( "red"=>0xB0,  "green"=>0xC4,  "blue"=>0xDE), 
            "lightyellow"=>array( "red"=>0xFF,  "green"=>0xFF,  "blue"=>0xE0), 
            "limegreen"=>array( "red"=>0x32,  "green"=>0xCD,  "blue"=>0x32), 
            "linen"=>array( "red"=>0xFA,  "green"=>0xF0,  "blue"=>0xE6), 
            "mediumaquamarine"=>array( "red"=>0x66,  "green"=>0xCD,  "blue"=>0xAA), 
            "mediumblue"=>array( "red"=>0x00,  "green"=>0x00,  "blue"=>0xCD), 
            "mediumorchid"=>array( "red"=>0xBA,  "green"=>0x55,  "blue"=>0xD3), 
            "mediumpurple"=>array( "red"=>0x93,  "green"=>0x70,  "blue"=>0xD0), 
            "mediumseagreen"=>array( "red"=>0x3C,  "green"=>0xB3,  "blue"=>0x71), 
            "mediumslateblue"=>array( "red"=>0x7B,  "green"=>0x68,  "blue"=>0xEE), 
            "mediumspringgreen"=>array( "red"=>0x00,  "green"=>0xFA,  "blue"=>0x9A), 
            "mediumturquoise"=>array( "red"=>0x48,  "green"=>0xD1,  "blue"=>0xCC), 
            "mediumvioletred"=>array( "red"=>0xC7,  "green"=>0x15,  "blue"=>0x85), 
            "midnightblue"=>array( "red"=>0x19,  "green"=>0x19,  "blue"=>0x70), 
            "mintcream"=>array( "red"=>0xF5,  "green"=>0xFF,  "blue"=>0xFA), 
            "mistyrose"=>array( "red"=>0xFF,  "green"=>0xE4,  "blue"=>0xE1), 
            "moccasin"=>array( "red"=>0xFF,  "green"=>0xE4,  "blue"=>0xB5), 
            "navajowhite"=>array( "red"=>0xFF,  "green"=>0xDE,  "blue"=>0xAD), 
            "oldlace"=>array( "red"=>0xFD,  "green"=>0xF5,  "blue"=>0xE6), 
            "olivedrab"=>array( "red"=>0x6B,  "green"=>0x8E,  "blue"=>0x23), 
            "orange"=>array( "red"=>0xFF,  "green"=>0xA5,  "blue"=>0x00), 
            "orangered"=>array( "red"=>0xFF,  "green"=>0x45,  "blue"=>0x00), 
            "orchid"=>array( "red"=>0xDA,  "green"=>0x70,  "blue"=>0xD6), 
            "palegoldenrod"=>array( "red"=>0xEE,  "green"=>0xE8,  "blue"=>0xAA), 
            "palegreen"=>array( "red"=>0x98,  "green"=>0xFB,  "blue"=>0x98), 
            "paleturquoise"=>array( "red"=>0xAF,  "green"=>0xEE,  "blue"=>0xEE), 
            "palevioletred"=>array( "red"=>0xDB,  "green"=>0x70,  "blue"=>0x93), 
            "papayawhip"=>array( "red"=>0xFF,  "green"=>0xEF,  "blue"=>0xD5), 
            "peachpuff"=>array( "red"=>0xFF,  "green"=>0xDA,  "blue"=>0xB9), 
            "peru"=>array( "red"=>0xCD,  "green"=>0x85,  "blue"=>0x3F), 
            "pink"=>array( "red"=>0xFF,  "green"=>0xC0,  "blue"=>0xCB), 
            "plum"=>array( "red"=>0xDD,  "green"=>0xA0,  "blue"=>0xDD), 
            "powderblue"=>array( "red"=>0xB0,  "green"=>0xE0,  "blue"=>0xE6), 
            "rosybrown"=>array( "red"=>0xBC,  "green"=>0x8F,  "blue"=>0x8F), 
            "royalblue"=>array( "red"=>0x41,  "green"=>0x69,  "blue"=>0xE1), 
            "saddlebrown"=>array( "red"=>0x8B,  "green"=>0x45,  "blue"=>0x13), 
            "salmon"=>array( "red"=>0xFA,  "green"=>0x80,  "blue"=>0x72), 
            "sandybrown"=>array( "red"=>0xF4,  "green"=>0xA4,  "blue"=>0x60), 
            "seagreen"=>array( "red"=>0x2E,  "green"=>0x8B,  "blue"=>0x57), 
            "seashell"=>array( "red"=>0xFF,  "green"=>0xF5,  "blue"=>0xEE), 
            "sienna"=>array( "red"=>0xA0,  "green"=>0x52,  "blue"=>0x2D), 
            "skyblue"=>array( "red"=>0x87,  "green"=>0xCE,  "blue"=>0xEB), 
            "slateblue"=>array( "red"=>0x6A,  "green"=>0x5A,  "blue"=>0xCD), 
            "slategray"=>array( "red"=>0x70,  "green"=>0x80,  "blue"=>0x90), 
            "snow"=>array( "red"=>0xFF,  "green"=>0xFA,  "blue"=>0xFA), 
            "springgreen"=>array( "red"=>0x00,  "green"=>0xFF,  "blue"=>0x7F), 
            "steelblue"=>array( "red"=>0x46,  "green"=>0x82,  "blue"=>0xB4), 
            "tan"=>array( "red"=>0xD2,  "green"=>0xB4,  "blue"=>0x8C), 
            "thistle"=>array( "red"=>0xD8,  "green"=>0xBF,  "blue"=>0xD8), 
            "tomato"=>array( "red"=>0xFF,  "green"=>0x63,  "blue"=>0x47), 
            "turquoise"=>array( "red"=>0x40,  "green"=>0xE0,  "blue"=>0xD0), 
            "violet"=>array( "red"=>0xEE,  "green"=>0x82,  "blue"=>0xEE), 
            "wheat"=>array( "red"=>0xF5,  "green"=>0xDE,  "blue"=>0xB3), 
            "whitesmoke"=>array( "red"=>0xF5,  "green"=>0xF5,  "blue"=>0xF5), 
            "yellowgreen"=>array( "red"=>0x9A,  "green"=>0xCD,  "blue"=>0x32));
 
$BodyFonts = array
(
  'Palatino',
  'Frutiger',
  'Frutiger Linotype',
  'Univers',
  'Calibri',
  'Gill Sans',
  'Gill Sans MT',
  'Myriad Pro',
  'Myriad',
  'DejaVu Sans Condensed',
  'Liberation Sans',
  'Nimbus Sans L',
  'Tahoma',
  'Geneva',
  'Helvetica Neue',
  'Helvetica',
  'Arial'
);

/**
 * Helper, returns available body fonts.
 *
 * @returns array The available body fonts.
 */
function getbodyfonts()
{
  global  $BodyFonts;
  return $BodyFonts;
}

$HeaderFonts = array
(
  'Helvetica',
  'Arial',
  'Cambria',
  'Georgia',
  'Times',
  'Times New Roman'
);

/**
 * Helper, returns available header fonts.
 *
 * @returns array The available header fonts.
 */
function getheaderfonts()
{
  global  $HeaderFonts;
  return $HeaderFonts;
}
 
//  GetColor  returns  an  associative  array  with  the  red,  green  and  blue values  of  the  desired  color 

/**
 * Helper, returns the 6 digit hex code for a color name.
 *
 * @param string Colorname The color name.
 *
 * @returns string The corresponding 6 digit hex color value.
 */
function getcolorvalue($Colorname)
{
  global  $Colors;
  return strtoupper(zeropad(dechex($Colors[$Colorname]['red']),2)) . strtoupper(zeropad(dechex($Colors[$Colorname]['green']),2)) . strtoupper(zeropad(dechex($Colors[$Colorname]['blue']),2));
}

/**
 * Helper, returns an array with color names.
 *
 * @returns array color name.                                                                                                          
 */
function getallcolors()
{
  global  $Colors;
  $colornames = array();
  foreach($Colors as $key=>$value)
  {
    $colornames[] = $key;
  }
  return $colornames;
}

/**
 * Helper, returns theme path.
 *
 * @returns string theme path.                                                                                                          
 */
function getthemepath()
{
  return CMyFrameWork::Instance()->ThemePath();
}

/**
 * Helper, zeropads a number on the left side and returns the string.
 *
 * @returns string zero left padded string.
 */
function zeropad($num, $lim)
{
  return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}

/**
 * Helper, Get all filenames of a directory and return in an array.
 *
 * @returns array file names.
 */
function readDirectory($aPath)
{
  $list = Array();
  if(is_dir($aPath))
  {
    if ($dh = opendir($aPath))
    {
      while (($file = readdir($dh)) !== false)
      {
        if(is_file("$aPath/$file") && $file != '.htaccess')
        {
          $list[$file] = "$file";
        }
      }
      closedir($dh);
    }
  }
  sort($list, SORT_STRING);
  return $list;
}

/**
 * Helper, returns the start page title.
 *
 * @returns string start page title.
 */
function startpagetitle()
{
  if ( datadirectorywritable() && settingsconfigurationfileexist() )
    require(settingsconfigurationfile());
  else
  {
    $StartPageTitle = "Index Controller";
  }
  return $StartPageTitle;
}

/**
 * Helper, returns the file name with new extension
 *
 * @param string filename	The file name with extension.
 * @param string new_extension	The new extension.
 *
 * @returns string The file name with new extension.
 */
function replace_extension($filename, $new_extension)
{
  $info = pathinfo($filename);
  return $info['filename'] . '.' . $new_extension;
}
