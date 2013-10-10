<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/ubicacion/<?php echo $PATH_EVENT ?>/">
    <input name="ubi_id" id="ubi_id" type="hidden" value="<?php echo $ubi_id; ?>" />
</form>

<div id="dialog-form" title="Create new user">
    <div class="clear"></div>
    <p><table id="flex2" style="display:none"></table></p>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/ubicacion/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ubi_id', width : 40, sortable : true, align: 'center'},
            {display: 'Departamento', name : 'loc_nombre', width : 80, sortable : true, align: 'left'},
            {display: 'Provincia', name : 'loc_nombre', width : 80, sortable : true, align: 'left'},
            {display: 'Ciudad', name : 'loc_nombre', width : 80, sortable : true, align: 'left'},
            {display: 'C&oacute;digo', name : 'ubi_codigo', width : 60, sortable : true, align: 'left'},	
            {display: 'Descripci&oacute;n', name : 'ubi_descripcion', width : 300, sortable : true, align: 'left'},
            {display: 'Direcci&oacute;n', name : 'ubi_direccion', width : 250, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Pisos', bclass: 'ver', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'ubi_id', isdefault: true},
            {display: 'Departamento', name : 'loc_nombre'},
            {display: 'Provincia', name : 'loc_nombre'},
            {display: 'Localidad', name : 'loc_nombre'},
            {display: 'C&oacute;digo', name : 'ubi_codigo'},
            {display: 'Descripci&oacute;n', name : 'ubi_descripcion'},
            {display: 'Direcci&oacute;n', name : 'ubi_direccion'}
        ],
        sortname: "ubi_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA UBICACIONES DE EDIFICIOS',
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
            $("#ubi_id").val($('.trSelected div',grid).html());
            id = $("#ubi_id").val();
            window.location ="<?php echo $PATH_DOMAIN ?>/ubicacion/pisog/"+id+"/";
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?\nSe eliminaran los pisos existentes a este edificio'))
                    $.post("<?php echo $PATH_DOMAIN ?>/ubicacion/delete/",{ubi_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/ubicacion/add/";
        } 
        else if (com =='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ubi_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/ubicacion/edit/");
                document.getElementById('formA').submit();
            }	
            else {
                alert("Seleccione un registro");
            }
        }
        else if (com=='Pisos')
        {
            if($('.trSelected',grid).html())
            {	 $("#ubi_id").val($('.trSelected div',grid).html());
                id = $("#ubi_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/ubicacion/pisog/"+id+"/";
            }
            else alert("Seleccione un registro");	
        }
	
    }


    $(function() {
        // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
        $("#dialog").dialog("destroy");
	
        $("#dialog-form").dialog({
            stackfix: true,
            autoOpen: false,
            height: 431,
            width: 716,
            modal: true
        });
    });

</script>