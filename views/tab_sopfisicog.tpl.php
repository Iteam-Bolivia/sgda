<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/sopfisico/<?php echo $PATH_EVENT ?>/">
    <input name="sof_id" id="sof_id" type="hidden"
           value="<?php echo $sof_id; ?>" />
</form>


<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/sopfisico/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'sof_id', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'sof_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'sof_nombre', width : 600, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'sof_id', isdefault: true},
            {display: 'C&oacute;digo', name : 'sof_codigo'},
            {display: 'Nombre', name : 'sof_nombre'}
        ],
        sortname: "sof_id",
        sortorder: "asc",
        usepager: true,
        title: 'SOPORTE F&Iacute;SICO DE LOS DOCUMENTOS',
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
            $("#sof_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/sopfisico/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/sopfisico/delete/",{sof_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/sopfisico/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#sof_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/sopfisico/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>