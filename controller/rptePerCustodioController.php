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

class rptePerCustodioController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte_serie";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rptePerCustodio", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rptePerCustodio.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte_serie() {

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_series = $_REQUEST["filtro_series"];
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_EXI') {
            $order_by.=" ORDER BY tef.exf_fecha_exi ASC";
        }
        if ($tipo_orden == 'FECHA_EXF') {
            $order_by.=" ORDER BY tef.exf_fecha_exf ASC";
        }

        //para el where
        $where = "";
        $where .= "  AND teu.usu_id  =  '" . $_SESSION["USU_ID"] . "' ";


        //filtros
        if ($filtro_series != '') {
            $where.=" AND te.ser_id =  '$filtro_series' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");
        $sql = "SELECT
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                teu.usu_id,
                tef.exf_fecha_exi,
                tef.exf_fecha_exf,
                stc.con_codigo,
                sttc.ctp_codigo
                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_expusuario AS teu ON te.exp_id = teu.exp_id
                Inner Join tab_expfondo AS tef ON te.exp_id = tef.exp_id
                INNER JOIN tab_expcontenedor AS stec ON stec.exp_id = te.exp_id
                INNER JOIN tab_subcontenedor sub ON sub.suc_id = stec.suc_id
                INNER JOIN tab_contenedor AS stc ON stc.con_id = sub.con_id
                INNER JOIN tab_tipocontenedor AS sttc ON sttc.ctp_id = stc.ctp_id
                WHERE
                te.exp_estado =  '1' AND
                teu.eus_estado =  '1' AND
                tef.fon_id =  '1' AND
                tef.exf_estado =  '1'
                AND stec.exc_estado =  '1'" . $where . $order_by;

        //echo ($sql); die ();
        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Expedientes');
        $pdf->SetSubject('Reporte de Expedientes');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
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
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();
        $cadena = "<br/><br/><br/>";
        $cadena .= '<table width="500" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '</td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'REPORTE DE EXPEDIENTES REGISTRADOS POR FUNCIONARIO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboracion: ' . $fecha_actual . '</td></tr>';

        $usu = $_SESSION['USU_ID'];
        $this->usuario = new usuario ();
        $cadena .= '<tr><td align="left"> Funcionario: ' . $this->usuario->obtenerNombre($usu) . ' </td></tr>';
        //revisar porq no devuelve unidad
        $unidad = new unidad();
        $result1 = $unidad->obtenerUnidadUsuario($usu);
        //echo ($usu); die ();
        foreach ($result1 as $fila1) {
            $cadena .= '<tr><td align="left"> Unidad: ' . $fila1->uni_descripcion . ' <br/></td></tr>';
        }
        $cadena .= '</table>';
        $cadena .= '<table width="500" border="1" cellpadding="2">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .='<td width="120"><div align="center"><strong>Título</strong></div></td>';
        $cadena .='<td width="60"><div align="center"><strong>Fecha Extrema Inicial</strong></div></td>';
        $cadena .='<td width="60"><div align="center"><strong>Fecha Extrema Final</strong></div></td>';
        $cadena .='<td width="70"><div align="center"><strong>Unidad de Instalación</strong></div></td>';
        $cadena .='</tr>';

        $numero = 1;
        foreach ($result as $fila) {

            $cadena .='<tr>';
            $cadena .='<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .='<td width="70">' . $fila->exp_codigo . '</td>';
            $cadena .='<td width="90">' . $fila->ser_categoria . '</td>';
            $cadena .='<td width="120">' . $fila->exp_nombre . '</td>';
            $cadena .='<td width="60"><div align="center">' . $fila->exf_fecha_exi . '</div></td>';
            $cadena .='<td width="60"><div align="center">' . $fila->exf_fecha_exf . '</div></td>';
            $cadena .='<td width="70">' . $fila->con_codigo . ' ' . $fila->ctp_codigo . '</td>';
            $cadena .='</tr>';
            $numero++;
        }

        $cadena .='</table>';
        //echo ($cadena);

        $pdf->writeHTML($cadena, true, false, false, false, '');
        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_expediente.pdf', 'I');
    }

}

?>
