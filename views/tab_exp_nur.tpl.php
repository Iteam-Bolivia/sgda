<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/departamento/<?php echo $PATH_EVENT ?>/"><input
        name="dep_id" type="hidden" id="dep_id" value="<?php echo $dep_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="dep_codigo" type="text" maxlength="300"
                       id="dep_codigo" value="<?php echo $dep_codigo; ?>"
                       size="60" class="required alphanum"
                       title="código" /></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input name="dep_nombre" type="text" maxlength="300"
                       id="dep_nombre" value="<?php echo $dep_nombre; ?>"
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
            window.location="<?php echo $PATH_DOMAIN ?>/departamento/";
        });

        $("#dep_codigo").blur(function(){
            if($("#dep_codigo").val()!=""){
                var exp_reg=/^[1-9]{1}$/;
                if(!$("#dep_codigo").val().match(exp_reg)){
                    alert("Digite un numero del 1 al 9");
                    $("#dep_codigo").val("");
                    $("#dep_codigo").focus();
                }
            }
        });

    });

</script>