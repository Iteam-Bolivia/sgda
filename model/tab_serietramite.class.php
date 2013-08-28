<?php

/**
 * tab_serietramite.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_serietramite extends db {

    var $sts_id;
    var $ser_id;
    var $tra_id;
    var $sts_fecha_crea;
    var $sts_usuario_crea;
    var $ver_id;
    var $sts_fecha_reg;
    var $sts_usu_reg;
    var $sts_estado;

    function __construct() {
        parent::__construct();
    }

    function getSts_id() {
        return $this->sts_id;
    }

    function setSts_id($sts_id) {
        $this->sts_id = $sts_id;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getTra_id() {
        return $this->tra_id;
    }

    function setTra_id($tra_id) {
        $this->tra_id = $tra_id;
    }

    function getSts_fecha_crea() {
        return $this->sts_fecha_crea;
    }

    function setSts_fecha_crea($sts_fecha_crea) {
        $this->sts_fecha_crea = $sts_fecha_crea;
    }

    function getSts_usuario_crea() {
        return $this->sts_usuario_crea;
    }

    function setSts_usuario_crea($sts_usuario_crea) {
        $this->sts_usuario_crea = $sts_usuario_crea;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getSts_fecha_reg() {
        return $this->sts_fecha_reg;
    }

    function setSts_fecha_reg($sts_fecha_reg) {
        $this->sts_fecha_reg = $sts_fecha_reg;
    }

    function getSts_usu_reg() {
        return $this->sts_usu_reg;
    }

    function setSts_usu_reg($sts_usu_reg) {
        $this->sts_usu_reg = $sts_usu_reg;
    }

    function getSts_estado() {
        return $this->sts_estado;
    }

    function setSts_estado($sts_estado) {
        $this->sts_estado = $sts_estado;
    }

}

?>