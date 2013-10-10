<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipodoc/<?php echo $PATH_EVENT ?>/"><input
        name="tdo_id" type="hidden" id="tdo_id" value="<?php echo $tdo_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="tdo_codigo" type="text" maxlength="300"
                       id="tdo_codigo" value="<?php echo $tdo_codigo; ?>"
                       size="60" class="required alphanum"
                       title="código" /></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input name="tdo_nombre" type="text" maxlength="300"
                       id="tdo_nombre" value="<?php echo $tdo_nombre; ?>"
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
            window.location="<?php echo $PATH_DOMAIN ?>/tipodoc/";
        });

        //        $("#tdo_codigo").blur(function(){
        //            if($("#tdo_codigo").val()!=""){
        //            var exp_reg=/^[1-9]{1}$/;
        //            if(!$("#tdo_codigo").val().match(exp_reg)){
        //                alert("Digite un numero del 1 al 9");
        //                $("#tdo_codigo").val("");
        //                $("#tdo_codigo").focus();
        //            }
        //            }
        //        });

    });

</script>