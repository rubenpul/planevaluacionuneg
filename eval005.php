<?php
/*
<!-- inscripcion/listado_inscritos_excel.php                                                     -->
<!-- ******************************************************************************************* -->
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: ING RUBEN PULIDO                                                                  -->
<!-- NOMBRE: eval005.php                                                         -->
<!-- DESCRIPCION: Listado Asistencia                                      -->
<!-- ******************************************************************************************* -->
*/
// Enviamos los encabezados de hoja de calculo 
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=excel.xls"); 

//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="listado";
require_once('../webconfig/config.php');
require_once('../funciones/funciones_web.php');
require_once('../funciones/acceso_preg.php');

?>
<html>
    <head>
        
        <title></title>
    </head>
    <body>

        
        <table border="0" width="100%">
            <tr>
		<td colspan="4" class="txtNormalBold" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" class="txtNormalBold" align="center">UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA</td>
            </tr>
            <tr>
                <td colspan="4" class="txtNormalBold" align="center">COORDINACI&Oacute;N GENERAL DE PREGRADO</td>
            <tr>
                <td colspan="4" class="txtNormal">&nbsp;</td>
            </tr>
            <tr>
		<td colspan="4" class="txtNormalBold" align="center">&nbsp;</td>
            </tr>
            <tr>
		<td colspan="4" class="txtNormalBold" align="center">&nbsp;</td>
            </tr>
            <tr>
		<td colspan="4" class="txtNormalBold" align="center">REPORTE DE ASISTENCIAS</TD>
            </tr>
        </table>    
        
        <?php echo $_POST['datos_export_excel'];?> 
        
        
    </body>
</html>

 
