<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/tablasparametricas/<?php echo $PATH_EVENT ?>/">
    <!-- MODIFIED: CASTELLON 
    <input name="campo_id" id="campo_id" type="hidden" value="<?php //echo $campo_id;  ?>" />
    -->	
    <input name="campo_id" id="campo_id" type="hidden" value="<?php echo 0; ?>" />
</form>
<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/tablasparametricas/"><<--Volver a tablas perimetricas<<--</a></p>
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tablasparametricas/loadTabla/<?php echo $nombreTabla; ?>/<?php echo $activo; ?>/',
        dataType: 'json',
        colNames:['ID','tablax','activo','inactivo','total'],
        colModel : [
<?php echo $displayColModel; ?>
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},	
            {separator: true},
            {name: 'Ver todos', bclass: 'todos', onpress : test},
            {separator: true},
            {name: 'Ver Activos', bclass: 'activo', onpress : test},
            {separator: true},
            {name: 'Ver Inactivos', bclass: 'inactivo', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: '<?php echo $campoEstado; ?>', name : '<?php echo $campoEstado; ?>', isdefault: true}
        ],
        sortname: "<?php echo $campo1; ?>",
        sortorder: "asc",
        usepager: true,
        title: 'Tabla " <?php echo $nombreTabla; ?> " <?php echo $estadoRegistro; ?>',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });



    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html())
            {
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/tablasparametricas/delete/<?php echo $nombreTabla; ?>/",{campo_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/tablasparametricas/add/<?php echo $nombreTabla; ?>/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#campo_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tablasparametricas/edit/<?php echo $nombreTabla; ?>/");
                document.getElementById('formA').submit();
            }	
            else 
            {alert("Seleccione un registro.");}
        }
        else{
            $(".qsbox").val(com);
            $('.Search',grid.pDiv).click();
        }

    }
    function dobleClik(grid){
        if($('.trSelected',grid).html())
        {
            $("#campo_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tablasparametricas/edit/<?php echo $nombreTabla; ?>/");
            document.getElementById('formA').submit();
        }
    }

</script>