<div class="clear"></div>
<div class="titulo">Transferencias a Sub-Fondo</div>
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferenciaFondo/<?php echo $PATH_EVENT ?>/">
    <input name="trn_id" id="trn_id" type="hidden" value="<?php echo $trn_id; ?>" />
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferencia/loadTrans/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha Final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
        ],
        buttons : [
            //	{name: 'Reporte', bclass: 'Reporte', onpress : test},{separator: true},
            {name: 'Transferir', bclass: 'view', onpress : test}<?php echo $PATH_A ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'}
        ],
        sortname: "exp_fecha_exf",
        sortorder: "desc",
        usepager: true,
        title: '<?php echo $titulo ?>',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    $("#flex2").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferencia/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 250, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'U. Origen', name : 'uni_origen', width : 50, sortable : true, align: 'left'},
            {display: 'U. Destino', name : 'uni_destino', width : 50, sortable : true, align: 'left'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'},
            {display: 'Conf.', name : 'confirmado', width : 30, sortable : true, align: 'center'},
            {display: 'Motivo', name : 'trn_descripcion', width : 130, sortable : true, align: 'left'}
        ],
        buttons : [

<?php echo $PATH_B ?>
                ],
                searchitems : [
                    {display: 'Id', name : 'exp_id'},
                    {display: 'Serie', name : 'ser_categoria', isdefault: true},
                    {display: 'Codigo', name : 'exp_codigo'},
                    {display: 'Nombre', name : 'exp_nombre'},
                    {display: 'U. Origen', name : 'uni_origen'},
                    {display: 'U. Destino', name : 'uni_destino'},
                    {display: 'Fecha final', name : 'exp_fecha_exf'},
                    {display: 'Confirmado', name : 'confirmado'},
                    {display: 'Motivo', name : 'trn_descripcion'}
                ],
                sortname: "trn_uni_destino",
                sortorder: "asc",
                usepager: true,
                title: '<?php echo $titulo2 ?>',
                useRp: true,
                rp: 10,
                minimize: <?php echo $GRID_SW ?>,
                showTableToggleBtn: true,
                width: 687,
                height: 260
            });
            function dobleClik(grid){
                if($('.trSelected div',grid).html()){
                    $("#exp_id").val($('.trSelected div',grid).html());
                    if($("table",grid).attr('id')=="flex1"){
                        $("#exp_id").val($('.trSelected div',grid).html());
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/expediente/find/",
                            data: "exp_id="+$('.trSelected div',grid).html(),
                            dataType: 'json',
                            success: function(msg){
                                $.each(msg, function(i,item){
                                    $("#trn_uni_origen").val(item.uni_id);
                                    $(".exp_id").html(item.exp_nombre);
                                    $(".trn_uni_origen").html(item.uni_codigo);
                                    $("#trn_usuario").val(item.usu_id);
                                    $(".trn_usuario_orig").html(item.usu_nombres+" "+item.usu_apellidos);
                                });
                            },
                            error: function(msg){
                                //alert(msg);
                            }
                        });
                        $('#dialog-form').dialog('open');
                    }
                    if($("table",grid).attr('id')=="flex2"){
                        if($('.trSelected div',grid).html()){

                        }else{

                        }
                    }
                }
            }
            function test(com,grid)
            {

                if(com=="Transferir"){
                    if($('.trSelected div',grid).html()){
                        $("#exp_id").val($('.trSelected div',grid).html());
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/expediente/find/",
                            data: "exp_id="+$('.trSelected div',grid).html(),
                            dataType: 'json',
                            success: function(msg){
                                $.each(msg, function(i,item){
                                    $("#trn_uni_origen").val(item.uni_id);
                                    $(".exp_id").html(item.exp_nombre);
                                    $(".trn_uni_origen").html(item.uni_codigo);
                                    $("#trn_usuario").val(item.usu_id);
                                    $(".trn_usuario_orig").html(item.usu_nombres+" "+item.usu_apellidos);
                                });
                            },
                            error: function(msg){
                                //alert(msg);
                            }
                        });
                        $('#dialog-form').dialog('open');
                    }else{
                        alert("Seleccione un registro");
                    }
                }

                else{
                    $(".qsbox",grid).val(com);
                    $('.Search',grid).click();
                }
            }
            function test2(com,grid)
            {
                //alert($(grid).html());
                $(".qsbox",grid).val(com);
                $('.Search',grid).click();
            }
            $(function() {
                $("#trn_uni_destino").change(function(){
                    //alert("Aqui."+ $(this).val());
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/usuario/listUsuarioJson/",
                        data: "uni_id="+$(this).val(),
                        dataType: 'json',
                        success: function(msg){
                            //alert(msg.usu_nombres);
                            $("#trn_usuario_des").html('');
                            $.each(msg, function(i,item){
                                //alert(item.usu_id);
                                $("#trn_usuario_des").append("<option value='"+item.usu_id+"'>"+item.usu_nombres+" "+item.usu_apellidos+"</option>");
                            });
                        },
                        error: function(msg){
                            //alert(msg);
                        }
                    });
                });
                $("#dialog-form").dialog({
                    stackfix: true,
                    autoOpen: false,
                    height: 255,
                    width: 685,
                    modal: true,
                    buttons: {
                        Cancelar: function() {
                            $(this).dialog('close');
                        },
                        Enviar: function() {
                            var sw = true;
                            if(!$("#trn_uni_destino").val()){
                                sw = false;
                            }
                            if(!$("#trn_usuario_des").val()){
                                sw = false;
                            }
                            if(!$("#trn_descripcion").val()){
                                sw = false;
                            }
                            if(sw){
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo $PATH_DOMAIN ?>/transferencia/save/",
                                    data: "exp_id="+$("#exp_id").val()+"&trn_uni_origen="+$("#trn_uni_origen").val()+"&trn_uni_destino="+$("#trn_uni_destino").val()+"&trn_usuario_des="+$("#trn_usuario_des").val()+"&trn_descripcion="+$("#trn_descripcion").val()+"&trn_usuario_orig= "+ $("#trn_usuario").val(),
                                    success: function(msg){
                                        $(".pReload",".flexigrid").click();
                                        $("#dialog-form").dialog('close');
                                    },
                                    error: function(msg){
                                        alert(msg);
                                    }
                                });
                            }
                        }
                    },
                    close: function() {

                    }
                });

            });
</script>
<div id="dialog-form" title="Enviar expediente">
    <form>
        <input name="exp_id" id="exp_id" type="hidden" value="" />
        <input name="trn_uni_origen" id="trn_uni_origen" type="hidden" value="" />
        <input name="trn_usuario" id="trn_usuario" type="hidden" value="" />

        <table width="665" border="0">
            <tr>
                <td>Expediente:</td>
                <td colspan="3"><span class="exp_id"></span></td>
            </tr>
            <tr>
                <td width="142">Unidad origen:</td>
                <td width="184"><span class="trn_uni_origen"></span></td>
                <td width="114">Unidad destino:</td>
                <td width="197">
                    <select name="trn_uni_destino" id="trn_uni_destino" class="required" style="width:190px">
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_uni_destino ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Usuario origen:</td>
                <td><span class="trn_usuario_orig"></span></td>
                <td>Usuario destino:</td>
                <td>
                    <select name="trn_usuario_des" id="trn_usuario_des" class="required" style="width:190px">
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_usuario_des ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Descripci&oacute;n:</td>
                <td colspan="3"><label>
                        <textarea name="trn_descripcion" id="trn_descripcion" cols="80" rows="3"></textarea>
                    </label></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
