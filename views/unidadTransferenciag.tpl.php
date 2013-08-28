<div class="clear"></div>
<!--ul id="listNum">
    <li class="cuatroInc"><a class="linkCuatro" href="<?php echo $url_paso4 ?>" <?php echo $msg_paso4 ?>>4</a></li> 
    <li class="tresAct">3</li>
    <li class="dosInc"><a class="linkDos" href="<?php echo $url_paso2 ?>" >2</a></li>
    <li class="unoInc"><a class="linkUno" href="<?php echo $url_paso1 ?>" >1</a></li>  
</ul>
<div class="clear"></div-->
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/<?php echo $PATH_EVENT ?>/">
    <input name="uni_id" id="uni_id" type="hidden" value="" />
</form>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/unidadTransferencia/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'uni_id', width : 40, sortable : true, align: 'center'},
            {display: 'Nivel', name : 'niv_abrev', width : 80, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Descripcion', name : 'uni_descripcion', width : 220, sortable : true, align: 'left'},
            {display: 'Unid. que maneja', name : 'tem_uni_recibidas_cod', width : 200, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Transf. Personas', bclass: 'edit', onpress : test},{separator: true},
            {name: 'Transf. Unidades', bclass: 'edit', onpress : test},{separator: true},
            {name: 'Finalizar', bclass: 'process', onpress : test}<?php echo $PATH_B ?>
        ],
        searchitems : [
            {display: 'Id', name : 'uni_id'},
            {display: 'Nivel', name : 'niv_abrev', isdefault: true},
            {display: 'Unidad', name : 'uni_codigo'},
            {display: 'Descripcion', name : 'uni_descripcion'},
            {display: 'Unid. que maneja', name : 'tem_uni_recibidas_cod'}
        ],
        sortname: "uni_id",
        sortorder: "asc",
        usepager: true,
        title: 'Transferencias',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });
    function test(com,grid)
    {
        if (com=='Transf. Unidades'){
            if($('.trSelected div',grid).html()){
                $("#uni_id").val($('.trSelected div',grid).html());
                document.location.href = "<?php echo "$PATH_DOMAIN/$VAR1" ?>/viewU/"+$('#uni_id').val()+"/";
                //document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Transf. Personas'){
            if($('.trSelected div',grid).html()){
                $("#uni_id").val($('.trSelected div',grid).html());
                document.location.href = "<?php echo "$PATH_DOMAIN/$VAR1" ?>/viewP/"+$('#uni_id').val()+"/";
                //document.getElementById('formA').submit();
            }
            else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Finalizar'){
            $.ajax({
                url: '<?php echo $PATH_DOMAIN ?>/unidadTransferencia/verifTransf/',
                type: 'POST',
                data: 'uni_id='+$('.trSelected div',grid).html(),
                dataType:  		"json",
                success: function(datos){
                    var j=0;
                    if(datos){
                        alerta="Las siguientes personas todavia no fueron reasignadas de unidad:<br />";
                        jQuery.each(datos, function(i,item){
                            j++;
                            alerta=alerta + "<li>"+item.uni_codigo+" - "+ item.usu_apellidos + " "+ item.usu_nombres+"</li>";
                        });
                    }
                    if(j==0){ // finaliza todo reenviando a otra pagina y muestra mensaje de fin vacio con link volver!!

                        $('#alert').html('Se esta transfiriendo los datos, por favor espere.');
                        $('#dialog-form').dialog('open');
                        $.post("<?php echo $PATH_DOMAIN ?>/versionado/finalizar/",{} ,function(data){
                            if(!data){
                                $('#dialog-form').dialog('close');
                                window.location.href = "<?php echo $PATH_DOMAIN ?>/login/logout/";
                            }
                        });
                    }
                    else{
                        $("#faltantes").html(alerta);
                        $('#dialogFaltantes').dialog('open');
                    }
                }
            });
        }
        else{
            $(".qsbox").val(com);
            $(".qtype").val('niv_abrev');
            $('.Search').click();
        }
    }
    $(function() {
        $("#dialogFaltantes").dialog({
            stackfix: true,
            autoOpen: false,
            height: 255,
            width: 400,
            modal: true,
            buttons: {
                Aceptar: function() {
                    $(this).dialog('close');
                }
            },
            close: function() {
            }
        });
        $("#dialog-form").dialog({
            autoOpen: false,
            height: 150,
            width: 200,
            modal: true
        });
    });
</script>
<div id="dialogFaltantes" title="No se puede finalizar el proceso de Transferencias">
    <table><tr><td><span id="faltantes"></span></td></tr></table>

</div>

<div id="dialog-form" title="Finalizando Transferencia de Personal-Unidades">
    <span id="alert"></span>
</div>