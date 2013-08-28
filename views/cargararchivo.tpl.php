
<div class="clear"></div>

<?php /* echo $tituloEstructura; ?>
  <p align="left"><?php echo $linkTree;?></p> */ ?>
<form id="formA" name="formA" method="post" enctype="multipart/form-data" class="validable" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/<?php echo $seccion; ?>/">

    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
    <input name="exp_id" id="fil_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <table width="100%" border="0">
        <caption class="titulo">CARGA O DIGITALIZACION DE ARCHIVO
        </caption>
        <tr>
            <td width="149">Archivo:</td>
            <td colspan="3">
                <input type="file" name="archivo" id="archivo" class="required" title="Seleccione un archivo" />
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
</body>
</html>
