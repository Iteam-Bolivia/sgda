<div class="clear"></div>
<p>
    <table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/provincia/<?php echo $PATH_EVENT ?>/">
    <input name="pro_id" id="pro_id" type="hidden" value="<?php echo $pro_id; ?>" />
    <input name="dep_id" id="dep_id" type="hidden" value="<?php echo 0; ?>" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/departamento/"><<<< Volver a Departamentos </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/provincia/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'pro_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'pro_codigo', width : 80, sortable : true, align: 'left'},
            {display: 'Provincia', name : 'pro_nombre', width : 600, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Ciudades', bclass: 'ver', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'pro_id', isdefault: true},
            {display: 'Código', name : 'pro_codigo'},
            {display: 'Provincia', name : 'pro_nombre'}
        ],
        sortname: "pro_id",
        sortorder: "asc",
        usepager: true,
        title: 'PROVINCIAS DEL DEPARTAMENTO DE: " <?php echo $dep_nombre; ?> "',
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
            $("#pro_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/provincia/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                //                            if(r)
                    $.ajax({
                        url: '<?php echo $PATH_DOMAIN ?>/provincia/validaDepen/',
                        type: 'POST',
                        data: 'pro_id='+$('.trSelected div',grid).html(),
                        dataType:  		"text",
                        success: function(datos)
                        {
                            if(datos!='')
                            {
                                alert(datos);
                            }
                            else
                            {
                                $.post("<?php echo $PATH_DOMAIN ?>/provincia/delete/",{pro_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                    if(data != true){
                                        $('.pReload',grid.pDiv).click();
                                    }
                                });   
                        }
                    }				
                });
            }else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar')
        {
            $("#pro_id").val($('.trSelected div',grid).html());
            pro_id= $("#pro_id").val();

            window.location="<?php echo $PATH_DOMAIN ?>/provincia/add/<?php echo VAR3; ?>/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#pro_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/provincia/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Ciudades')
        {
            if($('.trSelected',grid).html())
            {	 $("#pro_id").val($('.trSelected div',grid).html());
                id = $("#pro_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/localidad/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }
    }
    
</script>