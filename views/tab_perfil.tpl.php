<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/perfil/<?php echo $PATH_EVENT ?>/">
    <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
            <td width="80">Login:</td>
            <td colspan="2">
                <?php echo $usu_login; ?></td>
        </tr>
        <tr>
            <td>Nombres:</td>
            <td colspan="2"><?php echo $usu_nombres; ?></td>
        </tr>
        <tr>
            <td>Apellidos:</td>
            <td colspan="2"><?php echo $usu_apellidos; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td colspan="2"><input name="usu_email"  class="email" type="text" id="usu_email" value="<?php echo $usu_email; ?>" size="35" maxlength="50" autocomplete="off" title="Email"/></td>
        </tr>
        <tr>
            <td>Fono:</td>
            <td colspan="3"><input name="usu_fono" class="onlynumeric" type="text" id="usu_fono" value="<?php echo $usu_fono; ?>" size="35" maxlength="12" autocomplete="off" title="Tel&eacute;fono"/></td>
        </tr>	
        <tr>
            <td>Nro_item:</td>
            <td colspan="2"><input name="usu_nro_item" class="onlynumeric" type="text" id="usu_nro_item" value="<?php echo $usu_nro_item; ?>" size="35" autocomplete="off" maxlength="11" title="Nro. Item"/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td colspan="2"><a href="#" id="cambiap">Cambiar Password</a></td>
        </tr>
        <tr>
            <td rowspan="2">Contenedores:</td>
            <td colspan="2"><a href="<?php echo $PATH_DOMAIN ?>/contenUsuario/" id="viewContenedor">Ver contenedores</a></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $listaContenedorUsuario; ?></td>
        </tr>
        <tr>
            <td colspan="3" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>

<div class="demo">
    <div id="dialog" title="Ingreso password">
        <p id="validateTips"></p>
        <form id="formAX" name="formAX" method="post" action="<?php echo $PATH_DOMAIN ?>/perfil/<?php echo $PATH_EVENT_DIALOG; ?>/">
            <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
            <input type="hidden" value="" id="sww" class="sww" name="sww" />
            <table border="0" width="100%">
                <tr><td><label for="pass1">Password Anterior:</label></td><td><input type="password" value="" id="pass1" class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
                </tr>
                <tr><td><label for="pass2">Nuevo Password:</label></td><td><input type="password" value="" id="pass3" name="pass3" class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
                </tr>
                <tr><td><label for="pass3">Confirma Nuevo Password:</label></td><td><input type="password" value="" id="pass2" class="text ui-widget-content ui-corner-all" maxlength="70" /></td>
                </tr>
            </table>

            <input id="btnSub" type="submit" value="" style="visibility:hidden" />

        </form>
    </div>
</div>



<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.history.back();
        });
    });			

</script>

<script type="text/javascript">  
    jQuery(document).ready(function($) {  

        $("form.validable").click(function(){  
		
            /*if($("#usu_email").val() == ""){	$("#usu_email").attr("class","required req"); return false; }
                if($("#usu_nro_item").val() == ""){	$("#usu_nro_item").attr("class","required req"); return false; }
                if($("#usu_pass").val() == ""){		$("#usu_pass").attr("class","required req");	 return false; }*/
            if($("#usu_pass").val() != $("#usu_pass2").val()){
                $("#usu_pass").attr("class","required req");
                $("#usu_pass2").attr("class","required req");
                return false;
            }
            /*	if(!$("#usu_fono").val().match(/^[0-9]+$/) ){	$("#usu_fono").attr("class","required req"); return false; }
                if(!$("#usu_nro_item").val().match(/^[0-9]+$/)){$("#usu_nro_item").attr("class","required req"); return false; }*/
        });  
    });  
</script> 

<script>
    $(function() {	
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });
        $('#cambiap').click(function() {
            $('#pass1').val('');
            $('#pass2').val('');
            $('#pass3').val('');
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
                var id = o.val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/usuario/verificaPass/",
                    data: "usu_id="+$("#usu_id").val()+"&pass_usu="+id,
                    success: function(msg){
                        if(msg=='OK')
                        {
                            if(p.val() == q.val() ){
                                $("#dialog").dialog('close');
                                $("#formAX").submit();
                            }
                            else {
                                updateTips("Password nuevo y su confirmacion deben ser iguales");
                                p.val('');
                                q.val('');
                                p.addClass('ui-state-error');
                                q.addClass('ui-state-error');
                            }
								
                        }
                        else{
                            o.val('');
                            o.addClass('ui-state-error');
                            updateTips(msg);
                        }
                    }
                });
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
                    evalPass($("#pass1"),$("#pass2"),$("#pass3"));
                },
                Cancelar: function() {
                    allFields.val('').removeClass('ui-state-error');
                    $(this).dialog('close');
                }
            },
            Cerrar: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });		
    });
    
</script>
</body>
</html>
