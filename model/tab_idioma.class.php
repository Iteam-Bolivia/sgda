<?php

/**
 * tab_idioma.class.php Class
 *
 * @package
 * @author lic. castellón
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_idioma extends db {

    var $idi_id;
    var $idi_codigo;
    var $idi_nombre;
    var $idi_estado;

    function __construct() {
        parent::__construct();
    }

    function getIdi_id() {
        return $this->idi_id;
    }

    function setIdi_id($idi_id) {
        $this->idi_id = $idi_id;
    }

    function getIdi_codigo() {
        return $this->idi_codigo;
    }

    function setIdi_codigo($idi_codigo) {
        $this->idi_codigo = $idi_codigo;
    }

    function getIdi_nombre() {
        return $this->idi_nombre;
    }

    function setIdi_nombre($idi_nombre) {
        $this->idi_nombre = $idi_nombre;
    }

    function getIdi_estado() {
        return $this->idi_estado;
    }

    function setIdi_estado($idi_estado) {
        $this->idi_estado = $idi_estado;
    }

}

?>