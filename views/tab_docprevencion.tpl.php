<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/evalriesgos/<?php echo $PATH_EVENT ?>/">

    <input name="dpr_id" id="dpr_id" type="hidden" value="<?php echo $dpr_id; ?>" />
    <input name="dpr_tipo" type="hidden" id="dpr_tipo" value="<?php echo $dpr_tipo; ?>" class="required" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $tipo; ?></caption>
        <td width="28%">Fecha de Revisi&oacute;n:</td>
        <td>
            <input type="hidden" id="format"  value="yy-mm-dd"/>
            <input name="dpr_fecha_revision" type="text" id="datepickerr" value="<?php echo $dpr_fecha_revision; ?>" size="25" auclass="hasDatepicker" title="Fecha de Revisi&oacute;n"/>
        </td>
        <td width="28%">C&oacute;digo de Referencia:</td>
        <td>
            <input name="dpr_codigo" type="text" id="dpr_codigo" value="<?php echo $dpr_codigo; ?>" size="25" title="C&oacute;digo de Referencia"/>
        </td>
        </tr>
        <tr>
            <td>Nombre del Productor:</td>
            <td><input name="dpr_productor" type="text" id="dpr_productor" value="<?php echo $dpr_productor; ?>" size="35" autocomplete="off" class="required" title="productor"/></td>
            <td width="28%">C&oacute;digo de Referencia:</td>
            <td><select name="uni_id" id="uni_id" class="required" style="width:190px" title="Unidad a la que se realiza la Evaluaci&oacute;n de Riesgos.">
                    <option value="">-Seleccionar-</option>
                    <?php echo $uni_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Cargo del productor:</td>
            <td><input name="dpr_cargo_productor" type="text" id="dpr_cargo_productor" value="<?php echo $dpr_cargo_productor; ?>" size="120" autocomplete="off" class="required" title="cargo_productor"/></td>
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
            //window.location="<?php echo $PATH_DOMAIN ?>/docprevencion/";
        });
	  
    });			
    $(function() {
        $("#datepickerr").datepicker();
    });
</script>
</body>
</html>