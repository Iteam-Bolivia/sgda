<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/tramite/<?php echo $PATH_EVENT ?>/">
    <input name="tra_id" id="tra_id" type="hidden" value="" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/series/"><<<< Volver a Series </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tramite/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'tra_id', width : 40, sortable : true, align: 'center'},
            {display: 'Orden', name : 'tra_orden', width : 40, sortable : true, align: 'center'},
            {display: 'Descripci&oacute;n', name : 'tra_descripcion', width : 600, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Adicionar Tipos Documentales', bclass: 'add', onpress : test}

        ],
        searchitems : [
            {display: 'Id', name : 'tra_id', isdefault: true},
            {display: 'Orden', name : 'tra_orden'},
            {display: 'C&oacute;digo', name : 'tra_codigo'},
            {display: 'Descripci&oacute;n', name : 'tra_descripcion'}
        ],
        sortname: "tra_id",
        sortorder: "asc",
        usepager: true,
        title: 'GRUPOS DOCUMENTALES DE LA SERIE: <?php echo $ser_categoria; ?> ',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#tra_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tramite/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')
                $.post("<?php echo $PATH_DOMAIN ?>/tramite/delete/",{tra_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data =='OK'){
                        $('.pReload',grid.pDiv).click();
                    }else{
                        alert("No se pudo eliminar el registro "+$('.trSelected div',grid).html())
                    }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/tramite/add/<?php echo VAR3; ?>/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#tra_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tramite/edit/");
                document.getElementById('formA').submit();
            }
            else{  alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar Tipos Documentales')
        {
            if($('.trSelected',grid).html())
            {	 $("#tra_id").val($('.trSelected div',grid).html());
                id = $("#tra_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/cuerpos/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }
        
    }
</script>