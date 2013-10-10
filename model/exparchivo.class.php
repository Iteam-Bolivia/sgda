<?php

/**
 * exparchivo.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class exparchivo extends tab_exparchivo {

    function __construct() {
        $this->exparchivo = new Tab_exparchivo();
    }

    function obtenerVacio($exp_id, $ser_id, $cue_id) {
//        $sql = "SELECT
//			*
//			FROM
//			tab_exparchivo
//			Inner Join tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
//			WHERE
//			tab_archivo.fil_nomoriginal LIKE  '' AND
//			tab_archivo.fil_nomcifrado LIKE  '' AND
//			tab_archivo.fil_extension LIKE  '' AND
//			tab_exparchivo.exa_estado =  '1' AND
//			tab_exparchivo.exp_id =  '" . $exp_id . "' AND
//			tab_exparchivo.ser_id =  '" . $ser_id . "' AND
//			tab_exparchivo.cue_id =  '" . $cue_id . "' ";
        $sql = "SELECT
			*
			FROM
			tab_exparchivo
			Inner Join tab_archivo ON tab_archivo.fil_id = tab_exparchivo.fil_id
			WHERE
			tab_exparchivo.exa_estado =  '1' AND
			tab_exparchivo.exp_id =  '" . $exp_id . "' AND
			tab_exparchivo.cue_id =  '" . $cue_id . "' ";        
        
        $rows = $this->exparchivo->dbSelectBySQL($sql);
        $res = null;
        if (!is_null($rows) && count($rows) > 0) {
            $res = $rows[0];
        }
        return $res;
    }

    function cargar($exp_id, $tra_id, $cue_id) {
        //obtenemos los datos del expediente
        $usu_id = $_SESSION['USU_ID'];
        $uni_id = $_SESSION['VER_UNIDAD']; //$_SESSION['UNI_ID'];
        $ver_id = $_SESSION['VER_VERSION']; //$_SESSION['VER_ID'];
        $this->expediente = new tab_expediente();
        $this->expediente->dbselectBySQL("select * from tab_expediente where exp_estado = 1");
        $ser_id = $this->expediente->getSer_id();

        $this->expunidad = new tab_expunidad();
        $this->expunidad->dbselectBySQL("select * from tab_expunidad where exp_estado = 1
				      and exp_id=" . $exp_id . " and uni_id=" . $uni_id . "
				      and ver_id=" . $ver_id);
        $euv_id = $this->expunidad->getEuv_id();

        $this->tramitecuerpos = new tab_tramitecuerpos();
        $this->tramitecuerpos->dbselectBySQL("select * from tab_tramitecuerpos where exp_estado = 1
				      and tra_id=" . $tra_id . " and cue_id=" . $cue_id . "
				      and ver_id=" . $ver_id);
        $trc_id = $this->tramitecuerpos->getTrc_id();

        $fil_id = $this->saveArchivo();
        $exc_id = $this->saveContenedor($euv_id, $exp_id, $_REQUEST['con_id']);
        $this->saveExpArchivo($fil_id, $euv_id, $exp_id, $ser_id, $tra_id, $cue_id, $trc_id, $exc_id);

        Header("Location: " . PATH_DOMAIN . "/estrucDocumental/viewTree/$exp_id/");
    }

    function saveArchivo() {
        //recepciona los datos del archivo
        //print_r($_POST);
        //print("<br/>");
        //print_r($_FILES);
        $archivo = $_FILES['archivo']['tmp_name'];
        $archivo_name = $_FILES['archivo']['name'];
        $archivo_type = $_FILES['archivo']['type'];
        $archivo_size = $_FILES['archivo']['size'];
        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $archivo_size);
        $contenido = addslashes($contenido);
        fclose($fp);
        $archivo_name = explode(".", $archivo_name);
        $archivo_ext = $archivo_name[1];
        $archivo_name = $archivo_name[0];
        //inserta un archivo
        $this->archivo = new tab_archivo();
        $this->archivo->setRequest2Object($_REQUEST);
        $this->archivo->setFil_id('');
        $this->archivo->setFil_nomoriginal($archivo_name);
        $this->archivo->setFil_nomcifrado(md5($archivo_name));
        $this->archivo->setFil_tamano($archivo_size);
        $this->archivo->setFil_extension($archivo_ext);
        $this->archivo->setFil_tipo($archivo_type);
        $this->archivo->setFil_descripcion($_REQUEST['fil_descripcion']);
        $this->archivo->setFil_caracteristica($_REQUEST['fil_caracteristica']);
        $this->archivo->setFil_fecha_crea(date("Y-m-d"));
        $this->archivo->setFil_usuario_crea($_SESSION['USU_ID']);
        $this->archivo->setFil_fecha_mod('');
        $this->archivo->setFil_usuario_mod('');
        $this->archivo->setFil_confidencialidad($_REQUEST['fil_confidencialidad']);
        $this->archivo->setFil_estado('1');
        $fil_id = $this->archivo->insert();

        $this->saveArchivoBin($fil_id, $contenido);
        return $fil_id;
        //// fin insertar en archivo
    }

    function saveArchivoBin($fil_id, $contenido) {
        // inserta en archivobin
        $this->archivobin = new tab_archivobin();
        $this->archivobin->setFil_id($fil_id);
        $this->archivobin->setFil_contenido($contenido);
        $this->archivobin->setFil_estado(1);
        $this->archivobin->insert();
        // fin inserta archivobin
    }

    function saveContenedor($euv_id, $exp_id, $con_id) {
        //inserta en expcontenenedor
        $this->expcontenedor = new tab_expcontenedor();
        $this->expcontenedor->setEuv_id($euv_id);
        $this->expcontenedor->setExp_id($exp_id);
        $this->expcontenedor->setCon_id($con_id);
        $this->expcontenedor->setExc_fecha_reg(date("Y-m-d"));
        $this->expcontenedor->setExc_usu_reg($_SESSION['USU_ID']);
        $this->expcontenedor->setExc_estado(1);
        return $this->expcontenedor->insert();
        //fin inserta en expcontenenedor
    }

    function saveExpArchivo($fil_id, $euv_id, $exp_id, $ser_id, $tra_id, $cue_id, $trc_id, $exc_id) {
        //inserta en exparchivo
        $this->exparchivo = new tab_exparchivo();
        $this->exparchivo->setExa_id('');
        $this->exparchivo->setFil_id($fil_id);
        $this->exparchivo->setEuv_id($euv_id);
        $this->exparchivo->setExp_id($exp_id);
        $this->exparchivo->setSer_id($ser_id);
        $this->exparchivo->setTra_id($tra_id);
        $this->exparchivo->setCue_id($cue_id);
        $this->exparchivo->setTrc_id($trc_id);
        $this->exparchivo->setUni_id($_SESSION['VER_UNIDAD']); //$_SESSION['UNI_ID']);
        $this->exparchivo->setVer_id($_SESSION['VER_VERSION']); //$_SESSION['VER_ID']);
        $this->exparchivo->setExc_id($exc_id);
        $this->exparchivo->setCon_id($_REQUEST['con_id']);
        $this->exparchivo->setSuc_id($_REQUEST['suc_id']);
        $this->exparchivo->setUsu_id($_SESSION['USU_ID']);
        $this->exparchivo->setExa_condicion($_REQUEST['exa_condicion']);
        $this->exparchivo->setExa_fecha_crea(date("Y-m-d"));
        $this->exparchivo->setExa_usuario_crea($_SESSION['USU_ID']);
        $this->exparchivo->setExa_fecha_mod('');
        $this->exparchivo->setExa_usuario_mod('');
        $this->exparchivo->setExa_estado(1);
        return $this->exparchivo->insert();
        //fin exparchivo
    }

    function existeExparchivo($exp_id, $usu_id, $uni_id) {
        $this->exparchivo = new tab_exparchivo();
        $row = $this->exparchivo->dbSelectBySQL("SELECT * FROM tab_exparchivo WHERE
    	exp_id='$exp_id' AND
    	usu_id='" . $usu_id . "' AND
    	uni_id='" . $uni_id . "' AND
    	exa_estado='1' ");
        return $row;
    }

}

?>
