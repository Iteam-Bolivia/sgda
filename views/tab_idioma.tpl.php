<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/idioma/<?php echo $PATH_EVENT ?>/">
        <input name="idi_id" type="hidden" id="idi_id" value="<?php echo $idi_id; ?>" />
        <input name="path_event" id="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />
    
     <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanumeric"
                       id="idi_codigo"
                        maxlength="8"
                       name="idi_codigo" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" 
                       type="text" 
                       title="código" 
                       value="<?php echo $idi_codigo; ?>"
                       />
            <span class="error-requerid">*</span>
            </td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input class="required alphanum"
                       id="idi_nombre"
                       maxlength="128"
                       name="idi_nombre" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" 
                       type="text" 
                       title="nombre"
                       value="<?php echo $idi_nombre; ?>" 
                       />
            <span class="error-requerid">*</span>
            </td>
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
            window.location="<?php echo $PATH_DOMAIN ?>/idioma/";
        });
        
    });

</script>