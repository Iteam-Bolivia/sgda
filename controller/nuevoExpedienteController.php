<?php

/**
 * nuevoExpedienteController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class nuevoExpedienteController Extends baseController {

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
        $this->registry->template->show('nuevoExpedienteg.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
 
	//$_SESSION ['SER_ID'] = 1;
        $usuario = new usuario();
        $adm = $usuario->esAdm();
        $this->series = new series();
        $contenedor = new contenedor();
        
        $this->registry->template->series = $this->series->obtenerSelectDefault($_SESSION['USU_ID'], $_SESSION['SER_ID']);
        if ($_SESSION['SER_ID']){
            $this->registry->template->exp_codigo = $this->series->obtenerCodigoSerie($_SESSION['SER_ID']);
            $this->registry->template->exp_codigoSigla = $this->series->validarCodigoSerie($_SESSION['SER_ID']);
        }else{$this->registry->template->exp_codigo = "";
            $this->registry->template->exp_codigo = "";
            $this->registry->template->exp_codigoSigla="";
        }        
        
        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect();        
        
        $this->registry->template->exp_lugar = "";
        
        $this->registry->template->exp_nrofoj = "";
        $this->registry->template->exp_tomovol = "";
        $this->registry->template->exp_nroejem = "";
        $this->registry->template->exp_nrocaj = "";
        $this->registry->template->exp_sala = "";
        $archivo = new archivo ();        
        $this->registry->template->exp_estante = $archivo->obtenerSelectEstante();
        
        $this->registry->template->exp_cuerpo  = "";
        $this->registry->template->exp_balda = "";          
        $this->registry->template->exp_obs = "";  
        $this->registry->template->exp_ori = "0"; 
        $this->registry->template->exp_cop = "0"; 
        $this->registry->template->exp_fot = "0"; 
                        
        $this->registry->template->exp_descripcion = "";
        
        $expediente = new expediente ();
        // Expediente ISAD G
        $this->registry->template->exp_id = "";
        $this->registry->template->exp_titulo = "";
        
        $this->registry->template->exp_mesi = $expediente->obtenerSelectMes();
        $this->registry->template->exp_anioi = $expediente->obtenerSelectAnio();
        $this->registry->template->exp_fecha_exi = date("Y-m-d");
        
        $this->registry->template->exp_mesf = $expediente->obtenerSelectMes();
        $this->registry->template->exp_aniof = $expediente->obtenerSelectAnio();        
        $this->registry->template->exp_fecha_exf = date("Y-m-d");        
        
        $this->registry->template->exp_nivdes = $expediente->obtenerSelectNivelDescripcion();
        $this->registry->template->exp_volsop = "";
        //$this->registry->template->exp_nomprod = $expediente->obtenerSelectProductor();
        $this->registry->template->exp_nomprod = "";
        
        
        $this->registry->template->exp_hisins = "Historia Institucional de la ABC";
        $this->registry->template->exp_hisarc = "";
        $this->registry->template->exp_foring = "";
        $this->registry->template->exp_alccon = "";
        $this->registry->template->exp_vaseel = "";
        $this->registry->template->exp_nueing = "";
        $this->registry->template->exp_org = "";
        $this->registry->template->exp_conacc = "";
        $this->registry->template->exp_conrep = "";
        // idioma
        $idioma = new idioma ();        
        $this->registry->template->idi_id = $idioma->obtenerSelect();

        //$nuevo = $expediente2->obtenerSelectEstado();
        $this->registry->template->exp_carfis = $expediente->obtenerSelectEstado();
        $this->registry->template->exp_insdes = "";
        $this->registry->template->exp_exloor = "";
        $this->registry->template->exp_exloco = "";
        $this->registry->template->exp_underel = "";
        $this->registry->template->exp_notpub = "";
        $this->registry->template->exp_notas = "";
        $this->registry->template->exp_notarc = "";
        $this->registry->template->exp_regnor = "";
        $this->registry->template->exp_fecdes = date("Y-m-d");
        $this->registry->template->exp_descripcion = "";
        // Containers
        $this->registry->template->contenedores = $contenedor->loadSelect($_SESSION['USU_ID']);
        $this->registry->template->suc_id = "";    
        
        $ser_id = $_SESSION['SER_ID'];
        
        // Include dynamic fields
        $expcampo = new expcampo();        
        $this->registry->template->expcampo = $expcampo->obtenerSelectCampos($ser_id);
        $this->registry->template->series = $this->series->obtenerSelectDefault($_SESSION['USU_ID'], $_SESSION['SER_ID']);

//        // Project
//        $proyecto = new proyecto();
//        $this->registry->template->lista_tramos = $proyecto->obtenerCheck();

        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC('Expediente');

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        
        $this->registry->template->titulo = "HOJA DE TRABAJO - Nuevo";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->show('headerF');
        $this->registry->template->show('nuevoExpediente.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $expediente = new expediente();
        $hoy = date("Y-m-d");
        $this->expediente = new tab_expediente();
        $this->expediente->setRequest2Object($_REQUEST);
        $this->expediente->setExp_id($_REQUEST['exp_id']);
        $this->expediente->setSer_id($_REQUEST['ser_id']);
        $this->expediente->setExp_codigo($expediente->generaCodigo($_REQUEST['ser_id']));     
        $this->expediente->setExp_lugar(strtoupper($_REQUEST['exp_lugar']));        
        
        $this->expediente->setSof_id($_REQUEST['sof_id']);
        $this->expediente->setExp_nrofoj(strtoupper($_REQUEST['exp_nrofoj']));        
        $this->expediente->setExp_tomovol(strtoupper($_REQUEST['exp_tomovol']));
        $this->expediente->setExp_nroejem(strtoupper($_REQUEST['exp_nroejem']));
        $this->expediente->setExp_nrocaj(strtoupper($_REQUEST['exp_nrocaj']));
        $this->expediente->setExp_sala(strtoupper($_REQUEST['exp_sala']));
        $this->expediente->setExp_estante(strtoupper($_REQUEST['exp_estante']));
        $this->expediente->setExp_cuerpo(strtoupper($_REQUEST['exp_cuerpo']));
        $this->expediente->setExp_balda(strtoupper($_REQUEST['exp_balda']));
        
        if ($_REQUEST['exp_ori']) $this->expediente->setExp_ori($_REQUEST['exp_ori']);
        if ($_REQUEST['exp_cop']) $this->expediente->setExp_cop($_REQUEST['exp_cop']);
        if ($_REQUEST['exp_fot']) $this->expediente->setExp_fot($_REQUEST['exp_fot']);

        $this->expediente->setExp_obs(strtoupper($_REQUEST['exp_obs']));        
        $this->expediente->setExp_estado(1);        
        $exp_id = $this->expediente->insert();
        
        // Update contador
        $tseries = new tab_series();
        $row2 = $tseries->dbselectByField("ser_id", $_REQUEST['ser_id']);
        $row2 = $row2[0];  
        $tseries->setSer_id($_REQUEST['ser_id']);
        $ser_contador = $row2->ser_contador+1;
        $tseries->setSer_contador($ser_contador);        
        $tseries->update();        
        
        //$this->expisadg->setTrm_id(1);
        $expisadg = new tab_expisadg ();
        $expisadg->setExp_id($exp_id);
        $expisadg->setExp_titulo(strtoupper($_REQUEST['exp_titulo']));  
        $expisadg->setExp_fecha_exi($_REQUEST['exp_fecha_exi']);
        $expisadg->setExp_mesi($_REQUEST['exp_mesi']);
        $expisadg->setExp_anioi($_REQUEST['exp_anioi']);
        $expisadg->setExp_fecha_exf($_REQUEST['exp_fecha_exf']);
        $expisadg->setExp_mesf($_REQUEST['exp_mesf']);
        $expisadg->setExp_aniof($_REQUEST['exp_aniof']);        
        $expisadg->setExp_nivdes(strtoupper($_REQUEST['exp_nivdes']));
        $expisadg->setExp_volsop(strtoupper($_REQUEST['exp_volsop']));
        $expisadg->setExp_nomprod(strtoupper($_REQUEST['exp_nomprod']));
        $expisadg->setExp_hisins(strtoupper($_REQUEST['exp_hisins']));
        $expisadg->setExp_hisarc(strtoupper($_REQUEST['exp_hisarc']));
        $expisadg->setExp_foring(strtoupper($_REQUEST['exp_foring']));
        $expisadg->setExp_alccon(strtoupper($_REQUEST['exp_alccon']));
        $expisadg->setExp_vaseel(strtoupper($_REQUEST['exp_vaseel']));
        $expisadg->setExp_nueing(strtoupper($_REQUEST['exp_nueing']));
        $expisadg->setExp_org(strtoupper($_REQUEST['exp_org']));
        $expisadg->setExp_conacc(strtoupper($_REQUEST['exp_conacc']));
        $expisadg->setExp_conrep(strtoupper($_REQUEST['exp_conrep']));        
        $expisadg->setIdi_id($_REQUEST['idi_id']);
        
        $expisadg->setExp_carfis(strtoupper($_REQUEST['exp_carfis']));
        $expisadg->setExp_insdes(strtoupper($_REQUEST['exp_insdes']));
        $expisadg->setExp_exloor(strtoupper($_REQUEST['exp_exloor']));
        $expisadg->setExp_exloco(strtoupper($_REQUEST['exp_exloco']));
        $expisadg->setExp_underel(strtoupper($_REQUEST['exp_underel']));
        $expisadg->setExp_notpub(strtoupper($_REQUEST['exp_notpub']));
        $expisadg->setExp_notas(strtoupper($_REQUEST['exp_notas']));
        $expisadg->setExp_notarc(strtoupper($_REQUEST['exp_notarc']));
        $expisadg->setExp_regnor(strtoupper($_REQUEST['exp_regnor']));
        $expisadg->setExp_fecdes($_REQUEST['exp_fecdes']);   
        $expisadg->setExp_estado(1);   
        $eig_id = $expisadg->insert();

        // Save expfondo data
        $texf = new Tab_expfondo();  
        $texf->setExp_id($exp_id);
        $usuario = new usuario();
        $fon_id = $usuario->getFon_id($_SESSION['USU_ID']);
        $texf->setFon_id($fon_id);
        $texf->setExf_fecha_exi($_REQUEST['exp_fecha_exi']);
        $texf->setExf_fecha_exf($_REQUEST['exp_fecha_exf']);
        $texf->setExf_estado('1');
        $texf->insert();

        // Save expusuario data
        $this->expusuario = new expusuario();
        $this->expusuario->saveExp($exp_id, $_SESSION['USU_ID']);

//        // Save expcontenedor data
//        $con = new expcontenedor();
//        $con->saveExpCont($_REQUEST['con_id'], $_REQUEST['suc_id'], $exp_id);

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

        //Guardar palabra clave
        if (!empty($_REQUEST['exp_descripcion'])) {
            $this->palclave = new tab_palclave();
            $pac_nombre = trim($_REQUEST['exp_descripcion']);
            $array = explode(SEPARATOR_SEARCH, $pac_nombre);
            for($j=0;$j<count($array);$j++){
                $sql = "select pac_id from tab_palclave where pac_estado = 1 AND exp_id='$exp_id' AND pac_nombre='" . $array[$j] . "'";
                $row = $this->palclave->dbSelectBySQL($sql);
                if (count($row) == 0) {
                    $this->palclave->setFil_id($exp_id);
                    $this->palclave->setPac_nombre(strtoupper(trim($array[$j])));
                    $this->palclave->setPac_formulario('Expediente');
                    $this->palclave->setPac_estado(1);
                    $this->palclave->insert();
                }
            }               
       }        



        
        
        
        
        
//        // SIACO - REGISTRO DE TABLAS ARCHIVADOS O ARCHIVADOS_DIGITALES
//        if($_REQUEST['exp_ocf']=='Original'){
//            // Registra en el SIACO tabla archivados
//            $subcontenedor = new subcontenedor();
//            $this->archivados = new tab_archivados ();
//            $this->archivados->setRequest2Object($_REQUEST);
//            $this->archivados->setId_archivado("0");
//            //$this->archivados->setCodigo($_REQUEST['nur']);
//            $this->archivados->setFecha(date("Y-m-d"));
//            $this->archivados->setPersona($_SESSION['USU_LOGIN']);
//            $this->archivados->setLugar($_REQUEST['exp_nombre']);
//            $this->archivados->setObservaciones("SISTEMA DE ARCHIVO DIGITAL");                        
//            $this->archivados->setCopia("NO");
//            $this->archivados->insert();
//            
//        }else{
//            // Registra en el SIACO tabla archivados_digitales
//            $subcontenedor = new subcontenedor();
//            $this->archivados_digitales = new tab_archivados_digitales ();
//            $this->archivados_digitales->setRequest2Object($_REQUEST);
//            $this->archivados_digitales->setId_archivado("0");
//            //$this->archivados_digitales->setCodigo($_REQUEST['nur']);
//            $this->archivados_digitales->setFecha(date("Y-m-d"));
//            $this->archivados_digitales->setPersona($_SESSION['USU_LOGIN']);
//            $this->archivados_digitales->setLugar($_REQUEST['exp_nombre']);
//            $this->archivados_digitales->setObservaciones("SISTEMA DE ARCHIVO DIGITAL");                        
//            $this->archivados_digitales->setCopia("SI");
//            $this->archivados_digitales->insert();
//        }
//        

        
        if ($_REQUEST ['accion'] == 'guardar') {
            Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/index/");
        } else {
            if ($_REQUEST ['accion'] == 'guardarnuevo') {
                 $this->add();
            }else{
                Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/index/");
            }
        }        
        
    }
    
    function edit() {
        header("Location: " . PATH_DOMAIN . "/nuevoExpediente/view/" . $_REQUEST["exp_id"] . "/");
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
        $this->registry->template->exp_codigo = $row->exp_codigo;
        
        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect($row->sof_id);        
        
        $this->registry->template->exp_lugar = $row->exp_lugar;
        $this->registry->template->exp_nrofoj = $row->exp_nrofoj;
        $this->registry->template->exp_tomovol = $row->exp_tomovol;
        $this->registry->template->exp_nroejem = $row->exp_nroejem;
        $this->registry->template->exp_nrocaj = $row->exp_nrocaj;
        $this->registry->template->exp_sala = $row->exp_sala;
        $archivo = new archivo ();        
        $this->registry->template->exp_estante = $archivo->obtenerSelectEstante($row->exp_estante);        
        $this->registry->template->exp_cuerpo  = $row->exp_cuerpo;
        $this->registry->template->exp_balda = $row->exp_balda;    
        $this->registry->template->exp_obs = $row->exp_obs;
        
        $this->registry->template->exp_ori = $row->exp_ori;
        $this->registry->template->exp_cop = $row->exp_cop;
        $this->registry->template->exp_fot = $row->exp_fot;
        $palclave = new palclave();
        $this->registry->template->exp_descripcion = $palclave->listaPCFile($row->exp_id);

        $ser_id = $row->ser_id;
        // Include dynamic fields
        $expcampo = new expcampo();        
        $this->registry->template->expcampo = $expcampo->obtenerSelectCamposEdit($row->ser_id, VAR3);
        
        // Expediente ISAD-G   
        $expisadg = new tab_expisadg();
        $rows2 = $expisadg->dbselectByField("exp_id", VAR3);
        $rows2 = $rows2[0];
        $expediente = new expediente();
        $this->registry->template->exp_titulo = $rows2->exp_titulo;
        $this->registry->template->exp_fecha_exi = $rows2->exp_fecha_exi;
        $this->registry->template->exp_mesi = $expediente->obtenerSelectMes($rows2->exp_mesi);
        $this->registry->template->exp_anioi = $expediente->obtenerSelectAnio($rows2->exp_anioi);
        
        $this->registry->template->exp_fecha_exf = $rows2->exp_fecha_exf;        
        $this->registry->template->exp_mesf = $expediente->obtenerSelectMes($rows2->exp_mesf);
        $this->registry->template->exp_aniof = $expediente->obtenerSelectAnio($rows2->exp_aniof);
        
        $this->registry->template->exp_nivdes = $expediente->obtenerSelectNivelDescripcion($rows2->exp_nivdes);
        $this->registry->template->exp_volsop = $rows2->exp_volsop;
        
        //$this->registry->template->exp_nomprod = $expediente->obtenerSelectProductor($rows2->exp_nomprod);        
        $this->registry->template->exp_nomprod = $rows2->exp_nomprod;
        
        $this->registry->template->exp_hisins = $rows2->exp_hisins;
        $this->registry->template->exp_hisarc = $rows2->exp_hisarc;
        $this->registry->template->exp_foring = $rows2->exp_foring;
        $this->registry->template->exp_alccon = $rows2->exp_alccon;
        $this->registry->template->exp_vaseel = $rows2->exp_vaseel;
        $this->registry->template->exp_nueing = $rows2->exp_nueing;
        $this->registry->template->exp_org = $rows2->exp_org;
        $this->registry->template->exp_conacc = $rows2->exp_conacc;
        $this->registry->template->exp_conrep = $rows2->exp_conrep;
        // idioma
        $idioma = new idioma ();        
        $this->registry->template->idi_id = $idioma->obtenerSelect($rows2->idi_id);

        //$nuevo = $expediente2->obtenerSelectEstado();
        $this->registry->template->exp_carfis = $expediente->obtenerSelectEstado($rows2->exp_carfis);
        
        $this->registry->template->exp_insdes = $rows2->exp_insdes;
        $this->registry->template->exp_exloor = $rows2->exp_exloor;
        $this->registry->template->exp_exloco = $rows2->exp_exloco;
        $this->registry->template->exp_underel = $rows2->exp_underel;
        $this->registry->template->exp_notpub = $rows2->exp_notpub;
        $this->registry->template->exp_notas = $rows2->exp_notas;
        $this->registry->template->exp_notarc = $rows2->exp_notarc;
        $this->registry->template->exp_regnor = $rows2->exp_regnor;
        $this->registry->template->exp_fecdes = $rows2->exp_fecdes;        

        $eus = new Tab_expusuario();
        $row_eus = $eus->dbselectBy2Field("exp_id", VAR3, "eus_estado", 1);
        $usu_id = $_SESSION['USU_ID'];
        if (!is_null($row_eus) && count($row_eus) > 0)
            $usu_id = $row_eus[0]->usu_id;
        
        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC();

        $this->registry->template->titulo = "HOJA DE TRABAJO - Editar";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
         $this->registry->template->exp_codigoSigla=$this->series->validarCodigoSerie($ser_id);
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('nuevoExpediente.tpl');
        $this->registry->template->show('footer');
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
        $this->expediente->setExp_codigo($_REQUEST['exp_codigo']);
        $this->expediente->setExp_lugar(strtoupper($_REQUEST['exp_lugar'])); 
        $this->expediente->setSof_id($_REQUEST['sof_id']);
        $this->expediente->setExp_nrofoj(strtoupper($_REQUEST['exp_nrofoj']));        
        $this->expediente->setExp_tomovol(strtoupper($_REQUEST['exp_tomovol']));
        $this->expediente->setExp_nroejem(strtoupper($_REQUEST['exp_nroejem']));
        $this->expediente->setExp_nrocaj(strtoupper($_REQUEST['exp_nrocaj']));
        $this->expediente->setExp_sala(strtoupper($_REQUEST['exp_sala']));
        $this->expediente->setExp_estante(strtoupper($_REQUEST['exp_estante']));
        $this->expediente->setExp_cuerpo(strtoupper($_REQUEST['exp_cuerpo']));
        $this->expediente->setExp_balda(strtoupper($_REQUEST['exp_balda']));
        
        if (isset($_REQUEST['exp_ori'])) $this->expediente->setExp_ori($_REQUEST['exp_ori']);
        if (isset($_REQUEST['exp_cop'])) $this->expediente->setExp_cop($_REQUEST['exp_cop']);
        if (isset($_REQUEST['exp_fot'])) $this->expediente->setExp_fot($_REQUEST['exp_fot']);
        
        $this->expediente->setExp_obs($_REQUEST['exp_obs']);
        $this->expediente->update();
        
        // New
        $tab_expisadg = new tab_expisadg();
        $rows = $tab_expisadg->dbselectByField("exp_id", $_REQUEST['exp_id']);
        $rows = $rows[0];
        
        $expisadg = new tab_expisadg ();
        $expisadg->setEig_id($rows->eig_id);
        $expisadg->setExp_id($_REQUEST['exp_id']);
        $expisadg->setExp_titulo(strtoupper($_REQUEST['exp_titulo']));
        
        $expisadg->setExp_fecha_exi($_REQUEST['exp_fecha_exi']);
        $expisadg->setExp_mesi($_REQUEST['exp_mesi']);
        $expisadg->setExp_anioi($_REQUEST['exp_anioi']);
        $expisadg->setExp_fecha_exf($_REQUEST['exp_fecha_exf']);
        $expisadg->setExp_mesf($_REQUEST['exp_mesf']);
        $expisadg->setExp_aniof($_REQUEST['exp_aniof']);
        
        $expisadg->setExp_nivdes(strtoupper($_REQUEST['exp_nivdes']));
        $expisadg->setExp_volsop(strtoupper($_REQUEST['exp_volsop']));
        $expisadg->setExp_nomprod(strtoupper($_REQUEST['exp_nomprod']));
        $expisadg->setExp_hisins(strtoupper($_REQUEST['exp_hisins']));
        $expisadg->setExp_hisarc(strtoupper($_REQUEST['exp_hisarc']));
        $expisadg->setExp_foring(strtoupper($_REQUEST['exp_foring']));
        $expisadg->setExp_alccon(strtoupper($_REQUEST['exp_alccon']));
        $expisadg->setExp_vaseel(strtoupper($_REQUEST['exp_vaseel']));
        $expisadg->setExp_nueing(strtoupper($_REQUEST['exp_nueing']));
        $expisadg->setExp_org(strtoupper($_REQUEST['exp_org']));
        $expisadg->setExp_conacc(strtoupper($_REQUEST['exp_conacc']));
        $expisadg->setExp_conrep(strtoupper($_REQUEST['exp_conrep']));
        $expisadg->setIdi_id($_REQUEST['idi_id']);
        
        $expisadg->setExp_carfis(strtoupper($_REQUEST['exp_carfis']));
        $expisadg->setExp_insdes(strtoupper($_REQUEST['exp_insdes']));
        $expisadg->setExp_exloor(strtoupper($_REQUEST['exp_exloor']));
        $expisadg->setExp_exloco(strtoupper($_REQUEST['exp_exloco']));
        $expisadg->setExp_underel(strtoupper($_REQUEST['exp_underel']));
        $expisadg->setExp_notpub(strtoupper($_REQUEST['exp_notpub']));
        $expisadg->setExp_notas(strtoupper($_REQUEST['exp_notas']));
        $expisadg->setExp_notarc(strtoupper($_REQUEST['exp_notarc']));
        $expisadg->setExp_regnor(strtoupper($_REQUEST['exp_regnor']));
        $expisadg->setExp_fecdes($_REQUEST['exp_fecdes']);   
        $expisadg->setExp_estado(1);   
        $eig_id = $expisadg->update();
        
        

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
        
//        $exp = new expproyecto();
//        $exp->delete($id);
//        if (isset($_REQUEST['lista_tramo'])) {
//            $proyectos = $_REQUEST['lista_tramo'];
//            foreach ($proyectos as $proyecto) {
//                // damos de baja todas las ocurrencias
//                // damos de alta las que se encuentran en $series o insertamos en caso de q no existan
//                $use_id = $exp->existe($proyecto, $id);
//                if ($use_id != null) {
//                    //update
//                    $texp = new tab_expproyecto();
//                    $texp->setEpp_id($ext_id);
//                    $texp->setExp_id($id);
//                    $texp->setPry_id($proyecto);
//                    $texp->setEpp_estado('1');
//                    $texp->update();
//                } else {
//                    //insert
//                    $texp = new tab_expproyecto();
//                    $texp->setExp_id($id);
//                    $texp->setPry_id($proyecto);
//                    $texp->setEpp_estado('1');
//                    $texp->insert();
//                }
//            }
//        }


//        $tcon = new tab_expcontenedor();
//        $row_con = $tcon->dbselectByField("exp_id", $_REQUEST['exp_id']);
//        if (count($row_con) > 0) {
//            $tcon = $row_con[0];
//            $tcon->suc_id = $_REQUEST['suc_id'];
//            $tcon->exc_estado = 1;
//            $tcon->update();
//        } else {
//            $con = new expcontenedor();
//            $con->saveExpCont($_REQUEST['suc_id'], $_REQUEST['exp_id']);
//        }

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
        if (!empty($_REQUEST['exp_descripcion'])) {
            $this->palclave = new tab_palclave();
            $pac_nombre = trim($_REQUEST['exp_descripcion']);
            $array = explode(SEPARATOR_SEARCH, $pac_nombre);
            for($j=0;$j<count($array);$j++){
                $sql = "select pac_id from tab_palclave where pac_estado = 1 AND exp_id='$exp_id' AND pac_nombre='" . $array[$j] . "'";
                $row = $this->palclave->dbSelectBySQL($sql);
                if (count($row) == 0) {
                    $this->palclave->setFil_id($exp_id);
                    $this->palclave->setPac_nombre(strtoupper(trim($array[$j])));
                    $this->palclave->setPac_formulario('Expediente');
                    $this->palclave->setPac_estado(1);
                    $this->palclave->insert();
                }
            }               
       }

        //Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/");
        Header("Location: " . PATH_DOMAIN . "/nuevoExpediente/index/");
    }

    function verifSeries() {
        $usu_serie = new usu_serie();
        echo $usu_serie->tieneSeries($_SESSION['USU_ID']);
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

    
    
//    function add2() {
//        header("Location: " . PATH_DOMAIN . "/nuevoExpediente/addview/" . $_REQUEST["ser_id"] . "/");
//    }

//    function addview() {
//        if(! VAR3){ die("Error del sistema 404"); }
//        $this->expediente = new tab_expediente();
//        $contenedor = new contenedor();
//        $rows = $this->expediente->dbselectByField("exp_id", VAR3);
//        //if(! $rows){ die("Error del sistema 404"); }
//        if (empty($rows)) {
//            echo 'Error: No existe el expediente';
//            die;
//        }
//        $row = $rows[0];
//        $this->registry->template->exp_id = $row->exp_id;
//
//        $exc = new Tab_expcontenedor();
//        $row_con = $exc->dbselectBy2Field("exp_id", VAR3, "exc_estado", 1);
//        $con_id = "";
//        if (!is_null($row_con) && count($row_con) > 0)
//            $con_id = $row_con[0]->con_id;
//
//        $eus = new Tab_expusuario();
//        $row_eus = $eus->dbselectBy2Field("exp_id", VAR3, "eus_estado", 1);
//        $usu_id = $_SESSION['USU_ID'];
//        if (!is_null($row_eus) && count($row_eus) > 0)
//            $usu_id = $row_eus[0]->usu_id;
//
//        $this->series = new series();
//        $this->registry->template->series = $this->series->getTitle($row->ser_id) . '<input name="ser_id" id="ser_id" type="hidden"
//		value="' . $row->ser_id . '" />';
//        $this->registry->template->contenedores = $contenedor->loadSelect($usu_id, $con_id);
//        $this->registry->template->exp_nombre = $row->exp_nombre;
//        $this->registry->template->exp_descripcion = $row->exp_descripcion;
//        $this->registry->template->exp_codigo = $row->exp_codigo;
//        
//
//        $exf = new Tab_expfondo();
//        $row_exf = $exf->dbselectBy2Field("exp_id", VAR3, "exf_estado", 1);
//        $this->registry->template->exp_fecha_exi = $row_exf[0]->exf_fecha_exi;
//        $this->registry->template->exp_fecha_exf = $row_exf[0]->exf_fecha_exf;
//        $this->registry->template->titulo = "Editar";
//        $this->registry->template->PATH_WEB = PATH_WEB;
//        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
//        $this->registry->template->PATH_EVENT = "update";
//        $this->registry->template->GRID_SW = "true";
//        $this->registry->template->PATH_J = "jquery-1.4.1";
//        $this->menu = new menu();
//        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
//        $this->registry->template->men_titulo = $this->liMenu;
//        $this->registry->template->show('headerF');
//        $this->registry->template->show('nuevoExpediente.tpl');
//        $this->registry->template->show('footer');
//    }

    
}

?>
