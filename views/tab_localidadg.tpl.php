<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/localidad/<?php echo $PATH_EVENT ?>/">
    <input name="loc_id" id="loc_id" type="hidden" value="<?php echo $loc_id; ?>" />
    <input name="pro_id" id="pro_id" type="hidden" value="<?php echo 0; ?>" />
</form>

<p align="right"><a href="<?php echo $PATH_DOMAIN; ?>/provincia/index/<?php echo $dep_id; ?>/"><<<< Volver a Provincias </a></p>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/localidad/load/<?php echo VAR3; ?>/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'loc_id', width : 40, sortable : true, align: 'center'},
            {display: 'Código', name : 'loc_codigo', width : 80, sortable : true, align: 'left'},
            {display: 'Ciudad', name : 'loc_nombre', width : 600, sortable : true, align: 'left'},
        ],
        buttons : [
                    {name: 'Adicionar', bclass: 'add', onpress : test},
                    {name: 'Eliminar', bclass: 'delete', onpress : test},
                    {name: 'Editar', bclass: 'edit', onpress : test},
                    {separator: true}
                ],
                searchitems : [
                    {display: 'Id', name : 'loc_id', isdefault: true},
                    {display: 'Código', name : 'loc_codigo'},
                    {display: 'Ciudad', name : 'loc_nombre'},
                ],
                sortname: "loc_id",
                sortorder: "asc",
                usepager: true,
                title: 'CIUDADES DE LA PROVINCIA: " <?php echo $pro_nombre; ?> "',
                useRp: true,
                rp: 20,
                minimize: <?php echo $GRID_SW ?>,
                showTableToggleBtn: true,
                width: "100%",
                height: 390
            });

            function dobleClik(grid){
                if($('.trSelected div',grid).html())
                {
                    $("#loc_id").val($('.trSelected div',grid).html());
                    $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/localidad/edit/");
                    document.getElementById('formA').submit();
                }
            }

            function test(com,grid)
            {
                if (com=='Eliminar')
                {
                    if($('.trSelected div',grid).html()){
                        if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                            $.ajax({
                                url: '<?php echo $PATH_DOMAIN ?>/localidad/validaDepen/',
                                type: 'POST',
                                data: 'loc_id='+$('.trSelected div',grid).html(),
                                dataType:  		"text",
                                success: function(datos)
                                {
                                    if(datos!='')
                                    {
                                        alert(datos);
                                    }
                                    else
                                    {
                                        $.post("<?php echo $PATH_DOMAIN ?>/localidad/delete/",{loc_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                            if(data != true){
                                                $('.pReload',grid.pDiv).click();
                                            }
                                        });
                                }
                            }
                        });

                    }else{
                        alert("Seleccione un registro");
                    }
                }
                else if (com=='Adicionar')
                {
                    $("#loc_id").val($('.trSelected div',grid).html());
                    loc_id= $("#loc_id").val();

                    window.location="<?php echo $PATH_DOMAIN ?>/localidad/add/<?php echo VAR3; ?>/";
                }
                else if (com=='Editar'){
                    if($('.trSelected div',grid).html()){
                        $("#loc_id").val($('.trSelected div',grid).html());
                        $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/localidad/edit/");
                        document.getElementById('formA').submit();
                    }
                    else{
                        alert("Seleccione un registro");
                    }
                }
            }

</script>