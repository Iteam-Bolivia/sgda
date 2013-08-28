<?php

/**
 * expcontenedor.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class expcontenedor extends tab_expcontenedor {

    function __construct() {
        $this->expcontenedor = new Tab_expcontenedor ();
    }

    function existeExpContendor($con_id, $exp_id) {
        $row = $this->expcontenedor->dbSelectBySQL("SELECT * from tab_expcontenedor WHERE
		exp_id='$exp_id' AND
		con_id='$con_id' AND
    	exc_estado='1'
		");
        //usu_id='".$_SESSION['USU_ID']."' AND
        //uni_id='".$_SESSION['UNI_ID']."  AND
        if (count($row))
            return true;
        else
            return false;
    }

    function dameUltimoRegistro($exp_id) {
        $row = $this->expcontenedor->dbSelectBySQL("SELECT MAX(exc_id) as id from tab_expcontenedor WHERE
		exp_id='$exp_id' AND
    	exc_estado='1'");
        if (count($row))
            return $row[0];
        else
            return "";
    }

    function saveExpCont($con_id, $suc_id, $exp_id) {
        $this->expcontenedor->setExc_id('');
        //$this->expcontenedor->setEuv_id($euv_id);
        $this->expcontenedor->setExp_id($exp_id);
        $this->expcontenedor->setCon_id($con_id);
        $this->expcontenedor->setSuc_id($suc_id);
        $this->expcontenedor->setExc_estado(1);
        return $this->expcontenedor->insert();
    }

}

?>
