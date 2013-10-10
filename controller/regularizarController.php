<?php

/**
 * regularizarController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class regularizarController Extends baseController {

    function index() {
        $tmenu = new menu ();
        $liMenu = $tmenu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $tseries = new series ();
        if ($_SESSION['ROL_COD'] != 'ADM') {

            $inst = new institucion();
            $ins_fondo = $inst->obtenerInstitucion($_SESSION['USU_ID']);
            $menu = $tseries->loadMenuRegularizacion($ins_fondo->ins_id, "test");
        } else {
            $menu = $tseries->loadMenu(false, "");
        }

        $this->registry->template->titulo = "Regularizacion de Documentos";
        $this->registry->template->exp_id = "";
        $this->registry->template->PATH_B = $menu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('regularizarg.tpl');
        $this->registry->template->show('footer');
    }

    function llenaDatos($id) {
        $expediente = new tab_expediente();
        $exp = $expediente->dbselectById($id);
        $codigo = $exp->exp_codigo;
        $exp = new expediente();
        $expediente = $expediente->dbselectById($id);
        $serie = new tab_series();
        $serie = $serie->dbselectById($expediente->getSer_id());
        $tipo = $serie->getSer_tipo();
        $this->registry->template->detExpediente = "";
        if ($tipo == 'SISIN') {
            $this->registry->template->convenios = $exp->getConvenios($codigo, $tipo);
            $this->registry->template->detExpediente = $exp->getDim_sisin($codigo);
        } elseif ($tipo == 'SISFIN') {
            $this->registry->template->proyectos = $exp->getProyectos($codigo, $tipo);
            $this->registry->template->detExpediente = $exp->getDim_sisfin($codigo);
        } elseif ($tipo == 'CIF') {
            $this->registry->template->proyectos = $exp->getProyectos($codigo, $tipo);
            $this->registry->template->convenios = $exp->getConvenios($codigo, $tipo);
            $this->registry->template->detExpediente = $exp->getDim_cif($codigo);
        } else {
            $this->registry->template->detExpediente = $exp->getDetalles($id);
        }
        $this->registry->template->serie = $serie->getSer_categoria();
        $this->registry->template->serTipo = $tipo;
        $this->registry->template->exp_codigo = $expediente->getExp_codigo();
        $this->registry->template->exp_fecha_exi = $expediente->getExp_fecha_exi();
        $this->registry->template->exp_fecha_exf = $expediente->getExp_fecha_exf();
        $this->registry->template->ubicacion = $exp->getUbicacion($id);
        $this->registry->template->show('exp_detalles.tpl');
    }

    function load() {
        $texpediente = new tab_expediente ();
        $texpediente->setRequest2Object($_REQUEST);
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
                $where = " and E.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " and ts.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tu.usu_nombres LIKE '%$nom%' OR tu.usu_apellidos LIKE '%$nom%') ";
                }
            }else
                $where = " and E.$qtype LIKE '%$query%' ";
        }

        /*         * ***************** */
        $tipo = $_SESSION['ROL_COD'];
        if ($tipo != 'ADM') {
            $inst = new institucion();
            $ins_fondo = $inst->obtenerInstitucion($_SESSION['USU_ID']);
            $where .= " AND un.ins_id = '$ins_fondo->ins_id' ";
        }

        if ($tipo == 'OPE') {
            $where .= " AND tt.trn_usuario_orig ='" . $_SESSION['USU_ID'] . "' ";
        }
        /*         * *************** */
        $sql = "select DISTINCT te.exp_id, te.exp_nombre, te.exp_descripcion,te.exp_codigo, ts.ser_categoria,
                        ef.exf_fecha_exi, ef.exf_fecha_exf
                        from tab_expediente te
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_expfondo ef ON te.exp_id=ef.exp_id
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_transferencia tt ON tt.exp_id = te.exp_id
                INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                INNER JOIN tab_usu_serie us ON us.usu_id = tu.usu_id AND us.ser_id=ts.ser_id
                WHERE
                eu.usu_id = tt.trn_usuario_des AND
                eu.eus_estado =  '1' AND
                ef.exf_estado =  '1' AND
                te.exp_estado =  '1' AND
                us.use_estado =  '1' AND
                tt.trn_estado = '2' $where $sort $limit ";

        $texp = new expediente();
        $total = $texp->countReg($where);

        $result = $texpediente->dbselectBySQL($sql);


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
            /* $json .= ",'" . addslashes ( $un->ser_categoria ) . "'"; */
            $json .= ",'" . addslashes($un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_nombre) . "'";
            $json .= ",'" . addslashes($un->exp_descripcion) . "'";
            $json .= ",'" . addslashes($un->exf_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exf_fecha_exf) . "'";
            $json .= ",'" . addslashes($texp->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function searchTree() {
        header("location:" . PATH_DOMAIN . "/regularizar/viewTree/" . $_REQUEST["exp_id"] . "/");
    }

    function viewTree() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->registry->template->tituloEstructura = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->expediente = new expediente ();
        $this->expediente->setRequest2Object(VAR3);
        $this->tree = $this->expediente->searchTreeReg(VAR3);

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $linkUno = $this->expediente->linkTreeUno(VAR3);
        $pathUno = $linkUno [0];
        $tituloUno = $linkUno [1];
        $sinEnlace = $linkUno [3];

        $this->registry->template->linkTree = "<a href='" . $pathUno . "'>" . "$tituloUno</a> $flecha $sinEnlace";

        $this->registry->template->exp_id = VAR3;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verifpass";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->tree = $this->tree;
        $this->registry->template->show('header');
        $this->llenaDatos(VAR3);
        $this->registry->template->show('regularizarTree.tpl');
        $this->registry->template->show('footer');
    }

    function addCC() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->tituloEstructura = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";

        $expediente = new tab_expediente ();
        $rows = $expediente->dbselectByField("exp_id", VAR3);
        $expediente = $rows[0];

        $serie = new tab_series ();
        $rows = $serie->dbselectByField("ser_id", $expediente->ser_id);
        $serie = $rows[0];

        $nombre = $expediente->exp_nombre;
        if (strlen($expediente->exp_nombre) > 50)
            $nombre = substr($expediente->exp_nombre, 0, 50) . "...";

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $this->registry->template->linkTree = "<a href='" . PATH_DOMAIN . "/" . VAR1 . "/'>" . $serie->ser_categoria . "</a> $flecha <a href='" . PATH_DOMAIN . "/" . VAR1 . "/viewTree/" . VAR3 . "/'>" . $nombre . "</a> $flecha CORRESPONDENCIA";
        $this->registry->template->nroingreso = "";
        $this->registry->template->controlador = VAR1;
        $this->registry->template->url_ubicacion = VAR3;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('dim_sisecc_entg.tpl');
        $this->registry->template->show('footer');
    }

    function addCCO() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->tituloEstructura = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";

        $expediente = new tab_expediente ();
        $rows = $expediente->dbselectByField("exp_id", VAR3);
        $expediente = $rows[0];

        $serie = new tab_series ();
        $rows = $serie->dbselectByField("ser_id", $expediente->ser_id);
        $serie = $rows[0];

        $nombre = $expediente->exp_nombre;
        if (strlen($expediente->exp_nombre) > 50)
            $nombre = substr($expediente->exp_nombre, 0, 50) . "...";

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $this->registry->template->linkTree = "<a href='" . PATH_DOMAIN . "/" . VAR1 . "/'>" . $serie->ser_categoria . "</a> $flecha <a href='" . PATH_DOMAIN . "/" . VAR1 . "/viewTree/" . VAR3 . "/'>" . $nombre . "</a> $flecha CORRESPONDENCIA";
        $this->registry->template->nrosalida = "";
        $this->registry->template->controlador = VAR1;
        $this->registry->template->url_ubicacion = VAR3;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('dim_sisecc_salg.tpl');
        $this->registry->template->show('footer');
    }

}

?>
