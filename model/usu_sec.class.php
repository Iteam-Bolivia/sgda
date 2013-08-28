<?php

/**
 * use_sec.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class usu_sec extends tab_usu_sec {

    function __construct() {
        //parent::__construct();
        $this->usu_sec = new Tab_usu_sec();
    }

    function existe($sec, $usu_id) {
        $rows = $this->usu_sec->dbselectBy2Field("sec_id", $sec, "usu_id", $usu_id);
        if (count($rows) > 0) {
            return $rows[0]->use_id;
        } else {
            return false;
        }
    }

//    function delete($usu_id) {
//        $del = "UPDATE tab_usu_sec SET use_estado = '2' WHERE usu_id = '$usu_id' AND use_estado = '1' ";
//        $this->usu_sec->dbBySQL($del);
//    }
//
//    function deleteXSerie($sec_id) {
//        $del = "UPDATE tab_usu_sec SET use_estado = '2' WHERE sec_id = '$sec_id' AND use_estado = '1' ";
//        $this->usu_sec->dbBySQL($del);
//    }
//
//    function deleteXUsuario($usu_id) {
//        $del = "UPDATE tab_usu_sec SET use_estado = '2' WHERE usu_id = '$usu_id' AND use_estado = '1' ";
//        $this->usu_sec->dbBySQL($del);
//    }

    function tieneSeries($usu_id) {
        $sql = "SELECT COUNT(DISTINCT us.use_id)
            FROM
            tab_usu_sec AS us
            Inner Join tab_seccion AS s ON s.sec_id = us.sec_id
            WHERE
            us.use_estado =  '1' AND
            us.usu_id =  '$usu_id' AND
            (s.ser_tipo IS NULL  OR s.ser_tipo = '') ";
        $num = $this->usu_sec->countBySQL($sql);
        if ($num > 0) {
            return 'OK';
        } else {
            return false;
        }
    }

}

?>