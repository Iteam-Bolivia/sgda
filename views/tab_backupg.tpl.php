<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/backup/<?php echo $PATH_EVENT ?>/">
    <input name="bac_id" id="bac_id" type="hidden" value="<?php echo $bac_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/backup/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'bac_id', width : 40, sortable : true, align: 'center'},
            {display: 'accion', name : 'bac_accion', width : 40, sortable : true, align: 'center'},
            {display: 'file', name : 'bac_file', width : 40, sortable : true, align: 'center'},
            {display: 'size', name : 'bac_size', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'bac_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'usuario', name : 'bac_usuario', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'bac_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'bac_id', name : 'bac_id', isdefault: true},
            {display: 'bac_id', name : 'bac_id'},
            {display: 'bac_accion', name : 'bac_accion'},
            {display: 'bac_file', name : 'bac_file'},
            {display: 'bac_size', name : 'bac_size'},
            {display: 'bac_fecha_crea', name : 'bac_fecha_crea'},
            {display: 'bac_usuario', name : 'bac_usuario'},
            {display: 'bac_estado', name : 'bac_estado'},
        ],
        sortname: "bac_id",
        sortorder: "asc",
        usepager: true,
        title: 'GESTIÓN DE BACKUPS',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 380
    });
    function test(com,grid)
    {
        if (com=='Delete')
        {
            if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                $.post("<?php echo $PATH_DOMAIN ?>/backup/delete/",{bac_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/backup/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#bac_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/backup/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
