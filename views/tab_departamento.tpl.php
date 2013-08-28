<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/departamento/<?php echo $PATH_EVENT ?>/"><input
        name="dep_id" type="hidden" id="dep_id" value="<?php echo $dep_id; ?>" />
        <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td><input class="required onlynumeric"
                       id="dep_codigo"
                       maxlength="64"
                       name="dep_codigo" 
                       size="60" 
                       title="código"
                       type="text" 
                       value="<?php echo $dep_codigo; ?>"                       
                        />
            </td>
        </tr>
        <tr>
            <td>Nombre Departamento:</td>
            <td><input class="required alphanum" 
                       id="dep_nombre" 
                       maxlength="126"
                       name="dep_nombre"
                       size="60"
                       onkeyup="this.value=this.value.toUpperCase()"
                       type="text"
                       title="nombre"
                       value="<?php echo $dep_nombre; ?>"
                        
                       
                       
                        />
            </td>
        </tr>
        <tr>
            <td colspan="2" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button" /> 
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />

        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/departamento/";
        });
//        $('#dep_codigo').change(function(){
//            if($(this).val()!=''){
//                $.ajax({
//                    url: '<?php echo $PATH_DOMAIN ?>/departamento/verifCodigo/',
//                    type: 'POST',
//                    data: 'dep_codigo='+$('#dep_codigo').val()+ '&Path_event='+$('#path_event').val(),
//                    dataType:  		"text",
//                    success: function(datos){
//                        if(datos!=''){
//                            $('#dep_codigo').val('');
//                            $('#dep_codigo').focus();
//                            alert(datos);
//                        }
//                    }
//                });
//            }
//        }); 
        
        $('#dep_codigo').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/departamento/verifCodigo/',
                    type: 'POST',
                    data: 'Dep_codigo='+$(this).val()+ '&Dep_id='+$('#dep_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#dep_codigo').val('');
                            $('#dep_codigo').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
        
        
//        $("#btnSub").click(function(){
//        if($("#dep_cod").val()=="" || $("#dep_cod").val()==0){
//        //}else if($("#cli_nit").val()==""){
//        //            jAlert("Ingrese un NIT o C.I.",'');
//        //            $("#cli_nit").focus();
//         //       }            
//        //else if($("#cli_nombre").val()==""){
//        //            jAlert("Ingrese una Razon Social",'');
//        //            $("#cli_nombre").focus();
//        }    
//        else
//        {            
//             //var flag = false;
//             // Validate Form
//                $.ajax({
//                  url: '<?php echo $PATH_DOMAIN ?>/departamento/verifyFields/',
//                  type: 'POST',
//                  data: 'dep_codigo='+$('#dep_codigo').val()+ '&Path_event='+$('#path_event').val(),
//                  dataType:          "text",
//                  success: function(datos)
//                  {
//                      if(datos!='')
//                      {
//                          $('#dep_codigo').val('');
//                          $('#dep_codigo').focus();
//                          alert(datos);
//                      }
//                      else
//                      {
//                        //if (flag==false){
//                        $('form#formA').submit();
//                        //$('form#formA')[0].reset();
//                        //}
//                      }
//                  }
//              });       
//        }
//    });
        //        $("#dep_codigo").blur(function(){
        //            if($("#dep_codigo").val()!=""){
        //            var exp_reg=/^[1-9]{1}$/;
        //            if(!$("#dep_codigo").val().match(exp_reg)){
        //                alert("Digite un numero del 1 al 9");
        //                $("#dep_codigo").val("");
        //                $("#dep_codigo").focus();
        //            }
        //            }
        //        });

    });

</script>