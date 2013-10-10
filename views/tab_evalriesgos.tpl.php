
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/evalriesgos/<?php echo $PATH_EVENT ?>/">
    <input name="eva_id" id="eva_id" type="hidden" value="<?php echo $eva_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo">
            Evaluaci&oacute;n de Riesgos
        </caption>
        <tr>
            <td width="71">Riesgo:</td>
            <td><select name="rie_id" id="rie_id" class="required" style="width:190px" title="Riesgo">
                    <option value="">-Seleccionar-</option>
                    <?php echo $rie_id; ?>
                </select></td>
        </tr>
        <tr>
            <td>Unidad:</td>
            <td><input name="eva_oficina" type="text" id="eva_oficina" value="<?php echo $eva_oficina; ?>" size="35" autocomplete="off" class="required" title="Oficina"/></td>
        </tr>
        <tr>
            <td>C&oacute;digo de Referencia:</td>
            <td><input name="eva_oficina" type="text" id="eva_oficina" value="<?php echo $eva_oficina; ?>" size="35" autocomplete="off" class="required" title="Oficina"/></td>
        </tr>
        <tr>
            <td>Frecuencia:</td>
            <td><input name="eva_frecuencia" type="text" id="eva_frecuencia" value="<?php echo $eva_frecuencia; ?>" size="100" autocomplete="off" class="required" title="Frecuencia"/></td>
        </tr>
        <tr>
            <td>Intensidad:</td>
            <td><input name="eva_intensidad" type="text" id="eva_intensidad" value="<?php echo $eva_intensidad; ?>" size="100" autocomplete="off" class="required" title="Intensidad"/></td>
        </tr>
        <tr>
            <td class="botones" colspan="2">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
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
            window.location="<?php echo $PATH_DOMAIN ?>/evalriesgos/";
        });
    });			

</script>
</body>
</html>