<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/usuario/<?php echo $PATH_EVENT ?>/">

    <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>Sección:</td>
            <td><select autocomplete="off"
                        class="required"
                        id="uni_id"
                        name="uni_id"
                        title="Sección del Usuario">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_id; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Rol :</td>
            <td><select autocomplete="off"
                        class="required"
                        id="usu_rol_id"
                        name="usu_rol_id"
                        title="Rol del Usuario">
                    <option value="">-Seleccionar-</option>
                    <?php echo $roles; ?>
                </select></td>

            <td>Leer Documento Privado:</td>
            <td><select autocomplete="off"
                        id="usu_leer_doc"
                        name="usu_leer_doc"
                        title="Permiso de Leer Documentos Privados">
                    <option value="">-Seleccionar-</option>
                    <?php echo $leer_doc; ?>
                </select></td>
        </tr>

        <tr>
            <td>Nombres:</td>
            <td><input autocomplete="off"
                       class="required alpha"
                       id="usu_nombres"
                       maxlength="70"
                       name="usu_nombres"
                       size="35"
                       title="Nombre(s)"
                       type="text"
                       value="<?php echo $usu_nombres; ?> "/>
            </td>
            <td>Apellidos:</td>
            <td><input autocomplete="off"
                       class="required alpha"
                       id="usu_apellidos"
                       maxlength="70"
                       name="usu_apellidos"
                       size="35"
                       type="text"
                       value="<?php echo $usu_apellidos; ?>"
                       title="Apellido(s)" />
            </td>
        </tr>

        <tr>
            <td>Fono:</td>
            <td><input autocomplete="off"
                       class="alphanum"
                       id="usu_fono"
                       maxlength="12"
                       name="usu_fono"
                       size="35"
                       type="text"
                       value="<?php echo $usu_fono; ?>"
                       title="Tel&eacute;fono" />
            </td>

            <td>Email:</td>
            <td><input autocomplete="off"
                   
                       id="usu_email"
                       maxlength="50"
                       name="usu_email"
                       size="35"
                       title="Email"
                       type="text"
                       value="<?php echo $usu_email; ?>" />
            </td>
        </tr>


        <tr>
            <td>Login:</td>
            <td><input autocomplete="off"
                       class="required alphanumeric"
                       id="usu_login"
                       maxlength="30"
                       name="usu_login" <?php echo $mod_login ?>
                       title="Login del usuario"
                       type="text"
                       value="<?php echo $usu_login; ?> ">
            </td>
        </tr>

        <tr>
            <td>Contrase&ntilde;a:</td>
            <td><input autocomplete="off"
                       id="usu_pass"
                       maxlength="30"
                       name="usu_pass"
                       size="35"
                       title="Password del Usuario"
                       type="password"
                       value=""/>
            </td>
        </tr>

        <tr>
            <td>Repetir Contrase&ntilde;a:</td>
            <td><input autocomplete="off"
                       id="usu_pass2"
                       maxlength="30"
                       name="usu_pass2"
                       size="35"
                       type="password"
                       value=""
                       title="Confirmar Password del Usuario" />
            </td>
        </tr>

        <tr>
            <td colspan="4" class="botones">
                <input type="hidden" name="usu_pass_leer" id="usu_pass_leer" value="" />
                <input type="hidden" name="usu_pass_dias" id="usu_pass_dias" value="" />
                <input id="btnSub" type="button" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>



<div class="flexigrid" style="width: 100%;">
    <div class="nBtn srtd" style="left: 36px; top: 51px; display: none;">
        <div></div>
    </div>
    <div class="mDiv">
        <div class="ftitle">LISTA DE SERIES DOCUMENTALES</div>
    </div>
    <div class="hDiv">
        <div class="hDivBox">
            <table cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th align="center" abbr="exp_fecha_exi" axis="col4">
                <div style="text-align: center; width: 80px;">Ver</div>
                </th>
                <th align="center" abbr="exp_id" axis="col0" class="">
                <div class="sasc" style="text-align: center; width: 120px;">C&oacute;digo</div>
                </th>
                <th align="left" abbr="ser_id" axis="col1" class="">
                <div style="text-align: left; width: 600px;" class="">Serie</div>
                </th>

                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="bDiv" style="">
        <table cellspacing="0" cellpadding="0" border="0" style="" id="flex1">
            <tbody>
                <?php echo $lista_series; ?>
            </tbody>
        </table>

        <div class="iDiv" style="display: none;"></div>
    </div>
    <div class="pDiv">
        <div style="clear: both;"></div>
    </div>
    <div class="vGrip"><span></span></div>
    <div class="hGrip" style="height: 348px;"><span></span></div>


</div>



<div class="clear"></div>

<div id="dialog"
     title="Contrase&ntilde;a para Lectura de Documentos Privados">
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

        $("#btnSub").click(function(){
            $(".flexigrid").clone().hide().appendTo("#formA");
            return false;
        });

        $("#btnSub").click(function(){
            if($("#usu_pass").val() == $("#usu_pass2").val()){
                $('form#formA').submit();
            }else{
                alert("Las contraseñas deben ser iguales");
            }


        });

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/usuario/";
        });

        $(".evenw").click(function(){
            //alert("aqui "+$(this).attr('id'));
            if($("."+$(this).attr('id')+"z").is(':visible')){
                $("."+$(this).attr('id')+"z").hide()
            }else{
                $("."+$(this).attr('id')+"z").show()
            }
        });

        //        $("form.validable").click(function(){
        //            if($("#usu_pass").val() != $("#usu_pass2").val()){
        //                $("#usu_pass").attr("class","required req");
        //                $("#usu_pass2").attr("class","required req");
        //                return false;
        //            }
        //        });

    });


    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });


        //        $('#uni_id').change(function(){
        //            if($(this).val()!=''){
        //                $.ajax({
        //                    url: '<?php echo $PATH_DOMAIN ?>/unidad/loadAjaxFondo/',
        //                    type: 'POST',
        //                    data: 'Uni_id='+$('#uni_id').val(),
        //                    dataType:  		"text",
        //                    success: function(datos){
        //                        if(datos!=''){
        //                            var x = $("#TdFondo");
        //                            x.text(datos);
        //                            //alert(datos);
        //                        }
        //                    }
        //                });
        //                // check de secciones
        //                var option = $("#divSeccion");
        //                option.find("table").remove();
        //                $.ajax({
        //                    url: '<?php echo $PATH_DOMAIN ?>/usuario/loadAjaxCkeck/',
        //                    type: 'POST',
        //                    data: 'Uni_id='+$('#uni_id').val()+'&Usu_id='+$('#usu_id').val(),
        //                    dataType:  	"text",
        //                    success: function(datos){
        //                        if(datos!=''){
        //                            //alert(datos);
        //                            option.append(datos);
        //                            //alert(datos);
        //                        }
        //                    }
        //                });
        //
        //            }
        //        });


        $('#usu_login').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/usuario/verifLogin/',
                    type: 'POST',
                    data: 'login='+$(this).val()+ '&usu_id='+$('#usu_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#usu_login').val('');
                            $('#usu_login').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });

        $('#usu_leer_doc').change(function() {
            $('#pass1').val('');
            $('#pass2').val('');
            $('#dias').val('');
            $('#usu_pass_leer').val('');
            $('#usu_pass_dias').val('');
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
                        $('#usu_pass_leer').val(p.val());
                        $('#usu_pass_dias').val(q.val());//alert($('#usu_pass_leer').val());
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
                    $("#usu_leer_doc").val('2');
                    $(this).dialog('close');
                }
            },
            close: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });




    });
</script>