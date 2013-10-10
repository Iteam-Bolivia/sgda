
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/exparchivo/<?php echo $PATH_EVENT ?>/">
    <input name="exa_id" id="exa_id" type="hidden" value="<?php echo $exa_id; ?>" />
    <table width="687" border="1">
        <tr>
            <td width="125">fil_id:</td>
            <td width="200">
                <select name="fil_id" id="fil_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $fil_id; ?>
                </select>
            </td>
            <td width="125">euv_id:</td>
            <td width="200">
                <select name="euv_id" id="euv_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $euv_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">exp_id:</td>
            <td width="200">
                <select name="exp_id" id="exp_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $exp_id; ?>
                </select>
            </td>
            <td width="125">ser_id:</td>
            <td width="200">
                <select name="ser_id" id="ser_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $ser_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">tra_id:</td>
            <td width="200">
                <select name="tra_id" id="tra_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $tra_id; ?>
                </select>
            </td>
            <td width="125">cue_id:</td>
            <td width="200">
                <select name="cue_id" id="cue_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $cue_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">trc_id:</td>
            <td width="200">
                <select name="trc_id" id="trc_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $trc_id; ?>
                </select>
            </td>
            <td width="125">uni_id:</td>
            <td width="200">
                <select name="uni_id" id="uni_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">ver_id:</td>
            <td width="200">
                <select name="ver_id" id="ver_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $ver_id; ?>
                </select>
            </td>
            <td width="125">exc_id:</td>
            <td width="200">
                <select name="exc_id" id="exc_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $exc_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">con_id:</td>
            <td width="200">
                <select name="con_id" id="con_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $con_id; ?>
                </select>
            </td>
            <td width="125">suc_id:</td>
            <td width="200">
                <select name="suc_id" id="suc_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $suc_id; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="125">usu_id:</td>
            <td width="200">
                <select name="usu_id" id="usu_id" class="required" style="width:190px">
                    <option value="">(seleccionar)</option>
                    <?php echo $usu_id; ?>
                </select>
            </td>
            <td>condicion:</td>
            <td><input name="exa_condicion" type="text" id="exa_condicion" value="<?php echo $exa_condicion; ?>" size="35" autocomplete="off" class="required" title="exa_condicion"/></td>
        </tr>
        <tr>
            <td>fecha_crea:</td>
            <td><input name="exa_fecha_crea" type="text" id="exa_fecha_crea" value="<?php echo $exa_fecha_crea; ?>" size="35" autocomplete="off" class="required" title="exa_fecha_crea"/></td>
            <td>usuario_crea:</td>
            <td><input name="exa_usuario_crea" type="text" id="exa_usuario_crea" value="<?php echo $exa_usuario_crea; ?>" size="35" autocomplete="off" class="required" title="exa_usuario_crea"/></td>
        </tr>
        <tr>
            <td>fecha_mod:</td>
            <td><input name="exa_fecha_mod" type="text" id="exa_fecha_mod" value="<?php echo $exa_fecha_mod; ?>" size="35" autocomplete="off" class="required" title="exa_fecha_mod"/></td>
            <td>usuario_mod:</td>
            <td><input name="exa_usuario_mod" type="text" id="exa_usuario_mod" value="<?php echo $exa_usuario_mod; ?>" size="35" autocomplete="off" class="required" title="exa_usuario_mod"/></td>
        </tr>
        <tr>
            <td>estado:</td>
            <td><input name="exa_estado" type="text" id="exa_estado" value="<?php echo $exa_estado; ?>" size="35" autocomplete="off" class="required" title="exa_estado"/></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td  >&nbsp;</td>
            <td><input id="btnSub" type="submit" value="Guardar" class="button"/></td>
            <td><input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
            <td colspan="4">&nbsp;</td>
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
                window.location="<?php echo $PATH_DOMAIN ?>/exparchivo/";
            }else{
                $("#formA").show();
            }
        });
    });

</script>
</body>
</html>