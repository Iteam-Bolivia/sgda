<?php

/**
 * prestamosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class rpteTransSubfondoController Extends baseController {

    function index() {
        //PARA LOS SELECT DEL FORM
        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();
        $unidad = new unidad();
        $this->registry->template->optUnidad = $unidad->obtenerSelect();
        $usuario = new usuario();
        $this->registry->template->optUsuario = $usuario->obtenerSelect();


        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteTransSubfondo", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteTransSubfondo.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

        $tipo_clasificado = $_REQUEST["tipo_clasificado"];
        if ($tipo_clasificado == "SERIE") {
            $this->verRpte_series();
        }
        if ($tipo_clasificado == "UNIDAD") {
            $this->verRpte_unidad();
        }
        if ($tipo_clasificado == "FUNCIONARIO") {
            $this->verRpte_funcionario();
        }
    }

    function verRpte_series() {
        /* $tipo_clasificado = "SERIE";
          $add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "SERIE") {
          $add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY te.ser_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
        $cabezera = "";
        if ($_SESSION["ROL_COD"] == "SUBF") {
            //$where .= "AND tef.fon_id =  '2' ";
            $cabezera.="FONDO";
        } elseif ($_SESSION["ROL_COD"] == "ACEN") {
            //$where .= "AND tef.fon_id =  '3' ";
            $cabezera.="ARCHIVO CENTRAL";
        }
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun1.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY te.ser_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY te.ser_id ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY te.ser_id ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY te.ser_id ASC, ttr.trn_fecha_crea    ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu1.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND tu1.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = " SELECT
                te.exp_id,
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_nombres AS nom_ultimocust,
                tu1.usu_apellidos AS ape_ultimocust,
                tu2.usu_nombres,
                tu2.usu_apellidos,
                tu2.usu_id,
                tu1.usu_id,
                tun1.uni_codigo,
                tun1.uni_descripcion AS uni_origen,
                tun1.uni_id,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion,
                tun2.uni_id,
                CASE WHEN ttr.trn_estado = '1' THEN 'PENDIENTE A RECEPCIONAR' ELSE 'RECEPCIONADO' END AS observaciones
                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_transferencia AS ttr ON ttr.exp_id = te.exp_id
                Inner Join tab_usuario AS tu1 ON ttr.trn_usuario_orig = tu1.usu_id
                Inner Join tab_usuario AS tu2 ON tu2.usu_id = ttr.trn_usuario_des
                Inner Join tab_unidad AS tun1 ON tu1.uni_id = tun1.uni_id
                Inner Join tab_unidad AS tun2 ON tun2.uni_id = tu2.uni_id

                 where te.exp_estado =  '1'" . $where . $order_by;

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
        $pdf->SetTitle('Reporte de Expedientes Transferidos a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Transferidos a Subfondo');
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
        $cadena .= '<table width="540" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '</td></tr>';
        $cadena .= '<tr><td>Nombre del fondo:' . $cabezera . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES TRANSFERIDOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Transferencia: Del ' . $f_transdesde . ' al ' . $f_transhasta . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: SERIE <br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="110"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="180"><table width="150" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="180"><div align="center"><strong>ULTIMO CUSTODIO</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="90"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Observaciones</strong></div></td>';
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
            $cadena .= '<td width="80">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="110">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="70"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="90">' . $fila->uni_origen . '</td>';
            $cadena .= '<td width="90">' . $fila->nom_ultimocust . ' ' . $fila->ape_ultimocust . '</td>';
            $cadena .= '<td width="90">' . $fila->observaciones . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_trans.pdf', 'I');
    }

    function verRpte_unidad() {
        /* $tipo_clasificado = "UNIDAD";
          //$add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "UNIDAD") {
          //$add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY tu1.uni_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
        $cabezera = "";
        if ($_SESSION["ROL_COD"] == "SUBF") {
            $where .= "AND tef.fon_id =  '2' ";
            $cabezera.="FONDO";
        } elseif ($_SESSION["ROL_COD"] == "ACEN") {
            $where .= "AND tef.fon_id =  '3' ";
            $cabezera.="ARCHIVO CENTRAL";
        }
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun1.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY uni_id_ori ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY uni_id_ori ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY uni_id_ori ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY uni_id_ori ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY uni_id_ori ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY uni_id_ori ASC, ttr.trn_fecha_crea    ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu1.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND tu1.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = " SELECT
                te.exp_id,
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_nombres AS nom_ultimocust,
                tu1.usu_apellidos AS ape_ultimocust,
                tu2.usu_nombres,
                tu2.usu_apellidos,
                tu2.usu_id,
                tu1.usu_id,
                tun1.uni_codigo,
                tun1.uni_descripcion AS uni_origen,
                tun1.uni_id AS uni_id_ori,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion,
                tun2.uni_id,
                CASE WHEN ttr.trn_estado = '1' THEN 'RECEPCIONADO' ELSE 'PENDIENTE A RECEPCIONAR' END AS observaciones
                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_transferencia AS ttr ON ttr.exp_id = te.exp_id
                Inner Join tab_usuario AS tu1 ON ttr.trn_usuario_orig = tu1.usu_id
                Inner Join tab_usuario AS tu2 ON tu2.usu_id = ttr.trn_usuario_des
                Inner Join tab_unidad AS tun1 ON tu1.uni_id = tun1.uni_id
                Inner Join tab_unidad AS tun2 ON tun2.uni_id = tu2.uni_id

                 where te.exp_estado =  '1'" . $where . $order_by;

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
        $pdf->SetTitle('Reporte de Expedientes Transferidos a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Transferidos a Subfondo');
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
        $cadena .= '<table width="540" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '</td></tr>';
        $cadena .= '<tr><td>Nombre del fondo:' . $cabezera . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES TRANSFERIDOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Transferencia:</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción:UNIDAD<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="155"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="115"><div align="center"><strong>Ultimo Custodio</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><div align="center"><strong>Unidad:</strong></div></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $uni_id = $fila->uni_id_ori;
            if ($uni_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Unidad:' . $fila->uni_origen . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $uni_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="90">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="90">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="155">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="80"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="115">' . $fila->nom_ultimocust . ' ' . $fila->ape_ultimocust . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }

    function verRpte_funcionario() {
        /* $tipo_clasificado = "FUNCIONARIO";
          //$add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "FUNCIONARIO") {
          //$add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY tu1.usu_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
        $cabezera = "";
        if ($_SESSION["ROL_COD"] == "SUBF") {
            $where .= "AND tef.fon_id =  '2' ";
            $cabezera.="FONDO";
        } elseif ($_SESSION["ROL_COD"] == "ACEN") {
            $where .= "AND tef.fon_id =  '3' ";
            $cabezera.="ARCHIVO CENTRAL";
        }
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun1.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY usuid_origen ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY usuid_origen ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY usuid_origen ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY usuid_origen ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY usuid_origen ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY usuid_origen ASC, ttr.trn_fecha_crea    ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu1.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND tu1.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = " SELECT
                te.exp_id,
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_nombres AS nom_ultimocust,
                tu1.usu_apellidos AS ape_ultimocust,
                tu2.usu_nombres,
                tu2.usu_apellidos,
                tu2.usu_id,
                tu1.usu_id AS usuid_origen,
                tun1.uni_codigo AS unicod_origen,
                tun1.uni_descripcion AS uni_origen,
                tun1.uni_id,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion,
                tun2.uni_id,
                CASE ttr.trn_estado = '1' THEN 'RECEPCIONADO' ELSE 'PENDIENTE A RECEPCIONAR' END AS observaciones
                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_transferencia AS ttr ON ttr.exp_id = te.exp_id
                Inner Join tab_usuario AS tu1 ON ttr.trn_usuario_orig = tu1.usu_id
                Inner Join tab_usuario AS tu2 ON tu2.usu_id = ttr.trn_usuario_des
                Inner Join tab_unidad AS tun1 ON tu1.uni_id = tun1.uni_id
                Inner Join tab_unidad AS tun2 ON tun2.uni_id = tu2.uni_id

                 where te.exp_estado =  '1'" . $where . $order_by;

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
        $pdf->SetTitle('Reporte de Expedientes Transferidos a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Transferidos a Subfondo');
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
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '</td></tr>';
        $cadena .= '<tr><td>Nombre del fondo:' . $cabezera . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES TRANSFERIDOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Transferencia:</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción:FUNCIONARIO<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="105"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="110"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="205"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><div align="left"><strong>Funcionario:</strong></div></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $usu_id = $fila->usuid_origen;
            if ($usu_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Funcionario:' . $fila->nom_ultimocust . ' ' . $fila->ape_ultimocust . ' - ' . $fila->unicod_origen . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $usu_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="105">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="110">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="205">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="100"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }

}

?>
