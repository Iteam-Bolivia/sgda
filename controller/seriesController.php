<?php

/**
 * seriesController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class seriesController Extends baseController {

    function index() {

        $this->registry->template->ser_id = "";
        $this->registry->template->ser_categoria = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_seriesg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        //$series = new series();
        $this->series = new tab_series();
        $this->series->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'ser_id';
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
                
        if ($query) {
            if ($qtype == 'ser_id') {
                $where = " AND ts.ser_id = '$query' ";
            } elseif ($qtype == 'fon_descripcion') {
                $where = " AND tab_fondo.fon_id IN (SELECT fon_id from tab_fondo WHERE fon_descripcion like '%$query%') ";
            } elseif ($qtype == 'uni_descripcion') {
                $where = " AND tab_unidad.uni_id IN (SELECT uni_id from tab_unidad WHERE uni_descripcion like '%$query%') ";
            } elseif ($qtype == 'ser_par') {
                $where = " AND ts.ser_id IN (SELECT ser_id from tab_series WHERE ser_categoria like '%$query%') ";                                
            } elseif ($qtype == 'red_codigo') {
                $where = " AND tab_retensiondoc.red_id IN (SELECT red_id from tab_retensiondoc WHERE red_codigo like '%$query%') ";                
            } else {
                $where = " AND $qtype like '%$query%' ";
            }
        }        
        
        
        $select = "SELECT
                ts.ser_id,
                tab_fondo.fon_codigo,
                tab_fondo.fon_cod,
                tab_fondo.fon_descripcion,
                tab_unidad.uni_cod,
                tab_unidad.uni_descripcion,
                tab_tipocorr.tco_codigo,
                tab_tipocorr.tco_nombre, 
                ts.ser_par,
                ts.ser_codigo,
                ts.ser_categoria,
                (SELECT ser_categoria from tab_series WHERE ser_id=ts.ser_par) AS ser_parent,
                ts.ser_nivel,
                tab_retensiondoc.red_codigo,
                ts.ser_contador
                FROM
                tab_series AS ts
                INNER JOIN tab_retensiondoc ON tab_retensiondoc.red_id = ts.red_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = ts.tco_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = ts.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                WHERE ts.ser_estado =  1 ";
        $sql = "$select $where $sort $limit";
        $result = $this->series->dbselectBySQL($sql);
        $sql_c = "SELECT COUNT(ts.ser_id) 
                FROM
                tab_series AS ts
                INNER JOIN tab_retensiondoc ON tab_retensiondoc.red_id = ts.red_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = ts.tco_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = ts.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id          
                WHERE ts.ser_estado = 1 " .  $where;
        $total = $this->series->countBySQL($sql_c);
        /* header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
          header("Cache-Control: no-cache, must-revalidate" );
          header("Pragma: no-cache" ); */
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        
        
        $uni_descripciona = "";
        $uni_descripcionn = "";
        
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            
            
            // New
            $uni_descripcionn = $un->uni_descripcion;
            if ($uni_descripcionn != $uni_descripciona){
                
                // List Seccion
                $json .= "\n{";
                $json .= "id:'" . $un->ser_id . "',";
                $json .= "cell:['" . $un->ser_id . "'";

                if ($un->ser_codigo == '') {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod) . "'";
                } else {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod) . "'";
                }

                $json .= ",'" . addslashes("") . "'";                
                $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
                

                $json .= ",'" . addslashes("") . "'";
                $json .= ",'" . addslashes("") . "'";
                $json .= ",'" . addslashes("") . "'";
                $json .= ",'" . addslashes("") . "'";
                $json .= ",'" . addslashes("") . "'";
                $json .= "]}";
                
                // List Serie
                $rc = true;
                if ($rc)
                    $json .= ",";
                
                $json .= "\n{";
                $json .= "id:'" . $un->ser_id . "',";
                $json .= "cell:['" . $un->ser_id . "'";

                if ($un->ser_codigo == '') {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo) . "'";
                } else {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo) . "'";
                }

                $json .= ",'" . addslashes($un->tco_codigo) . "'";
                if ($un->ser_par == '-1') {
                    $json .= ",'" . addslashes(utf8_decode($un->ser_categoria)) . "'";
                } else {                    
                    $series = new series();
                    $spaces = $series->getSpaces($un->ser_nivel);                    
                    $json .= ",'" . addslashes($spaces . " " . utf8_decode($un->ser_categoria)) . "'";
                }            

                $json .= ",'" . addslashes(utf8_decode($un->ser_parent)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->fon_descripcion)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->red_codigo)) . "'";
                $json .= ",'" . addslashes($un->ser_contador) . "'";
                $json .= "]}";
                
            
            }else{
                
                $json .= "\n{";
                $json .= "id:'" . $un->ser_id . "',";
                $json .= "cell:['" . $un->ser_id . "'";

                if ($un->ser_codigo == '') {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo) . "'";
                } else {
                    $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo) . "'";
                }

                $json .= ",'" . addslashes($un->tco_codigo) . "'";
                if ($un->ser_par == '-1') {
                    $json .= ",'" . addslashes(utf8_decode($un->ser_categoria)) . "'";
                } else {
                    $series = new series();
                    $spaces = $series->getSpaces($un->ser_nivel);                    
                    $json .= ",'" . addslashes($spaces . " " . utf8_decode($un->ser_categoria)) . "'";
                }            

                $json .= ",'" . addslashes(utf8_decode($un->ser_parent)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->uni_descripcion)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->fon_descripcion)) . "'";
                $json .= ",'" . addslashes(utf8_decode($un->red_codigo)) . "'";
                $json .= ",'" . addslashes($un->ser_contador) . "'";
                $json .= "]}";
            }
            
            $uni_descripciona = $un->uni_descripcion;
            $rc = true;
            $i++;
        }
        
        
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();

        $departamento = new departamento();
        $this->registry->template->dep_id = $departamento->obtenerSelect();

        $unidad = new unidad();
        //$this->registry->template->uni_id = $unidad->obtenerSelect();
        $this->registry->template->uni_id = "";

        $serie = new series();
        $tipo_corr = new tipocorr();
        $retensiondoc = new retensiondoc();

        $fondo = new fondo();
        $this->registry->template->adm = $adm;
        $this->registry->template->delimiter = DELIMITER;

        $this->registry->template->ser_id = "";
        $this->registry->template->fon_id = $fondo->obtenerSelectFondos();
        //$this->registry->template->ser_par = $serie->obtenerSelectTodas(); 
        $this->registry->template->ser_par = "";
        $this->registry->template->ser_categoria = "";
        $this->registry->template->ser_tipo = "N";
        $this->registry->template->ser_codigop = ""; //$_SESSION['DEP_CODIGO'] . DELIMITER . $_SESSION['UNI_CODIGO'];
        $this->registry->template->ser_codigo = "";
        $this->registry->template->titulo = "Nueva ";

        $this->registry->template->tco_id = $tipo_corr->obtenerSelect();
        $this->registry->template->red_id = $retensiondoc->obtenerSelect();

        $this->registry->template->fon_cod = "";
        $this->registry->template->uni_cod = "";
        $this->registry->template->tco_codigo = "";

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";




        $tramiteSerie = new tab_tramite();
        $tramites = $tramiteSerie->dbSelectBySQL("SELECT * FROM tab_tramite
        WHERE tra_estado = '1' ORDER BY tra_descripcion ASC ");
        $tramiteTr = "";
        $i = 0;
        if (count($tramites)) {
            foreach ($tramites as $tramite) {
                $tramiteTr .= "<tr><td><input type='checkbox' class='' name='tramite[$i]' value='" . $tramite->tra_id . "' /></td><td>" . $tramite->tra_descripcion . "</td></tr>\n";
                $i++;
            }
        } else {
            $tramiteTr = "<tr><td colspan='2'>No existen tramites</td></tr>";
        }

        $this->registry->template->LISTA_TRAMITES = $tramiteTr;
        $this->registry->template->LISTA_TRAMITES_SELECT = "";



        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_series.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->series = new tab_series ();
        $tseries = new tab_series();
        $tseries->setRequest2Object($_REQUEST);

        $id_serie = 0;
        $tseries->setSer_id($_REQUEST['ser_id']);
        $tseries->setUni_id($_REQUEST['uni_id']);
        $tseries->setTco_id($_REQUEST['tco_id']);
        $tseries->setRed_id($_REQUEST['red_id']);

        if ($_REQUEST['ser_par']) {
            $codigo = $this->generaCodigo($_REQUEST['ser_par']);
            $ser_nivel = $this->generaNivel($codigo);

            $tseries->setSer_codigo($codigo);
            $tseries->setSer_nivel($ser_nivel);
            $tseries->setSer_par($_REQUEST['ser_par']);
            $tseries->setSer_contador('0');
            $tseries->setSer_categoria($_REQUEST['ser_categoria']);
            $tseries->setSer_estado(1);
            $id_serie = $tseries->insert2();

            // Actualizar Código Seccion
            $row2 = $this->series->dbselectByField("ser_id", $_REQUEST['ser_par']);
            $row2 = $row2[0];
            $this->series->setSer_id($row2->ser_id);

            $this->series->setUni_id($row2->uni_id);
            $this->series->setTco_id($row2->tco_id);
            $this->series->setRed_id($row2->red_id);
            $this->series->setSer_codigo($row2->ser_codigo);

            $this->series->setSer_par($row2->ser_par);
            $this->series->setSer_categoria($row2->ser_categoria);

            $ser_contador = $row2->ser_contador + 1;
            $this->series->setSer_contador($ser_contador);

            $this->series->setSer_estado(1);
            $this->series->update();
        } else {
            $codigo = $this->getCodigoPadre();
            if ($_REQUEST['ser_tipo'] == 'R') {
                $tseries->setSer_codigo('');
            } else {
                $tseries->setSer_codigo($codigo . DELIMITER . "0");
            }
            $ser_nivel = 0;
            $tseries->setSer_nivel($ser_nivel);
            $tseries->setSer_par(-1);
            $tseries->setSer_contador('0');
            $tseries->setSer_categoria($_REQUEST['ser_categoria']);
            $tseries->setSer_estado(1);
            $id_serie = $tseries->insert2();
        }


        // SERIE DEFAULT
        // Nuevo tramite
        $tramite = new tab_tramite ();
        $tramite->setRequest2Object($_REQUEST);
        $tramite->setTra_orden("1");
        $tramite->setTra_codigo("1");
        $tramite->setTra_descripcion("GRUPO DOCUMENTAL");
        $tramite->setTra_fecha_crea(date("Y-m-d"));
        $tramite->setTra_usuario_crea($_SESSION ['USU_ID']);
        $tramite->setTra_estado(1);
        $tra_id = $tramite->insert();
        //insert
        $seriet = new Tab_serietramite();
        $seriet->setSer_id($id_serie);
        $seriet->setTra_id($tra_id);
        $seriet->setSts_estado(1);
        $seriet->insert();


        // Nuevo cuerpo
        $tcuerpos = new tab_cuerpos ();
        $tcuerpos->setRequest2Object($_REQUEST);
        $tcuerpos->setCue_id("1");
        $tcuerpos->setCue_orden("1");
        $tcuerpos->setCue_codigo("1");
        $tcuerpos->setCue_descripcion("TIPO DOCUMENTAL");
        $tcuerpos->setCue_estado(1);
        $cue_id = $tcuerpos->insert();


        // Last code
        $tramitecc = new tab_tramitecuerpos();
        $tramitecc->setCue_id($cue_id);
        $tramitecc->setTra_id($tra_id);
        $tramitecc->setTrc_estado(1);
        $tramitecc->insert();





        Header("Location: " . PATH_DOMAIN . "/series/");
    }

    // Nueva generación de codigo 
    function getCodigoPadre() {
        $contador = "";
        $series = new tab_series();
        $sql = "SELECT count(ser_id) as contador
                FROM tab_series
                WHERE ser_par = -1
                ORDER BY 1 DESC ";
        $result = $series->dbSelectBySQL($sql);
        if ($result != null) {
            foreach ($result as $row) {
                $res = $row->contador;
            }
            $contador = $res + 1;
        }
        return $contador;
    }

    // Nueva generación de codigo 
    function generaCodigo($ser_par) {
        $new_cod = "";
        $series = new tab_series();
        $sql = "SELECT 
                ser_codigo, 
                ser_contador
                FROM tab_series 
                WHERE ser_id = $ser_par
                ORDER BY 1 DESC 
                LIMIT 1 OFFSET 0";
        $result = $series->dbSelectBySQL($sql);
        if ($result != null) {
            foreach ($result as $row) {
                if ($row->ser_codigo == '') {
                    $res = sprintf("%01d", $row->ser_contador + 1);
                } else {
                    $res = $row->ser_codigo . DELIMITER . sprintf("%01d", $row->ser_contador + 1);
                }
            }
            $new_cod = $res;
        } else {
            $new_cod = "1";
        }
        return $new_cod;
    }

    // Nivel
    function generaNivel($ser_codigo) {
        $count = 0;
        $nomArray = explode(DELIMITER, $ser_codigo);
        foreach ($nomArray as $nom) {
            $count++;
        }
        return $count;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/series/view/" . $_REQUEST["ser_id"] . "/");
    }

    function view() {
        if (!VAR3) {
            die("Error del sistema 404");
        }
        $codigo = "";
        $codigop = "";
        $serie = new series();
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();
        $this->series = new tab_series();
        $this->series->setRequest2Object($_REQUEST);
        $row = $this->series->dbselectByField("ser_id", VAR3);
        $row = $row[0];


        // Find state
        $departamento = new departamento();
        //$dep_id = $departamento->obtenerIdDeptoCodigoSerie($row->ser_codigo);
        $this->registry->template->dep_id = $departamento->obtenerSelect($row->dep_id); //$departamento->obtenerSelect($dep_id);
        // Find unity
        $unidad = new unidad();
        //$uni_id = $unidad->obtenerIdUnidadCodigoSerie($row->ser_codigo);
        $this->registry->template->uni_id = $unidad->listUnidad($row->uni_id); //$unidad->obtenerSelect($uni_id);
        $fondo = new fondo ();
        $this->registry->template->fon_id = $fondo->obtenerSelectFondosbySeccion($row->uni_id);
        $this->registry->template->adm = $adm;
        $this->registry->template->ser_id = $row->ser_id;
        $this->registry->template->ser_par = $serie->obtenerSelectTodas($row->ser_par);
        $this->registry->template->ser_categoria = utf8_encode($row->ser_categoria);
        $this->registry->template->ser_tipo = $row->ser_tipo;

        $this->registry->template->fon_cod = $fondo->getCod($row->uni_id);
        $this->registry->template->uni_cod = $unidad->getCodigo($row->uni_id);


        $tipo_corr = new tipocorr();
        $this->registry->template->tco_codigo = $tipo_corr->getCodigoById($row->tco_id);
        $retensiondoc = new retensiondoc();
        $this->registry->template->tco_id = $tipo_corr->obtenerSelect($row->tco_id);
        $this->registry->template->red_id = $retensiondoc->obtenerSelect($row->red_id);

        $this->registry->template->delimiter = DELIMITER;
        $this->registry->template->ser_codigo = $row->ser_codigo;

        $tramiteSerie = new tramite();
        $tramites = $tramiteSerie->obtenerTramitesSerie(VAR3);
        $tramiteTr = "";
        $i = 0;
        if ($tramites != "") {
            foreach ($tramites as $tramite) {
                $tramiteTr .= "<tr><td><input type='checkbox' name='tramite[$i]' value='" . $tramite->tra_id . "' $tramite->checked></td><td>" . $tramite->tra_descripcion . "</td></tr>\n";
                $i++;
            }
        } else {
            $tramiteTr = "<tr><td colspan='2'>No existen tramites</td></tr>";
        }
        $this->registry->template->LISTA_TRAMITES = $tramiteTr;
        $this->registry->template->LISTA_TRAMITES_SELECT = ''; //$tramiteLi;        

        $this->registry->template->titulo = "Editar ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_series.tpl');
        $this->registry->template->show('footer');
    }

    function update() {
        $tseries = new tab_series();
        $tseries->setRequest2Object($_REQUEST);
        $ser_id = $_REQUEST['ser_id'];
        $rows = $tseries->dbselectByField("ser_id", $ser_id);
        $rows = $rows[0];
        $tseries->setSer_id($rows->ser_id);
        $tseries->setUni_id($_REQUEST['uni_id']);
        $tseries->setTco_id($_REQUEST['tco_id']);
        $tseries->setRed_id($_REQUEST['red_id']);
        $tseries->setSer_codigo($rows->ser_codigo);
        if ($_REQUEST['ser_par']) {
            $tseries->setSer_par($_REQUEST['ser_par']);
        } else {
            $tseries->setSer_par(-1);
        }
        $tseries->setSer_categoria($_REQUEST['ser_categoria']);
        $tseries->setSer_contador($rows->ser_contador);
        $tseries->setSer_estado(1);
        $tseries->update();


        Header("Location: " . PATH_DOMAIN . "/series/");
    }

    function delete() {
        if (isset($_REQUEST)) {
            $ser_id = $_REQUEST['ser_id'];
            $this->series = new tab_series();
            $this->series->setRequest2Object($_REQUEST);

            $this->series->setSer_id($ser_id);
            $this->series->setSer_estado(2);
            $this->series->update();

            $st = new serietramite();
            $st->delete($ser_id);
            $use = new usu_serie();
            $use->deleteXSerie($ser_id);
            $ret = new retdocumental();
            $ret->deleteXSerie($ser_id);
            echo "OK";
        }
    }

    function validaDepen() {
        $series = new series();
        $swDepen = $series->validaDependencia($_REQUEST['ser_id']);
        if ($swDepen != 0) {
            echo 'No se puede eliminar la serie ! \nTiene expedientes o documentos';
        } else {
            echo '';
        }
    }

    function verifTramite() {
        $tramitec = new tab_serietramite();
        $tramite = $_REQUEST['ser_id'];
        $num = $tramitec->countBySQL("SELECT COUNT(ser_id) as num FROM tab_serietramite  WHERE ser_id='$tramite' ");
        if ($num > 0)
            echo true;
        else
            echo false;
    }

    function impresion() {

        //$usu_id = $_REQUEST["usu_id"];
        $this->tab_series = new Tab_series();
        $blanco = '#FFFFFF';
        $gris = '#D3D3D3';

        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        //ob_end_clean();
        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arsenio Castellon');
        $pdf->SetTitle('Reporte Series');
        $pdf->SetSubject('Reporte Series');
        $pdf->SetKeywords('ITEAM, Iteam, Iteam SRL');
        $pdf->SetHeaderData('logo_abc_comp.png', 20, 'ABC', 'ADMINISTRADORA BOLIVIANA DE CARRETERAS');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //set margins
        //define ('PDF_MARGIN_LEFT', 35);
        $pdf->SetMargins(15, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        // set font
        $pdf->AddPage();

        
        
        $cadena = "";
        $cadena .= '<table border="1">';
        $cadena .= '<tr align="center">
                        <td width="30"><b>Nro</b></td>
                        <td width="150"><b>C&oacute;digo</b></td>
                        <td width="500"><b>Serie</b></td>
                    </tr>';
        
        
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                ser.ser_codigo,
                tab_unidad.uni_id,
                tab_unidad.uni_descripcion,
                ser.ser_id,
                ser.ser_categoria,
                ser.ser_par,
                ser.ser_estado
                FROM
                tab_series AS ser
                INNER JOIN tab_unidad ON tab_unidad.uni_id = ser.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = ser.tco_id
                WHERE
                ser.ser_estado = 1 
                ORDER BY ser.ser_id ASC ";
        $row = $this->tab_series->dbSelectBySQL($sql);        
                //AND ser.ser_par = -1        
        
        
        $i = 1;
        $uni_descripciona = "";
        $uni_descripcionn = "";
        foreach ($row as $value) {
            if ($i % 2 == 0)
                $color = $blanco;
            else
                $color = $gris;

            
            $uni_descripcionn = $value->uni_descripcion;
            if ($uni_descripcionn != $uni_descripciona){
                $cadena .= '<tr bgcolor="' . $color . '">
                                <td width="680" colspan="3">' . "SECCION: " . $value->uni_descripcion . '</td>
                            </tr>';
            
            }
            
            if ($value->ser_codigo == '') {
                $cadena .= '<tr bgcolor="' . $color . '">
                                <td width="30">' . $i . '</td>
                                <td width="150">' . $value->fon_cod . DELIMITER . $value->uni_cod . DELIMITER . $value->tco_codigo . '</td>
                                <td width="500">' . $value->ser_categoria . '</td>
                            </tr>';
            } else {
                $cadena .= '<tr bgcolor="' . $color . '">
                                <td width="30">' . $i . '</td>
                                <td width="150">' . $value->fon_cod . DELIMITER . $value->uni_cod . DELIMITER . $value->tco_codigo . DELIMITER . $value->ser_codigo . '</td>
                                <td width="500">' . $value->ser_categoria . '</td>
                            </tr>';
            }
            $i++;
            $uni_descripciona = $value->uni_descripcion;
            
        }
        
        
        $cadena .= "</table>";

        // print a line using Cell()
        $usuario = new usuario();
        $pdf->SetFont('times', 'B', 10);
        $pdf->Cell(0, 10, 'LISTADO DE SERIES Y SUB SERIES', 0, 1, 'L', 0, '', 0);

        //$pdf->Ln();
        $pdf->SetFont('times', 'B', 10);
        $pdf->writeHTML($cadena, true, 0, true, 0);

        $pdf->Output('listado_series.pdf', 'I');
    }

    
    
    function loadAjaxSeries() {
        $uni_id = $_POST["Uni_id"];
        $sql = "SELECT 
                ser_id,
                ser_par,
                ser_nivel,
                ser_categoria
		FROM
		tab_series
		WHERE
                tab_series.ser_estado =  '1' AND
                tab_series.uni_id =  '$uni_id'
                ORDER BY ser_codigo ";
        $tab_series = new tab_series();
        $result = $tab_series->dbSelectBySQL($sql);
        $res = array();
        $series = new series();
        foreach ($result as $row) {
            if ($row->ser_par == '-1') {
                $res[$row->ser_id] = $row->ser_categoria;
            } else {
                $spaces = $series->getSpaces($row->ser_nivel);
                $res[$row->ser_id] = $spaces . " " . $row->ser_categoria;
            }
        }
        echo json_encode($res);
    }

    function loadAjax() { //despliega las unidades padre de un nivel dado (unidad hija)
        $res = array();
        $ser_id = $_POST["Ser_id"];
        $series = new tab_series();
        $sql = "SELECT
                    ser_id,
                    ser_codigo,
                    ser_contador
                    FROM
                    tab_series
                    WHERE (ser_estado = '1' AND ser_id='$ser_id')";
        $result = $series->dbSelectBySQL($sql);
        foreach ($result as $row) {
            $res['ser_codigo'] = $row->ser_codigo;
            $res['ser_contador'] = sprintf("%02d", $row->ser_contador + 1);
        }

        echo json_encode($res);
    }

}

?>
