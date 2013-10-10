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
class rptePrestamosNoDevueltosController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();
        $par_institucion = new pinstitucion();
        $this->registry->template->optInstitucion = $par_institucion->obtenerSelect();
        $tipofondo = false;
        if ($_SESSION["ROL_COD"] == "ADM") {
            $tipofondo = true;
        }
        $this->registry->template->tipofondo = $tipofondo;

        //para el path y el menu
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rptePrestamosNoDevueltos", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rptePrestamosNoDevueltos.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

        $tipo_clasificado = $_REQUEST["tipo_clasificado"];
        if ($tipo_clasificado == "SERIE") {
            $this->verRpte_noDevuelto_series();
        }
        if ($tipo_clasificado == "INSTITUCION") {
            $this->verRpte_noDevuelto_Institucion();
        }
    }

    function verRpte_noDevuelto_series() {

        //$tipo_clasificado = "SERIE";
        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_series = $_REQUEST["filtro_series"];
        $filtro_institucion = $_REQUEST["filtro_institucion"];
        $f_prestdesde = $_REQUEST["f_prestdesde"];
        $f_presthasta = $_REQUEST["f_presthasta"];
        $f_devodesde = $_REQUEST["f_devodesde"];
        $f_devohasta = $_REQUEST["f_devohasta"];

        $where = "";
        $cabezera = "";
        if ($_SESSION["ROL_COD"] == "SUBF") {
            $where .= " AND tef.fon_id =  '2' ";
            $cabezera.="FONDO";
        } elseif ($_SESSION["ROL_COD"] == "ACEN") {
            $where .= " AND tef.fon_id =  '3' ";
            $cabezera.="ARCHIVO CENTRAL";
        }
        if ($_SESSION["ROL_COD"] != "ADM") {
            $where .= "  AND tun.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
            $where .= "  AND teu.usu_id  =  '" . $_SESSION["USU_ID"] . "' ";
        }

        if ($_SESSION["ROL_COD"] == "ADM") {
            $tipo_fondo = $_REQUEST["tipo_fondo"];
            if ($tipo_fondo == "SUBFONDO") {
                $where .= " AND tef.fon_id =  '2' ";
                $cabezera.="FONDO";
            }
            if ($tipo_fondo == "ARCENTRAL") {
                $where .= " AND tef.fon_id =  '3' ";
                $cabezera.="ARCHIVO CENTRAL";
            }
        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY te.ser_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'INSTITUCION') {
            $order_by.=" ORDER BY te.ser_id ASC, pint.int_descripcion  ASC";
        }
        if ($tipo_orden == 'PER_SOLICITANTE') {
            $order_by.=" ORDER BY te.ser_id ASC, tpr.pre_solicitante ASC";
        }
        if ($tipo_orden == 'NOM_EXPEDIENTE') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'COD_REF') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_codigo ASC";
        }

        /* $add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "SERIE") {
          $add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY te.ser_id ";
          } */
        //PARA LOS FILTROS

        if ($filtro_series != '') {
            $where.=" AND te.ser_id =  '$filtro_series' ";
        }
        if ($filtro_institucion != '') {
            $where.=" AND pint.int_id =  '$filtro_institucion' ";
        }
        if ($f_prestdesde != '' && $f_presthasta != '') {
            $where.=" AND DATE(tpr.pre_fecha_pres)  BETWEEN '$f_prestdesde' AND '$f_presthasta' ";
        }
        if ($f_devodesde != '' && $f_devohasta != '') {
            $where.=" AND DATE(tpr.pre_fecha_dev)  BETWEEN '$f_devodesde' AND '$f_devohasta' ";
        }
//para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "
            SELECT
            te.exp_id,
            te.exp_nombre,
            te.exp_codigo,
            te.ser_id,
            ts.ser_categoria,
            tpr.pre_solicitante,
            tpr.pre_descripcion,
            tpr.pre_fecha_pres,
            tpr.pre_fecha_dev,
            pint.int_descripcion ,
            tpr.pre_justificacion,
           (
                 SELECT (stc.con_codigo || ' ' || sttc.ctp_codigo)
                FROM tab_expcontenedor AS stec
                INNER JOIN tab_contenedor AS stc ON stc.con_id = stec.con_id
                INNER JOIN tab_tipocontenedor AS sttc ON sttc.ctp_id = stc.ctp_id
                WHERE stec.exc_estado = '1'
                AND stec.exp_id =te.exp_id
                LIMIT 1 OFFSET 0
            ) as contenedor
            FROM
            tab_expediente AS te
            Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
            Inner Join tab_prestamos AS tpr ON tpr.exp_id = te.exp_id
            Inner Join par_institucion AS pint ON pint.int_id = tpr.pre_institucion
            Inner Join tab_expfondo AS tef ON tef.exp_id = te.exp_id
            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
            Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id

            WHERE
            te.exp_estado =  '1' AND
            tpr.pre_estado =  '1'
            AND teu.eus_estado = '1'" . $where . $order_by;
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
        $pdf->SetTitle('Reporte de Prestamos No Devueltos');
        $pdf->SetSubject('Reporte de Prestamos No Devueltos');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 20, 'ABC', 'Administradora Boliviana de Carreteras');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 15, 10);
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
        $cadena .= '<table width="540" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';

        if ($_SESSION["ROL_COD"] != "ADM")
            $ins_id = $_SESSION["INS_ID"];
        else
            $ins_id = 0;
        $institucion = new Tab_institucion();
        $sql = "SELECT ti.ins_id, tu.uni_descripcion FROM tab_unidad tu INNER JOIN tab_institucion ti ON tu.ins_id = ti.ins_id " .
                " WHERE tu.uni_id = ti.uni_id AND ti.ins_id=$ins_id AND tu.uni_par<>0 ";
        //print $sql;
        $row_inst = $institucion->dbselectBySQL($sql);

        if (count($row_inst) > 0) {
            $cadena .= '<tr><td>' . $row_inst[0]->uni_descripcion . '<br/></td></tr>';
        }

        $cadena .= '<tr><td>' . $cabezera . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'PRESTAMO NO DEVUELTOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        //$cadena .= '<tr><td align="left">Fecha de Elaboracion:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Prestamo:' . $f_prestdesde . ' - ' . $f_presthasta . '</td></tr>';
        //$cadena .= '<tr><td align="left">Fechas de Devolucion:</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: Serie<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="310"><div align="center"><strong>IDENTIFICACION DEL EXPEDIENTE</strong></div></td>';
        $cadena .= '<td width="105"><div align="center"><strong>DATOS DEL PRESTAMO</strong></div></td>';
        $cadena .= '<td width="125"><div align="center"><strong>DATOS DEL SOLICITANTE</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="500" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="60"><div align="center"><strong>Unidad de Instalación</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Codigo de Referencia</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Motivo</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Fecha de Prestamo</strong></div></td>';
        $cadena .= '<td width="55"><div align="center"><strong>Fecha de Devolución</strong></div></td>';
        $cadena .= '<td width="60"><div align="center"><strong>Solicitante</strong></div></td>';
        $cadena .= '<td width="65"><div align="center"><strong>Institución</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><strong>Serie:</strong></td>';
        //$cadena .= '</tr>';
        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $ser_id = $fila->ser_id;
            if ($ser_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Serie:' . $fila->ser_categoria . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $ser_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="60">' . $fila->contenedor . '</td>';
            $cadena .= '<td width="70">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="100">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="70">' . $fila->pre_justificacion . '</td>';
            $cadena .= '<td width="50"><div align="center">' . $fila->pre_fecha_pres . '</div></td>';
            $cadena .= '<td width="55"><div align="center">' . $fila->pre_fecha_dev . '</div></td>';
            $cadena .= '<td width="60">' . $fila->pre_solicitante . '</td>';
            $cadena .= '<td width="65">' . $fila->int_descripcion . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';
        //echo ($cadena);

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }

    function verRpte_noDevuelto_Institucion() {
        //$tipo_clasificado = "INSTITUCION";
        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_series = $_REQUEST["filtro_series"];
        $filtro_institucion = $_REQUEST["filtro_institucion"];
        $f_prestdesde = $_REQUEST["f_prestdesde"];
        $f_presthasta = $_REQUEST["f_presthasta"];
        $f_devodesde = $_REQUEST["f_devodesde"];
        $f_devohasta = $_REQUEST["f_devohasta"];

        $where = "";
        $cabezera = "";
        if ($_SESSION["ROL_COD"] == "SUBF") {
            $where .= " AND tef.fon_id =  '2' ";
            $cabezera.="FONDO";
        } elseif ($_SESSION["ROL_COD"] == "ACEN") {
            $where .= " AND tef.fon_id =  '3' ";
            $cabezera.="ARCHIVO CENTRAL";
        }
        if ($_SESSION["ROL_COD"] != "ADM") {
            $where .= "  AND tun.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
            $where .= "  AND teu.usu_id  =  '" . $_SESSION["USU_ID"] . "' ";
        }

        if ($_SESSION["ROL_COD"] == "ADM") {
            $tipo_fondo = $_REQUEST["tipo_fondo"];
            if ($tipo_fondo == "SUBFONDO") {
                $where .= " AND tef.fon_id =  '2' ";
                $cabezera.="FONDO";
            }
            if ($tipo_fondo == "ARCENTRAL") {
                $where .= " AND tef.fon_id =  '3' ";
                $cabezera.="ARCHIVO CENTRAL";
            }
        }

        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY pint.int_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'INSTITUCION') {
            $order_by.=" ORDER BY pint.int_id ASC, pint.int_descripcion  ASC";
        }
        if ($tipo_orden == 'PER_SOLICITANTE') {
            $order_by.=" ORDER BY pint.int_id ASC, tpr.pre_solicitante ASC";
        }
        if ($tipo_orden == 'NOM_EXPEDIENTE') {
            $order_by.=" ORDER BY pint.int_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'COD_REF') {
            $order_by.=" ORDER BY pint.int_id ASC, te.exp_codigo ASC";
        }

        /* $add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "INSTITUCION") {
          $add_select.=" pint.int_descripcion, ";
          $add_group_by.= " GROUP BY pint.int_id ";
          } */
        //PARA LOS FILTROS

        if ($filtro_series != '') {
            $where.=" AND te.ser_id =  '$filtro_series' ";
        }
        if ($filtro_institucion != '') {
            $where.=" AND pint.int_id =  '$filtro_institucion' ";
        }
        if ($f_prestdesde != '' && $f_presthasta != '') {
            $where.=" AND DATE(tpr.pre_fecha_pres)  BETWEEN '$f_prestdesde' AND '$f_presthasta' ";
        }
        if ($f_devodesde != '' && $f_devohasta != '') {
            $where.=" AND DATE(tpr.pre_fecha_dev)  BETWEEN '$f_devodesde' AND '$f_devohasta' ";
        }
//para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "
            SELECT
            te.exp_id,
            te.exp_nombre,
            te.exp_codigo,
            te.ser_id,
            ts.ser_categoria,
            tpr.pre_solicitante,
            tpr.pre_descripcion,
            tpr.pre_fecha_pres,
            tpr.pre_fecha_dev,
            pint.int_id,
            pint.int_descripcion ,
            tpr.pre_justificacion,
            (
                 SELECT (stc.con_codigo || ' ' || sttc.ctp_codigo)
                FROM tab_expcontenedor AS stec
                INNER JOIN tab_contenedor AS stc ON stc.con_id = stec.con_id
                INNER JOIN tab_tipocontenedor AS sttc ON sttc.ctp_id = stc.ctp_id
                WHERE stec.exc_estado = '1'
                AND stec.exp_id =te.exp_id
                LIMIT 1 OFFSET 0
            ) as contenedor
            FROM tab_expediente AS te
            Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
            Inner Join tab_prestamos AS tpr ON tpr.exp_id = te.exp_id
            Inner Join par_institucion AS pint ON pint.int_id = tpr.pre_institucion
            Inner Join tab_expfondo AS tef ON tef.exp_id = te.exp_id
            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
            Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id

            WHERE
            te.exp_estado =  '1' AND
            tpr.pre_estado =  '1'
            AND teu.eus_estado = '1'" . $where . $order_by;
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
        $pdf->SetTitle('Reporte de Prestamos No Devueltos');
        $pdf->SetSubject('Reporte de Prestamos No Devueltos');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 20, 'ABC', 'Administradora Boliviana de Carreteras');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
        $pdf->SetMargins(10, 15, 10);
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
        $cadena .= '<table width="540" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';

        if ($_SESSION["ROL_COD"] != "ADM")
            $ins_id = $_SESSION["INS_ID"];
        else
            $ins_id = 0;
        $institucion = new Tab_institucion();
        $sql = "SELECT ti.ins_id, tu.uni_descripcion FROM tab_unidad tu INNER JOIN tab_institucion ti ON tu.ins_id = ti.ins_id " .
                " WHERE tu.uni_id = ti.uni_id AND ti.ins_id=$ins_id AND tu.uni_par<>0 ";
        //print $sql;
        $row_inst = $institucion->dbselectBySQL($sql);

        if (count($row_inst) > 0) {
            $cadena .= '<tr><td>' . $row_inst[0]->uni_descripcion . '<br/></td></tr>';
        }

        $cadena .= '<tr><td>' . $cabezera . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'PRESTAMO NO DEVUELTOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        //$cadena .= '<tr><td align="left">Fecha de Elaboracion:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Prestamo: ' . $f_prestdesde . ' - ' . $f_presthasta . '</td></tr>';
        //$cadena .= '<tr><td align="left">Fechas de Devolucion:</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripcion: Institución Solicitante<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="330"><div align="center"><strong>IDENTIFICACION DEL EXPEDIENTE</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>DATOS DEL PRESTAMO</strong></div></td>';
        $cadena .= '<td width="110"><div align="center"><strong>DATOS DEL SOLICITANTE</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="55"><div align="center"><strong>Unidad de Instalación</strong></div></td>';
        $cadena .= '<td width="63"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="68"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="77"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="57"><div align="center"><strong>Motivo</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Fecha de Prestamo</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Fecha de Devolucion</strong></div></td>';
        $cadena .= '<td width="52"><div align="center"><strong>Solicitante</strong></div></td>';
        $cadena .= '<td width="58"><div align="center"><strong>Institución</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><strong>Institucion:</strong></td>';
        //$cadena .= '</tr>';
        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $inst_id = $fila->int_id;
            if ($inst_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Institucion:' . $fila->int_descripcion . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $inst_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="55">' . $fila->contenedor . '</td>';
            $cadena .= '<td width="63">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="68">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="77">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="57">' . $fila->pre_justificacion . '</td>';
            $cadena .= '<td width="50"><div align="center">' . $fila->pre_fecha_pres . '</div></td>';
            $cadena .= '<td width="50"><div align="center">' . $fila->pre_fecha_dev . '</div></td>';
            $cadena .= '<td width="52">' . $fila->pre_solicitante . '</td>';
            $cadena .= '<td width="58">' . $fila->int_descripcion . '</td>';
            $cadena .= '</tr>';
        }
        $cadena .= '</table>';

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }

}

?>
