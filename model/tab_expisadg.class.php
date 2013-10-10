<?php

/**
 * tab_expediente.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_expisadg extends db {
    var $eig_id;
    var $exp_id;
    var $exp_titulo;
    var $exp_fecha_exi;
    var $exp_mesi;
    var $exp_anioi;
    var $exp_fecha_exf;
    var $exp_mesf;
    var $exp_aniof;
    var $exp_fecha_crea;
    var $exp_nivdes;
    var $exp_volsop;
    var $exp_nomprod;
    var $exp_hisins;
    var $exp_hisarc;
    var $exp_foring;
    var $exp_alccon;
    var $exp_vaseel;
    var $exp_nueing;
    var $exp_org;
    var $exp_conacc;
    var $exp_conrep;
    var $idi_id;
    var $exp_lengua;
    var $exp_carfis;
    var $exp_insdes;
    var $exp_exloor;
    var $exp_exloco;
    var $exp_underel;
    var $exp_notpub;
    var $exp_notas;
    var $exp_notarc;
    var $exp_regnor;
    var $exp_fecdes;
    var $exp_estado;
    
    function __construct() {
        parent::__construct();
    }

    function getEig_id() {
        return $this->eig_id;
    }

    function setEig_id($eig_id) {
        $this->eig_id = $eig_id;
    }
    
    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getExp_titulo() {
        return $this->exp_titulo;
    }

    function setExp_titulo($exp_titulo) {
        $this->exp_titulo = $exp_titulo;
    }

    function getExp_fecha_exi() {
        return $this->exp_fecha_exi;
    }

    function setExp_fecha_exi($exp_fecha_exi) {
        $this->exp_fecha_exi = $exp_fecha_exi;
    }

    function getExp_mesi() {
        return $this->exp_mesi;
    }

    function setExp_mesi($exp_mesi) {
        $this->exp_mesi = $exp_mesi;
    }
    
    function getExp_anioi() {
        return $this->exp_anioi;
    }

    function setExp_anioi($exp_anioi) {
        $this->exp_anioi = $exp_anioi;
    }
    
    function getExp_fecha_exf() {
        return $this->exp_fecha_exf;
    }

    function setExp_fecha_exf($exp_fecha_exf) {
        $this->exp_fecha_exf = $exp_fecha_exf;
    }

    function getExp_mesf() {
        return $this->exp_mesf;
    }

    function setExp_mesf($exp_mesf) {
        $this->exp_mesf = $exp_mesf;
    }
    
    function getExp_aniof() {
        return $this->exp_aniof;
    }

    function setExp_aniof($exp_aniof) {
        $this->exp_aniof = $exp_aniof;
    }    
    
    function getExp_nivdes() {
        return $this->exp_nivdes;
    }
    function setExp_nivdes($exp_nivdes) {
        $this->exp_nivdes = $exp_nivdes;
    }    
    
    function getExp_volsop() {
        return $this->exp_volsop;
    }
    function setExp_volsop($exp_volsop) {
        $this->exp_volsop = $exp_volsop;
    }
    
    function getExp_nomprod() {
        return $this->exp_nomprod;
    }
    function setExp_nomprod($exp_nomprod) {
        $this->exp_nomprod = $exp_nomprod;
    }    
    
    function getExp_hisins() {
        return $this->exp_hisins;
    }
    function setExp_hisins($exp_hisins) {
        $this->exp_hisins = $exp_hisins;
    }    
    
    function getExp_hisarc() {
        return $this->exp_hisarc;
    }
    function setExp_hisarc($exp_hisarc) {
        $this->exp_hisarc = $exp_hisarc;
    }
    
    function getExp_foring() {
        return $this->exp_foring;
    }
    function setExp_foring($exp_foring) {
        $this->exp_foring = $exp_foring;
    } 
    
    function getExp_alccon() {
        return $this->exp_alccon;
    }
    function setExp_alccon($exp_alccon) {
        $this->exp_alccon = $exp_alccon;
    } 
    
    function getExp_vaseel() {
        return $this->exp_vaseel;
    }
    function setExp_vaseel($exp_vaseel) {
        $this->exp_vaseel = $exp_vaseel;
    }
    
    function getExp_nueing() {
        return $this->exp_nueing;
    }
    function setExp_nueing($exp_nueing) {
        $this->exp_nueing = $exp_nueing;
    }
    
    function getExp_org() {
        return $this->exp_org;
    }
    function setExp_org($exp_org) {
        $this->exp_org = $exp_org;
    }
    
    function getExp_conacc() {
        return $this->exp_conacc;
    }
    function setExp_conacc($exp_conacc) {
        $this->exp_conacc = $exp_conacc;
    }
    
    function getExp_conrep() {
        return $this->exp_conrep;
    }
    function setExp_conrep($exp_conrep) {
        $this->exp_conrep = $exp_conrep;
    }
    
    function getExp_lengua() {
        return $this->exp_lengua;
    }
    function setExp_lengua($exp_lengua) {
        $this->exp_lengua = $exp_lengua;
    }
    
    function getIdi_Id() {
        return $this->idi_id;
    }
    function setIdi_id($idi_id) {
        $this->idi_id = $idi_id;
    }
    
    function getExp_carfis() {
        return $this->exp_carfis;
    }
    function setExp_carfis($exp_carfis) {
        $this->exp_carfis = $exp_carfis;
    }
    
    function getExp_insdes() {
        return $this->exp_insdes;
    }
    function setExp_insdes($exp_insdes) {
        $this->exp_insdes = $exp_insdes;
    }
    
    function getExp_exloor() {
        return $this->exp_exloor;
    }
    function setExp_exloor($exp_exloor) {
        $this->exp_exloor = $exp_exloor;
    }
    
    function getExp_exloco() {
        return $this->exp_exloco;
    }
    function setExp_exloco($exp_exloco) {
        $this->exp_exloco = $exp_exloco;
    }
    
    function getExp_underel() {
        return $this->exp_underel;
    }
    function setExp_underel($exp_underel) {
        $this->exp_underel = $exp_underel;
    }
    
    function getExp_notpub() {
        return $this->exp_notpub;
    }
    function setExp_notpub($exp_notpub) {
        $this->exp_notpub = $exp_notpub;
    }   
    
    function getExp_notas() {
        return $this->exp_notas;
    }
    function setExp_notas($exp_notas) {
        $this->exp_notas = $exp_notas;
    }   
    
    function getExp_notarc() {
        return $this->exp_notarc;
    }
    function setExp_notarc($exp_notarc) {
        $this->exp_notarc = $exp_notarc;
    }  
        
    function getExp_regnor() {
        return $this->exp_regnor;
    }
    function setExp_regnor($exp_regnor) {
        $this->exp_regnor = $exp_regnor;
    } 
    
    function getExp_fecdes() {
        return $this->exp_fecdes;
    }
    function setExp_fecdes($exp_fecdes) {
        $this->exp_fecdes = $exp_fecdes;
    }
    
    function getExp_estado() {
        return $this->exp_estado;
    }

    function setExp_estado($exp_estado) {
        $this->exp_estado = $exp_estado;
    }
    
}

?>