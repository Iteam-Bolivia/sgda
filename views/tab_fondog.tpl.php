<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/fondo/<?php echo $PATH_EVENT ?>/">
    <input name="fon_id" id="fon_id" type="hidden"
           value="<?php echo $fon_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/fondo/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'fon_id', width : 40, sortable : true, align: 'center'},
            {display: 'Codigo', name : 'fon_cod', width : 80, sortable : true, align: 'left'},
            //{display: 'Codigo', name : 'fon_codigo', width : 60, sortable : true, align: 'left'},                                    
            {display: 'Fondo o Subfondo', name : 'fon_descripcion', width : 350, sortable : true, align: 'left'},
            {display: 'Subfondo de', name : 'fon_par', width : 300, sortable : true, align: 'left'},            
            {display: 'Contador', name : 'fon_contador', width : 60, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'fon_id', isdefault: true},
            {display: 'Codigo', name : 'fon_cod'},
            {display: 'Fondo o Subfondo', name : 'fon_descripcion'},
            {display: 'Depende de', name : 'fon_par'},
            {display: 'Contador', name : 'fon_contador'}
        ],
        sortname: "fon_cod",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE FONDOS O SUBFONDODOS DOCUMENTALES',
        useRp: true,
        rp: 40,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 800
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#fon_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/fondo/edit/");
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
                        url: '<?php echo $PATH_DOMAIN ?>/fondo/validaDepen/',
                        type: 'POST',
                        data: 'fon_id='+$('.trSelected div',grid).html(),
                        dataType:  "text",
                        success: function(datos)
                        {
                            if(datos!='')
                            {
                                alert(datos);
                            }
                            else
                            {
                                $.post("<?php echo $PATH_DOMAIN ?>/fondo/delete/",{fon_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/fondo/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#fon_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/fondo/edit/");
                document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>