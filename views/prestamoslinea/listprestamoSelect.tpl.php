<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<div class="clear"></div>

<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/prestamosLinea/listarprestamo/"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>

<div class="clear"></div>
<input type="hidden" name="d_cantidad" id="d_cantidad">

<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>


<script type="text/javascript">
   var cantidad=0;

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/prestamosLinea/listar2/<?php echo VAR3 ?>/',
        dataType: 'json',
        colModel : [
            {display: '', name : 'chk_id', width : 40, sortable : true, align: 'center'},
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



    
    function loadarhivos(){
    
    cantidad=document.getElementById("d_cantidad").value;   


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

    }
    function test(com,grid)
    {
    cantidad=document.getElementById("d_cantidad").value;    
    
$("#archivos").val($('.trSelected div',grid).html());
        if (com=='Imprimir'){            
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/prestamosLinea/rpteBuscar/");
            document.getElementById('formA').submit();                        
        }
if (com=='Cancelar'){

var urlhack="<?php echo $PATH_DOMAIN ?>/prestamosLinea/eliminarsession/";
$("#recarga").load(urlhack);
     window.location.href="<?php echo $PATH_DOMAIN ?>/prestamosLinea/";
        
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
$( "#spr_fecini" ).datepicker();
$( "#spr_fecfin" ).datepicker();

   $(".folder_table").css("display","block");
        $("#btnSubB").click(function(){
            //$(".pReload",".flexigrid").click();
               loadarhivos();
     var dathay=document.getElementById("archivos").value
    if(dathay==""){
        $.msgbox("Por favor seleccione un lista");
        return false;
    }
    //window.location.href="<?php echo $PATH_DOMAIN ?>/prestamosLinea/listarprestamo/";
        
            
        });
        $("#btnClear").click(function(){
             $("#usu_telefono").val('');
            $("#usu_observ").val('');
            $("#usu_correo").val('');    
            $("#usu_solicitante").val('');  
            $("#nuevoUsu").val('');  
            $("#spr_fecfin").val('');
            $("#spr_fecini").val('');
          return false;
            
           // $(".pReload",".flexigrid").click();
        });

    });        
        
        
    
</script>
<script languaje="javascript">
function NuevoRegistro(){
    $("#nuevoUsu").show("fast");
   // document.getElementById("usu_solicitante")se
    //$("#usu_solicitante").che();
    document.forms['formA']['usu_solicitante'].value = '';
    document.getElementById("textNuevo").innerHTML='<a href="javascript:void(0)" style="color: #3F5A7C" onclick="CerrarRegistro()">Cerrar X</a>';
}
function CerrarRegistro(){
    
    $("#nuevoUsu").hide("fast");
    document.getElementById("textNuevo").innerHTML='<a href="javascript:void(0)" style="color: #3F5A7C" onclick="NuevoRegistro()">Nuevo</a>';

}
function cagarusuario(st){
    if(st==""){
        NuevoRegistro();
    }else{
        $("#nuevoUsu").val("");
        CerrarRegistro();
    }
}

</script>
<script languaje="javascript">
            jQuery(document).ready(function($) {  
                $("form.validable").bind("submit", function(e){
                    var post = "";
                    if (typeof filters == 'undefined') return;
                    $(this).find("input, textarea, select").each(function(x,el){
                        if ($(el).attr("className") != 'undefined') { 
                            $(el).removeClass("req");
                            $.each(new String($(el).attr("className")).split(" "), function(x, klass){
                                if ($.isFunction(filters[klass])){
                                    if (!filters[klass](el)){
                                        $(el).addClass("req");
                                        var idName = $(el).attr("name");
                                        $("#e_"+idName).fadeIn(800);
                                    }else{
                                        var idName = $(el).attr("name");
                                        if(post==''){
                                            post = idName + "=" + $(el).val();
                                        }else{
                                            post = post + "&"+idName + "=" + $(el).val();
                                        }
									
                                    }
                                }	
                            });
                        }
                    });
                    if ($(this).find(".req").size() > 0) {
                        $.stop(e || window.event);
                        return false;
                    }
                    return true;
                }); 
                // on focus	remueve los tag de error
                $("form.validable").find("input, textarea, select").each(function(x,el){ 
                    $(el).bind("focus",function(e){
                        if ($(el).attr("className") != 'undefined') { 
                            $(el).removeClass("req");
                            var idName = $(el).attr("name");
                            $("#e_"+idName).fadeOut(800);
                        }
                    });
                });
                /* para el acordeon */
		
                $(".pagClik").click(function(){
                    if($("."+$(this).attr('id')+"x").is(':visible')){
                        $("."+$(this).attr('id')+"x").hide();
                    }else{
                        $("."+$(this).attr('id')+"x").slideDown();
                    }
                });
                $("#menuarch a").click(function(){
                    var d = $(this).attr('di');
                    if($("."+d+"a").is(':visible')){
                        $("."+d+"a").hide();
                    }else{
                        $("."+d+"a").slideDown();
                    }
                });        
                $(".suboptAct").click(function(){
                    if($("#"+$(this).attr('id')+"x").is(':visible')){
                        $("#"+$(this).attr('id')+"x").hide();
                    }else{
                        $("#"+$(this).attr('id')+"x").slideDown();
                    }
                });
                $(".suboptAct").dblclick(function(){
                    location.href = $(this).attr('href');
                });
                // end	
                $("#menu4 dt a").click(function(){
                    var id = $(this).attr('id');
                    $("#menu4 dl").each(function(x,el){
                        if($("dt a",this).attr('id')==id){
                            if($(this).attr('class')=='Act'){
                                $(this).removeClass('Act');
                            }else{
                                $(this).attr('class','Act');
                            }
                        }						
                    });
                });
            })
	
        </script>

<div id="recarga"></div>

<div>

</div>