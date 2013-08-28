<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/retensiondoc/<?php echo $PATH_EVENT ?>/">
    <input name="red_id" type="hidden" id="red_id" value="<?php echo $red_id; ?>" />
    <input name="path_event" id="path_event" type="hidden" alue="<?php echo $PATH_EVENT; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanum"
                       id="red_codigo" 
                       maxlength="8"
                       name="red_codigo"
                       onkeyup="this.value=this.value.toUpperCase()"
                       title="código"
                       size="20"
                       type="text"
                       value="<?php echo $red_codigo; ?>"
                       /></td>
        </tr>
        
        <tr>
            <td>Series:</td>
            <td><input  class="required alphanum"
                       id="red_series"
                       maxlength="128"
                       name="red_series"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="100"
                       type="text"
                       title="nombre"
                       value="<?php echo $red_series; ?>"
                       /></td>
        </tr>

        <tr>
            <td>Tipo documental:</td>
            <td><input class="required alphanum"
                       id="red_tipodoc"
                       maxlength="256"
                       name="red_tipodoc"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="100" 
                       type="text" 
                       title="nombre"
                       value="<?php echo $red_tipodoc; ?>" 
                       /></td>
        </tr>
        
        <tr>
            <td>Valor documental:</td>
            <td><input class="required alphanum"
                       id="red_valdoc"
                       type="text"
                       maxlength="4"
                       name="red_valdoc"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="100"
                       title="nombre"
                       value="<?php echo $red_valdoc; ?>"
                        
                       /></td>
        </tr>     
        
        <tr>
            <td>Prescripción Archivística (años):</td>
            <td><input class="required onlynumeric"
                       id="red_prearc" 
                       maxlength="4"
                       name="red_prearc"
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="100"
                       title="nombre"
                       type="text"
                        value="<?php echo $red_prearc; ?>"
                       /></td>
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
            window.location="<?php echo $PATH_DOMAIN ?>/retensiondoc/";
        });
    });

</script>