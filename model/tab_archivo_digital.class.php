<?php

/**
 * tab_archivo_digital.class.php Class
 *
 * @package
 * @author Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_archivo_digital extends db {
    var $fid_id;
    var $fil_id;
    var $fil_nomoriginal;
    var $fil_nomcifrado;
    var $fil_tipo;
    var $fil_tamano;
    var $fil_extension;    
    var $nombre;
    var $archivo_bytea;
    var $archivo_oid;
    var $mime;
    var $size;
    var $archivo;
    var $fil_estado;    
    

    // Others
//    var $fill_id_digital;
    
    
    function __construct() {
        parent::__construct();
    }

    function getFid_id() {
        return $this->fid_id;
    }

    function setFid_id($fid_id) {
        $this->fid_id = $fid_id;
    }
    
    
    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getFil_nomoriginal() {
        return $this->fil_nomoriginal;
    }

    function setFil_nomoriginal($fil_nomoriginal) {
        $this->fil_nomoriginal = $fil_nomoriginal;
    }    
    
    function getFil_nomcifrado() {
        return $this->fil_nomcifrado;
    }

    function setFil_nomcifrado($fil_nomcifrado) {
        $this->fil_nomcifrado = $fil_nomcifrado;
    }    
    
    function getFil_tipo() {
        return $this->fil_tipo;
    }

    function setFil_tipo($fil_tipo) {
        $this->fil_tipo = $fil_tipo;
    }    
    
    function getFil_tamano() {
        return $this->fil_tamano;
    }

    function setFil_tamano($fil_tamano) {
        $this->fil_tamano = $fil_tamano;
    }    
    
    function getFil_extension() {
        return $this->fil_extension;
    }

    function setFil_extension($fil_extension) {
        $this->fil_extension = $fil_extension;
    }
    
    function getNombre() {
        return $this->nommbre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getArchivo_bytea() {
        return $this->archivo_bytea;
    }

    function setArchivo_bytea($archivo_bytea) {
        $this->archivo_bytea = $archivo_bytea;
    }

    function getArchivo_oid() {
        return $this->archivo_oid;
    }

    function setArchivo_oid($archivo_oid) {
        $this->archivo_oid = $archivo_oid;
    }

    function getMime() {
        return $this->mime;
    }

    function setMime($mime) {
        $this->mime = $mime;
    }

    function getSize() {
        return $this->size;
    }

    function setSize($size) {
        $this->size = $size;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }
    
    function getFil_estado() {
        return $this->fil_estado;
    }

    function setFil_estado($fil_estado) {
        $this->fil_estado = $fil_estado;
    }

//    function getFill_id_digital() {
//        return $this->fill_id_digital;
//    }
//
//    function setFill_id_digital($fill_id_digital) {
//        $this->fill_id_digital = $fill_id_digital;
//    }


}

?>