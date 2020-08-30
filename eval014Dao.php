<?php

//error_reporting(0);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
    
    $opcion = $_POST['Opcion'];
    $cedulaDocente = $_POST['Cedula'];
    $cedulaAct = $_POST['CedulaAct'];
    
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
                $combo = "<SELECT name=\"cmb_instrumento[]\" id=\"cmb_instrumento\" class=\"Combobox\" required>\n".
                             "<OPTION  selected value=\"\">Seleccione...</option>\n";
                
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
                
         case 3: //GUARDAR UNA EVALUACIsedeON
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
                        "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/generarplan.png\" title=\"Generar Plan Evaluaci&oacute;n\" class=\"GenerarPlanEvaluacion\" height=\"30\" width=\"30\"></a></td> " .
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                        "<td style=\"display:none;\">" .$datos[$i]["sce025d_descripcion"] . "</td>".
                        "<td style=\"display:none;\">" . strtoupper(utf8_encode($datos[$i]["sce090d_nom_asign"])) . "</td>".        
                        "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".
                        "<td style=\"display:none;\">" .$datos[$i]["lapso_sys"] . "</td>".
                        "</tr>";         
                                                
                        $i++;
                    }    
                        
                    if ($nro == 0){
                         $tabla = $tabla . "<tr  class=\"alt\">".
                         $tabla = $tabla . "<td colspan = \"11\" width=\"200px\" align=\"center\">NO TIENE REGISTRO DE OFERTA ACAD&Eacute;MICA EN EL SISTEMA PARA EL LAPSO " . $lapso[0]['lapso'] . ". DIRIGIRSE A SU COORDINADOR DE PROYECTO DE CARRERA " . "</td>".     
                         $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                         $tabla = $tabla . "</tr>"; 
                                 
                    }
                    
                    
                    $tabla = $tabla . "</tbody></table>";
                    echo $tabla;
               }    
                    
            
            break;
        
        case 5: //GUARDAR TODO EL PLAN DE EVALUACION
            if(isset($_POST['IdEval']) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Instrumento']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                                      
                $date = getdate();
                $fecha_proceso = "" . $date[year] . "-" . $date[mon] . "-" . $date[mday];

                $carrera = $_POST['Carrera']; 
                $asignatura = $_POST['Asignatura']; 
                $sede = $_POST['Sede'];
                $seccion = $_POST['Seccion'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $lapsovigencia = $_POST['LapsoVigencia'];

                $i=0;
                
                $idbd="00";
                
                while($i<count($_POST["Producto"])){

                    
                    
                    if (trim($_POST["Producto"][$i]) != "" && trim($_POST["Actividad"][$i]) != "" && trim($_POST["Criterio"][$i]) != "" && trim($_POST["Instrumento"][$i]) != "" && trim($_POST["Evaluacion"][$i]) != "" && trim($_POST["Semana"][$i]) != ""){
                        $producto = $_POST["Producto"][$i];
                        $actividad = $_POST["Actividad"][$i];
                        $criterio = $_POST["Criterio"][$i];
                        $instrumento = $_POST["Instrumento"][$i];
                        $evaluacion = $_POST["Evaluacion"][$i];
                        $semana = $_POST["Semana"][$i];
                        $ideval = $_POST["IdEval"][$i];
                        $pase = $i;
                        do{
                            
                            $id_evaluacion = GetMaxCodEvaluacion()+1; 
                                     
                        }while (($resp_bd = GuardarEvaluacion($msg,$id_evaluacion,$sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$producto,$actividad,$criterio,$instrumento,$evaluacion,$fecha_proceso,1,$semana,$fecha_proceso,$cedulaAct,$ideval)) != "");
                       
                        if ($ideval !=0){
                            $idbd = $idbd . "!!" . $ideval;
                        }
                        else{
                            $idbd = $idbd . "!!" . $id_evaluacion;
                        }
                       
                        
                    }
                    $i++;
                }
                
                                
                if ($i == count($_POST["Producto"])){
                    echo $idbd;
                }
                else{
                    echo 0;
                }
            }
            else{
                
                echo -1;
            }
            
            
              
            
            break;

        case 6: //GUARDAR PLAN DE EVALUACION ESPECIFICO
            
            if(isset($_POST["IdEval"]) && isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) && isset($_POST['Producto']) && isset($_POST['Actividad']) && isset($_POST['Criterio']) && isset($_POST['Instrumento']) && isset($_POST['Evaluacion']) && isset($_POST['Semana'])){
                    
                    $i=0;
                                       
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
                    
                    
                    if (trim($producto) != "" && trim($actividad) != "" && trim($criterio) != "" && trim($instrumento) != "" && trim($evaluacion) != "" && trim($semana) != ""){ 

                        do{
                            
                            $id_evaluacion = GetMaxCodEvaluacion()+1; 
                                     
                        }while (($resp_bd = GuardarEvaluacion($msg,$id_evaluacion,$sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$producto,$actividad,$criterio,$instrumento,$evaluacion,$fecha_proceso,1,$semana,$fecha_proceso,$cedulaAct,$ideval)) != "");
                                  
                    }    
                    else{
                        $id_evaluacion = 0;
                    }
                    
                    if ($ideval != 0){
                        echo $ideval;
                    }
                    else{
                        echo $id_evaluacion;
                    }
                    
                    
            }    
            break;        
        
        case 7: //CONSULTAR PLAN DE EVALUACION
            
            if(isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
            
                    $carrera = trim($_POST['Carrera']); 
                    $asignatura = trim($_POST['Asignatura']); 
                    $sede = trim($_POST['Sede']);
                    $seccion = trim($_POST['Seccion']);
                    $lapsoacademico = trim($_POST['LapsoAcademico']);
                    $lapsovigencia = trim($_POST['LapsoVigencia']);
            
                    $datos = ConsultarPlanDocente($nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
               
                    $i=0;
                    $resultado = "";
                    
                    while($i<$nro){
                        $resultado = $resultado . $datos[$i]['eval001d_id_evaluacion'] . "!!" . $datos[$i]['eval001d_producto'] . "!!" . $datos[$i]['eval001d_actividad']. "!!" .$datos[$i]['eval001d_criterio']. "!!" .$datos[$i]['eval001d_instrumento']. "!!" .$datos[$i]['eval001d_ponderacion']. "!!" .$datos[$i]['eval001d_sem_planificacion'] . "!!" .$datos[$i]['eval001d_status'];
                                                                        
                        $i++;
                        if ($i<$nro){
                            $resultado = $resultado . "!!";
                        }
                    }
                    echo $resultado;
            }        
            break;
            
        case 8:   
            
            if(isset($_POST["IdEval"])){ 
            
                BorrarEvaluacion($_POST["IdEval"]);
                
                echo 1;
            }
            else{
                
                echo 0;
            }
            break;
            
        case 9:   
            
            if(isset($_POST["Cedula"]) && isset($_POST['Asignatura'])){ 
            
                $asignatura = $_POST['Asignatura']; 
                                
                $datos = ConsultarLapsoPlan($nro,$cedulaDocente,$asignatura);
                
                 
                if ($nro > 0){	
                    $i=0;  
                    $combo = "<SELECT name=\"cmb_lapso\" id=\"cmb_lapso\" class=\"Combobox\">\n".
                             "<OPTION  selected value=\"0\">Seleccione...</option>\n";
               
                    while ($i<$nro) {
                        
                        $combo = $combo. "<OPTION  VALUE=" . $datos[$i]['eval001d_lapso_academico'] . ">" . $datos[$i]['lapsofront']  . "</OPTION>\n";
                        $i++;
                        
                    }    
                     $combo = $combo. "</SELECT>";
                     echo $combo;
                }		            
                else{
                    echo 0;
                }
               
                
                
            }
            else{
                
                echo 0;
            }
            break;  
            
        case 10:   
            
            if(isset($_POST["Cedula"]) && isset($_POST["LapsoAcademico"]) && isset($_POST['Asignatura'])){ 
            
                $asignatura = $_POST['Asignatura']; 
                    
                $datos = ConsultarLapsoUnidadPlan($nro,$cedulaDocente,$_POST["LapsoAcademico"],$asignatura);
                
                $combo = "<SELECT name=\"cmb_unidad\" id=\"cmb_unidad\" class=\"Combobox\">\n".
                             "<OPTION  selected value=\"0\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<OPTION  VALUE=" . $datos[$i]['eval001d_cod_asignatura'] . ">" . strtoupper(utf8_encode(trim($datos[$i]['sce090d_nom_asign'])))  . "</OPTION>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</SELECT>";
                
                echo $combo;
            }
            else{
                
                echo 0;
            }
            break;     
            
        case 11:   
            
            if(isset($_POST["Cedula"]) && isset($_POST["LapsoAcademico"]) && isset($_POST["Asignatura"])){ 
            
                    
                $datos = ConsultarLapsoUnidadCarreraPlan($nro,$cedulaDocente,$_POST["LapsoAcademico"],$_POST["Asignatura"]);
                
                $combo = "<SELECT name=\"cmb_carrera\" id=\"cmb_carrera\" class=\"Combobox\">\n".
                             "<OPTION  selected value=\"0\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<OPTION  VALUE=" . $datos[$i]['eval001d_cod_carrera'] . ">" . strtoupper(utf8_encode(trim($datos[$i]['sce080d_nom_carr'])))  . "</OPTION>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</SELECT>";
                
                echo $combo;
            }
            else{
                
                echo 0;
            }
            break;  
            
        case 12:   
            
            if(isset($_POST["Cedula"]) && isset($_POST["LapsoAcademico"]) && isset($_POST["Asignatura"]) && isset($_POST["Carrera"])){ 
            
                    
                $datos = ConsultarLapsoUnidadCarreraSeccionPlan($nro,$cedulaDocente,$_POST["LapsoAcademico"],$_POST["Asignatura"],$_POST["Carrera"]);
                
                $combo = "<SELECT name=\"cmb_seccion\" id=\"cmb_seccion\" class=\"Combobox\">\n".
                             "<OPTION  selected value=\"0\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<OPTION  VALUE=" . $datos[$i]['eval001d_cod_seccion'] . ">" . strtoupper(utf8_encode(trim($datos[$i]['eval001d_cod_seccion'])))  . "</OPTION>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</SELECT>";
                
                echo $combo;
            }
            else{
                
                echo 0;
            }
            break;                
 
        case 13:   
            
            if(isset($_POST["Cedula"]) && isset($_POST["LapsoAcademico"]) && isset($_POST["Asignatura"]) && isset($_POST["Carrera"]) && isset($_POST["Seccion"])){ 
                                
                $datos = ConsultarLapsoUnidadCarreraSeccionSedePlan($nro,$cedulaDocente,$_POST["LapsoAcademico"],$_POST["Asignatura"],$_POST["Carrera"],$_POST["Seccion"]);
                               
                echo $datos[0]['eval001d_cod_sede'];
            }
            else{
                
                echo 0;
            }
            break;  

        case 14:   
            
            if(isset($_POST["Cedula"]) && isset($_POST["LapsoAcademico"]) && isset($_POST["Asignatura"]) && isset($_POST["Carrera"]) && isset($_POST["Seccion"])){ 
                                
                $datos = ConsultarLapsoUnidadCarreraSeccionSedeVigenciaPlan($nro,$cedulaDocente,$_POST["LapsoAcademico"],$_POST["Asignatura"],$_POST["Carrera"],$_POST["Seccion"]);
                               
                echo $datos[0]['eval001d_lapso_vigencia'];
            }
            else{
                
                echo 0;
            }
            break;    
            
        case 15:   
            
            if(isset($_POST["Cedula"])){ 
            
                $datos = ConsultarLapsosCargadosDocente($nro,$cedulaDocente);

                $combolapso = "<select name=\"cmb_lapsoconsulta\" id=\"cmb_lapsoconsulta\" class=\"Combobox\">".
                             "<OPTION  selected value=\"0\">Seleccione...</option>";
                               
                if ($nro > 0){	
                    $i=0;  
                    
                    while ($i<$nro) {
                        
                        $combolapso = $combolapso. "<OPTION  VALUE=" . $datos[$i]['lapsoback'] . ">" . $datos[$i]['lapsofront']  . "</OPTION>\n";
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

       case 16:
                //GENERAR OFERTAS ACADEMICAS DEL DOCENTE DADO UN LAPSO    
               if(isset($_POST['Cedula'])){      
                   $tabla= "";
                                            
                    
                  
                   
                    $lapso =  Consultar_Lapso($cedulaDocente);
                    
                   
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
                        "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/generarplan.png\" title=\"Generar Plan Evaluaci&oacute;n\" class=\"GenerarPlanEvaluacion\" height=\"30\" width=\"30\"></a></td> " .
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_lapso_vigencia"] . "</td>".        
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_carr"] . "</td>".                
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cod_asign"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_sede"] . "</td>". 
                        "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                        "<td style=\"display:none;\">" .$datos[$i]["sce070d_cedula_doc"] . "</td>".          
                        "<td style=\"display:none;\">" .$datos[$i]["sce025d_descripcion"] . "</td>".
                        "<td style=\"display:none;\">" . strtoupper(utf8_encode($datos[$i]["sce090d_nom_asign"])) . "</td>".        
                        "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".
                        "<td style=\"display:none;\">" .$datos[$i]["lapso_sys"] . "</td>".
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
            
        case 17:
                //GENERAR OFERTAS ACADEMICAS DEL DOCENTE DADO UN LAPSO    
               if(isset($_POST['Cedula'])){      
                   $tabla= "";
                                            
                           
                    //CONSULTAR LAPSO CIVA   
                          
                    $datos = ConsultarLapsoCIVA($nro);

                    if($nro > 0){
                        $lapso = $datos[0]['lapso'];
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

                            $tabla = $tabla . "<td>". strtoupper(utf8_encode($datos[$i]["eval001d_cod_asignatura"] . "-" . trim($datos[$i]["sce090d_nom_asign"]))) . "</td>".
                            "<td>". strtoupper(utf8_encode(trim($datos[$i]["sce080d_nom_carr"]))) . "</td>". 
                            "<td align=\"center\">". $datos[$i]["eval001d_cod_seccion"] . "</td> ".
                            "<td align=\"center\"><a href=\"#\"><img src=\"../imagenes/generarplan.png\" title=\"Generar Plan Evaluaci&oacute;n\" class=\"GenerarPlanEvaluacion\" height=\"30\" width=\"30\"></a></td> " .
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_lapso_vigencia"] . "</td>".        
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_carrera"] . "</td>".                
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_asignatura"] . "</td>". 
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cod_sede"] . "</td>". 
                            "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>".  
                            "<td style=\"display:none;\">" .$datos[$i]["eval001d_cedula_docente"] . "</td>".          
                            "<td style=\"display:none;\">" .$datos[$i]["sce025d_descripcion"] . "</td>".   
                            "<td style=\"display:none;\">" . strtoupper(utf8_encode($datos[$i]["sce090d_nom_asign"])) . "</td>".           
                            "<td ><img id=\"Imagen\" src=\"../imagenes/arrow_left.png\" height=\"20\" width=\"20\" class=\"ImagenIndicador\"></td>".
                            "<td style=\"display:none;\">" .$datos[$i]["lapso"] . "</td>". 
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
            
        case 19: //VERIFICAR SI LA EVALUACION DOCENTE ESTA CERRADO
            
            if(isset($_POST['Cedula']) && isset($_POST['Carrera']) && isset($_POST['Asignatura']) && isset($_POST['Seccion']) && isset($_POST['Sede']) && isset($_POST['LapsoAcademico']) && isset($_POST['LapsoVigencia']) ){
            
                    $carrera = trim($_POST['Carrera']); 
                    $asignatura = trim($_POST['Asignatura']); 
                    $sede = trim($_POST['Sede']);
                    $seccion = trim($_POST['Seccion']);
                    $lapsoacademico = trim($_POST['LapsoAcademico']);
                    $lapsovigencia = trim($_POST['LapsoVigencia']);
            
                    $datos = ConsultarEvaluacionDocente($nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
               
                                       
                    echo $datos[0]['estatus'];
            }        
            break;                
            
            
            
    }//fin switch
} 
   

               
