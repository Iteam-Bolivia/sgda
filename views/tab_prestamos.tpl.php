<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/prestamos/<?php echo $PATH_EVENT ?>/">
    <input name="pre_id" id="pre_id" type="hidden" value="<?php echo $pre_id; ?>" />
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo">Registro de Pr&eacute;stamo</caption>
        <tr>
            <td width="238">Expediente:</td>
            <td colspan="3"><?php echo $exp_codigo; ?> - <?php echo $exp_nombre; ?></td>
        </tr>
        <tr>
            <td>Unidad:</td>
            <td colspan="3">
                <select name="uni_id" style="width:300px;" id="uni_id" title="Unidad">
                    <option value="">-Seleccionar-</option>
                    <?php echo $uni_id; ?>
                </select></td>
        </tr>
        <tr>
            <td>Instituci&oacute;n:</td>
            <td colspan="3">
                <select name="pre_institucion" style="width:300px;" id="pre_institucion" title="Instituci&oacute;n a la que pertenece el Solicitante">
                    <option value="">-Seleccionar-</option>
                    <?php echo $pre_institucion; ?>
                </select></td>
        </tr>
        <tr>
            <td>Oficina:</td>
            <td colspan="3"><input name="pre_sigla_of" type="text" id="pre_sigla_of" value="<?php echo $pre_sigla_of; ?>" size="35" maxlength="20" autocomplete="off" class="required alphanum" title="Oficina Solicitante"/>  </td>
        </tr>
        <tr>
            <td>Solicitante:</td>
            <td colspan="3"><input name="pre_solicitante" type="text" id="pre_solicitante" value="<?php echo $pre_solicitante; ?>" maxlength="150" size="95" autocomplete="off" class="required alphanum" title="Nombre del Solicitante"/></td>
        </tr>
        <tr>
            <td>Documento Aval:</td>
            <td colspan="3"><input name="pre_doc_aval" type="text" id="pre_doc_aval" value="<?php echo $pre_doc_aval; ?>" maxlength="100" size="35" autocomplete="off" class="required alphanum" title="Documento de Aval que deja el Solicitante como Garant&iacute;a de Pr&eacute;stamo"/></td>
        </tr>
        <tr>
            <td>Motivo:</td>
            <td colspan="3"><textarea name="pre_justificacion" cols="92" rows="3" class="required alphanum" id="pre_justificacion" maxlength="500" title="Motivo o justificaci&oacute;n del pr&eacute;stamo" type="text"><?php echo $pre_justificacion; ?></textarea></td>
        </tr>
        <tr>
            <td  >Fecha Pr&eacute;stamo:</td>
            <td width="163"><input name="pre_fecha_pres" type="text" id="pre_fecha_pres" value="<?php echo $pre_fecha_pres; ?>" size="15" autocomplete="off" class="required" title="Fecha desde la que se presta el expediente"/></td>
            <td width="200">Fecha Devoluci&oacute;n:</td>
            <td width="348"><input name="pre_fecha_dev" type="text" id="pre_fecha_dev" value="<?php echo $pre_fecha_dev; ?>" size="15" autocomplete="off" class="required" title="Fecha de devoluci�n del expediente"/></td>
        </tr>
        <tr>
            <td class="botones" colspan="4"><input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />    </td>
        </tr>
    </table>
    <input name="pre_tipo" type="hidden" id="pre_tipo" value="1" />
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/prestamos/";
        });
    });
    $(function() {
        $('#pre_fecha_pres').change(function(){
            if($('#pre_fecha_dev').val()<$('#pre_fecha_pres').val()){
                alert("La fecha de devolucion debe ser posterior a la de prestamo");
                $('#pre_fecha_dev').val($('#pre_fecha_pres').val());
            }
        });
        $('#pre_fecha_dev').change(function(){
            if($('#pre_fecha_dev').val()<$('#pre_fecha_pres').val()){
                alert("La fecha de devolucion debe ser posterior a la de prestamo");
                $('#pre_fecha_dev').val($('#pre_fecha_pres').val());
            }
        });
        $('#pre_fecha_pres').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: 'c:c+5',
            dateFormat: 'yy-mm-dd',
            minDate: '<?php echo $hoy ?>',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        $('#pre_fecha_dev').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c:c+5',
            dateFormat: 'yy-mm-dd',
            minDate: $('#pre_fecha_pres').val(),//'+10D',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr','May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        });
    });
</script>