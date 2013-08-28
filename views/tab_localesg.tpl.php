<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/locales/<?php echo $PATH_EVENT ?>/">
    <input name="loc_id" id="loc_id" type="hidden" value="<?php echo $loc_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/locales/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'loc_id', width : 40, sortable : true, align: 'center'},
            {display: 'descripcion', name : 'loc_descripcion', width : 40, sortable : true, align: 'center'},
            {display: 'usu_reg', name : 'loc_usu_reg', width : 40, sortable : true, align: 'center'},
            {display: 'usu_mod', name : 'loc_usu_mod', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_reg', name : 'loc_fecha_reg', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'loc_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'loc_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'loc_id', name : 'loc_id', isdefault: true},
            {display: 'loc_id', name : 'loc_id'},
            {display: 'loc_descripcion', name : 'loc_descripcion'},
            {display: 'loc_usu_reg', name : 'loc_usu_reg'},
            {display: 'loc_usu_mod', name : 'loc_usu_mod'},
            {display: 'loc_fecha_reg', name : 'loc_fecha_reg'},
            {display: 'loc_fecha_mod', name : 'loc_fecha_mod'},
            {display: 'loc_estado', name : 'loc_estado'},
        ],
        sortname: "loc_id",
        sortorder: "asc",
        usepager: true,
        title: 'locales',
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
                $.post("<?php echo $PATH_DOMAIN ?>/locales/delete/",{loc_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {

                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/locales/add/";
        }
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#loc_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/locales/view/");
                document.getElementById('formA').submit();
            }
        }
    }
</script>
</body>
</html>
