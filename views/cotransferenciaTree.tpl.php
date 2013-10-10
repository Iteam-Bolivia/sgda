<div class="clear"></div><?php echo $tituloEstructura; ?>
<table align="center" class="tDatos" width="100%" border="0">
    <tr>
        <th colspan="4">Datos de la Transferencia</th>
    </tr>
    <tr>
        <td width="159"><strong>Lugar:</strong></td>
        <td width="249"><?php echo $lugar; ?></a></td>
        <td width="198"><strong>Fecha:</strong></td>
        <td width="342"><?php echo $trn_fecha_crea; ?></td>
    </tr>
    <tr>
        <td><strong>Unidad:</strong></td>
        <td colspan="3"><?php echo $unidad; ?></td>
    </tr>
    <tr>
        <td><strong>Usuario:</strong></td>
        <td colspan="3"><? echo $usuario; ?></td>
    </tr>
</table>


<form id="formA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/coTransferencia/<?php echo $PATH_EVENT ?>/<?php echo $VAR3 ?>/">
    <input id="trn_confirmado" name="trn_confirmado" type="hidden" value="<?php echo $trn_confirmado ?>" />
    <input id="trn_uni_origen" name="trn_uni_origen" type="hidden" value="<?php echo $trn_uni_origen ?>" />
    <input id="trn_usuario_orig" name="trn_usuario_orig" type="hidden" value="<?php echo $trn_usuario_orig ?>" />
    <input id="trn_fecha_crea" name="trn_fecha_crea" type="hidden" value="<?php echo $trn_fecha_crea ?>" />
    <ul id="menuarch">
        <?php echo $tree ?>
    </ul>
    <div class="clear"></div>
    <table width="100%" border="0">
        <tr>
            <td>Ubicaci&oacute;n:</td>
            <td colspan="3">
                <select name="con_id" id="con_id" title="Ubicacion fisica donde se encontrara el expediente fisico." >
                    <option value="" selected="selected" class="required"> ----- </option>
                    <? echo $contenedores ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="button" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos"  title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
<script type="text/javascript">

    $(function() {
        $("#btnSub").click(function(){
            var i = 0;
            $(".submenuarch li a").each(function(){
                if($(this).attr('class')=='suboptActCh'){
                    i++;
                }
            });
            if($(".submenuarch li a").length==i){
                //alert("SI "+$(".submenuarch li a").length+" == "+i);
                //location.href="<?php echo $PATH_DOMAIN ?>/coTransferencia/coTree/<?php echo $VAR3 ?>/";
                $('#formA').submit();
            }else{
                //alert("NO "+$(".submenuarch li a").length+" == "+i);
                alert("Seleccione todos los cuerpos");
            }
        });
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/coTransferencia/";
        });
        $(".submenuarch a").click(function(){
            if($(this).attr('class')=='suboptAct'){
                $(this).attr('class','suboptActCh');
            }else{
                $(this).attr('class','suboptAct');
            }
        });
        var name = $("#pass"),
        allFields = $([]).add(name),
        tips = $("#validateTips");

        function updateTips(t) {
            tips.text(t).effect("highlight",{},1500);
        }

        function checkLength(o,n,min,max) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass('ui-state-error');
                updateTips("Tamano de "+n+" debe estar entre "+min+" y "+max+".");
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp(o,regexp,n) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass('ui-state-error');
                updateTips(n);
                return false;
            } else {
                return true;
            }
        }

        $("#dialog").dialog({
            bgiframe: true,
            autoOpen: false,
            height: 150,
            width: 350,
            modal: true,
            buttons: {
                Aceptar: function() {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');
                    bValid = bValid && checkLength($("#pass"),"Password",3,50);
                    bValid = bValid && checkRegexp($("#pass"),/^([0-9a-zA-Z])+$/,"Introduzca solo letras y n�meros : a-z 0-9");
                    if (bValid) {
                        $(this).dialog('close');
                        $("#formAA").submit();
                    }
                },
                Cancelar: function() {
                    $(this).dialog('close');
                }
            },
            Cerrar: function() {
                allFields.val('').removeClass('ui-state-error');
            }
        });

        $('.submenuarch a#linkPass').click(function() {
            $("#fil_id").val($(this).attr("valueId"));
            $('#pass').val("");
            $('#dialog').dialog('open');
        });

    });
</script>

</body>
</html>