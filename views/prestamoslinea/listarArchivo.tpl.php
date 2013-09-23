
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<input type="hidden" name="archivos" id="archivos">
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/prestamosLinea/<?php echo $PATH_EVENT ?>/">
    <input name="sql" id="sql" type="hidden" value="" />
    
    <table width="100%" border="0">
        <caption class="titulo">BUSQUEDA DE EXPEDIENTES Y DOCUMENTOS</caption>        
        
        <tr>
            <td>Fondo o Subfondo:</td>
            <td><select name="fon_id" type="text" id="fon_id" 
                        title="Fondo o Subfondo del Expediente o Documento">
                    <option value="">(seleccionar)</option>
                    <?php echo $fon_id; ?>
                </select></td>
        </tr>   

        <tr>
            <td>Seccion o Subseccion:</td>
            <td><select name="uni_id" type="text" id="uni_id" 
                        title="Sección o Subsección Expediente o Documento">
                    <?php echo $uni_id; ?>                        
                </select></td>
        </tr>    
        
        <tr>
            </td>
            <td>Serie:</td>
            <td>
                <select name="ser_id" id="ser_id" title="Serie" >
                    <?php echo $ser_id; ?>
                </select>
            </td>
        </tr> 

        <tr>
            <td>Grupo documental:</td>
            <td colspan="3">
                <select name="tra_id" id="tra_id" autocomplete="off" 
                        title="Tr&aacute;mite" />
                    <?php echo $tra_id; ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Tipo Documental:</td>
            <td colspan="3">
                <select name="cue_id" id="cue_id" autocomplete="off" title="Tipos Documentales" />
                    <?php echo $cue_id; ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>T&iacute;tulo del Expediente:</td>
            <td colspan="3">
                <input name="exp_titulo" type="text" id="exp_titulo"
                    value="" size="100" autocomplete="off" maxlength="255"
                    class="alphanum" title="Título del Expediente" />
            </td>
        </tr>
        
        
        <tr>
            <td>T&iacute;tulo del Documento:</td>
            <td>
                <input type="text" name="fil_titulo" id="fil_titulo"
                       value="" size="100" autocomplete="off" maxlength="255"
                       class="alphanum" title="Título del Documento" value="" />
            </td>
        </tr>
        
<!--        <tr>
            <td width="166">Tipo de Documento:</td>
            <td colspan="3">
                <input type="radio" name="fil_tipoarch" value="ADM" 
                    title="Solo los documentos que han pasado por el proceso administrativo institucional"/>Administrativo
                <input type="radio" name="fil_tipoarch" value="CON" 
                    title="Sólo los documentos que pasan por el proceso administrativo contable y /o comercial tienen valor fiscal o contable. Documentos relacionados con mecanismos de control presupuestario, operaciones de gasto y ejecución presupuestaria"/>Financiero
                <input type="radio" name="fil_tipoarch" value="LEG" 
                    title="Sólo los documentos originales propios del proceso administrativo institucional, comercial y/o notarial tiene valor legal intrínseco"/>Legal
                <input type="radio" name="fil_tipoarch" value="TEC" 
                    title="Sólo los documentos originales propios del proceso administrativo institucional, tecnico tiene valor legal intrínseco"/>T&eacute;cnico
            </td>
        </tr>-->
        
        <tr>
            <td>Palabras Clave (separadas por <?php echo SEPARATOR_SEARCH; ?> ):</td>
            <td>
                <input name="pac_nombre" type="text" id="pac_nombre" 
                       value="" size="100" autocomplete="off" maxlength="255" class="alphanum"
                       title="Palabras clave de búsqueda"/>
            </td>
        </tr>
            
        <tr>
            <td>NUR/NURI:</td>
            <td><input name="fil_nur" type="text" id="fil_nur"
                       value="" size="20" autocomplete="off" maxlength="20"
                       class="alphanum" title="NUR/NURI" /></td>
        </tr> 
            
     </table>
       
    <p>        
    <table border="0">   
    <tr>
    <td>
    <input type="button" align="left" value="+ BÚSQUEDA AVANZADA POR DOCUMENTO" onclick='$("#div2").toggle(500);'>
    </td>
    </tr>
    </table>
    
    <div id="div2" style="background-color:#eeeeee;border:0px solid;display:none">
        <table width="100%" border="0">  
            
            <tr>
                <td>Departamento:</td>
                <td><select name="dep_id" type="text" id="dep_id" 
                            title="Departamento del Fondo">
                        <option value="">(seleccionar)</option>
                        <?php //echo $dep_id; ?>
                    </select></td>
            </tr> 
        
            <tr>
                <td>Subtitulo:</td>
                <td><input name="fil_subtitulo" type="text" id="fil_subtitulo"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Subtitulo del documento" /></td>
            </tr>  
            
            <tr>
                <td>Procedencia(Empresa):</td>
                <td><input name="fil_proc" type="text" id="fil_proc"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Empresa que elaboro el documento" /></td>
            </tr>             
            
            <tr>
                <td>Firma:</td>
                <td><input name="fil_firma" type="text" id="fil_firma"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Firma o persona que elabora el documento" /></td>
            </tr>     
            <tr>
                <td>Cargo:</td>
                <td><input name="fil_cargo" type="text" id="fil_cargo"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Cargo de la persona que elabora el documento" /></td>
            </tr>             
        </table>              
    </div>        
    </p>        
    
    <table width="100%" border="0">
        <tr>
            <td class="botones" colspan="4">
                <input id="btnClear" type="button" value="Limpiar" class="button"/>
                <input id="btnSubB" type="button" value="Buscar" class="button"/></td>
        </tr>
    </table>
</form>

<script type="text/javascript">
   var cantidad=3;

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/listarArchivo/search/',
        dataType: 'json',
        colModel : [
            {display: '<input type="checkbox" class="noteCheckBox" id="checkAll" onclick="checkAllNotes()" value="1"/>', name : 'chk_id', width : 40, sortable : true, align: 'center'},
            {display: 'Ver', name : 'view', width : 30, sortable : true, align: 'center'},   
            {display: 'Abrir', name : 'view', width : 30, sortable : true, align: 'center'},   
            {display: 'Id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'Fondo', name : 'fon_descripcion', width : 50, sortable : true, align: 'left'},
            {display: 'Seccion', name : 'uni_descripcion', width : 100, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 150, sortable : true, align: 'left'},
            {display: 'Expediente', name : 'exp_titulo', width : 150, sortable : true, align: 'left'},
            {display: 'Tipo Doc.', name : 'cue_descripcion', width : 150, sortable : true, align: 'left'},
            {display: 'Cod. Documento', name : 'fil_codigo', width : 140, sortable : true, align: 'left'},
            {display: 'T&iacute;tulo Documento', name : 'fil_titulo', width : 200, sortable : true, align: 'left'},
            {display: 'Procedencia', name : 'fil_proc', width : 100, sortable : true, align: 'left'},
            {display: 'Firma', name : 'fil_firma', width : 100, sortable : true, align: 'left'},
            {display: 'Cargo', name : 'fil_cargo', width : 100, sortable : true, align: 'left'},
            {display: 'Nro.Foj', name : 'fil_nrofoj', width : 40, sortable : true, align: 'center'},
            {display: 'Nro.Caja', name : 'fil_nrocaj', width : 40, sortable : true, align: 'center'},
            {display: 'Sala', name : 'fil_sala', width : 40, sortable : true, align: 'center'},
            {display: 'Estante', name : 'fil_estante', width : 40, sortable : true, align: 'center'},
            {display: 'Cuerpo', name : 'fil_cuerpo', width : 40, sortable : true, align: 'center'},
            {display: 'Balda', name : 'fil_balda', width : 40, sortable : true, align: 'center'},
            {display: 'Tipo', name : 'fil_tipoarch', width : 40, sortable : true, align: 'center'},
            {display: 'Estado', name : 'fil_mrb', width : 40, sortable : true, align: 'center'},
            {display: 'Nro.Ori', name : 'fil_ori', width : 40, sortable : true, align: 'center'},
            {display: 'Nro.Cop', name : 'fil_cop', width : 40, sortable : true, align: 'center'},
            {display: 'Nro.Fot', name : 'fil_fot', width : 40, sortable : true, align: 'center'},
            
            {display: 'NUR/NURI', name : 'fil_nur', width : 60, sortable : true, align: 'left'},
            {display: 'Asunto/Ref.', name : 'fil_asunto', width : 100, sortable : true, align: 'left'},
            
            {display: 'Disponibilidad', name : 'disponibilidad', width : 60, sortable : true, align: 'center'},
            {display: 'Doc.Digital', name : 'fil_nomoriginal', width : 300, sortable : true, align: 'left'},
            {display: 'Tamaño (MB)', name : 'fil_tamano', width : 60, sortable : true, align: 'center'},            
            {display: 'Obs', name : 'fil_obs', width : 150, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},{separator: true},
            {name: 'Imprimir', bclass: 'print', onpress : test},{separator: true},
            {name: 'Exportar', bclass: 'pdf', onpress : test},{separator: true},
           
           {name: 'Ver-lista', bclass: 'folder_table', onpress : test},{separator: true},
           
                    ],
        searchitems : [
            {display: 'Id', name : 'fil_id', isdefault: true},
//            {display: 'T&iacute;tulo', name : 'rol_titulo'},
//            {display: 'Descripci&oacute;n', name : 'rol_descripcion'},
//            {display: 'C&oacute;digo', name : 'rol_cod'}
        ],
        sortname: "fil_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE DOCUMENTOS BUSCADOS',
        useRp: true,
        rp: 40,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 250,
        fon_id: "",
        uni_id: "",
        ser_id: "",
        tra_id: "",
        cue_id: "",
        exp_titulo: "",
        fil_nur: "",
        fil_titulo: "",
        pac_nombre: "",
        fil_subtitulo: "",
        fil_proc: "",
        fil_firma: "",
        fil_cargo: "",
        onSuccess: function(){
            $('.viewFile').click(function(){
                url="<?php echo $PATH_DOMAIN ?>/archivo/download/"+$(this).attr('file')+"/";
                abrir(url);
            });
            $('.view').click(function(){
                url="<?php echo $PATH_DOMAIN ?>/archivo/printFichaSearch/"+$(this).attr('file')+"/";
                abrir(url);
            });            
            $('.viewFileP').click(function(){
                $("#fil_id").val($(this).attr("valueId"));
                $('#pass').val("");
                $('#dialog').dialog('open');
            });
        }        
    });


//    function dobleClik(grid){
//        if($('.trSelected div',grid).html())
//        {
//            $("#fil_id").val($('.trSelected div',grid).html());
//            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/rol/edit/");
//            document.getElementById('formA').submit();
//        }
//    }

function checkAllNotes(){
  

if($("#checkAll").val()==1){
    var t=1;
     while(t<=cantidad){
            $(".fil_chk"+t).attr('checked',true);
        t++;
        }document.getElementById("checkAll").value=0;
        document.getElementById("checkAll").checked=true;
}else
{var t=1;document.getElementById("checkAll").checked=false;
document.getElementById("checkAll").value=1;
            while(t<=cantidad){
            $(".fil_chk"+t).attr('checked',false);
        t++;
        } 
        
}
       
}
   
    
    function test(com,grid)
    {
$("#archivos").val($('.trSelected div',grid).html());
        if (com=='Imprimir'){            
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/prestamosLinea/rpteBuscar/");
            document.getElementById('formA').submit();                        
        }
             if (com=='Adicionar'){  
                 document.getElementById("archivos").value="";
                      
                 var t=1;var dt=0; var comi="";var cadena;
while(t<=cantidad){
    if($(".fil_chk"+t).attr('checked')==true){
         dt=$(".fil_chk"+t).val();
         //var cadena=new array();
         
cadena=document.getElementById("archivos").value;
if(cadena==""){
    comi="";
}else{
   document.getElementById("archivos").value+=",";  
}
            document.getElementById("archivos").value+=dt;
        }
    t++;    
    }
    var idLista=$("#archivos").val();
    var url="<?php echo $PATH_DOMAIN ?>/prestamosLinea/<?php echo $PATH_EVENT_LISTA ?>/";
                       
      $("#recarga").load(url,{valorId:idLista}); 
      $(".folder_table").css("display","block");
}


        //var valor=$(".fil_chk1").val();
       
         
        
        if (com=='Exportar'){
            if($('.fil_chk',grid).length > 0){
                var ids = "";
                var fil_privados = "";
                var doc_privado = false;
                var file = "0";
                $('.fil_chk',grid).each(function(){
                    if($(this).is(':checked')){
                        ids = ids + $(this).val() + ",";
                        if($(this).attr('restric')=='3'){
                            /*url="<?php echo $PATH_DOMAIN ?>/archivo/download/"+$(this).attr('value')+"/";
                                                abrir(url);*/
                            doc_privado = true;
                            file = $(this).val();
                            fil_privados = fil_privados + $(this).val() + ",";
                        }
                    }
                });
                $("#fil_ids").val(ids);
                /*alert("fil_ids: "+$("#fil_ids").val());*/
                if(doc_privado && $('#pass_open').val()==''){
                    $("#sw").val('0');
                    //pedir password para el conjunto de documentos privados
                    //alert("Los archivos "+ ids + " necesitan password para poder ser exportados.");
                    $("#archivos").html("Archivos afectados: "+fil_privados+" escriba el password para exportarlos.<br>");
                    $("#fil_id").val(file);
                    $('#pass_open').val("");
                    $('#pass').val("");
                    $('#dialogExport').dialog('open');
                }
                //if($("#sw").val()=='1'){
                else{
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/prestamosLinea/<?php echo $PATH_EVENT_EXPORT ?>/",
                        data: "fil_ids="+$("#fil_ids").val(),
                        dataType: "json",
                        success: function(msg){
                            if(msg.res=='OK'){
                                $("#nomArchivo").val(msg.archivo);
                                $("#formDescarga").submit();
                            }else{
                                alert(msg);
                            }
                        }
                    });
                }

            }else{
                alert("Seleccione un registro");
            }
        }
        
    }
	
    $(function() {

   $(".folder_table").css("display","none");
        $("#btnSubB").click(function(){
            $(".pReload",".flexigrid").click();
        });
        $("#btnClear").click(function(){
            $("#uni_id").find("option").remove();
            $("#ser_id").find("option").remove();
            $("#tra_id").find("option").remove();
            $("#cue_id").find("option").remove();
            $("#exp_titulo").val('');
            $("#fil_nur").val('');
            $("#fil_titulo").val('');    
            $("#fil_descripcion").val('');   
            
            $("#fil_subtitulo").val('');    
            $("#fil_proc").val('');    
            $("#fil_firma").val('');    
            $("#fil_cargo").val('');    
            
            $(".pReload",".flexigrid").click();
        });

    });        
        
        
    
</script>

<script type="text/javascript">

    $("#fon_id").change(function(){
        if($("#fon_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/prestamosLinea/loadAjaxUnidades/',
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
        }
    });
        
    $("#uni_id").change(function(){  
        if($("#uni_id").val()==""){
        }else{    
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/prestamosLinea/loadAjaxSeries/',
                type: 'POST',
                data: 'Uni_id='+$("#uni_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#ser_id").find("option").remove();
                        $("#ser_id").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#ser_id").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#ser_id").find("option").remove();
                        $("#ser_id").append("<option value=''>-No hay series-</option>");
                    }
                }
            }); 
        }
    });            
            
    $("#ser_id").change(function(){  
        if($("#ser_id").val()==""){
        }else{    
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/prestamosLinea/loadAjaxTramites/',
                type: 'POST',
                data: 'Ser_id='+$("#ser_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#tra_id").find("option").remove();
                        $("#tra_id").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#tra_id").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#tra_id").find("option").remove();
                        $("#tra_id").append("<option value=''>-No hay tramites-</option>");
                    }
                }
            }); 
        }
    });            
            
   $("#tra_id").change(function(){  
        if($("#tra_id").val()==""){
        }else{    
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/prestamosLinea/loadAjaxCuerpos/',
                type: 'POST',
                data: 'Tra_id='+$("#tra_id").val(),
                dataType:  		"json",
                success: function(datos){
                    if(datos){
                        $("#cue_id").find("option").remove();
                        $("#cue_id").append("<option value=''>(seleccionar)</option>");
                        jQuery.each(datos, function(i,item){
                            $("#cue_id").append("<option value='"+i+"'>"+item+"</option>");
                        });
                    }else{
                        $("#cue_id").find("option").remove();
                        $("#cue_id").append("<option value=''>-No hay cuerpos-</option>");
                    }
                }
            }); 
        }
    });        
               
                 
         
</script>
<div id="recarga"></div>