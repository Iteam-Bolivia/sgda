<?php

/**
 * documentos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2013
 * @access public
 */
class documentos extends tab_documentos {

    function __construct() {
        $this->documentos = new Tab_documentos ();
    }
    
    function count($where) {
        $documentos = new Tab_documentos ();
        $num = 0;
        $sql = "select count(codigo) as num
		from tab_documentos
		WHERE $where ";
        $num = $documentos->countBySQL($sql);

        return $num;
    }

    function getReferencia($default = null) {        
        $sql = "SELECT codigo, referencia, sintesis 
                FROM documentos 
                WHERE codigo = '$default' "; 
        $result = $this->documentos->dbSelectBySQL($sql);        
        $res = array();
        foreach ($result as $row) {
            $res['referencia'] = $row->referencia;
            $res['sintesis'] = $row->sintesis;
        }
        echo json_encode($res);        
    }

}

?>
