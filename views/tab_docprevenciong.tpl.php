<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/docprevencion/<?php echo $PATH_EVENT ?>/">

    <input name="dpr_id" id="dpr_id" type="hidden" value="<?php echo $dpr_id; ?>" />
    <input name="dpr_tipo" id="dpr_tipo" type="hidden" value="<?php echo $dpr_tipo; ?>" />
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
<script type="text/javascript">


    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/docprevencion/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'dpr_id', width : 40, sortable : true, align: 'center'},
            {display: 'Tipo', name : 'dpr_tipo', width : 100, sortable : true, align: 'center'},
            {display: 'Unidad', name : 'uni_id', width : 70, sortable : true, align: 'left'},
            {display: 'Fecha de Revisi&oacute;n', name : 'dpr_fecha_revision', width : 80, sortable : true, align: 'center'},
            {display: 'Productor', name : 'dpr_productor', width : 160, sortable : true, align: 'left'},
            {display: 'Cargo Productor', name : 'dpr_cargo_productor', width : 160, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {name: 'Ver', bclass: 'ver', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'dpr_id', isdefault: true},
            {display: 'Tipo', name : 'dpr_tipo'},
            {display: 'Unidad', name : 'unidad'},
            {display: 'Fecha Rev.', name : 'dpr_fecha_revision'},
            {display: 'Productor', name : 'dpr_productor'},
            {display: 'Cargo Productor', name : 'dpr_cargo_productor'}
        ],
        sortname: "dpr_id",
        sortorder: "asc",
        usepager: true,
        title: 'Documento de Prevenci&oacute;n',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#dpr_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/docprevencion/editar/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/docprevencion/delete/",{dpr_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {
						
                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/docprevencion/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#dpr_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/docprevencion/editar/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
        else if (com=='Ver'){
            var i=0;
            var elemento = $('tr',grid).html();
            $('.trSelected',grid).each(function(i){
                //alert(i);
                if(i==2)
                {		alert($(this).val().html());
                }
                i++;
            });
            if($('.trSelected div',grid).html()){
			
                $("#dpr_tipo").val($('.trSelected div',grid).html());
                //alert($('.trSelected ',grid).html());
                var tipoEnlace = $("#dpr_tipo").val();
                window.location="<?php echo $PATH_DOMAIN ?>/docprevencion/ruta/"+tipoEnlace+"/";
            }else alert("Seleccione un registro");
        }
    }

</script>
</body>
</html>