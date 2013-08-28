<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/<?php echo $PATH_EVENT ?>/">
    <input name="con_id" id="con_id" type="hidden" value="<?php echo $con_id; ?>" />
</form>

<?php if ($PATH_CONTROLADOR == 'contenUsuario'): ?>
    <p align="right"><a href="<?php echo $PATH_DOMAIN ?>/perfil/view/" id="volver"><<--Volver a Perfil<<--</a></p>
<?php endif; ?>

<script type="text/javascript">
$("#flex1").flexigrid
({
    url: '<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/load/',
    dataType: 'json',
    colModel : [
    {display: 'id', name : 'con_id', width : 40, sortable : true, align: 'center'},
    <?php if ($adm) { ?>
        {display: 'Usuario', name : 'usu_nomape', width : 150, sortable : true, align: 'left'},
        {display: 'Tipo', name : 'ctp_descripcion', width : 100, sortable : true, align: 'left'},
        {display: 'Codigo', name : 'con_codigo', width : 100, sortable : true, align: 'left'},
        {display: 'Codigo BBSS', name : 'con_codbs', width : 100, sortable : true, align: 'left'},
        {display: 'Unidad', name : 'uni_codigo', width : 300, sortable : true, align: 'left'},                        
        
    <?php } else { ?>
        {display: 'Usuario', name : 'usu_nomape', width : 150, sortable : true, align: 'left'},
        {display: 'Tipo', name : 'ctp_descripcion', width : 100, sortable : true, align: 'left'},
        {display: 'Codigo', name : 'con_codigo', width : 100, sortable : true, align: 'left'},
        {display: 'Codigo BBSS', name : 'con_codbs', width : 100, sortable : true, align: 'left'},
        {display: 'Unidad', name : 'uni_codigo', width : 300, sortable : true, align: 'left'},	
        
    <?php } ?>
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Imprimir', bclass: 'print', onpress : test},
            {separator: true},
            {name: 'Subcontenedor', bclass: 'subcontainer', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'con_id'},
            {display: 'Tipo', name : 'ctp_codigo'},
            {display: 'Codigo', name : 'con_codigo'},
            <?php if ($adm) { ?>
                {display: 'Unidad', name : 'uni_codigo', isdefault: true},
                {display: 'Usuario', name : 'usu_nomape'}
            <?php } ?>
        ],
        sortname: "con_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE CONTENEDORES DE USUARIOS',
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
            $("#con_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/delete/",{con_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/add/<?php echo $con_id; ?>/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#con_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/edit/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
        else if (com=='Subcontenedor')
        {
            if($('.trSelected',grid).html())
            {	 $("#con_id").val($('.trSelected div',grid).html());
                id = $("#con_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/subcontenedor/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }        
    }
</script>