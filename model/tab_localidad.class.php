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
class tab_localidad extends db {

    var $loc_id;
    var $pro_id;
    var $loc_codigo;
    var $loc_nombre;
    var $loc_estado;

    function __construct() {
        parent::__construct();
    }

    function getloc_id() {
        return $this->loc_id;
    }

    function setloc_id($loc_id) {
        $this->loc_id = $loc_id;
    }

    function getpro_id() {
        return $this->pro_id;
    }

    function setpro_id($pro_id) {
        $this->pro_id = $pro_id;
    }

    function getloc_codigo() {
        return $this->loc_codigo;
    }

    function setloc_codigo($loc_codigo) {
        $this->loc_codigo = $loc_codigo;
    }

    function getloc_nombre() {
        return $this->loc_nombre;
    }

    function setloc_nombre($loc_nombre) {
        $this->loc_nombre = $loc_nombre;
    }

    function getloc_estado() {
        return $this->loc_estado;
    }

    function setloc_estado($loc_estado) {
        $this->loc_estado = $loc_estado;
    }

}

?>