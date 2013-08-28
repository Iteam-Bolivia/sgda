<div class="clear"></div>
<div align="center" class="titulo"><?php echo $tituloEstructura; ?></div>

<form id="formA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/<?php echo $PATH_EVENT ?>/<?php echo $VAR3 ?>/">
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
            <td><strong>Origen:</strong></td>
            <td><?php echo $origen; ?></td>
            <td><strong>Cantidad de Exp.:</strong></td>
            <td><?php echo $cantidad ?></td>
        </tr>
        <tr>
            <td><strong>Usuario Destino:</strong></td>
            <td><?php echo $usu_destino ?></td>
            <td><strong>Ubicaci&oacute;n:</strong></td>
            <td>
                <?php if ($contenedores != ''): ?>
                    <select name="con_id" id="con_id" title="Ubicacion fisica donde se encontrara el expediente fisico." >
                        <option value="" selected="selected">(Seleccionar)</option>
                        <?php echo $contenedores ?>
                    </select>
                <?php else: ?>
                    Ninguno
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><strong>Motivo:</strong></td>
            <td><?php echo $trn_descripcion ?></td>
            <td><strong>Sub Contenedor:</strong></td>
            <td>
                <select name="suc_id" id="suc_id" title="Sub Contenedor fisica donde se encontrara el expediente fisico." >
                    <!--            <option value="" selected="selected"> ----- </option>-->
                    <?php echo $suc_id ?>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="4">Expedientes Transferidos</th>
        </tr>
        <tr><td colspan="4">
                <table class="tDatosSub">
                    <tr>
                        <th width="10">&nbsp;</th>
                        <th width="300">Nombre del Expediente</th>
                        <th width="150">C&oacute;digo</th>
                        <th width="100">Serie</th>
                    </tr>
                    <?php echo $tree ?>
                </table>
            </td>
        </tr>
    </table>
    <input id="uni_id_origen" name="uni_id_origen" type="hidden" value="<?php echo $uni_id_origen ?>" />
    <input id="trn_confirmado" name="trn_confirmado" type="hidden" value="<?php echo $trn_confirmado ?>" />
    <input id="trn_fecha_crea" name="trn_fecha_crea" type="hidden" value="<?php echo $trn_fecha_crea ?>" />
    <input id="trn_usuario_des" name="trn_usuario_des" type="hidden" value="<?php echo $trn_usuario_des ?>" />
    <input id="trn_uni_destino" name="trn_uni_destino" type="hidden" value="<?php echo $trn_uni_destino ?>" />
    <div class="botones">
        <input id="btnSub" type="button" value="Guardar" class="button"/>
        <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
    </div>
</form>
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
                $('#formA').submit();
            }else{
                alert("Seleccione todos los cuerpos");
            }
        });
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/";
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
        
    $(function() {
        $("#con_id").change(function(){
            // alert("hola");
            var optionSuc = $("#suc_id");
            
            var con_id = $("#con_id").val();
            optionSuc.find("option").remove();
            
            
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/obtenerSuc/',
                type: 'POST',
                data: 'Con_id='+con_id,
                dataType:  'text',
                success: function(datos){
                    optionSuc.append(datos);    
                }
            });
 
        });

    });        
</script>