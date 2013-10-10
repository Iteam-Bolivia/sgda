<?php

/**
 * tab_doccorr.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_doccorr extends db {
    var $dco_id;
    var $fil_id;
    var $fil_nur;
    var $fil_nur_s;
    var $fil_cite;
    var $fil_asunto;  
    var $fil_sintesis;  
    var $dco_estado;
    

    function __construct() {
        parent::__construct();
    }

    function getDco_id() {
        return $this->dco_id;
    }

    function setDco_id($dco_id) {
        $this->dco_id = $dco_id;
    }
    
    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getFil_nur() {
        return $this->fil_nur;
    }

    function setFil_nur($fil_nur) {
        $this->fil_nur = $fil_nur;
    }

    function getFil_nur_s() {
        return $this->fil_nur_s;
    }

    function setFil_nur_s($fil_nur_s) {
        $this->fil_nur_s = $fil_nur_s;
    } 
    
    function getFil_cite() {
        return $this->fil_cite;
    }

    function setFil_cite($fil_cite) {
        $this->fil_cite = $fil_cite;
    }    
        
    function getFil_asunto() {
        return $this->fil_asunto;
    }

    function setFil_asunto($fil_asunto) {
        $this->fil_asunto = $fil_asunto;
    }     
    
    function getFil_sintesis() {
        return $this->fil_sintesis;
    }

    function setFil_sintesis($fil_sintesis) {
        $this->fil_sintesis = $fil_sintesis;
    }    

    function getFil_estado() {
        return $this->fil_estado;
    }

    function setFil_estado($fil_estado) {
        $this->fil_estado = $fil_estado;
    }

    function getDco_estado() {
        return $this->dco_estado;
    }

    function setDco_estado($dco_estado) {
        $this->dco_estado = $dco_estado;
    }
    
}

?>