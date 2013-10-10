<div class="demo">

    <div id="dialog" title="Necesita password para poder ver el archivo">
        <p id="validateTips"></p>
        <form id="formAA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/" >

            <label for="pass">Password:</label>
            <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
            <input type="hidden" value="" name="fil_id" id="fil_id"  />
            <input type="password" value="" id="pass" name="pass" class="text ui-widget-content ui-corner-all" />
            <input id="btnSub" type="submit" value="" style="visibility:hidden" />

        </form>
    </div>
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

            /*   $("#menuarch li").mouseover(function(){
            var d = $(this).attr('di2');
            $("."+d+"a").slideDown();
        });
        $("#menuarch li").mouseout(function(){
            var d = $(this).attr('di2');
            $("."+d+"a").hide();
        });
        $(".lisuboptAct").mouseover(function(){
            $("#"+$(this).attr('id2')+"x").slideDown();
        });
        $(".lisuboptAct").mouseout(function(){
            $("#"+$(this).attr('id2')+"x").hide();
        });*/
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

            $('.viewFile').click(function(){
                url="<?php echo $PATH_DOMAIN ?>/archivo/download/"+$(this).attr('file')+"/";
                abrir(url);
            });

            $('.addFile').click(function(){
                window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/index/"+$('#exp_id').val()+"/"+$(this).attr('tra')+"/"+$(this).attr('cue')+"/";
            });
            /*		$('.deleteFile').click(function(){
                    window.location.href="<?php echo $PATH_DOMAIN ?>/archivo/delete/"+$('#exp_id').val()+"/"+$(this).attr('file')+"/";
            });*/

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
                        bValid = bValid && checkRegexp($("#pass"),/^([0-9a-zA-Z])+$/,"Introduzca solo letras y números : a-z 0-9");
                        if (bValid) {
                            $(this).dialog('close');
                            //						$("#formAA").submit();
                            $.ajax({
                                type: "POST",
                                url: "<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/",
                                data: "exp_id="+$("#exp_id").val()+"&fil_id="+$("#fil_id").val()+"&pass="+$("#pass").val(),
                                success: function(msg){
                                    if(msg=='ok'){
                                        $('#fil_id_open').val($("#fil_id").val());
                                        $('#pass_open').val($("#pass").val());
                                        $('#formArchivo').submit();
                                    }else{
                                        alert(msg);
                                    }
                                }
                            });
                        }
                    },
                    Cancelar: function() {
                        updateTips("");
                        allFields.val('').removeClass('ui-state-error');
                        $(this).dialog('close');
                    }
                },
                Cerrar: function() {
                    updateTips("");
                    allFields.val('').removeClass('ui-state-error');
                }
            });

            $('.submenuarch a.linkPass').click(function() {
                $("#fil_id").val($(this).attr("valueId"));
                $('#pass').val("");
                $('#dialog').dialog('open');
            });
        });
    </script>