<?php

/**
 * tab_doccampo.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_doccampo extends db {

    var $dcp_id;
    var $cue_id;
    var $dcp_orden;
    var $dcp_nombre;
    var $dcp_eti;
    var $dcp_tipdat;
    var $dcp_estado;

    function __construct() {
        parent::__construct();
    }

    function getDcp_id() {
        return $this->dcp_id;
    }

    function setDcp_id($dcp_id) {
        $this->dcp_id = $dcp_id;
    }

    function getCue_id() {
        return $this->cue_id;
    }

    function setCue_id($cue_id) {
        $this->cue_id = $cue_id;
    }

    function getDcp_orden() {
        return $this->dcp_orden;
    }

    function setDcp_orden($dcp_orden) {
        $this->dcp_orden = $dcp_orden;
    }

    function getDcp_nombre() {
        return $this->dcp_nombre;
    }

    function setDcp_nombre($dcp_nombre) {
        $this->dcp_nombre = $dcp_nombre;
    }
    
    function getDcp_eti() {
        return $this->dcp_eti;
    }

    function setDcp_eti($dcp_eti) {
        $this->dcp_eti = $dcp_eti;
    }

    function getDcp_tipdat() {
        return $this->dcp_tipdat;
    }

    function setDcp_tipdat($dcp_tipdat) {
        $this->dcp_tipdat = $dcp_tipdat;
    }

    function getDcp_estado() {
        return $this->dcp_estado;
    }

    function setDcp_estado($dcp_estado) {
        $this->dcp_estado = $dcp_estado;
    }


}

?>