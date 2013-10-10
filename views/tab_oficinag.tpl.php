<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/oficina/<?php echo $PATH_EVENT ?>/">
    <input name="ofi_id" id="ofi_id" type="hidden" value="<?php echo $ofi_id; ?>" />
</form>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/oficina/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ofi_id', width : 50, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'ofi_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Oficina', name : 'ofi_nombre', width : 450, sortable : true, align: 'left'},
            {display: 'Contador', name : 'ofi_contador', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'ofi_id', isdefault: true},
            {display: 'Codigo', name : 'ofi_codigo'},
            {display: 'Oficina', name : 'ofi_nombre'},
            {display: 'Contador', name : 'ofi_contador'}
        ],
        sortname: "ofi_id",
        sortorder: "asc",
        usepager: true,
        title: 'OFICINAS ABC',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#ofi_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/oficina/edit/");
            document.getElementById('formA').submit();
        }	
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/oficina/delete/",
                        data: "ofi_id="+$('.trSelected div',grid).html(),
                        dataType: 'text',
                        success: function(msg){
                            if(msg=='OK'){
                                $('.pReload',grid.pDiv).click();
                            }else{
                                alert(msg);
                            }
                        }
                    });
                }
            }
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/oficina/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ofi_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/oficina/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>