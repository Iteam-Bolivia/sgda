<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/proyecto/<?php echo $PATH_EVENT ?>/">
    <input name="pry_id" id="pry_id" type="hidden"
           value="<?php echo $pry_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/proyecto/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'pry_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'pry_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'pry_nombre', width : 400, sortable : true, align: 'left'},
            {display: 'Ofi. Departamental', name : 'pry_grod', width : 50, sortable : true, align: 'left'},
            {display: 'Ing. Monitoreo Proyecto', name : 'pry_imp', width : 100, sortable : true, align: 'left'},
            {display: 'Estado', name : 'pry_estado', width : 50, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'pry_id', isdefault: true},
            {display: 'Codigo', name : 'pry_codigo'},
            {display: 'Nombre', name : 'pry_nombre'},
            {display: 'OD', name : 'pry_grod'},
            {display: 'IMP', name : 'pry_imp'},
            {display: 'Estado', name : 'pry_estado'}
        ],
        sortname: "pry_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE PROYECTOS',
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
            $("#pry_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/proyecto/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/proyecto/delete/",{pry_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/proyecto/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#pry_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/proyecto/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>
