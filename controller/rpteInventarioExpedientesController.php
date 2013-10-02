<?php

/**
 * @package
 * @author Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class rpteInventarioExpedientesController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectTodas();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verRpte";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu("rpteInventario", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rpteInventarioExpedientes.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

        $filtro_serie = $_REQUEST["ser_id"];
        $where = "";
        $where .= " AND tab_usuario.usu_id=" . $_SESSION["USU_ID"];

        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        $order_by.=" ORDER BY tab_expediente.exp_codigo, tab_expisadg.exp_titulo ASC ";
        //PARA LOS FILTROS
        if ($filtro_serie != '') {
            $where.=" AND tab_series.ser_id =  '$filtro_serie' ";
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
                    tab_series.ser_categoria,
                    (SELECT COUNT (DISTINCT exp.exp_nrocaj)
                                 FROM tab_expediente as exp INNER JOIN
                                 tab_expusuario AS use ON exp.exp_id = use.exp_id
                      WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS totcja,
                    (SELECT COUNT (exp.exp_id) FROM tab_expediente as exp INNER JOIN
                                 tab_expusuario AS use ON exp.exp_id = use.exp_id
                      WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS totpzs,
                    (SELECT (COUNT (DISTINCT exp.exp_nrocaj)) * 0.32
                                 FROM tab_expediente as exp INNER JOIN
                                 tab_expusuario AS use ON exp.exp_id = use.exp_id
                      WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS totml,
                    (SELECT MIN (isad.exp_fecha_exi)
                                 FROM tab_expediente as exp INNER JOIN
                                                                     tab_expisadg AS isad ON exp.exp_id = isad.exp_id INNER JOIN
                                 tab_expusuario AS use ON exp.exp_id = use.exp_id
                      WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS fechaini,
                    (SELECT MAX (isad.exp_fecha_exf)
                                 FROM tab_expediente as exp INNER JOIN
                                                                     tab_expisadg AS isad ON exp.exp_id = isad.exp_id INNER JOIN
                                 tab_expusuario AS use ON exp.exp_id = use.exp_id
                      WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS fechafin
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
            $cadenah .= 'FORMULARIO DE INVENTARIO DE EXPEDIENTES';
            $cadenah .= '</span>';
            $cadenah .= '</td></tr>';
            $cadenah .= '</table>';
            $cadenah .= '<br/><br/>';

            $cadenah .= '<table width="760" border="1" cellpadding="2">';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;"> FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fondes . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">INSTRUMENTO DE CONSULTA:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">INVENTARIO DE EXPEDIENTES</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SUB-FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fon_descripcion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">CONSERVACIÓN DOCUMENTAL:</span></td>';
            $cadenah .= '<td width="220" ><span style="font-size: 14px;"></span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SECCIÓN:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->uni_descripcion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE CAJAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totcja . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">CODIGO DEL REFERENCIA:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fon_cod . DELIMITER . $resulth[0]->uni_cod . DELIMITER . $resulth[0]->tco_codigo . DELIMITER . $resulth[0]->ser_codigo . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE PIEZAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totpzs . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">NIVEL DE DESCRIPCIÓN:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;"></span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE ML:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totml . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SERIES:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->ser_categoria . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">FECHAS EXTREMAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->fechaini . '-' . $resulth[0]->fechafin . '</span></td>';
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
                tab_expediente.exp_obs
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
        $cadena .= '<td colspan="14" align="center" width="550"><span style="font-size: 12px;font-weight: bolder;">ÁREA DE IDENTIFICACIÓN</span></td>';
        $cadena .= '<td width="60" align="center"><span style="font-size: 12px;font-weight: bolder;">ÁREA DE NOTAS</span></td>';

        $camposh = new expcampo;
        $resultdh = $camposh->obtenerSelectCamposRepH($filtro_serie);

        $cadena .= $resultdh;

        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">Unidad de Instalación</span></td>';
        $cadena .= '<td width="80" colspan="3" align="center"><span style="font-size: 11px ;font-weight: bold;">Volumen</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">N de Orden doc.</span></td>';
        $cadena .= '<td width="50" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Código de Expediente</span></td>';
        $cadena .= '<td width="160" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Nombre de Expediente</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Fecha</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Tomo/Volumen</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Soporte Físico</span></td>';
        $cadena .= '<td width="120" colspan="4" align="center"><span style="font-size: 11px ;font-weight: bold;">Ubicación Topografica</span></td>';
        $cadena .= '<td width="60" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Observaciones</span></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="30" align="center" valign="middle"><span style="font-size: 11px; font-weight: bold;">N de Caja</span></td>';
        $cadena .= '<td width="20" align="center"><span style="font-size: 11px ;font-weight: bold;">Total piezas/cajas</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">N ejem.</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px; font-weight: bold;">ML</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">Sala</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">Estante</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">Cuerpo</span></td>';
        $cadena .= '<td width="30" align="center"><span style="font-size: 11px ;font-weight: bold;">Balda</span></td>';
        $cadena .= '</tr>';
        $numero = 1;
        foreach ($result as $fila) {
            $cadena .= '<tr>';
            $cadena .= '<td  width="30"><span style="font-size: 11px;">' . $fila->exp_nrocaj . '</span></td>';
            $cadena .= '<td  width="20"><span style="font-size: 11px;"></span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 11px;">' . $fila->exp_nroejem . '</span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 11px;">0,32</span></td>';
            $cadena .= '<td  width="30"><span style="font-size: 11px;">' . $numero . '</span></td>';
            $cadena .= '<td width="50"><span style="font-size: 11px;">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . '</span></td>';
            $cadena .= '<td width="160"><span style="font-size: 11px;">' . $fila->exp_titulo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->exp_fecha_exi . ' - ' . $fila->exp_fecha_exf . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->exp_tomovol . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->sof_codigo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->exp_sala . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->exp_estante . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->exp_cuerpo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->exp_balda . '</span></td>';
            $cadena .= '<td width="60"><span style="font-size: 11px;">' . $fila->exp_obs . '</span></td>';
            /////
            //consulta para campos adicionales

            $camposc = new expcampo;
            $resultdc = $camposc->obtenerSelectCamposRepC($filtro_serie, $fila->exp_id);
            $cadena .= $resultdc;
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
    
    
    // Reporte Inventario Documentos
    function verRpteDoc() {

        $filtro_expediente = $_REQUEST["exp_id"];
        $filtro_serie = $_REQUEST["ser_id"];
        $where = "";

        //PARA LA ORDENACION SOLO SE ESCOJE UNA OPCION
        $order_by = "";
        $order_by.=" ORDER BY tab_archivo.fil_codigo, tab_archivo.fil_titulo ASC ";
        //PARA LOS FILTROS
        if ($filtro_expediente != '') {
            $where.=" AND tab_expediente.exp_id = '$filtro_expediente' ";
        }

        $sqlh = "SELECT
                
                fonp.fon_descripcion as fondes,
                tab_fondo.fon_descripcion,
                sec.uni_descripcion AS seccion,
		tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_descripcion,
                tab_unidad.uni_codigo,
                tab_rol.rol_titulo,
                tab_rol.rol_cod,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                (SELECT COUNT (DISTINCT arc.fil_nrocaj)
                             FROM tab_archivo as arc INNER JOIN
                             tab_exparchivo AS exa ON arc.fil_id = exa.fil_id
                  WHERE exa.exp_id = tab_expediente.exp_id) AS totcja,
                (SELECT COUNT (arc.fil_id) FROM tab_archivo as arc INNER JOIN
                             tab_exparchivo AS exa ON arc.fil_id = exa.fil_id
                  WHERE exa.exp_id = tab_expediente.exp_id) AS totpzs,
                (SELECT (COUNT (DISTINCT arc.fil_nrocaj))* 0.32
                             FROM tab_archivo as arc INNER JOIN
                             tab_exparchivo AS exa ON arc.fil_id = exa.fil_id
                  WHERE exa.exp_id = tab_expediente.exp_id) AS totml,
                (SELECT MIN (isad.exp_fecha_exi)
                             FROM tab_expediente as exp INNER JOIN
                                                                 tab_expisadg AS isad ON exp.exp_id = isad.exp_id INNER JOIN
                             tab_expusuario AS use ON exp.exp_id = use.exp_id
                  WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS fechaini,
                (SELECT MAX (isad.exp_fecha_exf)
                             FROM tab_expediente as exp INNER JOIN
                                                                 tab_expisadg AS isad ON exp.exp_id = isad.exp_id INNER JOIN
                             tab_expusuario AS use ON exp.exp_id = use.exp_id
                  WHERE exp.ser_id = tab_series.ser_id AND use.usu_id = tab_usuario.usu_id AND use.eus_estado = 1) AS fechafin
                FROM
								tab_expediente
                    INNER JOIN tab_expisadg ON tab_expediente.exp_id =tab_expisadg.exp_id
                    INNER JOIN tab_series ON tab_expediente.ser_id = tab_series.ser_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                    INNER JOIN tab_usuario ON tab_expusuario.usu_id = tab_usuario.usu_id
                    INNER JOIN tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                    INNER JOIN tab_unidad ON tab_series.uni_id = tab_unidad.uni_id
                    INNER JOIN tab_unidad AS sec ON tab_unidad.uni_par = sec.uni_id
                    INNER JOIN tab_fondo ON sec.fon_id = tab_fondo.fon_id
                    INNER JOIN tab_fondo as fonp ON tab_fondo.fon_par = fonp.fon_id 
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
            $cadenah .= 'FORMULARIO DE INVENTARIO DE EXPEDIENTES';
            $cadenah .= '</span>';
            $cadenah .= '</td></tr>';
            $cadenah .= '</table>';
            $cadenah .= '<br/><br/>';

            $cadenah .= '<table width="760" border="1" cellpadding="2">';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;"> FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fondes . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">INSTRUMENTO DE CONSULTA:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">INVENTARIO DE DOCUMENTOS</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SUB-FONDO:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fon_descripcion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE CAJAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totcja . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SECCIÓN:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->seccion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE PIEZAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totpzs . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SUB SECCIÓN:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->uni_descripcion . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">TOTAL DE ML:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->totml . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">CÓDIGO DE REFERENCIA:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->fon_cod . DELIMITER . $resulth[0]->uni_cod . DELIMITER . $resulth[0]->tco_codigo . DELIMITER . $resulth[0]->ser_codigo . DELIMITER . $resulth[0]->exp_codigo . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">NIVEL DE DESCRIPCIÓN:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">UNIDAD DOCUMENTAL SIMPLE</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">SERIES:</span></td>';
            $cadenah .= '<td width="350"><span style="font-size: 14px;">' . $resulth[0]->ser_categoria . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">FECHAS EXTREMAS:</span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;">' . $resulth[0]->fechaini . '-' . $resulth[0]->fechafin . '</span></td>';
            $cadenah .= '</tr>';
            $cadenah .= '<tr>';
            $cadenah .= '<td width="100" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">EXPEDIENTE(PROYECTO):</span></td>';
            $cadenah .= '<td width="350" ><span style="font-size: 14px;">' . $resulth[0]->exp_titulo . '</span></td>';
            $cadenah .= '<td width="90" bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;"></span></td>';
            $cadenah .= '<td width="220"><span style="font-size: 14px;"></span></td>';
            $cadenah .= '</tr>';
                        /////
            //consulta para campos adicionales

            $camposc = new expcampo;
            $resultdc = $camposc->obtenerSelectCamposRepDoc($filtro_serie, $filtro_expediente);
            $cadenah .= $resultdc;
            /////

            $cadenah .= '</table>';
 
        }


        $sql = "SELECT
                        tab_archivo.fil_nrocaj,
                        tab_archivo.fil_nroejem,
                        tab_fondo.fon_cod,
                        tab_unidad.uni_cod,
                        tab_tipocorr.tco_codigo,
                        tab_series.ser_codigo,
                        tab_expediente.exp_codigo,
                        tab_archivo.fil_codigo,
                        tab_departamento.dep_nombre,
                        tab_archivo.fil_titulo,
                        tab_archivo.fil_subtitulo,
                        tab_archivo.fil_proc,
                        tab_archivo.fil_firma,
                        tab_expisadg.exp_fecha_exi,
                        tab_expisadg.exp_fecha_exf,
                        tab_archivo.fil_tomovol,
                        tab_archivo.fil_nrofoj,
                        (SELECT tab_sopfisico.sof_codigo
                                         FROM tab_sopfisico 
                                        WHERE tab_sopfisico.sof_id = tab_archivo.sof_id ) as sof_codigo,
                                                                                    tab_archivo.fil_mrb,
                                                                                    tab_archivo.fil_sala,
                        tab_archivo.fil_estante,
                        tab_archivo.fil_cuerpo,
                        tab_archivo.fil_balda,
                        tab_archivo.fil_obs
                        FROM
                        tab_expediente
                        INNER JOIN tab_expisadg ON tab_expediente.exp_id =tab_expisadg.exp_id
                        INNER JOIN tab_series ON tab_expediente.ser_id = tab_series.ser_id
                        INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                        INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                        INNER JOIN tab_usuario ON tab_expusuario.usu_id = tab_usuario.usu_id
                        INNER JOIN tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                        INNER JOIN tab_unidad ON tab_series.uni_id = tab_unidad.uni_id
                        INNER JOIN tab_unidad AS sec ON tab_unidad.uni_par = sec.uni_id
                        INNER JOIN tab_fondo ON sec.fon_id = tab_fondo.fon_id
                        INNER JOIN tab_fondo as fonp ON tab_fondo.fon_par = fonp.fon_id
                        INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                        INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                        INNER JOIN tab_archivo_digital ON tab_archivo.fil_id = tab_archivo_digital.fil_id
                        INNER JOIN tab_ubicacion ON tab_unidad.ubi_id = tab_ubicacion.ubi_id
                        INNER JOIN tab_localidad ON tab_ubicacion.loc_id = tab_localidad.loc_id
                        INNER JOIN tab_provincia ON tab_localidad.pro_id = tab_provincia.pro_id
                        INNER JOIN tab_departamento ON tab_provincia.dep_id = tab_departamento.dep_id
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
        $cadena .= '<td colspan="19" align="center" width="700"><span style="font-size: 12px;font-weight: bolder;">ÁREA DE IDENTIFICACIÓN</span></td>';
        $cadena .= '<td width="60" align="center"><span style="font-size: 12px;font-weight: bolder;">ÁREA DE NOTAS</span></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="25"  rowspan="2" align="center"><span style="font-size: 11px ;font-weight: bold;">N de Caja</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center"><span style="font-size: 11px ;font-weight: bold;">Total piezas/cajas</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center"><span style="font-size: 11px ;font-weight: bold;">N ejem.</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center"><span style="font-size: 11px; font-weight: bold;">ML</span></td>';
        $cadena .= '<td width="60" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">N de Orden doc.</span></td>';
        $cadena .= '<td width="40" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Depto.</span></td>';
        $cadena .= '<td width="90" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Titulo del Documento</span></td>';
        $cadena .= '<td width="70" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Sub titulo</span></td>';
        $cadena .= '<td width="45" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Productor</span></td>';
        $cadena .= '<td width="40" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Firma</span></td>';
        $cadena .= '<td width="35" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Fecha</span></td>';
        $cadena .= '<td width="35" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Tomo/Volumen</span></td>';
        $cadena .= '<td width="25" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Fojas</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Soporte Físico</span></td>';
        $cadena .= '<td width="30" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Conser. Doc.</span></td>';
        $cadena .= '<td width="100" colspan="4" align="center"><span style="font-size: 11px ;font-weight: bold;">Ubicación Topografica</span></td>';
        $cadena .= '<td width="60" rowspan="2" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">Observaciones</span></td>';
        $cadena .= '</tr>';
        $cadena .= '<tr bgcolor="#CCCCCC">';
        $cadena .= '<td width="25" align="center"><span style="font-size: 11px ;font-weight: bold;">Sala</span></td>';
        $cadena .= '<td width="25" align="center"><span style="font-size: 11px ;font-weight: bold;">Estante</span></td>';
        $cadena .= '<td width="25" align="center"><span style="font-size: 11px ;font-weight: bold;">Cuerpo</span></td>';
        $cadena .= '<td width="25" align="center"><span style="font-size: 11px ;font-weight: bold;">Balda</span></td>';
        $cadena .= '</tr>';
        $numero = 1;
        foreach ($result as $fila) {
            $cadena .= '<tr>';
            $cadena .= '<td  width="25"><span style="font-size: 11px;">' . $fila->fil_nrocaj . '</span></td>';
            $cadena .= '<td  width="25"><span style="font-size: 11px;"></span></td>';
            $cadena .= '<td  width="25"><span style="font-size: 11px;">' . $fila->fil_nroejem . '</span></td>';
            $cadena .= '<td  width="25"><span style="font-size: 11px;">0,32</span></td>';
            $cadena .= '<td  width="60"><span style="font-size: 11px;">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->fil_codigo .'</span></td>';
            $cadena .= '<td width="40"><span style="font-size: 11px;">' . $fila->dep_nombre . '</span></td>';
            
            $cadena .= '<td width="90"><span style="font-size: 11px;">' . $fila->fil_titulo .  '</span></td>';
            $cadena .= '<td width="70"><span style="font-size: 11px;">' . $fila->fil_subtitulo . '</span></td>';
            $cadena .= '<td width="45"><span style="font-size: 11px;">' . $fila->fil_proc . '</span></td>';
            $cadena .= '<td width="40"><span style="font-size: 11px;">' . $fila->fil_firma . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' .  $fila->exp_fecha_exi . ' - ' . $fila->exp_fecha_exf . '</span></td>';
            $cadena .= '<td width="35"><span style="font-size: 11px;">' . $fila->fil_tomovol . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->fil_nrofoj . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->sof_codigo . '</span></td>';
            $cadena .= '<td width="30"><span style="font-size: 11px;">' . $fila->fil_mrb . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->fil_sala . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->fil_estante . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->fil_cuerpo . '</span></td>';
            $cadena .= '<td width="25"><span style="font-size: 11px;">' . $fila->fil_balda . '</span></td>';
            $cadena .= '<td width="60"><span style="font-size: 11px;">' . $fila->fil_obs . '</span></td>';
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
    
    
    
    
    
    
    
    
}

?>
