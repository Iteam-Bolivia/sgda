<?php

/**
 * tramiteController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tramiteController extends baseController {

    function index() {

        $this->series = new tab_series();
        $sql = "SELECT 
                ser_categoria 
                FROM tab_series 
                WHERE ser_id = " . VAR3;
        $resul = $this->series->dbselectBySQL($sql);
        if (count($resul))
            $codigo = $resul[0]->ser_categoria;
        else
            $codigo = "";
        $this->registry->template->tra_id = "";
        $this->registry->template->ser_categoria = $codigo;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_tramiteg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tramite = new tramite();
        $this->tramite = new tab_tramite ();
        $this->tramite->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'tra_id';
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
            if ($qtype == 'tra_id')
                $where = " where $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT *
                                FROM tab_tramite
                                $where and tra_estado = 1 $sort $limit";
        } else {
            if (VAR3!=""){               
               $sql = "SELECT
                    tab_serietramite.ser_id,
                    tab_tramite.tra_id,
                    tab_tramite.tra_orden,
                    tab_tramite.tra_codigo,
                    tab_tramite.tra_descripcion,
                    tab_tramite.tra_estado
                    FROM
                    tab_series
                    INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
                    INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
                    WHERE tab_serietramite.ser_id = " . VAR3 . " 
                    AND tab_tramite.tra_estado = 1 $sort $limit";
                
            }else{
                $sql = "SELECT *
                        FROM tab_tramite
                        WHERE tra_estado = 1 $sort $limit";                
            }
        }
        $result = $this->tramite->dbselectBySQL($sql);
        $total = $tramite->count2($where, VAR3);
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
            $json .= "id:'" . $un->tra_id . "',";
            $json .= "cell:['" . $un->tra_id . "'";
            $json .= ",'" . addslashes($un->tra_orden) . "'";
            $json .= ",'" . addslashes($un->tra_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/tramite/view/" . $_REQUEST["tra_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->serietramite = new tab_serietramite();
        $sql = "SELECT * 
                FROM tab_serietramite 
                WHERE tra_id = " . VAR3;
        $resul = $this->serietramite->dbselectBySQL($sql);
        if(! $resul){ die("Error del sistema 404"); }
        if (count($resul)){
            $ser_id = $resul[0]->ser_id;
            $sts_id = $resul[0]->sts_id;
        }else{
            $ser_id = "";        
            $sts_id = "";
        }
        
        // Series
        $tab_series = new tab_series();
        $row2 = $tab_series->dbselectByField("ser_id", $ser_id);
        $row2 = $row2 [0];
        
        $this->tramite = new tab_tramite ();
        $this->tramite->setRequest2Object($_REQUEST);
        $tra_id = VAR3;
        $row = $this->tramite->dbselectByField("tra_id", $tra_id);
        $row = $row [0];
        
        $this->registry->template->sts_id = $sts_id;
        $this->registry->template->ser_id = $ser_id;
        $this->registry->template->ser_categoria = $row2->ser_categoria;
        $this->registry->template->tra_id = $row->tra_id;
        $this->registry->template->tra_orden = $row->tra_orden;
        $this->registry->template->tra_codigo = $row->tra_codigo;
        $this->registry->template->tra_descripcion = $row->tra_descripcion;
        $this->registry->template->titulo = "Editar ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $seriet = new series();
        $serietramite = $seriet->obtenerSerieTramites($tra_id);
        $i = 0;
        $liSerie = "";
        if ($serietramite != "") {
            foreach ($serietramite as $seriec) {
                $liSerie .= "<tr><td><input type='checkbox' name='serie[$i]' value='" . $seriec->ser_id . "' $seriec->checked></td><td>" . $seriec->ser_categoria . "</td></tr>\n";
                $i++;
            }
        } else {
            $liSerie = "<tr><td colspan='2'>No existen series asociadas a este tipo documental</td></tr>";
        }
        $this->registry->template->LISTA_SERIES = $liSerie;
        $this->registry->template->LISTA_SERIETRAMITES = ""; //$liSerie;
        $tramitec = new cuerpos ();

        $tramitecuerpo = $tramitec->obtenerCuerposTramite($tra_id);
        $tramiteCC = "";
        $i = 0;
        if ($tramitecuerpo != "") {
            foreach ($tramitecuerpo as $x => $tc) {
                if ($x % 2 == 0)
                    $class = 'class="marca"'; //"bgcolor='#DADADD'";
                else
                    $class = "";
                $tramiteCC .= "<tr $class><td><input type='checkbox' name='cuerpo[$i]' value='" . $tc->cue_id . "' $tc->checked></td><td>" . $tc->cue_descripcion . "</td></tr>\n";
                $i++;
            }
        } else {
            $tramiteCC = "<tr><td colspan='2'>No existen cuerpos asociados a este tramite</td></tr>";
        }
        $this->registry->template->LISTA_CUERPOS_TRAMITE = $tramiteCC;
        $this->registry->template->LISTA_CUERPOS = ""; //$liTramiteC;

        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_tramite.tpl');
        $this->registry->template->show('footer');
    }


    function add() {
        
        $this->series = new tab_series();
        $sql = "SELECT * 
                FROM tab_series 
                WHERE ser_id = " . VAR3;
        $resul = $this->series->dbselectBySQL($sql);
        if (count($resul))
            $codigo2 = $resul[0]->ser_categoria;
        else
            $codigo2 = "";
        $this->registry->template->sts_id = "";
        $this->registry->template->ser_id = VAR3;
        $this->registry->template->ser_categoria = $codigo2;
        $this->registry->template->tra_id = "";
        $tramite = new tramite();
        $this->registry->template->tra_orden = $tramite->getCount(null, VAR3);
        $this->registry->template->tra_codigo = "";
        $this->registry->template->tra_descripcion = "";
        $this->registry->template->titulo = "Nuevo tipo documental ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $seriet = new series();
        $serietramite = $seriet->obtenerSerieTramites();
        $i = 0;
        $liSerie = "";
        if ($serietramite != "") {
            foreach ($serietramite as $seriec) {
                $liSerie .= "<tr><td><input type='checkbox' name='serie[$i]' value='" . $seriec->ser_id . "' $seriec->checked></td> <td>" . $seriec->ser_codigo . "</td> <td>" . $seriec->ser_categoria . "</td></tr>\n";
                $i++;
            }
        } else {
            $liSerie = "<tr><td colspan='2'>No existen series asociadas a este tramite</td></tr>";
        }
        $this->registry->template->LISTA_SERIES = $liSerie;
        $this->registry->template->LISTA_SERIETRAMITES = ""; //$liSerie;
        $tramitec = new cuerpos ();
        $tramitecuerpo = $tramitec->obtenerCuerposTramite();
        $tramiteCC = "";
        $i = 0;
        if ($tramitecuerpo != "") {
            foreach ($tramitecuerpo as $x => $tc) {
                if ($x % 2 == 0)
                    $class = 'class="marca"'; //"bgcolor='#DADADD'";
                else
                    $class = "";

                $tramiteCC .= "<tr $class><td><input type='checkbox' name='cuerpo[$i]' value='" . $tc->cue_id . "' $tc->checked></td> <td>" . $tc->cue_codigo . "</td> <td>" . $tc->cue_descripcion . "</td> </tr>\n";
                $i++;
            }
        } else {
            $tramiteCC = "<tr><td colspan='2'>No existen cuerpos asociados a este tramite</td></tr>";
        }
        $this->registry->template->LISTA_CUERPOS_TRAMITE = $tramiteCC;
        $this->registry->template->LISTA_CUERPOS = ""; //$liTramiteC;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_tramite.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->series = new series();
        $ser_codigo = $this->series->obtenerCodigoSerie($_REQUEST['ser_id']);
        
//        // Codigo anterior
//        $ser_codigo = "";
//        $tra_siguiente = 0;
//        if (isset($_REQUEST['serie'])) {
//            $ser = $_REQUEST['serie'];
//            foreach ($ser as $serie) {
//                $this->series = new series();
//                $this->tramite = new tramite();
//                $ser_id = $serie;
//                $ser_codigo = $this->series->obtenerCodigoSerie($ser_id);
//                $tra_siguiente = $this->tramite->obtenerSiguienteSerie($ser_id);
//            }
//        }
//        //

        $this->tramite = new tab_tramite ();
        $this->tramite->setRequest2Object($_REQUEST);
        $this->tramite->setTra_orden = $_REQUEST['tra_orden'];
        //$this->tramite->setTra_codigo($_REQUEST['tra_codigo']);
        //$this->tramite->setTra_codigo($ser_codigo . "/" . $tra_siguiente);
        $this->tramite->setTra_codigo($_REQUEST['tra_orden']);
        $this->tramite->setTra_descripcion($_REQUEST['tra_descripcion']);
        $this->tramite->setTra_fecha_crea(date("Y-m-d"));
        $this->tramite->setTra_usuario_crea($_SESSION ['USU_ID']);
        $this->tramite->setTra_estado(1);
        $tra_id = $this->tramite->insert();
        
        //insert
        $seriet = new Tab_serietramite();
        $seriet->setSer_id($_REQUEST['ser_id']);
        $seriet->setTra_id($tra_id);
        $seriet->setSts_fecha_crea(date("Y-m-d"));
        $seriet->setSts_fecha_reg(date("Y-m-d"));
        $seriet->setSts_usuario_crea($_SESSION['USU_ID']);
        $seriet->setSts_usu_reg($_SESSION['USU_ID']);
        $seriet->setVer_id('0');
        $seriet->setSts_estado(1);
        $seriet->insert();

        
//        if (isset($_REQUEST['serie'])) {
//            $st = new tab_serietramite();
//            $serie = $_REQUEST['serie'];
//            foreach ($serie as $ser) {
//                //insert
//                $seriet = new Tab_serietramite();
//                $seriet->setSer_id($ser);
//                $seriet->setTra_id($tramite_id);
//                $seriet->setSts_fecha_crea(date("Y-m-d"));
//                $seriet->setSts_fecha_reg(date("Y-m-d"));
//                $seriet->setSts_usuario_crea($_SESSION['USU_ID']);
//                $seriet->setSts_usu_reg($_SESSION['USU_ID']);
//                $seriet->setVer_id('0');
//                $seriet->setSts_estado(1);
//                $seriet->insert();
//            }
//        }
        
        
        
//        if (isset($_REQUEST['cuerpo'])) {
//            $tramitec = new tab_tramitecuerpos ();
//            $cuerpos = $_REQUEST['cuerpo'];
//            foreach ($cuerpos as $cuerpotramite) {
//                $tramitec->setTra_id($tramite_id);
//                $tramitec->setCue_id($cuerpotramite);
//                //$tramitec->setVer_id ( $_SESSION ['VER_ID'] );
//                $tramitec->setVer_id('0');
//                $tramitec->setTrc_fecha_crea(date("Y-m-d"));
//                $tramitec->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                $tramitec->setTrc_estado(1);
//                $tramitec->insert();
//            }
//        }
        Header("Location: " . PATH_DOMAIN . "/tramite/index/" . $_REQUEST['ser_id'] . "/");
        //Header("Location: " . PATH_DOMAIN . "/tramite/");
    }

    function update() {
        
        
//        $tra_siguiente = 0;
//        if (isset($_REQUEST['serie'])) {
//            $ser = $_REQUEST['serie'];
//            foreach ($ser as $serie) {
//                $this->series = new series();
//                $this->tramite = new tramite();
//                $ser_id = $serie;
//                $ser_codigo = $this->series->obtenerCodigoSerie($ser_id);
//                $tra_siguiente = $this->tramite->obtenerSiguienteSerie($ser_id);
//            }
//        }
        
        $this->series = new series();
        $ser_codigo = $this->series->obtenerCodigoSerie($_REQUEST['ser_id']);
        $this->tramite = new tab_tramite ();
        $this->tramite->setRequest2Object($_REQUEST);
        $tramite_id = $_REQUEST['tra_id'];
        $this->tramite->setTra_id($tramite_id);
        $this->tramite->setTra_codigo($_REQUEST['tra_orden']);
        $this->tramite->setTra_orden($_REQUEST['tra_orden']);
        $this->tramite->setTra_descripcion($_REQUEST['tra_descripcion']);
        $this->tramite->setTra_fecha_mod(date("Y-m-d"));
        $this->tramite->setTra_usuario_mod($_SESSION ['USU_ID']);
        $this->tramite->setTra_estado(1);
        $this->tramite->update();

        
        $seriet = new Tab_serietramite();
        $seriet->setSts_id($_REQUEST['sts_id']);
        $seriet->setSer_id($_REQUEST['ser_id']);
        $seriet->setTra_id($_REQUEST['tra_id']);
        $seriet->setSts_estado(1);
        $seriet->update();
        
//        $sts = new serietramite();
//        $sts->deleteXTramite($tramite_id);
//
//        if (isset($_REQUEST['serie'])) {
//            $st = new tab_serietramite();
//            $serie = $_REQUEST['serie'];
//            foreach ($serie as $ser) {
//                $row = $st->dbSelectBySQL("SELECT * FROM tab_serietramite
//                                    WHERE tra_id='" . $tramite_id . "' AND ser_id='" . $ser . "' ");
//                if (count($row) > 0) {
//                    //update
//                    $seriet = new Tab_serietramite();
//                    $seriet->setSts_id($row[0]->sts_id);
//                    $seriet->setSts_fecha_reg(date("Y-m-d"));
//                    $seriet->setSts_usu_reg($_SESSION['USU_ID']);
//                    //$seriet->setVer_id( $_SESSION['VER_ID'] );
//                    $seriet->setVer_id('0');
//                    $seriet->setSts_estado(1);
//                    $seriet->update();
//                } else {
//                    //insert
//                    $seriet = new Tab_serietramite();
//                    $seriet->setSer_id($ser);
//                    $seriet->setTra_id($tramite_id);
//                    $seriet->setSts_fecha_crea(date("Y-m-d"));
//                    $seriet->setSts_fecha_reg(date("Y-m-d"));
//                    $seriet->setSts_usuario_crea($_SESSION['USU_ID']);
//                    $seriet->setSts_usu_reg($_SESSION['USU_ID']);
//                    //$seriet->setVer_id( $_SESSION['VER_ID'] );
//                    $seriet->setVer_id('0');
//
//                    $seriet->setSts_estado(1);
//                    $seriet->insert();
//                }
//            }
//        }
//        
//        
//        // Tramitecuerpos
//        $trc = new tramitecuerpos();
//        $trc->deleteXTramite($tramite_id);
//        if (isset($_REQUEST['cuerpo'])) {
//            $tramitec = new tab_tramitecuerpos ();
//            $cuerpos = $_REQUEST['cuerpo'];
//            foreach ($cuerpos as $cuerpotramite) {
//                $row = $tramitec->dbSelectBySQL("SELECT * FROM tab_tramitecuerpos
//								WHERE tra_id='" . $tramite_id . "' AND cue_id='" . $cuerpotramite . "' ");
//                if (count($row) > 0) {
//                    $tramitec = new tab_tramitecuerpos ();
//                    $tramitec->setTrc_id($row[0]->trc_id);
//                    //$tramitec->setVer_id ( $_SESSION ['VER_ID'] );1
//                    $tramitec->setVer_id('0');
//                    $tramitec->setTrc_fecha_crea(date("Y-m-d"));
//                    $tramitec->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                    $tramitec->setTrc_estado(1);
//                    $tramitec->update();
//                } else {
//                    $tramitec = new tab_tramitecuerpos ();
//                    $tramitec->setTra_id($tramite_id);
//                    $tramitec->setCue_id($cuerpotramite);
//                    //$tramitec->setVer_id ( $_SESSION ['VER_ID'] );
//                    $tramitec->setVer_id('0');
//                    $tramitec->setTrc_fecha_crea(date("Y-m-d"));
//                    $tramitec->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                    $tramitec->setTrc_estado(1);
//                    $tramitec->insert();
//                }
//            }
//        }
//        
        
        Header("Location: " . PATH_DOMAIN . "/tramite/index/" . $_REQUEST['ser_id'] . "/");

    }

    function delete() {
        $this->tramite = new tab_tramite ();
        $this->tramite->setRequest2Object($_REQUEST);
        $tra_id = $_REQUEST['tra_id'];
        $this->tramite->setTra_id($tra_id);
        $this->tramite->setTra_estado(2);
        $this->tramite->update();

        $st = new serietramite();
        $st->deleteXTramite($tra_id);

        $trc = new tramitecuerpos();
        $trc->deleteXTramite($tra_id);
        echo "OK";
    }

    function loadAjaxTramites() {
        $ser_id = $_POST["Ser_id"];
        $sql = "SELECT
                tab_series.ser_id,
                tab_tramite.tra_id,
                tab_tramite.tra_orden,
                tab_tramite.tra_descripcion
                FROM
                tab_series
                INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
                WHERE tab_serietramite.sts_estado = 1
                AND tab_series.ser_id =  '$ser_id'
                ORDER BY tab_tramite.tra_orden ";
        $this->tramite = new tab_tramite ();
        $result = $this->tramite->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->tra_id] = $row->tra_descripcion;
        }
        echo json_encode($res);
    }     
    
    function verif() {
        $tramitec = new tab_tramitecuerpos ();
        $tramite = VAR3;
        $row = $tramitec->dbSelectBySQL("SELECT COUNT(trc_id) as num FROM tab_tramitecuerpos  WHERE tra_id='$tramite' ");
        //if(count($row)) echo $row[0]->num;
        //else 			echo 0;
        echo $tramite;
    }

}

?>