<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/nivel/<?php echo $PATH_EVENT ?>/">
    <input name="niv_id" id="niv_id" type="hidden" value="<?php echo $niv_id; ?>" />
</form>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/nivel/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'niv_id', width : 50, sortable : true, align: 'center'},
            {display: 'Nivel Dependencia', name : 'niv_par', width : 100, sortable : true, align: 'left'},
            {display: 'Abreviaci&oacute;n', name : 'niv_abrev', width : 100, sortable : true, align: 'left'},
            {display: 'Descripci&oacute;n', name : 'niv_descripcion', width : 400, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'niv_id', isdefault: true},
            {display: 'Nivel Dependencia', name : 'niv_codigo'},
            {display: 'Abreviaci&oacute;n', name : 'niv_abrev'},
            {display: 'Descripci&oacute;n', name : 'niv_descripcion'}
        ],
        sortname: "niv_id",
        sortorder: "asc",
        usepager: true,
        title: 'NIVELES DE ORGANIGRAMA',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#niv_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nivel/edit/");
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
                        url: "<?php echo $PATH_DOMAIN ?>/nivel/delete/",
                        data: "niv_id="+$('.trSelected div',grid).html(),
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
            window.location="<?php echo $PATH_DOMAIN ?>/nivel/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#niv_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nivel/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>