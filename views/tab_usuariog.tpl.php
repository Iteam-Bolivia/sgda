<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/usuario/<?php echo $PATH_EVENT ?>/">
    <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/usuario/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'usu_id', width : 40, sortable : true, align: 'center'},            
            {display: 'Nombres', name : 'usu_nombres', width : 100, sortable : true, align: 'left'},
            {display: 'Apellidos', name : 'usu_apellidos', width : 100, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_descripcion', width : 200, sortable : true, align: 'left'},            
            {display: 'Rol', name : 'rol_cod', width : 30, sortable : true, align: 'left'},
            {display: 'Series que maneja', name : 'series', width : 200, sortable : true, align: 'left'},
            {display: 'Leer Doc.', name : 'usu_leer_doc', width : 50, sortable : true, align: 'left'},
            {display: 'Tel&eacute;fono', name : 'usu_fono', width : 80, sortable : true, align: 'left'},
            {display: 'Email', name : 'usu_email', width : 150, sortable : true, align: 'left'},            
            {display: 'Login', name : 'usu_login', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Clonar', bclass: 'ver', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'usu_id', isdefault: true},
            {display: 'Unidad', name : 'unidad'},
            {display: 'Nombres', name : 'usu_nombres'},
            {display: 'Apellidos', name : 'usu_apellidos'},
            {display: 'Login', name : 'usu_login'},
            {display: 'Rol', name : 'rol_cod'},
            {display: 'Series que maneja', name : 'series'},
            {display: 'Tel&eacute;fono', name : 'usu_fono'},
            {display: 'Email', name : 'usu_email'},
            {display: 'Item', name : 'usu_nro_item'},
            {display: 'Leer Doc. Privados', name : 'usu_leer_doc'}
        ],
        sortname: "usu_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE USUARIOS DEL SISTEMA',
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
            $("#usu_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/usuario/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/usuario/delete/",{usu_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/usuario/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#usu_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/usuario/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Clonar'){
            if($('.trSelected div',grid).html()){
                $("#usu_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/usuario/clonar/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
    
</script>
