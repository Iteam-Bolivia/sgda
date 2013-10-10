<?php

/**
 * Tab_fondo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_fondo extends db {

    var $fon_id;
    var $fon_par;
    var $fon_codigo;
    var $fon_cod;
    var $fon_descripcion;    
    var $fon_orden;
    var $fon_contador;
    var $fon_estado;

    function __construct() {
        parent::__construct();
    }

    function getFon_id() {
        return $this->fon_id;
    }

    function setFon_id($fon_id) {
        $this->fon_id = $fon_id;
    }

    function getFon_codigo() {
        return $this->fon_codigo;
    }

    function setFon_codigo($fon_codigo) {
        $this->fon_codigo = $fon_codigo;
    }
    
    function getFon_cod() {
        return $this->fon_cod;
    }

    function setFon_cod($fon_cod) {
        $this->fon_cod = $fon_cod;
    }

    function getFon_descripcion() {
        return $this->fon_descripcion;
    }

    function setFon_descripcion($fon_descripcion) {
        $this->fon_descripcion = $fon_descripcion;
    }

    function getFon_orden() {
        return $this->fon_orden;
    }

    function setFon_orden($fon_orden) {
        $this->fon_orden = $fon_orden;
    }


    function getFon_estado() {
        return $this->fon_estado;
    }

    function setFon_estado($fon_estado) {
        $this->fon_estado = $fon_estado;
    }

    function getFon_par() {
        return $this->fon_par;
    }

    function setFon_par($fon_par) {
        $this->fon_par = $fon_par;
    }
    
    function getFon_contador() {
        return $this->fon_contador;
    }

    function setFon_contador($fon_contador) {
        $this->fon_contador = $fon_contador;
    }    
    
}

?>