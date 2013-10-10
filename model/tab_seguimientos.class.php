<?php

/**
 * tab_seguimientos.class.php Class
 * SIACO
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

// Hereda Clase de conexion Mysql
class Tab_seguimientos extends db2 {

    var $id_seguimiento;
    var $codigo;
    var $derivado_por;
    var $derivado_a;
    var $f_derivacion;
    var $f_recepcion;
    var $estado;
    var $accion;
    var $observaciones;
    var $padre;
    var $oficial;
    var $hijo;
    var $escusa;
    var $bandera;
    

    function __construct() {
        parent::__construct();
    }

    function getId_seguimiento() {
        return $this->id_seguimiento;
    }

    function setId_seguimiento($id_seguimiento) {
        $this->id_seguimiento = $id_seguimiento;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getDerivado_por() {
        return $this->derivado_por;
    }

    function setDerivado_por($derivado_por) {
        $this->derivado_por = $derivado_por;
    }

    function getDerivado_a() {
        return $this->derivado_a;
    }

    function setDerivado_a($derivado_a) {
        $this->derivado_a = $derivado_a;
    }
          
    function getF_derivacion() {
        return $this->f_derivacion;
    }

    function setF_derivacion($f_derivacion) {
        $this->f_derivacion = $f_derivacion;
    }

    function getF_recepcion() {
        return $this->f_recepcion;
    }

    function setF_recepcion($f_recepcion) {
        $this->f_recepcion = $f_recepcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getAccion() {
        return $this->accion;
    }

    function setAccion($accion) {
        $this->accion = $accion;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function getPadre() {
        return $this->padre;
    }

    function setPadre($padre) {
        $this->padre = $padre;
    }

    function getOficial() {
        return $this->oficial;
    }

    function setOficial($oficial) {
        $this->oficial = $oficial;
    }

    function getHijo() {
        return $this->hijo;
    }

    function setHijo($hijo) {
        $this->hijo = $hijo;
    }

    function getEscusa() {
        return $this->escusa;
    }

    function setEscusa($escusa) {
        $this->escusa = $escusa;
    }
    

    function getBandera() {
        return $this->bandera;
    }

    function setBandera($bandera) {
        $this->bandera = $bandera;
    }
    


}

?>