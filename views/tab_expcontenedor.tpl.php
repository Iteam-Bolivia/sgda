<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/expcontenedor/<?php echo $PATH_EVENT ?>/">
    <input name="exc_id" id="exc_id" type="hidden" value="<?php echo $exc_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">euv_id:</td>
            <td width="200">
                <select name="euv_id" id="euv_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $euv_id; ?>
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
            <td width="125">con_id:</td>
            <td width="200">
                <select name="con_id" id="con_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $con_id; ?>
                </select>
            </td>
            <td>fecha_reg:</td>
            <td><input name="exc_fecha_reg" type="text" id="exc_fecha_reg" value="<?php echo $exc_fecha_reg; ?>" size="35" autocomplete="off" class="required" title="exc_fecha_reg"/></td>
        </tr>
        <tr>
            <td>usu_reg:</td>
            <td><input name="exc_usu_reg" type="text" id="exc_usu_reg" value="<?php echo $exc_usu_reg; ?>" size="35" autocomplete="off" class="required" title="exc_usu_reg"/></td>
            <td>estado:</td>
            <td><input name="exc_estado" type="text" id="exc_estado" value="<?php echo $exc_estado; ?>" size="35" autocomplete="off" class="required" title="exc_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/expcontenedor/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>