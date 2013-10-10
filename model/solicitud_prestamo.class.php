<?php

/**
 * solicitud_prestamo.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class solicitud_prestamo extends tab_solprestamo {

    function __construct() {
        //parent::__construct();
        $this->solicitud_prestamo = new Tab_solprestamo();
    }

    function obtenerSelect($default) {
        if ($default) {
            $sql = "SELECT *
                FROM tab_solicitud_prestamo
                WHERE spr_estado = 1
                AND spr_id = '$default'
                ORDER BY spr_id ASC";
        } else {
            $sql = "SELECT *
                FROM tab_solicitud_prestamo
                WHERE spr_estado = 1
                ORDER BY spr_id ASC";
        }
        $rows = $this->solicitud_prestamo->dbselectBySQL($sql);
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                $option .="<option value='" . $val->spr_id . "'>" . $val->spr_solicitante . "</option>";
            }
        }
        return $option;
    }

    function count($default) {
        $uni_id = $_SESSION['UNI_ID'];
        $serie = new tab_solprestamo();
        $num = 0;
        if ($default) {
            $sql = "SELECT count(spr_id)
                    FROM tab_solicitud_prestamo
                    WHERE spr_estado = 1
                    AND spr_id = '$default'
                    ORDER BY spr_id ASC";
        } else {
            $sql = "SELECT COUNT (spr_id)
                    FROM tab_solicitud_prestamo
                    WHERE spr_estado = 1
                    AND uni_id = '$uni_id' ";
        }
        $num = $serie->countBySQL($sql);
        return $num;
    }
      function count3($tipo, $value1) {
        $prestamos = new tab_solprestamo ();
        $num = 0;
        $where = "";
        if ($value1 != "") {
            if ($tipo == 'spr_id')
                $where = " and $tipo = '$value1' ";
            else
                $where = " and $tipo LIKE '%$value1%' ";
        }
        $sql = "select count(spr_id) as num
		from tab_solprestamo
		WHERE spr_estado = '1' $where ";
        $num = $prestamos->countBySQL($sql);

        return $num;
    }
    
    function ObtenerUsuario($id_usuario){
        $usuario=new tab_usuario();
        $sql="select* from tab_usuario where usu_id=$id_usuario";
        $dt=$usuario->dbSelectBySQL($sql);
        foreach($dt as $row){
            $nombre=$row->usu_nombres;
            $apellido=$row->usu_apellidos;
        }
       $nombrecompleto=$nombre." ".$apellido;
       return $nombrecompleto;
    }
    function obtenerMaximo($field){
      $maximo=new tab_solprestamo();
    $max=$maximo->dbSelectBySQL("SELECT* from tab_solprestamo
   where $field = (select max($field) from tab_solprestamo)");
   $mx=$max[0];
    $id=$mx->spr_id;
    return $id;
    }
    function obtenerEstado($sprId){
        
    $sql="select spr_estado from tab_solprestamo where spr_id=$sprId";
     $result=$this->solicitud_prestamo->dbSelectBySQL($sql);
     $result=$result[0];
     return $result->spr_estado;
    }
}

?>
