<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/cronoact/<?php echo $PATH_EVENT ?>/<?php echo $pla_id; ?>/">
    <input name="cro_id" id="cro_id" type="hidden" value="<?php echo $cro_id; ?>" />
    <input name="pla_id" id="pla_id" type="hidden" value="<?php echo $pla_id; ?>" />
    <table width="699" border="1">
        <caption class="titulo">Cronograma de Actividades</caption>
        <tr>
            <td width="139">Plan de Desastre:</td>
            <td colspan="2"><?php echo $pla_titulo; ?></td>
        </tr>
        <tr>
            <td>Actividad:</td>
            <td colspan="2"><input name="cro_actividad" type="text" id="cro_actividad" value="<?php echo $cro_actividad; ?>" size="90" autocomplete="off" class="required" title="cro_actividad"/></td>
        </tr>
        <tr>
            <td>Mes inicial:</td>
            <td colspan="2"><select name="cro_mes_ini" id="cro_mes_ini" class="required" style="width:190px">
                    <option value="">-Seleccionar-</option>
                    <?php echo $cro_mes_ini; ?>
                </select></td>
        </tr>
        <tr>
            <td>Tiemrpo en semanas </td>
            <td colspan="2"><input name="cro_tiempo" type="text" id="cro_tiempo" value="<?php echo $cro_tiempo; ?>" size="15" autocomplete="off" class="required" title="cro_tiempo"/></td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td width="284"><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td width="254"><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>

<div id="listaCronograma" class="seccion">Cronograma de actividades de este Plan
    <div class="scrollBar">
        <ul>
   <!--  <caption class="titulo"></caption> -->
            <?php echo $LISTA_CRONOGRAMA_PLANDESASTRE; ?>
        </ul>
    </div>
</div>

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
                $("#listaCronograma").hide();
                //$(".flexigrid").attr('class','flexigrid');
                window.location="<?php echo $PATH_DOMAIN ?>/cronoact/<?php echo $pla_id; ?>/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>