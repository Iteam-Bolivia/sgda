<?php

/**
 * empresas_ext Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class empresas_ext extends tab_empresas_ext {

    function __construct() {
        //parent::__construct();
        $this->empresas_ext = new tab_empresas_ext();
    }

    function obtenerNombre($emp_ext_id) {
        $user = $this->empresas_ext->dbSelectBySQL("SELECT * FROM tab_empresas_ext WHERE emp_id ='" . $emp_ext_id . "' ");
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->emp_nombre;
        }
        return $nom;
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        $this->empresas_ext = new tab_empresas_ext();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_empresas_ext.emp_id,
                    tab_empresas_ext.uni_id,
                    tab_empresas_ext.usu_nombres,
                    tab_empresas_ext.usu_apellidos,
                    tab_empresas_ext.usu_fono,
                    tab_empresas_ext.usu_email,
                    tab_empresas_ext.usu_nro_item,
                    tab_empresas_ext.usu_fech_ing,
                    tab_empresas_ext.usu_fech_fin,
                    tab_empresas_ext.usu_login,
                    tab_empresas_ext.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_empresas_ext
                    Inner Join tab_rol ON tab_empresas_ext.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ";
            $row = $this->empresas_ext->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

    function getDatos($emp_id) {
        $row = "";
        $this->empresas_ext = new tab_empresas_ext();
        $row = $this->empresas_ext->dbselectBySQL("SELECT
                    ttu.emp_id,
                    ttu.uni_id,
                    ttu.usu_nombres,
                    ttu.usu_apellidos,
                    ttu.rol_id,
                    tab_unidad.uni_codigo,
                    tab_unidad.uni_descripcion,
                    tab_rol.rol_cod
                    FROM
                    tab_empresas_ext AS ttu
                    Inner Join tab_unidad ON tab_unidad.uni_id = ttu.uni_id
                    Inner Join tab_rol ON ttu.rol_id = tab_rol.rol_id
                    WHERE ttu.emp_id =  '$emp_id'  ");
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
        $this->empresas_ext = new tab_empresas_ext ();
        if ($username != null || $pass != null) {
            $row = $this->empresas_ext->dbselectBySQL("SELECT * from tab_empresas_ext WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
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
            $where .= " AND tu.emp_id NOT IN (SELECT eu.emp_id FROM tab_expempresas_ext eu WHERE eu.exp_id = '$exp_id' AND eu.eus_estado = '1')";
        }
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT DISTINCT
            tu.emp_id,
            tu.uni_id,
            tu.usu_nombres,
            tu.usu_apellidos
            FROM
            tab_empresas_ext AS tu
            Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
            WHERE
            tu.usu_estado =  1 AND
            tr.rol_cod =  'OPE' " . $where . " ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
        //echo ($sql);die;
        $row = $this->empresas_ext->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function count($where) {
        $empresas_ext = new Tab_empresas_ext ();
        $sql = "SELECT count(emp_id)
                    FROM
                    tab_empresas_ext AS m
                    WHERE
                    m.emp_estado =  1 $where ";
        $num = $empresas_ext->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select * from tab_empresas_ext where tab_empresas_ext.emp_estado = 1 ORDER BY emp_id ASC ";
        $row = $this->empresas_ext->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->emp_id)
                $option .="<option value='" . $val->emp_id . "' selected>" . $val->emp_nombre . "</option>";
            else
                $option .="<option value='" . $val->emp_id . "'>" . $val->emp_nombre . "</option>";
        }
        return $option;
    }

}

?>