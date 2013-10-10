<?php

/**
 * tramite.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tramite extends tab_tramite {

    function __construct() {
        $this->tramite = new Tab_tramite();
    }

    function obtenerTramitesSerie($ser_id = null) {
        if ($ser_id != null) {
            $add = "(( CASE
                       WHEN (SELECT COUNT(tc.tra_id)
                       From tab_serietramite as tc
                       WHERE tc.sts_estado = '1'
                       AND tc.tra_id=tab_tramite.tra_id)>0 THEN
                            'checked'
                       ELSE
                              ''
                       END)) as checked ";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
            tab_tramite.tra_codigo,
            tab_tramite.tra_id,
            tab_tramite.tra_descripcion,
            $add
            FROM
            tab_tramite
            WHERE
            tab_tramite.tra_estado =  '1'
            ORDER BY tab_tramite.tra_descripcion ASC";
        //echo ($sql);die;
        $rows = $this->tramite->dbSelectBySQL($sql);
        if (count($rows))
            return $rows;
        else
            return "";
    }

    function obtenerTramitesCuerpo($cue_id = null) {
        if ($cue_id != null) {
            $add = " (CASE
                      WHEN (SELECT COUNT(tc.tra_id)
                            From tab_tramitecuerpos as tc
                            WHERE  tc.cue_id='" . $cue_id . "'
                            AND tc.trc_estado = '1' )>0 THEN
                          'checked'
                      ELSE
                           ''
                      END) as checked";
        } else {
            $add = "' ' as checked";
        }
        $sql = "SELECT
            tab_series.ser_codigo,
            tab_series.ser_id,
            tab_series.ser_categoria,
            $add
            FROM
            tab_series
            WHERE
            tab_series.ser_estado =  '1'
            ORDER BY tab_series.ser_codigo ASC";

        $rows = $this->tramite->dbSelectBySQL($sql);
        if (count($rows))
            return $rows;
        else
            return "";
    }

    function obtenerTramitesConSerie($ser_id) {
        $rows = $this->tramite->dbSelectBySQL("SELECT
			tab_tramite.tra_id,
			tab_tramite.tra_codigo,
			tab_tramite.tra_descripcion
			FROM
			tab_tramite
			Inner Join tab_serietramite ON tab_serietramite.tra_id = tab_tramite.tra_id
				WHERE
				tab_serietramite.ser_id='" . $ser_id . "'
                        ORDER BY tab_tramite.tra_descripcion ASC ");
        if (count($rows))
            return $rows;
        else
            return "";
    }

    
    function count2($where, $ser_id) {
        $tramite = new tab_tramite ();
//        $sql = "SELECT count(tra_id)
//                    FROM
//                    tab_tramite
//                    WHERE ser_id= $ser_id
//                     AND tra_estado =  1 $where ";
        
        $sql = "SELECT count(tab_serietramite.ser_id)
            FROM
            tab_series
            INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
            INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
            WHERE tab_serietramite.ser_id = $ser_id  
            AND tab_tramite.tra_estado = 1 $where ";                
        $num = $tramite->countBySQL($sql);
        return $num;
    }

    
    function count($tipo, $value1) {
        $tramite = new Tab_tramite();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'tra_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(tra_id) as num
		from tab_tramite
		WHERE tra_estado = '1' $where ";
        $num = $tramite->countBySQL($sql);
        return $num;
    }

    function getCount($where, $ser_id) {
        $tramite = new tab_tramite ();
        $sql = "SELECT count(tab_serietramite.ser_id)
            FROM
            tab_series
            INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
            INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
            WHERE tab_serietramite.ser_id = $ser_id  
            AND tab_tramite.tra_estado = 1 $where ";                
        $num = $tramite->countBySQL($sql);
        $num++;
        return $num;
    }
    
    function obtenerCodigoTramite($tra_id) {
        $tramite = new Tab_tramite();
        $rows = "";
        $sql = "select tra_codigo
		from tab_tramite
		WHERE tra_estado = '1' AND tra_id = $tra_id ";
        $rows = $tramite->countBySQL($sql);
        return $rows;
    }


    
    function obtenerSiguienteSerie($ser_id) {
        $series = new Tab_series();
        $maximo = 0;
        $sql = "SELECT
                COUNT (tab_series.ser_id) as maximo
                FROM
                tab_series
                INNER JOIN tab_serietramite ON tab_series.ser_id = tab_serietramite.ser_id
                INNER JOIN tab_tramite ON tab_tramite.tra_id = tab_serietramite.tra_id
		WHERE tab_series.ser_estado = 1
                AND tab_tramite.tra_estado = 1
                AND tab_serietramite.ser_id = $ser_id ";
        $maximo = $series->countBySQL($sql);
        if ($maximo == 0) {
            $maximo = 1;
        }
        return $maximo + 1;
    }

}

?>