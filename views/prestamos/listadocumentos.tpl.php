<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<div class="clear"></div>

<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/prestamos/"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>

<div class="clear"></div>
<input type="hidden" name="d_cantidad" id="d_cantidad">

<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/prestamos/guardarPrestamo/">
    <input name="sql" id="sql" type="hidden" value="" />
    <input type="hidden" name="archivos" id="archivos" value="">
    <table width="100%" border="0">
        <caption class="titulo">DATOS DEL PRESTAMO</caption>        
        
        <tr>
            <td>Solicitante:</td>
            <td><select name="usu_solicitante" type="text" id="usu_solicitante" 
                        title="Nombre del solicitante" onchange="cagarusuario(this.value)" >
                    <option value="">(seleccionar)/ o ninguno</option>
                    <?php $usuario=new tab_usuario();
                    $dato=$usuario->dbSelectBySQL("select* from tab_usuario where usu_estado=1");
                   foreach($dato as $row){ ?>
                    <option value="<?php echo $row->usu_id ?>"><?php echo $row->usu_nombres." ".$row->usu_apellidos ?></option>
                       <?php } ?>
                </select>
                <span id="textNuevo"><a href="javascript:void(0)" style="color: #3F5A7C" onclick="NuevoRegistro()">Nuevo</a></span>
                <input type="text" name="nuevoUsu" id="nuevoUsu" onfocus="loadarhivos()" style="display: none" size="45">
            </td>
        </tr>
   

  <tr>
            <td>Fecha Inicial:</td>
            <td>
                <select name="dia">
                    <?php 
                    for($i=1;$i<=31;$i++){
                   echo "<option value='".$i."'>".$i."</option>";
                        }
                    $hoy=date("Y");
                        ?>
                   </select>
    
                    <select name="mes">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                   </select> 
              
                <select name="anio">
                    <?php 
                    $select="";
                    
                    for($i=1955;$i<=2025;$i++){
                       if($hoy==$i){
                          $select ="selected='selected'";
                     echo "<option value='".$i."' $select >".$i."</option>";
                       }else{
                       echo "<option value='".$i."' >".$i."</option>"; 
                       }
             
                        }
                        ?>
                   </select>
            </td>
        </tr>

        <tr>
            <td>Fecha Final:</td>
            <td>      <select name="dia1">
                    <?php 
                    for($i=1;$i<=31;$i++){
                   echo "<option value='".$i."'>".$i."</option>";
                        }
                    $hoy=date("Y");
                        ?>
                   </select>
    
                    <select name="mes1">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                   </select> 
              
                <select name="anio1">
                    <?php 
                    $select="";
                    
                    for($i=1955;$i<=2025;$i++){
                       if($hoy==$i){
                          $select ="selected='selected'";
                     echo "<option value='".$i."' $select >".$i."</option>";
                       }else{
                       echo "<option value='".$i."' >".$i."</option>"; 
                       }
             
                        }
                        ?>
                   </select>
            </td>
        </tr>
        
        <tr>
            <td>Correo electrónico:</td>
            <td><input type="text" name="usu_correo" type="text" id="usu_correo" 
                       title="Correo electrónico del usuario" size="47" onfocus="loadarhivos()" class="required email">
                                  
                </td>
        </tr>    
        
        <tr>
            </td>
            <td>Teléfono:</td>
            <td>
                <input type="text" name="usu_telefono" id="usu_telefono" title="Serie" class="required">
              
          
            </td>
        </tr> 
   <tr>
            </td>
            <td>Observación:</td>
            <td style="padding-bottom: 10px">
                <textarea name="usu_observ" id="usu_observ" cols="55" rows="4" onfocus="loadarhivos()"></textarea>
          
            </td>
        </tr> 
        
       
          
     </table>
       

      
       
    
    <table width="100%" border="0">
        <tr>
            <td class="botones" colspan="4" style="padding: 20px;border-top:1px dotted #3F5A7C">
                 <input id="btnSubB" type="submit" value="Guardar" class="button"/>
                <input id="btnClear" type="submit" value="Limpiar" class="button"/>
               </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
   var cantidad=0;

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/prestamos/listar/',
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
        buttons : [
             {name: 'Imprimir', bclass: 'print', onpress : test},{separator: true},
            {name: 'Exportar', bclass: 'pdf', onpress : test},{separator: true},
           
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
    //window.location.href="<?php echo $PATH_DOMAIN ?>/prestamos/listarprestamo/";
        
            
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

<div id="recarga"></div>
<input type="hidden" id="d_cantidad" value="3">
<div>

</div>