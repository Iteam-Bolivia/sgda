<?php

/**
 * cuerposController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class cuerposController extends baseController {

    function index() {
        $this->tramite = new tab_tramite();
        
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
                WHERE tab_tramite.tra_id = " . VAR3 . " 
                AND tab_tramite.tra_estado = 1 ";
        
        //$sql = "SELECT * FROM tab_tramite WHERE tra_id = " . VAR3;
        $resul = $this->tramite->dbselectBySQL($sql);
        if (count($resul)) {
            $codigo = $resul[0]->tra_descripcion;
            $tra_id = $resul[0]->tra_id;
            $ser_id = $resul[0]->ser_id;
        }
        else{
            $codigo = "";
            $tra_id = 0;
            $ser_id = 0;
        }
        $this->registry->template->cue_id = "";
        $this->registry->template->tra_id = $tra_id;
        $this->registry->template->ser_id = $ser_id;
        $this->registry->template->tra_descripcion = $codigo;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_cuerposg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $cuerpos = new cuerpos();
        $this->cuerpos = new tab_cuerpos ();
        $this->cuerpos->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'cue_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        if ($query) {
            if ($qtype == 'cue_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT *
                                FROM tab_cuerpos
                                $where and cue_estado = 1
                                $sort $limit";
        } else {
            if (VAR3!=""){
                $sql = "SELECT
                        tab_tramitecuerpos.tra_id,
                        tab_cuerpos.cue_id,
                        tab_cuerpos.cue_orden,
                        tab_cuerpos.cue_codigo,
                        tab_cuerpos.cue_descripcion,
                        tab_cuerpos.cue_estado
                        FROM
                        tab_tramite
                        INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                        INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                        WHERE tab_tramitecuerpos.tra_id = " . VAR3 . " AND tab_cuerpos.cue_estado = 1
                        $sort $limit";                
            }else{
                $sql = "SELECT *
                        FROM tab_cuerpos
                        WHERE cue_estado = 1
                        $sort $limit";
            }
        }
        $result = $this->cuerpos->dbselectBySQL($sql);
        //$total = $cuerpos->count($qtype, $query);
        $total = $cuerpos->count2($where, VAR3);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
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
            $json .= "id:'" . $un->cue_id . "',";
            $json .= "cell:['" . $un->cue_id . "'";
            $json .= ",'" . addslashes(utf8_encode($un->cue_orden)) . "'";
            $json .= ",'" . addslashes(utf8_encode($un->cue_descripcion)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/cuerpos/view/" . $_REQUEST["cue_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->tramite = new tab_tramite();
        $sql = "SELECT * FROM tab_tramite WHERE tra_id = " . VAR3;
        $resul = $this->tramite->dbselectBySQL($sql);
        if (count($resul))
            $codigo2 = $resul[0]->tra_descripcion;
        else
            $codigo2 = "";
        
        $this->tramitecuerpos = new tab_tramitecuerpos();
        $sql = "SELECT * 
                FROM tab_tramitecuerpos 
                WHERE cue_id = " . VAR3;
        $resul2 = $this->tramitecuerpos->dbselectBySQL($sql);
        if (count($resul2)){
            $tra_id = $resul2[0]->tra_id;
            $trc_id = $resul2[0]->trc_id;
        }else{
            $tra_id = ""; 
            $trc_id = ""; 
        }
        
        $this->cuerpos = new tab_cuerpos ();
        
        $this->cuerpos->setRequest2Object($_REQUEST);
        $cue_id = VAR3;
        $row = $this->cuerpos->dbselectByField("cue_id", $cue_id);
        $row = $row [0];
        /* $tramite = new tramitecuerpos ();
          $options = $tramite->obtenerSelectTramiteCuerpos ( "", $cue_id );
          $this->registry->template->tramites = $options;

          $tramitecuerpo = $tramite->obtenerTramiteCuerpos ( $cue_id );
          $liTramite = "";
          if ($tramitecuerpo != "") {
          foreach ( $tramitecuerpo as $tramitec ) {
          $liTramite .= "<li>" . $tramitec->tra_descripcion . "</li>\n";
          }
          }
          $this->registry->template->LIST_TRAMITES = $liTramite; */
        $tramiteSerie = new tramite();
        $tramites = $tramiteSerie->obtenerTramitesCuerpo($cue_id);
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
        $this->registry->template->tra_descripcion = $codigo2;  
        $this->registry->template->trc_id = $trc_id;
        $this->registry->template->tra_id = $tra_id;
        $this->registry->template->cue_id = $row->cue_id;
        $this->registry->template->cue_orden = $row->cue_orden;
        $this->registry->template->cue_codigo = $row->cue_codigo;
        $this->registry->template->cue_descripcion = $row->cue_descripcion;
        $this->registry->template->cue_fecha_crea = $row->cue_fecha_crea;
        $this->registry->template->cue_usuario_crea = $row->cue_usuario_crea;
        $this->registry->template->cue_fecha_mod = $row->cue_fecha_mod;
        $this->registry->template->cue_usuario_mod = $row->cue_usuario_mod;
        $this->registry->template->cue_estado = $row->cue_estado;
        $this->registry->template->titulo = "Editar ";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_cuerpos.tpl');
        $this->registry->template->show('footer');
    }


    function add() {
        $this->tramite = new tab_tramite();
        $sql = "SELECT * FROM tab_tramite WHERE tra_id = " . VAR3;
        $resul = $this->tramite->dbselectBySQL($sql);
        if (count($resul))
            $codigo2 = $resul[0]->tra_descripcion;
        else
            $codigo2 = "";

        $this->registry->template->titulo = "Nuevo tipo documental de";
        $this->registry->template->trc_id = "";
        $this->registry->template->tra_id = VAR3;
        $this->registry->template->tra_descripcion = $codigo2;        
        $this->registry->template->cue_id = "";
        $cuerpos = new cuerpos();
        $this->registry->template->cue_orden = $cuerpos->getCount(null, VAR3);
        $this->registry->template->cue_codigo = "";
        $this->registry->template->cue_descripcion = "";
        $this->registry->template->titulo = "Nuevo ";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";

        /* $this->registry->template->LIST_TRAMITECUERPOS = "";
          $tramite = new tramitecuerpos ();
          $options = $tramite->obtenerSelectTramites ( "" );
          $this->registry->template->tramites = $options; */
        $tramiteSerie = new tramite();
        $tramites = $tramiteSerie->obtenerTramitesCuerpo();
        $tramiteTr = "";
        $i = 0;
        if ($tramites != "") {
            foreach ($tramites as $tramite) {
                $tramiteTr .= "<tr><td><input type='checkbox' name='tramite[$i]' value='" . $tramite->tra_id . "' $tramite->checked></td> <td>" . $tramite->tra_codigo . "</td> <td>" . $tramite->tra_descripcion . "</td> </tr>\n";
                $i++;
            }
        } else {
            $tramiteTr = "<tr><td colspan='2'>No existen tipos documentales</td></tr>";
        }
        $this->registry->template->LISTA_TRAMITES = $tramiteTr;

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_cuerpos.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        // Last code
        $this->tramite = new tramite();
        $tra_codigo = $this->tramite->obtenerCodigoTramite($_REQUEST['tra_id']);
        //$cue_siguiente = $this->cuerpos->obtenerSiguienteCuerpo($_REQUEST['tra_id']);
             
//        // Code before
//        $tra_codigo = "";
//        $cue_siguiente = 0;
//        if (isset($_REQUEST['tramite'])) {
//            $tram = $_REQUEST['tramite'];
//            foreach ($tram as $tramite) {
//                $this->tramite = new tramite();
//                $this->cuerpos = new cuerpos();
//                $tra_id = $tramite;
//                $tra_codigo = $this->tramite->obtenerCodigoTramite($tra_id);
//                $cue_siguiente = $this->cuerpos->obtenerSiguienteCuerpo($tra_id);
//            }
//        }
        //

        $tcuerpos = new tab_cuerpos ();
        $tcuerpos->setRequest2Object($_REQUEST);        
        $tcuerpos->setCue_id($_REQUEST['cue_id']);
        $tcuerpos->setCue_orden($_REQUEST['cue_orden']);
        //$tcuerpos->setCue_codigo ( $_REQUEST['cue_codigo'] );
        //$tcuerpos->setCue_codigo ( $tra_codigo . "/". $cue_siguiente );
        $tcuerpos->setCue_codigo($_REQUEST['cue_orden']);
        $tcuerpos->setCue_descripcion($_REQUEST['cue_descripcion']);
        $tcuerpos->setCue_fecha_crea(date("Y-m-d"));
        $tcuerpos->setCue_usuario_crea($_SESSION ['USU_ID']);
        $tcuerpos->setCue_estado(1);
        $cue_id = $tcuerpos->insert();

        
        // Last code
        $tramitecc = new tab_tramitecuerpos();
        $tramitecc->setCue_id($cue_id);
        $tramitecc->setTra_id($_REQUEST['tra_id']);
        $tramitecc->setTrc_estado(1);
        $tramitecc->insert();
        
       
//        // Code before
//        if (isset($_REQUEST['tramite'])) {
//            $tramitec = new tab_tramitecuerpos();
//            $tram = $_REQUEST['tramite'];
//            foreach ($tram as $tramite) {
//                $tramitecc = new tab_tramitecuerpos();
//                $tramitecc->setCue_id($cuerpo_id);
//                $tramitecc->setTra_id($tramite);
//                //$tramitecc->setVer_id($_SESSION['VER_ID']);
//                $tramitecc->setVer_id('0');
//                $tramitecc->setTrc_fecha_crea(date("Y-m-d"));
//                $tramitecc->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                $tramitecc->setTrc_estado(1);
//                $tramitecc->insert();
//            }
//        }
        
        
        Header("Location: " . PATH_DOMAIN . "/cuerpos/index/" . $_REQUEST['tra_id'] . "/");
        //Header("Location: " . PATH_DOMAIN . "/cuerpos/");
    }

    function update() {

        
//        $cue_siguiente = 0;
//        if (isset($_REQUEST['tramite'])) {
//            $tram = $_REQUEST['tramite'];
//            foreach ($tram as $tramite) {
//                $this->tramite = new tramite();
//                $this->cuerpos = new cuerpos();
//                $tra_id = $tramite;
//                $tra_codigo = $this->tramite->obtenerCodigoTramite($tra_id);
//                $cue_siguiente = $this->cuerpos->obtenerSiguienteCuerpo($tra_id);
//            }
//        }
//        //

        $this->tramite = new tramite();
        $tra_codigo = $this->tramite->obtenerCodigoTramite($_REQUEST['tra_id']);        
        $this->cuerpos = new tab_cuerpos ();
        $this->cuerpos->setRequest2Object($_REQUEST);
        $cue_id = $_REQUEST['cue_id'];
        $this->cuerpos->setCue_id($cue_id);        
        $this->cuerpos->setCue_codigo($_REQUEST['cue_orden']);
        $this->cuerpos->setCue_orden($_REQUEST['cue_orden']);        
        $this->cuerpos->setCue_descripcion($_REQUEST['cue_descripcion']);
        $this->cuerpos->setCue_fecha_mod(date("Y-m-d"));
        $this->cuerpos->setCue_usuario_mod($_SESSION ['USU_ID']);
        $this->cuerpos->update();
        
        // Last code
        $tramitecc = new tab_tramitecuerpos();
        $tramitecc->setTrc_id($_REQUEST['trc_id']);
        $tramitecc->setCue_id($_REQUEST['cue_id']);
        $tramitecc->setTra_id($_REQUEST['tra_id']);
        $tramitecc->setTrc_estado(1);
        $tramitecc->update();
        
//        $trc = new tramitecuerpos();
//        $trc->deleteXCuerpo($cue_id);
//        if (isset($_REQUEST['tramite'])) {
//            $tramitec = new tab_tramitecuerpos();
//            $tram = $_REQUEST['tramite'];
//            foreach ($tram as $tramite) {
//                $row = $tramitec->dbSelectBySQL("SELECT *
//                                                FROM tab_tramitecuerpos
//                                                WHERE cue_id='" . $cue_id . "' AND tra_id='" . $tramite . "' ");
//                if (count($row) > 0) {
//                    $tramitec = new tab_tramitecuerpos();
//                    // MODIFIED: CASTELLON
//                    $tramitec->setTrc_id($row[0]->trc_id);
//                    // END MODIFIED: CASTELLON
//
//                    $tramitec->setTra_id($tramite);
//                    $tramitec->setCue_id($cue_id);
//                    //$tramitec->setVer_id ( $_SESSION ['VER_ID'] );
//                    //$tramitec->setVer_id ( '0' );
//                    $tramitec->setTrc_fecha_crea(date("Y-m-d"));
//                    $tramitec->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                    $tramitec->setTrc_estado(1);
//                    $tramitec->update();
//                } else {
//                    $tramitec = new tab_tramitecuerpos();
//                    $tramitec->setTra_id($tramite);
//                    $tramitec->setCue_id($cue_id);
//                    $tramitec->setVer_id('0');
//                    $tramitec->setTrc_fecha_crea(date("Y-m-d"));
//                    $tramitec->setTrc_usuario_crea($_SESSION ['USU_ID']);
//                    $tramitec->setTrc_estado(1);
//                    $tramitec->update();
//                }
//            }
//        }
        
        Header("Location: " . PATH_DOMAIN . "/cuerpos/index/" . $_REQUEST['tra_id'] . "/");

    }

    function delete() {
        $tcuerpos = new tab_cuerpos();
        $tcuerpos->setRequest2Object($_REQUEST);

        $tcuerpos->setCue_id($_REQUEST['cue_id']);
        $tcuerpos->setCue_estado(2);
        $tcuerpos->setCue_fecha_mod(date("Y-m-d"));
        $tcuerpos->setCue_usuario_mod($_SESSION['USU_ID']);
        $tcuerpos->update();

        $tracue = new tab_tramitecuerpos();
        $tracue->dbBySQL("UPDATE tab_tramitecuerpos
                                  SET trc_estado='2'
                                  WHERE cue_id='" . $_REQUEST['cue_id'] . "' AND trc_estado='1'");
        echo 'OK';
    }
    
    
    function loadAjaxCuerpos() {
        $tra_id = $_POST["Tra_id"];
        $sql = "SELECT
                tab_tramite.tra_id,
                tab_cuerpos.cue_id,
                tab_cuerpos.cue_orden,
                tab_cuerpos.cue_descripcion
                FROM
                tab_tramite
                INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                WHERE tab_tramitecuerpos.trc_estado = 1
                AND tab_tramite.tra_id =  '$tra_id'
                ORDER BY tab_cuerpos.cue_orden ";
        $this->cuerpos = new tab_cuerpos ();
        $result = $this->cuerpos->dbSelectBySQL($sql);
        $res = array();
        foreach ($result as $row) {
            $res[$row->cue_id] = $row->cue_descripcion;
        }
        echo json_encode($res);
    }      

}

?>