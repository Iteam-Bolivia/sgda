<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

</div>
<div class="clear"></div>
</div>
</div>
<div id="footer"><a href="#" class="byLogos"
                    title="Desarrollado por ITeam business technology">Desarrollado por
        ITeam business technology</a></div>
</div>
<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/login/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'uni_id', width : 40, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'usu_nombres', width : 70, sortable : true, align: 'left'},
            {display: 'Apellido', name : 'usu_apellidos', width : 70, sortable : true, align: 'left'},
            {display: 'Categoria', name : 'ser_categoria', width : 200, sortable : true, align: 'left'},
            {display: 'Tipo', name : 'ser_tipo', width : 60, sortable : true, align: 'left'},
            {display: 'Cant. Exp.', name : 'exp_count', width : 60, sortable : true, align: 'left'},
            {display: 'Exp. Sub-Fondo', name : 'exp_countf', width : 60, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Ver',  onpress : test}<?php echo ($PATH_B != '' ? ',' . $PATH_B : '') ?>
        ],
        searchitems : [
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Nombre', name : 'exp_nombre'}
        ],	
        sortname: "uni_id",
        sortorder: "asc",
        usepager: true,
        useRp: true,
        rp: 10,
        showTableToggleBtn: true,
        width: 687,
        height: 260,
        autoload: false
    });

    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#exp_id").val($('.trSelected div',grid).html());
            $("#formA").attr("action","<?php echo $PATH_DOMAIN ?>/estrucDocumental/searchTree/");
            document.getElementById('formA').submit();
        }	
    }
    function test(com,grid)
    {
        if (com=='Ver'){
            alert("Seleccione un registro");
        }
        else{
            $(".qsbox").val(com);
            $('.Search',grid.pDiv).click();
        }
    }

</script>
</body>
</html>
