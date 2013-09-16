<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>
<div class="clear"></div>
<p>
<table id="flex1" style="display: none"></table>
</p>
<div class="clear"></div>
<form id="formA" name="formA" method="post" class="validable" 
      action="<?php echo $PATH_DOMAIN ?>/cotransferencia/<?php echo $PATH_EVENT ?>/">
    <input name="str_id" id="trn_id" type="text" value="<?php echo $str_id; ?>" />
</form>

<script type="text/javascript">
    
    $("#flex1").flexigrid
    ({
        url: '<?php echo $PATH_DOMAIN ?>/cotransferencia/load/',
        dataType: 'json',
        colModel : [
            {display: 'ID' , name : 'str_id', width : 40, sortable : true, align: 'center'},            
            {display: 'Fecha', name : 'str_fecha', width : 80, sortable : true, align: 'left'},
            {display: 'Unidad', name : 'uni_descripcion', width : 120, sortable : true, align: 'left'},
            {display: 'Usuario', name : 'usu_nombres', width : 120, sortable : true, align: 'left'},
            {display: 'Nro. Cajas', name : 'str_nrocajas', width : 80, sortable : true, align: 'right'},
            {display: 'Total Pzas.', name : 'str_totpzas', width : 80, sortable : true, align: 'right'},
            {display: 'Total ML', name : 'str_totml', width : 80, sortable : true, align: 'right'},
            {display: 'Nro.Registro', name : 'str_nroreg', width : 80, sortable : true, align: 'right'},
            {display: 'Fecha Inicial', name : 'str_fecini', width : 80, sortable : true, align: 'left'},
            {display: 'Fecha Final', name : 'str_fecfin', width : 80, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Confirmar', bclass: 'accept', onpress : test},
            {name: 'Ver expedientes', bclass: 'view', onpress : test},
        ],
        searchitems : [
            {display: 'Id', name : 'str_id', isdefault: true},
            {display: 'Fecha', name : 'str_fecha'},
            {display: 'Unidad', name : 'uni_descripcion'},
            {display: 'Usuario', name : 'usu_nombres'},
            {display: 'Nro. Cajas', name : 'str_nrocajas'},
            {display: 'Total Pzas.', name : 'str_totpzas'},
            {display: 'Total ML', name : 'str_totml'},
            {display: 'Nro.Registro', name : 'str_nroreg'},
            {display: 'Fecha Inicial', name : 'str_fecini'},
            {display: 'Fecha Final', name : 'str_fecfin'},
        ],
        sortname: "str_id",
        sortorder: "asc",
        usepager: true,
        title: '<?php echo $titulo ?>',
        useRp: true,
        rp: 15,
        minimize: <?php echo $GRID_SW ?>,
        showTableToggleBtn: true,
        width: "100%",
        height: 200
    });
    
    
    
    function dobleClik(grid){
        if($('.trSelected div',grid).html()){
            $("#str_id").val($('.trSelected div',grid).html());
            if($("table",grid).attr('id')=="flex1"){
                window.location ="<?php echo $PATH_DOMAIN ?>/cotransferencia2/index/"+$('.trSelected div',grid).html()+"/";
                //location.href="<?php //echo $PATH_DOMAIN ?>/cotransferencia/viewTree/"+$('.trSelected div',grid).html()+"/";						
            }
        }
    }
    
    function test(com,grid)
    { var id=0;
        if(com=="Ver expedientes"){                        
            if($('.trSelected',grid).html())
            {	 
                $("#str_id").val($('.trSelected div',grid).html());
                id = $('.trSelected div',grid).html();
           
          window.location.href ="<?php echo $PATH_DOMAIN ?>/cotransferencia/listado/"+id+"/";
                
            }
            else $.msgbox("Por favor, seleccione una lista");           
            
            
            
        }
        if(com=="Confirmar"){
              if($('.trSelected',grid).html())
              {
              id = $('.trSelected div',grid).html();   
            var url="<?php echo $PATH_DOMAIN."/cotransferencia/recarga/";?>";  
            $("#recarga").load(url,{valor:id});
                $(".pReload",".flexigrid").click();    
            }else{
            $.msgbox("Por favor, seleccione una lista"); 
            }
        
        }
        
    }
</script>
<div id="recarga"></div>