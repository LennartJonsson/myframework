<?php
/**
* A model for settings stored in database.
*
* @package MyFrameWorkCore
*/
class CMSetting extends CObject implements IHasSQL, ArrayAccess, IModule
{

  /**
   * Properties
   */

  public $data;

  /**
   * Constructor
   */
  public function __construct($key=null)
  {
    parent::__construct();
    if($key)
    {
      $this->LoadByKey($key);
    }
    else
    {
      $this->data = array();
    }
  }

  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value)
  {
    if (is_null($offset))
    {
      $this->data[] = $value;
    }
    else
    {
      $this->data[$offset] = $value;
    }
  }
  public function offsetExists($offset)
  {
    return isset($this->data[$offset]);
  }
  public function offsetUnset($offset)
  {
    unset($this->data[$offset]);
  }
  public function offsetGet($offset)
  {
    return isset($this->data[$offset]) ? $this->data[$offset] : null;
  }

  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null)
  {
    $queries = array(
      'drop table settings'    => "DROP TABLE IF EXISTS Settings;",
      'create table settings'  => "CREATE TABLE IF NOT EXISTS Settings (key TEXT, value TEXT, type TEXT);",
      'insert into settings'   => "INSERT INTO Settings (key,value,type) VALUES (?,?,?);",
      'select * by key'        => "SELECT key,value,type FROM Settings WHERE key=?;",
      'select * from settings' => "SELECT * FROM Settings ORDER BY key ASC;",
      'delete from settings'   => "DELETE FROM Settings;",
      'update by key'          => "UPDATE Settings SET value=? WHERE key=?;",
     );
    if(!isset($queries[$key]))
    {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }

  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null)
  {
    switch($action)
    {
      case 'install':
	try
	{
	  $this->db->ExecuteQuery(self::SQL('drop table settings'));
	  $this->db->ExecuteQuery(self::SQL('create table settings'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('MenuTitleAbout', '', 'menu'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('MenuTitleBlog', '', 'menu'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('MenuTitleGuestbook', '', 'menu'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('HtmlBackgroundColour', 'yellowgreen', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('BodyBackgroundColour', 'green', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('OuterWrapHeaderBackgroundColour', 'olive', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('OuterWrapHeaderBorderBottomWidth', '2', 'numeric'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('OuterWrapHeaderBorderBottomColour', 'navy', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('OuterWrapFooterBackgroundColour', 'plum', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('AnchorColour', 'aquamarine', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('NavigationbarSelectedBackgroundColour', 'gray', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('NavigationbarHoverBackgroundColour', 'silver', 'color'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('FooterText',htmlent('MyFrameWork © by Lennart Jönsson (bo.lennart.jonsson@gmail.com)'), 'text'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('FaviconLogo', 'bart_biker.jpg', 'image'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('StartPageTitle', 'Index Controller', 'text'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('BodyFont', 'Palatino', 'bodyfont'));
	  $this->db->ExecuteQuery(self::SQL('insert into settings'), array('HeaderFont', 'Helvetica', 'headerfont'));
	  return array('success', 'Successfully created the database table and created default values.');
	}
	catch(Exception $e)
	{
	  die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
	}
      break;
     
      default:
	throw new Exception('Unsupported action for this module.');
      break;
    }
  }

  /**
   * List all settings.
   *
   * @returns array with listing or null if empty.
   */
  public function ListAll()
  {
    try
    {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from settings'));
    }
    catch(Exception $e)
    {
      echo $e;
      return null;
    }
  }

  /**
   * Writes the setting config file.
   */
  public function WriteSettingConfigFile()
  {
    $settings = $this->ListAll();
    $php = null;
    $first_line = true;
    foreach($settings as $setting)
    {
      if ( $first_line )
      	$first_line = false;
      else
        $php .= "\n";
      if ( $setting['type'] == 'color')
        $value = getcolorvalue($setting['value']);
      else
        $value = $setting['value'];
      $php .= "  $" . $setting['key'] . " = '" . $value . "';";
    }
    $file = <<<EOD
<?php
$php
?>
EOD;
  // Write the file
    file_put_contents(settingsconfigurationfile(), $file);
  }

  /**
   * Save setting.
   *                       
   * @returns boolean true if success else false.
   */
  public function Save()
  {
    $this['value'] = htmlent($this['value']);
    $this->db->ExecuteQuery(self::SQL('update by key'), array($this['value'],$this['key']));

    $rowcount = $this->db->RowCount();
    if($rowcount)
    {
      $this->AddMessage('success', "Successfully updated setting '" . htmlEnt($this['key']) . "'.");
      $this->WriteSettingConfigFile();
    }
    else
    {
      $this->AddMessage('error', "Failed to update setting '" . htmlEnt($this['key']) . "'.");
    }
    return $rowcount === 1;
  }

  /**
   * Load setting by key.
   *
   * @param key string the key of the setting.
   * @returns boolean true if success else false.
   */
  public function LoadByKey($key)
  {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by key'), array($key));
    if(empty($res))
    {
      $this->AddMessage('error', "Failed to load setting with key '$key'.");
      return false;
    }
    else
    {
      $this->data = $res[0];
      $this->data['value'] = htmldec($this->data['value']);
    }
    return true;
  }
}
