<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/subcontenedor/<?php echo $PATH_EVENT ?>/">
    <input name="suc_id" id="suc_id" type="hidden" value="<?php echo $suc_id; ?>" />
</form>
<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/contenedor/"><<<< Volver a Contenedores </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/subcontenedor/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'suc_id', width : 40, sortable : true, align: 'center'},
            //{display: 'Usuario', name : 'usu_nombres', width : 150, sortable : true, align: 'left'},	
            {display: 'Contenedor', name : 'con_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Sub Contenedor', name : 'suc_codigo', width : 150, sortable : true, align: 'left'},
            {display: 'Mtrs. Lineales', name : 'suc_ml', width : 100, sortable : true, align: 'left'},
            {display: 'Nro Balda', name : 'suc_nro_balda', width : 100, sortable : true, align: 'left'}        
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'suc_id', isdefault: true}
        ],
        sortname: "suc_id",
        sortorder: "asc",
        usepager: true,
        title: '<?php echo $usuario; ?> - <?php echo $con_codigo; ?> - LISTA DE SUBCONTENEDORES',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });


    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#suc_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/subcontenedor/edit/");
            document.getElementById('formA').submit();
        }
    }

    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?\n'))
                    $.post("<?php echo $PATH_DOMAIN ?>/subcontenedor/delete/",{suc_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {
					
                        }
                });
            }	
            else {
                alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/subcontenedor/add/<?php echo VAR3; ?>/";
        } 
        else if (com =='Editar'){
            if($('.trSelected div',grid).html()){
                $("#suc_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/subcontenedor/edit/");
                document.getElementById('formA').submit();
            }	
            else {
                alert("Seleccione un registro");
            }
        }
	
	
    }

</script>