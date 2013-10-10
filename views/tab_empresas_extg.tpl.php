<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/empresas_ext/<?php echo $PATH_EVENT ?>/">
    <input name="emp_id" id="emp_id" type="hidden" value="<?php echo $emp_id; ?>" /></form>
<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/empresas_ext/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'emp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Empresa', name : 'emp_nombre', width : 550, sortable : true, align: 'left'}
            //{display: 'Codigo', name : 'emp_sigla', width : 50, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'emp_id', isdefault: true},
            {display: 'Empresa', name : 'emp_nombre'},
            {display: 'Codigo', name : 'emp_sigla'}	
        ],
        sortname: "emp_id",
        sortorder: "asc",
        usepager: true,
        title: 'Empresas Externas',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 360
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#emp_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/empresas_ext/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/empresas_ext/delete/",{emp_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/empresas_ext/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#emp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/empresas_ext/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>