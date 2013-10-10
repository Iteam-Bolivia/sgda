<?php

/**
 * transferenciaController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class coTransferenciaController extends baseController {

    function index() {    
        
        $this->menu = new menu();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;   
        $this->registry->template->titulo = "Confirmar Transferencias";
        $this->registry->template->str_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->FORM_SW = "display:none;";
        $this->registry->template->PATH_J = "jquery";
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_cotransferenciag.tpl');
        $this->registry->template->show('footer');        
    }

    
    
    function load() {
        $this->series = new series ();
        $this->expediente = new tab_expediente ();
        $this->expediente->setRequest2Object($_REQUEST);
        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'str_id';
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
        if ($query != "") {
            if ($qtype == 'str_id'){
                $where .= " and tab_soltransferencia.str_id LIKE '$query' ";
            }else{
                $where .= " and $qtype LIKE '%$query%' ";
            }                
        }

        $sql = "SELECT
                tab_soltransferencia.str_id,
                tab_soltransferencia.str_fecha,
                (SELECT uni_descripcion from tab_unidad WHERE uni_estado = 1 AND uni_id=tab_soltransferencia.uni_id) AS uni_descripcion,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_estado = 1 AND usu_id=tab_soltransferencia.usu_id) AS usu_nombres,
                tab_soltransferencia.uni_id,
                tab_soltransferencia.usu_id,
                tab_soltransferencia.unid_id,
                tab_soltransferencia.usud_id,
                tab_soltransferencia.str_nrocajas,
                tab_soltransferencia.str_totpzas,
                tab_soltransferencia.str_totml,
                tab_soltransferencia.str_nroreg,
                tab_soltransferencia.str_fecini,
                tab_soltransferencia.str_fecfin,
                tab_soltransferencia.str_estado
                FROM
                tab_soltransferencia
                WHERE 
                tab_soltransferencia.str_estado = 2 AND
                tab_soltransferencia.usud_id =" . $_SESSION['USU_ID'] . " $where $sort $limit";

        $expediente = new expediente ();
        $result = $this->expediente->dbselectBySQL($sql);
        $total = $expediente->countExp3($where);

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
            $json .= "id:'" . $un->str_id . "',";            
            $json .= "cell:['" . $un->str_id . "'";
            $json .= ",'" . addslashes($un->str_fecha) . "'";
            $json .= ",'" . addslashes($un->uni_descripcion) . "'";
            $json .= ",'" . addslashes($un->usu_nombres) . "'";
            $json .= ",'" . addslashes($un->str_nrocajas) . "'";
            $json .= ",'" . addslashes($un->str_totpzas) . "'";
            $json .= ",'" . addslashes($un->str_totml) . "'";
            $json .= ",'" . addslashes($un->str_nroreg) . "'";
            $json .= ",'" . addslashes($un->str_fecini) . "'";
            $json .= ",'" . addslashes($un->str_fecfin) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }
    

    function add() {

        $this->registry->template->trn_id = "";
        $this->registry->template->exp_id = "";
        $this->registry->template->trn_descripcion = "";
        $this->registry->template->trn_contenido = "";
        $this->registry->template->trn_uni_origen = "";
        $this->registry->template->trn_uni_destino = "";
        $this->registry->template->trn_confirmado = "";
        $this->registry->template->trn_fecha_crea = "";
        $this->registry->template->trn_usuario_crea = "";
        $this->registry->template->trn_estado = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_transferencia.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        //$this->transferencia->setTrn_id = $_REQUEST ['trn_id'];
        $this->transferencia->setExp_id = $_REQUEST ['exp_id'];
        $this->transferencia->setTrn_descripcion = $_REQUEST ['trn_descripcion'];
        //$this->transferencia->setTrn_contenido = $_REQUEST ['trn_contenido'];
        $this->transferencia->setTrn_uni_origen = $_REQUEST ['trn_uni_origen'];
        $this->transferencia->setTrn_uni_destino = $_REQUEST ['trn_uni_destino'];
        //$this->transferencia->setTrn_confirmado = 2;
        $this->transferencia->setTrn_fecha_crea = date('Y-m-d');
        $this->transferencia->setTrn_usuario_orig = $_SESSION ['USU_ID'];

        $this->transferencia->setTrn_usuario_crea = $_SESSION ['USU_ID'];
        $this->transferencia->setTrn_usuario_des = $_REQUEST ['trn_usuario_des'];
        //$this->transferencia->setTrn_estado = 1;


        $this->transferencia->insert();
        echo "OK";
        //Header ( "Location: " . PATH_DOMAIN . "/transferencia/" );
    }
    
    function view() {
        $this->transferencia = new tab_soltransferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);
        $row = $this->transferencia->dbselectByField("str_id", VAR3);
        $row = $row [0];
        
//        $this->registry->template->trn_id = $row->trn_id;
//        $this->registry->template->trn_descripcion = $row->trn_descripcion;
//        $this->registry->template->trn_contenido = $row->trn_contenido;
//        $this->registry->template->trn_uni_origen = $row->trn_uni_origen;
//        $this->registry->template->trn_uni_destino = $row->trn_uni_destino;
//        $this->registry->template->trn_confirmado = $row->trn_confirmado;
//        $this->registry->template->trn_fecha_crea = $row->trn_fecha_crea;
//        $this->registry->template->trn_usuario_crea = $row->trn_usuario_crea;
//        $this->registry->template->trn_estado = $row->trn_estado;

        
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_transferencia.tpl');
        $this->registry->template->show('footer');
    }

    function viewTree() {


        $this->trans = new tab_soltransferencia ();
        $rowx = $this->trans->dbselectBy2Field("str_id", VAR3, "str_estado", 1);
        $trn = $rowx [0];

        

        
//        $this->tra = new tab_transferencia ();
//        $tra = $this->tra->dbselectByField("trn_id", VAR3);
//        $tra = $tra [0];
        
        $usuario = new usuario();
        $usu_origen = $usuario->getDatos($trn->usu_id);
        $usu_destino = $usuario->getDatos($trn->usud_id);

//        $rows = $this->expediente->dameDatosExp($tra->exp_id);
//        $exp = $rows[0];
        
        //$this->registry->template->exp_id = VAR3;
        //$this->registry->template->exp_nombre = $exp->exp_nombre;
        $this->registry->template->str_id = VAR3;
        $this->registry->template->exp_id = "";
        $this->registry->template->exp_nombre = "";
        
        $this->registry->template->trn_fecha_crea = $trn->str_fecha;
        $this->registry->template->trn_descripcion = "";

        
        $this->registry->template->unidad = $usu_origen->uni_codigo . ' - ' . $usu_origen->uni_descripcion;
        $this->registry->template->usuario = $usu_origen->usu_nombres . ' ' . $usu_origen->usu_apellidos;
        $this->registry->template->usu_destino = $usu_destino->usu_nombres . ' ' . $usu_destino->usu_apellidos;
        
//        $this->expediente = new expediente ();
//        $tree = $this->expediente->searchcoTree($trn->exp_id);        
//        $this->registry->template->tree = $tree;
        $this->registry->template->tree = "";

        
        
//        $contenedor = new contenedor ();
        $this->registry->template->contenedores = "";
        $this->registry->template->suc_id = "";
        
        
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "coTree";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->VAR3 = VAR3;
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = "CONFIRMAR TRANSFERENCIA";
        $this->registry->template->show('header');
        $this->registry->template->show('tab_cotransferencia.tpl');
        $this->registry->template->show('footer');
        
        
    }

    
    function loadExp() {
        $this->series = new series ();
        $this->expediente = new tab_expediente ();
        $this->expediente->setRequest2Object($_REQUEST);
        $this->usuario = new usuario ();
        //$tipo = $this->usuario->getTipo($_SESSION ['USU_ID']);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'tab_expediente.exp_fecha_exf';
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
                $where .= " and tab_expediente.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query!='TODOS'){
                    $where .= " and tab_series.ser_categoria LIKE '%$query%' ";
                }
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nom%' OR tab_usuario.usu_apellidos LIKE '%$nom%') ";
                }
            }else{
                if ($query=='TODOS'){
                    $where .= "";
                }else{
                    $where .= " and $qtype LIKE '%$query%' ";
                }
            }
                
        }

        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                    (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                    FROM tab_retensiondoc 
                    WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                    tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expfondo.exf_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expfondo.exf_estado = 1                
                AND tab_expusuario.eus_estado = 1 
                 $where $sort $limit";

        $expediente = new expediente ();
        $result = $this->expediente->dbselectBySQL($sql);
        $total = $expediente->countExp2($where);

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
            
            $chk = "<input id=\"chk_" . $un->exp_id . "\" restric=\"" . $un->exp_id . "\" class=\"exp_chk\" type=\"checkbox\" value=\"" . $un->exp_id . "\" />";
            
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->exp_id . "',";            
            $json .= "cell:['" . $un->exp_id . "'";            
            $json .= ",'" . $chk . "'";
            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo .  DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            //$json .= ",'" . addslashes($un->exp_descripcion) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($expediente->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;

    }
    
    
    function coTree() {
        $this->tra = new Tab_transferencia();
        $this->tra->setRequest2Object($_REQUEST);

        $rows = $this->tra->dbselectByField("trn_id", VAR3);
        $tra = $rows[0];


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
        $tusu->eus_fecha_crea = date("Y-m-d");
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
            } else {
                $con = new expcontenedor ();
                $datos['exc_id'] = $con->saveExpCont($suc_id, $tra->exp_id);
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
            $tarc->exa_fecha_crea = date("Y-m-d");
            $tarc->exa_usuario_crea = $_SESSION ['USU_ID'];
            $tarc->exa_estado = 1;
            $datos ['eus_id'] = $tarc->insert();
        }

        $this->tra->updateValue("trn_estado", 2, $tra->trn_id);
        Header("Location: " . PATH_DOMAIN . "/cotransferencia/");
    }
    
    function update() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        $this->transferencia->setTrn_id = $_REQUEST ['trn_id'];
        $this->transferencia->setExp_id = $_REQUEST ['exp_id'];
        $this->transferencia->setTrn_descripcion = $_REQUEST ['trn_descripcion'];
        $this->transferencia->setTrn_contenido = $_REQUEST ['trn_contenido'];
        $this->transferencia->setTrn_uni_origen = $_REQUEST ['trn_uni_origen'];
        $this->transferencia->setTrn_uni_destino = $_REQUEST ['trn_uni_destino'];
        $this->transferencia->setTrn_confirmado = $_REQUEST ['trn_confirmado'];
        $this->transferencia->setTrn_fecha_crea = $_REQUEST ['trn_fecha_crea'];
        $this->transferencia->setTrn_usuario_crea = $_REQUEST ['trn_usuario_crea'];
        $this->transferencia->setTrn_estado = $_REQUEST ['trn_estado'];

        $this->transferencia->update();
        Header("Location: " . PATH_DOMAIN . "/transferencia/");
    }

    function delete() {
        $this->transferencia = new tab_transferencia ();
        $this->transferencia->setRequest2Object($_REQUEST);

        $this->transferencia->setTrn_id($_REQUEST ['trn_id']);
        $this->transferencia->setTrn_estado(2);

        $this->transferencia->update();
    }

    function obtenerSuc() {
        $subcontenedor = new subcontenedor();
        $res = $subcontenedor->selectSuc(0, $_REQUEST['Con_id']);
        echo $res;
    }
    function recarga(){
       $id_transf=$_REQUEST['valor'];
      $usuario=$_SESSION['USU_ID'];
    $tab_soltransferencia=new tab_soltransferencia();
    $tab_expusuario=new tab_expusuario();
    $tab_extransferencia=new tab_exptransferencia();
    
    $tab_soltransferencia->updateMult("str_estado",1, $id_transf);
    $result=$tab_extransferencia->dbSelectBySQL("select* from tab_exptransferencia where str_id=$id_transf");
    
    foreach($result as $row){
        $ids_exp=$tab_expusuario->dbSelectBySQL("select* from tab_expusuario where exp_id=$row->exp_id and usu_id=$usuario and eus_estado=2");
        foreach ($ids_exp as $listUpdate){
            $tab_expusuario->updateMult("eus_estado",1,$listUpdate->eus_id);
        }
    }
      
    }
    function listado(){
  
        $this->uni = new unidad ();
        $this->usu = new usuario ();
        
        $sol_trasnferencia=new tab_soltransferencia();
        $rowt=$sol_trasnferencia->dbselectByField("str_id", VAR3);
        $rowt=$rowt[0];
        $nombre=$this->usu->ObtenerUsuarioTranferencia($rowt->usu_id);
        $this->registry->template->str_id = "";
        $this->registry->template->trn_uni_destino = $this->uni->obtenerSelectUnidades();
        $this->registry->template->trn_usuario_des = ""; 
        //$this->usu->listUsuariosOper($_SESSION ['USU_ID'],$ins_id);
 
        
        $this->series = new series ();
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();
        $this->registry->template->PATH_A = $this->series->loadMenu($adm, "test");
        $this->registry->template->PATH_B = $this->series->loadMenu($adm, "test2");

        $this->registry->template->titulo = "Expedientes de ".$nombre;
        $this->registry->template->titulo2 = "Expedientes transferidos";          
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;        
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $this->menu = new menu ();
        $this->liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $this->liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('transferencia/tab_list_confirmar.tpl');
        $this->registry->template->show('footer');
        
    }
 function gridtransferencia(){
     
        $id_trans=VAR3;
        $usuario=$_SESSION ['USU_ID'];
        $this->series = new series ();
        $this->expediente = new tab_expediente ();
        $this->expediente->setRequest2Object($_REQUEST);
        $this->usuario = new usuario ();
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'tab_expediente.exp_fecha_exf';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = "ORDER BY $sortname $sortorder ";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        $limit = "LIMIT $rp OFFSET $start ";
        $query = utf8_encode($_REQUEST ['query']);
        $qtype = $_REQUEST ['qtype'];
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where .= " and tab_expediente.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                if ($query=='TODOS'){
                    $where .= "";
                }
                else{
                    $where .= " and tab_series.ser_categoria LIKE '%$query%' ";
                }
            elseif ($qtype == 'custodio') {
                $nomArray = explode(" ", $query);
                foreach ($nomArray as $nom) {
                    $where .= " and (tab_usuario.usu_nombres LIKE '%$nom%' OR tab_usuario.usu_apellidos LIKE '%$nom%') ";
                }
            }else{
                if ($query=='TODOS'){
                    $where .= "";
                }else{
                    $where .= " and $qtype LIKE '%$query%' ";
                }
            }
                
        }
 $where2="";
    $tab_expusuario=new tab_expusuario();
    $tab_extransferencia=new tab_exptransferencia();
    $result=$tab_extransferencia->dbSelectBySQL("select* from tab_exptransferencia where str_id=$id_trans");
    $cantidad=count($result);
    $valor3="";
    $t=1;
    foreach($result as $row){
        $nuevo=$tab_expusuario->dbSelectBySQL("select* from tab_expusuario where exp_id=".$row->exp_id." and usu_id=$usuario and eus_estado=2");
        foreach($nuevo as $list){
             $valor3.="tab_expusuario.eus_id=".$list->eus_id."";
					if($t<$cantidad){
                                        $valor3.=" or ";}
				$t++;
            
        }
    }      
        
       $where.= " AND $valor3 ";            
       
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo,
                tab_expediente.exp_codigo,
                tab_unidad.uni_id,
                tab_series.ser_id,
                tab_expediente.exp_id,
                tab_series.ser_categoria,
                tab_expisadg.exp_titulo,
                tab_expisadg.exp_fecha_exi,
                (tab_expisadg.exp_fecha_exi + 
                    (SELECT tab_retensiondoc.red_prearc * INTERVAL '1 year' 
                    FROM tab_retensiondoc 
                    WHERE tab_retensiondoc.red_id = tab_series.red_id)) ::DATE AS exp_fecha_exf,
                    tab_usuario.usu_nombres,
                tab_usuario.usu_apellidos,
                tab_expfondo.exf_estado
                FROM
                tab_unidad
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id
                INNER JOIN tab_expfondo ON tab_expediente.exp_id = tab_expfondo.exp_id
                INNER JOIN tab_expusuario ON tab_expediente.exp_id = tab_expusuario.exp_id
                INNER JOIN tab_expisadg ON tab_expediente.exp_id = tab_expisadg.exp_id
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                INNER JOIN tab_usuario ON tab_usuario.usu_id = tab_expusuario.usu_id
                WHERE
                tab_expusuario.usu_id = " . $_SESSION['USU_ID'] . "
                AND tab_series.ser_estado = 1
                AND tab_expediente.exp_estado = 1
                AND tab_usuario.usu_estado = 1
                AND tab_expfondo.exf_estado = 1                
                 AND tab_expusuario.eus_estado =2
                $where $sort $limit";

        $expediente = new expediente ();
        $result = $this->expediente->dbselectBySQL($sql);
        //$total=$this->expediente->countBySQL($sql);
        $total = $expediente->countExp2($where);
      
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;$j=1;
        $si=0;
        foreach ($result as $un) {
               $chk = "<input id=\"chk_" . $un->exp_id . "\" restric=\"" . $un->exp_id . "\" class=\"fil_chk".$j."\"   checked=\"checked\" type=\"checkbox\" value=\"" . $un->exp_id . "\"   />";
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->exp_id . "',";            
            $json .= "cell:['" . $un->exp_id . "'";            
            $json .= ",'" . $chk . "'";
            
            $json .= ",'" . addslashes($un->fon_cod . DELIMITER . $un->uni_cod . DELIMITER . $un->tco_codigo . DELIMITER . $un->ser_codigo .  DELIMITER . $un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->exp_titulo) . "'";
            //$json .= ",'" . addslashes($un->exp_descripcion) . $un->exp_titulo "'";
            $json .= ",'" . addslashes($un->exp_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exp_fecha_exf) . "'";
            $json .= ",'" . addslashes($expediente->obtenerCustodios($un->exp_id)) . "'";
            $json .= "]}";
            $rc = true;
            $i++;$j++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;


 }
}

?>
