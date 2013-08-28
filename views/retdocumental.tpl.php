<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/retdocumental/<?php echo $PATH_EVENT ?>/">

    <input name="ret_id" id="ret_id" type="hidden" value="<?php echo $ret_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>par:</td>
            <td><input name="ret_par" type="text" id="ret_par" value="<?php echo $ret_par; ?>" size="35" autocomplete="off" class="required" title="ret_par"/></td>
            <td>lugar:</td>
            <td><input name="ret_lugar" type="text" id="ret_lugar" value="<?php echo $ret_lugar; ?>" size="35" autocomplete="off" class="required" title="ret_lugar"/></td>
        </tr>
        <tr>
            <td>anios:</td>
            <td><input name="ret_anios" type="text" id="ret_anios" value="<?php echo $ret_anios; ?>" size="35" autocomplete="off" class="required" title="ret_anios"/></td>
            <td>usuario_crea:</td>
            <td><input name="ret_usuario_crea" type="text" id="ret_usuario_crea" value="<?php echo $ret_usuario_crea; ?>" size="35" autocomplete="off" class="required" title="ret_usuario_crea"/></td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="ret_fecha_crea" type="text" id="ret_fecha_crea" value="<?php echo $ret_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="ret_fecha_crea"/></td>
            <td>fecha_mod:</td>
            <td><input name="ret_fecha_mod" type="text" id="ret_fecha_mod" value="<?php echo $ret_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="ret_fecha_mod"/></td>
        </tr>
        <tr>
            <td>usu_mod:</td>
            <td><input name="ret_usu_mod" type="text" id="ret_usu_mod" value="<?php echo $ret_usu_mod; ?>" size="35" autocomplete="off" class="required" title="ret_usu_mod"/></td>
            <td>estado:</td>
            <td><input name="ret_estado" type="text" id="ret_estado" value="<?php echo $ret_estado; ?>" size="35" autocomplete="off" class="required" title="ret_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/retdocumental/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>