<?php

/**
 * tab_tablas.class.php Class
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class Tab_tablas extends db {

    var $tab_name;
    var $tab_activo;
    var $tab_inactivo;
    var $tab_total;

    function __construct() {
        parent::__construct();
    }

    function getTab_name() {
        return $this->tab_name;
    }

    function setTab_name($tab_name) {
        $this->tab_name = $tab_name;
    }

    function getTab_activo() {
        return $this->tab_activo;
    }

    function setTab_activo($tab_activo) {
        $this->tab_activo = $tab_activo;
    }

    function getTab_inactivo() {
        return $this->tab_inactivo;
    }

    function setTab_inactivo($tab_inactivo) {
        $this->tab_inactivo = $tab_inactivo;
    }

    function getTab_total() {
        return $this->tab_total;
    }

    function setTab_total($tab_total) {
        $this->tab_total = $tab_total;
    }

    function obtenerTabActivos($tabla, $campo) {
        $activos = pg_query("SELECT COUNT($campo) as num FROM " . $tabla . " WHERE " . $campo . "='1'");
        if ($activos) {
            if (pg_num_rows($activos)) {
                if ($row = pg_fetch_row($activos))
                    return $row [0];
            }
            pg_free_result($activos);
        }else
            return 0;
    }

    function obtenerTabTotal($tabla, $campo) {
        $activos = pg_query("SELECT COUNT($campo) as num FROM " . $tabla);
        if ($activos) {
            if (pg_num_rows($activos)) {
                if (($row = pg_fetch_row($activos)))
                    return $row [0];
            }
            pg_free_result($activos);
        }else
            return 0;
    }

    function obtenerTabInactivos($tabla, $campo) {
        $inactivos = pg_query("SELECT COUNT($campo) as num FROM " . $tabla . " WHERE " . $campo . "!='1'");

        if ($inactivos) {
            if (pg_num_rows($inactivos)) {
                if (($row = pg_fetch_row($inactivos)))
                    return $row [0];
            }
            pg_free_result($inactivos);
        }else
            return 0;
    }

    function obtenerTablas($defaultTablas) {
        $BuscarEnTablas = array('tab_subcontenedor', 'par_institucion', 'tab_locales', 'tab_menu', 'tab_riesgos', 'tab_retdocumental', 'auditoria', 'tab_contenedor');
        $db = new db ();
        $link = $db->connect();
        $result = pg_query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");

        if ($result) {
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_row($result)) {
                    $tablasBD [] = $row[0];
                }
            }
            pg_free_result($result);
        }

        //$tablasBD = $tablas->dbAll ();
        $tablaCampo = array();
        $t = 0;
        foreach ($tablasBD as $tabla) {
            if (in_array($tabla, $BuscarEnTablas)) {
                $campos = pg_query("SELECT column_name AS Field , udt_name AS Type , is_nullable AS null ,ordinal_position AS Key, column_default AS default FROM information_schema.columns WHERE table_name = '" . $tabla . "'");
                $i = 0;
                $arrayCampos = array();
                if ($campos) {
                    if (pg_num_rows($campos) > 0) {
                        while ($row = pg_fetch_assoc($campos)) {
                            $arrayCampos [$i] = $row['field'];
                            $i++;
                        }
                        pg_free_result($campos);
                    }
                    $estado = "no";
                    foreach ($arrayCampos as $i => $camposs) {

                        if (strstr($camposs, "_estado")) {
                            $listaCampo [$i] = $camposs;
                            $estado = $camposs;
                            break;
                        }
                    }
                    if ($estado != "no") {
                        $activos = $this->obtenerTabActivos($tabla, $estado);
                        $inactivos = $this->obtenerTabInactivos($tabla, $estado);
                        //$total = $activos+ $inactivos;
                    } else {
                        $activos = $this->obtenerTabTotal($tabla, $camposs);
                        $inactivos = "-";
                    }
                    $total = $this->obtenerTabTotal($tabla, $camposs);
                    $tablaCampo [$t] ["tabla"] = $tabla;
                    $tablaCampo [$t] ["activo"] = $activos;
                    $tablaCampo [$t] ["inactivo"] = $inactivos;
                    $tablaCampo [$t] ["total"] = $total;
                    $t++;
                }
            }
        }
        $db->disconnect($link);
        return $tablaCampo;
    }

    function obtenerCampos($tabla) {
        $arrayCampos = array();
        $db = new db ();
        $link = $db->connect();
        $campos = pg_query($link, "SELECT column_name AS Field , udt_name AS Type , is_nullable AS null ,ordinal_position AS Key, column_default AS default FROM information_schema.columns WHERE table_name = '" . $tabla . "'");
        if ($campos) {
            if (pg_num_rows($campos) > 0) {
                $i = 0;
                while ($ca = pg_fetch_assoc($campos)) {
                    $arrayCampos [$i] = $ca;
                    $i++;
                }
            }
        }
        $db->disconnect($link);
        return $arrayCampos;
    }

    function obtenerCamposField($tabla) {
        $arrayCampos = array();
        $db = new db ();
        $link = $db->connect();
        $campos = pg_query($link, "SELECT column_name AS Field , udt_name AS Type , is_nullable AS null ,ordinal_position AS Key, column_default AS default FROM information_schema.columns WHERE table_name = '" . $tabla . "'");
        if ($campos) {
            if (pg_num_rows($campos) > 0) {
                $i = 0;
                while ($ca = pg_fetch_assoc($campos)) {
                    $arrayCampos [$i] = $ca['field'];
                    $i++;
                }
            }
        }
        $db->disconnect($link);
        return $arrayCampos;
    }

    function buscarCampoEstado($tabla) {
        $arrayCampos = $this->obtenerCampos($tabla);
        foreach ($arrayCampos as $i => $camposs) {
            if (strstr($camposs ['field'], "_estado")) {
                return $camposs ['field'];
                break;
            }
        }
        return null;
    }

    function generarCamposInput($arrayCampos, $row = null) {
        $table = "";
        if ($row != null || $row != "") {
            $i = 1;
            foreach ($arrayCampos as $campo) {
                //if($campo['key']=="PRI") $table .="<tr><td>".$campo['Field']." : </td><td colspan=2>".$row->$campo['Field']."</td></tr>";
                //else
                if (strstr($campo ['field'], "fecha")) {
                    $idCampo = "id='datepicker$i'";
                    $i++;
                } else
                    $idCampo = "id='" . $campo ['field'] . "'";
                // para evitar que ponga como obligatorio required en todos los campos
                $required = " class='required' ";
                $readonly = "";
                if (substr($campo ['field'], -3) == "_id") {
                    $required = "";
                    $readonly = " readonly ";
                } else if (substr($campo ['field'], -4) == "_mod") {
                    $required = "";
                }
                $table .= "<tr><td width=30%>" . $campo ['field'] . " : </td><td colspan=2><input type='text' name='" . $campo ['field'] . "' $idCampo value='" . utf8_encode($row->$campo ['field']) . "' size='70' $required $readonly /></td></tr>";
            }
        } else {
            $i = 1;
            foreach ($arrayCampos as $campo) {
                if (strstr($campo ['field'], "fecha")) {
                    $idCampo = "id='datepicker$i'";
                    $i++;
                } else
                    $idCampo = "id='" . $campo ['field'] . "'";
                // para evitar que ponga como obligatorio required en todos los campos
                $required = " class='required' ";
                if (substr($campo ['field'], -3) == "_id") {
                    $required = "";
                } else if (substr($campo ['field'], -4) == "_mod") {
                    $required = "";
                }
                $table .= "<tr><td width=30%>" . $campo ['field'] . " : </td><td colspan=2><input type='text' name='" . $campo ['field'] . "' $idCampo value='' size='70' $required /></td></tr>";
            }
        }
        //print_r ($table);die;
        return $table;
    }

    function countField($tabla, $tipo, $query) {
        $this->tabla = new db ();
        $num = 0;
        if (strtoupper($query) == "VER ACTIVOS")
            $sql = "SELECT COUNT(*) as num FROM $tabla WHERE $tipo = '1'";
        elseif (strtoupper($query) == "VER INACTIVOS")
            $sql = "SELECT COUNT(*) as num FROM $tabla WHERE $tipo!= '1'";
        else
            $sql = "SELECT COUNT(*) as num FROM $tabla ";
        $num = $this->tabla->countBySQL($sql);
        return $num;
    }

}

?>