
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/buscarArchivo/<?php echo $PATH_EVENT ?>/">
    <table width="100%" border="0">
        <caption class="titulo">BUSCAR EXPEDIENTE</caption>
        <tr>
            <td colspan="4">Llene los campos para restringir la b&uacute;squeda.</td>
        </tr>
        <tr>
            <td width="245">Cod.Expediente:</td>
            <td width="238"><input name="exp_codigo" type="text" id="exp_codigo"
                                   value="" size="20" autocomplete="off" maxlength="20"
                                   class="alphanum" title="C&oacute;digo del Expediente" />
                <input type="hidden" value="" name="fil_ids" id="fil_ids"  />
                <input type="hidden" value="0" name="sw" id="sw"  />
            </td>
            <td width="206">Serie:</td>
            <td width="250">
                <select name="ser_id" id="ser_id" title="Serie" >
                    <option value="">- -</option>
                    <?php echo $series; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Expediente:</td>
            <td colspan="3"><input name="exp_nombre" type="text" id="exp_nombre"
                                   value="" size="70" autocomplete="off" maxlength="255"
                                   class="alphanum" title="Nombre del Expediente" /></td>
        </tr>
        <tr>
            <td>Tr&aacute;mite:</td>
            <td colspan="3">
                <select name="tra_id" id="tra_id" autocomplete="off" title="Tr&aacute;mite" style="width:300px;" />
        <option value="">- -</option>
        <?php echo $tramites; ?>
        </select>
        </td>
        </tr>
        <tr>
            <td>Cuerpo:</td>
            <td colspan="3">
                <select name="cue_id" id="cue_id" autocomplete="off" title="Cuerpo" style="width:300px;" />
        <option value="">- -</option>
        <?php echo $cuerpos; ?>
        </select>
        </td>
        </tr>
        <tr>
            <td colspan="2">Fecha Extrema Inicial:  
                <input name="exf_fecha_exi" type="text" id="exf_fecha_exi" 
                       value="" size="15" autocomplete="off" maxlength="10" title="exf_fecha_exi" /></td>
            <td colspan="2">Fecha Extrema Final: &nbsp;
                <input name="exf_fecha_exf" type="text" id="exf_fecha_exf" 
                       value="" size="15" autocomplete="off" maxlength="10" title="exf_fecha_exf" /></td>
        </tr>
        <tr>
            <td>Instituci&oacute;n:</td>
            <td><?php echo $institucion; ?>
                <input id="institucion" name="institucion" type="hidden" value="<?php echo $ins_id; ?>" />
            </td>
            <td>Lugar:</td>
            <td><select name="lugar" type="text" id="lugar" title="Lugar de ubicaci&oacute;n del Archivo.">
                    <option value="">- -</option>
                    <?php echo $lugar; ?>
                </select></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td class="botones" colspan="4">
                <!--<input id="paginas" name="paginas" type="hidden" value="<?php echo $paginas; ?>" />
                <input id="page" name="page" type="hidden" value="<?php echo $page; ?>" />
                <input id="rp" name="rp" type="hidden" value="<?php echo $rp; ?>" />
                <input id="sortname" name="sortname" type="hidden" value="<?php echo $sortname; ?>" />
                <input id="sortorder" name="sortorder" type="hidden" value="<?php echo $sortorder; ?>" />
                <input id="total" name="total" type="hidden" value="<?php echo $total; ?>" />-->
                <input id="btnClear" type="button" value="Limpiar" class="button"/>
                <input id="btnSubB" type="button" value="Buscar" class="button"/></td>
        </tr>
    </table>
</form>
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>
<script type="text/javascript">

    $("#flex1").flexigrid({
        url: '<?php echo $PATH_DOMAIN ?>/buscarExpediente/search/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'exp_id', width : 40, sortable : true, align: 'center'},
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 100, sortable : true, align: 'left'},
            {display: 'Expediente', name : 'exp_nombre', width : 150, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 150, sortable : true, align: 'left'},
            {display: 'Lugar', name : 'fon_descripcion', width : 100, sortable : true, align: 'center'},
            {display: 'Contenedor', name : 'contenedor', width : 150, sortable : true, align: 'left'}],
        sortname: "exp_id",
        sortorder: "asc",
        usepager: true,
        title: 'Resultado de la B&uacute;squeda',
        useRp: true,
        rp: 10,
        minimize: false,
        showTableToggleBtn: true,
        width: 687,
        height: 260,
        exp_codigo: "",
        ser_id: "",
        exp_nombre: "",
        tra_id: "",
        cue_id: "",
        exf_fecha_exi: "",
        exf_fecha_exf: "",
        institucion: "",
        lugar: ""
    });

</script>

<div class="clear"></div>

<script type="text/javascript">	
    $(document).ready(function() {		
        
        $('#exf_fecha_exf').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']

        });
        $('#exf_fecha_exi').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        $("#btnSubB").click(function(){
            $(".pReload",".flexigrid").click();
        });
        $("#btnClear").click(function(){
            $("#exp_codigo").val('');
            $("#ser_id").val('');
            $("#exp_nombre").val('');
            $("#tra_id").val('');
            $("#cue_id").val('');
            $("#exf_fecha_exi").val('');
            $("#exf_fecha_exf").val('');
            $("#archivo").val('');
            $("#fil_descripcion").val('');
            $("#institucion").val('');
            $("#lugar").val('');
            $(".pReload",".flexigrid").click();
        });
    });
</script>

