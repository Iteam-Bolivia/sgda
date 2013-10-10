<div class="clear"></div>
<?php echo $tituloEstructura; ?>
<p align="left"><?php echo $linkTree; ?></p>
<form id="formA" name="formA" method="post" class="validable" style="<?php echo $FORM_SW ?>" action="<?php echo $PATH_DOMAIN ?>/estrucDocumental/<?php echo $PATH_EVENT ?>/">
    <input name="exp_id" id="exp_id" type="hidden" value="<?php echo $exp_id; ?>" />
</form>

<div id="contentIn">
    <p>&nbsp;
    <ul class="listServ">
        <li>
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addField/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/" class="bold2" alt="Subir o Digitalizar Archivos" title="Subir o Digitalizar Archivos">Subir o Digitalizar Archivos</a><br />
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addField/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/"><img src="<?php echo $PATH_WEB ?>/lib/title05.png" alt="Subir o Digitalizar Archivos" title="Subir o Digitalizar Archivos" class="imgPrin" /></a>
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addField/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/" class="viewMore">Adicionar</a>
        </li>
        <li class="noMargin">
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addCC/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/" class="bold2" alt="Adicionar Correspondencia" title="Adicionar Correspondencia">Adicionar Correspondencia</a><br />
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addCC/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/"><img src="<?php echo $PATH_WEB ?>/lib/title05.jpg" alt="Adicionar Correspondencia" title="Adicionar Correspondencia" class="imgPrin" /></a>
            <a href="<?php echo $PATH_DOMAIN ?>/<?php echo $VAR1 ?>/addCC/<?php echo $VAR3 ?>/<?php echo $VAR4 ?>/<?php echo $VAR5 ?>/" class="viewMore">Adicionar</a>
        </li>
    </ul>

</p>
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("#cancelar").click(function(){
            if($("#formA").is(":visible")){
                $("#formA").hide();
                //$(".flexigrid").attr('class','flexigrid');
                window.location="<?php echo $PATH_DOMAIN ?>/estrucDocumental/";
            }else{
                $("#formA").show();				
            }
        });
    });			

</script>