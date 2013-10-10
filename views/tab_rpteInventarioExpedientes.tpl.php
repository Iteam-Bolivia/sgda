
<form id="formA" name="formA" method="post" 
      class="validable" action="<?php echo $PATH_DOMAIN ?>/rpteInventarioExpedientes/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            LISTADO INVENTARIO DE EXPEDIENTES
        </caption>

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
