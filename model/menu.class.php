<?php

/**
 * archivoModel
 *
 * @package
 * @author lic. castellon
 * @copyright ITEAM
 * @version $Id$ 2012
 * @access public
 */
class menu extends Tab_menu {

    function __construct() {
        $this->menu = new Tab_menu ();
    }

    function count($where) {
        $menu = new Tab_menu ();
        $sql = "SELECT count(men_id)
                FROM
                tab_menu AS u
                WHERE
                u.men_estado =  1 $where ";
        $num = $menu->countBySQL($sql);
        return $num;
    }

    function obtenerMenu($parent, $usu_id) {
        $rows = $this->menu->dbSelectBySQL("SELECT
                                            tab_menu.men_id,
                                            tab_menu.men_titulo,
                                            tab_menu.men_enlace
                                            FROM tab_menu
                                            Inner Join tab_usurolmenu ON tab_usurolmenu.men_id = tab_menu.men_id
                                            Inner Join tab_usuario ON tab_usurolmenu.rol_id = tab_usuario.rol_id
                                            WHERE tab_menu.men_estado = '1'
                                            AND tab_menu.men_par = '0'
                                            AND  tab_menu.men_posicion = 'Izquierda'
                                            AND tab_menu.men_id IN (SELECT men_par FROM tab_menu)
                                            AND tab_usurolmenu.rol_id = tab_usuario.rol_id
                                            AND tab_usuario.usu_id='" . $usu_id . "'
                                            AND tab_usurolmenu.urm_estado='1'
                                            ORDER BY tab_menu.men_id ");
        return $rows;
    }

    function obtenerMenuUsuario($parent, $usu_rol) {
        $usuario = $_SESSION["USU_ID"];
        $sql = "SELECT *
                FROM tab_usurolmenu
                Inner Join tab_menu ON tab_menu.men_id = tab_usurolmenu.men_id
                Inner Join tab_usuario ON tab_usurolmenu.rol_id = tab_usuario.rol_id
                WHERE
                tab_menu.men_par =  '" . $parent . "' AND
                tab_menu.men_estado =  '1' AND
                tab_usurolmenu.urm_estado =  '1' AND
                tab_usuario.rol_id =  '" . $usu_rol . "'
                AND tab_usuario.usu_id =  ' " . $usuario . "'
                ORDER BY tab_menu.men_id ";
        
        $rows = $this->menu->dbselectBySQL($sql);
        //tab_usurolmenu.urm_privilegios >=  '1000' AND
        return $rows;
    }

    function obtenerPadreXEnlace($enlace) {
        $sql = "SELECT
                tab_menu.men_id,
                tab_menu.men_titulo,
                tab_menu.men_par,
                tab_menu.men_enlace,
                tab_menu.men_posicion,
                tab_menu.men_estado
                FROM
                tab_menu
                WHERE men_enlace like '%" . $enlace . "'  ";
        $datosMenu = $this->menu->dbSelectBySQL($sql);
        if (isset($datosMenu [0]) && is_object($datosMenu [0]))
            return $datosMenu [0];
        else
            return "";
    }

    function obtenerDatosPadre($men_id) {
        $sql = "SELECT
                tab_menu.men_id,
                tab_menu.men_titulo,
                tab_menu.men_par,
                tab_menu.men_enlace,
                tab_menu.men_posicion,
                tab_menu.men_estado
                FROM
                tab_menu
                WHERE men_id='" . $men_id . "'
                AND men_estado='1'";
        $datosMenu = $this->menu->dbSelectBySQL($sql);
        if (isset($datosMenu [0]) && is_object($datosMenu [0]))
            return $datosMenu [0];
        else
            return "";
    }

    function buscarMenuPadre($idSubMenu, $idRol) {
        $sql = "SELECT
                tab_menu.men_id,
                tab_menu.men_par
                FROM tab_usurolmenu
                Inner Join tab_menu ON tab_usurolmenu.men_id = tab_menu.men_id
                WHERE tab_usurolmenu.rol_id= '" . $idRol . "'
                AND tab_usurolmenu.urm_privilegios >=  '1000'
                AND tab_usurolmenu.men_id = '" . $idSubMenu . "'
                AND tab_menu.men_par IN (SELECT men_id from tab_menu where men_par ='0')) ";
        $row = $this->menu->dbSelectBySQL($sql);
        if (count($row))
            return $row [0]->men_par;
        else
            return "";
    }

    function isHijo($enlace) {
        $sql = "SELECT 
                tab_menu.men_id, 
                tab_menu.men_par, 
                tab_menu.men_titulo, 
                tab_menu.men_enlace
                FROM tab_menu
                WHERE tab_menu.men_id IN (SELECT men_par FROM tab_menu WHERE men_enlace like '%" . $enlace . "')";
        $datosMenu = $this->menu->dbSelectBySQL($sql);
        if (count($datosMenu))
            return $datosMenu [0]->men_id;
        else
            return "";
    }

    function imprimirMenu($seleccionado = '', $usuId = '') {
        $liMenu = "";
        $menu = new menu ();
        $urm = new usurolmenu ();
        $parent = '0';
        $swMenu = 0;
        $swSubMenu = 0;
        if ($usuId != null || $usuId != "") {
            $usuario = new Tab_usuario ();
            $rolUsu = $usuario->dbSelectBySQL("SELECT 
                                               usu_id, 
                                               rol_id 
                                               FROM tab_usuario 
                                               WHERE usu_id='" . $usuId . "' ");
            // Method obtenerMenu
            $arrayMenus = $menu->obtenerMenu($parent, $usuId);
            foreach ($arrayMenus as $menus) {
                $arraySubmenus = $menu->obtenerMenuUsuario($menus->men_id, $rolUsu[0]->rol_id);
                $id_urm = $urm->obtenerPermisosArchivosUsuarios($menus->men_id, $usuId);
                $classMenu = '';
                $classAct = '';
                if ($seleccionado != "") {
                    $padre = $menu->obtenerPadreXEnlace($seleccionado);
                    if (is_object($padre) && $padre->men_par == $menus->men_id) {
                        $classMenu = ' class="pagAct" ';
                        $classAct = ' class="Act" ';
                    } elseif ($menus->men_id == $menu->isHijo("plandesastre") && $seleccionado == "cronoact") {
                        $classMenu = ' class="pagAct" ';
                        $classAct = ' class="Act" ';
                    }
                }
                $liMenu .= '<li>';
                $liMenu .= '<!--[if lte IE 6]><a href="#"><table><tr><td><![endif]-->';
                $liMenu .='<dl' . $classAct . '>';
                $addMenu = '';
                if ($classMenu != "pagAct") {
                    $addMenu .=' class="' . $menus->men_id . 'x" style="display:none;" ';
                }
                $liMenu .='<dt><a href="#" id="' . $menus->men_id . '" onclick="return false;" ' . $classMenu . '> ' . $menus->men_titulo . '</a></dt>';

                /* if ($classMenu == "pagAct") {
                  $liMenu .= "<ul class='submenu_' >\n";
                  } else {
                  $liMenu .= "<ul class='submenu_ ".$menus->men_id."x' style='display:none;' >\n";
                  } */
                foreach ($arraySubmenus as $submenus) {
                    //if(strstr(strtoupper($submenus->men_enlace),strtoupper($seleccionado)) && $seleccionado!="docprevencion")$classSubMenu = "suboptAct";
                    if (strtoupper($seleccionado) == strtoupper($submenus->men_enlace))
                        $classSubMenu = " class='subAct' ";
                    elseif ($menus->men_id == $menu->isHijo("plandesastre") && $seleccionado == "cronoact" && strstr(strtoupper($submenus->men_enlace), strtoupper("plandesastre")))
                        $classSubMenu = " class='subAct' ";
                    else
                        $classSubMenu = "";
                    $id_urm2 = $urm->obtenerPermisosArchivosUsuarios($submenus->men_id, $usuId);
                    $liMenu .= "<dd>" . "<a href='" . PATH_DOMAIN . "/" . $submenus->men_enlace . "/' " . $classSubMenu . ">" . $submenus->men_titulo . "</a></dd>\n";
                    ;
                }

                $liMenu .="</dl><!--[if lte IE 6]></td></tr></table></a><![endif]-->";
                $liMenu .= "</li>\n";
            }
        } else {
            Header("Location: " . PATH_DOMAIN . "/");
        }
        return $liMenu;
    }

    function allMenu() {
        $liMenu = "";
        $rows = $this->menu->dbselectBySQL("SELECT 
                                            tab_menu.men_id, 
                                            tab_menu.men_titulo
                                            FROM tab_menu
                                            WHERE tab_menu.men_par =  '0' 
                                            AND tab_menu.men_estado =  '1'");
        $row1 = 1;
        foreach ($rows as $menus) {
            $liMenu .= "		<tr class='erow'>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 40px;'>" . $menus->men_id . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 375px;'>" . $menus->men_titulo . "</div>";
            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='left' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='left' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='center' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
            $liMenu .= "		</tr>";

            $rowsb = $this->menu->dbselectBySQL("SELECT 
                                                 tab_menu.men_id, 
                                                 tab_menu.men_titulo
						 FROM tab_menu
						 WHERE tab_menu.men_par = '" . $menus->men_id . "' 
                                                 AND tab_menu.men_estado =  '1'");
            $row1 = 1;
            $i = 0;
            foreach ($rowsb as $menusb) {
                $liMenu .= "		<tr " . ($row1 % 2 ? "" : "class='erow'") . ">";
                $liMenu .= "			<input type='hidden' name='id_menu[$i]' value='" . $menusb->men_id . "'>";
                $liMenu .= "			<td align='center' class='sorted'>";
                $liMenu .= "			<div style='text-align: center; width: 40px;'>" . $menusb->men_id . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: left; width: 375px;'>" . $menusb->men_titulo . "</div>";
                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='left'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[$i]' type='checkbox' value='ver'></div>";
//                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='left'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[$i]' type='checkbox' value='add'></div>";
//                $liMenu .= "			</td>";
                $liMenu .= "			<td align='center'>";
                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[$i]' type='checkbox' value='del'></div>";
                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='center'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[$i]' type='checkbox' value='rep'></div>";
//                $liMenu .= "			</td>";
                $liMenu .= "		</tr>";
                $row1++;
                $i++;
            }
        }
        return $liMenu;
    }

    function allMenuSeleccionado($idRol) {
        $liMenu = "";
        $rows = $this->menu->dbselectBySQL("SELECT 
                                            tab_menu.men_id, 
                                            tab_menu.men_titulo
                                            FROM tab_menu
                                            WHERE tab_menu.men_par = '0' 
                                            AND tab_menu.men_estado =  '1'");
        $row1 = 1;
        $i = 0;
        foreach ($rows as $menus) {
            $liMenu .= "		<tr class='erow evenw' id='" . $menus->men_id . "'>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 40px;'>" . $menus->men_id . "</div>";
            $liMenu .= "			</td>";
            $liMenu .= "			<td align='left' class='sorted'>";
            $liMenu .= "			<div style='text-align: left; width: 375px;'>" . $menus->men_titulo . "</div>";
            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='left' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='left' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
            $liMenu .= "			<td align='center' class='sorted'>";
            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
            $liMenu .= "			</td>";
//            $liMenu .= "			<td align='center' class='sorted'>";
//            $liMenu .= "			<div style='text-align: center; width: 50px;'>&nbsp;</div>";
//            $liMenu .= "			</td>";
            $liMenu .= "		</tr>";

            $rowsb = $this->menu->dbselectBySQL("SELECT 
                                                tab_menu.men_id, 
                                                tab_menu.men_titulo
                                                FROM tab_menu
                                                WHERE tab_menu.men_par = '" . $menus->men_id . "' 
                                                AND tab_menu.men_estado =  '1'");

            $row1 = 1;

            foreach ($rowsb as $key => $menusb) {
                $r = 0;
                $w = 0;
                $d = 0;
                $x = 0;
                $chek1 = "";
                $chek2 = "";
                $chek3 = "";
                $chek4 = "";
                $rowChek = $this->menu->dbselectBySQL("SELECT 
                                                        tab_usurolmenu.rol_id, 
                                                        tab_usurolmenu.men_id, 
                                                        tab_usurolmenu.urm_privilegios
							FROM tab_usurolmenu
							WHERE tab_usurolmenu.rol_id =  '" . $idRol . "' 
                                                        AND tab_usurolmenu.men_id =  '" . $menusb->men_id . "' 
                                                        AND tab_usurolmenu.urm_estado=1 ");

                if (count($rowChek) > 0) {

                    $r = substr($rowChek [0]->urm_privilegios, 0, 1);
                    $w = substr($rowChek [0]->urm_privilegios, 1, 1);
                    $d = substr($rowChek [0]->urm_privilegios, 2, 1);
                    $x = substr($rowChek [0]->urm_privilegios, 3, 1);
                    if ($r == 1)
                        $chek1 = "checked";
                    if ($w == 1)
                        $chek2 = "checked";
                    if ($d == 1)
                        $chek3 = "checked";
                    if ($x == 1)
                        $chek4 = "checked";
                }
                //else echo "<br>vacio";

                $liMenu .= "		<tr " . ($row1 % 2 ? "class='" . $menus->men_id . "z'" : "class='erow " . $menus->men_id . "z'") . " style='display:none;'>";
                $liMenu .= "			<input type='hidden' name='id_menu[$i]' value='" . $menusb->men_id . "'>";
                $liMenu .= "			<td align='center' class='sorted'>";
                $liMenu .= "			<div style='text-align: center; width: 40px;'>" . $menusb->men_id . "</div>";
                $liMenu .= "			</td>";
                $liMenu .= "			<td align='left'>";
                $liMenu .= "			<div style='text-align: left; width: 375px;'>" . $menusb->men_titulo . "</div>";
                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='left'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[0]' type='checkbox' value='ver' " . $chek1 . "></div>";
//                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='left'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[1]' type='checkbox' value='add' " . $chek2 . "></div>";
//                $liMenu .= "			</td>";
                $liMenu .= "			<td align='center'>";
                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[2]' type='checkbox' value='del' " . $chek3 . "></div>";
                $liMenu .= "			</td>";
//                $liMenu .= "			<td align='center'>";
//                $liMenu .= "			<div style='text-align: center; width: 50px;'><input name='" . $menusb->men_id . "[3]' type='checkbox' value='rep' " . $chek4 . "></div>";
//                $liMenu .= "			</td>";
                $liMenu .= "		</tr>";
                $row1++;
                $i++;
            }
        }

        return $liMenu;
    }

    function existeMenu($id) {
        $row = $this->menu->dbselectBySQL("SELECT 
                                        tab_menu.men_id, 
                                        tab_menu.men_titulo
                                        FROM tab_menu
                                        WHERE tab_menu.men_id='" . $id . "' 
                                        AND tab_menu.men_estado =  '1'");
        if (is_object($row) || $row != null)
            return true;
        else
            return false;
    }

    function obtenerMenus($default = null) {
        $rows = $this->menu->dbSelectBySQL("SELECT
                                            ts.men_id,
                                            ts.men_titulo
                                            FROM
                                            tab_menu ts
                                            WHERE
                                            ts.men_estado =  '1'
                                            ORDER BY ts.men_id ASC");
        $option = '';
        if (count($rows) > 0) {
            foreach ($rows as $val) {
                if ($default == $val->men_id)
                    $selected = "selected";
                else
                    $selected = "";
                $option .="<option value='" . $val->men_id . "' $selected>" . $val->men_titulo . "</option>";
            }
        }
        return $option;
    }

}

?>