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
class tiposolicitud extends tab_tiposolicitud {

    function __construct() {
        //parent::__construct();
        $this->tiposolicitud = new tab_tiposolicitud();
    }

    function obtenerNombre($sol_id) {
        $user = $this->tiposolicitud->dbSelectBySQL("SELECT * FROM tab_tiposolicitud WHERE sol_id ='" . $sol_id . "' ");
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->usu_nombres . " " . $user[0]->usu_apellidos;
        }
        return $nom;
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        $this->tiposolicitud = new tab_tiposolicitud();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_tiposolicitud.sol_id,
                    tab_tiposolicitud.uni_id,
                    tab_tiposolicitud.usu_nombres,
                    tab_tiposolicitud.usu_apellidos,
                    tab_tiposolicitud.usu_fono,
                    tab_tiposolicitud.usu_email,
                    tab_tiposolicitud.usu_nro_item,
                    tab_tiposolicitud.usu_fech_ing,
                    tab_tiposolicitud.usu_fech_fin,
                    tab_tiposolicitud.usu_login,
                    tab_tiposolicitud.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_tiposolicitud
                    Inner Join tab_rol ON tab_tiposolicitud.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ";
            $row = $this->tiposolicitud->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

    function getDatos($sol_id) {
        $row = "";
        $this->tiposolicitud = new tab_tiposolicitud();
        $row = $this->tiposolicitud->dbselectBySQL("SELECT
                    ttu.sol_id,
                    ttu.uni_id,
                    ttu.usu_nombres,
                    ttu.usu_apellidos,
                    ttu.rol_id,
                    tab_unidad.uni_codigo,
                    tab_unidad.uni_descripcion,
                    tab_rol.rol_cod
                    FROM
                    tab_tiposolicitud AS ttu
                    Inner Join tab_unidad ON tab_unidad.uni_id = ttu.uni_id
                    Inner Join tab_rol ON ttu.rol_id = tab_rol.rol_id
                    WHERE ttu.sol_id =  '$sol_id'  ");
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
        $this->tiposolicitud = new tab_tiposolicitud ();
        if ($username != null || $pass != null) {
            $row = $this->tiposolicitud->dbselectBySQL("SELECT * from tab_tiposolicitud WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
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
            $where .= " AND tu.sol_id NOT IN (SELECT eu.sol_id FROM tab_exptiposolicitud eu WHERE eu.exp_id = '$exp_id' AND eu.eus_estado = '1')";
        }
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT DISTINCT
            tu.sol_id,
            tu.uni_id,
            tu.usu_nombres,
            tu.usu_apellidos
            FROM
            tab_tiposolicitud AS tu
            Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
            WHERE
            tu.usu_estado =  1 AND
            tr.rol_cod =  'OPE' " . $where . " ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
        //echo ($sql);die;
        $row = $this->tiposolicitud->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function count($where) {
        $tiposolicitud = new Tab_tiposolicitud ();
        $sql = "SELECT count(sol_id)
                    FROM
                    tab_tiposolicitud AS t
                    WHERE
                    t.sol_estado =  1 $where ";
        $num = $tiposolicitud->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select * from tab_tiposolicitud where tab_tiposolicitud.sol_estado = 1 ORDER BY sol_id  ASC ";
        $row = $this->tiposolicitud->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->sol_id)
                $option .="<option value='" . $val->sol_id . "' selected>" . $val->sol_descripcion . "</option>";
            else
                $option .="<option value='" . $val->sol_id . "'>" . $val->sol_descripcion . "</option>";
        }
        return $option;
    }

}

?>