<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rptePerCustodio/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Reportes de Expedientes por Custodio
        </caption>

        <tr>
            <td>Ordenado por:</td>
            <td>

                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required">
                    <option value="" selected>(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="NOMBRE_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="CODIGO_REFERENCIA">CODIGO DE REFERENCIA</option>
                    <option value="FECHA_EXI">FECHA EXTREMA INICIAL</option>
                    <option value="FECHA_EXF">FECHA EXTREMA FINAL</option>
                </select>
                <span class="error-requerid">*</span>
            
            </td>
        </tr>

        <tr>
            <td>FILTROS :</td>
        </tr>
        <tr>
            <td>Serie: </td>
            <td>
                <select name="filtro_series" style="width:300px;" id="filtro_series" >
                    <option value="">(seleccionar)</option>
                    <?php echo ($optSerie) ?>
                </select>
            </td>
        </tr>

        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Reporte" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />    </td>
        <tr>
    </table>
    <input name="pre_tipo" type="hidden" id="pre_tipo" value="1" />
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/estrucDocumental/";
        });
    });
</script>
