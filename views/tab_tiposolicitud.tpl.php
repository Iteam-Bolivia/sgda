<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tiposolicitud/<?php echo $PATH_EVENT ?>/">
    <input name="sol_id" id="sol_id" type="hidden"
           value="<?php echo $sol_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="125">C&oacute;digo:</td>
            <td width="200"><input name="sol_codigo" type="text" id="sol_codigo"
                                   value="<?php echo $sol_codigo; ?>" size="35" autocomplete="off"
                                   class="required alpha" maxlength="5" title="Codigo" /></td>
        </tr>
        <tr>
            <td width="125">Tipo de Solicitud:</td>
            <td width="200"><input name="sol_descripcion" type="text" id="sol_descripcion"
                                   value="<?php echo $sol_descripcion; ?>" class="required alpha" maxlength="255"
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
            window.location="<?php echo $PATH_DOMAIN ?>/tiposolicitud/";
        });
    });
    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });
    });
</script>