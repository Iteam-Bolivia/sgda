
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/serietramite/<?php echo $PATH_EVENT ?>/">

    <input name="sts_id" id="sts_id" type="hidden" value="<?php echo $sts_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">ser_id:</td>
            <td width="200">
                <select name="ser_id" id="ser_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $ser_id; ?>
                </select>
            </td>
            <td width="125">tra_id:</td>
            <td width="200">
                <select name="tra_id" id="tra_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $tra_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="sts_fecha_crea" type="text" id="sts_fecha_crea" value="<?php echo $sts_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="sts_fecha_crea"/></td>
            <td>usuario_crea:</td>
            <td><input name="sts_usuario_crea" type="text" id="sts_usuario_crea" value="<?php echo $sts_usuario_crea; ?>" size="35" autocomplete="off" class="required" title="sts_usuario_crea"/></td>
        </tr>
        <tr>
            <td width="125">ver_id:</td>
            <td width="200">
                <select name="ver_id" id="ver_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $ver_id; ?>
                </select>
            </td>
            <td>fecha_reg:</td>
            <td><input name="sts_fecha_reg" type="text" id="sts_fecha_reg" value="<?php echo $sts_fecha_reg; ?>" size="35" autocomplete="off" class="required" title="sts_fecha_reg"/></td>
        </tr>
        <tr>
            <td>usu_reg:</td>
            <td><input name="sts_usu_reg" type="text" id="sts_usu_reg" value="<?php echo $sts_usu_reg; ?>" size="35" autocomplete="off" class="required" title="sts_usu_reg"/></td>
            <td>estado:</td>
            <td><input name="sts_estado" type="text" id="sts_estado" value="<?php echo $sts_estado; ?>" size="35" autocomplete="off" class="required" title="sts_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/serietramite/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>
