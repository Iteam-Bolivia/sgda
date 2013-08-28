<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/palclave/<?php echo $PATH_EVENT ?>/">
    <input name="pac_id" type="hidden" id="pac_id" value="<?php echo $pac_id; ?>" />
    <input name="path_event" id="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
       
        <tr>
            <td>Palabra Clave:</td>
            <td><input class="required alphanum"
                       id="pac_nombre"
                       maxlength="255"
                       name="pac_nombre"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" 
                       type="text"
                       title="nombre"
                       value="<?php echo $pac_nombre; ?>"
                       /></td>
        </tr>
        
        <tr>
            <td>Nivel de Descripci&oacute;n:</td>
            <td><select name="pac_formulario" id="pac_formulario">
                    <option value="Expediente">Expediente</option>
                    <option value="Archivo">Documento</option>
                </select>
                
            </td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/palclave/";
        });

    });

</script>