<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/<?php echo $PATH_EVENT ?>/">
    <input name="exs_id" id="exs_id" type="hidden" value="<?php echo $exs_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">exp_id:</td>
            <td width="200">
                <select name="exp_id" id="exp_id" class="required" style="width:190px">
                    <option value="">-Seleccionar-</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
            <td>alida:</td>
            <td><input name="nrosalida" type="text" id="nrosalida" value="<?php echo $nrosalida; ?>" size="35" autocomplete="off" class="required" title="nrosalida"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>