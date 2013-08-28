<?php

/**
 * hojas_rutaController.php Controller
 *
 * @packages
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class hojas_rutaController extends baseController {


    function index() {
    }

    function load() {
    }

    function obtenerHoja_ruta() {
        $hoja_ruta = new hoja_ruta();
        $res = $hoja_ruta->obtenerSelect($_REQUEST['Fil_nur']);
        echo $res;
    }

}

?>
