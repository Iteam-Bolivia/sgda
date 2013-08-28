<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/documento/<?php echo $PATH_EVENT ?>/">
    <table width="100%" border="0">
        <caption class="titulo">BUSCAR ARCHIVO</caption>
        <tr>
            <td colspan="4">Llene los campos para restringir la b&uacute;squeda.</td>
        </tr>
        <tr>
            <td width="245">Cod.Expediente:</td>
            <td width="238"><input name="exp_codigo" type="text" id="exp_codigo"
                                   value="<?php echo $exp_codigo; ?>" size="20" autocomplete="off" maxlength="20"
                                   class="alphanum" title="C&oacute;digo del Expediente" /></td>
            <td width="206">Serie:</td>
            <td width="250">
                <select name="ser_id" id="ser_id" title="Serie" >
                    <option value="">- -</option>
                    <?php echo $series; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Expediente:</td>
            <td colspan="3"><input name="exp_nombre" type="text" id="exp_nombre"
                                   value="<?php echo $exp_nombre; ?>" size="70" autocomplete="off" maxlength="255"
                                   class="alphanum" title="Nombre del Expediente" /></td>
        </tr>
        <tr>
            <td>Tr&aacute;mite:</td>
            <td colspan="3">
                <select name="tra_id" id="tra_id" autocomplete="off" title="Tr&aacute;mite" style="width:300px;" />
        <option value="">- -</option>
        <?php echo $tramites; ?>
        </select>
        </td>
        </tr>
        <tr>
            <td>Cuerpo:</td>
            <td colspan="3">
                <select name="cue_id" id="cue_id" autocomplete="off" title="Cuerpo" style="width:300px;" />
        <option value="">- -</option>
        <?php echo $cuerpos; ?>
        </select>
        </td>
        </tr>
        <tr>
            <td colspan="2">Fecha Extrema Inicial:  
                <input name="exp_fecha_exi" type="text" id="exp_fecha_exi" 
                       value="<?php echo $exp_fecha_exi; ?>" size="15" autocomplete="off" maxlength="10" title="exp_fecha_exi" /></td>
            <td colspan="2">Fecha Extrema Final: &nbsp;
                <input name="exp_fecha_exf" type="text" id="exp_fecha_exf" 
                       value="<?php echo $exp_fecha_exf; ?>" size="15" autocomplete="off" maxlength="10" title="exp_fecha_exf" /></td>
        </tr>
        <tr>
            <td>Nombre del Archivo:</td>
            <td>
                <input type="text" name="archivo" id="archivo" size="35" class="alphanum" title="Nombre de Archivo" value="<?php echo $archivo; ?>" />
            </td>
            <td>Descripci&oacute;n:</td>
            <td><input name="fil_descripcion" type="text" id="fil_descripcion" value="<?php echo $fil_descripcion; ?>" size="35" autocomplete="off" class="alphanum" title="Descripci&oacute;n del Archivo"/></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td>Instituci&oacute;n:</td>
            <td>
                <select name="institucion" id="institucion" title="Instituci&oacute;n o Entidad Gubernamental" >
                    <option value="">- -</option>
                    <?php echo $institucion; ?>
                </select>
            </td>
            <td>Lugar:</td>
            <td><select name="lugar" type="text" id="lugar" title="Lugar de ubicaci&oacute;n del Archivo.">
                    <option value="">- -</option>
                    <?php echo $lugar; ?>
                </select></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td class="botones" colspan="4">
                <input id="paginas" name="paginas" type="hidden" value="<?php echo $paginas; ?>" />
                <input id="page" name="page" type="hidden" value="<?php echo $page; ?>" />
                <input id="rp" name="rp" type="hidden" value="<?php echo $rp; ?>" />
                <input id="sortname" name="sortname" type="hidden" value="<?php echo $sortname; ?>" />
                <input id="sortorder" name="sortorder" type="hidden" value="<?php echo $sortorder; ?>" />
                <input id="total" name="total" type="hidden" value="<?php echo $total; ?>" />
                <input id="btnClear" type="button" value="Limpiar" class="button"/>
                <input id="btnSubB" type="button" value="Buscar" class="button"/></td>
        </tr>
    </table>
</form>
<br />

<div align="left" id="totalpag" class="titulo">
</div>
<div id="tableContainer" class="tableContainer">
    <table border="1" cellpadding="1" cellspacing="0" class="scrollTable">

        <thead class="fixedHeader">
            <tr>
                <th width="80">Id</th>
                <th width="100">Archivo</th>
                <th width="50">Tam.Mb</th>
                <th width="100">Tipo</th>
                <th width="100">Descripci&oacute;n</th>
                <th width="100">Expediente</th>
                <th width="50">C&oacute;digo</th>
                <th width="50">Fecha. Inicio</th>
                <th width="50">Fecha. Final</th>
                <th width="100">Serie</th>
                <th width="150">Tr&aacute;mite</th>
                <th width="150">Cuerpo</th>
                <th width="150">Disponib.</th>
                <th width="150">Instituci&oacute;n</th>
                <th width="150">Lugar</th>
                <th width="100">Contenedor</th>
                <th width="100">Subcontenedor</th>
            </tr>
        </thead>
        <tbody class="scrollContent" id="contenido">

        </tbody>
    </table>
</div>
<div id="tablefooter" class="botones">
    <a href="#" page="" class="page" id="pag_ant">&lt;&lt;</a> 
    <a href="#" page="" class="page" id="pag_sig">&gt;&gt;</a>
</div>
<div class="clear"></div>
<div id="dialog" title="Necesita password para poder ver el archivo">
    <p id="validateTips"></p>
    <form id="formAA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT2 ?>/">

        <label for="pass">Password:</label>
        <input type="hidden" value="" name="fil_id" id="fil_id"  />
        <input type="password" value="" id="pass" name="pass" class="text ui-widget-content ui-corner-all" />
        <input id="btnSub" type="submit" value="" style="visibility:hidden" />

    </form>
</div>

<form id="formArchivo" name="formArchivo" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT3 ?>/" target="_blank">
    <input type="hidden" value="" name="fil_id_open" id="fil_id_open"  />
    <input type="hidden" value="" id="pass_open" name="pass_open" />
</form>

<script type="text/javascript">	
    function llenaTabla(){ //alert($('#rp').val());
        $.ajax({
            type: "POST",
            url: "<?php echo $PATH_DOMAIN ?>/documento/<?php echo $PATH_EVENT ?>/",
            data: "ser_id="+$("#ser_id").val()+
                "&exp_codigo="+$("#exp_codigo").val()+
                "&exp_nombre="+$("#exp_nombre").val()+
                "&tra_id="+$("#tra_id").val()+
                "&cue_id="+$("#cue_id").val()+
                "&exp_fecha_exi="+$("#exp_fecha_exi").val()+
                "&exp_fecha_exf="+$("#exp_fecha_exf").val()+
                "&archivo="+$("#archivo").val()+
                "&fil_descripcion="+$("#fil_descripcion").val()+
                "&institucion="+$("#institucion").val()+
                "&lugar="+$("#lugar").val()+
                "&page="+$("#page").val()+
                "&rp="+10+
                "&sortname="+$("#sortname").val()+
                "&sortorder="+$("#sortorder").val(),
            dataType:  		"json",
            success: function(datos){
                var j=0;
                if(datos){
                    var cont;
                    var total = datos.total;
                    if(total>0){
                        var paginas = parseInt(datos.paginas);
                        var page = parseInt(datos.page);
                        var anterior = '';
                        var siguiente = '';
                        $('#pag_ant').html('&lt;&lt;');
                        $('#pag_sig').html('&gt;&gt;');
                        $("#totalpag").html('Total de resultados: '+total+'<br>P&aacute;gina: '+page);
                        if(page>=1 && page<=paginas){
                            pag_ant=page-1;
                            pag_sig=page+1;
                            $('#pag_ant').attr('page',pag_ant);
                            $('#pag_sig').attr('page',pag_sig);
                            if(page==1){
                                $('#pag_ant').attr('page','');
                                $('#pag_ant').html('');
                                anterior = '';
                            }
                            if(page == paginas){
                                $('#pag_sig').attr('page','');
                                $('#pag_sig').html('');
                                siguiente = '';
                            }
                        }
                    }else{
                        $('#pag_ant').attr('page','');
                        $('#pag_sig').attr('page','');
                        $('#pag_ant').html('');
                        $('#pag_sig').html('');
                        $("#totalpag").html('Total de resultados: '+total);
                    }
                    $('#contenido').html(' ');
                    jQuery.each(datos.datos, function(i,item){
                        j++;
                        cont=' ';
                        if(j % 2 == 0){
                            cont+="<tr class='alternateRow'>";
                        }
                        else{
                            cont+="<tr>";
                        }
                        cont+="<td>"+item.fil_id+"</td>";
                        if(item.fil_confidencialidad=='1'){
                            cont+="<td><a href='<?php echo $PATH_DOMAIN ?>/archivo/download/"+item.fil_id+"/' id='"+item.fil_id+"' class='fil_id'  target='_blank'>"+item.fil_nomoriginal+"</a></td>";
                        }
                        else
                            if(item.fil_confidencialidad=='2' && <?php echo $UNI_ID ?>==item.uni_id){
                                cont+="<td><a href='<?php echo $PATH_DOMAIN ?>/archivo/download/"+item.fil_id+"/' id='"+item.fil_id+"' class='fil_id'  target='_blank'>"+item.fil_nomoriginal+"</a></td>";
                            }
                        else{
                            cont+="<td><a href='#' id='"+item.fil_id+"' class='fil_id'>"+item.fil_nomoriginal+"</a></td>";
								
                        }
                        cont+="<td>"+item.fil_tamano+"</td>";
                        cont+="<td>"+item.fil_tipo+"</td>";
                        cont+="<td>"+item.fil_descripcion+"</td>";
                        cont+="<td>"+item.exp_nombre+"</td>";
                        cont+="<td>"+item.exp_codigo+"</td>";
                        cont+="<td>"+item.exp_fecha_exi+"</td>";
                        cont+="<td>"+item.exp_fecha_exf+"</td>";
                        cont+="<td>"+item.ser_categoria+"</td>";
                        cont+="<td>"+item.tra_descripcion+"</td>";
                        cont+="<td>"+item.cue_descripcion+"</td>";
                        cont+="<td>"+item.exa_condicion+"</td>";
                        cont+="<td>"+item.institucion+"</td>";
                        cont+="<td>"+item.lugar+"</td>";
                        cont+="<td>"+item.contenedor+"</td>";
                        cont+="<td>"+item.subcontenedor+"</td>";
                        cont+="</tr>";
                        $('#contenido').append(cont);
                    });
                }
                if(j==0){
                    $('#contenido').append("<tr><td colspan='13'>No se encontraron resultados</td></tr>");
                }
            }
        });
    }
    $(document).ready(function() {
        //alert($('#rp').val());
        llenaTabla();
        $('#btnSubB').click(function(){ 
            $("#page").val('1');
            llenaTabla();
        });
        $('#pag_ant').click(function(){
            if($(this).attr('page')!=''){
                $("#page").val($(this).attr('page'));
                llenaTabla();
            }
            return false;
        });
        $('#pag_sig').click(function(){
            if($(this).attr('page')!=''){
                $("#page").val($(this).attr('page'));
                llenaTabla();
            }
            return false;
        });
        $('#btnClear').click(function(){
            window.location.href = "<?php echo $PATH_DOMAIN ?>/documento/";
        });
        $('.fil_id').click(function(){
            alert($(this).html());
            if( $(this).attr('href') == '#' ){
                $("#fil_id").val($(this).attr("id"));
                $('#pass').val("");
                $('#dialog').dialog('open');
            }
        });
        $('#exp_fecha_exf').datepicker({
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
            /*onSelect: function(selectedDate) {
                          var instance = $(this).data("datepicker");
                          if(selectedDate<$('#exp_fecha_exi').val())
                          {
                                return [dates[$('#exp_fecha_exi').val()], ''];
                          }
                        }*/

        });
        $('#exp_fecha_exi').datepicker({
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
<script type="text/javascript">

    $(function() {

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
                        //						$("#formAA").submit();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT2 ?>/",
                            data: "exp_id="+$("#exp_id").val()+"&fil_id="+$("#fil_id").val()+"&pass="+$("#pass").val(),
                            success: function(msg){
                                if(msg=='ok'){
                                    $('#fil_id_open').val($("#fil_id").val());
                                    $('#pass_open').val($("#pass").val());
                                    $('#formArchivo').submit();
                                }else{
                                    alert(msg);
                                }
                            }
                        });
                    }
                },
                Cancelar: function() {
                    updateTips("");
                    allFields.val('').removeClass('ui-state-error');
                    $(this).dialog('close');
                }
            },
            Cerrar: function() {
                updateTips("");
                allFields.val('').removeClass('ui-state-error');
                $(this).dialog('close');
            }
        });
    });
</script>

</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
</body>
</html>