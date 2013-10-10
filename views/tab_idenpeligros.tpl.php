<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/idenpeligros/<?php echo $PATH_EVENT ?>/">
    <input name="ide_id" id="ide_id" type="hidden" value="<?php echo $ide_id; ?>" />
    <table width="100%" border="0"><caption class="titulo">
            Identificaci&oacute;n de riesgos
        </caption>
        <tr>
            <td width="144">Local :</td>
            <td><select name="loc_id" id="loc_id" class="required" style="width:190px" title="Local">
                    <option value="">-Seleccionar-</option>
                    <?php echo $loc_id; ?>
                </select></td>
        </tr>
        <tr>
            <td>Elementos Expuetos:</td>
            <td><table width="542">
                    <tr>
                        <td width="215"><input type="checkbox" name="ide_ele_ex[]2" value="P" <?php echo $chekP; ?> />PERSONAS </td>
                        <td width="315"><input type="checkbox" name="ide_ele_ex[]6" value="M" <?php echo $chekM; ?> />MOVILIARIO Y MATERIALES</td>
                    </tr> <tr>
                        <td><input type="checkbox" name="ide_ele_ex[]3" value="D" <?php echo $chekD; ?> />
                            DOCUMENTACI&Oacute;N </td>
                        <td><input type="checkbox" name="ide_ele_ex[]7" value="H" <?php echo $chekH; ?> />
                            HERRAMIENTAS ESPEC&Iacute;FICAS</td></tr> <tr>
                        <td><input type="checkbox" name="ide_ele_ex[]4" value="E" <?php echo $chekE; ?> />
                            EDIFICACI&Oacute;N </td>
                        <td><input type="checkbox" name="ide_ele_ex[]8" value="I" <?php echo $chekI; ?> />
                            INSTALACIONES TECNICAS</td></tr> <tr>
                        <td><input type="checkbox" name="ide_ele_ex[]5" value="A" <?php echo $chekA; ?> />
                            AMBIENTE INTERIOR</td>
                        <td><input type="checkbox" name="ide_ele_ex[]" value="O" <?php echo $chekO; ?> />
                            OBJETOS HISTORICOS </td></tr>
                </table>
                <hr />
            </td>
        </tr>
        <tr>
            <td>Peligros:</td>
            <td>

                <table width="510" >
                    <tr>
                        <td width="215"><input type="checkbox" name="ide_peligros[]2" value="p" <?php echo $chekp; ?> />PLAGAS </td>
                        <td width="282"><input type="checkbox" name="ide_peligros[]6" value="a" <?php echo $cheka; ?> />
                            AGUA </td></tr> <tr>
                        <td><input type="checkbox"  name="ide_peligros[]3" value="r" <?php echo $chekr; ?> />
                            ROBO </td>
                        <td><input type="checkbox" name="ide_peligros[]7" value="t" <?php echo $chekt; ?> />
                            TEMPERATURA</td></tr> <tr>
                        <td><input type="checkbox"  name="ide_peligros[]4" value="i" <?php echo $cheki; ?> />
                            INCENDIO </td>
                        <td><input type="checkbox" name="ide_peligros[]8"  value="h" <?php echo $chekh; ?> />
                            HUMEDAD</td></tr> <tr>
                        <td><input type="checkbox"  name="ide_peligros[]5" value="e" <?php echo $cheke; ?> />
                            EXPLOSI&Oacute;N </td>
                        <td><input type="checkbox" name="ide_peligros[]" value="q"  <?php echo $chekq; ?> />
                            QU&Iacute;MICOS</td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td  >Oficina:</td>
            <td>
                <input name="ide_oficina" type="text" id="ide_oficina" value="<?php echo $ide_oficina; ?>" size="35" autocomplete="off" class="required" title="ide_oficina"/></td>
        </tr>
        <tr>
            <td  >Observaciones:</td>
            <td colspan="2"><input name="ide_observaciones" type="text" id="ide_observaciones" value="<?php echo $ide_observaciones; ?>" size="120" autocomplete="off" class="required" title="ide_observaciones"/></td>
        </tr>
        <tr>
            <td class="botones" colspan="2">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/idenpeligros/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>