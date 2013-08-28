<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/ubicacion/<?php echo $PATH_EVENT ?>/">

    <input name="ubi_id" id="ubi_id" type="hidden" value="<?php echo $ubi_id; ?>" />
    <input name="ubi_par" id="ubi_par" type="hidden" value="<?php echo $ubi_par; ?>" />
    <input name="path_event" id="path_event" type="hidden"
           value="<?php echo $PATH_EVENT; ?>" />
    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo_ubi; ?></caption>

        <tr>
            <td>Departamento:</td>
            <td colspan=3 >
                <select name="dep_id" id="dep_id" title="Seleccione un departamento" class="required">
                    <option value="">(Seleccionar)</option>
                    <?php echo $dep_id; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Provincia:</td>
            <td colspan=3 >
                <select name="pro_id" id="pro_id" title="Seleccione una provincia" class="required">
                    <option value="">(Seleccionar)</option>
                    <?php echo $pro_id; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Ciudad:</td>
            <td colspan=3 >
                <select name="loc_id" id="loc_id" title="Seleccione una ciudad" class="required">
                    <option value="">(Seleccionar)</option>
                    <?php echo $loc_id; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>C&oacute;digo Edificio:</td>
            <td colspan=3 >
                <!-- MODIFIED: CASTELLON maxlength="8" -->
                <input autocomplete="off"
                       class="required alphanum" 
                       id="ubi_codigo" 
                       maxlength="8"
                       name="ubi_codigo"
                       size="10"   
                       type="text" 
                       title="C&oacute;digo" 
                       value="<?php echo $ubi_codigo; ?>"
                       />
                <!-- -->
            </td>
        </tr>
        <tr>
            <td width="130">Descripci&oacute;n:</td>
            <td colspan="2"><input autocomplete="off"  
                                   class="required alphanum"
                                   id="ubi_descripcion" 
                                   maxlength="50"
                                   name="ubi_descripcion"
                                   onkeyup="this.value=this.value.toUpperCase()" 
                                   type="text"
                                   title="Descripci&oacute;n"
                                   size="50" 
                                   value="<?php echo $ubi_descripcion; ?>"
                                   /></td>
        </tr>
        <tr>
            <td>Direcci&oacute;n:</td>
            <td colspan="2"><input autocomplete="off"
                                   class="alphanum" 
                                   id="ubi_direccion"
                                   name="ubi_direccion"
                                   maxlength="200"
                                   size="120"
                                   title="Direcci&oacute;n"
                                   type="text"
                                   value="<?php echo $ubi_direccion; ?>"
                                   /></td>
        </tr>
        <tr>
            <td colspan="3" class="botones">
                <input id="btnSub" type="submit" value="Guardar" class="button"/>
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/ubicacion/";
            //window.history.back(-1);
        });

    });			



    $(function() {
        $("#dep_id").change(function(){
            // alert("hola");
            var optionPro = $("#pro_id");
            var optionLoc = $("#loc_id");
            var dep_id = $("#dep_id").val();
            optionPro.find("option").remove();
            optionLoc.find("option").remove();
            
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/departamento/obtenerPro/',
                type: 'POST',
                data: 'Dep_id='+dep_id,
                dataType:  'text',
                success: function(datos){
                    optionPro.append(datos);    
                }
            });
 
        });

        $("#pro_id").change(function(){
            // alert("hola");
            var optionLoc = $("#loc_id");
            var pro_id = $("#pro_id").val();
            optionLoc.find("option").remove();
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/provincia/obtenerLoc/',
                type: 'POST',
                data: 'Pro_id='+pro_id,
                dataType:  'text',
                success: function(datos){
                    optionLoc.append(datos);    
                }
            });
 
        });
       

                
        $('#ubi_codigo').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/ubicacion/verifCodigo/',
                    type: 'POST',
                    data: 'Ubi_codigo='+$(this).val()+ '&Ubi_id='+$('#ubi_id').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#ubi_codigo').val('');
                            $('#ubi_codigo').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
         
//        
//        $("#btnSub").click(function(){
//            if($("#dep_id").val()=="" || $("#dep_id").val()==0){
//                //}else if($("#cli_nit").val()==""){
//                //            jAlert("Ingrese un NIT o C.I.",'');
//                //            $("#cli_nit").focus();
//                //       }            
//                //else if($("#cli_nombre").val()==""){
//                //            jAlert("Ingrese una Razon Social",'');
//                //            $("#cli_nombre").focus();
//            }    
//            else
//            {            
//                //var flag = false;
//                // Validate Form
//                $.ajax({
//                    url: '<?php echo $PATH_DOMAIN ?>/departamento/verifyFields/',
//                    type: 'POST',
//                    data: 'dep_codigo='+$('#dep_codigo').val()+ '&Path_event='+$('#path_event').val(),
//                    dataType:          "text",
//                    success: function(datos)
//                    {
//                        if(datos!='')
//                        {
//                            $('#dep_codigo').val('');
//                            $('#dep_codigo').focus();
//                            alert(datos);
//                        }
//                        else
//                        {
//                            //if (flag==false){
//                            $('form#formA').submit();
//                            //$('form#formA')[0].reset();
//                            //}
//                        }
//                    }
//                });       
//            }
//        });

    });
</script>