<?php

/**
 * Tab_expfondo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expfondo extends db {

    var $exf_id;
    var $exp_id;
    var $fon_id;
    var $exf_fecha_crea;
    var $exf_usu_crea;
    var $exf_estado;
    var $exf_fecha_exi;
    var $exf_fecha_exf;

    function __construct() {
        parent::__construct();
    }

    function getExf_id() {
        return $this->exf_id;
    }

    function setExf_id($exf_id) {
        $this->exf_id = $exf_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getFon_id() {
        return $this->fon_id;
    }

    function setFon_id($fon_id) {
        $this->fon_id = $fon_id;
    }

    function getExf_fecha_crea() {
        return $this->exf_fecha_crea;
    }

    function setExf_fecha_crea($exf_fecha_crea) {
        $this->exf_fecha_crea = $exf_fecha_crea;
    }

    function getExf_usu_crea() {
        return $this->exf_usu_crea;
    }

    function setExf_usu_crea($exf_usu_crea) {
        $this->exf_usu_crea = $exf_usu_crea;
    }

    function getExf_estado() {
        return $this->exf_estado;
    }

    function setExf_estado($exf_estado) {
        $this->exf_estado = $exf_estado;
    }

    function getExf_fecha_exi() {
        return $this->exf_fecha_exi;
    }

    function setExf_fecha_exi($exf_fecha_exi) {
        $this->exf_fecha_exi = $exf_fecha_exi;
    }

    function getExf_fecha_exf() {
        return $this->exf_fecha_exf;
    }

    function setExf_fecha_exf($exf_fecha_exf) {
        $this->exf_fecha_exf = $exf_fecha_exf;
    }

}

?>