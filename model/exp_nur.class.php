<?php

/**
 * archivoModel
 *
 * @package
 * @author Dev. Diego Calderon Ramirez
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class exp_nur extends tab_exp_nur {

    function __construct() {
        //parent::__construct();
        $this->exp_nur = new tab_exp_nur();
    }

    function count($where) {
        $exp_nur = new Tab_exp_nur ();
        $sql = "SELECT count(exn_id)
                    FROM
                    tab_exp_nur
                    WHERE
                    exn_estado =  1 $where ";
        //echo($sql);die;
        $num = $exp_nur->countBySQL($sql);
        return $num;
    }

    function obtenerNur($exn_id) {
        $exp_nur = new Tab_exp_nur ();
        $sql = "SELECT *
                    FROM
                    tab_exp_nur
                    WHERE
                    exn_estado =  1 AND exn_id='" . $exn_id . "'";
        //echo($sql);die;
        $row = $exp_nur->dbSelectBySQL($sql);
        if ($row[0]->exn_nur)
            return $row[0]->exn_nur;
        else
            return "";
    }

}

?>