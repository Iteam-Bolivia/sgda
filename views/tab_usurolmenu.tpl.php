<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/usurolmenu/<?php echo $PATH_EVENT ?>/">

    <input name="urm_id" id="urm_id" type="hidden" value="<?php echo $urm_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">usu_id:</td>
            <td width="200">
                <select name="usu_id" id="usu_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $usu_id; ?>
                </select>
            </td>
            <td width="125">rol_id:</td>
            <td width="200">
                <select name="rol_id" id="rol_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $rol_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">men_id:</td>
            <td width="200">
                <select name="men_id" id="men_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $men_id; ?>
                </select>
            </td>
            <td>privilegios:</td>
            <td><input name="urm_privilegios" type="text" id="urm_privilegios" value="<?php echo $urm_privilegios; ?>" size="35" autocomplete="off" class="required" title="urm_privilegios"/></td>
        </tr>
        <tr>
            <td>fecha_reg:</td>
            <td><input name="urm_fecha_reg" type="text" id="urm_fecha_reg" value="<?php echo $urm_fecha_reg; ?>" size="35" autocomplete="off" class="required" title="urm_fecha_reg"/></td>
            <td>usu_reg:</td>
            <td><input name="urm_usu_reg" type="text" id="urm_usu_reg" value="<?php echo $urm_usu_reg; ?>" size="35" autocomplete="off" class="required" title="urm_usu_reg"/></td>
        </tr>
        <tr>
            <td>fecha_mod:</td>
            <td><input name="urm_fecha_mod" type="text" id="urm_fecha_mod" value="<?php echo $urm_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="urm_fecha_mod"/></td>
            <td>usu_mod:</td>
            <td><input name="urm_usu_mod" type="text" id="urm_usu_mod" value="<?php echo $urm_usu_mod; ?>" size="35" autocomplete="off" class="required" title="urm_usu_mod"/></td>
        </tr>
        <tr>
            <td>estado:</td>
            <td><input name="urm_estado" type="text" id="urm_estado" value="<?php echo $urm_estado; ?>" size="35" autocomplete="off" class="required" title="urm_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/usurolmenu/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>