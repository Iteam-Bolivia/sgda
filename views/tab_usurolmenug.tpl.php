<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/usurolmenu/<?php echo $PATH_EVENT ?>/">
    <input name="urm_id" id="urm_id" type="hidden" value="<?php echo $urm_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/usurolmenu/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'urm_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'usu_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'rol_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'men_id', width : 40, sortable : true, align: 'center'},
            {display: 'privilegios', name : 'urm_privilegios', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_reg', name : 'urm_fecha_reg', width : 40, sortable : true, align: 'center'},
            {display: 'usu_reg', name : 'urm_usu_reg', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'urm_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'usu_mod', name : 'urm_usu_mod', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'urm_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'urm_id', name : 'urm_id', isdefault: true},
            {display: 'urm_id', name : 'urm_id'},
            {display: 'usu_id', name : 'usu_id'},
            {display: 'rol_id', name : 'rol_id'},
            {display: 'men_id', name : 'men_id'},
            {display: 'urm_privilegios', name : 'urm_privilegios'},
            {display: 'urm_fecha_reg', name : 'urm_fecha_reg'},
            {display: 'urm_usu_reg', name : 'urm_usu_reg'},
            {display: 'urm_fecha_mod', name : 'urm_fecha_mod'},
            {display: 'urm_usu_mod', name : 'urm_usu_mod'},
            {display: 'urm_estado', name : 'urm_estado'},
        ],
        sortname: "urm_id",
        sortorder: "asc",
        usepager: true,
        title: 'usurolmenu',
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
                $.post("<?php echo $PATH_DOMAIN ?>/usurolmenu/delete/",{urm_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/usurolmenu/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#urm_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/usurolmenu/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
