<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class localidad extends tab_localidad {

    function __construct() {
        //parent::__construct();
        $this->localidad = new tab_localidad();
    }

    function validaDependenciaLoc($loc_id) {

        $localidad = new tab_localidad();
        $sql = "SELECT COUNT (ubi.ubi_id)
                        FROM tab_localidad loc INNER JOIN
                        tab_ubicacion ubi ON loc.loc_id = ubi.loc_id
                        WHERE ubi.ubi_estado = 1 AND loc.loc_id = $loc_id ";
        $option = 0;
        $algo = $localidad->countBySQL($sql);
        if ($algo != 0) {
            $option = 1;
        }
        return $option;
    }

    function count($where, $pro_id) {
        $localidad = new tab_localidad ();
        $sql = "SELECT count(loc_id)
                    FROM
                    tab_localidad
                    WHERE pro_id= $pro_id
                     AND loc_estado =  1 $where ";
        //echo($sql);die;
        $num = $localidad->countBySQL($sql);
        return $num;
    }

    function obtenerLocalidades($default) {
        $localidad = new Tab_localidad();
        $result = $localidad->dbSelectBySQL("SELECT l.loc_id, l.loc_nombre
		FROM tab_localidad l
		WHERE l.loc_estado =  '1'
                ORDER BY l.loc_nombre ASC ");
        $option = "";
        foreach ($result as $tipo) {
            if ($tipo->loc_id == $default)
                $option .="<option value='$tipo->loc_id' selected>$tipo->loc_nombre</option>";
            else
                $option .="<option value='$tipo->loc_id'>$tipo->loc_nombre</option>";
        }
        return $option;
    }

    function selectLoc($loc_id, $pro_id = NULL) {
        $tab_localidad = new tab_localidad();

        if ($pro_id == NULL) {
            $sql = "SELECT pro_id FROM tab_localidad WHERE sub_estado=1 AND sub_id=$sub_id";
            $res = $tab_localidad->dbSelectBySQL($sql);
            $pro_id = $res[0]->pro_id;
        }
        $sql = "SELECT loc_id, loc_nombre FROM tab_localidad WHERE loc_estado=1 AND pro_id=$pro_id";
        $res = $tab_localidad->dbSelectBySQL($sql);
        $option = "";
        $option .="<option value=''>(Seleccionar)</option>";
        foreach ($res as $value) {
            if ($value->loc_id == $loc_id)
                $option .="<option value='" . $value->loc_id . "' selected>" . $value->loc_nombre . "</option>";
            else
                $option .="<option value='" . $value->loc_id . "' >" . $value->loc_nombre . "</option>";
        }
        return $option;
    }

    function buscaIdLocalidad($ubi_id) {
        $localidad = new tab_localidad();
        $sql = "SELECT
                tab_localidad.loc_id,
                tab_ubicacion.ubi_id
                FROM
                tab_departamento
                INNER JOIN tab_provincia ON tab_departamento.dep_id = tab_provincia.dep_id
                INNER JOIN tab_localidad ON tab_provincia.pro_id = tab_localidad.pro_id
                INNER JOIN tab_ubicacion ON tab_localidad.loc_id = tab_ubicacion.loc_id
                WHERE tab_ubicacion.ubi_estado = 1 AND tab_ubicacion.ubi_id = $ubi_id ";
        $result = $localidad->dbSelectBySQL($sql);
        $loc_id = 1;
        foreach ($result as $tipo) {
            $loc_id = $tipo->loc_id;
        }
        return $loc_id;
    }
    
     function existeCodigo($loc_codigo, $loc_id = null) {
        $row = array();
        if ($loc_id == null) {
            $sql = "select * from tab_localidad where tab_localidad.loc_codigo = '$loc_codigo' AND loc_estado='1'";
            $row = $this->localidad->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_localidad where tab_localidad.loc_codigo = '$loc_codigo' AND loc_id<>'$loc_id' AND loc_estado='1' ";
            $row = $this->localidad->dbselectBySQL($sql);
        }
        if (count($row) > 0) {
            return true;
        }
        return false;
    }  
}

?>