<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: REPORTE DE ASISTENCIA ACADEMICA            -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval003";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL003";
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

<script src="eval004.js"></script>

 
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
                    <div align="left"><b>Reporte &gt; Asistencia</b></div>
		</td>
            </tr>
</table>

                      
<br>
<br>						 
                  	
                
    <table class="datagrid" width="70%" cellspacing="2" cellpadding="2">
        <tbody>

                <tr class="alt"> 
                    <td><b>Proyecto de Carrera:</b></td>
                    <td><SELECT id="cmb_carrera"></select></td>   
                </tr>
                <tr > 
                    <td><b>Semestre:</b></td>
                    <td><SELECT id="cmb_semestre">
                    
                     <option value="0">Todos</option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                     <option value="5">5</option>
                     <option value="6">6</option>
                     <option value="7">7</option>
                     <option value="8">8</option>
                     <option value="9">9</option>
                     <option value="10">10</option>
                     <option value="11">11</option>
                     </select>
                    </td>   
                </tr>
                
                <tr class="alt"> 
                    <td><b>Condición Docente:</b></td>
                    <td><SELECT id="cmb_condicion"></select></td>   
                </tr>
                
                <tr > 
                    <td></td>
                    <td><INPUT type ="button" id="bot_consultar" value="Consultar"></select></td>   
                </tr>

        </tbody>        
    </table>  
                    

    <div style="display:none;" id="div_Acciones"> 
        
        <form action="eval005.php" method="post" target="_blank">
            <INPUT type ="hidden" id="datos_export_excel" name="datos_export_excel">
            <p><input type="submit" value="Generar Reporte"></p>
        </form>
                
    </div>   


<br>
<br>

<div  style="display:none;" id="div_asistencia" class="datagrid">
    <fieldset>
         <legend class="txtNormalSmall">UNIDADES CURRICULARES:</legend>
             <label></label>

           
                 <table style="display:none;" id="table_resumenasistencia">
                        <thead>
                             <tr>
                             <th width="60px" align="center">N° Cédula</th>    
                             <th width="250px" align="center">Nombres</th>  
                             <th width="100px" align="center">Proyecto de Carrera</th>
                             <th width="100px" align="center">Código</th>
                             <th width="100px" align="center">Unidad Curricular</th>
                             <th width="100px" align="center">Semestre</th>
                             <th width="100px" align="center">Sección</th>
                             <th width="100px" align="center">Condición</th>
                             <th width="100px" align="center">HAD</th>
                             <th width="100px" align="center">N° Encuentros Verificado</th>
                                                         
                             <th style="display:none;" >lapsovigencia</th>
                             <th style="display:none;" >codcarr</th>
                             <th style="display:none;" >codasign</th>
                             <th style="display:none;" >codsede</th>
                             <th style="display:none;" >codlapso</th>
                             <th style="display:none;">Fechas de Encuentos</th>
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
