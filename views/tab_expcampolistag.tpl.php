<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/expcampolista/<?php echo $PATH_EVENT ?>/">
    <input name="ecl_id" id="ecl_id" type="hidden" value="<?php echo $ecl_id; ?>" />
    <input name="ecp_id" id="ecp_id" type="hidden" value="<?php echo $ecp_id; ?>" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/expcampo/index/<?php echo $ser_id; ?>/"><<<< Volver a Campos </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/expcampolista/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ecl_id', width : 40, sortable : true, align: 'center'},
            {display: 'Valor', name : 'ecl_valor', width : 200, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test},{separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'ecl_id', isdefault: true},
            {display: 'Valor', name : 'ecl_valor'}
        ],
        sortname: "ecl_id",
        sortorder: "asc",
        usepager: true,
        title: 'DATOS DE LISTA: <?php echo $ecp_tipdat; ?> ',
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
            $("#ecl_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expcampolista/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
	
        if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/expcampolista/add/<?php echo VAR3; ?>/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ecl_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expcampolista/edit/");
                document.getElementById('formA').submit();
            }	
            else
            { alert("Seleccione un registro");
            }
        }else if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')
                $.post("<?php echo $PATH_DOMAIN ?>/expcampolista/delete/",{ecl_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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