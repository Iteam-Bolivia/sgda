<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/<?php echo $PATH_EVENT ?>/" >
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <input name="ser_id" id="ser_id" type="hidden" value="<?php echo $ser_id; ?>" />
</form>

<form id="formB" name="formB" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/<?php echo $PATH_EVENT ?>/" target="_blank">
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/loadSerie/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ser_id', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'ser_codigo', width : 110, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 500, sortable : true, align: 'left'}
        ],
        buttons : [
            //{name: 'Adicionar Expediente', bclass: 'add', onpress : test},{separator: true},
            {name: 'Filtrar', bclass: 'ver', onpress : test}, {separator: true},
            {name: 'Imprimir inventario de expedientes', bclass: 'print', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'ser_id'},
            {display: 'C&oacute;digo', name : 'ser_codigo', isdefault: true},
            {display: 'Serie', name : 'ser_categoria'}
        ],
        sortname: "ser_id",
        sortorder: "asc",
        usepager: true,
        title:"LISTA DE SERIES",
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 150,
        autoload: true
    });

    
    $("#flex2").flexigrid
    ({  
        url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/load/<?php echo $ser_id; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'exp_codigo', width : 120, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_titulo', width : 500, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha Final', name : 'exf_fecha_exf', width : 60, sortable : true, align: 'left'},            
//            {display: 'Soporte Fisico', name : 'sof_nombre', width : 50, sortable : true, align: 'left'},
//            {display: 'Nro.Ejem.', name : 'exp_nroejem', width : 50, sortable : true, align: 'left'},
//            {display: 'Tomo Vol.', name : 'exp_tomovol', width : 50, sortable : true, align: 'left'},
            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test2}, {separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test2}, {separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test2}, {separator: true},
            {name: 'Documentos del expediente', bclass: 'ver', onpress : test2}, {separator: true},
            {name: 'Cerrar expediente', bclass: 'ver', onpress : test2}, {separator: true},
            {name: 'Imprimir marbetes documentos', bclass: 'ver', onpress : test2}, {separator: true},
            {name: 'Imprimir inventario documentos', bclass: 'print', onpress : test2}            
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Codigo', name : 'exp_codigo', isdefault: true},
            {display: 'Nombre', name : 'exp_titulo'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
//            {display: 'Soporte Fisico', name : 'sof_nombre'},
//            {display: 'Nro.Ejem', name : 'exp_nroejem'},
//            {display: 'Tomo Vol.', name : 'exp_tomovol'},
            {display: 'Custodio', name : 'custodios'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: 'REGISTRO DE EXPEDIENTES',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 380,
        autoload: true
    });
    
    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            if($("table",grid).attr('id')=="flex2"){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nuevoExpediente/edit/");
                document.getElementById('formA').submit();
            }
            if($("table",grid).attr('id')=="flex1"){
                $("#ser_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nuevoExpediente/");
                document.getElementById('formA').submit();
            }
        }
    }

    function test2(com,grid)
    {
        if (com=='Adicionar')
        {
            $.post("<?php echo $PATH_DOMAIN ?>/nuevoExpediente/verifSeries/", {rand:Math.random()}, function(data){
                if(data != 'OK'){
                    alert("No puede adicionar expedientes porque no tiene permiso para ninguna Serie.");
                }else{
                    window.location="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/add/";
                }
            });
        }
        else if (com=='Cerrar expediente')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de cerrar el expediente ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/nuevoExpediente/cierre_exp/",{exp_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else{
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Documentos del expediente'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                //window.location="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/add/";
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/searchTree/");
                document.getElementById('formA').submit();
            }else{
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nuevoExpediente/edit/");
                document.getElementById('formA').submit();
            }	else{
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/nuevoExpediente/delete/",{exp_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else{
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Imprimir inventario de documentos'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formB").attr("action","<?php echo $PATH_DOMAIN ?>/rpteInventarioDoc/verRpte/");
                document.getElementById('formB').submit();
            }	else{
                alert("Seleccione un registro");
            }
        }
        

    }
    
    function test(com,grid)
    {
        if (com=='Filtrar')
        { 
            if($('.trSelected div',grid).html())
            {
                $("#ser_id").val($('.trSelected div',grid).html());
                //$('#flex2').flexReload();
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nuevoExpediente/");
                document.getElementById('formA').submit();                
            }	else{
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Imprimir inventario de expedientes'){
            if($('.trSelected div',grid).html()){
                $("#ser_id").val($('.trSelected div',grid).html());
                $("#formB").attr("action","<?php echo $PATH_DOMAIN ?>/rpteInventario/verRpte/");
                document.getElementById('formB').submit();
            }	else{
                alert("Seleccione un registro");
            }
        }
        
        else{
            $(".qsbox").val($('.trSelected div',grid).html());
            $(".qtype").val('ser_id');
            $('.Search').click();
        }

    }
    
</script>