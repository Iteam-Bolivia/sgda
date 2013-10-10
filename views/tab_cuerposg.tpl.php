<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/cuerpos/<?php echo $PATH_EVENT ?>/">
    <input name="cue_id" id="cue_id" type="hidden" value="<?php echo $cue_id; ?>" />
    <input name="tra_id" id="tra_id" type="hidden" value="<?php echo $tra_id; ?>" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/tramite/index/<?php echo $ser_id; ?>/"><<<< Volver a Grupos Documentales </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cuerpos/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'cue_id', width : 40, sortable : true, align: 'center'},
            {display: 'Orden', name : 'cue_orden', width : 40, sortable : true, align: 'left'},
            {display: 'Descripci&oacute;n', name : 'cue_descripcion', width : 600, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test},{separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'cue_id', isdefault: true},
            {display: 'Orden', name : 'cue_orden'},
            {display: 'Descripci&oacute;n', name : 'cue_descripcion'}
        ],
        sortname: "cue_id",
        sortorder: "asc",
        usepager: true,
        title: 'TIPOS DOCUMENTALES DEL GRUPO: <?php echo $tra_descripcion; ?> ',
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
            $("#cue_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/cuerpos/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
	
        if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/cuerpos/add/<?php echo VAR3; ?>/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#cue_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/cuerpos/edit/");
                document.getElementById('formA').submit();
            }	
            else
            { alert("Seleccione un registro");
            }
        }else if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')
                $.post("<?php echo $PATH_DOMAIN ?>/cuerpos/delete/",{cue_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data =='OK'){
                        $('.pReload',grid.pDiv).click();
                    }else{
                        alert("No se pudo eliminar el registro "+$('.trSelected div',grid).html())
                    }
                });
            }else alert("Seleccione un registro");
        }
    }
</script>