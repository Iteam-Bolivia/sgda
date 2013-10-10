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
class buscarArchivoRecibidoController extends baseController {
    /* var $envia = array('ser_id'=>'','exp_codigo'=>'','exp_nombre'=>'','tra_id'=>'','cue_id'=>'',
      'exf_fecha_exi'=>'', 'exf_fecha_exf'=>'', 'archivo'=>'', 'fil_descripcion'=>''); */

    function index() {
        $tseries = new series();
        $tramite = new tramitecuerpos ();
        $fondos = new fondo();
        $empresas_ext = new empresas_ext();

        $this->registry->template->tramites = $empresas_ext->obtenerSelect();
        //$this->registry->template->tramites = $tramite->obtenerSelectTramites("");
        // REVISED CASTELLON
        $this->registry->template->cuerpos = $tramite->obtenerSelectCuerpos("");
        //
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
        // ERROR: REVISED CASTELLON
        $this->registry->template->show('headerBuscador');
        $this->registry->template->show('buscarArchivoRecibido.tpl');
        $this->registry->template->show('footer');
    }

    function search() { //print("ingreso a search");die;
        $arc = new archivo();
        $envia = $arc->setRequestTrim($_REQUEST);
        //print_r($_REQUEST);die;
        $resultado = $arc->buscar($envia);
        //echo json_encode($datos);
    }

    function imprimirPdf() {
        $exp_codigo = $_REQUEST['exp_codigo'];
        $exp_nombre = $_REQUEST['exp_nombre'];
        $tra_id = $_REQUEST['tra_id'];
        $exf_fecha_exi = $_REQUEST['exf_fecha_exi'];
        $exf_fecha_exf = $_REQUEST['exf_fecha_exf'];
        $ser_id = 1; // 1= correspondencia recibida 2= correspondencia enviada
        $fi = "";
        $ff = "";
        $expediente = new tab_expediente();
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');

        $select = "SELECT DISTINCT ta.fil_id, ta.fil_nomoriginal, (ta.fil_tamano/1048576) AS fil_tamano, ta.fil_tipo, ta.fil_descripcion, ta.fil_confidencialidad, te.exp_id, te.exp_nombre, te.exp_codigo,te.exp_descripcion, ts.ser_categoria, tt.tra_codigo, tt.tra_descripcion, tc.cue_codigo, tc.cue_descripcion, (CASE tea.exa_condicion WHEN '1' THEN 'DISPONIBLE' WHEN '2' THEN 'PRESTADO' END) AS disponibilidad, tin.ins_nombre, tf.fon_descripcion, (SELECT (ttipo.ctp_codigo || ' ' || ttc.con_codigo) as contenedor FROM tab_contenedor ttc Inner Join tab_exparchivo AS ttea ON ttea.con_id = ttc.con_id Inner Join tab_tipocontenedor AS ttipo ON ttc.ctp_id = ttipo.ctp_id WHERE ttea.fil_id=ta.fil_id) as contenedor,
            (SELECT (tipo.ctp_codigo || ' ' || ts.suc_nro) as subcontenedor FROM tab_exparchivo AS ea Inner Join tab_subcontenedor AS ts ON ea.suc_id = ts.suc_id Inner Join tab_tipocontenedor AS tipo ON ts.ctp_id = tipo.ctp_id WHERE ea.fil_id=ta.fil_id) as subcontenedor, te.emp_id, te.exp_fecha_exi, te.exp_fecha_exf ";
        $from = "FROM
            tab_archivo AS ta Inner Join tab_exparchivo AS tea ON tea.fil_id = ta.fil_id Inner Join tab_expediente AS te ON te.exp_id = tea.exp_id Inner Join tab_expusuario AS exu ON exu.exp_id = tea.exp_id Inner Join tab_usuario AS tu ON tu.usu_id = exu.usu_id Inner Join tab_series AS ts ON te.ser_id = ts.ser_id Inner Join tab_tramite AS tt ON tea.tra_id = tt.tra_id Inner Join tab_cuerpos AS tc ON tea.cue_id = tc.cue_id Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id Inner Join tab_institucion AS tin ON tin.ins_id = tun.ins_id Inner Join tab_expfondo AS tef ON tef.exp_id = te.exp_id Inner Join tab_fondo AS tf ON tf.fon_id = tef.fon_id
            WHERE
            tea.exa_estado =  '1' AND ta.fil_estado =  '1' AND te.exp_estado =  '1' AND exu.eus_estado =  '1' AND tef.exf_estado =  '1' AND ta.fil_nomoriginal IS NOT NULL  AND ta.fil_nomoriginal <>  '' ";

        $where = "";
        if ($_SESSION['ROL_COD'] != 'ADM') {
            $where .= " AND ( exu.usu_id = '" . $_SESSION['USU_ID'] . "' OR te.usu_env_id='" . $_SESSION['USU_ID'] . "' )";
        }
        if (strlen($ser_id) > 0) {
            $where .= " AND te.ser_id='$ser_id' ";
        }
        if (strlen($exp_codigo) > 0) {
            $where .= " AND te.exp_codigo LIKE '%$exp_codigo%' ";
        }
        if (strlen($exp_nombre) > 0) {
            $where .= " AND te.exp_nombre LIKE '%$exp_nombre%' ";
        }
        if (strlen($tra_id) > 0) {
            $where .= " AND te.emp_id='$tra_id' ";
        }
//		if(strlen($cue_id)>0) {
//			$where .= " AND tc.cue_id='$cue_id' ";
//		}
        if (strlen($exf_fecha_exi) > 0) {
            $where .= " AND te.exp_fecha_exf>='$exf_fecha_exi' ";
            $fi = date("d/m/Y", strtotime($exf_fecha_exi));
        }
        if (strlen($exf_fecha_exf) > 0) {
            $where .= " AND te.exp_fecha_exf<='$exf_fecha_exf' ";
            $ff = date("d/m/Y", strtotime($exf_fecha_exf));
        }
        $sql = "$select $from $where ";
        $result = $expediente->dbSelectBySQL($sql);
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Iteam');
        $pdf->SetTitle('Listado de Filtro');
        $pdf->SetSubject('Filtro de Correspondencia Recibida');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(20, 20, 20);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();

        $fechaimpresion = date("d") . "-" . date("m") . "-" . date("Y");
        $horaimpresion = date("H") . ":" . date("i") . ":" . date("s");

        $pdf->SetFont('times', 'B', 6);
        $pdf->Cell(50, 6, 'Fecha Impresion:' . $fechaimpresion, 0, 0, 'L', 2, '', 0);
        $pdf->Cell(50, 6, 'Hora Impresion:' . $horaimpresion, 0, 0, 'L', 2, '', 0);
        $pdf->Cell(50, 6, '', 0, 1, 'L', 0, '', 0);
        $pdf->SetFont('times', 'B', 10);
        $pdf->Cell(80, 10, 'CORRESPONDENCIA RECIBIDA', 0, 0, 'L', 0, '', 0);
        $pdf->Cell(80, 10, $fi . ' - ' . $ff, 0, 0, 'R', 0, '', 0);
        $pdf->Cell(80, 10, '', 0, 1, 'R', 0, '', 0);

        $pdf->SetFont('times', '', 9);
        $empresa_ext = new empresas_ext();
        $contador = 1;
        if (strlen($tra_id) > 0) {
            $cadena = "";
            $cadena .= '<table width="100%" border="1" >';
            $cadena .= '<tr colspan="5"><td width="450"><b>EMPRESA : </b>' . $empresa_ext->obtenerNombre($result[0]->emp_id) . '</td></tr>
            <tr align="center">
<td width="50"><b>Nro.</b></td>
<td width="60"><b>C&Oacute;DIGO</b></td>
<td width="80"><b>FECHA DOCUMENTO</b></td>
<td width="80"><b>FECHA RECEPCI&Oacute;N</b></td>
<td width="180"><b>REFERENCIA</b></td>
                    </tr>';
            foreach ($result as $un) {
                $cadena .='<tr>
<td width="50" align="right">&nbsp;&nbsp;' . $contador . '&nbsp;&nbsp;</td>
<td width="60">&nbsp;&nbsp;' . $un->exp_codigo . '</td>
<td width="80" align="center">&nbsp;&nbsp;' . date("d/m/Y", strtotime($un->exp_fecha_exi)) . '</td>
<td width="80" align="center">&nbsp;&nbsp;' . date("d/m/Y", strtotime($un->exp_fecha_exf)) . '</td>
<td width="180">&nbsp;&nbsp;' . $un->exp_descripcion . '</td>
            </tr>';

                $contador++;
            }

            $cadena .= '</table>';
        } else {
            $cadena = "";
            $cadena .= '<table width="100%" border="1" >';
            $cadena .= '<tr align="center">
<td width="20"><b>Nro.</b></td>
<td width="60"><b>C&Oacute;DIGO</b></td>
<td width="120"><b>EMPRESA</b></td>
<td width="80"><b>FECHA DOCUMENTO</b></td>
<td width="80"><b>FECHA RECEPCI&Oacute;N</b></td>
<td width="160"><b>REFERENCIA</b></td>
                    </tr>';
            foreach ($result as $un) {
                $cadena .='<tr>
<td width="20"align="right">&nbsp;&nbsp;' . $contador . '&nbsp;&nbsp;</td>
<td width="60">&nbsp;&nbsp;' . $un->exp_codigo . '</td>
<td width="120">&nbsp;&nbsp;' . $empresa_ext->obtenerNombre($un->emp_id) . '</td>
<td width="80" align="center">&nbsp;&nbsp;' . date("d/m/Y", strtotime($un->exp_fecha_exi)) . '</td>
<td width="80" align="center">&nbsp;&nbsp;' . date("d/m/Y", strtotime($un->exp_fecha_exf)) . '</td>
<td width="160">&nbsp;&nbsp;' . $un->exp_descripcion . '</td>
            </tr>';

                $contador++;
            }

            $cadena .= '</table>';
        }

        $pdf->writeHTML($cadena, true, false, false, false, '');
        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('filtro_correspondecia_recibida.pdf', 'I');
    }

    function exportar() {
        $fil = new Tab_archivo();
        $exp = new Tab_expediente();
        $fil_zip = '';
        $fil->setRequest2Object($_REQUEST);
        $msg = 'Hubo un error al exportar los archivos intentelo de nuevo.';
        /////$cid = @ftp_connect (PATH_FTPHOST);
        try {
            ////$resultado = @ftp_login ( $cid, PATH_FTPUSER, PATH_FTPPASS );
            if (1) {/////$cid && $resultado) {
                //@ftp_pasv ( $cid, true );
                if (isset($_REQUEST) && strlen($_REQUEST['fil_ids']) > 0) {
                    $fil_ids = substr($_REQUEST['fil_ids'], 0, -1);
                    //selecciÃ¯Â¿Â½n de los expedientes para conformar las carpetas
                    $sql = "SELECT DISTINCT
                            te.exp_id,
                            te.exp_nombre,
                            te.exp_codigo
                            FROM
                            tab_expediente AS te
                            Inner Join tab_exparchivo AS tea ON tea.exp_id = te.exp_id
                            WHERE
                            tea.fil_id IN($fil_ids) AND
                            tea.exa_estado = '1' ";
                    $rows = $exp->dbSelectBySQL($sql);
                    if (count($rows) > 0) {
                        $dir = getcwd() . "\upload\\"; //realpath("/");
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
                        $dir_array = array();
                        $zip = new ZipArchive;

                        $fil_zip = $dir . $fil_destino;
                        $res = $zip->open($fil_zip, ZipArchive::CREATE);
                        if ($res === TRUE) {
                            $i = 0;
                            foreach ($rows as $exp) {
                                //creamos la carpeta
                                $dir_destino = substr(addslashes($exp->exp_nombre), 0, 30) . "_" . $exp->exp_codigo;
                                //$dir_array[$i++] = $dir_destino;
                                //@ftp_mkdir($cid, $dir_destino);
                                //$msg = $dir_destino;
                                if ($zip->addEmptyDir($dir_destino)) {
                                    $sql_fil = "SELECT DISTINCT
                                        ta.fil_id,
                                        ta.fil_nomcifrado,
                                        ta.fil_nomoriginal,
                                        ta.fil_extension,  tab.fil_contenido
                                        FROM
                                        tab_archivo AS ta
                                        INNER JOIN tab_archivobin tab ON ta.fil_id =  tab.fil_id
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

                                            $zip->addFromString($dir_destino . '/' . $fil_destino . "." . $file->fil_extension, html_entity_decode($file->fil_contenido));
                                        }
                                        $msg = "ok";
                                    } else {
                                        $msg.="<br>No se encontraron archivos";
                                    }
                                } else {
                                    $msg.="<br>NO CREO EL DIRECTORIO " . $dir_destino;
                                }
                            }
                            $zip->close();
                            $msg = 'OK';
                        } else {
                            $msg.="<br>No se pudo abrir el archivo zip";
                        }
                    } else {
                        $msg.="<br>No existen expedientes relacionados al(los) archivo(s)";
                    }
                } else {
                    $msg.="<br>No existen archivos a exportar";
                }
                //@ftp_close ( $cid );
            } else {
                $msg.="<br>No se pudo conectar al servidor";
            }
        } catch (Exception $e) {
            // @ftp_close ( $cid );
        }
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

}

?>
