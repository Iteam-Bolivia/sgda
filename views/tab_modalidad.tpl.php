<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/modalidad/<?php echo $PATH_EVENT ?>/">
    <input name="mod_id" id="mod_id" type="hidden"
           value="<?php echo $mod_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="125">C&oacute;digo:</td>
            <td width="200"><input name="mod_codigo" type="text" id="mod_codigo"
                                   value="<?php echo $mod_codigo; ?>" size="35" autocomplete="off"
                                   class="required alpha" maxlength="5" title="Codigo" /></td>
        </tr>
        <tr>
            <td width="125">Modalidad:</td>
            <td width="200"><input name="mod_descripcion" type="text" id="mod_descripcion"
                                   value="<?php echo $mod_descripcion; ?>" class="required alpha" maxlength="255"
                                   size="100" autocomplete="off" title="Fuente de Financiamiento" /></td>
        </tr>
        <tr>
            <td colspan="4" class="botones"> <input
                    id="btnSub" type="submit" value="Guardar" class="button" /> <input
                    name="cancelar" id="cancelar" type="button" class="button"
                    value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/modalidad/";
        });
    });
    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });
    });
</script>