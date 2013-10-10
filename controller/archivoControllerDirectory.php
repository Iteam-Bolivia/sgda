<?php

/**
 * archivoController.php Controller
 *
 * @package
 * @author lic. castellon
  * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class archivoController extends baseController {

    var $tituloEstructuraD = "<div class='titulo' align='center'>ESTRUCTURA DOCUMENTAL</div>";
    var $tituloEstructuraR = "<div class='titulo' align='center'>REGULARIZACION DE DOCUMENTOS</div>";

    function index() {
        /* VAR3: exp_id, VAR4: tra_id, VAR5: cue_id */
        $exa1 = new exparchivo ();
        $exa = $exa1->obtenerVacio(VAR3, VAR4, VAR5);
        if (!is_null($exa)) {
            header("Location: " . PATH_DOMAIN . "/archivo/view/$exa->exa_id/estrucDocumental/");
        } else {
            $this->addArchivo("estrucDocumental");
        }
    }

    function regularizar() {
        $exa1 = new exparchivo ();
        $exa = $exa1->obtenerVacio(VAR3, VAR4, VAR5);
        if (!is_null($exa)) {
            header("Location: " . PATH_DOMAIN . "/archivo/view/$exa->exa_id/regularizar/");
        } else {
            $this->addArchivo("regularizar");
        }
    }

    function addArchivo($seccion) {
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->exp_id = VAR3;
        $this->registry->template->tra_id = VAR4;
        $this->registry->template->cue_id = VAR5;
        $this->registry->template->exa_id = "";
        $contenedor = new contenedor ();
        $con_descrip = $contenedor->obtenerDescripcion(VAR3);
        $this->registry->template->seccion = $seccion;
        $this->registry->template->con_id = $con_descrip ['con_id'];
        $this->registry->template->contenedor = $con_descrip ['ctp_codigo'] . " - " . $con_descrip ['con_codigo'];
        $this->registry->template->fil_descripcion = "";
        $this->registry->template->fil_caracteristica = "";
        $arc = new archivo ();
        $this->registry->template->confidencialidad = $arc->loadConfidencialidad();
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $exp = new expediente ();
        if ($seccion == "estrucDocumental") {
            $this->registry->template->PATH_EVENT = "save";
            $this->registry->template->linkTree = $exp->linkTree(VAR3, VAR4, VAR5);
        } else {
            $this->registry->template->PATH_EVENT = "saveReg";
            $this->registry->template->linkTree = $exp->linkTreeReg(VAR3, VAR4, VAR5);
        }
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $this->registry->template->show('header');
        $this->registry->template->controller = $seccion;
        $this->llenaDatos(VAR3);
        $this->registry->template->show('regarchivo.tpl');
    }

    function view() {
        $seccion = VAR4;
        $texa = new Tab_exparchivo ();
        $texa = $texa->dbselectById(VAR3);
        $tarc = new Tab_archivo ();
        $fil = $tarc->dbselectById($texa->fil_id);
        $this->menu = new menu ();
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $this->registry->template->exp_id = $texa->exp_id;
        $this->registry->template->tra_id = $texa->tra_id;
        $this->registry->template->cue_id = $texa->cue_id;
        $this->registry->template->exa_id = $texa->exa_id;
        $contenedor = new contenedor ();
        $con_descrip = $contenedor->obtenerDescripcion($texa->exp_id);
        $this->registry->template->seccion = $seccion;
        $this->registry->template->fil_descripcion = $fil->fil_descripcion;
        $this->registry->template->fil_caracteristica = $fil->fil_caracteristica;
        $arc = new archivo ();
        $this->registry->template->confidencialidad = $arc->loadConfidencialidad($fil->fil_confidencialidad);
        $this->registry->template->con_id = $con_descrip ['con_id'];
        $this->registry->template->contenedor = $con_descrip ['ctp_codigo'] . " - " . $con_descrip ['con_codigo'];
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "update";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $exp = new expediente ();
        if ($seccion == "estrucDocumental") {
            $this->registry->template->linkTree = $exp->linkTree($texa->exp_id, $texa->tra_id, $texa->cue_id);
        } else {
            $this->registry->template->linkTree = $exp->linkTreeReg($texa->exp_id, $texa->tra_id, $texa->cue_id);
        }
        $this->registry->template->show('header');
        $this->registry->template->controller = $seccion;
        $this->llenaDatos(VAR3);
        $this->registry->template->show('regarchivo.tpl');
    }

    function save() {
        //obtenemos los datos del expediente
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];
        $ver_id = $_SESSION ['VER_ID'];
        $ser_id = 0;
        $euv_id = 0;
        $uni_id = 0;
        $usu_id = 0;
        $trc_id = 0;
        $exc_id = 0;
        $con_id = 0;
        $this->expediente = new tab_expediente ();
        $rows = $this->expediente->dbselectBySQL("select * from tab_expediente where exp_estado = 1 and exp_id='$exp_id' ");

        if (count($rows) == 1) {
            $ser_id = $rows [0]->getSer_id();
        }

        $this->expunidad = new tab_expunidad ();
        $rows_euv = $this->expunidad->dbselectBySQL("select * from tab_expunidad where euv_estado = 1
						and exp_id='" . $exp_id . "' ");
        if (count($rows_euv) >= 1) {
            $euv_id = $rows_euv [0]->getEuv_id();
            $uni_id = $rows_euv [0]->getUni_id();
        }

        $expusuario = new Tab_expusuario ();
        $rows_eus = $expusuario->dbselectBySQL("select * from tab_expusuario where eus_estado = 1
						and exp_id='" . $exp_id . "' ");
        if (count($rows_eus) >= 1) {
            $usu_id = $rows_eus [0]->getUsu_id();
        }

        $this->tramitecuerpos = new tab_tramitecuerpos ();
        $rows = $this->tramitecuerpos->dbselectBySQL("select * from tab_tramitecuerpos where tra_id=" . $tra_id . " and cue_id=" . $cue_id . " ");
        if (count($rows) >= 1) {
            $trc_id = $rows [0]->getTrc_id();
        }
        //print "ser_id: ".$ser_id."<br>"."euv_id: ".$euv_id."<br>"."uni_id: ".$uni_id."<br>usu_id: ".$usu_id."<br>trc_id: ".$trc_id;die();
        $fil_id = $this->saveArchivo();

        if ($ser_id != 0 && $euv_id != 0 && $uni_id != 0 && $usu_id != 0 && $trc_id != 0) {

            if (isset($_REQUEST ["con_id"]) && $_REQUEST ["con_id"] != "") {
                $con_id = $_REQUEST ["con_id"];
                $expcontenedor = new tab_expcontenedor ();
                $row_exc = $expcontenedor->dbselectBy3Field("con_id", $con_id, "exc_estado", "1", "exp_id", $exp_id);

                if (count($row_exc) == 0) {
                    $exc_id = $this->saveContenedor($euv_id, $exp_id, $con_id);
                } else {
                    $exc_id = $row_exc [0]->exc_id;
                }
            }
            $this->saveExpArchivo($fil_id, $euv_id, $exp_id, $ser_id, $tra_id, $cue_id, $trc_id, $exc_id, $uni_id, $usu_id, $con_id);
            if ($_REQUEST ['accion'] == 'cargar') {
                Header("Location: " . PATH_DOMAIN . "/archivo/cargar/$exp_id/$fil_id/" . VAR3 . "/");
            } else {
                Header("Location: " . PATH_DOMAIN . "/archivo/digitalizar/$exp_id/$fil_id/" . VAR3 . "/");
            }
        } else {
            header("location:" . PATH_DOMAIN . "/estrucDocumental/viewTree/" . $exp_id . "/");
        }
    }

    function lisjson() {
        $fil = array();

        $ids = explode(",", $_REQUEST ['ids']);
        for ($i = 0; $i < count($ids); $i++) {
            if ($ids [$i]) {
                $tarc = new Tab_archivo ();
                //$fil[] = $tarc->dbselectById ( $ids[$i] );
                $sql = "SELECT DISTINCT
                        te.exp_id,
                        te.exp_nombre,
                        te.exp_descripcion,
                        te.exp_codigo,
                        ts.ser_categoria,
                        te.exp_fecha_exi,
                        te.exp_fecha_exf,
                        un.uni_codigo,
                        tu.usu_nombres,
                        tu.usu_apellidos
                FROM
                tab_expediente AS te
                Inner Join tab_expusuario AS eu ON eu.exp_id = te.exp_id
                Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
                Inner Join tab_usuario AS tu ON eu.usu_id = tu.usu_id
                Inner Join tab_unidad AS un ON tu.uni_id = un.uni_id
                Inner Join tab_expfondo AS ef ON ef.exp_id = te.exp_id
                INNER JOIN tab_expunidad euv ON euv.exp_id=te.exp_id
                INNER JOIN tab_usu_serie AS u ON u.ser_id = ts.ser_id
                        WHERE
                        te.exp_estado =  '1' AND
                        te.exp_id ='" . $ids [$i] . "' ";
                $fil [] = $tarc->dbselectBySQLj($sql);
            }
        }
        echo (json_encode($fil));
    }

    function update() {
        //obtenemos los datos del expediente
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];
        $exa_id = $_REQUEST ["exa_id"];
        $ver_id = $_SESSION ['VER_ID'];
        $texa = new Tab_exparchivo ();
        $texa = $texa->dbselectById($exa_id);
        $ser_id = 0;
        $euv_id = 0;
        $uni_id = 0;
        $usu_id = 0;
        $trc_id = 0;
        $exc_id = 0;
        $con_id = 0;
        $this->expediente = new tab_expediente ();
        $rows = $this->expediente->dbselectBySQL("select * from tab_expediente where exp_estado = 1 and exp_id='$exp_id' ");
        if (count($rows) == 1) {
            $ser_id = $rows [0]->getSer_id();
        }

        $this->expunidad = new tab_expunidad ();
        $rows_euv = $this->expunidad->dbselectBySQL("select * from tab_expunidad where euv_estado = 1
						and exp_id=" . $exp_id . "
						and ver_id<='" . $ver_id . "'");
        if (count($rows_euv) == 1) {
            $euv_id = $rows_euv [0]->getEuv_id();
            $uni_id = $rows_euv [0]->getUni_id();
        }

        $expusuario = new Tab_expusuario ();
        $rows_eus = $expusuario->dbselectBySQL("select * from tab_expusuario where eus_estado = 1
						and exp_id='" . $exp_id . "' ");
        if (count($rows_eus) == 1) {
            $usu_id = $rows_eus [0]->getUsu_id();
        }

        if ($ser_id != 0 && $euv_id != 0 && $uni_id != 0 && $usu_id != 0) {
            $this->updateArchivo($texa->fil_id);
            if (isset($_REQUEST ["con_id"]) && $_REQUEST ["con_id"] != "") {
                $con_id = $_REQUEST ["con_id"];
                $expcontenedor = new tab_expcontenedor ();
                $row_exc = $expcontenedor->dbselectBy3Field("con_id", $con_id, "exc_estado", "1", "exp_id", $exp_id);

                if (count($row_exc) == 0) {
                    $exc_id = $this->saveContenedor($euv_id, $exp_id, $con_id);
                } else {
                    $exc_id = $row_exc [0]->exc_id;
                }
            }
            $this->updateExpArchivo($exa_id, $texa->fil_id, $exc_id, $uni_id, $usu_id, $con_id);
        }
        if ($_REQUEST ['accion'] == 'cargar')
            Header("Location: " . PATH_DOMAIN . "/archivo/cargar/$exp_id/$texa->fil_id/" . VAR3 . "/");
        else
            Header("Location: " . PATH_DOMAIN . "/archivo/digitalizar/$exp_id/$texa->fil_id/" . VAR3 . "/");
    }

    function saveReg() {

        //obtenemos los datos del expediente
        $exp_id = $_REQUEST ["exp_id"];
        $tra_id = $_REQUEST ["tra_id"];
        $cue_id = $_REQUEST ["cue_id"];
        $ver_id = $_SESSION ['VER_ID'];
        $ser_id = 0;
        $euv_id = 0;
        $uni_id = 0;
        $usu_id = 0;
        $trc_id = 0;
        $exc_id = 0;
        $con_id = 0;
        $this->expediente = new tab_expediente ();
        $rows = $this->expediente->dbselectBySQL("select * from tab_expediente where exp_estado = 1 and exp_id='$exp_id' ");
        if (count($rows) == 1) {
            $ser_id = $rows [0]->getSer_id();
        }

        $this->expunidad = new tab_expunidad ();
        $rows_euv = $this->expunidad->dbselectBySQL("select * from tab_expunidad where euv_estado = 1
						and exp_id='" . $exp_id . "' ");
        if (count($rows_euv) >= 1) {
            $euv_id = $rows_euv [0]->getEuv_id();
            $uni_id = $rows_euv [0]->getUni_id();
        }

        $expusuario = new Tab_expusuario ();
        $add = "";
        $this->usuario = new usuario ();
        $adm = $this->usuario->esAdm();
        if (!$adm) {
            $add = " AND  t.trn_usuario_orig ='" . $_SESSION ['USU_ID'] . "'";
        }
        $rows_eus = $expusuario->dbselectBySQL("select * from tab_expusuario where tab_expusuario.eus_estado = 1
						and tab_expusuario.exp_id='" . $exp_id . "'  and tab_expusuario.usu_id in (select t.trn_usuario_des from tab_transferencia t
						where t.exp_id='" . $exp_id . "' $add )");
        if (count($rows_eus) >= 1) {
            $usu_id = $rows_eus [0]->getUsu_id();
        }

        $this->tramitecuerpos = new tab_tramitecuerpos ();
        $rows = $this->tramitecuerpos->dbselectBySQL("select * from tab_tramitecuerpos where tra_id=" . $tra_id . " and cue_id=" . $cue_id . " ");
        if (count($rows) >= 1) {
            $trc_id = $rows [0]->getTrc_id();
        }
        $fil_id = $this->saveArchivo();
        die("ser_id: " . $ser_id . "<br>" . "euv_id: " . $euv_id . "<br>" . "uni_id: " . $uni_id . "<br>usu_id: " . $usu_id . "<br>trc_id: " . $trc_id);
        if ($ser_id != 0 && $euv_id != 0 && $uni_id != 0 && $usu_id != 0 && $trc_id != 0) {

            if (isset($_REQUEST ["con_id"]) && $_REQUEST ["con_id"] != "") {
                $con_id = $_REQUEST ["con_id"];
                $expcontenedor = new tab_expcontenedor ();
                $row_exc = $expcontenedor->dbselectBy3Field("con_id", $con_id, "exc_estado", "1", "exp_id", $exp_id);

                if (count($row_exc) == 0) {
                    $exc_id = $this->saveContenedor($euv_id, $exp_id, $con_id);
                } else {
                    $exc_id = $row_exc [0]->exc_id;
                }
            }
            if ($_REQUEST ['accion'] == 'cargar') {
                Header("Location: " . PATH_DOMAIN . "/archivo/cargar/$exp_id/$fil_id/regularizar/");
            } else {
                Header("Location: " . PATH_DOMAIN . "/archivo/digitalizar/$exp_id/$fil_id/regularizar/");
            }
            $this->saveExpArchivo($fil_id, $euv_id, $exp_id, $ser_id, $tra_id, $cue_id, $trc_id, $exc_id, $uni_id, $usu_id, $con_id);
        } else {
            header("location:" . PATH_DOMAIN . "/regularizar/viewTree/" . $exp_id . "/");
        }
        //obtenemos los datos del expediente
    }

    function cargar() {
        $this->menu = new menu ();
        $seccion = "estrucDocumental";
        if (!is_null(VAR5))
            $seccion = VAR5;
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        //muestra el formulario para cargar un archivo
        $exp_id = VAR3;
        $fil_id = VAR4;
        $this->registry->template->seccion = $seccion;
        $this->registry->template->exp_id = $exp_id;
        $this->registry->template->fil_id = $fil_id;
        $tab_exparchivo = new Tab_exparchivo ();
        $rows_exa = $tab_exparchivo->dbselectBy3Field("exp_id", VAR3, "fil_id", VAR4, "exa_estado", "1");

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $exp = new expediente ();

        if ($seccion == "regularizar")
            $this->registry->template->linkTree = $exp->linkTreeReg(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);
        else
            $this->registry->template->linkTree = $exp->linkTree(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);

        if ($seccion == "regularizar")
            $this->registry->template->tituloEstructura = $this->tituloEstructuraR;
        else
            $this->registry->template->tituloEstructura = $this->tituloEstructuraD;

        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "savecargar";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->controller = $seccion;
        $this->llenaDatos(VAR3);
        $this->registry->template->show('cargararchivo.tpl');
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

        /*
          if($tipo=='SISIN') {
          $this->registry->template->convenios = $exp->getConvenios($codigo,$tipo);
          $this->registry->template->detExpediente = $exp->getDim_sisin($codigo);
          }elseif($tipo=='SISFIN') {
          $this->registry->template->proyectos = $exp->getProyectos($codigo,$tipo);
          $this->registry->template->detExpediente = $exp->getDim_sisfin($codigo);
          }elseif($tipo=='CIF') {
          $this->registry->template->proyectos = $exp->getProyectos($codigo,$tipo);
          $this->registry->template->convenios = $exp->getConvenios($codigo,$tipo);
          $this->registry->template->detExpediente = $exp->getDim_cif($codigo);
          }else {
          $this->registry->template->detExpediente = $exp->getDetalles($id);
          }
         */

        $this->registry->template->detExpediente = $exp->getDetalles($id);
        $this->registry->template->serie = $serie->getSer_categoria();
        $this->registry->template->serTipo = $tipo;
        $this->registry->template->exp_codigo = $expediente->getExp_codigo();
        $this->registry->template->exp_fecha_exi = $expediente->getExp_fecha_exi();
        $this->registry->template->exp_fecha_exf = $expediente->getExp_fecha_exf();
        $this->registry->template->ubicacion = $exp->getUbicacion($id);
        $this->registry->template->show('exp_detallesView.tpl');
    }

    function digitalizar() {
        $this->menu = new menu ();
        $seccion = "estrucDocumental";
        if (!is_null(VAR5))
            $seccion = VAR5;
        $liMenu = $this->menu->imprimirMenu($seccion, $_SESSION ['USU_ID']);
        $this->registry->template->men_titulo = $liMenu;
        $exp_id = VAR3;
        $fil_id = VAR4;
        $this->registry->template->seccion = $seccion;
        $this->registry->template->exp_id = $exp_id;
        $this->registry->template->fil_id = $fil_id;
        $this->registry->template->usu_id = $_SESSION ['USU_ID'];

        $tab_exparchivo = new Tab_exparchivo ();
        $rows_exa = $tab_exparchivo->dbselectBy3Field("exp_id", VAR3, "fil_id", VAR4, "exa_estado", "1");

        $flecha = "<img src='" . PATH_DOMAIN . "/web/img/arrow.png' width=\"12px\" height=\"12px\"/>";
        $exp = new expediente ();
        if ($seccion == "regularizar")
            $this->registry->template->linkTree = $exp->linkTreeReg(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);
        else
            $this->registry->template->linkTree = $exp->linkTree(VAR3, $rows_exa [0]->tra_id, $rows_exa [0]->cue_id);

        if ($seccion == "regularizar")
            $this->registry->template->tituloEstructura = $this->tituloEstructuraR;
        else
            $this->registry->template->tituloEstructura = $this->tituloEstructuraD;
        $this->registry->template->PATH_WEB = PATH_WEB;
        $this->registry->template->PATH_DOMAIN = PATH_DOMAIN;
        $this->registry->template->PATH_EVENT = "";
        $this->registry->template->GRID_SW = "true";
        $this->registry->template->PATH_J = "jquery-1.4.1";
        $this->registry->template->show('header');
        $this->registry->template->show('digitalizararchivo.tpl');
    }

    // MODIFIED: CASTELLON
    // TYPE OF SAVE: BD OR FILE
    function savecargar() {
        //recepciona los datos del archivo
        $seccion = VAR3;
        $arc = new archivo ();
        $tarchivo = new tab_archivo ();
        $tarchivo->setRequest2Object($_REQUEST);
        $exp_id = $_REQUEST ['exp_id'];
        $fil_id = $_REQUEST ['fil_id'];
        $rows = $tarchivo->dbselectBySQL("select * from tab_archivo where fil_id = '$fil_id' ");
        $tarch = $rows [0];

        $archivo_type = $_FILES ["archivo"] ["type"];
        $archivo = $_FILES ["archivo"] ["tmp_name"];
        $archivo_size = $_FILES ["archivo"] ["size"];
        $archivo_name = $_FILES ["archivo"] ["name"];

        $nombre = basename($_FILES["archivo"]["name"]);

        $nombreFichero = $_FILES ["archivo"] ["name"];

        $archivo_name_array = explode(".", $archivo_name);
        $archivo_ext = array_pop($archivo_name_array);
        $archivo_sin_ext = implode($archivo_name_array);
        $archivo_name = $arc->generarNombre($archivo_sin_ext);
        $archivo_cifrado = md5($archivo_name);





        // TYPE SAVE
        $type_save = 1;

        if ($type_save == 1) {
            // OPTION SAVE FILE
            $error = false;

            // Subir fichero
            $copiarFichero = false;

            // Copiar fichero en directorio de ficheros subidos
            // Se renombra para evitar que sobreescriba un fichero existente
            // Para garantizar la unicidad del nombre se aÃ±ade una marca de tiempo
            if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                $nombreDirectorio = "img/";
                $nombreFichero = $_FILES['archivo']['name'];
                $copiarFichero = true;

                // Si ya existe un fichero con el mismo nombre, renombrarlo
                $nombreCompleto = $nombreDirectorio . $nombreFichero;
                if (is_file($nombreCompleto)) {
                    $idUnico = time();
                    $nombreFichero = $idUnico . "-" . $nombreFichero;
                }
            }

            // El fichero introducido supera el lÃ­mite de tamaÃ±o permitido
            else if ($_FILES['archivo']['error'] == UPLOAD_ERR_FORM_SIZE) {
                $maxsize = $_REQUEST['MAX_FILE_SIZE'];
                $errores["archivo"] = "Â¡El tamaÃ±o del fichero supera el lÃ­mite permitido ($maxsize bytes)!";
                $error = true;
            }
            // No se ha introducido ningÃºn fichero
            else if ($_FILES['archivo']['name'] == "")
                $nombreFichero = '';
            // El fichero introducido no se ha podido subir
            else {
                $errores["archivo"] = "Â¡No se ha podido subir el fichero!";
                $error = true;
            }


            // Si los datos son correctos, procesar formulario
            if ($error == false) {
                // Insertar la noticia en la Base de Datos
                //*********************
                // MODIFIED: CASTELLON
                //*********************
                //$this->saveContenido ( $fil_id, $contenido );
                // MODIFIED: CASTELLON
                # Servidor de base de datos
                $dbhost = "192.168.132.28";
                # Nombre de la base de datos
                $dbname = "digitalizacion";
                # Usuario de base de datos
                $dbuser = "postgres";
                # Password de base de datos
                $dbpwd = "iteam123";

                # Concexion a la base de datos
                $link = pg_connect("host=$dbhost user=$dbuser password=$dbpwd dbname=$dbname") or die(pg_last_error($link));

                # Inicia una transaccion
                pg_query($link, "begin");

                # Crea un objeto blob y retorna el oid
                $sql = "INSERT INTO tab_archivo_digital(fil_id, nombre, mime, size, archivo)
							VALUES ($fil_id, '$nombre', '$archivo_type', $archivo_size, '$nombreFichero')";

                # Ejecuta la sentencia SQL
                pg_query($link, $sql) or die(pg_last_error($link));

                # Compromete la transaccion
                pg_query($link, "commit");

                // Mover fichero de imagen a su ubicacion definitiva
                if ($copiarFichero)
                    move_uploaded_file($_FILES['archivo']['tmp_name'], $nombreDirectorio . $nombreFichero);
            }
        }
        else {
            // OPTION SAVE BD.
            //		@ftp_close ( $cid );
            //actualiza un archivo
            $tarchivo->setFil_id($fil_id);
            $tarchivo->setFil_nomoriginal($archivo_name);
            $tarchivo->setFil_nomcifrado($archivo_cifrado);
            $tarchivo->setFil_tamano($archivo_size);
            $tarchivo->setFil_extension($archivo_ext);
            $tarchivo->setFil_tipo($archivo_type);
            $tarchivo->update();

            //*********************
            // MODIFIED: CASTELLON
            //*********************
            //$this->saveContenido ( $fil_id, $contenido );
            // MODIFIED: CASTELLON
            # Servidor de base de datos
            $dbhost = "192.168.132.28";
            # Nombre de la base de datos
            $dbname = "digitalizacion";
            # Usuario de base de datos
            $dbuser = "postgres";
            # Password de base de datos
            $dbpwd = "iteam123";

            # Concexion a la base de datos
            $link = pg_connect("host=$dbhost user=$dbuser password=$dbpwd dbname=$dbname") or die(pg_last_error($link));

            # Contenido del archivo
            $fp = fopen($archivo, "rb");
            $contenido = fread($fp, filesize($archivo));
            fclose($fp);

            # Inicia una transaccion
            pg_query($link, "begin");

            # Crea un objeto blob y retorna el oid
            $oid = pg_lo_create($link);
            $sql = "INSERT INTO tab_archivo_digital(fil_id, nombre, archivo_oid, mime, size, archivo)
						VALUES ($fil_id, '$nombre', $oid, '$archivo_type', $archivo_size, '$nombreFichero')";

            # Ejecuta la sentencia SQL
            pg_query($link, $sql) or die(pg_last_error($link));

            # Abre el objeto blob
            $blob = pg_lo_open($link, $oid, "w");

            # Escribe el contenido del archivo
            pg_lo_write($blob, $contenido);

            # Cierra el objeto
            pg_lo_close($blob);

            # Compromete la transaccion
            pg_query($link, "commit");


            //}
            //Header ( "Location: " . PATH_DOMAIN . "/$seccion/viewTree/$exp_id/" );
        }

        Header("Location: " . PATH_DOMAIN . "/$seccion/viewTree/$exp_id/");


        /*
          if (is_uploaded_file ( $archivo )) {
          }
         */











        /* } catch ( Exception $e ) {
          @ftp_close ( $cid );
          } */
        //Header ( "Location: " . PATH_DOMAIN . "/$seccion/viewTree/$exp_id/" );
    }

    function saveArchivo() {
        //inserta un archivo
        $this->archivo = new tab_archivo ();
        $this->archivo->setRequest2Object($_REQUEST);
        $this->archivo->setFil_id('');
        $this->archivo->setFil_nomoriginal('');
        $this->archivo->setFil_nomcifrado('');
        $this->archivo->setFil_tamano('');
        $this->archivo->setFil_extension('');
        $this->archivo->setFil_tipo('');
        $this->archivo->setFil_descripcion($_REQUEST ['fil_descripcion']);
        $this->archivo->setFil_caracteristica($_REQUEST ['fil_caracteristica']);
        $this->archivo->setFil_fecha_crea(date("Y-m-d"));
        $this->archivo->setFil_usuario_crea($_SESSION ['USU_ID']);
        $this->archivo->setFil_fecha_mod('');
        $this->archivo->setFil_usuario_mod('');
        $this->archivo->setFil_confidencialidad($_REQUEST ['fil_confidencialidad']);
        $this->archivo->setFil_estado('1');
        //print_r($this->archivo);die();
        $fil_id = $this->archivo->insert();
        $bin = new Tab_archivobin ();
        $bin = $bin->dbselectById($fil_id);

        // MODIFIED: CASTELLON
        /*
          if (! is_null ( $bin ) && ! empty ( $bin->fil_id )) {
          $this->archivobin = new tab_archivobin ();
          $this->archivobin->setFil_id ( $fil_id );
          $this->archivobin->setFil_contenido ( '' );
          $this->archivobin->setFil_estado ( 1 );
          $this->archivobin->update ();
          } else {

          $this->archivobin = new tab_archivobin ();
          $this->archivobin->setFil_id ( $fil_id );
          $this->archivobin->setFil_contenido ( 0 );
          $this->archivobin->setFil_estado ( 1 );
          $fil_id_bin = $this->archivobin->insertManual ();
          }
         */

        return $fil_id;
        //// fin insertar en archivo
    }

    function updateArchivo($fil_id) {
        //inserta un archivo
        $this->archivo = new tab_archivo ();
        $this->archivo->setRequest2Object($_REQUEST);
        $this->archivo->setFil_id($fil_id);
        $this->archivo->setFil_nomoriginal('');
        $this->archivo->setFil_nomcifrado('');
        $this->archivo->setFil_tamano('');
        $this->archivo->setFil_extension('');
        $this->archivo->setFil_tipo('');
        $this->archivo->setFil_descripcion($_REQUEST ['fil_descripcion']);
        $this->archivo->setFil_caracteristica($_REQUEST ['fil_caracteristica']);
        $this->archivo->setFil_fecha_crea(date("Y-m-d"));
        $this->archivo->setFil_usuario_crea($_SESSION ['USU_ID']);
        $this->archivo->setFil_fecha_mod('');
        $this->archivo->setFil_usuario_mod('');
        $this->archivo->setFil_confidencialidad($_REQUEST ['fil_confidencialidad']);
        $this->archivo->setFil_estado('1');
        $this->archivo->update();
        $bin = new Tab_archivobin ();
        $bin = $bin->dbselectById($fil_id);
        if (!is_null($bin) && !empty($bin->fil_id)) {
            $this->archivobin = new tab_archivobin ();
            $this->archivobin->setFil_id($fil_id);
            $this->archivobin->setFil_contenido('');
            $this->archivobin->setFil_estado(1);
            $this->archivobin->update();
        } else {
            $this->archivobin = new tab_archivobin ();
            $this->archivobin->setFil_id($fil_id);
            $this->archivobin->setFil_contenido('');
            $this->archivobin->setFil_estado(1);
            $fil_id_bin = $this->archivobin->insertManual();
        }
    }

    function saveContenido($fil_id, $contenido) {
        // inserta en archivobin
        $this->archivobin = new tab_archivobin ();
        $this->archivobin->setFil_id($fil_id);
        $this->archivobin->setFil_contenido($contenido);
        $this->archivobin->setFil_estado(1);
        $this->archivobin->updateArchivo();
    }

    function saveContenedor($euv_id, $exp_id, $con_id) {
        //inserta en expcontenenedor
        $this->expcontenedor = new tab_expcontenedor ();
        $this->expcontenedor->setEuv_id($euv_id);
        $this->expcontenedor->setExp_id($exp_id);
        $this->expcontenedor->setCon_id($con_id);
        $this->expcontenedor->setExc_fecha_reg(date("Y-m-d"));
        $this->expcontenedor->setExc_usu_reg($_SESSION ['USU_ID']);
        $this->expcontenedor->setExc_estado(1);
        return $this->expcontenedor->insert();
        //fin inserta en expcontenenedor
    }

    function saveExpArchivo($fil_id, $euv_id, $exp_id, $ser_id, $tra_id, $cue_id, $trc_id, $exc_id, $uni_id, $usu_id, $con_id) {
        //inserta en exparchivo
        $this->exparchivo = new tab_exparchivo ();
        $this->exparchivo->setExa_id('');
        $this->exparchivo->setFil_id($fil_id);
        $this->exparchivo->setEuv_id($euv_id);
        $this->exparchivo->setExp_id($exp_id);
        $this->exparchivo->setSer_id($ser_id);
        $this->exparchivo->setTra_id($tra_id);
        $this->exparchivo->setCue_id($cue_id);
        $this->exparchivo->setTrc_id($trc_id);
        $this->exparchivo->setUni_id($uni_id);
        $this->exparchivo->setVer_id($_SESSION ['VER_ID']);
        $this->exparchivo->setExc_id($exc_id);
        $this->exparchivo->setCon_id($con_id);
        $this->exparchivo->setSuc_id('');
        $this->exparchivo->setUsu_id($usu_id);
        $this->exparchivo->setExa_condicion(1);
        $this->exparchivo->setExa_fecha_crea(date("Y-m-d"));
        $this->exparchivo->setExa_usuario_crea($_SESSION ['USU_ID']);
        $this->exparchivo->setExa_fecha_mod('');
        $this->exparchivo->setExa_usuario_mod('');
        $this->exparchivo->setExa_estado(1);
        return $this->exparchivo->insert();
        //fin exparchivo
    }

    function updateExpArchivo($exa_id, $fil_id, $exc_id, $uni_id, $usu_id, $con_id) {
        //inserta en exparchivo
        $this->exparchivo = new tab_exparchivo ();
        $this->exparchivo->setExa_id($exa_id);
        $this->exparchivo->setFil_id($fil_id);
        $this->exparchivo->setUni_id($uni_id);
        $this->exparchivo->setVer_id($_SESSION ['VER_ID']);
        $this->exparchivo->setExc_id($exc_id);
        $this->exparchivo->setCon_id($con_id);
        $this->exparchivo->setSuc_id('');
        $this->exparchivo->setUsu_id($usu_id);
        $this->exparchivo->setExa_condicion(1);
        $this->exparchivo->setExa_fecha_crea(date("Y-m-d"));
        $this->exparchivo->setExa_usuario_crea($_SESSION ['USU_ID']);
        $this->exparchivo->setExa_fecha_mod('');
        $this->exparchivo->setExa_usuario_mod('');
        $this->exparchivo->setExa_estado(1);
        return $this->exparchivo->update();
        //fin exparchivo
    }

    function verifpass() {
        if (isset($_REQUEST ["exp_id"])) {
            if (isset($_REQUEST ['fil_id']) && isset($_REQUEST ['pass']) && $_REQUEST ['pass'] != "") {
                $usuario = new tab_usuario ();
                $row_usu = $usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
                $usuario = $row_usu [0];
                $fil_id = $_REQUEST ['fil_id'];
                if ($usuario->getUsu_leer_doc() == '1' && $usuario->getUsu_pass_leer() == md5($_REQUEST ['pass'])) {
                    /* $sw=1; */
                    //Header("location:".PATH_DOMAIN."/expediente/download/".$_REQUEST["fil_id"]."/".md5($_REQUEST['pass'])."/");
                    Header("location:" . PATH_DOMAIN . "/archivo/download/" . $fil_id . "/");
                    $res = 'ok';
                } else {
                    $res = 'Password incorrecto.';
                }
            } else {
                $res = 'Seleccione un archivo e introduzca el password para poder verlo.';
            }
        } else {
            $res = "No existe el expediente.";
        }
        echo $res;
    }

    function verifConfidencialidad() {
        $res = "Seleccione un archivo";
        if (isset($_REQUEST ['fil_id'])) {
            $fil_id = $_REQUEST ['fil_id'];
            $arc = new Tab_archivo ();
            $rowa = $arc->dbSelectBySQL("SELECT fil_confidencialidad from tab_archivo WHERE fil_id = '$fil_id'");
            if (count($rowa) > 0)
                $res = $arc->fil_confidencialidad;
        }
        return $res;
    }

    //*********************
    // MODIFIED: CASTELLON
    //*********************
    function download() {
        $error = "";
        /*
          if (isset ( $_COOKIE [session_name ()] )) {
          if (session_is_registered ( 'USU_ID' )) { */

        if (isset($_POST ['fil_id_open'])) {
            $fil_id = $_POST ['fil_id_open'];
        } else {
            $fil_id = VAR3;
        }

        if ($fil_id != '') {
            $archivo = new tab_archivo ();
            $rowe = $archivo->dbSelectBySQL("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");
            if ($rowe [0]->fil_confidencialidad != '3') {
                $rowa = $archivo->dbSelectBySQL("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");
                $archivobin = new tab_archivobin ();
                $row = $archivobin->dbSelectBySQLField("SELECT fil_contenido FROM tab_archivobin WHERE fil_id =  '" . $fil_id . "'");
                if (count($row) == 1 || count($rowa) == 1) {
                    $sql = "SELECT
										tab_archivo.fil_id,
										tab_archivo.fil_nomoriginal,
										tab_archivo.fil_nomcifrado,
										tab_archivo.fil_tamano,
										tab_archivo.fil_extension,
										tab_archivo.fil_tipo,
										coalesce(tab_archivobin.fil_contenido,'-1') as fil_contenido
									FROM
										tab_archivo
									Inner Join tab_archivobin ON tab_archivo.fil_id = tab_archivobin.fil_id WHERE tab_archivobin.fil_id =  '" . $fil_id . "'";
                    $r_files = $archivo->dbSelectBySQLArchive($sql);

                    // MODIFIED: CASTELLON
                    # Servidor de base de datos
                    $dbhost = "192.168.132.28";
                    # Nombre de la base de datos
                    $dbname = "digitalizacion";
                    # Usuario de base de datos
                    $dbuser = "postgres";
                    # Password de base de datos
                    $dbpwd = "iteam123";
                    # ConexiÃ³n a la base de datos
                    $link = pg_connect("host=$dbhost user=$dbuser password=$dbpwd dbname=$dbname") or die(pg_last_error($link));

                    // REVISAR CONSULTA
                    //$sql = "select id, nombre, size, coalesce(archivo_oid,-1) as archivo_oid, coalesce(archivo_bytea,'-1') as archivo_bytea from tab_archivo_digital where id=$id";
                    $sql = "select fil_id, nombre, mime, size, coalesce(archivo_oid,'-1') as archivo_oid, coalesce(archivo_bytea,'-1') as archivo_bytea from tab_archivo_digital where fil_id=$fil_id";
                    $result = pg_query($link, $sql);

                    # Si no existe, redirecciona a la pÃ¡gina principal
                    if (!$result || pg_num_rows($result) < 1) {
                        header("Location: index.php");
                        exit();
                    }

                    # Recupera los atributos del archivo
                    $row = pg_fetch_array($result, 0);
                    pg_free_result($result);

                    # Para determinar si archivo a bajar fue ingresado al campo archivo_oid (es de tipo "oid")
                    if ($row['archivo_bytea'] == -1 && $row['archivo_oid'] == -1)
                        die('No existe el archivo para mostrar o bajar');

                    # Inicia la transacciÃ³n
                    pg_query($link, "begin");
                    # Abre el objeto blob
                    $file = pg_lo_open($link, $row['archivo_oid'], "r");

                    # EnvÃ­o de cabeceras
                    header("Cache-control: private");
                    header("Content-type: $row[mime]");
                    //if($f==1) header("Content-Disposition: attachment; filename=\"$row[nombre]\"");
                    header("Content-length: $row[size]");
                    header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Pragma: no-cache");
                    # Imprime el contenido del objeto blob
                    pg_lo_read_all($file);
                    # Cierra el objeto
                    pg_lo_close($file);
                    # Compromete la transacciÃ³n
                    pg_query($link, "commit");
                    pg_close($link);

                    //
                    //header("Content-type: $row[mime]");
                    //echo $r_files[0]->fil_contenido;
                //

				} else {
                    $error = "No existe el archivo.";
                }
            } else {
                if (isset($_POST ['pass_open']) && $_POST ['pass_open'] != '') {
                    $usuario = new tab_usuario ();
                    $row_usu = $usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
                    $usuario = $row_usu [0];
                    if ($usuario->getUsu_leer_doc() == '1' && $usuario->getUsu_pass_leer() == md5($_POST ['pass_open'])) {
                        $archivo = new tab_archivo ();
                        $rowa = $archivo->dbSelectBySQLField("SELECT * FROM tab_archivo WHERE fil_id =  '" . $fil_id . "'");

                        $archivobin = new tab_archivobin ();
                        $row = $archivobin->dbSelectBySQLField("SELECT fil_contenido FROM tab_archivobin WHERE fil_id =  '" . $fil_id . "'");

                        if (count($row) == 1 || count($rowa) == 1) {
                            $sql = "SELECT
										tab_archivo.fil_id,
										tab_archivo.fil_nomoriginal,
										tab_archivo.fil_nomcifrado,
										tab_archivo.fil_tamano,
										tab_archivo.fil_extension,
										tab_archivo.fil_tipo,
										tab_archivobin.fil_contenido
									FROM
										tab_archivo
									Inner Join tab_archivobin ON tab_archivo.fil_id = tab_archivobin.fil_id WHERE tab_archivobin.fil_id =  '" . $fil_id . "'";

                            $r_files = $archivo->dbSelectBySQLArchive($sql);
                            header('Content-type:' . $r_files[0]->fil_tipo);
                            echo $r_files[0]->fil_contenido;
                        } else {
                            $error = "No existe el archivo.";
                        }
                    } else {
                        $error = 'Password incorrecto.';
                    }
                } else {
                    $error = 'No tiene permisos para ver este archivo.';
                }
            }
        } else {
            $error = 'No existe el archivo.';
        }
        /*
          } else {
          $error = 'No inicio la sesion';

          }

          } else {
          $error = 'No inicio la sesion';

          } */

        if ($error != '')
            echo $error;
    }

    //********************
    // MODIFIED: CASTELLON
    //********************
    function delete() {
        $id = VAR3;
        $fil_id = VAR4;
        $seccion = VAR5;
        $exa = new Tab_exparchivo ();
        $arc = new Tab_archivobin ();
        $url = "";
        // borramos el archivo de la base de datos
        //$sql = "UPDATE tab_archivobin SET fil_contenido = '', fil_estado =  '2' WHERE fil_id = '$fil_id' ";
        $sql = "UPDATE tab_archivo_digital SET archivo_oid = 0, fil_estado =  '2' WHERE fil_id = '$fil_id' ";
        $arc->dbBySQL($sql);

        if (VAR5 == 'estrucDocumental') {
            // inactivamos la relacion expediente archivo
            $sql = "UPDATE tab_exparchivo SET exa_estado = '2' WHERE exp_id =  '$id' AND fil_id = '$fil_id' AND exa_estado =  '1'";
            $exa->dbBySQL($sql);
        }
        $sql = "UPDATE tab_archivo SET fil_estado = '2' WHERE fil_id = '$fil_id' AND fil_estado =  '1'";
        $exa->dbBySQL($sql);

        Header("Location: " . PATH_DOMAIN . "/$seccion/viewTree/$id/");
    }

}

?>
