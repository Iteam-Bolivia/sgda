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
class reportePrestamosController Extends baseController {

    function index() {

        $series = new series();
        $this->registry->template->optSerie = $series->obtenerSelectSeries();
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
        $liMenu = $this->menu->imprimirMenu("reportePrestamos", $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('prestamos/reportePrestamos.tpl');
        $this->registry->template->show('footer');
    }

    function verRpte() {

$fecha_inicial=$_REQUEST['f_prestdesde'];
$fecha_final=$_REQUEST['f_presthasta'];
            $this->verRpte_serie($fecha_inicial,$fecha_final);
    
    }

    function verRpte_serie($fi,$ff) {

           $sql="SELECT
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
tab_unidad.uni_descripcion
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
tab_solprestamo.spr_fecent>='$fi' and  tab_solprestamo.spr_fecent<='$ff'";
       // $sql = "SELECT* FROM tab_solprestamo where spr_fecent>='$fi' and spr_fecent<='$ff'";
//        
//        //echo ($sql); die ();
//
        $solprestamos=new Tab_solprestamo();

        $todo=$solprestamos->dbSelectBySQL($sql);
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
$fec1=explode("-",$fi);
$fech1=$fec1[2]."-".$fec1[1]."-".$fec1[0];
$fec2=explode("-",$ff);
$fech2=$fec2[2]."-".$fec2[1]."-".$fec2[0];
        $cadenah="";
        $cadenah = "<br/><br/><br/><br/><br/><br/><br/><br/>";
        $cadenah .= '<table width="790" border="0" >';
        $cadenah .= '<tr><td align="center">';
        $cadenah .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadenah .= 'Listado de prestamos de '.$fech1.' al '.$fech2;
        $cadenah .= '</span>';
        $cadenah .= '</td></tr></table><br>';
        $cadena="";
$cadena.='<table width="790" border="1" cellspacing="2">';
  $cadena.='<tr>';
    $cadena.='<td width="20" bgcolor="#CCCCCC" align="center">Nro </td>';
    $cadena.='<td width="20" bgcolor="#CCCCCC"  align="center">Id</td>';
    $cadena.='<td width="70" bgcolor="#CCCCCC"  align="center">Codigo</td>';
    $cadena.='<td width="100" bgcolor="#CCCCCC"  >DOCUMENTO SOLICITADO</td>';
    $cadena.='<td width="48" bgcolor="#CCCCCC" align="center">FECHA SOLIC.</td>';
    $cadena.='<td width="86" bgcolor="#CCCCCC">UNIDAD</td>';
    $cadena.='<td width="65" bgcolor="#CCCCCC">SOLICITADO POR</td>';
    $cadena.='<td width="65" bgcolor="#CCCCCC">AUTORIZADO</td>';
    $cadena.='<td width="65" bgcolor="#CCCCCC">PRESTAMISTA</td>';
    $cadena.='<td width="60" bgcolor="#CCCCCC">OBSERVACION</td>';
    $cadena.='<td width="48" bgcolor="#CCCCCC" align="center">FECHA DE ENTREGA</td>';
    $cadena.='<td width="48" bgcolor="#CCCCCC" align="center">FECHA DE VENCI.</td>';

    $cadena.='<td width="50" bgcolor="#CCCCCC" align="center">ESTADO</td>';
  $cadena.='</tr>';
  $i=0;
  foreach($todo as $row){
   $i++;
      
      $unidad=$row->uni_descripcion;
     $spr_fecha=explode("-",$row->spr_fecha);
     $spr_fecha=$spr_fecha[2]."-".$spr_fecha[1]."-".$spr_fecha[0];
  $cadena.='<tr>';
   $cadena.='<td align="center">'.$i.'</td>';
    $cadena.='<td align="center">'.$row->spr_id.'</td>';
    $cadena.='<td align="center">'.$row->fon_cod.DELIMITER.$row->uni_codigo.DELIMITER.$row->ser_codigo.DELIMITER.$row->exp_codigo.DELIMITER.$row->fil_codigo.'</td>';
    $cadena.='<td >'.$row->fil_titulo.'</td>';
    $cadena.='<td align="center">'.$spr_fecha.'</td>';
    $cadena.='<td>'.$unidad.'</td>';
    $cadena.='<td>';
    if($row->spr_solicitante==""){
        $solicitante=$row->usu_solicitante;
        $cadena.=$solicitante;
    }else{
        $cadena.=$row->spr_solicitante;
    }
    $cadena.='</td>';
    $cadena.='<td>';
    $cadena.=$row->usu_autoriza;
    $cadena.='</td>';
    $cadena.='<td>';
    $cadena.=$row->usu_registrado;
    $cadena.='</td>';
    $cadena.='<td>'.$row->spr_obs.'</td>';
    $cadena.='<td align="center">';
    $fecha=explode("-",$row->spr_fecent);
    $fechaini=$fecha[2]."-".$fecha[1]."-".$fecha[0];
    $cadena.=$fechaini;
    $cadena.='</td>';
    $cadena.='<td align="center">';
        $fecha1=explode("-",$row->spr_fecdev);
    $fechafin=$fecha1[2]."-".$fecha1[1]."-".$fecha1[0];
    $cadena.=$fechafin;
    $cadena.='</td>';

    $cadena.='<th align="center" bgcolor="#CCCCCC">';
        $estado=$row->spr_estado;
        
          if($estado==0){
              $est="Devuelto";
          }else if($estado==1){
              $est="En proceso";
          }else if($estado==2){
              $est="Prestado";
          }
                     $cadena.=$est;
    $cadena.='</th>';
  $cadena.='</tr>';
  }
  
$cadena.='</table>';
$cadena.='<br><b>Se encontraron '.$i.' Resultados</b>';
        $cadena = $cadenah . $cadena;
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_prestamos.pdf', 'I');
    }

}

?>
