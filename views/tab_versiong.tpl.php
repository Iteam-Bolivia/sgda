<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/version/<?php echo $PATH_EVENT ?>/">
    <input name="ver_id" id="ver_id" type="hidden" value="<?php echo $ver_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/version/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'ver_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_ini', name : 'ver_fecha_ini', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_fin', name : 'ver_fecha_fin', width : 40, sortable : true, align: 'center'},
            {display: 'paso', name : 'ver_paso', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'usu_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'ver_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'ver_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'ver_id', name : 'ver_id', isdefault: true},
            {display: 'ver_id', name : 'ver_id'},
            {display: 'ver_fecha_ini', name : 'ver_fecha_ini'},
            {display: 'ver_fecha_fin', name : 'ver_fecha_fin'},
            {display: 'ver_paso', name : 'ver_paso'},
            {display: 'usu_id', name : 'usu_id'},
            {display: 'ver_fecha_crea', name : 'ver_fecha_crea'},
            {display: 'ver_estado', name : 'ver_estado'},
        ],
        sortname: "ver_id",
        sortorder: "asc",
        usepager: true,
        title: 'version',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });
    function test(com,grid)
    {
        if (com=='Delete')
        {
            if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                $.post("<?php echo $PATH_DOMAIN ?>/version/delete/",{ver_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/version/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#ver_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/version/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
