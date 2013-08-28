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
class tipodoc extends tab_tipodoc {

    function __construct() {
        //parent::__construct();
        $this->tipodoc = new tab_tipodoc();
    }

    function validaDependencia($tdo_id) {

        $tipodoc = new tab_tipodoc();
        $sql = "SELECT COUNT (ubi.ubi_id)
                        FROM tab_tipodoc tdo INNER JOIN
                        tab_provincia pro ON tdo.tdo_id = pro.tdo_id INNER JOIN
                        tab_localidad loc ON pro.pro_id = loc.pro_id INNER JOIN
                        tab_ubicacion ubi ON loc.loc_id = ubi.loc_id
                        WHERE ubi.est_estado = 1 AND tdo.tdo_id = $tdo_id ";
        $option = 0;
        $algo = $tipodoc->countBySQL($sql);
        if ($algo != 0) {
            $option = 1;
        }
        return $option;
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select *
			from tab_tipodoc
			where tab_tipodoc.tdo_estado = 1
			ORDER BY tdo_id ASC ";
        $row = $this->tipodoc->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->tdo_id)
                $option .="<option value='" . $val->tdo_id . "' selected>" . $val->tdo_nombre . "</option>";
            else
                $option .="<option value='" . $val->tdo_id . "'>" . $val->tdo_nombre . "</option>";
        }
        return $option;
    }

    function count($where) {
        $tipodoc = new Tab_tipodoc ();
        $sql = "SELECT count(tdo_id)
                    FROM
                    tab_tipodoc
                    WHERE
                    tdo_estado =  1 $where ";
        //echo($sql);die;
        $num = $tipodoc->countBySQL($sql);
        return $num;
    }

}

?>