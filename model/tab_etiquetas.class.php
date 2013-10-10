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
class Tab_etiquetas extends db {

    var $eti_id;
    var $ete_id;
    var $exp_id;
    var $usu_id;
    var $suc_id;
    var $ete_usu_crea;
    var $ete_fecha_crea;
    var $ete_estado;

    function __construct() {
        parent::__construct();
    }

    function getEti_id() {
        return $this->eti_id;
    }

    function setEti_id($eti_id) {
        $this->eti_id = $eti_id;
    }

    function getEte_id() {
        return $this->ete_id;
    }

    function setEte_id($ete_id) {
        $this->ete_id = $ete_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getUsu_id() {
        return $this->usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function getSuc_id() {
        return $this->suc_id;
    }

    function setSuc_id($suc_id) {
        $this->suc_id = $suc_id;
    }

    function getEte_usu_crea() {
        return $this->ete_usu_crea;
    }

    function setEte_usu_crea($ete_usu_crea) {
        $this->ete_usu_crea = $ete_usu_crea;
    }

    function getEte_fecha_crea() {
        return $this->ete_fecha_crea;
    }

    function setEte_fecha_crea($ete_fecha_crea) {
        $this->ete_fecha_crea = $ete_fecha_crea;
    }

    function getEte_estado() {
        return $this->ete_estado;
    }

    function setEte_estado($ete_estado) {
        $this->ete_estado = $ete_estado;
    }

}

?>