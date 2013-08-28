<?php

/**
 * plandesastre.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class plandesastre extends tab_plandesastre {

    var $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    function __construct() {
        $this->plandesastre = new tab_plandesastre();
    }

    function obtenerSelectMes($default = null) {
        $mes = "";
        foreach ($this->meses as $m) {
            if ($default == $m)
                $selected = "selected";
            else
                $selected = "";
            $mes .="<option value='$m'" . $selected . ">$m</option>";
        }
        return $mes;
    }

    function obtenerSelectGestion($default = null) {
        $ini_anio = date("Y") - 10;
        $fin_anio = date("Y");
        $gestion = "";
        //echo $ini_anio;
        for ($i = $ini_anio; $i <= $fin_anio; $i++) {
            if ($default == $i)
                $selected = "selected";
            else
                $selected = "";
            $gestion .= "<option value='$i'" . $selected . ">$i</option>";
        }
        return $gestion;
    }

    function count2($query, $qtype) {
        $this->plandesastre = new Tab_plandesastre();
        $where = "";
        if ($query) {
            if ($qtype == 'pla_id')
                $where = " AND $qtype LIKE '%$query%' ";
            elseif ($qtype == 'dpr_id')
                $where = " AND $qtype IN (SELECT dpr_id FROM tab_docprevencion WHERE dpr_tipo LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $num = $this->plandesastre->countBySQL("SELECT
			COUNT(tab_plandesastre.pla_id) as num
			FROM
			tab_docprevencion
			Inner Join tab_plandesastre ON tab_plandesastre.dpr_id = tab_docprevencion.dpr_id
			WHERE
			tab_plandesastre.pla_estado =  '1'
			AND
			tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
			AND
			tab_docprevencion.dpr_tipo =  'plandesastre' $where ");
        return $num;
    }

}

?>
