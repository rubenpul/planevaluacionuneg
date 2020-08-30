<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: MUestra información de estatus de trabajos de grado por estudiante             -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval010";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL011";
$strnombrereporte="REPORTE EVALUACIÓN DOCENTE";	
			   					   										 				 
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

 
<script src="eval011.js"></script>

 
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

    
    
<!--SESION --> 
<div style="display:none;" id="div_Sesion" >
   
   <p id="p_data"><?php echo $_SESSION['dataplan']; ?></p>
   <p id="p_data_len"><?php echo $_SESSION['lendataplan']; ?></p>
   <p id="p_Sesion"><?php echo SID; ?></p>
   <p id="p_Cedula"><?php echo GetCedulaUser(EncriptarCad($key_log, $id_login, 2)); ?></p>
</div>
    
<table width="100%" border="0"  height="440" cellpadding="0" cellspacing="0">
	<tr> 
            <td colspan="2" align="center" valign="top" height="350"> 
            <table width="100%" border="0" >
                <tr> 
                    <td height="10" valign="top" align="left" width="100%" class="barraPage"> 
                        <div align="left"><b>Planificación Docente</b></div>
                    </td>
                </tr>
            </table>
    
   
    <fieldset>
        <legend class="txtNormalSmall">PLANIFICACIÓN DOCENTE</legend>
    
            <font size="4"><b><label><?php echo $_GET['DescDocente']; ?></label></b></font><br>
            <font size="4"><b><label><?php echo $_GET['DescSede']; ?></label></b></font><br>  
            <font size="4"><b><label><?php echo $_GET['DescCarrera']; ?></label></b></font>  
                        
            <div id="div_DatosPlanificacion" class="datagrid2">
               <table id="table_planevaluacion" >
                            <thead>
                               
                               <tr>
                                    <th width="200px" align="center"><div class="tooltip">PRODUCTO O EVIDENCIA<span class="tooltiptext">Producto a Evaluar</span></th>
                                    <th width="150px" align="center"><div class="tooltip">ACTIVIDADES<span class="tooltiptext">Actividades del Docente (Ruta de Aprendizaje)</span></th>
                                    <th width="150px" align="center"><div class="tooltip">CRITERIO E INDICADORES<span class="tooltiptext">Justificación de Realizar la Evaluación</span></th>
                                    <th width="190px" align="center"><div class="tooltip">INSTRUMENTO<span class="tooltiptext">Instrumento que se le aplica a la Evaluación</span></th>
                                    <th width="110px" align="center"><div class="tooltip">%EVALUACIÓN<span class="tooltiptext">Porcentaje de Evaluación</span></th>
                                    <th width="80px" align="center"><div class="tooltip">SEMANA<span class="tooltiptext">Semana de Evaluación</span></th>
                                    <th width="80px" align="center"><div class="tooltip">ESTATUS<span class="tooltiptext">Producto evaluado o por evaluar por el Docente</span></th>
                                    
                                </tr>
                            </thead>   
                            <tbody>
            </div>  
    </fieldset>   
   
                
                
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

 
 
   
</html>
