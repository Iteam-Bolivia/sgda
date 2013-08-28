<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/archivobin/<?php echo $PATH_EVENT ?>/">

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
        url: '<?php echo $PATH_DOMAIN ?>/archivobin/load/',
        dataType: 'json',
        colModel : [
            {display: 'id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'contenido', name : 'fil_contenido', width : 40, sortable : true, align: 'center'},
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
            {display: 'fil_contenido', name : 'fil_contenido'},
            {display: 'fil_estado', name : 'fil_estado'},
        ],
        sortname: "fil_id",
        sortorder: "asc",
        usepager: true,
        title: 'ARCHIVOS DIGITALES',
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
                $.post("<?php echo $PATH_DOMAIN ?>/archivobin/delete/",{fil_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                    if(data != true){
                        $('.pReload',grid.pDiv).click();
                    }else {
					
                    }
            });
        }
        else if (com=='Add')
        {
            window.location="<?php echo $PATH_DOMAIN ?>/archivobin/add/";
        } 
        else if (com=='Edit'){
            if($('.trSelected div',grid).html()){
                $("#fil_id").val($('.trSelected div',grid).html());
                $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/archivobin/view/");
                document.getElementById('formA').submit();
            }	
        }
    }
</script>
</body>
</html>