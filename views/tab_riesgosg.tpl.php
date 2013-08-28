<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/riesgos/<?php echo $PATH_EVENT ?>/">
    <input name="rie_id" id="rie_id" type="hidden" value="<?php echo $rie_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/riesgos/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'rie_id', width : 40, sortable : true, align: 'center'},
            {display: 'descripcion', name : 'rie_descripcion', width : 40, sortable : true, align: 'center'},
            {display: 'tipo', name : 'rie_tipo', width : 40, sortable : true, align: 'center'},
            {display: 'usu_reg', name : 'rie_usu_reg', width : 40, sortable : true, align: 'center'},
            {display: 'usu_mod', name : 'rie_usu_mod', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_reg', name : 'rie_fecha_reg', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'rie_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'rie_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'rie_id', name : 'rie_id', isdefault: true},
            {display: 'rie_id', name : 'rie_id'},
            {display: 'rie_descripcion', name : 'rie_descripcion'},
            {display: 'rie_tipo', name : 'rie_tipo'},
            {display: 'rie_usu_reg', name : 'rie_usu_reg'},
            {display: 'rie_usu_mod', name : 'rie_usu_mod'},
            {display: 'rie_fecha_reg', name : 'rie_fecha_reg'},
            {display: 'rie_fecha_mod', name : 'rie_fecha_mod'},
            {display: 'rie_estado', name : 'rie_estado'},
        ],
        sortname: "rie_id",
        sortorder: "asc",
        usepager: true,
        title: 'riesgos',
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
                $.post("<?php echo $PATH_DOMAIN ?>/riesgos/delete/",{rie_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/riesgos/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#rie_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/riesgos/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>