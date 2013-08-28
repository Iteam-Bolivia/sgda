<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/transferencia/<?php echo $PATH_EVENT ?>/">
    <input name="trn_id" id="trn_id" type="hidden" value="<?php echo $trn_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">exp_id:</td>
            <td width="200">
                <select name="exp_id" id="exp_id" class="required" style="width:190px">
                    <option value="">-Seleccionar-</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
            <td>descripcion:</td>
            <td><input name="trn_descripcion" type="text" id="trn_descripcion" value="<?php echo $trn_descripcion; ?>" size="35" autocomplete="off" class="required" title="trn_descripcion"/></td>
        </tr>
        <tr>
            <td>contenido:</td>
            <td><input name="trn_contenido" type="text" id="trn_contenido" value="<?php echo $trn_contenido; ?>" size="35" autocomplete="off" class="required" title="trn_contenido"/></td>
            <td>uni_origen:</td>
            <td><input name="trn_uni_origen" type="text" id="trn_uni_origen" value="<?php echo $trn_uni_origen; ?>" size="35" autocomplete="off" class="required" title="trn_uni_origen"/></td>
        </tr>
        <tr>
            <td>uni_destino:</td>
            <td><input name="trn_uni_destino" type="text" id="trn_uni_destino" value="<?php echo $trn_uni_destino; ?>" size="35" autocomplete="off" class="required" title="trn_uni_destino"/></td>
            <td>confirmado:</td>
            <td><input name="trn_confirmado" type="text" id="trn_confirmado" value="<?php echo $trn_confirmado; ?>" size="35" autocomplete="off" class="required" title="trn_confirmado"/></td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="trn_fecha_crea" type="text" id="trn_fecha_crea" value="<?php echo $trn_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="trn_fecha_crea"/></td>
            <td>usuario_crea:</td>
            <td><input name="trn_usuario_crea" type="text" id="trn_usuario_crea" value="<?php echo $trn_usuario_crea; ?>" size="35" autocomplete="off" class="required" title="trn_usuario_crea"/></td>
        </tr>
        <tr>
            <td>estado:</td>
            <td><input name="trn_estado" type="text" id="trn_estado" value="<?php echo $trn_estado; ?>" size="35" autocomplete="off" class="required" title="trn_estado"/></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/transferencia/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>