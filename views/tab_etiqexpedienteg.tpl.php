<div class="titulo">ETIQUETADO DE EXPEDIENTES</div>
<p><table id="flex1" style="display:none"></table></p>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formImprimir" name="formImprimir" method="post" target="_blank" 
      action="<?php echo $PATH_DOMAIN ?>/etiqexpediente/<?php echo $PATH_EVENT ?>/">
    <input name="ete_id" id="ete_id" type="hidden" value="<?php echo $ete_id; ?>" />
    <input name="exp_id" id="exp_id" type="text" value="<?php echo $exp_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="exp_ids" id="exp_ids" type="hidden" value="" />
    <input name="tipo" id="tipo" type="hidden" value="" />
    <input name="nro_inicial" id="nro_inicial" type="text" value="" />
    <input name="nro_final" id="nro_final" type="text" value="0" />
</form>

<script type="text/javascript">
    var dataj;
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/etiqexpediente/loadExp/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Series', name : 'ser_categoria', width : 150, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'exp_codigo', width : 120, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_titulo', width : 350, sortable : true, align: 'left'},
            {display: 'Fecha inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'},
            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Agregar', bclass: 'add', onpress : test} 
            <?php echo ($PATH_A != '' ? ',' . $PATH_A : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'Codigo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_titulo'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
            {display: 'Fecha Final', name : 'exf_fecha_exf'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: '<?php echo $tituloA ?>',
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
        url: '<?php echo $PATH_DOMAIN ?>/etiqexpediente/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 150, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'exp_codigo', width : 120, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_titulo', width : 350, sortable : true, align: 'left'},
            {display: 'Fecha inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'},
            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Borrar', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Borrar Todo', bclass: 'delete', onpress : test},{separator: true},
            {name: 'Marbetes', bclass: 'print', onpress : test},{separator: true},
            {name: 'Archivos', bclass: 'print', onpress : test},{separator: true},
            {name: 'Caratulas', bclass: 'print', onpress : test},{separator: true},            
            {name: 'Cajas', bclass: 'print', onpress : test}<?php echo ($PATH_B != '' ? ',' . $PATH_B : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'Codigo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_titulo'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        //mulSelec: true,
        usepager: true,
        title: '<?php echo $tituloB ?>',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 150,
        autoload: false
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#exp_id").val($('.trSelected div',grid).html());
            if($("table",grid).attr('id')=="flex1"){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/save/",
                    data: "exp_id="+$("#exp_id").val(),
                    dataType: 'text',
                    success: function(data){
                        if(data=='OK'){
                            $("#exp_ids").val($("#exp_ids").val()+$("#exp_id").val()+",");
                            $(".qsbox").val($('#idcom').val());
                            $(".qtype").val('ser_categoria');
                            $('.Search').click();
                        }
                    }
                });
            }
        }
    }
    
    function test(com,grid)
    {
        if(com=='Agregar'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/save/",
                    data: "exp_id="+$("#exp_id").val(),
                    dataType: 'text',
                    success: function(data){
                        if(data=='OK'){
                            $("#exp_ids").val($("#exp_ids").val()+$("#exp_id").val()+",");
                            $(".qsbox").val($('#idcom').val());
                            $(".qtype").val('ser_categoria');
                            $('.Search').click();
                        }
                    }
                });
            }else{
                alert("Seleccione un registro");
            }
        }else if (com=='Borrar'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/delete/",
                    data: "exp_id="+$("#exp_id").val(),
                    dataType: 'text',
                    success: function(data){
                        if(data=='OK'){
                            $(".qsbox").val($('#idcom').val());
                            $(".qtype").val('ser_categoria');
                            $('.Search').click();
                        }
                    }
                });
            }else{
                alert("Seleccione un registro");
            }            
        }else if (com=='Borrar Todo'){
            if($('.trSelected div',grid).html()){        
                if(confirm("Esta seguro de borrar los expedientes de la pre-impresion?")){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/deleteAll/",
                        dataType: 'text',
                        success: function(data){
                            if(data=='OK'){
                                $(".qsbox").val($('#idcom').val());
                                $(".qtype").val('ser_categoria');
                                $('.Search').click();
                            }
                        }
                    });
                }
            }else{
                alert("Seleccione un registro");
            }             
        }else if (com=='Marbetes'){
            if($('.trSelected div',grid).html()){ 
                $('#tipo').val('MARBETES');
                $("#exp_id").val($('.trSelected div',grid).html());
                $.ajax({                    
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/getNroInicial/",
                    type: "POST",
                    data: 'Tipo='+$('#tipo').val()+ '&Exp_id='+$('#exp_id').val(),
                    dataType: "json",
                    success: function(datos){
                        if(datos!=''){
                            jQuery.each(datos, function(i,item){
                                $('#nro_ini0').val(datos.nro_inicial);
                                $('#nro_fin0').val(datos.nro_final);                                					    	   
                            });                            
                        }
                        $('#dialogMarbetesNro').dialog('open');
                    }
                });
            }else{
                alert("Seleccione un registro");
            }            
        }else if (com=='Cajas'){
        
            if($('.trSelected div',grid).html()){ 
                $('#tipo').val('cajas');
                $("#exp_id").val($('.trSelected div',grid).html());
                
                $.ajax({                    
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/getNroInicial/",
                    type: "POST",
                    data: 'tipo=CAJA&Exp_id='+$('#exp_id').val(),
                    dataType: "json",
                    success: function(datos){
                        if(datos!=''){
                            jQuery.each(datos, function(i,item){
                                $('#nro_ini').val(datos.nro_inicial);
                                $('#nro_fin').val(datos.nro_final);                                					    	   
                            });                            
                        }
                        $('#dialogNro').dialog('open');
                    }
                });
            }else{
                alert("Seleccione un registro");
            }  
        }else if (com=='Caratulas'){
            if($('.trSelected div',grid).html()){ 
                $('#tipo').val('caratulas');
                //$('#formImprimir').submit();                
                window.location.href="<?php echo $PATH_DOMAIN ?>/etiqexpediente/viewCaratulas2/"+$('.trSelected div',grid).html()+"/";
            }else{
                alert("Seleccione un registro");
            }            
        }else if (com=='Archivos'){
            if($('.trSelected div',grid).html()){        
                $('#tipo').val('folders');
                $("#exp_id").val($('.trSelected div',grid).html());
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/getNroInicial/",
                    data: "tipo=FOLDER",
                    dataType: 'text',
                    success: function(data){
                        if(data!=''){
                            $('#nro_ini2').val('');
                            $('#dialogNro2').dialog('open');
                        }
                    },
                    error: function(msg){
                        $('#nro_ini2').val('');
                        $('#formImprimir').submit();
                    }
                });
            }else{
                alert("Seleccione un registro");
            }            
        }else{
            $('#idcom').val(com);
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
    
    function test2(com,grid){
        $('#idcom').val(com);
        $(".qsbox").val(com);
        $(".qtype").val('ser_categoria');
        $('.Search').click();
    }    
</script>


<div id="dialogMarbetesNro" title="N&uacute;mero correlativo etiquetado de documentos: MARBETES" align="left">
    <form name="formNro" id="formNro">
        <span id="alert">N&uacute;mero inicial de etiquetado: </span>
        <input name="nro_ini0" id="nro_ini0" type="text" value="" size="5" maxlength="11" class="required" />
        <br /><span>N&uacute;mero final de etiquetado: </span>
        <input name="nro_fin0" id="nro_fin0" type="text" value="" size="5" maxlength="5" />
    </form>
</div>

<div id="dialogNro" title="N&uacute;mero correlativo etiquetado: CAJAS" align="left">
    <form name="formNro" id="formNro">
        <span id="alert">N&uacute;mero inicial de etiquetado: </span>
        <input name="nro_ini" id="nro_ini" type="text" value="" size="5" maxlength="11" class="required" />
        <br /><span>N&uacute;mero final de etiquetado: </span>
        <input name="nro_fin" id="nro_fin" type="text" value="" size="5" maxlength="5" />
    </form>
</div>

<div id="dialogNro2" title="N&uacute;mero correlativo de etiquetado" align="left">
    <span id="alert2">Introduzca el N&uacute;mero correlativo de etiquetado: </span>
    <input name="nro_ini2" id="nro_ini2" type="text" value="" size="5" maxlength="11" class="required"  />
</div>

<script>
    $(function() {
        
        $("#dialogMarbetesNro").dialog({
            stackfix: true,
            autoOpen: false,
            height: 200,
            width: 300,
            modal: true,
            buttons: {
                Aceptar: function() {
                    if($('#nro_ini0').val()){
                        $('#nro_inicial').val($('#nro_ini0').val());                        
                        if($('#nro_fin0').val()){
                            $('#nro_final').val($('#nro_fin0').val());
                            if($('#nro_fin0').val()<$('#nro_ini0').val()){
                                alert("El número final no puede ser menor que el inicial");
                            }else{
                                $('#formImprimir').submit();
                                $(this).dialog('close');
                            }
                        }else{
                          $('#formImprimir').submit();
                          $(this).dialog('close');
                        }
                    
                     }else{
                        alert("Ingrese el numero correlativo...");
                    }
                }
            },
            close: function() {
            }
        });        
        
        $("#dialogNro").dialog({
            stackfix: true,
            autoOpen: false,
            height: 200,
            width: 300,
            modal: true,
            buttons: {
                Aceptar: function() {
                    if($('#nro_ini').val()){
                        $('#nro_inicial').val($('#nro_ini').val());                    
                        if($('#nro_fin').val()){
                            $('#nro_final').val($('#nro_fin').val());
                            if($('#nro_fin').val()<$('#nro_ini').val()){
                                alert("El número final no puede ser menor que el inicial");
                            }else{
                                $('#formImprimir').submit();
                                $(this).dialog('close');
                            }
                        }else{
                          $('#formImprimir').submit();
                          $(this).dialog('close');
                        }                    
                     }else{
                        alert("Ingrese el numero correlativo...");
                    }
                }
            },
            close: function() {
            }
        });
        
        $("#dialogNro2").dialog({
            stackfix: true,
            autoOpen: false,
            height: 200,
            width: 300,
            modal: true,
            buttons: {
                Aceptar: function() {
                    if($('#nro_ini2').val()){
                    $('#nro_inicial').val($('#nro_ini2').val());
                    $('#formImprimir').submit();
                    $(this).dialog('close');
                    }else{
                        alert("Ingrese el numero correlativo...");
                    }
                    
                }
            },
            close: function() {
            }
        });
    });
</script>
