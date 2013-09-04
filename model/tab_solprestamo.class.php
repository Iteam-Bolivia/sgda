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
class Tab_solprestamo extends db {

    var $spr_id;
    var $spr_tipo;
    var $spr_fecha;
    var $uni_id;
    var $usu_id;
    var $usur_id; 
    var $usua_id;
    var $spr_docsolen;
    var $int_id;
    var $spr_solicitante;
    var $spr_email;
    var $spr_tel;
    var $unid_id;
    var $spr_fecdev;
    var $spr_fecren;
    var $spr_fecent;
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
        function getSpr_fecdev() {
        return $this->spr_fecdev;
    }

    function setSpr_fecdev($spr_fecdev) {
        $this->spr_fecdev = $spr_fecdev;
    }
    

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }
        function getUsu_id() {
        return $this->$usu_id;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

       function getUsua_id() {
        return $this->usua_id;
    }

    function setUsua_id($usua_id) {
        $this->usua_id = $usua_id;
    }
           function getUsur_id() {
        return $this->usur_id;
    }

    function setUsur_id($usur_id) {
        $this->usur_id = $usur_id;
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

    function getSpr_fecent() {
        return $this->spr_fecent;
    }

    function setSpr_fecent($spr_fecent) {
        $this->spr_fecent = $spr_fecent;
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