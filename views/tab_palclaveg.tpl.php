<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/palclave/<?php echo $PATH_EVENT ?>/">
    <input name="pac_id" id="pac_id" type="hidden" value="<?php echo $pac_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/palclave/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'pac_id', width : 40, sortable : true, align: 'center'},
            {display: 'Palabra Clave', name : 'pac_nombre', width : 300, sortable : true, align: 'left'},
            {display: 'Nivel Descripci&oacute;n', name : 'pac_formulario', width : 200, sortable : true, align: 'left'},
        ],
        buttons : [
        
                {name: 'Adicionar', bclass: 'add', onpress : test},
                {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        
        ],
        searchitems : [
            {display: 'Id', name : 'pac_id', isdefault: true},
            {display: 'Palabra Clave', name : 'pac_nombre'},
            {display: 'Nivel Descripci&oacute;n', name : 'pac_formulario'},
        ],
        sortname: "pac_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE PALABRAS CLAVES',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 390
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#pac_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/palclave/edit/");
            document.getElementById('formA').submit();
        }
    }
    
    function test(com,grid)
    {
        if (com=='Eliminar')
		{
			if($('.trSelected div',grid).html())
			{
				if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
				$.post("<?php echo $PATH_DOMAIN ?>/palclave/delete/",{pac_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
						if(data != true){
							$('.pReload',grid.pDiv).click();
						}else {

						}
					});
			}else alert("Seleccione un registro");
		}
        
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/palclave/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#pac_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/palclave/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
    
</script>