<?php

/**
 * expedienteController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expedienteController Extends baseController {

    function index() {
        $series = new series();
        $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->registry->template->exp_id = "";
        if (isset($_REQUEST['ser_id'])){
            $this->registry->template->ser_id = $_REQUEST['ser_id'];
            $_SESSION ['SER_ID'] = $_REQUEST['ser_id'];
        }
        else 
            $this->registry->template->ser_id = 0;
        
        
        //
        $this->registry->template->PATH_B = $series->loadMenu($adm, "");
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_expedienteg.tpl');
        $this->registry->template->show('footer');
    }

    function add() {

	//$_SESSION ['SER_ID'] = 1;
        $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->series = new series();
        $contenedor = new contenedor();
        $expediente = new expediente ();
        $this->registry->template->nur = $_SESSION['NUR'];
        //$this->registry->template->series = $this->series->obtenerSelect($adm, $_SESSION['USU_ID']);
        $this->registry->template->series = $this->series->obtenerSelectDefault($_SESSION['USU_ID'], $_SESSION['SER_ID']);


        $this->registry->template->contenedores = $contenedor->loadSelect($_SESSION['USU_ID']);
        $this->registry->template->suc_id = "";
        $this->registry->template->exp_id = "";
        $this->registry->template->exp_nombre = "";
        $this->registry->template->exp_descripcion = "";
        if ($_SESSION['SER_ID']){
            $this->registry->template->exp_codigo = $this->series->obtenerCodigoSerie($_SESSION['SER_ID']);
        }else{$this->registry->template->exp_codigo = "";
            $this->registry->template->exp_codigo = "";
        }
        
        $this->registry->template->exp_mesi = $expediente->obtenerSelectMes();
        $this->registry->template->exp_anioi = $expediente->obtenerSelectAnio();
        $this->registry->template->exf_fecha_exi = date("Y-m-d");
        
        $this->registry->template->exp_mesf = $expediente->obtenerSelectMes();
        $this->registry->template->exp_aniof = $expediente->obtenerSelectAnio();        
        $this->registry->template->exf_fecha_exf = "";
        
        
        $this->registry->template->exp_ocf = "";
        // News
        $this->registry->template->exp_nivdes = "";
        $this->registry->template->exp_volsop = "";
        $this->registry->template->exp_nomprod = "";
        $this->registry->template->exp_hisins = "";
        $this->registry->template->exp_hisarc = "";
        $this->registry->template->exp_foring = "";
        $this->registry->template->exp_alccon = "";
        $this->registry->template->exp_vaseel = "";
        $this->registry->template->exp_nueing = "";
        $this->registry->template->exp_org = "";
        $this->registry->template->exp_conacc = "";
        $this->registry->template->exp_conrep = "";
        $this->registry->template->exp_lengua = "";
        $this->registry->template->exp_carfis = "";
        $this->registry->template->exp_insdes = "";
        $this->registry->template->exp_exloor = "";
        $this->registry->template->exp_exloco = "";
        $this->registry->template->exp_underel = "";
        $this->registry->template->exp_notpub = "";
        $this->registry->template->exp_notas = "";
        $this->registry->template->exp_notarc = "";
        $this->registry->template->exp_regnor = "";
        $this->registry->template->exp_carfis = "";
        $this->registry->template->exp_fecdes = date("Y-m-d");
        
    
        
        $seccion = new seccion();
        $this->registry->template->sec_id = "";

        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect();
        $this->registry->template->exp_nroejem = "1";
        $this->registry->template->exp_tomovol = "1";

        // Include dynamic fields
        $expcampo = new expcampo();
        //$ser_id = $this->series->obtenerIdSerie($_SESSION['SERIE_NAME']);
        $ser_id = $_SESSION['SER_ID'];
        $this->registry->template->expcampo = $expcampo->obtenerSelectCampos($ser_id);

        // Project
        $proyecto = new proyecto();
        $this->registry->template->lista_tramos = $proyecto->obtenerCheck();

        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC('Expediente');

        $this->registry->template->titulo = "HOJA DE TRABAJO - Nuevo";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expediente.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/expediente/view/" . $_REQUEST["exp_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->expediente = new tab_expediente();
        $this->series = new series();
        $contenedor = new contenedor();
        $rows = $this->expediente->dbselectByField("exp_id", VAR3);
        if(! $rows){ die("Error del sistema 404"); }
        if (empty($rows)) {
            echo 'Error: No existe el expediente';
            die;
        }

        
        $row = $rows[0];
        $this->registry->template->exp_id = $row->exp_id;
        $this->registry->template->series = $this->series->obtenerSelectDefault($_SESSION['USU_ID'], $row->ser_id);
//        // Save expnur data
//        $this->expnur = new tab_expnur();
//        $rows = $this->expnur->dbselectByField("exp_id", VAR3);
//        $this->expnur = $rows[0];
//        $exn_nur = $this->expnur->exn_nur;
//        $this->registry->template->nur = $exn_nur;

        $exc = new Tab_expcontenedor();
        $row_con = $exc->dbselectBy2Field("exp_id", VAR3, "exc_estado", 1);
        $suc_id = "";
        if (!is_null($row_con) && count($row_con) > 0)
            $suc_id = $row_con[0]->suc_id;

        $eus = new Tab_expusuario();
        $row_eus = $eus->dbselectBy2Field("exp_id", VAR3, "eus_estado", 1);
        $usu_id = $_SESSION['USU_ID'];
        if (!is_null($row_eus) && count($row_eus) > 0)
            $usu_id = $row_eus[0]->usu_id;

//        $this->series = new series();
//        $this->registry->template->series = $this->series->getTitle($row->ser_id) . '<input name="ser_id" id="ser_id" type="hidden"
//		value="' . $row->ser_id . '" />';
        $tab_subcontenedor = new tab_subcontenedor();
        $row_suc = $tab_subcontenedor->dbselectByField("suc_id", $suc_id);

        $this->registry->template->contenedores = $contenedor->loadSelect($usu_id, $row_suc[0]->con_id);
        $subcontenedor = new subcontenedor();
        $this->registry->template->suc_id = $subcontenedor->selectSuc($suc_id, $row_suc[0]->con_id);
        $this->registry->template->exp_nombre = $row->exp_nombre;
        $this->registry->template->exp_descripcion = $row->exp_descripcion;
        $this->registry->template->exp_codigo = $row->exp_codigo;
        $this->registry->template->exp_ocf = $row->exp_ocf;

        
        // New
        $this->registry->template->exp_nivdes = $row->exp_nivdes;
        $this->registry->template->exp_volsop = $row->exp_volsop;
        $this->registry->template->exp_nomprod = $row->exp_nomprod;
        $this->registry->template->exp_hisins = $row->exp_hisins;
        $this->registry->template->exp_hisarc = $row->exp_hisarc;
        $this->registry->template->exp_foring = $row->exp_foring;
        $this->registry->template->exp_alccon = $row->exp_alccon;
        $this->registry->template->exp_vaseel = $row->exp_vaseel;
        $this->registry->template->exp_nueing = $row->exp_nueing;
        $this->registry->template->exp_org = $row->exp_org;
        $this->registry->template->exp_conacc = $row->exp_conacc;
        $this->registry->template->exp_conrep = $row->exp_conrep;
        $this->registry->template->exp_lengua = $row->exp_lengua;
        $this->registry->template->exp_carfis = $row->exp_carfis;
        $this->registry->template->exp_insdes = $row->exp_insdes;
        $this->registry->template->exp_exloor = $row->exp_exloor;
        $this->registry->template->exp_exloco = $row->exp_exloco;
        $this->registry->template->exp_underel = $row->exp_underel;
        $this->registry->template->exp_notpub = $row->exp_notpub;
        $this->registry->template->exp_notas = $row->exp_notas;
        $this->registry->template->exp_notarc = $row->exp_notarc;
        $this->registry->template->exp_regnor = $row->exp_regnor;
        $this->registry->template->exp_fecdes = $row->exp_fecdes;
        

//        $seccion = new seccion();
//        $this->registry->template->sec_id = $seccion->selectSeccion($_SESSION['USU_ID'], $_SESSION['UNI_ID'], $row_eus[0]->sec_id);

        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect($row->sof_id);
        $this->registry->template->exp_nroejem = $row->exp_nroejem;
        $this->registry->template->exp_tomovol = $row->exp_tomovol;

        $exf = new Tab_expfondo();
        $row_exf = $exf->dbselectBy2Field("exp_id", VAR3, "exf_estado", 1);
        $this->registry->template->exf_fecha_exi = $row_exf[0]->exf_fecha_exi;
        $this->registry->template->exf_fecha_exf = $row_exf[0]->exf_fecha_exf;


        // Include dynamic fields
        $expcampo = new expcampo();
        //$ser_id = $this->series->obtenerIdSerie($_SESSION['SERIE_NAME']);
        $ser_id = $_SESSION['SER_ID'];
        $this->registry->template->expcampo = $expcampo->obtenerSelectCamposEdit($ser_id, VAR3);


        $proyecto = new proyecto();
        $this->registry->template->lista_tramos = $proyecto->obtenerCheck($row->exp_id);

        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC('Expediente');

        $this->registry->template->titulo = "HOJA DE TRABAJO - Editar";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expediente.tpl');
        $this->registry->template->show('footer');
    }

    function add2() {
        header("Location: " . PATH_DOMAIN . "/expediente/addview/" . $_REQUEST["ser_id"] . "/");
    }

    function addview() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->expediente = new tab_expediente();
        $contenedor = new contenedor();
        $rows = $this->expediente->dbselectByField("exp_id", VAR3);
        //if(! $rows){ die("Error del sistema 404"); }
        if (empty($rows)) {
            echo 'Error: No existe el expediente';
            die;
        }
        $row = $rows[0];
        $this->registry->template->exp_id = $row->exp_id;

        $exc = new Tab_expcontenedor();
        $row_con = $exc->dbselectBy2Field("exp_id", VAR3, "exc_estado", 1);
        $con_id = "";
        if (!is_null($row_con) && count($row_con) > 0)
            $con_id = $row_con[0]->con_id;

        $eus = new Tab_expusuario();
        $row_eus = $eus->dbselectBy2Field("exp_id", VAR3, "eus_estado", 1);
        $usu_id = $_SESSION['USU_ID'];
        if (!is_null($row_eus) && count($row_eus) > 0)
            $usu_id = $row_eus[0]->usu_id;

        $this->series = new series();
        $this->registry->template->series = $this->series->getTitle($row->ser_id) . '<input name="ser_id" id="ser_id" type="hidden"
		value="' . $row->ser_id . '" />';
        $this->registry->template->contenedores = $contenedor->loadSelect($usu_id, $con_id);
        $this->registry->template->exp_nombre = $row->exp_nombre;
        $this->registry->template->exp_descripcion = $row->exp_descripcion;
        $this->registry->template->exp_codigo = $row->exp_codigo;
        $this->registry->template->exp_ocf = $row->exp_ocf;

        $exf = new Tab_expfondo();
        $row_exf = $exf->dbselectBy2Field("exp_id", VAR3, "exf_estado", 1);
        $this->registry->template->exf_fecha_exi = $row_exf[0]->exf_fecha_exi;
        $this->registry->template->exf_fecha_exf = $row_exf[0]->exf_fecha_exf;
        $this->registry->template->titulo = "Editar";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_expediente.tpl');
        $this->registry->template->show('footer');
    }

    function save() {

        $hoy = date("Y-m-d");
        $this->expediente = new tab_expediente();
        $this->expediente->setRequest2Object($_REQUEST);
        $this->expediente->setExp_id($_REQUEST['exp_id']);
        $this->expediente->setSer_id($_REQUEST['ser_id']);
        $this->expediente->setExp_nombre($_REQUEST['exp_nombre']);
        $this->expediente->setExp_descripcion($_REQUEST['exp_descripcion']);
        $this->expediente->setExp_codigo("0");
        $this->expediente->setExp_fecha_exi($_REQUEST['exf_fecha_exi']);
        $this->expediente->setExp_fecha_exf(NULL);
        $this->expediente->setExp_orden("0");
        $this->expediente->setSof_id($_REQUEST['sof_id']);
        $this->expediente->setExp_nroejem($_REQUEST['exp_nroejem']);
        $this->expediente->setExp_tomovol($_REQUEST['exp_tomovol']);
        $this->expediente->setExp_fecha_crea(date("Y-m-d"));
        $this->expediente->setExp_ocf($_REQUEST['exp_ocf']);
        $this->expediente->setExp_estado(1);
        $this->expediente->setTrm_id(1);
        
        // New
        $this->expediente->setExp_nivdes($_REQUEST['exp_nivdes']);
        $this->expediente->setExp_volsop($_REQUEST['exp_volsop']);
        $this->expediente->setExp_nomprod($_REQUEST['exp_nomprod']);
        $this->expediente->setExp_hisins($_REQUEST['exp_hisins']);
        $this->expediente->setExp_hisarc($_REQUEST['exp_hisarc']);
        $this->expediente->setExp_foring($_REQUEST['exp_foring']);
        $this->expediente->setExp_alccon($_REQUEST['exp_alccon']);
        $this->expediente->setExp_vaseel($_REQUEST['exp_vaseel']);
        $this->expediente->setExp_nueing($_REQUEST['exp_nueing']);
        $this->expediente->setExp_org($_REQUEST['exp_org']);
        $this->expediente->setExp_conacc($_REQUEST['exp_conacc']);
        $this->expediente->setExp_conrep($_REQUEST['exp_conrep']);
        $this->expediente->setExp_lengua($_REQUEST['exp_lengua']);
        $this->expediente->setExp_carfis($_REQUEST['exp_carfis']);
        $this->expediente->setExp_insdes($_REQUEST['exp_insdes']);
        $this->expediente->setExp_exloor($_REQUEST['exp_exloor']);
        $this->expediente->setExp_exloco($_REQUEST['exp_exloco']);
        $this->expediente->setExp_underel($_REQUEST['exp_underel']);
        $this->expediente->setExp_notpub($_REQUEST['exp_notpub']);
        $this->expediente->setExp_notas($_REQUEST['exp_notas']);
        $this->expediente->setExp_notarc($_REQUEST['exp_notarc']);
        $this->expediente->setExp_regnor($_REQUEST['exp_regnor']);
        $this->expediente->setExp_fecdes($_REQUEST['exp_fecdes']);
        
        $exp_id = $this->expediente->insert();

//        // Save expnur data
//        $this->expnur = new tab_expnur();
//        $this->expnur->setExp_id($exp_id);
//        $this->expnur->setExn_nur($_REQUEST['nur']);
//        $this->expnur->setExn_pass('0');
//        $this->expnur->setExn_user($_SESSION['USU_ID']);
//        $this->expnur->setExn_estado(1);
//        $this->expnur->insert();

        // Update expediente code
        $series = new series();
        $this->expediente->setExp_id($exp_id);
        //$this->expediente->setExp_codigo($series->obtenerCodigoSerie($_REQUEST['ser_id']) . DELIMITER . $exp_id);
        $this->expediente->setExp_codigo($exp_id);
        $this->expediente->update();

        // Save data dynamic
        $this->expcampo = new expcampo();
        $row = $this->expcampo->obtenerCampos($_REQUEST['ser_id']);
        if (count($row) > 0) {
            foreach ($row as $val) {
                if ($val->ecp_tipdat == 'Lista') {
                    $ecp_id = $val->ecp_id;
                    $ecp_valor = $_REQUEST[$ecp_id];
                    // Save data dynamic
                    $this->expcampovalor = new tab_expcampovalor();
                    $this->expcampovalor->setExp_id($exp_id);
                    $this->expcampovalor->setEcp_id($ecp_id);
                    // Set value of list
                    $this->expcampovalor->setEcl_id($ecp_valor);
                    //
                    $this->expcampovalor->setEcv_valor($ecp_valor);
                    $this->expcampovalor->setEcv_estado(1);
                    $this->expcampovalor->insert();
                } else {
                    $ecp_id = (string) $val->ecp_id;
                    $ecp_valor = $_REQUEST[$ecp_id];
                    // Save data dynamic
                    $this->expcampovalor = new tab_expcampovalor();
                    $this->expcampovalor->setExp_id($exp_id);
                    $this->expcampovalor->setEcp_id($ecp_id);
                    $this->expcampovalor->setEcv_valor($ecp_valor);
                    $this->expcampovalor->setEcv_estado(1);
                    $this->expcampovalor->insert();
                }
            }
        }
        // Save expfondo data
        $texf = new Tab_expfondo();
        $texf->exf_estado = 1;
        $texf->exf_fecha_crea = $hoy;
        $texf->exf_fecha_exi = $hoy;
        $texf->exf_fecha_exf = date("Y-m-d");
        $texf->exf_usu_crea = $_SESSION['USU_ID'];
        $texf->exp_id = $exp_id;
        $usuario = new usuario();
        $fon_id = $usuario->getFon_id($_SESSION['USU_ID']);
        $texf->fon_id = $fon_id;
        $texf->exf_estado = '1';
        $texf->insert();

        // Save expusuario data
        $this->expusuario = new expusuario();
        $this->expusuario->saveExp($exp_id, $_SESSION['USU_ID']);

        // Save expcontenedor data
        $con = new expcontenedor();
        $con->saveExpCont($_REQUEST['suc_id'], $exp_id);

        // Save proyecto list data (tramos)
        if (isset($_REQUEST['lista_tramo'])) {
            $proyectos = $_REQUEST['lista_tramo'];
            foreach ($proyectos as $proyecto) {
                $exp = new tab_expproyecto();
                $exp->setExp_id($exp_id);
                $exp->setPry_id($proyecto);
                $exp->setEpp_estado(1);
                $exp->insert();
            }
        }

        //Guardar palabra clave

        if (isset($_REQUEST['pac_nombre'])) {
            $this->palclave = new tab_palclave();
            $pac_nombre = trim($_REQUEST['exp_descripcion']);
            $sql = "select pac_id from tab_palclave where pac_estado = 1 AND pac_nombre='" . $pac_nombre . "'";
            $row = $this->palclave->dbSelectBySQL($sql);
            if (count($row) == 0) {

                //$this->palclave->setPac_id();
                $this->palclave->setPac_nombre(trim($_REQUEST['exp_descripcion']));
                $this->palclave->setPac_formulario('Expediente');
                $this->palclave->setPac_estado(1);
                $this->palclave->insert();
            }
        }

        
        
        
        
        
        // SIACO - REGISTRO DE TABLAS ARCHIVADOS O ARCHIVADOS_DIGITALES
        if($_REQUEST['exp_ocf']=='Original'){
            // Registra en el SIACO tabla archivados
            $subcontenedor = new subcontenedor();
            $this->archivados = new tab_archivados ();
            $this->archivados->setRequest2Object($_REQUEST);
            $this->archivados->setId_archivado("0");
            //$this->archivados->setCodigo($_REQUEST['nur']);
            $this->archivados->setFecha(date("Y-m-d"));
            $this->archivados->setPersona($_SESSION['USU_LOGIN']);
            $this->archivados->setLugar($_REQUEST['exp_nombre']);
            $this->archivados->setObservaciones("SISTEMA DE ARCHIVO DIGITAL");                        
            $this->archivados->setCopia("NO");
            $this->archivados->insert();
            
        }else{
            // Registra en el SIACO tabla archivados_digitales
            $subcontenedor = new subcontenedor();
            $this->archivados_digitales = new tab_archivados_digitales ();
            $this->archivados_digitales->setRequest2Object($_REQUEST);
            $this->archivados_digitales->setId_archivado("0");
            //$this->archivados_digitales->setCodigo($_REQUEST['nur']);
            $this->archivados_digitales->setFecha(date("Y-m-d"));
            $this->archivados_digitales->setPersona($_SESSION['USU_LOGIN']);
            $this->archivados_digitales->setLugar($_REQUEST['exp_nombre']);
            $this->archivados_digitales->setObservaciones("SISTEMA DE ARCHIVO DIGITAL");                        
            $this->archivados_digitales->setCopia("SI");
            $this->archivados_digitales->insert();
        }
        

        
        
        //Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/");
        Header("Location: " . PATH_DOMAIN . "/expediente/index/");
    }

    function update() {
        $this->expediente = new tab_expediente();
        $this->expediente->setRequest2Object($_REQUEST);

        $rows = $this->expediente->dbselectByField("exp_id", $_REQUEST['exp_id']);
        $this->expediente = $rows[0];
        $id = $this->expediente->exp_id;
        $exp_id = $this->expediente->exp_id;
        $this->expediente->setExp_id($_REQUEST['exp_id']);
        $this->expediente->setSer_id($_REQUEST['ser_id']);
        $this->expediente->setExp_nombre($_REQUEST['exp_nombre']);
        $this->expediente->setExp_descripcion($_REQUEST['exp_descripcion']);
        $this->expediente->setExp_codigo($_REQUEST['exp_codigo']);
        $this->expediente->setExp_fecha_exi($_REQUEST['exf_fecha_exi']);
        $this->expediente->setExp_fecha_exf($_REQUEST['exf_fecha_exf']);
        $this->expediente->setSof_id($_REQUEST['sof_id']);
        $this->expediente->setExp_nroejem($_REQUEST['exp_nroejem']);
        $this->expediente->setExp_tomovol($_REQUEST['exp_tomovol']);
        $this->expediente->setExp_ocf($_REQUEST['exp_ocf']);
        
        // New
        $this->expediente->setExp_nivdes($_REQUEST['exp_nivdes']);
        $this->expediente->setExp_volsop($_REQUEST['exp_volsop']);
        $this->expediente->setExp_nomprod($_REQUEST['exp_nomprod']);
        $this->expediente->setExp_hisins($_REQUEST['exp_hisins']);
        $this->expediente->setExp_hisarc($_REQUEST['exp_hisarc']);
        $this->expediente->setExp_foring($_REQUEST['exp_foring']);
        $this->expediente->setExp_alccon($_REQUEST['exp_alccon']);
        $this->expediente->setExp_vaseel($_REQUEST['exp_vaseel']);
        $this->expediente->setExp_nueing($_REQUEST['exp_nueing']);
        $this->expediente->setExp_org($_REQUEST['exp_org']);
        $this->expediente->setExp_conacc($_REQUEST['exp_conacc']);
        $this->expediente->setExp_conrep($_REQUEST['exp_conrep']);
        $this->expediente->setExp_lengua($_REQUEST['exp_lengua']);
        $this->expediente->setExp_carfis($_REQUEST['exp_carfis']);
        $this->expediente->setExp_insdes($_REQUEST['exp_insdes']);
        $this->expediente->setExp_exloor($_REQUEST['exp_exloor']);
        $this->expediente->setExp_exloco($_REQUEST['exp_exloco']);
        $this->expediente->setExp_underel($_REQUEST['exp_underel']);
        $this->expediente->setExp_notpub($_REQUEST['exp_notpub']);
        $this->expediente->setExp_notas($_REQUEST['exp_notas']);
        $this->expediente->setExp_notarc($_REQUEST['exp_notarc']);
        $this->expediente->setExp_regnor($_REQUEST['exp_regnor']);
        $this->expediente->setExp_fecdes($_REQUEST['exp_fecdes']);
        
        $this->expediente->update();

//        // Save expnur data
//        $this->expnur = new tab_expnur();
//        $rows = $this->expnur->dbselectByField("exp_id", $_REQUEST['exp_id']);
//        $this->expnur = $rows[0];
//        $exn_id = $this->expnur->exn_id;

//        $this->expnur->setExn_id($exn_id);
//        $this->expnur->setExp_id($exp_id);
//        $this->expnur->setExn_nur($_REQUEST['nur']);
//        $this->expnur->setExn_pass('0');
//        $this->expnur->setExn_user($_SESSION['USU_ID']);
//        $this->expnur->setExn_estado(1);
//        $this->expnur->update();

        // Update data dynamic
        $expcampo = new expcampo();
        $row = $expcampo->obtenerCampos($_REQUEST['ser_id']);
        if(count($row)>0){
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                $ecp_id = $val->ecp_id;
                $ecp_valor = $_REQUEST[$ecp_id];
                // Find ecv_id
                $expcampovalor = new expcampovalor();
                $ecv_id = $expcampovalor->obtenerIdCampoValorporExpediente($ecp_id, $exp_id);
                // Save data dynamic                
                $this->expcampovalor = new tab_expcampovalor();
                $this->expcampovalor->setEcv_id($ecv_id);
                $this->expcampovalor->setExp_id($exp_id);
                $this->expcampovalor->setEcp_id($ecp_id);
                // Set value of list
                $this->expcampovalor->setEcl_id($ecp_valor);
                //
                $this->expcampovalor->setEcv_valor($ecp_valor);
                $this->expcampovalor->setEcv_estado(1);
                $this->expcampovalor->update();
            } else {
                // Find ecv_id
                $ecp_id = $val->ecp_id;
                $expcampovalor = new expcampovalor();
                $ecv_id = $expcampovalor->obtenerIdCampoValorporExpediente($ecp_id, $exp_id);
                $ecp_id = (string) $val->ecp_id;
                $ecp_valor = $_REQUEST[$ecp_id];
                // Save data dynamic
                $this->expcampovalor = new tab_expcampovalor();
                $this->expcampovalor->setEcv_id($ecv_id);
                $this->expcampovalor->setExp_id($exp_id);
                $this->expcampovalor->setEcp_id($ecp_id);
                $this->expcampovalor->setEcv_valor($ecp_valor);
                $this->expcampovalor->setEcv_estado(1);
                $this->expcampovalor->update();
            }
        }
        }
        $exp = new expproyecto();
        $exp->delete($id);
        if (isset($_REQUEST['lista_tramo'])) {
            $proyectos = $_REQUEST['lista_tramo'];
            foreach ($proyectos as $proyecto) {
                // damos de baja todas las ocurrencias
                // damos de alta las que se encuentran en $series o insertamos en caso de q no existan
                $use_id = $exp->existe($proyecto, $id);
                if ($use_id != null) {
                    //update
                    $texp = new tab_expproyecto();
                    $texp->setEpp_id($ext_id);
                    $texp->setExp_id($id);
                    $texp->setPry_id($proyecto);
                    $texp->setEpp_estado('1');
                    $texp->update();
                } else {
                    //insert
                    $texp = new tab_expproyecto();
                    $texp->setExp_id($id);
                    $texp->setPry_id($proyecto);
                    $texp->setEpp_estado('1');
                    $texp->insert();
                }
            }
        }


        $tcon = new tab_expcontenedor();
        $row_con = $tcon->dbselectByField("exp_id", $_REQUEST['exp_id']);
        if (count($row_con) > 0) {
            $tcon = $row_con[0];
            $tcon->suc_id = $_REQUEST['suc_id'];
            $tcon->exc_estado = 1;
            $tcon->update();
        } else {
            $con = new expcontenedor();
            $con->saveExpCont($_REQUEST['suc_id'], $_REQUEST['exp_id']);
        }

        $expusuario = new tab_expusuario();
        $row_con = $expusuario->dbselectByField("exp_id", $_REQUEST['exp_id']);
        if (count($row_con) > 0) {
            $expusuario = $row_con[0];
            //$expusuario->sec_id = $_REQUEST['sec_id'];
            $expusuario->eus_estado = 1;
            $expusuario->update();
        } else {
            $expusuario = new expusuario();
            $expusuario->saveExp($_REQUEST['exp_id'], $_SESSION['USU_ID'], $_REQUEST['sec_id']);
        }

        //Guardar palabra clave

        if (isset($_REQUEST['pac_nombre'])) {
            $this->palclave = new tab_palclave();
            $pac_nombre = trim($_REQUEST['exp_descripcion']);
            $sql = "select pac_id from tab_palclave where pac_estado = 1 AND pac_nombre='" . $pac_nombre . "'";
            $row = $this->palclave->dbSelectBySQL($sql);
            if (count($row) == 0) {

                //$this->palclave->setPac_id();
                $this->palclave->setPac_nombre(trim($_REQUEST['exp_descripcion']));
                $this->palclave->setPac_formulario('Expediente');
                $this->palclave->setPac_estado(1);
                $this->palclave->insert();
            }
        }

        //Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/");
        Header("Location: " . PATH_DOMAIN . "/expediente/index/");
    }

    function verifSeries() {
        $use = new usu_serie();
        echo $use->tieneSeries($_SESSION['USU_ID']);
    }

    function verifCodigo() {
        $exp_cod = $_REQUEST['exp_codigo'];
        $ser_id = $_REQUEST['ser_id'];
        $exp = new expediente();
        $msg = "OK";
        if ($exp_cod != '' && $msg != '' && $exp->existeCodigo($exp_cod, $ser_id)) {
            $msg = "El c&oacute;digo ya existe en esta serie";
        }
        echo $msg;
    }

    function cierre_exp() {
        $this->expediente = new Tab_expediente();
        $this->expediente->setExp_id($_REQUEST['exp_id']);
        $this->expediente->setExp_fecha_exf(date("Y-m-d"));
        $this->expediente->update();
    }

    // verifFechaFin
    // Revisar codigo Fred For
    function verifFechaFin() {
        $expediente = new tab_expediente ();
        $exp_id = $_POST["Exp_id"];

        $sql = "SELECT exp_fecha_exf FROM tab_expediente WHERE exp_id='$exp_id'";
        $row = $expediente->dbselectBySQL($sql);
        if ($row[0]->exp_fecha_exf) {
            echo 'El expediente fue cerrado';
        } else {
            echo '';
        }
    }
    
    
    function verifNurTipoDoc(){
        $tab_expediente = new Tab_expediente();
        $nur = trim($_POST['Nur']);
        //$exp_ocf = $_POST['Exp_ocf'];
        $sql = "SELECT exn.exn_id,exn.exn_pass,exn.exn_user,exn.exn_nur,exn.exn_estado,exn.exp_id,exp.exp_ocf
                FROM tab_expnur AS exn INNER JOIN tab_expediente AS exp ON exn.exn_id = exp.exp_id
                WHERE exn.exn_nur = '$nur' AND exp.exp_ocf = 'Original'";
        $row = $tab_expediente->dbSelectBySQL($sql);        
        if(count($row)>0){
            echo 'El NUR/NURI ya esta en formato original';
        }else{
            echo '';
        }
        
        
    }
    
    
    function find() {
        $ids = substr($_REQUEST['Ids'], 0, -1);
        // 
        $result = "";
        $texpediente = new tab_expediente ();
        $texpediente->setRequest2Object($_REQUEST);
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                (SELECT su.uni_descripcion FROM tab_unidad AS su WHERE su.uni_id=tab_usuario.uni_id AND su.uni_estado = '1' ) as uni_descripcion,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                tab_usuario.usu_id,
                tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expfondo.exf_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_expfondo.exf_estado = 1 AND
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . " AND
                tab_expusuario.eus_estado = 1 AND
                tab_expediente.exp_id IN (" . $ids . ")"; // 
        $result = $texpediente->dbselectBySQL2($sql);
        echo json_encode($result);
    }

    
    
    function listArch() {
        $this->expediente = new tab_expediente ();
        $sql = "SELECT
                                tab_expediente.exp_id,
				tab_expediente.ser_id,
				tab_expediente.exp_nombre,
				tab_tramite.tra_codigo,
				tab_tramite.tra_descripcion,
				tab_cuerpos.cue_codigo,
				tab_cuerpos.cue_descripcion,
				tab_exparchivo.exa_id,
				tab_archivo.fil_nomoriginal
				FROM
				tab_expediente
				Inner Join tab_serietramite ON tab_expediente.ser_id = tab_serietramite.ser_id
				Inner Join tab_tramite ON tab_serietramite.tra_id = tab_tramite.tra_id
				Inner Join tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
				Inner Join tab_cuerpos ON tab_tramitecuerpos.cue_id = tab_cuerpos.cue_id
				Inner Join tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id AND tab_tramitecuerpos.tra_id = tab_exparchivo.tra_id AND tab_cuerpos.cue_id = tab_exparchivo.cue_id
				Inner Join tab_archivo ON tab_exparchivo.fil_id = tab_archivo.fil_id
				WHERE
				tab_expediente.exp_id = '" . $_REQUEST['exp_id'] . "' AND
				tab_archivo.fil_estado = '1' AND tab_exparchivo.exa_estado = 1";
        $result = $this->expediente->dbselectBySQL2($sql);
        echo json_encode($result);
    }

    function download() {
        $this->archivobin = new tab_archivobin ();
        $row = $this->archivobin->dbSelectBySQLField("SELECT fil_contenido FROM tab_archivobin WHERE fil_id =  '1'");
        $row = $row [0];
        header("Content-Type: application/pdf");
        echo $row->fil_contenido;
    }    

}

?>
