<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/<?php echo $PATH_EVENT ?>/">

    <input name="spr_id" id="spr_id" type="hidden"
           value="<?php echo $spr_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        </tr>
        <td>Tipo:</td>
        <td><input name="spr_tipo" type="text" id="spr_tipo"
                   value="<?php echo $spr_tipo; ?>" size="35" autocomplete="off"
                   class="required alpha" maxlength="70" title="Tipo" /></td>
        </tr>

        <tr>
            <td>Fecha:</td>
            <td><input name="spr_fecha" type="text" id="spr_fecha" value="<?php echo $spr_fecha; ?>" 
                       size="35" autocomplete="off" class="required" title="Fecha Final"/>
            </td>
        </tr>

        <tr>
            <td>Unidad:</td>
            <td><select name="uni_id" id="uni_id" autocomplete="off"
                        class="required" title="">
                    <option value="">-Seleccionar-</option>
                    <?php echo $uni_id; ?>
                </select></td>
        <tr>

        </tr>
        <td>Doc. Solen:</td>
        <td>
            <textarea name="spr_docsolen" id="spr_docsolen" rows="3" cols="40">
                <?php echo $spr_docsolen; ?>
            </textarea>
        </td>
        </tr>

        </tr>
        <td>Email:</td>
        <td><input name="spr_email" type="text" id="spr_email"
                   value="<?php echo $spr_email; ?>" size="35" autocomplete="off"
                   class="required alpha" maxlength="70" title="Email" /></td>
        </tr>

        </tr>
        <td>Telefono:</td>
        <td><input name="spr_tel" type="text" id="spr_tel"
                   value="<?php echo $spr_tel; ?>" size="35" autocomplete="off"
                   class="required alpha" maxlength="70" title="Telefono" /></td>
        </tr>

        <tr>
            <td>Fecha Inicial:</td>
            <td><input name="spr_fecini" type="text" id="spr_fecini" value="<?php echo $spr_fecini; ?>"
                       size="35" autocomplete="off" class="required" title="Fecha Inicial"/>
            </td>
        </tr>

        <tr>
            <td>Fecha Final:</td>
            <td><input name="spr_fecfin" type="text" id="spr_fecfin" value="<?php echo $spr_fecfin; ?>"
                       size="35" autocomplete="off" class="required" title="Fecha Final"/>
            </td>
        </tr>

        <tr>
            <td>Fecha Renovacion:</td>
            <td><input name="spr_fecren" type="text" id="spr_fecren" value="<?php echo $spr_fecren; ?>"
                       size="35" autocomplete="off" class="required" title="Fecha Renovacion"/>
            </td>

        </tr>

        </tr>
        <td>Observaciones:</td>
        <td>
            <textarea name="spr_obs" id="spr_obs" rows="5" cols="40">
                <?php echo $spr_obs; ?>
            </textarea>
        </td>
        </tr>


        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>

</form>
</div>
<div class="clear"></div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        /**********/
        // Submit
        /**********/
        $("#btnSub").click(function(){
            if($("#usu_rol_id").val()=="" || $("#uni_id").val()==0){
                var flag = false;
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/verifyFields/',
                    type: 'POST',
                    data: 'Rol_id='+$('#usu_rol_id').val()+ '&Uni_id='+$('#uni_id').val(),
                    dataType:  		"text",
                    success: function(datos)
                    {
                        if(datos!='')
                        {
                            jAlert(datos, '');
                        }
                        else
                        {
                            if (flag==false){
                                $('form#formA').submit();
                                $('form#formA')[0].reset();
                            }
                        }
                    }
                });
            }
        });

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/";
        });

        $('#spr_fecha').datepicker({//jquery
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'dd/mm/yy',
            //            maxDate: '+10Y',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        
        $('#spr_fecini').datepicker({//jquery
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'dd/mm/yy',
            //            maxDate: '+10Y',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });

        $('#spr_fecfin').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'dd/mm/yy',
            //minDate: $('#f_desde').val(),
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });


        $('#spr_fecren').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'dd/mm/yy',
            //minDate: $('#f_desde').val(),
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });

    });


    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });


        $('#uni_id').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/unidad/loadAjaxFondo/',
                    type: 'POST',
                    data: 'Uni_id='+$('#uni_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            var x = $("#TdFondo");
                            x.text(datos);
                            //alert(datos);
                        }
                    }
                });
            }
        });


    });
</script>