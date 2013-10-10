<?php

/**
 * tab_exp_ecc_sal.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_exp_ecc_sal extends db {

    var $exs_id;
    var $exp_id;
    var $nrosalida;

    function __construct() {
        parent::__construct();
    }

    function getExs_id() {
        return $this->exs_id;
    }

    function setExs_id($exs_id) {
        $this->exs_id = $exs_id;
    }

    function getExp_id() {
        return $this->exp_id;
    }

    function setExp_id($exp_id) {
        $this->exp_id = $exp_id;
    }

    function getNrosalida() {
        return $this->nrosalida;
    }

    function setNrosalida($nrosalida) {
        $this->nrosalida = $nrosalida;
    }

}

?>