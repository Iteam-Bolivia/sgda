<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipoarch/<?php echo $PATH_EVENT ?>/">
    <input name="tar_id" id="tar_id" type="hidden"
           value="<?php echo $tar_id; ?>" />
    <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Codigo:</td>
            <td><input autocomplete="off"
                       class="required alphanumeric"
                       id="tar_codigo" 
                       maxlength="8"
                       name="tar_codigo"
                       size="35"
                       type="text" 
                       title="Codigo" 
                       value="<?php echo $tar_codigo; ?>"
                       /></td>
        </tr>

        <tr>
            <td>Nombre:</td>
            <td><input autocomplete="off" 
                       class="required alphanumeric"
                       id="tar_nombre"
                       maxlength="256" 
                       name="tar_nombre"
                       size="75" 
                       title="Nombre"
                       type="text"
                       value="<?php echo $tar_nombre; ?>" 
                       /></td>
        </tr>


        <tr>
            <td>Orden:</td>
            <td><input name="tar_orden" 
                       type="text" 
                       id="tar_orden" 
                       value="<?php echo $tar_orden; ?>" 
                       size="75"
                       autocomplete="off"
                       class="required alphanumeric"
                       maxlength="3" 
                       title="Nombre" 
                       /></td>
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
        /**********/
        // Submit
        /**********/
        $("#btnSub").click(function(){
            if($("#tar_rol_id").val()=="" || $("#uni_id").val()==0){
                $('form#formA').submit();
                $('form#formA')[0].reset()
            }
        });

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/tipoarch/";
        });

    });


    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });        
    });
    
</script>