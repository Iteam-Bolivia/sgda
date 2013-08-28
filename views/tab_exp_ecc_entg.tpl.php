<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/exp_ecc_ent/<?php echo $PATH_EVENT ?>/">

    <input name="exe_id" id="exe_id" type="hidden" value="<?php echo $exe_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/exp_ecc_ent/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'exe_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'ngreso', name : 'nroingreso', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'exe_id', name : 'exe_id', isdefault: true},
            {display: 'exe_id', name : 'exe_id'},
            {display: 'exp_id', name : 'exp_id'},
            {display: 'nroingreso', name : 'nroingreso'},
        ],
        sortname: "exe_id",
        sortorder: "asc",
        usepager: true,
        title: 'exp_ecc_ent',
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
                $.post("<?php echo $PATH_DOMAIN ?>/exp_ecc_ent/delete/",{exe_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/exp_ecc_ent/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#exe_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/exp_ecc_ent/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
