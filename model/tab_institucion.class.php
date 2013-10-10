<?php

/**
 * Tab_institucion.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_institucion extends db {

    var $int_id;
    var $int_descripcion;
    var $int_fecha_crea;
    var $int_usu_crea;
    var $int_estado;

    function __construct() {
        parent::__construct();
    }

    function getInt_id() {
        return $this->int_id;
    }

    function setInt_id($int_id) {
        $this->int_id = $int_id;
    }

    function getInt_descripcion() {
        return $this->int_descripcion;
    }

    function setInt_descripcion($int_descripcion) {
        $this->int_descripcion = $int_descripcion;
    }

    function getInt_fecha_crea() {
        return $this->int_fecha_crea;
    }

    function setInt_fecha_crea($int_fecha_crea) {
        $this->int_fecha_crea = $int_fecha_crea;
    }

    function getInt_usu_crea() {
        return $this->int_usu_crea;
    }

    function setInt_usu_crea($int_usu_crea) {
        $this->int_usu_crea = $int_usu_crea;
    }

    function getInt_estado() {
        return $this->int_estado;
    }

    function setInt_estado($int_estado) {
        $this->int_estado = $int_estado;
    }

}

?>
