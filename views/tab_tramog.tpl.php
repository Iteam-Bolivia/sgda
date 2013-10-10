<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tramo/<?php echo $PATH_EVENT ?>/">
    <input name="trm_id" id="trm_id" type="hidden"
           value="<?php echo $trm_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tramo/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'trm_id', width : 40, sortable : true, align: 'center'},
            {display: 'Proyecto', name : 'pry_id', width : 250, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'trm_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'trm_nombre', width : 250, sortable : true, align: 'left'},
            {display: 'Estado', name : 'trm_estado', width : 40, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'trm_id', isdefault: true},
            {display: 'Proyecto', name : 'pry_id'},
            {display: 'Codigo', name : 'trm_codigo'},
            {display: 'Nombre', name : 'trm_nombre'},
            {display: 'Estado', name : 'trm_estado'}
        ],
        sortname: "trm_id",
        sortorder: "asc",
        usepager: true,
        title: 'Tramo',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#trm_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tramo/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/tramo/delete/",{trm_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/tramo/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#trm_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tramo/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>
