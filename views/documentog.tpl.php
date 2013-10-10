<div id="dialog" title="Necesita password para poder ver el archivo">
    <p id="validateTips"></p>
    <form id="formAA" name="formA" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT2 ?>/">

        <label for="pass">Password:</label>
        <input type="hidden" value="" name="fil_id" id="fil_id"  />
        <input type="password" value="" id="pass" name="pass" class="text ui-widget-content ui-corner-all" />
        <input id="btnSub" type="submit" value="" style="visibility:hidden" />

    </form>
</div>

<form id="formArchivo" name="formArchivo" method="post" action="<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT3 ?>/" target="_blank">
    <input type="hidden" value="" name="fil_id_open" id="fil_id_open"  />
    <input type="hidden" value="" id="pass_open" name="pass_open" />
</form>

<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/documento/load/',
        <?php /* data: 'ser_id='+<?php echo $ser_id ?>+'&exp_nombre='+<?php echo $exp_nombre ?>+'&exp_codigo='+<?php echo $exp_codigo ?>+'&tra_id='+<?php echo $tra_id ?>+'&cue_id='+<?php echo $cue_id ?>+'&exp_fecha_exi='+<?php echo $exp_fecha_exi ?>+'&exp_fecha_exf='+<?php echo $exp_fecha_exf ?>+'&archivo='+<?php echo $archivo ?>+'&fil_descripcion='+<?php echo $fil_descripcion ?>, */ ?>
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'fil_id', width : 40, sortable : true, align: 'center'},
            {display: 'Archivo', name : 'fil_nomoriginal', width : 40, sortable : true, align: 'center'},
            {display: 'Tamano', name : 'exa_condicion', width : 40, sortable : true, align: 'center'},
            {display: 'Estado', name : 'fil_tipo', width : 40, sortable : true, align: 'center'},
            {display: 'Tipo', name : 'fil_tipo', width : 40, sortable : true, align: 'center'},
            {display: 'Expediente', name : 'exp_nombre', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 40, sortable : true, align: 'center'},
            {display: 'Serie', name : 'ser_categoria', width : 40, sortable : true, align: 'center'},
            {display: 'Tr&aacute;mite', name : 'tra_descripcion', width : 40, sortable : true, align: 'center'},
            {display: 'Cuerpo', name : 'cue_descripcion', width : 40, sortable : true, align: 'center'},
            {display: 'Fecha. Inicio', name : 'exp_fecha_exi', width : 40, sortable : true, align: 'center'},
            {display: 'Fecha. Final', name : 'exp_fecha_exf', width : 40, sortable : true, align: 'center'},
            {display: 'Descripcion', name : 'fil_descripcion', width : 40, sortable : true, align: 'center'}
	
        ],
        buttons : [
            {name: 'Ver', bclass: 'ver', onpress : test},
            {separator: true}
        ],
        sortname: "fil_id",
        sortorder: "asc",
        usepager: true,
        title: 'Archivos',
        sql: '00',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: 687,
        height: 260
    });
    function test(com,grid)
    {
        if (com=='Ver'){
            if($('.trSelected div',grid).html()){
                $("#fil_id").val($('.trSelected div',grid).html());
				
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PATH_DOMAIN ?>/archivo/<?php echo $PATH_EVENT4 ?>/",
                    data: "fil_id="+$("#fil_id").val(),
                    success: function(msg){
                        if(msg=='3'){
                            $('#pass').val("");
                            $('#dialog').dialog('open');
                        }else
                            if(msg=='1' || msg=='2'){
                                $('#fil_id_open').val($("#fil_id").val());
                                $('#pass_open').val('');
                                $('#formArchivo').submit();
                            }else{
                            alert(msg);
                        }
                    }
                });
						 
            }else alert("Seleccione un registro");
        }
    }		

</script>

</div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
    <a href="#" class="byLogos" title="Desarrollado por ITeam business technology">Desarrollado por ITeam business technology</a>
</div>
</div>
</body>
</html>