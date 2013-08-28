<div id="dialog" title="Necesita password para poder ver el archivo">
    <p id="validateTips"></p>
    <form id="formAA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/download/" target="_blank">

        <label for="pass">Password:</label>
        <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
        <input type="hidden" value="" name="fil_id" id="fil_id"  />
        <input type="password" value="" id="pass" name="pass" class="text ui-widget-content ui-corner-all" />
        <input id="btnSub" type="submit" value="" style="visibility:hidden" />

    </form>
</div>
<strong style="color: red" align="left"><?php echo $msm ?></strong>
<form id="formA" name="formExpcontenedor" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/" target="_blank">
    <ul id="menuarch">
        <?php echo $tree ?>
    </ul>
</form>
<a href="#" id="verArchivo" target="_blank" ></a>
<form id="formArchivo" name="formArchivo" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/download/" target="_blank">
    <input type="hidden" value="" name="fil_id_open" id="fil_id_open"  />
    <input type="hidden" value="" id="pass_open" name="pass_open" />
</form>
<script type="text/javascript">

    $(function() {
            
        var name = $("#pass"),
        allFields = $([]).add(name),
        tips = $("#validateTips");

        function updateTips(t) {
            tips.text(t).effect("highlight",{},1500);
        }

        function checkLength(o,n,min,max) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass('ui-state-error');
                updateTips("Tamano de "+n+" debe estar entre "+min+" y "+max+".");
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp(o,regexp,n) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass('ui-state-error');
                updateTips(n);
                return false;
            } else {
                return true;
            }
        }
		
        $('.viewFicha').click(function(){
            if(confirm("Mostrar ficha del documento?")){
                window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/viewFicha/"+$('#exp_id').val()+"/"+$(this).attr('tra')+"/"+$(this).attr('cue')+"/";
            }
        });
        
        $('.viewFile').click(function(){
            url="<?php echo $PATH_DOMAIN ?>/archivo/download/"+$(this).attr('file')+"/";
            abrir(url);
        });
        
        $('.viewFileP').click(function(){
            $("#fil_id").val($(this).attr("valueId"));
            $('#pass').val("");
            $('#dialog').dialog('open');
        });
		
        $('.updateFile').click(function(){
            window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/update/"+$('#exp_id').val()+"/"+$(this).attr('file')+"/estrucDocumental/";
            
        });
        $('.addFile').click(function(){
            window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/index/"+$('#exp_id').val()+"/"+$(this).attr('tra')+"/"+$(this).attr('cue')+"/";                
        });
        
        
        $('.deleteFile').click(function(){
            if(confirm("Est\u00e1 seguro de eliminar este archivo?")){
                window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/delete/"+$('#exp_id').val()+"/"+$(this).attr('file')+"/estrucDocumental/";
            }
        });

        $('.printFile').click(function(){
            url="<?php echo $PATH_DOMAIN ?>/archivo/viewFicha/"+$('#exp_id').val()+"/"+$(this).attr('file')+"/estrucDocumental/";
            abrir(url);
        });
        
        $('.view').click(function(){
            url="<?php echo $PATH_DOMAIN ?>/archivo/printFicha/"+$('#exp_id').val()+"/"+$(this).attr('file')+"/estrucDocumental/";
            abrir(url);
        });       

        $("#dialog").dialog({
            bgiframe: true,
            autoOpen: false,
            height: 150,
            width: 350,
            modal: true,
            buttons: {
                Aceptar: function() {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');
                    bValid = bValid && checkLength($("#pass"),"Password",3,50);
                    bValid = bValid && checkRegexp($("#pass"),/^([0-9a-zA-Z])+$/,"Introduzca solo letras y numeros : a-z 0-9");
                    if (bValid) {
                        //						$("#formAA").submit();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT_VERIF_PASS ?>/",
                            data: "exp_id="+$("#exp_id").val()+"&fil_id="+$("#fil_id").val()+"&pass="+$("#pass").val(),
                            success: function(msg){
                                if(msg=='ok'){
                                    /*$('#fil_id_open').val($("#fil_id").val());
                                                                                $('#pass_open').val($("#pass").val());*/
                                    $('#formAA').submit();
                                }else{
                                    alert(msg);
                                }
                            }
                        });
                        $(this).dialog('close');
                    }
                },
                Cancelar: function() {
                    $(this).dialog('close');
                }
            },
            close: function() {
                updateTips("");
                allFields.val('').removeClass('ui-state-error');
                $("#fil_id").val("");
                $('#pass').val("");
            }
        });

    });


</script>
