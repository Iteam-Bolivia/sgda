<?php

/**
 * buscarArchivoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class buscarArchivoController extends baseController {

    function index() {
        $tseries = new series();
        $series = "";
        if ($_SESSION["ROL_COD"] == "AA" || $_SESSION["ROL_COD"] == "AC" || $_SESSION["ROL_COD"] == "AI") {
            $series = $tseries->obtenerSelectTodas();
        } else {
            $series = $tseries->obtenerSelectSeries();
        }
        
        $departamento = new departamento();        
        $this->registry->template->dep_id = $departamento->obtenerSelect();        
        $fondo = new fondo();        
        $this->registry->template->fon_id = $fondo->obtenerSelectFondos();
        $this->registry->template->uni_id = "";
        $this->registry->template->ser_id = ""; 
        //$this->registry->template->exp_id = ""; 
        $this->registry->template->tra_id = "";
        $this->registry->template->cue_id = "";
        
        $tmenu = new menu ();
        $liMenu = $tmenu->imprimirMenu("buscarArchivo", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->registry->template->UNI_ID = $_SESSION['UNI_ID'];
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "search";
        $this->registry->template->PATH_EVENT2 = "verifpass";
        $this->registry->template->PATH_EVENT_VERIF_PASS = "verifpass";
        $this->registry->template->PATH_EVENT3 = "download";
        $this->registry->template->PATH_EVENT4 = "getConfidencialidad";
        $this->registry->template->PATH_EVENT_EXPORT = "exportar";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerBuscador');
        $this->registry->template->show('buscarArchivo.tpl');
        $this->registry->template->show('footer');
    }

    function search() { 
        $archivo = new archivo();
        $request = $this->setRequestTrim($_REQUEST);
        $json = $archivo->buscar($request);
        echo $json;
    }
    
    
    function setRequestTrim($request) {        
        /*
          $object = array(); 
          foreach ( $request as $field => $value ) {
            $request[$field] = html_entity_decode(trim($request[$field], ENT_QUOTES) );
            //print($field."<br>");
          }
          return $object; 
         */        
        
        $result['page'] = $_REQUEST["page"];
        $result['rp'] = $_REQUEST["rp"];
        $result['sortname'] = $_REQUEST["sortname"];
        $result['sortorder'] = $_REQUEST["sortorder"];
        
//        if (isset($_REQUEST["fon_id"])) {
//            $result['fon_id'] = html_entity_decode(trim($_REQUEST["fon_id"]), ENT_QUOTES);
//        }    
        
        if (isset($_REQUEST["palabra"])) {
            $result['palabra'] = html_entity_decode(trim(strtoupper($_REQUEST["palabra"])), ENT_QUOTES);
        }  

        if (isset($_REQUEST["fil_nur"])) {
            $result['fil_nur'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_nur"])), ENT_QUOTES);
        } 
        
        if (isset($_REQUEST["uni_id"])) {
            $result['uni_id'] = html_entity_decode(trim($_REQUEST["uni_id"]), ENT_QUOTES);
        }  
        
        if (isset($_REQUEST["ser_id"])) {
            $result['ser_id'] = html_entity_decode(trim($_REQUEST["ser_id"]), ENT_QUOTES);
        }
        
        if (isset($_REQUEST["tra_id"])) {
            $result['tra_id'] = html_entity_decode(trim($_REQUEST["tra_id"]), ENT_QUOTES);
        }
        
        if (isset($_REQUEST["cue_id"])) {
            $result['cue_id'] = html_entity_decode(trim($_REQUEST["cue_id"]), ENT_QUOTES);
        }
        
        if (isset($_REQUEST["exp_titulo"])) {
            $result['exp_titulo'] = html_entity_decode(trim(strtoupper($_REQUEST["exp_titulo"])), ENT_QUOTES);
        }        
              
        if (isset($_REQUEST["fil_titulo"])) {
            $result['fil_titulo'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_titulo"])), ENT_QUOTES);
        }     

        if (isset($_REQUEST["pac_nombre"])) {
            $result['pac_nombre'] = html_entity_decode(trim(strtoupper($_REQUEST["pac_nombre"])), ENT_QUOTES);
        } 

        if (isset($_REQUEST["fil_subtitulo"])) {
            $result['fil_subtitulo'] = html_entity_decode(strtoupper(trim($_REQUEST["fil_subtitulo"])), ENT_QUOTES);
        } 

        if (isset($_REQUEST["fil_proc"])) {
            $result['fil_proc'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_proc"])), ENT_QUOTES);
        } 
        
        if (isset($_REQUEST["fil_firma"])) {
            $result['fil_firma'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_firma"])), ENT_QUOTES);
        } 
        
        if (isset($_REQUEST["fil_cargo"])) {
            $result['fil_cargo'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_cargo"])), ENT_QUOTES);
        }         
      
        if (isset($_REQUEST["fil_tipoarch"])) {
            // MODIFICAR ESTE PARAMETRO POR EL MOMENTO ESTA RECIBIENDO VACIO
            //$result['fil_tipoarch'] = html_entity_decode(trim(strtoupper($_REQUEST["fil_tipoarch"])), ENT_QUOTES);
            $result['fil_tipoarch'] = html_entity_decode(trim(strtoupper("")), ENT_QUOTES);
        }         

        
        return $result;
    }    
   
    
    // Reporte para Buscar documentos
    function rpteBuscar() {
        $archivo = new archivo();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $where = ""; 
        
//        if (isset($_REQUEST ['fon_id'])) {
//            $where .= " AND tab_fondo.fon_id='$_REQUEST ['fon_id']' ";            
//        }
//        if (isset($_REQUEST ['uni_id'])) {
//            $where .= " AND tab_unidad.uni_id='$_REQUEST ['uni_id']' ";            
//        }
//        if (isset($_REQUEST ['ser_id'])) {
//            $where .= " AND tab_series.ser_id='$ser_id' ";           
//        }
//        if (!is_null($_REQUEST ['tra_id'])) {
//            $where .= " AND tab_tramite.tra_id='$tra_id' ";            
//        }
//        if (!is_null($_REQUEST ['cue_id'])) {
//            $where .= " AND tab_cuerpos.cue_id='$cue_id' ";            
//        }
//        if (!is_null($_REQUEST ['exp_titulo'])) {
//            $where .= " AND tab_expisadg.exp_titulo='$exp_titulo' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exi'])) {
//            $where .= " AND tab_expisadg.exp_fecha_exi='$exf_fecha_exi' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exf'])) {
//            $where .= " AND tab_expisadg.exf_fecha_exf='$exf_fecha_exi' ";            
//        }        
        
        $usu_id = $_SESSION['USU_ID'];
        
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
                tab_expusuario.usu_id='$usu_id' ";
        
               
//        if (isset($_REQUEST ['fon_id'])) {
//            $where .= " AND tab_fondo.fon_id='$fon_id' ";            
//        }
//        if (isset($_REQUEST ['uni_id'])) {
//            $where .= " AND tab_unidad.uni_id='$uni_id' ";            
//        }
//        if (isset($_REQUEST ['ser_id'])) {
//            $where .= " AND tab_series.ser_id='$ser_id' ";           
//        }
//        if (!is_null($_REQUEST ['tra_id'])) {
//            $where .= " AND tab_tramite.tra_id='$tra_id' ";            
//        }
//        if (!is_null($_REQUEST ['cue_id'])) {
//            $where .= " AND tab_cuerpos.cue_id='$cue_id' ";            
//        }
//        if (!is_null($_REQUEST ['exp_titulo'])) {
//            $where .= " AND tab_expisadg.exp_titulo='$exp_titulo' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exi'])) {
//            $where .= " AND tab_expisadg.exp_fecha_exi='$exf_fecha_exi' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exf'])) {
//            $where .= " AND tab_expisadg.exf_fecha_exf='$exf_fecha_exi' ";            
//        }
        

//        $fil_nur
//        $fil_nur
//        $fil_titulo
//        $fil_descripcion        
        
        $sql = "$select $from $where ";
        $result = $tarchivo->dbSelectBySQL($sql);         
        $this->usuario = new usuario ();
        
        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Buscar Archivo ');
        $pdf->SetSubject('Reporte de Buscar Archivo ');
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
        $pdf->SetFont('helvetica', '', 6);
        // add a page
        $pdf->AddPage();
        // Report
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $cadena = "<br/><br/><br/><br/><br/><br/>";
        $cadena .= '<table width="780" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'Reporte de Búsqueda de Documentos';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left">Código: ' . "" . '</td></tr>';
            $cadena .= '<tr><td align="left">Sección Remitente: ' . ""  . '</td></tr>';
            $cadena .= '<tr><td align="left">Dirección y Teléfono: ' . "" . '</td></tr>';
            $cadena .= '</table>';
            break;
        }
        // Header
        $cadena .= '<table width="700" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Fondo</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Sección</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Expediente</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Tipo Doc.</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Cod.Doc.</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Titulo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Proc.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Firma</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Cargo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.Foj.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.Caja</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Sala</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Estante</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Cuerpo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Balda</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Tipo</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Estado</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Ori</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Cop</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Fot</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>NUR/NURI</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Asunto/Ref.</strong></div></td>';
        $cadena .= '<td width="40"><div align="center"><strong>Disponibilidad</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Doc.Digital</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Tamaño</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Obs.</strong></div></td>';
        
        
        
        $cadena .= '</tr>';
        $numero = 1;
        foreach ($result as $fila) {
            $cadena .= '<tr>';
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="20">' . $fila->fon_codigo .  '</td>';
            $cadena .= '<td width="50">' . $fila->uni_descripcion .  '</td>';
            $cadena .= '<td width="50">' . $fila->ser_categoria .  '</td>';
            $cadena .= '<td width="50">' . $fila->exp_titulo .  '</td>';
            $cadena .= '<td width="50">' . $fila->cue_descripcion .  '</td>';
            $cadena .= '<td width="80">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->cue_codigo .  DELIMITER . $fila->fil_codigo .  '</td>';
            $cadena .= '<td width="50">' . $fila->fil_titulo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_proc .  '</td>';
            $cadena .= '<td width="20">' . $fila->fil_firma . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_cargo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_nrofoj . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_nrocaj . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_sala . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_estante . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_cuerpo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_balda . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_tipoarch . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_mrb . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_ori . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_cop . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_fot . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_nur . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_asunto . '</td>';
            $cadena .= '<td width="40">' . $fila->disponibilidad . '</td>';
            $cadena .= '<td width="50">' . $fila->fil_nomoriginal . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_tamano . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_obs . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }            
        
        $cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_buscar_archivo.pdf', 'I');
    }
    
    
    
    function exportar() {
//        $zip = new zipArchive2();
//        //$zip->addFile($path, $codigo);
//        $dir = getcwd() . "/img/";
//        $dirs = getcwd() . "/uploads/";
//        $zip->addDir('paver');
//        $zip->addFile($dir.'1Z0-0511.pdf', 'paver/1Z0-0511.pdf');
//        $pathSave = $dirs . "algo.zip"; 
//        $zip->saveZip($pathSave);
//        $zip->downloadZip($pathSave);

        $fil = new Tab_archivo();
        $exp = new Tab_expediente();
        $fil_zip = '';
        $fil->setRequest2Object($_REQUEST);
        $msg = 'Hubo un error al exportar los archivos intentelo de nuevo.';
        /////$cid = @ftp_connect (PATH_FTPHOST);
        try {
            if (isset($_REQUEST) && strlen($_REQUEST['fil_ids']) > 0) {
                $fil_ids = substr($_REQUEST['fil_ids'], 0, -1);
                //selecciÃƒÂ³n de los expedientes para conformar las carpetas
                $sql = "SELECT DISTINCT
                            te.exp_id,
                            te.exp_nombre,
                            te.exp_codigo
                            FROM
                            tab_expediente AS te
                            Inner Join tab_exparchivo AS tea ON tea.exp_id = te.exp_id
                            WHERE
                            tea.fil_id IN($fil_ids) AND
                            tea.exa_estado = '1' 
                             ORDER BY 1";
                $rows = $exp->dbSelectBySQL($sql);
                if (count($rows) > 0) {
//                        $dir = getcwd() . "\upload\\"; //realpath("/");
                    $dir = getcwd() . "/uploads/"; //realpath("/");
                    //$fil_origen = "Nuevo.zip";
                    $fil_destino = "Export_" . date("Ymd_His") . "_" . $_SESSION['USU_ID'] . ".zip";
                    //$ftp_destino = ftp_pwd($cid);
                    //copy($dir.$fil_origen, $dir.$fil_destino );
                    //print_r(ftp_site($cid, "cp archivo.txt $fil_destino"));
                    // archivo a copiar/subir
                    //ftp_get($cid, $fil_destino, $fil_origen, FTP_BINARY);
                    //ftp_put($cid, $fil_destino, $fil_origen, FTP_BINARY);
                    //ftp_put($cid, $dir.$fil_destino, $fil_destino, FTP_BINARY);
                    //echo $fil_destino."--".$fil_origen;
//                        $dir_array = array();
//                        $zip = new ZipArchive();
                    $zip = new zipArchive2();

                    $fil_zip = $dir . $fil_destino;
//                        $res = $zip->open($fil_zip, ZipArchive::CREATE);
//                        if ($res === TRUE) {
//                            $i = 0;
                    $dir_destinosw = '';
                    foreach ($rows as $exp) {
                        //creamos la carpeta
                        $dir_destino = substr(addslashes($exp->exp_nombre), 0, 30) . "_" . $exp->exp_codigo;
                        //$dir_array[$i++] = $dir_destino;
                        //@ftp_mkdir($cid, $dir_destino);
                        //$msg = $dir_destino;
//                                if ($zip->addEmptyDir($dir_destino)) {
                        if ($dir_destino == !$dir_destinosw) {
                            $zip->addDir($dir_destino);
                        }
                        $sql_fil = "SELECT DISTINCT
                                            ta.fil_id,
                                            ta.fil_nomcifrado,
                                            ta.fil_nomoriginal,
                                            ta.fil_extension,  
                                            tab.archivo_bytea
                                            FROM
                                            tab_archivo AS ta
                                            INNER JOIN tab_archivo_digital tab ON ta.fil_id =  tab.fil_id
                                            Inner Join tab_exparchivo AS tea ON tea.fil_id = ta.fil_id
                                            WHERE
                                        ta.fil_id IN  ($fil_ids) AND
                                        tea.exp_id =  '$exp->exp_id' AND
                                        ta.fil_estado = '1' "; //echo($sql_fil." ... ");$i++;if($i==3) die(" fin");
                        $r_files = $fil->dbSelectBySQLArchive($sql_fil);
                        if (count($r_files) > 0) {
                            foreach ($r_files as $file) {
                                $fil_origen = $file->fil_nomcifrado;
                                $fil_destino = $file->fil_nomoriginal;
//                                            $zip->addFromString($dir_destino . '/' . $fil_destino . "." . $file->fil_extension);
                                $dirAr = getcwd() . '/img/' . $fil_destino . "." . $file->fil_extension;
                                $zip->addFile($dirAr, $dir_destino . "/" . $fil_destino . "." . $file->fil_extension);
                            }
                            $msg = "ok";
                        } else {
                            $msg.="<br>No se encontraron archivos";
                        }
//                                } else {
//                                    $msg.="<br>NO CREO EL DIRECTORIO " . $dir_destino;
//                                }
                        $dir_destinosw = $dir_destino;
                    }
                    $zip->saveZip($fil_zip);
//                    $zip->close();
//                    $msg = 'OK';
//                        } else {
//                            $msg.="<br>No se pudo abrir el archivo zip";
//                        }
                } else {
                    $msg.="<br>No existen expedientes relacionados al(los) archivo(s)";
                }
            } else {
                $msg.="<br>No existen archivos a exportar";
            }
        } catch (Exception $e) {
            // @ftp_close ( $cid );
        }
        $msg = 'OK';
        $arr = array('res' => $msg, 'archivo' => $fil_zip);
        echo json_encode($arr);
        //echo $msg;
    }

    function descargar() {
        $nomArchivo = $_REQUEST['nomArchivo'];
        $file = $nomArchivo; //getcwd()."\upload/".$nomArchivo;

        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($file));
        header("Content-Disposition: attachment; filename=\"$nomArchivo\"");
        echo file_get_contents($file);
        unlink($file);
    }

    function loadAjaxUnidades() {
        $fon_id = $_POST["Fon_id"];
        $sql = "SELECT 
                uni_id,
                uni_par,
                uni_descripcion
		FROM
		tab_unidad
		WHERE
                tab_unidad.uni_estado =  '1' AND
                tab_unidad.fon_id =  '$fon_id'
                ORDER BY uni_cod ";
        $unidad = new tab_unidad();
        $result = $unidad->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            if ($row->uni_par=='-1'){
                $res[$row->uni_id] = $row->uni_descripcion;
            }else{
                $res[$row->uni_id] = "----- " . $row->uni_descripcion;
            }
        }
        echo json_encode($res);
    }        
    
    function loadAjaxSeries() {
        $uni_id = $_POST["Uni_id"];
        $sql = "SELECT 
                ser_id,
                ser_par,
                ser_categoria
		FROM
		tab_series
		WHERE
                tab_series.ser_estado =  '1' AND
                tab_series.uni_id =  '$uni_id'
                ORDER BY ser_codigo ";
        $series = new tab_series();
        $result = $series->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            if ($row->ser_par=='-1'){
                $res[$row->ser_id] = $row->ser_categoria;
            }else{
                $res[$row->ser_id] = "-- " . $row->ser_categoria;
            }
        }
        echo json_encode($res);
    }    
    
    function loadAjaxTramites() {
        $ser_id = $_POST["Ser_id"];
        $sql = "SELECT
                tab_series.ser_id,
                tab_tramite.tra_id,
                tab_tramite.tra_orden,
                tab_tramite.tra_descripcion
                FROM
                tab_series
                INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
                WHERE tab_serietramite.sts_estado = 1
                AND tab_series.ser_id =  '$ser_id'
                ORDER BY tab_tramite.tra_orden ";
        $tramite = new tab_tramite();
        $result = $tramite->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->tra_id] = $row->tra_descripcion;
        }
        echo json_encode($res);
    }   
    
    
    function loadAjaxCuerpos() {
        $tra_id = $_POST["Tra_id"];
        $sql = "SELECT
                tab_tramite.tra_id,
                tab_cuerpos.cue_id,
                tab_cuerpos.cue_orden,
                tab_cuerpos.cue_descripcion
                FROM
                tab_tramite
                INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                WHERE tab_tramitecuerpos.trc_estado = 1
                AND tab_tramite.tra_id =  '$tra_id'
                ORDER BY tab_cuerpos.cue_orden ";
        $cuerpos = new Tab_cuerpos();
        $result = $cuerpos->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->cue_id] = $row->cue_descripcion;
        }
        echo json_encode($res);
    }  
    

}

?>
