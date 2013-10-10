
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/serietramite/<?php echo $PATH_EVENT ?>/">
    <input name="sts_id" id="sts_id" type="hidden" value="<?php echo $sts_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/serietramite/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'sts_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'ser_id', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'tra_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'sts_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_crea', name : 'sts_usuario_crea', width : 40, sortable : true, align: 'center'},
            {display: 'id', name : 'ver_id', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_reg', name : 'sts_fecha_reg', width : 40, sortable : true, align: 'center'},
            {display: 'usu_reg', name : 'sts_usu_reg', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'sts_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'sts_id', name : 'sts_id', isdefault: true},
            {display: 'sts_id', name : 'sts_id'},
            {display: 'ser_id', name : 'ser_id'},
            {display: 'tra_id', name : 'tra_id'},
            {display: 'sts_fecha_crea', name : 'sts_fecha_crea'},
            {display: 'sts_usuario_crea', name : 'sts_usuario_crea'},
            {display: 'ver_id', name : 'ver_id'},
            {display: 'sts_fecha_reg', name : 'sts_fecha_reg'},
            {display: 'sts_usu_reg', name : 'sts_usu_reg'},
            {display: 'sts_estado', name : 'sts_estado'},
        ],
        sortname: "sts_id",
        sortorder: "asc",
        usepager: true,
        title: 'serietramite',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                $.post("<?php echo $PATH_DOMAIN ?>/serietramite/delete/",{sts_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/serietramite/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#sts_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/serietramite/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>
