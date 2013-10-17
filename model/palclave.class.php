<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class palclave extends tab_palclave {

    function __construct() {
        //parent::__construct();
        $this->palclave = new tab_palclave();
    }

    function count($where) {
        $palclave = new Tab_palclave ();
        $sql = "SELECT count(pac_id)
                    FROM
                    tab_palclave
                    WHERE
                    pac_estado =  1 $where ";
        //echo($sql);die;
        $num = $palclave->countBySQL($sql);
        return $num;
    }
    
    function listaPC($formulario = null) {
        $palclave = new Tab_palclave ();
        $cadena = "";
        if($formulario=="")
            $where = "";
        else $where = "AND pac_formulario='".$formulario."'";
        
        $sql = "SELECT DISTINCT pac_nombre
                    FROM
                    tab_palclave
                    WHERE
                    pac_estado =  1 $where order by pac_nombre";
        $row = $palclave->dbSelectBySQL($sql);
        foreach ($row as $val) {
            //$cadena .="<div><li>".$val->pac_nombre."</li></div>";
            $cadena .="<option value='" . $val->pac_nombre . "'>" . $val->pac_nombre . "</option>";
        }
        return $cadena;
    }
    
    function listaPCFile($fil_id=null) {
        $palclave = new Tab_palclave ();
        $cadena = "";
        if($fil_id=="")
            $where = "";
        else $where = "AND fil_id='".$fil_id."'";
        
        $sql = "SELECT pac_nombre
                    FROM
                    tab_palclave
                    WHERE
                    pac_estado =  1 $where";
        $row = $palclave->dbSelectBySQL($sql);
        foreach ($row as $val) {
            $cadena .= ' ' .$val->pac_nombre . SEPARATOR_SEARCH;
        }
        return $cadena;
    }    
 
    // Set chain for search addwords
    function listaPCSearchFile($pac_nombre=null) {
        $ids = "";
        if($pac_nombre!=""){
            $array = explode(SEPARATOR_SEARCH, $pac_nombre);
            for($j=0;$j<count($array);$j++){
                $in .= "'" . trim($array[$j]) . "'" . ',';
            }        
            $in = substr($in, 0, -1);
        }
        $palclave = new tab_palclave();
        $sql = "SELECT DISTINCT fil_id
                    FROM
                    tab_palclave
                    WHERE
                    pac_estado = 1 AND pac_nombre IN ($in)";
        $row = $palclave->dbSelectBySQL($sql);
        foreach ($row as $val) {
            $ids .= $val->fil_id . ',';
        }
        
        if (strlen($ids)>0)
            return substr($ids, 0, -1);
        else
            return $ids;
    }     
    
}

?>