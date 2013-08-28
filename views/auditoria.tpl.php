
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/auditoria/<?php echo $PATH_EVENT ?>/">

    <input name="aud_id" id="aud_id" type="hidden" value="<?php echo $aud_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>tabla:</td>
            <td><input name="aud_tabla" type="text" id="aud_tabla" value="<?php echo $aud_tabla; ?>" size="35" autocomplete="off" class="required" title="aud_tabla"/></td>
            <td>usuario_mod:</td>
            <td><input name="aud_usuario_mod" type="text" id="aud_usuario_mod" value="<?php echo $aud_usuario_mod; ?>" size="35" autocomplete="off" class="required" title="aud_usuario_mod"/></td>
        </tr>
        <tr>
            <td>fecha_mod:</td>
            <td><input name="aud_fecha_mod" type="text" id="aud_fecha_mod" value="<?php echo $aud_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="aud_fecha_mod"/></td>
            <td>hora_mod:</td>
            <td><input name="aud_hora_mod" type="text" id="aud_hora_mod" value="<?php echo $aud_hora_mod; ?>" size="35" autocomplete="off" class="required" title="aud_hora_mod"/></td>
        </tr>
        <tr>
            <td>accion:</td>
            <td><input name="aud_accion" type="text" id="aud_accion" value="<?php echo $aud_accion; ?>" size="35" autocomplete="off" class="required" title="aud_accion"/></td>
            <td>estado:</td>
            <td><input name="aud_estado" type="text" id="aud_estado" value="<?php echo $aud_estado; ?>" size="35" autocomplete="off" class="required" title="aud_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/auditoria/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>
