<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="es" />
        <meta name="robots" content="all" />
        <meta name="author" content="ITeam" />
        <meta name="copyright"
              content="MMAyA" />
        <meta name="category" content="General" />
        <meta name="rating" content="General" />
        <title>SISTEMA DE ARCHIVO DIGITAL</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo $PATH_WEB ?>/css/impresora.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $PATH_WEB ?>/css/impresora.css" media="print" />
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/jquery-1.3.2.js"></script>
        <script language="Javascript">
            <!--
            function doPrint(){
                document.getElementById("factory").portrait = false;
                document.getElementById("factory").printing.header = " ";
                document.getElementById("factory").printing.footer = " ";
                document.getElementById("factory").printing.topMargin = 0.4;
                document.getElementById("factory").printing.bottomMargin = 0.4;
                document.getElementById("factory").printing.leftMargin = 1;
                document.getElementById("factory").printing.rightMargin = 0.4;
                document.getElementById("factory").printing.Print(false);
                /*window.frames["nombredelframe"].print();
        document.getElementById("impresion").print();*/
            }
            //--></script>
        <object id="factory"
                classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="<?php echo $PATH_WEB ?>/smsx.cab#Version=6,3,434,26">
        </object>
        <input name=idPrint type=button value="Imprimir" onclick="doPrint()">
            <script>
                jQuery(document).ready(function($) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $PATH_DOMAIN ?>/etiqexpediente/imprimirFolder/",
                        data: "ser_id=folder",
                        dataType: 'json',
                        success: function(dataj){
                            var total = dataj.total;
                            $("#num").val(dataj.num);
                            $("#anio").val(dataj.anio);
                            $("#windowFolder").html("");
                            jQuery.each(dataj.rows, function(m,item){
                                //alert(item);
                                //$("#tFolder").html("");
                                //jQuery.each(row, function(i,item){
                                $("#tFolder #direccion").html(item.direccion);
                                $("#tFolder #unidad").html(item.unidad);
                                $("#tFolder #serie").html(item.serie);
                                $("#tFolder #exp_codigo").html(item.exp_codigo);
                                $("#tFolder #exp_nombre").html(item.exp_nombre);
                                $("#tFolder #fextremas").html(item.fextremas);
                                $("#tFolder #nro").html(item.nro);
                                $("#tFolder #gestion").html(item.gestion);
                                $("#tFolder #institucion").html(item.institucion);
                                obj = $("#tFolder").html()+"<hr />";
                                //alert(obj);
                                $("#windowFolder").append(obj);
                                //});
                            });
                            $("#tFolder").html('');
                        },
                        error: function(msg){
                            alert(msg);
                        }
                    });
                });
            </script>
    </head>
    <body id="impresion">
        <div class="clear"></div>
        <div id="windowFolder">
        </div>
        <div  id="tFolder">
            <table width="568" border="0" class="folder" >
                <tr>
                    <td width="102"><img src="<?php echo $PATH_WEB ?>/img/escudo.png" /><br />
                        <span id="institucion"></span>
                    </td>
                    <td width="295"><br />
                        <br />
                        Serie:<span id="serie"></span></td>
                    <td width="157">
                        <table width="157" height="65" border="1">
                            <tr>
                                <td>Nro: <span id="nro"></span></td>
                            </tr>
                            <tr>
                                <td>Gesti&oacute;n: <span id="gestion"></span></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td>Direcci&oacute;n: <span id="direccion"></span></td>
                    <td colspan="2">Titulo: <span id="exp_nombre"></span></td>
                </tr>
                <tr>
                    <td>Unidad:<span id="unidad"></span></td>
                    <td>Fecha extremas: <span id="fextremas"></span></td>
                    <td>Codigo: <span id="exp_codigo"></span></td>
                </tr>
            </table>
        </div>
    </body>
</html>
