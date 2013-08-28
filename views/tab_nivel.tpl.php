<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/nivel/<?php echo $PATH_EVENT ?>/"><input
        name="niv_id" type="hidden" id="niv_id" value="<?php echo $niv_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td width="126">Nivel Dependencia:</td>
            <td colspan="3"><select name="niv_par" id="niv_par" class=""
                                    title="Nivel en el organigrama al que pertenece esta unidad">
                    <option value="">(seleccionar)</option>
                    <?php echo $niv_par; ?>
                </select></td>
        </tr>

        <tr>
            <td width="88">Abreviaci&oacute;n:</td>
            <td width="395"><input name="niv_abrev" id="niv_abrev" type="text"
                                   maxlength="5" size="8" autocomplete="off"
                                   class="required alphanumeric" title="Abreviaci&oacute;n"
                                   value="<?php echo $niv_abrev; ?>" /></td>
        </tr>
        <tr>
            <td>Descripci&oacute;n:</td>
            <td><input name="niv_descripcion" type="text" maxlength="300"
                       id="niv_descripcion" value="<?php echo $niv_descripcion; ?>"
                       size="60" autocomplete="off" class="required alphanum"
                       title="Descripci&oacute;n" /></td>
        </tr>
        <tr>
            <td colspan="2" class="botones"><input id="btnSub" type="submit"
                                                   value="Guardar" class="button" /> <input name="cancelar"
                                                   id="cancelar" type="button" class="button" value="Cancelar" />

        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/nivel/";
        });
    });
</script>