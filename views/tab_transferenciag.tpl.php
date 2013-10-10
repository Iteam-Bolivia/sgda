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
<div class="titulo">Transferencias</div>

<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>


<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferencia/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="str_id" type="hidden" value="<?php echo $str_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="ids" id="ids" type="hidden" value="" />
</form>
<input type="hidden" name="archivos" id="archivos">
<input type="hidden" name="archivos2" id="archivos2">
<input type="hidden" id="d_cantidad">
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferencia/loadExp/',
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
            {name: 'Guardar', bclass: 'folder_table', onpress : test},
            {name: 'Listar', bclass: 'fields', onpress : test},
            {name: 'Cancelar', bclass: 'cancel', onpress : test}
                <?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
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
        height: 250,
        autoload: false
    });


    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#exp_id").val($('.trSelected div',grid).html());
            if($("table",grid).attr('id')=="flex1"){
                $("#exp_id").val($('.trSelected div',grid).html());
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/expediente/find/",
                    data: "exp_id="+$('.trSelected div',grid).html(),
                    dataType: 'json',
                    success: function(msg){
                        $.each(msg, function(i,item){
                            $("#trn_uni_origen").val(item.uni_id);
                            $(".exp_id").html(item.exp_nombre);
                            $(".exp_codigo").html(item.exp_codigo);
                            $(".uni_origen").html(item.uni_descripcion);
                            $("#usu_id").val(item.usu_id);
                            $(".usu_nombres").html(item.usu_nombres+" "+item.usu_apellidos);
                        });
                    },
                    error: function(msg){
                        //alert(msg);
                    }
                });
                $('#dialog-form').dialog('open');
            }
            if($("table",grid).attr('id')=="flex2"){
                if($('.trSelected div',grid).html()){

                }else{

                }
            }
        }
    }
    
    function test(com,grid)
    {   cantidad=document.getElementById("d_cantidad").value;    

                        if (com=='Cancelar'){

var urlhack="<?php echo $PATH_DOMAIN ?>/transferencia/eliminarsession/";
$("#recarga").load(urlhack);
$(".pReload",".flexigrid").click();
$("#sesi").val(0);
            
}
if (com=='Listar'){
       if($("#sesi").val()==0||$("#sesi").val()==""){
          $.msgbox("Adicione un expediente a la lista");
       } else{
    window.location.href="<?php echo $PATH_DOMAIN."/transferencia/listado/";?>";
   }

}
        if (com=='Guardar'){  
        
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
         
cadena=document.getElementById("archivos2").value;

if(cadena==""){
    comi="";
}else{
   document.getElementById("archivos2").value+=",";  
}
            document.getElementById("archivos2").value+=dt2;  
    
        }
    t++;    
    }

      var id_archivos=document.getElementById("archivos").value;
      var id_archivos2=document.getElementById("archivos2").value;
  
      var url="<?php echo $PATH_DOMAIN."/transferencia/recarga/";?>";
          $("#recarga").load(url,{valor:id_archivos,valor2:id_archivos2});
            $("#archivos").val("");
              $("#archivos2").val("");
               $(".pReload",".flexigrid").click();
               
   var urlsesi="<?php echo $PATH_DOMAIN ?>/transferencia/ajaxsession/";
       $("#recarga2").load(urlsesi);             
             
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

             $.ajax({
                 type: "POST",
                 url: "<?php echo $PATH_DOMAIN ?>/transferencia/verifSerie/",
                 data: "usu_id="+$(this).val()+"&Ids="+$('#ids').val(),
                 dataType: 'text',
                 success: function(msg){
                     if(msg!='Ok'){
                         alert("El usuario destino no maneja la serie de este expediente: " + msg + "\nConsulte con el Administrador del Sistema");
                     }
                 }
             });
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

     });    
     
</script>
<div id="recarga"></div>
