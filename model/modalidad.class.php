<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. arsenio castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class modalidad extends tab_modalidad {

    function __construct() {
        //parent::__construct();
        $this->modalidad = new tab_modalidad();
    }

    function obtenerNombre($mod_id) {
        $user = $this->modalidad->dbSelectBySQL("SELECT * FROM tab_modalidad WHERE mod_id ='" . $mod_id . "' ");
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->usu_nombres . " " . $user[0]->usu_apellidos;
        }
        return $nom;
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        $this->modalidad = new tab_modalidad();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_modalidad.mod_id,
                    tab_modalidad.uni_id,
                    tab_modalidad.usu_nombres,
                    tab_modalidad.usu_apellidos,
                    tab_modalidad.usu_fono,
                    tab_modalidad.usu_email,
                    tab_modalidad.usu_nro_item,
                    tab_modalidad.usu_fech_ing,
                    tab_modalidad.usu_fech_fin,
                    tab_modalidad.usu_login,
                    tab_modalidad.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_modalidad
                    Inner Join tab_rol ON tab_modalidad.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ";
            $row = $this->modalidad->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

    function getDatos($mod_id) {
        $row = "";
        $this->modalidad = new tab_modalidad();
        $row = $this->modalidad->dbselectBySQL("SELECT
                    ttu.mod_id,
                    ttu.uni_id,
                    ttu.usu_nombres,
                    ttu.usu_apellidos,
                    ttu.rol_id,
                    tab_unidad.uni_codigo,
                    tab_unidad.uni_descripcion,
                    tab_rol.rol_cod
                    FROM
                    tab_modalidad AS ttu
                    Inner Join tab_unidad ON tab_unidad.uni_id = ttu.uni_id
                    Inner Join tab_rol ON ttu.rol_id = tab_rol.rol_id
                    WHERE ttu.mod_id =  '$mod_id'  ");
        $res = array();
        if (count($row) > 0) {
            $res = $row[0];
        } else {
            $res = null;
        }
        return $res;
    }

    function buscarUsuario($username = null, $pass = null) {
        $row = "";
        $this->modalidad = new tab_modalidad ();
        if ($username != null || $pass != null) {
            $row = $this->modalidad->dbselectBySQL("SELECT * from tab_modalidad WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
            //print_r($row);
            if (count($row))
                return true;
            else
                return false;
        } else
            false;
    }

    function listUsuarioJson() {
        $where = "";
        $default = $_POST ["uni_id"];
        if (isset($_POST ["exp_id"])) {
            $exp_id = $_POST ["exp_id"];
            $where .= " AND tu.mod_id NOT IN (SELECT eu.mod_id FROM tab_expmodalidad eu WHERE eu.exp_id = '$exp_id' AND eu.eus_estado = '1')";
        }
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT DISTINCT
            tu.mod_id,
            tu.uni_id,
            tu.usu_nombres,
            tu.usu_apellidos
            FROM
            tab_modalidad AS tu
            Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
            WHERE
            tu.usu_estado =  1 AND
            tr.rol_cod =  'OPE' " . $where . " ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
        //echo ($sql);die;
        $row = $this->modalidad->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function count($where) {
        $modalidad = new Tab_modalidad ();
        $sql = "SELECT count(mod_id)
                    FROM
                    tab_modalidad AS m
                    WHERE
                    m.mod_estado =  1 $where ";
        $num = $modalidad->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select * from tab_modalidad where tab_modalidad.mod_estado = 1 ORDER BY mod_id ASC ";
        $row = $this->modalidad->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->mod_id)
                $option .="<option value='" . $val->mod_id . "' selected>" . $val->mod_descripcion . "</option>";
            else
                $option .="<option value='" . $val->mod_id . "'>" . $val->mod_descripcion . "</option>";
        }
        return $option;
    }

}

?>