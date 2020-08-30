<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: MUestra información de estatus de trabajos de grado por estudiante             -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval001";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL001";
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

 
<script src="eval001C.js"></script>
<script src="alertify.js-0.3.11/lib/alertify.min.js"></script>	
 
<link href="../estilos_css/sistemas.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid.css" rel="stylesheet" type="text/css">
<link href="../estilos_css/datagrid2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="alertify.js-0.3.11/themes/alertify.core.css" />
<link rel="stylesheet" href="alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />

<style>
    .alertify-log-custom {
            background: blue;
    }
</style>

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
                        <div align="left"><b>Plan de Evaluación Docente</b></div>
                    </td>
                </tr>
            </table>

               
                
   
    <fieldset>
        <legend class="txtNormalSmall">OFERTA DOCENTE</legend>
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
                            <b>HISTÓRICO</b><select name="cmb_lapsoconsulta" id="cmb_lapsoconsulta" class="Combobox" disabled></select>
                        </td>
                        <?php /*if (date("m") == "07" || date("m") == "08" || date("m") == "09" || date("m") == "10"){ 
                            echo "<td>" .
                                "<input type=\"radio\" name = \"radio_lapso\" value = \"CIVA\"><font size=\"2\"><b>CIVA <?php echo date(\"Y\"); ?></b>" .
                                "</td>";
                            }*/?>   
                        <td>
                            <input type="button" id = "bot_buscarlapso" value = "Consultar">
                        </td>
                    </tr>
                </table> 
                                               
            </div>
            <div id="div_DatosDocente" class="datagrid2">
                <table id="table_ofertadocente">
                           <tbody>
                           <thead>
                               
                                <tr>
                                <th align=\"center\">UNIDAD CURRICULAR</th>
                                <th align=\"center\">PROYECTO DE CARRERA</th>
                                <th align=\"center\">SECCI&Oacute;N</th>
                                <th align=\"center\">PLAN DE EVALUACI&Oacute;N</th>
                                <th style="display:none;" align=\"center\" >lapsovigencia</th>
                                <th style="display:none;" align=\"center\" >codcarr</th>
                                <th style="display:none;" align=\"center\" >codasign</th>
                                <th style="display:none;" align=\"center\" >codsede</th>
                                <th style="display:none;" align=\"center\" >lapsoacademico</th>
                                <th style="display:none;" align=\"center\" >cedula</th>
                                <th style="display:none;" align=\"center\" >sede</th>
                                <th style="display:none;" align=\"center\" >asignatura</th>
                                <th style="display:none;" align=\"center\" >indicador</th>
                                <th style="display:none;" align=\"center\" >lapsosys</th>
                                </tr>
                           </thead> 
                           </tbody>  
                     </table>   
            </div>  
    </fieldset>            

    <div style="display:none;" id="div_Acciones">        
        <table width="80%">
            <tr>
                <td align="right">
                    <a href="#" id="a_AgregarEvaluacion"><img title="Agregar Evaluación" src="../imagenes/agregar.png" alt="Agregar Evaluación" height="30" width="30" id="nuevaevaluacion"/></a>

                </td>
                <td align="right">
                    <a href="#" id="a_GuardarTodaEvaluacion"><img title="Guardar Todo el Plan Evaluacion" src="../imagenes/savedatabase.png" alt="Guardar el Plan de Evaluación" height="30" width="30" id="guardarevaluacion"/></a>

                </td>
                <!--<td align="right">
                    <a href="#" id="a_ReiniciarPlanEvaluacion"><img title="Reiniciar Plan de Evaluacion" src="../imagenes/restart.png" alt="Reiniciar el Plan de Evaluación" height="30" width="30" id="reiniciarevaluacion"/></a>

                </td>-->
                <td align="right">
                    <font size="5"><b>Total:&nbsp;<label id="lbl_acumevaluacion" name="lbl_acumevaluacion">0</label>&nbsp;%</b></font>

                </td>
               
                <td id="td_excel" align="right">
                        <FORM id="Report" METHOD = "POST" ACTION = "eval015.php">
                            <INPUT type ="hidden" id="Datos" name="Datos">
                            <INPUT type ="hidden" id="DesCarrera" name="DesCarrera">
                            <INPUT type ="hidden" id="CodAsignatura" name="CodAsignatura">
                            <INPUT type ="hidden" id="DesAsignatura" name="DesAsignatura">
                            <INPUT type ="hidden" id="DesSeccion" name="DesSeccion">
                            <INPUT type ="hidden" id="DesSede" name="DesSede">
                            <INPUT type ="hidden" id="DesLapsoAcad" name="DesLapsoAcad">
                            <INPUT type ="hidden" id="DesLapsoVigencia" name="DesLapsoVigencia">
                            <INPUT type ="hidden" id="CedulaDocente" name="CedulaDocente">
                          
                            <a href="#" id="a_ExportarExcel"><img title="Exportar Control de Evaluación a  MSExcel" src="../imagenes/icoexcel.png" alt="Exportar Control de Evaluación a MSExcel" id="exportarevaluacion"/></a>
                            
                        </form>    
                </td>
                
            </tr>                                
        </table>     
    </div>   
    <br>
            
    <div style="display:none;" id="div_referencia">  
        <fieldset>
            <legend class="txtNormalSmall">REFERENCIA PLANES DE EVALUACION</legend>
                <table width="60%">
                    <tr>
                        <td>
                            <font size="2"><b>Lapso</b><SELECT name="cmb_lapso" id="cmb_lapso" class="Combobox"></SELECT>
                        </td>
                        <td>
                            <font size="2"><b>Unidad Curricular</b><SELECT name="cmb_unidad" id="cmb_unidad" class="Combobox"></SELECT>
                        </td>
                        <td>
                            <font size="2"><b>Proyecto Carrera</b><SELECT name="cmb_carrera" id="cmb_carrera" class="Combobox"></SELECT>
                        </td>
                        <td>
                            <font size="2"><b>Sección</b><SELECT name="cmb_seccion" id="cmb_seccion" class="Combobox"></SELECT>
                        </td>
                        <td>
                            <input type = "button" name="bot_buscar" id="bot_buscar" value="Consultar"></SELECT>
                        </td>
                    </tr>                                
                </table>     
        </fieldset>            
    </div>                 
    
    <div style="display:none;"  id="div_PlanEvaluacion" class="datagrid">   
        <fieldset>
            <legend class="txtNormalSmall">PLAN DE EVALUACIÓN</legend>
                <font size="4"><b>SEDE <label id="lbl_sede"></label></b></font><br>
                <font size="4"><b><label id="lbl_ofertadocente"></label></b></font>
                <label style="display:none;" id="lbl_seccion"></label>
                <label style="display:none;" id="lbl_lapsovigencia"></label>
                <label style="display:none;" id="lbl_codcarr"></label>
                <label style="display:none;" id="lbl_codasign"></label>
                <label style="display:none;" id="lbl_codsede"></label>
                <label style="display:none;" id="lbl_lapsoacademicosys"></label><br>
                
                <font size="4"><b>LAPSO ACADÉMICO <label id="lbl_lapsoacademico"></label></b></font>
               
                  <table id="table_planevaluacion" >
                            <thead>
                               
                               <tr>
                                    <th width="8px"></th>
                                    <th width="200px" align="center"><div class="tooltip">PRODUCTO O EVIDENCIA<span class="tooltiptext">Producto a Evaluar</span></th>
                                    <th width="150px" align="center"><div class="tooltip">ACTIVIDADES<span class="tooltiptext">Actividades del Docente (Ruta de Aprendizaje)</span></th>
                                    <th width="150px" align="center"><div class="tooltip">CRITERIO E INDICADORES<span class="tooltiptext">Justificación de Realizar la Evaluación</span></th>
                                    <th width="190px" align="center"><div class="tooltip">INSTRUMENTO<span class="tooltiptext">Instrumento que se le aplica a la Evaluación</span></th>
                                    <th width="110px" align="center"><div class="tooltip">%EVALUACIÓN<span class="tooltiptext">Porcentaje de Evaluación</span></th>
                                    <th width="80px" align="center"><div class="tooltip">SEMANA<span class="tooltiptext">Semana de Evaluación</span></th>
                                    <th width="80px"></th>
                                    <th style="display:none;"></th>
                                </tr>
                            </thead>   
                            <tbody>
                        <?php
                        
                         $select="eval003d_id_instrumento,eval003d_descripcion";
                         $from = "eval003d";
                         $where="1=1";
                         $groupby="";
                         $orderby="eval003d_descripcion";

                         $nro=0;
                         $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                         $tecnica = "<SELECT name=\"cmb_instrumento[]\" id=\"cmb_instrumento\" class=\"Combobox\" required>\n".
                                    "<OPTION  selected value=\"\">Seleccione...</option>\n";
                
                         if ($nro > 0){	
                            $i=0;                 
                            while ($i<$nro) {
                        
                                $tecnica = $tecnica. "<OPTION  VALUE=" . trim($rs[$i]['eval003d_id_instrumento']) . ">" . strtoupper(trim($rs[$i]['eval003d_descripcion']))  . "</OPTION>\n";
                                $i++;
                        
                            }    
                         }		            

                         $tecnica = $tecnica. "</SELECT>";  
                         
                         for($i=1;$i<=4;$i++){ 
                                
                                    echo "<tr>";
                                    echo        "<td>$i</td>";  
                                    echo        "<td  width=\"200px\"><textarea rows=\"9\" cols=\"20\" name=\"producto[]\" id=\"producto\" border:1px solid blue; required></textarea></td>";
                                    echo        "<td width=\"150px\"><textarea rows=\"9\" cols=\"20\" name=\"actividad[]\" id=\"actividad\" border:1px solid blue; required></textarea></td>";
                                    echo        "<td width=\"150px\"><textarea rows=\"9\" cols=\"20\" name=\"criterio[]\" id=\"criterio\" border:1px solid blue; required></textarea></td>";
                                    echo        "<td width=\"150px\">". $tecnica;
                                    echo        "</td>";
                                    echo        "<td width=\"110px\">";
                                    echo        "<input name=\"pesoevaluacion[]\" id=\"pesoevaluacion\" maxlength=\"2\" size=\"1\" class=\"EvaluarPonderacion\" required></input><b>1%-25%</b>";
                                    echo        "</td>";
                                    echo        "<td width=\"80px\">";
                                    echo        "<input name=\"semanaevaluar[]\" id=\"semanaevaluar\" maxlength=\"2\" size=\"1\" class=\"EvaluarSemana\" required></input><b>(1-16)</b>";
                                    echo        "</td>";
                                    echo        "<td width=\"80px\">";
                                    echo            "<a href=\"#\"><img src=\"../imagenes/savedatabase.png\" title=\"Guardar Evaluación\" height=\"30\" width=\"30\" class=\"GuardarEvaluacion\"></a>";
                                    echo            "<br><br><a href=\"#\"><img src=\"../imagenes/eraser.png\" title=\"Borrar Evaluación\" class=\"BorrarEvaluacionBase\" height=\"30\" width=\"30\"></a>";
                                    echo        "</td>";
                                    echo        "<td style=\"display:none;\">";
                                    echo        "<input name=\"idbd[]\" id=\"idbd\" maxlength=\"2\" size=\"1\"  value=\"0\"></input>";
                                    echo        "</td>";
                                    echo "</tr>"; 
                            
                         }
                        ?>
                        </tbody>  
                     </table>                         
                 
        </fieldset>
    </div>    

<br>

<br>


<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="left"><b><u>Leyenda:</u><b> <br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/generarplan.png" title="Ver Planificación" height="30" width="30"><b>Crear / Consultar / Actualizar Plan de Evaluación</b><br></td>
  </tr>
   
  <tr> 
      <td align="left"><img src="../imagenes/agregar.png" title="Agregar Evaluación" height="30" width="30"><b>Agregar Evaluación</b><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/savedatabase.png" title="Guardar Todas las Evaluaciones" height="30" width="30"><b>Guardar Todas las Evaluaciones</b><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/eliminar.png" title="Borrar Contenido de una Evaluación" height="30" width="30"><b>Borrar Fila y Contenido de una Evaluación</b><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/eraser.png" title="Borrar Contenido de una Evaluación Base" height="30" width="30"><b>Borrar Contenido de una Evaluación Base</b></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/icoexcel.png" title="Exportar Control de Evaluación a MSExcel" height="30" width="30"><b>Exportar Control de Evaluación a MSExcel</b></td>
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
