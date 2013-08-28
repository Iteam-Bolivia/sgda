<?php

/**
 * fondoModel
 *
 * @package
 * @author Dev. a.
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class fondo extends Tab_fondo {

    function __construct() {
        //parent::__construct();
        $this->fondo = new Tab_fondo();
    }

    function count($where) {
        $fondo = new Tab_fondo ();
        $sql = "SELECT count(fon_id)
                    FROM
                    tab_fondo AS u
                    WHERE
                    u.fon_estado =  1 $where ";
        $num = $fondo->countBySQL($sql);
        return $num;
    }

    
    function obtenerSelect($default = null) {
        $sql = "SELECT 
            f.fon_id,
            f.fon_descripcion
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1'
            ORDER BY f.fon_id ";
        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        foreach ($rows as $fon) {
            if ($default == $fon->fon_id) {
                $fondos .= "<option value='$fon->fon_id' selected>$fon->fon_descripcion</option>";
            } else {
                $fondos .= "<option value='$fon->fon_id'>$fon->fon_descripcion</option>";
            }
        }
        return $fondos;
    }
    
    function validaDependencia($fon_id) {
        $fondo = new tab_fondo();        
        $option = 0;
        $sql = "SELECT COUNT (fon_id) from tab_fondo WHERE fon_par=$fon_id";
        $algo = $fondo->countBySQL($sql);
        if ($algo == 0) {
            $sql = "SELECT COUNT (tab_fondo.fon_id)
                    FROM tab_fondo 
                    INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id 
                    INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.ser_id 
                    WHERE tab_fondo.fon_id = $fon_id ";
            $algo = $fondo->countBySQL($sql);            
            if ($algo != 0) {
                $option = 1;
            }            
        }else{
            $option = 1;
        }
        return $option;
    }
    
    function obtenerCodigoFondo($fon_id = null) {
        $sql = "SELECT 
            f.fon_id,
            f.fon_cod,
            f.fon_contador
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1' and f.fon_id = '$fon_id'
            ORDER BY f.fon_id ";
        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        $contador = 0;
        foreach ($rows as $fon) {
            $contador = $fon->fon_contador+1;
            $fondos = $fon->fon_cod . "." . $contador;
        }
        return $fondos;
    }    
    
    function generarCodigoFondo() {
        $sql = "SELECT count(f.fon_id) as contador
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado = '1'";
        $rows = $this->fondo->dbSelectBySQL($sql);
        $contador = 0;
        foreach ($rows as $fon) {
            $contador = $fon->contador;
        }
        return ($contador + 1);
    } 
    
    
    function getCod($uni_id) {
        $sql = "SELECT
                tab_fondo.fon_cod
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id 
                where tab_fondo.fon_estado = '1' AND tab_unidad.uni_id = '$uni_id' ";
        $row = $this->fondo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            $option = $val->fon_cod;
        }
        return $option;
    }    
    
    function getCodigo($fon_id) {
        $sql = "SELECT
                tab_fondo.fon_codigo
                FROM
                tab_fondo
                WHERE tab_fondo.fon_estado = '1' AND tab_fondo.fon_id = '$fon_id' ";
        $row = $this->fondo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            $option = $val->fon_codigo;
        }
        return $option;
    }     
    
    // others
    
    
    
    
    
    function obtenerInsFondo($ins_id) {
        $sql = "SELECT
        tab_fondo.fon_id,
        tab_fondo.fon_orden,
        tab_fondo.fon_descripcion,
        tab_unidad.uni_id,
        tab_unidad.unif_id,
        (SELECT uni_codigo from tab_unidad WHERE uni_id=tab_unidad.unif_id) as uni_codigo,
        (SELECT uni_descripcion from tab_unidad WHERE uni_id=tab_unidad.unif_id) as fondo
        FROM
        tab_fondo
        INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
        WHERE
        tab_unidad.uni_estado = '1' AND
        tab_unidad.unif_id =  '$ins_id' ";
        $rows = $this->fondo->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    function obtenerFondo($usu_id, $orden) {
//        $sql = "SELECT DISTINCT
//        tf.fon_id,
//        tf.fon_orden,
//        tf.fon_descripcion,
//        tti.ins_nombre,
//        ttif.ins_id,
//        ttif.inl_id
//        FROM
//        tab_inst_fondo AS ttif
//        Inner Join tab_unidad AS tu ON tu.ins_id = ttif.ins_id
//        Inner Join tab_usuario AS tus ON tus.uni_id = tu.uni_id
//        Inner Join tab_fondo AS tf ON ttif.fon_id = tf.fon_id
//        Inner Join tab_institucion AS tti ON ttif.ins_id = tti.ins_id
//        WHERE
//        tus.usu_id =  '$usu_id' AND
//        tf.fon_orden =  '$orden' AND
//        ttif.inl_estado =  '1' "; //print_r($sql);die;

        $sql = "SELECT fon.fon_id,fon.fon_cod,fon.fon_descripcion,fon.fon_orden
FROM tab_usuario AS usu
INNER JOIN tab_unidad AS uni ON usu.uni_id = uni.uni_id
INNER JOIN tab_fondo AS fon ON uni.fon_id = fon.fon_id
WHERE usu.usu_id = '$usu_id' AND fon.fon_orden = '$orden' AND usu.usu_estado = 1 AND uni.uni_estado = 1";

        $rows = $this->fondo->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    function obtenerArchivo($fon_orden) {
        //Obtener la descripcion del Archivo Central y la institucion a la q pertenece
//        $sql="SELECT DISTINCT
//        tf.fon_id,
//        tf.fon_orden,
//        tf.fon_descripcion,
//        tti.ins_nombre,
//        ttif.ins_id,
//        ttif.inl_id
//        FROM
//        tab_inst_fondo AS ttif
//        Inner Join tab_fondo AS tf ON ttif.fon_id = tf.fon_id
//        Inner Join tab_institucion AS tti ON ttif.ins_id = tti.ins_id
//        WHERE
//        tti.ins_estado = '1' AND
//        tf.fon_id =  '3' AND
//        ttif.inl_estado =  '1' ";

        $sql = "SELECT fon.fon_id,fon.fon_descripcion,fon.fon_orden,uni.uni_id,
uni.unif_id,uni.uni_codigo,uni.uni_descripcion
FROM tab_fondo AS fon
INNER JOIN tab_unidad AS uni ON fon.fon_id = uni.fon_id
WHERE fon.fon_estado = 1 AND uni.uni_estado=1  AND fon.fon_orden = '$fon_orden'";

        $rows = $this->fondo->dbSelectBySQL($sql);
        if (count($rows) > 0) {
            return $rows[0];
        } else {
            return null;
        }
    }

    function obtenerFondos($ins_id) {
        $sql = "SELECT DISTINCT
            f.fon_id,
            f.fon_descripcion,
            i.ins_nombre,
            inf.inl_id,
            inf.ins_id
            FROM
            tab_inst_fondo AS inf
            Inner Join tab_fondo AS f ON inf.fon_id = f.fon_id
            Inner Join tab_institucion AS i ON inf.ins_id = i.ins_id
            WHERE
            f.fon_estado = '1'
            AND inf.inl_estado = '1'
            AND f.fon_orden>0
            AND inf.ins_id =  '$ins_id' ";

        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        foreach ($rows as $fon) {
            $fondos .= $fon->fon_descripcion . ", ";
        }
        $fondos = substr($fondos, 0, -2);
        return $fondos;
    }

    function obtenerSelectTodos($default = null) {
        $sql = "SELECT DISTINCT
            f.fon_id,
            f.fon_descripcion
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1' ";
        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        foreach ($rows as $fon) {
            if ($default == $fon->fon_id) {
                $fondos .= "<option value='$fon->fon_id' selected>$fon->fon_descripcion</option>";
            } else {
                $fondos .= "<option value='$fon->fon_id'>$fon->fon_descripcion</option>";
            }
        }
        return $fondos;
    }

    function obtenerSelectFondos($default = null) {
        $sql = "SELECT            
            f.fon_id,
            f.fon_par,
            f.fon_descripcion
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1'
            ORDER BY f.fon_cod ";
        //AND f.fon_orden>0
        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        foreach ($rows as $fon) {
            if ($default == $fon->fon_id) {
                if($fon->fon_par=='-1'){
                    $fondos .= "<option value='$fon->fon_id' selected>$fon->fon_descripcion</option>";
                }else{
                    $fondos .= "<option value='$fon->fon_id' selected>" . "-- " . "$fon->fon_descripcion</option>";
                }
            } else {
                if($fon->fon_par=='-1'){
                    $fondos .= "<option value='$fon->fon_id'>$fon->fon_descripcion</option>";
                }else{
                    $fondos .= "<option value='$fon->fon_id'>" . "----- " . "$fon->fon_descripcion</option>";
                }
            }
        }
        return $fondos;
    }

    
    function obtenerSelectFondosbySeccion($default = null) {
       $sql = "SELECT            
            f.fon_id,
            f.fon_par,
            f.fon_descripcion
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1'
            ORDER BY f.fon_cod ";
        //AND f.fon_orden>0
        $rows = $this->fondo->dbSelectBySQL($sql);
        $fondos = "";
        foreach ($rows as $fon) {
            $sql = "SELECT            
                    fon_id
                    FROM
                    tab_unidad
                    WHERE
                    uni_estado =  '1' and fon_id = '$fon->fon_id' and uni_id = '$default'
                    ORDER BY uni_id ";            
            
            $rows2 = $this->fondo->dbSelectBySQL($sql);
            if (count($rows2) > 0) {
                if($fon->fon_par==0){
                    $fondos .= "<option value='$fon->fon_id' selected>$fon->fon_descripcion</option>";
                }else{
                    $fondos .= "<option value='$fon->fon_id' selected>" . "----- " . "$fon->fon_descripcion</option>";
                }
            } else {
                if($fon->fon_par==0){
                    $fondos .= "<option value='$fon->fon_id'>$fon->fon_descripcion</option>";
                }else{
                    $fondos .= "<option value='$fon->fon_id'>" . "----- " . "$fon->fon_descripcion</option>";
                }
            }            

        }
        return $fondos;
    }
    
    function obtenerCheck($default = null) {
        $check = '';
        $add = "";
        if ($default != null) {
            $add = " (SELECT
            inf.fon_id
            FROM
            tab_inst_fondo AS inf
            WHERE
            inf.fon_id =  f.fon_id AND inf.inl_estado = '1' AND inf.ins_id='$default') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT DISTINCT
            f.fon_id,
            f.fon_descripcion,
            $add
            FROM
            tab_fondo AS f
            WHERE
            f.fon_estado =  '1' AND f.fon_orden>0 AND f.fon_id<>'3'";
        $rows = $this->fondo->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $fon) {
            $ck = '';
            if ($fon->seleccionado != null)
                $ck = ' checked="checked" ';
            $check.="<tr><td><input class='required' type='checkbox' $ck name='fondos[$i]' id='fon-$fon->fon_id' value='$fon->fon_id' /></td><td>$fon->fon_descripcion</td></tr>";
            $i++;
        }
        return $check;
    }


}

?>
