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
class rpteCustodioArchivoController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte_serie";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteCustodioArhivo", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteCustodioArchivo.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte_serie() {

//        $tipo_orden = $_REQUEST["tipo_orden"];
        $filtro_series = $_REQUEST["filtro_series"];
        if(isset($_REQUEST["filtro_expediente"])){
        $filtro_expediente = $_REQUEST["filtro_expediente"];
        }else{
          $filtro_expediente="";  
        }
//        $order_by = "";
//        if ($tipo_orden == 'SERIE') {
//            $order_by.=" ORDER BY ts.ser_categoria ASC";
//        }
//        if ($tipo_orden == 'NOMBRE_EXPEDIENTE') {
//            $order_by.=" ORDER BY te.exp_nombre ASC";
//        }
//        if ($tipo_orden == 'CODIGO_REFERENCIA') {
//            $order_by.=" ORDER BY te.exp_codigo ASC";
//        }
//        if ($tipo_orden == 'FECHA_EXI') {
//            $order_by.=" ORDER BY tef.exf_fecha_exi ASC";
//        }
//        if ($tipo_orden == 'FECHA_EXF') {
//            $order_by.=" ORDER BY tef.exf_fecha_exf ASC";
//        }
        //para el where
        $where = "";
        $where .= "  AND tab_usuario.usu_id  =  '" . $_SESSION["USU_ID"] . "' ";


        //filtros
   
        if ($filtro_expediente != '') {
            $where.=" AND tab_expediente.exp_id =  '$filtro_expediente' ";
        }


        //para la fecha de la cabezera
        $fecha_actual = date("d/m/Y");

        $sql = "SELECT
tab_solprestamo.spr_id,
tab_fondo.fon_cod,
tab_unidad.uni_codigo,
tab_series.ser_codigo,
tab_expediente.exp_codigo,
tab_archivo.fil_codigo,
tab_solprestamo.spr_fecha,
tab_solprestamo.uni_id,
(SELECT usu_nombres || ' ' || usu_apellidos FROM tab_usuario WHERE usu_id = tab_solprestamo.usu_id AND usu_estado = '1') AS usu_solicitante,
tab_solprestamo.spr_solicitante,
tab_solprestamo.spr_email,
tab_solprestamo.spr_tel,
tab_solprestamo.spr_fecent,
tab_solprestamo.spr_fecren,
(SELECT usu_nombres || ' ' || usu_apellidos FROM tab_usuario WHERE usu_id = tab_solprestamo.usua_id AND usu_estado = '1') AS usu_autoriza,
(SELECT usu_nombres || ' ' || usu_apellidos FROM tab_usuario WHERE usu_id = tab_solprestamo.usur_id AND usu_estado = '1') AS usu_registrado,
tab_solprestamo.spr_fecdev,
tab_solprestamo.spr_obs,
tab_solprestamo.spr_estado,
tab_docprestamo.fil_id,
tab_docprestamo.dpr_orden,
tab_docprestamo.dpr_obs,
tab_archivo.fil_titulo,
tab_archivo.fil_proc,
tab_archivo.fil_tomovol,
tab_archivo.fil_ori,
tab_archivo.fil_cop,
tab_archivo.fil_fot,
tab_archivo.fil_sala,
tab_archivo.fil_estante,
tab_archivo.fil_cuerpo,
tab_archivo.fil_balda,
tab_archivo.fil_nrocaj,
tab_archivo.fil_obs,
tab_expisadg.exp_fecha_exi,
tab_expisadg.exp_fecha_exf,
tab_sopfisico.sof_codigo,
tab_unidad.uni_descripcion,
tab_expisadg.exp_titulo,
tab_series.ser_id,
tab_expediente.exp_id
FROM
tab_solprestamo
INNER JOIN tab_docprestamo ON tab_solprestamo.spr_id = tab_docprestamo.spr_id
INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_docprestamo.fil_id
INNER JOIN tab_exparchivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
INNER JOIN tab_expediente ON tab_expediente.exp_id = tab_exparchivo.exp_id
INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
INNER JOIN tab_series ON tab_series.ser_id = tab_expediente.ser_id
INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
INNER JOIN tab_sopfisico ON tab_sopfisico.sof_id = tab_archivo.sof_id
WHERE
tab_series.ser_id = $filtro_series $where ORDER BY tab_expediente.exp_id";

        //echo ($sql); die ();
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
        $pdf->SetTitle('Reporte de Archivos');
        $pdf->SetSubject('Reporte de Archivos');
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



        $cadena = "<br/><br/><br/><br/><br/><br/><br/><br/>";
        $cadena .= '<table width="760" border="0" >';

        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'REPORTE DE ARCHIVOS REGISTRADOS POR FUNCIONARIO';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        $cadena .= '<tr><td align="left">Fecha de Elaboracion: ' . $fecha_actual . '</td></tr>';

        if (count($result) > 0) {
            $cadena .= '<tr><td align="left"> Funcionario: ' . $result[0]->usu_nombre . ' </td></tr>';

            $cadena .= '<tr><td align="left"> Unidad: ' . $result[0]->uni_descripcion . ' <br/></td></tr>';

            $cadena .= '</table>';
            $cadena .= '<br/>';
        }

        $cadena .= '<table width="760" border="1" cellpadding="2">';
        $cadena .= '<tr align="center" bgcolor="#CCCCCC">';
        $cadena .= '<td width="20"><span style="font-size: 10px;font-weight: bold;">Nro</span></td>';
        $cadena .= '<td width="110"><span style="font-size: 10px;font-weight: bold;">Nombre</span></td>';
        $cadena .= '<td width="110"><span style="font-size: 10px;font-weight: bold;">Descripción</span></td>';
        $cadena .= '<td width="80"><span style="font-size: 10px;font-weight: bold;">Característica</span></td>';
        $cadena .= '<td width="60"><span style="font-size: 10px;font-weight: bold;">NUR</span></td>';
        $cadena .= '<td width="60"><span style="font-size: 10px;font-weight: bold;">N Ejemplar</span></td>';
        $cadena .= '<td width="60"><span style="font-size: 10px;font-weight: bold;">Tomo/ Volumen</span></td>';
        $cadena .= '<td width="100"><span style="font-size: 10px;font-weight: bold;">Tramite</span></td>';
        $cadena .= '<td width="100"><span style="font-size: 10px;font-weight: bold;">Cuerpo</span></td>';
        $cadena .= '<td width="60"><span style="font-size: 10px;font-weight: bold;">Sop. Físico</span></td>';
        $cadena .= '</tr>';

        $numero = 1;
        $aux = 0;
        foreach ($result as $fila) {
            $exp_id = $fila->exp_id;
            if ($exp_id != $aux) {
                $cadena .= '<tr><td colspan="10" width="760"><span style="font-size: 10px;">' . $fila->expediente . '</span></td></tr>';

                $aux = $exp_id;
            }

            $cadena .='<tr>';
            $cadena .='<td width="20"><span style="font-size: 10px;">' . $numero . '</span></td>';
            $cadena .='<td width="110"><span style="font-size: 10px;">' . $fila->fil_nomoriginal . '</span></td>';
            $cadena .='<td width="110"><span style="font-size: 10px;">' . $fila->fil_descripcion . '</span></td>';
            $cadena .='<td width="80"><span style="font-size: 10px;">' . $fila->fil_caracteristica . '</span></td>';
            $cadena .='<td width="60"><span style="font-size: 10px;">' . $fila->fil_nur . '</span></td>';
            $cadena .='<td width="60"><span style="font-size: 10px;">' . $fila->fil_nroejem . '</span></td>';
            $cadena .='<td width="60"><span style="font-size: 10px;">' . $fila->fil_tomovol . '</span></td>';
            $cadena .='<td width="100"><span style="font-size: 10px;">' . $fila->tra_descripcion . '</span></td>';
            $cadena .='<td width="100"><span style="font-size: 10px;">' . $fila->cue_descripcion . '</span></td>';
            $cadena .='<td width="60"><span style="font-size: 10px;">' . $fila->sof_nombre . '</span></td>';
            $cadena .='</tr >';
            $numero++;
        }

        $cadena .='</table>';
        //echo ($cadena);

        $pdf->writeHTML($cadena, true, false, false, false, '');
        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_expediente.pdf', 'I');
    }

    function loadAjaxExpediente() {
        $ser_id = $_POST["serie"];
        $sql = "SELECT
                tab_expediente.exp_id,
                tab_expediente.exp_nombre
                FROM
                tab_usuario
                INNER JOIN tab_usu_serie ON tab_usuario.usu_id = tab_usu_serie.usu_id
                INNER JOIN tab_series ON tab_series.ser_id = tab_usu_serie.ser_id
                INNER JOIN tab_expediente ON tab_expediente.ser_id = tab_series.ser_id
                WHERE
                tab_series.ser_id = $ser_id AND tab_usuario.usu_id = " . $_SESSION['USU_ID'];
        $expediente = new tab_expediente();
        $result = $expediente->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->exp_id] = $row->exp_nombre;
        }
        echo json_encode($res);
    }
        function ajaxExp(){
       $ser_id=$_REQUEST['valor'];
        $sql="SELECT
tab_expediente.exp_id,
tab_expisadg.exp_titulo
FROM
tab_series
INNER JOIN tab_expediente ON tab_expediente.ser_id = tab_series.ser_id
INNER JOIN tab_expisadg ON tab_expisadg.exp_id = tab_expediente.exp_id
where tab_series.ser_id = $ser_id ORDER BY tab_expediente.exp_id";
    $series=new Tab_series();
    $result=$series->dbSelectBySQL($sql);
     echo '<select name="filtro_expediente" style="width: auto;"
                        id="filtro_funcionario" size="5" style="height: 250px">';
                   echo '<option value="">(seleccionar)</option>';
        foreach($result as $list){
            echo "<option value='".$list->exp_id."'>".$list->exp_titulo."</option>";
        }
        echo "</select>";
    }

}

?>
