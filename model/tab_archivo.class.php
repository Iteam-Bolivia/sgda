<?php

/**
 * tab_archivo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_archivo extends db {

    var $fil_id;
    var $fil_codigo;
    var $fil_nro;
    var $fil_titulo;
    var $fil_subtitulo;
    var $fil_fecha;
    var $fil_mes;
    var $fil_anio;
    var $idi_id;
    var $fil_proc;
    var $fil_firma;
    var $fil_cargo;    
    var $sof_id;
    var $fil_nrofoj;
    var $fil_tomovol;
    var $fil_nroejem;    
    var $fil_nrocaj;
    var $fil_sala;
    var $fil_estante;
    var $fil_cuerpo;
    var $fil_tipoarch;
    var $fil_mrb;
    var $fil_ori;
    var $fil_cop;
    var $fil_fot;
    var $fil_orin;
    var $fil_copn;
    var $fil_fotn;
    var $fil_confidencialidad;
    var $fil_obs;
    var $fil_estado;
        
    function __construct() {
        parent::__construct();
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }
    
    function getFil_nro() {
        return $this->fil_nro;
    }

    function setFil_nro($fil_nro) {
        $this->fil_nro = $fil_nro;
    }
    
    function getFil_titulo() {
        return $this->fil_titulo;
    }

    function setFil_titulo($fil_titulo) {
        $this->fil_titulo = $fil_titulo;
    }
    
    function getFil_subtitulo() {
        return $this->fil_subtitulo;
    }

    function setFil_subtitulo($fil_subtitulo) {
        $this->fil_subtitulo = $fil_subtitulo;
    }
        
    function getFil_fecha() {
        return $this->fil_fecha;
    }

    function setFil_fecha($fil_fecha) {
        $this->fil_fecha = $fil_fecha;
    }    
    
    function getFil_mes() {
        return $this->fil_mes;
    }

    function setFil_mes($fil_mes) {
        $this->fil_mes = $fil_mes;
    } 
    
    function getFil_anio() {
        return $this->fil_anio;
    }

    function setFil_anio($fil_anio) {
        $this->fil_anio = $fil_anio;
    } 
    
    function getIdi_id() {
        return $this->idi_id;
    }

    function setIdi_id($idi_id) {
        $this->idi_id = $idi_id;
    }
    
    function getFil_proc() {
        return $this->fil_proc;
    }

    function setFil_proc($fil_proc) {
        $this->fil_proc = $fil_proc;
    }     
    
    function getFil_firma() {
        return $this->fil_firma;
    }

    function setFil_firma($fil_firma) {
        $this->fil_firma = $fil_firma;
    }     
    
    function getFil_cargo() {
        return $this->fil_cargo;
    }

    function setFil_cargo($fil_cargo) {
        $this->fil_cargo = $fil_cargo;
    }    
    
    function getSof_id() {
        return $this->sof_id;
    }

    function setSof_id($sof_id) {
        $this->sof_id = $sof_id;
    }    
    
    function getFil_nrofoj() {
        return $this->fil_nrofoj;
    }

    function setFil_nrofoj($fil_nrofoj) {
        $this->fil_nrofoj = $fil_nrofoj;
    }    
    
    function getFil_tomovol() {
        return $this->fil_tomovol;
    }

    function setFil_tomovol($fil_tomovol) {
        $this->fil_tomovol = $fil_tomovol;
    }     
    
    function getFil_nroejem() {
        return $this->fil_nroejem;
    }

    function setFil_nroejem($fil_nroejem) {
        $this->fil_nroejem = $fil_nroejem;
    }         
    
    function getFil_nrocaj() {
        return $this->fil_nrocaj;
    }

    function setFil_nrocaj($fil_nrocaj) {
        $this->fil_nrocaj = $fil_nrocaj;
    }    
    
    function getFil_sala() {
        return $this->fil_sala;
    }

    function setFil_sala($fil_sala) {
        $this->fil_sala = $fil_sala;
    }    
    
    function getFil_estante() {
        return $this->fil_estante;
    }

    function setFil_estante($fil_estante) {
        $this->fil_estante = $fil_estante;
    }  
    
    function getFil_cuerpo() {
        return $this->fil_cuerpo;
    }

    function setFil_cuerpo($fil_cuerpo) {
        $this->fil_cuerpo = $fil_cuerpo;
    }     
    
    function getFil_balda() {
        return $this->fil_balda;
    }

    function setFil_balda($fil_balda) {
        $this->fil_balda = $fil_balda;
    }  
    
    function getFil_tipoarch() {
        return $this->fil_tipoarch;
    }

    function setFil_tipoarch($fil_tipoarch) {
        $this->fil_tipoarch = $fil_tipoarch;
    }
    
    function getFil_mrb() {
        return $this->fil_mrb;
    }
    function setFil_mrb($fil_mrb) {
        $this->fil_mrb = $fil_mrb;
    }
 
    function getFil_ori() {
        return $this->fil_ori;
    }
    function setFil_ori($fil_ori) {
        $this->fil_ori = $fil_ori;
    }    
    
    function getFil_cop() {
        return $this->fil_cop;
    }
    function setFil_cop($fil_cop) {
        $this->fil_cop = $fil_cop;
    }
    
    function getFil_fot() {
        return $this->fil_fot;
    }
    function setFil_fot($fil_fot) {
        $this->fil_fot = $fil_fot;
    }    
        
    function getFil_confidencialidad() {
        return $this->fil_confidencialidad;
    }
    function setFil_confidencialidad($fil_confidencialidad) {
        $this->fil_confidencialidad = $fil_confidencialidad;
    }  
    
    function getFil_obs() {
        return $this->fil_obs;
    }
    function setFil_obs($fil_obs) {
        $this->fil_obs = $fil_obs;
    }    
    
    function getFil_estado() {
        return $this->fil_estado;
    }
    function setFil_estado($fil_estado) {
        $this->fil_estado = $fil_estado;
    }    
    
    
}

?>