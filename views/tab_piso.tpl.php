<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/ubicacion/<?php echo $PATH_EVENT ?>/">
    <input name="ubi_id" id="ubi_id" type="hidden" value="<?php echo $ubi_id; ?>" />
    <input name="ubi_par" id="ubi_par" type="hidden" value="<?php echo $ubi_par; ?>" />
    <input name="loc_id" id="ubi_par" type="hidden" value="<?php echo $loc_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo_ubi; ?></caption>
        <tr><td>Edificio:</td><td colspan=3><?php echo $ubi_par2; ?></td></tr>
        <tr>
            <td>Piso:</td>
            <td colspan=2>
                <input name="ubi_codigo" type="text" id="ubi_codigo" value="<?php echo $ubi_codigo; ?>"
                       size="35" autocomplete="off" class="required alphanum" maxlength="8"
                       onkeyup="this.value=this.value.toUpperCase()"
                       title="C&oacute;digo o abreviaci&oacute;n de Piso"/></td>
        </tr>
        <tr>
            <td>Descripci&oacute;n:</td>
            <td><input name="ubi_descripcion" type="text" id="ubi_descripcion" value="<?php echo $ubi_descripcion; ?>"
                       size="50" autocomplete="off" class="required alphanum" maxlength="50"
                       onkeyup="this.value=this.value.toUpperCase()"
                       title="Descripci&oacute;n"/></td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.history.back();
        });
    });

</script>