<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/sopfisico/<?php echo $PATH_EVENT ?>/">

    <input name="sof_id" id="sof_id" type="hidden"
           value="<?php echo $sof_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Codigo:</td>
            <td><input autocomplete="off"
                       class="required alpha" 
                       id="sof_codigo"
                       maxlength="8" 
                       name="sof_codigo" 
                       onkeyup="this.value=this.value.toUpperCase()" 
                       size="35" 
                       type="text"
                       title="Codigo" 
                       value="<?php echo $sof_codigo; ?>"
                       />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Nombre:</td>
            <td><input autocomplete="off"
                       class="required alpha"
                       id="sof_codigo"
                       maxlength="128" 
                       name="sof_nombre"
                       onkeyup="this.value=this.value.toUpperCase()"
                       title="Nombre" 
                       type="text"size="35"
                       value="<?php echo $sof_nombre; ?>"  />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="botones"><input type="hidden"
                                                   name="sof_pass_leer" id="sof_pass_leer" value="" /> <input
                                                   type="hidden" name="sof_pass_dias" id="sof_pass_dias" value="" /> <input
                                                   id="btnSub" type="submit" value="Guardar" class="button" /> <input
                                                   name="cancelar" id="cancelar" type="button" class="button"
                                                   value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>

<div id="dialog"
     title="Contrase&&ntilde;a para Lectura de Documentos Privados">
    <p id="validateTips"></p>
    <form id="formAX" name="formAX" method="post" action="#">
        <table border="0" width="100%">
            <tr>
                <td><label for="pass1">Contrase&ntilde;a:</label></td>
                <td><input type="password" value="" id="pass1" name="pass1"
                           class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
            </tr>
            <tr>
                <td><label for="pass2">Confirme Contrase&ntilde;a:</label></td>
                <td><input type="password" value="" id="pass2" name="pass2"
                           class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
            </tr>
            <tr>
                <td><label for="pass3">D&iacute;as de vigencia:</label></td>
                <td><input type="text" value="" id="dias"
                           class="text ui-widget-content ui-corner-all" maxlength="4" /></td>
            </tr>
        </table>

        <input id="btnSub" type="submit" value="" style="visibility: hidden" />

    </form>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {


        /**********/
        // Submit
        /**********/
        $("#btnSub").click(function(){
            if($("#sof_rol_id").val()=="" || $("#uni_id").val()==0){
                var flag = false;
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/sopfisico/verifyFields/',
                    type: 'POST',
                    data: 'Rol_id='+$('#sof_rol_id').val()+ '&Uni_id='+$('#uni_id').val()+ '&Path_event='+$('#path_event').val(),
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
            window.location="<?php echo $PATH_DOMAIN ?>/sopfisico/";
        });
        //$("#sof_rol_id").change(function(){
        //    if($("#sof_rol_id").val()=='13' || $("#sof_rol_id").val()=='5' || $("#sof_rol_id").val()=='6'){
        //        $('#divSeries').attr("style", "height:0px; overflow:hidden;");
        //    }else{
        //        $('#divSeries').attr("style", "");
        //    }
        //});
        //$("#divSeries")
        $("form.validable").click(function(){
            if($("#sof_pass").val() != $("#sof_pass2").val()){
                $("#sof_pass").attr("class","required req");
                $("#sof_pass2").attr("class","required req");
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
                    url: '<?php echo $PATH_DOMAIN ?>/unidad/verifyFields/',
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


        $('#sof_login').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/sopfisico/verifLogin/',
                    type: 'POST',
                    data: 'login='+$(this).val()+ '&sof_id='+$('#sof_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#sof_login').val('');
                            $('#sof_login').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });

        $('#sof_leer_doc').change(function() {
            $('#pass1').val('');
            $('#pass2').val('');
            $('#dias').val('');
            $('#sof_pass_leer').val('');
            $('#sof_pass_dias').val('');
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
                        $('#sof_pass_leer').val(p.val());
                        $('#sof_pass_dias').val(q.val());//alert($('#sof_pass_leer').val());
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
                    $("#sof_leer_doc").val('2');
                    $(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });

    });
</script>