<?php

/**
 * prestamosController.php Controller
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class prestamosController Extends baseController {

    function index() {
        $series = new series ();
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();        
        $menuS = $series->loadMenu($adm, "test");
        $menuS2 = $series->loadMenu($adm, "test2");
        
        $this->registry->template->PATH_A = $menuS;
        $this->registry->template->PATH_B = $menuS2;
        $this->registry->template->pre_id = "";
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "add";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery";
        $menu = new menu();
        $liMenu = $menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerG');
        $this->registry->template->show('tab_prestamosg.tpl');
        $this->registry->template->show('footer');

    }

    function load() {
        $prestamos = new tab_prestamos();
        $prestamos->setRequest2Object($_REQUEST);
        //$inst = new institucion();
        //$ins_fondo = $inst->getFondoUsu($_SESSION['USU_ID']);

        $page = $_REQUEST['page'];
        $rp = $_REQUEST['rp'];
        $sortname = $_REQUEST['sortname'];
        $sortorder = $_REQUEST['sortorder'];
        if (!$sortname)
            $sortname = 'pre_id';
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
            if ($qtype == 'pre_id')
                $where = " AND $qtype = '$query' ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }

//        $tipo = $_SESSION['ROL_COD'];
//        if ($tipo == 'SUBF') {
//            $where .= " AND ef.fon_id='2' ";
//        } elseif ($tipo == 'ACEN') {
//            $where .= " AND ef.fon_id='3' ";
//        } elseif ($tipo == 'OPE') {
//            //$where .= " AND e.usu_id ='" . $_SESSION['USU_ID'] . "' ";
//            $where .= " AND ef.fon_id='1' ";
//        } else {
//            $where .= " AND ef.fon_id='1' ";
//        }
        
        /*         * *************** */
//        $sql = "SELECT DISTINCT
//            p.pre_id,p.exp_id,p.uni_id,un.uni_descripcion,int.int_descripcion,p.pre_sigla_of,p.pre_solicitante,
//            p.pre_doc_aval,p.pre_descripcion,p.pre_justificacion,
//            p.pre_fecha_pres,p.pre_fecha_dev,s.ser_categoria,e.exp_nombre,e.exp_descripcion,e.exp_codigo
//            FROM tab_prestamos AS p
//            Inner Join tab_expediente AS e ON e.exp_id = p.exp_id
//            Inner Join tab_series AS s ON s.ser_id = e.ser_id
//            Inner Join tab_expusuario AS u ON u.exp_id = e.exp_id
//            Inner Join tab_usuario AS us ON u.usu_id = us.usu_id
//            Left Join tab_unidad AS un ON us.uni_id = un.uni_id
//            Inner Join tab_expfondo AS ef ON e.exp_id = ef.exp_id
//            Left Join tab_institucion AS int ON p.pre_institucion = int.int_id
//            WHERE
//            p.pre_estado =  '1' AND
//            u.eus_estado =  '1' AND
//            ef.exf_estado =  '1'  $where $sort $limit";
        
        $sql = "SELECT
                tab_solprestamo.spr_id,
                tab_solprestamo.spr_fecha,
                (SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_solprestamo.uni_id) AS uni_id,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usu_id) AS usu_id,
                tab_solprestamo.spr_solicitante,
                tab_solprestamo.spr_email,
                tab_solprestamo.spr_tel,
                tab_solprestamo.spr_fecent,
                tab_solprestamo.spr_fecren,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usua_id) AS usua_id,
                (SELECT usu_nombres || ' ' || usu_apellidos from tab_usuario WHERE usu_id=tab_solprestamo.usur_id) AS usur_id,
                tab_solprestamo.spr_fecdev,
                tab_solprestamo.spr_obs,
                tab_solprestamo.spr_estado
                FROM
                tab_solprestamo
                WHERE
                tab_solprestamo.spr_estado = 1 AND
                tab_solprestamo.usur_id = 3 
                $root $where $sort $limit ";
        
        $result = $prestamos->dbselectBySQL($sql);
        $prestamo = new prestamos();
        $total = $prestamo->count($where);
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
            $json .= "id:'" . $un->spr_id . "',";
            $json .= "cell:['" . $un->spr_id . "'";
            /* $json .= ",'".addslashes($un->ser_categoria)."'"; */
            $json .= ",'" . addslashes($un->spr_fecha) . "'";
            $json .= ",'" . addslashes($un->uni_id) . "'";
            $json .= ",'" . addslashes($un->usu_id) . "'";
            $json .= ",'" . addslashes($un->spr_solicitante) . "'";
            $json .= ",'" . addslashes($un->spr_fecent) . "'";
            $json .= ",'" . addslashes($un->spr_fecren) . "'";
            $json .= ",'" . addslashes($un->usua_id) . "'";
            $json .= ",'" . addslashes($un->usur_id) . "'";
            $json .= ",'" . addslashes($un->spr_fecdev) . "'";
            $json .= ",'" . addslashes($un->spr_obs) . "'";            
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }    
    
    
    function loadExp() {
        $texpediente = new tab_expediente ();
        $texpediente->setRequest2Object($_REQUEST);
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
        $where = "";
        if ($query != "") {
            if ($qtype == 'exp_id')
                $where = " and te.exp_id LIKE '$query' ";
            else
                $where = " and $qtype LIKE '%$query%' ";
        }


        $tipo = $_SESSION['ROL_COD'];
        if ($tipo == 'SUBF') {
            $where .= " AND ef.fon_id='2' ";
        } elseif ($tipo == 'ACEN') {
            $where .= " AND ef.fon_id='3' ";
        } elseif ($tipo == 'OPE') {
            $where .= " AND eu.usu_id ='" . $_SESSION['USU_ID'] . "' ";
            $where .= " AND ef.fon_id='1' ";
        } else {
            $where .= " AND ef.fon_id='1' ";
        }
        /*         * *************** */
        $where .= " AND te.exp_id NOT IN(SELECT p.exp_id FROM tab_prestamos p WHERE p.pre_estado='1' AND p.exp_id=te.exp_id) ";
        
        
        $sql = "SELECT DISTINCT te.exp_id, te.exp_nombre, te.exp_descripcion,te.exp_codigo, ts.ser_categoria,
            ef.exf_fecha_exi, ef.exf_fecha_exf
            FROM
            tab_expediente AS te
            Inner Join tab_expusuario AS eu ON eu.exp_id = te.exp_id
            Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
            Inner Join tab_usuario AS tu ON eu.usu_id = tu.usu_id
            Inner Join tab_unidad AS un ON tu.uni_id = un.uni_id
            Inner Join tab_expfondo AS ef ON ef.exp_id = te.exp_id
            WHERE
            eu.eus_estado =  '1' AND
            te.exp_estado =  '1' AND
            ef.exf_estado =  '1' $where $sort $limit ";

        $exp = new expediente ();
        $total = $exp->countPorFondo($where);
        //countExpPrest($qtype, $query, $adm );

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
            $json .= ",'" . addslashes($un->exf_fecha_exi) . "'";
            $json .= ",'" . addslashes($un->exf_fecha_exf) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }
    
    
    function add() {
        $exp = new Tab_expediente();
        $exp = new Tab_expediente();
        $expn = $exp->dbSelectBySQL("SELECT exp_nombre,exp_codigo FROM tab_expediente WHERE exp_id='" . VAR3 . "'");
        $this->registry->template->pre_id = "";
        $this->registry->template->exp_id = VAR3;
        $this->registry->template->exp_nombre = $expn[0]->exp_nombre;
        $this->registry->template->exp_codigo = $expn[0]->exp_codigo;
        $this->registry->template->pre_sigla_of = "";
        $this->registry->template->pre_solicitante = "";
        $inst = new institucion();
        $this->registry->template->pre_institucion = $inst->obtenerSelect();
        $unidad = new unidad ();
        $this->registry->template->uni_id = $unidad->obtenerSelect();
        $this->registry->template->pre_doc_aval = "";
        $this->registry->template->pre_descripcion = "";
        $this->registry->template->pre_justificacion = "";
        $this->registry->template->pre_tipo = "";
        $hoy = date("Y-m-d");
        $this->registry->template->hoy = '+0D';
        $this->registry->template->pre_fecha_pres = $hoy;
        $this->registry->template->pre_fecha_dev = $hoy;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "save";
        $this->registry->template->GRID_SW = "false";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_prestamos.tpl');
        $this->registry->template->show('footer');
    }

    function save() {
        $this->prestamos = new tab_prestamos();
        $this->prestamos->setRequest2Object($_REQUEST);

        $this->prestamos->setPre_id($_REQUEST['pre_id']);
        $this->prestamos->setExp_id($_REQUEST['exp_id']);
        $this->prestamos->setUni_id($_REQUEST['uni_id']);
        $this->prestamos->setPre_sigla_of($_REQUEST['pre_sigla_of']);
        $this->prestamos->setPre_solicitante($_REQUEST['pre_solicitante']);
        $this->prestamos->setPre_institucion($_REQUEST['pre_institucion']);
        $this->prestamos->setPre_doc_aval($_REQUEST['pre_doc_aval']);
        $this->prestamos->setPre_descripcion("");
        $this->prestamos->setPre_justificacion($_REQUEST['pre_justificacion']);
        $this->prestamos->setPre_tipo(1);
        $this->prestamos->setPre_fecha_pres($_REQUEST['pre_fecha_pres']);
        $this->prestamos->setPre_fecha_dev($_REQUEST['pre_fecha_dev']);
        $this->prestamos->setPre_usu_reg($_SESSION['USU_ID']);
        $this->prestamos->setPre_fecha_reg(date("Y-m-d"));
        $this->prestamos->setPre_estado(1);
        $this->prestamos->insert();
        $arch = new Tab_exparchivo();
        $arch->updateValueOne("exa_condicion", "2", "exp_id", $_REQUEST['exp_id']);
        Header("Location: " . PATH_DOMAIN . "/prestamos/");
    }

    function update() {
        $tprestamos = new tab_prestamos();
        $tprestamos->setRequest2Object($_REQUEST);
        $tprestamos->setPre_id($_REQUEST['pre_id']);
        $tprestamos->setExp_id($_REQUEST['exp_id']);
        $tprestamos->setPre_sigla_of($_REQUEST['pre_sigla_of']);
        $tprestamos->setPre_solicitante($_REQUEST['pre_solicitante']);
        $tprestamos->setPre_institucion($_REQUEST['pre_institucion']);
        $tprestamos->setPre_doc_aval($_REQUEST['pre_doc_aval']);
        $tprestamos->setPre_justificacion($_REQUEST['pre_justificacion']);
        $tprestamos->setPre_fecha_pres($_REQUEST['pre_fecha_pres']);
        $tprestamos->setPre_fecha_dev($_REQUEST['pre_fecha_dev']);
        $tprestamos->setPre_usu_mod($_SESSION['USU_ID']);
        $tprestamos->setPre_fecha_mod(date("Y-m-d"));

        $tprestamos->update();
        Header("Location: " . PATH_DOMAIN . "/prestamos/");
    }


 
    
    function edit() {
        header("Location: " . PATH_DOMAIN . "/prestamos/view/" . $_REQUEST["pre_id"] . "/");
    }

    function view() {
        if(! VAR3){ die("Error del sistema 404"); }
        $this->prestamos = new tab_prestamos();
        $this->prestamos->setRequest2Object($_REQUEST);
        $row = $this->prestamos->dbselectByField("pre_id", VAR3);
        if(! $row){ die("Error del sistema 404"); }
        $row = $row[0];
        $exp = new Tab_expediente();
        $expn = $exp->dbSelectBySQL("SELECT exp_nombre,exp_codigo FROM tab_expediente WHERE exp_id='" . $row->exp_id . "'");

        $this->registry->template->pre_id = $row->pre_id;
        $this->registry->template->exp_id = $row->exp_id;
        $this->registry->template->exp_nombre = $expn[0]->exp_nombre;
        $this->registry->template->exp_codigo = $expn[0]->exp_codigo;
        $this->registry->template->pre_sigla_of = $row->pre_sigla_of;
        $this->registry->template->pre_solicitante = $row->pre_solicitante;
        $unidad = new unidad();
        $this->registry->template->uni_id = $unidad->obtenerSelect($row->uni_id);
        
        $inst = new institucion();
        $this->registry->template->pre_institucion = $inst->obtenerSelect($row->pre_institucion);
        $this->registry->template->pre_doc_aval = $row->pre_doc_aval;
        $this->registry->template->pre_descripcion = $row->pre_descripcion;
        $this->registry->template->pre_justificacion = $row->pre_justificacion;
        $this->registry->template->pre_tipo = $row->pre_tipo;
        $this->registry->template->pre_fecha_pres = $row->pre_fecha_pres;
        $this->registry->template->pre_fecha_dev = $row->pre_fecha_dev;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->menu = new menu();
        $liMenu = $this->menu->imprimirMenu(VAR1, $_SESSION['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->show('headerF');
        $this->registry->template->show('tab_prestamos.tpl');
        $this->registry->template->show('footer');
    }


    function delete() {
        $tprestamos = new tab_prestamos();
        $tprestamos->setRequest2Object($_REQUEST);
        $tprestamos->setPre_id($_REQUEST['pre_id']);
        $tprestamos->setPre_descripcion($_REQUEST['pre_descripcion']);
        $tprestamos->setPre_estado(2);
        $tprestamos->update();
        $expediente = $tprestamos->dbSelectBySQL("SELECT exp_id FROM tab_prestamos WHERE pre_id='" . $_REQUEST['pre_id'] . "' ");
        $arch = new Tab_exparchivo();
        $arch->updateValueOne("exa_condicion", "1", "exp_id", $expediente[0]->exp_id);
        $arch->updateValueOne("exa_fecha_mod", date("Y-m-d"), "exp_id", $expediente[0]->exp_id);
        $arch->updateValueOne("exa_usuario_mod", $_SESSION['USU_ID'], "exp_id", $expediente[0]->exp_id);
    }

    function devolver() {
        $tprestamos = new tab_prestamos();
        $tprestamos->setRequest2Object($_REQUEST);
        $pre_id = $_REQUEST['pre_id'];
        /* $contenedor = new contenedor();
          $contenedor->obtenerDescripcion($exp_id);
          $des_conten = $contenedor['ctp_codigo']." ".$contenedor['con_codigo']; */
        $sql = "SELECT
            te.exp_id,
            te.exp_nombre,
            te.exp_codigo,
            tp.pre_id,
            tp.pre_doc_aval,
            tp.pre_justificacion,
            tp.pre_solicitante,
            tp.pre_institucion,
            tp.pre_fecha_pres,
            tp.pre_fecha_dev,
            (SELECT (ctp_codigo || ' ' || con_codigo) FROM tab_expcontenedor ec
		INNER JOIN tab_subcontenedor sc ON sc.suc_id = ec.suc_id
		INNER JOIN tab_contenedor c ON sc.con_id = c.con_id
		INNER JOIN tab_tipocontenedor tc ON tc.ctp_id = c.ctp_id
		WHERE ec.exp_id=tp.exp_id AND ec.exc_estado = '1' ) AS ubicacion
            FROM
            tab_prestamos AS tp
            Inner Join tab_expediente AS te ON te.exp_id = tp.exp_id
            WHERE
            tp.pre_id =  '$pre_id' ";
        $result = $tprestamos->dbselectBySQL2($sql);
        echo json_encode($result);
    }       
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function rpt() {
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Prestamo');
        //$pdf->SetSubject ( 'Importacion Sub' );
        $pdf->SetKeywords('VIPFE, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "VIPFE", "Prueba reporte");

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$pdf->setFooterFont ( Array (PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA ) );
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetFooterMargin ( PDF_MARGIN_FOOTER );
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 8);

        // add a page
        $pdf->AddPage();

        // -----------------------------------------------------------------------------
        $this->prestamos = new tab_prestamos();
        $this->usuario = new usuario();
        $adm = $this->usuario->esAdm();
        $this->tab_importacion = new tab_importacion ();
        $this->tab_importacion->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'pre_id';
        if (!$sortorder)
            $sortorder = 'desc';
        if ($sortorder == "sasc")
            $sortorder = 'asc';
        else
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
            if ($qtype == 'pre_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " AND exp_id IN (SELECT e.exp_id FROM tab_expediente e
                Inner Join tab_series s ON e.ser_id = s.ser_id WHERE s.ser_categoria LIKE '%$query%') ";
            elseif ($qtype == 'exp_codigo')
                $where = " AND exp_id IN (SELECT e.exp_id FROM tab_expediente e WHERE e.exp_codigo LIKE '%$query%') ";
            elseif ($qtype == 'exp_nombre')
                $where = " AND exp_id IN (SELECT e.exp_id FROM tab_expediente e WHERE e.exp_nombre LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        if (!$adm) {
            $where .= " AND p.exp_id IN (SELECT exp_id FROM tab_expusuario WHERE usu_id='" . $_SESSION['USU_ID'] . "' AND eus_estado = '1') ";
        }
        $sql = "SELECT * FROM tab_prestamos WHERE pre_estado = 1";
        $result = $this->prestamos->dbselectBySQL($sql);
        $prestamo = new prestamos();
        $total = $prestamo->count($qtype, $query, $adm);
        $rc = false;
        $i = 0;
        $cadena = "";
        foreach ($result as $un) {
            $exp = new Tab_expediente();
            $expn = $exp->dbSelectBySQL("SELECT ser_id, exp_codigo, exp_nombre, exp_id FROM tab_expediente WHERE exp_id='" . $un->exp_id . "'");
            $ser = new Tab_series();
            $sern = $ser->dbSelectBySQL("SELECT ser_categoria FROM tab_series WHERE ser_id='" . $expn[0]->ser_id . "'");
            //$cadena .= "  <tr>";
            $cadena = $cadena . "<tr>";
            $cadena .= '    <th width="25" align="center">' . addslashes($un->pre_id) . '</th>';
            $cadena .= '    <td width="245" style="font-size: 22px;">' . addslashes($expn[0]->exp_nombre) . '</td>';
            $cadena .= '    <td width="60" align="center" style="font-size: 22px;">' . addslashes($expn[0]->exp_id) . '</td>';
            $cadena .= '    <td width="62" align="center" style="font-size: 22px;">' . addslashes($un->pre_solicitante) . '</td>';
            $cadena .= '    <td width="74" align="center" style="font-size: 22px;">2</td>';
            $cadena .= '    <td width="84" align="center" style="font-size: 22px;">3</td>';
            $cadena .= '    <td width="69" align="center" style="font-size: 22px;">4</td>';
            $cadena .= '    <td width="81" align="center" style="font-size: 22px;">5</td>';
            $cadena .= '    <td width="60" align="center" style="font-size: 22px;">' . addslashes($un->pre_fecha_dev) . '</td>';
            $cadena .= '    <td width="216" style="font-size: 22px;"></td>';
            $cadena .= '  </tr>';
        }
        // -----------------------------------------------------------------------------
        // NON-BREAKING ROWS (nobr="true")

        $unidad = "UNIDAD DE SEGUIMIENTO DE PROYECTOS";
        $tbl = <<<EOD
		<p align="right"><strong>Nro de Reporte................</strong></p>
		<p align="center"><strong>ARCHIVO DE OFICIINA</strong></p>
		<p align="center"><strong>DIRECCION</strong>VIPFE</p>
		<p align="center"><strong>UNIDAD</strong> $unidad </p>
		<p align="center"><strong>FORMULARIO DE PRESTAMO DE DOCUMENTOS</strong></p>
		<table width="1233" border="1" bordercolor="#000000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
		  <tr>
		    <th width="25" align="center" style="font-size: 18px;"><strong>N� DE ORDEN</strong></th>
		    <th width="245" align="center" style="font-size: 18px;"><strong>TITULO DEL DOCUMENTO SOLICITADO</strong></th>
		    <th width="60" align="center" style="font-size: 18px;"><strong>C�DIGODEL DOCUMENTO</strong></th>
		    <th width="62" align="center" style="font-size: 18px;"><strong>FOJAS</strong></th>
		    <th colspan="4" width="308" align="center" style="font-size: 18px;"><p><strong>LOCALIZACION TOPOGRAFICA</strong></p>
		    <table width="308" height="24" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
		      <tr>
		    <td width="74" align="center" style="font-size: 18px;"><strong>ESTANTE</strong></td>
		    <td width="84" align="center" style="font-size: 18px;"><strong>GAVETERO</strong></td>
		    <td width="69" align="center" style="font-size: 18px;"><strong>BALDA</strong></td>
		    <td width="81" align="center" style="font-size: 18px;"><strong>GAVETA</strong></td>
		  </tr></table></th>
		    <th width="60" align="center" style="font-size: 18px;"><strong>FECHA DE DEVOLUCION</strong></th>
		    <th width="216" align="center" style="font-size: 18px;"><strong>RECIBIDO POR</strong></th>
		  </tr>
			 $cadena
		</table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_048.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    function rptblt() {
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Importacion');
        $pdf->SetSubject('Importacion Sub');
        $pdf->SetKeywords('VIPFE, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "VIPFE", "por VIPFE Bolivia");

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 8);

        // add a page
        $pdf->AddPage();

        // -----------------------------------------------------------------------------
        $this->prestamos = new tab_prestamos();
        $this->usuario = new usuario();
        $adm = $this->usuario->esAdm();
        $this->tab_importacion = new tab_importacion ();
        $this->tab_importacion->setRequest2Object($_REQUEST);
        $exp_id = $_REQUEST ['page'];
        $pre_id = $_REQUEST ['sortorder'];
        $sql = "SELECT pre_id, exp_id, uni_id, exa_id, pre_sigla_of, pre_solicitante, pre_institucion,
				pre_doc_aval, pre_descripcion, pre_justificacion, pre_tipo, pre_fecha_pres, pre_fecha_dev, pre_usu_reg,
				pre_fecha_reg, pre_usu_mod, pre_fecha_mod, pre_estado
				FROM tab_prestamos WHERE pre_estado = 1 AND exp_id = " . $exp_id . " AND pre_id =" . $pre_id;
        $result = $this->prestamos->dbselectBySQL($sql);

        $json = "";
        foreach ($result as $un) {
            $exp = new Tab_expediente();
            $expn = $exp->dbSelectBySQL("SELECT ser_id, exp_codigo, exp_nombre, exp_id FROM tab_expediente WHERE exp_id='" . $un->exp_id . "'");
            $ser = new Tab_series();
            $sern = $ser->dbSelectBySQL("SELECT ser_categoria FROM tab_series WHERE ser_id='" . $expn[0]->ser_id . "'");
            $json .= "  <tr>";
            $json .= '    <th width="25" align="center">' . addslashes($un->pre_id) . '</th>';
            $json .= '    <td width="245" style="font-size: 22px;">' . addslashes($expn[0]->exp_nombre) . '</td>';
            $json .= '    <td width="60" align="center" style="font-size: 22px;">' . addslashes($expn[0]->exp_id) . '</td>';
            $json .= '    <td width="62" align="center" style="font-size: 22px;"></td>';
            $json .= '    <td width="74" align="center" style="font-size: 22px;"></td>';
            $json .= '    <td width="84" align="center" style="font-size: 22px;"></td>';
            $json .= '    <td width="69" align="center" style="font-size: 22px;"></td>';
            $json .= '    <td width="81" align="center" style="font-size: 22px;"></td>';
            $json .= '    <td width="60" align="center" style="font-size: 22px;">' . addslashes($un->pre_fecha_dev) . '</td>';
            $json .= '    <td width="216" style="font-size: 22px;"></td>';
            $json .= '  </tr>';
        }
        // -----------------------------------------------------------------------------
        // NON-BREAKING ROWS (nobr="true")
        $tbl = <<<EOD
		<p align="right"><strong>N� DE FORM................</strong></p>
		<p align="center"><strong>ARCHIVO DE OFICIINA</strong></p>
		<p align="center"><strong>DIRECCION</strong>...............................................</p>
		<p align="center"><strong>UNIDAD</strong>......................................................</p>
		<p align="center"><strong>FORMULARIO DE PRESTAMO DE DOCUMENTOS</strong></p>
		<table width="1233" border="1" bordercolor="#000000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
		  <tr>
		    <th width="25" align="center" style="font-size: 18px;"><strong>N� DE ORDEN</strong></th>
		    <th width="245" align="center" style="font-size: 18px;"><strong>TITULO DEL DOCUMENTO SOLICITADO</strong></th>
		    <th width="60" align="center" style="font-size: 18px;"><strong>C�DIGODEL DOCUMENTO</strong></th>
		    <th width="62" align="center" style="font-size: 18px;"><strong>FOJAS</strong></th>
		    <th colspan="4" width="308" align="center" style="font-size: 18px;"><p><strong>LOCALIZACION TOPOGRAFICA</strong></p>
		    <table width="308" height="24" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
		      <tr>
		    <td width="74" align="center" style="font-size: 18px;"><strong>ESTANTE</strong></td>
		    <td width="84" align="center" style="font-size: 18px;"><strong>GAVETERO</strong></td>
		    <td width="69" align="center" style="font-size: 18px;"><strong>BALDA</strong></td>
		    <td width="81" align="center" style="font-size: 18px;"><strong>GAVETA</strong></td>
		  </tr></table></th>
		    <th width="60" align="center" style="font-size: 18px;"><strong>FECHA DE DEVOLUCION</strong></th>
		    <th width="216" align="center" style="font-size: 18px;"><strong>RECIBIDO POR</strong></th>
		  </tr>
		 $json
		</table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');
        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('boletadeprestamo.pdf', 'I');
        //============================================================+
        // END OF FILE
        //============================================================+
    }


    function rptExp() {
        require_once ('tcpdf/config/lang/eng.php');
        require_once ('tcpdf/tcpdf.php');
        $this->usuario = new usuario ();
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->usuario->obtenerNombre($_SESSION['USU_ID']));
        $pdf->SetTitle('Importacion');
        $pdf->SetSubject('Importacion Sub');
        $pdf->SetKeywords('VIPFE, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "VIPFE", "por VIPFE Bolivia");

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 8);

        // add a page
        $pdf->AddPage();

        // -----------------------------------------------------------------------------
        $this->prestamos = new tab_prestamos();
        $this->expediente = new tab_expediente ();
        $this->usuario = new usuario();
        $adm = $this->usuario->esAdm();
        $this->tab_importacion = new tab_importacion ();
        $this->tab_importacion->setRequest2Object($_REQUEST);
        $page = $_REQUEST ['page'];
        $rp = $_REQUEST ['rp'];
        $sortname = $_REQUEST ['sortname'];
        $sortorder = $_REQUEST ['sortorder'];
        if (!$sortname)
            $sortname = 'pre_id';
        if (!$sortorder)
            $sortorder = 'desc';
        if ($sortorder == "sasc")
            $sortorder = 'asc';
        else
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
                $where = " and te.exp_id LIKE '$query' ";
            elseif ($qtype == 'ser_categoria')
                $where = " and ts.ser_categoria LIKE '%$query%' ";
            elseif ($qtype == 'exp_codigo')
                $where = " and te.exp_codigo LIKE '%$query%' ";
            elseif ($qtype == 'exp_nombre')
                $where = " and te.exp_nombre LIKE '%$query%' ";
            else
                $where = " and $qtype LIKE '%$query%' ";
        }
        if ($adm) {
            $sql = "select DISTINCT te.exp_id, te.exp_nombre, te.exp_descripcion,te.exp_codigo, ts.ser_categoria, te.exp_fecha_exi, te.exp_fecha_exf
				from tab_expediente te inner join tab_series ts on te.ser_id=ts.ser_id
				WHERE te.exp_estado = '1' AND te.exp_id NOT IN(SELECT exp_id FROM tab_prestamos WHERE pre_estado='1') $where  $sort $limit ";
        } else {
            $sql = "select DISTINCT te.exp_id, te.exp_nombre, te.exp_descripcion,te.exp_codigo, ts.ser_categoria, te.exp_fecha_exi, te.exp_fecha_exf
				from tab_expediente te inner join tab_expusuario eu on eu.exp_id=te.exp_id
				INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
				WHERE eu.eus_estado='1' $where
				and eu.usu_id='" . $_SESSION ['USU_ID'] . "'
				AND exp_estado = '1'
				AND te.exp_id NOT IN(SELECT exp_id FROM tab_prestamos WHERE pre_estado='1') $sort $limit";
        }
        $this->exp = new expediente ();
        $total = $this->exp->countExpPrest($qtype, $query, $adm);

        $result = $this->expediente->dbselectBySQL($sql);
        $rc = false;
        $i = 0;
        $json = "";
        foreach ($result as $un) {
            $exp = new Tab_expediente();
            $expn = $exp->dbSelectBySQL("SELECT ser_id, exp_codigo, exp_nombre, exp_id FROM tab_expediente WHERE exp_id='" . $un->exp_id . "'");
            $ser = new Tab_series();
            $sern = $ser->dbSelectBySQL("SELECT ser_categoria FROM tab_series WHERE ser_id='" . $expn[0]->ser_id . "'");

            $json .= "<tr nobr='true'>";
            $json .= "<td>" . $un->exp_id . "</td>";
            $json .= "<td>" . addslashes($un->ser_categoria) . "</td>";
            $json .= "<td>" . addslashes($un->exp_codigo) . "</td>";
            $json .= "<td>" . addslashes($un->exp_nombre) . "</td>";
            $json .= "<td>" . addslashes($un->exp_fecha_exi) . "</td>";
            $json .= "<td>" . addslashes($un->exp_fecha_exf) . "</td>";
            $json .= "</tr>";
        }
        // -----------------------------------------------------------------------------
        // NON-BREAKING ROWS (nobr="true")


        $tbl = <<<EOD
				<table border="1" cellpadding="2" cellspacing="2" align="center">
				 <tr nobr="true">
				  <th colspan="6">Datos de Expedientes</th>
				 </tr>
				 <tr nobr="true">
				  <td>ID</td>
				  <td>SERIE</td>
				  <td>CODIGO</td>
				  <td>NOMBRE</td>
				  <td>FECHA DE INICIO</td>
				  <td>FECHA DE FINAL</td>
				 </tr>
				 $json
				</table>
EOD;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        // -----------------------------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_048.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    


}

?>
