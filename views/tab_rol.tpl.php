<div class="clear">
</div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/rol/<?php echo $PATH_EVENT ?>/">

    <input name="rol_id" id="rol_id" type="hidden" value="<?php echo $rol_id; ?>" />
    <input name="path_event" id="path_event" type="hidden" value="<?php echo $PATH_EVENT; ?>" />

    <table width="100%" border="0">
        <caption class="titulo"><?php echo $titulo; ?></caption>

        <tr>
            <td>C&oacute;digo:</td>
            <td colspan="2">
                <input autocomplete="off"
                       class="required alphanum"
                       id="rol_cod"
                       maxlength="8"
                       name="rol_cod" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="35"
                       title="C&oacute;digo"
                       type="text"                        
                       value="<?php echo $rol_cod; ?>" />
            </td>
        </tr>

        <tr>
            <td>T&iacute;tulo:</td>
            <td colspan="2">
                <input autocomplete="off"
                       class="required alphanum"
                       id="rol_titulo"
                       maxlength="32" 
                       name="rol_titulo" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="35" 
                       type="text"                        
                       value="<?php echo $rol_titulo; ?>" 
                       title="T&iacute;tulo" />
            </td>
        </tr>

        <tr>
            <td>Descripci&oacute;n:</td>
            <td colspan="2">
                <input autocomplete="off" 
                       class="required alphanum"
                       id="rol_descripcion"
                       maxlength="96"
                       name="rol_descripcion" 
                       onkeyup="this.value=this.value.toUpperCase()"
                       size="60" 
                       title="Ddescripci&oacute;n"
                       type="text"                        
                       value="<?php echo $rol_descripcion; ?>" />
            </td>
        </tr>

        <tr>
            <td class="botones" colspan="4">
                <input id="btnSub" type="button" value="Guardar" class="button" />
                <input name="cancelar" id="cancelar" type="button" class="button" value="Cancelar" />
            </td>
        </tr>

    </table>
    <br />
    <br />
</form>

<div class="flexigrid" style="width: 100%;">
    <div class="nBtn srtd" style="left: 36px; top: 51px; display: none;">
        <div></div>
    </div>
    <div class="mDiv">
        <div class="ftitle">Lista de Men&uacute;</div>
    </div>
    <div class="hDiv">
        <div class="hDivBox">
            <table cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th align="center" abbr="exp_id" axis="col0" class="">
                        <div class="sasc" style="text-align: center; width: 40px;">Nivel</div>
                        </th>
                    <th align="left" abbr="ser_id" axis="col1" class="">
                        <div style="text-align: left; width: 375px;" class="">Menu</div>
                    </th>

                    <th align="center" abbr="exp_fecha_exi" axis="col4">
                        <div style="text-align: center; width: 50px;">Ver</div>
                    </th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="bDiv" style="">
        <table cellspacing="0" cellpadding="0" border="0" style="" id="flex1">
            <tbody>
                <?php echo $LIST_MENU; ?>
            </tbody>
        </table>

        <div class="iDiv" style="display: none;"></div>
    </div>
    
    <div class="pDiv">
        <div style="clear: both;"></div>
    </div>
    
    <div class="vGrip"><span></span></div>
    <div class="hGrip" style="height: 348px;"><span></span></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        $("#cancelar").click(function(){
            window.location="<?php echo $PATH_DOMAIN ?>/rol/";
        });
        $("#btnSub").click(function(){
            $(".flexigrid").clone().hide().appendTo("#formA");
            return false;
        });

        $("#btnSub").click(function(){
            if($("#rol_cod").val()=="" || $("#rol_cod").val()==0){
            }
            else
            {
                // Validate Form
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/rol/verifyFields/',
                    type: 'POST',
                    data: 'rol_cod='+$('#rol_cod').val() + '&Path_event='+$('#path_event').val(),
                    dataType:          "text",
                    success: function(datos)
                    {
                        if(datos!='')
                        {
                            $('#rol_cod').val('');
                            $('#rol_cod').focus();
                            alert(datos);
                        }
                        else
                        {
                            //if (flag==false){
                            $('form#formA').submit();
                            //$('form#formA')[0].reset();
                            //}
                        }
                    }
                });
            }
        });
        $(".evenw").click(function(){
            if($("."+$(this).attr('id')+"z").is(':visible')){
                $("."+$(this).attr('id')+"z").hide()
            }else{
                $("."+$(this).attr('id')+"z").show()
            }
        });
        $('#rol_cod').change(function(){
            if($(this).val()!=''){
                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/rol/verifCodigo/',
                    type: 'POST',
                    data: 'rol_cod='+$('#rol_cod').val() + '&Path_event='+$('#path_event').val(),
                    dataType:  		"text",
                    success: function(datos){
                        if(datos!=''){
                            $('#rol_cod').val('');
                            $('#rol_cod').focus();
                            alert(datos);
                        }
                    }
                });
            }
        });
    });


</script>