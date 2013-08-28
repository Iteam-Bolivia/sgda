<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/retdocumental/<?php echo $PATH_EVENT ?>/">
    <input name="ret_id" id="ret_id" type="hidden" value="<?php echo $ret_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/retdocumental/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'ret_id', width : 40, sortable : true, align: 'center'},
            {display: 'par', name : 'ret_par', width : 40, sortable : true, align: 'center'},
            {display: 'lugar', name : 'ret_lugar', width : 40, sortable : true, align: 'center'},
            {display: 'anios', name : 'ret_anios', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_crea', name : 'ret_usuario_crea', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'ret_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'ret_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'usu_mod', name : 'ret_usu_mod', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'ret_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'ret_id', name : 'ret_id', isdefault: true},
            {display: 'ret_id', name : 'ret_id'},
            {display: 'ret_par', name : 'ret_par'},
            {display: 'ret_lugar', name : 'ret_lugar'},
            {display: 'ret_anios', name : 'ret_anios'},
            {display: 'ret_usuario_crea', name : 'ret_usuario_crea'},
            {display: 'ret_fecha_crea', name : 'ret_fecha_crea'},
            {display: 'ret_fecha_mod', name : 'ret_fecha_mod'},
            {display: 'ret_usu_mod', name : 'ret_usu_mod'},
            {display: 'ret_estado', name : 'ret_estado'},
        ],
        sortname: "ret_id",
        sortorder: "asc",
        usepager: true,
        title: 'RETENCIÓN DE DOCUMENTOS',
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
                $.post("<?php echo $PATH_DOMAIN ?>/retdocumental/delete/",{ret_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/retdocumental/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#ret_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/retdocumental/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>