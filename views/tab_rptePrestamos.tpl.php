<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rptePrestamos/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Reporte de Prestamos
        </caption>

        <tr>
            <td>Ordenado por:</td>
            <td>
                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required">
                    <option value="" selected>(seleccionar)</option>
                    <option value="NOM_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="COD_EXP">CODIGO DE EXPEDIENTE</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>FILTROS:</td>
        </tr>
        <tr>
            <td>Filtro por Serie: </td>
            <td>
                <select name="filtro_series" style="width:300px;" id="filtro_series" >
                    <option value="">(seleccionar)</option>
                    <?php echo ($optSerie) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Estado:</td>
            <td>
                <select name="estado" style="width:300px;" id="estado">
                    <option value="0" selected>(TODOS)</option>
                    <option value="1">SOLICITADO</option>
                    <option value="2">PRESTADO</option>
                    <option value="3">DEVUELTO</option>
                    <option value="4">RECHAZADO</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Fecha de Prestamo:</td>
            <td>
                desde:
                <input type="text" name="f_prestdesde" id='f_prestdesde'/>
                hasta:
                <input type="text" name="f_presthasta"  id='f_presthasta'/>
            </td>
        </tr>

<!--        <tr>
            <td>Fecha de Devolucion:</td>
            <td>
                desde:
                <input type="text" name="f_devodesde" id='f_devodesde'/>
                hasta:
                <input type="text" name="f_devohasta"  id='f_devohasta'/>
            </td>
        </tr>	-->
        </tr>

        <tr>
            <td class="botones" colspan="2">
                <input id="btnSub" type="submit" value="Reporte" class="button"/>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {

        $('#f_prestdesde').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial.");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial.");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').datepicker({//jquery
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
        $('#f_prestdesde').datepicker({
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
