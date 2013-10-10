<?php

/**
 * archivo_digital.class.php Model
 *
 * @package
 * @author Arsenio Castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class archivo_digital extends tab_archivo_digital {

    function __construct() {
        $this->archivo_digital = new Tab_archivo_digital();
    }

    function generarNombre($archivo_name) {
        $sql_nom_arch = "SELECT * FROM tab_archivo_digital WHERE fil_nomoriginal like '$archivo_name' AND fil_estado='1' ";
        $result = $this->archivo_digital->dbselectBySQL($sql_nom_arch);
        if (count($result) > 0)
            $archivo_name = $archivo_name . "_" . count($result);
        return $archivo_name;
    }

    function count($where) {
        $where = "";
        $sql = "SELECT COUNT(distinct ta.fil_id) as num
        FROM tab_archivo AS ta Inner Join tab_exparchivo AS tea ON tea.fil_id = ta.fil_id
        Inner join tab_expediente AS te ON te.exp_id = tea.exp_id
        Inner join tab_series AS se ON tea.ser_id = se.ser_id
        Inner join tab_tramite AS tt ON tea.tra_id = tt.tra_id
        Inner join tab_cuerpos AS tc ON tea.cue_id = tc.cue_id
		WHERE tea.exa_estado='1' ";
        $num = $this->archivo->countBySQL($sql);
        return $num;
    }

    function buscar($busquedaArray) {
        $page = $busquedaArray['page'];
        $rp = $busquedaArray['rp'];
        $sortname = $busquedaArray['sortname'];
        $sortorder = $busquedaArray['sortorder'];
        $ser_id = $busquedaArray['ser_id'];
        $exp_codigo = $busquedaArray['exp_codigo'];
        $exp_nombre = $busquedaArray['exp_nombre'];
        $tra_id = $busquedaArray['tra_id'];
        $cue_id = $busquedaArray['cue_id'];
        $exf_fecha_exi = $busquedaArray['exf_fecha_exi'];
        $exf_fecha_exf = $busquedaArray['exf_fecha_exf'];
        $archivo = $busquedaArray['archivo'];
        $fil_descripcion = $busquedaArray['fil_descripcion']; //print $fil_descripcion;die;
        $institucion = $busquedaArray['institucion'];
        $lugar = $busquedaArray['lugar'];

        if (!$sortname)
            $sortname = 'fil_id';
        if (!$sortorder)
            $sortorder = 'asc';
        $sort = "ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $start = (($page - 1) * $rp);
        //$limit = "LIMIT $start, $rp";
        $select = "SELECT DISTINCT
            ta.fil_id,
            ta.fil_nomoriginal,
            (ta.fil_tamano/1048576) AS fil_tamano,
            ta.fil_tipo,
            ta.fil_descripcion,
            ta.fil_confidencialidad,
            te.exp_id,
            te.exp_nombre,
            te.exp_codigo,
            ts.ser_categoria,
            tt.tra_codigo,
            tt.tra_descripcion,
            tc.cue_codigo,
            tc.cue_descripcion,
            (CASE tea.exa_condicion WHEN '1' THEN 'DISPONIBLE' WHEN '2' THEN 'PRESTADO' END) AS disponibilidad,
            tin.ins_nombre,
            tf.fon_descripcion,
            (SELECT (ttipo.ctp_codigo || ' ' || ttc.con_codigo) as contenedor
                        FROM tab_contenedor ttc Inner Join tab_exparchivo AS ttea ON ttea.con_id =
                        ttc.con_id
                        Inner Join tab_tipocontenedor AS ttipo ON ttc.ctp_id = ttipo.ctp_id
                        WHERE ttea.fil_id=ta.fil_id)
                    as contenedor,
            (SELECT (tipo.ctp_codigo || ' ' || ts.suc_nro) as subcontenedor
                        FROM tab_exparchivo AS ea Inner Join tab_subcontenedor AS ts
                        ON ea.suc_id = ts.suc_id
                        Inner Join tab_tipocontenedor AS tipo ON ts.ctp_id = tipo.ctp_id
                        WHERE ea.fil_id=ta.fil_id)
                    as subcontenedor ";
        $from = "FROM
            tab_archivo AS ta
            Inner Join tab_exparchivo AS tea ON tea.fil_id = ta.fil_id
            Inner Join tab_expediente AS te ON te.exp_id = tea.exp_id
            Inner Join tab_expusuario AS exu ON exu.exp_id = tea.exp_id
            Inner Join tab_usuario AS tu ON tu.usu_id = exu.usu_id
            Inner Join tab_series AS ts ON te.ser_id = ts.ser_id
            Inner Join tab_tramite AS tt ON tea.tra_id = tt.tra_id
            Inner Join tab_cuerpos AS tc ON tea.cue_id = tc.cue_id
            Inner Join tab_unidad AS tun ON tun.uni_id = tu.uni_id
            Inner Join tab_institucion AS tin ON tin.ins_id = tun.ins_id
            Inner Join tab_expfondo AS tef ON tef.exp_id = te.exp_id
            Inner Join tab_fondo AS tf ON tf.fon_id = tef.fon_id
            WHERE
            tea.exa_estado =  '1' AND
            ta.fil_estado =  '1' AND
            te.exp_estado =  '1' AND
            exu.eus_estado =  '1' AND
            tef.exf_estado =  '1' AND
            ta.fil_nomoriginal IS NOT NULL  AND
            ta.fil_nomoriginal <>  '' ";

        $where = "";
        if (strlen($ser_id) > 0) {
            $where .= " AND te.ser_id='$ser_id' ";
        }
        if (strlen($exp_codigo) > 0) {
            $where .= " AND te.exp_codigo LIKE '%$exp_codigo%' ";
        }
        if (strlen($exp_nombre) > 0) {
            $where .= " AND te.exp_nombre LIKE '%$exp_nombre%' ";
        }
        if (strlen($tra_id) > 0) {
            $where .= " AND tt.tra_id='$tra_id' ";
        }
        if (strlen($cue_id) > 0) {
            $where .= " AND tc.cue_id='$cue_id' ";
        }
        if (strlen($exf_fecha_exi) > 0) {
            $where .= " AND tef.exf_fecha_exi>='$exf_fecha_exi' ";
        }
        if (strlen($exf_fecha_exf) > 0) {
            $where .= " AND tef.exf_fecha_exf<='$exf_fecha_exf' ";
        }
        if (strlen($archivo) > 0) {
            $where .= " AND ta.fil_nomoriginal LIKE '%$archivo%' ";
        }
        if (strlen($fil_descripcion) > 0) {
            $where .= " AND ta.fil_descripcion LIKE '%$fil_descripcion%' ";
        }
        if (strlen($institucion) > 0) {
            $where .= " AND tin.ins_id='$institucion'  ";
        }
        if (strlen($lugar) > 0) {
            $where .= " AND tf.fon_id ='$lugar' ";
        }
        $sql = "$select $from $where $sort"; //$limit
        //print $sql;die;
        $result = $this->archivo->dbSelectBySQL($sql); //print $sql;
        $sql_c = "SELECT COUNT(DISTINCT ta.fil_id) $from $where ";
        $total = $this->archivo->countBySQL($sql_c);
        $exp = new expediente ();
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: $total,\n";
        $json .= "rows: [";
        $rc = false;
        $i = 0;
        foreach ($result as $un) {
            if ($rc)
                $json .= ",";
            $json .= "\n{";
            $json .= "id:'" . $un->fil_id . "',";
            $json .= "cell:[";
            $json .= "'<input id=\"chkid_" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"fil_chk\" type=\"checkbox\" value=\"" . $un->fil_id . "\" />'";
            if ($un->fil_confidencialidad == 3) {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFileP icon\" />'";
            } else {
                $json .= ",'<img src=\"" . PATH_DOMAIN . "/web/lib/b_view.png\" file=\"$un->fil_id\" valueId=\"" . $un->fil_id . "\" restric=\"" . $un->fil_confidencialidad . "\" class=\"viewFile icon\" />'";
            }

            $json .= ",'" . $un->fil_id . "'";
            $json .= ",'" . addslashes($un->exp_codigo) . "'";
            $json .= ",'" . addslashes($un->exp_nombre) . "'";
            $json .= ",'" . addslashes($un->ser_categoria) . "'";
            $json .= ",'" . addslashes($un->tra_codigo) . "'";
            $json .= ",'" . addslashes($un->cue_codigo) . "'";
            $json .= ",'" . addslashes($un->fil_nomoriginal) . "'";
            $json .= ",'" . addslashes($un->disponibilidad) . "'";
            $json .= ",'" . addslashes($un->ins_nombre) . "'";
            $json .= ",'" . addslashes($un->fon_descripcion) . "'";
            $json .= ",'" . addslashes($exp->obtenerCustodios($un->exp_id)) . "'";
            $json .= ",'" . addslashes($un->contenedor) . "'";
            $json .= ",'" . addslashes($un->subcontenedor) . "'";
            $json .= ",'" . addslashes($un->fil_tipo) . "'";
            $json .= ",'" . addslashes($un->fil_tamano) . "'";
            $json .= ",'" . addslashes($un->fil_descripcion) . "'";
            $json .= "]}";
            $rc = true;
            $i++;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

    function obtenerPermisos($fil_id) {
        $sql = "";
        $this->archivo->dbSelectBySQL($sql);
    }

}

?>