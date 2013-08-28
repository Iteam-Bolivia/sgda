<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/estrucDocumental/<?php echo $PATH_EVENT ?>/">

    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">ser_id:</td>
            <td width="200">
                <select name="ser_id" id="ser_id" class="required" style="width:190px">
                    <option value="">-Seleccionar-</option>
                    <?php echo $ser_id; ?>
                </select>
            </td>
            <td>nombre:</td>
            <td><input name="exp_nombre" type="text" id="exp_nombre" value="<?php echo $exp_nombre; ?>" size="35" autocomplete="off" class="required" title="exp_nombre"/></td>
        </tr>
        <tr>
            <td>descripcion:</td>
            <td><input name="exp_descripcion" type="text" id="exp_descripcion" value="<?php echo $exp_descripcion; ?>" size="35" autocomplete="off" class="required" title="exp_descripcion"/></td>
            <td>codigo:</td>
            <td><input name="exp_codigo" type="text" id="exp_codigo" value="<?php echo $exp_codigo; ?>" size="35" autocomplete="off" class="required" title="exp_codigo"/></td>
        </tr>
        <tr>
            <td>fecha_exi:</td>
            <td><input name="exp_fecha_exi" type="text" id="exp_fecha_exi" value="<?php echo $exp_fecha_exi; ?>" size="35" autocomplete="off" class="required" title="exp_fecha_exi"/></td>
            <td>fecha_exf:</td>
            <td><input name="exp_fecha_exf" type="text" id="exp_fecha_exf" value="<?php echo $exp_fecha_exf; ?>" size="35" autocomplete="off" class="required" title="exp_fecha_exf"/></td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="exp_fecha_crea" type="text" id="exp_fecha_crea" value="<?php echo $exp_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="exp_fecha_crea"/></td>
            <td>estado:</td>
            <td><input name="exp_estado" type="text" id="exp_estado" value="<?php echo $exp_estado; ?>" size="35" autocomplete="off" class="required" title="exp_estado"/></td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            if($("#formA").is(":visible")){
                $("#formA").hide();
                //$(".flexigrid").attr('class','flexigrid');
                window.location="<?php echo $PATH_DOMAIN ?>/estrucDocumental/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>