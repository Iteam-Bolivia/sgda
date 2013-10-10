<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rptePerCustodio/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Listado de Expedientes por Custodio
        </caption>

 

        <tr>
            <td>FILTRO:</td>
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
