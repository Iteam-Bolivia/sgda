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
class perfilController Extends baseController
{
	function index() {
		$unidad = new unidad();
		$this->registry->template->usu_id = "";
		$this->registry->template->PATH_WEB = PATH_WEB;
		$this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
		$this->registry->template->PATH_EVENT = "add";
		$this->registry->template->GRID_SW = "false";
		$this->registry->template->FORM_SW = "display:none;";
		$this->registry->template->PATH_J = "jquery";
		$this->menu = new menu();
		$this->liMenu=$this->menu->imprimirMenu(VAR1,$_SESSION['USU_ID']);
		$this->registry->template->men_titulo = $this->liMenu;
		
		$this->registry->template->show('header');
		$this->registry->template->show('tab_usuariog.tpl');
	}
	function edit() {
            Header("Location: ".PATH_DOMAIN."/perfil/view/".$_REQUEST["usu_id"]."/");
	}
	function view() {
            
		$this->usuario = new tab_usuario();
		$row = $this->usuario->dbselectByField("usu_id",$_SESSION['USU_ID']);
		$row = $row[0];
		$this->registry->template->usu_id = $row->usu_id;
		$this->registry->template->titulo = "Perfil del Usuario";
		$this->registry->template->usu_nombres = $row->usu_nombres;
		$this->registry->template->usu_apellidos = $row->usu_apellidos;
		$this->registry->template->usu_fono = $row->usu_fono;
		$this->registry->template->usu_email = $row->usu_email;
		$this->registry->template->usu_nro_item = $row->usu_nro_item;

		$this->registry->template->usu_login = $row->usu_login;
		$contenedor = new contenedor(); 
		$this->registry->template->listaContenedorUsuario =$contenedor->listaContenedorUsuario($_SESSION['USU_ID']);
		$this->menu = new menu();
		$this->liMenu=$this->menu->imprimirMenu(VAR1,$_SESSION['USU_ID']);
		$this->registry->template->men_titulo = $this->liMenu;
		
		$this->registry->template->PATH_WEB = PATH_WEB;
		$this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
		$this->registry->template->PATH_EVENT = "update";
		$this->registry->template->PATH_EVENT_DIALOG = "updatePass";
		$this->registry->template->PATH_J = "jquery";
		$this->registry->template->GRID_SW = "true";
		$this->registry->template->FORM_SW = "";
		$this->registry->template->show('header');
		$this->registry->template->show('tab_perfil.tpl');
	}
	function load() {

		$this->unidad = new unidad();
		$this->usuario = new tab_usuario();
		$this->usuario->setRequest2Object($_REQUEST);
		$page = $_REQUEST['page'];
		$rp = $_REQUEST['rp'];
		$sortname = $_REQUEST['sortname'];
		$sortorder = $_REQUEST['sortorder'];
		if (!$sortname) $sortname = 'usu_id';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		if (!$page) $page = 1;
		if (!$rp) $rp = 15;
		$start = (($page-1) * $rp);
		$limit = "LIMIT $rp OFFSET $start ";
		$query = $_REQUEST['query'];
		$qtype = $_REQUEST['qtype'];
		$where = "";
		if ($query){
			$where = " WHERE $qtype LIKE '%$query%' ";
			$sql = "SELECT * FROM tab_usuario $where and usu_estado = 1 $sort $limit "; 
		}else{
			$sql = "SELECT * FROM tab_usuario WHERE usu_estado = 1 $sort $limit ";
		}
		$result = $this->usuario->dbselectBySQL($sql);
		$total = $this->usuario->count("usu_estado",1);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		$i=0;
		foreach ($result as $un)
		{
			if($un->usu_leer_doc=='1') $leer_doc="SI";
			elseif($un->usu_leer_doc=='2') $leer_doc="NO";
			else $leer_doc=" ";		
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$un->usu_id."',";
			$json .= "cell:['".$un->usu_id."'";
			$json .= ",'".addslashes($this->unidad->dameDatosUnidad($un->uni_id)->uni_codigo)."'";
			$json .= ",'".addslashes($un->usu_nombres)."'";
			$json .= ",'".addslashes($un->usu_apellidos)."'";
			$json .= ",'".addslashes($un->usu_fono)."'";
			$json .= ",'".addslashes($un->usu_email)."'";
			$json .= ",'".addslashes($un->usu_nro_item)."'";
			$json .= ",'".addslashes($leer_doc)."'";
			$json .= ",'".addslashes($un->usu_pass_dias)."'";
			$json .= ",'".addslashes($un->usu_crear_doc)."'";
			
			$json .= "]}";
			$rc = true;
			$i++;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;


	}


	function update() {
		$this->usuario = new tab_usuario();
		$this->usuario->setRequest2Object($_REQUEST);
		$this->usuario->update();
                $id = $this->usuario->usu_id;
                if($_REQUEST['usu_email']=='')
                    $this->usuario->updateValue("usu_email", '', $id);
                if($_REQUEST['usu_fono']=='')
                    $this->usuario->updateValue("usu_fono", '', $id);
                if($_REQUEST['usu_nro_item']=='')
                    $this->usuario->updateValue("usu_nro_item", '', $id);
		Header("Location: ".PATH_DOMAIN."/login/show/");
	}
        function updatePass() {
		$this->usuario = new tab_usuario();
		$this->usuario->setRequest2Object($_REQUEST);
		$this->usuario->setUsu_id($_SESSION['USU_ID']);
		$this->usuario->setUsu_pass(md5($_REQUEST['pass3']));
		$this->usuario->update();
		Header("Location: ".PATH_DOMAIN."/perfil/view/");
	}
}
?>
