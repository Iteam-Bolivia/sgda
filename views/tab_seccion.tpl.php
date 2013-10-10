
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/seccion/<?php echo $PATH_EVENT ?>/"><input
        name="sec_id" type="hidden" id="sec_id" value="<?php echo $sec_id; ?>" />


    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Unidad:</td>
            <td><select name="uni_id" id="uni_id">
                    <option value="">(Seleccionar)</option>
                    <?php echo $uni_id; ?>
                </select>

            </td>
        </tr>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="sec_codigo" type="text" maxlength="8"
                       id="sec_codigo" value="<?php echo $sec_codigo; ?>"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" class="required alphanum"
                       title="código" /></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input name="sec_nombre" type="text" maxlength="300"
                       id="sec_nombre" value="<?php echo $sec_nombre; ?>"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" class="required alphanum"
                       title="nombre" /></td>
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
            window.location="<?php echo $PATH_DOMAIN ?>/seccion/";
        });

        //        $("#sec_codigo").blur(function(){
        //            if($("#sec_codigo").val()!=""){
        //            var exp_reg=/^[1-9]{1}$/;
        //            if(!$("#sec_codigo").val().match(exp_reg)){
        //                alert("Digite un numero del 1 al 9");
        //                $("#sec_codigo").val("");
        //                $("#sec_codigo").focus();
        //            }
        //            }
        //        });

    });

</script>
