<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/<?php echo $PATH_EVENT ?>/">

    <input name="con_id" id="con_id" type="hidden" value="<?php echo $con_id; ?>" />
    <?php if (!$adm) { ?>
        <input name="usu_id" id="usu_id" type="hidden" value="<?php echo $usu_id; ?>" />
    <?php } ?>
    <table width="100%" border="0"><caption class="titulo">Registrar Contenedor</caption>
        <tr>
            <td>Usuario:</td>
            <td colspan="2"><?php echo $usuario; ?></td>
        </tr>
        <tr>
            <td width="80">Tipo:</td>
            <td><select name="ctp_id" id="ctp_id" autocomplete="off" class="required" title="Tipo de Contenedor" />
                <?php echo $tipo_contenedores; ?>
                </select></td>
        </tr>
        <tr>
            <td>C&oacute;digo:</td>
            <td><input name="con_codigo" type="text" id="con_codigo" value="<?php echo $con_codigo; ?>" size="35" autocomplete="off" class="required" title="con_codigo" maxlength="20" class="alphanumeric"/></td>
        </tr>
        <tr>
            <td>C&oacute;digo BBSS:</td>
            <td><input name="con_codbs" type="text" id="con_codbs" value="<?php echo $con_codbs; ?>" size="35" autocomplete="off" class="required" title="con_codigo" maxlength="20" class="alphanumeric"/></td>
        </tr>
        <tr>
            <td class="botones" colspan="2"><input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
<?php if ($PATH_CONTROLADOR == 'contenUsuario'): ?>
    <p align="right"><a href="<?php echo $PATH_DOMAIN ?>/perfil/view/" id="volver"><<--Volver a Perfil<<--</a></p>
<?php endif; ?>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/<?php echo $PATH_CONTROLADOR ?>/";
        });
    });

</script>