<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/cuerpos/<?php echo $PATH_EVENT ?>/">  
    <input name="trc_id" id="trc_id" type="hidden" value="<?php echo $trc_id; ?>" />  
    <input name="cue_id" id="cue_id" type="hidden" value="<?php echo $cue_id; ?>" />
    <input name="tra_id" id="tra_id" type="hidden" value="<?php echo $tra_id; ?>" />  
    
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?>Tipo Documental</caption>
        
        <tr>
            <td>Grupo Documental:</td>
            <td colspan=2><?php echo $tra_descripcion; ?></td>
        </tr>       
        
        <tr>
            <td>Orden:</td>
            <td colspan="2"><input name="cue_orden" type="text" id="cue_orden"
                                   value="<?php echo $cue_orden; ?>" size="3" autocomplete="off"
                                   class="onlynumeric" title="Orden del Cuerpo" maxlength="20" /></td>
        </tr>

        <tr>
            <td>Tipo Documental:</td>
            <td colspan="2"><input name="cue_descripcion" type="text"
                                   id="cue_descripcion" value="<?php echo $cue_descripcion; ?>"
                                   size="90" autocomplete="off" class="required alphanum"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   title="Descripci&oacute;n" maxlength="500" /></td>
        </tr>



<!--        <tr>
            <td colspan="3">Tr&aacute;mites</td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="tram" class="scrollBar h500">
                    <table width="100%">
                        <?php //echo $LISTA_TRAMITES; ?>
                    </table>
                </div>
            </td>
        </tr>-->
        
        
        <tr>
            <td colspan="3" class="botones">
                <input name="guardar" id="btnSub" type="submit" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>

<!--br />
<?php if ($LIST_TRAMITECUERPOS != "") { ?>
            <div id="listaTramite" class="seccion">Tramites a los que  pertenece  este  cuerpo:
                    <ul>
    <?php echo $LIST_TRAMITECUERPOS; ?>
                    </ul>
            </div>
<?php } ?>-->

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#btnSub").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/cuerpos/";
        });
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/cuerpos/index/<?php echo VAR3; ?>/";
        });
    });

</script>