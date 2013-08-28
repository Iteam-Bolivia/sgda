<?php

/**
 * tab_subcontenedor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_subcontenedor extends db {

    var $suc_id;
    var $con_id;
    var $suc_ml;
    var $suc_nro_balda;
    var $suc_fecha_exi_min;
    var $suc_fecha_exf_max;
    var $suc_usu_reg;
    var $suc_fecha_reg;
    var $suc_estado;
    var $suc_codigo;

    function __construct() {
        parent::__construct();
    }

    function getSuc_id() {
        return $this->suc_id;
    }

    function setSuc_id($suc_id) {
        $this->suc_id = $suc_id;
    }

    function getCon_id() {
        return $this->con_id;
    }

    function setCon_id($con_id) {
        $this->con_id = $con_id;
    }

    function getSuc_ml() {
        return $this->suc_ml;
    }

    function setSuc_ml($suc_ml) {
        $this->suc_ml = $suc_ml;
    }

    function getSuc_nro_balda() {
        return $this->suc_nro_balda;
    }

    function setSuc_nro_balda($suc_nro_balda) {
        $this->suc_nro_balda = $suc_nro_balda;
    }

    function getSuc_fecha_exi_min() {
        return $this->suc_fecha_exi_min;
    }

    function setSuc_fecha_exi_min($suc_fecha_exi_min) {
        $this->suc_fecha_exi_min = $suc_fecha_exi_min;
    }

    function getSuc_fecha_exf_max() {
        return $this->suc_fecha_exf_max;
    }

    function setSuc_fecha_exf_max($suc_fecha_exf_max) {
        $this->suc_fecha_exf_max = $suc_fecha_exf_max;
    }

    function getSuc_usu_reg() {
        return $this->suc_usu_reg;
    }

    function setSuc_usu_reg($suc_usu_reg) {
        $this->suc_usu_reg = $suc_usu_reg;
    }

    function getSuc_fecha_reg() {
        return $this->suc_fecha_reg;
    }

    function setSuc_fecha_reg($suc_fecha_reg) {
        $this->suc_fecha_reg = $suc_fecha_reg;
    }

    function getSuc_estado() {
        return $this->suc_estado;
    }

    function setSuc_estado($suc_estado) {
        $this->suc_estado = $suc_estado;
    }

    function getSuc_codigo() {
        return $this->suc_codigo;
    }

    function setSuc_codigo($suc_codigo) {
        $this->suc_codigo = $suc_codigo;
    }

}

?>