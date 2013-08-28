<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/expediente/<?php echo $PATH_EVENT ?>/">
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
                <td>Serie:</td>
                <td>
                    <select name="ser_id" id="ser_id" class="required">
                        <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $series; ?>
                    </select> 
                </td>

                <td>C&oacute;digo de Ref:</td>
                <td><input name="exp_codigo" type="text" id="exp_codigo" readonly
                           value="<?php echo $exp_codigo; ?>" size="20" autocomplete="off"
                           maxlength="20" title="C&oacute;digo" /></td>

            </tr>

            <tr>
                <td>T&iacute;tulo:</td>
                <td colspan="3"><input name="exp_nombre" type="text" id="exp_nombre"
                                       value="<?php echo $exp_nombre; ?>" size="120" autocomplete="off"
                                       onkeyup="this.value=this.value.toUpperCase()"
                                       maxlength="255" class="required alphanum" title="Nombre" /></td>
            </tr>

            <tr>
                <td>Fecha Inicio: </td>
                <td colspan="3"><input name="exf_fecha_exi"
                                       type="text" id="exf_fecha_exi" value="<?php echo $exf_fecha_exi; ?>"
                                       size="15" autocomplete="off" class="required" maxlength="10"
                                       title="Fecha extrema Inicial del Expediente o Fecha de Registro" /></td>
            </tr>

            <tr>
                <td>Fecha Final: </td>
                <td colspan="3"><input name="exf_fecha_exf" 
                                       type="text" 
                                       id="exf_fecha_exf" 
                                       value="<?php echo $exf_fecha_exf; ?>" 
                                       size="15" autocomplete="off" class="required" maxlength="10"
                                       title="Fecha extrema Inicial del Expediente o Fecha de Registro" /> </td>
            </tr>


            <!-- News --> 
            <tr>
                <td>Nivel de descripci&oacute;n:</td>
                <td colspan="3"><input name="exp_nivdes" type="text" id="exp_nivdes"
                                       value="<?php echo $exp_nivdes; ?>" size="120" autocomplete="off"
                                       onkeyup="this.value=this.value.toUpperCase()"
                                       maxlength="255" class="alphanum" title="Nivel de descripcion" /></td>
            </tr>

            <tr>
                <td>Volumen y soporte de la Unidad de Descripci&oacute;n:</td>
                <td colspan="3"><input name="exp_volsop" type="text" id="exp_volsop"
                                       value="<?php echo $exp_volsop; ?>" size="120" autocomplete="off"
                                       onkeyup="this.value=this.value.toUpperCase()"
                                       maxlength="255" class="alphanum" title="Volumen y soporte de la Unidad de Descripcion" /></td>
            </tr>    
            
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
            <td colspan="3"><input name="exp_nomprod" type="text" id="exp_nomprod"
                                   value="<?php echo $exp_nomprod; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Nombre del o de los Productores" /></td>
        </tr>        
        
        <tr>            
            <td>Historia Institucional/Reseña biogr&aacute;fica:</td>
            <td colspan="3">
                <textarea name="exp_hisins" 
                          id="exp_hisins" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
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
                          title="Historia Archivistica"><?php echo $exp_hisarc; ?></textarea>                                  
        </tr>         
        
        <tr>
            <td>Forma de ingreso:</td>
            <td colspan="3"><input name="exp_foring" type="text" id="exp_foring"
                                   value="<?php echo $exp_foring; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Forma de Ingreso" /></td>
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
                          title="Alcance y contenido"><?php echo $exp_alccon; ?></textarea>
        </tr>        

        <tr>
            <td>Valoraci&oacute;n, Selecci&oacute;n y eliminaci&oacute;n:</td>
            <td colspan="3"><input name="exp_vaseel" type="text" id="exp_vaseel"
                                   value="<?php echo $exp_vaseel; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Valoracion, Seleccion y eliminacion" /></td>
        </tr>
        
        <tr>
            <td>Nuevos Ingresos:</td>
            <td colspan="3"><input name="exp_nueing" type="text" id="exp_nueing"
                                   value="<?php echo $exp_nueing; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Nuevos Ingresos" /></td>
        </tr>
        
        <tr>
            <td>Organizaci&oacute;n:</td>
            <td colspan="3"><input name="exp_org" type="text" id="exp_org"
                                   value="<?php echo $exp_org; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Organizacion" /></td>
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
<div id="div4" style="background-color:#eeeeee;border:0px solid;display:none">
    <table width="100%" border="0">   
        <tr>
            <td>Condiciones de Acceso:</td>
            <td colspan="3"><input name="exp_conacc" type="text" id="exp_conacc"
                                   value="<?php echo $exp_conacc; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Condiciones de Acceso" /></td>
        </tr>
        
        <tr>
            <td>Condiciones de Reproducci&oacute;n:</td>
            <td colspan="3"><input name="exp_conrep" type="text" id="exp_conrep"
                                   value="<?php echo $exp_conrep; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Condiciones de Reproduccion" /></td>
        </tr>
        
        <tr>
            <td>Lengua/Escritura de la documentaci&oacute;n:</td>
            <td colspan="3"><input name="exp_lengua" type="text" id="exp_lengua"
                                   value="<?php echo $exp_lengua; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Lengua/Escritura de la documentacion" /></td>
        </tr>
        
        
        <tr>
            <td>Caracteristicas f&iacute;sicas o requisitos t&eacute;cnicos:</td>
            <td colspan="3"><input name="exp_carfis" type="text" id="exp_carfis"
                                   value="<?php echo $exp_carfis; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Caracteristicas fisicas o requisitos tecnicos" /></td>
        </tr>
        
        <tr>
            <td>Instrumentos de descripci&oacute;n:</td>
            <td colspan="3"><input name="exp_insdes" type="text" id="exp_insdes"
                                   value="<?php echo $exp_insdes; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Instrumentos de descripcion" /></td>
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
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Existencia y localizacion de originales" /></td>
        </tr>        
        
        <tr>
            <td>Existencia y localizaci&oacute;n de copias:</td>
            <td colspan="3"><input name="exp_exloco" type="text" id="exp_exloco"
                                   value="<?php echo $exp_exloco; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Existencia y localizacion de copias" /></td>
        </tr>  
        
        <tr>
            <td>Unidades de descripci&oacute;n relacionadas:</td>
            <td colspan="3"><input name="exp_underel" type="text" id="exp_underel"
                                   value="<?php echo $exp_underel; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Unidades de descripcion relacionadas" /></td>
        </tr> 
        
   
        <tr>
            <td>Notas de Publicaci&oacute;n:</td>
            <td colspan="3">
                <textarea name="exp_notpub" 
                          id="exp_notpub" 
                          cols="110" 
                          rows="3" 
                          class="alphanum" 
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
                          title="Notas"><?php echo $exp_notarc; ?></textarea>                   
        </tr>        
        
        <tr>
            <td>Reglas o Normas:</td>
            <td colspan="3"><input name="exp_regnor" type="text" id="exp_regnor"
                                   value="<?php echo $exp_regnor; ?>" size="120" autocomplete="off"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   maxlength="255" class="alphanum" title="Reglas o Normas" /></td>
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
<div id="div8" style="background-color:#eeeeee;border:0px solid">
    <table width="100%" border="0"> 
        <tr>
            <td>Soporte Fisico:</td>
            <td colspan="3">
                <select name="sof_id" id="sof_id" title="Sopor te f&iacute;sico." class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $sof_id ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>Nro. Ejemplares:</td>
            <td colspan="3">
                <input name="exp_nroejem" type="text" id="exp_nroejem"
                       value="<?php echo $exp_nroejem; ?>" size="40" autocomplete="off"
                       maxlength="20" class="required onlynumeric" title="Nro. Ejemplares" /></td>
        </tr>

        <tr>
            <td>Tomos (Vols):</td>
            <td colspan="3"><input name="exp_tomovol" type="text" id="exp_tomovol"
                                   value="<?php echo $exp_tomovol; ?>" size="40" autocomplete="off"
                                   maxlength="20" class="required onlynumeric" title="Tomos (Volumenes)" /></td>
        </tr>

        <tr>
            <td>Palabras Clave B&uacute;squeda:</td>
            <td colspan="3"><input name="exp_descripcion" type="text"
                                   id="exp_descripcion" value="<?php echo $exp_descripcion; ?>"
                                   size="120" autocomplete="off" maxlength="500"
                                   onkeyup="this.value=this.value.toUpperCase()"
                                   class="required alphanum" title="Descripci&oacute;n" />
                (<input type="checkbox" name="pac_nombre" value="ON"/> Guardar)
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
            <td>Contenedor:</td>
            <td colspan="3"><select name="con_id" id="con_id"
                                    title="Ubicaci&oacute;n f&iacute;sica donde se encuentra el expediente f&iacute;sico." class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $contenedores ?>
                </select></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>Sub Contenedor:</td>
            <td >
                <select name="suc_id" id="suc_id" title="Sub Contenedor f&iacute;sica donde se encuentra el expediente f&iacute;sico." class="required">
                    <?php echo $suc_id ?>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>


        <tr>
            <td>Tipo de Documento:</td>
            <td width="389">
                Original <input type="radio" name="exp_ocf" value="Original" <?php
                    if ($exp_ocf == 'Original') {
                        echo "checked='checked'";
                    }
                    ?> />
                Copia <input type="radio" name="exp_ocf" value="Copia" <?php
                                if ($exp_ocf == 'Copia') {
                                    echo "checked='checked'";
                                }
                    ?> />
                Fotocopia <input type="radio" name="exp_ocf" value="Fotocopia" <?php
                             if ($exp_ocf == 'Fotocopia') {
                                 echo "checked='checked'";
                             }
                    ?> />
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
</p>        


<p>        
<table border="0">   
<tr>
<td>
<input type="button" value="9. PROYECTOS" onclick='$("#div9").toggle(500);'>
</td>
</tr>
</table>
<div id="div9" style="background-color:#eeeeee;border:0px solid;display:none">

    <table width="100%" border="0"> 
        <tr>
            <td colspan="4"></td>
        </tr>        
            <?php
            if ($_SESSION['USU_VERPROY'] == 'SI') {
            //echo $_SESSION['USU_VERPROY'];
            ?>


            <tr>
                <td>PROYECTOS</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4" class="botones">
                    <div class="scrollBar" id="divSeries">
                        <table class="marcaRegistro" width="100%">
                            <?php echo $lista_tramos; ?>
                        </table>
                    </div>
                </td>
            </tr>

        <?PHP } ?>
            
        <tr>
            <td colspan="4">DESCRIPCIÓN ADICIONAL DEL EXPEDIENTE:</td>
        </tr>

        <tr>
            <td colspan="4"></td>
        </tr>        
                  

    </table>
</div>
</p>        

<table width="100%" border="0"> 
    <tr>
        <td colspan="10" class="botones">
            <input id="btnSub" type="button" value="Guardar" class="button" /> 
            <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
        </td>
    </tr>
</table>



</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/expediente/";
        });
        
        $("#btnSub").click(function(){
            //$('form#formA').submit();
            if($("input[name='exp_ocf']:radio").is(':checked')){
                $('form#formA').submit();
            }else{
                alert ("Seleccione Tipo de Documento");
            }
        });
        
    });

    $(function() {
        $("#idPC").hide();
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

        $("#verPC").click(function(){
            $("#idPC").toggle();
        });
        
        $("#palabra").click(function(){
            $("#exp_descripcion").val($(this).val());
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
            //            if( $("input[name='exp_ocf']:radio").is(':checked') && $("#nur").val()!="") {  
            //alert("Está activado");  
            if($("#nur").val()!=""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/expediente/verifNurTipoDoc/",
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
            //          }  
        });

        $('#exf_fecha_exi').datepicker({
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
        
        $('#exf_fecha_exf').datepicker({
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