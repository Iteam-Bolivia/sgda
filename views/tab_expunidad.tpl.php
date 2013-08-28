<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/expunidad/<?php echo $PATH_EVENT ?>/">  
    <input name="euv_id" id="euv_id" type="hidden" value="<?php echo $euv_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">exp_id:</td>
            <td width="200">
                <select name="exp_id" id="exp_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
            <td width="125">uni_id:</td>
            <td width="200">
                <select name="uni_id" id="uni_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">ver_id:</td>
            <td width="200">
                <select name="ver_id" id="ver_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $ver_id; ?>
                </select>
            </td>
            <td>fecha_crea:</td>
            <td><input name="euv_fecha_crea" type="text" id="euv_fecha_crea" value="<?php echo $euv_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="euv_fecha_crea"/></td>
        </tr>
        <tr>
            <td>estado:</td>
            <td><input name="euv_estado" type="text" id="euv_estado" value="<?php echo $euv_estado; ?>" size="35" autocomplete="off" class="required" title="euv_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/expunidad/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>