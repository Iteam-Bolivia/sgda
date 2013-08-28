<?php

/**
 * progdesastresController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tablasparametricasController Extends baseController {

    protected $regActivo = "none";

    function index() {

        /* 	$tab = new Tab_tablas();
          $tablaCampo = $tab->obtenerTablas("");
          foreach($tablaCampo as $dato)
          {
          echo "<br> ".$dato["tabla"]."->act =".$dato["activo"]." ->inac=".$dato["inactivo"]." -> total =".$dato["total"];
          }
         */
        $this->registry->template->des_id = "";
        $this->registry->template->dpr_id = "<option value='1'>TEST</option>";
        $this->registry->template->des_resumen = "";
        $this->registry->template->des_indicador = "";
        $this->registry->template->des_fuentes = "";
        $this->registry->template->des_riesgo = "";
        $this->registry->template->des_usu_reg = "";
        $this->registry->template->des_fecha_reg = "";
        $this->registry->template->des_usu_mod = "";
        $this->registry->template->des_fecha_mod = "";
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        // REVISED: ARSENIO
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_tablasg.tpl');
        $this->registry->template->show('footer');
    }

    function edit() {

        Header("Location: " . PATH_DOMAIN . "/tablasparametricas/view/" . VAR3 . "/" . $_REQUEST["campo_id"] . "/");
    }

    function view() {
        

        $campoTabla = VAR3;
        $this->tabla = new db();
        $this->tabla->setRequest2Object($_REQUEST);
        $tab = new Tab_tablas();

        $result = $tab->obtenerCampos($campoTabla);

        $row = $this->tabla->dbSelectBySQL("select * from " . $campoTabla . " where " . $result[0]['field'] . "='" . VAR4 . "' ");
        //dbselectByField($result[0]['Field'], VAR4);
        //echo $result[0]['Field'];
        if (!empty($row))
            $camposTable = $tab->generarCamposInput($result, $row[0]);
        else
            $camposTable = $tab->generarCamposInput($result);
        $this->registry->template->nombreTabla = $campoTabla;

        $this->registry->template->campo1 = $result[0]['field'];
        $this->registry->template->cuerpoCampos = $camposTable;
        $this->registry->template->tituloTabla = "Registro " . $campoTabla;
        $this->registry->template->campo_id = VAR4;


        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tablas.tpl');
        $this->registry->template->show('footer');
    }

    function viewTabla() {
        $tab = new Tab_tablas();
        $result = $tab->obtenerCamposField(substr(VAR3, 3, strlen(VAR3)));
        $model = "";
        foreach ($result as $campo) {
            $model .="{display: '" . $campo . "', name : '" . $campo . "', width : 50, sortable : true, align: 'left'},";
        }
        $model = substr($model, 0, -1);
        $this->registry->template->displayColModel = $model;

        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);

        $resultado = pg_query($link, "select * from tab_menu");
        $i = 0;
        while ($un = pg_fetch_array($resultado)) {
            $id[$i] = $un[0];
        }
        if (VAR4) {

            if (VAR4 == "true") {
                $this->regActivo = "true";
                $estadoReg = ", registros ACTIVOS";
            } elseif (VAR4 == "false") {
                $this->regActivo = "false";
                $estadoReg = ", registros INACTIVOS";
            }
            else
                $estadoReg = "";
        }
        else
            $estadoReg = "";
        $this->registry->template->estadoRegistro = $estadoReg;
        $this->registry->template->campo1 = $result[0];
        $estado = $tab->buscarCampoEstado(substr(VAR3, 3, strlen(VAR3)));
        $this->registry->template->campoEstado = $estado;
        $this->registry->template->activo = $this->regActivo;
        $this->registry->template->nombreTabla = substr(VAR3, 3, strlen(VAR3));

        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tablasg.tpl');
        $this->registry->template->show('footer');
    }

    function loadTabla() {


        $tab = new Tab_tablas();
        $tab->setRequest2Object($_REQUEST);

        $resultCampos = $tab->obtenerCamposField(VAR3);
        $tabla = VAR3;
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = $_REQUEST['campo_id'];
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        // MODIFIED: CASTELLON
        $limit = "LIMIT $rp OFFSET $start ";
        //
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        $estado = $tab->buscarCampoEstado(VAR3);
        if ($query) {
            if (strtoupper($query) == "VER ACTIVOS")
                $where = " WHERE $estado ='1' ";
            elseif (strtoupper($query) == "VER INACTIVOS")
                $where = " WHERE $estado !='1' ";
            elseif (strtoupper($query) == "VER TODOS")
                $where = "";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * FROM $tabla $where $sort $limit ";
        }else {
            if (VAR4 == "true") {
                if ($estado != null)
                    $query2 = "Where $estado = '1' ";
                else
                    $query2 = "";
            }
            elseif (VAR4 == "false") {
                if ($estado != null)
                    $query2 = "Where $estado != '1' ";
                else
                    $query2 = "";
            }
            else
                $query2 = "";

            $sql = "SELECT * FROM " . $tabla . " " . $query2 . " $sort $limit";
            //print_r($sql);
        }

        $total = $tab->countField($tabla, $qtype, $query);
        //$this->tablas->count("des_estado",1);
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
        $i = 1;
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);
        $resultado = pg_query($link, $sql);
        while ($un = pg_fetch_array($resultado)) {
            //print_r($un);
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un[0] . "',";
            $json .= "cell:['" . $un[0] . "'";
            for ($x = 1; $x <= count($resultCampos) - 1; $x++) {
                $json .= ",'" . addslashes(utf8_encode($un[$x])) . "'";
            }

            $json .= "]}";
            $rc = true;
            $i++;
        }
        pg_close($link);
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function load() {


        $tablas = new db();
        $tablas->setRequest2Object($_REQUEST);

        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'des_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        // MODIFIED: CASTELLON
        $limit = "LIMIT $rp OFFSET $start";
        //
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        $where = "";
        $tab = new Tab_tablas();
        $result = $tab->obtenerTablas("");

        $total = count($result);
        //$this->tablas->count("des_estado",1);
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
        $i = 1;
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un["tabla"] . "',";
            $json .= "cell:['" . $i . "'";
            $json .= ",'" . addslashes(utf8_encode($un["tabla"])) . "'";
            $json .= ",'" . addslashes($un["activo"]) . "'";
            $json .= ",'" . addslashes($un["inactivo"]) . "'";
            $json .= ",'" . addslashes($un["total"]) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function add() {

        $tab = new Tab_tablas();
        $result = $tab->obtenerCampos(VAR3);
        //$row = $this->tabla->dbselectByField($result[0]['Field'], VAR4);
        //$camposTable = $tab->generarCamposInput($result,$row[0]);
        $camposTable = $tab->generarCamposInput($result);
        $this->registry->template->nombreTabla = VAR3;
        $this->registry->template->tituloTabla = "Registro de la tabla " . VAR3;
        $this->registry->template->campo_id = "";

        $this->registry->template->cuerpoCampos = $camposTable;
        $this->registry->template->des_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tablas.tpl');
        $this->registry->template->show('footer');
    }

    function save() {

        $this->dbb = new db();
        $this->dbb->setRequest2Object($_REQUEST);
        $nombreTabla = $_REQUEST['nombreTabla'];

        $tab = new Tab_tablas();
        $result = $tab->obtenerCamposField($nombreTabla);
        $values = "";
        foreach ($result as $field) {
            if ($_REQUEST[$field] == '') {
                $values .=" NULL,";
            } else {
                $values .=" '" . $_REQUEST[$field] . "' ,";
            }
        }
        //print_r ($values);die;
        $values = substr($values, 0, -1);
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);

        $resultado = pg_query($link, "insert into " . $nombreTabla . " values (" . $values . ")");
        //print_r($resultado);
        pg_close($link);
        Header("Location: " . PATH_DOMAIN . "/tablasparametricas/viewTabla/row" . $nombreTabla . "/");
    }

    function update() {
        $nombreTabla = $_REQUEST['nombreTabla'];
        $tab = new Tab_tablas();
        $result = $tab->obtenerCamposField($nombreTabla);
        //print_r ($result);die;
        $values = "";
        foreach ($result as $field) {

            //(strstr ( $field, "fecha" ))AND
            if ($_REQUEST[$field] == '') {
                $values .=" " . $field . "= NULL,";
            } else {
                $values .=" " . $field . "='" . $_REQUEST[$field] . "',";
            }
        }
        //print_r ($values);die;
        $values = substr($values, 0, -1);
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);
        $resultado = pg_query("UPDATE " . $nombreTabla . " SET " . $values . " where " . $result[0] . "='" . $_REQUEST[$result[0]] . "' ");
        pg_close($link);
        Header("Location: " . PATH_DOMAIN . "/tablasparametricas/viewTabla/row" . $_REQUEST['nombreTabla'] . "/");
    }

    function delete() {
        $tabla = new Tab_tablas();
        $result = $tabla->obtenerCamposField(VAR3);
        $estado = $tabla->buscarCampoEstado(VAR3);
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);
        $resultado = pg_query($link, "UPDATE " . VAR3 . " SET  " . $estado . "='2'  WHERE " . $result[0] . " = " . $_REQUEST['campo_id']);
        //print_r($resultado);
        pg_close($link);

        /* $this->progdesastres = new tab_progdesastres();
          $this->progdesastres->setRequest2Object($_REQUEST);

          $this->progdesastres->setDes_id($_REQUEST['des_id']);
          $this->progdesastres->setDes_estado(2);
         */

        return false;
        //$this->progdesastres->update();
    }

    function filtrarActivo() {

        $tabla = new Tab_tablas();
        $result = $tabla->obtenerCamposField(VAR3);
        $estado = $tabla->buscarCampoEstado(VAR3);
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);
        $resultado = pg_query($link, "SELECT * FROM " . VAR3 . "  WHERE  " . $estado . "='1' ");
        print_r($resultado);
        pg_close($link);
    }

    function filtrarInactivo() {

        $tabla = new Tab_tablas();
        $result = $tabla->obtenerCamposField(VAR3);
        $estado = $tabla->buscarCampoEstado(VAR3);
        $link = pg_connect('host=' . PGHOST . ' port=' . PGPORT . ' dbname=' . PGDATABASE . ' user=' . PGUSER . ' password=' . PGPASSWORD);
        //mysql_select_db(PATH_DBNAME);
        $resultado = pg_query($link, "SELECT * FROM " . VAR3 . "  WHERE  " . $estado . "='2' ");
        //print_r($resultado);
        pg_close($link);
    }

}

?>
