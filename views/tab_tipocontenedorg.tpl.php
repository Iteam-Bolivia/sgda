<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/tipocontenedor/<?php echo $PATH_EVENT ?>/">
    <input name="ctp_id" id="ctp_id" type="hidden" value="<?php echo $ctp_id; ?>" />
</form>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/tipocontenedor/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ctp_id', width : 50, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'ctp_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Descripcion', name : 'ctp_descripcion', width : 600, sortable : true, align: 'left'},
            {display: 'Nivel', name : 'ctp_nivel', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'ctp_id', isdefault: true},
            {display: 'Codigo', name : 'ctp_codigo'},
            {display: 'Descripcion', name : 'ctp_descripcion'},
            {display: 'Nivel', name : 'ctp_nivel'}
        ],
        sortname: "ctp_id",
        sortorder: "asc",
        usepager: true,
        title: 'TIPOS DE CONTENEDORES/SUBCONTENEDORES',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#ctp_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipocontenedor/edit/");
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
                        url: "<?php echo $PATH_DOMAIN ?>/tipocontenedor/delete/",
                        data: "ctp_id="+$('.trSelected div',grid).html(),
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
            window.location="<?php echo $PATH_DOMAIN ?>/tipocontenedor/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ctp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tipocontenedor/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>