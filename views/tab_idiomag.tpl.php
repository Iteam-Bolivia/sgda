<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/idioma/<?php echo $PATH_EVENT ?>/">    
    <input name="idi_id" id="idi_id" type="hidden" value="<?php echo $idi_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/idioma/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'idi_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'idi_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'idi_nombre', width : 600, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'idi_id', isdefault: true},
            {display: 'Código', name : 'idi_codigo'},
            {display: 'Nombre', name : 'idi_nombre'},
        ],
        sortname: "idi_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE IDIOMAS',
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
            $("#idi_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/idioma/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?')){
                    $.post("<?php echo $PATH_DOMAIN ?>/idioma/delete/",{idi_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                    });
                }
            }else {
                alert("Seleccione un registro");
            }
        }
        
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/idioma/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#idi_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/idioma/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
    
</script>