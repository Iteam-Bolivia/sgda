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
class usuario extends tab_usuario {

    function __construct() {
        //parent::__construct();
        $this->usuario = new tab_usuario();
    }

    function obtenerNombre($usu_id) {
        $sql = "SELECT 
                usu_nombres, 
                usu_apellidos 
                FROM tab_usuario 
                WHERE usu_id ='" . $usu_id . "' ";
        $user = $this->usuario->dbSelectBySQL($sql);
        $nom = '';
        if (count($user) > 0) {
            $nom = $user[0]->usu_nombres . " " . $user[0]->usu_apellidos;
        }
        return $nom;
    }

    function obtenerCustodios($exp_id) {
        $sql = "SELECT 
                tu.usu_id, 
                tu.usu_nombres, 
                tu.usu_apellidos
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
        $root = "";
        if ($username=='root') $root ="OR usu_estado=0";
        $this->usuario = new tab_usuario();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                    tab_usuario.usu_id,
                    tab_usuario.uni_id,
                    tab_usuario.usu_nombres,
                    tab_usuario.usu_apellidos,
                    tab_usuario.usu_fono,
                    tab_usuario.usu_email,
                    tab_usuario.usu_fech_ing,
                    tab_usuario.usu_fech_fin,
                    tab_usuario.usu_login,
                    tab_usuario.usu_verproy,
                    tab_usuario.rol_id,
                    tab_rol.rol_cod,
                    tab_rol.rol_descripcion
                    FROM
                    tab_usuario
                    Inner Join tab_rol ON tab_usuario.rol_id = tab_rol.rol_id
                    AND usu_login ='" . $username . "' AND usu_pass ='" . $pass . "' AND usu_estado=1 $root ";
            $row = $this->usuario->dbselectBySQL($sql);

            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }

    function getUnidad($usu_id) {
        $row = "";
        $this->usuario = new tab_usuario();
        $sql = "SELECT
                ttu.uni_id
                FROM
                tab_usuario AS ttu
                WHERE
                ttu.usu_id =  '$usu_id' ";
        $row = $this->usuario->dbselectBySQL($sql);
        if (count($row) > 0)
            return $row[0]->uni_id;
        else
            return 0;
    }

    function getFon_id($usu_id) {
        $row = "";
        $this->usuario = new tab_usuario();
        $sql = "SELECT 
                fon.fon_id
                FROM tab_usuario AS usu
                INNER JOIN tab_unidad AS uni ON usu.uni_id = uni.uni_id
                INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
                WHERE usu.usu_id = '$usu_id' AND uni.uni_estado = 1 AND fon.fon_estado = 1";
        $row = $this->usuario->dbselectBySQL($sql);
        if (count($row) > 0)
            return $row[0]->fon_id;
        else
            return 0;
    }

    function getFon_orden($usu_id) {
        $row = "";
        $this->usuario = new tab_usuario();
        $sql = "SELECT 
                fon.fon_orden
                FROM tab_usuario AS usu
                INNER JOIN tab_unidad AS uni ON usu.uni_id = uni.uni_id
                INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
                WHERE usu.usu_id = '$usu_id' AND uni.uni_estado = 1 AND fon.fon_estado = 1";
        $row = $this->usuario->dbselectBySQL($sql);
        if (count($row) > 0)
            return $row[0]->fon_orden;
        else
            return 0;
    }

    function getDatos($usu_id) {
        $sql = "SELECT
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
                WHERE ttu.usu_id =  '$usu_id'  ";
        $row = "";
        $this->usuario = new tab_usuario();
        $row = $this->usuario->dbselectBySQL($sql);
        $res = array();
        if (count($row) > 0) {
            $res = $row[0];
        } else {
            $res = null;
        }
        return $res;
    }

    function buscarUsuario($username = null, $pass = null) {
        $row = 0;
        $root = "";
        if ($username=='root') $root = "OR usu_estado='0'"; 
        $sql = "SELECT * 
                FROM tab_usuario 
                WHERE usu_login ='" . pg_escape_string($username) . "' AND usu_pass ='" . $pass . "' AND usu_estado='1' $root ";
        $this->usuario = new tab_usuario ();
        if ($username != null || $pass != null) {
            $row = $this->usuario->dbselectBySQL($sql);
            //print_r($row);
            if (count($row))
                return true;
            else
                return false;
        } else
            false;
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

    function listUsuarios($ins_id, $default = null) {
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

    function listUsuariosFondo($usu_id, $tipo, $fon_orden_des, $default = null) {
        $sql = "SELECT DISTINCT
                tu.usu_id,tu.usu_nombres,tu.usu_apellidos,tu.rol_id,tu.uni_id,fon.fon_orden
                FROM tab_usuario AS tu
                INNER JOIN tab_rol AS tr ON tu.rol_id = tr.rol_id
                INNER JOIN tab_unidad AS uni ON tu.uni_id = uni.uni_id
                INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
                WHERE tu.usu_estado = '1' AND tu.usu_id <> '$usu_id' AND fon.fon_orden = '$fon_orden_des'
                ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
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

    function listUsuariosArchivo($usu_id, $tipo, $fon_orden_des, $default = null) {
        $sql = "SELECT DISTINCT
                tu.usu_id,tu.usu_nombres,tu.usu_apellidos,tu.rol_id,tu.uni_id,fon.fon_orden
                FROM tab_usuario AS tu
                INNER JOIN tab_rol AS tr ON tu.rol_id = tr.rol_id
                INNER JOIN tab_unidad AS uni ON tu.uni_id = uni.uni_id
                INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
                WHERE tr.rol_cod = '$tipo' AND tu.usu_estado = '1' AND tu.usu_id <> '$usu_id' AND fon.fon_orden = '$fon_orden_des'
                ORDER BY tu.usu_apellidos ASC,tu.usu_nombres ASC";
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
        if ($default) {
            $where .= " AND tu.uni_id = '" . $default . "' ";
        }

        $sql = "SELECT 
                tu.usu_id, 
                tu.uni_id, 
                tu.usu_nombres, 
                tu.usu_apellidos
                FROM tab_usuario AS tu 
                Inner Join tab_rol AS tr ON tr.rol_id = tu.rol_id
                WHERE tu.usu_estado =  1  " . $where . " 
                ORDER BY tu.usu_apellidos ASC, tu.usu_nombres ASC"; 
        $row = $this->usuario->dbselectBySQL2($sql);
        return json_encode($row);
    }

    function count($where) {
        $usuario = new Tab_usuario ();
        $sql = "SELECT count(usu_id)
                    FROM
                    tab_usuario AS u
                    WHERE
                    u.usu_estado =  1 $where ";
        //echo($sql);die;
        $num = $usuario->countBySQL($sql);
        return $num;
    }

    function obtenerSelect($default = null) {
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
            $sql = "select * from tab_usuario where tab_usuario.usu_login = '$login' ";
            $row = $this->usuario->dbselectBySQL($sql);
        } else {
            $sql = "select * from tab_usuario where tab_usuario.usu_login = '$login' AND usu_id<>'$usu_id' ";
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

    function verifyFields($id) {
        $unidad = new unidad ();
        //el ingreso es normal
        $sql = "SELECT *
                FROM tab_usuario
                WHERE usu_id='" . $id . "'";
        $row = $unidad->dbselectBySQL($sql);
        if (count($row)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // codigo de freddy velasco
    function allSerieSeleccionado($usu_id = null) {
        $liMenu = "";
        $sql = "SELECT 
                uni_id,
                uni_codigo,
                uni_descripcion 
                FROM tab_unidad 
                WHERE uni_estado=1";
        $rows = $this->usuario->dbselectBySQL($sql);
        $row1 = 1;
        $i = 0;
        foreach ($rows as $menus) {
            $liMenu .= "		<tr class='erow evenw' id='" . $menus->uni_id . "'>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 80px;'>" . $menus->uni_id . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 120px;'>" . $menus->uni_codigo . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 600px;'>" . $menus->uni_descripcion . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "		</tr>";

            $sql = "SELECT 
                    ser_id, 
                    ser_codigo,
                    ser_categoria 
                    FROM tab_series 
                    WHERE ser_estado=1 AND uni_id='" . $menus->uni_id . "'";
            
            $rowsb = $this->usuario->dbselectBySQL($sql);

            $row1 = 1;

            foreach ($rowsb as $key => $menusb) {
                $chek1 = "";


                if ($usu_id != null) {
                    $sql = "SELECT 
                            use_id 
                            FROM tab_usu_serie 
                            WHERE usu_id=$usu_id AND ser_id='" . $menusb->ser_id . "' AND use_estado=1";

                    $rowChek = $this->usuario->dbselectBySQL($sql);

                    if (count($rowChek) > 0) {

                        $chek1 = "checked";
                    }
                }
                //else echo "<br>vacio";

                $liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->uni_id . "z'" : "class='erow " . $menus->uni_id . "z'") . " style='display:none;'>";
                $liMenu .= "			<input type='hidden' name='id_ser[$i]' value='" . $menusb->ser_id . "'>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: center; width: 80px;'><input name='" . $menusb->ser_id . "[0]' type='checkbox' value='ver' " . $chek1 . "></div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='center' class='sorted'>";
                $liMenu .= "			<div style='text-align: center; width: 120px;'>" . $menusb->ser_id . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: left; width: 600px;'>" . $menusb->ser_categoria . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "		</tr>";
                $row1++;
                $i++;
            }
        }

        return $liMenu;
    }

    function allSeries() {
        $liMenu = "";
//        $sql = "SELECT 
//                uni_id,
//                uni_cod,
//                uni_descripcion 
//                FROM tab_unidad
//                WHERE uni_estado =  '1' 
//                ORDER by uni_cod ";
        
        $sql = "SELECT
                tab_unidad.uni_id,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_unidad.uni_descripcion
                FROM
                tab_unidad
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                WHERE uni_estado = '1' 
                ORDER by uni_cod "; 
        
        $rows = $this->usuario->dbselectBySQL($sql);
        $row1 = 1;
        $i = 0;
        foreach ($rows as $menus) {
            //$liMenu .= "		<tr class='erow' id='" . $menus->uni_id . "'>";
            $liMenu .= "		<tr class='erow evenw' id='" . $menus->uni_id . "'>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 80px;'>&nbsp;Secci&oacute;n</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 120px;'>" . $menus->fon_cod . DELIMITER. $menus->uni_cod . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 600px;'>" . $menus->uni_descripcion . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "		</tr>";

            // Series
//            $sql2 = "SELECT 
//                    ser_id,
//                    ser_codigo,
//                    ser_categoria
//                    FROM tab_series
//                    WHERE uni_id = '" . $menus->uni_id . "' 
//                    AND ser_estado =  '1' 
//                    ORDER BY ser_codigo, ser_categoria";
            $sql2 = "SELECT
                    tab_fondo.fon_cod,
                    tab_unidad.uni_cod,
                    tab_tipocorr.tco_codigo,
                    tab_series.ser_id,
                    tab_series.ser_codigo,
                    tab_series.ser_categoria
                    FROM
                    tab_series
                    INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                    INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    WHERE tab_unidad.uni_id = '" . $menus->uni_id . "' 
                    AND tab_series.ser_estado =  '1' 
                    ORDER BY tab_series.ser_codigo, 
                    tab_series.ser_categoria";
            
            $rowsb = $this->usuario->dbselectBySQL($sql2);
            $row1 = 1;

            foreach ($rowsb as $menusb) {
                //$liMenu .= "		<tr " . ($row1 % 2 ? "" : "class='erow'") . ">";
                $liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->uni_id . "z'" : "class='erow " . $menus->uni_id . "z'") . " >";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: center; width: 80px;'><input name='lista_serie[$i]' type='checkbox' value='" . $menusb->ser_id . "'></div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<input type='hidden' name='id_menu[$i]' value='" . $menusb->ser_id . "'>";
                $liMenu .= "			<td align='center' class='sorted'>";
                $liMenu .= "			<div style='text-align: left; width: 120px;'>" . $menusb->fon_cod. DELIMITER. $menusb->uni_cod . DELIMITER . $menusb->tco_codigo . DELIMITER . $menusb->ser_codigo . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: left; width: 600px;'>" . $menusb->ser_categoria . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "		</tr>";
                $row1++;
                $i++;
            }
        }
        return $liMenu;
    }

    function allSeriesSeleccionado($idUsuario) {
        $liMenu = "";
//        $sql = "SELECT 
//                uni_id,
//                uni_cod,
//                uni_descripcion 
//                FROM tab_unidad
//                WHERE uni_estado = '1' 
//                ORDER by uni_cod ";        
        $sql = "SELECT
                tab_unidad.uni_id,
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_unidad.uni_descripcion
                FROM
                tab_unidad
                INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                WHERE uni_estado = '1' 
                ORDER by uni_cod ";        
        
        $rows = $this->usuario->dbselectBySQL($sql);
        
        $row1 = 1;
        $i = 0;
        foreach ($rows as $menus) {
            $liMenu .= "		<tr class='erow evenw' id='" . $menus->uni_id . "'>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 80px;'>&nbsp;Secci&oacute;n</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 120px;'>" . $menus->fon_cod . DELIMITER . $menus->uni_cod . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 600px;'>" . $menus->uni_descripcion . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "		</tr>";
            
            $sql2 = "SELECT
                    tab_fondo.fon_cod,
                    tab_unidad.uni_cod,
                    tab_tipocorr.tco_codigo,
                    tab_series.ser_id,
                    tab_series.ser_codigo,
                    tab_series.ser_categoria
                    FROM
                    tab_series
                    INNER JOIN tab_unidad ON tab_unidad.uni_id = tab_series.uni_id
                    INNER JOIN tab_fondo ON tab_fondo.fon_id = tab_unidad.fon_id
                    INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                    WHERE tab_unidad.uni_id = '" . $menus->uni_id . "' 
                    AND tab_series.ser_estado = '1' 
                    ORDER BY tab_series.ser_codigo, 
                    tab_series.ser_categoria ";
            $rowsb = $this->usuario->dbselectBySQL($sql2);

            $row1 = 1;

            foreach ($rowsb as $key => $menusb) {
                $sql3 = "SELECT 
                        tab_usu_serie.usu_id, 
                        tab_usu_serie.ser_id
                        FROM tab_usu_serie
                        WHERE tab_usu_serie.usu_id = '" . $idUsuario . "' 
                        AND tab_usu_serie.ser_id = '" . $menusb->ser_id . "' 
                        AND tab_usu_serie.use_estado=1 ";
                $chek1 = "";
                $rowChek = $this->usuario->dbselectBySQL($sql3);

                if (count($rowChek) > 0) {
                    $chek1 = "checked";
                }
                //else echo "<br>vacio";
                if (count($rowChek) > 0) {
                    $liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->uni_id . "z'" : "class='erow " . $menus->uni_id . "z'") . " >";
                }else{
                    //$liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->uni_id . "z'" : "class='erow " . $menus->uni_id . "z'") . " style='display:none;'>";
                    $liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->uni_id . "z'" : "class='erow " . $menus->uni_id . "z'") . " >";
                }
                
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: center; width: 80px;'><input name='lista_serie[$i]' type='checkbox' value='" . $menusb->ser_id . "' " . $chek1 . "></div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<input type='hidden' name='id_menu[$i]' value='" . $menusb->ser_id . "'>";
                $liMenu .= "			<td align='center' class='sorted'>";
                $liMenu .= "			<div style='text-align: left; width: 120px;'>" . $menusb->fon_cod. DELIMITER. $menusb->uni_cod . DELIMITER . $menusb->tco_codigo . DELIMITER . $menusb->ser_codigo . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: left; width: 600px;'>" . $menusb->ser_categoria . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "		</tr>";
                $row1++;
                $i++;
                
            }
        }

        return $liMenu;
    }

}

?>