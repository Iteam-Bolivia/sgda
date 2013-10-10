<?php

/**
 * tipoarchModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class tipoarch extends Tab_tipoarch {

    function __construct() {
        //parent::__construct();
        $this->tipoarch = new Tab_tipoarch();
    }

    function count($where) {
        $tipoarch = new Tab_tipoarch ();
        $sql = "SELECT count(tar_id)
                    FROM
                    tab_tipoarch AS u
                    WHERE
                    u.tar_estado =  1 $where ";
        $num = $tipoarch->countBySQL($sql);
        return $num;
    }

    
    function obtenerSelect($default = null) {
        $sql = "SELECT 
            f.tar_id,
            f.tar_nombre
            FROM
            tab_tipoarch AS f
            WHERE
            f.tar_estado =  '1'
            ORDER BY f.tar_id ";
        $rows = $this->tipoarch->dbSelectBySQL($sql);
        $tipoarchs = "";
        foreach ($rows as $tar) {
            if ($default == $tar->tar_id) {
                $tipoarchs .= "<option value='$tar->tar_id' selected>$tar->tar_nombre</option>";
            } else {
                $tipoarchs .= "<option value='$tar->tar_id'>$tar->tar_nombre</option>";
            }
        }
        return $tipoarchs;
    }
    
    
    
    
    
    

}

?>
