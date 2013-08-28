<?php

/**
 * buscarArchivoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class buscarExpedienteController extends baseController {
    /* var $envia = array('ser_id'=>'','exp_codigo'=>'','exp_nombre'=>'','tra_id'=>'','cue_id'=>'',
      'exf_fecha_exi'=>'', 'exf_fecha_exf'=>'', 'archivo'=>'', 'fil_descripcion'=>''); */

    function index() {
        $tseries = new series();
        $tramite = new tramitecuerpos ();
        $fondos = new fondo();
        $this->registry->template->tramites = $tramite->obtenerSelectTramites("");
        $this->registry->template->cuerpos = $tramite->obtenerSelectCuerpos("");
        $this->registry->template->lugar = $fondos->obtenerSelectTodos();

        $inst = new institucion();
        $usu = new usuario();
        $adm = $usu->esAdm();
        if ($adm) {
            $institucion = $inst->obtenerSinUSR('1');
        } else {
            $institucion = $inst->obtenerInstitucion($_SESSION['USU_ID']);
        }
        $this->registry->template->series = $tseries->obtenerSelectPorInst($institucion->ins_id);
        $this->registry->template->institucion = $institucion->ins_nombre;
        $this->registry->template->ins_id = $institucion->ins_id;
        $tmenu = new menu ();
        $liMenu = $tmenu->imprimirMenu("buscarExpediente", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->registry->template->UNI_ID = $_SESSION['UNI_ID'];
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "search";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerBuscador');
        $this->registry->template->show('buscarExpediente.tpl');
        $this->registry->template->show('footer');
    }

    function search() {
        $arc = new archivo();
        $envia = $arc->setRequestTrim($_REQUEST);
        //print_r($_REQUEST);die;
        $resultado = $arc->buscarExp($envia);
        //echo json_encode($datos);
    }

}

?>
