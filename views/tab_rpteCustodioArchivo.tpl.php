<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/rpteCustodioArchivo/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            Reportes de Archivos por Expediente
        </caption>

<!--<tr>
<td>Ordenado por:</td>
<td>

<select name="tipo_orden" style="width:300px;" id="tipo_orden" class="required">
<option value="" selected>(seleccionar)</option>
<option value="SERIE">SERIE</option>
<option value="NOMBRE_EXPEDIENTE">NOMBRE EXPEDIENTE</option>
<option value="CODIGO_REFERENCIA">CODIGO DE REFERENCIA</option>
<option value="FECHA_EXI">FECHA EXTREMA INICIAL</option>
<option value="FECHA_EXF">FECHA EXTREMA FINAL</option>
</select>
</td>
</tr>-->
  <tr>
            <td>Serie:</td>
            <td><select name="filtro_series" style="width: 300px;"
                        id="filtro_series" onchange="iniciarBusqueda(this.value)">
                   
                    <?php echo ($optSerie) ?>
                </select></td>
        </tr>
        <tr>
            <td>Expedientes:</td>
            <td> <div id="cargarExp">
                <select name="filtro_expediente" style="width: auto;"
                        id="filtro_funcionario" size="5" style="height: 250px">
                    <option value="">(seleccionar)</option>
                   
                    
                </select></div>
            </td>
        </tr>

        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Reporte" class="button"/>
          <!--    <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />   -->
            </td>
        <tr>
    </table>
    <input name="pre_tipo" type="hidden" id="pre_tipo" value="1" />
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        //	  $("#cancelar").click(function(){
        //				window.location="<?php //echo $PATH_DOMAIN  ?>/estrucDocumental/";
        //	  });

        $("#filtro_series").change(function(){
            if($("#filtro_series").val()==""){
            }else{
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/rpteCustodioArchivo/loadAjaxExpediente/',
                    type: 'POST',
                    data: 'serie='+$("#filtro_series").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            $("#filtro_expediente").find("option").remove();
                            $("#filtro_expediente").append("<option value=''>(TODO)</option>");
                            jQuery.each(datos, function(i,item){
                                $("#filtro_expediente").append("<option value='"+i+"'>"+item+"</option>");
                            });
                        }else{
                            $("#filtro_expediente").find("option").remove();
                            $("#filtro_expediente").append("<option value=''>-No hay Expedientes-</option>");
                        }
                    }
                });

            }
        });
    });
</script>
<script languaje="javascript">

function iniciarBusqueda(str){
  //  alert(str)

    var url="<?php echo $PATH_DOMAIN ?>/rpteCustodioArchivo/ajaxExp/";
   $("#cargarExp").load(url,{valor:str});
    
}
</script>