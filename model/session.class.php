<?php

@session_start();

class session {

    private $SessionName;
    private $encrypted;

    /**
     * Establece nombre de la session
     *
     * @param string $encrypt
     */
    function __construct($encrypt = SESSKRYPT) {
        $this->sessionName = md5(SESSNAME . session_id());
        $this->encrypted = $encrypt;
    }

    /* Function name: Set
      Params:
      @Setting - The key to set
      @Value - The value to set
     */

    public function Set($Setting, $Value) {
        if ($this->encrypted)
            $_SESSION[$this->SessionName][$Setting] = Cipher::encrypt($Value);
        else
            $_SESSION[$this->SessionName][$Setting] = $Value;
    }

    /* Function name: Get
      Params:
      @Setting - The key to get
      @Default - Value to return if the requested key is empty.
     */

    function Get($Setting) {
        if (isset($_SESSION[$this->SessionName][$Setting]) && !empty($_SESSION[$this->SessionName][$Setting])) {
            if ($this->encrypted)
                return Cipher::decrypt($_SESSION[$this->SessionName][$Setting]);
            else
                return $_SESSION[$this->SessionName][$Setting];
        }
        else
            return '';
    }

    /** Function name: Set
      Params:
      @Setting - The key to set
      @Value - The value to set
     */
    function Del($Setting) {
        unset($_SESSION[$this->SessionName][$Setting]);
    }

    /**
     * Unsets all sessions
     *
     */
    function DestroyAll() {
        unset($_SESSION[$this->SessionName]);
    }

}

/*
  // Example Usage:
  include('classes/class.Sessions.inc.php');

  $Session = new Sessions('Script');

  // Clean setting of the session data
  $Session->Set('user','username');
  $Session->Set('pass','password');

  // Clean retrieving of the data
  $User = $Session->Get('user');

  // Clean retrieving of the data, with a default value.

  $User = $Session->Get('user','username'); // If no value, returns 'username'
 */
?>
