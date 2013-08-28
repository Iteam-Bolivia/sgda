
<div class="clear"></div>
<p><table id="flex1" style="display:none"></table></p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/cotransferencia/<?php echo $PATH_EVENT ?>/">
    
    <input name="str_id" id="str_id" type="hidden" value="<?php echo $str_id; ?>" />
    <input name="serie" id="idcom" type="hidden" value="" />
    <input name="ids" id="ids" type="text" value="" />
    
    
    
<!--    <table align="center" class="tDatos" width="100%" border="0">
    
        <tr>
            <th colspan="4">Datos de la Transferencia</th>
        </tr>
        <tr>
            <td width="160">
                <strong>Fecha:</strong>
            </td>
            <td width="361"><?php //echo $trn_fecha_crea; ?></td>
                       
        </tr>
        
        <tr>
            <td><strong>Unidad Origen:</strong></td>
            <td><?php //echo $unidad; ?></td>
            
            
        </tr>
        
        <tr>
            <td><strong>Usuario Origen:</strong></td>
            <td><?php //echo $usuario; ?></td>
            <td><strong>Usuario Destino:</strong></td>
            <td><?php //echo $usu_destino ?></td>
        </tr>
        <tr>
            <td><strong>Motivo:</strong></td>
            <td colspan="3"><?php //echo $trn_descripcion ?></td>
        </tr>
        
        
        <tr>
            <th colspan="4">Expedientes Transferidos</th>
        </tr>
        <tr><td colspan="4">
                <?php //if ($tree != ""): ?>
                    <ul id="menuarch">
                        <?php //echo $tree ?>
                    </ul>
                <?php //else: ?>
                    No existen archivos en este expediente.
                <?php //endif; ?>
            </td>
        </tr>
        
        
    </table>    -->
    
    
    
</form>



<script type="text/javascript">

    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cotransferencia/loadExp/',
        dataType: 'json',
        colModel : [
            {display: 'ID' , name : 'exp_id', width : 40, sortable : true, align: 'center'},            
            {display: '', name : 'exp_chk', width : 20, sortable : true, align: 'center'},            
            {display: 'C&oacute;digo', name : 'exp_codigo', width : 120, sortable : true, align: 'left'},
            {display: 'Serie', name : 'ser_categoria', width : 250, sortable : true, align: 'left'},
            {display: 'Nombre', name : 'exp_titulo', width : 450, sortable : true, align: 'left'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi', width : 60, sortable : true, align: 'center'},
            {display: 'Fecha Final', name : 'exp_fecha_exf', width : 60, sortable : true, align: 'center'}
//            {display: 'Custodio', name : 'custodios', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Transferir', bclass: 'view', onpress : test}
        ],
        searchitems : [
            {display: 'Id', name : 'exp_id'},
            {display: 'Serie', name : 'ser_categoria', isdefault: true},
            {display: 'C&oacute;digo', name : 'exp_codigo'},
            {display: 'Serie', name : 'ser_categoria'},
            {display: 'Nombre', name : 'exp_titulo'},
            {display: 'Fecha Inicio', name : 'exp_fecha_exi'},
            {display: 'Fecha Final', name : 'exp_fecha_exf'}
            //{display: 'Custodio', name : 'custodio'}
        ],
        sortname: "exp_fecha_exf",
        sortorder: "desc",
        usepager: true,
        title: 'TITULO',
        useRp: true,
        rp: 10,
        minimize: '<?php echo $GRID_SW ?>',
        showTableToggleBtn: true,
        width: "100%",
        height: 320
    });
     
</script>