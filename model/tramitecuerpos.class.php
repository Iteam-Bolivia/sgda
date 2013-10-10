<?php

/**
 * tramitecuerpos.class.php Model
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class tramitecuerpos extends tab_tramitecuerpos {

    function __construct() {
        $this->tramites = new Tab_tramitecuerpos();
    }

    function deleteXTramite($tra_id) {
        $upd = "UPDATE tab_tramitecuerpos SET trc_estado='2' WHERE tra_id = '$tra_id' ";
        $this->tramites->dbBySQL($upd);
    }

    function deleteXCuerpo($cue_id) {
        $upd = "UPDATE tab_tramitecuerpos SET trc_estado='2' WHERE cue_id = '$cue_id' ";
        $this->tramites->dbBySQL($upd);
    }

    function obtenerSelectTramiteCuerpos($default = null, $cue_id) {
        $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_tramite.tra_id,
				tab_tramite.tra_codigo,
				tab_tramite.tra_descripcion,
				tab_tramite.tra_fecha_crea,
				tab_tramite.tra_usuario_crea,
				tab_tramite.tra_fecha_mod,
				tab_tramite.tra_usuario_mod,
				tab_tramite.tra_estado
				FROM
				tab_tramite
				WHERE
				tra_id NOT IN  (SELECT
				tab_tramite.tra_id
				FROM
				tab_tramite
				Inner Join tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
				WHERE
				tab_tramitecuerpos.cue_id =  '" . $cue_id . "') ORDER BY tab_tramite.tra_descripcion ASC");

        if (count($rows)) {
            $option = "";
            foreach ($rows as $val) {
                if ($default == $val->tra_id)
                    $selected = "selected";
                else
                    $selected = " ";
                if (strlen($val->tra_descripcion) > 50)
                    $tramite = substr($val->tra_descripcion, 0, 60) . " ...";
                else
                    $tramite = $val->tra_descripcion;
                $option .="<option value='" . $val->tra_id . "' " . $selected . ">" . $tramite . "</option>";
            }
            return $option;
        }
        else
            return "";
    }

    function obtenerSelectTramites($default = null) {
        $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_tramite.tra_id,
				tab_tramite.tra_codigo,
				tab_tramite.tra_descripcion,
				tab_tramite.tra_fecha_crea,
				tab_tramite.tra_usuario_crea,
				tab_tramite.tra_fecha_mod,
				tab_tramite.tra_usuario_mod,
				tab_tramite.tra_estado
				FROM
				tab_tramite
				WHERE
				tra_estado ='1' ORDER BY tra_descripcion ASC");
        if (count($rows)) {
            $option = "";
            foreach ($rows as $val) {
                if ($default == $val->tra_id)
                    $selected = "selected";
                else
                    $selected = " ";
                if (strlen($val->tra_descripcion) > 100)
                    $tramite = substr($val->tra_descripcion, 0, 60) . " ...";
                else
                    $tramite = $val->tra_descripcion;
                $option .="<option value='" . $val->tra_id . "' " . $selected . ">" . $tramite . "</option>";
            }
            return $option;
        }
        else
            return "";
    }

    function obtenerTramiteCuerpos($cuerpo_id) {
        $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_tramite.tra_id,
				tab_tramite.tra_codigo,
				tab_tramite.tra_descripcion,
				tab_tramite.tra_fecha_crea,
				tab_tramite.tra_usuario_crea,
				tab_tramite.tra_fecha_mod,
				tab_tramite.tra_usuario_mod,
				tab_tramite.tra_estado
				FROM
				tab_tramite
				Inner Join tab_tramitecuerpos ON tab_tramite.tra_id = tab_tramitecuerpos.tra_id
				WHERE
				tab_tramitecuerpos.cue_id =  '" . $cuerpo_id . "'
                                 AND tab_tramitecuerpos.trc_estado = '1'
                                ORDER BY tab_tramite.tra_descripcion ASC ");
        if (count($rows))
            return $rows;
        else
            return "";
    }

    function obtenerSelectCuerpos($tra_id, $default = null) {
        $rows = $this->obtenerCuerposTramite($tra_id);
        $option = "";
        if ($rows != "") {
            foreach ($rows as $val) {
                if ($default == $val->cue_id)
                    $selected = "selected";
                else
                    $selected = " ";
                if (strlen($val->cue_descripcion) > 100)
                    $cuerpo = substr($val->cue_descripcion, 0, 60) . " ...";
                else
                    $cuerpo = $val->cue_descripcion;
                $option .="<option value='" . $val->cue_id . "' " . $selected . ">" . $cuerpo . "</option>";
            }
        }
        return $option;
    }

    function obtenerCuerposTramiteNoseleccionados($tra_id) {
        $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_cuerpos.cue_codigo,
				tab_cuerpos.cue_descripcion,
				tab_cuerpos.cue_id
				FROM
				tab_cuerpos
				WHERE
				tab_cuerpos.cue_id NOT IN
				(SELECT c.cue_id From tab_tramitecuerpos as tc
                                    inner join  tab_cuerpos as c ON tc.cue_id=c.cue_id
                                    WHERE  tc.tra_id='" . $tra_id . "' AND tc.trc_estado = '1')
                                ORDER BY tab_cuerpos.cue_descripcion ASC ");
        if (count($rows))
            return $rows;
        else
            return "";
    }

    // REVISED CASTELLON
    // ERROR: $tra_id no debe ser  NULL
    function obtenerCuerposTramite($tra_id) {
        // MODIFIED CASTELLON
        if (isset($tra_id)) {
            $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_cuerpos.cue_codigo,
				tab_cuerpos.cue_descripcion,
				tab_cuerpos.cue_id
				FROM tab_cuerpos
				WHERE tab_cuerpos.cue_id IN (SELECT c.cue_id From tab_tramitecuerpos AS tc INNER JOIN  tab_cuerpos as c ON tc.cue_id=c.cue_id WHERE tc.trc_estado = '1')
                ORDER BY tab_cuerpos.cue_descripcion ASC ");
        } else {
            //
            $rows = $this->tramites->dbSelectBySQL("SELECT
				tab_cuerpos.cue_codigo,
				tab_cuerpos.cue_descripcion,
				tab_cuerpos.cue_id
				FROM
				tab_cuerpos
				WHERE
				tab_cuerpos.cue_id IN
				(SELECT c.cue_id From tab_tramitecuerpos as tc
				inner join  tab_cuerpos as c ON tc.cue_id=c.cue_id
				WHERE  tc.tra_id='" . $tra_id . "' AND tc.trc_estado = '1')
				ORDER BY tab_cuerpos.cue_descripcion ASC ");
            //
        }
        //
        if (count($rows))
            return $rows;
        else
            return "";
    }

}

?>