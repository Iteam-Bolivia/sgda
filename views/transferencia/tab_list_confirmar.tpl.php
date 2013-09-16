<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/cotransferencia/" border="0"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>


<p><table id="flex1" style="display:none"></table></p>



<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferencia/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="str_id" type="hidden" value="<?php echo $str_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="ids" id="ids" type="hidden" value="" />
</form>
<input type="hidden" id="exp_reprobado">

<input type="hidden" name="archivos" id="archivos">
<input type="hidden" name="archivos2" id="archivos2">
<input type="hidden" id="d_cantidad">
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cotransferencia/gridtransferencia/',
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
