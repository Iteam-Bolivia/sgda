<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/cronoact/<?php echo $PATH_EVENT ?>/">
    <input name="cro_id" id="cro_id" type="hidden" value="<?php echo $cro_id; ?>" />
</form>
<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/plandesastre/"><<--Volver a Plan de desastres<<--</a></p>
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
        url: '<?php echo $PATH_DOMAIN ?>/cronoact/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'cro_id', width : 40, sortable : true, align: 'center'},
            {display: 'Plan titulo', name : 'pla_id', width : 128, sortable : true, align: 'center'},
            {display: 'Actividad', name : 'cro_actividad', width : 280, sortable : true, align: 'left'},
            {display: 'Mes inicial', name : 'cro_mes_ini', width : 80, sortable : true, align: 'left'},
            {display: 'Tiempo en semanas', name : 'cro_tiempo', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'cro_id', name : 'cro_id', isdefault: true},
            {display: 'Actividad', name : 'cro_actividad'},
            {display: 'Mes inicial', name : 'cro_mes_ini'},
            {display: 'Tiempo', name : 'cro_tiempo'}
        ],
        sortname: "cro_id",
        sortorder: "asc",
        usepager: true,
        title: 'CRONOGRAMA DE ACTIVIDADES',
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
                $.post("<?php echo $PATH_DOMAIN ?>/cronoact/delete/",{cro_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/cronoact/add/<?php echo $pla_id; ?>/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#cro_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/cronoact/edit/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>