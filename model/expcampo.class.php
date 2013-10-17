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
class expcampo extends tab_expcampo {

    function __construct() {
        //parent::__construct();
        $this->expcampo = new tab_expcampo();
    }

    function obtenerSelect($default = null) {
        $sql = "SELECT *
                FROM tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                ORDER BY ecp_id ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($default == $val->ecp_id)
                $option .="<option value='" . $val->ecp_id . "' selected>" . $val->ecp_tipdat . "</option>";
            else
                $option .="<option value='" . $val->ecp_id . "'>" . $val->ecp_tipdat . "</option>";
        }
        return $option;
    }

    function obtenerSelectTipoDato($default = null) {
        $option = "";
        if ($default == 'Texto') {
            $option .="<option value='Texto' selected>Texto</option>";
            $option .="<option value='Numero'>Número</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
        } else if ($default == 'Numero') {
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='Numero' selected>Número</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
        } else if ($default == 'Fecha') {
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='Numero'>Número</option>";
            $option .="<option value='Fecha' selected>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
        } else if ($default == 'Decimal') {
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='Numero'>Número</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal' selected>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
        } else if ($default == 'Lista') {
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='Numero'>Número</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista' selected>Lista</option>";
        } else {
            $option .="<option value='Texto'>Texto</option>";
            $option .="<option value='Numero'>Número</option>";
            $option .="<option value='Fecha'>Fecha</option>";
            $option .="<option value='Decimal'>Decimal</option>";
            $option .="<option value='Lista'>Lista</option>";
        }

        return $option;
    }

    function obtenerSelectCamposMostrar($ser_id = null, $exp_id = null) {
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                $option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .= "<td colspan='3'>";
                // Lista
                $sql = "SELECT
                        tab_expcampo.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecl_estado = 1 AND tab_expcampo.ecp_id = $val->ecp_id ";
                $row2 = $this->expcampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    // Find value
                    $sql = "SELECT
                            tab_expcampovalor.ecv_id,
                            tab_expcampovalor.exp_id,
                            tab_expcampovalor.ecp_id,
                            tab_expcampovalor.ecl_id,
                            tab_expcampovalor.ecv_valor,
                            tab_expcampovalor.ecv_estado
                            FROM
                            tab_expcampo
                            INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                            WHERE tab_expcampovalor.exp_id = '$exp_id'
                            AND tab_expcampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_expcampo.ecp_orden";
                    $row5 = $this->expcampo->dbselectBySQL($sql);
                    foreach($row5 as $list){
                       $ecv_valor=$list->ecv_valor;
                       $ecl_id=$list->ecl_id;
                    }
                    error_reporting(0);
                    if($ecv_valor){
                        $valor = $ecl_id;
                        if ($row5[0]->ecl_id == $val2->ecl_id)
                            $option .= $val2->ecl_valor;
                    }else{
                        $valor = "";
                        $option .= "";
                    }
                }
                $option .= "</select>";
                $option .="</td>";
                $option .="</tr>";
            } else {
                // Find Value
                $sql = "SELECT
                        tab_expcampovalor.ecv_id,
                        tab_expcampovalor.exp_id,
                        tab_expcampovalor.ecp_id,
                        tab_expcampovalor.ecl_id,
                        tab_expcampovalor.ecv_valor,
                        tab_expcampovalor.ecv_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                        WHERE tab_expcampovalor.exp_id = '$exp_id'
                        AND tab_expcampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_expcampo.ecp_orden";
                $this->expcampovalor = new tab_expcampovalor();
                $row5 = $this->expcampovalor->dbselectBySQL($sql);
                if (isset($row5[0]->ecv_valor)){
                    $valor = $row5[0]->ecv_valor;
                }else{
                    $valor = "";
                }
                    
                // Campos
                $option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .="<td colspan='3'> " . $valor . "</td>";
                $option .="</tr>";
            }
        }
        return $option;
    }

    /////////// mod diego calderon 2013.04.23

    function obtenerSelectCamposRepH($ser_id = null) {
        $width = 50;
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            $option .='<td width="' . $width . '" rowspan="3" align="center" valign="middle"><span style="font-size: 11px ;font-weight: bold;">' . $val->ecp_eti . '</span></td>';
        }
        return $option;
    }

    function obtenerSelectCamposRepC($ser_id = null, $exp_id = null) {
        $width = 50;
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                //$option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .= '<td width="' . $width . '">';
                // Lista
                $sql = "SELECT
                        tab_expcampo.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecl_estado = 1 AND tab_expcampo.ecp_id = $val->ecp_id ";
                $row2 = $this->expcampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    // Find value
                    $sql = "SELECT
                            tab_expcampovalor.ecv_id,
                            tab_expcampovalor.exp_id,
                            tab_expcampovalor.ecp_id,
                            tab_expcampovalor.ecl_id,
                            tab_expcampovalor.ecv_valor,
                            tab_expcampovalor.ecv_estado
                            FROM
                            tab_expcampo
                            INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                            WHERE tab_expcampovalor.exp_id = '$exp_id'
                            AND tab_expcampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_expcampo.ecp_orden";
                    $row5 = $this->expcampo->dbselectBySQL($sql);
                    if(isset($row5[0]->ecv_valor)){
                        $valor = $row5[0]->ecl_id;
                        if ($row5[0]->ecl_id == $val2->ecl_id)
                            $option .= '<span style="font-size: 11px;">' . $val2->ecl_valor . '</span>';
                        
                    }else{
                        $valor = "";
                        $option .= '<span style="font-size: 11px;"></span>';
                    }
                }
                //$option .= "</select>";
                $option .="</td>";
                //$option .="</tr>";
            } else {
                // Find Value
                $sql = "SELECT
                        tab_expcampovalor.ecv_id,
                        tab_expcampovalor.exp_id,
                        tab_expcampovalor.ecp_id,
                        tab_expcampovalor.ecl_id,
                        tab_expcampovalor.ecv_valor,
                        tab_expcampovalor.ecv_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                        WHERE tab_expcampovalor.exp_id = '$exp_id'
                        AND tab_expcampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_expcampo.ecp_orden";
                $this->expcampovalor = new tab_expcampovalor();
                $row5 = $this->expcampovalor->dbselectBySQL($sql);
                if(isset($row5[0]->ecv_valor)){
                    $valor = $row5[0]->ecv_valor;
                }else{
                    $valor = "";
                }
                
                // Campos
                //$option .="<tr><td><strong>" . $val->ecp_eti . "</strong></td>";
                $option .='<td width="' . $width . '"><span style="font-size: 11px;">' . $valor . '</span></td>';
                //$option .="</tr>";
            }
        }
        return $option;
    }

    function obtenerSelectCamposRepDoc($ser_id = null, $exp_id = null) {
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";
        $count = 0;
        // Trace
        if (count($row) > 0) {
            foreach ($row as $val) {


                if ($count == 0) {
                    $option .="<tr>";
                }
                if ($val->ecp_tipdat == 'Lista') {
                    $option .='<td bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">' . $val->ecp_eti . ':</span></td>';
                    $option .= '<td><span style="font-size: 14px;">';
                    // Lista
                    $sql = "SELECT
                        tab_expcampo.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecl_estado = 1 AND tab_expcampo.ecp_id = $val->ecp_id ";
                    $row2 = $this->expcampolista->dbselectBySQL($sql);
                    foreach ($row2 as $val2) {
                        // Find value
                        $sql = "SELECT
                            tab_expcampovalor.ecv_id,
                            tab_expcampovalor.exp_id,
                            tab_expcampovalor.ecp_id,
                            tab_expcampovalor.ecl_id,
                            tab_expcampovalor.ecv_valor,
                            tab_expcampovalor.ecv_estado
                            FROM
                            tab_expcampo
                            INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                            WHERE tab_expcampovalor.exp_id = '$exp_id'
                            AND tab_expcampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_expcampo.ecp_orden";
                        $row5 = $this->expcampo->dbselectBySQL($sql);
                        if (isset($val2->ecl_valor)) {
                            $valor = $row5[0]->ecl_id;
                            if ($row5[0]->ecl_id == $val2->ecl_id)
                                $option .= $val2->ecl_valor;
                        }else {
                            $valor = "";
                            $option .= "";
                        }
                    }

                    $option .="</span></td>";
                } else {
                    // Find Value
                    $sql = "SELECT
                        tab_expcampovalor.ecv_id,
                        tab_expcampovalor.exp_id,
                        tab_expcampovalor.ecp_id,
                        tab_expcampovalor.ecl_id,
                        tab_expcampovalor.ecv_valor,
                        tab_expcampovalor.ecv_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                        WHERE tab_expcampovalor.exp_id = '$exp_id'
                        AND tab_expcampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_expcampo.ecp_orden";
                    $this->expcampovalor = new tab_expcampovalor();
                    $row5 = $this->expcampovalor->dbselectBySQL($sql);
                    if (isset($row5[0]->ecv_valor)) {
                        $valor = $row5[0]->ecv_valor;
                    } else {
                        $valor = "";
                    }
                    // Campos
                    $option .='<td bgcolor="#CCCCCC"><span style="font-size: 14px;font-weight: bold;">' . $val->ecp_eti . ":</span></td>";
                    $option .='<td><span style="font-size: 14px;">' . $valor . "</span></td>";
                }
                $count++;
                if ($count == 2) {
                    $option .="</tr>";
                    $count = 0;
                }
            }
            if ($count < 2) {
                $option .="</tr>";
            }
        }
        return $option;
    }

    ///////////////


    function obtenerSelectCampos($ser_id = null) {
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                $option .="<tr><td>" . $val->ecp_eti . "</td>";
                $option .= "<td colspan='3'>
                    <select name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' title='" . $val->ecp_nombre . "' class=''>
                        <option value='' selected='selected'>(seleccionar)</option>";

                // Lista
                $sql = "SELECT
                        tab_expcampo.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecl_estado = 1 AND tab_expcampo.ecp_id = $val->ecp_id ";
                $row2 = $this->expcampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    $option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
                }
                $option .= "</select>";
                $option .="</td>";
                $option .="</tr>";
            } else {
                // Campo
                $option .="<tr><td>" . $val->ecp_eti . "</td>";
                if ($val->ecp_tipdat == 'Texto') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='256' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Numero') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='onlynumeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Decimal') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='numeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Fecha') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_nombre . "' value='' type='text'
                                     size='40' autocomplete='off' maxlength='20' class=''
                                     title='" . $val->ecp_nombre . "' />
                              </td>";


                    $option .="<script type='text/javascript'>";
                    $option .= "jQuery(document).ready(function($) { ";
                    $option .= "$('#" . $val->ecp_nombre . "').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                yearRange:'c-5:c+10',
                                dateFormat: 'yy-mm-dd',
                                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                                    'Junio', 'Julio', 'Agosto', 'Septiembre',
                                    'Octubre', 'Noviembre', 'Diciembre'],
                                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                                    'May', 'Jun', 'Jul', 'Ago',
                                    'Sep', 'Oct', 'Nov', 'Dic']
                            });";
                    $option .= "});";
                    $option .="</script>";
                }

                $option .="</tr>";
            }
        }
        return $option;
    }

    function obtenerSelectCamposEdit($ser_id = null, $exp_id = null) {
        $this->expcampolista = new tab_expcampolista();
        $sql = "SELECT
                tab_expcampo.ecp_id,
                tab_expcampo.ser_id,
                tab_expcampo.ecp_orden,
                tab_expcampo.ecp_eti,
                tab_expcampo.ecp_tipdat,
                tab_expcampo.ecp_estado,
                tab_expcampo.ecp_nombre
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        $option = "";

        // Trace
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                $option .="<tr><td>" . $val->ecp_eti . "</td>";
                $option .= "<td colspan='3'>
                    <select name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' title='" . $val->ecp_nombre . "' class='required'>
                        <option value=''>(seleccionar)</option>";

                // Lista
                $sql = "SELECT
                        tab_expcampo.ecp_id,
                        tab_expcampolista.ecl_id,
                        tab_expcampolista.ecl_valor,
                        tab_expcampolista.ecl_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampolista ON tab_expcampo.ecp_id = tab_expcampolista.ecp_id
                        WHERE tab_expcampolista.ecl_estado = 1 AND tab_expcampo.ecp_id = $val->ecp_id ";
                $row2 = $this->expcampolista->dbselectBySQL($sql);
                foreach ($row2 as $val2) {
                    // Find value
                    // Find Value
                    $sql = "SELECT
                            tab_expcampovalor.ecv_id,
                            tab_expcampovalor.exp_id,
                            tab_expcampovalor.ecp_id,
                            tab_expcampovalor.ecl_id,
                            tab_expcampovalor.ecv_valor,
                            tab_expcampovalor.ecv_estado
                            FROM
                            tab_expcampo
                            INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                            WHERE tab_expcampovalor.exp_id = '$exp_id'
                            AND tab_expcampo.ecp_id = $val->ecp_id
                            ORDER BY
                            tab_expcampo.ecp_orden";
                    $row5 = $this->expcampo->dbselectBySQL($sql);
                   // $valor = $row5[0]->ecl_id;
                    foreach($row5 as $list){
                       $valor=$list->ecl_id;
                    }

                    if ($valor == $val2->ecl_id)
                        $option .="<option value='" . $val2->ecl_id . "' selected>" . $val2->ecl_valor . "</option>";
                    else
                        $option .="<option value='" . $val2->ecl_id . "'>" . $val2->ecl_valor . "</option>";
                }
                $option .= "</select>";
                $option .="</td>";
                $option .="</tr>";
            } else {
                // Find Value
                $sql = "SELECT
                        tab_expcampovalor.ecv_id,
                        tab_expcampovalor.exp_id,
                        tab_expcampovalor.ecp_id,
                        tab_expcampovalor.ecl_id,
                        tab_expcampovalor.ecv_valor,
                        tab_expcampovalor.ecv_estado
                        FROM
                        tab_expcampo
                        INNER JOIN tab_expcampovalor ON tab_expcampo.ecp_id = tab_expcampovalor.ecp_id
                        WHERE tab_expcampovalor.exp_id = '$exp_id'
                        AND tab_expcampo.ecp_id = $val->ecp_id
                        ORDER BY
                        tab_expcampo.ecp_orden";
                $this->expcampovalor = new tab_expcampovalor();
                $row5 = $this->expcampovalor->dbselectBySQL($sql);
                if (isset($row5[0]->ecv_valor)){
                    $valor = $row5[0]->ecv_valor;
                }else{
                    $valor = "";
                }
                // Campo
                $option .="<tr><td>" . $val->ecp_eti . "</td>";
                if ($val->ecp_tipdat == 'Texto') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='required'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Numero') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='required onlynumeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Decimal') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_id . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='required numeric'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";
                } else if ($val->ecp_tipdat == 'Fecha') {
                    $option .="<td colspan='3'>
                              <input name='" . $val->ecp_id . "' id='" . $val->ecp_nombre . "' value='" . $valor . "' type='text'
                                     size='40' autocomplete='off' maxlength='20' class='required'
                                     title='" . $val->ecp_nombre . "' />
                              </td>";


                    $option .="<script type='text/javascript'>";
                    $option .= "jQuery(document).ready(function($) { ";
                    $option .= "$('#" . $val->ecp_nombre . "').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                yearRange:'c-5:c+10',
                                dateFormat: 'yy-mm-dd',
                                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                                    'Junio', 'Julio', 'Agosto', 'Septiembre',
                                    'Octubre', 'Noviembre', 'Diciembre'],
                                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                                    'May', 'Jun', 'Jul', 'Ago',
                                    'Sep', 'Oct', 'Nov', 'Dic']
                            });";
                    $option .= "});";
                    $option .="</script>";
                }

                $option .="</tr>";
            }
        }
        return $option;
    }

    function obtenerCampos($ser_id = null) {
        $this->expcampo = new tab_expcampo();
        $sql = "SELECT *
                FROM
                tab_expcampo
                WHERE tab_expcampo.ecp_estado = 1
                AND tab_expcampo.ser_id = $ser_id
                ORDER BY ecp_orden ASC ";
        $row = $this->expcampo->dbselectBySQL($sql);
        if (count($row)) {
            return $row;
        } else {
            return null;
        }
    }

    function count($where) {
        $expcampo = new Tab_expcampo ();
        $sql = "SELECT count(ecp_id)
                FROM
                tab_expcampo
                WHERE
                ecp_estado =  1 $where ";
        $num = $expcampo->countBySQL($sql);
        return $num;
    }

    function count2($where, $ser_id) {
        $expcampo = new tab_expcampo ();
        $sql = "SELECT count(tab_series.ser_id)
                FROM
                tab_series
                INNER JOIN tab_expcampo ON tab_expcampo.ser_id = tab_series.ser_id
                WHERE tab_series.ser_id = $ser_id
                AND tab_expcampo.ecp_estado = 1 $where ";
        $num = $expcampo->countBySQL($sql);
        return $num;
    }

    function saveCampos($ser_id = null, $exp_id = null, $ecp_id = null) {
        $row = $this->expcampo->obtenerCampos($ser_id);
        foreach ($row as $val) {
            if ($val->ecp_tipdat == 'Lista') {
                $ecp_id = $val->ecp_id;
                $ecp_valor = $ecp_id;
                // Save data dynamic
                $this->expcampovalor = new tab_expcampovalor();
                $this->expcampovalor->setExp_id($exp_id);
                $this->expcampovalor->setEcp_id($ecp_id);
                // Set value of list
                $this->expcampovalor->setEcl_id($ecp_valor);
                //
                $this->expcampovalor->setEcv_valor($ecp_valor);
                $this->expcampovalor->setEcv_estado(1);
                $this->expcampovalor->insert();
            } else {
                $ecp_id = (string) $val->ecp_id;
                $ecp_valor = $ecp_id;
                // Save data dynamic
                $this->expcampovalor = new tab_expcampovalor();
                $this->expcampovalor->setExp_id($exp_id);
                $this->expcampovalor->setEcp_id($ecp_id);
                $this->expcampovalor->setEcv_valor($ecp_valor);
                $this->expcampovalor->setEcv_estado(1);
                $this->expcampovalor->insert();
            }
        }
    }

}

?>