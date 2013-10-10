<?php

/**
 * rol.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class rol extends tab_rol {

    function __construct() {
        $this->rol = new Tab_rol();
    }

    function obtenerSelectRoles($default = null) {
        if ($default == '0'){
            $rows = $this->rol->dbSelectBySQL("SELECT * from tab_rol where (rol_estado = '1' OR rol_estado = '0') ");
        }else{
            $rows = $this->rol->dbSelectBySQL("SELECT * from tab_rol where rol_estado = '1' ");
        }
        $option = "";
        if (count($rows)) {
            foreach ($rows as $val) {
                if ($default == $val->rol_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->rol_id . "' " . $selected . ">" . $val->rol_titulo . "</option>";
            }
        }
        return $option;
    }

    function count($tipo, $value1) {
        $rol = new Tab_rol ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'rol_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(rol_id) as num
		from tab_rol
		WHERE rol_estado = '1' $where ";
        $num = $rol->countBySQL($sql);

        return $num;
    }

    function validaAcceso($usu_id = null, $men_enlace = null) {
        $row = "";
        $this->rol = new tab_rol ();
        $sql = "SELECT
                tab_usuario.usu_id,
                tab_menu.men_enlace
                FROM
                tab_usuario
                Inner Join tab_rol ON tab_rol.rol_id = tab_usuario.rol_id
                Inner Join tab_usurolmenu ON tab_rol.rol_id = tab_usurolmenu.rol_id
                Inner Join tab_menu ON tab_menu.men_id = tab_usurolmenu.men_id
                WHERE tab_usuario.usu_id = '$usu_id' AND tab_menu.men_enlace = '$men_enlace' ";     //AND tab_usurolmenu.urm_estado=1
        $row = $this->rol->dbselectBySQL($sql);
        if (count($row))
            return true;
        else
            return false;
    }
    function existeCodigo($rol_cod) {
        $row = array();
        if ($rol_cod != null) {
            $sql = "select rol_id 
                    from tab_rol
                    where tab_rol.rol_cod = '$rol_cod' ";
            $row = $this->rol->dbselectBySQL($sql);
        }else{
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else return false;
    }  
}

?>
