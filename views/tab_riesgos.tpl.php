<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/riesgos/<?php echo $PATH_EVENT ?>/">
    <input name="rie_id" id="rie_id" type="hidden" value="<?php echo $rie_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>descripcion:</td>
            <td><input name="rie_descripcion" type="text" id="rie_descripcion" value="<?php echo $rie_descripcion; ?>" size="35" autocomplete="off" class="required" title="rie_descripcion"/></td>
            <td>tipo:</td>
            <td><input name="rie_tipo" type="text" id="rie_tipo" value="<?php echo $rie_tipo; ?>" size="35" autocomplete="off" class="required" title="rie_tipo"/></td>
        </tr>
        <tr>
            <td>usu_reg:</td>
            <td><input name="rie_usu_reg" type="text" id="rie_usu_reg" value="<?php echo $rie_usu_reg; ?>" size="35" autocomplete="off" class="required" title="rie_usu_reg"/></td>
            <td>usu_mod:</td>
            <td><input name="rie_usu_mod" type="text" id="rie_usu_mod" value="<?php echo $rie_usu_mod; ?>" size="35" autocomplete="off" class="required" title="rie_usu_mod"/></td>
        </tr>
        <tr>
            <td>fecha_reg:</td>
            <td><input name="rie_fecha_reg" type="text" id="rie_fecha_reg" value="<?php echo $rie_fecha_reg; ?>" size="35" autocomplete="off" class="required" title="rie_fecha_reg"/></td>
            <td>fecha_mod:</td>
            <td><input name="rie_fecha_mod" type="text" id="rie_fecha_mod" value="<?php echo $rie_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="rie_fecha_mod"/></td>
        </tr>
        <tr>
            <td>estado:</td>
            <td><input name="rie_estado" type="text" id="rie_estado" value="<?php echo $rie_estado; ?>" size="35" autocomplete="off" class="required" title="rie_estado"/></td>
            <td></td>
            <td></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/riesgos/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>