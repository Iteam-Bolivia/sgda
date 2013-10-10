
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/tramitecuerpos/<?php echo $PATH_EVENT ?>/">
    <input name="trc_id" id="trc_id" type="hidden" value="<?php echo $trc_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/tramitecuerpos/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'trc_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'ver_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'tra_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'cue_id', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_crea', name : 'trc_usuario_crea', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'trc_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'trc_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'trc_id', name : 'trc_id', isdefault: true},
            {display: 'trc_id', name : 'trc_id'},
            {display: 'ver_id', name : 'ver_id'},
            {display: 'tra_id', name : 'tra_id'},
            {display: 'cue_id', name : 'cue_id'},
            {display: 'trc_usuario_crea', name : 'trc_usuario_crea'},
            {display: 'trc_fecha_crea', name : 'trc_fecha_crea'},
            {display: 'trc_estado', name : 'trc_estado'},
        ],
        sortname: "trc_id",
        sortorder: "asc",
        usepager: true,
        title: 'tramitecuerpos',
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
                $.post("<?php echo $PATH_DOMAIN ?>/tramitecuerpos/delete/",{trc_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {

                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/tramitecuerpos/add/";
        }
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#trc_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/tramitecuerpos/view/");
                document.getElementById('formA').submit();
            }
        }
    }
</script>
</body>
</html>
