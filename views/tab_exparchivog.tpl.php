<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/exparchivo/<?php echo $PATH_EVENT ?>/">
    <input name="exa_id" id="exa_id" type="hidden" value="<?php echo $exa_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/exparchivo/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'exa_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'euv_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'ser_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'tra_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'cue_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'trc_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'uni_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'ver_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'exc_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'con_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'suc_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'usu_id', width : 40, sortable : true, align: 'center'},
            {display: 'condicion', name : 'exa_condicion', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'exa_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_crea', name : 'exa_usuario_crea', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'exa_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_mod', name : 'exa_usuario_mod', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'exa_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'exa_id', name : 'exa_id', isdefault: true},
            {display: 'exa_id', name : 'exa_id'},
            {display: 'fil_id', name : 'fil_id'},
            {display: 'euv_id', name : 'euv_id'},
            {display: 'exp_id', name : 'exp_id'},
            {display: 'ser_id', name : 'ser_id'},
            {display: 'tra_id', name : 'tra_id'},
            {display: 'cue_id', name : 'cue_id'},
            {display: 'trc_id', name : 'trc_id'},
            {display: 'uni_id', name : 'uni_id'},
            {display: 'ver_id', name : 'ver_id'},
            {display: 'exc_id', name : 'exc_id'},
            {display: 'con_id', name : 'con_id'},
            {display: 'suc_id', name : 'suc_id'},
            {display: 'usu_id', name : 'usu_id'},
            {display: 'exa_condicion', name : 'exa_condicion'},
            {display: 'exa_fecha_crea', name : 'exa_fecha_crea'},
            {display: 'exa_usuario_crea', name : 'exa_usuario_crea'},
            {display: 'exa_fecha_mod', name : 'exa_fecha_mod'},
            {display: 'exa_usuario_mod', name : 'exa_usuario_mod'},
            {display: 'exa_estado', name : 'exa_estado'},
        ],
        sortname: "exa_id",
        sortorder: "asc",
        usepager: true,
        title: 'exparchivo',
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
                $.post("<?php echo $PATH_DOMAIN ?>/exparchivo/delete/",{exa_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {

                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/exparchivo/add/";
        }
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#exa_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/exparchivo/view/");
                document.getElementById('formA').submit();
            }
        }
    }
</script>
</body>
</html>