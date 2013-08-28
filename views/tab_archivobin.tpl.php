<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/archivobin/<?php echo $PATH_EVENT ?>/">

    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td>contenido:</td>
            <td><input name="fil_contenido" type="text" id="fil_contenido" value="<?php echo $fil_contenido; ?>" size="35" autocomplete="off" class="required" title="fil_contenido"/></td>
            <td>estado:</td>
            <td><input name="fil_estado" type="text" id="fil_estado" value="<?php echo $fil_estado; ?>" size="35" autocomplete="off" class="required" title="fil_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/archivobin/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>