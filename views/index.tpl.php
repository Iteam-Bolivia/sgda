<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="language" content="es" />
        <meta name="robots" content="all" />
        <meta name="author" content="ITEAM" />
        <meta name="copyright" content="MMAyA" />
        <meta name="category" content="General" />
        <meta name="rating" content="General" />
        <title>SISTEMA DE ARCHIVO DIGITAL</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="<?php echo $PATH_WEB; ?>/css/style.css" rel="stylesheet"
              type="text/css" />
    </head>

    <body>
        <div id="wrapper">
            <div id="header"><a href="#" class="logo">SISTEMA DE ARCHIVO DIGITAL</a>
                <a href="#" class="logot bold2">SISTEMA DE ARCHIVO DIGITAL</a></div>
            <center>
                <div id="containerLogin">
                    <div id="error"><?php echo $observaciones; ?></div>
                    <form method="post"
                          action="<?php echo $PATH_DOMAIN; ?>/<?php echo $PATH_EVENT; ?>/">
                        <table border="0" align="center" id="login">
                            <tr>
                                <th colspan="2" align="center"><img
                                        src="<?php echo $PATH_DOMAIN; ?>/web/lib/user.gif" /></th>
                            </tr>
                            <tr>
                                <td><label>Usuario:</label></td>
                                <td><input type="text" size="20" name="user" autocomplete="off"/></td>
                            </tr>
                            <tr>
                                <td><label>Contrase&ntilde;a:</label></td>
                                <td><input type="password" size="20" name="pass" /></td>
                            </tr>
                            <tr>
                                <input type="hidden" name="exn_id" value="">
                                    <td class="botones" colspan="2"><input type="submit" value="Aceptar"
                                                                           class="button" name="Enviar" /> <input type="reset" value="Cancelar"
                                                                           class="button" name="Enviar" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </center>
            <div id="footer"><a href="#" class="byLogos"
                                title="Desarrollado por ITEAM">Desarrollado por ITeam business
                    technology</a></div>
        </div>
    </body>
</html>
