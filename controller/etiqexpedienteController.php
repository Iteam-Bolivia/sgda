<?php

/**
 * etiqexpedienteController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */

class etiqexpedienteController extends baseController {

    function index() {
        //$item = VAR1;
        $series = new series();
        $menuS = $series->loadMenu(false, "test");
        $menuS2 = $series->loadMenu(false, "test2");

        $menu = new menu ();
        $liMenu = $menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->tituloA = "Expedientes";
        $this->registry->template->tituloB = "Expedientes a Etiquetar";
        $this->registry->template->PATH_A = $menuS;
        $this->registry->template->PATH_B = $menuS2;
        $this->registry->template->exp_id = "";
        $this->registry->template->ete_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "view";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_etiqexpedienteg.tpl');
        $this->registry->template->show('footer');
    }

    function loadExp() {
        $expediente = new tab_expediente ();
        $expediente->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'exp_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY tab_expediente.$sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where = " and tab_expediente.exp_id = '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query == "TODOS") {
                    $where = "";
                } else {
                    $where = " and tab_series.ser_categoria LIKE '%$query%' ";
                } else {
                if ($query == "TODOS") {
                    $where = "";
                } else {
                    $where = " and $qtype LIKE '%$query%' ";
                }
            }
        }


        $select = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,                
                tab_expediente.exp_codigo,                
                tab_series.ser_categoria,
                tab_expediente.exp_id,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                FROM tab_retensiondoc 
                WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf ";
        $from = "FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_expisadg.exp_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND 
                tab_expusuario.usu_id = " . $_SESSION ['USU_ID'];

        $sql = "$select $from $where $sort $limit ";
        $sql_c = "select COUNT(DISTINCT tab_expediente.exp_id) as num $from $where";
        //print $sql;die;
        $total = $expediente->countBySQL($sql_c);
        $result = $expediente->dbselectBySQL($sql);
        $exp = new expediente ();

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
            $json .= "id:'" . $un->exp_id . "',";
            $json .= "cell:['" . $un->exp_id . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo . DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($exp->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function load() {
        $expediente = new tab_expediente ();
        $expediente->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'exp_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";

        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where = " and tab_expediente.exp_id = '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query == "TODOS") {
                    $where = "";
                } else {
                    $where = " and tab_series.ser_categoria LIKE '%$query%' ";
                } else {
                if ($query == "TODOS") {
                    $where = "";
                } else {
                    $where = " and $qtype LIKE '%$query%' ";
                }
            }
        }




        $select = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,                
                tab_expediente.exp_codigo,                
                tab_series.ser_categoria,
                tab_expediente.exp_id,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                FROM tab_retensiondoc 
                WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf ";
        $from = "FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_etiquetas ON tab_expediente.exp_id = tab_etiquetas.exp_id
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_expisadg.exp_estado = 1 AND
                tab_expusuario.eus_estado = 1 AND 
                tab_etiquetas.ete_estado = '1' AND
                tab_expusuario.usu_id = " . $_SESSION ['USU_ID'];

        $sql = "$select $from $where $sort $limit ";
        $sql_c = "SELECT COUNT(tab_expediente.exp_id) as num $from $where";
        //print $sql;die;
        $result = $expediente->dbselectBySQL($sql);
        $total = $expediente->countBySQL($sql_c);
        $exp = new expediente ();

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
            $json .= "id:'" . $un->exp_id . "',";
            $json .= "cell:['" . $un->exp_id . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo . DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($exp->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->registry->template->ete_id = "";
        $this->registry->template->ete_procedencia = "";
        $this->registry->template->ete_direccion = "";
        $this->registry->template->ete_unidad = "";
        $this->registry->template->ete_serie = "";
        $this->registry->template->ete_titulo = "";
        $this->registry->template->ete_fecha_exi = "";
        $this->registry->template->ete_fecha_exf = "";
        $this->registry->template->ete_cod_ref = "";
        $this->registry->template->ete_nro = "";
        $this->registry->template->ete_contenedor = "";
        $this->registry->template->ete_fecha_reg = "";
        $this->registry->template->ete_usu_reg = "";
        $this->registry->template->ete_estado = "";


        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_etiqexpediente.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $tab_expediente = new tab_expediente ();
        $tab_expediente->setRequest2Object($_REQUEST);
        $exp_id = $_REQUEST['exp_id'];

        // obtener sub contenedor
        $expediente = new expediente();

        $tetiq = new tab_etiquetas();
        $tetiq->exp_id = $exp_id;
        $tetiq->usu_id = $_SESSION['USU_ID'];
        $tetiq->suc_id = $expediente->obtenerSucId($exp_id);
        $tetiq->ete_fecha_crea = date("Y-m-d");
        $tetiq->ete_usu_crea = $_SESSION['USU_ID'];
        $tetiq->ete_estado = 1;
        $tetiq->insert();
        echo "OK";
    }

    function update() {
        $this->etiqexpediente = new tab_etiqexpediente ();
        $this->etiqexpediente->setRequest2Object($_REQUEST);

        $this->etiqexpediente->setEte_id = $_REQUEST['ete_id'];
        $this->etiqexpediente->setEte_procedencia = $_REQUEST['ete_procedencia'];
        $this->etiqexpediente->setEte_direccion = $_REQUEST['ete_direccion'];
        $this->etiqexpediente->setEte_unidad = $_REQUEST['ete_unidad'];
        $this->etiqexpediente->setEte_serie = $_REQUEST['ete_serie'];
        $this->etiqexpediente->setEte_titulo = $_REQUEST['ete_titulo'];
        $this->etiqexpediente->setEte_fecha_exi = $_REQUEST['ete_fecha_exi'];
        $this->etiqexpediente->setEte_fecha_exf = $_REQUEST['ete_fecha_exf'];
        $this->etiqexpediente->setEte_cod_ref = $_REQUEST['ete_cod_ref'];
        $this->etiqexpediente->setEte_nro = $_REQUEST['ete_nro'];
        $this->etiqexpediente->setEte_contenedor = $_REQUEST['ete_contenedor'];
        $this->etiqexpediente->setEte_fecha_reg = $_REQUEST['ete_fecha_reg'];
        $this->etiqexpediente->setEte_usu_reg = $_REQUEST['ete_usu_reg'];
        $this->etiqexpediente->setEte_estado = $_REQUEST['ete_estado'];

        $this->etiqexpediente->update();
        Header("Location: " . PATH_DOMAIN . "/etiqexpediente/");
    }

    function delete() {
        $texp = new Tab_etiquetas();
        $sql = "SELECT * FROM
        tab_etiquetas ete
        WHERE
        ete.usu_id =  '" . $_SESSION['USU_ID'] . "' AND
        ete.ete_estado =  '1' AND
        ete.exp_id =  '" . $_REQUEST['exp_id'] . "' ";
        $rows = $texp->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            foreach ($rows as $ete) {
                $ete->delete();
            }
        }
        echo 'OK';
    }

    function deleteAll() {
        $texp = new Tab_etiquetas();
        $sql = "SELECT * FROM
        tab_etiquetas ete
        WHERE
        ete.usu_id =  '" . $_SESSION['USU_ID'] . "' AND
        ete.ete_estado =  '1' ";
        $rows = $texp->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            foreach ($rows as $ete) {
                $ete->delete();
            }
        }
        echo 'OK';
    }

    function view() {
        $tipo = $_REQUEST['tipo'];
        //$nro_ini = $_REQUEST['nro_ini'];
        if ($tipo == 'cajas') {
            $this->viewCajas2();
        } elseif ($tipo == 'folders') {
            $this->viewFolders2();
        } elseif ($tipo == 'caratulas') {
            $this->viewCaratulas2();
        } elseif ($tipo == 'revisteros') {
            $this->viewRevisteros();
        } elseif ($tipo == 'carpetas') {
            $this->viewCaratulas();
        }
    }

    function getNroInicial() {
        $exp_id = $_REQUEST['Exp_id'];
        $usu_id = $_SESSION['USU_ID'];
        $res = array();
        // Minimo
        $sql = "SELECT min(tab_archivo.fil_nrocaj) as minimo
                FROM
                tab_expediente
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
		WHERE 
                tab_expediente.exp_estado = '1' AND
                tab_expediente.exp_id =  '$exp_id' ";
        $etiquetas = new tab_etiquetas();
        $result = $etiquetas->dbSelectBySQL($sql);

        foreach ($result as $row) {
            if (strlen($row->minimo) > 0)
                $res['nro_inicial'] = $row->minimo;
            else
                $res['nro_inicial'] = 0;
        }
        // Maximo
        $sql = "SELECT min(tab_archivo.fil_nrocaj) as maximo
                FROM
                tab_expediente
                INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id
                INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
		WHERE 
                tab_expediente.exp_estado = '1' AND
                tab_expediente.exp_id =  '$exp_id' ";
        //$etiquetas = new etiquetas();
        $result = $etiquetas->dbSelectBySQL($sql);
        foreach ($result as $row) {
            if (strlen($row->maximo) > 0)
                $res['nro_maximo'] = $row->maximo;
            else
                $res['nro_final'] = 0;
        }
        echo json_encode($res);
    }

    function viewFolders2() {
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Etiquetado de Expedientes');
        $pdf->SetSubject('Etiquetado de Expedientes');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetKeywords('Iteam, IT, Iteam SRL');
        $pdf->SetHeaderData('logo_abc.png', 25, 'ADMINISTRADORA BOLIVIANA DE CARRETERA', 'UNIDAD DE TECNOLOGIA, INFORMACION Y COMUNICACION');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(15, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 3);
        $pdf->SetFont('helvetica', '', 18);

        $st = '';

        $pdf->AddPage();
        //$pdf->AddPage('P', 'LETTER');

        $texp = new Tab_etiquetas();

        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_fondo.fon_descripcion,
                (SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_unidad.uni_par) AS uni_par_cod,
                tab_unidad.uni_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                        (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                        FROM tab_retensiondoc 
                        WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                tab_expediente.exp_nroejem,
                tab_expediente.exp_tomovol,
                tab_expediente.exp_nrocaj,
                (SELECT sof_nombre FROM tab_sopfisico WHERE sof_id=tab_expediente.sof_id AND tab_sopfisico.sof_estado = '1' ) AS sof_nombre,
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
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_expisadg.exp_estado = 1 AND
                tab_expediente.exp_id = '" . $_REQUEST['exp_id'] . "' ";


        $rows = $texp->dbSelectBySQL($sql);
        foreach ($rows as $value) {
            $st.='<table border = "1" style="width: 40%">';
            $st.='<tr>';
            $st.='<td>';
            $st.='<img src="' . PATH_ROOT . '/web/img/escudo.png" width="60" height="60" border="0" />';
            //$st.='<img src="' . PATH_ROOT . '/web/img/iso.png" width="50" height="50" border="0" align="right" />';
            $st.='</td>';
            $st.='</tr>';


            $st.='<tr>';
            $st.='<td>';
            $st.='<table border = "1" style="width: 100%; text-align: center">';
            $st.='<tr>';
            $st.='<td height="40"><b>CÓDIGO DE PROCEDENCIA ADMINISTRATIVA</b></td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td>' . $value->fon_cod . DELIMITER . $value->uni_cod . DELIMITER . $value->tco_codigo . DELIMITER . $value->ser_codigo . DELIMITER . $value->exp_codigo . '</td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td><b>GERENCIA / UNIDAD</b></td>';
            $st.='</tr>';

            if ($value->uni_par_cod) {
                $st.='<tr>';
                $st.='<td>' . $value->uni_par_cod . '</td>';
                $st.='</tr>';
            } else {
                $st.='<tr>';
                $st.='<td>' . $value->uni_descripcion . '</td>';
                $st.='</tr>';
            }

            $st.='<tr>';
            $st.='<td><b>SECCIÓN</b></td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td>' . $value->uni_descripcion . '</td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td><b>TÍTULO DEL DOCUMENTO</b></td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td>' . $value->exp_titulo . '</td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td><b>NRO. VOLUMEN</b></td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td>' . $value->exp_tomovol . '</td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td><b>FECHAS EXTREMAS</b></td>';
            $st.='</tr>';
            $st.='<tr>';
            $st.='<td>' . $value->exp_fecha_exf . '</td>';
            $st.='</tr>';
            $st.='</table>';

            $st.='</td>';
            $st.='</tr>';
            $st.='</table>';
        }


        $pdf->writeHTML($st, false, false, false, false, '');
        $pdf->Output('etiquetasFolders.pdf', 'I');
    }

    function viewCajas2() {

        $ini = $_REQUEST['nro_inicial'];
        $fin = $_REQUEST['nro_final'];
        if ($fin == NULL) {
            $fin = $ini;
        }

        $texp = new Tab_etiquetas();
        $usuario = new usuario();
        
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_fondo.fon_descripcion,
                (SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_unidad.uni_par) AS uni_par_cod,
                tab_unidad.uni_codigo,
                tab_unidad.uni_descripcion,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                        (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                        FROM tab_retensiondoc 
                        WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                tab_expediente.exp_nroejem,
                tab_expediente.exp_tomovol,
                tab_expediente.exp_nrocaj,
                (SELECT sof_nombre FROM tab_sopfisico WHERE sof_id=tab_expediente.sof_id AND tab_sopfisico.sof_estado = '1' ) AS sof_nombre,
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
                WHERE
                tab_fondo.fon_estado = 1 AND
                tab_unidad.uni_estado = 1 AND
                tab_tipocorr.tco_estado = 1 AND
                tab_series.ser_estado = 1 AND
                tab_expediente.exp_estado = 1 AND
                tab_expisadg.exp_estado = 1 AND
                tab_expediente.exp_id = '" . $_REQUEST['exp_id'] . "' ";


        $rows = $texp->dbSelectBySQL($sql);
        
        
        
        

        // Include the main TCPDF library (search for installation path).
        //require_once('tcpdf/tcpdf_include.php');
        require_once('tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Iteam S.R.L.');
        $pdf->SetTitle('Etiquetado de Cajas');
        $pdf->SetSubject('Etiquetado de Cajas');
        $pdf->SetKeywords('Etiquetado, Cajas, cajas, caratulas, folders');

        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 25, 'ADMINISTRADORA BOLIVIANA DE CARRETERA', 'IMPRESIÓN DE CAJAS');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', 'B', 8);

        // add a page
        $pdf->AddPage();

        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 8);
$st="";
        // -----------------------------------------------------------------------------

        for ($i = $ini; $i <= $fin; $i++) {


                foreach ($rows as $value) {
                    $expediente=new expediente();
                    $obteneCaja=$expediente->obtenerCaja($i,$_REQUEST['exp_id']); 
                    $cantMin=strlen($obteneCaja->minimo); 
                    $cantMax=strlen($obteneCaja->maximo);
                  
                    switch ($cantMin){
                        case 1:$cero="0000";break;
                        case 2:$cero="000";break;
                        case 3:$cero="00";break;
                        case 4:$cero="0";break;
                        case 5:$cero="";break;
                    }
                     switch ($cantMax){
                        case 1:$cero2="0000";break;
                        case 2:$cero2="000";break;
                        case 3:$cero2="00";break;
                        case 4:$cero2="0";break;
                        case 5:$cero2="";break;
                    }
                    $st.='<table border="1" style="width: 100%">';
                    
                    $st.='<tr>';
                    $st.='<td>';
                    $st.='<img src="' . PATH_ROOT . '/web/img/escudo.png" width="50" height="50" border="0" />';
                    //$st.='<img src="' . PATH_ROOT . '/web/img/iso.png" width="50" height="50" border="0" align="right" />';
                    $st.='</td>';
                    $st.='</tr>';

                    $st.='<tr>';
                    $st.='<td>';

                    $st.='<table border="1" style="width: 100%; text-align: center">';
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20"  bgcolor="#CCCCCC"><b>CÓDIGO DE PROCEDENCIA ADMINISTRATIVA</b></td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    //$st.='<td colspan="11">'.$value->fon_cod . "-" . $value->uni_cod. '</td>';
                    $st.='<td colspan="11" height="20">' . $value->fon_cod . DELIMITER . $value->uni_cod . DELIMITER . $value->tco_codigo . DELIMITER . $value->ser_codigo . DELIMITER . $value->exp_codigo . '</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20" bgcolor="#CCCCCC"><b>GERENCIA / UNIDAD</b></td>';
                    $st.='</tr>';
                    if ($value->uni_par_cod) {
                        $st.='<tr>';
                        $st.='<td colspan="11" height="20">' . $value->uni_par_cod . '</td>';
                        $st.='</tr>';
                    } else {
                        $st.='<tr>';
                        $st.='<td colspan="11" height="20">' . $value->uni_descripcion . '</td>';
                        $st.='</tr>';
                    }
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20" bgcolor="#CCCCCC"><b>SECCIÓN</b></td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20">' . $value->uni_descripcion . '</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20" bgcolor="#CCCCCC"><b>DESCRIPCIÓN DEL CONTENIDO</b></td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="11" height="20" style="font-size:50px">' . $value->exp_titulo . '</td>';
                    $st.='</tr>';
                    
                    $fechaextrema=explode("-",$value->exp_fecha_exf);
                    $fechE=$fechaextrema[2]."-".$fechaextrema[1]."-".$fechaextrema[0];
                    $pdf->SetFont('helvetica', '', 8);
                    $st.='<tr>';
                    $st.='<td colspan="2" height="20" bgcolor="#CCCCCC">FECHAS EXTREMAS</td>';
                    $st.='<td colspan="9" bgcolor="#CCCCCC" >NRO. DE ORDEN</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="2" height="20">' . $fechE . '</td>';
                    $st.='<td colspan="4" bgcolor="#CCCCCC">DEL</td>';
                    $st.='<td>'.$cero.$obteneCaja->minimo.'</td>';
                    $st.='<td colspan="3" bgcolor="#CCCCCC">AL&nbsp;</td>';
                    $st.='<td>'.$cero2.$obteneCaja->maximo.'</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td colspan="4" height="20" bgcolor="#CCCCCC">UBICACIÓN TOPOGRÁFICA</td>';
                    $st.='<td colspan="5"></td>';
                    $st.='<td colspan="2"></td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td height="20" bgcolor="#CCCCCC">SALA:</td>';
                    $st.='<td bgcolor="#CCCCCC">ESTANTE:</td>';
                    $st.='<td bgcolor="#CCCCCC">CUERPO:</td>';
                    $st.='<td bgcolor="#CCCCCC">BALDA:</td>';
                    $st.='<td colspan="5" bgcolor="#CCCCCC">FECHA DE TRANSFERENCIA</td>';
                    $st.='<td colspan="2" bgcolor="#CCCCCC">NRO. DE TRANSFERENCIA</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    $st.='<td height="20">' . $value->exp_sala . '</td>';
                    $st.='<td>' . $value->exp_estante . '</td>';
                    $st.='<td>' . $value->exp_cuerpo . '</td>';
                    $st.='<td>' . $value->exp_balda . '</td>';
                    $st.='<td colspan="5"></td>';
                    $st.='<td colspan="2"></td>';
                    $st.='</tr>';
                    $st.='</table>';

                    $st.='<table border="1" style="width: 100%; text-align: center;">';
                    $st.='<tr>';
                    $st.='<td height="20" bgcolor="#CCCCCC">NRO. DE CAJA:</td>';
                    $st.='<td bgcolor="#CCCCCC">ML:</td>';
                    $st.='<td bgcolor="#CCCCCC">NRO. DE PIEZAS</td>';
                    $st.='<td bgcolor="#CCCCCC">ELABORADO POR:</td>';
                    $st.='</tr>';
                    $st.='<tr>';
                    //$st.='<td>' . $value->exp_nrocaj . '</td>';
                    $st.='<td height="20">' . $i . '</td>';
                    $st.='<td>' . $value->exp_nroejem . '</td>';
                    $st.='<td>' . $value->exp_tomovol . '</td>';
                    $st.='<td>' . $usuario->obtenerNombre($_SESSION['USU_ID']) . '</td>';
                    $st.='</tr>';
                    $st.='</table>';

                    $st.='</td>';
                    $st.='</tr>';
                    $st.='</table>';
                }    

            //EOD;


        $pdf->writeHTML($st, true, false, false, false, '');
        $st = "";
        }

        // -----------------------------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('example_048.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+        
        
        
    }

    
    

    function viewCaratulas2() {

        $texp = new Tab_etiquetas();
        $usuario = new usuario ();
        
        $sql = "SELECT
tab_fondo.fon_cod,
tab_unidad.uni_cod,
tab_tipocorr.tco_codigo,
tab_series.ser_codigo,
tab_expediente.exp_codigo,
tab_fondo.fon_descripcion,
(SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_unidad.uni_par) AS uni_par_cod,
tab_unidad.uni_codigo,
tab_unidad.uni_descripcion,
tab_series.ser_categoria,
tab_expisadg.exp_titulo,
tab_expisadg.exp_fecha_exi,
(tab_expisadg.exp_fecha_exi + 
                        (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                        FROM tab_retensiondoc 
                        WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
tab_expediente.exp_nroejem,
tab_expediente.exp_tomovol,
tab_expediente.exp_nrocaj,
(SELECT sof_nombre FROM tab_sopfisico WHERE sof_id=tab_expediente.sof_id AND tab_sopfisico.sof_estado = '1' ) AS sof_nombre,
tab_expediente.exp_sala,
tab_expediente.exp_estante,
tab_expediente.exp_cuerpo,
tab_expediente.exp_balda,
tab_expediente.exp_obs,
tab_sopfisico.sof_codigo
FROM
tab_fondo
INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
INNER JOIN tab_exparchivo ON tab_exparchivo.exp_id = tab_expediente.exp_id
INNER JOIN tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
INNER JOIN tab_sopfisico ON tab_sopfisico.sof_id = tab_archivo.sof_id
WHERE
tab_fondo.fon_estado = 1 AND
tab_unidad.uni_estado = 1 AND
tab_tipocorr.tco_estado = 1 AND
tab_series.ser_estado = 1 AND
tab_expediente.exp_estado = 1 AND
tab_expisadg.exp_estado = 1 AND
tab_expediente.exp_id = '" . VAR3 . "' ";


        $rows = $texp->dbSelectBySQL($sql);
        
        $rows=$rows[0];
        
        

        // Include the main TCPDF library (search for installation path).
        //require_once('tcpdf/tcpdf_include.php');
        require_once('tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Iteam S.R.L.');
        $pdf->SetTitle('UNIDAD DE TECNOLOGÍA, INFORMACION Y COMUNICACION');
        $pdf->SetSubject('Etiquetado de Caratulas');
        $pdf->SetKeywords('Etiquetado, Caratulas, cajas, caratulas, folders');

        // set default header data
        $pdf->SetHeaderData('logo_abc.png', 25, 'ADMINISTRADORA BOLIVIANA DE CARRETERA', 'UNIDAD DE TECNOLOGÍA, INFORMACION Y COMUNICACION');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', 'B', 8);
        // add a page
$td="";$td.="<br>";$td.="<br>";$td.="<br>";
        $td.='<table border="0"><tr><td align="center" style="font-size:65px"><b>ARCHIVO CENTRAL</b></td></tr></table>';
$td.="<br>";
        $st="";
        // -----------------------------------------------------------------------------

  

       $st.='<table width="660" border="1" style="font-family:Tahoma, Geneva, sans-serif;font-size:50px">';
  $st.='<tr>';
    $st.='<td colspan="4" bgcolor="#CCCCCC" height="35" ><b>CODIGO DE PRECEDENCIA:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" height="40" align="center" style="font-size:50px">'.$rows->fon_cod.DELIMITER.$rows->uni_cod.DELIMITER.$rows->tco_codigo.DELIMITER.$rows->ser_codigo.DELIMITER.$rows->exp_codigo.'</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" bgcolor="#CCCCCC" height="35"><b>GERENCIA/UNIDAD:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" height="40" align="center" style="font-size:50px">';
   
    if($rows->uni_par_cod==""){
       $st.=$rows->uni_descripcion;
    }else{
        $st.=$rows->uni_par_cod;
    }
    
    $fecha1=explode("-",$rows->exp_fecha_exi);
    $fecha2=explode("-",$rows->exp_fecha_exf);
    $fechaInicial=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0];
    $fechaFinal=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];
  
    $st.='</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" bgcolor="#CCCCCC" height="35"><b>SECCION:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" height="40" align="center" style="font-size:50px">'.$rows->ser_categoria.'</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" bgcolor="#CCCCCC" height="35" ><b>TITULO DEL DOCUMENTO:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" height="45" align="center" style="font-size:70px">'.$rows->exp_titulo.'</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td width="220" bgcolor="#CCCCCC" height="35" align="center"><b>Nº DE VOLUMEN:</b></td>';
    $st.='<td width="220" colspan="2" bgcolor="#CCCCCC" align="center"><b>SOPORTE FISICO:</b></td>';
    $st.='<td width="220" bgcolor="#CCCCCC" align="center"><b>CONSERVACION DOCUMENTAL:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td height="40" align="center" style="font-size:50px">'.$rows->exp_tomovol.'</td>';
    $st.='<td colspan="2" align="center" style="font-size:50px">'.$rows->sof_codigo.'</td>';
    $st.='<td align="center" style="font-size:45px">&nbsp;</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" bgcolor="#CCCCCC" height="35"><b>FECHAS EXTREMAS:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="4" height="40" align="center" style="font-size:50px">'.$fechaInicial.'   -   '.$fechaFinal.'</td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="2" bgcolor="#CCCCCC" height="35"><b>OBSERVACIONES:</b></td>';
    $st.='<td colspan="2" bgcolor="#CCCCCC"><b>Nº DE ORDEN/INVENTARIO:</b></td>';
  $st.='</tr>';
  $st.='<tr>';
    $st.='<td colspan="2" height="50"  >'.$rows->exp_obs.'</td>';
    $st.='<td colspan="2">&nbsp;</td>';
  $st.='</tr>';
$st.='</table><br>';
$st.='<strong>*SOPORTE FISICO:</strong> Anillado <strong>AN</strong>,  Archivador de Palanca <strong>AP</strong>,Empastado <strong>EM</strong>, Folder <strong>FL</strong>, Legajo <strong>LG</strong>, Mapas <strong>MA</strong>, Planos <strong>PL</strong><br />';
$st.='<strong>*CONSERVACION DOCUMENTAL</strong>: Bueno<strong>( B )</strong> Regular<strong>( R )</strong> Malo<strong>( M )</strong>';

        $pdf->AddPage();

        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 8);
        $pst=$td.$st;
        // -----------------------------------------------------------------------------
$pdf->writeHTML($pst, true, false, false, false, '');
        //Close and output PDF document
        $pdf->Output('example_048.pdf', 'D');

        //============================================================+
        // END OF FILE
        //============================================================+        
        
        
        
    }
    
    
    
    

    function viewCarpetas() {
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Etiquetado de Expedientes');
        $pdf->SetSubject('Etiquetado de Expedientes');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(11, 12, 9);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 2);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 8);
        $tipo = $_REQUEST['tipo'];
        $nro_exps_max = 20;
        $nro_exps = $_REQUEST['nro_exps'];
        if ($nro_exps > $nro_exps_max || $nro_exps == '') {
            $nro_exps = $nro_exps_max;
        }
        $res = $this->obtenerContenidoXFilas('ARCHIVADOR', $nro_exps, 35);
        $st = '';
        $i = 0;
        foreach ($res as $i => $etiq) {
            if ($i % 4 == 0) {
                $pdf->AddPage('L', 'LETTER');
                $st = '';
                $st.='<table width="18cm" border="0" style="width: 18cm;height:18.5cm;" cellspacing="5" ><tr>';
            }
            $st.='<td width="6.5cm" height="18.5cm">';
            $st.='<table width="5.5cm" border="1" style="width: 5.5cm;height:18.5cm;" cellspadding="2" >';
            $st.='<tr><td width="5.5cm" height="17.5cm" align="center">';

            $st.='<img src="' . PATH_ROOT . '/web/img/escudo.png" width="60" height="60" border="0" />';

            $st.='<span style="font-size: 30px;font-weight: bold;width:80%">';
//            if ($etiq['ins_id'] != 1) {
//                //obtenemos la descripcion de la institucion 1
//                $inst = new tab_unidad();
//                $sql = "SELECT
//                    tun.uni_codigo,
//                    tun.uni_descripcion as inst_origen,
//                    tun.uni_id
//                    FROM
//                    tab_institucion AS tin
//                    Inner Join tab_unidad AS tun ON tun.uni_id = tin.uni_id
//                    WHERE
//                    tin.ins_id =  '1' ";
//                $r_inst = $inst->dbselectBySQL($sql);
//                $inst_origen = '';
//                if (count($r_inst) > 0) {
//                    $inst_origen = $r_inst[0]->inst_origen;
//                }
//                $st.='<br />' . $inst_origen;
//            } else {
//                $st.='<br />' . $etiq['institucion'];
//            }
            $st.='</span>';
            $st.='<span style="font-size: 30px;font-weight: bold;">';
//            if ($etiq['ins_id'] != 1) {
//                $st.='<br />' . $etiq['ins_nombre'];
//            }
            if ($etiq['direccion'] != '') {
                $st.='<br />' . $etiq['direccion'];
            }
            if ($etiq['unidad'] != $etiq['direccion']) {
                $st.='<br />' . $etiq['unidad'];
            }
            $st.='</span>';
            $st.='<br />SERIE: ' . strtoupper($etiq['serie']) . '<br />';
            $st.='<font size="6">';
            $st.='<table width="5.45cm" border="1" cellspadding="2" >';
            $st.='<tr><td width="15%">Nº</td><td width="85%">Tituto</td></tr>';
            foreach ($etiq['rows'] as $ei => $exp) {
                $st.='<tr><td width="15%">' . ($ei + 1) . '</td><td width="85%" align="left">' . substr($exp['exp_nombre'], 0, 100) . '</td></tr>';
            }

            $st.='</table>';

            $st.='</font></td></tr>';
            $st.='<tr><td width="5.5cm" align="center">FECHAS EXTREMAS: ' . strtoupper($etiq['fextremas']) . '</td></tr>';
            $st.='<tr><td width="5.5cm" align="center">CARPETA NRO.: ' . strtoupper($etiq['nro']) . '<br />';
            $st.='GESTION: ' . strtoupper($etiq['gestion']) . '</td></tr>';
            $st.='<tr><td width="5.5cm" align="center">&nbsp;';
            if ($etiq['contenedor'] != '') {
                $st.=strtoupper($etiq['contenedor']);
            }
            $st.='</td></tr>';
            $st.='</table>';

            $st.='</td>';
            if ($i % 4 == 3) {
                $st.='</tr></table>';
                $pdf->writeHTML($st, false, false, false, false, '');
                $pdf->lastPage();
            }
        }
        if ($i % 4 != 3) {
            $st.='</tr></table>';
            $pdf->writeHTML($st, false, false, false, false, '');
            $pdf->lastPage();
        }
        $pdf->Output('etiquetasCarpetas.pdf', 'I');
    }



    function obtenerContenido($tipo) {
        $usu_id = $_SESSION['USU_ID'];
        $anio = date("Y");
        $rol = $_SESSION['ROL_COD'];
        $etiquetas = new etiquetas();
        $result = $etiquetas->loadEtiquetas($usu_id, $rol);
        $total = count($result);
        $i = 0;
        $json_array = array();

        $nro_ini = $_REQUEST['nro_ini'];
        if ($nro_ini == '') {
            $num_ant = $etiquetas->getNroMax($tipo, $usu_id, $anio);
            $num = $num_ant + 1;
        } else {
            $num_ant = $nro_ini - 1;
            $num = $nro_ini;
        }
        $json_array = array('total' => $total, 'num' => $num_ant, 'anio:' => $anio);
        $rows = array();
        if ($total > 0) {
            foreach ($result as $un) {
                $exi = substr($un->exf_min, 0, 4);
                $exf = substr($un->exf_max, 0, 4);
                if ($exi == $exf)
                    $fextremas = $exi;
                else
                    $fextremas = $exi . " - " . $exf;
                //Recogemos cada etiqueta en un array cada etiqueta
                $sub_rows = array(
                    'unidad' => $un->uni_codigo,
                    'direccion' => $un->direccion,
                    'uni_par' => $un->uni_par,
                    'serie' => $un->ser_categoria,
                    'fextremas' => $fextremas,
                    'contenedor' => $un->contenedor,
                    'nro' => $num,
                    'gestion' => $anio,
                    'ins_id' => $un->ins_id,
                    'ins_nombre' => $un->ins_nombre,
                    'institucion' => $un->institucion);
                $j = 0;
                //leemos los expedientes
                $r_exps = $etiquetas->loadExpedientes($usu_id, $rol, $un->uni_id, $un->ser_id);
                //for($t=1;$t<30;$t++){
                foreach ($r_exps as $exp) {
                    $sub_exps = array(
                        'ete_id' => $exp->ete_id,
                        'exp_codigo' => $exp->exp_codigo,
                        'exp_nombre' => $exp->exp_nombre, //.' uuuuuuuuuuuuu uuuuuuiiiiiiiiiiiiiii fooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo',
                        'exf_fecha_exi' => $exp->exf_fecha_exi,
                        'exf_fecha_exf' => $exp->exf_fecha_exf);
                    $sub_rows['rows'][$j] = $sub_exps;
                    $j++;
                    $suc = new subcontenedor();
                    $ctp_id = $suc->getCtp_id($tipo);
                    //1) verificamos que no se haya registrado en el subcontenedor
                    if ($exp->suc_id == 0 || $exp->suc_id == '') {
                        //obtenemos id del tipo
                        $tsuc = new tab_subcontenedor();
                        $tsuc->suc_nro = $num;
                        $tsuc->ctp_id = $ctp_id;
                        $tsuc->usu_id = $_SESSION['USU_ID'];
                        $tsuc->uni_id = $un->uni_codigo;
                        $tsuc->ser_id = $un->ser_id;
                        $tsuc->con_id = $un->con_id;
                        $tsuc->suc_gestion = $anio;
                        $tsuc->suc_fecha_exi_min = $un->exf_min;
                        $tsuc->suc_fecha_exf_max = $un->exf_max;
                        $tsuc->suc_usu_reg = $_SESSION['USU_ID'];
                        $tsuc->suc_fecha_reg = date("Y-m-d");
                        $tsuc->suc_estado = 1;
                        $suc_id = $tsuc->insert();
                    } else {
                        //update
                        $suc_id = $exp->suc_id;
                        $tsuc = new tab_subcontenedor();
                        $tsuc->suc_id = $suc_id;
                        $tsuc->suc_nro = $num;
                        $tsuc->ctp_id = $ctp_id;
                        $tsuc->usu_id = $_SESSION['USU_ID'];
                        $tsuc->uni_id = $un->uni_codigo;
                        $tsuc->ser_id = $un->ser_id;
                        $tsuc->con_id = $un->con_id;
                        $tsuc->suc_gestion = $anio;
                        $tsuc->suc_fecha_exi_min = $un->exf_min;
                        $tsuc->suc_fecha_exf_max = $un->exf_min;
                        $tsuc->suc_usu_reg = $_SESSION['USU_ID'];
                        $tsuc->suc_fecha_reg = date("Y-m-d");
                        $tsuc->suc_estado = 1;
                        $tsuc->update();
                    }
                    //update suc_id en exparchivos
                    $sql = "UPDATE tab_exparchivos SET suc_id = '$suc_id' WHERE exp_id = '$exp->exp_id' AND exa_estado =  '1'";
                    $suc->dbBySQL($sql);
                    //update en etiquetas
                    $sql = "UPDATE tab_etiquetas SET suc_id = '$suc_id' WHERE ete_id = '$exp->ete_id' AND ete_estado =  '1'";
                    $suc->dbBySQL($sql);
                }
                //}
                $rows[$i] = $sub_rows;
                $i++;
                $num++;
            }
        }
        $json_array['rows'] = $rows; //print_r($rows);die(" ");
        return $rows;
    }



}

?>
