<?php

/**
 * archivoModel
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class provincia extends tab_provincia {

    function __construct() {
        //parent::__construct();
        $this->provincia = new tab_provincia();
    }

    function validaDependenciaPr($pro_id) {

        $provincia = new tab_provincia();
        $sql = "SELECT COUNT (ubi.ubi_id)
                        FROM tab_provincia pro INNER JOIN
                        tab_localidad loc ON pro.pro_id = loc.pro_id INNER JOIN
                        tab_ubicacion ubi ON loc.loc_id = ubi.loc_id
                        WHERE ubi.ubi_estado = 1 AND pro.pro_id = $pro_id ";
        $option = 0;
        $algo = $provincia->countBySQL($sql);
        if ($algo != 0) {
            $option = 1;
        }
        return $option;
    }

    function count($where, $dep_id) {
        $provincia = new tab_provincia ();
        $sql = "SELECT count(pro_id)
                    FROM
                    tab_provincia
                    WHERE dep_id= $dep_id
                     AND pro_estado =  1 $where ";
        //echo($sql);die;
        $num = $provincia->countBySQL($sql);
        return $num;
    }

    function selectPro($pro_id, $dep_id = NULL) {
        $tab_provincia = new tab_provincia();

        if ($dep_id == NULL) {
            $sql = "SELECT dep_id FROM tab_provincia WHERE pro_estado=1 AND pro_id=$pro_id";
            $res = $tab_provincia->dbSelectBySQL($sql);
            $dep_id = $res[0]->dep_id;
        }
        $sql = "SELECT pro_id, pro_nombre FROM tab_provincia WHERE pro_estado=1 AND dep_id=$dep_id";
        $res = $tab_provincia->dbSelectBySQL($sql);
        $option = "";
        $option .="<option value=''>(Seleccionar)</option>";
        foreach ($res as $value) {
            if ($value->pro_id == $pro_id)
                $option .="<option value='" . $value->pro_id . "' selected>" . $value->pro_nombre . "</option>";
            else
                $option .="<option value='" . $value->pro_id . "' >" . $value->pro_nombre . "</option>";
        }
        return $option;
    }
    
    function existeCodigo($pro_codigo, $pro_id = null) {
        $row = array();
        if ($pro_id == null) {
            $sql = "select * from tab_provincia where tab_provincia.pro_codigo = '$pro_codigo' AND pro_estado='1'";
            $row = $this->provincia->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_provincia where tab_provincia.pro_codigo = '$pro_codigo' AND pro_id<>'$pro_id' AND pro_estado='1' ";
            $row = $this->provincia->dbselectBySQL($sql);
        }
        if (count($row) > 0) {
            return true;
        }
        return false;
    } 
}

?>