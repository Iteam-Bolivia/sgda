
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/auditoria/<?php echo $PATH_EVENT ?>/">

    <input name="aud_id" id="aud_id" type="hidden" value="<?php echo $aud_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/auditoria/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'aud_id', width : 40, sortable : true, align: 'center'},
            {display: 'tabla', name : 'aud_tabla', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_mod', name : 'aud_usuario_mod', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'aud_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'hora_mod', name : 'aud_hora_mod', width : 40, sortable : true, align: 'center'},
            {display: 'accion', name : 'aud_accion', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'aud_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'aud_id', name : 'aud_id', isdefault: true},
            {display: 'aud_id', name : 'aud_id'},
            {display: 'aud_tabla', name : 'aud_tabla'},
            {display: 'aud_usuario_mod', name : 'aud_usuario_mod'},
            {display: 'aud_fecha_mod', name : 'aud_fecha_mod'},
            {display: 'aud_hora_mod', name : 'aud_hora_mod'},
            {display: 'aud_accion', name : 'aud_accion'},
            {display: 'aud_estado', name : 'aud_estado'},
        ],
        sortname: "aud_id",
        sortorder: "asc",
        usepager: true,
        title: 'AUDITORÍA',
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
                $.post("<?php echo $PATH_DOMAIN ?>/auditoria/delete/",{aud_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {

                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/auditoria/add/";
        }
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#aud_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/auditoria/view/");
                document.getElementById('formA').submit();
            }
        }
    }
</script>
</body>
</html>