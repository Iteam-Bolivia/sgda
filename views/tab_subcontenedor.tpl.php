<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/subcontenedor/<?php echo $PATH_EVENT ?>/">
    
    <input name="con_id" id="con_id" type="hidden" value="<?php echo $con_id; ?>" />
    <input name="suc_id" id="suc_id" type="hidden" value="<?php echo $suc_id; ?>" />
        
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Usuario:</td>
            <td colspan=3 ><?php echo $nombre; ?>
            </td>
        </tr>

        <tr>
            <td>Contenedor:</td>
            <td colspan=3 ><?php echo $con_codigo; ?>
            </td>
        </tr>
        <tr>
            <td>Sub Contenedor C&oacute;digo:</td>
            <td colspan=3 >
                <input type="text" name="suc_codigo" id="suc_codigo" size="20" maxlength="15" autocomplete="off" class="required alphanum" title="C&oacute;digo" value="<?php echo $suc_codigo; ?>" />
            </td>
        </tr>
        
        <tr>
            <td>Metros lineales:</td>
            <td colspan=3 >
                <input type="text" name="suc_ml" id="suc_ml" size="20" maxlength="15" autocomplete="off" class="required alphanum" title="C&oacute;digo" value="<?php echo $suc_ml; ?>" />
            </td>
        </tr>
        
        <tr>
            <td>Nro Balda:</td>
            <td colspan="2"><input name="suc_nro_balda" type="text" id="suc_nro_balda" value="<?php echo $suc_nro_balda; ?>" size="30" maxlength="200" autocomplete="off" class="numeric" title="Nro Balda"/></td>
        </tr>
<!--        <tr>
            <td>Fecha Inicial:</td>
            <td colspan="2"><input name="suc_fecha_exi_min" type="text" id="suc_fecha_exi_min" value="<?php //echo $suc_fecha_exi_min; ?>" size="30" maxlength="200" autocomplete="off" class="required" title="Fecha extrema inicial"/></td>
        </tr>
        <tr>
            <td>Fecha Final:</td>
            <td colspan="2"><input name="suc_fecha_exf_max" type="text" id="suc_fecha_exf_max" value="<?php //echo $suc_fecha_exf_max; ?>" size="30" maxlength="200" autocomplete="off" class="required" title="Fecha extrema final"/></td>
        </tr>-->
        <tr>
            <td colspan="3" class="botones"><input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/subcontenedor/index/<?php echo $con_id; ?>/";
            //window.history.back(-1);
        });
    });			
    
    
    $('#suc_fecha_exi_min').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'c-5:c+10',
        dateFormat: 'yy-mm-dd',
        //minDate: $('#f_desde').val(),
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 
            'Junio', 'Julio', 'Agosto', 'Septiembre', 
            'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
            'May', 'Jun', 'Jul', 'Ago', 
            'Sep', 'Oct', 'Nov', 'Dic']
    });
    
    $('#suc_fecha_exf_max').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'c-5:c+10',
        dateFormat: 'yy-mm-dd',
        //minDate: $('#f_desde').val(),
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 
            'Junio', 'Julio', 'Agosto', 'Septiembre', 
            'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
            'May', 'Jun', 'Jul', 'Ago', 
            'Sep', 'Oct', 'Nov', 'Dic']
    });
    
    $(function() {
        $("#usu_id").change(function(){            
            var optionCon = $("#con_idOption");
            var usu_id = $("#usu_id").val();
            optionCon.find("option").remove();            
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/usuario/obtenerCon/',
                type: 'POST',
                data: 'Usu_id='+usu_id,
                dataType:  'text',
                success: function(datos){
                    optionCon.append(datos);    
                }
                
            });
 
        });

    });
</script>