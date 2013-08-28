<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/backup/<?php echo $PATH_EVENT ?>/">
    <input name="bac_id" id="bac_id" type="hidden" value="<?php echo $bac_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>accion:</td>
            <td><input name="bac_accion" type="text" id="bac_accion" value="<?php echo $bac_accion; ?>" size="35" autocomplete="off" class="required" title="bac_accion"/></td>
            <td>file:</td>
            <td><input name="bac_file" type="text" id="bac_file" value="<?php echo $bac_file; ?>" size="35" autocomplete="off" class="required" title="bac_file"/></td>
        </tr>
        <tr>
            <td>size:</td>
            <td><input name="bac_size" type="text" id="bac_size" value="<?php echo $bac_size; ?>" size="35" autocomplete="off" class="required" title="bac_size"/></td>
            <td>fecha_crea:</td>
            <td><input name="bac_fecha_crea" type="text" id="bac_fecha_crea" value="<?php echo $bac_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="bac_fecha_crea"/></td>
        </tr>
        <tr>
            <td>usuario:</td>
            <td><input name="bac_usuario" type="text" id="bac_usuario" value="<?php echo $bac_usuario; ?>" size="35" autocomplete="off" class="required" title="bac_usuario"/></td>
            <td>estado:</td>
            <td><input name="bac_estado" type="text" id="bac_estado" value="<?php echo $bac_estado; ?>" size="35" autocomplete="off" class="required" title="bac_estado"/></td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
            <td colspan="4">&nbsp;</td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/backup/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>