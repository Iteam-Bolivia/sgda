<?php

/**
 * series.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class series extends tab_series {

    function __construct() {
        //parent::__construct();
        $this->series = new tab_series();
    }

    function validaDependencia($ser_id) {
        $series = new tab_series();        
        $option = 0;
        $sql = "SELECT COUNT (ser_id) from tab_series WHERE ser_par=$ser_id";
        $algo = $series->countBySQL($sql);
        if ($algo == 0) {
            $sql = "SELECT COUNT (tab_series.ser_id)
                    FROM tab_series
                    INNER JOIN tab_expediente ON tab_series.ser_id = tab_expediente.ser_id 
                    INNER JOIN tab_exparchivo ON tab_expediente.exp_id = tab_exparchivo.exp_id 
                    WHERE tab_series.ser_id = $ser_id ";
            $algo = $series->countBySQL($sql);            
            if ($algo != 0) {
                $option = 1;
            }            
        }else{
            $option = 1;
        }
        return $option;
    }
    
    function getTitle($ser_id) {
        $row = $this->series->dbselectByField("ser_id", $ser_id);
        if (!is_null($row))
            return $row[0]->ser_categoria;
        else
            return "";
    }

    function getTransFondo($trn_uni_origen, $trn_usuario_orig, $trn_fecha_crea) {
        $sql_series = "SELECT DISTINCT
                    s2.ser_id,
                    s2.ser_categoria
                    FROM
                    tab_transferencia AS t2
                    Inner Join tab_expediente AS e2 ON e2.exp_id = t2.exp_id Inner Join
                    tab_series AS s2 ON s2.ser_id = e2.ser_id
                    WHERE
                    t2.trn_uni_origen='$trn_uni_origen'
                    AND t2.trn_usuario_orig='$trn_usuario_orig'
                    AND t2.trn_fecha_crea = '$trn_fecha_crea'
                    ORDER BY s2.ser_categoria ASC "; //print ($sql_series);die;
        $rows = $this->series->dbSelectBySQL($sql_series);
        $series = "";
        if (count($rows) > 0) {
            foreach ($rows as $ser) {
                $series.=$ser->ser_categoria . ',';
            }
            $series = substr($series, 0, -1);
        } else {
            $series = 'VARIAS SERIES';
        }
        return $series;
    }

    function getTransArchivo($fon_id, $trn_fecha_crea) {
        $sql_series = "SELECT DISTINCT
                        s2.ser_id,
                        s2.ser_categoria
                        FROM
                        tab_transferencia AS t2
                        Inner Join tab_expediente AS e2 ON e2.exp_id = t2.exp_id Inner Join
                        tab_series AS s2 ON s2.ser_id = e2.ser_id
                        WHERE
                        t2.trn_confirmado =  '$fon_id'
                        AND t2.trn_fecha_crea = '$trn_fecha_crea'
                        ORDER BY s2.ser_categoria ASC  "; //print ($sql_series);die;
        $rows = $this->series->dbSelectBySQL($sql_series);
        $series = "";
        if (count($rows) > 0) {
            foreach ($rows as $ser) {
                $series.=$ser->ser_categoria . ',';
            }
            $series = substr($series, 0, -1);
        } else {
            $series = 'VARIAS SERIES';
        }
        return $series;
    }

    function loadMenuFondo($fon_orden, $fun = "") {
        if ($fun == "") {
            $fun = "test";
        }
        //$row = $this->getPorFondo($_SESSION ['USU_ID'],$fon_orden);
        $sql = "SELECT DISTINCT
                s.ser_id,
                s.ser_categoria
                FROM
                tab_series AS s
                Inner Join tab_expediente AS e ON e.ser_id = s.ser_id
                Inner Join tab_expfondo AS ef ON ef.exp_id = e.exp_id
                Inner Join tab_fondo AS f ON f.fon_id = ef.fon_id
                WHERE
                f.fon_orden =  '$fon_orden'
                ORDER BY s.ser_categoria ASC  ";
        //print $sql;die;
        // REVISED: CASTELLON
        // ERROR
        $rows = $this->series->dbSelectBySQL($sql);
        $search = "";
        foreach ($rows as $val) {
            $search .= "{separator: true},{name: '" . $val->ser_categoria . "', bclass: 'ser_categoria', onpress : $fun},";
        }
        $search = substr($search, 0, -1);
        return $search;
    }

    function loadMenu($adm = false, $fun = null) {
        if ($fun == null) {
            $fun = "test";
        }
        $usu_id = null;
        if (!$adm) {
            $usu_id = $_SESSION ['USU_ID'];
        }
        $row = $this->getSeries($usu_id);
        $search = "";
        $search .= "{separator: true},{name: 'TODOS', bclass: 'ser_categoria', onpress : $fun},";
        foreach ($row as $val) {
            $search .= "{separator: true},{name: '" . $val->ser_categoria . "', bclass: 'ser_categoria', onpress : $fun},";
        }
        $search = substr($search, 0, -1);
        return $search;
    }

    function getPrimeraSerie($adm = false) {
        $usu_id = null;
        if (!$adm) {
            $usu_id = $_SESSION ['USU_ID'];
        }
        $rows = $this->getSeries($usu_id);
        $res = "";
        foreach ($rows as $val) {
            $res = $val->ser_id;
        }
        return $res;
    }

    function getSeries($usu_id = null) {
        $rows = array();
        $where = "";
        if ($usu_id != null) {
            $where .= " AND u.usu_id =  '" . $usu_id . "' ";
        }
        $sql = "SELECT DISTINCT 
                    s.ser_id, 
                    s.ser_categoria
                    FROM
                    tab_usu_serie AS u 
                    Inner Join tab_series s ON u.ser_id = s.ser_id
                    WHERE
                    u.use_estado = '1' 
                    AND s.ser_estado = '1' $where
                    ORDER BY s.ser_id ASC  ";
        //echo ($sql);die();
        $rows = $this->series->dbSelectBySQL($sql);
        return $rows;
    }

    function loadMenuTransfer($inl_id, $adm, $fun) {
        if ($fun == "") {
            $fun = "test";
        }
        $sql = "SELECT DISTINCT
		    ts.ser_id,
		    ts.ser_categoria
		    FROM tab_series ts
                    Inner Join tab_expediente te ON te.ser_id = ts.ser_id
                    Inner Join tab_transferencia tt ON tt.exp_id = te.exp_id
                    Inner Join tab_usu_serie AS u ON u.ser_id = ts.ser_id
                    WHERE ts.ser_estado = 1 
                    AND tt.trn_estado = 1 
                    AND tt.trn_confirmado='$inl_id'
                    AND u.usu_id =  '" . $_SESSION ['USU_ID'] . "' 
                    AND u.use_estado = '1'
                    GROUP BY
                    ts.ser_id 
                    ORDER BY ts.ser_categoria ASC "; //print($sql);die;
        $row = $this->series->dbselectBySQL($sql);
        $search = "";
        foreach ($row as $val) {
            $search .= "{separator: true},{name: '" . $val->ser_categoria . "', bclass: 'ser_categoria', onpress : $fun},";
        }//print "previo";
        $search = substr($search, 0, -1); //print "luego2";die;
        return $search;
    }

    function loadMenuRegularizacion($ins_id, $fun) {

        $tipo = $_SESSION['ROL_COD'];
        $where = "";
        if ($tipo == 'OPE') {
            $where .= " AND tt.trn_usuario_orig ='" . $_SESSION['USU_ID'] . "' ";
        }
        $sql = "SELECT DISTINCT
                ts.ser_id,
                ts.ser_categoria
                FROM tab_expediente te
                INNER JOIN tab_expusuario eu ON eu.exp_id=te.exp_id
                INNER JOIN tab_series ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_transferencia tt ON tt.exp_id = te.exp_id
                INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                INNER JOIN tab_usu_serie us ON us.usu_id = tu.usu_id AND us.ser_id=ts.ser_id
                WHERE
                eu.eus_estado = '1' 
                AND eu.usu_id = tt.trn_usuario_des 
                AND te.exp_estado =  '1' 
                AND us.use_estado =  '1' 
                AND tt.trn_estado = '2' 
                AND un.ins_id = '$ins_id' $where 
                ORDER BY ts.ser_categoria ASC";

        $row = $this->series->dbselectBySQL($sql);
        $search = "";
        foreach ($row as $val) {
            $search .= "{separator: true},{name: '" . $val->ser_categoria . "', bclass: 'ser_categoria', onpress : $fun},";
        }
        $search = substr($search, 0, -1);
        return $search;
    }

    function obtenerSelectSeries($default = null) {
        $rows = $this->series->dbSelectBySQL("SELECT
                                            ts.ser_id,
                                            ts.ser_categoria
                                            FROM
                                            tab_series ts
                                            WHERE
                                            ts.ser_estado =  '1' 
                                            AND ts.ser_id IN(SELECT use.ser_id FROM tab_usu_serie use WHERE use.usu_id='" . $_SESSION['USU_ID'] . "' AND use.use_estado = '1')
                                            ORDER BY ts.ser_categoria ASC");
        if (count($rows) > 0) {
            $option = "";
            foreach ($rows as $val) {
                if ($default == $val->ser_id)
                    $selected = "selected";
                else
                    $selected = " ";
                $option .="<option value='" . $val->ser_id . "' " . $selected . ">" . $val->ser_categoria . "</option>";
            }
            return $option;
        }
        else
            return "";
    }

    function obtenerSerieTramites($tra_id = null) {
        $tseries = new tab_series();
        $add = "";
        if ($tra_id != null) {
            $add = " (CASE
                         WHEN (SELECT COUNT(tc.ser_id)
                               From tab_serietramite as tc
                               WHERE tc.sts_estado = '1'
                               AND tc.ser_id=ts.ser_id
                               AND tc.tra_id='" . $tra_id . "' )>0 THEN
                           'checked'
                        ELSE
                               ''
                        END) as checked";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
                ts.ser_id,
                ts.ser_codigo,
                ts.ser_categoria,
                $add
                FROM
                tab_series AS ts
                WHERE ts.ser_estado = '1'
                ORDER BY ts.ser_codigo ASC";
        $rows = $tseries->dbSelectBySQL($sql);
        if (count($rows) > 0)
            return $rows;
        else
            return "";
    }

    function obtenerSelect($adm, $usu_id) {
        if ($adm) {
            $sql = "SELECT
		    s.ser_id,
                    s.ser_codigo,
                    s.ser_categoria,
		    s.ser_tipo
		    FROM tab_series s
			WHERE s.ser_estado = 1 AND (s.ser_tipo IS NULL  OR s.ser_tipo = '') ";
        } else {
            $sql = "SELECT DISTINCT s.ser_id,s.ser_codigo, s.ser_categoria, s.ser_tipo
		    FROM tab_series s Inner Join tab_usu_serie us ON s.ser_id = us.ser_id
			WHERE us.use_estado = 1
		     AND us.usu_id = '" . $usu_id . "' AND (s.ser_tipo IS NULL  OR s.ser_tipo = '') ";
        }
        $sql .= " ORDER BY s.ser_categoria ASC ";
        $rows = $this->series->dbselectBySQL($sql);
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                $option .="<option value='" . $val->ser_id . "'>" . $val->ser_codigo . " - " . $val->ser_categoria . "</option>";
            }
        }
        return $option;
    }

    function obtenerSelectTodas($default = null) {
        $sql = "SELECT
                ts.ser_id,
                ts.ser_codigo,
                ts.ser_categoria
                FROM
                tab_series ts
                WHERE
                ts.ser_estado =  '1'
                ORDER BY ts.ser_codigo ASC";
        $rows = $this->series->dbSelectBySQL($sql);
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

    function obtenerSelectPorInst($ins_id, $default = null) {
        $rows = $this->series->dbSelectBySQL("SELECT DISTINCT
                                            ts.ser_id,
                                            ts.ser_categoria
                                            FROM
                                            tab_series AS ts
                                            Inner Join tab_expediente AS te ON te.ser_id = ts.ser_id
                                            Inner Join tab_expusuario AS teu ON teu.exp_id = te.exp_id
                                            Inner Join tab_usuario AS tu ON teu.usu_id = tu.usu_id
                                            Inner Join tab_unidad ON tu.uni_id = tab_unidad.uni_id
                                            WHERE
                                            ts.ser_estado =  '1' AND
                                            tab_unidad.ins_id =  '$ins_id'
                                            ORDER BY
                                            ts.ser_categoria ASC ");
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

    function count($tipo, $value1) {
        $serie = new Tab_series();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'ser_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(ser_id) as num
		from tab_series
		WHERE ser_estado = '1' $where
                ORDER BY ser_categoria ASC ";
        $num = $serie->countBySQL($sql);
        return $num;
    }
    
    function countSer($where, $usu_id = null) {
        $serie = new Tab_series();
        if($usu_id==null){
            $sql="SELECT DISTINCT 
                    count (s.ser_id)
                    FROM
                    tab_usu_serie AS u 
                    Inner Join tab_series s ON u.ser_id = s.ser_id
                    WHERE
                    u.use_estado = '1' 
                    AND s.ser_estado = '1' $where";
            
        }
        else{
            $sql="SELECT DISTINCT 
                    count(s.ser_id)
                    FROM
                    tab_usu_serie AS u 
                    Inner Join tab_series s ON u.ser_id = s.ser_id
                    WHERE
                    u.use_estado = '1' 
                    AND s.ser_estado = '1' and u.usu_id=$usu_id $where";
        }
        $num = $serie->countBySQL($sql);
        return $num;
    }

    function obtenerCheck($usu_id = null) {
        $check = '';
        $add = "";
        if ($usu_id != null) {
            $add = " (SELECT
                    us.ser_id
                    FROM
                    tab_usu_serie AS us
                    WHERE
                    us.ser_id =  s.ser_id 
                    AND us.use_estado = '1' 
                    AND us.usu_id='$usu_id') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT
                s.ser_id,
                s.ser_codigo,
                s.ser_categoria,
                s.ser_tipo,
                $add
                FROM
                tab_series AS s
                WHERE
                s.ser_estado =  '1'
                ORDER BY s.ser_codigo ASC  ";
        $rows = $this->series->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $serie) {
            $ck = '';
            if ($serie->seleccionado != null)
                $ck = ' checked="checked" ';
            $check.='<tr><td><input type="checkbox" name="lista_serie[' . $i . ']" ' . $ck . ' id="serie-' . $serie->ser_id . '" value="' . $serie->ser_id . '" /></td> <td>' . $serie->ser_codigo . '</td> <td>' . $serie->ser_categoria . '</td> </tr>';
            $i++;
        }
        return $check;
    }

    function getPorFondo($usu_id, $fon_orden) {
        $ins = new institucion();
        $ins_id = $ins->obtenerIns_id($usu_id);
        $rows = array();
        $sql = "SELECT DISTINCT
                s.ser_id,
                s.ser_categoria
                FROM
                tab_series AS s
                Inner Join tab_expediente AS e ON e.ser_id = s.ser_id
                Inner Join tab_expfondo AS ef ON ef.exp_id = e.exp_id
                Inner Join tab_fondo AS f ON f.fon_id = ef.fon_id
                Inner Join tab_inst_fondo AS iif ON iif.fon_id = ef.fon_id
                WHERE
                f.fon_orden = '$fon_orden' 
                AND iif.ins_id = '$ins_id'
                ORDER BY s.ser_categoria ASC  ";
        //print $sql;die;
        $rows = $this->series->dbSelectBySQL($sql);
        return $rows;
    }

    function obtenerSelectDefault($usu_id, $default = null) {
        if ($default) {
            $sql = "SELECT DISTINCT 
                    s.ser_id, 
                    s.ser_categoria
		    FROM tab_series s 
                    Inner Join tab_usu_serie us ON s.ser_id = us.ser_id
                    WHERE s.ser_estado = 1 
                    AND us.usu_id = '" . $usu_id . "' ";
        } else {
            $sql = "SELECT DISTINCT 
                    s.ser_id, 
                    s.ser_categoria 
		    FROM tab_series s 
                    Inner Join tab_usu_serie us ON s.ser_id = us.ser_id
                    WHERE s.ser_estado = 1 
                    AND us.usu_id = '" . $usu_id . "' ";
        }
        $row = $this->series->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ser_id) {
                $option .="<option value='" . $val->ser_id . "' selected>" . $val->ser_categoria . "</option>";
            } else {
                $option .="<option value='" . $val->ser_id . "'>" . $val->ser_categoria . "</option>";
            }
        }
        return $option;
    }

    function obtenerCodigoSerie($ser_id) {
        $series = new Tab_series();
        $ser_cod = "";
        $rows = "";
        $sql = "SELECT
                tab_fondo.fon_cod,
                tab_unidad.uni_cod,
                tab_tipocorr.tco_codigo,
                tab_series.ser_codigo
                FROM
                tab_fondo
                INNER JOIN tab_unidad ON tab_fondo.fon_id = tab_unidad.fon_id
                INNER JOIN tab_series ON tab_unidad.uni_id = tab_series.uni_id
                INNER JOIN tab_tipocorr ON tab_tipocorr.tco_id = tab_series.tco_id
                WHERE tab_fondo.fon_estado = 1
                AND tab_unidad.uni_estado = 1
                AND tab_tipocorr.tco_estado = 1
                AND tab_series.ser_estado = 1 
                AND tab_series.ser_id = '$ser_id' ";
        
        $rows = $series->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $ser_cod = $val->fon_cod . DELIMITER . $val->uni_cod . DELIMITER . $val->tco_codigo . DELIMITER . $val->ser_codigo ;
        }
        return $ser_cod;
    }
    
    function obtenerIdSerie($ser_categoria) {
        $series = new Tab_series();
        $ser_id = 0;
        $rows = "";
        $sql = "select ser_id
		from tab_series
		WHERE ser_estado = '1' 
                AND ser_categoria = '$ser_categoria' ";
        $rows = $series->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $ser_id = $val->ser_id;
        }
        return $ser_id;
    }
    
    
    function obtenerCategoriaSerie($ser_id) {
        $series = new Tab_series();
        $ser_categoria = "";
        $rows = "";
        $sql = "select ser_categoria
		from tab_series
		WHERE ser_estado = '1' 
                AND ser_id = '$ser_id' ";
        $rows = $series->dbselectBySQL($sql);
        foreach ($rows as $val) {
            $ser_categoria = $val->ser_categoria;
        }
        return $ser_categoria;
    }    
    
    
}

?>
