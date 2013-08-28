<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tramo/<?php echo $PATH_EVENT ?>/">

    <input name="trm_id" id="trm_id" type="hidden"
           value="<?php echo $trm_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Proyecto:</td>
            <td><select name="pry_id" id="pry_id" autocomplete="off"
                        class="required" title="Proyecto">
                    <option value="">-Seleccionar-</option>
                    <?php echo $pry_id; ?>
                </select></td>
        </tr>

        <tr>
            <td>Codigo:</td>
            <td><input name="trm_codigo" type="text" id="trm_codigo"
                       value="<?php echo $trm_codigo; ?>" size="35" autocomplete="off"
                       class="required alphanumeric" maxlength="70" title="Codigo" /></td>
        </tr>

        <tr>
            <td>Nombre:</td>
            <td><input name="trm_nombre" type="text" id="trm_nombre"
                       value="<?php echo $trm_nombre; ?>" size="75" autocomplete="off"
                       class="required alphanumeric" maxlength="70" title="Nombre" /></td>
        </tr>

        <tr>
            <td colspan="4" class="botones"><input type="hidden"
                                                   name="trm_pass_leer" id="trm_pass_leer" value="" /> <input
                                                   type="hidden" name="trm_pass_dias" id="trm_pass_dias" value="" /> <input
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
            if($("#trm_rol_id").val()=="" || $("#uni_id").val()==0){
                var flag = false;
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/tramo/verifyFields/',
                    type: 'POST',
                    data: 'Rol_id='+$('#trm_rol_id').val()+ '&Uni_id='+$('#uni_id').val(),
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
            window.location="<?php echo $PATH_DOMAIN ?>/tramo/";
        });
        //$("#trm_rol_id").change(function(){
        //    if($("#trm_rol_id").val()=='13' || $("#trm_rol_id").val()=='5' || $("#trm_rol_id").val()=='6'){
        //        $('#divSeries').attr("style", "height:0px; overflow:hidden;");
        //    }else{
        //        $('#divSeries').attr("style", "");
        //    }
        //});
        //$("#divSeries")
        $("form.validable").click(function(){
            if($("#trm_pass").val() != $("#trm_pass2").val()){
                $("#trm_pass").attr("class","required req");
                $("#trm_pass2").attr("class","required req");
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
        
        
        $('#trm_login').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/tramo/verifLogin/',
                    type: 'POST',
                    data: 'login='+$(this).val()+ '&trm_id='+$('#trm_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#trm_login').val('');
                            $('#trm_login').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
        
        $('#trm_leer_doc').change(function() {
            $('#pass1').val('');
            $('#pass2').val('');
            $('#dias').val('');
            $('#trm_pass_leer').val('');
            $('#trm_pass_dias').val('');
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
                        $('#trm_pass_leer').val(p.val());
                        $('#trm_pass_dias').val(q.val());//alert($('#trm_pass_leer').val());
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
                    $("#trm_leer_doc").val('2');
                    $(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });

    });
</script>