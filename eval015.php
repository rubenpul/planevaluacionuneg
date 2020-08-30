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
require_once('funciones.php');
?>
<html>
    <head>
        
        <title></title>
    </head>
    <body>

        
        <table border="0" width="100%">
            <tr>
		<td  colspan="4" class="txtNormalBold" align="left">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" class="txtNormalBold" align="left">UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA</td>
            </tr>
            <tr>
                <td  colspan="4" class="txtNormalBold" align="left">SEDE <?php echo $_POST['DesSede'];?></td>
            <tr>
                <td  colspan="4" class="txtNormal" align="left">PROYECTO DE CARRERA: <?php echo $_POST['DesCarrera'];?></td>
            </tr>
            <tr>
		<td colspan="4" class="txtNormalBold" align="left">UNIDAD CURRICULAR: <?php echo $_POST['CodAsignatura'];?><?php echo $_POST['DesLapsoVigencia'];?>-<?php echo $_POST['DesAsignatura'];?> </td>
            </tr>
            <tr >
		<td  colspan="4" class="txtNormalBold" align="left">SECCI&Oacute;N &nbsp;<?php echo $_POST['DesSeccion'];?></TD>
            </tr>
            <tr >
		<td  colspan="4" class="txtNormalBold" align="left">DOCENTE: <?php echo $_POST['CedulaDocente'];?>-<?php echo GetNameDocente($_POST['CedulaDocente']);?></td>
            </tr>
            <tr >
		<td  colspan="4" class="txtNormalBold" align="center"></TD>
            </tr>
            <tr >
		<td  colspan="4" class="txtNormalBold" align="center">FORMATO DE EVALUACI&Oacute;N</TD>
            </tr>
        </table>    
        
        <?php echo $_POST['Datos'];?> 
        
        
    </body>
</html>

 
