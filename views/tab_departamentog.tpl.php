<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/departamento/<?php echo $PATH_EVENT ?>/">
    <input name="dep_id" id="dep_id" type="hidden" value="<?php echo $dep_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/departamento/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'dep_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'dep_codigo', width : 80, sortable : true, align: 'left'},
            {display: 'Departamento', name : 'dep_nombre', width : 600, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Provincia', bclass: 'ver', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'dep_id', isdefault: true},
            {display: 'Código', name : 'dep_codigo'},
            {display: 'Departamento', name : 'dep_nombre'},
        ],
        sortname: "dep_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE DEPARTAMENTOS',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 390
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#dep_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/departamento/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.ajax({
                        url: '<?php echo $PATH_DOMAIN ?>/departamento/validaDepen/',
                        type: 'POST',
                        data: 'dep_id='+$('.trSelected div',grid).html(),
                        dataType:  "text",
                        success: function(datos)
                        {
                            if(datos!='')
                            {
                                alert(datos);
                            }
                            else
                            {
                                $.post("<?php echo $PATH_DOMAIN ?>/departamento/delete/",{dep_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                    if(data != true){
                                        $('.pReload',grid.pDiv).click();
                                    }
                                });   
                        }
                    }				
                });
            }	
            else {
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/departamento/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#dep_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/departamento/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Provincia')
        {
            if($('.trSelected',grid).html())
            {	 $("#dep_id").val($('.trSelected div',grid).html());
                id = $("#dep_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/provincia/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }
    }
    
</script>