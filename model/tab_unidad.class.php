<?php

/**
 * tab_unidad.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_unidad extends db {

    var $uni_id;
    var $niv_id;
    var $ver_id;
    var $ubi_id;
    var $uni_piso;
    var $uni_par;
    var $uni_codigo;
    var $uni_descripcion;
    var $uni_ml;
    var $uni_estado;
    var $ins_id;
    var $fon_id;
    var $unif_id;
    var $uni_contador;
    var $uni_cod;    
    var $uni_tel;
    
    
    // New
    var $ofi_id;
    var $tar_id;
    var $uni_parcont;

    function __construct() {
        parent::__construct();
    }

    function getUni_id() {
        return $this->uni_id;
    }

    function setUni_id($uni_id) {
        $this->uni_id = $uni_id;
    }

    function getNiv_id() {
        return $this->niv_id;
    }

    function setNiv_id($niv_id) {
        $this->niv_id = $niv_id;
    }

    function getVer_id() {
        return $this->ver_id;
    }

    function setVer_id($ver_id) {
        $this->ver_id = $ver_id;
    }

    function getUbi_id() {
        return $this->ubi_id;
    }

    function setUbi_id($ubi_id) {
        $this->ubi_id = $ubi_id;
    }

    function getUni_piso() {
        return $this->uni_piso;
    }

    function setUni_piso($uni_piso) {
        $this->uni_piso = $uni_piso;
    }

    function getUni_par() {
        return $this->uni_par;
    }

    function setUni_par($uni_par) {
        $this->uni_par = $uni_par;
    }

    function getUni_codigo() {
        return $this->uni_codigo;
    }

    function setUni_codigo($uni_codigo) {
        $this->uni_codigo = $uni_codigo;
    }

    function getUni_descripcion() {
        return $this->uni_descripcion;
    }

    function setUni_descripcion($uni_descripcion) {
        $this->uni_descripcion = $uni_descripcion;
    }

    function getUni_ml() {
        return $this->uni_ml;
    }

    function setUni_ml($uni_ml) {
        $this->uni_ml = $uni_ml;
    }

    function getUni_estado() {
        return $this->uni_estado;
    }

    function setUni_estado($uni_estado) {
        $this->uni_estado = $uni_estado;
    }

    function getIns_id() {
        return $this->ins_id;
    }

    function setIns_id($ins_id) {
        $this->ins_id = $ins_id;
    }

    function getFon_id() {
        return $this->fon_id;
    }

    function setFon_id($fon_id) {
        $this->fon_id = $fon_id;
    }

    function getUnif_id() {
        return $this->unif_id;
    }

    function setUnif_id($unif_id) {
        $this->unif_id = $unif_id;
    }
    
    function getUni_contador() {
        return $this->uni_contador;
    }
    function setUni_contador($uni_contador) {
        $this->uni_contador = $uni_contador;
    }

    function getUni_tel() {
        return $this->uni_tel;
    }

    function setUni_tel($uni_tel) {
        $this->uni_tel = $uni_tel;
    }
    
    // New
    function getOfi_id() {
        return $this->ofi_id;
    }

    function setOfi_id($ofi_id) {
        $this->ofi_id = $ofi_id;
    }    
    
    function getTar_id() {
        return $this->tar_id;
    }

    function setTar_id($tar_id) {
        $this->tar_id = $tar_id;
    }      
    
    
    function getUni_parcont() {
        return $this->uni_parcont;
    }

    function setUni_parcont($uni_parcont) {
        $this->uni_parcont = $uni_parcont;
    }    
    
    function getUni_cod() {
        return $this->uni_cod;
    }

    function setUni_cod($uni_cod) {
        $this->uni_cod = $uni_cod;
    }     
    
    
}

?>