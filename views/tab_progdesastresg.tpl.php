<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/progdesastres/<?php echo $PATH_EVENT ?>/">
    <input name="dpr_id" id="dpr_id" type="hidden" value="<?php echo $dpr_id; ?>" />   
    <input name="des_id" id="des_id" type="hidden" value="<?php echo $des_id; ?>" />
    <input name="uni_id" id="uni_id" type="hidden" value="<?php echo $uni_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/progdesastres/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'des_id', width : 50, sortable : true, align: 'center'},
            {display: 'Resumen', name : 'des_resumen', width : 250, sortable : true, align: 'left'},
            {display: 'Indicador', name : 'des_indicador', width : 100, sortable : true, align: 'left'},
            {display: 'Fuentes', name : 'des_fuentes', width : 100, sortable : true, align: 'left'},
            {display: 'Riesgo', name : 'des_riesgo', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'des_id', isdefault: true},
            {display: 'Resumen', name : 'des_resumen'},
            {display: 'Indicador', name : 'des_indicador'},
            {display: 'Fuentes', name : 'des_fuentes'},
            {display: 'Riesgo', name : 'des_riesgo'}
        ],
        sortname: "des_id",
        sortorder: "asc",
        usepager: true,
        title: 'Programa de Desastres',
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
            $("#des_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/progdesastres/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/progdesastres/delete/",{des_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {
						
                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/progdesastres/add/";
        } 
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#des_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/progdesastres/edit/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
    }
</script>
</body>
</html>