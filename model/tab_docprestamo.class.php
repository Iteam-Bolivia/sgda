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
class Tab_docprestamo extends db {
    
    var $dpr_id;
    var $spr_id;
    var $dpr_orden;
    var $fil_id;
    var $dpr_obs;    
    var $dpr_estado;
    
    
    function __construct() {
        parent::__construct();
    }

    function getDpr_id() {
        return $this->dpr_id;
    }

    function setDpr_id($dpr_id) {
        $this->dpr_id = $dpr_id;
    }
    
    function getSpr_id() {
        return $this->spr_id;
    }

    function setSpr_id($spr_id) {
        $this->spr_id = $spr_id;
    }

    function getDpr_orden() {
        return $this->dpr_orden;
    }

    function setDpr_orden($dpr_orden) {
        $this->dpr_orden = $dpr_orden;
    }

    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }
          
    function getDpr_obs() {
        return $this->dpr_obs;
    }

    function setDpr_obs($dpr_obs) {
        $this->dpr_obs = $dpr_obs;
    }

    function getDpr_estado() {
        return $this->dpr_estado;
    }

    function setDpr_estado($dpr_estado) {
        $this->dpr_estado = $dpr_estado;
    }
       
    
    
}

?>