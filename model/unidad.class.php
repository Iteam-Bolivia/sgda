<?php

/**
 * unidad
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class unidad extends Tab_unidad {

    function __construct() {
        //parent::__construct();
        $this->unidad = new tab_unidad();
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT
                tab_unidad.uni_id,
                tab_unidad.uni_codigo,
                tab_unidad.uni_descripcion,
                tab_unidad.uni_par
                FROM
                tab_unidad
                WHERE
                tab_unidad.uni_estado =  '1' 
                ORDER BY tab_unidad.uni_cod ASC  ";
        $rows = $this->unidad->dbSelectBySQL($sql);
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->uni_id)
                    $selected = "selected";
                else
                    $selected = "";
                $option .="<option value='" . $val->uni_id . "' " . $selected . ">".$val->uni_codigo." - " . $val->uni_descripcion . "</option>";
            }
        }
        return $option;
    }
    function obtenerSeccion($valor){
        
        $usuario=new tab_usuario();
       $sql="SELECT
f.uni_descripcion,
(SELECT uni_descripcion FROM tab_unidad WHERE uni_id =f.uni_par) AS tab_sec
FROM
tab_unidad as f
INNER JOIN tab_usuario ON tab_usuario.uni_id = f.uni_id
WHERE
tab_usuario.usu_id  = $valor";
        $nombre=$usuario->dbSelectBySQL($sql);
        $nombre=$nombre[0];
        
        return $nombre;
    }
    
    function obtenerSelectUnidades($default = null) {
        $sql = "SELECT
                tab_unidad.uni_id,
                tab_unidad.uni_codigo,
                tab_unidad.uni_descripcion,
                tab_unidad.uni_par
                FROM
                tab_unidad
                WHERE
                tab_unidad.uni_estado =  '1' 
                ORDER BY tab_unidad.uni_cod ASC  ";
        $rows = $this->unidad->dbSelectBySQL($sql);
        $option = "";
        foreach ($rows as $unidad) {
            if ($default == $unidad->uni_id) {
                if($unidad->uni_par=='-1'){
                    $option .= "<option value='$unidad->uni_id' selected>$unidad->uni_descripcion</option>";
                }else{
                    $option .= "<option value='$unidad->uni_id' selected>" . "-- " . "$unidad->uni_descripcion</option>";
                }
            } else {
                if($unidad->uni_par=='-1'){
                    $option .= "<option value='$unidad->uni_id'>$unidad->uni_descripcion</option>";
                }else{
                    $option .= "<option value='$unidad->uni_id'>" . "----- " . "$unidad->uni_descripcion</option>";
                }
            }
        }
        return $option;
    }

    
    function obtenerSelectPadres($default = null) {
        $add = "";
        $option = "";
        if ($default != '-1') {
            if ($default != null) {
                $padre = new Tab_unidad();
                $r_padres = $padre->dbselectBy2Field("uni_id", $default, "uni_estado", 1);
                if (count($r_padres) > 0) {
                    $padre = $r_padres[0];
                }
            }
            
            $sql = "SELECT 
                    tu.uni_id, 
                    tu.uni_codigo, 
                    tu.uni_par, 
                    tu.uni_descripcion
                    FROM tab_unidad tu
                    WHERE (tu.uni_estado = '10' OR tu.uni_estado = '1') $add
                    ORDER BY tu.uni_cod ASC ";
            $rows = $this->unidad->dbSelectBySQL($sql);
            if (count($rows) > 0) {
                foreach ($rows as $val) {
                    if ($default == $val->uni_id)
                        $selected = "selected";
                    else
                        $selected = " ";
                    
                    if ($val->uni_par==-1){
                        $option .="<option value='" . $val->uni_id . "' " . $selected . ">" . $val->uni_descripcion . "</option>";
                    }else{
                        $option .="<option value='" . $val->uni_id . "' " . $selected . ">" . "-- " . $val->uni_descripcion . "</option>";
                    }
                }
            }
        }
        return $option;
    }


    function obtenerSelectUniFondo($default = null, $id_uni) {
        $rows = $this->unidad->dbSelectBySQL("SELECT
                                        unifon.uni_id AS id_fondo,
                                        unifon.uni_descripcion AS desc_fondo,
                                        uni.uni_id,
                                        uni.uni_descripcion
                                        FROM
                                        tab_unidad AS unifon
                                        INNER JOIN tab_unidad AS uni ON uni.unif_id = unifon.uni_id
                                        WHERE
                                        uni.uni_estado = 1
                                        AND unifon.uni_id = " . $id_uni . "
                                        ORDER BY uni.uni_descripcion ASC ");
        $option = "";
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->uni_id)
                    $selected = "selected";
                else
                    $selected = "";
                $option .="<option value='" . $val->uni_id . "' " . $selected . ">" . $val->uni_descripcion . "</option>";
            }
        }
        return $option;
    }    
    
    function listUnidad($default = null) {
        $add = "";
        $sql = "SELECT 
                uni_id ,
                uni_descripcion
                FROM tab_unidad 
                WHERE uni_estado = 1 $add 
                ORDER BY uni_id ";
        $row = $this->unidad->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->uni_id)
                $selected = "selected";
            else
                $selected = " ";
            $option .="<option value='" . $val->uni_id . "' $selected>" . $val->uni_descripcion . "</option>";
        }
        return $option;
    }

    function getTitle($id) {
        $row = $this->unidad->dbselectBySQL("select * from tab_unidad where uni_id = $id");
        $option = "";
        foreach ($row as $val) {
            $option = $val->uni_descripcion;
        }
        return $option;
    }

    function getCodigo($id) {
        $sql = "select 
                uni_cod 
                from tab_unidad 
                where uni_id = $id";
        $row = $this->unidad->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            $option = $val->uni_cod;
        }
        return $option;
    }

    function obtenerUnidadUsuario($pk_user) {
        $row = $this->unidad->dbselectBySQL("select * from tab_unidad where uni_id IN( SELECT uni_id FROM tab_usuario WHERE usu_id = " . $pk_user . ")");
        $i = 0;
        foreach ($row as $val) {
            $rows[$i] = $val;
        }
        return $rows;
    }

    function dameDatosUnidad($id) {
        $this->aux = new unidad();
        $row = $this->unidad->dbselectBySQL("select * from tab_unidad WHERE uni_id='" . $id . "'");
        if (count($row)) {
            return $row[0];
        } else {
            return $this->aux;
        }
    }

    function copyEstructura() {
        //insertar copia de la estructura de tab_unidad con la ultima version
        $sql = "SELECT * FROM tab_unidad WHERE uni_estado <>'2'";
        $rows_uni = $this->unidad->dbSelectBySQL($sql);
        foreach ($rows_uni as $uni) {
            $unidad = new Temp_unidad ();
            $unidad->setTemp_uni_id("");
            $unidad->setUni_id($uni->getUni_id());
            $unidad->setNiv_id($uni->getNiv_id());
            $unidad->setVer_id($uni->getVer_id());
            $unidad->setUni_codigo($uni->getUni_codigo());
            $unidad->setUni_descripcion($uni->getUni_descripcion());
            $unidad->setUni_ml($uni->getUni_ml());
            $unidad->setUbi_id($uni->getUbi_id());
            $unidad->setUni_par($uni->getUni_par());
            $unidad->setUni_piso($uni->getUni_piso());
            $unidad->setUni_fecha_crea($uni->getUni_fecha_crea());
            $unidad->setUni_usuario_crea($uni->getUni_usuario_crea());
            $unidad->setUni_fecha_mod($uni->getUni_fecha_mod());
            $unidad->setUni_usuario_mod($uni->getUni_usuario_mod());
            $unidad->setIns_id($uni->getIns_id());
            $unidad->setUni_estado($uni->getUni_estado());
            $unidad->insert();
        }
    }

    function obtenerCheck($uni_id, $usu_id = null) {
        $check = '';
        $add = "";
        if ($usu_id != null || $usu_id != '') {
            $add = " (SELECT
            us.sec_id
            FROM
            tab_usu_sec AS us
            WHERE
            us.sec_id =  s.sec_id AND us.use_estado = '1' AND us.usu_id='$usu_id') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT
            s.sec_id,
            s.sec_codigo,
            s.sec_nombre,
            $add
            FROM
            tab_seccion AS s
            WHERE
            s.sec_estado =  '1' AND s.uni_id='$uni_id'
            ORDER BY s.sec_codigo ASC  ";
        $rows = $this->unidad->dbSelectBySQL($sql);
        $i = 0;
        $check .= '<table class="marcaRegistro" width="100%">';
        foreach ($rows as $serie) {
            $ck = '';
            if ($serie->seleccionado != null)
                $ck = ' checked="checked" ';

            $check.='<tr><td><input type="checkbox" name="lista_sec[' . $i . ']" ' . $ck . ' id="serie-' . $serie->sec_id . '" value="' . $serie->sec_id . '" /></td> <td>' . $serie->sec_codigo . '</td> <td>' . $serie->sec_nombre . '</td> </tr>';
            $i++;
        }
        $check .= '</table>';
        return $check;
    }

    function obtenerDatosUnidad($username = null, $pass = null) {
        $row = "";
        $root = "";
        if ($username=='root') $root="OR tab_usuario.usu_estado='0' ";
        $this->unidad = new tab_unidad();
        if ($username != null || $pass != null) {
            $sql = "SELECT
                        tab_unidad.uni_codigo
                        FROM
                        tab_departamento
                        INNER JOIN tab_provincia ON tab_departamento.dep_id = tab_provincia.dep_id
                        INNER JOIN tab_localidad ON tab_provincia.pro_id = tab_localidad.pro_id
                        INNER JOIN tab_ubicacion ON tab_localidad.loc_id = tab_ubicacion.loc_id
                        INNER JOIN tab_unidad ON tab_ubicacion.ubi_id = tab_unidad.ubi_id
                        INNER JOIN tab_usuario ON tab_unidad.uni_id = tab_usuario.uni_id
                        WHERE tab_usuario.usu_login ='" . $username . "' AND tab_usuario.usu_pass ='" . $pass . "' AND usu_estado=1 $root ";
            $row = $this->unidad->dbselectBySQL($sql);
            $row = $row [0];
            if (is_object($row))
                return $row;
            else
                return 0;
        } else
            0;
    }
    
    function existeCodigo($uni_codigo) {
        $row = array();
        if ($uni_codigo != null) {
            $sql = "select * 
                    from tab_unidad 
                    where tab_unidad.uni_codigo = '$uni_codigo' ";
            $row = $this->unidad->dbselectBySQL($sql);
        }else{
            return false;
        }
        if (count($row) > 0) {
            return true;
        } else return false;
    }    
    
    
    function obtenerIdUnidadCodigoSerie($ser_codigo) {
        $delimiter = DELIMITER;
        $unidad = new Tab_unidad();
        $codigo = explode($delimiter, $ser_codigo);
        $uni_codigo = $codigo[1];        
        $uni_id = 0;
        $rows = "";
        $sql = "SELECT 
                uni_id
		FROM tab_unidad
		WHERE 
                uni_estado = '1' 
                AND uni_codigo = '$uni_codigo' ";
        $rows = $unidad->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $uni_id = $val->uni_id;
        }
        return $uni_id;
    }     

}

?>