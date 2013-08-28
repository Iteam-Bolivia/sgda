<?php

/**
 * tab_riesgos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_riesgos extends db {

    var $rie_id;
    var $rie_descripcion;
    var $rie_tipo;
    var $rie_usu_reg;
    var $rie_usu_mod;
    var $rie_fecha_reg;
    var $rie_fecha_mod;
    var $rie_estado;

    function __construct() {
        parent::__construct();
    }

    function getRie_id() {
        return $this->rie_id;
    }

    function setRie_id($rie_id) {
        $this->rie_id = $rie_id;
    }

    function getRie_descripcion() {
        return $this->rie_descripcion;
    }

    function setRie_descripcion($rie_descripcion) {
        $this->rie_descripcion = $rie_descripcion;
    }

    function getRie_tipo() {
        return $this->rie_tipo;
    }

    function setRie_tipo($rie_tipo) {
        $this->rie_tipo = $rie_tipo;
    }

    function getRie_usu_reg() {
        return $this->rie_usu_reg;
    }

    function setRie_usu_reg($rie_usu_reg) {
        $this->rie_usu_reg = $rie_usu_reg;
    }

    function getRie_usu_mod() {
        return $this->rie_usu_mod;
    }

    function setRie_usu_mod($rie_usu_mod) {
        $this->rie_usu_mod = $rie_usu_mod;
    }

    function getRie_fecha_reg() {
        return $this->rie_fecha_reg;
    }

    function setRie_fecha_reg($rie_fecha_reg) {
        $this->rie_fecha_reg = $rie_fecha_reg;
    }

    function getRie_fecha_mod() {
        return $this->rie_fecha_mod;
    }

    function setRie_fecha_mod($rie_fecha_mod) {
        $this->rie_fecha_mod = $rie_fecha_mod;
    }

    function getRie_estado() {
        return $this->rie_estado;
    }

    function setRie_estado($rie_estado) {
        $this->rie_estado = $rie_estado;
    }

}

?>