<?php

/**
 * tab_tipoctt.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_tipoctt extends db {

    var $tct_id;
    var $tct_codigo;
    var $tct_nombre;
    var $tct_estado;

    function __construct() {
        parent::__construct();
    }

    function gettct_id() {
        return $this->tct_id;
    }

    function settct_id($tct_id) {
        $this->tct_id = $tct_id;
    }

    function gettct_codigo() {
        return $this->tct_codigo;
    }

    function settct_codigo($tct_codigo) {
        $this->tct_codigo = $tct_codigo;
    }

    function gettct_nombre() {
        return $this->tct_nombre;
    }

    function settct_nombre($tct_nombre) {
        $this->tct_nombre = $tct_nombre;
    }

    function gettct_estado() {
        return $this->tct_estado;
    }

    function settct_estado($tct_estado) {
        $this->tct_estado = $tct_estado;
    }

}

?>