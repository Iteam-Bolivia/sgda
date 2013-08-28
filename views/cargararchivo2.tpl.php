
<div class="clear"></div>

<?php echo $tituloEstructura; ?>
<p align="left"><?php echo $linkTree; ?></p>
<form id="formA" name="formA" method="post" enctype="multipart/form-data" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/">

    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
    <input name="exp_id" id="fil_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <table width="687" border="1">
        <caption class="titulo">CARGA O DIGITALIZACION DE ARCHIVO
        </caption>
        <tr>
            <td width="149">Archivo:</td>
            <td colspan="3">
                <input type="file" name="archivo" id="archivo" size="40" class="required" title="Seleccione un archivo" />
                <input id="btnSub" type="submit" value="Guardar" class="button"/></td>
        </tr>
    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            if($("#formA").is(":visible")){
                $("#formA").hide();
                //$(".flexigrid").attr('class','flexigrid');
                window.location="<?php echo $PATH_DOMAIN ?>/archivo/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>