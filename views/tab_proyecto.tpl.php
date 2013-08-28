<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/proyecto/<?php echo $PATH_EVENT ?>/">
    <input name="pry_id" id="pry_id" type="hidden"
           value="<?php echo $pry_id; ?>" />
    <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Departamento:</td>
            <td><select name="dep_id" id="dep_id">
                    <option value="">(Seleccionar)</option>
                    <?php echo $dep_id ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="pry_codigo" type="text" id="pry_codigo"
                       value="<?php echo $pry_codigo; ?>" size="35" autocomplete="off"
                       onkeyup="this.value=this.value.toUpperCase()"
                       class="required alphanumeric" maxlength="70" title="Codigo" /></td>
        </tr>

        <tr>
            <td>N&oacute;mbre:</td>
            <td><input name="pry_nombre" type="text" id="pry_codigo"
                       value="<?php echo $pry_nombre; ?>" size="150" autocomplete="off"
                       onkeyup="this.value=this.value.toUpperCase()"
                       class="required alphanumeric" maxlength="128" title="Nombre" /></td>
        </tr>

        <tr>
            <td>Oficina Departamental:</td>
            <td><input name="pry_grod" type="text" id="pry_grod"
                       value="<?php echo $pry_grod; ?>" size="150" autocomplete="off"
                       class="alphanumeric" maxlength="70" title="Oficina Departamental" /></td>
        </tr>

        <tr>
            <td>Ingeniero Monitoreo de Proyecto:</td>
            <td><input name="pry_imp" type="text" id="pry_imp"
                       value="<?php echo $pry_imp; ?>" size="35" autocomplete="off"
                       class="alphanumeric" maxlength="70" title="Ingeniero Monitoreo de Proyecto" /></td>
        </tr>

        <tr>
            <td>Fecha Inicio:</td>
            <td><input name="pry_fecini" type="text" id="pry_fecini"
                       value="<?php echo $pry_fecini; ?>" size="35" autocomplete="off"
                       class="required" maxlength="70" title="IMP" /></td>
        </tr>

        <tr>
            <td>Nro. Contrato:</td>
            <td><input name="pry_nroctt" type="text" id="pry_nroctt"
                       value="<?php echo $pry_nroctt; ?>" size="35" autocomplete="off"
                       maxlength="70" title="Nro Contrato" /></td>
        </tr>

        <tr>
            <td>Licitaci&oacute;n:</td>
            <td><input name="pry_licitacion" type="text" id="pry_licitacion"
                       value="<?php echo $pry_licitacion; ?>" size="35" autocomplete="off"
                       maxlength="70" title="Licitacion" /></td>
        </tr>

        <tr>
            <td>Empresa Contratista:</td>
            <td><input name="pry_empctt" type="text" id="pry_empctt"
                       value="<?php echo $pry_empctt; ?>" size="35" autocomplete="off"
                       title="Empresa contratista" /></td>
        </tr>

        <tr>
            <td>Supervisor:</td>
            <td><input name="pry_supervisor" type="text" id="pry_supervisor"
                       value="<?php echo $pry_supervisor; ?>" size="35" autocomplete="off"
                       title="Supervisor" /></td>
        </tr>

        <tr>
            <td>Financiamiento:</td>
            <td><input name="pry_finan" type="text" id="pry_finan"
                       value="<?php echo $pry_finan; ?>" size="35" autocomplete="off"
                       class="onlynumeric" title="Financiamiento" /></td>
        </tr>

        <tr>
            <td>Tipo de Proyecto:</td>
            <td><select name="tpy_id" id="tpy_id">
                    <option value="">(Seleccionar)</option>
                    <?php echo $tpy_id ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Tipo de Contrato:</td>
            <td><select name="tct_id" id="tct_id">
                    <option value="">(Seleccionar)</option>
                    <?php echo $tct_id ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Fecha de Acta Provisional:</td>
            <td><input name="pry_fecactprov" type="text" id="pry_fecactprov"
                       value="<?php echo $pry_fecactprov; ?>" size="35" autocomplete="off"
                       title="Fecha de Acta Provisional" /></td>
        </tr>

        <tr>
            <td>Fecha de Acta Definitiva:</td>
            <td><input name="pry_fecactfin" type="text" id="pry_fecactfin"
                       value="<?php echo $pry_fecactfin; ?>" size="35" autocomplete="off"
                       title="Fecha de Acta Definitiva" /></td>
        </tr>

        <tr>
            <td>Estado Proyecto:</td>
            <td>Vigente<input type="radio" name="pry_estproy" value="Vigente" <?php if($pry_estproy == 'Vigente'){ echo "checked='checked'";}?> />
                Concluido<input type="radio" name="pry_estproy" value="Concluido" <?php if($pry_estproy == 'Concluido'){ echo "checked='checked'";}?>/>
                Cerrado<input type="radio" name="pry_estproy" value="Cerrado" <?php if($pry_estproy == 'Cerrado'){ echo "checked='checked'";}?>/>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
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
        //        $("#btnSub").click(function(){
        //            if($("#pry_rol_id").val()=="" || $("#uni_id").val()==0){
        //                var flag = false;
        //                $.ajax({
        //                    url: '<?php echo $PATH_DOMAIN ?>/proyecto/verifyFields/',
        //                    type: 'POST',
        //                    data: 'Rol_id='+$('#pry_rol_id').val()+ '&Uni_id='+$('#uni_id').val()+ '&Path_event='+$('#path_event').val(),
        //                    dataType:  		"text",
        //                    success: function(datos)
        //                    {
        //                        if(datos!='')
        //                        {
        //                            alert(datos);
        //                        }
        //                        else
        //                        {
        //                            if (flag==false){
        //                                $('form#formA').submit();
        //                                $('form#formA')[0].reset();
        //                            }
        //                        }
        //                    }
        //                });
        //            }
        //        });

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/proyecto/";
        });
        //$("#pry_rol_id").change(function(){
        //    if($("#pry_rol_id").val()=='13' || $("#pry_rol_id").val()=='5' || $("#pry_rol_id").val()=='6'){
        //        $('#divSeries').attr("style", "height:0px; overflow:hidden;");
        //    }else{
        //        $('#divSeries').attr("style", "");
        //    }
        //});
        //$("#divSeries")
        $("form.validable").click(function(){
            if($("#pry_pass").val() != $("#pry_pass2").val()){
                $("#pry_pass").attr("class","required req");
                $("#pry_pass2").attr("class","required req");
                return false;
            }
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
                    data: 'Uni_id='+$('#uni_id').val()+ '&Path_event='+$('#path_event').val(),
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


        $('#pry_login').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/proyecto/verifLogin/',
                    type: 'POST',
                    data: 'login='+$(this).val()+ '&pry_id='+$('#pry_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#pry_login').val('');
                            $('#pry_login').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });

        $('#pry_leer_doc').change(function() {
            $('#pass1').val('');
            $('#pass2').val('');
            $('#dias').val('');
            $('#pry_pass_leer').val('');
            $('#pry_pass_dias').val('');
            if($(this).val()=='1')
                $('#dialog').dialog('open');
        });

        var name = $("#pass1"),
        allFields = $([]).add(name),
        tips = $("#validateTips");

        function updateTips(t) {
            tips.text(t).effect("highlight",{},1500);
        }

        function evalPass(o, p, q) {
            if(o.val() == "" || p.val() == "" || q.val() == "" ){
                if(o.val() == "")
                    o.addClass('ui-state-error');
                if(p.val() == "")
                    p.addClass('ui-state-error');
                if(q.val() == "")
                    q.addClass('ui-state-error');
                updateTips("Todos los datos son requeridos");
            }else{
                if(o.val() == p.val() ){
                    if(q.val().match(/[^0-9]/g) )
                    {
                        updateTips("Por favor ingrese solo numeros como cantidad de D�as");
                        q.addClass('ui-state-error');
                        q.attr("value","");
                        q.focus();
                    }
                    else{
                        $('#pry_pass_leer').val(p.val());
                        $('#pry_pass_dias').val(q.val());//alert($('#pry_pass_leer').val());
                        $("#dialog").dialog('close');
                    }
                }
                else {
                    updateTips("La contrase�a y su confirmaci�n deben ser iguales");
                    o.val('');
                    p.val('');
                    o.addClass('ui-state-error');
                    p.addClass('ui-state-error');
                }
            }
        }

        $("#dialog").dialog({
            bgiframe: true,
            autoOpen: false,
            height: 220,
            width: 400,
            modal: true,
            buttons: {
                Aceptar: function() {
                    allFields.removeClass('ui-state-error');
                    evalPass($("#pass1"),$("#pass2"),$("#dias"));
                },
                Cancelar: function() {
                    //allFields.val('').removeClass('ui-state-error');
                    $("#pry_leer_doc").val('2');
                    $(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });

        $('#pry_codigo').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/proyecto/verifCodigo/',
                    type: 'POST',
                    data: 'pry_codigo='+$('#pry_codigo').val()+ '&Path_event='+$('#path_event').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#pry_codigo').val('');
                            $('#pry_codigo').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });

        $('#pry_fecini').datepicker({
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

        $('#pry_fecactprov').datepicker({
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

        $('#pry_fecactfin').datepicker({
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