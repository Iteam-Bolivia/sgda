<?php

/**
 * tab_importacion.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_importacion extends db {

    var $imp_id;
    var $usu_id;
    var $imp_num_up;
    var $imp_num_new;
    var $imp_num_error;
    var $imp_descripcion;
    var $imp_fecha;

    function __construct() {
        parent::__construct();
    }

    function getImp_id() {
        return $this->imp_id;
    }

    function setImp_id($imp_id) {
        $this->imp_id = $imp_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getImp_num_up() {
        return $this->imp_num_up;
    }

    function setImp_num_up($Imp_num_up) {
        $this->imp_num_up = $Imp_num_up;
    }

    function getImp_num_new() {
        return $this->imp_num_new;
    }

    function setImp_num_new($Imp_num_new) {
        $this->imp_num_new = $Imp_num_new;
    }

    function getImp_num_error() {
        return $this->imp_num_error;
    }

    function setImp_num_error($Imp_num_error) {
        $this->imp_num_error = $Imp_num_error;
    }

    function getImp_descripcion() {
        return $this->imp_descripcion;
    }

    function setImp_descripcion($Imp_descripcion) {
        $this->imp_descripcion = $Imp_descripcion;
    }

    function getImp_fecha() {
        return $this->imp_fecha;
    }

    function setImp_fecha($Imp_fecha) {
        $this->imp_fecha = $Imp_fecha;
    }

}

?>