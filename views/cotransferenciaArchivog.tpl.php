<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/<?php echo $PATH_EVENT ?>/">
    <input name="trn_id" id="trn_id" type="hidden" value="<?php //echo $trn_id;  ?>" /> -->
    <input name="trn_id" id="trn_id" type="hidden" value="<?php echo 0; ?>" />
</form>

</div>
<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'trn_id', width : 40, sortable : true, align: 'center'},
            {display: 'Sub-Fondo Origen', name : 'trn_usuario_orig', width : 100, sortable : true, align: 'left'},
            /*{display: 'Unidad Origen', name : 'trn_uni_origen', width : 65, sortable : true, align: 'left'},*/
            {display: 'Fecha', name : 'trn_fecha_crea', width : 60, sortable : true, align: 'center'},
            //{display: 'Cant. Exped.', name : 'cantidad', width : 60, sortable : true, align: 'left'},
            {display: 'Series', name : 'series', width : 100, sortable : true, align: 'left'},
            {display: 'Motivo', name : 'trn_descripcion', width : 150, sortable : true, align: 'left'}	
        ],
        buttons : [
            {name: 'Ver', bclass: 'view', onpress : test}<?php //echo ($PATH_A!='' ? ','.$PATH_A : '')  ?>
        ],
        searchitems : [
            {display: 'Id', name : 'trn_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'Codigo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'},
            {display: 'Sub-Fondo', name : 'inl_descripcion'},
            /*{display: 'U. Destino', name : 'uni_destino'},*/
            {display: 'Fecha final', name : 'exp_fecha_exf'},
            {display: 'Motivo', name : 'trn_descripcion'}
        ],
        sortname: "trn_id",
        sortorder: "desc",
        usepager: true,
        title: '<?php echo $titulo ?>',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });
    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#exp_id").val($('.trSelected div',grid).html());
            if($("table",grid).attr('id')=="flex1"){
                //alert($('.trSelected div',grid).html());
                location.href="<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/viewTree/"+$('.trSelected div',grid).html()+"/";
						
            }
        }
    }
    function test(com,grid)
    {
        if(com=="Ver"){
            if($('.trSelected div',grid).html()){
                $("#exp_id").val($('.trSelected div',grid).html());
                location.href="<?php echo $PATH_DOMAIN ?>/cotransferenciaArchivo/viewTree/"+$('.trSelected div',grid).html()+"/";
            }else{
                alert("Seleccione un registro");
            }
        }else{
            $(".qsbox").val(com);
            $(".qtype").val('ser_categoria');
            $('.Search').click();
        }
    }
</script>

</body>
</html>
