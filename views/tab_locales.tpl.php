<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/locales/<?php echo $PATH_EVENT ?>/">
    <input name="loc_id" id="loc_id" type="hidden" value="<?php echo $loc_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>descripcion:</td>
            <td><input name="loc_descripcion" type="text" id="loc_descripcion" value="<?php echo $loc_descripcion; ?>" size="35" autocomplete="off" class="required" title="loc_descripcion"/></td>
            <td>usu_reg:</td>
            <td><input name="loc_usu_reg" type="text" id="loc_usu_reg" value="<?php echo $loc_usu_reg; ?>" size="35" autocomplete="off" class="required" title="loc_usu_reg"/></td>
        </tr>
        <tr>
            <td>usu_mod:</td>
            <td><input name="loc_usu_mod" type="text" id="loc_usu_mod" value="<?php echo $loc_usu_mod; ?>" size="35" autocomplete="off" class="required" title="loc_usu_mod"/></td>
            <td>fecha_reg:</td>
            <td><input name="loc_fecha_reg" type="text" id="loc_fecha_reg" value="<?php echo $loc_fecha_reg; ?>" size="35" autocomplete="off" class="required" title="loc_fecha_reg"/></td>
        </tr>
        <tr>
            <td>fecha_mod:</td>
            <td><input name="loc_fecha_mod" type="text" id="loc_fecha_mod" value="<?php echo $loc_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="loc_fecha_mod"/></td>
            <td>estado:</td>
            <td><input name="loc_estado" type="text" id="loc_estado" value="<?php echo $loc_estado; ?>" size="35" autocomplete="off" class="required" title="loc_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/locales/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>