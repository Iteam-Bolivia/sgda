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
class intermedia extends tab_intermedia {

    function __construct() {
        //parent::__construct();
        $this->intermedia = new tab_intermedia();
    }

    function count($where) {
        $intermedia = new Tab_intermedia();
        $sql = "SELECT count(cor_id)
                    FROM
                    tab_intermedia
                    WHERE
                    cor_estado =  1 $where ";
        //echo($sql);die;
        $num = $intermedia->countBySQL($sql);
        return $num;
    }

//    function validaDependencia($dep_id) {
//
//        $departamento = new tab_departamento();
//        $sql = "SELECT COUNT (ubi.ubi_id)
//                        FROM tab_departamento dep INNER JOIN
//                        tab_provincia pro ON dep.dep_id = pro.dep_id INNER JOIN
//                        tab_localidad loc ON pro.pro_id = loc.pro_id INNER JOIN
//                        tab_ubicacion ubi ON loc.loc_id = ubi.loc_id
//                        WHERE ubi.ubi_estado = 1 AND dep.dep_id = $dep_id ";
//        $option = 0;
//    $algo = $departamento->countBySQL($sql);
//            if ($algo != 0) {
//                $option = 1;
//            }
//        return $option;
//    }
//
//    function obtenerSelect($default=null) {
//		$where = "";
//		$sql="select *
//			from tab_departamento
//			where tab_departamento.dep_estado = 1
//			ORDER BY dep_id ASC ";
//		$row = $this->departamento->dbselectBySQL($sql);
//		$option="";
//		foreach($row as $val) {
//			if($default==$val->dep_id)
//			$option .="<option value='".$val->dep_id."' selected>".$val->dep_nombre."</option>";
//			else
//			$option .="<option value='".$val->dep_id."'>".$val->dep_nombre."</option>";
//		}
//		return $option;
//	}
//
}

?>