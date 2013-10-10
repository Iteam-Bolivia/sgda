<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/localidad/<?php echo $PATH_EVENT ?>/">
    <input name="loc_id" type="hidden" id="loc_id" value="<?php echo $loc_id; ?>" />
    <input name="pro_id" id="pro_id" type="hidden" value="<?php echo $pro_id; ?>" />
    <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr><td>Provincia:</td><td colspan=3><?php echo $nom_pro2; ?></td></tr>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanum"
                       id="loc_codigo"
                       maxlength="64"
                       name="loc_codigo"
                       onkeyup="this.value=this.value.toUpperCase()"
                       title="código"
                       type="text"
                       size="60"
                       value="<?php echo $loc_codigo; ?>"
                        
                       
                       
                       
                       /></td>
        </tr>

        <tr>
            <td>Nombre Ciudad:</td>
            <td><input id="loc_nombre"
                       class="required alphanum"
                       maxlength="126"
                       name="loc_nombre"
                       onkeyup="this.value=this.value.toUpperCase()"
                       type="text"
                       title="nombre" 
                       size="60"
                       value="<?php echo $loc_nombre; ?>"  
                       /></td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />                
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            id = $("#pro_id").val();
            window.location ="<?php echo $PATH_DOMAIN ?>/localidad/index/"+id+"/";
            //window.location="<?php //echo $PATH_DOMAIN   ?>/provincia/";
            //window.history.back();
        });

         $('#loc_codigo').change(function(){
            
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/localidad/verifCodigo/',
                    type: 'POST',
                    data: 'Loc_codigo='+$(this).val()+ '&Loc_id='+$('#loc_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#loc_codigo').val('');
                            $('#loc_codigo').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
    });

</script>