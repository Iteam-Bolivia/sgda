<div class="clear"></div>
<p><table id="flex1" style="display: none"></table></p>
<p><table id="flex2" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/estrucDocumental/<?php echo $PATH_EVENT ?>/">
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
    <input name="ser_id" id="ser_id" type="hidden" value="<?php echo $ser_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/loadSerie/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ser_id', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'ser_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 500, sortable : true, align: 'left'}
        ],
        buttons : [
            //{name: 'Adicionar Expediente', bclass: 'add', onpress : test},{separator: true},
            {name: 'Filtrar', bclass: 'ver', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'ser_id'},
            {display: 'C&oacute;digo', name : 'ser_codigo', isdefault: true},
            {display: 'Serie', name : 'ser_categoria'}
        ],
        sortname: "ser_id",
        sortorder: "asc",
        usepager: true,
        title:"LISTA DE SERIES",
        useRp: true,
        rp: 1000,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 150,
        autoload: true
    });

        
    
    $("#flex2").flexigrid
    ({  
        url: '<?php echo $PATH_DOMAIN ?>/estrucDocumental/load/<?php echo $ser_id; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            //{display: 'Serie', name : 'ser_categoria', width : 150, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'exp_codigo', width : 60, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 300, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha Final', name : 'exf_fecha_exf', width : 60, sortable : true, align: 'left'},            
            {display: 'Soporte Fisico', name : 'sof_nombre', width : 50, sortable : true, align: 'left'},
            {display: 'Nro.Ejem.', name : 'exp_nroejem', width : 50, sortable : true, align: 'left'},
            {display: 'Tomo Vol.', name : 'exp_tomovol', width : 50, sortable : true, align: 'left'},
            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Documentos', bclass: 'ver', onpress : test2}, {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria'},
            {display: 'Codigo', name : 'exp_codigo', isdefault: true},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
            {display: 'Fecha Final', name : 'exf_fecha_exf'},            
            {display: 'Soporte Fisico', name : 'sof_nombre'},
            {display: 'Nro.Ejem', name : 'exp_nroejem'},
            {display: 'Tomo Vol.', name : 'exp_tomovol'},
            {display: 'Custodio', name : 'custodios'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: 'REGISTRO DE EXPEDIENTES',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380,
        autoload: true
    });
    
    
    
    

    //    function dobleClik(grid){
    //        if($('.trSelected div',grid).html()){
    //            $("#exp_id").val($('.trSelected div',grid).html());
    //            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/searchTree/");
    //            document.getElementById('formA').submit();
    //        }	
    //    }
    
    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            if($("table",grid).attr('id')=="flex2"){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/searchTree/");
                document.getElementById('formA').submit();
            }
            if($("table",grid).attr('id')=="flex1"){
                $("#ser_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/");
                document.getElementById('formA').submit();
            }
        }
    }
    
    function test(com,grid)
    {
        if (com=='Filtrar')
        { 
            if($('.trSelected div',grid).html())
            {
                $("#ser_id").val($('.trSelected div',grid).html());
                //$('#flex2').flexReload();
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/");
                document.getElementById('formA').submit();
                
            }	else{
                alert("Seleccione un registro");
            }
        }
        else{
            $(".qsbox").val($('.trSelected div',grid).html());
            $(".qtype").val('ser_id');
            $('.Search').click();
        }

    }
    
    function test2(com,grid)
    {
        if (com=='Documentos'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/searchTree/");
                document.getElementById('formA').submit();
            }else{
                alert("Seleccione un registro");
            }	
        }
        else if (com=='Reporte')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/rptePerCustodio/";
        }
        else{
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }

</script>
