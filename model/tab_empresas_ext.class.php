<?php

/**
 * tab_empresas.class.php Class
 *
 * @package
 * @author Lic. Castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class Tab_empresas_ext extends db {

    var $emp_id;
    var $emp_nombre;
    var $emp_sigla;
    var $emp_estado;

    function __construct() {
        parent::__construct();
    }

    function getEmp_id() {
        return $this->emp_id;
    }

    function setEmp_id($emp_id) {
        $this->emp_id = $emp_id;
    }

    function getEmp_nombre() {
        return $this->emp_nombre;
    }

    function setEmp_nombre($emp_nombre) {
        $this->emp_nombre = $emp_nombre;
    }

    function getEmp_sigla() {
        return $this->emp_sigla;
    }

    function setEmp_sigla($emp_sigla) {
        $this->emp_sigla = $emp_sigla;
    }

    function getEmp_estado() {
        return $this->emp_estado;
    }

    function setEmp_estado($emp_estado) {
        $this->emp_estado = $emp_estado;
    }

}

?>