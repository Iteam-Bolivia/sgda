<?php

/**
 * tab_departamento.class.php Class
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_departamento extends db {

    var $dep_id;
    var $dep_codigo;
    var $dep_nombre;
    var $dep_estado;

    function __construct() {
        parent::__construct();
    }

    function getdep_id() {
        return $this->dep_id;
    }

    function setdep_id($dep_id) {
        $this->dep_id = $dep_id;
    }

    function getdep_codigo() {
        return $this->dep_codigo;
    }

    function setdep_codigo($dep_codigo) {
        $this->dep_codigo = $dep_codigo;
    }

    function getdep_nombre() {
        return $this->dep_nombre;
    }

    function setdep_nombre($dep_nombre) {
        $this->dep_nombre = $dep_nombre;
    }

    function getdep_estado() {
        return $this->dep_estado;
    }

    function setdep_estado($dep_estado) {
        $this->dep_estado = $dep_estado;
    }

}

?>