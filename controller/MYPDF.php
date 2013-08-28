<?php

class MYPDF extends TCPDF {

    public function Footer() {
        $this->usuario = new usuario ();

        $fecha_actual = date("d/m/Y");
        $cadena = '';
        $cadena.='<table width="720" border="0">
                    <tr>
                    <td><strong>AREA DE CONTROL DE LA DESCRIPCION </strong></td>
                    </tr>
                    <tr>
                    <td><strong>FIRMA:<br/><br/></strong></td>
                    </tr>
                    <tr>
                    <td><strong>NOMBRE:'.$this->usuario->obtenerNombre($_SESSION['USU_ID']).'</strong></td>
                    </tr>
                    <tr>
                    <td><strong>CARGO:</strong></td>
                    </tr>
                    <tr>
                    <td><strong>FECHA DE ELABORACION:' . $fecha_actual . ' </strong></td>
                    </tr>
                    </table>';

        // Position at 15 mm from bottom
        $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', '', 8);
        // Page number
        $this->writeHTML($cadena, true, false, false, false, '');
    }

}
?>
