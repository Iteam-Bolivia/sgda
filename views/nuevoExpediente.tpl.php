<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/<?php echo $PATH_EVENT ?>/">
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <caption class="titulo"><?php echo $titulo ?> Expediente</caption>

    
    
<p>        
<table border="0">   
<tr>
<td>
<input type="button" align="left" value="1. AREA DE IDENTIFICACION" onclick='$("#div1").toggle(500);'>
</td>
</tr>
</table>
<div id="div1" style="background-color:#eeeeee;border:0px solid">
    <table width="100%" border="0">  
        
            <tr>
                <td>C&oacute;digo de Referencia (Autogenerado):</td>
                <td><input name="exp_codigo" type="text" id="exp_codigo" readonly
                           value="<?php echo $exp_codigo; ?>" size="30" autocomplete="off"
                           maxlength="20" title="C&oacute;digo" /></td>
            </tr>
            
            <tr>
                <td>Serie:</td>
                <td>
                    <select name="ser_id" id="ser_id" class="required">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $series; ?>
                    </select> 
                </td>
            </tr>

            <tr>
                <td>T&iacute;tulo:</td>
                <td colspan="3"><input name="exp_titulo" type="text" id="exp_titulo"
                                       value="<?php echo $exp_titulo; ?>" size="120" autocomplete="off"                                       
                                       maxlength="1024" class="required alphanum" title="Titulo del expediente" /></td>
            </tr>           
            
            
            <tr>
                <td>Fechas: </td>
                <td> Mes:
                    <select name="exp_mesi" id="exp_mesi">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_mesi; ?>
                    </select> 
                    Año:
                    <select name="exp_anioi" id="exp_anioi">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_anioi; ?>
                    </select>                    
                </td>
            </tr>
            
           <tr>
                <td></td>
                <td>
                    Mes:
                    <select name="exp_mesf" id="exp_mesf">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_mesf; ?>
                    </select> 
                    Año:
                    <select name="exp_aniof" id="exp_aniof">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_aniof; ?>
                    </select>                    
                </td>
            </tr>            
            
            
            
            <tr>
                <td></td>
                <td colspan="3">
                    <input name="exp_fecha_exi"
                           type="hidden" 
                           id="exp_fecha_exi" 
                           value="<?php echo $exp_fecha_exi; ?>"
                           size="15" 
                           autocomplete="off" 
                           class="required" maxlength="10"
                           title="Fecha extrema Inicial del Expediente o Fecha de Registro" />
                </td>
            </tr>

            <tr>
                <td></td>
                <td colspan="3">
                    <input name="exp_fecha_exf"                           
                           type="hidden" 
                           id="exp_fecha_exf" 
                           value="<?php echo $exp_fecha_exf; ?>" 
                           size="15" 
                           autocomplete="off" 
                           maxlength="10"
                           title="Fecha extrema Final del Expediente o Fecha de Registro" /> 
                </td>
            </tr>

            
            
            <tr>
                <td>Nivel de descripci&oacute;n:</td>
                <td>
                    <select name="exp_nivdes" id="exp_nivdes" class="required">
                        <?php echo $exp_nivdes; ?>
                    </select> 
                </td>
            </tr>            

            <tr>
                <td>Volumen y soporte de la Unidad de Descripci&oacute;n:</td>
                <td colspan="3"><input name="exp_volsop" type="text" id="exp_volsop"
                                       value="<?php echo $exp_volsop; ?>" size="120" autocomplete="off"
                                       maxlength="64" class="alphanum" title="Volumen y soporte de la Unidad de Descripcion" /></td>
            </tr>    
            
            <td><b>Datos adicionales:</b></td>
            <td>
            </td>            
            <?php echo $expcampo; ?>  
            
            
    </table>              
</div>        
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="2. AREA DE CONTEXTO" onclick='$("#div2").toggle(500);'>
</td>
</tr>
</table>
<div id="div2" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Nombre del o de los Productores:</td>                
                <td colspan="3">
                    <select name="exp_nomprod" id="exp_nomprod" class="required">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_nomprod; ?>
                    </select>                 
               </td>                
        </tr>        
        
        <tr>            
            <td>Historia Institucional/Reseña biogr&aacute;fica:</td>
            <td colspan="3">
                <textarea name="exp_hisins" 
                          id="exp_hisins" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Historia Institucional/Reseña biografica"><?php echo $exp_hisins; ?></textarea>                
        </tr>      
       
        <tr>
            <td>Historia Archivistica:</td>
            <td colspan="3">
                <textarea name="exp_hisarc" 
                          id="exp_hisarc" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Historia Archivistica"><?php echo $exp_hisarc; ?></textarea>                                  
        </tr>         
        
        <tr>
            <td>Forma de ingreso:</td>
            <td colspan="3"><input name="exp_foring" type="text" id="exp_foring"
                                   value="<?php echo $exp_foring; ?>" size="120" autocomplete="off"                                   
                                   maxlength="64" class="alphanum" title="Forma de Ingreso" /></td>
        </tr>        
                
    </table>   
</div>        
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="3. AREA DE CONTENIDO Y ESTRUCTURA" onclick='$("#div3").toggle(500);'>
</td>
</tr>
</table>
<div id="div3" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Alcance y contenido:</td>
            <td colspan="3">
                <textarea name="exp_alccon" 
                          id="exp_alccon" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Alcance y contenido"><?php echo $exp_alccon; ?></textarea>
        </tr>        

        <tr>
            <td>Valoraci&oacute;n, Selecci&oacute;n y eliminaci&oacute;n:</td>
            <td colspan="3"><input name="exp_vaseel" type="text" id="exp_vaseel"
                                   value="<?php echo $exp_vaseel; ?>" size="120" autocomplete="off"
                                   maxlength="64" class="alphanum" title="Valoracion, Seleccion y eliminacion" /></td>
        </tr>
        
        <tr>
            <td>Nuevos Ingresos:</td>
            <td colspan="3"><input name="exp_nueing" type="text" id="exp_nueing"
                                   value="<?php echo $exp_nueing; ?>" size="120" autocomplete="off"
                                   maxlength="64" class="alphanum" title="Nuevos Ingresos" /></td>
        </tr>
        
        <tr>
            <td>Organizaci&oacute;n:</td>
            <td colspan="3"><input name="exp_org" type="text" id="exp_org"
                                   value="<?php echo $exp_org; ?>" size="120" autocomplete="off"
                                   maxlength="64" class="alphanum" title="Organizacion" /></td>
        </tr>                
    </table>
</div>
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="4. AREA DE CONDICIONES DE ACCESO Y USO" onclick='$("#div4").toggle(500);'>
</td>
</tr>
</table>
<div id="div4" style="background-color:#eeeeee;border:0px solid">
    <table width="100%" border="0">   
        <tr>
            <td>Condiciones de Acceso:</td>
            <td colspan="3"><input name="exp_conacc" type="text" id="exp_conacc"
                                   value="<?php echo $exp_conacc; ?>" size="120" autocomplete="off"
                                   maxlength="64" class="alphanum" title="Condiciones de Acceso" /></td>
        </tr>
        
        <tr>
            <td>Condiciones de Reproducci&oacute;n:</td>
            <td colspan="3"><input name="exp_conrep" type="text" id="exp_conrep"
                                   value="<?php echo $exp_conrep; ?>" size="120" autocomplete="off"
                                   maxlength="64" class="alphanum" title="Condiciones de Reproduccion" /></td>
        </tr>
               
        <tr>
            <td>Lengua/Escritura de la documentaci&oacute;n:</td>
            <td>
                <select name="idi_id" id="idi_id" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $idi_id; ?>
                </select> 
            </td>
        </tr>        
        
        <tr>
            <td>Caracteristicas f&iacute;sicas o requisitos t&eacute;cnicos:</td>
            <td colspan="3">
                <select name="exp_carfis" id="exp_carfis" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $exp_carfis; ?>
                </select>                 
           </td>
        </tr>
           
        
        <tr>
            <td>Instrumentos de descripci&oacute;n:</td>
            <td colspan="3"><input name="exp_insdes" type="text" id="exp_insdes"
                                   value="<?php echo $exp_insdes; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Instrumentos de descripcion" /></td>
        </tr>                
    </table>
</div>
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="5. AREA DE DOCUMENTACION ASOCIADA" onclick='$("#div5").toggle(500);'>
</td>
</tr>
</table>
<div id="div5" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Existencia y localizaci&oacute;n de originales:</td>
            <td colspan="3"><input name="exp_exloor" type="text" id="exp_exloor"
                                   value="<?php echo $exp_exloor; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Existencia y localizacion de originales" /></td>
        </tr>        
        
        <tr>
            <td>Existencia y localizaci&oacute;n de copias:</td>
            <td colspan="3"><input name="exp_exloco" type="text" id="exp_exloco"
                                   value="<?php echo $exp_exloco; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Existencia y localizacion de copias" /></td>
        </tr>  
        
        <tr>
            <td>Unidades de descripci&oacute;n relacionadas:</td>
            <td colspan="3"><input name="exp_underel" type="text" id="exp_underel"
                                   value="<?php echo $exp_underel; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Unidades de descripcion relacionadas" /></td>
        </tr> 
        
   
        <tr>
            <td>Notas de Publicaci&oacute;n:</td>
            <td colspan="3">
                <textarea name="exp_notpub" 
                          id="exp_notpub" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Notas de Publicacion"><?php echo $exp_notpub; ?></textarea>                
        </tr>                
    </table>
</div>
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="6. AREA DE NOTAS" onclick='$("#div6").toggle(500);'>
</td>
</tr>
</table>
<div id="div6" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Notas:</td>
            <td colspan="3">
                <textarea name="exp_notas" 
                          id="exp_notas" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Notas"><?php echo $exp_notas; ?></textarea>                 
        </tr>                
    </table>
</div>
</p>

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="7. AREA DE CONTROL DE LA DESCRIPCION" onclick='$("#div7").toggle(500);'>
</td>
</tr>
</table>
<div id="div7" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Notas del archivero:</td>
            <td colspan="3">
                <textarea name="exp_notarc" 
                          id="exp_notarc" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
                          maxlength="10240"
                          title="Notas"><?php echo $exp_notarc; ?></textarea>                   
        </tr>        
        
        <tr>
            <td>Reglas o Normas:</td>
            <td colspan="3"><input name="exp_regnor" type="text" id="exp_regnor"
                                   value="<?php echo $exp_regnor; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Reglas o Normas" /></td>
        </tr> 
       
        <tr>
            <td>Fecha de la Descripci&oacute;n: </td>
            <td colspan="3"><input name="exp_fecdes"
                                   type="text" id="exp_fecdes" value="<?php echo $exp_fecdes; ?>"
                                   size="15" autocomplete="off" class="required" maxlength="10"
                                   title="Fecha de la Descripcion" /></td>
        </tr>                
    </table>
</div>
</p>

      

<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="8. PRESENTACION DEL EXPEDIENTE" onclick='$("#div8").toggle(500);'>
</td>
</tr>
</table>
<div id="div8" style="background-color:#eeeeee;border:0px solid;">
    <table width="100%" border="0">
        
        <tr>
            <td width="166">Soporte Fisico:</td>
            <td colspan="3"><select name="sof_id" id="sof_id">
                    <option value="">(Seleccionar)</option>
                    <?php echo $sof_id ?>
                </select>
            </td>
        </tr>


        <tr>
            <td width="166">Nro. de Fojas:</td>
            <td colspan="3"><input name="exp_nrofoj" type="text"
                                   id="exp_nrofoj" maxlength="8" value="<?php echo $exp_nrofoj; ?>" size="40" autocomplete="off"
                                   class="alphanumeric" title="Nro de fojas" /></td>
        </tr>

        <tr>
            <td width="166">Tomos (Vols):</td>
            <td colspan="3"><input name="exp_tomovol" type="text"
                                   id="exp_tomovol" maxlength="16" value="<?php echo $exp_tomovol; ?>" size="40" autocomplete="off"
                                   class="alphanumeric" title="Nro de tomos" /></td>
        </tr>

        <tr>
            <td width="166">Nro.Ejemplares:</td>
            <td colspan="3"><input name="exp_nroejem" type="text"
                                   id="exp_nroejem" maxlength="16" value="<?php echo $exp_nroejem; ?>" size="40" autocomplete="off"
                                   class="alphanumeric" title="Nro de ejemplares" /></td>
        </tr>
        
       <tr>
            <td width="166">Nro. de caja:</td>
            <td colspan="3"><input name="exp_nrocaj" type="text"
                                   id="exp_nrocaj" maxlength="10" value="<?php echo $exp_nrocaj; ?>" 
                                   size="40" autocomplete="off"
                                   class="onlynumeric" title="Nro de caja" /></td>
        </tr>

        <tr>
            <td width="166">Sala:</td>
            <td colspan="3"><input name="exp_sala" type="text"
                                   id="exp_sala" maxlength="16" value="<?php echo $exp_sala; ?>" 
                                   size="40" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="alphanumeric" 
                                   title="Sala donde se almacena el documento" /></td>
        </tr>

        <tr>
            <td>Estante:</td>
            <td colspan="3">
                <select name="exp_estante" id="exp_estante" 
                    title="Estante donde se almacena el documento" class="">
                    <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $exp_estante ?>
                </select></td>
        </tr>

        <tr>
            <td>Cuerpo:</td>
            <td colspan="3"><input name="exp_cuerpo" type="text"
                                   id="exp_cuerpo" maxlength="16" value="<?php echo $exp_cuerpo; ?>" 
                                   size="40" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="alphanumeric" 
                                   title="Cuerpo donde se almacena el documento" /></td>
        </tr>

        <tr>
            <td width="166">Balda:</td>
            <td colspan="3"><input name="exp_balda" type="text"
                                   id="exp_balda" maxlength="16" value="<?php echo $exp_balda; ?>" 
                                   size="40" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="alphanumeric" 
                                   title="Balda donde se almacena el documento" /></td>
        </tr>    
                        
        <tr>
            <td>Tipo de Documento:</td>
            <td colspan="3">
                Original(es):
                <input name="exp_ori" type="text"
                id="exp_ori" maxlength="3" value="<?php echo $exp_ori; ?>" 
                size="1" autocomplete="off"
                class="numeric" 
                title="Nro. Documentos Originales" />                 
                                  
                Copia(s):
                <input name="exp_cop" type="text"
                id="exp_cop" maxlength="3" value="<?php echo $exp_cop; ?>" 
                size="1" autocomplete="off"
                class="numeric" 
                title="Nro. Documentos Copia" />                 
                 
                Fotocopia(s):
                <input name="exp_fot" type="text"
                id="exp_fot" maxlength="3" value="<?php echo $exp_fot; ?>" 
                size="1" autocomplete="off"
                class="numeric" 
                title="Nro. Documentos Fotocopias" /> 
                                    
            </td>
        </tr>        

        <tr>
            <td>Palabras Clave (separadas por <?php echo SEPARATOR_SEARCH; ?> ):</td>
            <td colspan="3"><input name="exp_descripcion" type="text"
                                   id="exp_descripcion" value="<?php echo $exp_descripcion; ?>"
                                   size="120" autocomplete="off" maxlength="255"
                                   class="" title="Descripci&oacute;n" />
<!--                (<input type="checkbox" name="pac_nombre" value="ON"/> Guardar)-->
                <a href="#" title="Ver palabras claves" id="verPC">(+ Ver)</a>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <div id="idPC" style="color: darkblue">
                    <div><strong>Palabras Claves</strong></div>
                    <select name="palabra" id="palabra" size="10">
                        <?php echo $pac_nombre; ?>
                    </select>

                </div>
            </td>
        </tr>        
        
        <tr>
            <td width="166">Observaciones:</td>
            <td colspan="3"><input name="exp_obs" type="text"
                                   id="exp_obs" maxlength="100" value="<?php echo $exp_obs; ?>" 
                                   size="120" autocomplete="off"
                                   class="alphanumeric" 
                                   title="Observaciones del registro de expediente" /></td>
        </tr>                    
        
    </table>
</div>
</p>

<table width="100%" border="0"> 
    <tr>
        <td colspan="10" class="botones">
            <input type="hidden" name="accion" id="accion" value="guardar" />
            <input id="btnSub2" type="button" value="Guardar y Nuevo" class="button2" /> 
            <input id="btnSub" type="button" value="Guardar" class="button" /> 
            <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
        </td>
    </tr>
</table>



</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/nuevoExpediente/";
        });
        
        $("#btnSub").click(function(){
            $("#accion").val('guardar');
            $('form#formA').submit();
        });
        
        $("#btnSub2").click(function(){
            $("#accion").val('guardarnuevo');
            $('form#formA').submit();
        })        
        
    });

    $(function() {
        $("#idPC").hide();
        
        $("#verPC").click(function(){
            $("#idPC").toggle();
        });
        
        $("#palabra").click(function(){
            $("#exp_descripcion").val($(this).val());
        });
        
        $("#ser_id").change(function(){
            if($("#ser_id").val()==""){
            }else{
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/series/loadAjax/',
                    type: 'POST',
                    data: 'Ser_id='+$("#ser_id").val(),
                    dataType:  		"json",
                    success: function(datos){
                        if(datos){
                            $("#exp_codigo").val(datos.ser_codigo);
                        }
                    }
                });
            }
        });



        $("#con_id").change(function(){
            var optionSuc = $("#suc_id");
            var con_id = $("#con_id").val();
            optionSuc.find("option").remove();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/obtenerSuc/',
                type: 'POST',
                data: 'Con_id='+con_id,
                dataType:  'text',
                success: function(datos){
                    optionSuc.append(datos);
                }
            });
        });

        $('#nur').blur(function(){
                        if( $("input[name='exp_ocf']:radio").is(':checked') && $("#nur").val()!="") {  
            //alert("Está activado");  
            if($("#nur").val()!=""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/nuevoExpediente/verifNurTipoDoc/",
                    data: "Nur="+$('#nur').val(),
                    dataType: 'text',
                    success: function(datos){
                        var a = 'Original';
                        if(datos!=""){
                            //alert(datos);
                            $("input[type=radio][value=" + a + "]").attr("disabled",true);
                        }
                        else{//alert ('NO existe en formato original');
                            $("input[type=radio][value=" + a + "]").attr("disabled",false);
                        }
                    }
                });
            }
                      }  
        });

        $('#exp_fecha_exi').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        
        $('#exp_fecha_exf').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });


        $('#exp_fecdes').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });        
        

        
    });
    
    
</script>