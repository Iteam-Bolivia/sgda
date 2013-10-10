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
class cotransferenciaFondoController extends baseController {

    function index() {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;

        $this->series = new series ();
        $this->registry->template->exp_id = "";
        $this->usuario = new usuario ();
        //$adm = $this->usuario->esAdm ();
        //$fondo = new fondo();
        //$fon_orden = '1'; //verÃ¡ lo de fondo
        $this->registry->template->trn_id = "";
        //$ins_fondo = $fondo->obtenerFondo($_SESSION['USU_ID'], $fon_orden);
        $this->registry->template->titulo = "Confirmar Transferencias a Fondo Documental";
        $this->registry->template->PATH_A = ""; //$this->series->loadMenuTransfer($ins_fondo->inl_id, $adm, "test" );
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('cotransferenciaFondog.tpl');
        $this->registry->template->show('footer');
    }

    function viewTree() {
        //$inst = new institucion();
        $fondo_des = 1;
        $usuario = new usuario();
        $contenedor = new contenedor ();
        $transferencia = new transferencia();
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->trans = new Tab_transferencia ();
        $rowx = $this->trans->dbselectByField("trn_id", VAR3);
        $tra = $rowx [0];
        //listar expedientes de esa transferencia

        $res = $transferencia->listaExpConfirmar($tra->trn_confirmado, $tra->trn_uni_origen, $tra->trn_usuario_orig, $tra->trn_fecha_crea);
        $tree = $res[1];
        //$fondo = $inst->getFondo($tra->trn_confirmado);
        $this->registry->template->contenedores = $contenedor->loadSelectInstFondo($fondo_des,$_SESSION['USU_ID']);
        $this->registry->template->suc_id = "";
        $this->registry->template->trn_confirmado = $tra->trn_confirmado;
        $this->registry->template->trn_usuario_orig = $tra->trn_usuario_orig;
        $this->registry->template->trn_fecha_crea = $tra->trn_fecha_crea;
        $this->registry->template->trn_usuario_des = $tra->trn_usuario_des;
        $this->registry->template->trn_uni_destino = $tra->trn_uni_destino;
        $this->registry->template->trn_descripcion = $tra->trn_descripcion;

        $usu_origen = $usuario->getDatos($tra->trn_usuario_orig);
        if ($res[2] != '-1') {
            $usu_destino = $usuario->getDatos($tra->trn_usuario_des);
            $this->registry->template->usu_destino = $usu_destino->usu_nombres . ' ' . $usu_destino->usu_apellidos;
        } else {
            $this->registry->template->usu_destino = "VARIOS";
        }
        $fondo = new fondo();
        $row_fondo = $fondo->obtenerFondo($_SESSION['USU_ID'], $fondo_des);
        $this->registry->template->lugar = $row_fondo->fon_descripcion; 
        $this->registry->template->unidad = $usu_origen->uni_codigo . ' - ' . $usu_origen->uni_descripcion;
        $this->registry->template->usuario = $usu_origen->usu_nombres . ' ' . $usu_origen->usu_apellidos;
        $this->registry->template->cantidad = $res[0];
        $this->registry->template->tree = $tree;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "confirmar";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = "CONFIRMAR TRANSFERENCIA";
        $this->registry->template->show('headerF');
        $this->registry->template->show('cotransferenciaFondo.tpl');
        $this->registry->template->show('footer');
    }

    function confirmar() {
        $texp = new tab_expediente ();
        $texp->setRequest2Object($_REQUEST);

        $inl_id = $_REQUEST["trn_confirmado"];
        $trn_fecha_crea = $_REQUEST["trn_fecha_crea"];
        $trn_usuario_orig = $_REQUEST["trn_usuario_orig"];
        $suc_id = $_REQUEST['suc_id'];

        $hoy = date("Y-m-d");
        $usuario = new usuario();
        $usu_origen = $usuario->getDatos($trn_usuario_orig);
        //$tipo = $usu_origen->rol_cod;
        $nombre = $usu_origen->usu_nombres . " " . $usu_origen->usu_apellidos;

        $unidad = new Tab_unidad();
        $row_uni = $unidad->dbselectByField("uni_id", $_REQUEST['trn_uni_destino']);
//        $insfondo = new Tab_inst_fondo();
//        $rowsInsF = $insfondo->dbselectByField("inl_id", $inl_id);
//        $insfondo = $rowsInsF[0];
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
                    t.trn_confirmado =  '$inl_id' AND
                    t.trn_usuario_orig =  '$trn_usuario_orig' AND
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
                //$fecha_final = $retdoc->obtenerFechaExtFinal($tra->exp_id,$insfondo->fon_id,date("m"),date("d"), date("Y"));
                $fecha_final = date("Y-m-d");
                $texf->exf_fecha_exf = $fecha_final;
                $texf->exf_usu_crea = $_SESSION['USU_ID'];
                $texf->exp_id = $tra->exp_id;
                $texf->fon_id = $row_uni[0]->fon_id;
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
                $rows = $tusu->dbselectBy3Field("exp_id", $tra->exp_id, "usu_id", $tra->trn_usuario_orig, "eus_estado", 1);
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
                $suc_id = 0;
                if (isset($_REQUEST["suc_id"])) {
                    $suc_id = $_REQUEST["suc_id"];
                    $tcon = new tab_expcontenedor ();
                    $row_con = $tcon->dbselectBy2Field("exp_id", $tra->exp_id, "exc_estado", 1);
                    if (count($row_con) > 0) {
                        $con = $row_con[0];
                        $datos['exc_id'] = $con->exc_id;
                        $tcon->exc_id = $con->exc_id;
                        $tcon->suc_id = $suc_id;
                        $tcon->exc_estado = 1;
                        $tcon->update();
                    } elseif ($suc_id != '') {
                        $con = new expcontenedor ();
                        $datos['exc_id'] = $con->saveExpCont($suc_id, $tra->exp_id);
                    } else {
                        $suc_id = 0;
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

                $exp = new tab_expediente ();
                $rows = $exp->dbSelectBySQL("SELECT * from tab_expediente WHERE exp_id ='" . $tra->exp_id . "' ");
                $nombreExpediente = $rows [0]->exp_nombre;

                $this->inventario = new tab_inventario ();
                $rows = $this->inventario->dbSelectBySQL("SELECT * from tab_inventario WHERE exp_id ='" . $tra->exp_id . "' ");
                if (count($rows) > 0) {
                    //update
                    $this->inventario->setInv_id($rows[0]->inv_id);
                    $this->inventario->setExp_id($tra->exp_id);
                    $this->inventario->setInv_orden($inl_id);
                    $this->inventario->setInv_titulo($nombreExpediente);
                    $this->inventario->setInv_nom_productor($nombre);

                    if ($row_uni[0]->fon_id == '2') {
                        $this->inventario->setInv_unidad($tra->trn_uni_origen);
                        $this->inventario->setUsu_id($tra->trn_usuario_des);
                        $this->inventario->setUni_id($tra->trn_uni_destino);
                    }
                    $this->inventario->setInv_fecha_mod($hoy);
                    $this->inventario->setInv_usu_mod($_SESSION['USU_ID']);
                    $this->inventario->setInv_estado(1);
                    $this->inventario->update();
                } else {
                    //insert
                    $this->inventario->setExp_id($tra->exp_id);
                    $this->inventario->setInv_orden($inl_id);
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
                    $this->inventario->setInv_anio(date("Y"));
                    $this->inventario->setInv_estado(1);

                    if ($row_uni[0]->fon_id == '2') {
                        $this->inventario->setInv_unidad($tra->trn_uni_origen);
                        $this->inventario->setUsu_id($tra->trn_usuario_des);
                        $this->inventario->setUni_id($tra->trn_uni_destino);
                    }
                    $this->inventario->insert();
                }
            }
        }

        Header("Location: " . PATH_DOMAIN . "/cotransferenciaFondo/");
    }

    function load() {
        $transferencia = new tab_transferencia ();
        $usuario = new usuario ();
        $serie = new series();
        $transferencia->setRequest2Object($_REQUEST);
        $fondos = new fondo();
        $fon_orden = '1';
        $ins_fondo = $fondos->obtenerFondo($_SESSION['USU_ID'], $fon_orden);
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
            elseif ($qtype == 'usu_origen') {
                $nomArray = explode(" ", $query);
                $where .= " and tt.trn_usuario_orig IN (SELECT t2.usu_id FROM tab_usuario t2 WHERE 1 ";
                foreach ($nomArray as $nom) {
                    $where .=" AND (t2.usu_nombres LIKE '%$nom%' OR t2.usu_apellidos LIKE '%$nom%') ";
                }
                $where.=") ";
            }else
                $where = " and $qtype LIKE '%$query%' ";
        }

        /*         * ***************** */

        $tipo = $_SESSION['ROL_COD'];
//        if($tipo != 'ADM') {
//            $tinst = new institucion();
//            $inst = $tinst->obtenerInstitucion($_SESSION['USU_ID']);
//            $where .= " AND un.ins_id = '$inst->ins_id' ";
//            $where .= " AND tt.trn_confirmado =  '$ins_fondo->inl_id' ";
//        }
        if ($tipo != 'ADM') {
            $where .= " AND tt.trn_usuario_des ='" . $_SESSION['USU_ID'] . "' ";
        }
//        if($tipo == 'OPE') {
//            $where .= " AND ef.fon_id='1' ";
//        }elseif($tipo == 'SUBF'){
//            $where .= " AND ef.fon_id='2' ";
//        }elseif($tipo == 'ACEN'){
//            $where .= " AND ef.fon_id='3' ";
//        }elseif($tipo == 'AINT'){
//            $where .= " AND ef.fon_id='4' ";
//        }
//        else{
//            $where .= " AND ef.fon_id='1' ";
//        }
        // MODIFIED: CASTELLON
        $sql = "SELECT DISTINCT tt.trn_descripcion, tt.trn_uni_origen, tt.trn_confirmado, tt.trn_usuario_orig, tt.trn_usuario_des, tt.trn_fecha_crea,tt.trn_id
                FROM tab_transferencia tt Inner Join tab_expediente te ON tt.exp_id = te.exp_id INNER JOIN tab_expfondo ef ON ef.exp_id=te.exp_id INNER JOIN tab_series ts ON te.ser_id=ts.ser_id INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_des INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                WHERE tt.trn_estado = 1 AND te.exp_estado =  '1' AND ef.exf_estado =  '1' $where
        		$sort $limit ";
        //
        $result = $transferencia->dbselectBySQL($sql);
        $ttransferencia = new transferencia ();
        $total = $ttransferencia->countFondo($where);
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
            $usr = $usuario->getDatos($un->trn_usuario_orig);
            if ($usr != null) {
                $json .= ",'" . addslashes($usr->usu_nombres . ' ' . $usr->usu_apellidos) . "'";
                $json .= ",'" . addslashes($usr->uni_codigo) . "'";
            } else {
                $json .= ",'" . addslashes('') . "'";
                $json .= ",'" . addslashes('') . "'";
            }
            $json .= ",'" . addslashes($un->trn_fecha_crea) . "'";
            //$json .= ",'" . addslashes ( $un->count_exp ) . "'";
            if ($tipo != 'ADM') {
                $detSerie = $serie->getTransFondo($un->trn_uni_origen, $un->trn_usuario_orig, $un->trn_fecha_crea);
            } else {
                $detSerie = "";
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
