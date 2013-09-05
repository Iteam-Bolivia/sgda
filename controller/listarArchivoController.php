<?php

/**
 * prestamosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class listarArchivoController Extends baseController {

    function index() {
        $series = new series ();
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();        
        $menuS = $series->loadMenu($adm, "test");
        $menuS2 = $series->loadMenu($adm, "test2");
        
        $this->registry->template->PATH_A = $menuS;
        $this->registry->template->PATH_B = $menuS2;
        $this->registry->template->pre_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $menu = new menu();
        $liMenu = $menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('prestamos/listarArchivo.tpl');
        $this->registry->template->show('footer');

    }
        function search() { 
        $archivo = new archivo();
        $request = $this->setRequestTrim($_REQUEST);
        $json = $archivo->buscar($request);
        echo $json;
    }
    
    
    //function listar
}

?>
