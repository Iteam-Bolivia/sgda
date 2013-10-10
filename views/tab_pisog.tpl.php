<div class="clear"></div>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/ubicacion/<?php echo $PATH_EVENT ?>/">
    <input name="ubi_id" id="ubi_id" type="hidden" value="<?php echo $ubi_id; ?>" />
    <!-- <input name="ubi_par" id="ubi_par" type="hidden" value="<?php //echo $ubi_par; ?>" /> -->
    <input name="ubi_par" id="ubi_par" type="hidden" value="<?php echo 0; ?>" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN;?>/ubicacion/"><<-- Volver a Edificios <<-- </a></p>
<script type="text/javascript">
$("#flex2").flexigrid
({
url: '<?php echo $PATH_DOMAIN ?>/ubicacion/loadPisos/<?php echo VAR3;?>/',
dataType: 'json',
colModel : [
	{display: 'Id', name : 'ubi_id', width : 40, sortable : true, align: 'center'},
	{display: 'Codigo', name : 'ubi_codigo', width : 60, sortable : true, align: 'left'},
	{display: 'Descripcion', name : 'ubi_descripcion', width : 330, sortable : true, align: 'left'},
	{display: 'Direccion', name : 'ubi_direccion', width : 210, sortable : true, align: 'left'}
	],
buttons : [
	{name: 'Adicionar', bclass: 'add', onpress : test},
	{name: 'Eliminar', bclass: 'delete', onpress : test},
	{name: 'Editar', bclass: 'edit', onpress : test},
	{separator: true}
	],
searchitems : [
	{display: 'Id', name : 'ubi_id', isdefault: true},
	{display: 'C&oacute;digo', name : 'ubi_codigo'},
	{display: 'Descripci&oacute;n', name : 'ubi_descripcion'},
	{display: 'Direcci&oacute;n', name : 'ubi_direccion'}
	],
sortname: "ubi_id",
sortorder: "asc",
usepager: true,
title: 'Pisos del edificio " <?php echo $ubi_codigo;?> "',
useRp: true,
rp: 10,
minimize: <?php echo $GRID_SW ?>,
showTableToggleBtn: true,
width: 800,
height: 380
});

function dobleClik(grid){
	if($('.trSelected div',grid).html())
	{
			$("#ubi_id").val($('.trSelected div',grid).html());
			$("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/ubicacion/editarPiso/");
			document.getElementById('formA').submit();
	}

	//$('#dialog-form').dialog('open');
}

function test(com,grid)
{
	if (com=='Eliminar')
		{
			if($('.trSelected div',grid).html())
			{
				if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
				$.post("<?php echo $PATH_DOMAIN ?>/ubicacion/deletePiso/",{ubi_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
						if(data != true){
							$('.pReload',grid.pDiv).click();
						}else {

						}
					});
			}else alert("Seleccione un registro");
		}
	else if(com=='Adicionar')
	{
				$("#ubi_id").val($('.trSelected div',grid).html());
				ubi_id= $("#ubi_id").val();
				window.location ="<?php echo $PATH_DOMAIN ?>/ubicacion/addPiso/<?php echo VAR3;?>/";
				//$("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/ubicacion/editPiso/");
				//document.getElementById('formA').submit();

	}
	else if(com =='Editar')
	{
		if($('.trSelected div',grid).html())
		{
			$("#ubi_id").val($('.trSelected div',grid).html());
			$("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/ubicacion/editarPiso/");
			document.getElementById('formA').submit();
		}
		else alert("Seleccione un registro");
	}
}
</script>