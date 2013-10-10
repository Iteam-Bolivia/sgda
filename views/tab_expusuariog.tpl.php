<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/expusuario/<?php echo $PATH_EVENT ?>/">
    <input name="eus_id" id="eus_id" type="hidden" value="<?php echo $eus_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/expusuario/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'eus_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'usu_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'eus_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'eus_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'eus_id', name : 'eus_id', isdefault: true},
            {display: 'eus_id', name : 'eus_id'},
            {display: 'usu_id', name : 'usu_id'},
            {display: 'exp_id', name : 'exp_id'},
            {display: 'eus_fecha_crea', name : 'eus_fecha_crea'},
            {display: 'eus_estado', name : 'eus_estado'},
        ],
        sortname: "eus_id",
        sortorder: "asc",
        usepager: true,
        title: 'expusuario',
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
                $.post("<?php echo $PATH_DOMAIN ?>/expusuario/delete/",{eus_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/expusuario/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#eus_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/expusuario/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
