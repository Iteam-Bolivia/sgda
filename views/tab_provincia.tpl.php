<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/provincia/<?php echo $PATH_EVENT ?>/">
    <input name="pro_id" type="hidden" id="pro_id" value="<?php echo $pro_id; ?>" />
    <input name="dep_id" id="dep_id" type="hidden" value="<?php echo $dep_id; ?>" />
    <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
            <td>Departamento:</td>
            <td colspan=3><?php echo $nom_dep2; ?></td>
        </tr>
        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanum"
                       id="pro_codigo"
                       maxlength="64"
                       name="pro_codigo"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60"
                       title="Código"
                       type="text"
                       value="<?php echo $pro_codigo; ?>"
                       /></td>
        </tr>
        <tr>
            <td>Nombre Provincia:</td>
            <td><input class="required alphanum"
                       id="pro_nombre"
                       name="pro_nombre" 
                       maxlength="126"
                       onkeyup="this.value=this.value.toUpperCase()" 
                       size="60" 
                       type="text"
                       title="nombre" 
                       value="<?php echo $pro_nombre; ?>"
                       /></td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar"id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            id = $("#dep_id").val();
            window.location ="<?php echo $PATH_DOMAIN ?>/provincia/index/"+id+"/";
            //window.location="<?php //echo $PATH_DOMAIN      ?>/provincia/";
            //window.history.back();
        });
        $('#pro_codigo').change(function(){
            
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/provincia/verifCodigo/',
                    type: 'POST',
                    data: 'Pro_codigo='+$(this).val()+ '&Pro_id='+$('#pro_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#pro_codigo').val('');
                            $('#pro_codigo').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
        
    });

</script>