<?php

/**
 * evalriesgos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class evalriesgos extends tab_evalriesgos {

    function __construct() {
        $this->evalriesgos = new tab_evalriesgos();
    }

    function count2($query, $qtype) {
        $num = 0;
        $where = '';
        if ($query) {
            if ($qtype == 'eva_id')
                $where = " AND $qtype = '$query' ";
            elseif ($qtype == 'riesgo')
                $where = " AND rie_id IN (SELECT rie_id from tab_riesgos WHERE rie_descripcion LIKE '%$query%') ";
            else
                $where = " AND $qtype LIKE '%$query%' ";
        }
        $num = $this->evalriesgos->countBySQL("SELECT COUNT(tab_evalriesgos.eva_id) as num
            FROM
            tab_docprevencion
            Inner Join tab_evalriesgos ON tab_evalriesgos.dpr_id = tab_docprevencion.dpr_id
            WHERE
            tab_evalriesgos.eva_estado =  '1'
            AND
            tab_docprevencion.uni_id =  '" . $_SESSION['UNI_ID'] . "'
            AND
            tab_docprevencion.dpr_tipo =  'evalriesgos' $where");
        return $num;
    }

}

?>
