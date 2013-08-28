<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/inventario/<?php echo $PATH_EVENT ?>/">
	
<input name="inv_id" id="inv_id" type="hidden" value="<?php echo $inv_id; ?>" />
<input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
<input name="inv_orden" type="hidden" id="inv_orden" value="<?php echo $inv_orden; ?>" />
<table width="100%" border="0"><caption class="titulo">Registro de Inventario</caption>
<tr>
<td width="241">Expediente:</td>
<td colspan="3"><?php echo $exp_nombre; ?></td>
</tr>
<tr>
<td>Fecha de Transferencia:</td>
<td colspan="3">
<input name="exf_fecha_exf" type="text" id="exf_fecha_exf" value="<?php echo $exf_fecha_exf; ?>" size="10" maxlength="10" autocomplete="off" class="required" title="Fecha de Transferencia del expediente."/>
</td>
</tr>
<tr>
<td>Nro. de Piezas:</td>
<td width="189"><input name="inv_pieza" type="text" id="inv_pieza" value="<?php echo $inv_pieza; ?>" size="5" maxlength="5" autocomplete="off" class="required numeric" title="Indicar si el expediente f&iacute;sico se encuentra en una o varias piezas."/>
</td>
<td width="177">&Aacute;rea Metros Linales:</td>
<td width="342"><input name="inv_ml" type="text" id="inv_ml" value="<?php echo $inv_ml; ?>" size="6" maxlength="6" autocomplete="off" class="required numeric" title="Indicar el especio ocupado por el expediente f&iacute;sico"/>
  m
  .</td>
</tr>
<tr>
  <td>Tomo:</td>
  <td><input name="inv_tomo" type="text" id="inv_tomo" value="<?php echo $inv_tomo; ?>" size="10" maxlength="10" autocomplete="off" class="required alphanum" title="N&uacute;mero de tomo al que corresponde el documento."/></td>
  <td>Unidad de Instalaci&oacute;n:</td>
  <td><?php if($con_id==''): ?>Ninguno
  <?php else: ?>
  		<select id="con_id" name="con_id" ><option value="">- Seleccionar -</option>
  	 	<?php echo $con_id;?>
  		</select>  
  <?php endif; ?>
  </td>
  </tr>
<tr>
<td>Nombre del Productor:</td>
<td colspan="3" title="Nombre del Productor del expediente."><input name="inv_nom_productor" type="hidden" id="inv_nom_productor" value="<?php echo $inv_nom_productor; ?>" /><?php echo $inv_nom_productor; ?></td>
</tr>
<tr>
<td>Observaciones:</td>
<td colspan="3"><input name="inv_obs" type="text" id="inv_obs" value="<?php echo $inv_obs; ?>" size="100" autocomplete="off" class="required" maxlength="100" title="Observaciones"/></td>
</tr>
<tr>
<td>Caracter&iacute;stica f&iacute;sica:</td>
<td colspan="3"><input name="inv_caract_fisica" type="text" id="inv_caract_fisica" value="<?php echo $inv_caract_fisica; ?>" size="100" maxlength="150" autocomplete="off" class="alphanum" title="Indicar alguna caracter&iacute;stica que permite identificar f&aacute;cilmente al expediente."/></td>
</tr>
<tr>
  <td>Condici&oacute;n del papel:</td>
  <td><select name="inv_condicion_papel" id="inv_condicion_papel" title="Condici&oacute;n del papel" class="required">
    <?php echo $inv_condicion_papel; ?>
  </select></td>
  <td>Nitidez de escritura:</td>
  <td><select name="inv_nitidez_escritura" class="required" id="inv_nitidez_escritura" title="Nitidez de la escritura">
    <?php echo $inv_nitidez_escritura; ?>
  </select>  </td>
  </tr>
<tr>
<td><label for="inv_analisis_causa" id="lbl_inv_analisis_causa">An&aacute;lisis causa:</label></td>
<td colspan="3"><input name="inv_analisis_causa" type="text" id="inv_analisis_causa" value="<?php echo $inv_analisis_causa; ?>" size="100" autocomplete="off" class="alphanum" title="An&aacute;lisis de la Causa de la mala condici&oacute;n de papel o nitidez de escritura."/></td>
</tr>
<tr>
<td><label for="inv_accion_curativa" id="lbl_inv_accion_curativa">Acci&oacute;n curativa:</label></td>
<td colspan="3"><input name="inv_accion_curativa" type="text" id="inv_accion_curativa" value="<?php echo $inv_accion_curativa; ?>" size="100" autocomplete="off" class="alphanum" title="Accion Curativa para tener una buena condici&oacute;n de papel y nitidez de escritura."/></td>
</tr>
  <tr>
    <td class="botones" colspan="4">
    <input id="btnSub" type="submit" value="Guardar" class="button"/>
    <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
    </tr>
</table>
</form>
</div>
<script type="text/javascript">

jQuery(document).ready(function($) {
	  verif($('#inv_condicion_papel').val(), $('#inv_nitidez_escritura').val());
	  $("#cancelar").click(function(){
			if($("#formA").is(":visible")){
				$("#formA").hide();
				//$(".flexigrid").attr('class','flexigrid');
				window.location="<?php echo $PATH_DOMAIN ?>/inventario/";
			}else{
				$("#formA").show();				
			}
	  });
	  $('#inv_condicion_papel').change(function(){
	  	verif($(this).val(),$('#inv_nitidez_escritura').val());
	  });
	  $('#inv_nitidez_escritura').change(function(){
	  	verif($('#inv_condicion_papel').val(),$(this).val());
	  });
});
function verif(a,b){ //alert("1. "+a + " 2. "+b); alert(a!='BUENO' || b!='LEGIBLE');
	  if(a=='BUENO' && b=='LEGIBLE'){
	  	$('#lbl_inv_analisis_causa').attr('class','oculto');
	  	$('#inv_analisis_causa').attr('class','oculto');
	  	$('#lbl_inv_accion_curativa').attr('class','oculto');
	  	$('#inv_accion_curativa').attr('class','oculto');
	  }else{
	  	$('#lbl_inv_analisis_causa').attr('class','visible');
	  	$('#inv_analisis_causa').attr('class','alphanum');
	  	$('#lbl_inv_accion_curativa').attr('class','visible');
	  	$('#inv_accion_curativa').attr('class','alphanum');
	  }

}
</script>

