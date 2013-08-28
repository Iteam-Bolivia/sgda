<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/regularizar/<?php echo $PATH_EVENT ?>/">

    <input name="exp_id" id="exp_id" type="hidden"
           value="<?php echo $exp_id; ?>" /></form>
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/regularizar/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            /*{display: 'Serie', name : 'ser_categoria', width : 70, sortable : true, align: 'left'},*/
            {display: 'Codigo', name : 'exp_codigo', width : 95, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_nombre', width : 290, sortable : true, align: 'left'},
            {display: 'Descripci&oacute;n', name : 'exp_descripcion', width : 200, sortable : true, align: 'left'},
            {display: 'Fecha inicio', name : 'exf_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha final', name : 'exf_fecha_exf', width : 60, sortable : true, align: 'center'},
            {display: 'Custodio', name : 'custodios', width : 150, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Ver', bclass: 'ver', onpress : test}<?php echo ($PATH_B != '' ? ',' . $PATH_B : '') ?>
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Descripci&oacute;n', name : 'exp_descripcion'},
            {display: 'Fecha Inicio', name : 'exf_fecha_exi'},
            {display: 'Fecha Final', name : 'exf_fecha_exf'},
            {display: 'Custodio', name : 'custodio'}
        ],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: 'REGULARIZACIÓN DE DOCUMENTOS',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260,
        autoload: false
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#exp_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/regularizar/searchTree/");
            document.getElementById('formA').submit();
        }	
    }
    function test(com,grid)
    {
        if (com=='Ver'){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/regularizar/searchTree/");
                document.getElementById('formA').submit();
            }else{
                alert("Seleccione un registro");
            }	
        }
        else{
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }

</script>
</body>
</html>
