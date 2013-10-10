<?php

/**
 * usu_serie.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class usu_serie extends tab_usu_serie {

    function __construct() {
        //parent::__construct();
        $this->usu_serie = new Tab_usu_serie();
    }

    function existe($serie, $usu_id) {
        $rows = $this->usu_serie->dbselectBy2Field("ser_id", $serie, "usu_id", $usu_id);
        if (count($rows) > 0) {
            return $rows[0]->use_id;
        } else {
            return false;
        }
    }

    function delete($usu_id) {
        $del = "UPDATE tab_usu_serie SET use_estado = '2' WHERE usu_id = '$usu_id' AND use_estado = '1' ";
        $this->usu_serie->dbBySQL($del);
    }

    function deleteXSerie($ser_id) {
        $del = "UPDATE tab_usu_serie SET use_estado = '2' WHERE ser_id = '$ser_id' AND use_estado = '1' ";
        $this->usu_serie->dbBySQL($del);
    }

    function deleteXUsuario($usu_id) {
        $del = "UPDATE tab_usu_serie SET use_estado = '2' WHERE usu_id = '$usu_id' AND use_estado = '1' ";
        $this->usu_serie->dbBySQL($del);
    }

    function tieneSeries($usu_id) {
        $sql = "SELECT COUNT(us.use_id)
                FROM
                tab_usu_serie AS us
                Inner Join tab_series AS s ON s.ser_id = us.ser_id
                WHERE
                us.use_estado =  '1' AND
                us.usu_id =  '$usu_id' ";
        $num = $this->usu_serie->countBySQL($sql);
        if ($num > 0) {
            return 'OK';
        } else {
            return false;
        }
    }

}

?>