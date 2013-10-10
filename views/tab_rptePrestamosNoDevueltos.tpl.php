<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rptePrestamosNoDevueltos/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Reportes de Prestamo No Devueltos
        </caption>

        <tr>
            <td width="238">Clasificado por:</td>
            <td width="711">
                <select name="tipo_clasificado" style="width:300px;" id="tipo_clasificado" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="INSTITUCION">INSTITUCION</option>
                </select></td>
        </tr>
        <tr>
            <td>Ordenado por:</td>
            <td>

                <select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required">
                    <option value="" selected>(seleccionar)</option>
                    <option value="SERIE">SERIE</option>
                    <option value="INSTITUCION">INSTITUCION</option>
                    <option value="PER_SOLICITANTE">PERSONA SOLICITANTE</option>
                    <option value="NOM_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
                    <option value="COD_REF">CODIGO DE REFERENCIA</option>
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
            <td>Filtro por Institucion: </td>
            <td>
                <select name="filtro_institucion" style="width:300px;" id="filtro_institucion" >
                    <option value="">(seleccionar)</option>
                    <?php echo ($optInstitucion) ?>
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

        <tr>
            <td>Fecha de Devolucion:</td>
            <td>
                desde:
                <input type="text" name="f_devodesde" id='f_devodesde'/>
                hasta:
                <input type="text" name="f_devohasta"  id='f_devohasta'/>
            </td>
        </tr>
        </tr>

        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Reporte" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />    </td>
        </tr>
    </table>
    <?php if ($tipofondo) { ?>
        Sub-Fondo:
        <select name="tipo_fondo" style="width:150px;" id="tipo_fondo" class="required">
            <option value="" selected="selected">(seleccionar)</option>
            <option value="SUBFONDO">SUB-FONDO</option>
            <option value="ARCENTRAL">ARCHIVO CENTRAL</option>
        </select>
    <?php } ?>

</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/prestamos/";
        });
    });

    jQuery(document).ready(function($) {
        $('#f_prestdesde').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial");
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

    jQuery(document).ready(function($) {
        $('#f_devodesde').change(function(){
            if($('#f_devohasta').val()<$('#f_devodesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial");
                $('#f_devohasta').val($('#f_devodesde').val());
            }
        });
        $('#f_devohasta').change(function(){
            if($('#f_devohasta').val()<$('#f_devodesde').val()){
                alert("La fecha final debe ser superior a la fecha inicial");
                $('#f_devohasta').val($('#f_devodesde').val());
            }
        });
        $('#f_devohasta').datepicker({//jquery
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
        $('#f_devodesde').datepicker({
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
