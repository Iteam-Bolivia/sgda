<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/lecturaArchivos/<?php echo $PATH_EVENT ?>/">

    <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
</form>
<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/lecturaArchivos/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'usu_id', width : 40, sortable : true, align: 'center'},
            {display: 'Unidad', name : 'uni_id', width : 50, sortable : true, align: 'left'},
            {display: 'Nombres', name : 'usu_nombres', width : 100, sortable : true, align: 'left'},
            {display: 'Login', name : 'usu_login', width : 100, sortable : true, align: 'left'},
            {display: 'Leer Doc. Privados', name : 'usu_leer_doc', width : 90, sortable : true, align: 'left'},
            {display: 'Rol', name : 'rol_cod', width : 30, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Editar', bclass: 'view', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'usu_id', isdefault: true},
            {display: 'Unidad', name : 'unidad'},
            {display: 'Nombres', name : 'usu_nombres'},
            {display: 'Apellidos', name : 'usu_apellidos'},
            {display: 'Login', name : 'usu_login'},
            {display: 'Rol', name : 'rol_cod'},
            {display: 'Leer Doc. Privados', name : 'usu_leer_doc'}
        ],
        sortname: "usu_id",
        sortorder: "asc",
        usepager: true,
        title: 'Permiso de Lectura de Usuario',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#usu_id").val($('.trSelected div',grid).html());
            window.location="<?php echo $PATH_DOMAIN ?>/lecturaArchivos/view/"+$("#usu_id").val()+"/";
        }
    }
    function test(com,grid)
    {
        if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#usu_id").val($('.trSelected div',grid).html());
                window.location="<?php echo $PATH_DOMAIN ?>/lecturaArchivos/view/"+$("#usu_id").val()+"/";
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>
