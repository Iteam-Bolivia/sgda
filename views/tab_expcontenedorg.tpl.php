<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/expcontenedor/<?php echo $PATH_EVENT ?>/">
    <input name="exc_id" id="exc_id" type="hidden" value="<?php echo $exc_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/expcontenedor/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'exc_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'euv_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'con_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_reg', name : 'exc_fecha_reg', width : 40, sortable : true, align: 'center'},
            {display: 'usu_reg', name : 'exc_usu_reg', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'exc_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'exc_id', name : 'exc_id', isdefault: true},
            {display: 'exc_id', name : 'exc_id'},
            {display: 'euv_id', name : 'euv_id'},
            {display: 'exp_id', name : 'exp_id'},
            {display: 'con_id', name : 'con_id'},
            {display: 'exc_fecha_reg', name : 'exc_fecha_reg'},
            {display: 'exc_usu_reg', name : 'exc_usu_reg'},
            {display: 'exc_estado', name : 'exc_estado'},
        ],
        sortname: "exc_id",
        sortorder: "asc",
        usepager: true,
        title: 'expcontenedor',
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
                $.post("<?php echo $PATH_DOMAIN ?>/expcontenedor/delete/",{exc_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {

                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/expcontenedor/add/";
        }
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#exc_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expcontenedor/view/");
                document.getElementById('formA').submit();
            }
        }
    }
</script>
</body>
</html>