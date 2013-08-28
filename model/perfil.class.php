<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class perfil extends tab_usuario {

    function __construct() {
        $this->usuario = new tab_usuario();
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        if ($username != null || $pass != null) {
            $row = $this->usuario->dbselectBySQL("SELECT * from tab_usuario WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ");

            $row = $row[0];
            if (is_object($row))
                return $row;
            else
                return 0;
        }
        else
            0;
    }

    function buscarUsuario($username = null, $pass = null) {
        $row = "";
        if ($username != null || $pass != null) {
            $row = $this->usuario->dbselectBySQL("SELECT * from tab_usuario WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
            //print_r($row);
            if (isset($row[0]) && is_object($row[0]))
                return true;
            else
                return false;
        }
        else
            false;
    }

}

?>