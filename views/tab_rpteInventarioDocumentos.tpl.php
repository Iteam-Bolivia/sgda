<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/rpteInventarioDocumentos/<?php echo $PATH_EVENT ?>/"
      target="_blank">

    <table width="100%" border="0">
        <caption class="titulo">
            LISTADO INVENTARIO DE DOCUMENTOS
        </caption>



   
        <tr>
            <td>Serie:</td>
            <td><select name="filtro_series" style="width: 300px;"
                        id="filtro_series" onchange="iniciarBusqueda(this.value)">
                    <option value="">(TODAS)</option>
                    <?php echo ($optSerie) ?>
                </select></td>
        </tr>
        <tr>
            <td>Expedientes:</td>
            <td> <div id="cargarExp">
                <select name="filtro_expedientes" style="width: auto;"
                        id="filtro_funcionario" size="5" style="height: 250px">
                    <option value="">(seleccionar)</option>
                   
                    
                </select></div>
            </td>
        </tr>



        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit"
                                                   value="Reporte" class="button" /> 
<!--                <input name="cancelar"
                                                   id="cancelar" type="button" class="button" value="Cancelar" />-->
            </td>
        </tr>
    </table>
  
</form>
<script languaje="javascript">

function iniciarBusqueda(str){
    var url="<?php echo $PATH_DOMAIN ?>/rpteInventarioDocumentos/ajaxExp/";
   $("#cargarExp").load(url,{valor:str});
    
}
</script>
<div id="recargar"></div>