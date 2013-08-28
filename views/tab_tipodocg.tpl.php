<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tipodoc/<?php echo $PATH_EVENT ?>/">
    <input name="tdo_id" id="tdo_id" type="hidden"
           value="<?php echo $tdo_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tipodoc/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'tdo_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'tdo_codigo', width : 80, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'tdo_nombre', width : 700, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'tdo_id', isdefault: true},
            {display: 'Código', name : 'tdo_codigo'},
            {display: 'Nombre', name : 'tdo_nombre'},
        ],
        sortname: "tdo_id",
        sortorder: "asc",
        usepager: true,
        title: 'Tipo Documento',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 390
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#tdo_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipodoc/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/tipodoc/delete/",{tdo_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/tipodoc/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#tdo_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipodoc/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
        
    }
</script>