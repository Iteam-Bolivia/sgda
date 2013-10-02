<link href="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
<script languaje="javascript" type="text/javascript" src="<?php echo $PATH_WEB ?>/js/javascript/msgbox/jquery.msgbox.js"></script>

<form id="formA" name="formA" method="post" class="validable" action="<?php echo $PATH_DOMAIN ?>/reportePrestamos/<?php echo $PATH_EVENT ?>/" target="_blank">

    <table width="100%" border="0" style="padding-bottom: 20px">
        <caption class="titulo">
            LISTADO DE PRESTAMOS
        </caption>
        
        <tr>
            <th>Fecha de Prestamo:</th>
            <td>
                desde:
                <input type="text" name="f_prestdesde" id='f_prestdesde' class="required"/>
                <span class="error-requerid">*</span>
                hasta:
                <input type="text" name="f_presthasta"  id='f_presthasta' class="required"/>
                   <span class="error-requerid">*</span>
            </td>
        </tr>
   <tr>
            <th><br>Archivo:</th>
            <td><br>
                <select name="tipo">
                    <option value="1">Pdf</option>
                    <option value="2">Excel</option>
                </select>
            </td>
        </tr>
        </tr>

        <tr>
            <td class="botones" colspan="2">
                <input id="btnSub" type="submit" value="Reporte" class="button"/>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">

    jQuery(document).ready(function($) {

        $('#f_prestdesde').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                $.msgbox("La fecha final debe ser superior a la fecha inicial.");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').change(function(){
            if($('#f_presthasta').val()<$('#f_prestdesde').val()){
                $.msgbox("La fecha final debe ser superior a la fecha inicial.");
                $('#f_presthasta').val($('#f_prestdesde').val());
            }
        });
        $('#f_presthasta').datepicker({//jquery
            changeMonth: true,
            changeYear: true,
            yearRange:'c-5:c+10',
            dateFormat: 'yy-mm-dd',
            //			minDate: $('#exp_fecha_exi').val(),//'+10D',
            //            maxDate: '+10Y',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                'May', 'Jun', 'Jul', 'Ago',
                'Sep', 'Oct', 'Nov', 'Dic']
        });
        $('#f_prestdesde').datepicker({
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
    });
</script>
<script languaje="javascript">
            jQuery(document).ready(function($) {  
                $("form.validable").bind("submit", function(e){
                    var post = "";
                    if (typeof filters == 'undefined') return;
                    $(this).find("input, textarea, select").each(function(x,el){
                        if ($(el).attr("className") != 'undefined') { 
                            $(el).removeClass("req");
                            $.each(new String($(el).attr("className")).split(" "), function(x, klass){
                                if ($.isFunction(filters[klass])){
                                    if (!filters[klass](el)){
                                        $(el).addClass("req");
                                        var idName = $(el).attr("name");
                                        $("#e_"+idName).fadeIn(800);
                                    }else{
                                        var idName = $(el).attr("name");
                                        if(post==''){
                                            post = idName + "=" + $(el).val();
                                        }else{
                                            post = post + "&"+idName + "=" + $(el).val();
                                        }
									
                                    }
                                }	
                            });
                        }
                    });
                    if ($(this).find(".req").size() > 0) {
                        $.stop(e || window.event);
                        return false;
                    }
                    return true;
                }); 
                // on focus	remueve los tag de error
                $("form.validable").find("input, textarea, select").each(function(x,el){ 
                    $(el).bind("focus",function(e){
                        if ($(el).attr("className") != 'undefined') { 
                            $(el).removeClass("req");
                            var idName = $(el).attr("name");
                            $("#e_"+idName).fadeOut(800);
                        }
                    });
                });
                /* para el acordeon */
		
                $(".pagClik").click(function(){
                    if($("."+$(this).attr('id')+"x").is(':visible')){
                        $("."+$(this).attr('id')+"x").hide();
                    }else{
                        $("."+$(this).attr('id')+"x").slideDown();
                    }
                });
                $("#menuarch a").click(function(){
                    var d = $(this).attr('di');
                    if($("."+d+"a").is(':visible')){
                        $("."+d+"a").hide();
                    }else{
                        $("."+d+"a").slideDown();
                    }
                });        
                $(".suboptAct").click(function(){
                    if($("#"+$(this).attr('id')+"x").is(':visible')){
                        $("#"+$(this).attr('id')+"x").hide();
                    }else{
                        $("#"+$(this).attr('id')+"x").slideDown();
                    }
                });
                $(".suboptAct").dblclick(function(){
                    location.href = $(this).attr('href');
                });
                // end	
                $("#menu4 dt a").click(function(){
                    var id = $(this).attr('id');
                    $("#menu4 dl").each(function(x,el){
                        if($("dt a",this).attr('id')==id){
                            if($(this).attr('class')=='Act'){
                                $(this).removeClass('Act');
                            }else{
                                $(this).attr('class','Act');
                            }
                        }						
                    });
                });
            })
	
        </script>
