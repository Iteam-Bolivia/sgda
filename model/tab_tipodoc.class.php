<?php

/**
 * tab_tipodoc.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_tipodoc extends db {

    var $tdo_id;
    var $tdo_codigo;
    var $tdo_nombre;
    var $tdo_estado;

    function __construct() {
        parent::__construct();
    }

    function gettdo_id() {
        return $this->tdo_id;
    }

    function settdo_id($tdo_id) {
        $this->tdo_id = $tdo_id;
    }

    function gettdo_codigo() {
        return $this->tdo_codigo;
    }

    function settdo_codigo($tdo_codigo) {
        $this->tdo_codigo = $tdo_codigo;
    }

    function gettdo_nombre() {
        return $this->tdo_nombre;
    }

    function settdo_nombre($tdo_nombre) {
        $this->tdo_nombre = $tdo_nombre;
    }

    function gettdo_estado() {
        return $this->tdo_estado;
    }

    function settdo_estado($tdo_estado) {
        $this->tdo_estado = $tdo_estado;
    }

}

?>