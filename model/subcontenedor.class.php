<?php

/**
 * subcontenedor.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class subcontenedor extends tab_subcontenedor {

    function __construct() {
        $this->subcontenedor = new tab_subcontenedor();
    }

    function count($where) {
        $subcontenedor = new tab_subcontenedor ();
        $sql = "SELECT count(suc.suc_id)
                FROM tab_subcontenedor AS suc 
                INNER JOIN tab_contenedor AS con ON suc.con_id = con.con_id
                INNER JOIN tab_usuario AS usu ON con.usu_id = usu.usu_id
                WHERE con.con_id = " . VAR3 . " 
                AND suc.suc_estado = 1 
                AND con.con_estado = 1  $where ";
        $num = $subcontenedor->countBySQL($sql);
        return $num;
    }

    function loadSelect($suc_seleccionado, $con_id = null) {
        $cadena = "";
        $sql = "SELECT
		  tab_subcontenedor.suc_id,
		  tab_subcontenedor.suc_codigo,
		  tab_subcontenedor.con_id,
		  tab_subcontenedor.suc_tipo,
		  tab_subcontenedor.suc_nro_balda
		  FROM
		  tab_subcontenedor";
        if (!empty($con_id))
            $sql .=" WHERE tab_subcontenedor.con_id =  '$con_id' ";
        $result = $this->subcontenedor->dbSelectBySQL($sql);
        if ($result)
            foreach ($result as $row) {
                $cadena.="<option value='$row->suc_id'";
                if (!empty($suc_seleccionado) && $suc_seleccionado == $row->suc_id) {
                    $cadena.=" selected";
                }
                $cadena.=">$row->suc_codigo</option>";
            }
        return $cadena;
    }

    function getCtp_id($ctp_codigo) {
        $tt = new tab_tipocontenedor();
        $r_tt = $tt->dbSelectByField("ctp_codigo", $ctp_codigo);
        $id = null;
        if (count($r_tt) > 0) {
            $id = $r_tt[0]->ctp_id;
        }
        return $id;
    }

    function selectSuc($suc_id, $con_id = NULL) {
        $tab_subcontenedor = new tab_subcontenedor();

        if ($con_id == NULL) {
            $sql = "SELECT con_id FROM tab_subcontenedor WHERE suc_estado=1 AND suc_id=$suc_id";
            $res = $tab_subcontenedor->dbSelectBySQL($sql);
            $con_id = $res[0]->con_id;
        }
        $sql = "SELECT suc_id, suc_codigo FROM tab_subcontenedor WHERE suc_estado=1 AND con_id=$con_id";
        $res = $tab_subcontenedor->dbSelectBySQL($sql);
        $option = "";
        $option .="<option value=''>(Seleccionar)</option>";
        foreach ($res as $value) {
            if ($value->suc_id == $suc_id)
                $option .="<option value='" . $value->suc_id . "' selected>" . $value->suc_codigo . "</option>";
            else
                $option .="<option value='" . $value->suc_id . "' >" . $value->suc_codigo . "</option>";
        }
        return $option;
    }

    
    function getSucNombre($suc_id) {
        $tab_subcontenedor = new tab_subcontenedor();
        $r_tt = $tab_subcontenedor->dbSelectByField("suc_id", $suc_id);
        $id = null;
        if (count($r_tt) > 0) {
            $id = $r_tt[0]->suc_codigo;
        }
        return $id;
    }
    
}

?>