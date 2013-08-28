<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/cotransferencia2/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="str_id" type="text" value="<?php echo $str_id; ?>" />
    <input name="ids" id="ids" type="text" value="" />
</form>

<script type="text/javascript">
    
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cotransferencia2/load/',
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
            {name: 'Confirmar', bclass: 'view', onpress : test}
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
        sortname: "exp_id",
        sortorder: "desc",
        usepager: true,
        title: 'LISTA DE EXPEDIENTES A TRANSFERIR',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 320
    });
    
    
    
   function test(com,grid)
    {
        if(com=="Confirmar"){            
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
                        url: "<?php echo $PATH_DOMAIN ?>/cotransferencia2/confirmar/",
                        data: "Ids="+$('#ids').val()+"&Str_id="+$('#str_id').val(),
                        dataType: 'text',
                        success: function(datos){
                            if(datos=='Nok')
                            {
                                alert('Debe escoger todos los expedientes');
                            }
                              else
                            {
                                window.location ="<?php echo $PATH_DOMAIN ?>/cotransferencia/index/";
                                //$('form#formA').submit();
                            }
                        },                   
                        error: function(msg){
                            alert(msg);
                        }
                    });                    
                     $('#dialog-form').dialog('open');
                }else{
                    alert("Seleccione expedientes a recibir", '');
                } 
            }else{
                alert("Seleccione expedientes a recibir", '');
            }
        }else if (com=='Reporte'){
            window.location="<?php echo $PATH_DOMAIN ?>/rpteTransCustodios/";
        } else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
    
    
</script>