<?php

/**
 * empresas.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class empresas extends tab_empresas {

    function __construct() {
        //parent::__construct();
        $this->empresas = new tab_empresas();
    }

    function getTitle($ser_id) {
        $row = $this->empresas->dbselectByField("ser_id", $ser_id);
        if (!is_null($row))
            return $row[0]->ser_categoria;
        else
            return "";
    }

    function getTransFondo($trn_uni_origen, $trn_usuario_orig, $inl_id, $trn_fecha_crea) {
        $sql_empresas = "SELECT DISTINCT
                    s2.ser_id,
                    s2.ser_categoria
                    FROM
                    tab_transferencia AS t2
                    Inner Join tab_expediente AS e2 ON e2.exp_id = t2.exp_id Inner Join
                    tab_empresas AS s2 ON s2.ser_id = e2.ser_id
                    WHERE
                    t2.trn_confirmado =  '$inl_id' AND t2.trn_uni_origen='$trn_uni_origen'
                    AND t2.trn_usuario_orig='$trn_usuario_orig'
                    AND t2.trn_fecha_crea = '$trn_fecha_crea'
                    ORDER BY s2.ser_categoria ASC "; //print ($sql_empresas);die;
        $rows = $this->empresas->dbSelectBySQL($sql_empresas);
        $empresas = "";
        if (count($rows) > 0) {
            foreach ($rows as $ser) {
                $empresas.=$ser->ser_categoria . ',';
            }
            $empresas = substr($empresas, 0, -1);
        } else {
            $empresas = 'VARIAS empresas';
        }
        return $empresas;
    }

    function getTransArchivo($inl_id, $trn_fecha_crea) {
        $sql_empresas = "SELECT DISTINCT
                    s2.ser_id,
                    s2.ser_categoria
                    FROM
                    tab_transferencia AS t2
                    Inner Join tab_expediente AS e2 ON e2.exp_id = t2.exp_id Inner Join
                    tab_empresas AS s2 ON s2.ser_id = e2.ser_id
                    WHERE
                    t2.trn_confirmado =  '$inl_id'
                    AND t2.trn_fecha_crea = '$trn_fecha_crea'
                    ORDER BY s2.ser_categoria ASC  "; //print ($sql_empresas);die;
        $rows = $this->empresas->dbSelectBySQL($sql_empresas);
        $empresas = "";
        if (count($rows) > 0) {
            foreach ($rows as $ser) {
                $empresas.=$ser->ser_categoria . ',';
            }
            $empresas = substr($empresas, 0, -1);
        } else {
            $empresas = 'VARIAS empresas';
        }
        return $empresas;
    }

    function loadMenuFondo($ins_id, $fon_orden, $fun = "") {
        if ($fun == "") {
            $fun = "test";
        }
        //$row = $this->getPorFondo($_SESSION ['USU_ID'],$fon_orden);
        $sql = "SELECT DISTINCT
            s.ser_id,
            s.ser_categoria
            FROM
            tab_empresas AS s
            Inner Join tab_expediente AS e ON e.ser_id = s.ser_id
            Inner Join tab_expfondo AS ef ON ef.exp_id = e.exp_id
            Inner Join tab_fondo AS f ON f.fon_id = ef.fon_id
            Inner Join tab_inst_fondo AS iif ON iif.fon_id = ef.fon_id
            WHERE
            f.fon_orden =  '$fon_orden' AND iif.ins_id = '$ins_id'
            ORDER BY s.ser_categoria ASC  ";
        //print $sql;die;
        // REVISED: CASTELLON
        // ERROR
        $rows = $this->empresas->dbSelectBySQL($sql);
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
        $row = $this->getempresas($usu_id);
        $search = "";
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
        $rows = $this->getempresas($usu_id);
        $res = "";
        foreach ($rows as $val) {
            $res = $val->ser_id;
        }
        return $res;
    }

    function getempresas($usu_id = null) {
        $rows = array();
        $where = "";
        if ($usu_id != null) {
            $where .= " AND u.usu_id =  '" . $usu_id . "' ";
        }
        $sql = "SELECT DISTINCT s.ser_id, s.ser_categoria
                    FROM
                    tab_usu_serie AS u Inner Join tab_empresas s ON u.ser_id = s.ser_id
                    WHERE
                    u.use_estado = '1' AND s.ser_estado = '1' $where
                    ORDER BY s.ser_categoria ASC  ";
        //echo ($sql);die();
        $rows = $this->empresas->dbSelectBySQL($sql);
        return $rows;
    }

    function loadMenuTransfer($inl_id, $adm, $fun) {
        if ($fun == "") {
            $fun = "test";
        }
        $sql = "SELECT DISTINCT
		    ts.ser_id,
		    ts.ser_categoria
		    FROM tab_empresas ts
                    Inner Join tab_expediente te ON te.ser_id = ts.ser_id
                    Inner Join tab_transferencia tt ON tt.exp_id = te.exp_id
                    Inner Join tab_usu_serie AS u ON u.ser_id = ts.ser_id
                    WHERE ts.ser_estado = 1 and tt.trn_estado = 1 AND tt.trn_confirmado='$inl_id'
                    AND u.usu_id =  '" . $_SESSION ['USU_ID'] . "' AND u.use_estado = '1'
                    GROUP BY
                    ts.ser_id ORDER BY ts.ser_categoria ASC "; //print($sql);die;
        $row = $this->empresas->dbselectBySQL($sql);
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
                INNER JOIN tab_empresas ts ON te.ser_id=ts.ser_id
                INNER JOIN tab_transferencia tt ON tt.exp_id = te.exp_id
                INNER JOIN tab_usuario tu ON tu.usu_id=tt.trn_usuario_orig
                INNER JOIN tab_unidad un ON tu.uni_id=un.uni_id
                INNER JOIN tab_usu_serie us ON us.usu_id = tu.usu_id AND us.ser_id=ts.ser_id
                WHERE
                eu.eus_estado = '1' AND
                eu.usu_id = tt.trn_usuario_des AND
                te.exp_estado =  '1' AND
                us.use_estado =  '1' AND
                tt.trn_estado = '2' AND
                un.ins_id = '$ins_id' $where  ORDER BY ts.ser_categoria ASC";

        $row = $this->empresas->dbselectBySQL($sql);
        $search = "";
        foreach ($row as $val) {
            $search .= "{separator: true},{name: '" . $val->ser_categoria . "', bclass: 'ser_categoria', onpress : $fun},";
        }
        $search = substr($search, 0, -1);
        return $search;
    }

    function obtenerSelectempresas($default = null) {
        $rows = $this->empresas->dbSelectBySQL("SELECT
			ts.ser_id,
			ts.ser_categoria
			FROM
			tab_empresas ts
			WHERE
			ts.ser_estado =  '1' AND ts.ser_id IN(SELECT use.ser_id FROM tab_usu_serie use WHERE use.usu_id='" . $_SESSION['USU_ID'] . "' AND use.use_estado = '1')
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
        $tempresas = new tab_empresas();
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
            ts.ser_categoria,
            $add
            FROM
            tab_empresas AS ts
            WHERE ts.ser_estado = '1'
            ORDER BY ts.ser_categoria ASC"; //print "<br>....<br>".$sql;
        $rows = $tempresas->dbSelectBySQL($sql); //die("uno");
        if (count($rows) > 0)
            return $rows;
        else
            return "";
    }

    function obtenerSelect() {
        $sql = "SELECT
                emp_id,
                emp_nombre,
                emp_sigla
                FROM tab_empresas";
        $sql .= " ORDER BY emp_nombre ASC ";
        $rows = $this->empresas->dbselectBySQL($sql);
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                $option .="<option value='" . $val->emp_id . "'>" . $val->emp_nombre . "</option>";
            }
        }
        return $option;
    }

    function obtenerSelectTodas($default = null) {
        $rows = $this->empresas->dbSelectBySQL("SELECT
			ts.ser_id,
			ts.ser_categoria
			FROM
			tab_empresas ts
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

    function obtenerSelectPorInst($ins_id, $default = null) {
        $rows = $this->empresas->dbSelectBySQL("SELECT DISTINCT
            ts.ser_id,
            ts.ser_categoria
            FROM
            tab_empresas AS ts
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
        $serie = new Tab_empresas();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'ser_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(ser_id) as num
		from tab_empresas
		WHERE ser_estado = '1' $where
                ORDER BY ser_categoria ASC ";
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
            us.ser_id =  s.ser_id AND us.use_estado = '1' AND us.usu_id='$usu_id') as seleccionado ";
        } else {
            $add = " NULL as seleccionado ";
        }

        $sql = "SELECT
            s.ser_id,
            s.ser_categoria,
            s.ser_tipo,
            $add
            FROM
            tab_empresas AS s
            WHERE
            s.ser_estado =  '1'
            ORDER BY s.ser_categoria ASC  ";
        $rows = $this->empresas->dbSelectBySQL($sql);
        $i = 0;
        foreach ($rows as $serie) {
            $ck = '';
            if ($serie->seleccionado != null)
                $ck = ' checked="checked" ';
            $check.='<tr><td><input type="checkbox" name="lista_serie[' . $i . ']" ' . $ck . ' id="serie-' . $serie->ser_id . '" value="' . $serie->ser_id . '" /></td><td>' . $serie->ser_categoria . '</td></tr>';
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
            tab_empresas AS s
            Inner Join tab_expediente AS e ON e.ser_id = s.ser_id
            Inner Join tab_expfondo AS ef ON ef.exp_id = e.exp_id
            Inner Join tab_fondo AS f ON f.fon_id = ef.fon_id
            Inner Join tab_inst_fondo AS iif ON iif.fon_id = ef.fon_id
            WHERE
            f.fon_orden =  '$fon_orden' AND iif.ins_id = '$ins_id'
            ORDER BY s.ser_categoria ASC  ";
        //print $sql;die;
        $rows = $this->empresas->dbSelectBySQL($sql);
        return $rows;
    }

}

?>
