<?php

/**
 * tab_digediente.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_digisadg extends db {
    var $dig_id;
    var $fil_id;
    var $dig_titulo;
    var $dig_fecha_exi;
    var $dig_fecha_exf;
    var $dig_fecha_crea;
    var $dig_nivdes;
    var $dig_volsop;
    var $dig_nomprod;
    var $dig_hisins;
    var $dig_hisarc;
    var $dig_foring;
    var $dig_alccon;
    var $dig_vaseel;
    var $dig_nueing;
    var $dig_org;
    var $dig_conacc;
    var $dig_conrep;
    var $dig_lengua;
    var $dig_carfis;
    var $dig_insdes;
    var $dig_exloor;
    var $dig_exloco;
    var $dig_underel;
    var $dig_notpub;
    var $dig_notas;
    var $dig_notarc;
    var $dig_regnor;
    var $dig_fecdes;
    var $dig_estado;
    
    function __construct() {
        parent::__construct();
    }

    function getEig_id() {
        return $this->dig_id;
    }

    function setEig_id($dig_id) {
        $this->dig_id = $dig_id;
    }
    
    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getDig_titulo() {
        return $this->dig_titulo;
    }

    function setDig_titulo($dig_titulo) {
        $this->dig_titulo = $dig_titulo;
    }

    function getDig_fecha_exi() {
        return $this->dig_fecha_exi;
    }

    function setDig_fecha_exi($dig_fecha_exi) {
        $this->dig_fecha_exi = $dig_fecha_exi;
    }

    function getDig_fecha_exf() {
        return $this->dig_fecha_exf;
    }

    function setDig_fecha_exf($dig_fecha_exf) {
        $this->dig_fecha_exf = $dig_fecha_exf;
    }

    function getDig_nivdes() {
        return $this->dig_nivdes;
    }
    function setDig_nivdes($dig_nivdes) {
        $this->dig_nivdes = $dig_nivdes;
    }    
    
    function getDig_volsop() {
        return $this->dig_volsop;
    }
    function setDig_volsop($dig_volsop) {
        $this->dig_volsop = $dig_volsop;
    }
    
    function getDig_nomprod() {
        return $this->dig_nomprod;
    }
    function setDig_nomprod($dig_nomprod) {
        $this->dig_nomprod = $dig_nomprod;
    }    
    
    function getDig_hisins() {
        return $this->dig_hisins;
    }
    function setDig_hisins($dig_hisins) {
        $this->dig_hisins = $dig_hisins;
    }    
    
    function getDig_hisarc() {
        return $this->dig_hisarc;
    }
    function setDig_hisarc($dig_hisarc) {
        $this->dig_hisarc = $dig_hisarc;
    }
    
    function getDig_foring() {
        return $this->dig_foring;
    }
    function setDig_foring($dig_foring) {
        $this->dig_foring = $dig_foring;
    } 
    
    function getDig_alccon() {
        return $this->dig_alccon;
    }
    function setDig_alccon($dig_alccon) {
        $this->dig_alccon = $dig_alccon;
    } 
    
    function getDig_vaseel() {
        return $this->dig_vaseel;
    }
    function setDig_vaseel($dig_vaseel) {
        $this->dig_vaseel = $dig_vaseel;
    }
    
    function getDig_nueing() {
        return $this->dig_nueing;
    }
    function setDig_nueing($dig_nueing) {
        $this->dig_nueing = $dig_nueing;
    }
    
    function getDig_org() {
        return $this->dig_org;
    }
    function setDig_org($dig_org) {
        $this->dig_org = $dig_org;
    }
    
    function getDig_conacc() {
        return $this->dig_conacc;
    }
    function setDig_conacc($dig_conacc) {
        $this->dig_conacc = $dig_conacc;
    }
    
    function getDig_conrep() {
        return $this->dig_conrep;
    }
    function setDig_conrep($dig_conrep) {
        $this->dig_conrep = $dig_conrep;
    }
    
    function getDig_lengua() {
        return $this->dig_lengua;
    }
    function setDig_lengua($dig_lengua) {
        $this->dig_lengua = $dig_lengua;
    }
    
    function getDig_carfis() {
        return $this->dig_carfis;
    }
    function setDig_carfis($dig_carfis) {
        $this->dig_carfis = $dig_carfis;
    }
    
    function getDig_insdes() {
        return $this->dig_insdes;
    }
    function setDig_insdes($dig_insdes) {
        $this->dig_insdes = $dig_insdes;
    }
    
    function getDig_exloor() {
        return $this->dig_exloor;
    }
    function setDig_exloor($dig_exloor) {
        $this->dig_exloor = $dig_exloor;
    }
    
    function getDig_exloco() {
        return $this->dig_exloco;
    }
    function setDig_exloco($dig_exloco) {
        $this->dig_exloco = $dig_exloco;
    }
    
    function getDig_underel() {
        return $this->dig_underel;
    }
    function setDig_underel($dig_underel) {
        $this->dig_underel = $dig_underel;
    }
    
    function getDig_notpub() {
        return $this->dig_notpub;
    }
    function setDig_notpub($dig_notpub) {
        $this->dig_notpub = $dig_notpub;
    }   
    
    function getDig_notas() {
        return $this->dig_notas;
    }
    function setDig_notas($dig_notas) {
        $this->dig_notas = $dig_notas;
    }   
    
    function getDig_notarc() {
        return $this->dig_notarc;
    }
    function setDig_notarc($dig_notarc) {
        $this->dig_notarc = $dig_notarc;
    }  
        
    function getDig_regnor() {
        return $this->dig_regnor;
    }
    function setDig_regnor($dig_regnor) {
        $this->dig_regnor = $dig_regnor;
    } 
    
    function getDig_fecdes() {
        return $this->dig_fecdes;
    }
    function setDig_fecdes($dig_fecdes) {
        $this->dig_fecdes = $dig_fecdes;
    }
    
    function getDig_estado() {
        return $this->dig_estado;
    }

    function setDig_estado($dig_estado) {
        $this->dig_estado = $dig_estado;
    }
    
}

?>