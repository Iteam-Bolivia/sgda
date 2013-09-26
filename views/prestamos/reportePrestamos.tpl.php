<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/reportePrestamos/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0" style="padding-bottom: 20px">
        <caption class="titulo">
            Reporte de Prestamos
        </caption>
        
        <tr>
            <th>Fecha de Prestamo:</th>
            <td>
                desde:
                <input type="text" name="f_prestdesde" id='f_prestdesde'/>
                hasta:
                <input type="text" name="f_presthasta"  id='f_presthasta'/>
            </td>
        </tr>

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
                $.msgbox("La fecha final debe ser superior a la fecha inicial.");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                $.msgbox("La fecha final debe ser superior a la fecha inicial.");
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
