<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/">
    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="149">Archivo:</td>
            <td colspan="3"><? echo ($nombrearchivo == '<input id="btnCargar" type="button" value="Cargar Archivo" class="button"/>' ? '' : '<input id="btnDigitalizar" type="button" value="Digitalizar Archivo" class="button"/>'); ?>
                <input type="text" name="archivo" id="archivo" size="40" class="required" title="Seleccione un archivo" value="" />
            </td>
        </tr>
        <tr>
            <td>Descripci&oacute;n (Claves):</td>
            <td colspan="3"><input name="fil_descripcion" type="text" id="fil_descripcion" value="<?php echo $fil_descripcion; ?>" size="80" autocomplete="off" class="required" title="fil_descripcion"/></td>
        </tr>
        <tr>
            <td>Caracter&iacute;sticas F&iacute;sicas:</td>
            <td colspan="3"><input name="fil_caracteristica" type="text" id="fil_caracteristica" value="<?php echo $fil_caracteristica; ?>" size="80" autocomplete="off" class="required" title="fil_caracteristica"/></td>
        </tr>
        <tr>
            <td>Contenedor:</td>
            <td width="219">
                <select name="con_id" id="con_id" title="Estante o gavetero donde se encuentra el archivo fisico.">
                    <option value="">Seleccione Estante o Gavetero</option>
                    <? echo $contenedores ?>
                </select></td>
        </tr>
        <tr>
            <td>Confidencialidad:</td>
            <td>
                <select name="fil_confidencialidad" id="fil_confidencialidad" >
                    <option value="0" >(seleccionar)</option>
                    <option value="1" >PUBLICO</option>
                    <!--  
                    <option value="2" >RESTRINGIDO</option>
                    <option value="3" >PRIVADO</option>-->
                </select>
            </td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td width="278"><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
            <td width="13" colspan="4">&nbsp;</td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/archivo/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>
</body>
</html>