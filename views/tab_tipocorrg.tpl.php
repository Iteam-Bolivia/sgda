<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipocorr/<?php echo $PATH_EVENT ?>/">
    <input name="tco_id" id="tco_id" type="hidden" value="<?php echo $tco_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tipocorr/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'tco_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'tco_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'tco_nombre', width : 600, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            //{name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'tco_id', isdefault: true},
            {display: 'Código', name : 'tco_codigo'},
            {display: 'Nombre', name : 'tco_nombre'},
        ],
        sortname: "tco_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE CLASES DE SERIE',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 390
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#tco_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipocorr/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')){                    
                    $.post("<?php echo $PATH_DOMAIN ?>/tipocorr/delete/",{tco_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                    });  
                }
            }	
            else {
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/tipocorr/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#tco_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipocorr/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
    
</script>