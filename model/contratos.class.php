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
class contratos extends tab_contratos {

    function __construct() {
        //parent::__construct();
        $this->contratos = new tab_contratos();
    }

    function getUnidad($usu_id) {
        $row = "";
        $this->usuario = new tab_usuario();
        $row = $this->usuario->dbselectBySQL("SELECT
                        ttu.usu_id,
                        ttu.usu_nombres,
                        ttu.usu_apellidos,
                        ttu.uni_id,
                        ttu.rol_id
                        FROM
                        tab_usuario AS ttu
                        WHERE
                        ttu.usu_id =  '$usu_id' ");
        if (count($row) > 0)
            return $row[0]->uni_id;
        else
            return 0;
    }

    function buscarContrato($username = null, $pass = null) {
        $row = "";
        $this->usuario = new tab_usuario ();
        if ($username != null || $pass != null) {
            $row = $this->usuario->dbselectBySQL("SELECT * from tab_usuario WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
            //print_r($row);
            if (count($row))
                return true;
            else
                return false;
        } else
            false;
    }

    function listContratos($ins_id, $default = null) {
        $where = "";
        if ($ins_id != '0') {
            $where .= " AND u.uni_id IN (SELECT un.uni_id FROM tab_unidad un WHERE un.ins_id = '$ins_id')";
        }
        if ($default != null) {
            $where .= " AND u.uni_id = " . $default;
        }
        $sql = "select u.usu_id, u.usu_apellidos, u.usu_nombres
             from tab_usuario u where u.usu_estado = 1" . $where . " ORDER BY u.usu_apellidos ASC,u.usu_nombres ASC ";
        $row = $this->usuario->dbselectBySQL($sql);

        $option = "";
        foreach ($row as $val) {
            $option .="<option value='" . $val->usu_id . "'>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
        }
        return $option;
    }

    function count($where) {
        $contratos = new Tab_contratos ();
        $sql = "SELECT count(ctt_id)
                    FROM
                    tab_contratos AS c
                    WHERE
                    c.ctt_estado =  1 $where ";
        //echo($sql);die;
        $num = $contratos->countBySQL($sql);
        return $num;
    }

    /* GARBAGE */

    function getDatos($usu_id) {
        $row = "";
        $this->usuario = new tab_usuario();
        $row = $this->usuario->dbselectBySQL("SELECT
                    ttu.usu_id,
                    ttu.uni_id,
                    ttu.usu_nombres,
                    ttu.usu_apellidos,
                    ttu.rol_id,
                    tab_unidad.uni_codigo,
                    tab_unidad.uni_descripcion,
                    tab_rol.rol_cod
                    FROM
                    tab_usuario AS ttu
                    Inner Join tab_unidad ON tab_unidad.uni_id = ttu.uni_id
                    Inner Join tab_rol ON ttu.rol_id = tab_rol.rol_id
                    WHERE ttu.usu_id =  '$usu_id'  ");
        $res = array();
        if (count($row) > 0) {
            $res = $row[0];
        } else {
            $res = null;
        }
        return $res;
    }

    function generarLogin($nombress, $apellidoss) {
        if ($nombress == "" && $apellidoss == "") {
            $login = "";
            $nombres = strtolower(trim($nombress));
            $apellidos = strtolower(trim($apellidoss));
            $nombre = explode(" ", $nombres);
            $apellido = explode(" ", $apellidos);
            $login = $nombre [0] . "." . $apellido [0];
            if (existeLogin($login)) {
                $login.=rand(0, 100);
            }
            return $login;
        } else
            return "user.user";
    }

    function obtenerRolUsuario($id_user) {
        $row = "";
        if ($id_user != null) {
            $row = $this->usuario->dbselectBySQL("SELECT * from tab_usuario WHERE usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' ");
            if (count($row))
                return true;
            else
                return false;
        }
        else
            false;
    }

    function listUsuariosOper($usu_actual, $ins_id, $default = null) {
        $where = " AND u.usu_id<>'$usu_actual'";
        if ($ins_id != '0') {
            $where .= " AND u.uni_id IN (SELECT un.uni_id FROM tab_unidad un WHERE un.ins_id = '$ins_id')";
        }
        if ($default != null) {
            $where .= " AND u.uni_id = " . $default;
        }
        $sql = "select u.usu_id, u.usu_apellidos, u.usu_nombres
             from tab_usuario u Inner Join tab_rol r ON u.rol_id = r.rol_id
             where r.rol_cod = 'OPE' AND u.usu_estado = 1" . $where . " ORDER BY u.usu_apellidos ASC,u.usu_nombres ASC ";
        $row = $this->usuario->dbselectBySQL($sql);
        //print $sql;
        $option = "";
        foreach ($row as $val) {
            $option .="<option value='" . $val->usu_id . "'>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
        }
        return $option;
    }

    function listUsuariosFondo($usu_id, $ins_id, $tipo, $default = null) {
        $sql = "SELECT DISTINCT
                tu.usu_id,
                tu.usu_nombres,
                tu.usu_apellidos,
                tu.rol_id,
                tu.uni_id
                FROM
                tab_usuario AS tu
                Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id
                Inner Join tab_rol AS tr ON tu.rol_id = tr.rol_id
                WHERE
                tr.rol_cod =  '$tipo' AND
                tun.ins_id =  '$ins_id' AND
                tu.usu_estado = '1' AND tu.usu_id<>'$usu_id'
                ORDER BY
                tu.usu_apellidos ASC,
                tu.usu_nombres ASC ";
        //print($sql);
        $row = $this->usuario->dbselectBySQL($sql);

        $option = "";
        foreach ($row as $val) {
            if ($default == $val->usu_id) {
                $option .="<option value='" . $val->usu_id . "' selected>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
            } else {
                $option .="<option value='" . $val->usu_id . "'>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
            }
        }
        return $option;
    }

    function listUsuariosArchivo($usu_id, $default = null) {
        $sql = "SELECT DISTINCT
                tu.usu_id,
                tu.usu_nombres,
                tu.usu_apellidos
                FROM
                tab_usuario AS tu
                Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id
                Inner Join tab_rol AS tr ON tu.rol_id = tr.rol_id
                Inner Join tab_inst_fondo AS tif ON tif.ins_id = tun.ins_id
                WHERE
                tr.rol_cod =  'ACEN' AND
                tif.fon_id =  '3' AND
                tu.usu_estado = '1' AND tu.usu_id<>'$usu_id'
                ORDER BY
                tu.usu_apellidos ASC,
                tu.usu_nombres ASC ";
        //print($sql);
        $row = $this->usuario->dbselectBySQL($sql);

        $option = "";
        foreach ($row as $val) {
            if ($default == $val->usu_id) {
                $option .="<option value='" . $val->usu_id . "' selected>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
            } else {
                $option .="<option value='" . $val->usu_id . "'>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
            }
        }
        return $option;
    }

    function listUsuarioJson() {
        $where = "";
        $default = $_POST ["uni_id"];
        if (isset($_POST ["exp_id"])) {
            $exp_id = $_POST ["exp_id"];
            $where .= " AND tu.usu_id NOT IN (SELECT eu.usu_id FROM tab_expusuario eu WHERE eu.exp_id = '$exp_id' AND eu.eus_estado = '1')";
        }
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT DISTINCT
            tu.usu_id,
            tu.uni_id,
            tu.usu_nombres,
            tu.usu_apellidos
            FROM
            tab_usuario AS tu
            Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
            WHERE
            tu.usu_estado =  1 AND
            tr.rol_cod =  'OPE' " . $where . " ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
        //echo ($sql);die;
        $row = $this->usuario->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function obtenerSelect($default = null) {
        $where = "";
        $sql = "select * from tab_usuario where tab_usuario.usu_estado = 1 ORDER BY usu_apellidos ASC,usu_nombres ASC ";
        $row = $this->usuario->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->usu_id)
                $option .="<option value='" . $val->usu_id . "' selected>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
            else
                $option .="<option value='" . $val->usu_id . "'>" . $val->usu_apellidos . " " . $val->usu_nombres . "</option>";
        }
        return $option;
    }

    function existeLogin($login, $usu_id = null) {
        $row = array();
        if ($usu_id == null) {
            $sql = "select * from tab_usuario where tab_usuario.usu_login like '$login' ";
            $row = $this->usuario->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_usuario where tab_usuario.usu_login like '$login' AND usu_id<>'$usu_id' ";
            $row = $this->usuario->dbselectBySQL($sql);
        }
        if (count($row) > 0) {
            return true;
        }
        return false;
    }

    function getSeries($usu_id) {
        $series = new tab_series();
        $sql = "SELECT
                tab_series.ser_id,
                tab_series.ser_categoria
                FROM
                tab_series
                Inner Join tab_usu_serie ON tab_series.ser_id = tab_usu_serie.ser_id
                WHERE
                tab_usu_serie.use_estado =  1 AND
                tab_usu_serie.usu_id =  '$usu_id'";
        $rows = $series->dbSelectBySQL($sql);
        $det = "";
        foreach ($rows as $serie) {
            $det.=$serie->ser_categoria . ", ";
        }
        return(substr($det, 0, -2));
    }

    function obtenerNombre($usu_id) {
        $user = $this->usuario->dbSelectBySQL("SELECT * FROM tab_usuario WHERE usu_id ='" . $usu_id . "' ");
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->usu_nombres . " " . $user[0]->usu_apellidos;
        }
        return $nom;
    }

    function obtenerCustodios($exp_id) {
        $sql = "SELECT tu.usu_id, tu.usu_nombres, tu.usu_apellidos
		FROM tab_usuario tu
		INNER JOIN tab_expusuario teu ON teu.usu_id=tu.usu_id
		WHERE teu.exp_id ='" . $exp_id . "' AND teu.eus_estado = '1' ";
        $users = $this->usuario->dbSelectBySQL($sql);
        $nom = '';
        if (count($users) > 0) {
            foreach ($users as $user) {
                $nom .= $user->usu_nombres . " " . $user->usu_apellidos . ", ";
            }
        }
        $nom = substr($nom, 0, -2);
        return $nom;
    }

    function esAdm() {
        $this->usuario = new tab_usuario();
        $rows = array();
        $rows = $this->usuario->dbselectByField("usu_id", $_SESSION ['USU_ID']);
        if (count($rows) && $rows [0]->rol_id == '1')
            return true;
        return false;
    }

    function getTipo($usu_id) {
        $this->rol = new tab_rol();
        $rows = array();
        $sql = "SELECT *
                    FROM
                    tab_usuario AS u
                    Inner Join tab_rol AS r ON r.rol_id = u.rol_id
                    WHERE
                    u.usu_id =  '" . $usu_id . "' ";
        $rows = $this->rol->dbSelectBySQL($sql);
        if (count($rows))
            return $rows[0]->rol_cod;
        return "";
    }

    function obtenerDatosUsuario($username = null, $pass = null) {
        $row = "";
        $this->usuario = new tab_usuario();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_usuario.usu_id,
                    tab_usuario.uni_id,
                    tab_usuario.usu_nombres,
                    tab_usuario.usu_apellidos,
                    tab_usuario.usu_fono,
                    tab_usuario.usu_email,
                    tab_usuario.usu_nro_item,
                    tab_usuario.usu_fech_ing,
                    tab_usuario.usu_fech_fin,
                    tab_usuario.usu_login,
                    tab_usuario.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_usuario
                    Inner Join tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 ";
            $row = $this->usuario->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

}

?>