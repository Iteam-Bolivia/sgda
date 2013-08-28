<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/plandesastre/<?php echo $PATH_EVENT ?>/">
    <input name="pla_id" id="pla_id" type="hidden" value="<?php echo $pla_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/plandesastre/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'pla_id', width : 50, sortable : true, align: 'center'},
            {display: 'T�tulo', name : 'pla_titulo', width : 340, sortable : true, align: 'left'},
            {display: 'Gestion', name : 'pla_gestion', width : 60, sortable : true, align: 'center'},
            {display: 'Mes inicial', name : 'pla_mes_inicial', width : 100, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Eliminar', bclass: 'delete', onpress : test},
            {name: 'Editar', bclass: 'edit', onpress : test},
            {name: 'Actividad', bclass: 'act', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'pla_id', isdefault: true},
            {display: 'Tipo', name : 'dpr_id'},
            {display: 'T&iacute;tulo', name : 'pla_titulo'},
            {display: 'Gesti&oacute;n', name : 'pla_gestion'},
            {display: 'Mes Inicial', name : 'pla_mes_inicial'}
        ],
        sortname: "pla_id",
        sortorder: "asc",
        usepager: true,
        title: 'Plan de Desastres',
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
            $("#eva_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/evalriesgos/edit/");
            document.getElementById('formA').submit();
        }
    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.post("<?php echo $PATH_DOMAIN ?>/plandesastre/delete/",{pla_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                        if(data != true){
                            $('.pReload',grid.pDiv).click();
                        }else {

                        }
                });
            }else alert("Seleccione un registro");
        }
        else if (com=='Adicionar')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/plandesastre/add/";
        }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#pla_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/plandesastre/edit/");
                document.getElementById('formA').submit();
            }else alert("Seleccione un registro");
        }
        else if (com=='Actividad'){
            if($('.trSelected div',grid).html()){
                $("#pla_id").val($('.trSelected div',grid).html());
                id = $("#pla_id").val();
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/cronoact/ind/"+id+"/");
                document.getElementById('formA').submit();

            }else alert("Seleccione un registro");
        }

    }
</script>
</body>
</html>