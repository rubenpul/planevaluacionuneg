<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
    
    $opcion = $_POST['Opcion'];
    $cedulaDocente = $_POST['Cedula'];
    $cedulaAct = $_POST['CedulaAct'];
    $carrera = $_POST['Carrera'];
    $asignatura = $_POST['Asignatura'];
    $seccion = $_POST['Seccion'];
    $sede = $_POST['Sede'];
    $lapsoacademico = $_POST['LapsoAcademico'];
    $lapsovigencia = $_POST['LapsoVigencia'];
    
    switch ($opcion){
    
        case 1:
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
                        
                        $tabla = $tabla . "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce070d_cod_asign"] . "-" . $datos[$i]["sce090d_nom_asign"]))) . "</td>".
                        "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                        "<td align=\"center\">". $datos[$i]["sce070d_seccion"] . "</td> ".
                        "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Generar Productos de Evaluaci&oacute;n\" class=\"GenerarProductos\" height=\"30\" width=\"30\" name=\"ClickProducto\"></a></td> " .
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                        "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".        
                        "<td style=\"display:none;\">" . $datos[$i]["lapso_sys"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce110d_semestre"] . "</td>".
                        "<td style=\"display:none;\">" .utf8_encode(trim($datos[$i]["sce090d_nom_asign"])) . "</td>".        
                        
                        "</tr>";         
                                                
                        $i++;
                    }    
                    
                    if ($nro == 0){
                         $tabla = $tabla . "<tr  class=\"alt\">".
                         $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $datos[$i]["lapso"] . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                         $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                         $tabla = $tabla . "</tr>"; 
                                 
                    }
                        
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
               }    
                    
            
            break;
        
        case 2:   
            
            if (isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
                    $tabla= "";
                                                 
                    $datos = ConsultarProductosDocente($nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
               
                    ConsultarEstudiantesNotas($nroest,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);                  
                    ConsultarEstudiantesConNotas($nroestcur,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);                  
                    
                    $i=0;    
                    $idproducto = $i + 1;
                    $semana = 1;
                    
                    while($i<$nro){
                        
                        if($i % 2){
                            $tabla = $tabla . "<tr class=\"alt\">";
                        }
                        else{
                            $tabla = $tabla . "<tr>";   
                        }
                        
                        $estatus = ConsultarStatusEvaluacion($datos[$i]["eval001d_id_evaluacion"]);
                        
                        $fechaevaluacion = ConsultarFechaEvaluacion($datos[$i]["eval001d_id_evaluacion"]);
                        
                        $semana = ConsultarSemanaEvaluacion($datos[$i]["eval001d_id_evaluacion"]);
                        
                        $fechaevaluacion2 = formatearFecha($fechaevaluacion);
                        
                        if ($fechaevaluacion2 == 0){
                            $fechaevaluacion2 = "";
                        }
                        
                        $tabla = $tabla . "<td>". $idproducto . "</td>".
                        "<td>". strtoupper(trim($datos[$i]["eval001d_producto"])) . "</td>". 
                        "<td align=\"center\">". $datos[$i]["eval001d_ponderacion"] . "</td> ".
                        "<td align=\"center\">". $datos[$i]["eval001d_sem_planificacion"] . "</td> ".
                        "<td align=\"center\"><a href=\"#\">" .  AgregarRutaEvaluacion($estatus) . "</a></td> " .
                        "<td style=\"display:none;\" >". $datos[$i]["eval001d_id_evaluacion"] . "</td>".
                        "<td style=\"display:none;\" >". $estatus . "</td>".   
                        "<td style=\"display:none;\" >". $fechaevaluacion . "</td>".   
                        "<td>". $fechaevaluacion2 . "</td>".
                        "<td align=\"center\">". $semana . "</td>". 
                        "<td style=\"display:none;\">". $nroest . "</td>".  
                        "<td style=\"display:none;\">". $nroestcur . "</td>".         
                        "</tr>";         
                        $idproducto = $idproducto + 1;                        
                        $i++;
                        
                    }    
                        
                    if ($nro == 0){
                         $tabla = $tabla . "<tr  class=\"alt\">".
                         $tabla = $tabla . "<td colspan = \"9\" width=\"200px\" align=\"center\">NO HA REGISTRADO EL PLAN DE EVALUACI&Oacute;N"  . "</td>".     
                         $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                         $tabla = $tabla . "</tr>"; 
                                 
                    }
                    
                    
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
                
            }
            
             break;
        
        case 3:
            
            if(isset($_POST['IdEvalAprob']) && isset($_POST['IdEval']) && isset($_POST['Cedula']) && isset($_POST['Carrera'])  && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
            
                    $carrera = $_POST['Carrera']; 
                    $asignatura = $_POST['Asignatura']; 
                    $sede = $_POST['Sede'];
                    $seccion = $_POST['Seccion'];
                    $lapsoacademico = $_POST['LapsoAcademico'];
                    $lapsovigencia = $_POST['LapsoVigencia'];
                    $ceduladoc = $_POST['Cedula'];
                    $ideval = $_POST['IdEval'];
                    $idevalaprob = $_POST['IdEvalAprob'];
                    
                    if ($idevalaprob != -1){
                        ActualizarStatusEvaluacion($idevalaprob);
                        
                    }
                    
                    
                    $datos = ConsultarEstudiantes($nro,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                                    
                    
                    $i=0;
                    $resultado = "";
                    $tabla = "";
                    $id = $i+1;
                    while($i<$nro){
                        $tabla = $tabla . "<tr>".
                        "<td>" . $id . "</td>".        
                        "<td width='300px'>". $datos[$i]['sce020d_cedula'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) ."</td>" . 
                        "<td width='75px'><input type=\"text\" name=\"nota[]\" id=\"nota\" maxlength=\"5\" size=\"2\" class=\"NotaEstudiante\"></input></td>" .
                        "<td width='75px'><input type=\"checkbox\" name=\"asistencia[]\" id=\"asistencia\" checked class=\"ActualizarAsistencia\"></input></td>" .
                        "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"notabd[]\" id=\"notabd\" maxlength=\"5\" size=\"3\" class=\"NotaEstudianteBD\"></input><font size=\"3\"></font></td>" .
                        "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"cedula[]\" id=\"cedula\" maxlength=\"4\" size=\"2\" class=\"CedulaEst\" value = \"" . trim($datos[$i]['sce020d_cedula']) . "\"></input></td>" .
                        "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"ideval[]\" id=\"ideval\" maxlength=\"4\" size=\"2\" class=\"ideval\" value = \"" . $ideval . "\"></td>" .
                        "</tr>";
                        $id++;
                        $i++;       
                    }
                 
                                        
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
            }        
            break;
            
        case 4:
            
            if (isset($_POST['IdStatus']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdEval']) && isset($_POST['CedulaEst']) && isset($_POST['Ponderacion']) && isset($_POST['Asistencia']) && isset($_POST['FechaEvaluacion']) && isset($_POST['SemEvaluacion'])){
                $date = getdate();
                $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];
                $fechaevaluacion = $_POST['FechaEvaluacion'];
                $semana = $_POST['SemEvaluacion'];
                $status = $_POST['IdStatus'];
                
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $idproductosdef = $_POST['IdProductosDef'];
                $nota = $_POST['ValorNota'];
                
                
                $i=0;
                
                if ($i==0){
                    ActualizarStatusPlanEvaluacion($_POST["IdEval"][0]);
                }    
                
                while($i<count($_POST["IdEval"])){
                    
                    $ideval = $_POST["IdEval"][$i];
                    $cedula = $_POST["CedulaEst"][$i];
                    $poderacion = $_POST["Ponderacion"][$i];
                    $asistio = $_POST["Asistencia"][$i];
                    $expediente = GetExpedienteEstudiante($cedula,$lapsoacademico,$carrera);

                    if (trim($poderacion) == "0" || trim($poderacion) == ""){
                        $asistio = "0";
                    }
                    
                    do{


                    }while (($resp_bd = GuardarPonderacion($msg,$ideval,$cedula,$expediente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$poderacion,0/*definitiva*/,0 /*abandono*/,$asistio,$cedulaDocente,0/*nro de acta*/,$semana,$fecha_proceso,$fecha_proceso,$cedulaAct,1/*estatus*/,$fechaevaluacion,"")) != "");
                                       
                    GetNotaDefinitiva($cedula,$cedulaDocente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$idproductosdef);
                    
                     $i++;
                    
                }
                
               GetNumeroActa($cedulaDocente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico);       
                
                //CREAR DATOS PARA LA SESION EN CASO QUE VAYA GENERAR EL ACTA
                $datos = ConsultarEstudiantesPonderacion($nro,$_POST["IdEval"][0],$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                
                $_SESSION['lendataacta'] = serialize($nro);
                
                $_SESSION['desproducto'] = serialize(utf8_decode($_POST['DesProducto']));
                $_SESSION['dessemestre'] = serialize($_POST['DesSemestre']);
                $_SESSION['desasign'] = serialize(utf8_decode($_POST['DesAsignatura']));
                $_SESSION['descarr'] = serialize(utf8_decode($_POST['DesCarrera']));
                $_SESSION['dessede'] = serialize(utf8_decode(GetNombreSede($_POST['Sede'])));
                $_SESSION['desseccion'] = serialize($_POST['Seccion']);
                $_SESSION['ceduladoc'] = serialize($cedulaDocente);
                $_SESSION['docente'] = serialize(GetNameDocente($cedulaDocente));
                $_SESSION['ponderacion'] = serialize($nota);
                $_SESSION['dataacta'] = serialize($datos);
                               
                echo 1;
                       
            }
            else{
                
                echo -1;
            }
                        
            
            break;
            
        case 5:
            
            if (isset($_POST['DesSemestre']) && isset($_POST['DesAsignatura']) && isset($_POST['DesCarrera']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdEval'])){
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $ideval = $_POST['IdEval'];
                $producto = $_POST['DesProducto'];
                $ponderacion = $_POST['Ponderacion'];
                

                $datos = ConsultarEstudiantesPonderacion($nro,$ideval,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);

                             
                
                $_SESSION['lendataacta'] = serialize($nro);
                
                $_SESSION['desproducto'] = serialize(utf8_decode($_POST['DesProducto']));
                $_SESSION['dessemestre'] = serialize($_POST['DesSemestre']);
                $_SESSION['desasign'] = serialize(utf8_decode($_POST['DesAsignatura']));
                $_SESSION['descarr'] = serialize(utf8_decode($_POST['DesCarrera']));
                $_SESSION['dessede'] = serialize(utf8_decode(GetNombreSede($_POST['Sede'])));
                $_SESSION['desseccion'] = serialize($_POST['Seccion']);
                $_SESSION['ceduladoc'] = serialize($ceduladoc);
                $_SESSION['docente'] = serialize(GetNameDocente($ceduladoc));
                $_SESSION['ponderacion'] = serialize($ponderacion);
                $_SESSION['dataacta'] = serialize($datos);
                
                $i=0;
                $resultado = "";
                $tabla = "";
                $id = $i+1;
                while($i<$nro){
                    $tabla = $tabla . "<tr>".
                    "<td>" . $id . "</td>".        
                    "<td width='300px'>". $datos[$i]['eval002d_cedula_est'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) . "</td>" . 
                    "<td width='75px'><input type=\"text\" name=\"nota[]\" id=\"nota\" maxlength=\"5\" size=\"2\" class=\"NotaEstudiante\"" . AsistenciaEstudianteEvaluacion($datos[$i]['eval002d_no_asistio'],1) . " value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input></td>" .
                    "<td width='75px'><input type=\"checkbox\" name=\"asistencia[]\" id=\"asistencia\" class=\"ActualizarAsistencia\"" . AsistenciaEstudianteEvaluacion($datos[$i]['eval002d_no_asistio'],2) . "></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"notabd[]\" id=\"notabd\" maxlength=\"5\" size=\"3\" class=\"NotaEstudianteBD\" value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input><font size=\"3\"></font></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"cedula[]\" id=\"cedula\" maxlength=\"4\" size=\"2\" class=\"CedulaEst\" value = \"" . $datos[$i]['eval002d_cedula_est'] ."\"></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"ideval[]\" id=\"ideval\" maxlength=\"4\" size=\"2\" class=\"ideval\" value = \"" . $ideval . "\"></input></td>" .
                    "</tr>";
                    $id++;
                    $i++;       
                }


                $tabla = $tabla . "</tbody></table>";
                echo $tabla;
            }        
            break;
    
        case 6:
            
            if (isset($_POST['DesSemestre']) && isset($_POST['DesAsignatura']) && isset($_POST['DesCarrera']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdEval'])){
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $ideval = $_POST['IdEval'];
                $ponderacion = $_POST['Ponderacion'];
                
                $datos = ConsultarEstudiantesPonderacion($nro,$ideval,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);

                $_SESSION['lendataacta'] = serialize($nro);
                
                $_SESSION['desproducto'] = serialize(utf8_decode($_POST['DesProducto']));
                $_SESSION['dessemestre'] = serialize($_POST['DesSemestre']);
                $_SESSION['desasign'] = serialize(utf8_decode($_POST['DesAsignatura']));
                $_SESSION['descarr'] = serialize(utf8_decode($_POST['DesCarrera']));
                $_SESSION['dessede'] = serialize(utf8_decode(GetNombreSede($_POST['Sede'])));
                $_SESSION['desseccion'] = serialize($_POST['Seccion']);
                $_SESSION['ceduladoc'] = serialize($ceduladoc);
                $_SESSION['docente'] = serialize(GetNameDocente($ceduladoc));
                $_SESSION['ponderacion'] = serialize($ponderacion);
                $_SESSION['dataacta'] = serialize($datos);                

                $i=0;
                $resultado = "";
                $tabla = "";
                $id = $i+1;
                while($i<$nro){
                    $tabla = $tabla . "<tr>".
                    "<td>" . $id . "</td>".        
                    "<td width='300px'>". $datos[$i]['eval002d_cedula_est'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) . "</td>" . 
                    "<td width='75px'><input disabled type=\"text\" name=\"nota[]\" id=\"nota\" maxlength=\"5\" size=\"2\" class=\"NotaEstudiante\" value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input></td>" .
                    "<td width='75px'><input disabled type=\"checkbox\" name=\"asistencia[]\" id=\"asistencia\" class=\"ActualizarAsistencia\"" . AsistenciaEstudianteEvaluacion($datos[$i]['eval002d_no_asistio'],2) . "></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"notabd[]\" id=\"notabd\" maxlength=\"5\" size=\"3\" class=\"NotaEstudianteBD\" value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input><font size=\"3\"></font></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"cedula[]\" id=\"cedula\" maxlength=\"4\" size=\"2\" class=\"CedulaEst\" value = \"" . $datos[$i]['eval002d_cedula_est'] ."\"></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"ideval[]\" id=\"ideval\" maxlength=\"4\" size=\"2\" class=\"ideval\" value = \"" . $ideval . "\"></input></td>" .
                    "<td width='75px'><input type=\"button\" name=\"actualizarnotaaprob[]\" id=\"actualizarnotaaprob\" maxlength=\"4\" size=\"2\" class=\"ActualizarNotaAprob\" value = \"ACTUALIZAR\"></input></td>" .
                    "<td width='75px'><input disabled type=\"button\" name=\"guardarnotaaprob[]\" id=\"guardarnotaaprob\" maxlength=\"4\" size=\"2\" class=\"GuardarNotaAprob\" value = \"GUARDAR\"></input></td>" .
                    "</tr>";
                    $id++;
                    $i++;       
                }


                $tabla = $tabla . "</tbody></table>";
                echo $tabla;
            }        
            break;    
            
        case 7:   
            
            //CONSULTAR LAPSOS CARGADOS DE EVALUACION DOCENTE
            
            if(isset($_POST["Cedula"])){ 
            
                $datos = ConsultarLapsosCargadosEvaDocente($nro,$cedulaDocente);

                $combolapso = "<select name=\"cmb_lapsoconsulta\" id=\"cmb_lapsoconsulta\" class=\"Combobox\">".
                             "<OPTION  selected value=\"0\">Seleccione...</option>";
                               
                if ($nro > 0){	
                    $i=0;  
                    
                    while ($i<$nro) {
                        
                        $combolapso = $combolapso. "<OPTION  VALUE=" . $datos[$i]['eval002d_lapsoacademico'] . ">" . $datos[$i]['lapsofront']  . "</OPTION>\n";
                        $i++;
                        
                    }    
                     $combolapso = $combolapso. "</SELECT>";
                     
                   
                }    
                 echo $combolapso;
            }
            else{
                
                echo 0;
            }
            break;                      

        case 8:
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
                        
                        $tabla = $tabla . "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce070d_cod_asign"] . "-" . $datos[$i]["sce090d_nom_asign"]))) . "</td>".
                        "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                        "<td align=\"center\">". $datos[$i]["sce070d_seccion"] . "</td> ".
                        "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Generar Productos de Evaluaci&oacute;n\" class=\"GenerarProductos\" height=\"30\" width=\"30\" name=\"ClickProducto\"></a></td> " .
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                        "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".        
                        "<td style=\"display:none;\">" . $datos[$i]["lapso_sys"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce110d_semestre"] . "</td>".
                        "<td style=\"display:none;\">" .utf8_encode(trim($datos[$i]["sce090d_nom_asign"])) . "</td>".        
                        
                        "</tr>";        
                                                                       
                        $i++;
                    }    
                    
                    if ($nro == 0){
                         $tabla = $tabla . "<tr  class=\"alt\">".
                         $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $lapso . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                         $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                         $tabla = $tabla . "</tr>"; 
                                 
                    }
                        
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
               }    
                    
            
            break;

        case 9:
                
               //GENERAR OFERTAS ACADEMICAS DEL DOCENTE DADO UN LAPSO    
               if(isset($_POST['Cedula'])){      
                   $tabla= "";
                                           
                           
                    //CONSULTAR LAPSO CIVA   
                          
                    $datos = ConsultarLapsoCIVA($nro);

                    if($nro > 0){
                        $lapso = $datos[0]['sce016d_lapso_acad'];
                    }    
                    else{
                        $lapso = 'NoRegistro';
                    }                                       
                    
                    
                    if ($lapso != 'NoRegistro'){
                        $datos = Consultar_Asig_Lapso_Docente_2($nro,$lapso, $cedulaDocente);

                        $i=0;

                        while($i<$nro){

                            if($i % 2){
                                $tabla = $tabla . "<tr class=\"alt\">";
                            }
                            else{
                                $tabla = $tabla . "<tr>";   
                            }

                            $tabla = $tabla . "<td>". strtoupper(utf8_encode(trim($datos[$i]["eval001d_cod_asignatura"] . "-" . $datos[$i]["sce090d_nom_asign"]))) . "</td>".
                            "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                            "<td align=\"center\">". $datos[$i]["eval001d_cod_seccion"] . "</td> ".
                            "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Generar Productos de Evaluaci&oacute;n\" class=\"GenerarProductos\" height=\"30\" width=\"30\"></a></td> " .
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_lapso_vigencia"] . "</td>".        
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_carrera"] . "</td>".                
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_asignatura"] . "</td>". 
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_sede"] . "</td>". 
                            "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cedula_docente"] . "</td>".          
                            "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".        
                            "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                            "<td style=\"display:none;\">" .$datos[$i]["sce110d_semestre"] . "</td>".        
                            "<td style=\"display:none;\">" .utf8_encode(trim($datos[$i]["sce090d_nom_asign"])) . "</td>".        
                            
                            "</tr>";         

                            $i++;
                        }    

                        if ($nro == 0){
                             $tabla = $tabla . "<tr  class=\"alt\">".
                             $tabla = $tabla . "<td colspan = \"10\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $lapso . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
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
            
        case 10:
            
            //ACTUALIZAR UNA NOTA APROBADA
            
            if (isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdEval']) && isset($_POST['CedulaEst']) && isset($_POST['Ponderacion']) && isset($_POST['Asistencia']) && isset($_POST['FechaEvaluacion'])){
                $date = getdate();
                $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];
                $fechaevaluacion = $_POST['FechaEvaluacion'];
                $semana = 0 ; //GetSemanaAcademica($fechaevaluacion);
                
                
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ponderacionold = $_POST['PonderacionOld']; 
                $justificacion = $_POST['Justificacion']; 
                $idproductosdef = $_POST['IdProductosDef'];
                
                $i=0;
                
                if ($i==0){
                    ActualizarStatusPlanEvaluacion($_POST["IdEval"]);
                }    
                
                $ideval = $_POST["IdEval"];
                $cedula = $_POST["CedulaEst"];
                $poderacion = $_POST["Ponderacion"];
                $asistio = $_POST["Asistencia"];
                $expediente = GetExpedienteEstudiante($cedula,$lapsoacademico,$carrera);

                do{


                }while (($resp_bd = GuardarPonderacion($msg,$ideval,$cedula,$expediente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$poderacion,0/*definitiva*/,0 /*abandono*/,$asistio,$cedulaDocente,0/*nro de acta*/,$semana,$fecha_proceso,$fecha_proceso,$cedulaAct,2/*estatus*/,$fechaevaluacion,$justificacion)) != "");

                GetNotaDefinitiva($cedula,$cedulaDocente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$idproductosdef);

                GetNumeroActa($cedulaDocente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico);       
                
                //CREAR DATOS PARA LA SESION EN CASO QUE VAYA GENERAR EL ACTA
                $datos = ConsultarEstudiantesPonderacion($nro,$_POST["IdEval"],$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                
                $_SESSION['lendataacta'] = serialize($nro);
                
                $_SESSION['desproducto'] = serialize(utf8_decode($_POST['DesProducto']));
                $_SESSION['dessemestre'] = serialize($_POST['DesSemestre']);
                $_SESSION['desasign'] = serialize(utf8_decode($_POST['DesAsignatura']));
                $_SESSION['descarr'] = serialize(utf8_decode($_POST['DesCarrera']));
                $_SESSION['dessede'] = serialize(utf8_decode(GetNombreSede($_POST['Sede'])));
                $_SESSION['desseccion'] = serialize($_POST['Seccion']);
                $_SESSION['ceduladoc'] = serialize($cedulaDocente);
                $_SESSION['docente'] = serialize(GetNameDocente($cedulaDocente));
                $_SESSION['ponderacion'] = serialize($nota);
                $_SESSION['dataacta'] = serialize($datos);
                               
                echo 1;
                       
            }
            else{
                
                echo -1;
            }
                        
            
            break;            
        
        case 11:
 
            if (isset($_POST['DesSemestre']) &&  isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdActa'])){
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $idacta = $_POST['IdActa'];
                $idproductosdef = $_POST['IdProductosDef'];

                $datos = ConsultarEstudiantesActa($nro,$idacta,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$idproductosdef);
                
                $datospdf = ConsultarEstudiantesActa($nropdf,1,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$idproductosdef);
                
                $_SESSION['dataacta'] = serialize($datospdf);
                              
                $_SESSION['lendataacta'] = serialize($nropdf);
                
                $_SESSION['dessemestre'] = serialize($_POST['DesSemestre']);
                $_SESSION['desasign'] = serialize(utf8_decode($_POST['DesAsignatura']));
                $_SESSION['descarr'] = serialize(utf8_decode($_POST['DesCarrera']));
                $_SESSION['dessede'] = serialize(utf8_decode(GetNombreSede($_POST['Sede'])));
                $_SESSION['desseccion'] = serialize($_POST['Seccion']);
                $_SESSION['ceduladoc'] = serialize($ceduladoc);
                $_SESSION['docente'] = serialize(GetNameDocente($ceduladoc));
                
                $_SESSION['DesNroEstIns'] = serialize($_POST['DesNroEstIns']);
                $_SESSION['DesNroEstCur'] = serialize($_POST['DesNroEstCur']);
                $_SESSION['DesTotalEvaluado'] = serialize($_POST['DesTotalEvaluado']);
                $_SESSION['DesNroAprob'] = serialize($_POST['DesNroAprob']);
                $_SESSION['DesPorcenAprob'] = serialize($_POST['DesPorcenAprob']);
                $_SESSION['DesNroReprob'] = serialize($_POST['DesNroReprob']);
                $_SESSION['DesPorcenReprob'] = serialize($_POST['DesPorcenReprob']);
                $_SESSION['DesMedia'] = serialize($_POST['DesMedia']);
                $_SESSION['DesNotaMax'] = serialize($_POST['DesNotaMax']);
                $_SESSION['DesNotaMin'] = serialize($_POST['DesNotaMin']);
                $_SESSION['DesDesvtip'] = serialize($_POST['DesDesvtip']);
                $_SESSION['DesVarianza'] = serialize($_POST['DesVarianza']);
                
                
                
                if ($idacta == 1){
                        
                        
                        $i=0;
                        $resultado = "";

                        $tabla = "<table id=\"table_acta\" >".
                                 "<tbody>".
                                    "<thead>".
                                       "<tr>".
                                            "<th width=\"8px\"></th>".
                                            "<th width=\"300px\" align=\"center\"><div class=\"tooltip\">NOMBRE ESTUDIANTE</th>".
                                            "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">NOTA ACUMULADO %</th>".
                                            "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">" . utf8_encode("ACUMULADO EN N�MERO") . "</th>".
                                            "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">ACUMULADO EN LETRA</th>".
                                       "</tr>". 
                                       "</thead>";               

                        $id = $i+1;
                        while($i<$nro){
                            $tabla = $tabla . "<tr class=\"alt\">".
                            "<td>" . $id . "</td>".        
                            "<td width='300px'>". $datos[$i]['eval002d_cedula_est'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) . "</td>" . 
                            "<td width='75px' align=\"right\">" . trim(round($datos[$i]['eval002d_definitiva'],2)) . " %</td>" .
                            "<td width='75px' align=\"right\">" . trim($datos[$i]['eval002d_nota110']) . "</td>" .
                            "<td width='75px' align=\"right\">" . NumeroLetras(trim($datos[$i]['eval002d_nota110'])) . "</td>" .
                            "</tr>";
                            
                            
                                            
                            $id++;
                            $i++;        
                        }

                        $tabla = $tabla . " </tbody></table>";
                        
                        
                        
                        echo $tabla;
                }
                else{
                        $_SESSION['idacta'] = serialize($idacta);
                        
                        
                        
                        $datosprod = ConsultarProductosActa($nroprod,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$idproductosdef);
                         
                         $i=0;
                         $resultado = "";

                         $tabla = "<table id=\"table_acta\" >".
                                  "<tbody>".
                                     "<thead>".
                                        "<tr>".
                                             "<th width=\"8px\"></th>".
                                             "<th width=\"300px\" align=\"center\"><div class=\"tooltip\">NOMBRE ESTUDIANTE</th>";
                                             $id = $i+1;
                                             while($i<$nroprod){
                                                 $tabla = $tabla . "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">PRODUCTO " . $id . "<span class=\"tooltiptext\">" . $datosprod[$i]['eval001d_producto'] . "</span></th>";
                                                 $id++;
                                                 $i++;   
                                             }

                                             $tabla = $tabla . "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">NOTA ACUMULADO %</th>".
                                             "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">" . utf8_encode("ACUMULADO EN N�MERO") . "</th>".
                                             "<th width=\"75px\" align=\"center\"><div class=\"tooltip\">ACUMULADO EN LETRA</th>".                                                     
                                        "</tr>". 
                                        "</thead>";               

                         $i=0;                    
                         $id = $i+1;

                         while($i<$nro){
                             $tabla = $tabla . "<tr class=\"alt\">".
                             "<td>" . $id . "</td>".        
                             "<td width='300px'>". $datos[$i]['eval002d_cedula_est'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) . "</td>";
                             $cedula =  $datos[$i]['eval002d_cedula_est'];  
                             $j=0;
                             $bandera = true;
                             while (($j<$nroprod)){
                                 if ($cedula == $datos[$i]['eval002d_cedula_est']){
                                    $tabla = $tabla ."<td width='75px' align=\"right\">" . trim(round($datos[$i]['eval002d_nota'],2)) . " %</td>";
                                    $i++;
                                 }
                                 else{
                                    $tabla = $tabla ."<td width='75px' align=\"right\">0%</td>"; 
                                 }
                                 $j++; 
                                 
                             }
                             $i--;
                             $tabla = $tabla ."<td width='75px' align=\"right\">" . trim(round($datos[$i]['eval002d_definitiva'],2)) . " %</td>" .
                             "<td width='75px' align=\"right\">" . trim($datos[$i]['eval002d_nota110']) . "</td>" .
                             "<td width='75px' align=\"right\">" . NumeroLetras(trim($datos[$i]['eval002d_nota110'])) . "</td>" .
                             "</tr>";
                             $id++;
                             $i++;       
                         }

                         $tabla = $tabla . " </tbody></table>";
                         echo $tabla;                    
                }
            }     
            
            break;              
        
        case 12:
 
                   
            if (isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['IdEval'])){
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $ideval = $_POST['IdEval'];

                $datos = ConsultarEstudiantesPonderacion($nro,$ideval,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);


                $i=0;
                $resultado = "";
                $tabla = "";
                $id = $i+1;
                while($i<$nro){
                    $tabla = $tabla . "<tr>".
                    "<td>" . $id . "</td>".        
                    "<td width='300px'>". $datos[$i]['eval002d_cedula_est'] . " " . strtoupper(utf8_encode(trim($datos[$i]['primer_apellido']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_apellido']))) . ", " . strtoupper(utf8_encode(trim($datos[$i]['primer_nombre']))) . " " . strtoupper(utf8_encode(trim($datos[$i]['segundo_nombre']))) . "</td>" . 
                    "<td width='75px'><input disabled type=\"text\" name=\"nota[]\" id=\"nota\" maxlength=\"5\" size=\"2\" class=\"NotaEstudiante\" value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input></td>" .
                    "<td width='75px'><input disabled type=\"checkbox\" name=\"asistencia[]\" id=\"asistencia\" class=\"ActualizarAsistencia\"" . AsistenciaEstudianteEvaluacion($datos[$i]['eval002d_no_asistio'],2) . "></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"notabd[]\" id=\"notabd\" maxlength=\"5\" size=\"3\" class=\"NotaEstudianteBD\" value = \"" . trim($datos[$i]['eval002d_nota']) . "\"></input><font size=\"3\"></font></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"cedula[]\" id=\"cedula\" maxlength=\"4\" size=\"2\" class=\"CedulaEst\" value = \"" . $datos[$i]['eval002d_cedula_est'] ."\"></input></td>" .
                    "<td style=\"display:none;\" width='75px'><input disabled type=\"text\" name=\"ideval[]\" id=\"ideval\" maxlength=\"4\" size=\"2\" class=\"ideval\" value = \"" . $ideval . "\"></input></td>" .
                    "<td width='75px'></td>" .
                    "<td width='75px'></td>" .
                    "<td width='75px'>" . GetObjecion($datos[$i]['eval002d_objecion']) . "</td>" .
                    "</tr>";
                    $id++;
                    $i++;       
                }


                $tabla = $tabla . "</tbody></table>";
                echo $tabla;
            }        
            break;  
        
        case 13:
 
                   
            if (isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['TotalEvaluado']) && isset($_POST['TotalEstudiante'])){
                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];
                $ceduladoc = $_POST['Cedula'];
                $totalevaluado = $_POST['TotalEvaluado'];
                $totalestudiante = $_POST['TotalEstudiante'];
                $minaprob = ($totalevaluado*0.55)/10;
                
                //APROBADOS
                ConsultarEstudiantesAprob($nroaprob,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$minaprob);
                
                //%APROBADOS
                
                $porcenaprob = round(($nroaprob /  $totalestudiante)*100,2);
                
                //CALIFICACION PROMEDIO  MAXIMA Y MINIMA
                $datos = ConsultarEstudiantesNotasPromedioMaxMin($nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                $promedio = Round($datos[0]['promedio'],2);
                $maxnota = $datos[0]['maxnota'];
                $minnota = $datos[0]['minnota'];
                
                //REPROBADO
                $reprobados = $totalestudiante - $nroaprob;
                
                $porcenreprob = round(($reprobados /  $totalestudiante)*100,2);
                
                //VARIANZA Y DESV ESTANDAR
                $datos = ConsultarEstudiantesConNotas($nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                
                $i=0;
                $resultado = "";
                $suma=0;
               
                while($i<$nro){
                    $suma+=($datos[$i]['eval002d_nota110']-$promedio)*($datos[$i]['eval002d_nota110']-$promedio);
                    $i++;       
                }

                $vari = Round($suma/$nro,2);
                $desvest = Round(sqrt($vari),2);
                
                echo $nroaprob . "|" . $porcenaprob . "|" . $reprobados . "|" . $porcenreprob . "|" . $promedio . "|" . $maxnota . "|" . $minnota . "|" . $desvest . "|" . $vari;
                
                               
            }        
            break;     
            
        case 14:
            
            if(isset($_POST['IdEvaUlt'])){
            
                $idevalult = $_POST['IdEvaUlt']; 

                ActualizarStatusEvaluacion($idevalult);

                echo 1;
            }        
            break;   
            
        case 15:
            
            if (isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
                   
                BorrarRegistroNotasAsignaturaDocente($cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);

                echo 1;
            } 
            else{
                echo 0;
            }
            break;       
            
    }//fin switch
} 
   

               
