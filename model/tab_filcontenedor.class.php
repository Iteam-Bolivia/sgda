<?php

/**
 * tab_filcontenedor.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class Tab_filcontenedor extends db {

    var $fic_id;
    var $fil_id;
    var $con_id;
    var $suc_id;
    var $fic_estado;

    function __construct() {
        parent::__construct();
    }


    function getFic_id() {
        return $this->fic_id;
    }

    function setFic_id($fic_id) {
        $this->fic_id = $fic_id;
    }
    
    function getFil_id() {
        return $this->fil_id;
    }

    function setFil_id($fil_id) {
        $this->fil_id = $fil_id;
    }

    function getCon_id() {
        return $this->con_id;
    }

    function setCon_id($con_id) {
        $this->con_id = $con_id;
    }

    function getSuc_id() {
        return $this->suc_id;
    }

    function setSuc_id($suc_id) {
        $this->suc_id = $suc_id;
    }

    function getFic_estado() {
        return $this->fic_estado;
    }

    function setFic_estado($fic_estado) {
        $this->fic_estado = $fic_estado;
    }

    

}

?>