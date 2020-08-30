<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: MUestra información de estatus de trabajos de grado por estudiante             -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval008";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL008";
$strnombrereporte="REPORTE PLANIFICACIÓN DOCENTE";	
			   					   										 				 
//--------------------------------------------------------------------------------------------------------
?>
<html>
<head>
     
</head>    
<title><?php echo $name_sistema; ?></title>
<SCRIPT language="JavaScript" src="../../applet/funciones_uneg.js"></SCRIPT>

<script
        src="jquery-2.2.4.js"
        integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous">
</script>

 
<script src="eval008.js"></script>

 
<link href="../estilos_css/sistemas.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid2.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.Combobox
{
font-size: 10px;
}
-->

</style>        

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 20%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>
<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(imagenes/loader3.gif) center no-repeat #fff;
}
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <!-- Paste this code after body tag -->
	<div style="display:none;" id="preloader" class="se-pre-con"></div>
	<!-- Ends -->
    
    
<!--SESION --> 
<div style="display:none;" id="div_Sesion" >
   <p id="p_Sesion"><?php echo SID; ?></p>
   <p id="p_Cedula"><?php echo GetCedulaUser(EncriptarCad($key_log, $id_login, 2)); ?></p>
</div>
    
<table width="100%" border="0"  height="440" cellpadding="0" cellspacing="0">
	<tr> 
            <td colspan="2" align="center" valign="top" height="350"> 
            <table width="100%" border="0" >
                <tr> 
                    <td height="10" valign="top" align="left" width="100%" class="barraPage"> 
                        <div align="left"><b>Reporte Planificación Docente - CGP</b></div>
                    </td>
                </tr>
            </table>
    
   
    <fieldset>
        <legend class="txtNormalSmall">AVANCE DE PLAN DE EVALUACIÓN SEDES</legend>
            <label></label>
            
            <div id = "div_lapso" align="right">
                            
                <table>
                    <tr>
                        <td>
                            <input type="radio" name = "radio_lapso" value="LAPSOACTUAL" checked ><font size="2">
                            <b>LAPSO ACTUAL</b>
                        </td>
                        
                        <td>
                            <input type="radio" name = "radio_lapso" value="LAPSO"><font size="2">
                            <b>LAPSOS CARGADOS</b><select name="cmb_lapsoconsulta" id="cmb_lapsoconsulta" class="Combobox" disabled></select>
                        </td>
                        <?php if (date("m") == "07" || date("m") == "08" || date("m") == "09" || date("m") == "10"){ 
                            echo "<td>" .
                                "<input type=\"radio\" name = \"radio_lapso\" value = \"CIVA\"><font size=\"2\"><b>CIVA <?php echo date(\"Y\"); ?></b>" .
                                "</td>";
                            }?>   
                        <td>
                            <input type="button" id = "bot_buscarlapso" value = "Consultar">
                        </td>
                    </tr>
                </table> 
                                               
            </div>
            
                        
            <div id="div_DatosSede" class="datagrid2">
                <table id="table_sedes">
                           <tbody>
                           <thead>
                                <tr>
                                <th align=\"center\">SEDE</th>
                                <th align=\"center\">COMPLETADO </th>
                                <th align=\"center\"> AVANCE >= 50%</th>
                                <th align=\"center\"> AVANCE > 0%  y <= 49% </th>
                                <th align=\"center\">SIN AVANCE</th>
                                <th align=\"center\"></th>
                                <th style="display:none;" align=\"center\" >codsede</th>
                                <th style="display:none;" align=\"center\" >lapso</th>
                                </tr>
                           </thead> 
                           </tbody>  
                     </table>   
            </div>  
    </fieldset>   
    <font size="4"><b><label id="lbl_consulta"></label></b></font>         
    <div style="display:none;" id="div_carrera" >            
     <fieldset>
        <legend class="txtNormalSmall">AVANCE DE PLAN DE EVALUACIÓN POR PROYECTO DE CARRERA</legend>
            <label></label>
            <div id="div_DatosCarrera" class="datagrid2">
                <table id="table_carrera">
                           <tbody>
                           <thead>
                                <tr>
                                <th align=\"center\">PROYECTO DE CARRERA</th>
                                <th align=\"center\">COMPLETADO </th>
                                <th align=\"center\"> AVANCE >= %50</th>
                                <th align=\"center\"> AVANCE > 0%  y <= 49% </th>
                                <th align=\"center\">SIN AVANCE</th>
                                <th align=\"center\"></th>
                                <th style="display:none;" align=\"center\" >codcarrera</th>
                                <th style="display:none;" align=\"center\" >lapso</th>
                                </tr>
                           </thead> 
                           </tbody>  
                     </table>   
            </div>  
    </fieldset>                  
    </div>    
    <font size="4"><b><label id="lbl_consulta_2"></label></b></font>   
     <div style="display:none;" id="div_docente" >            
     <fieldset>
        <legend class="txtNormalSmall">AVANCE DE PLAN DE EVALUACIÓN POR DOCENTE</legend>
            <label></label>
            <div id="div_DatosDocente" class="datagrid2">
                <table id="table_docente">
                           <tbody>
                           <thead>
                                <tr>
                                <th width="300px" align="center">NOMBRE DOCENTE</th>
                                <th width="75px" align="center">UNIDAD CURRICULAR</th>
                                <th width="75px" align="center">SECCIÓN</th>
                                <th width="75px" align="center">%AVANCE</th>
                                <th width="75px" align="center">VER PLANIFICACIÓN</th>
                                <th style="display:none;" width="75px" align="center" >lapso</th>
                                <th style="display:none;" width="75px" align="center" >codasig</th>
                                <th style="display:none;" width="75px" align="center" >seccion</th>
                                <th style="display:none;" width="75px" align="center" >carrera</th>
                                <th style="display:none;" width="75px" align="center" >codsede</th>
                                <th style="display:none;" width="75px" align="center" >ceduladoc</th>
                                </tr>
                           </thead> 
                           
                           </tbody>  
                     </table>   
            </div>  
    </fieldset>                  
    </div>    
                
                
<br>

<br>

<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
       
  <tr> 
    <td align="center" class="fondoInf"><b class="txtDerechos"><?php echo $derechos?></b></td>
  </tr>
</table>

</body>
<script language="JavaScript">

parent.show();

</script>

 
        
<!--DESHABILITAR FUNCION CLICK DERECHO -->
 <script type="text/javascript">

    document.oncontextmenu = function(){return false;}

 </script>
 
   
</html>
