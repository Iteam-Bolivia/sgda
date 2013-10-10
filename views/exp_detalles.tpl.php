<?php echo $tituloEstructura; ?>
<span class="left"><?php echo $linkTree; ?></span>
<table align="center" class="tDatos" width="100%" border="0">
    <tr>
        <th colspan="4">Detalles del Expediente</th>
    </tr>
    <tr>
        <td width="159"><strong>Series:</strong></td>
        <td width="249"><a
                href="<?php echo $PATH_DOMAIN ?>/<?php echo $controller ?>/"><?php echo utf8_decode($serie); ?></a></td>
        <td width="198">&nbsp;</td>
        <td width="342">&nbsp;</td>
    </tr>
    
<!--    <tr>
        <td><strong>Unidad de Instalaci&oacute;n:</strong></td>
        <td><?php //echo $ubicacion; ?></td>
    </tr>-->
    
        <?php echo $detExpediente ?>
    <tr>
        <th colspan="4">TIPOS DOCUMENTALES Y DOCUMENTOS (Documento digital): </th>
    </tr>
</table>
