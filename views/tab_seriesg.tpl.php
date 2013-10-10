<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/series/<?php echo $PATH_EVENT ?>/">
    <input name="ser_id" id="ser_id" type="hidden"
           value="<?php echo $ser_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/series/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ser_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'ser_codigo', width : 110, sortable : true, align: 'left'},
            {display: 'Clase', name : 'tco_codigo', width : 25, sortable : true, align: 'left'},            
            {display: 'Nombre de Serie o Subserie', name : 'ser_categoria', width : 400, sortable : true, align: 'left'},
            {display: 'Subserie de', name : 'ser_par', width : 200, sortable : true, align: 'left'},
            {display: 'Seccion o Subseccion', name : 'uni_descripcion', width : 150, sortable : true, align: 'left'},
            {display: 'Fondo o Subfondo', name : 'fon_descripcion', width : 150, sortable : true, align: 'left'},            
            {display: 'Valor Doc.', name : 'red_codigo', width : 50, sortable : true, align: 'left'},
            {display: 'Contador', name : 'ser_parcont', width : 40, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Adicionar Grupos Documentales', bclass: 'add', onpress : test},
            {separator: true},
            {name: 'Adicionar Información a los Expedientes', bclass: 'fields', onpress : test},
            {separator: true},
            {name: 'Impresion', bclass: 'print', onpress : test}            
            
        ],
        searchitems : [
            {display: 'Id', name : 'ser_id', isdefault: true},
            {display: 'Codigo', name : 'ser_codigo', isdefault: true},            
            {display: 'Clase', name : 'tco_codigo', isdefault: true},            
            {display: 'Serie', name : 'ser_categoria'},
            {display: 'Subserie de', name : 'ser_par'},
            {display: 'Seccion o Subseccion', name : 'uni_descripcion', isdefault: true},
            {display: 'Fondo o Subfondo', name : 'fon_descripcion', isdefault: true},
            {display: 'Valor Doc.', name : 'red_codigo'}
        ],
        sortname: "ser_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE SERIES O SUBSERIES',
        useRp: true,
        rp: 50,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 800
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#ser_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/series/edit/");
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
                        url: '<?php echo $PATH_DOMAIN ?>/series/validaDepen/',
                        type: 'POST',
                        data: 'ser_id='+$('.trSelected div',grid).html(),
                        dataType:  "text",
                        success: function(datos)
                        {
                            if(datos!='')
                            {
                                alert(datos);
                            }
                            else
                            {
                                $.post("<?php echo $PATH_DOMAIN ?>/series/delete/",{ser_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/series/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ser_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/series/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Ver Serie documental')
        {
            if($('.trSelected',grid).html())
            {	 $("#ser_id").val($('.trSelected div',grid).html());
                id = $("#ser_id").val();
                 window.location ="<?php echo $PATH_DOMAIN ?>/series/reporte/";
                //window.location ="<?php echo $PATH_DOMAIN ?>/tramite/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }                
        else if (com=='Adicionar Grupos Documentales')
        {
            if($('.trSelected',grid).html())
            {	 $("#ser_id").val($('.trSelected div',grid).html());
                id = $("#ser_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/tramite/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }
        else if (com=='Adicionar Información a los Expedientes')
        {
            if($('.trSelected',grid).html())
            {	 $("#ser_id").val($('.trSelected div',grid).html());
                id = $("#ser_id").val();
                window.location ="<?php echo $PATH_DOMAIN ?>/expcampo/index/"+id+"/";
            }
            else alert("Seleccione un registro");
        }
        else if (com=='Impresion')
        {
            window.location ="<?php echo $PATH_DOMAIN ?>/series/impresion/";
        }        
    }
</script>