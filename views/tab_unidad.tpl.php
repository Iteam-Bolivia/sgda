<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/unidad/<?php echo $PATH_EVENT ?>/">
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
    <input name="uni_cod" id="uni_cod" type="hidden" value="<?php echo $uni_cod; ?>" />
    <input name="path_event" id="uni_id" type="hidden" value="<?php echo $PATH_EVENT; ?>" />
    
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo ?></caption>

        <tr>
            <td>Fondo o Subfondo Documental:</td>
            <td><select name="fon_id" id="fon_id" class="required"
                        title="Fondo documental">
                    <option value="">(seleccionar)</option>
                    <?php echo $fon_id; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td><input name="uni_codigo" type="hidden" id="uni_codigo"
                       value="<?php echo $uni_codigo; ?>" maxlength="8" size="15" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       autocomplete="off" title="C&oacute;digo" />
            
            </td>            
            
        </tr>        
        
        <tr>
            <td>Sección o Subsección:</td>
            <td colspan="2">
                <input name="uni_descripcion" type="text"
                                   id="uni_descripcion" value="<?php echo $uni_descripcion; ?>"
                                   maxlength="200" size="80" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="required alphanum" title="Descripci&oacute;n" />
            <span class="error-requerid">*</span>
            </td>            
        </tr>
        
        <tr>
            <td>Subsecci&oacute;n de:</td>
            <td><select name="uni_par" id="uni_par" 
                        title="Sección de la que depende">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_par; ?>
                </select>
            </td>                
        </tr>
        
        
        <tr>
            <td>Fase de Archivo: </td>
            <td colspan="2"><select name="tar_id" id="tar_id" class="required"
                                    title="Fase de archivo">
                    <option value="">(seleccionar)</option>
                    <?php echo $tar_id; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

   
        <tr>
            <td>Edificio:</td>
            <td><select name="ubi_id" id="ubi_id" class="required"
                        title="Edificio">
                    <option value="">(seleccionar)</option>
                    <?php echo $ubi_id; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Piso:</td>
            <td><select name="uni_piso" id="uni_piso" class="required"
                        title="Piso">
                    <option value="">(seleccionar)</option>
                    <?php echo $uni_piso; ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Teléfono(s):</td>
            <td colspan="2">
                <input name="uni_tel" 
                       type="text"
                       id="uni_tel" 
                       value="<?php echo $uni_tel; ?>"
                       maxlength="16" 
                       size="15" 
                       autocomplete="off"
                       onkeyup="this.value=this.value.toUpperCase()"
                       class="alphanum" 
                       title="Descripci&oacute;n" />
            </td>            
        </tr>
        
        <tr>
            <td colspan="4" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer"><a href="#" class="byLogos"
                    title="Desarrollado por ITeam business technology">Desarrollado por
        ITeam business technology</a></div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/unidad/";
        });        
    }); 
    

    $("#fon_id").change(function(){
        if($("#fon_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/unidad/loadAjaxUnidades/',
                type: 'POST',
                data: 'Fon_id='+$("#fon_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#uni_par").find("option").remove();
                        $("#uni_par").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#uni_par").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#uni_par").find("option").remove();
                        $("#uni_par").append("<option value=''>-No hay unidades-</option>");
                    }
                }
            });

        }
    });


    $("#ubi_id").change(function(){
        if($("#ubi_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/ubicacion/loadAjaxPisos/',
                type: 'POST',
                data: 'edif='+$("#ubi_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#uni_piso").find("option").remove();
                        $("#uni_piso").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#uni_piso").append("<option value='"+i+"'>"+item+"</option>");
                        });
//                    }else{
//                        $("#uni_piso").find("option").remove();
//                        $("#uni_piso").append("<option value=''>-No hay pisos-</option>");
                    }
                }
            });

        }
    });
    
    

</script>
</body>
</html>

