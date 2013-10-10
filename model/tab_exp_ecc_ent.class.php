<?php

/**
 * tab_exp_ecc_ent.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_exp_ecc_ent extends db {

    var $exe_id;
    var $exp_id;
    var $nroingreso;

    function __construct() {
        parent::__construct();
    }

    function getExe_id() {
        return $this->exe_id;
    }

    function setExe_id($exe_id) {
        $this->exe_id = $exe_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getNroingreso() {
        return $this->nroingreso;
    }

    function setNroingreso($nroingreso) {
        $this->nroingreso = $nroingreso;
    }

}

?>