
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/lecturaArchivos/<?php echo $PATH_EVENT ?>/">

    <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
            <td width="125">Usuario:</td>
            <td><?php echo $usuario; ?></td>
        </tr>
        <tr>
            <td width="125">Unidad:</td>
            <td><?php echo $unidad; ?></td>
        </tr>
        <tr>
            <td>Leer Documento Privado:</td>
            <td>
                <select name="usu_leer_doc" id="usu_leer_doc" autocomplete="off" class="required" title="Permiso de Leer Documentos Privados">
                    <option value="">-Seleccionar-</option>
                    <?php echo $leer_doc; ?>
                </select></td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input type="hidden" name="usu_pass_leer"  id="usu_pass_leer" value="" />
                <input type="hidden" name="usu_pass_dias"  id="usu_pass_dias" value="" />
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>

<div id="dialog" title="Contrase�a para Lectura de Documentos Privados">
    <p id="validateTips"></p>
    <form id="formAX" name="formAX" method="post" action="#">
        <table border="0" width="100%">
            <tr><td><label for="pass1">Contrase&ntilde;a:</label></td><td><input type="password" value="" id="pass1" name="pass1" class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
            </tr>
            <tr><td><label for="pass2">Confirme Contrase&ntilde;a:</label></td><td><input type="password" value="" id="pass2" name="pass2" class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
            </tr>
            <tr><td><label for="pass3">D&iacute;as de vigencia:</label></td><td><input type="text" value="" id="dias" class="text ui-widget-content ui-corner-all" maxlength="4" /></td>
            </tr>
        </table>

        <input id="btnSub" type="submit" value="" style="visibility:hidden" />

    </form>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/lecturaArchivos/";
        });
    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("form.validable").click(function(){
            if($("#usu_pass").val() != $("#usu_pass2").val()){
                $("#usu_pass").attr("class","required req");
                $("#usu_pass2").attr("class","required req");
                return false;
            }
        });
    });
    $(function() {
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
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