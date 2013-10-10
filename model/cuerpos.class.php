<?php

/**
 * cuerpos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class cuerpos extends tab_cuerpos {

    function __construct() {
        $this->cuerpos = new Tab_cuerpos ();
    }

    function count2($where, $tra_id) {
        $cuerpos = new tab_cuerpos ();
        $sql = "SELECT count(tab_tramitecuerpos.tra_id)
                FROM
                tab_tramite
                INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                WHERE tab_tramitecuerpos.tra_id = $tra_id
                AND tab_cuerpos.cue_estado = 1 $where ";
        //echo($sql);die;
        $num = $cuerpos->countBySQL($sql);
        return $num;
    }
    
    
    function count($tipo, $value1) {
        $cuerpos = new Tab_cuerpos ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'cue_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(cue_id) as num
		from tab_cuerpos
		WHERE cue_estado = '1' $where ";
        $num = $cuerpos->countBySQL($sql);

        return $num;
    }

    function getCount($where, $tra_id) {
        $cuerpos = new tab_cuerpos ();
        $sql = "SELECT count(tab_tramitecuerpos.tra_id)
                FROM
                tab_tramite
                INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
                WHERE tab_tramitecuerpos.tra_id = $tra_id
                AND tab_cuerpos.cue_estado = 1 $where ";
        $num = $cuerpos->countBySQL($sql);
        $num++;
        return $num;
    }
    
    function obtenerCuerposTramite($tra_id = null) {
        $cuerpos = new Tab_cuerpos ();
        $add = "";
        if ($tra_id != null) {
            $add = " (CASE
                     WHEN (SELECT  COUNT(tc.cue_id) From tab_tramitecuerpos as tc
                           WHERE tc.trc_estado = '1'
                           AND tc.cue_id=c.cue_id AND tc.tra_id='" . $tra_id . "' )>0 THEN
                       'checked'
                      ELSE
                             ''
                       END) as checked";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
            c.cue_id,
            c.cue_codigo,
            c.cue_descripcion,
            " . $add . "
            FROM
            tab_cuerpos AS c
            WHERE c.cue_estado = '1'
            ORDER BY c.cue_descripcion ASC";
        $rows = $cuerpos->dbSelectBySQL($sql);
        if (count($rows))
            return $rows;
        else
            return "";
    }

    function obtenerSiguienteCuerpo($tra_id) {
        $tramite = new Tab_tramite();
        $maximo = 0;
        $sql = "SELECT
                COUNT (tab_tramite.tra_orden) as maximo
                FROM
                tab_tramite
                INNER JOIN tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
                INNER JOIN tab_cuerpos ON tab_cuerpos.cue_id = tab_tramitecuerpos.cue_id
		WHERE tab_tramite.tra_estado = 1
                AND tab_cuerpos.cue_estado = 1
                AND tab_tramitecuerpos.tra_id = $tra_id ";
        $maximo = $tramite->countBySQL($sql);
        if ($maximo == 0) {
            $maximo = 1;
        }
        return $maximo + 1;
    }

    function obtenerNombreCuerpo($cue_id) {
        $cue_descripcion = "";
        $sql = "SELECT
                cue_descripcion
                FROM
                tab_cuerpos
		WHERE tab_cuerpos.cue_estado = 1
                AND tab_cuerpos.cue_id = $cue_id ";
        $cuerpos = $this->cuerpos->dbSelectBySQL($sql);
        if (count($cuerpos) > 0) {
            $cue_descripcion = $cuerpos[0]->cue_descripcion;
        }
        return $cue_descripcion;
    }
    
}

?>
