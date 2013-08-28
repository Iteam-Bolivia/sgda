<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/expcampo/<?php echo $PATH_EVENT ?>/">
    <input name="ecp_id" id="ecp_id" type="hidden" value="" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/series/"><<<< Volver a Series </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/expcampo/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ecp_id', width : 50, sortable : true, align: 'center'},
            {display: 'Orden', name : 'ecp_orden', width : 50, sortable : true, align: 'left'},
            {display: 'Nombre campo', name : 'ecp_nombre', width : 200, sortable : true, align: 'left'},
            {display: 'Etiqueta', name : 'ecp_eti', width : 150, sortable : true, align: 'left'},
            {display: 'Tipo dato', name : 'ecp_tipdat', width : 100, sortable : true, align: 'left'},
            {display: 'Estado', name : 'ecp_estado', width : 40, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Adicionar datos a lista', bclass: 'add', onpress : test}

        ],
        searchitems : [
            {display: 'Id', name : 'ecp_id', isdefault: true},
            {display: 'Orden', name : 'ecp_orden'},
            {display: 'Nombre campo', name : 'ecp_nombre'},
            {display: 'Etiqueta', name : 'ecp_eti'},
            {display: 'Tipo dato', name : 'ecp_tipdat'}
        ],
        sortname: "ecp_id",
        sortorder: "asc",
        usepager: true,
        title: 'DATOS ADICIONALES - SERIE: <?php echo $ser_categoria; ?> ',
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
            $("#ecp_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expcampo/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/expcampo/delete/",{ecp_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/expcampo/add/<?php echo VAR3; ?>/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ecp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expcampo/edit/");
                document.getElementById('formA').submit();
            }
            else{  alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar datos a lista')
        {
            if($('.trSelected',grid).html())
            {	
                $("#ecp_id").val($('.trSelected div',grid).html());
                id = $("#ecp_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/expcampolista/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }        
    }
</script>