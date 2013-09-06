<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<div align="left"><a href="<?php echo $PATH_DOMAIN ?>/prestamos/"><img src="<?php echo $PATH_WEB ?>/img/back.png"></a>
</div>
    <div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>

<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/prestamos/<?php echo $PATH_EVENT ?>/">
    <input name="spr_id" id="spr_id" type="hidden" value="<?php echo $spr_id; ?>" />
</form>


<script type="text/javascript">
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/prestamos/gridprestamo/',
        dataType: 'json',
        colModel : [
            {display: 'Id', name : 'spr_id', width : 25, sortable : true, align: 'center'},            
        {display: 'Fecha de Registro', name : 'spr_fecha', width : 130, sortable : true, align: 'left'},        
        {display: 'Solicitante', name : 'spr_solicitante', width : 155, sortable : true, align: 'left'},        
        {display: 'Autoriza', name : 'usua_id', width : 155, sortable : true, align: 'left'},        
        {display: 'Fecha de Entrega', name : 'spr_fecent', width : 130, sortable : true, align: 'left'},
        {display: 'Fecha de Vencimiento', name : 'spr_fecdev', width : 130, sortable : true, align: 'left'},
        {display: 'Correo', name : 'spr_email', width : 130, sortable : true, align: 'left'},
        {display: 'Télefono', name : 'spr_tel', width : 80, sortable : true, align: 'left'},
        {display: 'Observación', name : 'spr_obs', width : 275, sortable : true, align: 'left'},
          ],
        buttons : [
            //{name: 'Adicionar', bclass: 'add', onpress : test},
            {name: 'Devolver', bclass: 'devolt', onpress : test},
            {separator: true},
            {name: 'Reporte', bclass: 'pdf', onpress : test},
        ],
        searchitems : [
         
            {display: 'Solicitante', name : 'spr_solicitante'},
            {display: 'Correo', name : 'spr_email'},
            {display: 'Observación', name : 'spr_obs'}
        ],
        sortname: "spr_id",
        sortorder: "asc",
        usepager: true,
        title: 'LISTA DE PRESTAMOS',
        useRp: true,
        rp: 10,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 250
    });


    function dobleClik(grid){
     if($('.trSelected div',grid).html())
        {
            $("#spr_id").val($('.trSelected div',grid).html());
           var valor=$('.trSelected div',grid).html();
           alert(valor);/*
   $("#mostrar").dialog({
      height: 300,
      width: 350,
      modal: true
    });
     document.getElementById("mostrar").innerHTML="la id era:"+valor;*/
        }
    }
    
    function test(com,grid)
    {
      if (com=='Eliminar')
        {
            $.post("<?php echo $PATH_DOMAIN ?>/rol/findReg/",{rol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                if(data != true){
                    if($('.trSelected div',grid).html()){
                        if(confirm('Esta seguro de eliminar el registro ' + $('.trSelected div',grid).html() + ' ?'))
                            $.post("<?php echo $PATH_DOMAIN ?>/rol/delete/",{rol_id:$('.trSelected div',grid).html(),rand:Math.random() } ,function(data){
                                if(data != true){
                                    $('.pReload',grid.pDiv).click();
                                }
                        });
                    }
                    else{
                        alert("Seleccione un registro");
                    }
                }else{
                    alert("No se puede eliminar el registro");
                }
            });
        }
        else if (com=='Devolver')
        {
          if($('.trSelected div',grid).html()){
                $("#spr_id").val($('.trSelected div',grid).html());
  $.msgbox("Confirmar la devolución?",{
  type: "confirm",
  buttons : [
    {type: "submit", value: "Yes"},
    {type: "submit", value: "No"}
  ]
}, function(result) {
  if (result=="Yes") {
               var id=$('.trSelected div',grid).html();
                
            var url2="<?php echo $PATH_DOMAIN ?>/prestamos/returnprestamo/";
          $("#mostrar").load(url2,{id_prestamo:id});
          $(".pReload",".flexigrid").click();
       
  }
});
        
           
                
       
            }
            else{
                $.msgbox("Seleccione un registro especifico");
            }
       }
        else if (com=='Editar'){
            if($('.trSelected div',grid).html()){
                $("#spr_id").val($('.trSelected div',grid).html());
                
                var id=$('.trSelected div',grid).html();
                
            var url="<?php echo $PATH_DOMAIN ?>/prestamos/editprestamo/"+id+"/";
           
           
           
     jQuery.lightbox(url,{
        'width'       : 390,
        'height'      : 290,
        'autoresize'  : false,
      }  
	  );
             // $(".pReload",".flexigrid").click();
            }
            else{
                $.msgbox("Seleccione un registro especifico");
            }
        }
           else if (com=='Reporte'){
            if($('.trSelected div',grid).html()){
                $("#spr_id").val($('.trSelected div',grid).html());
                
     var id=$('.trSelected div',grid).html();          
    window.location.href="<?php echo $PATH_DOMAIN ?>/prestamos/verRpte_prestamo/"+id+"/";
     // window.location.href="<?php echo $PATH_DOMAIN ?>/prestamos/verRpte_prestamo/";
     
                // $(".pReload",".flexigrid").click();
            }
            else
            {
                $.msgbox("Seleccione un registro especifico");
            }
        }
        
        
    }
    
</script>
<script languaje="javascript">
$(document).ready(function(){

})
</script>
<div id="mostrar"></div>

