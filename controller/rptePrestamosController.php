<?php

/**
 * prestamosController.php Controller
 *
 * @package
 * @author Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class rptePrestamosController Extends baseController {

    function index() {


        //para el path y el menu
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rptePrestamos", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rptePrestamos.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {
        $spr_id = $_REQUEST["spr_id"];

//        $where = " AND tab_usuario.usu_id = " . $_SESSION['USU_ID'];
        $where = "";
        $where = " AND tab_solprestamo.spr_id = " . $spr_id;

        $order_by = "";
        $order_by.=" ORDER BY dpr_orden";


        $sql = "SELECT
                tab_solprestamo.spr_id,
                tab_solprestamo.spr_fecha,
                (SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_solprestamo.uni_id) AS uni_id,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usu_id) AS usu_id,
                tab_solprestamo.spr_solicitante,
                tab_solprestamo.spr_email,
                tab_solprestamo.spr_tel,
                tab_solprestamo.spr_fecent,
                tab_solprestamo.spr_fecren,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usua_id) AS usua_id,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usur_id) AS usur_id,
                tab_solprestamo.spr_fecdev,
                tab_solprestamo.spr_obs,
                tab_solprestamo.spr_estado,
                tab_docprestamo.dpr_orden,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_archivo.fil_codigo,
                tab_archivo.fil_titulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_tomovol,
                tab_sopfisico.sof_nombre,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_nrocaj,
                tab_docprestamo.dpr_obs
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_docprestamo ON tab_archivo.fil_id = tab_docprestamo.fil_id
                INNER JOIN tab_solprestamo ON tab_solprestamo.spr_id = tab_docprestamo.spr_id
                INNER JOIN tab_sopfisico ON tab_sopfisico.sof_id = tab_archivo.sof_id
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_docprestamo.dpr_estado = 1 AND
                tab_solprestamo.spr_estado = 1 " . $where . $order_by;


        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Prestamos');
        $pdf->SetSubject('Reporte de Prestamos');
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
        // set default header data
        $pdf->SetHeaderData('logo_abc_comp.png', 20, 'ABC', 'ADMINISTRADORA BOLIVIANA DE CARRETERAS');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(5, 30, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();

//        $pdf->SetXY(110, 200);
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $sqltop = "SELECT
                    tab_unidad.uni_descripcion,
                    tab_unidad.uni_codigo,
                    tab_rol.rol_titulo,
                    tab_rol.rol_cod
                    FROM
                    tab_unidad
                    INNER JOIN tab_usuario ON tab_usuario.uni_id = tab_unidad.uni_id
                    INNER JOIN tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                    WHERE tab_usuario.usu_estado = 1 AND tab_usuario.usu_id = " . $_SESSION['USU_ID'];

        $usuario = new Tab_usuario();
        $resultop = $usuario->dbselectBySQL($sqltop);

        $cadena = "<br/><br/><br/><br/><br/><br/><br/><br/>";

        if (count($resultop) > 0) {
            $cadena .= '<table width="760" border="0" cellpadding="2">';
            $cadena .= '<tr><td align="center">';
            $cadena .= '<span style="font-size: 24px;">' . $resultop[0]->uni_descripcion . ' (' . $resultop[0]->uni_codigo . ')</span>';
            $cadena .= '</td></tr>';
            $cadena .= '<tr><td align="center">';
            $cadena .= '<span style="font-size: 24px;">' . $resultop[0]->rol_titulo . ' (' . $resultop[0]->rol_cod . ')</span>';
            $cadena .= '</td></tr>';
            $cadena .= '<tr><td align="center">';
            $cadena .= '<span style="font-size: 30px;font-weight: bold;text-decoration: underline;">';
            $cadena .= 'FORMULARIO DE SALIDA DOCUMENTAL';
            $cadena .= '</span>';
            $cadena .= '</td></tr>';
            $cadena .= '<tr><td align="center">';
            $cadena .= '<span style="font-size: 24px;">(Para uso de las diferentes unidades y/o áreas solicitantes)</span>';
            $cadena .= '</td></tr>';
            $cadena .= '</table>';
            $cadena .= '<br/><br/>';
        }
        if (count($result) > 0) {

            $cadena .= '<table width="760" border="1" cellpadding="2">';
            $cadena .= '<tr>';
            $cadena .= '<td width="130" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">FECHA DE SOLICITUD:</span></td>';
            $cadena .= '<td width="130"><span style="font-size: 14px;">' . $result[0]->spr_fecha . '</span></td>';
            $cadena .= '<td width="130" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">Ubicado:</span></td>';
            $cadena .= '<td width="130"><span style="font-size: 14px;">' . $result[0]->spr_fecha . '</span></td>';
            $cadena .= '<td width="130" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">N DE PRÉSTAMO:</span></td>';
            $cadena .= '<td width="110"><span style="font-size: 14px;">' . 'no hay query' . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">GCIA/UNIDAD/ÁREA:</span></td>';
            $cadena .= '<td width="130"><span style="font-size: 14px;">' . $result[0]->uni_id . '</span></td>';
            $cadena .= '<td width="130" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SOLICITADO POR:</span></td>';
            $cadena .= '<td colspan="3"><span style="font-size: 14px;">' . 'no hay query' . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '</table>';
            
        }
        $cadena .= '<table width="760" border="1" cellpadding="2">';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">N</span></td>';
        $cadena .= '<td width="70" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Código de Referencia</span></td>';
        $cadena .= '<td width="120" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Documento Solicitado</span></td>';
        $cadena .= '<td width="70" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Productor</span></td>';
        $cadena .= '<td width="60" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Firma</span></td>';
        $cadena .= '<td width="60" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Fechas Extremas</span></td>';
        $cadena .= '<td width="35" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Tomo/Vol.</span></td>';
        $cadena .= '<td width="35" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Sop. Fis.</span></td>';
        $cadena .= '<td width="35" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">N Fojas</span></td>';
        $cadena .= '<td width="175" colspan="5" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Localización Topográfica</span></td>';
        $cadena .= '<td width="70" rowspan="2" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Observaciones</span></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="35" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Sala</span></td>';
        $cadena .= '<td width="35" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Estante</span></td>';
        $cadena .= '<td width="35" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Cuerpo</span></td>';
        $cadena .= '<td width="35" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Balda</span></td>';
        $cadena .= '<td width="35" align="center" valign="middle"><span style="font-size: 11px;font-weight: bold;">Caja</span></td>';
        $cadena .= '</tr>';

        foreach ($result as $fila) {

            $cadena .= '<tr>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->dpr_orden . '</span></td>';
            $cadena .= '<td width="70"><span style="font-size: 11px;">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->fil_codigo . '</span></td>';
            $cadena .= '<td width="120"><span style="font-size: 11px;">' . $fila->fil_titulo . '</span></td>';
            $cadena .= '<td width="70"><span style="font-size: 11px;">' . $fila->fil_proc . '</span></td>';
            $cadena .= '<td width="60"><span style="font-size: 11px;">' . $fila->fil_firma . '</span></td>';
            $cadena .= '<td width="60"><span style="font-size: 11px;">' . 'no hay query' . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_tomovol . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->sof_nombre . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_nrofoj . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_sala . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_estante . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_cuerpo . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_balda . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_nrocaj . '</span></td>';
            $cadena .= '<td width="70"><span style="font-size: 11px;">' . $fila->dpr_obs . '</span></td>';
            $cadena .= '</tr>';
        }
        $cadena .= '</table>';

        if (count($result) > 0) {
            $cadena .= '<br/>';
            $cadena .= '<table width="760" border="1" cellpadding="2">';
            $cadena .= '<tr>';
            $cadena .= '<td width="130" height="50"><span style="font-size: 14px;font-weight: bold;">Nombre Completo del Solicitante:</span></td>';
            $cadena .= '<td width="500" height="50"><span style="font-size: 14px;">' . $result[0]->spr_solicitante . '</span></td>';
            $cadena .= '<td width="130" height="50" align="center"><span style="font-size: 14px;">Firma</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130"><span style="font-size: 14px;font-weight: bold;">Documento Retirado del Archivo:</span></td>';
            $cadena .= '<td colspan="2"><span style="font-size: 14px;">' . 'no hay query' . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130"><span style="font-size: 14px;font-weight: bold;">Fecha Entrega Doc.:</span></td>';
            $cadena .= '<td colspan="2"><span style="font-size: 14px;">' . $result[0]->spr_fecha . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130" height="50"><span style="font-size: 14px;font-weight: bold;">Nombre Completo del que Autoriza:</span></td>';
            $cadena .= '<td width="500" height="50"><span style="font-size: 14px;">' . $result[0]->usua_id . '</span></td>';
            $cadena .= '<td width="130" height="50" align="center"><span style="font-size: 14px;">Firma</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130" height="50"><span style="font-size: 14px;font-weight: bold;">Archivista Responsable:</span></td>';
            $cadena .= '<td width="500" height="50"><span style="font-size: 14px;">' . $result[0]->usur_id . '</span></td>';
            $cadena .= '<td width="130" height="50" align="center"><span style="font-size: 14px;">Firma</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr bordercolor="#FFFFFF">';
            $cadena .= '<td colspan="3"><span style="font-size: 14px">Llenado unicamente por el personal de archivo</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130"><span style="font-size: 14px;font-weight: bold;">Fecha de Devolución:</span></td>';
            $cadena .= '<td colspan="2"><span style="font-size: 14px;">' . $result[0]->spr_fecdev . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr>';
            $cadena .= '<td width="130"><span style="font-size: 14px;font-weight: bold;">Observaciones:</span></td>';
            $cadena .= '<td colspan="2"><span style="font-size: 14px;">' . $result[0]->spr_obs . '</span></td>';
            $cadena .= '</tr>';
            $cadena .= '<tr bordercolor="#FFFFFF">';
            $cadena .= '<td colspan="3"><span style="font-size: 14px"><strong>Nota:</strong> A través de este formulario cada funcionario se responsabiliza por el cuidado o cualquier deterioro del documento.</span></td>';
            $cadena .= '</tr>';
            $cadena .= '</table>';
        }
        //echo ($cadena);

        $pdf->writeHTML($cadena, true, false, false, false, '');
        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }

}

?>
