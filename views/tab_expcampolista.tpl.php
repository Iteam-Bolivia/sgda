<div class="clear"></div>
    
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/expcampolista/<?php echo $PATH_EVENT ?>/">  
    
    <input name="ecl_id" id="ecl_id" type="hidden" value="<?php echo $ecl_id; ?>" />
    <input name="ecp_id" id="ecp_id" type="hidden" value="<?php echo $ecp_id; ?>" />    
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?>Valor de la lista</caption>
        <tr><td>Campo de lista:</td><td colspan=2><?php echo $ecp_nombre; ?></td></tr>
        
        <tr>
            <td>Valor:</td>
            <td colspan="2"><input name="ecl_valor" type="text"
                                   id="ecl_valor" value="<?php echo $ecl_valor; ?>"
                                   size="120" autocomplete="off" class="required alphanum"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   title="Valor del campo" maxlength="255" /></td>
        </tr>
        
        <tr>
            <td colspan="3" class="botones">
                <input name="guardar" id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
        
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#btnSub").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/expcampolista/";
        });
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/expcampolista/index/<?php echo VAR3; ?>/";
        });
    });

</script>