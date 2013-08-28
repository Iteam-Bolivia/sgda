<?php

/**
 * tab_gestion.class.php Class
 *
 * @package
 * @author Lic. Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class tab_gestion extends db {

    var $ges_id;
    var $ges_nombre;
    var $ges_numero;
    var $ges_estado;
    var $ser_id;

    function __construct() {
        parent::__construct();
    }

    function getGes_id() {
        return $this->ges_id;
    }

    function setGes_id($ges_id) {
        $this->ges_id = $ges_id;
    }

    function getGes_nombre() {
        return $this->ges_nombre;
    }

    function setGes_nombre($ges_nombre) {
        $this->ges_nombre = $ges_nombre;
    }

    function getGes_numero() {
        return $this->ges_numero;
    }

    function setGes_numero($ges_numero) {
        $this->ges_numero = $ges_numero;
    }

    function getGes_estado() {
        return $this->ges_estado;
    }

    function setGes_estado($ges_estado) {
        $this->ges_estado = $ges_estado;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

}

?>