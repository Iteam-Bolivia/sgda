<?php

/**
 * transferenciaArchivoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class transferenciaArchivoController extends baseController {

    function index() {
        $fon_orden = 3; //ARCHIVO CENTRAL O 2da instancia a la que se debe transferir
        $fondos = new fondo();
        $detFondo = $fondos->obtenerArchivo($fon_orden);
        $fon_orden_ant = 1; //FONDO EN EL QUE SE ENCUENTRAN LOS EXPEDIENTES
        //$detAnterior = $fondos->obtenerFondo($_SESSION['USU_ID'],$fon_orden_ant);

        $tmenu = new menu ();
        $liMenu = $tmenu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->registry->template->trn_id = "";
        $this->registry->template->titulo = "Expedientes";
        $this->registry->template->tituloGeneral = "Transferencias a Archivo Central";
        $this->registry->template->titulo2 = "Expedientes transferidos";

        $this->usuario = new usuario ();
        $menuTransf = "";
        if ($_SESSION['ROL_COD'] != 'ADM') {
            $this->series = new series ();
            $menuTransf = $this->series->loadMenuFondo($fon_orden_ant, "test");
        }
        $this->registry->template->PATH_B = $menuTransf;
        $this->registry->template->PATH_A = $menuTransf;
        if ($detFondo != null) {
            $this->registry->template->inst_fondo_id = $detFondo->fon_id;
            $this->registry->template->fondo_des = $detFondo->fon_descripcion;
        } else {
            $fon_orden = '1'; //fondo
            $tinl = new institucion();
            $ins_fon = $tinl->obtenerSinUSR($fon_orden);
            $this->registry->template->inst_fondo_id = $ins_fon->fon_id;
            $this->registry->template->fondo_des = $ins_fon->fon_descripcion;
        }
        $this->registry->template->trn_usuario_des = $this->usuario->listUsuariosArchivo($_SESSION ['USU_ID'], 'ACEN', $fon_orden);
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('transferenciaArchivog.tpl');
        $this->registry->template->show('footer');
    }

    function loadExp() {
        $texpediente = new tab_expediente ();
        $texpediente->setRequest2Object($_REQUEST);
        $tipo = $_SESSION['ROL_COD'];
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'ef.exf_fecha_exf';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder ";
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
            if ($qtype == 'exp_id')
                $where = " and te.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " and ts.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tu.usu_nombres LIKE '%$nom%' OR tu.usu_apellidos LIKE '%$nom%') ";
                }
            }else
                $where = " and $qtype LIKE '%$query%' ";
        }

        /*         * ***************** */
        $select = "select DISTINCT te.exp_id, te.exp_nombre, te.exp_descripcion,te.exp_codigo,
                ts.ser_categoria, ef.exf_fecha_exi, ef.exf_fecha_exf ";
        if ($tipo == 'ADM') {
            $from = " from tab_expediente te
                    INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
                    INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                    INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                    INNER JOIN tab_usuario tu ON tu.usu_id=eu.usu_id
                    WHERE
                    eu.eus_estado =  '1' AND
                    te.exp_estado =  '1' AND
                    ef.exf_estado =  '1' AND
                    tu.usu_estado =  '1' ";
        } else {
//            $inst = new institucion();
//            $ins_fondo = $inst->obtenerInstitucion($_SESSION['USU_ID']);
//            $where .= " AND un.ins_id = '$ins_fondo->ins_id' ";
            if ($tipo == 'OPE') {
                $where .= " AND eu.usu_id ='" . $_SESSION['USU_ID'] . "'  AND tu.usu_id='" . $_SESSION['USU_ID'] . "' ";
            }
            $from = " from tab_expediente te
                    INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
                    INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                    INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                    INNER JOIN tab_usuario tu ON tu.usu_id=eu.usu_id
                    INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                    WHERE
                    eu.eus_estado =  '1' AND
                    te.exp_estado =  '1' AND
                    ef.exf_estado =  '1' AND
                    un.uni_estado = '1' AND
                    tu.usu_estado =  '1' ";
        }
        $where .= " AND ef.fon_id='2' ";


        /*         * *************** */

//        $fon_orden = 1;//FONDO
        $where .= " AND ef.exf_fecha_exf <= CURRENT_DATE ";
        $where .= " AND te.exp_id NOT IN  ( select ttt.exp_id FROM tab_transferencia ttt WHERE ttt.trn_estado = '1' AND te.exp_id = ttt.exp_id)";
        //$where .= " AND tf.fon_orden = '$fon_orden' AND ef.fon_id= tf.fon_id ";

        $sql = "$select $from $where $sort $limit ";
        $sql_c = "select COUNT(DISTINCT te.exp_id) AS num $from $where $sort $limit ";
        //print $sql;die;
        $texp = new expediente ();
        //$total = $texp->countExpATransf( $where );
        // echo ($sql);
        $result = $texpediente->dbselectBySQL($sql);
        $total = $texpediente->countBySQL($sql);

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

    function loadFondo() {
        $ttransf = new tab_transferencia ();
        $tuni = new unidad ();
        $tusuario = new usuario ();
        $tipo = $_SESSION['ROL_COD'];
        $fondo = new fondo();
        $fon_orden = 2;
        // fon_orden = 1 para indicar que esta en fondo
        $inst_fondo = $fondo->obtenerArchivo($fon_orden);
        $ttransf->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'trn_id';
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
            if ($qtype == 'exp_id')
                $where = " and tab_transferencia.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " and tab_series.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'uni_origen')
                $where = " and tab_transferencia.trn_uni_origen IN (SELECT t.uni_id FROM tab_unidad t WHERE t.uni_codigo LIKE '%$query%' ) ";
            elseif ($qtype == 'usu_origen') {
                $nomArray = explode(" ", $query);
                $where .= " and tab_transferencia.trn_usuario_orig IN (
SELECT t2.usu_id FROM tab_usuario t2 WHERE 1 ";
                foreach ($nomArray as $nom) {
                    $where .=" AND (t2.usu_nombres LIKE '%$nom%' OR t2.usu_apellidos LIKE '%$nom%') ";
                }
                $where.=") ";
            } elseif ($qtype == 'uni_destino')
                $where = " and tab_transferencia.trn_uni_destino IN (SELECT t.uni_id FROM tab_unidad t WHERE t.uni_codigo LIKE '%$query%' ) ";
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (u.usu_nombres LIKE '%$nom%' OR u.usu_apellidos LIKE '%$nom%') ";
                }
            } elseif ($qtype == 'usu_destino') {
                $nomArray = explode(" ", $query);
                $where .= " and tab_transferencia.trn_usuario_des IN (
SELECT t4.usu_id FROM tab_usuario t4 WHERE 1 ";
                foreach ($nomArray as $nom) {
                    $where .=" AND (t4.usu_nombres LIKE '%$nom%' OR t4.usu_apellidos LIKE '%$nom%') ";
                }
                $where.=") ";
            }else
                $where = " and $qtype LIKE '%$query%' ";
        }

        /*         * ***************** */
        if ($tipo == 'ADM') {
            $inst = new institucion();
            $ins_fondo = $inst->obtenerInstitucion($_SESSION['USU_ID']);
            $where .= " AND un.ins_id = '$ins_fondo->ins_id' ";
            $where.= " AND tab_transferencia.trn_confirmado = '$inst_fondo->inl_id' ";
        }
        $where .= " AND ef.fon_id='2' ";
        /* if($tipo == 'SUBF') {
          $where .= " AND ef.fon_id='2' ";
          }elseif($tipo == 'ACEN') {
          $where .= " AND ef.fon_id='3' ";
          }else {
          $where .= " AND ef.fon_id='2' ";
          } */
        /*         * *************** */

        $select = "SELECT DISTINCT
                tab_transferencia.trn_descripcion,
                tab_transferencia.trn_uni_origen,
                tab_transferencia.trn_usuario_orig,
                tab_transferencia.trn_uni_destino,
                tab_transferencia.trn_usuario_des,
                tab_series.ser_categoria,
                tab_transferencia.trn_id,
                te.exp_nombre,
                te.exp_descripcion,
                te.exp_codigo,
                tab_transferencia.exp_id,
                te.exp_fecha_exf,
                ef.exf_fecha_exf ";
        $from = " FROM
                tab_transferencia
                Inner Join tab_expediente te ON tab_transferencia.exp_id = te.exp_id
                Inner Join tab_series ON te.ser_id = tab_series.ser_id
                Inner Join tab_expfondo ef ON te.exp_id = ef.exp_id
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_usuario u ON u.usu_id=eu.usu_id
                INNER JOIN tab_unidad un ON un.uni_id=u.uni_id
                WHERE trn_estado = 1 AND
                tab_transferencia.trn_usuario_orig=u.usu_id AND
                eu.eus_estado =  '1' AND
                te.exp_estado =  '1' AND
                ef.exf_estado =  '1' ";
        $sql = "$select $from $where $sort $limit ";
        $sql_c = "SELECT count( DISTINCT tab_transferencia.trn_id) as num $from $where ";

        //print_r($sql);die;
        $result = $ttransf->dbselectBySQL($sql);
        $total = $ttransf->countBySQL($sql_c);
        $transferencia = new transferencia();
        //$total = $transferencia->count ($where);
        $texp = new expediente ();
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
            $json .= ",'" . addslashes($tuni->getCodigo($un->trn_uni_origen)) . "'";
            $json .= ",'" . addslashes($tusuario->obtenerNombre($un->trn_usuario_orig)) . "'";
            $json .= ",'" . addslashes($tuni->getCodigo($un->trn_uni_destino)) . "'";
            $json .= ",'" . addslashes($tusuario->obtenerNombre($un->trn_usuario_des)) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            /* $json .= ",'" . addslashes ( $un->confirmado) . "'"; */
            $json .= ",'" . addslashes($un->trn_descripcion) . "'";
            $json .= ",'" . addslashes($texp->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";

            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function find() {
        $expediente = new tab_expediente();
//        $unidad = new tab_unidad();
        $usuario = new tab_usuario();
        $expediente->setRequest2Object($_REQUEST);
        $unidadA = array();
        $usuarioA = array();
        $expeds = array();
        $ids = $_REQUEST['ids'];
        if ($ids != '') {
            $ids = substr($ids, 0, -1);
            $sqlUs = "SELECT DISTINCT
            tus.usu_id,
            tus.usu_nombres,
            tus.usu_apellidos
            FROM
            tab_expusuario AS teus
            Inner Join tab_usuario AS tus ON tus.usu_id = teus.usu_id
            WHERE
            teus.exp_id IN($ids) AND teus.eus_estado = 1
            ORDER BY tus.usu_nombres ASC ";
            $rowsUs = $usuario->dbselectBySQL($sqlUs);
            if (count($rowsUs) == 1) {
                $usuarioA['usu_id'] = $rowsUs[0]->usu_id;
                $usuarioA['usuario'] = $rowsUs[0]->usu_nombres . ' ' . $rowsUs[0]->usu_apellidos;
            } else {
                $usuarioA['usu_id'] = '';
                $usuarioA['usuario'] = 'VARIOS';
            }
            $sqlUn = "SELECT DISTINCT
            tu.uni_id,
            tu.uni_codigo,
            tu.uni_descripcion
            FROM
            tab_expusuario AS teus
            Inner Join tab_usuario AS tus ON tus.usu_id = teus.usu_id
            Inner Join tab_unidad AS tu ON tu.uni_id = tus.uni_id
            WHERE
            teus.exp_id IN($ids) AND teus.eus_estado = 1 ";
            $rowsUn = $usuario->dbselectBySQL($sqlUn);
            if (count($rowsUn) == 1) {
                $unidadA['uni_id'] = $rowsUn[0]->uni_id;
                $unidadA['uni_codigo'] = $rowsUn[0]->uni_codigo;
                $unidadA['uni_descripcion'] = $rowsUn[0]->uni_descripcion;
            } else {
                $unidadA['uni_id'] = '';
                $unidadA['uni_codigo'] = '';
                $unidadA['uni_descripcion'] = 'VARIOS';
            }

            $sql = "SELECT
            te.exp_nombre,
            te.exp_codigo,
            te.exp_id
            FROM tab_expediente AS te
            WHERE
            te.exp_id IN($ids) AND te.exp_estado = 1
            ORDER BY te.exp_nombre ASC ";
            $rowE = $expediente->dbselectBySQL($sql);
            $i = 0;
            $expDes = "";
            foreach ($rowE as $exp) {
                $expeds[$i]['exp_id'] = $exp->exp_id;
                $expeds[$i]['exp_codigo'] = $exp->exp_codigo;
                $expeds[$i]['exp_codigo'] = $exp->exp_nombre;
                $i++;
                $expDes.=$exp->exp_nombre . "<br />";
            }
            $result[0]['unidad'] = $unidadA['uni_descripcion'];
            $result[0]['usuario'] = $usuarioA['usuario'];
            $result[0]['usu_origen'] = $usuarioA['usu_id'];
            $result[0]['expedientes'] = $expDes;
            echo json_encode($result[0]);
        } else {
            echo false;
        }
    }

    function save() {
        $transf = new tab_transferencia ();
        $transf->setRequest2Object($_REQUEST);
        $expeds = substr($_REQUEST['expedientes'], 0, -1);
        $expArray = explode(",", $expeds);
        $exped = new expediente();
        $usu = new usuario();
        $usu_id = $_REQUEST['trn_usuario_des'];
        $inst_fondo = $_REQUEST['inst_fondo'];
        $usu_origen = $_REQUEST['trn_usuario_orig'];
        $uni_id = $usu->getUnidad($usu_id);
        foreach ($expArray as $exp_id) {
            $tr = new tab_transferencia ();
            $datosExp = $exped->obtenerDatos($exp_id, $usu_origen);
            $tr->setExp_id($exp_id);
            $tr->setTrn_descripcion($_REQUEST['trn_descripcion']);
            $tr->setTrn_uni_origen($datosExp->uni_id);
            $tr->setTrn_uni_destino($uni_id);
            $tr->setTrn_confirmado($inst_fondo); /* colocando en esta secciÃƒÂ³n el fondo al q se envia */
            $tr->setTrn_usuario_orig($datosExp->usu_id);
            $tr->setTrn_usuario_des($usu_id);
            $tr->setTrn_fecha_crea(date('Y-m-d'));
            $tr->setTrn_usuario_crea($_SESSION ['USU_ID']);
            $tr->setTrn_estado(1);
            $tr->insert();
        }
        echo "OK";
    }

}

?>
