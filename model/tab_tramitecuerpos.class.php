<?php

/**
 * tab_tramitecuerpos.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_tramitecuerpos extends db {

    var $trc_id;
    var $tra_id;
    var $cue_id;
    var $trc_estado;

    function __construct() {
        parent::__construct();
    }

    function getTrc_id() {
        return $this->trc_id;
    }

    function setTrc_id($trc_id) {
        $this->trc_id = $trc_id;
    }

    function getTra_id() {
        return $this->tra_id;
    }

    function setTra_id($tra_id) {
        $this->tra_id = $tra_id;
    }

    function getCue_id() {
        return $this->cue_id;
    }

    function setCue_id($cue_id) {
        $this->cue_id = $cue_id;
    }

    function getTrc_estado() {
        return $this->trc_estado;
    }

    function setTrc_estado($trc_estado) {
        $this->trc_estado = $trc_estado;
    }

}

?>
