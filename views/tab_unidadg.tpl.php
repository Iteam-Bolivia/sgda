<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/unidad/<?php echo $PATH_EVENT ?>/" >
    <input name="uni_id" id="uni_id" type="hidden" value="" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/unidad/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'uni_id', width : 40, sortable : true, align: 'center'},            
            {display: 'C&oacute;digo', name : 'uni_cod', width : 100, sortable : true, align: 'left'},            
            {display: 'Nombre Sección o Subsección', name : 'uni_descripcion', width : 350, sortable : true, align: 'left'},                            
            {display: 'Subsección de', name : 'uni_par_cod', width : 300, sortable : true, align: 'left'},
            {display: 'Fondo o Subfondo', name : 'fon_descripcion', width : 200, sortable : true, align: 'left'},                
            {display: 'Contador', name : 'uni_contador', width : 40, sortable : true, align: 'left'}                    
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Eliminar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Editar', bclass: 'edit', onpress : test},
        ],
        searchitems : [
            {display: 'Id', name : 'uni_id'},            
            {display: 'C&oacute;digo', name : 'uni_cod'},
            {display: 'Fondo o Subfondo', name : 'fon_descripcion'},
            {display: 'Seccion o Subsección', name : 'uni_descripcion'},
        ],
        sortname: "uni_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE SECCIONES O SUBSECCIONES',
        useRp: true,
        rp: 40,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height:800
    });
    
    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#uni_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/unidad/edit/");
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
                    url: '<?php echo $PATH_DOMAIN ?>/unidad/delete/',
                    type: 'POST',
                    data: 'uni_id='+$('.trSelected div',grid).html(),
                    dataType:  		"json",
                    success: function(datos){
                        var j=0;
                        if(datos){
                            alerta="No se puede eliminar la unidad! \nTiene los siguientes dependientes:\n";
                            jQuery.each(datos, function(i,item){
                                j++;
                                alerta=alerta + item + ", ";						
                            });
                        }
                    if(j==0){
                        $('.pReload',grid.pDiv).click();			   
                        $('#flex1.pReload',grid.pDiv).click();
                    }
                    else{
                        alert(alerta);
                    }
                }				
            });
        }
        else{
            alert("Seleccione un registro");
        }
    }
    else if (com=='Adicionar')
    {
        window.location="<?php echo $PATH_DOMAIN ?>/unidad/add/";
    } 
    else if (com=='Editar'){
        if($('.trSelected div',grid).html()){
            $("#uni_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/unidad/edit/");
            document.getElementById('formA').submit();
        }
        else{
            alert("Seleccione un registro");
        }
    }
    else if (com=='Imprimir')
    {
        window.location="<?php echo $PATH_DOMAIN ?>/unidad/rpteUnidad/";
    }     
    else{
        $(".qsbox").val(com);
        $('.Search',grid.pDiv).click();
    }
}

</script>
</body>
</html>