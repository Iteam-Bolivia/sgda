<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/retensiondoc/<?php echo $PATH_EVENT ?>/">
    <input name="red_id" id="red_id" type="hidden" value="<?php echo $red_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/retensiondoc/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'red_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'red_codigo', width : 40, sortable : true, align: 'left'},
            {display: 'Series', name : 'red_series', width : 250, sortable : true, align: 'left'},
            {display: 'Tipo documental', name : 'red_tipodoc', width : 420, sortable : true, align: 'left'},
            {display: 'Valor documental', name : 'red_valdoc', width : 110, sortable : true, align: 'left'},
            {display: 'P. Archivistica (años)', name : 'red_prearc', width : 100, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'red_id', isdefault: true},
            {display: 'Código', name : 'red_codigo'},
            {display: 'Series', name : 'red_series'},
            {display: 'Tipo documental', name : 'red_tipodoc'},
            {display: 'Valor documental', name : 'red_valdoc'},
            {display: 'Prescripción Archivistica (años)', name : 'red_prearc'},
        ],
        sortname: "red_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE CLASES DE SERIE',
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
            $("#red_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/retensiondoc/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')){                    
                    $.post("<?php echo $PATH_DOMAIN ?>/retensiondoc/delete/",{red_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                    });  
                }
            }	
            else {
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/retensiondoc/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#red_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/retensiondoc/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
    
</script>