<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/contratos/<?php echo $PATH_EVENT ?>/">
    <input name="ctt_id" id="ctt_id" type="hidden"
           value="<?php echo $ctt_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
            <td width="125">Expediente</td>
            <td width="300">
                <select name="exp_id" id="exp_id" class="required" style="width: 410px" title="Expediente">
                    <option value="">(seleccionar)</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
        </tr>

        <tr>
                <!--  <td>Codigo:</td> -->
            <td><input name="ctt_codigo" type="hidden" id="cod_codigo"
                       value="<?php echo ""; //$ctt_codigo;  ?>" size="35" autocomplete="off"
                       maxlength="8" title="Codigo Contrato" /></td>
        </tr>

        <tr>
                <!--  <td>Descripcion:</td>  -->
            <td><input name="ctt_descripcion" type="hidden" id="ctt_descripcion"
                       value="<?php echo "";
                    $ctt_descripcion; ?>" size="35" 
                       maxlength="100" autocomplete="off" title="Descripcion Contrato" /></td>

        </tr>

        <tr>
            <td>Proveedor:</td>
            <td><input name="ctt_proveedor" type="text" id="ctt_proveedor"
                       value="<?php echo $ctt_proveedor; ?>" class="required" maxlength="50"
                       size="35" autocomplete="off" title="Proveedor" /></td>
        </tr>



        <tr>
            <td>Gestion:</td>
            <td><input name="ctt_gestion" type="text" id="ctt_gestion"
                       value="<?php echo $ctt_gestion; ?>" size="35" class="required"
                       maxlength="16" autocomplete="off" title="Gestion" /></td>

        </tr>
        <tr>
            <td>CITE:</td>
            <td><input name="ctt_cite" type="text" id="ctt_cite"
                       value="<?php echo $ctt_cite; ?>" class="required" maxlength="50"
                       size="35" autocomplete="off" title="CITE" /></td>			
        </tr>

        <tr>
            <td>Precio Base Ref. Unitario:</td>
            <td><input name="ctt_precbasrefunit" type="text" id="ctt_precbasrefunit"
                       value="<?php echo $ctt_precbasrefunit; ?>" size="35" class="required"
                       maxlength="11" autocomplete="off" title="Precio Base Ref. Unitario" /></td>
        </tr>

        <tr>
            <td>Fecha: </td>
            <td><input name="ctt_fecha"
                       type="text" id="ctt_fecha" value="<?php echo $ctt_fecha; ?>"
                       size="15" autocomplete="off" class="required" maxlength="10"
                       title="Fecha del Contrato" /></td>
        </tr>

        <tr>
            <td width="125">Unidad</td>
            <td width="200"><select name="uni_id" id="uni_id" class="required"
                                    style="width: 210px" title="Unidad Solicitante">
                    <option value="">(seleccionar)</option>
                <?php echo $uni_id; ?>
                </select></td>
        </tr>
        <tr>
            <td width="125">Tipo Solicitud</td>
            <td width="200"><select name="sol_id" id="sol_id" class="required"
                                    style="width: 210px" title="Tipo Solicitud">
                    <option value="">(seleccionar)</option>
                <?php echo $sol_id; ?>
                </select></td>

        </tr>



        <tr>
            <td width="125">Modalidad</td>
            <td width="200"><select name="mod_id" id="mod_id" class="required"
                                    style="width: 210px" title="Modalidad">
                    <option value="">(seleccionar)</option>
                <?php echo $mod_id; ?>
                </select></td>
        </tr>	

        <tr>
            <td width="125">Fuente Financiamiento</td>
            <td width="200"><select name="ff_id" id="ff_id" class="required"
                                    style="width: 210px" title="Fuente Financiamiento">
                    <option value="">(seleccionar)</option>
                <?php echo $ff_id; ?>
                </select></td>

        </tr>

        <tr>
            <td>Observaciones:</td>
            <td><input name="ctt_detalle" type="text" id="ctt_detalle"
                       value="<?php echo $ctt_detalle; ?>" size="35" autocomplete="off"
                       maxlength="100" title="Detalle Contrato" /></td>
        </tr>


        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>
</form>

<div class="clear"></div>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/contratos/";
        });
    });
    $(function() {
        $('#ctt_fecha').datepicker({
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
        });
    });
</script>