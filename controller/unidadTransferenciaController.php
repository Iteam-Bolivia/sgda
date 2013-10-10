<?php

/**
 * unidadTransferenciaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class unidadTransferenciaController extends baseController {

    var $unidad;

    function countPersonal() {
        $tunidad = new unidadTemp();
        if ($tunidad->countEliminadas() > 0)
            header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/");
        else
            header("Location: " . PATH_DOMAIN . "/unidad/");
    }

    function verifUEliminadas() {
        $tunidad = new unidadTemp();
        if ($tunidad->countEliminadas() > 0)
            header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/");
        else
            header("Location: " . PATH_DOMAIN . "/unidad/");
    }

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu("versionado", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        //$this->llenarLinks();
        $nivel = new nivel ();
        $this->registry->template->PATH_B = $nivel->loadMenu();
        $this->registry->template->VAR1 = VAR1;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "edit";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('unidadTransferenciag.tpl');
        $this->registry->template->show('footer');
    }

    function editUnidades() {
        header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/viewU/" . $_REQUEST["uni_id"] . "/");
    }

    function editPersonas() {
        header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/viewP/" . $_REQUEST["uni_id"] . "/");
    }

    function viewP() {
        // confirmados los cambios de personal, copia el personal transferido a temp_personal
        if(! VAR3){ die("Error del sistema 404"); }
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu("versionado", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        //$this->llenarLinks();
        $tunidad = new unidadTemp();
        $tpersonal = new personalTemp();
        $this->registry->template->uni_destino = VAR3;
        $des = $tunidad->obtenerDes(VAR3);
        if (strlen($des) > 45)
            $des = substr($des, 0, 45) . "...";
        $this->registry->template->VAR1 = VAR1;
        $this->registry->template->uni_destino_des = $des;
        $this->registry->template->uni_origen = $tunidad->obtenerSelectTodas(VAR3);
        $this->registry->template->personal_transferido = $tpersonal->obtenerPersonalTransferido(VAR3);
        $this->registry->template->personal_por_tranf = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "savePersonas";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('temp_personal.tpl');
        $this->registry->template->show('footer');
    }

    function viewU() {
        // imprimimos el organigama y confirmados los cambios, copia las unidades de la tabla temporal a tab_unidad.
        // colocando en vigencia esta nueva estructura
        if(! VAR3){ die("Error del sistema 404"); }
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu("versionado", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        //$this->llenarLinks();
        $tunidad = new unidadTemp();
        $this->registry->template->uni_nueva = VAR3;
        $des = $tunidad->obtenerDes(VAR3);
        if (strlen($des) > 45)
            $des = substr($des, 0, 45) . "...";
        $this->registry->template->VAR1 = VAR1;
        $this->registry->template->uni_nueva_des = $des;
        $this->registry->template->uni_eliminadas = $tunidad->obtenerCuadrosOrigen(VAR3);
        $this->registry->template->uni_transferidas = $tunidad->obtenerCuadrosTransferidos(VAR3);
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "saveUnidades";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('temp_unidad.tpl');
        $this->registry->template->show('footer');
    }

    function savePersonas() {
        //marcamos los cambios de personal en la tabla temp_personal
        $unidad = new unidadTemp ();
        $uni_destino = addslashes(html_entity_decode($_REQUEST['uni_destino'], ENT_QUOTES));
        $personal_transferidas = addslashes(html_entity_decode($_REQUEST['personal_trans'], ENT_QUOTES));
        //delete de temp_personal de la uni_destino
        /* $tunidad = new temp_personal();
          $tunidad->deleteByField("uni_destino",$uni_destino); */

        //actualizamos unidad_trn
        /* $unitrn->deleteByField("uni_destino",$uni_destino); */

        //insert de personas transferidas
        $tuni = new Temp_unidad();

        $rows = $tuni->dbselectByField("uni_id", $uni_destino);
        if (count($rows) != 1) {
            header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/");
        }
        if (!empty($personal_transferidas)) {
            $personal_transferidas = substr($personal_transferidas, 1);
            $per_transfarray = explode("|", $personal_transferidas);
            foreach ($per_transfarray as $personal_trans) {
                $tper = new Tab_usuario();
                $row_per = $tper->dbselectByField("usu_id", $personal_trans);
                $uni_origen = $row_per[0]->uni_id;
                $unitrn = new Temp_unidad_trn();
                $r_unitrn = $unitrn->dbselectBy2Field("uni_origen", $uni_origen, "uni_destino", $uni_destino);
                if (count($r_unitrn) == 0) {
                    //insert en Temp_unidad_trn
                    $tunitrn = new Temp_unidad_trn();
                    $tunitrn->uni_origen = $uni_origen;
                    $tunitrn->uni_destino = $uni_destino;
                    $tunitrn->insert();
                }
                if (count($row_per) == 1) {
                    $tempp = new Temp_personal();
                    $row_tper = $tempp->dbselectByField("usu_id", $personal_trans);
                    if (count($row_tper) == 0) {
                        $tpersonal = new personalTemp();
                        $tpersonal->transferirPorPersonal($personal_trans, $uni_origen, $uni_destino);
                    }
                }
            }
        }
        header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/");
    }

    function saveUnidades() {
        //marcamos los cambios de personal en la tabla temp_personal
        $unidad = new unidadTemp ();
        $uni_destino = addslashes(html_entity_decode($_REQUEST['uni_nueva'], ENT_QUOTES));
        $uni_transferidas = addslashes(html_entity_decode($_REQUEST['uni_trans'], ENT_QUOTES));
        //update de $trans_uni_recibidas
        $tuni = new Temp_unidad();
        //actualizamos unidad_trn
        $unitrn = new Temp_unidad_trn();
        $unitrn->deleteByField("uni_destino", $uni_destino);
        $tusu = new tab_usuario();
        //actualizamos personal
        if (!empty($uni_transferidas)) {
            $uni_transferidas = substr($uni_transferidas, 1);
            $uni_transfarray = explode("|", $uni_transferidas);
            foreach ($uni_transfarray as $uni_transf) {
                $sql = "SELECT tu.usu_id FROM tab_usuario tu WHERE tu.uni_id = '$uni_transf'
                        AND tu.usu_id NOT IN
                                (SELECT t.usu_id FROM temp_personal t WHERE tu.usu_id = t.usu_id) ";
                $r_usu = $tusu->dbSelectBySQL($sql);
                foreach ($r_usu as $usu) {
                    $tpersonal = new Temp_personal();
                    $tpersonal->setUsu_id($usu->usu_id);
                    $tpersonal->setUni_origen($uni_transf);
                    $tpersonal->setUni_destino($uni_destino);
                    $tpersonal->insert();
                }
                $unidad_trn = new Temp_unidad_trn();
                $unidad_trn->uni_origen = $uni_transf;
                $unidad_trn->uni_destino = $uni_destino;
                $unidad_trn->insert();
            }
        }
        header("Location: " . PATH_DOMAIN . "/" . VAR1 . "/");
    }

    function load() {
        $unidad = new unidadTemp();
        $this->unidad = new temp_unidad ();
        $this->unidad->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'uni_id';
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
            if ($qtype == 'uni_id') {
                $where = " AND tem.uni_id = '" . $query . "' ";
            } elseif ($qtype == 'tem_uni_recibidas_cod') {
                $where = " AND tem.uni_id IN (SELECT tp.uni_destino FROM temp_personal tp
				INNER JOIN temp_unidad tu ON tu.uni_id = tp.uni_origen
				WHERE tu.uni_codigo like '%$query%' )";
            } elseif ($qtype == 'niv_abrev') {
                $where = " AND tn.niv_abrev = '" . $query . "' ";
            } else {
                $where = " AND $qtype like '%$query%' ";
            }
        }
        $select = "SELECT DISTINCT
				tem.uni_id,
				tn.niv_abrev,
				tem.uni_codigo,
				tem.uni_descripcion ";
        $from = "FROM
				temp_unidad AS tem
				INNER JOIN tab_nivel tn ON tn.niv_id=tem.niv_id
				WHERE (uni_estado = '1' or  uni_estado = '10') ";
        $sql = "$select $from $where $sort $limit ";
        $result = $this->unidad->dbselectBySQL($sql);
        $sql_c = "SELECT COUNT(DISTINCT tem.uni_id) AS num $from $where";
        $total = $this->unidad->countBySQL($sql_c);
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
            $json .= "id:'" . $un->uni_id . "',";
            $json .= "cell:['" . $un->uni_id . "'";
            $json .= ",'" . addslashes($un->niv_abrev) . "'";
            $json .= ",'" . addslashes($un->uni_codigo) . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($unidad->obtenerCodigos($un->uni_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function loadPersonal() {
        $uni_origen = addslashes(html_entity_decode($_REQUEST['uni_origen'], ENT_QUOTES));
        $uni_destino = addslashes(html_entity_decode($_REQUEST['uni_destino'], ENT_QUOTES));
        //se carga el personal de la unidad eliminada
        $tpersonal = new personalTemp();
        echo json_encode($tpersonal->obtenerPersonal($uni_origen, $uni_destino, ''));
    }

    function verifTransf() {
        //verifica si existe personal en unidad eliminada sin haberse transferido
        $tunidad = new temp_personal();
        $sql = "SELECT tab_usuario.usu_id, usu_nombres, usu_apellidos, temp_unidad.uni_id, uni_codigo
			FROM
			tab_usuario
			Inner Join temp_unidad ON tab_usuario.uni_id = temp_unidad.uni_id
			WHERE
			temp_unidad.uni_estado =  '3' AND
			tab_usuario.usu_id NOT IN
			(SELECT temp_personal.usu_id FROM temp_personal)
                ORDER BY uni_codigo ASC, usu_apellidos ASC, usu_nombres ASC";
        $row_faltantes = $tunidad->dbSelectBySQL($sql);
        echo json_encode($row_faltantes);
    }

    function llenarLinks() {

        $this->registry->template->msg_paso4 = "";
        $this->registry->template->url_paso4 = "#";
        $this->registry->template->url_paso3 = "#";
        $this->registry->template->url_paso2 = "#";
        $this->registry->template->url_paso1 = PATH_DOMAIN . "/nivel/";
        if ($_SESSION['PASO'] == 3) {
            $this->registry->template->url_paso4 = PATH_DOMAIN . "/unidadTransferencia/verifTransf/";
            $this->registry->template->msg_paso4 = ' onclick="return confirm(\'Desea Finalizar el proceso?\');"';
        }
        if ($_SESSION['PASO'] == 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/versionado/nextPaso/";
        } elseif ($_SESSION['PASO'] > 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/unidadTransferencia/";
        }
        if ($_SESSION['PASO'] == 1) {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/versionado/nextPaso/";
        } else {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/unidad/";
        }
    }

}

?>
