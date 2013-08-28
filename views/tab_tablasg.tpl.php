<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rol/<?php echo $PATH_EVENT ?>/">
<!-- <input name="rol_id" id="rol_id" type="hidden" value="<?php //echo $rol_id;  ?>" /> -->
    <!-- MODIFIED: CASTELLON -->
    <input name="rol_id" id="rol_id" type="hidden" value="<?php echo $_SESSION['USU_ROL']; ?>" />
    <!-- MODIFIED: CASTELLON -->

</form>


<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tablasparametricas/load/',
        dataType: 'json',
        colNames:['ID','tablax','activo','inactivo','total'],
        colModel : [
            {display: 'Id', name : 'rol_id', width : 50, sortable : true, align: 'center'},
            {display: 'Tablas', name : 'tabla',index:'tabla', width : 200, sortable : true, align: 'left'},
            {display: 'Activos', name : 'activo', width : 100, sortable : true, align: 'center'},
            {display: 'Inactivos', name : 'inactivo', width : 100, sortable : true, align: 'center'},
            {display: 'Total', name : 'total', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Ver', bclass: 'add', onpress : test},
            {separator: true}
        ],
        sortname: "rol_id",
        sortorder: "asc",
        usepager: true,
        title: 'Tablas PARAMETRICAS',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    function test(com,grid)
    {
        if (com=='Delete')
        {
            if($('.trSelected div',grid).html())
            {
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/rol/delete/",{rol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {
						
                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Ver')
        {
            if($('.trSelected',grid).html())
            {	 id = $('.trSelected').attr("id");
                window.location ="<?php echo $PATH_DOMAIN ?>/tablasparametricas/viewTabla/"+id+"/";
            }else alert("Seleccione un registro");
        }
    }
    function dobleClik(grid){
        if($('.trSelected',grid).html())
        {
            id = $('.trSelected').attr("id");
            window.location ="<?php echo $PATH_DOMAIN ?>/tablasparametricas/viewTabla/"+id+"/";
        }
    }

</script>