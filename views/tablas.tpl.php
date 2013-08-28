<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/tablasparametricas/<?php echo $PATH_EVENT ?>/">

    <input name="nombreTabla" id="nombreTabla" type="hidden" value="<?php echo $nombreTabla; ?>" />
    <input name="campo_id" id="campo_id" type="hidden" value="<?php echo $campo_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $tituloTabla; ?></caption>
        <?php echo $cuerpoCampos; ?>
        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>

</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
	
        $("#cancelar").click(function(){
            window.history.back(-1);
        });
	 	  
    });
    $(function() {
        //$("#datepicker1").datepicker();
        $('#datepicker1').datepicker({dateFormat: "yy-mm-dd",changeMonth: true,	changeYear: true}); 
        $('#datepicker2').datepicker({dateFormat: "yy-mm-dd",changeMonth: true,	changeYear: true}); 
        $('#datepicker3').datepicker({dateFormat: "yy-mm-dd"}); 
    });

</script>

