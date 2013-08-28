<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form class="validable" id="formA" method="post" name="formA" 
      action="<?php echo $PATH_DOMAIN ?>/sistema/<?php echo $PATH_EVENT ?>/">
    <input name="sis_id" id="sis_id" type="hidden" value="<?php echo $sis_id; ?>" />    
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/sistema/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'sis_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'sis_codigo', width : 80, sortable : true, align: 'left'},
            {display: 'Nombre del Sistema', name : 'sis_nombre', width : 400, sortable : true, align: 'left'},
            {display: 'Tipo de Carga', name : 'sis_tipcarga', width : 100, sortable : true, align: 'left'},
            {display: 'Tamaño Maximo (MB.)', name : 'sis_tammax', width : 100, sortable : true, align: 'left'},
            {display: 'Ruta de Carga', name : 'sis_ruta', width : 100, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'sis_id', isdefault: true},
            {display: 'Código', name : 'sis_codigo'},
            {display: 'Nombre del Sistema', name : 'sis_nombre'},
            {display: 'Tipo de Carga', name : 'sis_tipcarga'},
            {display: 'Tamaño Maximo (MB)', name : 'sis_tammax'},
            {display: 'Ruta de Carga', name : 'sis_ruta'},
        ],
        sortname: "sis_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE DATOS DEL SISTEMA',
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
            $("#sis_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/sistema/edit/");
            document.getElementById('formA').submit();
        }
    }

    function test(com,grid)
    {
        if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#sis_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/sistema/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }

</script>