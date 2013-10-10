<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/institucion/<?php echo $PATH_EVENT ?>/">
    <input name="int_id" id="int_id" type="hidden" value="<?php echo $int_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
            <td width="19%">Instituci&oacute;n:</td>
            <td width="81%"><input name="int_descripcion" type="text" id="int_descripcion" 
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   value="<?php echo $int_descripcion; ?>" size="35" maxlength="25" autocomplete="off" class="required" title="Instituci&oacute;n"/></td>
        </tr>
        <tr>
            <td colspan="2" class="botones" ><input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/institucion/";
        });
    });
</script>

