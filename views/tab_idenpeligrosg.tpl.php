<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/idenpeligros/<?php echo $PATH_EVENT ?>/">
    <input name="ide_id" id="ide_id" type="hidden" value="<?php echo $ide_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/idenpeligros/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'ide_id', width : 40, sortable : true, align: 'center'},
            {display: 'Local', name : 'loc_id', width : 140, sortable : true, align: 'left'},
            {display: 'Elemento Expuesto', name : 'ide_ele_ex', width : 80, sortable : true, align: 'left'},
            {display: 'Peligro', name : 'ide_peligros', width : 80, sortable : true, align: 'left'},
            {display: 'Oficina', name : 'ide_oficina', width : 80, sortable : true, align: 'left'},
            {display: 'Observaciones', name : 'ide_observaciones', width : 197, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'ide_id', isdefault: true},
            {display: 'Local', name : 'loc_id'},
            {display: 'El. Exp.', name : 'ide_ele_ex'},
            {display: 'Peligro', name : 'ide_peligros'},
            {display: 'Oficina', name : 'ide_oficina'},
            {display: 'Observ.', name : 'ide_observaciones'}
        ],
        sortname: "ide_id",
        sortorder: "asc",
        usepager: true,
        title: 'Identificaci&oacute;n de Peligros',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html())
        {
            $("#ide_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/idenpeligros/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/idenpeligros/delete/",{ide_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {

                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/idenpeligros/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#ide_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/idenpeligros/edit/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
    }
</script>
</body>
</html>