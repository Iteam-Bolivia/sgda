<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/inventario/<?php echo $PATH_EVENT ?>/">
    <input name="idcom" id="idcom" type="hidden" value="" />    
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/inventario/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Unidad', name : 'fon_cod', width : 40, sortable : true, align: 'left'},
            {display: 'Cod. Expediente', name : 'uni_cod', width : 100, sortable : true, align: 'left'},
            {display: 'Expediente', name : 'tco_codigo', width : 200, sortable : true, align: 'left'},
            {display: 'Caract. F&iacute;sica', name : 'ser_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Cond. Papel', name : 'exp_codigo', width : 60, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Reporte', bclass: 'Reporte', onpress : test},{separator: true} //,
            //{name: 'Editar', bclass: 'edit', onpress : test}<?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Caract. F&iacute;sica', name : 'fon_cod'},
            {display: 'Cod. Expediente', name : 'uni_cod'},
            {display: 'Cond. Papel', name : 'tco_codigo'},
            {display: 'Expediente', name : 'ser_codigo'},
            {display: 'Fecha Recepci&oacute;n', name : 'exp_codigo'}
//            {display: 'Nitidez Escritura', name : 'inv_nitidez_escritura'}
//            {display: 'Ubicaci&oacute;n', name : 'contenedor'},
//            {display: 'Unidad', name : 'uni_codigo'},
//            {display: 'Serie', name : 'ser_categoria', isdefault: true}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE INVENTARIO',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){

            if($("table",grid).attr('id')=="flex1"){
                $("#inv_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/inventario/edit/");
                document.getElementById('formA').submit();

            }
            if($("table",grid).attr('id')=="flex2"){
                $("#exp_id").val($('.trSelected div',grid).html());
                var  id_exp = $("#exp_id").val();
                window.location = "<?php echo $PATH_DOMAIN ?>/inventario/add/"+id_exp+"/";
            }
        }
    }
    
    function test(com,grid)
    {
        if(com=='Adicionar Inventario'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                var  id_exp = $("#exp_id").val();
                window.location = "<?php echo $PATH_DOMAIN ?>/inventario/add/"+id_exp+"/";
            }
            else {alert("Seleccionar un expediente")}
        }else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#inv_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/inventario/edit/");
                document.getElementById('formA').submit();
            }
            else {
                alert("Seleccione un inventario")
            }

        }
        else if (com=='Reporte')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/rpteInventario/";
        }
        else{
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
    $(".ser_categoria").click(function(){
        $(".qsbox").val($(this).html());
        $(".qtype").val('ser_categoria');
        $('.Search').click();
    });
    function test2(com,grid)
    {
        $(".qsbox").val(com);
        $(".qtype").val('ser_categoria');
        $('.Search').click();
    }    
</script>
