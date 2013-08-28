<?php

/**
 * tab_tipoproy.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_tipoproy extends db {

    var $tpy_id;
    var $tpy_codigo;
    var $tpy_nombre;
    var $tpy_estado;

    function __construct() {
        parent::__construct();
    }

    function gettpy_id() {
        return $this->tpy_id;
    }

    function settpy_id($tpy_id) {
        $this->tpy_id = $tpy_id;
    }

    function gettpy_codigo() {
        return $this->tpy_codigo;
    }

    function settpy_codigo($tpy_codigo) {
        $this->tpy_codigo = $tpy_codigo;
    }

    function gettpy_nombre() {
        return $this->tpy_nombre;
    }

    function settpy_nombre($tpy_nombre) {
        $this->tpy_nombre = $tpy_nombre;
    }

    function gettpy_estado() {
        return $this->tpy_estado;
    }

    function settpy_estado($tpy_estado) {
        $this->tpy_estado = $tpy_estado;
    }

}

?>