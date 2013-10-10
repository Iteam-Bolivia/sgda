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
class rpteParaTransSubfondoController Extends baseController {

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
        $liMenu = $this->menu->imprimirMenu("rpteParaTransSubfondo", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteParaTransSubfondo.tpl');
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
          //$add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "SERIE") {
          //$add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY te.ser_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
        //if para saber si esta en oficina o subfondo???
        //averiguar como
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY te.ser_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY te.ser_id ASC, tun.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY te.ser_id ASC, tu.usu_apellidos ASC, tu.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY te.ser_id ASC, tef.exf_fecha_exf  ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND teu.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(tef.exf_fecha_exf)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT te.exp_nombre, te.exp_codigo, te.ser_id, ts.ser_categoria, tef.exf_fecha_exf AS fecha_exf, tu.usu_nombres, tu.usu_apellidos, tun.uni_codigo, tun.uni_descripcion
            FROM tab_expediente AS te Inner Join tab_series AS ts ON ts.ser_id = te.ser_id Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id Inner Join tab_unidad AS tun ON tu.uni_id = tun.uni_id Inner Join tab_expfondo AS tef ON te.exp_id = tef.exp_id
            WHERE te.exp_estado =  '1' AND teu.eus_estado =  '1' AND tef.exf_estado =  '1' AND tef.exf_fecha_exf <= '" . date("Y-m-d") . "' AND tef.fon_id =  '1'" . $where . $order_by;

        // echo ($sql); die ();

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
        $pdf->SetTitle('Reporte de Expedientes  Para Transferir a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Para Transferir a Subfondo');
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
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES PARA TRANSFERIR A SUBFONDO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: Series<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="150"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Fecha Extrema Final</strong></div></td>';
        //$cadena .= '<td width="60"><div align="center"><strong>Fecha Transferencia</strong></div></td>';
        $cadena .= '<td width="210"><table width="190" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="210"><div align="center"><strong>CUSTODIO</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="110"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '</tr>';

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
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="80">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="150">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="80"><div align="center">' . $fila->fecha_exf . '</div></td>';
            //$cadena .= '<td width="60"><div align="center">' . $fecha_actual . '</div></td>';
            $cadena .= '<td width="110">' . $fila->uni_descripcion . '</td>';
            $cadena .= '<td width="100">' . $fila->usu_nombres . ' ' . $fila->usu_apellidos . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }

        $cadena .= '</table>';
        //echo ($cadena);

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
          $add_group_by.= " GROUP BY tu.uni_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY tun.uni_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY tun.uni_id ASC, tun.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY tun.uni_id ASC, tu.usu_apellidos ASC, tu.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY tun.uni_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY tun.uni_id ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY tun.uni_id ASC, tef.exf_fecha_exf  ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND teu.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(tef.exf_fecha_exf)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT te.exp_nombre, te.exp_codigo, te.ser_id, ts.ser_categoria, tef.exf_fecha_exf AS fecha_transferencia, tu.usu_nombres, tu.usu_apellidos, tun.uni_id, tun.uni_codigo, tun.uni_descripcion
            FROM tab_expediente AS te Inner Join tab_series AS ts ON ts.ser_id = te.ser_id Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id Inner Join tab_unidad AS tun ON tu.uni_id = tun.uni_id
            Inner Join tab_expfondo AS tef ON te.exp_id = tef.exp_id
            WHERE te.exp_estado =  '1' AND teu.eus_estado =  '1' AND tef.exf_estado =  '1' AND tef.exf_fecha_exf < '" . date("Y-m-d") . "' AND tef.fon_id =  '1'" . $where . $order_by;

        // echo ($sql); die ();

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
        $pdf->SetTitle('Reporte de Expedientes  Para Transferir a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Para Transferir a Subfondo');
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
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES PARA TRANSFERIR A SUBFONDO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción:Unidad<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="145"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="115"><div align="center"><strong>Custodio</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><div align="center"><strong>Unidad:</strong></div></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $uni_id = $fila->uni_id;
            if ($uni_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Unidad:' . $fila->uni_descripcion . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $uni_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="90">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="90">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="145">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="80"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="115">' . $fila->usu_nombres . ' ' . $fila->usu_apellidos . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';
        //echo ($cadena);


        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_trans.pdf', 'I');
    }

    function verRpte_funcionario() {
        /* $tipo_clasificado = "FUNCIONARIO";
          //$add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "FUNCIONARIO") {
          //$add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY tu.usu_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_transdesde = $_REQUEST["f_transdesde"];
        $f_transhasta = $_REQUEST["f_transhasta"];

        $where = "";
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY tu.usu_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD') {
            $order_by.=" ORDER BY tu.usu_id ASC, tun.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNCIONARIO') {
            $order_by.=" ORDER BY tu.usu_id ASC, tu.usu_apellidos ASC, tu.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY tu.usu_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY tu.usu_id ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY tu.usu_id ASC, tef.exf_fecha_exf  ASC";
        }


        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND te.ser_id =  '$filtro_serie' ";
        }
        if ($filtro_unidad != '') {
            $where.=" AND tu.uni_id  =  '$filtro_unidad' ";
        }
        if ($filtro_funcionario != '') {
            $where.=" AND teu.usu_id   =  '$filtro_funcionario' ";
        }
        if ($f_transdesde != '' && $f_transhasta != '') {
            $where.=" AND DATE(tef.exf_fecha_exf)  BETWEEN '$f_transdesde' AND '$f_transhasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT
            te.exp_nombre,
            te.exp_codigo,
            te.ser_id,
            ts.ser_categoria,
            tef.exf_fecha_exf AS fecha_transferencia,
            tu.usu_id,
            tu.usu_nombres,
            tu.usu_apellidos,
            tun.uni_codigo,
            tun.uni_descripcion
            FROM
            tab_expediente AS te
            Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = teu.usu_id
            Inner Join tab_unidad AS tun ON tu.uni_id = tun.uni_id
            Inner Join tab_expfondo AS tef ON te.exp_id = tef.exp_id
            WHERE
            te.exp_estado =  '1' AND
            teu.eus_estado =  '1' AND
            tef.exf_estado =  '1' AND tef.exf_fecha_exf < '" . date("Y-m-d") . "'
            AND tef.fon_id =  '1'" . $where . $order_by;

        // echo ($sql); die ();

        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);


        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Expedientes  Para Transferir a Subfondo');
        $pdf->SetSubject('Reporte de Expedientes Para Transferir a Subfondo');
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
//         $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'EXPEDIENTES PARA TRANSFERIR A SUBFONDO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboracion:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripcion:Funcionario<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="540" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro</strong></div></td>';
        $cadena .= '<td width="105"><div align="center"><strong>Codigo de Referencia</strong></div></td>';
        $cadena .= '<td width="130"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="195"><div align="center"><strong>Titulo</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="500"><div align="left"><strong>Funcionario:</strong></div></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $usu_id = $fila->usu_id;
            if ($usu_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="540"><strong>Funcionario:' . $fila->usu_nombres . ' ' . $fila->usu_apellidos . ' - ' . $fila->uni_codigo . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $usu_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="105">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="130">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="195">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="90"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';

        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_trans.pdf', 'I');
    }

}

?>
