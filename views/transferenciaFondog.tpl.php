<div class="clear"></div>
<div class="titulo"><?php echo $tituloGeneral ?></div>
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferenciaFondo/<?php echo $PATH_EVENT ?>/">
    <input name="trn_id" id="trn_id" type="hidden" value="<?php echo $trn_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
</form>

<script type="text/javascript">


    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferenciaFondo/loadExp/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha Final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'},
            {display: 'Custodio Actual', name : 'custodios', width : 150, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Reporte1', bclass: 'Reporte1', onpress : test},{separator: true},
            {name: 'Transferir', bclass: 'view', onpress : test}<?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'},
            {display: 'Custodio', name : 'custodios'}
        ],
        sortname: "exp_fecha_exf",
        sortorder: "desc",
        usepager: true,
        title: '<?php echo $titulo ?>',
        mulSelec: true,
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 150,
        autoload: false
    });

    $("#flex2").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferenciaFondo/loadFondo/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            /*{display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},*/
            {display: 'Codigo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 250, sortable : true, align: 'left'},
            /*{display: 'Descripci&oacute;n', name : 'exp_descripcion', width : 180, sortable : true, align: 'left'},*/
            {display: 'Uni. Origen', name : 'uni_origen', width : 50, sortable : true, align: 'left'},
            {display: 'Usuario Origen', name : 'usu_origen', width : 150, sortable : true, align: 'left'},
            {display: 'Uni. Destino', name : 'uni_destino', width : 50, sortable : true, align: 'left'},
            {display: 'Usuario Destino', name : 'usu_destino', width : 150, sortable : true, align: 'left'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'},
            /*	{display: 'Conf.', name : 'confirmado', width : 30, sortable : true, align: 'center'},*/
            {display: 'Motivo', name : 'trn_descripcion', width : 130, sortable : true, align: 'left'},
            {display: 'Custodio Actual', name : 'custodios', width : 150, sortable : true, align: 'center'}

        ],
        buttons : [
            {name: 'Reporte', bclass: 'Reporte', onpress : test},{separator: true},
<?php echo $PATH_B ?>
                ],
                searchitems : [
                    {display: 'Id', name : 'exp_id'},
                    {display: 'Serie', name : 'ser_categoria', isdefault: true},
                    {display: 'Codigo', name : 'exp_codigo'},
                    {display: 'Nombre', name : 'exp_nombre'},
                    {display: 'Descripci&oacute;n', name : 'exp_descripcion'},
                    {display: 'Uni. Origen', name : 'uni_origen'},
                    {display: 'Usu. Origen', name : 'usu_origen'},
                    {display: 'Uni. Destino', name : 'uni_destino'},
                    {display: 'Usu. Destino', name : 'usu_destino'},
                    {display: 'Fecha final', name : 'exp_fecha_exf'},
                    {display: 'Motivo', name : 'trn_descripcion'},
                    {display: 'Custodio', name : 'custodio'}
                ],
                sortname: "trn_uni_destino",
                sortorder: "asc",
                usepager: true,
                title: '<?php echo $titulo2 ?>',
                useRp: true,
                rp: 10,
                minimize: <?php echo $GRID_SW ?>,
                showTableToggleBtn: true,
                width: 800,
                height: 150,
                autoload: false
            });
            function dobleClik(grid){
                if($('.trSelected div',grid).html()){
                    $("#exp_id").val($('.trSelected div',grid).html());
                    if($("table",grid).attr('id')=="flex1"){
                        var ids = "";
                        $('.trSelected',grid).each(function(){
                            ids = ids+ $("div",this).html() + "," ;
                        });
                        $("#expedientes").val(ids);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/transferenciaFondo/find/",
                            data: "ids="+ids,
                            dataType: 'json',
                            success: function(json){
                                dataj = json;
                                $(".trn_uni_origen").html(dataj.unidad);
                                $(".trn_usuario_orig").html(dataj.usuario);
                                $("#trn_usuario_orig").val(dataj.usu_origen);
                                $(".expedientes").html(dataj.expedientes);
                            },
                            error: function(msg){
                                alert(msg);
                            }
                        });
                        $('#dialog-form').dialog('open');
                    }
                }
            }
            function test(com,grid)
            {
                if(com=="Transferir"){
                    if($('.trSelected',grid).length>0){
                        var ids = "";
                        $('.trSelected',grid).each(function(){
                            //			alert($("div",this).html());
                            ids = ids+ $("div",this).html() + "," ;
                        });
                        $("#expedientes").val(ids);
                        //			alert(ids);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/transferenciaFondo/find/",
                            data: "ids="+ids,
                            dataType: 'json',
                            success: function(json){
                                dataj = json;
                                //					alert(dataj.length);
                                //						alert('Item: '+dataj.unidad);
                                $(".trn_uni_origen").html(dataj.unidad);
                                $(".trn_usuario_orig").html(dataj.usuario);
                                $("#trn_usuario_orig").val(dataj.usu_origen);
                                $(".expedientes").html(dataj.expedientes);
                            },
                            error: function(msg){
                                alert(msg);
                            }
                        });
                        $('#dialog-form').dialog('open');
                    }else{
                        alert("Seleccione un registro");
                    }
                }

                else if (com=='Reporte')
                {
                    window.location="<?php echo $PATH_DOMAIN ?>/rpteTransSubfondo/";
                }
                else if (com=='Reporte1')
                {
                    window.location="<?php echo $PATH_DOMAIN ?>/rpteParaTransSubfondo/";
                }
                else{
                    $('#idcom').val(com);
                    $(".qsbox").val(com);
                    $(".qtype").val('ser_categoria');
                    $('.Search').click();
                }
            }
            function test2(com,grid)
            {
                $('#idcom').val(com);
                $(".qsbox").val(com);
                $(".qtype").val('ser_categoria');
                $('.Search').click();
            }
            $(function() {
                var allFields = $([]).add(name),
                tips = $("#validateTips");

                function updateTips(t) {
                    tips.text(t).effect("highlight",{},1500);
                }

                function tieneValor(o) {
                    if ( o.val().length <= 0 ) {
                        o.addClass('ui-state-error');
                        updateTips("Todos los campos son obligatorios.");
                        return false;
                    } else {
                        return true;
                    }
                }
                $("#dialog-form").dialog({
                    stackfix: true,
                    autoOpen: false,
                    height: 500,  //355
                    width: 685,
                    modal: true,
                    buttons: {
                        Cancelar: function() {
                            $(this).dialog('close');
                        },
                        Enviar: function() {
                            var sw = true;
                            sw = sw && tieneValor($("#expedientes")) && tieneValor($("#trn_usuario_des")) && tieneValor($("#trn_descripcion"));
                            if(sw){
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo $PATH_DOMAIN ?>/transferenciaFondo/save/",
                                    data: "expedientes="+$("#expedientes").val()+"&trn_usuario_des="+$("#trn_usuario_des").val()+"&trn_descripcion="+$("#trn_descripcion").val()+"&inst_fondo="+$("#inst_fondo").val()+"&trn_usuario_orig="+$("#trn_usuario_orig").val(),
                                    success: function(msg){
                                        //$(".pReload",".flexigrid").click();

                                        $(".qsbox").val($('#idcom').val());
                                        $(".qtype").val('ser_categoria');
                                        $('.Search').click();
                                    },
                                    error: function(msg){
                                        alert(msg);
                                    }
                                });
                                $(this).dialog('close');
                            }
                        }
                    },
                    close: function() {
                        updateTips("");
                        $('#trn_usuario_des').removeClass('ui-state-error');
                        $('#trn_descripcion').removeClass('ui-state-error');
                    }
                });

            });
</script>
<div id="dialog-form" title="Enviar expediente">
    <p id="validateTips"></p>
    <form>
        <table width="619" border="0">
            <tr>
                <td>Expedientes:
                    <input name="expedientes" id="expedientes" type="hidden" value="" /></td>
                <td colspan="3"><span class="expedientes"></span></td>
            </tr>
            <tr>
                <td width="114">Unidad origen:</td>
                <td width="188"><span class="trn_uni_origen"></span></td>
                <td width="109">Sub-Fondo Destino:</td>
                <td width="190"><?php echo $fondo_des ?>
        <!--    	<input type="text" name="inst_fondo" id="inst_fondo" value="<?php //echo $inst_fondo_id  ?>">-->
                    <input type="hidden" name="trn_usuario_orig" id="trn_usuario_orig" value="">
                </td>
            </tr>
            <tr>
                <td>Usuario origen:</td>
                <td><span class="trn_usuario_orig"></span></td>
                <td>Usuario destino:</td>
                <td>
                    <select name="trn_usuario_des" id="trn_usuario_des" class="required" style="width:190px">
                        <option value="">-Seleccionar-</option>
                        <?php echo $trn_usuario_des ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Descripci&oacute;n:</td>
                <td colspan="3"><label>
                        <textarea name="trn_descripcion" id="trn_descripcion" cols="80" rows="3" class="required"></textarea>
                    </label></td>
            </tr>
        </table>
    </form>
</div>