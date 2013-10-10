<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT ?>/">
    <input name="fil_id" id="fil_id" type="hidden" value="<?php echo $fil_id; ?>" />
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
        url: '<?php echo $PATH_DOMAIN ?>/archivo/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'nomoriginal', name : 'fil_nomoriginal', width : 40, sortable : true, align: 'center'},
            {display: 'nomcifrado', name : 'fil_nomcifrado', width : 40, sortable : true, align: 'center'},
            {display: 'tamano', name : 'fil_tamano', width : 40, sortable : true, align: 'center'},
            {display: 'extension', name : 'fil_extension', width : 40, sortable : true, align: 'center'},
            {display: 'tipo', name : 'fil_tipo', width : 40, sortable : true, align: 'center'},
            {display: 'descripcion', name : 'fil_descripcion', width : 40, sortable : true, align: 'center'},
            {display: 'caracteristica', name : 'fil_caracteristica', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_crea', name : 'fil_fecha_crea', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_crea', name : 'fil_usuario_crea', width : 40, sortable : true, align: 'center'},
            {display: 'fecha_mod', name : 'fil_fecha_mod', width : 40, sortable : true, align: 'center'},
            {display: 'usuario_mod', name : 'fil_usuario_mod', width : 40, sortable : true, align: 'center'},
            {display: 'confidencialidad', name : 'fil_confidencialidad', width : 40, sortable : true, align: 'center'},
            {display: 'estado', name : 'fil_estado', width : 40, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Add', bclass: 'add', onpress : test},
            {name: 'Delete', bclass: 'delete', onpress : test},
            {name: 'Edit', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'fil_id', name : 'fil_id', isdefault: true},
            {display: 'fil_id', name : 'fil_id'},
            {display: 'fil_nomoriginal', name : 'fil_nomoriginal'},
            {display: 'fil_nomcifrado', name : 'fil_nomcifrado'},
            {display: 'fil_tamano', name : 'fil_tamano'},
            {display: 'fil_extension', name : 'fil_extension'},
            {display: 'fil_tipo', name : 'fil_tipo'},
            {display: 'fil_descripcion', name : 'fil_descripcion'},
            {display: 'fil_caracteristica', name : 'fil_caracteristica'},
            {display: 'fil_fecha_crea', name : 'fil_fecha_crea'},
            {display: 'fil_usuario_crea', name : 'fil_usuario_crea'},
            {display: 'fil_fecha_mod', name : 'fil_fecha_mod'},
            {display: 'fil_usuario_mod', name : 'fil_usuario_mod'},
            {display: 'fil_confidencialidad', name : 'fil_confidencialidad'},
            {display: 'fil_estado', name : 'fil_estado'},
        ],
        sortname: "fil_id",
        sortorder: "asc",
        usepager: true,
        title: 'ARCHIVO DIGITAL',
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
                $.post("<?php echo $PATH_DOMAIN ?>/archivo/delete/",{fil_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/archivo/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#fil_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/archivo/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
    
</script>
</body>
</html>
