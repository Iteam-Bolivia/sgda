<p><table id="flex1" style="display:none"></table></p>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/prestamos/<?php echo $PATH_EVENT ?>/">
    <input name="spr_id" id="spr_id" type="hidden" value="<?php echo spr_id; ?>" />    
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo 0; ?>" />
    <input name="idcom" id="idcom" type="hidden" value="" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/prestamos/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'spr_id', width : 30, sortable : true, align: 'center'},
            {display: 'Fecha', name : 'spr_fecha', width : 100, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_id', width : 200, sortable : true, align: 'left'},
            {display: 'Usuario', name : 'usu_id', width : 80, sortable : true, align: 'center'},
            {display: 'Solicitante', name : 'spr_solicitante', width : 85, sortable : true, align: 'center'},
            {display: 'Fecha Entrega', name : 'spr_fecent', width : 100, sortable : true, align: 'left'},
            {display: 'Fecha Ren.', name : 'spr_fecren', width : 130, sortable : true, align: 'left'},
            {display: 'Autorizado por', name : 'usua_id', width : 230, sortable : true, align: 'left'},
            {display: 'Custodio', name : 'usur_id', width : 230, sortable : true, align: 'left'},
            {display: 'Fecha Dev.', name : 'spr_fecdev', width : 230, sortable : true, align: 'left'},
            {display: 'Observaciones', name : 'spr_obs', width : 230, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'ReporteN', bclass: 'reporteN', onpress : test},{separator: true},
            {name: 'Devolver', bclass: 'devolver', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test}<?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'spr_id'},
            {display: 'Serie', name : 'spr_fecha', isdefault: true},
            {display: 'Cod. Expediente', name : 'uni_id'},
            {display: 'Expediente', name : 'usu_id'},
            {display: 'Solicitante', name : 'spr_solicitante'},
            {display: 'Instituci&oacute;n', name : 'spr_fecent'},
            {display: 'Motivo', name : 'spr_fecren'},
            {display: 'Fecha Pr&eacute;stamo', name : 'usua_id'},
            {display: 'Fecha Devoluci&oacute;n', name : 'usur_id'},
            {display: 'Fecha Devoluci&oacute;n', name : 'spr_fecdev'},
            {display: 'Fecha Devoluci&oacute;n', name : 'spr_obs'}
        ],
        sortname: "spr_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTADO DE PR&Eacute;STAMOS DE DOCUMENTOS ',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 150,
        autoload: false
    });


    $("#flex2").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/prestamos/loadExp/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            /*	{display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},*/
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha Final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Reporte', bclass: 'reporte', onpress : test},{separator: true},
            {name: 'Prestar', bclass: 'prestar', onpress : test2}<?php echo ($PATH_B != '' ? ',' . $PATH_B : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title:"Expedientes",
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 150,
        autoload: false
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            if($("table",grid).attr('id')=="flex2"){
                $("#exp_id").val($('.trSelected div',grid).html());
                var  id_exp =$('.trSelected div',grid).html();
                window.location="<?php echo $PATH_DOMAIN ?>/prestamos/add/"+id_exp+"/";
            }
            if($("table",grid).attr('id')=="flex1"){
                $("#pre_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/prestamos/edit/");
                document.getElementById('formA').submit();
            }
        }
    }
    function test(com,grid)
    {
        if (com=='Devolver')
        {
            if($('.trSelected div',grid).html()){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/prestamos/devolver/",
                    data: "pre_id="+$('.trSelected div',grid).html(),
                    dataType: 'json',
                    success: function(msg){
                        $.each(msg, function(i,item){
                            $("#exp_nombre").html(item.exp_nombre);
                            $("#pre_id").val(item.pre_id);
                            $("#ubicacion").html(item.ubicacion);
                            $("#pre_doc_aval").html(item.pre_doc_aval);
                        });
                    },
                    error: function(msg){
                        //alert(msg);
                    }
                });
                $('#dialog-form').dialog('open');
            }else alert("Seleccione un registro");
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#pre_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/prestamos/edit/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
        else 	if (com=='ReporteN')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/rptePrestamosNoDevueltos/";
        }
        else 	if (com=='Reporte')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/rptePrestamos/";
        }
        else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }

    }
    function test2(com, grid)
    {
        if (com=='Prestar'){
            if($('.trSelected div',grid).html()){
                var  id_exp =$('.trSelected div',grid).html();
                window.location="<?php echo $PATH_DOMAIN ?>/prestamos/add/"+id_exp+"/";
            }else alert("Seleccione un registro");
        }else 	if (com=='Reporte')
        {
            $("#rp").val($(".pDiv2 select ",grid).val());
            $("#qtype").val($(".sDiv2 select ",grid).val());
            $("#query").val($(".qsbox ",grid).val());
            $("#sortname").val($(".sorted ",grid).attr('abbr'));
            $("#sortorder").val($(".sorted div",grid).attr('class'));
            $("#page").val($(".pcontrol input",grid).val());
            $("#rpt").attr("action","<?php echo $PATH_DOMAIN ?>/prestamos/rptExp/");
            $('#rpt').submit();
        }else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }

    }

    $(function() {
        $("#dialog-form").dialog({
            stackfix: true,
            autoOpen: false,
            height: 260,
            width: 450,
            modal: true,
            buttons: {
                Cancelar: function() {
                    $(this).dialog('close');
                },
                Devolver: function() {
                    var sw = true;
                    if(!$("#pre_descripcion").val()){
                        sw = false;
                    }
                    if(sw){
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/prestamos/delete/",
                            data: "pre_id="+$("#pre_id").val()+"&pre_descripcion="+$("#pre_descripcion").val(),
                            success: function(msg){
                                $(".pReload",".flexigrid").click();

                                $(".qsbox").val($('#idcom').val());
                                $(".qtype").val('ser_categoria');
                                $('.Search').click();
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
<div id="dialog-form" title="Devolver un Expediente">


    <form>
        <table width="427" border="0">
            <tr>
                <td>Expediente:</td>
                <td><span id="exp_nombre"></span></td>
            </tr>
            <tr>
                <td>Estado de la Devoluci&oacute;n:</td>
                <td><textarea name="pre_descripcion" id="pre_descripcion" cols="40" rows="2"></textarea></td>
            </tr>
            <tr>
                <td width="160">Documento de Aval:</td>
                <td width="257"><span id="pre_doc_aval"></span></td>
            </tr>
            <tr>
                <td>Ubicaci&oacute;n:</td>
                <td><span id="ubicacion"></span></td>
            </tr>
        </table>
    </form>
</div>