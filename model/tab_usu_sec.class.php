<?php

/**
 * Tab_use_sec.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_usu_sec extends db {

    var $use_id;
    var $usu_id;
    var $sec_id;
    var $use_estado;

    function __construct() {
        parent::__construct();
    }

    function getUse_id() {
        return $this->use_id;
    }

    function setUse_id($use_id) {
        $this->use_id = $use_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getSec_id() {
        return $this->sec_id;
    }

    function setSec_id($sec_id) {
        $this->sec_id = $sec_id;
    }

    function getUse_estado() {
        return $this->use_estado;
    }

    function setUse_estado($use_estado) {
        $this->use_estado = $use_estado;
    }

}

?>