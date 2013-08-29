<?php

/**
 * transferenciaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class transferenciaController extends baseController {

    function index() {
      
        $this->uni = new unidad ();
        $this->usu = new usuario ();
        $this->registry->template->str_id = "";
        $this->registry->template->trn_uni_destino = $this->uni->obtenerSelectUnidades();
        $this->registry->template->trn_usuario_des = ""; 
        //$this->usu->listUsuariosOper($_SESSION ['USU_ID'],$ins_id);
        
        
        $this->series = new series ();
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();
        $this->registry->template->PATH_A = $this->series->loadMenu($adm, "test");
        $this->registry->template->PATH_B = $this->series->loadMenu($adm, "test2");

        $this->registry->template->titulo = "Expedientes";
        $this->registry->template->titulo2 = "Expedientes transferidos";          
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_transferenciag.tpl');
        $this->registry->template->show('footer');

    }

    function loadExp() {
        $this->series = new series ();
        $this->expediente = new tab_expediente ();
        $this->expediente->setRequest2Object($_REQUEST);
        $this->usuario = new usuario ();
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'tab_expediente.exp_fecha_exf';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder ";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = utf8_encode($_REQUEST ['query']);
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where .= " and tab_expediente.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query=='TODOS'){
                    $where .= "";
                }
                else{
                    $where .= " and tab_series.ser_categoria LIKE '%$query%' ";
                }
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nom%' OR tab_usuario.usu_apellidos LIKE '%$nom%') ";
                }
            }else{
                if ($query=='TODOS'){
                    $where .= "";
                }else{
                    $where .= " and $qtype LIKE '%$query%' ";
                }
            }
                
        }

        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                    (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                    FROM tab_retensiondoc 
                    WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                    tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expfondo.exf_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expfondo.exf_estado = 1                
                AND tab_expusuario.eus_estado = 1 
                 $where $sort $limit";

        $expediente = new expediente ();
        $result = $this->expediente->dbselectBySQL($sql);
        $total = $expediente->countExp2($where);

        /* header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header ( "Cache-Control: no-cache, must-revalidate" );
          header ( "Pragma: no-cache" ); */
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            
            $chk = "<input id=\"chk_" . $un->exp_id . "\" restric=\"" . $un->exp_id . "\" class=\"exp_chk\" type=\"checkbox\" value=\"" . $un->exp_id . "\" />";
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->exp_id . "',";            
            $json .= "cell:['" . $un->exp_id . "'";            
            $json .= ",'" . $chk . "'";
            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo .  DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            //$json .= ",'" . addslashes($un->exp_descripcion) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($expediente->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }

    function loadTransf() {
        //trn_confirmado indica lugar: Fondo-Institucion,
        //trn_confirmado = 0 indica una transferencia entre custodios
        $this->soltransferencia = new tab_soltransferencia ();
        $this->soltransferencia->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'str_id';
        if (!$sortorder)
            $sortorder = 'asc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where = " and tab_transferencia.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query=='TODOS'){
                    $where .= "";
                }
                else{                
                    $where = " and tab_series.ser_categoria LIKE '%$query%' ";
                }
            else{
                if ($query=='TODOS'){
                    $where .= "";
                }
                else{                
                    $where = " and $qtype LIKE '%$query%' ";
                }
            }
        }

        
        $sql = "SELECT
                tab_soltransferencia.str_id,
                tab_soltransferencia.str_fecha,
                (SELECT uni_descripcion from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.uni_id) AS uni_descripcion,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_estado = 1 AND usu_id=tab_soltransferencia.usu_id) AS usu_nombres,
                tab_soltransferencia.uni_id,
                tab_soltransferencia.usu_id,
                (SELECT uni_descripcion from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.unid_id) AS unid_descripcion,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_estado = 1 AND usu_id=tab_soltransferencia.usud_id) AS usud_nombres,
                tab_soltransferencia.str_nrocajas,
                tab_soltransferencia.str_totpzas,
                tab_soltransferencia.str_totml,
                tab_soltransferencia.str_nroreg,
                tab_soltransferencia.str_fecini,
                tab_soltransferencia.str_fecfin,
                tab_soltransferencia.str_estado
                FROM
                tab_soltransferencia
                WHERE 
                tab_soltransferencia.str_estado = 1 AND
                tab_soltransferencia.usu_id = " . $_SESSION['USU_ID'] . "
                $where $sort $limit";        
        
        $soltransferencia = new soltransferencia ();
        $result = $this->soltransferencia->dbselectBySQL($sql);
        $total = $soltransferencia->countExp2($where);

        /* header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header ( "Cache-Control: no-cache, must-revalidate" );
          header ( "Pragma: no-cache" ); */
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->str_id . "',";            
            $json .= "cell:['" . $un->str_id . "'";
            $json .= ",'" . addslashes($un->str_fecha) . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($un->usu_nombres) . "'";
            $json .= ",'" . addslashes($un->unid_descripcion) . "'";
            $json .= ",'" . addslashes($un->usud_nombres) . "'";            
            $json .= ",'" . addslashes($un->str_nrocajas) . "'";
            $json .= ",'" . addslashes($un->str_totpzas) . "'";
            $json .= ",'" . addslashes($un->str_totml) . "'";
            $json .= ",'" . addslashes($un->str_nroreg) . "'";
            $json .= ",'" . addslashes($un->str_fecini) . "'";
            $json .= ",'" . addslashes($un->str_fecfin) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }

    
    function view() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);
        $row = $this->transferencia->dbselectByField("trn_id", $_REQUEST ["trn_id"]);
        $row = $row [0];
        $this->registry->template->trn_id = $row->trn_id;
        $this->registry->template->exp_id = "<option value='1'>TEST</option>";
        $this->registry->template->trn_descripcion = $row->trn_descripcion;
        $this->registry->template->trn_contenido = $row->trn_contenido;
        $this->registry->template->trn_uni_origen = $row->trn_uni_origen;
        $this->registry->template->trn_uni_destino = $row->trn_uni_destino;
        $this->registry->template->trn_confirmado = $row->trn_confirmado;
        $this->registry->template->trn_fecha_crea = $row->trn_fecha_crea;
        $this->registry->template->trn_usuario_crea = $row->trn_usuario_crea;
        $this->registry->template->trn_estado = $row->trn_estado;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_transferencia.tpl');
        $this->registry->template->show('footer');
    }

    function save() {

//        $trn_uni_origen = $_REQUEST['uni_id'];
//        $trn_uni_destino = $_REQUEST['trn_uni_destino'];
//        $trn_usuario_orig = $_REQUEST['usu_id'];
//        $trn_usuario_des = $_REQUEST['trn_usuario_des']; 
//                        
        // Lista de expedientes
        $ids = substr($_REQUEST['idsExp'], 0, -1);
        $array = explode(",", $ids);
               
        // tab_soltransferencia
        $soltransferencia = new tab_soltransferencia ();
        $soltransferencia->setStr_fecha(date('Y-m-d'));
        $soltransferencia->setUni_id($_REQUEST['uni_id']);
        $soltransferencia->setUsu_id($_REQUEST['usu_id']);
        $soltransferencia->setUnid_id($_REQUEST['trn_uni_destino']);
        $soltransferencia->setUsud_id($_REQUEST['trn_usuario_des']);        
        $soltransferencia->setStr_nrocajas(1);
        $soltransferencia->setStr_totpzas(1);
        $soltransferencia->setStr_totml(1);
        $soltransferencia->setStr_nroreg(1);        
        $soltransferencia->setStr_fecini(date('Y-m-d'));
        $soltransferencia->setStr_fecfin(date('Y-m-d'));                
        $soltransferencia->setStr_estado(1);
        $str_id = $soltransferencia->insert();

        $exptransferencia = new tab_exptransferencia();
        if (count($array) > 0) {
            for ($x=0;$x<count($array); $x++) {               
                // tab_exptransferencia
                $exptransferencia->setStr_id($str_id);
                $exptransferencia->setEtr_orden($x+1);
                $exptransferencia->setExp_id($array[$x]);
                $exptransferencia->setEtr_obs("Ninguna");
                $exptransferencia->setEtr_estado(1);
                $exptransferencia->insert();
                
                // tab_expusuario
                $expediente = new expediente();
                $eus_id = $expediente->obtenerExpUsuarioId($array[$x]);

                // tab_expusuario: origen
                $this->expusuario = new tab_expusuario();
                $this->expusuario->setEus_id($eus_id);
                $this->expusuario->setUsu_id($_REQUEST['usu_id']);
                $this->expusuario->setExp_id($array[$x]);
                $this->expusuario->setEus_estado(2);
                $this->expusuario->update();

                // tab_expusuario: destino
                $this->expusuariod = new tab_expusuario();
                $this->expusuariod->setRequest2Object($_REQUEST);
                $this->expusuariod->setUsu_id($_REQUEST['trn_usuario_des']);
                $this->expusuariod->setExp_id($array[$x]);
                $this->expusuariod->setEus_estado(3);
                $eus_id = $this->expusuariod->insert();                
                                
            }
        } 
        
    }

    function verifSerie() {
        $ids = substr($_REQUEST['Ids'], 0, -1);
        $array = explode(",",$ids);
        $tususer = new tab_usu_serie();        
        foreach ($array as $valor) {
            $sql = "";
            $sql = "SELECT
                tab_usuario.usu_id,
                tab_series.ser_id,
                tab_series.ser_categoria,
                tab_expediente.exp_id
                FROM
                tab_usu_serie AS us
                INNER JOIN tab_series ON tab_series.ser_id = us.ser_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = us.usu_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                WHERE tab_usuario.usu_estado = 1
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_id = '" . $_REQUEST['usu_id'] . "' 
                AND tab_expediente.exp_id = '" . $valor . "'" ;
            $num = $tususer->countBySQL($sql);
            $res = "";
            if ($num > 0) {
                $res = "Ok";
            }else{
                $res = $valor;
            }          

        }
        

        echo $res;
    }

    function listUsuarioJson() {
        $this->usu = new usuario();
        echo $this->usu->listUsuarioJson();
    }
    
    
    function verRpte() {
        $where = "";
        $str_id = VAR3;
        $fecha_actual = date("d/m/Y");
        
        $sql = "SELECT
                tab_soltransferencia.str_id,
                (SELECT uni_descripcion from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.uni_id) AS uni_descripcion,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_estado = 1 AND usu_id=tab_soltransferencia.usu_id) AS usu_nombres,
                tab_soltransferencia.uni_id,
                tab_soltransferencia.usu_id,
                (SELECT uni_descripcion from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.unid_id) AS unid_descripcion,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_estado = 1 AND usu_id=tab_soltransferencia.usud_id) AS usud_nombres,
                tab_ubicacion.ubi_direccion,
                tab_ubicacion.ubi_descripcion,
                tab_unidad.uni_tel,
                (SELECT tab_ubicacion.ubi_direccion FROM tab_unidad INNER JOIN tab_ubicacion ON tab_ubicacion.ubi_id = tab_unidad.ubi_id WHERE uni_id=tab_soltransferencia.unid_id) AS ubid_direccion,
                (SELECT tab_ubicacion.ubi_descripcion FROM tab_unidad INNER JOIN tab_ubicacion ON tab_ubicacion.ubi_id = tab_unidad.ubi_id WHERE uni_id=tab_soltransferencia.unid_id) AS ubid_descripcion,
                (SELECT uni_tel from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.unid_id) AS unid_tel,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,                
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                                    (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                                    FROM tab_retensiondoc 
                                    WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expusuario.eus_estado,
                tab_expediente.exp_obs,
                tab_expediente.exp_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_exptransferencia ON tab_expediente.exp_id = tab_exptransferencia.exp_id
                INNER JOIN tab_soltransferencia ON tab_soltransferencia.str_id = tab_exptransferencia.str_id
                INNER JOIN tab_ubicacion ON tab_ubicacion.ubi_id = tab_unidad.ubi_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expusuario.eus_estado = 2 ";

        $soltransferencia = new tab_soltransferencia();
        $result = $soltransferencia->dbselectBySQL($sql);
        
        $this->usuario = new usuario ();
        
        // PDF
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setFontSubsetting(FALSE);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Formulario Normalizado de Transferencias ');
        $pdf->SetSubject('Formulario Normalizado de Transferencias ');
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
        $pdf->SetFont('helvetica', '', 8);
        // add a page
        $pdf->AddPage();
        // Report
        $pdf->Image(PATH_ROOT . '/web/img/iso.png', '255', '8', 15, 15, 'PNG', '', 'T', false, 300, '', false, false, 1, false, false, false);
        
        $cadena = "<br/><br/><br/><br/><br/>";
        $cadena .= '<table width="780" border="0" >';
        $cadena .= '<tr><td align="center">';
        $cadena .= '<span style="font-size: 30px;font-weight: bold;">';
        $cadena .= 'Formulario de Relación de Transferencias ';
        $cadena .= '</span>';
        $cadena .= '</td></tr>';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left">Código: ' . $fila->str_id . '</td></tr>';
            $cadena .= '<tr><td align="left">Sección Remitente: ' . $fila->uni_descripcion  . '</td></tr>';
            $cadena .= '<tr><td align="left">Dirección y Teléfono: ' . $fila->ubi_direccion . "-" . $fila->ubi_descripcion  . " Tel. ".$fila->uni_tel . '</td></tr>';
            //$cadena .= '<tr><td align="left"></td></tr>';
            $cadena .= '<tr><td align="left">Sección Destino: ' . $fila->unid_descripcion . '</td></tr>';
            $cadena .= '<tr><td align="left">Dirección y Teléfono: ' . $fila->ubid_direccion . "-" . $fila->ubid_descripcion  . " Tel. ".$fila->unid_tel . '</td></tr>';
            //$cadena .= '<tr><td align="left">Serie:' . $fila->str_id  . '</td></tr>';
            $cadena .= '</table>';
            break;
        }
        
        // Header        
        $cadena .= '<table width="700" border="1">';
        $cadena .= '<tr>';
        $cadena .= '<td width="50"><div align="center"><strong>Nro.</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Código</strong></div></td>';
        $cadena .= '<td width="400"><div align="center"><strong>Descripción de Contenido (Título del expediente)</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Fechas Extremas</strong></div></td>';
        $cadena .= '<td width="100"><div align="center"><strong>Observaciones</strong></div></td>';
        $cadena .= '</tr>';

        $numero = 1;
        foreach ($result as $fila) {
            $cadena .= '<tr>';
            $cadena .= '<td width="50"><div align="center">' . $numero . '</div></td>';
            $cadena .= '<td width="100">' . $fila->fon_cod . DELIMITER . $fila->uni_cod . DELIMITER . $fila->tco_codigo . DELIMITER . $fila->ser_codigo . DELIMITER . $fila->exp_codigo .  '</td>';
            $cadena .= '<td width="400">' . $fila->exp_titulo . '</td>';
            $cadena .= '<td width="100">' . $fila->exp_fecha_exi . " - " . $fila->exp_fecha_exf . '</td>';
            $cadena .= '<td width="100">' . $fila->exp_obs . '</td>';
            $cadena .= '</tr>';
            $numero++;
        }
         $cadena .= '</table>';
        
        // Footer        
        $cadena .= '<table width="780" border="0" >';
        foreach ($result as $fila) {
            $cadena .= '<tr><td align="left">Lugar y Fecha de la Transferencia: ' . $fecha_actual . '</td></tr>';
            $cadena .= '<tr><td align="left">Entregué conforme: ' . $fila->usu_nombres . '</td></tr>';
            $cadena .= '<tr><td align="left">Recibí conforme: ' . $fila->usud_nombres . '</td></tr>';
            $cadena .= '</table>';
            break;
        }        
        
        
       
        //echo ($cadena);
        $pdf->writeHTML($cadena, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('reporte_transferencia.pdf', 'I');
    }    
    

}

?>