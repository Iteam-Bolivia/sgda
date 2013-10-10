<div class="clear"></div>
<!--Modoficado por coco-->
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipocontenedor/<?php echo $PATH_EVENT ?>/">
    <input name="ctp_id" type="hidden" id="ctp_id" value="<?php echo $ctp_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="88">C&oacute;digo:</td>
            <td width="395"><input  autocomplete="off"
                                    class="required alphanumeric"
                                    id="ctp_codigo" 
                                    maxlength="15" 
                                    name="ctp_codigo"
                                    size="8" 
                                    type="text" 
                                    title="Abreviaci&oacute;n"
                                    value="<?php echo $ctp_codigo; ?>"
                                    />
                <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td width="88">Descripci&oacute;n:</td>
            <td width="395"><input autocomplete="off" 
                                   class="required alphanumeric"
                                   id="ctp_descripcion"
                                   maxlength="100"
                                   name="ctp_descripcion" 
                                   size="100" 
                                   type="text"
                                   title="Abreviaci&oacute;n"
                                   value="<?php echo $ctp_descripcion; ?>"
                                   />
            <span class="error-requerid">*</span>
            </td>
        </tr>        

        <tr>
            <td width="126">Nivel:</td>
            <td colspan="3">
                <select name="ctp_nivel" id="ctp_nivel" class="" title="Nivel del contenedor (Contenedor, Subcontenedor)">
                    <option value="">(seleccionar)</option>
                    <?php echo $ctp_nivel; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="botones"><input id="btnSub" type="submit"
                                                   value="Guardar" class="button" /> <input name="cancelar"
                                                   id="cancelar" type="button" class="button" value="Cancelar" />

        </tr>

    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/tipocontenedor/";
        });
        /*$('#ctp_codigo').change(function(){
                if($(this).val()!=''){
                        $.ajax({
                                   url: '<?php echo $PATH_DOMAIN ?>/tipocontenedor/verifCodigo/',
                                   type: 'POST',
                                   data: 'codigo='+$(this).val()+ '&ctp_id='+$('#ctp_id').val(),
                                   dataType:  		"text",
                                   success: function(datos){
                        if(datos!=''){
                                                        $('#ctp_codigo').val('');
                                                        $('#ctp_codigo').focus();
                            alert(datos);
                        }
                                   }
                          });
                }
        });*/
    });
</script>