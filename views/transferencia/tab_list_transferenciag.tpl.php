<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>
<div align="left">
  <?php
  if(isset($_SESSION['id_transferencia'])){
   //$dtt=explode(",",$_SESSION['id_transferencia']);
   $dtt= $_SESSION['id_transferencia'];
  }else{
   $dtt=0;
  }
  ?>
</div>
<div id="recarga2">
    <input type="hidden" id="sesi" value="<?php echo $dtt?>">
</div>
<div class="clear"></div>
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/transferencia/" border="0"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferencia/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="str_id" type="hidden" value="<?php echo $str_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="ids" id="ids" type="hidden" value="" />
</form>
<input type="hidden" id="exp_reprobado">
<form id="form" name="form" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/transferencia/guardarTransferencia/">
    <input name="sql" id="sql" type="hidden" value="" />
    <input type="hidden" name="archivos" id="archivos" value="">
    <table width="100%" border="0">
        <caption class="titulo">DATOS DEL PRESTAMO</caption>        
        <tr>
            <th width="180" height="30">Seccion Origen:</th>
            <td>
                <?php 
                $usu=$_SESSION ['USU_ID'];
                $id_exps=$_SESSION ['id_transferencia'];
                $usu_origen=new tab_usuario();
                $result_uni=new tab_unidad();
              $result=$usu_origen->dbselectByField("usu_id",$usu);
          $result=$result[0];
               $uni_id=$result->uni_id;
                $res_uni=$result_uni->dbselectByField("uni_id",$uni_id);
                $res_uni=$res_uni[0];
                echo $res_uni->uni_descripcion;
                
                        ?>
        <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id ?>" />       
        <div id="recarga3"><input name="idsExp" id="idsExp" type="hidden" value="<?php echo $id_exps ?>" /> </div>
        <input name="ser_id" id="ser_id" type="hidden" value="" />
        <input name="exp_id" id="exp_id" type="hidden" value="" />
         <input type="hidden" id="usu_id" name="usu_id" value="<?php echo $usu ?>">
            </td>
        </tr>
             <tr>
            <th height="30">Usuario Origen:</th>
            <td><?php 
            
                $usu_origen=new tab_usuario();
              $result=$usu_origen->dbSelectBySQL("select* from tab_usuario where usu_id=$usu");
               foreach($result as $row){
                    $nombre=$row->usu_nombres;
                    $apellido=$row->usu_apellidos;
               }
               echo $nombre." ".$apellido;
                        ?>
               
            </td>
        </tr>
        <tr>
            <th>Sección/Archivo destino:</th>
                <td>
                    <select name="trn_uni_destino" id="trn_uni_destino" class="text ui-widget-content ui-corner-all" >
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_uni_destino ?>
                    </select>
                       <span class="error-requerid">*</span>
                </td>
        </tr>
         
        <tr>
                <th>Usuario destino:</th>
                <td>
                    <select name="trn_usuario_des" id="trn_usuario_des" class="text ui-widget-content ui-corner-all" size="2" style="height: 100px">
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_usuario_des ?>
                    </select>
                       <span class="error-requerid">*</span>
                </td>
        </tr>
         
        <tr>
            <th>Direcci&oacute;n:</th>
                <td>
                <input type="text" name="direccion" id="direccion" size="40" >
                </td>
        </tr>
            <tr>
                <th>T&eacute;lefono:</th>
                <td>
                <input type="text" name="telefono" id="telefono" size="16">
                </td>
        </tr>
     </table>
       
<div id="error_dominio" style="display:none">
<img src="<?php echo $PATH_WEB ?>/img/alert.png" width="30" border="0"/>&nbsp;<b>Error:</b>&nbsp;<span id="error_sp"></span>
</div>
      
       
    
    <table width="100%" border="0">
        <tr>
            <td class="botones" colspan="4" style="padding: 20px;border-top:1px dotted #3F5A7C">
                 <input id="btnSubB" type="submit" value="Guardar" class="button"/>
                <input id="btnClear" type="submit" value="Limpiar" class="button"/>
               </td>
        </tr>
    </table>
</form>
<input type="hidden" name="archivos" id="archivos">
<input type="hidden" name="archivos2" id="archivos2">
<input type="hidden" id="d_cantidad">
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferencia/gridtransferencia/',
        dataType: 'json',
        colModel : [
            {display: 'ID' , name : 'exp_id', width : 40, sortable : true, align: 'center'},            
            {display: '', name : 'exp_chk', width : 20, sortable : true, align: 'center'},            
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 120, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 250, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_titulo', width : 450, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha Final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
//            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Actualizar', bclass: 'folder_table', onpress : test},
          
            {name: 'Cancelar', bclass: 'cancel', onpress : test},
         
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Serie', name : 'ser_categoria'},
            {display: 'Nombre', name : 'exp_titulo'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'}
            //{display: 'Custodio', name : 'custodio'}
        ],
        sortname: "exp_fecha_exf",
        sortorder: "desc",
        usepager: true,
        title: '<?php echo $titulo ?>',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 200, 
    });



    
    function test(com,grid)
    {   cantidad=document.getElementById("d_cantidad").value;    

                        if (com=='Cancelar'){

var urlhack="<?php echo $PATH_DOMAIN ?>/transferencia/eliminarsession/";
$("#recarga").load(urlhack);
$(".pReload",".flexigrid").click();
$("#sesi").val(0);
        window.location.href="<?php echo $PATH_DOMAIN."/transferencia/";?>";
      
}

        if (com=='Actualizar'){  
        
                 document.getElementById("archivos").value="";
                      
                 var t=1;var dt=0;var dt2=0; var comi="";var cadena;
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
        }else{
                  dt2=$(".fil_chk"+t).val();
         //var cadena=new array();
         


if(cadena==""){
    comi="";
}
    
        }
    t++;    
    }

      var id_archivos=document.getElementById("archivos").value;
  
      var url="<?php echo $PATH_DOMAIN."/transferencia/recarga2/";?>";
          $("#recarga").load(url,{valor:id_archivos});
            $("#archivos").val("");
               $(".pReload",".flexigrid").click();
               
   var urlsesi="<?php echo $PATH_DOMAIN ?>/transferencia/ajaxsession2/";
       $("#recarga3").load(urlsesi);             
           $("#exp_reprobado").val(""); 
              // $("#sesi").val(id_archivos);
}else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
        
        
    }
     
</script>



<script>
    
    $(function() {
         $("#trn_uni_destino").change(function(){
          
             $.ajax({
                 type: "POST",
                 url: "<?php echo $PATH_DOMAIN ?>/transferencia/listUsuarioJson/",
                 data: "uni_id="+$(this).val(),
                 dataType: 'json',
                 success: function(msg){
                     $("#trn_usuario_des").html('');
                     $("#trn_usuario_des").append("<option value=''>(seleccionar)</option>");
                     $.each(msg, function(i,item){
                         $("#trn_usuario_des").append("<option value='"+item.usu_id+"'>"+item.usu_nombres+" "+item.usu_apellidos+"</option>");
                     });
                 },
                 error: function(msg){
                 }
             });
         });

         $("#trn_usuario_des").change(function(){
if($(this).val()!=""){
    $("#error_dominio").fadeOut("fast");
 $("#exp_reprobado").val(""); 
             $.ajax({
                 type: "POST",
                 url: "<?php echo $PATH_DOMAIN ?>/transferencia/verifSerie/",
                 data: "usu_id="+$(this).val()+"&Ids="+$('#idsExp').val(),
                 dataType: 'text',
                 success: function(msg){
                     if(msg==''){
                         //alert("Es correcto tiene autorizado para el expediente");
                     
        } else{
                        $("#exp_reprobado").val(msg); 
            $("#error_dominio").fadeIn("fast");
            $("#error_sp").html("El usuario destino no maneja la serie de este expediente: " + msg + "\nConsulte con el Administrador del Sistema");         
            //alert("El usuario destino no maneja la serie de este expediente: " + msg + "\nConsulte con el Administrador del Sistema");
                     
                   
                        }
                 }
             });
             }
         });

         var allFields = $([]).add(name),
         tips = $("#validateTips");
         function updateTips(t) {
             tips.text(t).effect("highlight",{},1500);
         }

         function tieneValor(o) {
             if ( o.val().length <= 0 ) {
                 o.addClass('ui-state-error');
                 updateTips("Todos los campos son obligatorios.");
                 return false;
             } else {
                 return true;
             }
         }

         $("#dialog-form").dialog({
             stackfix: true,
             autoOpen: false,
             height: 500,
             width: 800,
             modal: true,
             buttons: {
                 Cancelar: function() {
                     $(this).dialog('close');
                 },
                 Transferir: function() {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/transferencia/save/",
                        data: "idsExp="+$("#idsExp").val()+"&uni_id="+$("#uni_id").val()+"&trn_uni_destino="+$("#trn_uni_destino").val()+"&usu_id= "+ $("#usu_id").val()+"&trn_usuario_des="+$("#trn_usuario_des").val(),
                        success: function(msg){
                            $(".qsbox").val($('#idcom').val());
                            $(".qtype").val('ser_categoria');
                            $('.Search').click();
                        },
                        error: function(msg){
                            alert(msg);
                        }
                    });
                    $(this).dialog('close');
                 }
             },
             close: function() {
                 updateTips("");
                 $('#trn_uni_destino').removeClass('ui-state-error');
                 $('#trn_usuario_des').removeClass('ui-state-error');
                 $('#trn_descripcion').removeClass('ui-state-error');
             }
         });
$("#btnSubB").click(function(){
    var dato=$("#exp_reprobado").val();
    if(dato!=""){
        
        return false;
    }
    var usu=document.getElementById("trn_usuario_des").value;
    if($("#trn_uni_destino").val()==""||usu==""){
     $("#error_dominio").fadeIn("fast");
     $("#error_sp").html("Los siguientes campos son requeridos:\n ->Archivo Destino y Usuario Destino");         
     return false;
        }
 
})
     });    
     
</script>


<div id="recarga"></div>
