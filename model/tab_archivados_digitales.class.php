<?php

/**
 * tab_archivados.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

// Hereda Clase de conexion Mysql
class Tab_archivados_digitales extends db2 {

    var $id_archivado;
    var $codigo;
    var $fecha;
    var $persona;
    var $lugar;
    var $observaciones;
    var $copia;

    function __construct() {
        parent::__construct();
    }

    function getId_archivado() {
        return $this->id_archivado;
    }

    function setId_archivado($id_archivado) {
        $this->id_archivado = $id_archivado;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getPersona() {
        return $this->persona;
    }

    function setPersona($persona) {
        $this->persona = $persona;
    }
          
    function getLugar() {
        return $this->lugar;
    }

    function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function getCopia() {
        return $this->copia;
    }

    function setCopia($copia) {
        $this->copia = $copia;
    }



}

?>