<?php

/**
 * tab_solicitud_prestamo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_solicitud_prestamo extends db {

    var $spr_id;
    var $spr_tipo;
    var $spr_fecha;
    var $uni_id;
    var $spr_docsolen;
    var $int_id;
    var $spr_solicitante;
    var $spr_email;
    var $spr_tel;
    var $unid_id;
    var $spr_fecini;
    var $spr_fecfin;
    var $spr_fecren;
    var $spr_obs;
    var $spr_estado;

    function __construct() {
        parent::__construct();
    }

    function getSpr_id() {
        return $this->spr_id;
    }

    function setSpr_id($spr_id) {
        $this->spr_id = $spr_id;
    }

    function getSpr_tipo() {
        return $this->spr_tipo;
    }

    function setSpr_tipo($spr_tipo) {
        $this->spr_tipo = $spr_tipo;
    }

    function getSpr_fecha() {
        return $this->spr_fecha;
    }

    function setSpr_fecha($spr_fecha) {
        $this->spr_fecha = $spr_fecha;
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getSpr_docsolen() {
        return $this->spr_docsolen;
    }

    function setSpr_docsolen($spr_docsolen) {
        $this->spr_docsolen = $spr_docsolen;
    }

    function getInt_id() {
        return $this->int_id;
    }

    function setInt_id($int_id) {
        $this->int_id = $int_id;
    }

    function getSpr_solicitante() {
        return $this->spr_solicitante;
    }

    function setSpr_solicitante($spr_solicitante) {
        $this->spr_solicitante = $spr_solicitante;
    }

    function getSpr_email() {
        return $this->spr_email;
    }

    function setSpr_email($spr_email) {
        $this->spr_email = $spr_email;
    }

    function getSpr_tel() {
        return $this->spr_tel;
    }

    function setSpr_tel($spr_tel) {
        $this->spr_tel = $spr_tel;
    }

    function getUnid_id() {
        return $this->unid_id;
    }

    function setUnid_id($unid_id) {
        $this->unid_id = $unid_id;
    }

    function getSpr_fecini() {
        return $this->spr_fecini;
    }

    function setSpr_fecini($spr_fecini) {
        $this->spr_fecini = $spr_fecini;
    }

    function getSpr_fecfin() {
        return $this->spr_fecfin;
    }

    function setSpr_fecfin($fec_fin) {
        $this->fec_fin = $fec_fin;
    }

    function getSpr_fecren() {
        return $this->spr_fecren;
    }

    function setSpr_fecren($spr_fecren) {
        $this->spr_fecren = $spr_fecren;
    }

    function getSpr_obs() {
        return $this->spr_obs;
    }

    function setSpr_obs($spr_obs) {
        $this->spr_obs = $spr_obs;
    }

    function getSpr_estado() {
        return $this->spr_estado;
    }

    function setSpr_estado($spr_estado) {
        $this->spr_estado = $spr_estado;
    }

}

?>