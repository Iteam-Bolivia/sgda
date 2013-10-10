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
        <link href="<?php echo $PATH_WEB ?>/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $PATH_WEB ?>/css/flexigrid/flexigrid.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $PATH_WEB ?>/css/base/ui.all.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/jquery-1.3.2.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.core.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.draggable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.droppable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.position.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.resizable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.stackfix.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.dialog.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/ui/jquery.effects.core.js"></script>	
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/validable.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/flexigrid.js"></script>
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/jquery.PrintArea.js"></script>   
        <script type="text/javascript" src="<?php echo $PATH_WEB ?>/js/personalizados.js"></script>    

    </head>

    <body>
        <div class="clear"></div>
        <table width="705" height="80" border="0" >
            <tr>
                <td width="111" rowspan="2"><img src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png" width="159" height="50" /></td>
                <td width="361">Procedencia:<span id="procedencia">111</span></td>
                <td width="157" rowspan="2" bordercolor="#999999" >
                    <table width="157" height="65" border="1">
                        <tr>
                            <td>Nro:<span id="nro"></span></td>
                        </tr>
                        <tr>
                            <td>U.T.:<span id="ut"></span></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td>Serie:<span id="serie"></span></td>
            </tr>
            <tr>
                <td>Direccion:<span id="direccion"></span></td>
                <td colspan="2">Titulo:<span id="titulo"></span></td>
            </tr>
            <tr>
                <td>Unidad:<span id="unidad"></span></td>
                <td>Fecha extremas:<span id="fextremas"></span></td>
                <td>Codigo:<span id="codigo"></span></td>
            </tr>
        </table>
        <hr />
        </div>
        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="B" style="display:none;">
            <table width="705" height="80" border="0">
                <tr>
                    <td width="111">&nbsp;</td>
                    <td width="361" align="center"><p><img src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png" width="159" height="50" /></p>
                        <p>ARCHIVO DE OFICINA</p>
                        <p>DCOR2/UCOD6</p></td>
                    <td width="157" bordercolor="#999999" >&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">Serie: <span id="serie"></span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table width="687" border="1">
                            <tr id="xField">
                                <td width="30">Nro.</td>
                                <td width="640" colspan="2">Titulo:</td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr><td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td></tr>
                <tr>
                    <td colspan="3" align="center">Carpeta Nro: 5</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">UT: 1</td>
                </tr>
            </table>
            <hr />
        </div>
        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="C" style="display:none;">
            <table width="705" height="80" border="0">
                <tr>
                    <td width="111">&nbsp;</td>
                    <td width="361" align="center"><p><img src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png" width="159" height="50" /></p>
                        <p>ARCHIVO DE OFICINA</p>
                        <p>DCOR2/UCOD6</p></td>
                    <td width="157" bordercolor="#999999" >&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">Serie: <span id="serie"></span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table width="688" border="1">
                            <tr id="xField">
                                <td width="30">Nro.</td>
                                <td width="331">Titulo:</td>
                                <td width="100">Codigo:</td>
                                <td width="199">Fecha extremas:</td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr><td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td></tr>
                <tr>
                    <td colspan="3" align="center">Carpeta Nro: 5</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">UT: 1</td>
                </tr>
            </table>
            <hr />
        </div>      
        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="D" style="display:none;">
            <table width="705" height="80" border="0">
                <tr>
                    <td width="111">&nbsp;</td>
                    <td width="361" align="center"><p><img src="file:///C|/AppServ/www/1.8a2/themes/base/images/ui-icons_454545_256x240.png" width="159" height="50" /></p>
                        <p>ARCHIVO DE OFICINA</p>
                        <p>DCOR2/UCOD6</p></td>
                    <td width="157" bordercolor="#999999" >&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">Serie: <span id="serie"></span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table width="688" border="1">
                            <tr id="xField">
                                <td width="30">Nro.</td>
                                <td width="239">Titulo</td>
                                <td width="94">Codigo</td>
                                <td width="193">Fecha extremas</td>
                                <td width="98">Cubierta</td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr><td colspan="3" align="center">Fecha extremas: <span id="fextremas"></span></td></tr>
                <tr>
                    <td colspan="3" align="center">Carpeta Nro: 5</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">UT: 1</td>
                </tr>
            </table>
            <hr />
            <script type="text/javascript">
                jQuery(document).ready(function($) {

                });	
            </script>
    </body>
</html>
