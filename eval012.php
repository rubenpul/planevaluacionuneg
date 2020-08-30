<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: MUestra información de estatus de trabajos de grado por estudiante             -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval006";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL006";
$strnombrereporte="SISTEMA DE PLAN DE EVUALUACIÓN DOCENTE";	
			   					   										 				 
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

 
<script src="eval012.js"></script>
<script src="alertify.js-0.3.11/lib/alertify.min.js"></script>	



<link href="../estilos_css/sistemas.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="alertify.js-0.3.11/themes/alertify.core.css" />
<link rel="stylesheet" href="alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />




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
    background: url('imagenes/loader3.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;

    
	
}
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <!-- Paste this code after body tag -->
	<div style="display:none;" id="preloader" class="se-pre-con"></div>
	<!-- Ends -->
    

 <?php
$fecha = date("Y-m-d");


?>

<input style="display:none;" type="text" id="fechaactual" value="<?= $fecha; ?>">
           
        
        
        
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
                        <div align="left"><b>Reporte de Objeción</b></div>
                    </td>
                </tr>
            </table>
    
   
    <fieldset>
        <legend class="txtNormalSmall">OFERTA DOCENTE</legend>
            <label></label>
            
            
            
            <div id="div_DatosDocente" class="datagrid2">
                <table id="table_ofertadocente">
                           <tbody>
                           <thead>
                               <!---->
                                <tr>
                                <th align=\"center\">UNIDAD CURRICULAR</th>
                                <th align=\"center\">PROYECTO DE CARRERA</th>
                                <th align=\"center\">SECCI&Oacute;N</th>
                                <th align=\"center\">EVALUACI&Oacute;N</th>
                                <th style="display:none;" align=\"center\" >lapsovigencia</th>
                                <th style="display:none;" align=\"center\" >codcarr</th>
                                <th style="display:none;" align=\"center\" >codasign</th>
                                <th style="display:none;" align=\"center\" >codsede</th>
                                <th style="display:none;" align=\"center\" >lapsoacademico</th>
                                <th style="display:none;" align=\"center\" >cedula</th>
                                <th style="display:none;" align=\"center\" >indicador</th>
                                <th style="display:none;" align=\"center\" >lapsoacademicosys</th>
                                <th style="display:none;" align=\"center\" >semestre</th>
                                <th style="display:none;" align=\"center\" >asignatura</th>
                                </tr>
                           </thead> 
                           </tbody>  
                </table> 
               
                
            </div>  
    </fieldset>   
                

               
                
                
    <label style="display:none;" id="lbl_seccion"></label>
    <label style="display:none;" id="lbl_lapsovigencia"></label>
    <label style="display:none;" id="lbl_codcarr"></label>
    <label style="display:none;" id="lbl_codasign"></label>
    <label style="display:none;" id="lbl_codsede"></label>
    <label style="display:none;" id="lbl_lapsoacademico"></label>
    <label style="display:none;" id="lbl_lapsoacademicosis"></label>
    <label style="display:none;" id="lbl_semestre"></label>
       
    
    <div style="display:none;"  id="div_Productos" class="datagrid2">   
        <fieldset>
            <legend class="txtNormalSmall">Productos a Evaluar</legend>
                <font size="4"><b><label id="lbl_ofertadocente"></label></b></font>
                <br>
                <font size="2" color="red" ><b><label id="lbl_nroestobjetar"></label></b></font>
               
                  <table id="table_producto" >
                            <tbody>
                            <thead>
                               
                               <tr>
                                    <th width="8px"></th>
                                    <th width="400px" align="center"><div class="tooltip">PRODUCTO O EVIDENCIA<span class="tooltiptext">Producto o Evidencia a Evaluar</span></th>
                                    <th width="150px" align="center"><div class="tooltip">PONDERACIÓN %<span class="tooltiptext">Ponderación del Producto (1-25%)</span></th>
                                    <th width="150px" align="center"><div class="tooltip">SEMANA PLANIFICADA<span class="tooltiptext">Semana Académica que se planificó el Producto</span></th>
                                    <th width="190px" align="center"><div class="tooltip">STATUS<span class="tooltiptext">Status(Por Evaluar / Transcrito / Evaluado)</span></th>
                                    <th style="display:none;" width="190px" align="center"><div class="tooltip">ideva</th>
                                    <th style="display:none;" width="190px" align="center"><div class="tooltip">idstatus</th>
                                    <th style="display:none;" width="190px" align="center"><div class="tooltip">fechabd</th>
                                    <th width="190px" align="center"><div class="tooltip">FECHA REGISTRO<span class="tooltiptext">Fecha de Registro de la Evaluación por Sistema</span></th>
                                    <th width="190px" align="center"><div class="tooltip">SEMANA EVALUACIÓN<span class="tooltiptext">Semana Académica que se evaluó el Producto</span></th>
                                    <th style="display:none;" width="190px" align="center">nroest</th>
                               </tr>
                            </thead>   
                            </tbody>  
                     </table>                         
                 
                    <table>
                        <tr>
                            <td>
                                <div style="display:none;" id="div_actanotas">
                                <input type="button" id = "bot_actanotas" value = "Ver Acta de Notas">
                                </div>
                            </td>
                        </tr>
                    </table> 
        </fieldset>
    </div> 

    <div style="display:none;" id="div_Acciones">        
        <table width="80%">
            <tr>
                <td align="right">
                    <a href="#" id="a_GuardarTodaPonderacion"><img title="Guardar Ponderación" src="../imagenes/savedatabase.png" alt="Guardar Ponderación" height="30" width="30" id="guardarponderacion"/></a>
                </td>
                                
            </tr>                                
        </table>     
    </div>                                           

    <div style="display:none;" id="div_ActaEvaluacion">        
        <table width="80%">
            <tr>

                <td align="right">
                    <a href="visor_report.php?codreporte=1&" <?php echo SID;?>  id="a_ExportarPDFProd"><img title="Exportar a PDF el Acta de Evaluación" src="../imagenes/pdf.png" alt="Exportar Acta de Evaluación a PDF" height="30" width="30" id="exportarevaluacionproducto"/></a>
                </td>
                
            </tr>                                
        </table>     
    </div>                                           
                                       
    <div style="display:none;" id="div_Nota" class="datagrid2">   
        <fieldset>
            <legend class="txtNormalSmall">Ponderación Estudiante</legend>
                <font size="4"><b><label id="lbl_oferta"></label></b></font>
                <br>
                <font size="2"><b><label id="lbl_productoaevaluar"></label></b></font>
                <br>
                <font size="4"><b><label id="lbl_ponderacion"></label></b></font>
                <br>
                <div style="display:none;" id="div_escala">
                <font size="4"><b>Seleccione Escala de Notas</b></font><input checked type="radio" id="radio_porcentaje" name="escala"><font size="3"><b><label id="lbl_porcentaje"></label></b></font></input>
                <input type="radio" id="radio_110" name="escala"><font size="3"><b>[1-10]</b></font></input>
                <input type="radio" id="radio_120" name="escala"><font size="3"><b>[1-20]</b></font></input></br>
                </div>
                <font size="4"><b>Semana de Evaluación</b></font><select id="cmb_semevaluacion" name="cmb_semevaluacion">
                    <OPTION  selected value="0">Seleccione...</option>
                    <OPTION  value="1">1</option>
                    <OPTION  value="2">2</option>
                    <OPTION  value="3">3</option>
                    <OPTION  value="4">4</option>
                    <OPTION  value="5">5</option>
                    <OPTION  value="6">6</option>
                    <OPTION  value="7">7</option>
                    <OPTION  value="8">8</option>
                    <OPTION  value="9">9</option>
                    <OPTION  value="10">10</option>
                    <OPTION  value="11">11</option>
                    <OPTION  value="12">12</option>
                    <OPTION  value="13">13</option>
                    <OPTION  value="14">14</option>
                    <OPTION  value="15">15</option>
                    <OPTION  value="16">16</option>
                    
                </select>
                <div style="display:none;" id="div_aprobar">
                    <font size="4"><b>Desea aprobar ésta última evaluación?</b></font><input checked type="button" id="bot_ok" name="bot_ok" value="OK"></input>
                </div>
                <table id="table_ponderacion" >
                            <tbody>
                            <thead>
                               
                               <tr>
                                    <th width="8px"></th>
                                    <th width="300px" align="center"><div class="tooltip">NOMBRE ESTUDIANTE</th>
                                    <th width="75px" align="center"><div class="tooltip">PONDERACIÓN</th>
                                    <th width="75px" align="center"><div class="tooltip">ASISTIÓ?</th>
                                    <th style="display:none;" width="75px" align="center"><div class="tooltip"></th>
                                    <th style="display:none;" width="75px" align="center"><div class="tooltip"></th>
                                    <th style="display:none;" width="75px" align="center"><div class="tooltip"></th>
                                    <th width="75px" align="center"><div class="tooltip"></th>
                                    <th width="75px" align="center"><div class="tooltip"></th>
                                    <th width="75px" align="center"><div class="tooltip">OBJETADO?</th>
                               </tr>
                            </thead>   
                            </tbody>  
                     </table>                         
                 
        </fieldset>
    </div>                                                                             
            
    <div style="display:none;"  id="div_Acta">   
        
         <a href="visor_report.php?codreporte=0&" <?php echo SID;?>  id="a_ExportarPDF"><img title="Exportar a PDF el Acta de Evaluación" src="../imagenes/pdf.png" alt="Exportar Acta de Evaluación a PDF" height="30" width="30" id="exportarevaluacion"/></a>
        <fieldset>
            <legend class="txtNormalSmall">Acta de Notas</legend>
                <font size="4"><b><label id="lbl_ofertadocente"></label></b></font>
                  <font size="4"><b>Tipo Acta</b></font><input checked type="radio" id="radio_general" name="TipoActa" value="1"><font size="3"><b>General</b></font></input>
                    <input type="radio" id="radio_detallada" name="TipoActa" value="2"><font size="3"><b>Detallada</b></font></input>
                    
                    <div id="div_tablaActa" class="datagrid2">   
                              
                    </div>
                    
        </fieldset>
    </div>                                         
                
<br>




<div style="display:none;"  id="div_Estadistica" class="datagrid2">   
        <fieldset>
            <legend class="txtNormalSmall">Estadísticas Sección</legend>
     
                  <table id="table_estadistica" >
                        <tbody>
                        

                           <tr class="alt">
                                <td>Nro de Estudiantes Inscritos</td>
                                <td><label id="lbl_nroest"></label></td>
                                <td>Nro de Estudiantes Cursantes</td>
                                <td><label id="lbl_nroestcur"></label></td>
                                <td>Nro de Estudiantes Aprobados</td>
                                <td><label id="lbl_nroaprob"></label></td>
                               
                           </tr>
                           <tr>
                                <td>% Aprobados</td>
                                <td><label id="lbl_porcenaprob"></label>%</td>
                                <td>Nro de Estudiantes Reprobados</td>
                                <td><label id="lbl_nroreprob"></label></td>
                                <td>% Reprobados</td>
                                <td><label id="lbl_porcenreprob"></label>%</td>
                               
                           </tr>
                           <tr class="alt">
                                <td>Media Aritmética</td>
                                <td><label id="lbl_media"></label></td>
                                <td>Desviación Típica</td>
                                <td><label id="lbl_desvtip"></label></td>
                                <td>Varianza</td>
                                <td><label id="lbl_varianza"></label></td>
                               
                           </tr>
                           <tr>
                                <td>Calificación Máxima</td>
                                <td><label id="lbl_notamax"></label></td>
                                <td>Calificación Mínima</td>
                                <td><label id="lbl_notamin"></label></td>
                                <td>% Evaluado</td>
                                <td><label id="lbl_porcenevaluado"></label></td>
                               
                           </tr>
                        </tbody>  
                    </table>                         
        </fieldset>
</div>

<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="left"><b><u>Leyenda:</u><b> <br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/evaluacion_cerrada.png" title="Ponderación Cerrada por CACE" height="30" width="30"><b>Ponderación Cerrada por CACE</b><br></td>
  </tr>
    
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
