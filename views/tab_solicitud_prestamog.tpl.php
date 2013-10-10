<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/<?php echo $PATH_EVENT ?>/">
    <input name="spr_id" id="spr_id" type="hidden"
           value="<?php echo $spr_id; ?>" />
</form>

<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'spr_id', width : 40, sortable : true, align: 'center'},
            {display: 'Tipo', name : 'spr_tipo', width : 50, sortable : true, align: 'left'},
            {display: 'Fecha Sol.', name : 'spr_fecha', width : 50, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Doc. SolEn', name : 'spr_docsolen', width : 100, sortable : true, align: 'left'},
            {display: 'Institución Externa', name : 'int_id', width : 100, sortable : true, align: 'left'},
            {display: 'Solicitante', name : 'spr_solicitante', width : 100, sortable : true, align: 'left'},
            {display: 'Email', name : 'spr_email', width : 100, sortable : true, align: 'left'},
            {display: 'Telefono', name : 'spr_tel', width : 50, sortable : true, align: 'left'},
            {display: 'Unidad Derivada', name : 'unid_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Fecha Inicial', name : 'spr_fecini', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha Final', name : 'spr_fecfin', width : 60, sortable : true, align: 'left'},
            {display: 'Fecha Ren', name : 'spr_fecren', width : 60, sortable : true, align: 'left'},
            {display: 'Observaciones', name : 'spr_obs', width : 100, sortable : true, align: 'left'},
            {display: 'Estado', name : 'spr_estado', width : 40, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true},
            {name: 'Derivar', bclass: 'edit', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'spr_id', isdefault: true},
            {display: 'Tipo', name : 'spr_tipo'},
            {display: 'Unidad', name : 'uni_codigo'},
            {display: 'Solicitante', name : 'spr_solicitante'},
            {display: 'Email', name : 'spr_email'},
            {display: 'Telefono', name : 'spr_tel'},
            {display: 'Unidad Derivada', name : 'unid_codigo'},
            {display: 'Fecha Inicial', name : 'spr_fecini'},
            {display: 'Fecha Final', name : 'spr_fecfin'},
            {display: 'Fecha Ren', name : 'spr_fecren'},
            {display: 'Observaciones', name : 'spr_obs'},
            {display: 'Estado', name : 'spr_estado'}	
        ],
        sortname: "spr_id",
        sortorder: "asc",
        usepager: true,
        title: 'solicitud_prestamo',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#spr_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/delete/",{spr_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
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
            window.location="<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#spr_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/solicitud_prestamo/edit/");
                document.getElementById('formA').submit();
            }	
            else{
                alert("Seleccione un registro");
            }
        }
    }
</script>