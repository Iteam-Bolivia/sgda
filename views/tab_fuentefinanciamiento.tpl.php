<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/fuentefinanciamiento/<?php echo $PATH_EVENT ?>/">
    <input name="ff_id" id="ff_id" type="hidden"
           value="<?php echo $ff_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="125">C&oacute;digo:</td>
            <td width="200"><input name="ff_codigo" type="text" id="ff_codigo"
                                   value="<?php echo $ff_codigo; ?>" size="35" autocomplete="off"
                                   class="required alpha" maxlength="5" title="Codigo" /></td>
        </tr>
        <tr>
            <td width="125">Fuente Financiamiento:</td>
            <td width="200"><input name="ff_descripcion" type="text" id="ff_descripcion"
                                   value="<?php echo $ff_descripcion; ?>" class="required alpha" maxlength="255"
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
            window.location="<?php echo $PATH_DOMAIN ?>/fuentefinanciamiento/";
        });
    });
    $(function() {	
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });		
    });
</script>