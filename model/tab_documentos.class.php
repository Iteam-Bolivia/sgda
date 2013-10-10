<?php

/**
 * tab_documentos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

// Hereda Clase de conexion Mysql
class Tab_documentos extends db2 {
    var $codigo;
    var $cite_original;
    var $destinatario_titulo;
    var $destinatario_nombres;
    var $destinatario_cargo;    
    var $destinatario_institucion;
    var $remitente_nombres;
    var $remitente_cargo;
    var $remitente_institucion;
    var $mosca;    
    var $referencia;
    var $contenido;
    var $fecha;
    var $autor;
    var $tipo_documento;    
    var $adjuntos;
    var $copias;
    var $via_nombres;
    var $via_cargo;
    var $nro_hojas;
    var $poa;
    var $pre_obj;
    var $pre_pub;
    var $fin_ext;
    var $cod_poa;
    var $plazo;
    var $monto_obj;
    var $monto_pub;
    var $obs;
    var $sintesis;
    var $permisos;
    
    
    function __construct() {
        parent::__construct();
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    function getCite_original() {
        return $this->cite_original;
    }

    function setCite_original($cite_original) {
        $this->cite_original = $cite_original;
    }

    function getDestinatario_titulo() {
        return $this->destinatario_titulo;
    }

    function setDestinatario_titulo($destinatario_titulo) {
        $this->destinatario_titulo = $destinatario_titulo;
    }

    function getDestinatario_nombres() {
        return $this->destinatario_nombres;
    }

    function setDestinatario_nombres($destinatario_nombres) {
        $this->destinatario_nombres = $destinatario_nombres;
    }
          
    function getDestinatario_cargo() {
        return $this->destinatario_cargo;
    }

    function setDestinatario_cargo($destinatario_cargo) {
        $this->destinatario_cargo = $destinatario_cargo;
    }

    function getDestinatario_institucion() {
        return $this->destinatario_institucion;
    }

    function setDestinatario_institucion($destinatario_institucion) {
        $this->destinatario_institucion = $destinatario_institucion;
    }

    function getRemitente_nombres() {
        return $this->remitente_nombres;
    }

    function setRemitente_nombres($remitente_nombres) {
        $this->remitente_nombres = $remitente_nombres;
    }

    function getRemitente_cargo() {
        return $this->remitente_cargo;
    }

    function setRemitente_cargo($remitente_cargo) {
        $this->remitente_cargo = $remitente_cargo;
    }

    function getRemitente_institucion() {
        return $this->remitente_institucion;
    }

    function setRemitente_institucion($remitente_institucion) {
        $this->remitente_institucion = $remitente_institucion;
    }
    
    function getMosca() {
        return $this->mosca;
    }

    function setMosca($mosca) {
        $this->mosca = $mosca;
    }
    
    function getReferencia() {
        return $this->referencia;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }
    
    function getContenido() {
        return $this->contenido;
    }

    function setContenido($contenido) {
        $this->contenido = $contenido;
    }    
    
    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }        

    function getAutor() {
        return $this->autor;
    }

    function setTipo_documento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }        

    function getTipo_documento() {
        return $this->tipo_documento;
    }

    function setAutor($autor) {
        $this->autor = $autor;
    }      
    
    function getAdjuntos() {
        return $this->adjuntos;
    }

    function setAdjuntos($adjuntos) {
        $this->adjuntos = $adjuntos;
    }      
    
    function getCopias() {
        return $this->copias;
    }

    function setCopias($copias) {
        $this->copias = $copias;
    }    
    
    function getVia_nombres() {
        return $this->via_nombres;
    }

    function setVia_nombres($via_nombres) {
        $this->via_nombres = $via_nombres;
    }        
    
    function getVia_cargo() {
        return $this->via_cargo;
    }

    function setVia_cargo($via_cargo) {
        $this->via_cargo = $via_cargo;
    }            
    
    function getNro_hojas() {
        return $this->nro_hojas;
    }

    function setNro_hojas($nro_hojas) {
        $this->nro_hojas = $nro_hojas;
    }            
    
    function getPoa() {
        return $this->poa;
    }

    function setPoa($poa) {
        $this->poa = $poa;
    }                
    
    function getPre_obj() {
        return $this->pre_obj;
    }

    function setPre_obj($pre_obj) {
        $this->pre_obj = $pre_obj;
    }                    
    
    function getPre_pub() {
        return $this->pre_pub;
    }
    
    function setPre_pub($pre_pub) {
        $this->pre_pub = $pre_pub;
    }                    
    
    function getFin_ext() {
        return $this->fin_ext;
    }

    function setFin_ext($fin_ext) {
        $this->fin_ext = $fin_ext;
    }                    
    
    function getCod_poa() {
        return $this->cod_poa;
    }

    function setCod_poa($cod_poa) {
        $this->cod_poa = $cod_poa;
    }                    

    function getPlazo() {
        return $this->plazo;
    }

    function setPlazo($plazo) {
        $this->plazo = $plazo;
    }                    

    function getMonto_obj() {
        return $this->monto_obj;
    }

    function setMonto_obj($monto_obj) {
        $this->monto_obj = $monto_obj;
    }                    
    
    function getMonto_pub() {
        return $this->monto_pub;
    }

    function setMonto_pub($monto_pub) {
        $this->monto_pub = $monto_pub;
    }                    
    
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }                    
    
    function getSintesis() {
        return $this->sintesis;
    }

    function setSintesis($sistensis) {
        $this->Sintesis = $sintesis;
    }                    
    
    function getPermisos() {
        return $this->permisos;
    }

    function setPermisos($permisos) {
        $this->permisos = $permisos;
    }                    
    
    
}

?>