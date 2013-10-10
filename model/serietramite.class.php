<?php

/**
 * serietramite.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class serietramite extends tab_serietramite {

    function __construct() {
        $this->serietramite = new Tab_serietramite();
    }

    function obtenerSelectSerieTramites($default = null, $tra_id) {
        $rows = $this->serietramite->dbSelectBySQL("SELECT
			tab_series.ser_id,
			tab_series.ser_categoria,
			tab_series.ser_tipo,
			tab_series.ser_estado
			FROM
			tab_series
			WHERE
			tab_series.ser_id NOT IN (SELECT
                        tab_series.ser_id
                        FROM
                        tab_series
                        Inner Join tab_serietramite ON tab_serietramite.ser_id = tab_series.ser_id
                        WHERE
                        tab_serietramite.tra_id='" . $tra_id . "')
                        ORDER BY tab_series.ser_categoria ASC");

        if (count($rows)) {
            $option = "";
            foreach ($rows as $val) {
                if ($default == $val->ser_id)
                    $selected = "selected";
                else
                    $selected = " ";
                if (strlen($val->ser_categoria) > 60)
                    $categoria = substr($val->ser_categoria, 0, 60) . " ...";
                else
                    $categoria = $val->ser_categoria;
                $option .="<option value='" . $val->ser_id . "' " . $selected . ">" . $categoria . "</option>";
            }
            return $option;
        }
        else
            return "";
    }

    function delete($ser_id) {
        $upd = "UPDATE tab_serietramite SET sts_estado='2' WHERE ser_id = '$ser_id' ";
        $this->serietramite->dbBySQL($upd);
    }

    function deleteXTramite($tra_id) {
        $upd = "UPDATE tab_serietramite SET sts_estado='2' WHERE tra_id = '$tra_id' ";
        $this->serietramite->dbBySQL($upd);
    }

}

?>
