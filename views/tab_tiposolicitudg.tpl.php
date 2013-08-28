<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tiposolicitud/<?php echo $PATH_EVENT ?>/">
    <input name="sol_id" id="sol_id" type="hidden"
           value="<?php echo $sol_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tiposolicitud/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'sol_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'sol_codigo', width : 50, sortable : true, align: 'left'},
            {display: 'Tipo Solicitud', name : 'sol_descripcion', width : 550, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'sol_id', isdefault: true},
            {display: 'Codigo', name : 'sol_codigo'},
            {display: 'Tipo Solicitud', name : 'sol_descripcion'}	
        ],
        sortname: "sol_id",
        sortorder: "asc",
        usepager: true,
        title: 'Tipo Solicitud',
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
            $("#sol_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tiposolicitud/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/tiposolicitud/delete/",{sol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/tiposolicitud/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#sol_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tiposolicitud/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>
