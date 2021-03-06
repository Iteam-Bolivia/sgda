<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rpteTransSubfondo/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Reportes de Expedientes Transferidos a Subfondo
        </caption>

        <tr>
            <td width="238">Clasificado por:</td>
            <td width="711">
                <select name="tipo_clasificado" style="width:300px;" id="tipo_clasificado" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="UNIDAD">UNIDAD</option>
                    <option value="FUNCIONARIO">FUNCIONARIO</option>
                </select></td>
        </tr>
        <tr>
            <td>Ordenado por:</td>
            <td>

                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required">
                    <option value="" selected>(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="UNIDAD">UNIDAD</option>
                    <option value="FUNCIONARIO">FUNCIONARIO</option>
                    <option value="NOMBRE_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="CODIGO_REFERENCIA">CODIGO DE REFRENCIA</option>
                    <option value="FECHA_TRANS">FECHA DE TRANSFERENCIA</option>
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
                    <option value="">(seleccionar)</option>
                    <?php echo ($optSerie) ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Unidad que Transfiere: </td>
            <td>
                <select name="filtro_unidad" style="width:300px;" id="filtro_unidad">
                    <option value="">(seleccionar)</option>
                    <?php echo ($optUnidad) ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Funcionario que Transfiere: </td>
            <td>
                <select name="filtro_funcionario" style="width:300px;" id="filtro_funcionario">
                    <option value="">(seleccionar)</option>
                    <?php echo ($optUsuario) ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Fecha de Transferencia: </td>
            <td>
                desde:
                <input type="text" name="f_transdesde" id='f_transdesde'/>
                hasta:
                <input type="text" name="f_transhasta"  id='f_transhasta'/>
            </td>
        </tr>



        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Reporte" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />    </td>
        </tr>
    </table>
    <input name="pre_tipo" type="hidden" id="pre_tipo" value="1" />
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/transferenciaFondo/";
        });
    });

    jQuery(document).ready(function($) {
        $('#f_transdesde').change(function(){
            if($('#f_transhasta').val()<$('#f_transdesde').val()){
                alert("La fecha hasta la que se transfiere debe ser superior a la fecha desde que se transfiere");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_transhasta').change(function(){
            if($('#f_transhasta').val()<$('#f_transdesde').val()){
                alert("La fecha hasta la que se transfiere debe ser superior a la fecha desde que se transfiere");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_transhasta').datepicker({//jquery
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            //			minDate: $('#exp_fecha_exi').val(),//'+10D',
            //            maxDate: '+10Y',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        $('#f_transdesde').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
    });
</script>