<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/plandesastre/<?php echo $PATH_EVENT ?>/">
    <input name="pla_id" id="pla_id" type="hidden" value="<?php echo $pla_id; ?>" />
    <table width="687" border="1">
        <caption class="titulo">Registro de Plan de Desastres</caption>
        <tr>
            <td width="125">T&iacute;tulo:</td>
            <td colspan="2"><input name="pla_titulo" type="text" id="pla_titulo" value="<?php echo $pla_titulo; ?>" size="100" autocomplete="off" class="required" title="pla_titulo"/></td>
        </tr>
        <tr>
            <td>Gesti&oacute;n:</td>
            <td colspan="2"><select name="pla_gestion" id="pla_gestion"  autocomplete="off" class="required" title="pla_gestion">
                    <option value="">Seleccicone gestion</option>
                    <?php echo $pla_gestion; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td  >Mes inicial:</td>
            <td colspan="2"><select name="pla_mes_inicial" id="pla_mes_inicial" autocomplete="off" class="required" title="pla_mes_inicial">
                    <option value="">Seleccione mes</option>
                    <?php echo $pla_mes_inicial; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td width="200"><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/plandesastre/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>