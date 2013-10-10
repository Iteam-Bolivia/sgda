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
class fuentefinanciamiento extends tab_fuentefinanciamiento {

    function __construct() {
        //parent::__construct();
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
    }

    function obtenerNombre($ff_id) {
        $user = $this->fuentefinanciamiento->dbSelectBySQL("SELECT * FROM tab_fuentefinanciamiento WHERE ff_id ='" . $ff_id . "' ");
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->usu_nombres . " " . $user[0]->usu_apellidos;
        }
        return $nom;
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_fuentefinanciamiento.ff_id,
                    tab_fuentefinanciamiento.uni_id,
                    tab_fuentefinanciamiento.usu_nombres,
                    tab_fuentefinanciamiento.usu_apellidos,
                    tab_fuentefinanciamiento.usu_fono,
                    tab_fuentefinanciamiento.usu_email,
                    tab_fuentefinanciamiento.usu_nro_item,
                    tab_fuentefinanciamiento.usu_fech_ing,
                    tab_fuentefinanciamiento.usu_fech_fin,
                    tab_fuentefinanciamiento.usu_login,
                    tab_fuentefinanciamiento.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_fuentefinanciamiento
                    Inner Join tab_rol ON tab_fuentefinanciamiento.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ";
            $row = $this->fuentefinanciamiento->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

    function getDatos($ff_id) {
        $row = "";
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento();
        $row = $this->fuentefinanciamiento->dbselectBySQL("SELECT
                    ttu.ff_id,
                    ttu.uni_id,
                    ttu.usu_nombres,
                    ttu.usu_apellidos,
                    ttu.rol_id,
                    tab_unidad.uni_codigo,
                    tab_unidad.uni_descripcion,
                    tab_rol.rol_cod
                    FROM
                    tab_fuentefinanciamiento AS ttu
                    Inner Join tab_unidad ON tab_unidad.uni_id = ttu.uni_id
                    Inner Join tab_rol ON ttu.rol_id = tab_rol.rol_id
                    WHERE ttu.ff_id =  '$ff_id'  ");
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
        $this->fuentefinanciamiento = new tab_fuentefinanciamiento ();
        if ($username != null || $pass != null) {
            $row = $this->fuentefinanciamiento->dbselectBySQL("SELECT * from tab_fuentefinanciamiento WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
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
            $where .= " AND tu.ff_id NOT IN (SELECT eu.ff_id FROM tab_expfuentefinanciamiento eu WHERE eu.exp_id = '$exp_id' AND eu.eus_estado = '1')";
        }
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT DISTINCT
            tu.ff_id,
            tu.uni_id,
            tu.usu_nombres,
            tu.usu_apellidos
            FROM
            tab_fuentefinanciamiento AS tu
            Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
            WHERE
            tu.usu_estado =  1 AND
            tr.rol_cod =  'OPE' " . $where . " ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
        //echo ($sql);die;
        $row = $this->fuentefinanciamiento->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function count($where) {
        $fuentefinanciamiento = new Tab_fuentefinanciamiento ();
        $sql = "SELECT count(ff_id)
                    FROM
                    tab_fuentefinanciamiento AS u
                    WHERE
                    u.ff_estado =  1 $where ";
        //echo($sql);die;
        $num = $fuentefinanciamiento->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select * from tab_fuentefinanciamiento where tab_fuentefinanciamiento.ff_estado = 1 ORDER BY ff_id ASC ";
        $row = $this->fuentefinanciamiento->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ff_id)
                $option .="<option value='" . $val->ff_id . "' selected>" . $val->ff_descripcion . "</option>";
            else
                $option .="<option value='" . $val->ff_id . "'>" . $val->ff_descripcion . "</option>";
        }
        return $option;
    }

}

?>