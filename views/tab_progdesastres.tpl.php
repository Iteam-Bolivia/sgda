<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/progdesastres/<?php echo $PATH_EVENT ?>/">
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
    <input name="des_id" id="des_id" type="hidden" value="<?php echo $des_id; ?>" />
    <table width="684" border="1">
        <caption class="titulo">Registro de Programa de desastres</caption>
        <tr>
            <td width="61">Indicador:</td>
            <td colspan="2"><input name="des_indicador" type="text" id="des_indicador" value="<?php echo $des_indicador; ?>" size="100" autocomplete="off" class="required" title="des_indicador"/></td>
        </tr>
        <tr>
            <td>Resumen:</td>
            <td colspan="2"><input name="des_resumen" type="text" id="des_resumen" value="<?php echo $des_resumen; ?>" size="150" autocomplete="off" class="required" title="des_resumen"/></td>
        </tr>
        <tr>
            <td>Riesgo:</td>
            <td colspan="2"><input name="des_riesgo" type="text" id="des_riesgo" value="<?php echo $des_riesgo; ?>" size="100" autocomplete="off" class="required" title="des_riesgo"/></td>
        </tr>
        <tr>
            <td  >Fuentes:</td>
            <td colspan="2"><input name="des_fuentes" type="text" id="des_fuentes" value="<?php echo $des_fuentes; ?>" size="100" autocomplete="off" class="required" title="des_fuentes"/></td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            if($("#formA").is(":visible")){
                $("#formA").hide();
                //$(".flexigrid").attr('class','flexigrid');
                window.location="<?php echo $PATH_DOMAIN ?>/progdesastres/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>