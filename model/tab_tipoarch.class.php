<?php

/**
 * tab_tipoarch.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_tipoarch extends db {

    var $tar_id;
    var $tar_codigo;
    var $tar_nombre;
    var $tar_orden;
    var $tar_estado;

    function __construct() {
        parent::__construct();
    }

    function getTar_id() {
        return $this->tar_id;
    }

    function setTar_id($tar_id) {
        $this->tar_id = $tar_id;
    }

    function getTar_codigo() {
        return $this->tar_codigo;
    }

    function setTar_codigo($tar_codigo) {
        $this->tar_codigo = $tar_codigo;
    }

    function getTar_nombre() {
        return $this->tar_nombre;
    }

    function setTar_nombre($tar_nombre) {
        $this->tar_nombre = $tar_nombre;
    }
    
    function getTar_orden() {
        return $this->tar_orden;
    }

    function setTar_orden($tar_orden) {
        $this->tar_orden = $tar_orden;
    }

    function getTar_estado() {
        return $this->tar_estado;
    }

    function setTar_estado($tar_estado) {
        $this->tar_estado = $tar_estado;
    }

}

?>