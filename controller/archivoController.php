<?php

/**
 * archivoController.php Controller
 *
 * @package
 * @author Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class archivoController extends baseController {

    var $tituloEstructuraD = "<div class='titulo' align='center'>ESTRUCTURA DOCUMENTAL</div>";
    var $tituloEstructuraR = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";

    function index() {
      $this->addArchivo("estrucDocumental");
    }

    function addArchivo($seccion) {
        $exp_id = VAR3;
        $tra_id = VAR4;
        $cue_id = VAR5;
        
        // Descripción expediente
        $exp = new expediente ();
        if ($seccion == "estrucDocumental") {
            $this->registry->template->PATH_EVENT = "save";
            $this->registry->template->linkTree = $exp->linkTree(VAR3, VAR4, VAR5);
        } else {
            $this->registry->template->PATH_EVENT = "saveReg";
            $this->registry->template->linkTree = $exp->linkTreeReg(VAR3, VAR4, VAR5);
        }                        
        $this->registry->template->seccion = $seccion;
        
        

        // Documentos
        $this->registry->template->exp_id = VAR3;
        $this->registry->template->tra_id = VAR4;
        $this->registry->template->cue_id = VAR5;
        $this->registry->template->exa_id = "";
        $contenedor = new contenedor ();
        $con_descrip = $contenedor->obtenerDescripcion(VAR3);
        
        $this->registry->template->fil_id = "";
        $this->registry->template->fil_codigo = "";
        $this->registry->template->required_archivo = "class='required'";
        
        // Correspondencia
        $this->registry->template->dco_id = "";
        $this->registry->template->fil_nur = "";
        $this->registry->template->fil_cite = "";
        $this->registry->template->fil_asunto = "";
        $this->registry->template->fil_sintesis = "";
        $this->registry->template->fil_nur_s = "";
        
        // Identificacion        
        $this->registry->template->fil_nro = "1";
        $cuerpos = new cuerpos();
        $expediente = new expediente();
        $this->registry->template->fil_titulo = utf8_encode(strtoupper($cuerpos->obtenerNombreCuerpo($cue_id)));
        $this->registry->template->fil_subtitulo = "";
        $this->registry->template->fil_fecha = date("Y-m-d");
        $this->registry->template->fil_mes = $expediente->obtenerSelectMes();
        $this->registry->template->fil_anio = $expediente->obtenerSelectAnio();
        
        // idioma
        $idioma = new idioma ();        
        $this->registry->template->idi_id = $idioma->obtenerSelect();
        
        $this->registry->template->fil_proc = "";
        $this->registry->template->fil_firma = "";
        $this->registry->template->fil_cargo = "";
        
        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect();                
        $this->registry->template->fil_nrofoj = "";
        $this->registry->template->fil_tomovol = "";
        $this->registry->template->fil_nroejem = "";
        $this->registry->template->fil_nrocaj = "";
        $this->registry->template->fil_sala = "";
        $archivo = new archivo ();        
        $this->registry->template->fil_estante = $archivo->obtenerSelectEstante();        
        $this->registry->template->fil_cuerpo  = "";
        $this->registry->template->fil_balda = "";  
        
        // Presentacion        
        $this->registry->template->fil_tipoarch = "ADM";
        $this->registry->template->fil_mrb = "Bueno";
        
        $this->registry->template->fil_ori = "0";        
        $this->registry->template->fil_cop = "0";
        $this->registry->template->fil_fot = "0";
        
        
        $this->registry->template->fil_descripcion = "";
        
        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC();
        $arc = new archivo ();
        $this->registry->template->confidencialidad = $arc->loadConfidencialidad();        
        $this->registry->template->fil_obs = "";

        


        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;                
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;        
        $this->registry->template->controller = $seccion;
        $this->llenaDatos(VAR3);        
        $this->registry->template->show('regarchivo.tpl');
    }

    function addArchivo2($seccion) {
        
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];        
        
        // Descripción expediente
        $exp = new expediente ();
        if ($seccion == "estrucDocumental") {
            $this->registry->template->PATH_EVENT = "save";
            $this->registry->template->linkTree = $exp->linkTree($exp_id, $tra_id, $cue_id);
        } else {
            $this->registry->template->PATH_EVENT = "saveReg";
            $this->registry->template->linkTree = $exp->linkTreeReg($exp_id, $tra_id, $cue_id);
        }                        
        $this->registry->template->seccion = $seccion;
        
        

        // Documentos
        $this->registry->template->exp_id = $exp_id;
        $this->registry->template->tra_id = $tra_id;
        $this->registry->template->cue_id = $cue_id;
        $this->registry->template->exa_id = "";
        $contenedor = new contenedor ();
        $con_descrip = $contenedor->obtenerDescripcion($exp_id);
        
        $this->registry->template->fil_id = "";
        $this->registry->template->fil_codigo = "";
        $this->registry->template->required_archivo = "class='required'";
        
        // Correspondencia
        $this->registry->template->dco_id = "";
        $this->registry->template->fil_nur = "";
        $this->registry->template->fil_cite = "";
        $this->registry->template->fil_asunto = "";
        $this->registry->template->fil_sintesis = "";
        $this->registry->template->fil_nur_s = "";
        
        // Identificacion        
        $this->registry->template->fil_nro = "1";
        $cuerpos = new cuerpos(); 
        $expediente = new expediente();
        $this->registry->template->fil_titulo = utf8_encode(strtoupper($cuerpos->obtenerNombreCuerpo($cue_id)));
        $this->registry->template->fil_subtitulo = "";
        $this->registry->template->fil_fecha = date("Y-m-d");
        $this->registry->template->fil_mes = $expediente->obtenerSelectMes();
        $this->registry->template->fil_anio = $expediente->obtenerSelectAnio();        
        // idioma
        $idioma = new idioma ();        
        $this->registry->template->idi_id = $idioma->obtenerSelect();
        
        $this->registry->template->fil_proc = "";
        $this->registry->template->fil_firma = "";
        $this->registry->template->fil_cargo = "";
        
        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect();                
        $this->registry->template->fil_nrofoj = "";
        $this->registry->template->fil_tomovol = "";
        $this->registry->template->fil_nroejem = "";
        $this->registry->template->fil_nrocaj = "";
        $this->registry->template->fil_sala = "";
        $archivo = new archivo ();        
        $this->registry->template->fil_estante = $archivo->obtenerSelectEstante();        
        $this->registry->template->fil_cuerpo  = "";
        $this->registry->template->fil_balda = "";  
        
        // Presentacion        
        $this->registry->template->fil_tipoarch = "ADM";
        $this->registry->template->fil_mrb = "Bueno";
        
        $this->registry->template->fil_ori = "0";        
        $this->registry->template->fil_cop = "0";
        $this->registry->template->fil_fot = "0";
        
        
        $this->registry->template->fil_descripcion = "";
        
        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC();
        $arc = new archivo ();
        $this->registry->template->confidencialidad = $arc->loadConfidencialidad();        
        $this->registry->template->fil_obs = "";

        


        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;                
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;        
        $this->registry->template->controller = $seccion;
        $this->llenaDatos($exp_id);        
        $this->registry->template->show('regarchivo.tpl');
    }    


    function save() {
        //obtenemos los datos del expediente
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];
        
        //$ver_id = $_SESSION ['VER_ID'];
        //$ser_id = 0;
        $usu_id = 0;
        $trc_id = 0;
        $exc_id = 0;
        $con_id = 0;
        $this->expediente = new tab_expediente ();
        $sql = "SELECT * 
                FROM tab_expediente 
                WHERE exp_estado = 1 
                AND exp_id='$exp_id' ";
        $rows = $this->expediente->dbselectBySQL($sql);

        if (count($rows) == 1) {
            $ser_id = $rows [0]->getSer_id();
        }

//		$this->expunidad = new tab_expunidad ();
//		$rows_euv = $this->expunidad->dbselectBySQL ( "select * from tab_expunidad where euv_estado = 1
//						and exp_id='" . $exp_id . "' " );
//		if (count ( $rows_euv ) >= 1) {
//			$euv_id = $rows_euv [0]->getEuv_id ();
//			$uni_id = $rows_euv [0]->getUni_id ();
//		}

        $expusuario = new Tab_expusuario ();
        $sql = "SELECT *
                FROM tab_expusuario
                WHERE eus_estado = 1
		and exp_id='" . $exp_id . "' ";
        $rows_eus = $expusuario->dbselectBySQL($sql);
        if (count($rows_eus) >= 1) {
            $usu_id = $rows_eus [0]->getUsu_id();
        }

        $this->tramitecuerpos = new tab_tramitecuerpos ();
        $sql = "select *
                from tab_tramitecuerpos
                where tra_id=" . $tra_id . "
                and cue_id=" . $cue_id . " ";
        $rows = $this->tramitecuerpos->dbselectBySQL($sql);
        if (count($rows) >= 1) {
            $trc_id = $rows [0]->getTrc_id();
        }
        //print "ser_id: ".$ser_id."<br>"."euv_id: ".$euv_id."<br>"."uni_id: ".$uni_id."<br>usu_id: ".$usu_id."<br>trc_id: ".$trc_id;die();


        // Save Tab_archivo
        $fil_id = $this->saveArchivo();

        
        
        // Save Tab_archivo_digital
        ///////////////Aumentado por freddy///////////////////////////////////////////////////////////////////////////////////////////
        //$seccion = VAR3;
        $arc = new archivo ();
        $tarchivo = new tab_archivo ();
        //
        $archivo_digital = new tab_archivo_digital();
        //
        $tarchivo->setRequest2Object($_REQUEST);
        //$exp_id = $_REQUEST ['exp_id'];
        //$fil_id = $_REQUEST ['fil_id'];
        $sql = "SELECT *
                FROM tab_archivo
                WHERE fil_id = '$fil_id' ";
        $rows = $tarchivo->dbselectBySQL($sql);
        //$tarch = $rows [0];

        $archivo_type = $_FILES ["archivo"] ["type"];
        $archivo = $_FILES ["archivo"] ["tmp_name"];
        $archivo_size = $_FILES ["archivo"] ["size"];
        $archivo_name = $_FILES ["archivo"] ["name"];
        $nombre = basename($_FILES["archivo"]["name"]);
        $nombreFichero = $_FILES ["archivo"] ["name"];

        $archivo_name_array = explode(".", $archivo_name);
        $archivo_ext = array_pop($archivo_name_array);
        $archivo_sin_ext = implode($archivo_name_array);
        //$archivo_name = $arc->generarNombre($archivo_sin_ext);
        //$archivo_name = "";
        $archivo_cifrado = md5($archivo_name);
        $sis_tammax = 0;

        
        // Data Parameters
        $nombreDirectorio = "";
        $tsistema = new tab_sistema ();
        $sql = "SELECT *
                FROM tab_sistema";
        $rows2 = $tsistema->dbselectBySQL($sql);
        if (count($rows2) >= 1) {
            $sis_tipcarga = $rows2 [0]->sis_tipcarga;
            $sis_tammax = $rows2 [0]->sis_tammax;
            $nombreDirectorio = $rows2 [0]->sis_ruta;
        }


        // Verify size
        if ($archivo_size > $sis_tammax) {
            echo "El tamaño del archivo supera el permitido";
        } else {

            /*             * *************************************************** */
            /* TYPE SAVE BD */
            /*             * *************************************************** */
            $sis_tipcarga = 1;

            if ($sis_tipcarga == 1) {
                // SERVER
                $error = false;
                $copiarFichero = false;
                if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    //$nombreDirectorio = "img/";
                    $nombreFichero = $_FILES['archivo']['name'];
                    $copiarFichero = true;
                    $nombreCompleto = $nombreDirectorio . $nombreFichero;
                    if (is_file($nombreCompleto)) {
                        $idUnico = time();
                        $nombreFichero = $idUnico . "-" . $nombreFichero;
                    }
                } else if ($_FILES['archivo']['error'] == UPLOAD_ERR_FORM_SIZE) {
                    $maxsize = $_REQUEST['MAX_FILE_SIZE'];
                    $errores["archivo"] = "El tamanio del fichero supera el limite permitido ($maxsize bytes)!";
                    $error = true;
                } else if ($_FILES['archivo']['name'] == "")
                    $nombreFichero = '';
                else {
                    $errores["archivo"] = "No se ha podido subir el fichero!";
                    $msm_guardado_archivo = 0;
                    $error = true;
                }
                if ($error == false) {
                    $link = $archivo_digital->connect();
                    pg_query($link, "begin");
                    $sql = "INSERT INTO tab_archivo_digital(fil_id, 
                                                            fil_nomoriginal, 
                                                            fil_nomcifrado, 
                                                            fil_tipo, 
                                                            fil_tamano, 
                                                            fil_extension, 
                                                            nombre, 
                                                            mime, 
                                                            size, 
                                                            archivo, 
                                                            fil_estado) 
                                                   VALUES ($fil_id, 
                                                           '$nombreFichero', 
                                                           '$archivo_cifrado', 
                                                           '$archivo_type',
                                                           '$archivo_size' , 
                                                           '$archivo_ext' ,
                                                           '$nombre', 
                                                           '$archivo_type', 
                                                           $archivo_size, 
                                                           '$nombreFichero', 
                                                           1)";
                    pg_query($link, $sql) or die(pg_last_error($link));
                    pg_query($link, "commit");
                    if ($copiarFichero)
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $nombreDirectorio . $nombreFichero);
                    $msm_guardado_archivo = 1;    
                    
                }
            }
            else {
                // BD
                $link = $archivo_digital->connect();
                $fp = fopen($archivo, "rb");
                $contenido = fread($fp, filesize($archivo));
                fclose($fp);
                pg_query($link, "begin");
                $oid = pg_lo_create($link);
                $sql = "INSERT INTO tab_archivo_digital(fil_id, 
                                                        fil_nomoriginal, 
                                                        fil_nomcifrado, 
                                                        fil_tipo, 
                                                        fil_tamano, 
                                                        fil_extension, 
                                                        nombre, 
                                                        archivo_oid, 
                                                        mime, 
                                                        size, 
                                                        archivo) 
                                                VALUES ($fil_id, 
                                                        '$archivo_name', 
                                                        '$archivo_cifrado', 
                                                        '$archivo_type',
                                                        '$archivo_size', 
                                                        '$archivo_ext', 
                                                        '$nombre', 
                                                        $oid, 
                                                        '$archivo_type', 
                                                        $archivo_size, 
                                                        '$nombreFichero')";
                pg_query($link, $sql) or die(pg_last_error($link));
                $blob = pg_lo_open($link, $oid, "w");
                pg_lo_write($blob, $contenido);
                pg_lo_close($blob);
                pg_query($link, "commit");
                $msm_guardado_archivo = 1;    

            }

            //Guardar palabra clave
            if (!empty($_REQUEST['fil_descripcion'])) {
                $this->palclave = new tab_palclave();
                $pac_nombre = trim($_REQUEST['fil_descripcion']);
                $array = explode(SEPARATOR_SEARCH, $pac_nombre);
                for($j=0;$j<count($array);$j++){
                    $sql = "select pac_id from tab_palclave where pac_estado = 1 AND fil_id='$fil_id' AND pac_nombre='" . $array[$j] . "'";
                    $row = $this->palclave->dbSelectBySQL($sql);
                    if (count($row) == 0) {
                        $this->palclave->setFil_id($fil_id);
                        $this->palclave->setPac_nombre(strtoupper(trim($array[$j])));
                        $this->palclave->setPac_formulario('Documento');
                        $this->palclave->setPac_estado(1);
                        $this->palclave->insert();
                    }
                }               
           }


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($ser_id != 0 && $usu_id != 0 && $trc_id != 0) {

                if (isset($_REQUEST ["con_id"]) && $_REQUEST ["con_id"] != "") {
                    $con_id = $_REQUEST ["con_id"];
                    $suc_id = $_REQUEST ["suc_id"];
                    $expcontenedor = new tab_expcontenedor ();
                    $row_exc = $expcontenedor->dbselectBy3Field("suc_id", $suc_id, "exc_estado", "1", "exp_id", $exp_id);

                    if (count($row_exc) == 0) {
                        $exc_id = $this->saveContenedor($exp_id, $suc_id);
                    } else {
                        $exc_id = $row_exc [0]->exc_id;
                    }
                }
                
                
                $this->saveExpArchivo($fil_id, $exp_id, $tra_id, $cue_id);
                if ($_REQUEST ['accion'] == 'cargar') {
                    header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/" . $msm_guardado_archivo . "/");
                } else {
                    if ($_REQUEST ['accion'] == 'cargarnuevo') {
                        $this->addArchivo2("estrucDocumental");
                    }else{
                        Header("Location: " . PATH_DOMAIN . "/archivo/digitalizar/$exp_id/$fil_id/" . VAR3 . "/");
                    }
                }
            } else {
                header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/" . $msm_guardado_archivo . "/");
            }
        }
        
        
        
    }

    
    function saveArchivo() {
        //inserta un archivo
        $this->archivo = new tab_archivo ();
        $this->archivo->setRequest2Object($_REQUEST);
        $this->archivo->setFil_id('');
        $this->archivo->setFil_codigo(strtoupper($_REQUEST['fil_nro']));        
        $this->archivo->setFil_nro(strtoupper($_REQUEST['fil_nro']));
        if ($_REQUEST['fil_titulo2']){
            $this->archivo->setFil_titulo(strtoupper(utf8_encode($_REQUEST['fil_titulo'] . " Nro. ". $_REQUEST['fil_titulo2'] )));
        }else{
            $this->archivo->setFil_titulo(strtoupper(utf8_encode($_REQUEST['fil_titulo'])));
        }
        
        $this->archivo->setFil_subtitulo(strtoupper(utf8_encode($_REQUEST['fil_subtitulo'])));
        $this->archivo->setFil_fecha($_REQUEST['fil_fecha']);
        $this->archivo->setFil_mes($_REQUEST['fil_mes']);
        $this->archivo->setFil_anio($_REQUEST['fil_anio']);
        
        $this->archivo->setIdi_id($_REQUEST['idi_id']);
        $this->archivo->setFil_proc(strtoupper(utf8_encode($_REQUEST['fil_proc'])));
        $this->archivo->setFil_firma(strtoupper(utf8_encode($_REQUEST['fil_firma'])));
        $this->archivo->setFil_cargo(strtoupper(utf8_encode($_REQUEST['fil_cargo'])));
        $this->archivo->setSof_id($_REQUEST['sof_id']);
        $this->archivo->setFil_nrofoj(strtoupper($_REQUEST['fil_nrofoj']));
        $this->archivo->setFil_tomovol(strtoupper($_REQUEST['fil_tomovol']));
        $this->archivo->setFil_nroejem(strtoupper($_REQUEST['fil_nroejem']));
        $this->archivo->setFil_nrocaj(strtoupper($_REQUEST['fil_nrocaj']));
        $this->archivo->setFil_sala(strtoupper($_REQUEST['fil_sala']));
        $this->archivo->setFil_estante(strtoupper($_REQUEST['fil_estante']));
        $this->archivo->setFil_cuerpo(strtoupper($_REQUEST['fil_cuerpo']));
        $this->archivo->setFil_balda(strtoupper($_REQUEST['fil_balda']));
        $this->archivo->setFil_tipoarch($_REQUEST['fil_tipoarch']);
        $this->archivo->setFil_mrb($_REQUEST['fil_mrb']); 
        
        if ($_REQUEST['fil_ori']) $this->archivo->setFil_mrb($_REQUEST['fil_ori']); 
        if ($_REQUEST['fil_cop']) $this->archivo->setFil_mrb($_REQUEST['fil_cop']); 
        if ($_REQUEST['fil_fot']) $this->archivo->setFil_mrb($_REQUEST['fil_fot']); 
                
        $this->archivo->setFil_confidencialidad($_REQUEST ['fil_confidencialidad']);
        $this->archivo->setFil_obs(strtoupper(utf8_encode($_REQUEST ['fil_obs'])));        
        $this->archivo->setFil_estado('1');
        $fil_id = $this->archivo->insert();
        
        
        // Tab_doccorr
        $doccorr = new Tab_doccorr ();
        $doccorr->setFil_id($fil_id);
        if ($_REQUEST['fil_nur']) {
            $doccorr->setFil_nur($_REQUEST['fil_nur']);            
            if ($_REQUEST['fil_nur_s']) {
                $doccorr->setFil_nur_s(strtoupper($_REQUEST['fil_nur_s']));
            }
            if ($_REQUEST['fil_cite']) {
                $doccorr->setFil_cite(strtoupper($_REQUEST['fil_cite']));
            }        
            if ($_REQUEST['fil_asunto']) {
                $doccorr->setFil_asunto(strtoupper($_REQUEST['fil_asunto']));
            }        
            if ($_REQUEST['fil_sintesis']) {
                $doccorr->setFil_sintesis(strtoupper($_REQUEST['fil_sintesis']));
            }  
            $doccorr->setDco_estado(1);
            $dco_id = $doccorr->insert();
        }
        
        
        
        // Insert tab_doccampovalor
//        $doccampovalor = new Tab_doccampovalor(); 
//        $doccorr->setFil_id($fil_id);
//        if ($_REQUEST['dcp_id']) {
//            $doccampovalor->setDcp_id($_REQUEST['dcp_id']);
//        }        
//        $dcv_id = $doccampovalor->insert();
        
        return $fil_id;
    }

    
    
    
    // Debe ser
    // View documento
    // Modificado acastellon
    function update() {
        $exp_id = VAR3;
        $fil_id = VAR4;
        $seccion = VAR5;
        
        // Find ser_id
        $expediente = new tab_expediente ();
        $tab_expediente = $expediente->dbselectById($exp_id);
        $ser_id = $tab_expediente->getSer_id();
        
        // Tab_archivo
        $this->archivo = new tab_archivo();
        $row = $this->archivo->dbselectByField("fil_id", $fil_id);
        $row = $row[0];        
        

        
        // Tab_doccorr
        $tab_doccorr = new Tab_doccorr();
        $sql = "SELECT * 
                FROM tab_doccorr 
                WHERE fil_id='" . $row->fil_id . "'";
        $doccorr = $tab_doccorr->dbSelectBySQL($sql);
        if($doccorr){
            $doccorr = $doccorr[0];        
            // Nur
            $hojas_ruta = new hojas_ruta();
            $this->registry->template->dco_id = $doccorr->dco_id;
            $this->registry->template->fil_cite = $hojas_ruta->obtenerSelect($doccorr->fil_cite);
            $seguimientos = new seguimientos();
            $this->registry->template->fil_nur_s = $seguimientos->obtenerSelect($doccorr->fil_nur_s);

            $this->registry->template->fil_nur = $doccorr->fil_nur;
            $this->registry->template->fil_asunto = $doccorr->fil_asunto;
            $this->registry->template->fil_sintesis = $doccorr->fil_sintesis;
        }else{
            // Nur
            $this->registry->template->dco_id = "";
            $this->registry->template->fil_cite = "";
            $this->registry->template->fil_nur_s = "";
            $this->registry->template->fil_nur = "";
            $this->registry->template->fil_asunto = "";
            $this->registry->template->fil_sintesis = "";            
        }
//        $this->registry->template->fil_nur = "";
//        $this->registry->template->fil_asunto = "";
//        $this->registry->template->fil_sintesis = "";
//        $this->registry->template->fil_cite = "";
//        $this->registry->template->fil_nur_s = "";
        
       


        // Tab_exparchivo
        $sql = "SELECT * 
                FROM tab_exparchivo 
                WHERE fil_id='" . $row->fil_id . "'";
        $exa_row = $this->archivo->dbSelectBySQL($sql);
        $exa_row = $exa_row[0];
        $this->registry->template->exp_id = $exp_id;
        $this->registry->template->tra_id = $exa_row->tra_id;
        $this->registry->template->cue_id = $exa_row->cue_id;
        $this->registry->template->exa_id = $exa_row->exa_id;
        
        $expediente = new expediente ();
        // Tab_archivo
        $this->registry->template->seccion = $seccion;
        $this->registry->template->fil_id = $fil_id;
        $this->registry->template->fil_codigo = $row->fil_codigo;
        $this->registry->template->fil_nro = $row->fil_nro;
        $this->registry->template->fil_titulo = $row->fil_titulo;
        $this->registry->template->fil_subtitulo = $row->fil_subtitulo;
        $this->registry->template->fil_fecha = $row->fil_fecha;
        $this->registry->template->fil_mes = $expediente->obtenerSelectMes($row->fil_mes);
        $this->registry->template->fil_anio = $expediente->obtenerSelectAnio($row->fil_anio);        
        
        $idioma = new idioma ();        
        $this->registry->template->idi_id = $idioma->obtenerSelect($row->idi_id);

        $this->registry->template->fil_proc = $row->fil_proc;
        $this->registry->template->fil_firma = $row->fil_firma;
        $this->registry->template->fil_cargo = $row->fil_cargo;
        // Include dynamic fields
        $expcampo = new expcampo();
        $this->registry->template->filcampo = $expcampo->obtenerSelectCampos($ser_id);        
        $sopfisico = new sopfisico();
        $this->registry->template->sof_id = $sopfisico->obtenerSelect($row->sof_id);
        $this->registry->template->fil_nrofoj = $row->fil_nrofoj;
        $this->registry->template->fil_tomovol = $row->fil_tomovol;
        $this->registry->template->fil_nroejem = $row->fil_nroejem;
        $this->registry->template->fil_nrocaj = $row->fil_nrocaj;
        $this->registry->template->fil_sala = $row->fil_sala;
        $archivo = new archivo ();
        $this->registry->template->fil_estante = $archivo->obtenerSelectEstante($row->fil_estante);
        $this->registry->template->fil_cuerpo = $row->fil_cuerpo;
        $this->registry->template->fil_balda = $row->fil_balda;
        $this->registry->template->fil_tipoarch = $row->fil_tipoarch;
        $this->registry->template->fil_mrb = $row->fil_mrb;
        
        $this->registry->template->fil_ori = $row->fil_ori;
        $this->registry->template->fil_cop = $row->fil_cop;
        $this->registry->template->fil_fot = $row->fil_fot;
        
        $this->registry->template->fil_confidencilidad = $row->fil_confidencialidad;
        $this->registry->template->fil_obs = $row->fil_obs;
        
        $this->registry->template->required_archivo = "";        

        //palabras clave
        $palclave = new palclave();
        $this->registry->template->pac_nombre = $palclave->listaPC();
        $this->registry->template->fil_descripcion = $palclave->listaPCFile($row->fil_id);
        
        $arc = new archivo ();
        $this->registry->template->confidencialidad = $arc->loadConfidencialidad('1');
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $exp = new expediente ();
        if ($seccion == "estrucDocumental") {
            $this->registry->template->PATH_EVENT = "update_save";
            $this->registry->template->linkTree = $exp->linkTree($exp_id, $exa_row->tra_id, $exa_row->cue_id);
        } else {
            $this->registry->template->PATH_EVENT = "update_saveReg";
            $this->registry->template->linkTree = $exp->linkTreeReg($exp_id, $exa_row->tra_id, $exa_row->cue_id);
        }
        
        
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $this->registry->template->show('header');
        $this->registry->template->controller = $seccion;
        $this->llenaDatos(VAR3);
        $this->registry->template->show('regarchivo.tpl');
    }

    
    // Luego del View
    // Update despues del View
    function update_save() {
        //obtenemos los datos del expediente
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];
        //$ver_id = $_SESSION ['VER_ID'];
        $ser_id = 0;
        $usu_id = 0;
        $trc_id = 0;
        $exc_id = 0;
        $con_id = 0;
        $this->expediente = new tab_expediente ();
        $sql = "SELECT * 
                FROM tab_expediente
                WHERE exp_estado = 1 
                AND exp_id='$exp_id' ";
        $rows = $this->expediente->dbselectBySQL($sql);

        if (count($rows) == 1) {
            $ser_id = $rows [0]->getSer_id();
        }

        $expusuario = new Tab_expusuario ();
        $sql = "SELECT * 
                FROM tab_expusuario
                WHERE eus_estado = 1
                AND exp_id='" . $exp_id . "' ";
        $rows_eus = $expusuario->dbselectBySQL($sql);
        if (count($rows_eus) >= 1) {
            $usu_id = $rows_eus [0]->getUsu_id();
        }

        $this->tramitecuerpos = new tab_tramitecuerpos ();
        $sql = "SELECT * 
                FROM tab_tramitecuerpos 
                WHERE tra_id=" . $tra_id . " and cue_id=" . $cue_id . " ";
        $rows = $this->tramitecuerpos->dbselectBySQL($sql);
        if (count($rows) >= 1) {
            $trc_id = $rows [0]->getTrc_id();
        }

        $fil_id = $this->updateArchivo(); 
        
        if (!empty($_REQUEST['fil_descripcion'])) {
            $this->palclave = new tab_palclave();
            $pac_nombre = trim($_REQUEST['fil_descripcion']);
            $array = explode(SEPARATOR_SEARCH, $pac_nombre);
            for($j=0;$j<count($array);$j++){
                if ($array[$j]!='') {
                    $sql = "select pac_id from tab_palclave where pac_estado = 1 AND fil_id='$fil_id' AND pac_nombre='" . trim($array[$j]) . "'";
                    $row = $this->palclave->dbSelectBySQL($sql);
                    if (count($row) == 0) {
                        $this->palclave->setFil_id($fil_id);
                        $this->palclave->setPac_nombre(strtoupper(trim($array[$j])));
                        $this->palclave->setPac_formulario('Documento');
                        $this->palclave->setPac_estado(1);
                        $this->palclave->insert();
                    }
                }
            }
        }        


               

        
        // ********************************
        // Save Tab_archivo_digital
        ///////////////Aumentado por freddy///////////////////////////////////////////////////////////////////////////////////////////
        //$seccion = VAR3;
        $arc = new archivo ();
        $tarchivo = new tab_archivo ();
        //
        $archivo_digital = new tab_archivo_digital();
        //
        $tarchivo->setRequest2Object($_REQUEST);
        //$exp_id = $_REQUEST ['exp_id'];
        //$fil_id = $_REQUEST ['fil_id'];
        $sql = "SELECT *
                FROM tab_archivo
                WHERE fil_id = '$fil_id' ";
        $rows = $tarchivo->dbselectBySQL($sql);
        //$tarch = $rows [0];

        $archivo_type = $_FILES ["archivo"] ["type"];
        $archivo = $_FILES ["archivo"] ["tmp_name"];
        $archivo_size = $_FILES ["archivo"] ["size"];
        $archivo_name = $_FILES ["archivo"] ["name"];
        $nombre = basename($_FILES["archivo"]["name"]);
        $nombreFichero = $_FILES ["archivo"] ["name"];

        $archivo_name_array = explode(".", $archivo_name);
        $archivo_ext = array_pop($archivo_name_array);
        $archivo_sin_ext = implode($archivo_name_array);
        //$archivo_name = $arc->generarNombre($archivo_sin_ext);
        $archivo_name = "";
        $archivo_cifrado = md5($archivo_name);
        $sis_tammax = 0;

        
        // Data Parameters
        $nombreDirectorio = "";
        $tsistema = new tab_sistema ();
        $sql = "SELECT *
                FROM tab_sistema";
        $rows2 = $tsistema->dbselectBySQL($sql);
        if (count($rows2) >= 1) {
            $sis_tipcarga = $rows2 [0]->sis_tipcarga;
            $sis_tammax = $rows2 [0]->sis_tammax;
            $nombreDirectorio = $rows2 [0]->sis_ruta;
        }


        // Verify size
        if ($archivo_size > $sis_tammax) {
            echo "El tamaño del archivo supera el permitido";
        } else {

            /*             * *************************************************** */
            /* TYPE SAVE BD */
            /*             * *************************************************** */
            $sis_tipcarga = 1;

            if ($sis_tipcarga == 1) {
                $error = false;
                $copiarFichero = false;
                if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    //$nombreDirectorio = "img/";
                    $nombreFichero = $_FILES['archivo']['name'];
                    $copiarFichero = true;
                    $nombreCompleto = $nombreDirectorio . $nombreFichero;
                    if (is_file($nombreCompleto)) {
                        $idUnico = time();
                        $nombreFichero = $idUnico . "-" . $nombreFichero;
                    }
                } else if ($_FILES['archivo']['error'] == UPLOAD_ERR_FORM_SIZE) {
                    $maxsize = $_REQUEST['MAX_FILE_SIZE'];
                    $errores["archivo"] = "El tamanio del fichero supera el limite permitido ($maxsize bytes)!";
                    $error = true;
                } else if ($_FILES['archivo']['name'] == "")
                    $nombreFichero = '';
                else {
                    $errores["archivo"] = "No se ha podido subir el fichero!";
                    $msm_guardado_archivo = 0;
                    $error = true;
                }
                if ($error == false) {
                    $link = $archivo_digital->connect();
                    pg_query($link, "begin");
//                    $sql = "INSERT INTO tab_archivo_digital(fil_id, fil_nomoriginal, fil_nomcifrado, fil_tipo, fil_tamano, fil_extension, nombre, mime, size, archivo, fil_estado) 
//                                                   VALUES ($fil_id, '$nombreFichero', '$archivo_cifrado', '$archivo_type','$archivo_size' , '$archivo_ext' ,'$nombre', '$archivo_type', $archivo_size, '$nombreFichero', 1)";
                    $sql = "UPDATE tab_archivo_digital 
                            SET fil_nomoriginal='$nombreFichero', fil_nomcifrado='$archivo_cifrado', fil_tipo='$archivo_type', fil_tamano='$archivo_size', fil_extension='$archivo_ext', nombre='$nombre', mime='$archivo_type', size=$archivo_size, archivo='$nombreFichero', fil_estado=1 
                            WHERE fil_id = $fil_id ";
                    pg_query($link, $sql) or die(pg_last_error($link));
                    pg_query($link, "commit");
                    if ($copiarFichero)
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $nombreDirectorio . $nombreFichero);
                    $msm_guardado_archivo = 1;    //"Se subio correctamente el archivo";
                }
            }
            else {
                $link = $archivo_digital->connect();
                $fp = fopen($archivo, "rb");
                $contenido = fread($fp, filesize($archivo));
                fclose($fp);
                pg_query($link, "begin");
                $oid = pg_lo_create($link);
//                $sql = "INSERT INTO tab_archivo_digital(fil_id, fil_nomoriginal, fil_nomcifrado, fil_tipo, fil_tamano, fil_extensio, nombre, archivo_oid, mime, size, archivo) 
//                                                VALUES ($fil_id, '$archivo_name', '$archivo_cifrado', '$archivo_type','$archivo_size' , '$archivo_ext', '$nombre', $oid, '$archivo_type', $archivo_size, '$nombreFichero')";
                $sql = "UPDATE tab_archivo_digital
                        SET fil_nomoriginal='$archivo_name', fil_nomcifrado='$archivo_cifrado', fil_tipo='$archivo_type', fil_tamano='$archivo_size', fil_extension='$archivo_ext', nombre='$nombre', archivo_oid=$oid, mime='$archivo_type', size=$archivo_size, archivo='$nombreFichero', fil_estado=1 
                        WHERE fil_id = $fil_id ";
                
                pg_query($link, $sql) or die(pg_last_error($link));
                $blob = pg_lo_open($link, $oid, "w");
                pg_lo_write($blob, $contenido);
                pg_lo_close($blob);
                pg_query($link, "commit");
                $msm_guardado_archivo = 1;    //"Se subio correctamente el archivo"
            }


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($ser_id != 0 && $usu_id != 0 && $trc_id != 0) {
//                if (isset($_REQUEST ["con_id"]) && $_REQUEST ["con_id"] != "") {
//                    $con_id = $_REQUEST ["con_id"];
//                    $suc_id = $_REQUEST ["suc_id"];
//                    $expcontenedor = new tab_expcontenedor ();
//                    $row_exc = $expcontenedor->dbselectBy3Field("suc_id", $suc_id, "exc_estado", "1", "exp_id", $exp_id);
//
//                    if (count($row_exc) == 0) {
//                        $exc_id = $this->saveContenedor($exp_id, $suc_id);
//                    } else {
//                        $exc_id = $row_exc [0]->exc_id;
//                    }
//                }                                
                
                
                //$this->updateExpArchivo($fil_id, $exp_id, $tra_id, $cue_id);
                
                if ($_REQUEST ['accion'] == 'cargar') {
                    //Header ( "Location: " . PATH_DOMAIN . "/archivo/cargar/$exp_id/$fil_id/" . VAR3 . "/" );

                    header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/" . $msm_guardado_archivo . "/");
                } else {
                    Header("Location: " . PATH_DOMAIN . "/archivo/digitalizar/$exp_id/$fil_id/" . VAR3 . "/");
                }
            } else {
                header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/" . $msm_guardado_archivo . "/");
            }
        }
        
    }
    
    
    function updateArchivo() {
        //inserta un archivo
        $this->archivo = new tab_archivo ();
        $this->archivo->setRequest2Object($_REQUEST);
        $this->archivo->setFil_id($_REQUEST['fil_id']);        
        $this->archivo->setFil_codigo(strtoupper($_REQUEST['fil_nro']));        
        $this->archivo->setFil_nro(strtoupper($_REQUEST['fil_nro']));
        if ($_REQUEST['fil_titulo2']){
            $this->archivo->setFil_titulo(strtoupper(utf8_encode($_REQUEST['fil_titulo'] . " Nro. ". $_REQUEST['fil_titulo2'] )));
        }else{
            $this->archivo->setFil_titulo(utf8_encode(strtoupper($_REQUEST['fil_titulo'])));
        }        
        $this->archivo->setFil_subtitulo(utf8_encode(strtoupper($_REQUEST['fil_subtitulo'])));
        $this->archivo->setFil_fecha($_REQUEST['fil_fecha']);
        $this->archivo->setFil_mes($_REQUEST['fil_mes']);
        $this->archivo->setFil_anio($_REQUEST['fil_anio']);
        
        $this->archivo->setIdi_id($_REQUEST['idi_id']);
        $this->archivo->setFil_proc(strtoupper(utf8_encode($_REQUEST['fil_proc'])));
        $this->archivo->setFil_firma(strtoupper(utf8_encode($_REQUEST['fil_firma'])));
        $this->archivo->setFil_cargo(utf8_encode(strtoupper($_REQUEST['fil_cargo'])));
        $this->archivo->setSof_id($_REQUEST['sof_id']);
        $this->archivo->setFil_nrofoj(strtoupper($_REQUEST['fil_nrofoj']));
        $this->archivo->setFil_tomovol(strtoupper($_REQUEST['fil_tomovol']));
        $this->archivo->setFil_nroejem(strtoupper($_REQUEST['fil_nroejem']));
        $this->archivo->setFil_nrocaj(strtoupper($_REQUEST['fil_nrocaj']));
        $this->archivo->setFil_sala(strtoupper($_REQUEST['fil_sala']));
        $this->archivo->setFil_estante(strtoupper($_REQUEST['fil_estante']));
        $this->archivo->setFil_cuerpo(strtoupper($_REQUEST['fil_cuerpo']));
        $this->archivo->setFil_balda(strtoupper($_REQUEST['fil_balda']));
        $this->archivo->setFil_tipoarch($_REQUEST['fil_tipoarch']);
        $this->archivo->setFil_mrb($_REQUEST['fil_mrb']);        
        
        
        if ($_REQUEST['fil_ori']) $this->archivo->setFil_ori($_REQUEST['fil_ori']);
        if ($_REQUEST['fil_cop']) $this->archivo->setFil_cop($_REQUEST['fil_cop']);
        if ($_REQUEST['fil_fot']) $this->archivo->setFil_fot($_REQUEST['fil_fot']);
        
        
        $this->archivo->setFil_confidencialidad($_REQUEST ['fil_confidencialidad']);
        $this->archivo->setFil_obs(strtoupper(utf8_encode($_REQUEST ['fil_obs'])));        
        $this->archivo->setFil_estado('1');
        $fil_id = $this->archivo->update();
        
        
        // Tab_doccorr
        $doccorr = new Tab_doccorr ();
        $doccorr->setDco_id(1);
        $doccorr->setFil_id($fil_id);
        if ($_REQUEST['fil_nur']) {
            $doccorr->setFil_nur($_REQUEST['fil_nur']);
            
            if ($_REQUEST['fil_nur_s']) {
                $doccorr->setFil_nur(strtoupper($_REQUEST['fil_nur_s']));
            }
            if ($_REQUEST['fil_cite']) {
                $doccorr->setFil_cite(strtoupper($_REQUEST['fil_cite']));
            }        

            if ($_REQUEST['fil_asunto']) {
                $doccorr->setFil_asunto(strtoupper($_REQUEST['fil_asunto']));
            }        
            if ($_REQUEST['fil_sintesis']) {
                $doccorr->setFil_sintesis(strtoupper($_REQUEST['fil_sintesis']));
            }  
            $doccorr->setDco_estado(1);
            $dco_id = $doccorr->update();
        }        
        
        $this->archivo->update();
        return $_REQUEST['fil_id'];
        
        
    }

    //*********************
    // MODIFIED: CASTELLON
    //*********************
    function download() {

        /*         * *************************************************** */
        /* TYPE SAVE  */
        /*         * *************************************************** */
        $sis_tipcarga = 1;
        //
        $archivo_digital = new tab_archivo_digital();
        //
        // A BD
        if ($sis_tipcarga == 2) {
            $error = "";
            /*
              if (isset ( $_COOKIE [session_name ()] )) {
              if (session_is_registered ( 'USU_ID' )) { */

            if (isset($_POST ['fil_id_open'])) {
                $fil_id = $_POST ['fil_id_open'];
            } else {
                $fil_id = VAR3;
            }

            if ($fil_id != '') {
                $archivo = new tab_archivo ();
                $rowe = $archivo->dbSelectBySQL("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");
                if ($rowe [0]->fil_confidencialidad != '3') {
                    $rowa = $archivo->dbSelectBySQL("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");
                    $archivobin = new tab_archivobin ();
                    $row = $archivobin->dbSelectBySQLField("SELECT fil_contenido FROM tab_archivobin WHERE fil_id =  '" . $fil_id . "'");
                    if (count($row) == 1 || count($rowa) == 1) {
                        $sql = "SELECT
							tab_archivo.fil_id,
							tab_archivo.fil_nomoriginal,
							tab_archivo.fil_nomcifrado,
							tab_archivo.fil_tamano,
							tab_archivo.fil_extension,
							tab_archivo.fil_tipo,
							coalesce(tab_archivobin.fil_contenido,'-1') as fil_contenido
							FROM
							tab_archivo
							Inner Join tab_archivobin ON tab_archivo.fil_id = tab_archivobin.fil_id WHERE tab_archivobin.fil_id =  '" . $fil_id . "'";
                        $r_files = $archivo->dbSelectBySQLArchive($sql);
                        //
                        $link = $archivo_digital->connect();
                        $sql = "select fil_id, nombre, mime, size, coalesce(archivo_oid,'-1') as archivo_oid, coalesce(archivo_bytea,'-1') as archivo_bytea from tab_archivo_digital where fil_id=$fil_id";
                        $result = pg_query($link, $sql);
                        if (!$result || pg_num_rows($result) < 1) {
                            header("Location: index.php");
                            exit();
                        }
                        $row = pg_fetch_array($result, 0);
                        pg_free_result($result);
                        if ($row['archivo_bytea'] == -1 && $row['archivo_oid'] == -1)
                            die('No existe el archivo para mostrar o bajar');
                        pg_query($link, "begin");
                        $file = pg_lo_open($link, $row['archivo_oid'], "r");
                        header("Cache-control: private");
                        header("Content-type: $row[mime]");
                        //if($f==1) header("Content-Disposition: attachment; filename=\"$row[nombre]\"");
                        header("Content-length: $row[size]");
                        header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
                        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                        header("Cache-Control: no-cache, must-revalidate");
                        header("Pragma: no-cache");
                        pg_lo_read_all($file);
                        pg_lo_close($file);
                        pg_query($link, "commit");
                        pg_close($link);
                    } else {
                        $error = "No existe el archivo.";
                    }
                } else {
                    if (isset($_POST ['pass_open']) && $_POST ['pass_open'] != '') {
                        $usuario = new tab_usuario ();
                        $row_usu = $usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
                        $usuario = $row_usu [0];
                        if ($usuario->getUsu_leer_doc() == '1' && $usuario->getUsu_pass_leer() == md5($_POST ['pass_open'])) {
                            $archivo = new tab_archivo ();
                            $rowa = $archivo->dbSelectBySQLField("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");

                            $archivobin = new tab_archivobin ();
                            $row = $archivobin->dbSelectBySQLField("SELECT fil_contenido FROM tab_archivobin WHERE fil_id =  '" . $fil_id . "'");

                            if (count($row) == 1 || count($rowa) == 1) {
                                $sql = "SELECT
									tab_archivo.fil_id,
									tab_archivo.fil_nomoriginal,
									tab_archivo.fil_nomcifrado,
									tab_archivo.fil_tamano,
									tab_archivo.fil_extension,
									tab_archivo.fil_tipo,
									tab_archivobin.fil_contenido
									FROM
									tab_archivo
									Inner Join tab_archivobin ON tab_archivo.fil_id = tab_archivobin.fil_id WHERE tab_archivobin.fil_id =  '" . $fil_id . "'";

                                $r_files = $archivo->dbSelectBySQLArchive($sql);
                                header('Content-type:' . $r_files[0]->fil_tipo);
                                echo $r_files[0]->fil_contenido;
                            } else {
                                $error = "No existe el archivo.";
                            }
                        } else {
                            $error = 'Password incorrecto.';
                        }
                    } else {
                        $error = 'No tiene permisos para ver este archivo.';
                    }
                }
            } else {
                $error = 'No existe el archivo.';
            }
        } else {
            // A SERVER
            $error = "";
            if (isset($_POST ['fil_id_open'])) {
                $fil_id = $_POST ['fil_id_open'];
            } else {
                $fil_id = VAR3;
            }
            if ($fil_id != '') {
                //
                $link = $archivo_digital->connect();
                $sql = "select fil_id, nombre, mime, size, coalesce(archivo_oid,'-1') as archivo_oid, coalesce(archivo_bytea,'-1') as archivo_bytea from tab_archivo_digital where fil_id=$fil_id";
                $result = pg_query($link, $sql);
                if (!$result || pg_num_rows($result) < 1) {
                    header("Location: index.php");
                    exit();
                }
                $row = pg_fetch_array($result, 0);
                
                // Data Parameters
                $nombreDirectorio = "";
                $tsistema = new tab_sistema ();
                $sql = "SELECT *
                        FROM tab_sistema";
                $rows2 = $tsistema->dbselectBySQL($sql);
                if (count($rows2) >= 1) {
                    $sis_tipcarga = $rows2 [0]->sis_tipcarga;
                    $sis_tammax = $rows2 [0]->sis_tammax;
                    $nombreDirectorio = $rows2 [0]->sis_ruta;
                }      
                
                $archivopdf = $nombreDirectorio . $row[1];
                $len = filesize($archivopdf);
                
                //$archivopdf = PATH_DOMAIN ."/". $nombreDirectorio . $row[1];
                //$len = filesize($archivopdf);
                
                
                header("Cache-control: private");
                //header("Content-type: $row[mime]");
                header("Content-type: $row[2]");
                //header("Content-Disposition: attachment; filename='".$archivopdf."'");
                header("Content-length: $len");
                header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                readfile($archivopdf);
                pg_free_result($result);
                pg_close($link);
            }
        }
        if ($error != '')
            echo $error;
    }

    //********************
    // MODIFIED: CASTELLON
    //********************
    function delete() {
        $id = VAR3;
        $fil_id = VAR4;
        $seccion = VAR5;
        $exa = new Tab_exparchivo ();
        $arc = new Tab_archivo_digital ();
        $sql = "UPDATE tab_archivo_digital SET archivo_oid = 0, fil_estado =  '2' WHERE fil_id = '$fil_id' ";
        $arc->dbBySQL($sql);

        if (VAR5 == 'estrucDocumental') {
            $sql = "UPDATE tab_exparchivo SET exa_estado = '2' WHERE exp_id =  '$id' AND fil_id = '$fil_id' AND exa_estado =  '1'";
            $exa->dbBySQL($sql);
        }
        $sql = "UPDATE tab_archivo SET fil_estado = '2' WHERE fil_id = '$fil_id' AND fil_estado =  '1'";
        $exa->dbBySQL($sql);
        $msm = 2;
        Header("Location: " . PATH_DOMAIN . "/$seccion/viewTree/$id/$msm/");
    }
    
    

    function llenaDatos($id) {
        // Tab_expediente
//        $tab_expediente = new tab_expediente();
//        $row = $tab_expediente->dbselectByField("exp_id", $id);
//        $row = $row[0];                
//        $ser_id = $row->ser_id;
                
        $expediente = new tab_expediente ();
        $tab_expediente = $expediente->dbselectById($id);
        $ser_id = $tab_expediente->getSer_id();
        
        // Tab_expisadg
        $expisadg = new tab_expisadg();
        $expi = $expisadg->dbselectById($id);
        
        //$codigo = $exp->exp_codigo;
        $expediente = new expediente();
        //$tab_expediente = $tab_expediente->dbselectById($id);
        
        
        ;
        $tab_serie = new tab_series();
        $ser = $tab_serie->dbselectById($ser_id);
        //$tipo = $ser->tipo;
        
        
        $this->registry->template->detExpediente = "";
        $this->registry->template->detExpediente = $expediente->getDetalles($id);
        $this->registry->template->serie = $ser->ser_categoria;
        //$this->registry->template->serTipo = $tipo;
        $this->registry->template->exp_codigo = $tab_expediente->getExp_codigo();
        $this->registry->template->exp_fecha_exi = $expi->exp_fecha_exi;
        $this->registry->template->exp_fecha_exf = $expi->exp_fecha_exf;
        $this->registry->template->ubicacion = $expediente->getUbicacion($id);
        $this->registry->template->show('exp_detallesView.tpl');
    }

    
    function saveExpArchivo($fil_id, $exp_id, $tra_id, $cue_id) {
        //inserta en exparchivo
        $this->exparchivo = new tab_exparchivo ();
        $this->exparchivo->setExa_id('');
        $this->exparchivo->setFil_id($fil_id);
        $this->exparchivo->setExp_id($exp_id);
        $this->exparchivo->setTra_id($tra_id);
        $this->exparchivo->setCue_id($cue_id);
        $this->exparchivo->setExa_condicion('1');
        $this->exparchivo->setExa_estado(1);
        return $this->exparchivo->insert();
        //fin exparchivo
    }

    function updateExpArchivo($exa_id, $fil_id, $exp_id, $tra_id, $cue_id) {
        //inserta en exparchivo
        $this->exparchivo = new tab_exparchivo ();
        $this->exparchivo->setExa_id($exa_id);
        $this->exparchivo->setFil_id($fil_id);
        $this->exparchivo->setExp_id($exp_id);
        $this->exparchivo->setTra_id($tra_id);
        $this->exparchivo->setCue_id($cue_id);
        $this->exparchivo->setExa_condicion(1);
        $this->exparchivo->setExa_estado(1);
        return $this->exparchivo->update();
        //fin exparchivo
    }
    

    // Print Marbete
    function viewFicha() {
        $id = VAR3;
        $fil_id = VAR4;
        $seccion = VAR5;
        
        
        // Aqui
        $tarchivo = new tab_archivo ();
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id=" . $_SESSION['USU_ID'] . " AND
                tab_archivo.fil_id = '$fil_id' ";                
        $sql = "$select $from ";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;     
        $codigo = "";
        foreach ($result as $fila) {
            $codigo = $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->cue_codigo .  DELIMITER . $fila->fil_codigo;
        }        
        // Aqui
        

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Ficha de Documento');
        $pdf->SetSubject('Reporte de Ficha de Documento');
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
        // set default header data
        $pdf->SetHeaderData('logo_abc_comp.png', 20, 'Administradora Boliviana de Carreteras', $codigo);
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(5, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);               
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();

//        $pdf->SetXY(110, 200);
//        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 100, '', false, false, 1, false, false, false);

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('ficha_documento.pdf', 'I');        
        
    }
    
    function printFicha() {
        $exp_id = VAR3;
        $fil_id = VAR4;
        
        $tarchivo = new tab_archivo ();
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id=" . $_SESSION['USU_ID'] . " AND
                tab_archivo.fil_id = '$fil_id' ";                
        $sql = "$select $from ";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;     
        
        
        $this->usuario = new usuario ();
        
        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte Ficha del Documento ');
        $pdf->SetSubject('Reporte Ficha del Documento ');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, Sistema de Archivo Digital');
        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 20, 'ABC', 'Administradora Boliviana de Carreteras');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 14);
        // add a page
        $pdf->AddPage();
        // Report
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $cadena = "<br/><br/><br/><br/>";
        $cadena .= '<table width="580" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'Reporte Ficha del Documento';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left">Código: ' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->cue_codigo .  DELIMITER . $fila->fil_codigo .  '</td></tr>';
            $cadena .= '<tr><td align="left">Fondo: ' . $fila->fon_codigo  . '</td></tr>';
            $cadena .= '<tr><td align="left">Sección: ' . $fila->uni_descripcion . '</td></tr>';
            $cadena .= '<tr><td align="left">Serie: ' . $fila->ser_categoria . '</td></tr>';
            $cadena .= '<tr><td align="left">Expediente: ' . $fila->exp_titulo . '</td></tr>';            
            $cadena .= '<tr><td align="left">Tipo Documental: ' . $fila->cue_descripcion . '</td></tr>';
            $cadena .= '<tr><td align="left">Título: ' . $fila->fil_titulo . '</td></tr>';
            $cadena .= '<tr><td align="left">Subtítulo: ' . $fila->fil_subtitulo . '</td></tr>';
            $cadena .= '<tr><td align="left">Procedencia: ' . $fila->fil_proc . '</td></tr>';
            $cadena .= '<tr><td align="left">Firma: ' . $fila->fil_firma . '</td></tr>';
            $cadena .= '<tr><td align="left">Cargo: ' . $fila->fil_cargo . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Fojas: ' . $fila->fil_nrofoj . '</td></tr>';
            $cadena .= '<tr><td align="left">Tomos (Vols): ' . $fila->fil_tomovol . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Ejemplares: ' . $fila->fil_nroejem . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Caja: ' . $fila->fil_nrocaj . '</td></tr>';
            $cadena .= '<tr><td align="left">Sala: ' . $fila->fil_sala . '</td></tr>';
            
            $cadena .= '<tr><td align="left">Estante: ' . $fila->fil_estante . '</td></tr>';
            $cadena .= '<tr><td align="left">Cuerpo: ' . $fila->fil_cuerpo . '</td></tr>';
            $cadena .= '<tr><td align="left">Balda: ' . $fila->fil_balda . '</td></tr>';
            $cadena .= '<tr><td align="left">Tipo Archivo: ' . $fila->fil_tipoarch . '</td></tr>';
            $cadena .= '<tr><td align="left">Estado Doc.: ' . $fila->fil_mrb . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Originales: ' . $fila->fil_ori . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Copias: ' . $fila->fil_cop . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Fotocopias: ' . $fila->fil_fot . '</td></tr>';
            
            $cadena .= '<tr><td align="left">Disponibilidad: ' . $fila->disponibilidad . '</td></tr>';
            $cadena .= '<tr><td align="left">Archivo Digital: ' . $fila->fil_nomoriginal . '</td></tr>';
            $cadena .= '<tr><td align="left">Extensión: ' . $fila->fil_extension . '</td></tr>';
            $cadena .= '<tr><td align="left">Tamaño (MB): ' . $fila->fil_tamano . '</td></tr>';
            $cadena .= '<tr><td align="left">NUR/NURI: ' . $fila->fil_nur . '</td></tr>';
            $cadena .= '<tr><td align="left">Asunto/Referencias: ' . $fila->fil_asunto . '</td></tr>';
            $cadena .= '<tr><td align="left">Observaciones: ' . $fila->fil_obs . '</td></tr>';
            
            // Key words
            $palclave = new palclave();
            $cadena .= '<tr><td align="left">Palabras clave: ' . $palclave->listaPCFile($fila->fil_id) . '</td></tr>';
            
            
        }
        $cadena .= '</table>';
        //$cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // Close and output PDF document
        $pdf->Output('ficha_documento.pdf', 'I');        
        
    }
    
    
    function printFichaSearch() {
        $fil_id = VAR3;
        //$fil_id = VAR4;
        
        $tarchivo = new tab_archivo ();
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_subtitulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = "FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id=" . $_SESSION['USU_ID'] . " AND
                tab_archivo.fil_id = '$fil_id' ";
                
        $sql = "$select $from ";
        $result = $tarchivo->dbSelectBySQL($sql); //print $sql;        
        $this->usuario = new usuario ();
        
        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte Ficha del Documento ');
        $pdf->SetSubject('Reporte Ficha del Documento ');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, Sistema de Archivo Digital');
        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 20, 'ABC', 'Administradora Boliviana de Carreteras');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 14);
        // add a page
        $pdf->AddPage();
        // Report
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $cadena = "<br/><br/><br/><br/>";
        $cadena .= '<table width="580" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'Reporte Ficha del Documento';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left">Código: ' . $fila->fil_id . '</td></tr>';
            $cadena .= '<tr><td align="left">Fondo: ' . $fila->fon_codigo  . '</td></tr>';
            $cadena .= '<tr><td align="left">Sección: ' . $fila->uni_descripcion . '</td></tr>';
            $cadena .= '<tr><td align="left">Serie: ' . $fila->ser_categoria . '</td></tr>';
            $cadena .= '<tr><td align="left">Expediente: ' . $fila->exp_titulo . '</td></tr>';
            $cadena .= '<tr><td align="left">Código: ' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->cue_codigo .  DELIMITER . $fila->fil_codigo .  '</td></tr>';
            $cadena .= '<tr><td align="left">Tipo Documental: ' . $fila->cue_descripcion . '</td></tr>';
            $cadena .= '<tr><td align="left">Título: ' . $fila->fil_titulo . '</td></tr>';
            $cadena .= '<tr><td align="left">Subtítulo: ' . $fila->fil_subtitulo . '</td></tr>';
            $cadena .= '<tr><td align="left">Procedencia: ' . $fila->fil_proc . '</td></tr>';
            $cadena .= '<tr><td align="left">Firma: ' . $fila->fil_firma . '</td></tr>';
            $cadena .= '<tr><td align="left">Cargo: ' . $fila->fil_cargo . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Fojas: ' . $fila->fil_nrofoj . '</td></tr>';
            $cadena .= '<tr><td align="left">Tomos (Vols): ' . $fila->fil_tomovol . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Ejemplares: ' . $fila->fil_nroejem . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Caja: ' . $fila->fil_nrocaj . '</td></tr>';
            $cadena .= '<tr><td align="left">Sala: ' . $fila->fil_sala . '</td></tr>';
            
            $cadena .= '<tr><td align="left">Estante: ' . $fila->fil_estante . '</td></tr>';
            $cadena .= '<tr><td align="left">Cuerpo: ' . $fila->fil_cuerpo . '</td></tr>';
            $cadena .= '<tr><td align="left">Balda: ' . $fila->fil_balda . '</td></tr>';
            $cadena .= '<tr><td align="left">Tipo Archivo: ' . $fila->fil_tipoarch . '</td></tr>';
            $cadena .= '<tr><td align="left">Estado Doc.: ' . $fila->fil_mrb . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Originales: ' . $fila->fil_ori . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Copias: ' . $fila->fil_cop . '</td></tr>';
            $cadena .= '<tr><td align="left">Nro. Fotocopias: ' . $fila->fil_fot . '</td></tr>';
            
            $cadena .= '<tr><td align="left">Disponibilidad: ' . $fila->disponibilidad . '</td></tr>';
            $cadena .= '<tr><td align="left">Archivo Digital: ' . $fila->fil_nomoriginal . '</td></tr>';
            $cadena .= '<tr><td align="left">Extensión: ' . $fila->fil_extension . '</td></tr>';
            $cadena .= '<tr><td align="left">Tamaño (MB): ' . $fila->fil_tamano . '</td></tr>';
            $cadena .= '<tr><td align="left">NUR/NURI: ' . $fila->fil_nur . '</td></tr>';
            $cadena .= '<tr><td align="left">Asunto/Referencias: ' . $fila->fil_asunto . '</td></tr>';
            $cadena .= '<tr><td align="left">Observaciones: ' . $fila->fil_obs . '</td></tr>';
            
            
        }
        $cadena .= '</table>';
        //$cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // Close and output PDF document
        $pdf->Output('ficha_documento.pdf', 'I');        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    function digitalizar() {
        $this->menu = new menu ();
        $seccion = "estrucDocumental";
        if (!is_null(VAR5))
            $seccion = VAR5;
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $exp_id = VAR3;
        $fil_id = VAR4;
        $this->registry->template->seccion = $seccion;
        $this->registry->template->exp_id = $exp_id;
        $this->registry->template->fil_id = $fil_id;
        $this->registry->template->usu_id = $_SESSION ['USU_ID'];

        $tab_exparchivo = new Tab_exparchivo ();
        $rows_exa = $tab_exparchivo->dbselectBy3Field("exp_id", VAR3, "fil_id", VAR4, "exa_estado", "1");

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $exp = new expediente ();
        if ($seccion == "regularizar")
            $this->registry->template->linkTree = $exp->linkTreeReg(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);
        else
            $this->registry->template->linkTree = $exp->linkTree(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);

        if ($seccion == "regularizar")
            $this->registry->template->tituloEstructura = $this->tituloEstructuraR;
        else
            $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('digitalizararchivo.tpl');
    }



    function verifpass() {
        if (isset($_REQUEST ["exp_id"])) {
            if (isset($_REQUEST ['fil_id']) && isset($_REQUEST ['pass']) && $_REQUEST ['pass'] != "") {
                $usuario = new tab_usuario ();
                $row_usu = $usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
                $usuario = $row_usu [0];
                $fil_id = $_REQUEST ['fil_id'];
                if ($usuario->getUsu_leer_doc() == '1' && $usuario->getUsu_pass_leer() == md5($_REQUEST ['pass'])) {
                    /* $sw=1; */
                    //Header("location:".PATH_DOMAIN."/expediente/download/".$_REQUEST["fil_id"]."/".md5($_REQUEST['pass'])."/");
                    Header("location:" . PATH_DOMAIN . "/archivo/download/" . $fil_id . "/");
                    $res = 'ok';
                } else {
                    $res = 'Password incorrecto.';
                }
            } else {
                $res = 'Seleccione un archivo e introduzca el password para poder verlo.';
            }
        } else {
            $res = "No existe el expediente.";
        }
        echo $res;
    }

    function verifConfidencialidad() {
        $res = "Seleccione un archivo";
        if (isset($_REQUEST ['fil_id'])) {
            $fil_id = $_REQUEST ['fil_id'];
            $arc = new Tab_archivo ();
            $rowa = $arc->dbSelectBySQL("SELECT fil_confidencialidad from tab_archivo WHERE fil_id = '$fil_id'");
            if (count($rowa) > 0)
                $res = $arc->fil_confidencialidad;
        }
        return $res;
    }


    function regularizar() {
        $exa1 = new exparchivo ();
        $exa = $exa1->obtenerVacio(VAR3, VAR4, VAR5);
        if (!is_null($exa)) {
            header("Location: " . PATH_DOMAIN . "/archivo/view/$exa->exa_id/regularizar/");
        } else {
            $this->addArchivo("regularizar");
        }
    }


    function lisjson() {
        $fil = array();

        $ids = explode(",", $_REQUEST ['ids']);
        for ($i = 0; $i < count($ids); $i++) {
            if ($ids [$i]) {
                $tarc = new Tab_archivo ();
                //$fil[] = $tarc->dbselectById ( $ids[$i] );
                $sql = "SELECT DISTINCT
                        te.exp_id,
                        te.exp_nombre,
                        te.exp_descripcion,
                        te.exp_codigo,
                        ts.ser_categoria,
                        te.exp_fecha_exi,
                        te.exp_fecha_exf,
                        un.uni_codigo,
                        tu.usu_nombres,
                        tu.usu_apellidos
                FROM
                tab_expediente AS te
                Inner Join tab_expusuario AS eu ON eu.exp_id = te.exp_id
                Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
                Inner Join tab_usuario AS tu ON eu.usu_id = tu.usu_id
                Inner Join tab_unidad AS un ON tu.uni_id = un.uni_id
                Inner Join tab_expfondo AS ef ON ef.exp_id = te.exp_id
                INNER JOIN tab_expunidad euv ON euv.exp_id=te.exp_id
                INNER JOIN tab_usu_serie AS u ON u.ser_id = ts.ser_id
                        WHERE
                        te.exp_estado =  '1' AND
                        te.exp_id ='" . $ids [$i] . "' ";
                $fil [] = $tarc->dbselectBySQLj($sql);
            }
        }
        echo (json_encode($fil));
    }


}

?>