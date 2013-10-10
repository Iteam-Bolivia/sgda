<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable"
      action="<?php echo $PATH_DOMAIN ?>/exp_nur/<?php echo $PATH_EVENT ?>/">
    <input name="exn_id" id="exn_id" type="hidden"
           value="<?php echo $exn_id; ?>" />
</form>

<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/exp_nur/load/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'exn_id', width : 40, sortable : true, align: 'center'},
            {display: 'Usuario', name : 'exn_user', width : 80, sortable : true, align: 'left'},
            {display: 'NUR/NURI', name : 'exn_nur', width : 700, sortable : true, align: 'left'},
        ],
        buttons : [
            {name: 'Registrar', bclass: 'edit', onpress : test},
            {separator: true}
        ],
        searchitems : [
            {display: 'Id', name : 'exn_id', isdefault: true},
            {display: 'NUR/NURI', name : 'exn_nur'},
        ],
        sortname: "exn_id",
        sortorder: "asc",
        usepager: true,
        title: 'NUR/NURI PENDIENTES',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 800,
        height: 390
    });

    //    function dobleClik(grid){
    //        if($('.trSelected div',grid).html())
    //        {
    //            $("#exn_id").val($('.trSelected div',grid).html());
    //            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/exp_nur/edit/");
    //            document.getElementById('formA').submit();
    //        }
    //    }
    function test(com,grid)
    {
        if (com=='Eliminar')
        {
            if($('.trSelected div',grid).html()){
                if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                    $.ajax({
                        url: '<?php echo $PATH_DOMAIN ?>/exp_nur/validaexnen/',
                        type: 'POST',
                        data: 'exn_id='+$('.trSelected div',grid).html(),
                        dataType:  "text",
                        success: function(datos)
                        {
                            if(datos!='')
                            {
                                alert(datos);
                            }
                            else
                            {
                                $.post("<?php echo $PATH_DOMAIN ?>/exp_nur/delete/",{exn_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                    if(data != true){
                                        $('.pReload',grid.pDiv).click();
                                    }
                                });
                        }
                    }
                });
            }
            else {
                alert("Seleccione un registro");
            }
        }

        //    else if (com=='Adicionar')
        //    {
        //        window.location="<?php echo $PATH_DOMAIN ?>/exp_nur/add/";
        //    }
        else if (com=='Registrar'){
            if($('.trSelected div',grid).html()){
                $("#exn_id").val($('.trSelected div',grid).html());


                $.ajax({
                    url: '<?php echo $PATH_DOMAIN ?>/exp_nur/selecNur/',
                    type: 'POST',
                    data: 'Exn_id='+$('.trSelected div',grid).html(),
                    dataType:  "text",
                    success: function(datos)
                    {
                        if(datos!='')
                        {
                            alert(datos);
                        }
                        else
                        {
                            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/nuevoExpediente/add/");
                            document.getElementById('formA').submit();
                        }
                    }
                });







            }
            else{
                alert("Seleccione un registro");
            }
        }

    }
</script>