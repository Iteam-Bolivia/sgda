<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rptePrestamos/<?php echo $PATH_EVENT ?>/">

    <table width="100%" border="0">
        <caption class="titulo">
            Reportes de Pr&eacute;stamo
        </caption>

        <tr>
            <td width="238">Clasificado por:</td>
            <td width="711">
                <select name="tipo_clasificado" style="width:300px;" id="tipo_clasificado" class="required" title="Instituci&oacute;n a la que pertenece el Solicitante">
                    <option value="">(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="INSTITUCION">INSTITUCION</option>
                </select></td>
        </tr>
        <tr>
            <td>Ordenado por:</td>
            <td>

                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required" >
                    <option value="">(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="INSTITUCION">INSTITUCION</option>
                    <option value="PERSONA SOLICITANTE">PERSONA SOLICITANTE</option>
                    <option value="NOMBRE EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Abrir Reporte" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />    </td>
        </tr>
    </table>
    <input name="pre_tipo" type="hidden" id="pre_tipo" value="1" />
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/prestamos/";
        });
    });
</script>
