<?php

/**
 * tab_agrupacion.class.php Class
 * SIACO
 * 
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

// Hereda Clase de conexion Mysql
class Tab_agrupacion extends db2 {

    var $id_agru;
    var $id_agru_p;
    var $id_agru_s;
    var $id_seguimiento;
    var $oficial;
    var $est_agru;

    function __construct() {
        parent::__construct();
    }

    function getId_agru() {
        return $this->id_agru;
    }

    function setId_agru($id_agru) {
        $this->id_agru = $id_agru;
    }

    function getNur_p() {
        return $this->nur_p;
    }

    function setNur_p($nur_p) {
        $this->nur_p = $nur_p;
    }

    function getNur_s() {
        return $this->nur_s;
    }

    function setNur_s($nur_s) {
        $this->nur_s = $nur_s;
    }

    function getId_seguimiento() {
        return $this->id_seguimiento;
    }

    function setId_seguimiento($id_seguimiento) {
        $this->id_seguimiento = $id_seguimiento;
    }
          
    function getOficial() {
        return $this->oficial;
    }

    function setOficial($oficial) {
        $this->oficial = $oficial;
    }

    function getEst_agru() {
        return $this->est_agru;
    }

    function setEst_agru($est_agru) {
        $this->est_agru = $est_agru;
    }




}

?>