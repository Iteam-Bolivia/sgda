<?php

/**
 * unidadController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class unidadPersonalController extends baseController {

    var $unidad;

    function index() {

        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu("versionado", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->llenarLinks();
        $nivel = new nivel ();
        $this->registry->template->PATH_B = $nivel->loadMenu();
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "edit";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('temp_personalg.tpl');
    }

    function edit() {
        header("Location: " . PATH_DOMAIN . "/unidadPersonal/view/" . $_REQUEST["uni_id"] . "/");
    }

    function view() {
        // confirmados los cambios de personal, copia el personal transferido a temp_personal

        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu("versionado", $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->llenarLinks();
        $tunidad = new unidadTemp();
        $tpersonal = new personalTemp();
        $this->registry->template->uni_destino = VAR3;
        $des = $tunidad->obtenerDes(VAR3);
        if (strlen($des) > 45)
            $des = substr($des, 0, 45) . "...";
        $this->registry->template->uni_destino_des = $des;
        $this->registry->template->uni_eliminadas = $tunidad->obtenerSelectEliminados();
        $this->registry->template->personal_transferido = $tpersonal->obtenerPersonalTransferido(VAR3);
        $this->registry->template->personal_por_tranf = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('header');
        $this->registry->template->show('temp_personal.tpl');
    }

    function save() {
        //marcamos los cambios de personal en la tabla temp_personal
        $unidad = new unidadTemp ();
        $uni_destino = addslashes(html_entity_decode($_REQUEST['uni_destino'], ENT_QUOTES));
        $personal_transferidas = addslashes(html_entity_decode($_REQUEST['personal_trans'], ENT_QUOTES));
        //delete de temp_personal de la uni_destino
        $tunidad = new temp_personal();
        $tunidad->deleteByField("uni_destino", $uni_destino);

        //actualizamos unidad_trn
        /* $unitrn = new Temp_unidad_trn();
          $unitrn->deleteByField("uni_destino",$uni_destino); */

        //insert de personas transferidas
        $tuni = new Temp_unidad();

        $rows = $tuni->dbselectByField("uni_id", $uni_destino);
        if (count($rows) != 1) {
            echo "Error: unidad no se encuentra en temp_unidad, verifique.";
            die;
        }
        if (!empty($personal_transferidas)) {
            $personal_transferidas = substr($personal_transferidas, 1);
            $per_transfarray = explode("|", $personal_transferidas);
            foreach ($per_transfarray as $personal_trans) {
                $tper = new Tab_usuario();
                $row_per = $tper->dbselectByField("usu_id", $personal_trans);
                if (count($row_per) == 1) {
                    $tpersonal = new personalTemp();
                    $tpersonal->transferirPorPersonal($personal_trans, $row_per[0]->uni_id, $uni_destino);
                }
            }
        }
        header("Location: " . PATH_DOMAIN . "/unidadPersonal/");
    }

    function verifTransf() {
        //verifica si existe personal en unidad eliminada sin haberse transferido
        $tunidad = new temp_personal();
        $sql = "SELECT Count(tab_usuario.usu_id) as num
			FROM
			tab_usuario
			Inner Join temp_unidad ON tab_usuario.uni_id = temp_unidad.uni_id
			WHERE
			temp_unidad.uni_estado =  '2' AND
			tab_usuario.usu_id NOT IN
			(SELECT temp_personal.usu_id FROM temp_personal)";
        $row_cont = $tunidad->dbSelectBySQL($sql);
        if ($row_cont[0]->num > 0) {
            header("Location: " . PATH_DOMAIN . "/unidadPersonal/");
        } else {
            header("Location: " . PATH_DOMAIN . "/versionado/finalizar/");
        }
    }

    function loadPersonal() {
        $uni_origen = addslashes(html_entity_decode($_REQUEST['uni_origen'], ENT_QUOTES));
        $uni_destino = addslashes(html_entity_decode($_REQUEST['uni_destino'], ENT_QUOTES));
        //se carga el personal de la unidad eliminada
        $tpersonal = new personalTemp();
        echo json_encode($tpersonal->obtenerPersonal($uni_origen, $uni_destino, 2));
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
            if ($qtype == 'niv_codigo') {
                $qtype = "tem.niv_codigo";
                $query = substr($query, 0, 2);
                $where = " AND $qtype LIKE '%$query%' ";
            } elseif ($qtype == 'tem_uni_recibidas_cod') {
                $where = " AND tem.uni_id IN (SELECT tut.uni_destino FROM temp_unidad_trn tut
				INNER JOIN temp_unidad tu ON tu.uni_id = tut.origen
				WHERE tu.uni_codigo like '%$query%' )";
            } else {
                $where = " AND $qtype like '%$query%' ";
            }
        }
        $sql = "SELECT
				tem.uni_id,
				(SELECT niv_descripcion from tab_nivel WHERE niv_codigo=tem.niv_codigo) as
				niv_codigo,
				tem.uni_codigo,
				tem.uni_descripcion
				FROM
				temp_unidad AS tem
				WHERE uni_estado <> '2' $where $sort $limit ";

        $result = $this->unidad->dbselectBySQL($sql);
        $total = $unidad->countTodas($qtype, $query);
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
            $json .= "id:'" . $un->uni_id . "',";
            $json .= "cell:['" . $un->uni_id . "'";
            $json .= ",'" . addslashes($un->niv_codigo) . "'";
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

    function llenarLinks() {

        $this->registry->template->url_paso5 = "#";
        $this->registry->template->msg_paso5 = "";
        $this->registry->template->url_paso4 = "#";
        $this->registry->template->url_paso3 = "#";
        $this->registry->template->url_paso2 = "#";
        $this->registry->template->url_paso1 = PATH_DOMAIN . "/nivel/";
        if ($_SESSION['PASO'] == 4) {
            $this->registry->template->url_paso5 = PATH_DOMAIN . "/unidadPersonal/verifTransf/";
            $this->registry->template->msg_paso5 = ' onclick="return confirm(\'Desea Finalizar el proceso?\');"';
        }
        if ($_SESSION['PASO'] == 3) {
            $this->registry->template->url_paso4 = PATH_DOMAIN . "/versionado/nextPaso/";
        } elseif ($_SESSION['PASO'] > 3) {
            $this->registry->template->url_paso4 = PATH_DOMAIN . "/unidadPersonal/";
        }
        if ($_SESSION['PASO'] == 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/versionado/nextPaso/";
        } elseif ($_SESSION['PASO'] > 2) {
            $this->registry->template->url_paso3 = PATH_DOMAIN . "/unidadTabTemp/";
        }
        if ($_SESSION['PASO'] == 1) {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/versionado/nextPaso/";
        } else {
            $this->registry->template->url_paso2 = PATH_DOMAIN . "/unidad/";
        }
    }

}

?>
