<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/rpteExpedientes/<?php echo $PATH_EVENT ?>/"
      target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">Reportes de Expedientes</caption>
        <tr>
            <td width="238"></td>
            <td width="711">
                <select name="tipo_clasificado" style="width: 300px;display:none;"
                                    id="tipo_clasificado" class="required">
                    <option value="" >(seleccionar)</option>
                    <option value="SERIE" selected="selected">SERIE</option>
                    <option value="UNIDAD">UNIDAD</option>
                    <option value="FUNCIONARIO">FUNCIONARIO</option>
                </select></td>
        </tr>
        <tr>
            <td>Ordenado por:</td>
            <td><select name="tipo_orden" style="width: 300px;" id="tipo_orden"
                        class="required">
                    <option value="" selected>(seleccionar)</option>
<!--                    <option value="SERIE">SERIE</option>
                    <option value="UNIDAD">UNIDAD</option>
                    <option value="FUNCIONARIO">FUNCIONARIO</option>-->
                    <option value="NOMBRE_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="CODIGO_REFERENCIA">CODIGO DE REFERENCIA</option>
<!--                    <option value="FECHA_EXI">FECHA EXTREMA INICIAL</option>
                    <option value="FECHA_EXF">FECHA EXTREMA FINAL</option>-->
                </select></td>
        </tr>

        <tr>
            <td>FILTROS :</td>
        </tr>
        <tr>
            <td>Serie:</td>
            <td><select name="filtro_series" style="width: 300px;"
                        id="filtro_series">
                    <option value="">(TODAS)</option>
                    <?php echo ($optSerie) ?>
                </select></td>
        </tr>

<!--        <tr>
            <td>Unidad:</td>
            <td><select name="filtro_unidad" style="width: 300px;"
                        id="filtro_unidad">
                    <option value="">(seleccionar)</option>
                    <?php //echo ($optUnidad) ?>
                </select></td>
        </tr>

        <tr>
            <td>Funcionario:</td>
            <td><select name="filtro_funcionario" style="width: 300px;"
                        id="filtro_funcionario">
                    <option value="">(seleccionar)</option>
                    <?php //echo ($optUsuario) ?>
                </select></td>
        </tr>-->



        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit"
                                                   value="Reporte" class="button" /> 
<!--                <input name="cancelar"
                                                   id="cancelar" type="button" class="button" value="Cancelar" />-->
            </td>
        </tr>
    </table>
  
</form>
