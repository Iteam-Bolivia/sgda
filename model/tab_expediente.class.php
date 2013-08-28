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
class Tab_expediente extends db {

    var $exp_id;
    var $ser_id;
    var $exp_codigo; 
    var $sof_id;    
    var $exp_nrofoj;
    var $exp_tomovol;    
    var $exp_nroejem;        
    var $exp_nrocaj;
    var $exp_sala;
    var $exp_estante;
    var $exp_cuerpo;
    var $exp_balda;
    var $exp_ori;
    var $exp_cop;
    var $exp_fot;
    var $exp_orin;
    var $exp_copn;
    var $exp_fotn;
    var $exp_obs;
    var $exp_estado;  
    

    function __construct() {
        parent::__construct();
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getSer_id() {
        return $this->ser_id;
    }

    function setSer_id($ser_id) {
        $this->ser_id = $ser_id;
    }

    function getExp_codigo() {
        return $this->exp_codigo;
    }

    function setExp_codigo($exp_codigo) {
        $this->exp_codigo = $exp_codigo;
    }    
        
    function getSof_id() {
        return $this->sof_id;
    }
    
    function setSof_id($sof_id) {
        $this->sof_id = $sof_id;
    }

    function getExp_nrofoj() {
        return $this->exp_nrofoj;
    }

    function setExp_nrofoj($exp_nrofoj) {
        $this->exp_nrofoj = $exp_nrofoj;
    }

    function getExp_tomovol() {
        return $this->exp_tomovol;
    }

    function setExp_tomovol($exp_tomovol) {
        $this->exp_tomovol = $exp_tomovol;
    }   
    
    function getExp_nroejem() {
        return $this->exp_nrojem;
    }

    function setExp_nroejem($exp_nroejem) {
        $this->exp_nroejem = $exp_nroejem;
    }

    function getExp_nrocaj() {
        return $this->exp_nrocaj;
    }

    function setExp_nrocaj($exp_nrocaj) {
        $this->exp_nrocaj = $exp_nrocaj;
    }

    function getExp_sala() {
        return $this->exp_sala;
    }

    function setExp_sala($exp_sala) {
        $this->exp_sala = $exp_sala;
    }
    
    function getExp_estante() {
        return $this->exp_estante;
    }

    function setExp_estante($exp_estante) {
        $this->exp_estante = $exp_estante;
    }
   
    function getExp_cuerpo() {
        return $this->exp_cuerpo;
    }

    function setExp_cuerpo($exp_cuerpo) {
        $this->exp_cuerpo = $exp_cuerpo;
    }

    function getExp_balda() {
        return $this->exp_balda;
    }

    function setExp_balda($exp_balda) {
        $this->exp_balda = $exp_balda;
    }
        
    function getExp_ori() {
        return $this->exp_ori;
    }
    function setExp_ori($exp_ori) {
        $this->exp_ori = $exp_ori;
    }    
    
    function getExp_cop() {
        return $this->exp_cop;
    }
    function setExp_cop($exp_cop) {
        $this->exp_cop = $exp_cop;
    }    
    
    function getExp_fot() {
        return $this->exp_fot;
    }
    function setExp_fot($exp_fot) {
        $this->exp_fot = $exp_fot;
    }    
    
    function getExp_obs() {
        return $this->exp_obs;
    }
    
    function setExp_obs($exp_obs) {
        $this->exp_obs = $exp_obs;
    } 
    
    function getExp_estado() {
        return $this->exp_estado;
    }

    function setExp_estado($exp_estado) {
        $this->exp_estado = $exp_estado;
    }
    
    
    
    
}

?>