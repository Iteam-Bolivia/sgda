<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/oficina/<?php echo $PATH_EVENT ?>/">
    <input name="ofi_id" type="hidden" id="ofi_id" value="<?php echo $ofi_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="88">C&oacute;digo:</td>
            <td width="395"><input name="ofi_cod" id="ofi_cod" type="text"
                                   maxlength="5" size="8" autocomplete="off"
                                   class="required alphanumeric" title="Código"
                                   value="<?php echo $ofi_cod; ?>" /></td>
        </tr>

        <tr>
            <td width="88">Nombre:</td>
            <td width="395"><input name="ofi_nombre" id="ofi_nombre" type="text"
                                   maxlength="5" size="8" autocomplete="off"
                                   class="required alphanumeric" title="Nombre"
                                   value="<?php echo $ofi_nombre; ?>" /></td>
        </tr>

        <tr>
            <td width="88">Contador:</td>
            <td width="395"><input name="ofi_contador" id="ofi_contador" type="text"
                                   maxlength="5" size="8" autocomplete="off"
                                   class="required alphanumeric" title="Contador"
                                   value="<?php echo $ofi_contador; ?>" /></td>
        </tr>

        
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
        </tr>
        
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/oficina/";
        });
    });
</script>