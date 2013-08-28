<div class="clear"></div>
<div class="titulo">Transferencias</div>

<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/transferencia/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="str_id" type="hidden" value="<?php echo $str_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="ids" id="ids" type="hidden" value="" />
</form>

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
            {name: 'Transferir', bclass: 'transfer', onpress : test}<?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
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
        height: 150,
        autoload: false
    });

    $("#flex2").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/transferencia/loadTransf/',
        dataType: 'json',
        colModel : [
            {display: 'ID' , name : 'str_id', width : 40, sortable : true, align: 'center'},            
            {display: 'Fecha', name : 'str_fecha', width : 60, sortable : true, align: 'left'},
            {display: 'Sección Origen', name : 'uni_descripcion', width : 160, sortable : true, align: 'left'},
            {display: 'Usuario Origen', name : 'usu_nombres', width : 120, sortable : true, align: 'left'},
            {display: 'Sección Destino', name : 'unid_descripcion', width : 180, sortable : true, align: 'left'},
            {display: 'Usuario Destino', name : 'usud_nombres', width : 120, sortable : true, align: 'left'},
            {display: 'Nro. Cajas', name : 'str_nrocajas', width : 50, sortable : true, align: 'right'},
            {display: 'Total Pzas.', name : 'str_totpzas', width : 50, sortable : true, align: 'right'},
            {display: 'Total ML', name : 'str_totml', width : 40, sortable : true, align: 'right'},
            {display: 'Nro.Reg.', name : 'str_nroreg', width : 40, sortable : true, align: 'right'},
            {display: 'Fecha Inicial', name : 'str_fecini', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha Final', name : 'str_fecfin', width : 60, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Reporte', bclass: 'print', onpress : test2},{separator: true}            
        ],
        searchitems : [
            {display: 'Id', name : 'str_id', isdefault: true},
            {display: 'Fecha', name : 'str_fecha'},
            {display: 'Sección Origen', name : 'uni_descripcion'},
            {display: 'Usuario Origen', name : 'usu_nombres'},
            {display: 'Sección Destino', name : 'uni_descripcion'},
            {display: 'Usuario Destino', name : 'usu_nombres'},
            {display: 'Nro. Cajas', name : 'str_nrocajas'},
            {display: 'Total Pzas.', name : 'str_totpzas'},
            {display: 'Total ML', name : 'str_totml'},
            {display: 'Nro.Registro', name : 'str_nroreg'},
            {display: 'Fecha Inicial', name : 'str_fecini'},
            {display: 'Fecha Final', name : 'str_fecfin'},
        ],
        sortname: "str_id",
        sortorder: "asc",
        usepager: true,
        title: '<?php echo $titulo2 ?>',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 150
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
    {
        if(com=="Transferir"){            
            // Transferir
            var k=$('.exp_chk',grid).length;
            var ids = "";
            if(k > 0){
                $('.exp_chk',grid).each(function(){
                    if($(this).is(':checked')){
                        ids = ids + $(this).val() + ",";                        
                    }
                    $("#ids").val(ids);
                });			
                if($("#ids").val().length>0){
                    var ids = $("#ids").val();
                    $(".lstrch").html("");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/expediente/find/",
                        data: "Ids="+$('#ids').val(),
                        dataType: 'json',
                        success: function(msg){
                            $.each(msg, function(i, item){
                                $("#uni_id").val(item.uni_id);
                                $(".uni_descripcion").html(item.uni_descripcion);
                                $("#usu_id").val(item.usu_id);
                                $(".usu_nombres").html(item.usu_nombres+" "+item.usu_apellidos);
                                $("#idsExp").val($("#ids").val());
                                $("#trn_uni_origen").val(item.uni_id);                                
                                $(".exp_codigo").html(item.fon_cod + " " + item.exp_codigo);                                
                                // List
                                $(".lstrch").append(item.fon_cod+"<?php echo DELIMITER ?> "+ item.uni_cod +"<?php echo DELIMITER ?> "+ item.ser_codigo +"<?php echo DELIMITER ?> "+ item.exp_codigo + "" +":  "+item.exp_titulo+"<br>");
                            });
                        },                   
                        error: function(msg){
                            alert(msg);
                        }
                    });                    
                    $('#dialog-form').dialog('open');
                }else{alert("Seleccione un registro", '');} 
            }else{
                alert("No exite registros", '');
            }
                   
        } else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
    
    function test2(com,grid)
    {
        if (com=='Reporte')
        {
            if($('.trSelected',grid).html())
            {	
                $("#str_id").val($('.trSelected div',grid).html());
                id = $("#str_id").val();
                window.location="<?php echo $PATH_DOMAIN ?>/transferencia/verRpte/"+id+"/";
            }
            else alert("Seleccione un registro");            
        }else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
    
     
</script>



<div id="dialog-form" title="Transferir Expedientes">
    <p id="validateTips"></p>
    <form>
        <input name="uni_id" id="uni_id" type="hidden" value="" />
        <input name="usu_id" id="usu_id" type="hidden" value="" />        
        <input name="idsExp" id="idsExp" type="hidden" value="" />        
        
        <input name="ser_id" id="ser_id" type="hidden" value="" />
        <input name="exp_id" id="exp_id" type="hidden" value="" />

        <table width="665" border="0">

            
            <tr>
                <th>Sección origen:</th>
                <td><span class="uni_descripcion"></span></td>
                <th>Sección/Archivo destino:</th>
                <td>
                    <select name="trn_uni_destino" id="trn_uni_destino" class="text ui-widget-content ui-corner-all">
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_uni_destino ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>Usuario origen:</th>
                <td><span class="usu_nombres"></span></td>
                <th>Usuario destino:</th>
                <td>
                    <select name="trn_usuario_des" id="trn_usuario_des" class="text ui-widget-content ui-corner-all">
                        <option value="">(seleccionar)</option>
                        <?php echo $trn_usuario_des ?>
                    </select>
                </td>
            </tr>
            

            <br>
            <tr>
                <th>Expedientes a Transferir:</th>
                <td colspan="3"><span class="lstrch"></span></td>
            </tr>
            
        </table>
    </form>
</div>


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