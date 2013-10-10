<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/version/<?php echo $PATH_EVENT ?>/">

    <input name="ver_id" id="ver_id" type="hidden" value="<?php echo $ver_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>fecha_ini:</td>
            <td><input name="ver_fecha_ini" type="text" id="ver_fecha_ini" value="<?php echo $ver_fecha_ini; ?>" size="35" autocomplete="off" class="required" title="ver_fecha_ini"/></td>
            <td>fecha_fin:</td>
            <td><input name="ver_fecha_fin" type="text" id="ver_fecha_fin" value="<?php echo $ver_fecha_fin; ?>" size="35" autocomplete="off" class="required" title="ver_fecha_fin"/></td>
        </tr>
        <tr>
            <td>paso:</td>
            <td><input name="ver_paso" type="text" id="ver_paso" value="<?php echo $ver_paso; ?>" size="35" autocomplete="off" class="required" title="ver_paso"/></td>
            <td width="125">usu_id:</td>
            <td width="200">
                <select name="usu_id" id="usu_id" class="required" style="width:190px">
                    <option value="">-Seleccionar-</option>
                    <?php echo $usu_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="ver_fecha_crea" type="text" id="ver_fecha_crea" value="<?php echo $ver_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="ver_fecha_crea"/></td>
            <td>estado:</td>
            <td><input name="ver_estado" type="text" id="ver_estado" value="<?php echo $ver_estado; ?>" size="35" autocomplete="off" class="required" title="ver_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/version/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>