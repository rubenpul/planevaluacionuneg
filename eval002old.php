<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: stg001.php                                                                          -->  
<!-- DESCRIPCION: ASISTENCIA DEL ESTUDIANTE             -->
<!-- ******************************************************************************************* -->
*/
//Archivos del Sistema ------------------------------------------------------------------------------------
$namepage="eval001";
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
//----------------------------------------------------------------------------------------------------------
//Codificación del Reporte
$codreporte="EVAL002";
$strnombrereporte="ASISTENCIA DOCENTE";	
			   					   										 				 
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
 
<script src="eval002.js"></script>

 
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


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

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
                        <div align="left"><b>Asistencia Docente</b></div>
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
                       
            
            <div id="div_DatosDocente" class="datagrid2">
                <table id="table_ofertadocente">
                           <tbody>
                           <thead>
                               <!---->
                                <tr>
                                <th align=\"center\">UNIDAD CURRICULAR</th>
                                <th align=\"center\">PROYECTO DE CARRERA</th>
                                <th align=\"center\">SECCI&Oacute;N</th>
                                <th align=\"center\">VER ASISTENCIAS</th>
                                <th style="display:none;" align=\"center\" >lapsovigencia</th>
                                <th style="display:none;" align=\"center\" >codcarr</th>
                                <th style="display:none;" align=\"center\" >codasign</th>
                                <th style="display:none;" align=\"center\" >codsede</th>
                                <th style="display:none;" align=\"center\" >lapsoacademico</th>
                                <th style="display:none;" align=\"center\" >cedula</th>
                                <th style="display:none;" align=\"center\" >sede</th>
                                <th style="display:none;" align=\"center\" >docente</th>
                                <th style="display:none;" align=\"center\" >semestre</th>
                                </tr>
                           </thead> 
                           </tbody>  
                     </table>   
            </div>  
    </fieldset>            
                
    <div style="display:none;" id="div_Nroencuentros">        
        <table  width="100%" id="">
            <tr>
                <td >
                     <font size="4"><b><label id="lbl_textoencuentro">Nro de Encuentros Semanales</label></b></font><SELECT name="cmb_encuentro" id="cmb_encuentro" class="GenerarEncuentros">
                                    <OPTION  selected value="0">Seleccione...</option>
                                    <OPTION  value="1">1</OPTION>
                                    <OPTION  value="2">2</OPTION>
                                    <OPTION  value="3">3</OPTION>
                                    </SELECT>
                </td>
                <td >
                    <font size="2"><b><label id="lbl_nrosesionesclases"></label></b></font>
                    
                </td >
                <td id="td_pdf" align="center" style="display:none;">
                        
                </td>
                
                <td id="td_guardar" align="center" style="display:none;">
                    <a href="#" id="a_GuardarAsistencia"><img title="Guardar Todas las Asistencias" src="../imagenes/savedatabase.png" alt="Guardar Todas las Asistencias" height="30" width="30" id="guardarasistencias"/></a>
                </td>
                
                

                
            </tr>   
            
        </table>     
    </div>   
                
        
    <table width="25%" id="table_sesiones">
        <tr>
            <td   align="center"><a id = "a_116" style="display:none;" href="#" class="VisualizarAsistencia116">1 - 16</a></td>   
            <td  align="center"><a id = "a_1732" style="display:none;" href="#" class="VisualizarAsistencia1732">17 - 32</a></td> 
            <td  align="center"><a id = "a_3348" style="display:none;" href="#" class="VisualizarAsistencia3348">33 - 48</a></td> 
        </tr> 
       
    </table>     
   
     
    
    <div style="display:none;" id="div_EncuentroDocente" class="datagrid">   
        <fieldset>
            <legend class="txtNormalSmall">ASISTENCIA DOCENTE</legend>
                <font size="4"><b><label id="lbl_ofertadocente"></label></b></font>
                <label style="display:none;" id="lbl_seccion"></label>
                <label style="display:none;" id="lbl_lapsovigencia"></label>
                <label style="display:none;" id="lbl_codcarr"></label>
                <label style="display:none;" id="lbl_codasign"></label>
                <label style="display:none;" id="lbl_codsede"></label>
                <label style="display:none;" id="lbl_lapsoacademico"></label>
                <label style="display:none;" id="lbl_carrera"></label>
                <label style="display:none;" id="lbl_asignatura"></label>
                <label style="display:none;" id="lbl_sede"></label>
                <label style="display:none;" id="lbl_docente"></label>
                <label style="display:none;" id="lbl_semestre"></label>
               
                 <table style="display:none;"  id="table_detalleasistencia" >
                            <thead>
                               
                               <tr>
                                   <th width="150px"></th>  
                                   <th align="center" colspan="16">SESIONES DE CLASES</th>  
                               </tr>
                              
                               <tr>
                                    <th width="150px" align="center">Fechas de Encuentro:</th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro1" id="txt_fechaencuentro1" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro1" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro1Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro2" id="txt_fechaencuentro2" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro2" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro2Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro3" id="txt_fechaencuentro3" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro3" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro3Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro4" id="txt_fechaencuentro4" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro4" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro4Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro5" id="txt_fechaencuentro5" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro5" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro5Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro6" id="txt_fechaencuentro6" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro6" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro6Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro7" id="txt_fechaencuentro7" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro7" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro7Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro8" id="txt_fechaencuentro8" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro8" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro8Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro9" id="txt_fechaencuentro9" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro9" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro9Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro10" id="txt_fechaencuentro10" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro10" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro10Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro11" id="txt_fechaencuentro11" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro11" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro11Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro12" id="txt_fechaencuentro12" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro12" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro12Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro13" id="txt_fechaencuentro13" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro13" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro13Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro14" id="txt_fechaencuentro14" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro14" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro14Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro15" id="txt_fechaencuentro15" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro15" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro15Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th width="35px" align="center"><input hidden name="txt_fechaencuentro16" id="txt_fechaencuentro16" type="date"></input><a href="#"><img src="../imagenes/asignarfecha.png" id = "img_Encuentro16" title="Asignar Fecha Encuentro" height="30" width="30"><img style="display:none;" src="../imagenes/fechaasignada.png" id = "img_Encuentro16Asig" title="Fecha Asignada" height="30" width="30"></th>
                                    <th style="display:none;" width="35px" align="center"></th>  
                               </tr>
                               <tr>
                                    
                                    <th width="150px" align="center">NOMBRES</th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th width="35px" align="center"></th>
                                    <th style="display:none;" width="35px" align="center"></th>
                                    
                               </tr>
                            </thead>   
                            <tbody>
  
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
      <td align="left"><img src="../imagenes/fechaasignada.png" title="Fecha Asignada" height="30" width="30"><b>Fecha de Encuentro Asignado</b><br></td>
  </tr>
   
  <tr> 
      <td align="left"><img src="../imagenes/asignarfecha.png" title="Fecha Por Asignar" height="30" width="30"><b>Por Asignar Fecha de Encuentro</b><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/asistencia.png" title="Ver Asistencia" height="30" width="30"><b>Ver Asistencias</b><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/savedatabase.png" title="Salvar Asistencias" height="30" width="30"><b>Guarda Asistencias sólo a los Encuentros que tengan asignado fecha de Encuentro</b> <img src="../imagenes/fechaasignada.png" title="Fecha Asignada" height="30" width="30"><br></td>
  </tr>
  <tr> 
      <td align="left"><img src="../imagenes/pdf.png" title="Exportar Control Asistencias Manual" height="30" width="30"><b>Exporta Control Manual de Asistencias</b></td>
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
