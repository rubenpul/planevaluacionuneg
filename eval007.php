<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: REPORTE DE ASISTENCIA ACADEMICA            -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval007";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL007";
$strnombrereporte="RESUMEN ASISTENCIA ";					   					   										 				 
//--------------------------------------------------------------------------------------------------------
?>
<html>
<head>
     
</head>    
<title><?php echo $name_sistema; ?></title>
<SCRIPT language="JavaScript" src="../applet/funciones_uneg.js"></SCRIPT>

<script
        src="jquery-2.2.4.js"
        integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous">
</script>

<script src="eval007.js"></script>

 
<link href="../estilos_css/sistemas.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid2.css" rel="stylesheet" type="text/css">


        

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

 <!--SESION --> 
<div style="display:none;" id="div_Sesion" >
   <p id="Sesion"><?php echo SID; ?></p>
   <p id="Cedula"><?php echo GetCedulaUser(EncriptarCad($key_log, $id_login, 2)); ?></p>
</div>
    
<table width="100%" border="0"  height="440" cellpadding="0" cellspacing="0">
	<tr> 
    	<td colspan="2" align="center" valign="top" height="350"> 
            <table width="100%" border="0" >
            <tr> 
                <td height="10" valign="top" align="left" width="100%" class="barraPage"> 
                    <div align="left"><b>Condición Docente</b></div>
		</td>
            </tr>
</table>

                      
<br>
<br>						 
                  	
                
    <table class="datagrid" width="70%" cellspacing="2" cellpadding="2">
        <tbody>

                <tr class="alt"> 
                    <td><b>Departamento:</b></td>
                    <td><SELECT id="cmb_departamento"></select></td>   
                </tr>
                               
                <tr > 
                    <td><b>Área:</b></td>
                    <td><SELECT id="cmb_area"></select></td>   
                </tr>
                
                <tr > 
                    <td></td>
                    <td><INPUT type ="button" id="bot_consultar" value="Consultar"></select></td>   
                </tr>

        </tbody>        
    </table>  
                    

    <div style="display:none;" id="div_Acciones">        
        <table width="80%">
            <tr>
                <td align="right">
                    <a href="#" id="a_ActualizarTCD"><img title="Actualizar Contratación Docente" src="../imagenes/savedatabase.png" height="30" width="30" id="actualizarTCD"/></a>
                </td>
                                        
            </tr>                                
        </table>     
    </div>   


<br>
<br>

<div  style="display:none;" id="div_condiciondocente" class="datagrid">
    <fieldset>
         <legend class="txtNormalSmall">Condición Docente:</legend>
             <label></label>

           
            <table style="display:none;" id="table_condiciondocente">
                   <thead>
                        <tr>
                        <th width="100px">Nro Cédula</th>
                        <th width="300px">Nombres</th>
                        <th width="200px">Condición Docente</th>
                        <th style="display:none;" align="center">cedula</th>
                        <th style="display:none;" align="center">coddepartamento</th>
                        <th style="display:none;" align="center">codarea</th>
                        </tr>
                   </thead> 
                   <tbody>
                   </tbody>  
             </table>                      
                 

     </fieldset>

</div>


<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" class="fondoInf"><b class="txtDerechos"><?php echo $derechos?></b></td>
  </tr>
</table>

</body>
<script language="JavaScript">
//<!--
parent.show();
//-->
</script>


        
<!--DESHABILITAR FUNCION CLICK DERECHO -->
 <script type="text/javascript">

    document.oncontextmenu = function(){return false;}

 </script>
 
  
</html>
