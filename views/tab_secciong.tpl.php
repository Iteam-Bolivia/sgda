<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/seccion/<?php echo $PATH_EVENT ?>/">
    <input name="sec_id" id="sec_id" type="hidden"
           value="<?php echo $sec_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/seccion/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'sec_id', width : 40, sortable : true, align: 'center'},
            {display: 'Unidad', name : 'uni_descripcion', width : 150, sortable : true, align: 'left'},
            {display: 'Código', name : 'sec_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'sec_nombre', width : 400, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'sec_id', isdefault: true},
            {display: 'Unidad', name : 'uni_descripcion'},
            {display: 'Código', name : 'sec_codigo'},
            {display: 'Nombre', name : 'sec_nombre'},
        ],
        sortname: "sec_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE SECCIONES',
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
            $("#sec_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/seccion/edit/");
            document.getElementById('formA').submit();
        }
    }

    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/seccion/delete/",{sec_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }
            else {
                alert("Seleccione un registro");
            }
        }

        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/seccion/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#sec_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/seccion/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }

</script>