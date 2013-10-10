<div class="clear"></div>
<form class="validable" id="formA" method="post" name="formA"  
      action="<?php echo $PATH_DOMAIN ?>/sistema/<?php echo $PATH_EVENT ?>/">
    
    <input id="sis_id" name="sis_id" type="hidden" value="<?php echo $sis_id; ?>" />
    <input id="path_event" name="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required alphanum"
                       id="sis_codigo"
                       maxlength="16"
                       name="sis_codigo"
                       onkeyup="this.value=this.value.toUpperCase()"
                       type="text"
                       size="20"
                       title="código"
                       value="<?php echo $sis_codigo; ?>" />
            </td>
        </tr>
        <tr>
            <td>Nombre del Sistema:</td>
            <td><input class="required alphanum"
                       id="sis_nombre"
                       maxlength="256"
                       name="sis_nombre"
                       onkeyup="this.value=this.value.toUpperCase()"
                       type="text"
                       size="60"
                       title="Nombre del Sistema"
                       value="<?php echo $sis_nombre; ?>" />
            </td>
        </tr>

        </tr>
        <td>Tipo de Carga de Documentos:</td>
        <td><select autocomplete="off"
                    class="required"
                    id="sis_tipcarga"
                    name="sis_tipcarga"
                    title="Tipo de Carga de Documentos">
                <option value="">(Seleccionar)</option>
                <?php echo $sis_tipcarga; ?>
            </select>
        </td>
        </tr>


        <tr>
            <td>Tamaño Máximo de Carga (MB):</td>
            <td><input class="required onlynumeric"
                       id="sis_tammax"
                       maxlength="10"
                       name="sis_tammax"
                       size="20"
                       title="Tamaño Máximo de Carga"
                       type="text"
                       value="<?php echo $sis_tammax; ?>" />
            </td>
        </tr>

        <tr>
            <td>Ruta de Carga:</td>
            <td><input class="required alphanum"
                       id="sis_ruta"
                       maxlength="1028"
                       name="sis_ruta"
                       size="20"
                       title="Ruta de la Carga"
                       type="text"
                       value="<?php echo $sis_ruta; ?>" />
            </td>
        </tr>

        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/sistema/";
        });
    });
</script>