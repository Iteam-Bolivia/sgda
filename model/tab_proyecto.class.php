<?php

/**
 * tab_proyecto.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tab_proyecto extends db {

    var $pry_id;
    var $pry_codigo;
    var $pry_nombre;
    var $pry_grod;
    var $pry_imp;
    var $pry_estado;
    
    var $dep_id;
    var $pry_fecini;
    var $pry_nroctt;
    var $pry_licitacion;
    var $pry_empctt;
    var $pry_supervisor;
    var $pry_finan;
    var $tpy_id;
    var $tct_id;
    var $pry_fecactprov;
    var $pry_fecactfin;
    var $pry_estproy;
    

    function __construct() {
        parent::__construct();
    }

    function getPry_id() {
        return $this->pry_id;
    }

    function setPry_id($pry_id) {
        $this->pry_id = $pry_id;
    }

    function getPry_codigo() {
        return $this->pry_codigo;
    }

    function setPry_codigo($pry_codigo) {
        $this->pry_codigo = $pry_codigo;
    }

    function getPry_nombre() {
        return $this->pry_nombre;
    }

    function setPry_nombre($pry_nombre) {
        $this->pry_nombre = $pry_nombre;
    }

    function getPry_grod() {
        return $this->pry_grod;
    }

    function setPry_grod($pry_grod) {
        $this->pry_grod = $pry_grod;
    }

    function getPry_imp() {
        return $this->pry_imp;
    }

    function setPry_imp($pry_imp) {
        $this->pry_imp = $pry_imp;
    }

    function getPry_estado() {
        return $this->pry_estado;
    }

    function setPry_estado($pry_estado) {
        $this->pry_estado = $pry_estado;
    }
    
    function getDep_id() {
        return $this->dep_id;
    }

    function setDep_id($dep_id) {
        $this->dep_id = $dep_id;
    }
    
    function getPry_fecini() {
        return $this->pry_fecini;
    }
    function setPry_fecini($pry_fecini) {
        $this->pry_fecini = $pry_fecini;
    }
    
    function getPry_nroctt() {
        return $this->pry_nroctt;
    }
    function setPry_nroctt($pry_nroctt) {
        $this->pry_nroctt = $pry_nroctt;
    }
    
    function getPry_licitacion() {
        return $this->pry_licitacion;
    }
    function setPry_licitacion($pry_licitacion) {
        $this->pry_licitacion = $pry_licitacion;
    }
    
    function getPry_empctt() {
        return $this->pry_empctt;
    }
    function setPry_empctt($pry_empctt) {
        $this->pry_empctt = $pry_empctt;
    }
    
    function getPry_supervisor() {
        return $this->pry_supervisor;
    }
    function setPry_supervisor($pry_supervisor) {
        $this->pry_supervisor = $pry_supervisor;
    }
    
    function getPry_finan() {
        return $this->pry_finan;
    }
    function setPry_finan($pry_finan) {
        $this->pry_finan = $pry_finan;
    }
    
    function getTpy_id() {
        return $this->tpy_id;
    }
    function setTpy_id($tpy_id) {
        $this->tpy_id = $tpy_id;
    }
    
    function getTct_id() {
        return $this->tct_id;
    }
    function setTct_id($tct_id) {
        $this->tct_id = $tct_id;
    }
    
    function getPry_fecactprov() {
        return $this->pry_fecactprov;
    }
    function setPry_fecactprov($pry_fecactprov) {
        $this->pry_fecactprov = $pry_fecactprov;
    }
    
    function getPry_fecactfin() {
        return $this->pry_fecactfin;
    }
    function setPry_fecactfin($pry_fecactfin) {
        $this->pry_fecactfin = $pry_fecactfin;
    }
    
    function getPry_estproy() {
        return $this->pry_estproy;
    }
    function setPry_estproy($pry_estproy) {
        $this->pry_estproy = $pry_estproy;
    }
    

}

?>