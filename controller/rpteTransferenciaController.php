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
class rpteTransferenciaController Extends baseController {

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
        $this->registry->template->PATH_EVENT = "VerRTransferencia";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteTransCustodios", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteTransCustodios.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

        $tipo=$_REQUEST['tipo'];
        
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
        $f_prestdesde = $_REQUEST["f_prestdesde"];
        $f_presthasta = $_REQUEST["f_presthasta"];

        $where = "";
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun3.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY te.ser_id ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD_ORIGEN') {
            $order_by.=" ORDER BY te.ser_id ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNC_ORIGEN') {
            $order_by.=" ORDER BY te.ser_id ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY te.ser_id ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY te.ser_id ASC, ttr.trn_fecha_crea ASC";
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
        if ($f_prestdesde != '' && $f_presthasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_prestdesde' AND '$f_presthasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT  DISTINCT
                te.ser_id,
                te.exp_nombre,
                te.exp_codigo,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_nombres AS usunom_ori,
                tu1.usu_apellidos AS usuape_ori,
                tu2.usu_nombres AS usunom_dest,
                tu2.usu_apellidos AS usuape_dest,
                tu2.usu_id,
                tu1.usu_id,
                tun1.uni_codigo,
                tun1.uni_descripcion AS uni_ori,
                tun1.uni_id,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion AS uni_dest,
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
                Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
                Inner Join tab_usuario AS tu3 ON tu3.usu_id = teu.usu_id
                Inner Join tab_unidad AS tun3 ON tu3.uni_id = tun3.uni_id
                WHERE
                te.exp_estado =  '1' AND ttr.trn_confirmado =  0 " . $where . $order_by;

        //echo ($sql); die ();

        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Prestamos');
        $pdf->SetSubject('Reporte de Prestamos');
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
        $cadena .= '<table width="780" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'TRANSFERENCIAS ENTRE CUSTODIOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fechas de Transferencia: Del ' . $f_prestdesde . ' al ' . $f_presthasta . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: Serie<br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="780" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="110"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="180"><table width="180" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="180"><div align="center"><strong>ORIGEN</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="90"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="180"><table width="180" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="180"><div align="center"><strong>DESTINO</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="90"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="85"><div align="center"><strong>Descripción</strong></div></td>';
        $cadena .= '<td width="75"><div align="center"><strong>Observaciones</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="720"><strong>Serie:</strong></td>';
        //$cadena .= '</tr>';
        $aux = "";
        $numero = 1;
        foreach ($result as $fila) {

            $ser_id = $fila->ser_id;
            if ($ser_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="780"><strong>Serie:' . $fila->ser_categoria . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $ser_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="70">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="110">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="70"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="90">' . $fila->uni_ori . '</td>';
            $cadena .= '<td width="90">' . $fila->usunom_ori . ' ' . $fila->usuape_ori . '</td>';
            $cadena .= '<td width="90">' . $fila->uni_dest . '</td>';
            $cadena .= '<td width="90">' . $fila->usunom_dest . ' ' . $fila->usuape_dest . '</td>';
            $cadena .= '<td width="85">' . $fila->trn_descripcion . '</td>';
            $cadena .= '<td width="75">' . $fila->observaciones . '</td>';
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

    function verRpte_unidad() {
        /* $tipo_clasificado = "UNIDAD";
          $add_select = "";
          $add_group_by = "";
          if ($tipo_clasificado == "UNIDAD") {
          $add_select.=" ts.ser_categoria, ";
          $add_group_by.= " GROUP BY tu1.uni_id ";
          } */

        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_serie = $_REQUEST["filtro_serie"];
        $filtro_unidad = $_REQUEST["filtro_unidad"];
        $filtro_funcionario = $_REQUEST["filtro_funcionario"];
        $f_prestdesde = $_REQUEST["f_prestdesde"];
        $f_presthasta = $_REQUEST["f_presthasta"];

        $where = "";
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun3.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY uni_id_ori ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD_ORIGEN') {
            $order_by.=" ORDER BY uni_id_ori ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNC_ORIGEN') {
            $order_by.=" ORDER BY uni_id_ori ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY uni_id_ori ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY uni_id_ori ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY uni_id_ori ASC, ttr.trn_fecha_crea ASC";
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
        if ($f_prestdesde != '' && $f_presthasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_prestdesde' AND '$f_presthasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT DISTINCT
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_nombres AS usunom_ori,
                tu1.usu_apellidos AS usuape_ori,
                tu2.usu_nombres AS usunom_dest,
                tu2.usu_apellidos AS usuape_dest,
                tu2.usu_id,
                tu1.usu_id,
                tun1.uni_codigo,
                tun1.uni_descripcion AS uni_ori,
                tun1.uni_id AS uni_id_ori,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion AS uni_dest,
                tun2.uni_id,
                CASE ttr.trn_estado = '1' THEN 'PENDIENTE A RECEPCIONAR' ELSE 'RECEPCIONADO' END AS observaciones


                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_transferencia AS ttr ON ttr.exp_id = te.exp_id
                Inner Join tab_usuario AS tu1 ON ttr.trn_usuario_orig = tu1.usu_id
                Inner Join tab_usuario AS tu2 ON tu2.usu_id = ttr.trn_usuario_des
                Inner Join tab_unidad AS tun1 ON tu1.uni_id = tun1.uni_id
                Inner Join tab_unidad AS tun2 ON tun2.uni_id = tu2.uni_id
                Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
                Inner Join tab_usuario AS tu3 ON tu3.usu_id = teu.usu_id
                Inner Join tab_unidad AS tun3 ON tu3.uni_id = tun3.uni_id
                WHERE
                te.exp_estado =  '1' AND ttr.trn_confirmado =  '0'" . $where . $order_by;

        //echo ($sql); die ();

        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Prestamos');
        $pdf->SetSubject('Reporte de Prestamos');
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
        $cadena .= '<table width="780" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'TRANSFERENCIAS ENTRE CUSTODIOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Transferencia: Del ' . $f_prestdesde . ' al ' . $f_presthasta . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: Unidad <br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="780" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="110"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="70"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="80"><table width="80" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="80"><div align="center"><strong>ORIGEN</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        //$cadena .= '<td width="60"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="170"><table width="140" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="170"><div align="center"><strong>DESTINO</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="90"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="95"><div align="center"><strong>Descripción</strong></div></td>';
        $cadena .= '<td width="95"><div align="center"><strong>Observaciones</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="720"><strong>Unidad:</strong></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $uni_id = $fila->uni_id_ori;
            if ($uni_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="780"><strong>Unidad:' . $fila->uni_ori . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $uni_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="70">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="80">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="110">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="70"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="80">' . $fila->usunom_ori . ' ' . $fila->usuape_ori . '</td>';
            $cadena .= '<td width="90">' . $fila->uni_dest . '</td>';
            $cadena .= '<td width="80">' . $fila->usunom_dest . ' ' . $fila->usuape_dest . '</td>';
            $cadena .= '<td width="95">' . $fila->trn_descripcion . '</td>';
            $cadena .= '<td width="95">' . $fila->observaciones . '</td>';
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
        $f_prestdesde = $_REQUEST["f_prestdesde"];
        $f_presthasta = $_REQUEST["f_presthasta"];

        $where = "";
//        if ($_SESSION["ROL_COD"] != "ADM") {
//            $where .= "  AND tun3.ins_id =  '" . $_SESSION["INS_ID"] . "' ";
//        }
        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        if ($tipo_orden == 'SERIE') {
            $order_by.=" ORDER BY llave ASC, ts.ser_categoria ASC";
        }
        if ($tipo_orden == 'UNIDAD_ORIGEN') {
            $order_by.=" ORDER BY llave ASC, tun1.uni_codigo  ASC";
        }
        if ($tipo_orden == 'FUNC_ORIGEN') {
            $order_by.=" ORDER BY llave ASC, tu1.usu_apellidos ASC, tu1.usu_nombres ASC";
        }
        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
            $order_by.=" ORDER BY llave ASC, te.exp_nombre ASC";
        }
        if ($tipo_orden == 'CODIGO_REFERENCIA') {
            $order_by.=" ORDER BY llave ASC, te.exp_codigo ASC";
        }
        if ($tipo_orden == 'FECHA_TRANS') {
            $order_by.=" ORDER BY llave ASC, ttr.trn_fecha_crea ASC";
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
        if ($f_prestdesde != '' && $f_presthasta != '') {
            $where.=" AND DATE(ttr.trn_fecha_crea)  BETWEEN '$f_prestdesde' AND '$f_presthasta' ";
        }

        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT DISTINCT
                te.exp_nombre,
                te.exp_codigo,
                te.ser_id,
                ts.ser_categoria,
                ttr.trn_fecha_crea AS fecha_transferencia,
                tu1.usu_id AS llave,
                tu1.usu_nombres AS usunom_ori,
                tu1.usu_apellidos AS usuape_ori,
                tu2.usu_nombres AS usunom_dest,
                tu2.usu_apellidos AS usuape_dest,
                tu2.usu_id,
                tun1.uni_codigo AS cod_ori,
                tun1.uni_descripcion AS uni_ori,
                tun1.uni_id,
                ttr.trn_descripcion,
                tun2.uni_codigo,
                tun2.uni_descripcion AS uni_dest,
                tun2.uni_id,
                IF(ttr.trn_estado = '1','PENDIENTE A RECEPCIONAR','RECEPCIONADO') AS observaciones
                FROM
                tab_expediente AS te
                Inner Join tab_series AS ts ON ts.ser_id = te.ser_id
                Inner Join tab_transferencia AS ttr ON ttr.exp_id = te.exp_id
                Inner Join tab_usuario AS tu1 ON ttr.trn_usuario_orig = tu1.usu_id
                Inner Join tab_usuario AS tu2 ON tu2.usu_id = ttr.trn_usuario_des
                Inner Join tab_unidad AS tun1 ON tu1.uni_id = tun1.uni_id
                Inner Join tab_unidad AS tun2 ON tun2.uni_id = tu2.uni_id
                Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
                Inner Join tab_usuario AS tu3 ON tu3.usu_id = teu.usu_id
                Inner Join tab_unidad AS tun3 ON tu3.uni_id = tun3.uni_id
                WHERE
                te.exp_estado =  '1' AND ttr.trn_confirmado =  '0'" . $where . $order_by;

        //echo ($sql); die ();

        $expediente = new Tab_expediente();
        $result = $expediente->dbselectBySQL($sql);

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Transferencia');
        $pdf->SetSubject('Reporte de Transferencia');
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
        $cadena .= '<table width="780" border="0" >';
//        $cadena .= '<tr><td>MINISTERIO DE PLANIFICACION DEL DESARROLO </td></tr>';
//        $inst = $_SESSION["INS_ID"];
//        $institucion = new Tab_institucion();
//        $institucion = $institucion->dbselectById($inst);
//
//        $cadena .= '<tr><td>' . $institucion->ins_nombre . '<br/></td></tr>';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'TRANSFERENCIAS ENTRE CUSTODIOS';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboración:' . $fecha_actual . '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Transferencia:Del ' . $f_prestdesde . ' al ' . $f_presthasta . '</td></tr>';
        $cadena .= '<tr><td align="left"> Nivel de Descripción: Funcionario <br/></td></tr>';
        $cadena .= '</table>';
        $cadena .= '<table width="780" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="10"><div align="center"><strong>N°</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Código de Referencia</strong></div></td>';
        $cadena .= '<td width="90"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="120"><div align="center"><strong>Título</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Fecha de Transferencia</strong></div></td>';
        $cadena .= '<td width="200"><table width="170" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="200"><div align="center"><strong>DESTINO</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr>';
        $cadena .= '<td width="100"><div align="center"><strong>Unidad</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Funcionario</strong></div></td>';
        $cadena .= '</tr>';
        $cadena .= '</table></td>';
        $cadena .= '<td width="95"><div align="center"><strong>Descripción</strong></div></td>';
        $cadena .= '<td width="105"><div align="center"><strong>Observaciones</strong></div></td>';
        $cadena .= '</tr>';
        //$cadena .= '<tr>';
        //$cadena .= '<td width="720"><strong>Funcionario:</strong></td>';
        //$cadena .= '</tr>';

        $numero = 1;
        $aux = "";
        foreach ($result as $fila) {
            $usu_id = $fila->llave;
            if ($usu_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="780"><strong>Funcionario: ' . $fila->usunom_ori . ' ' . $fila->usuape_ori . ' - ' . $fila->cod_ori . '</strong></td>';
                $cadena .= '</tr>';
                $aux = $usu_id;
                $numero = 1;
            }
            $cadena .= '<tr>';
            $cadena .= '<td width="10"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="80">' . $fila->exp_codigo . '</td>';
            $cadena .= '<td width="90">' . $fila->ser_categoria . '</td>';
            $cadena .= '<td width="120">' . $fila->exp_nombre . '</td>';
            $cadena .= '<td width="80"><div align="center">' . $fila->fecha_transferencia . '</div></td>';
            $cadena .= '<td width="100">' . $fila->uni_dest . '</td>';
            $cadena .= '<td width="100">' . $fila->usunom_dest . ' ' . $fila->usuape_dest . '</td>';
            $cadena .= '<td width="95">' . $fila->trn_descripcion . '</td>';
            $cadena .= '<td width="105">' . $fila->observaciones . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
        $cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }
     function VerRTransferencia(){
         
$filtro_serie=$_REQUEST['filtro_serie'];
$filtro_unidad=$_REQUEST['filtro_unidad'];
$filtro_funcionario=$_REQUEST['filtro_funcionario'];
$f_prestdesde=$_REQUEST['f_prestdesde'];
$f_presthasta=$_REQUEST['f_presthasta'];
        
        $where="";
   
    $tab_extransferencia=new tab_exptransferencia();
    $result=$tab_extransferencia->dbSelectBySQL("select DISTINCT(exp_id) from tab_exptransferencia");
    $cantidad=count($result);
    $valor3="";
    $t=1;
    foreach($result as $row){
           $valor3.="tab_expediente.exp_id=$row->exp_id";
					if($t<$cantidad){
                                        $valor3.=" or ";}
				$t++;
    }      
        
       $where.= " AND $valor3 ";     
if($filtro_serie!=""){
    $where.= " AND tab_series.ser_id=".$filtro_serie;
}
if($filtro_unidad!=""){
    $where.= " AND tab_soltransferencia.uni_id=".$filtro_unidad;
}if($filtro_funcionario!=""){
    $where.= " AND tab_soltransferencia.usu_id=".$filtro_funcionario;
}

       
        $sql="SELECT
tab_fondo.fon_codigo,
tab_expediente.exp_codigo,
tab_soltransferencia.str_id,
tab_soltransferencia.str_fecha,
tab_soltransferencia.uni_id,
tab_soltransferencia.unid_id,
tab_soltransferencia.str_nrocajas,
tab_soltransferencia.str_totpzas,
tab_soltransferencia.str_totml,
tab_soltransferencia.str_nroreg,
tab_soltransferencia.str_fecini,
tab_soltransferencia.str_fecfin,
tab_soltransferencia.str_estado,
tab_soltransferencia.usu_id,
tab_soltransferencia.usud_id,
tab_soltransferencia.str_direccion,
tab_soltransferencia.str_telefono,
tab_expisadg.exp_fecha_exi,
tab_expisadg.exp_fecha_exf,
tab_series.ser_codigo,
tab_unidad.uni_codigo,
tab_fondo.fon_cod,
tab_series.ser_categoria,
tab_expisadg.exp_titulo,
tab_expediente.exp_obs,
tab_series.ser_id,
tab_series.ser_par,
tab_expediente.exp_id
FROM
tab_unidad
INNER JOIN tab_fondo ON tab_unidad.fon_id = tab_fondo.fon_id
INNER JOIN tab_series ON tab_series.uni_id = tab_unidad.uni_id
INNER JOIN tab_expediente ON tab_expediente.ser_id = tab_series.ser_id
INNER JOIN tab_expisadg ON tab_expisadg.exp_id = tab_expediente.exp_id
INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
WHERE
tab_soltransferencia.str_estado = 2 AND
tab_expediente.exp_estado = 1 ".$where." ORDER BY tab_soltransferencia.str_id";
        
   $usua= new usuario();    
   $subfondo=new fondo();    
   $seccion=new unidad();
   $expedientes=new expediente();
        $archivo=new tab_archivo();
        $archivo2=new tab_archivo();
      
   $query=$archivo->dbSelectBySQL($sql); 
   $query2=$archivo2->dbSelectBySQL($sql);  
   $query2=$query2[0];
   $usuarioOrigen=$usua->obtenerNombre($query2->usu_id);
   $usuarioDestino=$usua->obtenerNombre($query2->usud_id);
   $fond=$subfondo->obtenerfon($query2->usu_id);
 
   
   $cadena="";  
   $cadena="<br/><br/><br/><br/><br/><br/><br/>";
  
$cadena.='<b>Cuadro 8. Formulario Normalizado de Transferencias</b>';
$cadena.='<br/><br/>';

$cadena.='<table width="740" border="1">';
  $cadena.='<tr>';
    $cadena.='<td colspan="10" align="center"><b>ADMINISTRADORA BOLIVIANA DE CARRETERAS</b><br />';
    $cadena.='Formulario de Relacion de Transferencias<br /></td>';
  $cadena.='</tr></table>';  $i=1;
    foreach($query as $row){  $tabserie=new tab_series();
  $cadena.='<table border="1" width="740"><tr>';
    $cadena.='<td colspan="5"><blockquote>';
      $cadena.='<b>Subfondo:</b> '.$fond.'<br />';
        $cadena.='<b>Sección:</b> ';
          $ob_seccion=$seccion->obtenerSeccion($row->usu_id);
        if($ob_seccion->tab_sec==""){
               $cadena.=$ob_seccion->uni_descripcion.'<br />';
        }else{
        $cadena.=$ob_seccion->tab_sec.'<br />';
        }
        $cadena.='<b>Subsección:</b> ';
        if($ob_seccion->tab_sec<>""){
             $cadena.=$ob_seccion->uni_descripcion; 
        }
    $cadena.='</blockquote></td>';
    $cadena.='<td colspan="5"  ><blockquote><b>Nº de transferencia:</b> '.$row->str_id;
    $cadena.='<br /><b>Dirección  y Teléfono:</b> '.$row->str_direccion.' '.$row->str_telefono.'</blockquote></td>';
  $cadena.='</tr>';
   $cadena.='<tr>';
     $cadena.='<td width="20" rowspan="2" align="center"><strong>Nº</strong></td>';
     $cadena.='<td width="140" rowspan="2"><strong>Serie</strong></td>';
     $cadena.='<td width="120" rowspan="2"><strong>Subserie</strong></td>';
     $cadena.='<td width="80" rowspan="2"><strong>Codigo de Referencia</strong></td>';
     $cadena.='<td colspan="2" width="130"><strong>Fechas extremas</strong></td>';
     $cadena.='<td width="30" rowspan="2"><strong>Nº Piezas Docum.</strong></td>';
     $cadena.='<td width="30" rowspan="2"><strong>Cajas</strong></td>';
     $cadena.='<td width="30" rowspan="2"><strong>M.L.</strong></td>';
     $cadena.='<td width="160" rowspan="2"><p><strong>Observ.</strong></p></td>';
   $cadena.='</tr>';
   $cadena.='<tr>';
     $cadena.='<td width="65"><strong>Inicio</strong></td>';
     $cadena.='<td width="65"><strong>Final</strong></td>';
   $cadena.='</tr>';

  $sum=0;$sum2=0;

  

      if($row->exp_fecha_exi==""){ 
          $fei="";
      }else{
        $fechainicial=explode("-",$row->exp_fecha_exi);
      $fei=$fechainicial[2]."/".$fechainicial[1]."/".$fechainicial[0];}
      if($row->exp_fecha_exf==""){ 
          $fef="";
      }else{
     $fechafinal=explode("-",$row->exp_fecha_exf);
     $fef=$fechafinal[2]."/".$fechafinal[1]."/".$fechafinal[0];
      }
      if($row->ser_par==""){$ser_id=0;}else{$ser_id=$row->ser_par;}
      $obtenerSubserie=$tabserie->dbselectByField("ser_id",$ser_id);
   
      $u=0;
      foreach($obtenerSubserie as $ver){
          $u++;
          $cte=$ver->ser_categoria;
      }
  $cadena.='<tr>';
    $cadena.='<td align="center">'.$i.'</td>';
    $cadena.='<td>';
    if($u==0){
        $cadena.=$row->ser_categoria;
    }else{
        $cadena.=$cte;
    }
    
    
    $cadena.='</td>';
    $cadena.='<td>';
     if($u<>0){
        $cadena.=$row->ser_categoria;
     }
     $sum=$sum+$expedientes->cantidadExpedientes($row->exp_id);
     $sum2=$sum2+$row->str_nrocajas;
    $cadena.='</td>';
    $cadena.='<td align="center">'.$row->fon_codigo. DELIMITER . $row->uni_codigo. DELIMITER . $row->ser_codigo. DELIMITER . $row->exp_codigo.'</td>';
    $cadena.='<td align="center">'.$fei.'</td>';
    $cadena.='<td align="center">'.$fef.'</td>';
    $cadena.='<td align="center">'.$expedientes->cantidadExpedientes($row->exp_id).'</td>';
    $cadena.='<td align="center">'.$row->str_nrocajas.'</td>';
    $cadena.='<td align="center">'.$row->str_totml.'</td>';
    $cadena.='<td>'.$row->exp_obs.'</td>';
  $cadena.='</tr>';
  $i++;
$cadena.='</table><br><br>';
  }





        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
         $pdf->SetAuthor("ITEAM");
        $pdf->SetTitle('Reporte de Transferencia');
        $pdf->SetSubject('Reporte de Transferencia');
//        aumentado
        $pdf->SetKeywords('Iteam, TEAM DIGITAL');
        // set default header data
        $pdf->SetHeaderData('logo_abc_comp.png', 20, 'ABC', 'ADMINISTRADORA BOLIVIANA DE CARRETERAS (ABC)');
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
        $pdf->SetAutoPageBreak(TRUE, 14);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        $pdf->SetFont('helvetica', '', 10);
        // add a page
        $pdf->AddPage();

//        $pdf->SetXY(110, 200);
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        
        
        $cadena = $cadena;
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
     //   $pdf->Output('reporte_transferencia.pdf', 'D');
          $pdf->Output('reporte_transferencia.pdf', 'I');
     
    }

}

?>
