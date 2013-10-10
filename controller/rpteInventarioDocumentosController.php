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
class rpteInventarioDocumentosController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();
//        $unidad = new unidad();
//        $this->registry->template->optUnidad = $unidad->obtenerSelect();
//        $usuario = new usuario();
//        $this->registry->template->optUsuario = $usuario->obtenerSelect();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteExpedientes", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteInventarioDocumentos.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

            $this->verRpte_serie();
        
    }

    function verRpte_serie() {

        
        $filtro_series = $_REQUEST["filtro_series"];
        if(isset( $_REQUEST["filtro_expedientes"])){
        $filtro_expedientes = $_REQUEST["filtro_expedientes"];
        }else{
            $filtro_expedientes="";
        }

        $where = "";
        $where .= " AND tab_usuario.usu_id=" . $_SESSION["USU_ID"];

        $order_by = "";

   

        //PARA LOS FILTROS
        if ($filtro_series != '') {
            $where.=" AND tab_series.ser_id =  '$filtro_series' ";
        }
        if ($filtro_expedientes != '') {
            $where.=" AND tab_expediente.exp_id =  '$filtro_expedientes' ";
        }
        $sqlh = "SELECT
                    fonp.fon_descripcion as fondes,
                    tab_fondo.fon_descripcion,
                    tab_unidad.uni_descripcion,
                    tab_unidad.uni_codigo,
                    tab_rol.rol_titulo,
                    tab_rol.rol_cod,
                    tab_fondo.fon_cod,
                    tab_unidad.uni_cod,
                    tab_tipocorr.tco_codigo,
                    tab_series.ser_codigo,
                    tab_series.ser_categoria
                    
                    FROM
                    tab_fondo
                    INNER JOIN tab_fondo as fonp ON tab_fondo.fon_par = fonp.fon_id
                    INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                    INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    INNER JOIN tab_usu_serie ON tab_series.ser_id = tab_usu_serie.ser_id
                    INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_usu_serie.usu_id
                    INNER JOIN tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                    INNER JOIN tab_expusuario ON tab_expusuario.usu_id = tab_usuario.usu_id
                    INNER JOIN tab_expediente ON tab_expediente.ser_id = tab_series.ser_id
                    WHERE tab_expusuario.eus_estado = 1 " . $where;

        $expedienteh = new Tab_expediente();
        $resulth = $expedienteh->dbselectBySQL($sqlh);

        $cadenah = "<br/><br/><br/><br/><br/><br/><br/><br/>";


        if (count($resulth) > 0) {

            $cadenah .= '<table width="780" border="0" cellpadding="2">';
            $cadenah .= '<tr><td align="center">';
            $cadenah .= '<span style="font-size: 24px;">' . $resulth[0]->uni_descripcion . ' (' . $resulth[0]->uni_codigo . ')</span>';
            $cadenah .= '</td></tr>';
            $cadenah .= '<tr><td align="center">';
            $cadenah .= '<span style="font-size: 24px;">' . $resulth[0]->rol_titulo . ' (' . $resulth[0]->rol_cod . ')</span>';
            $cadenah .= '</td></tr>';
            $cadenah .= '<tr><td align="center">';
            $cadenah .= '<span style="font-size: 30px;font-weight: bold;text-decoration: underline;">';
            $cadenah .= 'FORMULARIO DE INVENTARIO DE DOCUMENTOS';
            $cadenah .= '</span>';
            $cadenah .= '</td></tr>';
            $cadenah .= '</table>';
            $cadenah .= '<br/><br/>';

            $cadenah .= '<table width="760" border="1" cellpadding="2">';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 20px;font-weight: bold;"> FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 20px;">' . $resulth[0]->fondes . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 20px;font-weight: bold;">INSTRUMENTO DE CONSULTA:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 20px;">INVENTARIO DE EXPEDIENTES</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 20px;font-weight: bold;">SUB-FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 20px;">' . $resulth[0]->fon_descripcion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 20px;font-weight: bold;">SECCIÓN:</span></td>';
            $cadenah .= '<td width="220" ><span style="font-size: 20px;">' . $resulth[0]->uni_descripcion . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '</table>';
        }


        $sql = "SELECT
                tab_expediente.exp_id,
                tab_expediente.exp_nrocaj,
                tab_expediente.exp_nroejem,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                tab_expisadg.exp_fecha_exf,
                tab_expediente.exp_tomovol,
                (SELECT tab_sopfisico.sof_codigo
                 FROM tab_sopfisico 
                WHERE tab_sopfisico.sof_id = tab_expediente.sof_id ) as sof_codigo,
                tab_expediente.exp_sala,
                tab_expediente.exp_estante,
                tab_expediente.exp_cuerpo,
                tab_expediente.exp_balda,
                tab_expediente.exp_obs,
                tab_series.ser_categoria,
                tab_series.ser_id
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE tab_expusuario.eus_estado = 1 " . $where . $order_by;
//        
//        //echo ($sql); die ();
//
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
        $pdf->SetTitle('Reporte de Inventario');
        $pdf->SetSubject('Reporte de Inventario');
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
        $pdf->SetAutoPageBreak(TRUE, 15);
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();

//        $pdf->SetXY(110, 200);
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);

        $cadena = "";
        $cadena .= '<table width="760" border="1" cellpadding="2">';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td colspan="14" align="center" width="650"><span style="font-size: 20px;font-weight: bolder;">ÁREA DE IDENTIFICACIÓN</span></td>';
        $cadena .= '<td width="110" align="center"><span style="font-size: 20px;font-weight: bolder;">ÁREA DE NOTAS</span></td>';

//        $camposh = new expcampo;
//        $resultdh = $camposh->obtenerSelectCamposRepH($filtro_series);
//
//        $cadena .= $resultdh;

        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Unidad de Instalación</span></td>';
        $cadena .= '<td width="100" colspan="3" align="center"><span style="font-size: 20px ;font-weight: bold;">Volumen</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">N de Orden doc.</span></td>';
        $cadena .= '<td width="50" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Código de Expediente</span></td>';
        $cadena .= '<td width="240" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Nombre de Expediente</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Fecha</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Tomo/Volumen</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Soporte Físico</span></td>';
        $cadena .= '<td width="120" colspan="4" align="center"><span style="font-size: 20px ;font-weight: bold;">Ubicación Topografica</span></td>';
        $cadena .= '<td width="110" rowspan="2" align="center" valign="middle"><span style="font-size: 20px ;font-weight: bold;">Observaciones</span></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="30" align="center" valign="middle"><span style="font-size: 20px; font-weight: bold;">N de Caja</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Total piezas/cajas</span></td>';
        $cadena .= '<td width="35" align="center"><span style="font-size: 20px ;font-weight: bold;">N ejem.</span></td>';
        $cadena .= '<td width="35" align="center"><span style="font-size: 20px; font-weight: bold;">ML</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Sala</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Estante</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Cuerpo</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 20px ;font-weight: bold;">Balda</span></td>';
        $cadena .= '</tr>';
        $aux = "";
        $numero = 1;
        foreach ($result as $fila) {
            $ser_id = $fila->ser_id;

            if ($ser_id != $aux) {
                $cadena .= '<tr>';
                $cadena .= '<td width="760"><strong>Serie:' . $fila->ser_categoria . ' - ' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . '</strong></td>';
                $cadena .= '</tr>';
                $numero = 1;
                $aux = $ser_id;
            }
            $cadena .= '<tr>';
            $cadena .= '<td  width="30"><span style="font-size: 20px;">' . $fila->exp_nrocaj . '</span></td>';
            $cadena .= '<td  width="20"><span style="font-size: 20px;"></span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 20px;">' . $fila->exp_nroejem . '</span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 20px;">0,32</span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 20px;">' . $numero . '</span></td>';
            $cadena .= '<td width="50"><span style="font-size: 20px;">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . '</span></td>';
            $cadena .= '<td width="260"><span style="font-size: 20px;">' . $fila->exp_titulo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 20px;">' . $fila->exp_fecha_exi . ' - ' . $fila->exp_fecha_exf . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 20px;">' . $fila->exp_tomovol . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 20px;">' . $fila->sof_codigo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 20px;">' . $fila->exp_sala . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 20px;">' . $fila->exp_estante . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 20px;">' . $fila->exp_cuerpo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 20px;">' . $fila->exp_balda . '</span></td>';
            $cadena .= '<td width="110"><span style="font-size: 20px;">' . $fila->exp_obs . '</span></td>';
            /////
            //consulta para campos adicionales

//            $camposc = new expcampo;
//            $resultdc = $camposc->obtenerSelectCamposRepC($filtro_series, $fila->exp_id);
//            $cadena .= $resultdc;
            /////

            $cadena .= '</tr>';
            $numero++;
        }
        //obtenerSelectCamposRepC
        $cadena .= '</table>';


        $cadena = $cadenah . $cadena;
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_inventario.pdf', 'I');
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
     echo '<select name="filtro_expedientes" style="width: auto;"
                        id="filtro_funcionario" size="5" style="height: 250px">';
                   echo '<option value="">(seleccionar)</option>';
        foreach($result as $list){
            echo "<option value='".$list->exp_id."'>".$list->exp_titulo."</option>";
        }
        echo "</select>";
    }

}

?>
