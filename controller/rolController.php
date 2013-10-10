<?php

/**
 * rolController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class rolController extends baseController {

    function index() {
        $this->registry->template->rol_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_rolg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $rol = new rol();
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'rol_id';
        if (!$sortorder)
            $sortorder = 'desc';
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
        if ($query) {
            if ($qtype == 'rol_id')
                $where = " WHERE $qtype = '$query' ";
            else
                $where = " WHERE $qtype LIKE '%$query%' ";
            $sql = "SELECT * 
                    FROM tab_rol 
                    $where AND
                    rol_estado = 1 $sort $limit ";
        } else {
            $sql = "SELECT * 
                    FROM tab_rol 
                    WHERE rol_estado = 1 $sort $limit ";
        }
        $result = $this->rol->dbselectBySQL($sql);
        $total = $rol->count($qtype, $query);
        
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
            $json .= "id:'" . $un->rol_id . "',";
            $json .= "cell:['" . $un->rol_id . "'";
            $json .= ",'" . addslashes($un->rol_cod) . "'";
            $json .= ",'" . addslashes($un->rol_titulo) . "'";
            $json .= ",'" . addslashes($un->rol_descripcion) . "'";            
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function add() {
        $this->fondo = new fondo ();
        $this->registry->template->titulo = "NUEVO ROL DE USUARIO";
        $this->registry->template->rol_id = "";
        $this->registry->template->rol_titulo = "";
        $this->registry->template->rol_descripcion = "";
        $this->registry->template->rol_cod = "";
        $this->registry->template->fon_id = $this->fondo->obtenerSelectFondos();

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->LIST_MENU = $this->menu->allMenu();
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rol.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        
        $this->rol = new tab_rol ();
        $this->fondo = new tab_fondo ();
        $this->menu = new Tab_menu ();
        $this->usurolmenu = new Tab_usurolmenu ();

        $this->rol->setRequest2Object($_REQUEST);
        $this->rol->setRol_cod($_REQUEST ['rol_cod']);
        $this->rol->setRol_titulo($_REQUEST ['rol_titulo']);
        $this->rol->setRol_descripcion($_REQUEST ['rol_descripcion']);
        $this->rol->setRol_estado(1);
        $idRol = $this->rol->insert();

        $arrayD = $_POST ["id_menu"];
        foreach ($arrayD as $id) {
            if (isset($_POST [$id])) {
                $sw1 = 0;
                $sw2 = 0;
                $sw3 = 0;
                $sw4 = 0;
                $privilegio = "";

                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "ver")
                        $sw1 = 1;
                }
                if ($sw1 == 1) {
                    $privilegio .= "1";
                } else {
                    $privilegio .= "0";
                }
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "add")
                        $sw2 = 1;
                }
                if ($sw2 == 1) {
                    $privilegio .= "1";
                } else {
                    $privilegio .= "0";
                }
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "del")
                        $sw3 = 1;
                }
                if ($sw3 == 1) {
                    $privilegio .= "1";
                } else {
                    $privilegio .= "0";
                }
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "rep")
                        $sw4 = 1;
                }
                if ($sw4 == 1) {
                    $privilegio .= "1";
                } else {
                    $privilegio .= "0";
                }
                $menus = new Tab_menu();
                $row = $menus->dbSelectBySQL("SELECT men_par FROM tab_menu WHERE men_id='" . $id . "'"); // existe el padre
                if (count($row)) {// existe rol y el menu_Padre
                    $row2 = $menus->dbSelectBySQL("SELECT rol_id FROM tab_usurolmenu WHERE rol_id ='" . $idRol . "' AND men_id='" . $row[0]->men_par . "'");
                    if (count($row2)) {
                        $print = "ya existe padre";
                    } else {
                        $rolmenu = new Tab_usurolmenu();
                        $rolmenu->setRol_id($idRol);
                        $rolmenu->setMen_id($row[0]->men_par);
                        $rolmenu->setUrm_privilegios("1111");
                        $rolmenu->setUrm_estadom($row[0]->men_estado);
                        $rolmenu->setUrm_estado(1);
                        $rolmenu->insert();
                    }
                }
                $this->usurolmenu->setRol_id($idRol);
                $this->usurolmenu->setMen_id($id);
                $this->usurolmenu->setUrm_privilegios($privilegio);
                $this->usurolmenu->setUrm_estado(1);
                $this->usurolmenu->insert();
            }
        }// fin foreach

        //$this->usurolmenu->insert();
        Header("Location: " . PATH_DOMAIN . "/rol/");
    }
    
    function edit() {
        Header("Location: " . PATH_DOMAIN . "/rol/view/" . $_REQUEST ["rol_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $row = $this->rol->dbselectByField("rol_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row [0];
        $this->registry->template->titulo = "EDITAR ROL DE USUARIO";
        $this->registry->template->rol_id = $row->rol_id;
        $this->registry->template->rol_titulo = $row->rol_titulo;
        $this->registry->template->rol_descripcion = $row->rol_descripcion;
        $this->registry->template->rol_cod = $row->rol_cod;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery";

        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->LIST_MENU = $this->menu->allMenuSeleccionado($row->rol_id);
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_rol.tpl');
        $this->registry->template->show('footer');
    }



    function update() {
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $this->rol->setRol_id($_REQUEST ['rol_id']);
        $this->rol->setRol_titulo($_REQUEST ['rol_titulo']);
        $this->rol->setRol_descripcion($_REQUEST ['rol_descripcion']);
        $this->rol->setRol_cod($_REQUEST ['rol_cod']);
        $this->rol->setRol_fecha_mod(date("Y-m-d"));
        $this->rol->setRol_usuario_mod($_SESSION ['USU_ID']);
        $this->rol->update();

        $darBaja = new Tab_usurolmenu();
        $darBaja->updateValueOneWhere("urm_estado", 2, "rol_id", $_REQUEST ['rol_id'], " AND urm_estadom <> 0 ");

        $this->usurolmenu = new tab_usurolmenu ();
        $this->usurolmenu->setRequest2Object($_REQUEST);
        $arrayD = $_REQUEST['id_menu'];

        foreach ($arrayD as $id) {

            $privilegio = "";
            $num = "";
            if (isset($_POST [$id])) {
                $sw1 = 0;
                $sw2 = 0;
                $sw3 = 0;
                $sw4 = 0;
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "add")
                        $sw2 = 1;
                }
                if ($sw2 == 1) {
                    $num .= "1";
                } else {
                    $num .= "0";
                }
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "del")
                        $sw3 = 1;
                }
                if ($sw3 == 1) {
                    $num .= "1";
                } else {
                    $num .= "0";
                }
                foreach ($_POST [$id] as $cont => $val) {
                    if ($_POST [$id] [$cont] == "rep")
                        $sw4 = 1;
                }
                if ($sw4 == 1) {
                    $num .= "1";
                } else {
                    $num .= "0";
                }
                if ($num > 0)
                    $privilegio = "1" . $num;
                else {
                    foreach ($_POST [$id] as $cont => $val) {
                        if ($_POST [$id] [$cont] == "ver")
                            $sw1 = 1;
                    }
                    if ($sw1 == 1) {
                        $privilegio = "1" . $num;
                    } else {
                        $privilegio = "0000";
                    }
                }


                $existeDato = $this->usurolmenu->dbSelectBySQL("SELECT * FROM tab_usurolmenu WHERE tab_usurolmenu.rol_id = '" . $_REQUEST ['rol_id'] . "' AND tab_usurolmenu.men_id = '" . $id . "' ");
                if (count($existeDato)) {
                    $menus = new Tab_menu();
                    $idPadre = $menus->dbSelectBySQL("SELECT * FROM tab_menu WHERE men_id='" . $id . "'");
                    $rolmen = new Tab_usurolmenu();
                    $row2 = $rolmen->dbSelectBySQL("SELECT urm_id FROM tab_usurolmenu WHERE rol_id ='" . $_REQUEST ['rol_id'] . "' AND men_id='" . $idPadre[0]->men_par . "'");
                    if (count($row2) > 0) {
                        $rolmen = new Tab_usurolmenu();
                        $rolmen->setUrm_id($row2[0]->urm_id);
                        $rolmen->setUrm_estado(1);
                        $rolmen->update();
                    }
                    $row = $this->usurolmenu->dbSelectBySQL("SELECT * FROM tab_usurolmenu WHERE tab_usurolmenu.rol_id = '" . $_REQUEST ['rol_id'] . "' AND tab_usurolmenu.men_id = '" . $id . "' ");
                    $this->usurolmenu = new tab_usurolmenu ();
                    $this->usurolmenu->setUrm_id($row [0]->urm_id);
                    $this->usurolmenu->setRol_id($_REQUEST ['rol_id']);
                    $this->usurolmenu->setMen_id($id);
                    $this->usurolmenu->setUrm_privilegios($privilegio);
                    $this->usurolmenu->setUrm_estadom($idPadre[0]->men_estado);
                    $this->usurolmenu->setUrm_estado(1);
                    $this->usurolmenu->update();
                } else {
                    $men = new Tab_menu();
                    $idPadre = $men->dbSelectBySQL("SELECT men_id, men_par, men_estado FROM tab_menu where men_id='$id' ");
                    $rolmen = new Tab_usurolmenu();
                    $estaMenuPadre = $rolmen->dbSelectBySQL("SELECT urm_id FROM tab_usurolmenu WHERE rol_id ='" . $_REQUEST ['rol_id'] . "' AND men_id='" . $idPadre[0]->men_par . "'");
                    if (count($estaMenuPadre)) {
                        $rolmen = new Tab_usurolmenu();
                        $rolmen->setUrm_id($estaMenuPadre[0]->urm_id);
                        $rolmen->setUrm_estado(1);
                        $rolmen->update();
                    } else {
                        $rolmen = new Tab_usurolmenu();
                        $rolmen->setRol_id($_REQUEST ['rol_id']);
                        $rolmen->setMen_id($idPadre[0]->men_par);
                        $rolmen->setUrm_privilegios($privilegio);
                        $rolmen->setUrm_estadom($idPadre[0]->men_estado);
                        $rolmen->setUrm_estado(1);
                        $rolmen->insert();
                    }
                    $this->usurolmenu = new Tab_usurolmenu();
                    $this->usurolmenu->setRol_id($_REQUEST ['rol_id']);
                    $this->usurolmenu->setMen_id($id);
                    $this->usurolmenu->setUrm_privilegios($privilegio);
                    $this->usurolmenu->setUrm_estadom($idPadre[0]->men_estado);
                    $this->usurolmenu->setUrm_estado(1);
                    $this->usurolmenu->insert();
                }
            }// fin post
        }
        Header("Location: " . PATH_DOMAIN . "/rol/");
    }

    function delete() {
        $this->rol = new tab_rol ();
        $this->usurolmenu = new tab_usurolmenu ();
        $this->rol->setRequest2Object($_REQUEST);

        $this->rol->setRol_id($_REQUEST ['rol_id']);
        $this->rol->setRol_estado(2);
        $sql = "UPDATE tab_usurolmenu SET urm_estado='2' Where rol_id='" . $_REQUEST ['rol_id'] . "' ";
        $this->usurolmenu->dbselectBySQL($sql);
        $this->rol->update();
    }

    function findReg() {
        $this->rol = new tab_rol ();
        $this->rol->setRequest2Object($_REQUEST);
        $sql = "SELECT
                tab_rol.rol_id,
                tab_rol.rol_titulo
                FROM
                tab_rol
                Inner Join tab_usuario ON tab_rol.rol_id = tab_usuario.rol_id
                WHERE
                tab_rol.rol_id =  '" . $_REQUEST['rol_id'] . "'";
        $row = $this->rol->dbselectBySQL($sql);
        if (count($row)) {
            echo true;
        } else {
            echo false;
        }
    }
    function verifyFields() {
        $rol = new rol();
        $rol_cod = trim($_POST['rol_cod']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($rol->existeCodigo($rol_cod)) {
                echo 'El código ya existe, escriba otro.';
            }
            //if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
            //    echo 'El tamaño debe de ser igual a 2.';
            //} 
            else {
                echo '';
            }
            } else {
                echo '';
            }
        }
    function verifCodigo() {
        $rol = new rol();
        $rol->setRequest2Object($_REQUEST);
        $rol_cod = trim($_POST['rol_cod']);
        $Path_event = trim($_POST['Path_event']);
        if ($Path_event != 'update') {
            if ($rol->existeCodigo($rol_cod)) {
                echo 'El código ya existe, escriba otro.';
            }
//if (strlen($uni_codigo) < 2 || strlen($uni_codigo) > 2) {
//    echo 'El tamaño debe de ser igual a 2.';
//} 
            else {
                echo '';
            }
        } else {
            echo '';
        }
    }
}
?>
