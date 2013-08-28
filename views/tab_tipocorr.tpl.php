<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipocorr/<?php echo $PATH_EVENT ?>/">
    <input name="tco_id" type="hidden" id="tco_id" value="<?php echo $tco_id; ?>" />
    <input name="path_event" id="path_event" type="hidden" alue="<?php echo $PATH_EVENT; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanum"
                       id="tco_codigo"
                       maxlength="8"
                       name="tco_codigo"
                       size="20"
                       type="text"
                       title="código"
                       value="<?php echo $tco_codigo; ?>"
                        /></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input class="required alphanum"
                       id="tco_nombre" 
                       maxlength="64"
                       name="tco_nombre"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" 
                       title="nombre"
                       type="text" 
                       value="<?php echo $tco_nombre; ?>"
                       /></td>
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
            window.location="<?php echo $PATH_DOMAIN ?>/tipocorr/";
        });
    });

</script>