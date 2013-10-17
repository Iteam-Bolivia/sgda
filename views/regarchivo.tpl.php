<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/<?php echo $seccion; ?>/" enctype="multipart/form-data">
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
    <input name="tra_id" id="tra_id" type="hidden" value="<?php echo $tra_id; ?>" />
    <input name="cue_id" id="cue_id" type="hidden" value="<?php echo $cue_id; ?>" />
    <input name="exa_id" id="exa_id" type="hidden" value="<?php echo $exa_id; ?>" />
    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id ?>">
    <input name="dco_id" id="dco_id" type="hidden" value="<?php echo $dco_id ?>">
   <?php 
         $v3=$exp_id;
        
          $exparchivo = new tab_exparchivo();
       // $row = $this->exparchivo->dbSelectBySQL("select* from tab_exparchivo where exp_id=$var3 and cue_id=$var5 "); POR SI ACASO SI DECIDE CAMBIAR
        $row = $exparchivo->dbSelectBySQL("select* from tab_exparchivo where exp_id=$v3");
        $fil_id="";
        
        foreach ($row as $list){
            $fil_id = $list->fil_id;  
        }
          $palclave = new palclave();
       // $this->registry->template->pac_nombre = $palclave->listaPC();
          if($fil_id==""){
        $fil_descripcion = "";
          }else{
        $fil_descripcion = $palclave->listaPCFile($fil_id);
          }
   ?>
    
    <table width="100%" border="0">
        <caption class="titulo">DESCRIPCIÓN DEL DOCUMENTO</caption>
    </table>


    <p>
    <table border="0">
        <tr>
            <td>
                <input type="button" align="left" value="1. AREA DE CORRESPONDENCIA - SIACO" onclick='$("#div1").toggle(500);'>
            </td>
        </tr>
    </table>
    <div id="div1" style="background-color:#eeeeee;border:0px solid;display:none">
        <table width="100%" border="0">
            <tr>
                <td>NUR/NURI (SIACO):</td>
                <td colspan="3"><input name="fil_nur" type="text"
                                       id="fil_nur" maxlength="100" value="<?php echo $fil_nur; ?>"
                                       size="40" autocomplete="off"
                                       onkeyup="this.value=this.value.toUpperCase()"
                                       class="alphanum" title="registrar NUR/NURI" /></td>
            </tr>
            
            <tr>
                <td>NURIS HIJO (SIACO):</td>
                <td >
                    <select name="fil_nur_s" id="fil_nur_s" title="NURIS HIJO del documento">
                        <option value="">(seleccionar)</option>
                        <?php echo $fil_nur_s ?>
                    </select>
                </td>
            </tr>

        <tr>
            <td>Tipo de NUR/NURI: </td>
            <td colspan="3">
                Original<input type="radio" name="fil_tipoarch" value="ADM" <?php if ($fil_tipoarch == 'ADM') {
                        echo "checked";
                    } ?> title="Solo los documentos que han pasado por el proceso administrativo institucional"/>
                Copia digital<input type="radio" name="fil_tipoarch" value="CON" <?php if ($fil_tipoarch == 'CON') {
                        echo "checked";
                    } ?> title="Originales o copias de NURIs"/>
            </td>
        </tr>
            
            
            <tr>
                <td>CITE (SIACO):</td>
                <td >
                    <select name="fil_cite" id="fil_cite" title="CITE del documento">
                        <option value="">(seleccionar)</option>
                        <?php echo $fil_cite ?>
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Asunto/Referencia (SIACO):</td>
                <td colspan="3">
                    <input name="fil_asunto" type="text" id="fil_asunto"
                           maxlength="120" value="<?php echo $fil_asunto; ?>"
                           size="120" autocomplete="off"
                           title="Asunto o Referencia del documento"
                           onkeyup="this.value=this.value.toUpperCase()" /></td>
            </tr>

            <tr>
                <td>S&iacute;ntesis (SIACO):</td>
                <td colspan="3">
                    <input name="fil_sintesis" type="text" id="fil_sintesis"
                           maxlength="120" value="<?php echo $fil_sintesis; ?>"
                           size="120" autocomplete="off"
                           title="Resume o Síntesis del documento"
                           onkeyup="this.value=this.value.toUpperCase()" /></td>
            </tr>
        </table>
    </div>
</p>


<p>
<table border="0">
    <tr>
        <td>
            <input type="button" align="left" value="2. AREA DE IDENTIFICACION DEL DOCUMENTO" onclick='$("#div2").toggle(500);'>
        </td>
    </tr>
</table>
<div id="div2" style="background-color:#eeeeee;border:0px solid">
    <table width="100%" border="0">
        
        <tr>
            <td>Orden:</td>
            <td colspan="3"><input name="fil_nro" type="text" id="fil_nro"
                                   value="<?php echo $fil_nro; ?>" size="3" autocomplete="off"
                                   maxlength="3" class="required onlynumeric" title="Orden del documento" /></td>         
        </tr>
        
        <tr>
            <td>T&iacute;tulo:</td>
            <td colspan="3">
                <input name="fil_titulo" type="text" id="fil_titulo"
                                   value="<?php echo $fil_titulo; ?>" size="100" autocomplete="off"
                                   maxlength="1024" class="required alphanum" title="Titulo del documento" />
                Nro.:<input name="fil_titulo2" type="text" id="fil_titulo2"
                                   value="<?php echo ""; ?>" size="9" autocomplete="off"
                                   maxlength="16" class="alphanum" title="Número del documento" />                
            </td>
           
            <td></td>
            
            <td><input name="fil_codigo" type="hidden" id="fil_codigo" readonly
                       value="<?php echo $fil_codigo; ?>" size="20" autocomplete="off"
                       maxlength="8" title="C&oacute;digo" /></td>
        </tr>

        <tr>
            <td>Subt&iacute;tulo:</td>
            <td colspan="3"><input name="fil_subtitulo" type="text" id="fil_subtitulo"
                                   value="<?php echo $fil_subtitulo; ?>" size="120" autocomplete="off"
                                   maxlength="1024" class="alphanum" title="Subtitulo del documento" /></td>
            
        </tr>
        
        <tr>
            <td width="166">Tomos (Vols):</td>
            <td colspan="3"><input name="fil_tomovol" type="text"
                                   id="fil_tomovol" maxlength="32" value="<?php echo $fil_tomovol; ?>" size="40" autocomplete="off"
                                   class="alphanumeric" title="Nro de tomos" /></td>
        </tr>        
        
        <tr>
            <td></td>
            <td colspan="3"><input name="fil_fecha"
                                   type="hidden" id="fil_fecha" value="<?php echo $fil_fecha; ?>"
                                   size="15" autocomplete="off" maxlength="10"
                                   title="Fecha del documento" /></td>
        </tr>
        
        <tr>
            <td>Fecha: </td>
            <td> Mes:
                <select name="fil_mes" id="fil_mes">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $fil_mes; ?>
                </select> 
                Año:
                <select name="fil_anio" id="fil_anio">
                    <option value="" selected="selected">(seleccionar)</option>
                    <?php echo $fil_anio; ?>
                </select>                    
            </td>
        </tr>        
        
        
        
        <tr>
            <td>Lengua:</td>
            <td >
                <select name="idi_id" id="idi_id" title="Lengua del documento" class="required">
                    <option value="">(seleccionar)</option>
                    <?php echo $idi_id ?>
                </select>   <span class="error-requerid">*</span>
            </td>
        </tr>        

        <tr>
            <td width="166">Productor:</td>
            <td colspan="3"><input name="fil_proc" type="text"
                                   id="fil_proc" maxlength="256" value="<?php if($fil_proc==""){echo "ADMINISTRADORA BOLIVIANA DE CARRETERAS (ABC)";}else{echo $fil_proc;} ?>" size="120" autocomplete="off"
                                   class="alphanumeric" title="Nro de ejemplares" /></td>
        </tr>

        <tr>
            <td>Responsable:</td>
            <td colspan="3"><input name="fil_firma" type="text" id="fil_firma"
                                   value="<?php echo $fil_firma; ?>" size="120" autocomplete="off"
                                   maxlength="256" class="alphanum" title="Nombre del o de los Productores" /></td>
        </tr>

        <tr>
            <td>Cargo del responsable:</td>
            <td colspan="3"><input name="fil_cargo" type="text" id="fil_cargo"
                                   value="<?php echo $fil_cargo; ?>" size="120" autocomplete="off"
                                   maxlength="128" class="alphanum" title="Nombre del o de los Productores" /></td>
        </tr>
        
        
        <!-- Dynamic fields -->
        <?php //echo $filcampo; ?>
        
        
        <tr>
            <td width="166">Soporte Fisico:</td>
            <td colspan="3"><select name="sof_id" id="sof_id" class="required">
                    <option value="" >(Seleccionar)</option>
                    <?php echo $sof_id ?>
                </select><span class="error-requerid">*</span>
            </td>
        </tr>


        <tr>
            <td width="166">Nro. de Fojas:</td>
            <td colspan="3"><input name="fil_nrofoj" type="text"
                                   id="fil_nrofoj" maxlength="128" value="<?php echo $fil_nrofoj; ?>" size="40" autocomplete="off"
                                   class="" title="Nro de fojas" /></td>
        </tr>



        <tr>
            <td width="166">Nro.Ejemplares:</td>
            <td colspan="3"><input name="fil_nroejem" type="text"
                                   id="fil_nroejem" maxlength="32" value="<?php echo $fil_nroejem; ?>" size="40" autocomplete="off"
                                   class="onlynumeric" title="Nro de ejemplares" />
             <span class="error-requerid">*</span>
            </td>
        </tr>
        
       <tr>
            <td width="166">Nro. de caja:</td>
            <td colspan="3"><input name="fil_nrocaj" type="text"
                                   id="fil_nrocaj" maxlength="10" value="<?php echo $fil_nrocaj; ?>" 
                                   size="40" autocomplete="off"
                                   class="onlynumeric required" title="Nro de caja"  />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td width="166">Sala:</td>
            <td colspan="3"><input name="fil_sala" type="text"
                                   id="fil_sala" maxlength="16" value="<?php echo $fil_sala; ?>" 
                                   size="40" autocomplete="off"
                                   class="alphanumeric"
                                   title="Sala donde se almacena el documento" />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Estante:</td>
            <td colspan="3">
                <select name="fil_estante" id="fil_estante" 
                        title="Estante donde se almacena el documento" class="required">
                    <option value="" selected="selected">(seleccionar)</option>
                        <?php echo $fil_estante ?>
                </select>
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td>Cuerpo:</td>
            <td colspan="3"><input name="fil_cuerpo" type="text"
                                   id="fil_cuerpo" maxlength="16" value="<?php echo $fil_cuerpo; ?>" 
                                   size="40" autocomplete="off"
                                   class="alphanumeric required" 
                                   title="Cuerpo donde se almacena el documento" />
            <span class="error-requerid">*</span>
            </td>
        </tr>

        <tr>
            <td width="166">Balda:</td>
            <td colspan="3"><input name="fil_balda" type="text"
                                   id="fil_balda" maxlength="16" value="<?php echo $fil_balda; ?>" 
                                   size="40" autocomplete="off"
                                   class="alphanumeric required" 
                                   title="Balda donde se almacena el documento" />
            <span class="error-requerid">*</span>
            </td>
        </tr>        
        

    </table>
</div>
</p>



<p>
<table border="0">
    <tr>
        <td>
            <input type="button" value="3. PRESENTACION DEL DOCUMENTO" onclick='$("#div3").toggle(500);'>
        </td>
    </tr>
</table>
<div id="div3" style="background-color:#eeeeee;border:0px solid">
    <table width="100%" border="0">


        <tr>
            <td width="166">Documento :</td>
            <td colspan="3">
                <input type="radio" name="fil_tipoarch" value="ADM" <?php if ($fil_tipoarch == 'ADM') {
                        echo "checked";
                    } ?> title="Solo los documentos que han pasado por el proceso administrativo institucional"/>Administrativo
                <input type="radio" name="fil_tipoarch" value="CON" <?php if ($fil_tipoarch == 'CON') {
                        echo "checked";
                    } ?> title="Sólo los documentos que pasan por el proceso administrativo contable y /o comercial tienen valor fiscal o contable. Documentos relacionados con mecanismos de control presupuestario, operaciones de gasto y ejecución presupuestaria"/>Financiero
                <input type="radio" name="fil_tipoarch" value="LEG" <?php if ($fil_tipoarch == 'LEG') {
                        echo "checked";
                    } ?> title="Sólo los documentos originales propios del proceso administrativo institucional, comercial y/o notarial tiene valor legal intrínseco"/>Legal
                <input type="radio" name="fil_tipoarch" value="TEC" <?php if ($fil_tipoarch == 'TEC') {
                        echo "checked";
                    } ?> title="Sólo los documentos originales propios del proceso administrativo institucional, tecnico tiene valor legal intrínseco"/>T&eacute;cnico
            </td>
        </tr>

        <tr>
            <td width="166">Estado Documento :</td>
            <td colspan="3">
                <input type="radio" name="fil_mrb" value="Bueno" <?php if ($fil_mrb == 'Bueno') {
                        echo "checked='checked'";
                    } ?>/>Bueno
                <input type="radio" name="fil_mrb" value="Regular" <?php if ($fil_mrb == 'Regular') {
                        echo "checked='checked'";
                    } ?>/>Regular
                <input type="radio" name="fil_mrb" value="Malo" <?php if ($fil_mrb == 'Malo') {
                        echo "checked='checked'";
                    } ?>/>Malo
            </td>
        </tr>

        <tr>
            <td>Tipo de Documento:</td>
            <td colspan="3">
                        Original(es):
                        <input name="fil_ori" type="text"
                        id="fil_ori" maxlength="3" value="<?php echo $fil_ori; ?>" 
                        size="1" autocomplete="off"
                        class="numeric" onfocus='if(this.value==0){this.value=""}' onblur='if(this.value==""){this.value="0"}'
                        title="Nro. Documentos Originales" />                 
                                                   
                        Copia(s):
                        <input name="fil_cop" type="text"
                        id="fil_cop" maxlength="3" value="<?php echo $fil_cop ?>" 
                        size="1" autocomplete="off"
                        class="numeric" onfocus='if(this.value==0){this.value=""}' onblur='if(this.value==""){this.value="0"}'
                        title="Nro. Documentos Copia" />                 
                 
                        Duplicado(s):
                        <input name="fil_fot" type="text"
                        id="fil_fot" maxlength="3" value="<?php echo $fil_fot; ?>" 
                        size="1" autocomplete="off"
                        class="numeric" onfocus='if(this.value==0){this.value=""}' onblur='if(this.value==""){this.value="0"}'
                        title="Nro. Documentos Fotocopias" /> 
                  <span id="error"></span>                    
            </td>
        </tr>        

        
        <tr>
            <td>Palabras Clave (separadas por <?php echo SEPARATOR_SEARCH; ?> ):</td>
            <td colspan="3"><input name="fil_descripcion" type="text"
                                   id="fil_descripcion" value="<?php echo $fil_descripcion; ?>"
                                   size="120" autocomplete="off" maxlength="255"
                                   class="" title="Descripci&oacute;n o Palabras clave" onblur="caracteres(this.value)" />
               
                <!--             
(<input type="checkbox" name="pac_nombre" value="ON"/> Guardar)-->
                <br><a href="javascript:void(0)" title="Ver palabras claves" id="verPC">(+ Ver)</a>
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
            <td width="166">Confidencialidad:</td>
            <td><select name="fil_confidencialidad" id="fil_confidencialidad"
                        class="required"
                        title="Indicar si el Archivo ser&aacute; visto por: Todos (PUBLICO), Personal de la Unidad (RESTRINGIDO), Personal con permiso especial y contrase&ntilde;a (PRIVADO)">
<!--                    <option value="" selected="selected">(seleccionar)</option>-->
                        <?php echo $confidencialidad ?>
                </select>
            </td>
        </tr>

        <tr>
            <td width="166">Observaciones:</td>
            <td colspan="3">                
                <textarea name="fil_obs"  rows="4" cols="120" id="fil_obs" autocomplete="off" class="alphanumeric" maxlength="20024" title="Observaciones del registro de documentos"  ><?php echo $fil_obs; ?></textarea>                
            </td>
        </tr>

        <tr>
            <td width="166">DOCUMENTO DIGITAL:</td>
            <td colspan="3">
            </td>
        </tr>
        <tr>
            <td width="166">Escoger documento:</td>
            <td>
                <input type="file" name="archivo" id="archivo" 
                        <?php //echo $required_archivo; ?> 
                        title="Seleccione un archivo"/></td>
        </tr>
    </table>
</div>
</p>

<!-- Hasta aqui -->

<table width="100%" border="0">
    <tr>
        <td colspan="4" class="botones">
        <input type="hidden" name="accion" id="accion" value="cargar" />
        <input id="btnSub2" type="button" value="Guardar y Nuevo" class="button2" />             
        <input id="btnCargar" type="submit" value="Guardar" class="button" />
<!--                <input id="btnDigitalizar" type="submit" value="DigitalizarR" class="button" />-->
        <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" /></td>
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
<style>
    .oculto {
        visibility: hidden;
    }
</style>


<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            location.href="<?php echo $PATH_DOMAIN ?>/estrucDocumental/viewTree/<?php echo $exp_id; ?>/<?php echo $fil_id; ?>/";
        });
       /* $("#btnCargar").click(function(){
            $("#accion").val('cargar');
          $("#formA").submit();
        }); */
        $("#btnSub2").click(function(){
            $("#accion").val('cargarnuevo');
            $("#formA").submit();
        });      
        $("#btnDigitalizar").click(function(){
            $("#accion").val('digitalizar');
            $("#formA").submit();
        });
    });
    
    $(function() {
        $("#idPC").hide();
        
        $("#verPC").click(function(){
            $("#idPC").toggle();
        });

        $("#palabra").dblclick(function(){
            
        if($("#fil_descripcion").val()==""){
            $("#fil_descripcion").val($(this).val()+"; ");
        }else{
            //$("#fil_descripcion").val( + $(this).val()); 
            document.getElementById("fil_descripcion").value+=$(this).val()+"; ";
        }
            
             });


        $("#fil_nur").change(function(){
            var optionNuri_s = $("#fil_nur_s");
            var fil_nur = $("#fil_nur").val();
            optionNuri_s.find("option").remove();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/obtenerNuri_s/',
                type: 'POST',
                data: 'Fil_nur='+fil_nur,
                dataType:  'text',
                success: function(datos){
                    optionNuri_s.append(datos);
                }
            });
        });

        $("#fil_nur").change(function(){
            var optionSuc = $("#fil_cite");
            var fil_nur = $("#fil_nur").val();
            optionSuc.find("option").remove();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/obtenerCite/',
                type: 'POST',
                data: 'Fil_nur='+fil_nur,
                dataType:  'text',
                success: function(datos){
                    optionSuc.append(datos);
                }
            });
        });



        $("#fil_cite").change(function(){
            var fil_cite = $("#fil_cite").val();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/obtenerReferencia/',
                type: 'POST',
                data: 'Fil_cite='+fil_cite,
                dataType:  'json',
                success: function(datos){
                    $('#fil_asunto').val(datos.referencia);
                    $('#fil_sintesis').val(datos.sintesis);
                }
            });
        });




        $('#nur').blur(function(){
            //            if( $("input[name='exp_ocf']:radio").is(':checked') && $("#nur").val()!="") {
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
            //          }
        });

        $('#fil_fecha').datepicker({
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
<script languaje="javascript">
        $(function(){

        var  totalejemp;
        var  original;
        var  copia;
        var  foto;
        $("#fil_obs,#accion,#palabra,#fil_descripcion,#btnSub2,#btnCargar").click(function(){
    
              totalejemp=Number($("#fil_nroejem").val());
              copia=Number($("#fil_cop").val());
              original=Number($("#fil_ori").val());
              foto=Number($("#fil_fot").val());
              var cantidad=original+copia+foto;
          
              if(cantidad>totalejemp){
                  $("#error").html("No es válido, Excede la Cantidad de ejemplares");
       
                   $("#fil_nroejem").css("border","1px solid red");
                $("#fil_nroejem").css("background","#FFF0F0");
                  return false;
              }else{
                $("#error").html("");
                $("#fil_nroejem").css("border","1px solid #E3E2E2");
                $("#fil_nroejem").css("background","#ffffff");
              }
              
        })
        
    })
    
    function caracteres(s){
        //var mycars = new Array();
    document.getElementById("fil_descripcion").value="";
        var cantidad=s.length;
       var i;
        for(i=0;i<cantidad;i++){
          
            if(s[i]=="."){
             document.getElementById("fil_descripcion").value+=";";
            }else if(s[i]==","){
             document.getElementById("fil_descripcion").value+=";";
            }else{
          document.getElementById("fil_descripcion").value+=s[i];
            }
          
        }
        
    }
    
    
</script>
</body>
</html>