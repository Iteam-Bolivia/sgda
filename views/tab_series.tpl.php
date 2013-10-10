<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/series/<?php echo $PATH_EVENT ?>/">

    <input name="ser_id" id="ser_id" type="hidden" value="<?php echo $ser_id; ?>" />
    <input name="delimiter" id="delimiter" type="hidden" value="<?php echo $delimiter; ?>" />
    <input name="contador" id="contador" type="hidden" value="" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?> Serie</caption>
        

            <tr>
                
                <td></td>
                <td>                    
                    <input name="fon_cod" type="hidden"
                           id="fon_cod" value="<?php echo $fon_cod; ?>" size="8" readonly
                           autocomplete="off" class="alphanum" maxlength="8"
                           title="C&oacute;digo Fondo, Subfondo" />
                    <input name="uni_cod" type="hidden"
                           id="uni_cod" value="<?php echo $uni_cod; ?>" size="6" readonly
                           autocomplete="off" class="alphanum" maxlength="8"
                           title="C&oacute;digo Seccion o Subseccion" /> 
                    
                    <input name="tco_codigo" type="hidden"
                           id="tco_codigo" value="<?php echo $tco_codigo; ?>" size="6" readonly
                           autocomplete="off" class="alphanum" maxlength="8"
                           title="C&oacute;digo Tipo de correspondencia" />                     
                    
                    <input name="ser_codigo" type="hidden"
                           id="ser_codigo" value="<?php echo $ser_codigo; ?>" size="6" readonly
                           autocomplete="off" class="alphanum" maxlength="2"
                           title="C&oacute;digo" />                
                </td>
                
            </tr> 
        
        
            <tr>
                <td>Fondo o Subfondo:</td>
                <td colspan="3">
                    <select name="fon_id" id="fon_id">
                        <option value="0">(Seleccionar)</option>
                        <?php echo $fon_id ?>
                    </select>
                </td>
            </tr>         
        
        
            <tr>
                <td>Secci&oacute;n o Subseccion:</td>
                <td colspan="1">
                    <select name="uni_id" id="uni_id" class="required">
                        <option value="0">(Seleccionar)</option>
                        <?php echo $uni_id ?>
                    </select>
                </td>                
            </tr>

            
        <tr>
            <td>Clase:</td>
            <td colspan="3">
                <select name="tco_id" id="tco_id">
                    <option value="0">(Seleccionar)</option>
                    <?php echo $tco_id ?>
                </select>
            </td>
        </tr>  
        
        <tr>
            <td>Tipo:</td>
            <td colspan="3">
                <input type="radio" name="ser_tipo" id="ser_tipo" value="R" 
                    title="Inicial"  />Inicial
                <input type="radio" name="ser_tipo" id="ser_tipo" value="N" 
                    title="No inicial" checked />No Inicial
            </td>
        </tr>         
        
        
        <tr>
            <td>Subserie de:</td>
            <td colspan="3">
                <select name="ser_par" id="ser_par">
                    <option value="0">(Seleccionar)</option>
                    <?php echo $ser_par ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Nombre de la Serie o Subserie:</td>
            <td colspan="3"><input name="ser_categoria" type="text"
                                   id="ser_categoria" value="<?php echo $ser_categoria; ?>" size="100"
                                   autocomplete="off" class="required alphanum" maxlength="256"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   title="Categor&iacute;a" />
            <span class="error-requerid">*</span>
            </td>
        </tr>
        
        <tr>
            <td>Valor documental de la Serie:</td>
            <td colspan="3">
                <select name="red_id" id="red_id">
                    <option value="0">(Seleccionar)</option>
                    <?php echo $red_id ?>
                </select>
            </td>
        </tr>        
        

        <tr>
            <td class="botones" colspan="4">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
        </tr>
    </table>
</form>


<p>&nbsp;</p>
<?php if ($LISTA_TRAMITES_SELECT != '') { ?>
    <div id="listaSerie1" class="seccion">Tr&aacute;mites de esta serie
        <ul>
            <?php echo $LISTA_TRAMITES_SELECT; ?>
        </ul>
    </div>
<?php } ?>


<script type="text/javascript">

    jQuery(document).ready(function($) {

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/series/";
        });

        
        $("#fon_id").change(function(){
            var delimiter = $("#delimiter").val();
            
            if($("#fon_id").val()==""){
            }else{
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/unidad/loadAjaxUnidades/',
                    type: 'POST',
                    data: 'Fon_id='+$("#fon_id").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            $("#uni_id").find("option").remove();
                            $("#uni_id").append("<option value=''>(seleccionar)</option>");
                            jQuery.each(datos, function(i,item){
                                $("#uni_id").append("<option value='"+i+"'>"+item+"</option>");
                            });
                        }else{
                            $("#uni_id").find("option").remove();
                            $("#uni_id").append("<option value=''>-No hay unidades-</option>");
                        }
                    }
                });
                
                
                
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/fondo/getCodigo/',
                    type: 'POST',
                    data: 'Fon_id='+$("#fon_id").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            $("#fon_cod").val(datos.fon_cod);
                            $("#uni_cod").val("");
                            $("#ser_codigo").val("");
                        }
                    }
                });                

            }
        });
        
        $("#uni_id").change(function(){
            var delimiter = $("#delimiter").val();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/unidad/getCodigo/',
                type: 'POST',
                data: 'Uni_id='+$("#uni_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#fon_cod").val(datos.fon_cod);
                        $("#uni_cod").val(datos.uni_cod);
                        $("#ser_codigo").val(datos.uni_contador);
                    }
                }
            });
            
            
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/series/loadAjaxSeries/',
                type: 'POST',
                data: 'Uni_id='+$("#uni_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#ser_par").find("option").remove();
                        $("#ser_par").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#ser_par").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#ser_par").find("option").remove();
                        $("#ser_par").append("<option value=''>-No hay series-</option>");
                    }
                }
            });            
            
            
            
            
        });
        
        $("#tco_id").change(function(){
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/unidad/getCodigoTipocorr/',
                type: 'POST',
                data: 'Tco_id='+$("#tco_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#tco_codigo").val(datos.tco_codigo);
                    }
                }
            });
        });
        


        $("#ser_par").change(function(){
            var delimiter = $("#delimiter").val();
            if($("#ser_par").val()==""){
            }else{
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/series/loadAjax/',
                    type: 'POST',
                    data: 'Ser_id='+$("#ser_par").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            //$("#ser_codigop").val(datos.ser_codigo);
                            $("#ser_codigo").val(datos.ser_parcont + delimiter +datos.ser_parcont);
                        }
                    }
                });

            }
        });



    
        
        
        $("#ser_codigo").change(function(){
        
            if($("#ser_codigo").val()!=""){
                $("#contador").val($("#ser_codigo").val());
            }
        });

    });

</script>