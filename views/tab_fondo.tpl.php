<div class="clear"></div>
<form class="validable" id="formA" name="formA" method="post"
      action="<?php echo $PATH_DOMAIN ?>/fondo/<?php echo $PATH_EVENT ?>/">

    <input name="fon_id" id="fon_id" type="hidden" value="<?php echo $fon_id; ?>" />
    <input name="fon_cod" id="fon_cod" type="hidden" value="<?php echo $fon_cod; ?>" />
    <input name="path_event" id="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="fon_codigo" type="text" id="fon_codigo"
                       value="<?php echo $fon_codigo; ?>" size="15" autocomplete="off"
                       onkeyup="this.value=this.value.toUpperCase()"
                       class="required alphanumeric" maxlength="8" title="Código de Fondo" />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Fondo o Subfondo:</td>
            <td><input name="fon_descripcion" type="text" id="fon_descripcion"
                       value="<?php echo $fon_descripcion; ?>" size="75" autocomplete="off"
                       onkeyup="this.value=this.value.toUpperCase()"
                       class="required alphanum" maxlength="100" title="Nombre" />
            <span class="error-requerid">*</span>
            </td>
            <td>    </td>
            <td><input name="fon_cod" type="hidden" id="fon_cod"
                       value="<?php echo $fon_cod; ?>" size="15" autocomplete="off" readonly
                       class="alphanum" maxlength="16" title="Codigo" /></td>
        </tr>

        <tr>
            <td>Subfondo de:</td>
            <td><select name="fon_par" id="fon_par"
                        title="Fondo del que depende">
                    <option value="">(seleccionar)</option>
                    <?php echo $fon_par; ?>
                </select></td>
        </tr>

        <tr>
            <td>Contador:</td>
            <td><input name="fon_contador" type="text" id="fon_contador"
                       value="<?php echo $fon_contador; ?>" size="15" autocomplete="off"
                       class="required onlynumeric" maxlength="3" title="Nombre" /></td>
        </tr>
        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
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
            if($("#fon_rol_id").val()=="" || $("#uni_id").val()==0){
                $('form#formA').submit();
                $('form#formA')[0].reset();

            }
        });

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/fondo/";
        });

    });


    $(function() {
        $("#fon_par").change(function(){
            if ($("#fon_par").val()!="0")
            {
                if($("#fon_par").val()=="0"){
                    $("#fon_cod").val("");
                }else{
                    $.ajax({
                        url: '<?php echo $PATH_DOMAIN ?>/fondo/obtenerCodigoFondoAjax/',
                        type: 'POST',
                        data: 'Fon_par='+$("#fon_par").val(),
                        dataType:  		"json",
                        success: function(datos){
                            if(datos){
                                $("#fon_cod").val(datos.fon_cod);
                            }
                        }
                    });

                }
            }
        });
    });


</script>