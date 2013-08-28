<?php

/**
 * tab_expnur.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_expnur extends db {

    var $exn_id;
    var $exp_id;
    var $exn_nur;
    var $exn_pass;
    var $exn_user;    
    var $exn_estado;

    function __construct() {
        parent::__construct();
    }

    function getExn_id() {
        return $this->exn_id;
    }

    function setExn_id($exn_id) {
        $this->exn_id = $exn_id;
    }
    
    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }
    

    
    function getExn_pass() {
        return $this->exn_pass;
    }

    function setExn_pass($exn_pass) {
        $this->exn_pass = $exn_pass;
    }

    function getExn_user() {
        return $this->exn_user;
    }

    function setExn_user($exn_user) {
        $this->exn_user = $exn_user;
    }

    function getExn_nur() {
        return $this->exn_nur;
    }

    function setExn_nur($exn_nur) {
        $this->exn_nur = $exn_nur;
    }

    function getExn_estado() {
        return $this->exn_estado;
    }

    function setExn_estado($exn_estado) {
        $this->exn_estado = $exn_estado;
    }

}

?>