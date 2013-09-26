<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/menu/<?php echo $PATH_EVENT ?>/">

    <input name="men_id" id="men_id" type="hidden" value="<?php echo $men_id; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?> Serie</caption>

        <tr>
            <td>Menu Padre:</td>
            <td colspan="3">
                <select autocomplete="off"
                        class="required"
                        id="men_par"
                        name="men_par"
                        title="Menú Padre"                    
                    <option value="0">(Seleccionar)</option>
                    <?php echo $men_par; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Titulo:</td>
            <td colspan="3">
                <input class="required"
                       id="men_tit" 
                       maxlength="70"
                       name="men_tit" 
                       size="50"
                       title="Titulo del menu"
                       type="text"                       
                       value="<?php echo $men_tit; ?>" />
            </td>
        </tr>

        <tr>
            <td>Enlace:</td>
            <td colspan="3">
                <input autocomplete="off" 
                       class="required" 
                       id="men_enlace" 
                       maxlength="100"
                       name="men_enlace" 
                       size="50" 
                       title="Enlace"
                       type="text"                       
                       value="<?php echo $men_enlace; ?>" />
            </td>
        </tr>

        <tr>
            <td>Posici&oacute;n:</td>
            <td colspan="3">
                <input class="required"
                       id="men_posicion" 
                       maxlength="10"
                       name="men_posicion" 
                       size="50"
                       title="Posición del menu"
                       type="text"                       
                       value="<?php echo $men_posicion; ?>" />
            </td>
        </tr>        
        <tr>
            <td class="botones" colspan="4">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
        
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/menu/";
        });
    });

</script>