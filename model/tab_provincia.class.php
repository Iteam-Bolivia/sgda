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
class tab_provincia extends db {

    var $pro_id;
    var $dep_id;
    var $pro_codigo;
    var $pro_nombre;
    var $pro_estado;

    function __construct() {
        parent::__construct();
    }

    function getpro_id() {
        return $this->pro_id;
    }

    function setpro_id($pro_id) {
        $this->pro_id = $pro_id;
    }

    function getdep_id() {
        return $this->dep_id;
    }

    function setdep_id($dep_id) {
        $this->dep_id = $dep_id;
    }

    function getpro_codigo() {
        return $this->pro_codigo;
    }

    function setpro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function getpro_nombre() {
        return $this->pro_nombre;
    }

    function setpro_nombre($pro_nombre) {
        $this->pro_nombre = $pro_nombre;
    }

    function getpro_estado() {
        return $this->pro_estado;
    }

    function setpro_estado($pro_estado) {
        $this->pro_estado = $pro_estado;
    }

}

?>