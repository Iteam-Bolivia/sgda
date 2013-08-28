<?php

/**
 * cotransferenciaFondoController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class coTransferenciaArchivoController extends baseController {

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        //$this->series = new series ();
        $this->registry->template->exp_id = "";
        $this->usuario = new usuario ();
//        $adm = $this->usuario->esAdm ();
        $fondos = new fondo();
        $fon_orden = '3'; //verÃ¡ lo de archivo central
        $ins_fondo = $fondos->obtenerArchivo($fon_orden);
        $this->registry->template->titulo = "Confirmar Transferencias a Archivo Central";
        //$this->registry->template->PATH_A = ""; //$this->series->loadMenuTransfer($ins_fondo->inl_id, $adm, "test");
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('cotransferenciaArchivog.tpl');
        $this->registry->template->show('footer');
    }

    function viewTree() {
        $inst = new institucion();
        $usuario = new usuario();
        $contenedor = new contenedor ();
        $transferencia = new transferencia();
        $tmenu = new menu ();
        $liMenu = $tmenu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $ttrans = new Tab_transferencia ();
        $rowx = $ttrans->dbselectByField("trn_id", VAR3);
        $tra = $rowx [0];
        //listar expedientes de esa transferencia

        $res = $transferencia->listaExpConfirmarPorFondo($tra->trn_confirmado, $tra->trn_fecha_crea);
        $tree = $res[1];
        $fon_orden_ant = 2;
        $fondoAnterior = $inst->obtenerFondo($tra->trn_usuario_orig, $fon_orden_ant);
        $fondo = $inst->getFondo($tra->trn_confirmado);
        $this->registry->template->contenedores = $contenedor->loadSelectInstFondo("ACEN");
        $this->registry->template->trn_confirmado = $tra->trn_confirmado;
        $this->registry->template->trn_usuario_orig = $tra->trn_usuario_orig;
        $this->registry->template->trn_fecha_crea = $tra->trn_fecha_crea;
        $this->registry->template->trn_usuario_des = $tra->trn_usuario_des;
        $this->registry->template->trn_uni_destino = $tra->trn_uni_destino;
        $this->registry->template->trn_descripcion = $tra->trn_descripcion;
        $this->registry->template->uni_id_origen = $fondoAnterior->uni_id;

        $usu_origen = $usuario->getDatos($tra->trn_usuario_orig);
        if ($res[2] != '-1') {
            $usu_destino = $usuario->getDatos($tra->trn_usuario_des);
            $this->registry->template->usu_destino = $usu_destino->usu_nombres . ' ' . $usu_destino->usu_apellidos;
        } else {
            $this->registry->template->usu_destino = "VARIOS";
        }
        $this->registry->template->lugar = $fondo->fon_descripcion . ' - ' . $fondo->uni_codigo;
        $this->registry->template->origen = $fondoAnterior->fon_descripcion . ' - ' . $fondoAnterior->uni_codigo;
        $this->registry->template->usuario = $usu_origen->usu_nombres . ' ' . $usu_origen->usu_apellidos;
        $this->registry->template->cantidad = $res[0];
        $this->registry->template->tree = $tree;
        $this->registry->template->suc_id = "";

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "confirmar";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = "CONFIRMAR TRANSFERENCIA";
        $this->registry->template->show('headerF');
        $this->registry->template->show('cotransferenciaArchivo.tpl');
        $this->registry->template->show('footer');
    }

    function confirmar() {
        $texp = new tab_expediente ();
        $texp->setRequest2Object($_REQUEST);
        $fon_id = $_REQUEST["trn_confirmado"];
        $trn_fecha_crea = $_REQUEST["trn_fecha_crea"];
//        $trn_usuario_des = $_REQUEST["trn_usuario_des"];

        $hoy = date("Y-m-d");
        $fondo = new Tab_fondo();
        $rowsInsF = $fondo->dbselectByField("fon_id", $fon_id);
        $fondo = $rowsInsF[0];
        if (isset($_REQUEST["expedientes"])) {
            $expedientes = $_REQUEST["expedientes"];
            foreach ($expedientes as $texp) {
                $sql = "SELECT
                    t.trn_id,
                    t.exp_id,
                    t.trn_descripcion,
                    t.trn_contenido,
                    t.trn_uni_origen,
                    t.trn_uni_destino,
                    t.trn_usuario_orig,
                    t.trn_usuario_des,
                    t.trn_confirmado,
                    t.trn_estado
                    FROM
                    tab_transferencia AS t
                    WHERE
                    t.trn_estado =  '1' AND
                    t.trn_confirmado =  '$fon_id' AND
                    t.exp_id =  '$texp' AND
                    t.trn_fecha_crea =  '$trn_fecha_crea' "; //print($sql);
                $ttra = new tab_transferencia ();
                $rows = $ttra->dbSelectBySQL($sql);
                $datos = array();
                $tra = $rows[0];

                $texf = new Tab_expfondo();
                $rows = $texf->dbselectBy2Field("exp_id", $tra->exp_id, "exf_estado", 1);
                if (count($rows) > 0) {
                    $exf = $rows [0];
                    $texf->exf_id = $exf->exf_id;
                    $texf->exf_estado = '2';
                    $texf->update();
                }
                $texf = new tab_expfondo ();
                $texf->exf_estado = 1;
                $texf->exf_fecha_crea = $hoy;
                $texf->exf_fecha_exi = $hoy;
                $retdoc = new retdocumental();
                $fecha_final = $retdoc->obtenerFechaExtFinal($tra->exp_id, $fondo->fon_id, date("m"), date("d"), date("Y"));
                $texf->exf_fecha_exf = $fecha_final;
                $texf->exf_usu_crea = $_SESSION['USU_ID'];
                $texf->exp_id = $tra->exp_id;
                $texf->fon_id = $fondo->fon_id;
                $texf->exf_estado = '1';
                $texf->insert();

//                if($tra->trn_uni_origen==$tra->trn_uni_destino){
//                    $tuni = new tab_expunidad ();
//                    $rows = $tuni->dbselectBy2Field ( "exp_id", $tra->exp_id, "uni_id", $tra->trn_uni_origen);
//                    if(count($rows)>0){
//                            $uni = $rows [0];
//                            $tuni->euv_id = $uni->euv_id;
//                            $tuni->euv_estado = 1;
//                            $tuni->update ();
//                    }
//                }else{
//                    $tuni = new tab_expunidad ();
//                    $rows = $tuni->dbselectBy3Field ( "exp_id", $tra->exp_id, "uni_id", $tra->trn_uni_origen, "euv_estado", 1 );
//                    if(count($rows)>0){
//                            $uni = $rows [0];
//                            $tuni->euv_id = $uni->euv_id;
//                            $tuni->euv_estado = 2;
//                            $tuni->update ();
//                    }
//                    $tuni = new tab_expunidad ();
//                    $tuni->uni_id = $tra->trn_uni_destino;
//                    $tuni->exp_id = $tra->exp_id;
//                    $tuni->euv_fecha_crea = $hoy;
//                    $tuni->ver_id = $_SESSION ['VER_ID'];
//                    $tuni->euv_estado = 1;
//                    $datos ['euv_id'] = $tuni->insert();
//                }

                $tusu = new tab_expusuario ();
                $rows = $tusu->dbselectBy2Field("exp_id", $tra->exp_id, "eus_estado", 1);
                if (count($rows) > 0) {
                    $usu = $rows[0];
                    $tusu->eus_id = $usu->eus_id;
                    $tusu->eus_estado = 2;
                    $tusu->update();
                }
                $tusu = new tab_expusuario ();
                $tusu->usu_id = $tra->trn_usuario_des;
                $tusu->exp_id = $tra->exp_id;
                $tusu->eus_fecha_crea = $hoy;
                $tusu->eus_estado = 1;
                $datos ['eus_id'] = $tusu->insert();

                $datos['exc_id'] = 0;
                $con_id = 0;
                if (isset($_REQUEST["con_id"])) {
                    $con_id = $_REQUEST["con_id"];
                    $tcon = new tab_expcontenedor ();
                    $row_con = $tcon->dbselectBy2Field("exp_id", $tra->exp_id, "exc_estado", 1);
                    if (count($row_con) > 0) {
                        $con = $row_con[0];
                        $datos['exc_id'] = $con->exc_id;
                        $tcon->exc_id = $con->exc_id;
                        $tcon->con_id = $con_id;
                        $tcon->exc_estado = 1;
                        $tcon->update();
                    } elseif ($con_id != '') {
                        $con = new expcontenedor ();
                        $datos['exc_id'] = $con->saveExpCont($con_id, $tra->exp_id, $datos ['euv_id']);
                    } else {
                        $con_id = 0;
                    }
                }

                $tarc = new tab_exparchivo ();
                $rows = $tarc->dbselectBy2Field("exp_id", $tra->exp_id, "exa_estado", 1);
                foreach ($rows as $row) {
                    $tarc->updateValueOne("exa_estado", "2", "exa_id", $row->exa_id);
                    $tarc->fil_id = $row->fil_id;
                    $tarc->exp_id = $tra->exp_id;
                    $tarc->tra_id = $row->tra_id;
                    $tarc->cue_id = $row->cue_id;
                    $tarc->ver_id = $row->ver_id;
                    $tarc->exa_condicion = $row->exa_condicion;
                    $tarc->exa_fecha_crea = $hoy;
                    $tarc->exa_usuario_crea = $_SESSION ['USU_ID'];
                    $tarc->exa_estado = 1;
                    $datos ['eus_id'] = $tarc->insert();
                    $arch = new Tab_archivo();
                    $arch->updateValue("fil_confidencialidad", 1, $row->fil_id);
                }

                $ttra->updateValue("trn_estado", 2, $tra->trn_id);

                //if($tipo=='ADM' || $tipo == 'SUBF')


                $this->inventario = new tab_inventario ();
                $rows = $this->inventario->dbSelectBySQL("SELECT * from tab_inventario WHERE exp_id ='" . $tra->exp_id . "' ");
                if (count($rows) > 0) {
                    //update para Archivo Central
                    $this->inventario->setInv_id($rows[0]->inv_id);
                    $this->inventario->setInv_orden($fon_id);
                    $this->inventario->setInv_fecha_mod($hoy);
                    $this->inventario->setInv_usu_mod($_SESSION['USU_ID']);
                    $this->inventario->setInv_estado(1);
                    $this->inventario->update();
                } else {
                    //insert
                    $exp = new tab_expediente ();
                    $rows = $exp->dbSelectBySQL("SELECT * from tab_expediente WHERE exp_id ='" . $tra->exp_id . "' ");
                    $nombreExpediente = $rows [0]->exp_nombre;
                    $exped = new expediente();
                    $usu_origen = $exped->getProductor($tra->exp_id);
                    $nombre = '';
                    $uni_id = 0;
                    $usu_id = 0;
                    if ($usu_origen != null) {
                        $nombre = $usu_origen->usu_nombres . " " . $usu_origen->usu_apellidos;
                        $uni_id = $usu_origen->uni_id;
                        $usu_id = $usu_origen->usu_id;
                    }
                    $this->inventario->setExp_id($tra->exp_id);
                    $this->inventario->setInv_orden($fon_id);
                    $this->inventario->setInv_pieza('');
                    $this->inventario->setInv_ml("0.1");
                    $this->inventario->setInv_titulo($nombreExpediente);
                    $this->inventario->setInv_tomo('');
                    $this->inventario->setInv_nom_productor($nombre);
                    $this->inventario->setInv_caract_fisica('');
                    $this->inventario->setInv_obs('');
                    $this->inventario->setInv_condicion_papel("BUENO");
                    $this->inventario->setInv_nitidez_escritura("LEGIBLE");
                    $this->inventario->setInv_analisis_causa('');
                    $this->inventario->setInv_accion_curativa('');
                    $this->inventario->setInv_fecha_reg(date("Y-m-d"));
                    $this->inventario->setInv_usu_reg($_SESSION['USU_ID']);
                    $this->inventario->setInv_estado(1);
                    $this->inventario->setInv_unidad($uni_id);
                    $this->inventario->setUsu_id($usu_id);
                    $this->inventario->setUni_id($uni_id);
                    $this->inventario->setInv_anio(date("Y"));
                    $this->inventario->insert();
                }
            }
        }

        Header("Location: " . PATH_DOMAIN . "/cotransferenciaArchivo/");
    }

    function load() {
        $transferencia = new tab_transferencia ();
        $serie = new series();
        $transferencia->setRequest2Object($_REQUEST);
        $fondos = new fondo();
        $fon_orden = '3';
        $ins_fondo = $fondos->obtenerArchivo($fon_orden);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'trn_id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = " ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        // MODIFIED: CASTELLON
        $limit = "LIMIT $rp OFFSET $start ";
        //
        $query = $_REQUEST ['query'];
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'trn_id')
                $where = " and tt.trn_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " and ts.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'uni_origen')
                $where = " and tt.trn_uni_origen IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            elseif ($qtype == 'uni_destino')
                $where = " and tt.trn_uni_destino IN (SELECT uni_id FROM tab_unidad WHERE uni_codigo LIKE '%$query%') ";
            else
                $where = " and $qtype LIKE '%$query%' ";
        }

        $tipo = $_SESSION['ROL_COD'];
        $where .= " AND ef.fon_id='2' ";
        /*         * *************** */
        if ($tipo != 'ADM') {
            $where .= " AND tt.trn_confirmado =  '$ins_fondo->fon_orden' ";
        }
        // MODIFIED: CASTELLON
        $sql = "SELECT DISTINCT tt.trn_id, tt.trn_descripcion, tt.trn_uni_origen, tt.trn_confirmado, tt.trn_usuario_orig,
tt.trn_usuario_des, tt.trn_fecha_crea, un.fon_id, tf.fon_cod, tf.fon_descripcion
FROM tab_transferencia tt
Inner Join tab_expediente te ON tt.exp_id = te.exp_id
INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id
INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
INNER JOIN tab_fondo tf ON tf.fon_id = un.fon_id
        WHERE tt.trn_estado = 1 AND te.exp_estado = '1' AND ef.exf_estado = '1' $where
		$sort $limit";

        $result = $transferencia->dbselectBySQL($sql);
        $transferencia = new transferencia ();
        $total = $transferencia->countArchivo($where);
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
            $json .= "id:'" . $un->trn_id . "',";
            $json .= "cell:['" . $un->trn_id . "'";
            $json .= ",'" . addslashes($un->fon_descripcion) . "'";
            $json .= ",'" . addslashes($un->trn_fecha_crea) . "'";
            //$json .= ",'" . addslashes ( $un->count_exp ) . "'";
            $detSerie = "";
            if ($tipo != 'ADM') {
                $detSerie = $serie->getTransArchivo($ins_fondo->fon_orden, $un->trn_fecha_crea);
            }
            $json .= ",'" . addslashes($detSerie) . "'";
            $json .= ",'" . addslashes($un->trn_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function obtenerSuc() {
        $subcontenedor = new subcontenedor();
        $res = $subcontenedor->selectSuc(0, $_REQUEST['Con_id']);
        echo $res;
    }

}

?>
