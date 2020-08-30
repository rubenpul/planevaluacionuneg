<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
    
    $opcion = $_POST['Opcion'];
    $cedulaDocente = $_POST['Cedula'];
    
    
    switch ($opcion){
        case 1: //GUARDAR TODA LA EVALUACION
                if(isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Tecnica']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                    $i=0;
                    $producto = $_POST["Producto"][$i];
                    $actividad = $_POST["Actividad"][$i];
                    $indicador = $_POST["Indicador"][$i];
                    $evaluacion = $_POST["Evaluacion"][$i];
                    $semana = $_POST["Semana"][$i];
                    echo $producto . " " . $actividad . " " . $indicador . " " . $evaluacion . " " . $semana;
                }    
                break;
        
        case 2: //CONSULTAR LOS INSTRUMENTOS DE EVALUACION
                
                $select="eval003d_id_instrumento,eval003d_descripcion";
                $from = "eval003d";
                $where="1=1";
                $groupby="";
                $orderby="eval003d_descripcion";

                $nro=0;
                $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                $combo = "<SELECT name=\"cmb_instrumento[]\" id=\"cmb_instrumento\" class=\"Combobox\">\n".
                             "<OPTION  selected value=\"00\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<OPTION  VALUE=" . trim($rs[$i]['eval003d_id_instrumento']) . ">" . strtoupper(utf8_encode(trim($rs[$i]['eval003d_descripcion'])))  . "</OPTION>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</SELECT>";
                
                echo $combo;        
                    
                break; 
                
         case 3: //GUARDAR UNA EVALUACION
                if(isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Instrumento']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                    $producto = $_POST["Producto"];
                    $actividad = $_POST["Actividad"];
                    $criterio = $_POST["Criterio"];
                    $instrumento = $_POST["Instrumento"];
                    $evaluacion = $_POST["Evaluacion"];
                    $semana = $_POST["Semana"];
                    echo $producto . " " . $actividad . " " . $criterio . " " . $instrumento . " " . $evaluacion . " " . $semana;
                
                    $select="eval003d_id_instrumento,eval003d_descripcion";
                         $from = "eval003d";
                         $where="1=1";
                         $groupby="";
                         $orderby="eval003d_descripcion";

                         $resp_bd = Ejecutar(1, "stg_003", $s_campos, $s_valores, "", 2);
                         $nro=0;
                         $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
 
                }    
                break;        
        case 4:
                //GENERAR OFERTAS ACADEMICAS DEL DOCENTE DADO UN LAPSO    
               if(isset($_POST['Cedula'])){      
                   $tabla= "";
                                            
                           
                    $lapso = Consultar_Lapso($cedulaDocente);
                    
                    $datos = Consultar_Asig_Lapso_Docente($nro,$lapso[0]['lapso'], $cedulaDocente);
               
                    $i=0;
                                        
                    while($i<$nro){
                        
                        if($i % 2){
                            $tabla = $tabla . "<tr class=\"alt\">";
                        }
                        else{
                            $tabla = $tabla . "<tr>";   
                        }
                        
                        $tabla = $tabla . "<td>". strtoupper(utf8_encode($datos[$i]["sce070d_cod_asign"] . "-" . trim($datos[$i]["sce090d_nom_asign"]))) . "</td>".
                        "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                        "<td align=\"center\">". $datos[$i]["sce070d_seccion"] . "</td> ".
                        "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/asistencia.png\" title=\"Generar Reporte de Asistencia;n\" class=\"GenerarAsistencia\" height=\"30\" width=\"30\"></a></td> " .
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                        "<td style=\"display:none;\">" .$lapso[0]['lapso'] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                        "<td style=\"display:none;\">" .$datos[$i]["sce025d_descripcion"] . "</td>".          
                        "<td style=\"display:none;\">" . strtoupper(utf8_encode(trim($datos[$i]["nombre"]))) . "</td>".          
                        "<td style=\"display:none;\">" .$datos[$i]["sce110d_semestre"] . "</td>".          
                        "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce090d_nom_asign"] . "</td>".      
                        "</tr>";         
                                                
                        $i++;
                    }  
                    
                    if ($nro == 0){
                         $tabla = $tabla . "<tr  class=\"alt\">".
                         $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $lapso[0]['lapso'] . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                         $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                         $tabla = $tabla . "</tr>"; 
                                 
                    }
                    
                        
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
               }    
                    
            
            break;
        
        case 5:
            //if(isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Instrumento']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                    
                    $i=0;
                    $id_evaluacion = GetMaxCodEvaluacion()+1;
                    
                    $date = getdate();
                    $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];
                    
                    $producto = $_POST["Producto"][$i];
                    $actividad = $_POST["Actividad"][$i];
                    $criterio = $_POST["Criterio"][$i];
                    $instrumento = $_POST["Instrumento"][$i];
                    $evaluacion = $_POST["Evaluacion"][$i];
                    $semana = $_POST["Semana"][$i];
                    $ideval = $_POST["IdEval"][$i];
                    
                    $carrera = $_POST['Carrera']; 
                    $asignatura = $_POST['Asignatura']; 
                    $sede = $_POST['Sede'];
                    $seccion = $_POST['Seccion'];
                    $lapsoacademico = $_POST['LapsoAcademico'];
                    $lapsovigencia = $_POST['LapsoVigencia'];
                                       
                    //echo $id_evaluacion . " " . $sede . " " . $carrera . " " . $seccion . " " . $asignatura . " " . $lapsoacademico . " " . $lapsovigencia . " " . $cedulaDocente . " " . $producto . " " . $actividad . " " . $criterio . " " . $instrumento . " " . $evaluacion . " " . $fecha_proceso . " " . 'ABIERTA' . " " . $semana . " " . $fecha_proceso . " " . $cedulaDocente;
                    echo $_POST["Producto"];
                    
           // }    
            break;

        case 6:
            
            if(isset($_POST["IdEval"]) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Instrumento']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                    
                    $i=0;
                    $id_evaluacion = GetMaxCodEvaluacion()+1;
                    
                    $date = getdate();
                    $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];
                    
                    $producto = $_POST["Producto"];
                    $actividad = $_POST["Actividad"];
                    $criterio = $_POST["Criterio"];
                    $instrumento = $_POST["Instrumento"];
                    $evaluacion = $_POST["Evaluacion"];
                    $semana = $_POST["Semana"];
                    $ideval = $_POST["IdEval"];
                    
                    $carrera = $_POST['Carrera']; 
                    $asignatura = $_POST['Asignatura']; 
                    $sede = $_POST['Sede'];
                    $seccion = $_POST['Seccion'];
                    $lapsoacademico = $_POST['LapsoAcademico'];
                    $lapsovigencia = $_POST['LapsoVigencia'];
                    
                    
                    if (trim($producto) != "" && trim($actividad) != "" && trim($criterio) != "" && trim($instrumento) != "00" && trim($evaluacion) != "" && trim($semana) != ""){ 
                    
                        GuardarEvaluacion($msg,$id_evaluacion,$sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$producto,$actividad,$criterio,$instrumento,$evaluacion,$fecha_proceso,1,$semana,$fecha_proceso,$cedulaDocente,$ideval);                   
                    }    
                    else{
                        $id_evaluacion = 0;
                    }
                    echo $id_evaluacion;
                    
            }    
            break;        
        
        case 7:
            
            if(isset($_POST['StartEval']) && isset($_POST['EndEval']) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
            
                    $carrera = $_POST['Carrera']; 
                    $asignatura = $_POST['Asignatura']; 
                    $sede = $_POST['Sede'];
                    $seccion = $_POST['Seccion'];
                    $lapsoacademico = $_POST['LapsoAcademico'];
                    $lapsovigencia = $_POST['LapsoVigencia'];
                    $ceduladoc = $_POST['Cedula'];
                    $starteval = $_POST['StartEval'];
                    
                    $datos = ConsultarEstudiantes($nro,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                                        
                    $i=0;
                    $resultado = "";
                    $tabla = "";
                    
                        while($i<$nro){

                            $resultado = $datos[$i]['sce020d_cedula'] . " " . $datos[$i]['primer_apellido'] . " " . $datos[$i]['primer_nombre'];
                                                                                                                               
                                                                                          
                            $tabla = $tabla . "<tr>".
                            "<td width='150px'>". strtoupper(utf8_encode(trim($resultado))) . "</td>";
                            $datosasist = ConsultarAsistEst($nro2,$starteval,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro1[]\" id=\"encuentro1\" maxlength=\"1\" size=\"1\" class=\"Asistencia01\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro1[]\" id=\"encuentro1\" maxlength=\"1\" size=\"1\" class=\"Asistencia01\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+1,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+1){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro2[]\" id=\"encuentro2\" maxlength=\"1\" size=\"1\" class=\"Asistencia02\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro2[]\" id=\"encuentro2\" maxlength=\"1\" size=\"1\" class=\"Asistencia02\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+2,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+2){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro3[]\" id=\"encuentro3\" maxlength=\"1\" size=\"1\" class=\"Asistencia03\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro3[]\" id=\"encuentro3\" maxlength=\"1\" size=\"1\" class=\"Asistencia03\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+3,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+3){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro4[]\" id=\"encuentro4\" maxlength=\"1\" size=\"1\" class=\"Asistencia04\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro4[]\" id=\"encuentro4\" maxlength=\"1\" size=\"1\" class=\"Asistencia04\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+4,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+4){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro5[]\" id=\"encuentro5\" maxlength=\"1\" size=\"1\" class=\"Asistencia05\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro5[]\" id=\"encuentro5\" maxlength=\"1\" size=\"1\" class=\"Asistencia05\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+5,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+5){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro6[]\" id=\"encuentro6\" maxlength=\"1\" size=\"1\" class=\"Asistencia06\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro6[]\" id=\"encuentro6\" maxlength=\"1\" size=\"1\" class=\"Asistencia06\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+6,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+6){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro7[]\" id=\"encuentro7\" maxlength=\"1\" size=\"1\" class=\"Asistencia07\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro7[]\" id=\"encuentro7\" maxlength=\"1\" size=\"1\" class=\"Asistencia07\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+7,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+7){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro8[]\" id=\"encuentro8\" maxlength=\"1\" size=\"1\" class=\"Asistencia08\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro8[]\" id=\"encuentro8\" maxlength=\"1\" size=\"1\" class=\"Asistencia08\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+8,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+8){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentro9[]\" id=\"encuentro9\" maxlength=\"1\" size=\"1\" class=\"Asistencia09\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentro9[]\" id=\"encuentro9\" maxlength=\"1\" size=\"1\" class=\"Asistencia09\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+9,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+9){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA10[]\" id=\"encuentroA10\" maxlength=\"1\" size=\"1\" class=\"Asistencia10\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA10[]\" id=\"encuentroA10\" maxlength=\"1\" size=\"1\" class=\"Asistencia10\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+10,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+10){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA11[]\" id=\"encuentroA11\" maxlength=\"1\" size=\"1\" class=\"Asistencia11\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA11[]\" id=\"encuentroA11\" maxlength=\"1\" size=\"1\" class=\"Asistencia11\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+11,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+11){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA12[]\" id=\"encuentroA12\" maxlength=\"1\" size=\"1\" class=\"Asistencia12\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA12[]\" id=\"encuentroA12\" maxlength=\"1\" size=\"1\" class=\"Asistencia12\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+12,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+12){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA13[]\" id=\"encuentroA13\" maxlength=\"1\" size=\"1\" class=\"Asistencia13\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA13[]\" id=\"encuentroA13\" maxlength=\"1\" size=\"1\" class=\"Asistencia13\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+13,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);                                
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+13){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA14[]\" id=\"encuentroA14\" maxlength=\"1\" size=\"1\" class=\"Asistencia14\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA14[]\" id=\"encuentroA14\" maxlength=\"1\" size=\"1\" class=\"Asistencia14\" checked></input></td>";    
                            }

                            $datosasist = ConsultarAsistEst($nro2,$starteval+14,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+14){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA15[]\" id=\"encuentroA15\" maxlength=\"1\" size=\"1\" class=\"Asistencia15\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA15[]\" id=\"encuentroA15\" maxlength=\"1\" size=\"1\" class=\"Asistencia15\" checked></input></td>";    
                            }


                            $datosasist = ConsultarAsistEst($nro2,$starteval+15,$datos[$i]['sce020d_cedula'],$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                            if($datosasist[0]['eval005d_id_encuentro'] == $starteval+15){
                                $tabla = $tabla . "<td width='35px'><input disabled type=\"checkbox\" name=\"encuentroA16[]\" id=\"encuentroA16\" maxlength=\"1\" size=\"1\" class=\"Asistencia16\" " . ConvertirAsist($datosasist[0]['eval005d_asistencia']) . "></input></td>";                                  
                            }
                            else{
                                $tabla = $tabla . "<td width='35px'><input type=\"checkbox\" name=\"encuentroA16[]\" id=\"encuentroA16\" maxlength=\"1\" size=\"1\" class=\"Asistencia16\" checked></input></td>";    
                            }

                            $tabla = $tabla ."<td style=\"display:none;\" width='35px'><input name=\"cedula[]\" id=\"cedula\" maxlength=\"1\" size=\"1\" class=\"Asistencia\" value = " .  $datos[$i]['sce020d_cedula'] . "></input></td>".                      
                            "</tr>";
                              
                                         
                           $i++;       
                        }
                  
                            
                                        
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
            }        
            break;

        case 8: //GUARDAR TODA LAS ASISTENCIAS
            
                if(isset($_POST['NroEncuentro'])  && isset($_POST['FechaEncuentro'])  && isset($_POST['IdEncuentro'])  && isset($_POST['CedulaAsistencia'])  && isset($_POST['Encuentro1']) && isset($_POST['Encuentro2']) && isset($_POST['Encuentro3']) && isset($_POST['Encuentro4']) && isset($_POST['Encuentro5']) && isset($_POST['Encuentro6']) && isset($_POST['Encuentro7']) && isset($_POST['Encuentro8']) && isset($_POST['Encuentro9']) && isset($_POST['EncuentroA10']) && isset($_POST['EncuentroA11']) && isset($_POST['EncuentroA12']) && isset($_POST['EncuentroA13']) && isset($_POST['EncuentroA14']) && isset($_POST['EncuentroA15']) && isset($_POST['EncuentroA16']) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia'])){
                    $i=0;
                    $carrera = $_POST['Carrera']; 
                    $asignatura = $_POST['Asignatura']; 
                    $sede = $_POST['Sede'];
                    $seccion = $_POST['Seccion'];
                    $lapsoacademico = $_POST['LapsoAcademico'];
                    $lapsovigencia = $_POST['LapsoVigencia'];
                    $ceduladoc = $_POST['Cedula'];
                    $nroencuentro = $_POST['NroEncuentro'];
                    $startEval = $_POST['IdEncuentro'][0];
                    $endEval = $_POST['IdEncuentro'][count($_POST['IdEncuentro'])-1];
                    
                    
                    $date = getdate();
                    $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];
                    
                    BorrarAsistencia($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$startEval,$endEval);                
                                        
                    while ($i< count($_POST['CedulaAsistencia'])){
                        $cedulaEst = $_POST['CedulaAsistencia'][$i];
                        $idencuentro = $_POST['IdEncuentro'][$i];                     
                        $encuentro1 = $_POST['Encuentro1'][$i];
                        $encuentro2 = $_POST['Encuentro2'][$i];
                        $encuentro3 = $_POST['Encuentro3'][$i];
                        $encuentro4 = $_POST['Encuentro4'][$i];
                        $encuentro5 = $_POST['Encuentro5'][$i];
                        $encuentro6 = $_POST['Encuentro6'][$i];
                        $encuentro7 = $_POST['Encuentro7'][$i];
                        $encuentro8 = $_POST['Encuentro8'][$i];
                        $encuentro9 = $_POST['Encuentro9'][$i];
                        $encuentro10 = $_POST['EncuentroA10'][$i];
                        $encuentro11 = $_POST['EncuentroA11'][$i];
                        $encuentro12 = $_POST['EncuentroA12'][$i];
                        $encuentro13 = $_POST['EncuentroA13'][$i];
                        $encuentro14 = $_POST['EncuentroA14'][$i];
                        $encuentro15 = $_POST['EncuentroA15'][$i];
                        $encuentro16 = $_POST['EncuentroA16'][$i];
                        
                        if (trim($_POST['FechaEncuentro'][0]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro1,$_POST['FechaEncuentro'][0],$fecha_proceso,$_POST['IdEncuentro'][0],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }   
                        if (trim($_POST['FechaEncuentro'][1]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro2,$_POST['FechaEncuentro'][1],$fecha_proceso,$_POST['IdEncuentro'][1],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }
                        if (trim($_POST['FechaEncuentro'][2]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro3,$_POST['FechaEncuentro'][2],$fecha_proceso,$_POST['IdEncuentro'][2],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }    
                        if (trim($_POST['FechaEncuentro'][3]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro4,$_POST['FechaEncuentro'][3],$fecha_proceso,$_POST['IdEncuentro'][3],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }
                        if (trim($_POST['FechaEncuentro'][4]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro5,$_POST['FechaEncuentro'][4],$fecha_proceso,$_POST['IdEncuentro'][4],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }
                        if (trim($_POST['FechaEncuentro'][5]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro6,$_POST['FechaEncuentro'][5],$fecha_proceso,$_POST['IdEncuentro'][5],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }    
                        if (trim($_POST['FechaEncuentro'][6]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro7,$_POST['FechaEncuentro'][6],$fecha_proceso,$_POST['IdEncuentro'][6],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }    
                        if (trim($_POST['FechaEncuentro'][7]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro8,$_POST['FechaEncuentro'][7],$fecha_proceso,$_POST['IdEncuentro'][7],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }
                        if (trim($_POST['FechaEncuentro'][8]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro9,$_POST['FechaEncuentro'][8],$fecha_proceso,$_POST['IdEncuentro'][8],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }    
                        if (trim($_POST['FechaEncuentro'][9]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro10,$_POST['FechaEncuentro'][9],$fecha_proceso,$_POST['IdEncuentro'][9],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }
                        if (trim($_POST['FechaEncuentro'][10]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro11,$_POST['FechaEncuentro'][10],$fecha_proceso,$_POST['IdEncuentro'][10],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }    
                        if (trim($_POST['FechaEncuentro'][11]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro12,$_POST['FechaEncuentro'][11],$fecha_proceso,$_POST['IdEncuentro'][11],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }    
                        if (trim($_POST['FechaEncuentro'][12]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro13,$_POST['FechaEncuentro'][12],$fecha_proceso,$_POST['IdEncuentro'][12],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }
                        if (trim($_POST['FechaEncuentro'][13]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro14,$_POST['FechaEncuentro'][13],$fecha_proceso,$_POST['IdEncuentro'][13],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }    
                        if (trim($_POST['FechaEncuentro'][14]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro15,$_POST['FechaEncuentro'][14],$fecha_proceso,$_POST['IdEncuentro'][14],$fecha_proceso,$cedulaDocente,$nroencuentro);  
                        }    
                        if (trim($_POST['FechaEncuentro'][15]) != ''){
                            GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$cedulaEst,$encuentro16,$_POST['FechaEncuentro'][15],$fecha_proceso,$_POST['IdEncuentro'][15],$fecha_proceso,$cedulaDocente,$nroencuentro); 
                        }    
                        
                        $i++;
                    }
                    
                    echo 1 ;
                    
                    
                }   
                else{
                    echo 0;
                }    
                break;      
                
        case 9:        
            
            if(isset($_POST['Encuentro']) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
                
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $fechaencuentro="";
                
                $i=0;
                
                while($i<count($_POST['Encuentro'])){
                
                    $dato = ConsultarFechaEncuentro($nro, $_POST['Encuentro'][$i], $ceduladoc, $lapsoacademico, $sede, $carrera, $seccion, $asignatura, $lapsovigencia);
            
                    if (trim($dato[0]['eval005d_fecha_encuentro']) != ''){
                        $fechaencuentro = $fechaencuentro . trim($dato[0]['eval005d_fecha_encuentro']) . "!!";
                    }
                    else{
                        $fechaencuentro = $fechaencuentro . "0" . "!!";
                    }
                    $i++;
                    
                }
                
                echo $fechaencuentro;
            }
            break;
            
        case 10:        
            
            if(isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
                
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $fechaencuentro="";
                
                $i=0;
                
                $dato = ConsultarNroEncuentro($nro,$ceduladoc, $lapsoacademico, $sede, $carrera, $seccion, $asignatura, $lapsovigencia);
                         
                echo $dato[0]['encuentro'];
            }
            break;    

       case 11:
                //GENERAR OFERTAS ACADEMICAS DEL DOCENTE DADO UN LAPSO    
               if(isset($_POST['Cedula'])){      
                   $tabla= "";
                                            
                           
                    $datos = ConsultarLapsoCIVA($nro);
                    
                    
                    if($nro > 0){
                        $lapso = $datos[0]['sce016d_lapso_acad'];
                    }    
                    else{
                        $lapso = 'NoRegistro';
                    }                                       
                    
                    
                    if ($lapso != 'NoRegistro'){
                    
                                        
                            $datos = Consultar_Asig_Lapso_Docente($nro,$lapso,$cedulaDocente);

                            $i=0;

                            while($i<$nro){

                                if($i % 2){
                                    $tabla = $tabla . "<tr class=\"alt\">";
                                }
                                else{
                                    $tabla = $tabla . "<tr>";   
                                }

                                $tabla = $tabla . "<td>". strtoupper(utf8_encode($datos[$i]["sce070d_cod_asign"] . "-" . trim($datos[$i]["sce090d_nom_asign"]))) . "</td>".
                                "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                                "<td align=\"center\">". $datos[$i]["sce070d_seccion"] . "</td> ".
                                "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/asistencia.png\" title=\"Generar Reporte de Asistencia;n\" class=\"GenerarAsistencia\" height=\"30\" width=\"30\"></a></td> " .
                                "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                                "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                                "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                                "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                                "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                                "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                                "<td style=\"display:none;\">" .$datos[$i]["sce025d_descripcion"] . "</td>".          
                                "<td style=\"display:none;\">" . strtoupper(utf8_encode(trim($datos[$i]["nombre"]))) . "</td>".          
                                "<td style=\"display:none;\">" .$datos[$i]["sce110d_semestre"] . "</td>".          
                                "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".        
                                "<td style=\"display:none;\">" .$datos[$i]["sce090d_nom_asign"] . "</td>".      
                                "</tr>";         

                                $i++;
                            }  

                            if ($nro == 0){
                                 $tabla = $tabla . "<tr  class=\"alt\">".
                                 $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $lapso[0]['lapso'] . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                                 $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                                 $tabla = $tabla . "</tr>"; 

                            }


                            $tabla = $tabla . "</tbody></table>";
                            echo $tabla;
                            
                    }
                    else{
                        $tabla = $tabla . "<tr  class=\"alt\">".
                        $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO HAY REGISTRO DE CIVA ". "DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                        $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                        $tabla = $tabla . "</tr>"; 
                        echo $tabla;
                    }                            
                            
               }    
                    
            
            break;

            
    }//fin switch
} 
   

               
