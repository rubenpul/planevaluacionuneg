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

<script src="eval003.js"></script>

 
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
                    <div align="left"><b>Actualizar &gt; Horas de  Docente</b></div>
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
                <tr > 
                    <td><b>Plan de Estudios:</b></td>
                    <td><SELECT id="cmb_plan">
                                   
                     </SELECT>
                    </td>   
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
                    <a href="#" id="a_ActualizarHAD"><img title="Actualizar HAD" src="../imagenes/savedatabase.png" height="30" width="30" id="actualizarHAD"/></a>
                </td>
                                        
            </tr>                                
        </table>     
    </div>   


<br>
<br>

<div  style="display:none;" id="div_unidadcurricular" class="datagrid">
    <fieldset>
         <legend class="txtNormalSmall">UNIDADES CURRICULARES:</legend>
             <label></label>

           
                 <table style="display:none;" id="table_unidadcurricular">
                        <thead>
                             <tr>
                             <th align="center">Código</th>
                             <th width="300px" align="center">Unidad Curricular</th>
                             <th width="30px" align="center">UC</th>
                             <th width="60px" align="center">Semestre</th>
                             <th align="center">HAD</th>
                             <th style="display:none;" align="center">coduni</th>
                             <th style="display:none;" align="center">sem</th>
                             <th style="display:none;" align="center">carrera</th>
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
