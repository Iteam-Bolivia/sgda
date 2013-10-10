<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/expusuario/<?php echo $PATH_EVENT ?>/">
    <input name="eus_id" id="eus_id" type="hidden" value="<?php echo $eus_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">usu_id:</td>
            <td width="200">
                <select name="usu_id" id="usu_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $usu_id; ?>
                </select>
            </td>
            <td width="125">exp_id:</td>
            <td width="200">
                <select name="exp_id" id="exp_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="eus_fecha_crea" type="text" id="eus_fecha_crea" value="<?php echo $eus_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="eus_fecha_crea"/></td>
            <td>estado:</td>
            <td><input name="eus_estado" type="text" id="eus_estado" value="<?php echo $eus_estado; ?>" size="35" autocomplete="off" class="required" title="eus_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/expusuario/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>