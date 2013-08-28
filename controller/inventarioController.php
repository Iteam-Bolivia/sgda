<?php

/**
 * archivoController
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class inventarioController Extends baseController {

    function index() {
        $this->registry->template->usu_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;

        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_inventariog.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $inventario = new inventario();
        $this->inventario = new tab_inventario();
        $this->inventario->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'usu_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15; //10
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start";
        $query = $_REQUEST['query'];
        $qtype = $_REQUEST['qtype'];
        
        $where = "";
        if ($query) {
            if ($qtype == 'inv_id')
                $where = " AND I.inv_id = '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " AND tab_series.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'exp_nombre')
                $where = " AND tab_expediente.exp_nombre LIKE '%$query%' ";
            elseif ($qtype == 'exp_codigo')
                $where = " AND tab_expediente.exp_codigo LIKE '%$query%' ";
            elseif ($qtype == 'uni_codigo')
                $where = " AND tab_unidad.uni_codigo LIKE '%$query%' ";
//            elseif ($qtype == 'contenedor')
//                $where = " AND tab_expediente.exp_id IN (SELECT ee.exp_id  
//                        FROM tab_expediente AS ee
//                        Inner Join tab_expcontenedor AS ec ON ee.exp_id = ec.exp_id
//                        Inner Join tab_contenedor AS c ON c.con_id = ec.con_id
//                        Inner Join tab_rol_codcontenedor AS t ON t.ctp_id = c.ctp_id
//                        WHERE
//                        ec.exc_estado =  '1' 
//                        AND t.ctp_nivel =  '1' 
//                        AND c.con_estado =  '1' 
//                        AND (t.ctp_codigo LIKE '%$query%' OR c.con_codigo LIKE '%$query%') ) ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

        
        
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_expediente.exp_id,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                tab_expfondo.exf_fecha_exf,
                tab_expediente.exp_nrocaj,
                tab_expediente.exp_sala,
                tab_expediente.exp_estante,
                tab_expediente.exp_cuerpo,
                tab_expediente.exp_balda,
                tab_series.ser_categoria,
                tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos
                FROM
                tab_expediente
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                INNER JOIN tab_series ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                WHERE tab_expediente.exp_estado = '1' 
                AND tab_expusuario.eus_estado = '1'                 
                AND tab_expfondo.exf_estado = '1' 
                AND tab_usuario.usu_id = $_SESSION ['USU_ID']
                $where $sort $limit ";

        $result = $this->inventario->dbselectBySQL($sql);
        $inventario = new inventario();
        $total = $inventario->count($where);
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
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->exp_id . "',";
            $json .= "cell:['" . $un->exp_id . "'";
            $json .= ",'" . addslashes($un->fon_cod) . "'";
            $json .= ",'" . addslashes($un->uni_cod) . "'";
            $json .= ",'" . addslashes($un->tco_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_codigo) . "'";
//            $json .= ",'" . addslashes($un->inv_nitidez_escritura) . "'";
//            $json .= ",'" . addslashes($un->contenedor) . "'";
//            $json .= ",'" . addslashes($un->exf_fecha_exf) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    function loadExp() {
        $this->expediente = new tab_expediente ();
        $this->expediente->setRequest2Object($_REQUEST);
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
        if ($query) {
            if ($qtype == 'exp_id')
                $where = " AND te.$qtype = '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " AND ts.ser_categoria LIKE '%$query%' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        
        
        $institucion = new institucion();
        $ins_fondo = $institucion->getFondoUsu($_SESSION['USU_ID']);

        $where .= " AND un.ins_id = '$ins_fondo->ins_id' ";
        $where .= "  AND te.exp_id NOT IN(SELECT i.exp_id FROM tab_inventario i
                     WHERE i.inv_estado ='1' AND i.exp_id=te.exp_id )";

        $rol_cod = $_SESSION['ROL_COD'];
        if ($rol_cod == 'SUBF') {
            $where .= " AND ef.fon_id='2' ";
        } elseif ($rol_cod == 'ACEN') {
            $where .= " AND ef.fon_id='3' ";
        } else {
            $where .= " AND ef.fon_id='2' ";
        }

        $sql = "SELECT DISTINCT
            te.exp_id,
            te.exp_nombre,
            te.exp_descripcion,
            te.exp_codigo,
            ts.ser_categoria,
            ef.exf_fecha_exi,
            ef.exf_fecha_exf,
            ef.fon_id
            FROM
            tab_expediente AS te
            Inner Join tab_expusuario AS eu ON eu.exp_id = te.exp_id
            Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
            Inner Join tab_usuario AS tu ON eu.usu_id = tu.usu_id
            Inner Join tab_unidad AS un ON tu.uni_id = un.uni_id
            Inner Join tab_expfondo AS ef ON ef.exp_id = te.exp_id
            WHERE
            eu.eus_estado =  '1' 
            AND te.exp_estado =  '1' 
            AND ef.exf_estado =  '1' $where $sort $limit ";
        //print $sql;die;
        $expediente = new expediente();
        $result = $this->expediente->dbselectBySQL($sql);
        $total = $expediente->countPorFondo($where);
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
            $json .= ",'" . addslashes($un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_nombre) . "'";
            $json .= ",'" . addslashes($un->exp_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function edit() {
        Header("Location: " . PATH_DOMAIN . "/inventario/view/" . $_REQUEST["inv_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->inventario = new tab_inventario();
        $this->inventario->setRequest2Object($_REQUEST);
        $row = $this->inventario->dbSelectBySQL("SELECT * 
                                                 FROM tab_inventario 
                                                 WHERE inv_id='" . VAR3 . "' ");
        if(! $row){ die("Error del sistema 404"); }

        if (!count($row))
            Header("Location: " . PATH_DOMAIN . "/inventario/");
        $row = $row[0];
        $this->registry->template->inv_id = $row->inv_id;

        $this->expediente = new tab_expediente();
        $rows = $this->expediente->dbSelectBySQL("SELECT * 
                                                  FROM tab_expediente 
                                                  WHERE exp_id='" . $row->exp_id . "' ");
        if (count($rows))
            $nombreExp = $rows[0]->exp_nombre;
        else
            $nombreExp = "";


        $contenedor = new contenedor();
        $this->contenedor = new tab_contenedor();
        $this->usuario = new Tab_usuario();
        $this->rol = new Tab_rol();
        $expCont = $this->contenedor->dbSelectBySQL("SELECT 
                                                    ec.exp_id,
                                                    ec.con_id 
                                                    FROM tab_expcontenedor ec
                                                    WHERE ec.exc_estado='1' 
                                                    AND ec.exp_id=" . $row->exp_id . " ");
        if (count($expCont)) {
            $expConId = $expCont[0]->con_id;
        } else {
            $expConId = "";
        }

        $usuario = new usuario();
        $unidad = new unidad();
        $inst_fondo = new institucion();
        $fondo = $inst_fondo->getFondoUsu($_SESSION['USU_ID']);
        $this->rol = $_SESSION['ROL_COD'];
        $optionCon = $contenedor->loadSelectInstFondo($fondo->inl_id, $this->rol, $expConId);
        $this->registry->template->con_id = $optionCon;
        $this->registry->template->exp_id = $row->exp_id;
        $this->registry->template->exp_nombre = $nombreExp;
        $this->registry->template->inv_orden = $fondo->inl_id;
        /*  $unidad=  new unidad();
          $datos = $unidad->dameDatosUnidad($row->inv_unidad);
          /*if(count($datos)) 	$nombreUn = $datos->uni_descripcion;
          else  				$nombreUn = "";
          $this->registry->template->inv_unidad = $nombreUn; */
        $this->registry->template->inv_pieza = $row->inv_pieza;
        $this->registry->template->inv_ml = $row->inv_ml;
        $this->registry->template->inv_titulo = $row->inv_titulo;
        $this->registry->template->inv_tomo = $row->inv_tomo;
        $this->registry->template->inv_nom_productor = $row->inv_nom_productor;
        $this->registry->template->inv_caract_fisica = $row->inv_caract_fisica;
        $this->registry->template->inv_obs = $row->inv_obs;
        $this->registry->template->inv_condicion_papel = $this->condicionPapel($row->inv_condicion_papel);
        $this->registry->template->inv_nitidez_escritura = $this->nitidezPapel($row->inv_nitidez_escritura);
        $this->registry->template->inv_analisis_causa = $row->inv_analisis_causa;
        $this->registry->template->inv_accion_curativa = $row->inv_accion_curativa;
        $this->expediente = new tab_expediente();
        $exf_fecha_exf = "";
        $rows = $this->expediente->dbSelectBySQL("SELECT * 
                                                  FROM tab_expfondo 
                                                  WHERE exp_id='" . $row->exp_id . "' 
                                                  AND exf_estado = '1' ");
        if (count($rows)) {
            $exf_fecha_exf = $rows[0]->exf_fecha_exf;
        }

        $this->registry->template->exf_fecha_exf = $exf_fecha_exf;

        /* $expUsu = $this->usuario->dbSelectBySQL("SELECT eu.exp_id, eu.usu_id FROM tab_expusuario eu
          where eu.exp_id=".VAR3." AND  eu.eus_estado='1' ");
          $expUsu = $expUsu[0]->usu_id;
          $this->registry->template->usu_id = $expUsu; */

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery";
        
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_inventario.tpl');
        $this->registry->template->show('footer');
    }

    function add() {
        $this->expediente = new tab_expediente();
        $rows = $this->expediente->dbSelectBySQL("SELECT * 
                                                  FROM tab_expediente 
                                                  WHERE exp_id ='" . VAR3 . "' 
                                                  AND exp_id NOT IN (SELECT i.exp_id FROM tab_inventario i WHERE i.inv_estado = '1' ");
        if (count($rows)) {
            $nombreExpediente = $rows[0]->exp_nombre;
        }
        else
            Header("Location: " . PATH_DOMAIN . "/inventario/");

        $contenedor = new contenedor();
        $this->contenedor = new tab_contenedor();
        $this->usuario = new Tab_usuario();
        $this->rol = new Tab_rol();
        $expCont = $this->contenedor->dbSelectBySQL("SELECT 
                                                    ec.exp_id,
                                                    ec.con_id 
                                                    FROM tab_expcontenedor ec
                                                    WHERE ec.exc_estado='1' 
                                                    AND ec.exp_id=" . VAR3 . " ");
        /* $expUni = $this->unidad->dbSelectBySQL("SELECT euv.euv_id, euv.exp_id, euv.uni_id FROM tab_expunidad euv
          where euv.exp_id=".VAR3." AND  euv.euv_estado='1' ");
          $expUni = $expUni[0]->uni_id; */
        if (count($expCont)) {
            $expConId = $expCont[0]->con_id;
        } else {
            $expConId = "";
        }
        $inst_fondo = new institucion();
        $fondo = $inst_fondo->getFondoUsu($_SESSION['USU_ID']);
        $this->rol = $_SESSION['ROL_COD'];
        $optionCon = $contenedor->loadSelectInstFondo($fondo->inl_id, $this->rol);
        $this->registry->template->inv_id = "";
        $this->registry->template->con_id = $optionCon;
        $this->registry->template->exp_id = VAR3;
        $this->registry->template->exp_nombre = $nombreExpediente;
        $this->registry->template->inv_orden = $fondo->inl_id;
        //$this->registry->template->inv_unidad = "<select name='inv_unidad' id='inv_unidad' class='required' title='Unidad de Procedencia'><option value =''>-Seleccionar-</option>".$unidad->listUnidad("")."</select>";
        $this->registry->template->inv_pieza = "1";
        $this->registry->template->inv_ml = "0.1";
        $this->registry->template->inv_tomo = "";
        $expUsu = $this->usuario->dbSelectBySQL("SELECT 
                                                eu.exp_id, 
                                                eu.usu_id, 
                                                u.usu_nombres, 
                                                u.usu_apellidos
                                                FROM tab_expusuario eu
                                                INNER JOIN tab_usuario u ON u.usu_id = eu.usu_id
                                                WHERE eu.exp_id=" . VAR3 . " 
                                                AND  eu.eus_estado='1' ");
        $expUsu = $expUsu[0];
        //$this->registry->template->usu_id = $expUsu;
        $this->registry->template->inv_nom_productor = $expUsu->usu_nombres . " " . $expUsu->usu_apellidos;
        $this->registry->template->inv_caract_fisica = "";
        $this->registry->template->inv_obs = "";
        $this->registry->template->inv_condicion_papel = $this->condicionPapel("BUENO");
        $this->registry->template->inv_nitidez_escritura = $this->nitidezPapel("LEGIBLE");
        $this->registry->template->inv_analisis_causa = "";
        $this->registry->template->inv_accion_curativa = "";
        $this->registry->template->exf_fecha_exf = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->FORM_SW = "";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_inventario.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->inventario = new tab_inventario();
        $this->inventario->setRequest2Object($_REQUEST);

        $this->expediente = new tab_expediente();
        $rows = $this->expediente->dbSelectBySQL("SELECT * 
                                                  FROM tab_expediente 
                                                  WHERE exp_id ='" . $_REQUEST['exp_id'] . "' ");
        $nombreExpediente = $rows[0]->exp_nombre;

        $this->inventario->setInv_id($_REQUEST['inv_id']);
        $this->inventario->setExp_id($_REQUEST['exp_id']);
        $this->inventario->setInv_orden($_REQUEST['inv_orden']);
        //$this->inventario->setInv_unidad($_REQUEST['inv_unidad']);
        $this->inventario->setInv_pieza($_REQUEST['inv_pieza']);
        $this->inventario->setInv_ml($_REQUEST['inv_ml']);
        $this->inventario->setInv_titulo($nombreExpediente);
        $this->inventario->setInv_tomo($_REQUEST['inv_tomo']);
        $this->inventario->setInv_nom_productor($_REQUEST['inv_nom_productor']);
        $this->inventario->setInv_caract_fisica($_REQUEST['inv_caract_fisica']);
        $this->inventario->setInv_obs($_REQUEST['inv_obs']);
        $this->inventario->setInv_condicion_papel($_REQUEST['inv_condicion_papel']);
        $this->inventario->setInv_nitidez_escritura($_REQUEST['inv_nitidez_escritura']);
        $this->inventario->setInv_analisis_causa($_REQUEST['inv_analisis_causa']);
        $this->inventario->setInv_accion_curativa($_REQUEST['inv_accion_curativa']);
        $exp_id = $_REQUEST['exp_id'];
        $this->usuario = new tab_expusuario();
        $this->unidad = new Tab_expunidad();
        $expUsu = $this->usuario->dbSelectBySQL("SELECT 
                                                 eu.eus_id, 
                                                 eu.exp_id, 
                                                 eu.usu_id 
                                                 FROM tab_expusuario eu
                                                 WHERE eu.exp_id=" . $exp_id . " 
                                                 AND  eu.eus_estado='1' ");
        $expUsu = $expUsu[0]->usu_id;
        $expUni = $this->unidad->dbSelectBySQL("SELECT 
                                                euv.euv_id, 
                                                euv.exp_id, 
                                                euv.uni_id 
                                                FROM tab_expunidad euv
                                                WHERE euv.exp_id=" . $exp_id . " 
                                                AND  euv.euv_estado='1' ");
        $expUni = $expUni[0]->uni_id;
        $this->inventario->setUsu_id($expUsu);
        $this->inventario->setUni_id($expUni);
        $this->inventario->setInv_fecha_reg(date("Y-m-d"));
        $this->inventario->setInv_estado(1);
        $this->inventario->insert();

        $exf = new tab_expfondo();
        $rows = $exf->dbSelectBySQL("SELECT * 
                                    from tab_expfondo 
                                    WHERE exp_id ='" . $_REQUEST['exp_id'] . "' 
                                    AND exf_estado = '1' ");
        $expfondo = new tab_expfondo();
        $expfondo->exf_id = $rows[0]->exf_id;
        $expfondo->exf_fecha_exf = $_REQUEST['exf_fecha_exf'];
        $expfondo->update();

        if (isset($_REQUEST['con_id']) && $_REQUEST['con_id'] != '') {
            $con_id = $_REQUEST['con_id'];
            $contenedor = new contenedor();
            $contenedor->updateContenedor($exp_id, $con_id);
        }

        Header("Location: " . PATH_DOMAIN . "/inventario/");
    }

    function update() {
        $this->inventario = new tab_inventario();
        $this->inventario->setRequest2Object($_REQUEST);
        $this->inventario->setInv_id($_REQUEST['inv_id']);
        $this->inventario->setExp_id($_REQUEST['exp_id']);
        $this->inventario->setInv_orden($_REQUEST['inv_orden']);
        $this->inventario->setInv_pieza($_REQUEST['inv_pieza']);
        $this->inventario->setInv_ml($_REQUEST['inv_ml']);
        $this->inventario->setInv_tomo($_REQUEST['inv_tomo']);
        $this->inventario->setInv_nom_productor($_REQUEST['inv_nom_productor']);
        $this->inventario->setInv_caract_fisica($_REQUEST['inv_caract_fisica']);
        $this->inventario->setInv_obs($_REQUEST['inv_obs']);
        $this->inventario->setInv_condicion_papel($_REQUEST['inv_condicion_papel']);
        $this->inventario->setInv_nitidez_escritura($_REQUEST['inv_nitidez_escritura']);
        $this->inventario->setInv_analisis_causa($_REQUEST['inv_analisis_causa']);
        $this->inventario->setInv_accion_curativa($_REQUEST['inv_accion_curativa']);
        $this->inventario->setInv_fecha_mod(date("Y-m-d"));
        $this->inventario->setInv_usu_mod($_SESSION['USU_ID']);

        $exp_id = $_REQUEST['exp_id'];
        $this->expusuario = new tab_expusuario();
        $this->unidad = new Tab_expunidad();
        $expUsu = $this->expusuario->dbSelectBySQL("SELECT 
                                                    eu.eus_id, 
                                                    eu.exp_id, 
                                                    eu.usu_id 
                                                    FROM tab_expusuario eu
                                                    WHERE eu.exp_id=" . $exp_id . " 
                                                    AND  eu.eus_estado='1' ");
        if (count($expUsu) > 0) {
            $expUsu = $expUsu[0]->usu_id;
        } else {
            $expUsu = 0;
        }

        $expUni = $this->unidad->dbSelectBySQL("SELECT 
                                                euv.euv_id, 
                                                euv.exp_id, euv.uni_id 
                                                FROM tab_expunidad euv
                                                WHERE euv.exp_id=" . $exp_id . " 
                                                AND  euv.euv_estado='1' ");
        if (count($expUni) > 0) {
            $expUni = $expUni[0]->uni_id;
        } else {
            $expUni = 0;
        }

        $this->inventario->setUsu_id($expUsu);
        $this->inventario->setUni_id($expUni);
        $this->inventario->update();
        $this->inventario->updateValueTwo("inv_analisis_causa", $_REQUEST['inv_analisis_causa'], "inv_accion_curativa", $_REQUEST['inv_accion_curativa'], $_REQUEST['inv_id']);

        $exf = new tab_expfondo();
        $rows = $exf->dbSelectBySQL("SELECT * 
                                    FROM tab_expfondo 
                                    WHERE exp_id ='" . $_REQUEST['exp_id'] . "' 
                                    AND exf_estado = '1' ");

        $expfondo = new tab_expfondo();
        $expfondo->exf_id = $rows[0]->exf_id;
        $expfondo->exf_fecha_exf = $_REQUEST['exf_fecha_exf'];
        $expfondo->update();

        if (isset($_REQUEST['con_id']) && $_REQUEST['con_id'] != '') {
            $con_id = $_REQUEST['con_id'];
            $contenedor = new contenedor();
            $contenedor->updateContenedor($exp_id, $con_id);
        }

        Header("Location: " . PATH_DOMAIN . "/inventario/");
    }

    function delete() {
        $this->inventario = new tab_inventario();
        $this->inventario->setRequest2Object($_REQUEST);
        $this->inventario->setInv_id($_REQUEST['inv_id']);
        $this->inventario->setInv_estado(2);
        $this->inventario->update();
    }

    function condicionPapel($default) {
        $cp = array("BUENO", "ARRUGADO", "HUMEDO", "ENSARRADO", "ROTO", "CARCOMIDO");
        $option = "";
        foreach ($cp as $condicionP) {
            if ($condicionP == $default)
                $select = "selected";
            else
                $select = "";
            $option .="<option  value='" . $condicionP . "' $select>" . $condicionP . "</option>";
        }
        return $option;
    }

    function nitidezPapel($default) {
        $cp = array("LEGIBLE", "OPACA", "ILEGIBLE");
        $option = "";
        foreach ($cp as $condicion) {
            if ($condicion == $default)
                $select = "selected";
            else
                $select = "";
            $option .="<option  value='" . $condicion . "' $select>" . $condicion . "</option>";
        }
        return $option;
    }

    function loadSubcon() {
        $subcontenedor = new subcontenedor();
        if ($_REQUEST['lista'] != "")
            $contenedor = $subcontenedor->loadSelect("", VAR3);
        else
            $contenedor = "";
        echo $contenedor;
    }
    

}

?>
