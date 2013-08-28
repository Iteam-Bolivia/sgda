<?php

/**
 * tab_docprevencion.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_docprevencion extends db {

    var $dpr_id;
    var $dpr_tipo;
    var $uni_id;
    var $dpr_fecha_revision;
    var $dpr_productor;
    var $dpr_cargo_productor;
    var $dpr_fecha_crea;
    var $dpr_usu_crea;
    var $dpr_fecha_mod;
    var $dpr_usu_mod;
    var $dpr_estado;

    function __construct() {
        parent::__construct();
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }

    function getDpr_tipo() {
        return $this->dpr_tipo;
    }

    function setDpr_tipo($dpr_tipo) {
        $this->dpr_tipo = $dpr_tipo;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getDpr_fecha_revision() {
        return $this->dpr_fecha_revision;
    }

    function setDpr_fecha_revision($dpr_fecha_revision) {
        $this->dpr_fecha_revision = $dpr_fecha_revision;
    }

    function getDpr_productor() {
        return $this->dpr_productor;
    }

    function setDpr_productor($dpr_productor) {
        $this->dpr_productor = $dpr_productor;
    }

    function getDpr_cargo_productor() {
        return $this->dpr_cargo_productor;
    }

    function setDpr_cargo_productor($dpr_cargo_productor) {
        $this->dpr_cargo_productor = $dpr_cargo_productor;
    }

    function getDpr_fecha_crea() {
        return $this->dpr_fecha_crea;
    }

    function setDpr_fecha_crea($dpr_fecha_crea) {
        $this->dpr_fecha_crea = $dpr_fecha_crea;
    }

    function getDpr_usu_crea() {
        return $this->dpr_usu_crea;
    }

    function setDpr_usu_crea($dpr_usu_crea) {
        $this->dpr_usu_crea = $dpr_usu_crea;
    }

    function getDpr_fecha_mod() {
        return $this->dpr_fecha_mod;
    }

    function setDpr_fecha_mod($dpr_fecha_mod) {
        $this->dpr_fecha_mod = $dpr_fecha_mod;
    }

    function getDpr_usu_mod() {
        return $this->dpr_usu_mod;
    }

    function setDpr_usu_mod($dpr_usu_mod) {
        $this->dpr_usu_mod = $dpr_usu_mod;
    }

    function getDpr_estado() {
        return $this->dpr_estado;
    }

    function setDpr_estado($dpr_estado) {
        $this->dpr_estado = $dpr_estado;
    }

}

?>