<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/empresas_ext/<?php echo $PATH_EVENT ?>/">
    <input name="emp_id" id="emp_id" type="hidden"
           value="<?php echo $emp_id; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>
        <tr>
<!--		<td width="125">C&oacute;digo:</td>-->
            <td width="200">
                <input name="emp_sigla" type="hidden" id="emp_sigla"	value="<?php echo '0'; ?>"  maxlength="2"	size="25" autocomplete="off" title="Codigo" />
            </td>
        </tr>


        <tr>
            <td width="125">Nombre Empresa:</td>
            <td width="200"><input name="emp_nombre" type="text" id="emp_nombre"
                                   value="<?php echo $emp_nombre; ?>" size="100" autocomplete="off"
                                   maxlength="255" title="Nombre Empresa" onkeypress="return tabEnterKeyPress(event, this)"
                                   onkeyup="this.value=this.value.toUpperCase()" class="required"/></td>
        </tr>

        <tr>
            <td colspan="4" class="botones"> <input
                    id="btnSub" type="submit" value="Guardar" class="button" /> <input
                    name="cancelar" id="cancelar" type="button" class="button"
                    value="Cancelar" /></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/empresas_ext/";
        });
    });
    $(function() {	
        $('#formAX .text').change(function(){
            $(this).removeClass('ui-state-error');
        });		
    });
</script>