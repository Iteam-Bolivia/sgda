<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/<?php echo $PATH_EVENT ?>/">
    <input name="exs_id" id="exs_id" type="hidden" value="<?php echo $exs_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'exs_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'alida', name : 'nrosalida', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'exs_id', name : 'exs_id', isdefault: true},
            {display: 'exs_id', name : 'exs_id'},
            {display: 'exp_id', name : 'exp_id'},
            {display: 'nrosalida', name : 'nrosalida'},
        ],
        sortname: "exs_id",
        sortorder: "asc",
        usepager: true,
        title: 'exp_ecc_sal',
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
            if(onfirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                $.post("<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/delete/",{exs_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#exs_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/exp_ecc_sal/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
