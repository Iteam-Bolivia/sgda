<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/contratos/<?php echo $PATH_EVENT ?>/">
    <input name="exp_id" id="exp_id" type="hidden"
           value="<?php echo $exp_id; ?>" />
    <input name="ctt_id" id="ctt_id" type="hidden"
           value="<?php echo $ctt_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/contratos/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ctt_id', width : 40, sortable : true, align: 'center'},
            {display: 'Expediente', name : 'exp_id', width : 50, sortable : true, align: 'left'},
            {display: 'Codigo', name : 'ctt_codigo', width : 30, sortable : true, align: 'left'},
            {display: 'Descripcion', name : 'ctt_descripcion', width : 350, sortable : true, align: 'left'},
            {display: 'Proveedor', name : 'ctt_proveedor', width : 100, sortable : true, align: 'left'},
            {display: 'Gestion', name : 'ctt_gestion', width : 40, sortable : true, align: 'left'},
            {display: 'CITE', name : 'ctt_cite', width : 40, sortable : true, align: 'left'},
            {display: 'Precio Base Ref. Unit.', name : 'ctt_precbasrefunit', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha', name : 'ctt_fecha', width : 60, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_id', width : 150, sortable : true, align: 'left'},
            {display: 'Tipo Solicitud', name : 'sol_id', width : 100, sortable : true, align: 'left'},
            {display: 'Modalidad', name : 'mod_id', width : 100, sortable : true, align: 'left'},
            {display: 'Fuente de Financiamiento', name : 'ff_id', width : 120, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'ctt_id', isdefault: true},
            {display: 'Expediente', name : 'exp_id'},
            {display: 'Codigo', name : 'ctt_id'},
            {display: 'Descripcion', name : 'ctt_descripcion'},
            {display: 'Proveedor', name : 'ctt_proveedor'},
            {display: 'Gestion', name : 'ctt_gestion'},
            {display: 'CITE', name : 'ctt_cite'},
            {display: 'Precio Base Ref. Unit.', name : 'ctt_precbasrefunit'},
            {display: 'Fecha', name : 'ctt_fecha'},
            {display: 'Unidad', name : 'uni_id'},
            {display: 'Tipo solicitud', name : 'sol_id'},
            {display: 'Modalidad', name : 'mod_id'},
            {display: 'Fuente de Financimiento', name : 'ff_id'}	
        ],
        sortname: "ctt_id",
        sortorder: "asc",
        usepager: true,
        title: 'CONTRATOS',
        useRp: true,
        rp: 20,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 710,
        height: 520
    });


    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#ctt_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/contratos/edit/");
            document.getElementById('formA').submit();
        }
    }

    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/contratos/delete/",{ctt_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }
                });
            }else{
                alert("Seleccione un registro");
            }
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/contratos/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ctt_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/contratos/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>