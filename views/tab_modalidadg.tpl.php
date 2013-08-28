<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/modalidad/<?php echo $PATH_EVENT ?>/">
    <input name="mod_id" id="mod_id" type="hidden"
           value="<?php echo $mod_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/modalidad/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'mod_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'mod_codigo', width : 50, sortable : true, align: 'left'},
            {display: 'Modalidad', name : 'mod_descripcion', width : 550, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'mod_id', isdefault: true},
            {display: 'Codigo', name : 'mod_codigo'},
            {display: 'Modalidad', name : 'mod_descripcion'}
        ],
        sortname: "mod_id",
        sortorder: "asc",
        usepager: true,
        title: 'Modalidades',
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
            $("#mod_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/modalidad/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/modalidad/delete/",{mod_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/modalidad/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#mod_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/modalidad/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>