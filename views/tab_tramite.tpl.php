<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/tramite/<?php echo $PATH_EVENT ?>/">

    <input name="tra_id" id="tra_id" type="hidden" value="<?php echo $tra_id; ?>" />
    <input name="ser_id" id="ser_id" type="hidden" value="<?php echo $ser_id; ?>" />
    <input name="sts_id" id="sts_id" type="hidden" value="<?php echo $sts_id; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?>GRUPO DOCUMENTAL</caption>
        <tr>
            <td>Serie:</td>
            <td colspan=2><?php echo $ser_categoria; ?></td>
        </tr>

        <tr>
            <td width="75">Orden:</td>
            <td colspan="2"><input name="tra_orden" type="text" id="tra_orden"
                                   value="<?php echo $tra_orden; ?>" size="10" autocomplete="off"
                                   class="onlynumeric" maxlength="3" title="Orden" /></td>
        </tr>

        <tr>
            <td>Grupo Documental:</td>
            <td colspan="2"><input name="tra_descripcion" type="text"
                                   id="tra_descripcion" value="<?php echo $tra_descripcion; ?>"
                                   size="90" autocomplete="off" maxlength="256"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="required alphanum" title="Grupo Documental" /></td>
        </tr>

        <tr>
            <td colspan="3">-</td>
        </tr>

<!--        <tr>
            <td title="Indique la(s) serie(s) a la que pertence el tr&aacute;mite">Series:</td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="ser" class="scrollBar h500">
                    <table class="marcaRegistro" width="100%">
                        <?php //echo $LISTA_SERIES; ?>
                    </table>
                </div>
            </td>
        </tr>-->

        <tr>
            <td colspan="3" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>
<!--br />
<?php if ($LISTA_SERIETRAMITES != "") { ?>
        <div id="listaSerie" class="seccion">Series de este tramite:
            <ul>
    <?php echo $LISTA_SERIETRAMITES; ?>
            </ul>
        </div>
<?php } ?><br />

<?php if ($LISTA_CUERPOS != "") { ?>
        <div id="listaCuerpos" class="seccion">Lista de Cuerpos de este tramite:
            <ul>
    <?php echo $LISTA_CUERPOS; ?>
            </ul>
        </div>
<?php } ?>-->
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/tramite/index/<?php echo VAR3; ?>/";
        });
        /* $("#btnSub").click(function(){
                        var i =0;
                        $(".marcaRegistro input[type=checkbox]").each(function() {
                                if($(this).is(':checked')){
                                        i++;
                                }
                        });
                        if(i>0){
                                return true;
                        }else{
                                var i=0;
                                $(".marcaRegistro ul li").each(function(){
                                                i++;
                                });
                                if(i==0)  {
                                        alert("Seleccione al menos un cuerpo");
                                        return false;
                                }
                                else{	return true; 	}

                        }

          });	*/
    });

</script>
