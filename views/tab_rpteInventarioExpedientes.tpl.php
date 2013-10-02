<form id="formA" name="formA" method="post" 
      class="validable" action="<?php echo $PATH_DOMAIN ?>/rpteInventarioExpedientes/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            LISTADO INVENTARIO DE EXPEDIENTES
        </caption>

        <tr>
            <td width="238">Clasificado por:</td>
            <td width="711">
                <select name="tipo_clasificado" style="width:300px;" id="tipo_clasificado" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="CONTENEDOR">CONTENEDOR</option>
                </select></td>
        </tr>


        <tr>
            <td>Ordenado por:</td>
            <td>
                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="">
                    <option value="" selected>(por defecto)</option>
                    <option value="NOM_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="COD_REF">CODIGO DE REFERENCIA</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Filtros:</td>
        </tr>
        <tr>
            <td>Serie: </td>
            <td>
                <select name="filtro_serie" style="width:300px;" id="filtro_serie">
                    <option value="">(TODOS)</option>
                    <?php echo ($optSerie) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Reporte" class="button"/>
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        //        $("#cancelar").click(function(){
        //            window.location="<?php // echo $PATH_DOMAIN  ?>/inventario/";
        //        });
    });
</script>
