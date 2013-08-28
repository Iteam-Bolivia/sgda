<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/progdesastres/<?php echo $PATH_EVENT ?>/">
    <input name="dpr_id" id="dpr_id" type="hidden" value="<?php echo $dpr_id; ?>" />
    <input name="des_id" id="des_id" type="hidden" value="<?php echo $des_id; ?>" />
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer"><a href="#" class="byLogos"
                    title="Desarrollado por ITeam business technology">Desarrollado por
        ITeam business technology</a></div>
</div>

<div id="dialog-form" title="Importacion de datos">
    <p class="validateTips">Se esta importando datos, espere porfavor....</p>
</div>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/importacion/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'imp_id', width : 30, sortable : true, align: 'center'},
            {display: 'Usuario', name : 'usu_id', width : 230, sortable : true, align: 'left'},
            {display: 'Tabla', name : 'imp_descripcion', width : 100, sortable : true, align: 'left'},
            {display: 'Modificados', name : 'imp_num_up', width : 50, sortable : true, align: 'left'},
            {display: 'Nuevos', name : 'imp_num_new', width : 50, sortable : true, align: 'left'},
            {display: 'Fecha Imp.', name : 'imp_fecha', width : 50, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Reporte', bclass: 'reporte', onpress : test},
            {separator: true},
            {name: 'Usuarios', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'SIN', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'ONG', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'FIN', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'CIF', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'RNC', bclass: 'add', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'imp_id', isdefault: true},
            {display: 'Usuario', name : 'usu_id'},
            {display: 'Tabla', name : 'imp_descripcion'},
            {display: 'Modificados', name : 'imp_num_up'},
            {display: 'Nuevos', name : 'imp_num_new'},
            {display: 'Fecha Imp.', name : 'imp_fecha'}
        ],
        sortname: "imp_id",
        sortorder: "desc",
        usepager: true,
        title: 'Datos de Importacion',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#des_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/progdesastres/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Usuarios')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/usu/",{} ,function(data){
                if(!data){
                    $('.pReload',grid.pDiv).click();
                    $('#dialog-form').dialog('close');
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
        else if (com=='SIN')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/tesin/",{} ,function(data){
                if(!data){
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
        else if (com=='ONG')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/teong/",{} ,function(data){
                if(!data){
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
        else if (com=='FIN')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/tefin/",{} ,function(data){
                if(!data){
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
        else if (com=='CIF')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/tecif/",{} ,function(data){
                if(!data){
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
        else if (com=='Reporte')
        {
            //alert($(".flexigrid .pcontrol input").val());
            $("#rp").val($(".flexigrid .pDiv2 select ").val());
            $("#qtype").val($(".flexigrid .sDiv2 select ").val());
            $("#query").val($(".flexigrid .qsbox ").val());
            $("#sortname").val($(".flexigrid .sorted ").attr('abbr'));
            $("#sortorder").val($(".flexigrid .sorted div").attr('class'));
            $("#page ").val($(".flexigrid .pcontrol input").val());
            $("#rpt").attr("action","<?php echo $PATH_DOMAIN ?>/importacion/rpt/");
            $('#rpt').submit();
        }else if (com=='RNC')
        {
            $('#dialog-form').dialog('open');
            $.post("<?php echo $PATH_DOMAIN ?>/importacion/ternc/",{} ,function(data){
                if(!data){
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }else{
                    $(".validateTips").append(data);
                    $.post("<?php echo $PATH_DOMAIN ?>/importacion/saveError/",{'ImError':data} ,function(data){});
                    $('#dialog-form').dialog('close');
                    $('.pReload',grid.pDiv).click();
                }
            });
        }
    }


    $(function() {
        $("#dialog-form").dialog({
            stackfix: true,
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true
        });

    });
</script>
</body>
</html>