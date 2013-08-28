<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipoarch/<?php echo $PATH_EVENT ?>/">
    <input name="tar_id" id="tar_id" type="hidden"
           value="<?php echo $tar_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tipoarch/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'tar_id', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'tar_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Descripci&oacute;n', name : 'tar_descripcion', width : 600, sortable : true, align: 'left'},
            {display: 'Orden', name : 'tar_orden', width : 60, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'tar_id', isdefault: true},
            {display: 'Codigo', name : 'tar_codigo'},
            {display: 'Descripcion', name : 'tar_descripcion'},
            {display: 'Orden', name : 'tar_orden'}
        ],
        sortname: "tar_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE TIPOS DE ARCHIVO',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#tar_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipoarch/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/tipoarch/delete/",{tar_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/tipoarch/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#tar_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipoarch/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>