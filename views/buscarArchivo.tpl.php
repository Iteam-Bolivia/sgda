<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/buscarArchivo/<?php echo $PATH_EVENT ?>/">
    <input name="sql" id="sql" type="hidden" value="" />
    
    <table width="100%" border="0">
        <caption class="titulo">BUSQUEDA DE EXPEDIENTES Y DOCUMENTOS</caption>        
        
        <tr>
            <td>Palabra de búsqueda:</td>
            <td colspan="3">
                <input name="palabra" type="text" id="palabra"
                    value="" size="100" autocomplete="off" maxlength="255"
                    class="alphanum" title="Palabra de Búsqueda" />
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
                    
             
            <tr>
                <td>Subtitulo:</td>
                <td><input name="fil_subtitulo" type="text" id="fil_subtitulo"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Subtitulo del documento" /></td>
            </tr>  
            
            <tr>
                <td>Productor:</td>
                <td><input name="fil_proc" type="text" id="fil_proc"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Empresa que elaboro el documento" /></td>
            </tr>             
            
            <tr>
                <td>Responsable:</td>
                <td><input name="fil_firma" type="text" id="fil_firma"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Firma o persona que elabora el documento" /></td>
            </tr>     
            <tr>
                <td>Cargo Responsable:</td>
                <td><input name="fil_cargo" type="text" id="fil_cargo"
                           value="" size="150" autocomplete="off" maxlength="20"
                           class="alphanum" title="Cargo de la persona que elabora el documento" /></td>
            </tr>   
                     
            
<!--        <tr>
            <td width="166">Tipo de Documento:</td>
            <td colspan="3">
                <input type="radio" name="fil_tipoarch" id="fil_tipoarch" value="ADM" 
                    title="Solo los documentos que han pasado por el proceso administrativo institucional"/>Administrativo
                <input type="radio" name="fil_tipoarch" id="fil_tipoarch" value="CON" 
                    title="Sólo los documentos que pasan por el proceso administrativo contable y /o comercial tienen valor fiscal o contable. Documentos relacionados con mecanismos de control presupuestario, operaciones de gasto y ejecución presupuestaria"/>Financiero
                <input type="radio" name="fil_tipoarch" id="fil_tipoarch" value="LEG" 
                    title="Sólo los documentos originales propios del proceso administrativo institucional, comercial y/o notarial tiene valor legal intrínseco"/>Legal
                <input type="radio" name="fil_tipoarch" id="fil_tipoarch" value="TEC" 
                    title="Sólo los documentos originales propios del proceso administrativo institucional, tecnico tiene valor legal intrínseco"/>T&eacute;cnico
            </td>
        </tr>         -->
        
        <tr>
            <td>Palabras Clave (separadas por <?php echo SEPARATOR_SEARCH; ?> ):</td>
            <td>
                <input name="pac_nombre" type="text" id="pac_nombre" 
                       value="" size="100" autocomplete="off" maxlength="255" class="alphanum"
                       title="Palabras clave de búsqueda"/>
            </td>
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


<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>

<script type="text/javascript">
    
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/buscarArchivo/search/',
        dataType: 'json',
        colModel : [
            {display: '', name : 'chk_id', width : 20, sortable : true, align: 'center'},
            {display: 'Ver', name : 'view', width : 30, sortable : true, align: 'center'},   
            {display: 'Abrir', name : 'view', width : 30, sortable : true, align: 'center'},
            
            {display: 'Id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'Cod. Documento', name : 'fil_codigo', width : 140, sortable : true, align: 'left'},            
            
            //{display: 'Fondo', name : 'fon_descripcion', width : 50, sortable : true, align: 'left'},
            
            {display: 'Seccion', name : 'uni_descripcion', width : 250, sortable : true, align: 'left'},
            
            //{display: 'Serie', name : 'ser_categoria', width : 250, sortable : true, align: 'left'},
            
            {display: 'Expediente', name : 'exp_titulo', width : 450, sortable : true, align: 'left'},
            
            //{display: 'Tipo Doc.', name : 'cue_descripcion', width : 250, sortable : true, align: 'left'},            
            
            {display: 'T&iacute;tulo Documento', name : 'fil_titulo', width : 650, sortable : true, align: 'left'},
            {display: 'Tomo/Vol.', name : 'fil_tomovol', width : 60, sortable : true, align: 'left'},
            {display: 'Productor', name : 'fil_proc', width : 250, sortable : true, align: 'left'},
            {display: 'Responsable', name : 'fil_firma', width : 100, sortable : true, align: 'left'},
            {display: 'Cargo Responsable', name : 'fil_cargo', width : 100, sortable : true, align: 'left'},
            {display: 'Nro.Fojas', name : 'fil_nrofoj', width : 100, sortable : true, align: 'left'},
            {display: 'Nro.Caja', name : 'fil_nrocaj', width : 40, sortable : true, align: 'right'},
            {display: 'Sala', name : 'fil_sala', width : 40, sortable : true, align: 'left'},
            {display: 'Estante', name : 'fil_estante', width : 40, sortable : true, align: 'left'},
            {display: 'Cuerpo', name : 'fil_cuerpo', width : 40, sortable : true, align: 'left'},
            {display: 'Balda', name : 'fil_balda', width : 40, sortable : true, align: 'left'},
            {display: 'Tipo', name : 'fil_tipoarch', width : 40, sortable : true, align: 'left'},
            {display: 'Estado', name : 'fil_mrb', width : 40, sortable : true, align: 'left'},
            {display: 'Nro.Ori', name : 'fil_ori', width : 40, sortable : true, align: 'right'},
            {display: 'Nro.Cop', name : 'fil_cop', width : 40, sortable : true, align: 'right'},
            {display: 'Nro.Fot', name : 'fil_fot', width : 40, sortable : true, align: 'right'},

            {display: 'Palabras clave', name : 'fil_palclave', width : 800, sortable : true, align: 'left'},
            {display: 'Obs', name : 'fil_obs', width : 1000, sortable : true, align: 'left'},
            
            // SIACO            
            {display: 'NUR/NURI', name : 'fil_nur', width : 100, sortable : true, align: 'left'},
            {display: 'Asunto/Ref.', name : 'fil_asunto', width : 100, sortable : true, align: 'left'},
            
            // DIGITAL
            //{display: 'Disponibilidad', name : 'disponibilidad', width : 60, sortable : true, align: 'center'},
            {display: 'Doc.Digital', name : 'fil_nomoriginal', width : 300, sortable : true, align: 'left'},
            {display: 'Tamaño (MB)', name : 'fil_tamano', width : 80, sortable : true, align: 'right'},            
            

            
        ],
        buttons : [
            {name: 'Imprimir', bclass: 'print', onpress : test},{separator: true},
        ],
        searchitems : [
            {display: 'Id', name : 'fil_id', isdefault: true},
        ],
        sortname: "fil_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE DOCUMENTOS BUSCADOS',
        useRp: true,
        rp: 50,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 1200,
        palabra: "",
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
        fil_tipoarch: "",
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
    
    function test(com,grid)
    {

        if (com=='Imprimir'){            
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/buscarArchivo/rpteBuscar/");
            document.getElementById('formA').submit();                        
        }
        
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
                        url: "<?php echo $PATH_DOMAIN ?>/buscarArchivo/<?php echo $PATH_EVENT_EXPORT ?>/",
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
        $("#btnSubB").click(function(){
            $(".pReload",".flexigrid").click();
        });
        $("#btnClear").click(function(){
            $("#palabra").val('');
            $("#fil_nur").val('');
            
            $("#uni_id").find("option").remove();
            $("#ser_id").find("option").remove();
            $("#tra_id").find("option").remove();
            $("#cue_id").find("option").remove();
            $("#exp_titulo").val('');
            $("#fil_titulo").val('');
            $("#fil_subtitulo").val('');    
            $("#fil_proc").val('');    
            $("#fil_firma").val('');    
            $("#fil_cargo").val('');    
            $("#pac_nombre").val('');
            
            $(".pReload",".flexigrid").click();
        });

    });        
        
        
    
</script>

<script type="text/javascript">

    $("#fon_id").change(function(){
        if($("#fon_id").val()==""){
        }else{
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/buscarArchivo/loadAjaxUnidades/',
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
                url: '<?php echo $PATH_DOMAIN ?>/buscarArchivo/loadAjaxSeries/',
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
                url: '<?php echo $PATH_DOMAIN ?>/buscarArchivo/loadAjaxTramites/',
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
                url: '<?php echo $PATH_DOMAIN ?>/buscarArchivo/loadAjaxCuerpos/',
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
