<div class="titulo">ETIQUETADO DE EXPEDIENTES</div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<p>
<table id="flex2" style="display: none"></table>
</p>

<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
	action="<?php echo $PATH_DOMAIN ?>/etiqexpediente/<?php echo $PATH_EVENT ?>/">
    
    <input name="ete_id" id="ete_id" type="hidden" value="<?php echo $ete_id; ?>" /> 
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" /> 
    <input name="idcom" id="idcom" type="hidden" value="" />
</form>
        
<script type="text/javascript">
var dataj;
$("#flex1").flexigrid
({
    url: '<?php echo $PATH_DOMAIN ?>/etiqexpediente/loadExp/',
    dataType: 'json',
    colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Fecha inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
            ],
    buttons : [
            {name: 'Agregar', bclass: 'add', onpress : test}<?php echo ($PATH_A!=''? ','.$PATH_A : '') ?>
            ],
    searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'Codigo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
            {display: 'Fecha Final', name : 'exf_fecha_exf'}
            ],
    sortname: "exp_id",
    sortorder: "asc",
    usepager: true,
    title: '<?php echo $tituloA ?>',
    useRp: true,
    rp: 10,
    minimize: '<?php echo $GRID_SW ?>',
    showTableToggleBtn: true,
    width: 687,
    height: 260,
    autoload: false
});

$("#flex2").flexigrid
({
    url: '<?php echo $PATH_DOMAIN ?>/etiqexpediente/load/',
    dataType: 'json',
    colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            /*{display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},*/
            {display: 'Codigo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Fecha inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
            ],
    buttons : [
            {name: 'Imprimir', bclass: 'print', onpress : test},{separator: true},
            {name: 'Borrar', bclass: 'delete', onpress : test}<?php echo ($PATH_B!=''? ','.$PATH_B : '') ?>
            ],
    searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'Codigo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
            {display: 'Fecha Final', name : 'exf_fecha_exf'}
            ],
    sortname: "exp_id",
    sortorder: "asc",
    mulSelec: true,
    usepager: true,
    title: '<?php echo $tituloB ?>',
    useRp: true,
    rp: 10,
    minimize: <?php echo $GRID_SW ?>,
    showTableToggleBtn: true,
    width: 687,
    height: 260,
    autoload: false
});

function test(com,grid)
{
	if(com=='Agregar'){
		$("#exp_id").val($('.trSelected div',grid).html());
		$.ajax({
			   type: "POST",
			   url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/save/",
			   data: "exp_id="+$("#exp_id").val(),
			   dataType: 'text',
			   success: function(data){
			   		if(data=='OK'){
						$(".qsbox",grid).val($('#idcom').val());
						$('.Search',grid.pDiv).click();
					}					
			   }
			 });
	}
	else if (com=='Imprimir'){
		if($('.trSelected',grid).length){
			var ids = "";
			$('.trSelected',grid).each(function(){
				//alert($("div",this).html());				
				ids = ids + "," + $("div",this).html();
			});
			//alert(ids);
			$.ajax({
			   type: "POST",
			   url: "<?php echo $PATH_DOMAIN ?>/archivo/lisjson/",
			   data: "ids="+ids,
			   dataType: 'json',
			   success: function(json){
					dataj = json;
					//alert(dataj.length);
					$("#formE").html("");
                    jQuery.each(dataj, function(i,item){
						//alert(item);
						$("#A #procedencia").html(item.usu_nombres+" "+item.usu_apellidos);
						$("#A #nro").html(item.fil_id);
						$("#A #ut").html(item.fil_nomoriginal);
						$("#A #serie").html(item.ser_categoria);
						$("#A #direccion").html(item.fil_nomoriginal);
						$("#A #titulo").html(item.exp_nombre);
						$("#A #unidad").html(item.uni_codigo);
						$("#A #fextremas").html(item.exp_fecha_exi+" "+item.exp_fecha_exf);
						$("#A #codigo").html(item.exp_codigo);
						obj = $("#A").html();
						$("#formE").append(obj);
                    });
					
			   },
			   error: function(msg){
					alert(msg);
			   }
			 });				
			$('#dialog').dialog('open');
		}else{
			$('#dialogError').dialog('open');
		}
	}else{
		$('#idcom').val(com);
		$(".qsbox",grid).val(com);
		$('.Search',grid).click();
	}
}
function test2(com,grid){
	$('#idcom').val(com);
	$(".qsbox",grid).val(com);
	$('.Search',grid).click();
}

$(function(){
		$("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 500,
			width: 755,
			modal: true,
			buttons: {
				Aceptar: function() {
					$("#formE").printArea('');
				},
				Cancelar: function() {
					$(this).dialog('close');
				},			
				Folders: function() {
					$("#formE").html("");
                    jQuery.each(dataj, function(i,item){
						//alert(item);
						$("#A #procedencia").html(item.usu_nombres+" "+item.usu_apellidos);
						$("#A #nro").html(item.fil_id);
						$("#A #ut").html(item.fil_nomoriginal);
						$("#A #serie").html(item.ser_categoria);
						$("#A #direccion").html(item.fil_nomoriginal);
						$("#A #titulo").html(item.exp_nombre);
						$("#A #unidad").html(item.uni_codigo);
						$("#A #fextremas").html(item.exp_fecha_exi+" "+item.exp_fecha_exf);
						$("#A #codigo").html(item.exp_codigo);
						obj = $("#A").html();
						$("#formE").append(obj);
                    });
				},
				Carpetas: function() {
					$("#formE").html("");
					obj = $("#B").html();
					$("#formE").append(obj);					
					obj ="";
                    jQuery.each(dataj, function(i,item){
						//alert(item);
						obj = obj + "<tr><td>"+(i+1)+"</td><td colspan='2'>"+item.exp_nombre+"</td></tr>";
						//$("#A #procedencia").html(item.usu_nombres+" "+item.usu_apellidos);
						//$("#A #nro").html(item.fil_id);
						//$("#A #ut").html(item.fil_nomoriginal);
						//$("#A #serie").html(item.ser_categoria);
						//$("#A #direccion").html(item.fil_nomoriginal);
						//$("#A #titulo").html(item.exp_nombre);
						//$("#A #unidad").html(item.uni_codigo);
						//$("#A #fextremas").html(item.exp_fecha_exi+" "+item.exp_fecha_exf);
						//$("#A #codigo").html(item.exp_codigo);
						fecha = item.exp_fecha_exi+" "+item.exp_fecha_exf;
						serie = item.ser_categoria;
                    });
					$("#formE #serie").html(serie);
					$("#formE #fextremas").html(fecha);
					$("#formE #xField").after(obj);
				},
				Cajas: function() {
					$("#formE").html("");
					obj = $("#C").html();
					$("#formE").append(obj);					
					obj ="";
                    jQuery.each(dataj, function(i,item){
						//alert(item);
						obj = obj + "<tr><td>"+(i+1)+"</td><td>"+item.exp_nombre+"</td><td>"+item.uni_codigo+"</td><td>"+ item.exp_fecha_exi+" "+item.exp_fecha_exf +"</td></tr>";
						//$("#A #procedencia").html(item.usu_nombres+" "+item.usu_apellidos);
						//$("#A #nro").html(item.fil_id);
						//$("#A #ut").html(item.fil_nomoriginal);
						//$("#A #serie").html(item.ser_categoria);
						//$("#A #direccion").html(item.fil_nomoriginal);
						//$("#A #titulo").html(item.exp_nombre);
						//$("#A #unidad").html(item.uni_codigo);
						//$("#A #fextremas").html(item.exp_fecha_exi+" "+item.exp_fecha_exf);
						//$("#A #codigo").html(item.exp_codigo);
						fecha = item.exp_fecha_exi+" "+item.exp_fecha_exf;
						serie = item.ser_categoria;
                    });
					$("#formE #serie").html(serie);
					$("#formE #fextremas").html(fecha);
					$("#formE #xField").after(obj);  
				},
				CajaNormalizada: function() {
					$("#formE").html("");
					obj = $("#D").html();
					$("#formE").append(obj);					
					obj ="";
                    jQuery.each(dataj, function(i,item){
						//alert(item);
						obj = obj + "<tr><td>"+ (i+1) +"</td><td>"+ item.exp_nombre +"</td><td>"+ item.exp_codigo +"</td><td>"+ item.exp_fecha_exi+" "+item.exp_fecha_exf +"</td><td><input type='text' name='z' id='z' size='12' /></td></tr>";
						//$("#A #procedencia").html(item.usu_nombres+" "+item.usu_apellidos);
						//$("#A #nro").html(item.fil_id);
						//$("#A #ut").html(item.fil_nomoriginal);
						//$("#A #serie").html(item.ser_categoria);
						//$("#A #direccion").html(item.fil_nomoriginal);
						//$("#A #titulo").html(item.exp_nombre);
						//$("#A #unidad").html(item.uni_codigo);
						//$("#A #fextremas").html(item.exp_fecha_exi+" "+item.exp_fecha_exf);
						//$("#A #codigo").html(item.exp_codigo);
						fecha = item.exp_fecha_exi+" "+item.exp_fecha_exf;
						serie = item.ser_categoria;
                    });
					$("#formE #serie").html(serie);
					$("#formE #fextremas").html(fecha);
					$("#formE #xField").after(obj);
				}
			},
			Cerrar: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});
		$("#dialogError").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 150,
			width: 350,
			modal: true,
			buttons: {
				Aceptar: function() {
					$(this).dialog('close');
				}
			},
			Cerrar: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});		
});
</script>

<div id="dialog" title="Impresion de etiquetas">
<form id="formE" name="formE" method="post" action="#"></form>
</div>
<div id="dialogError" title="Alert de accion">
<form id="formA" name="formA" method="post" action="#">
<p class="ui-state-error ui-corner-all">Necesita seleccionar un
expediente para imprimir una etiqueta</p>
</form>
</div>


<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="A"
	style="display: none;">
<table width="705" height="80" border="0">
	<tr>
		<td width="111" rowspan="2"><img
			src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png"
			width="159" height="50" /></td>
		<td width="361">Procedencia:<span id="procedencia">111</span></td>
		<td width="157" rowspan="2" bordercolor="#999999">
		<table width="157" height="65" border="1">
			<tr>
				<td>Nro:<span id="nro"></span></td>
			</tr>
			<tr>
				<td>U.T.:<span id="ut"></span></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>Serie:<span id="serie"></span></td>
	</tr>
	<tr>
		<td>Direccion:<span id="direccion"></span></td>
		<td colspan="2">Titulo:<span id="titulo"></span></td>
	</tr>
	<tr>
		<td>Unidad:<span id="unidad"></span></td>
		<td>Fecha extremas:<span id="fextremas"></span></td>
		<td>Codigo:<span id="codigo"></span></td>
	</tr>
</table>
<hr />
</div>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="B"
	style="display: none;">
<table width="705" height="80" border="0">
	<tr>
		<td width="111">&nbsp;</td>
		<td width="361" align="center">
		<p><img
			src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png"
			width="159" height="50" /></p>
		<p>ARCHIVO DE OFICINA</p>
		<p>DCOR2/UCOD6</p>
		</td>
		<td width="157" bordercolor="#999999">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Serie: <span id="serie"></span></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="687" border="1">
			<tr id="xField">
				<td width="30">Nro.</td>
				<td width="640" colspan="2">Titulo:</td>
			</tr>

		</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td>
	</tr>
	<tr>
		<td colspan="3" align="center">Carpeta Nro: 5</td>
	</tr>
	<tr>
		<td colspan="3" align="center">UT: 1</td>
	</tr>
</table>
<hr />
</div>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="C"
	style="display: none;">
<table width="705" height="80" border="0">
	<tr>
		<td width="111">&nbsp;</td>
		<td width="361" align="center">
		<p><img
			src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png"
			width="159" height="50" /></p>
		<p>ARCHIVO DE OFICINA</p>
		<p>DCOR2/UCOD6</p>
		</td>
		<td width="157" bordercolor="#999999">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Serie: <span id="serie"></span></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="688" border="1">
			<tr id="xField">
				<td width="30">Nro.</td>
				<td width="331">Titulo:</td>
				<td width="100">Codigo:</td>
				<td width="199">Fecha extremas:</td>
			</tr>

		</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td>
	</tr>
	<tr>
		<td colspan="3" align="center">Carpeta Nro: 5</td>
	</tr>
	<tr>
		<td colspan="3" align="center">UT: 1</td>
	</tr>
</table>
<hr />
</div>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="D"
	style="display: none;">
<table width="705" height="80" border="0">
	<tr>
		<td width="111">&nbsp;</td>
		<td width="361" align="center">
		<p><img
			src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png"
			width="159" height="50" /></p>
		<p>ARCHIVO DE OFICINA</p>
		<p>DCOR2/UCOD6</p>
		</td>
		<td width="157" bordercolor="#999999">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Serie: <span id="serie"></span></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="688" border="1">
			<tr id="xField">
				<td width="30">Nro.</td>
				<td width="239">Titulo</td>
				<td width="94">Codigo</td>
				<td width="193">Fecha extremas</td>
				<td width="98">Cubierta</td>
			</tr>

		</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td>
	</tr>
	<tr>
		<td colspan="3" align="center">Carpeta Nro: 5</td>
	</tr>
	<tr>
		<td colspan="3" align="center">UT: 1</td>
	</tr>
</table>
<hr />