<?php
/**
* Holding a instance of CMyFrameWork to enable use of $this in subclasses and provide some helpers.
*
* @package MyFrameWorkCore
*/
class CObject
{
  /**
   * Attributes
   */
  protected $mfw;
  protected $config;
  protected $request;
  protected $data;
  protected $db;
  protected $views;
  protected $session;
  protected $user;

  /**
   * Constructor, can be instantiated by sending in the $mfw reference.
   */
  protected function __construct($mfw=null)
  {
    if (!$mfw)
    {
      $mfw = CMyFrameWork::Instance();
    }
    $this->mfw     = &$mfw;
    $this->config  = &$mfw->config;
    $this->request = &$mfw->request;
    $this->data    = &$mfw->data;
    $this->db      = &$mfw->db;
    $this->views   = &$mfw->views;
    $this->session = &$mfw->session;
    $this->user    = &$mfw->user;
  }

  /**
   * Wrapper for same method in CMyFrameWork. See code for documentation.
   */
  protected function RedirectTo($urlOrController=null, $method=null, $arguments=null)
  {
    $this->mfw->RedirectTo($urlOrController, $method, $arguments);
  }

  /**
   * Wrapper for same method in CMyFrameWork. See code for documentation.
   */
  protected function RedirectToController($method=null, $arguments=null)
  {
    $this->mfw->RedirectToController($method, $arguments);
  }

  /**
   * Wrapper for same method in CMyFrameWork. See code for documentation.
   */
  protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null)
  {
    $this->mfw->RedirectToControllerMethod($controller, $method, $arguments);
  }

  /**
   * Wrapper for same method in CMyFrameWork. See code for documentation.
   */
  protected function AddMessage($type, $message, $alternative=null)
  {
    return $this->mfw->AddMessage($type, $message, $alternative);
  }

  /**
   * Wrapper for same method in CMyFrameWork. See code for documentation.
   */
  protected function CreateUrl($urlOrController=null, $method=null, $arguments=null)
  {
    return $this->mfw->CreateUrl($urlOrController, $method, $arguments);
  }
}

