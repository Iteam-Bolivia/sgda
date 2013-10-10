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

      $archivo = new prestamoslinea();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $where = ""; 
        
//        if (isset($_REQUEST ['fon_id'])) {
//            $where .= " AND tab_fondo.fon_id='$_REQUEST ['fon_id']' ";            
//        }
//        if (isset($_REQUEST ['uni_id'])) {
//            $where .= " AND tab_unidad.uni_id='$_REQUEST ['uni_id']' ";            
//        }
//        if (isset($_REQUEST ['ser_id'])) {
//            $where .= " AND tab_series.ser_id='$ser_id' ";           
//        }
//        if (!is_null($_REQUEST ['tra_id'])) {
//            $where .= " AND tab_tramite.tra_id='$tra_id' ";            
//        }
//        if (!is_null($_REQUEST ['cue_id'])) {
//            $where .= " AND tab_cuerpos.cue_id='$cue_id' ";            
//        }
//        if (!is_null($_REQUEST ['exp_titulo'])) {
//            $where .= " AND tab_expisadg.exp_titulo='$exp_titulo' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exi'])) {
//            $where .= " AND tab_expisadg.exp_fecha_exi='$exf_fecha_exi' ";            
//        }
//        if (!is_null($_REQUEST ['exf_fecha_exf'])) {
//            $where .= " AND tab_expisadg.exf_fecha_exf='$exf_fecha_exi' ";            
//        }        
        
        $usu_id = $_SESSION['USU_ID'];
        
        $select = "SELECT
                tab_archivo.fil_id,
                (SELECT fon_codigo from tab_fondo WHERE fon_id=f.fon_par) AS fon_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                f.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_id,
                tab_expediente.exp_codigo,
                tab_cuerpos.cue_codigo,
                tab_archivo.fil_codigo,
                tab_cuerpos.cue_descripcion,
                tab_archivo.fil_titulo,
                tab_archivo.fil_proc,
                tab_archivo.fil_firma,
                tab_archivo.fil_cargo,
                tab_archivo.fil_nrofoj,
                tab_archivo.fil_tomovol,
                tab_archivo.fil_nroejem,
                tab_archivo.fil_nrocaj,
                tab_archivo.fil_sala,
                tab_archivo.fil_estante,
                tab_archivo.fil_cuerpo,
                tab_archivo.fil_balda,
                tab_archivo.fil_tipoarch,
                tab_archivo.fil_mrb,
                tab_archivo.fil_ori,
                tab_archivo.fil_cop,
                tab_archivo.fil_fot,
                (CASE tab_exparchivo.exa_condicion 
                                    WHEN '1' THEN 'DISPONIBLE' 
                                    WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
                (SELECT fil_nomoriginal FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_nomoriginal,
                (SELECT fil_extension FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_extension,
                (SELECT fil_tamano/1048576 FROM tab_archivo_digital WHERE tab_archivo_digital.fil_id=tab_archivo.fil_id AND tab_archivo_digital.fil_estado = '1' ) AS fil_tamano,
                (SELECT fil_nur FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_nur,                
                (SELECT fil_asunto FROM tab_doccorr WHERE tab_doccorr.fil_id=tab_archivo.fil_id AND tab_doccorr.dco_estado = '1' ) AS fil_asunto,                
                tab_archivo.fil_obs";
        $from = " FROM
                tab_fondo as f
                INNER JOIN tab_unidad ON f.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_exparchivo.cue_id
                INNER JOIN tab_tramitecuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                WHERE
                f.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_archivo.fil_estado = 1 AND
                tab_exparchivo.exa_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND
                tab_expusuario.usu_id=$usu_id ";
             
        
        $sql =$select.$from;
        $result = $tarchivo->dbSelectBySQL($sql);         
        $this->usuario = new usuario ();
        
        // PDF
        // Landscape
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Reporte de Buscar Archivo ');
        $pdf->SetSubject('Reporte de Buscar Archivo ');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//        aumentado
        $pdf->SetKeywords('Iteam, Sistema de Archivo Digital');
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
        $pdf->SetFont('helvetica', '', 6);
        // add a page
        $pdf->AddPage();
        // Report
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);
$cadena="";
        $cadena = "<br/><br/><br/><br/><br/><br/>";
        $cadena .= '<table width="780" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'Reporte de Búsqueda de Documentos';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
      
            $cadena .= '<tr><td align="left">Código: ' . "" . '</td></tr>';
            $cadena .= '<tr><td align="left">Sección Remitente: ' . ""  . '</td></tr>';
            $cadena .= '<tr><td align="left">Dirección y Teléfono: ' . "" . '</td></tr>';
            $cadena .= '</table>';
        
        // Header
        $cadena .= '<table width="700" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Fondo</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Sección</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Serie</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Expediente</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Tipo Doc.</strong></div></td>';
        $cadena .= '<td width="80"><div align="center"><strong>Cod.Doc.</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Titulo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Proc.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Firma</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Cargo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.Foj.</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Nro.Caja</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Sala</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Estante</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Cuerpo</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Balda</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Tipo</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Estado</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Ori</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Cop</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Nro.Fot</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>NUR/NURI</strong></div></td>';
        $cadena .= '<td width="30"><div align="center"><strong>Asunto/Ref.</strong></div></td>';
        $cadena .= '<td width="40"><div align="center"><strong>Disponibilidad</strong></div></td>';
        $cadena .= '<td width="50"><div align="center"><strong>Doc.Digital</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Tamaño</strong></div></td>';
        $cadena .= '<td width="20"><div align="center"><strong>Obs.</strong></div></td>';
        
        
        
        $cadena .= '</tr>';
        $numero = 1;
        foreach ($result as $fila) {
            $cadena .= '<tr>';
            $cadena .= '<td width="20"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="20">' . $fila->fon_codigo .  '</td>';
            $cadena .= '<td width="50">' . $fila->uni_descripcion .  '</td>';
            $cadena .= '<td width="50">' . $fila->ser_categoria .  '</td>';
            $cadena .= '<td width="50">' . $fila->exp_titulo .  '</td>';
            $cadena .= '<td width="50">' . $fila->cue_descripcion .  '</td>';
            $cadena .= '<td width="80">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo . DELIMITER . $fila->cue_codigo .  DELIMITER . $fila->fil_codigo .  '</td>';
            $cadena .= '<td width="50">' . $fila->fil_titulo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_proc .  '</td>';
            $cadena .= '<td width="20">' . $fila->fil_firma . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_cargo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_nrofoj . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_nrocaj . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_sala . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_estante . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_cuerpo . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_balda . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_tipoarch . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_mrb . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_ori . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_cop . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_fot . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_nur . '</td>';
            $cadena .= '<td width="30">' . $fila->fil_asunto . '</td>';
            $cadena .= '<td width="40">' . $fila->disponibilidad . '</td>';
            $cadena .= '<td width="50">' . $fila->fil_nomoriginal . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_tamano . '</td>';
            $cadena .= '<td width="20">' . $fila->fil_obs . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }            
        
        $cadena .= '</table>';
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_buscar_archivo.pdf', 'I');
    }

}

?>
