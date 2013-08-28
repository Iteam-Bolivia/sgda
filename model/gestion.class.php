<?php

/**
 * gestion.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2011
 * @access public
 */
class gestion extends tab_gestion {

    function __construct() {
        //parent::__construct();
        $this->gestion = new tab_gestion();
    }

    function getNumero($ser_id, $emp_id, $usu_id) {
        $gestion = "";
        if ($ser_id == 1) {
            $sql_gestion = "SELECT *
	                    FROM tab_gestion
	                    WHERE ser_id = $ser_id AND ges_estado = 1
	                    ORDER BY ges_id ASC ";
            $rows = $this->gestion->dbSelectBySQL($sql_gestion);
            if (count($rows) > 0) {
                foreach ($rows as $ges) {
                    $gestion = $ges->ges_numero;
                    $gestion++;
                    $gestion = str_pad($gestion, 4, "0", STR_PAD_LEFT) . "." . $ges->ges_nombre;
                }
            } else {
                $gestion = "";
            }
            return $gestion;
        }
        if ($ser_id == 2) {
            // HZ.ABC.0111.11
            $sql_gestion = "SELECT *
	                    FROM tab_gestion
	                    WHERE ser_id = $ser_id AND ges_estado = 1
	                    ORDER BY ges_id ASC ";
            $rows = $this->gestion->dbSelectBySQL($sql_gestion);
            if (count($rows) > 0) {
                foreach ($rows as $ges) {
                    $gestion = $ges->ges_numero;
                    $gestion++;
                    $gestion = str_pad($gestion, 4, "0", STR_PAD_LEFT) . "." . $ges->ges_nombre;
                }
            } else {
                $gestion = "";
            }

            // User Code
            $sql_gestion = "SELECT usu_iniciales
		    	            FROM tab_usuario
	    	                WHERE usu_id = $usu_id ";
            $rows = $this->gestion->dbSelectBySQL($sql_gestion);
            if (count($rows) > 0) {
                foreach ($rows as $ges) {
                    $gestion = $ges->usu_iniciales . "." . $gestion;
                }
            }

            // Empresa Code
            $sql_gestion = "SELECT emp_sigla
		    	            FROM tab_empresas
	    	                WHERE emp_id = $emp_id ";
            $rows = $this->gestion->dbSelectBySQL($sql_gestion);
            if (count($rows) > 0) {
                foreach ($rows as $ges) {
                    $gestion = $ges->emp_sigla . "." . $gestion;
                }
            }


            return $gestion;
        }
    }

    function getSiguiente($ser_id) {
        $gestion = 0;
        $sql_gestion = "SELECT *
	                    FROM tab_gestion
	                    WHERE ser_id = $ser_id AND ges_estado = 1
	                    ORDER BY ges_id ASC ";
        $rows = $this->gestion->dbSelectBySQL($sql_gestion);
        if (count($rows) > 0) {
            foreach ($rows as $ges) {
                $gestion = $ges->ges_numero;
                $gestion++;
            }
        } else {
            $gestion = 0;
        }
        return $gestion;
    }

    function actualizaNumero($ser_id, $numero) {
        $sql_gestion = "UPDATE tab_gestion
                    SET ges_numero = $numero
                    WHERE ser_id = $ser_id AND ges_estado = 1";
        $rows = $this->gestion->dbSelectBySQL($sql_gestion);
        return $rows;
    }

    function loadSelect($cont_seleccionado = null) {
        $cadena = "";
        $sql = "SELECT *
		  FROM tab_empresas
		  ORDER BY emp_id ";
        $result = $this->gestion->dbSelectBySQL($sql);
        if ($result) {
            foreach ($result as $row) {
                if (!empty($cont_seleccionado) && $cont_seleccionado == $row->emp_id) {
                    $cadena.="<option value='$row->emp_id' selected>$row->emp_nombre</option>";
                } else {
                    $cadena.="<option value='$row->emp_id'>$row->emp_nombre</option>";
                }
            }
        }
        return $cadena;
    }

    function loadSelectExt($cont_seleccionado = null) {
        $cadena = "";
        $sql = "select * from tab_empresas_ext where tab_empresas_ext.emp_estado = 1 ORDER BY emp_id ASC";
        $result = $this->gestion->dbSelectBySQL($sql);
        if ($result) {
            foreach ($result as $row) {
                if (!empty($cont_seleccionado) && $cont_seleccionado == $row->emp_id) {
                    $cadena.="<option value='" . $row->emp_id . "' selected>" . $row->emp_nombre . "</option>";
                } else {
                    $cadena.="<option value='" . $row->emp_id . "'>" . $row->emp_nombre . "</option>";
                }
            }
        }
        return $cadena;
    }

    function loadSelectUsuario($cont_seleccionado = null) {
        $cadena = "";
        $sql = "SELECT *
		  FROM tab_usuario
		  ORDER BY usu_id ";
        $result = $this->gestion->dbSelectBySQL($sql);
        if ($result) {
            foreach ($result as $row) {
                if (!empty($cont_seleccionado) && $cont_seleccionado == $row->usu_id) {
                    $cadena.="<option value='$row->usu_id' selected>$row->usu_apellidos" . " " . "$row->usu_nombres</option>";
                } else {
                    $cadena.="<option value='$row->usu_id'>$row->usu_apellidos" . " " . "$row->usu_nombres</option>";
                }
            }
        }
        return $cadena;
    }

    function obtenerSelectTodas($default = null) {
        $rows = $this->gestion->dbSelectBySQL("SELECT
			ts.ser_id,
			ts.ser_categoria
			FROM
			tab_gestion ts
			WHERE
			ts.ser_estado =  '1'
                        ORDER BY ts.ser_categoria ASC");
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->ser_id)
                    $selected = "selected";
                else
                    $selected = "";
                $option .="<option value='" . $val->ser_id . "' $selected>" . $val->ser_categoria . "</option>";
            }
        }
        return $option;
    }

    function obtenerSelect($default = null) {
        $option = "";
        if ($default == 1) {
            $option = "<select name='ges_estado' id='ges_estado' class='required'><option value='1' selected>Activo</option><option value='0'>Inactivo</option></select>";
        } else {
            $option = "<select name='ges_estado' id='ges_estado' class='required'><option value='1'>Activo</option><option value='0' selected>Inactivo</option></select>";
        }
        return $option;
    }

    function count($where) {
        $gestion = new Tab_gestion ();
        $sql = "SELECT count(ges_id)
                    FROM
                    tab_gestion ";
        $num = $gestion->countBySQL($sql);
        return $num;
    }

    function getTitle($ser_id) {
        $row = $this->gestion->dbselectByField("ser_id", $ser_id);
        if (!is_null($row))
            return $row[0]->ser_categoria;
        else
            return "";
    }

    function ceros_izquierda($numero, $ceros) {
        $order_diez = explode(".", $numero);
        $dif_diez = $ceros - strlen($order_diez[0]);
        for ($m = 0; $m < $dif_diez; $m++) {
            @$insertar_ceros .= 0;
        }
        return $insertar_ceros .= $numero;
    }

}

?>
