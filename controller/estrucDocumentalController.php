<?php

/**
 * expedienteController.php Controller
 *
 * @packages
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class estrucDocumentalController extends baseController {

    var $tituloEstructuraD = "<div class='titulo' align='center'>ESTRUCTURA DOCUMENTAL</div>";
    var $tituloRegularizar = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";
    var $tree;

    function index() {
        $this->registry->template->titulo = "Estructura Documental";
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->series = new series ();
        $this->registry->template->exp_id = "";
        if (isset($_REQUEST['ser_id']))
            $this->registry->template->ser_id = $_REQUEST['ser_id'];
        else 
            $this->registry->template->ser_id = 0;
        
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();
        $this->registry->template->PATH_B = $this->series->loadMenu($adm, "");
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_estrucDocumentalg.tpl');
        $this->registry->template->show('footer');
    }

    function load() {
        $tab_expediente = new tab_expediente ();
        $tab_expediente->setRequest2Object($_REQUEST);
        $ser_id=VAR3;
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
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
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $_SESSION ["SER_ID"] = $ser_id;
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where .= " and exp.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where .= " and ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (usu.usu_nombres LIKE '%$nom%' OR usu.usu_apellidos LIKE '%$nom%') ";
                }
            }else
                $where .= " and $qtype LIKE '%$query%' ";
        }

        if($ser_id>0){
            $where .= " and tab_series.ser_id = '$ser_id' ";
        }
        $where .= " AND tab_usuario.usu_id ='" . $_SESSION['USU_ID'] . "' AND tab_usu_serie.usu_id='" . $_SESSION['USU_ID'] . "' ";
        $sql = "SELECT
            tab_expediente.exp_id,
            tab_fondo.fon_cod,
            tab_unidad.uni_cod,
            tab_tipocorr.tco_codigo,
            tab_series.ser_par,
            tab_series.ser_codigo,
            tab_expediente.exp_codigo,
            tab_usuario.usu_nombres,
            tab_usuario.usu_apellidos,
            tab_expisadg.exp_titulo,
            tab_expisadg.exp_fecha_exi,
            tab_expisadg.exp_fecha_exf,
            tab_expfondo.fon_id,
            tab_series.ser_id,
            tab_usu_serie.usu_id
            FROM
            tab_usuario
            INNER JOIN tab_expusuario ON tab_usuario.usu_id = tab_expusuario.usu_id
            INNER JOIN tab_expediente ON tab_expusuario.exp_id = tab_expediente.exp_id
            INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
            INNER JOIN tab_series ON tab_expediente.ser_id = tab_series.ser_id
            INNER JOIN tab_usu_serie ON tab_series.ser_id = tab_usu_serie.ser_id
            INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
            INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
            INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
            INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
            WHERE tab_fondo.fon_estado = 1
            AND tab_unidad.uni_estado = 1
            AND tab_series.ser_estado = 1
            AND tab_tipocorr.tco_estado = 1
            AND tab_expediente.exp_estado = 1
            AND tab_expisadg.exp_estado = 1
            AND tab_expfondo.exf_estado = 1
            AND tab_expusuario.eus_estado = 1
            $where $sort $limit ";
        $expediente = new expediente ();
        $total = $expediente->countExp($where);

        
        $result = $tab_expediente->dbSelectBySQL($sql);
        header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
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
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo .  DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
//            $json .= ",'" . addslashes($un->sof_nombre) . "'";
//            $json .= ",'" . addslashes($un->exp_nroejem) . "'";
//            $json .= ",'" . addslashes($un->exp_tomovol) . "'";
            $json .= ",'" . addslashes($expediente->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

       function loadSerie() {
        $expediente = new tab_expediente ();
        $expediente->setRequest2Object($_REQUEST);
        
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
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
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        
        if ($query != "") {
            if ($qtype == 'ser_id')
                $where .= " and s.ser_id = '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where .= " and s.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'ser_codigo')
                $where .= " and s.ser_codigo LIKE '%$query%' ";
            else
                $where .= " and $qtype LIKE '%$query%' ";
        }

        $tipo = $_SESSION['ROL_COD'];
        $usu_id = $_SESSION['USU_ID'];
        
        if ($tipo != 'ADM') {

            //ser.ser_categoria,
            $sql = "SELECT
                    tab_fondo.fon_cod,
                    tab_unidad.uni_cod,
                    tab_tipocorr.tco_codigo,
                    tab_series.ser_id,
                    tab_series.ser_codigo,
                    tab_series.ser_categoria
                    FROM
                    tab_usu_serie
                    INNER JOIN tab_series ON tab_usu_serie.ser_id = tab_series.ser_id
                    INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                    INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    WHERE
                    tab_usu_serie.use_estado = '1' 
                    AND tab_series.ser_estado = '1' and tab_usu_serie.usu_id=$usu_id 
                    $where $sort $limit ";
            $series = new series ();
            $total = $series->countSer($where, $usu_id);
        } else {
            // ts.ser_categoria,
            $sql = "SELECT
                    tab_fondo.fon_cod,
                    tab_unidad.uni_cod,
                    tab_tipocorr.tco_codigo,
                    tab_series.ser_id,
                    tab_series.ser_codigo,
                    tab_series.ser_categoria
                    FROM
                    tab_usu_serie
                    INNER JOIN tab_series ON tab_usu_serie.ser_id = tab_series.ser_id
                    INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                    INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    WHERE
                    tab_usu_serie.use_estado = '1' 
                    AND tab_series.ser_estado = '1' $where $sort $limit ";

            $series = new series ();
            $total = $series->countSer($where);
        }
        $result = $expediente->dbSelectBySQL($sql);
        header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
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
            $json .= "id:'" . $un->ser_id . "',";
            $json .= "cell:['" . $un->ser_id . "'";
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    
    function searchTree() {
        header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $_REQUEST ["exp_id"] . "/");
    }

    
    
    
    /**
     * Construye la estructura del documento
     * Fondo
     * Seccion
     * Serie
     * Expediente
     * 
     */
    function viewTree() {
        if(! VAR3){ die("Error del sistema 404"); }

        $this->expediente = new expediente ();
        $this->expediente->setRequest2Object(VAR3);
        $this->tree = $this->expediente->searchTree(VAR3);        
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;


        // Link - Documental Structure
        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $linkUno = $this->expediente->linkTreeUno(VAR3);
        $pathUno = $linkUno [0];
        $tituloUno = $linkUno [1];
        $sinEnlace = $linkUno [3];
        $this->registry->template->linkTree = "<a href='" . $pathUno . "'>" . "$tituloUno</a>  $flecha $sinEnlace";

        $this->registry->template->exp_id = VAR3;
        $this->registry->template->controller = VAR1;        

        if (VAR4 == 1) {
            $msm = "SE GUARDO CORRECTAMENTE EL DOCUMENTO";
        } elseif (VAR4 == 2) {
            $msm = "SE BORRO CORRECTAMENTE EL DOCUMENTO";
        } else {
            $msm = "";
        }        
        $this->registry->template->msm = $msm;
        
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "verifpass";
        $this->registry->template->PATH_EVENT_VERIF_PASS = "verifpass";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";

        $this->registry->template->tree = $this->tree;
        $this->registry->template->show('header');
        $this->llenaDatos(VAR3);
        $this->registry->template->show('tab_estrucDocumentalTree.tpl');
        $this->registry->template->show('footer');
    }

    function llenaDatos($id) {
        $expediente = new tab_expediente();
        $tab_expisadg = new Tab_expisadg();
        
        $exp = $expediente->dbselectById($id);
        $expisadg = $tab_expisadg->dbselectById($id);
        
        $codigo = $exp->exp_codigo;
        $exp = new expediente();
        $expediente = $expediente->dbselectById($id);
        $serie = new tab_series();
        $serie = $serie->dbselectById($expediente->getSer_id());
        $tipo = $serie->getSer_tipo();
        $this->registry->template->detExpediente = "";

        $this->registry->template->detExpediente = $exp->getDetalles($id);
        $this->registry->template->serie = $serie->getSer_categoria();
        $this->registry->template->serTipo = $tipo;
        $this->registry->template->exp_codigo = $expediente->getExp_codigo();
        $this->registry->template->exp_fecha_exi = $expisadg->getExp_fecha_exi();
        $this->registry->template->exp_fecha_exf = $expisadg->getExp_fecha_exf();
        $this->registry->template->ubicacion = $exp->getUbicacion($id);
        $this->registry->template->show('exp_detalles.tpl');
    }

    function uploadField() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->expediente = new expediente ();
        $this->expediente->setRequest2Object(VAR3);
        $this->tree = $this->expediente->searchTree(VAR3);

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;

        $this->registry->template->VAR1 = VAR1;
        $this->registry->template->VAR2 = VAR2;
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->VAR4 = VAR4;
        $this->registry->template->VAR5 = VAR5;

        $this->registry->template->linkTree = $this->expediente->linkTree(VAR3, VAR4, VAR5);
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tree = $this->tree;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_estrucDocumentalOption.tpl');
        $this->registry->template->show('footer');
    }

    function addField() {
        Header("location:" . PATH_DOMAIN . "/archivo/index/" . VAR3 . "/" . VAR4 . "/" . VAR5 . "/");
    }

    function addCC() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;

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
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;

        /* $this->expediente = new expediente ();
          $this->registry->template->linkTree = $this->expediente->linkTree(VAR3, VAR4, VAR5);
          $this->registry->template->controlador = "estrucDocumental";
          $this->registry->template->url_ubicacion = VAR3."/".VAR4."/".VAR5;
          $this->registry->template->PATH_EVENT = "save";
          $this->registry->template->GRID_SW = "false";
          $this->registry->template->PATH_J = "jquery";
          $this->registry->template->show ( 'header' );
          $this->registry->template->show ( 'dim_sisecc_salg.tpl' ); */

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
        $this->registry->template->show('header');
        $this->registry->template->show('dim_sisecc_salg.tpl');
        $this->registry->template->show('footer');
    }

    function obtenerCite() {
        $hojas_ruta = new hojas_ruta();
        $res = $hojas_ruta->obtenerSelect($_REQUEST['Fil_nur']);
        echo $res;
    }

    function obtenerNuri_s() {
        $seguimientos = new seguimientos();
        $res = $seguimientos->obtenerSelect($_REQUEST['Fil_nur']);
        echo $res;
    }    
    
    function obtenerReferencia() {
        $documentos = new documentos();
        $res = $documentos->getReferencia($_REQUEST['Fil_cite']);
        echo $res;
    }

    
    function obtenerSuc() {
        $subcontenedor = new subcontenedor();
        $res = $subcontenedor->selectSuc(0, $_REQUEST['Con_id']);
        echo $res;
    }    
    
}

?>
