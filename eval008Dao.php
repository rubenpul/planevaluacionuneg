<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
        
    $opcion = $_POST['Opcion'];
    $sede = $_POST['Sede'];
    $carrera = $_POST['Carrera'];
    $lapso = $_POST['LapsoAcademico'];
    
    switch ($opcion){
        case 1: //SEDES
               
        
            $nro=0;
            $datos = Consultar_Sede($nro); //consultar las sedes
            
            if ($lapso == ""){
                $lapsoact = Consultar_Lapso("");  //consultar el lapso actual
                $lapso = $lapsoact[0]['lapso'];
            }
            else{
                if ($lapso == "CIVA"){
                    $datosciva = ConsultarLapsoCIVA($nrociva);

                    if($nrociva > 0){
                        $lapso = $datosciva[0]['sce016d_lapso_acad'];
                    }    
                    else{
                        $lapso = 'NoRegistro';
                    }        
                }
               
            }
           
                        
            if ($lapso != 'NoRegistro'){
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {

                        $acumsecciones = Asignaturas_secciones_plan($nro3,$datos[$i]['sce025d_codigo_sede'],$lapso);
                        
                        if ($acumsecciones[0]['acumasig'] > 0){
                                           
                            //obtiene el acumulado por cada sede de la tabla resumen
                            $datos3 =GetAcumuladoSede_plan($nro4,$lapso,$datos[$i]['sce025d_codigo_sede']);

                            $cantidadcumplio100div = round(($datos3[0]['eval008d_completado'] / $acumsecciones[0]['acumasig'] )*100,2);
                            $cantidadnocumplio50div = round(($datos3[0]['eval008d_mayor50'] / $acumsecciones[0]['acumasig'])*100,2);
                            $cantidadnocumplio49div = round(($datos3[0]['eval008d_menor50'] / $acumsecciones[0]['acumasig'])*100,2);
                            $cantidadnocumplio0div = round(($datos3[0]['eval008d_sinavance'] / $acumsecciones[0]['acumasig'])*100,2);

                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                            }
                            else{
                                 $tabla = $tabla . "<tr>";   
                            }                    

                            $tabla = $tabla .  "<td width='300px'>". strtoupper(utf8_encode(trim($datos3[0]['eval008d_nombresede']))) . " (". $acumsecciones[0]['acumasig'] . ")</td>" . 

                                "<td width='75px'>" . $cantidadcumplio100div . "% (". $datos3[0]['eval008d_completado'] . ")</td>" .
                                "<td width='75px'>" . $cantidadnocumplio50div . "% (". $datos3[0]['eval008d_mayor50'] . ")</td>" .    
                                "<td width='75px'>" . $cantidadnocumplio49div . "% (". $datos3[0]['eval008d_menor50'] . ")</td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0div . "% (". $datos3[0]['eval008d_sinavance'] . ")</td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Ver Carreras Sede\" class=\"VerCarrerasPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce025d_codigo_sede'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .    
                                "</tr>";
                        }
                        
                        $i++;   
                        
                        
                        /*
                        
                        //consultar los docentes de la sede en el lapso actual    
                        $datos2 = Docentes_Sede_Plan($nro2,$lapso,$datos[$i]['sce025d_codigo_sede']);
                        //la cantidad de asignaturas ofertadas en la sede
                        $acumasig = Asignaturas_Sede($nro3,$datos[$i]['sce025d_codigo_sede'],$lapso);
                        $j=0;  
                        $cantidadcumplio100 = 0;
                        $cantidadnocumplio50 = 0;
                        $cantidadnocumplio49 = 0;
                        $cantidadnocumplio0 = 0;

                        while ($j<$nro2){
                            $acum = 0;
                            //obtiene el acumulado por cada plan de evaluacion del docente de la sede en el lapso actual
                            $datos3 =GetAcumuladoPlanificacionDocenteDetallado($nro4,$datos2[$j]['sce070d_cedula_doc'],$lapso,$datos[$i]['sce025d_codigo_sede']);
                            $k=0;
                            while($k<$nro4){ // si ha hecho algun plan de evaluacion lo contabiliza
                                $acum = $datos3[$k]['acum'];

                                if($acum == 100){
                                    $cantidadcumplio100 = $cantidadcumplio100 + 1;
                                }
                                else{
                                    if($acum >= 50){
                                        $cantidadnocumplio50 = $cantidadnocumplio50 + 1;
                                    }   
                                    else{
                                        if($acum > 0 && $acum <= 49){
                                            $cantidadnocumplio49 = $cantidadnocumplio49 + 1;
                                        }                               
                                    }
                                } 
                                $k++;
                            }

                            $j++;
                       }  
                       
                       if ($cantidadcumplio100 > $acumasig[0]['acumasig']){
                           $cantidadcumplio100 = $acumasig[0]['acumasig'];
                       }
                       
                       if ($cantidadnocumplio50 > $acumasig[0]['acumasig']){
                           $cantidadnocumplio50 = $acumasig[0]['acumasig'];
                       }
                       
                       if ($cantidadnocumplio49 > $acumasig[0]['acumasig']){
                           $cantidadnocumplio49 = $acumasig[0]['acumasig'];
                       }
                      
                       
                       $suma = $cantidadcumplio100 + $cantidadnocumplio50 + $cantidadnocumplio49 + $cantidadnocumplio0; 

                       if ($suma != $acumasig[0]['acumasig']){
                           $cantidadnocumplio0 = $cantidadnocumplio0 + ($acumasig[0]['acumasig'] -$suma);
                       }

                       if ($nro2 > 0){
                           $cantidadcumplio100div = round(($cantidadcumplio100 / $acumasig[0]['acumasig'] )*100,2);
                           $cantidadnocumplio50div = round(($cantidadnocumplio50 / $acumasig[0]['acumasig'])*100,2);
                           $cantidadnocumplio49div = round(($cantidadnocumplio49 / $acumasig[0]['acumasig'])*100,2);
                           $cantidadnocumplio0div = round(($cantidadnocumplio0 / $acumasig[0]['acumasig'])*100,2);


                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                             }
                             else{
                                 $tabla = $tabla . "<tr>";   
                             }                    

                              $tabla = $tabla .  "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['sce025d_descripcion']))) . " (". $acumasig[0]['acumasig'] . ")</td>" . 
                                "<td width='75px'>" . $cantidadcumplio100div . "% (". $cantidadcumplio100 . ")  </td>" .
                                "<td width='75px'>" . $cantidadnocumplio50div . "% (". $cantidadnocumplio50 . ")  </td>" .   
                                "<td width='75px'>" . $cantidadnocumplio49div . "% (". $cantidadnocumplio49 . ")  </td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0div . "% (". $cantidadnocumplio0 . ")  </td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Ver Carreras Sede\" class=\"VerCarrerasPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce025d_codigo_sede'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                                "</tr>";
                       }      
                       $i++;  */
                    }    
                }		            
                
                echo $tabla;        
            }
            else{
               
                $tabla = $tabla . "<tr  class=\"alt\">".
                $tabla = $tabla . "<td colspan = \"7\" width=\"200px\" align=\"center\">NO HAY REGISTRO DE CIVA ". "</td>".     
                $tabla = $tabla . "<td style=\"display:none;\">0</td>".      
                $tabla = $tabla . "</tr>"; 
                echo $tabla;
                        
            }
            break;
        
        case 2: //CARRERA
               
            if (isset($_POST['Sede'])){
            
                $nro=0;
                $datos = Consultar_Carrera_Sede_Plan2($nro,$sede);
                //$lapso = Consultar_Lapso("");
                                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $acumcarrera = Secciones_Sede_Carrera_Plan($nro3,$sede,$datos[$i]['eval008d_codcarr'],$lapso);
                        
                        $datos3 =GetAcumuladoCarrera_Plan($nro4,$datos[$i]['eval008d_codcarr'],$lapso,$_POST['Sede']);
                            
                        $cantidadcumplio100div = round(($datos3[0]['eval008d_completado'] / $acumcarrera[0]['acumasig'] )*100,2);
                        $cantidadnocumplio50div = round(($datos3[0]['eval008d_mayor50'] / $acumcarrera[0]['acumasig'])*100,2);
                        $cantidadnocumplio49div = round(($datos3[0]['eval008d_menor50'] / $acumcarrera[0]['acumasig'])*100,2);
                        $cantidadnocumplio0div = round(($datos3[0]['eval008d_sinavance'] / $acumcarrera[0]['acumasig'])*100,2);

                        if($i % 2){
                             $tabla = $tabla . "<tr class=\"alt\">";
                         }
                         else{
                             $tabla = $tabla . "<tr>";   
                         }                            


                        $tabla = $tabla . "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['eval008d_nombrecarr']))) . " (". $acumcarrera[0]['acumasig'] . ")</td>" . 
                           "<td width='75px'>" . $cantidadcumplio100div . "% (". $datos3[0]['eval008d_completado'] . ")</td>" .
                           "<td width='75px'>" . $cantidadnocumplio50div . "% (". $datos3[0]['eval008d_mayor50'] . ")</td>" .    
                           "<td width='75px'>" . $cantidadnocumplio49div . "% (". $datos3[0]['eval008d_menor50'] . ")</td>" .        
                           "<td width='75px'>" . $cantidadnocumplio0div . "% (". $datos3[0]['eval008d_sinavance'] . ")</td>" .            

                           "<td width='75px'><a href=\"#\"><img src=\"../imagenes/teacher.png\" title=\"Ver Docentes\" class=\"VerDocentesPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                           "<td style=\"display:none;\" width='75px'>" . $sede . "</td>" .
                           "<td style=\"display:none;\" width='75px'>" . $datos[$i]['eval008d_codcarr'] . "</td>" .
                           "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                           "</tr>";
                        
                             $i++;  
                        
                        
                        
                        /*$nro2 = 0;
                        $datos2 = Docentes_Sede_Carrera($nro2,$sede,$datos[$i]['sce085d_cod_carr'],$lapso);
                        $acumasig = Asignaturas_Sede_Carrera($nro3,$sede,$datos[$i]['sce085d_cod_carr'],$lapso);
                        $j=0;  
                        $cantidadcumplio100 = 0;
                        $cantidadnocumplio50 = 0;
                        $cantidadnocumplio49 = 0;
                        $cantidadnocumplio0 = 0;

                        while ($j<$nro2){
                            $acum = 0;
                            $datos3 =GetAcumuladoPlanificacionDocenteCarrera($nro4,$datos2[$j]['sce070d_cedula_doc'],$datos[$i]['sce085d_cod_carr'],$lapso,$_POST['Sede']);
                            
                            $k=0;
                            
                            while($k<$nro4){ // si ha hecho algun plan de evaluacion lo contabiliza
                                
                                $acum = $datos3[$k]['acum'];
                                
                                if($acum == 100){
                                    $cantidadcumplio100 = $cantidadcumplio100 + 1;
                                }
                                else{
                                    if($acum >= 50){
                                        $cantidadnocumplio50 = $cantidadnocumplio50 + 1;
                                    }   
                                    else{
                                        if($acum > 0 && $acum <= 49){
                                            $cantidadnocumplio49 = $cantidadnocumplio49 + 1;
                                        }   
                                    }
                                }
                                $k++;
                            }
                            $j++;
        
                       }

                       if ($cantidadcumplio100 > $acumasig[0]['acumasig']){
                           $cantidadcumplio100 = $acumasig[0]['acumasig'];
                       }
                       
                       if ($cantidadnocumplio50 > $acumasig[0]['acumasig']){
                           $cantidadnocumplio50 = $acumasig[0]['acumasig'];
                       }
                       
                       if ($cantidadnocumplio49 > $acumasig[0]['acumasig']){
                           $cantidadnocumplio49 = $acumasig[0]['acumasig'];
                       }                       
                       
                       
                       $suma = $cantidadcumplio100 + $cantidadnocumplio50 + $cantidadnocumplio49 + $cantidadnocumplio0; 
                   
                       if ($suma != $acumasig[0]['acumasig']){
                            $cantidadnocumplio0 = $cantidadnocumplio0 + ($acumasig[0]['acumasig'] -$suma);
                       }
                   
                       if ($nro2 > 0){
                           $cantidadcumplio100div = round(($cantidadcumplio100 * 100 ) / $acumasig[0]['acumasig'],2);
                           $cantidadnocumplio50div = round(($cantidadnocumplio50 *100 ) / $acumasig[0]['acumasig'],2);
                           $cantidadnocumplio49div = round(($cantidadnocumplio49 *100) / $acumasig[0]['acumasig'] ,2);
                           $cantidadnocumplio0div = round(($cantidadnocumplio0 *100) / $acumasig[0]['acumasig'],2);

                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                             }
                             else{
                                 $tabla = $tabla . "<tr>";   
                             }                            

                            
                             $tabla = $tabla . "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['sce080d_nom_carr']))) . " (". $acumasig[0]['acumasig'] . ")</td>" . 
                                "<td width='75px'>" . $cantidadcumplio100div .  "% ( ". $cantidadcumplio100 . ")</td>" .
                                "<td width='75px'>" . $cantidadnocumplio50div . "% ( ". $cantidadnocumplio50 . ")</td>" .    
                                "<td width='75px'>" . $cantidadnocumplio49div . "% ( ". $cantidadnocumplio49 . ")</td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0div . "% ( ". $cantidadnocumplio0 . ")</td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/teacher.png\" title=\"Ver Docentes\" class=\"VerDocentesPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $sede . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce085d_cod_carr'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                                "</tr>";
                        }      
                        $i++;  */
                    }    
                }		            

                echo $tabla;        
            }    

            break;    

        case 3: //DOCENTE
               
            if (isset($_POST['Sede']) && isset($_POST['Carrera'])){
            
                
                $j=0;  
               
                $datos3 =GetAcumuladoEvaluacionDocenteAsignatura_Plan($nro,$_POST['Sede'],$_POST['Carrera'],$lapso);
                    
                while ($j<$nro){

                    if($j % 2){
                        $tabla = $tabla . "<tr class=\"alt\">";
                    }
                    else{
                        $tabla = $tabla . "<tr>";   
                    }

                    if (trim($datos3[$j]['eval008d_ponderacion']) == ""){
                        $ponderacion = 0;
                        $plan = "";
                    }
                    else{
                        $ponderacion = $datos3[$j]['eval008d_ponderacion'];
                        $plan = "<img src=\"../imagenes/ver_planificacion.png\" title=\"Ver Planificaci&oacute;n\" class=\"VerPlanificacion\" height=\"30\" width=\"30\">";
                    }
                    
                    

                     $tabla = $tabla . "<td width='300px'>". $datos3[$j]['eval008d_ceduladoc'] .  " " . strtoupper(utf8_encode(trim($datos3[$j]['eval008d_nombredoc']))) . "</td>" . 
                     "<td width='300px'>". strtoupper(utf8_encode(trim($datos3[$j]['eval008d_codasign'] . "-" .$datos3[$j]['eval008d_nombreasign']))) . "</td>" . 
                     "<td width='75px'>". $datos3[$j]['eval008d_seccion'] . "</td>" .                             
                     "<td width='75px'>" . $ponderacion . "%</td>" .
                     "<td width='75px'>" . $plan ."</td>" .  
                     "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                     "<td style=\"display:none;\" width='75px'>" . $datos3[$j]['eval008d_codasign'] . "</td>" .        
                     "<td style=\"display:none;\" width='75px'>" . $datos3[$j]['eval008d_seccion'] . "</td>" .  
                     "<td style=\"display:none;\" width='75px'>" . $carrera . "</td>" .  
                     "<td style=\"display:none;\" width='75px'>" . $_POST['Sede'] . "</td>" .        
                     "<td style=\"display:none;\" width='75px'>" . $datos3[$j]['eval008d_ceduladoc'] . "</td>" .                
                     "</tr>";

                               
                    $j++;
                
                
                
                //$lapso = Consultar_Lapso("");
                
                /*$datos2 = Docentes_Sede_Carrera_Asignatura_Plan($nro2,$sede,$carrera,$lapso);

                $j=0;  
               
                while ($j<$nro2){
                    $acum = 0;
                    $datos3 =GetAcumuladoPlanificacionDocenteAsignatura($nro,$datos2[$j]['sce070d_cedula_doc'],$datos2[$j]['sce070d_cod_asign'],$datos2[$j]['sce070d_seccion'],$datos2[$j]['sce070d_sede'],$lapso);
                    
                    if($j % 2){
                        $tabla = $tabla . "<tr class=\"alt\">";
                    }
                    else{
                        $tabla = $tabla . "<tr>";   
                    }
                          
                    if (trim($datos3[0]['acum']) != ""){
                       $acum = $datos3[0]['acum'];
                       $plan = "<img src=\"../imagenes/ver_planificacion.png\" title=\"Ver Planificaci&oacute;n\" class=\"VerPlanificacion\" height=\"30\" width=\"30\">";
                    }
                    else{
                        $plan = "";
                    }
                    
                    
                    
                    
                     $tabla = $tabla . "<td width='300px'>". $datos2[$j]['sce070d_cedula_doc'] .  " " . strtoupper(utf8_encode(trim($datos2[$j]['nombre']))) . "</td>" . 
                     "<td width='75px'>". strtoupper(utf8_encode(trim($datos2[$j]['sce090d_nom_asign']))) . "</td>" . 
                     "<td width='75px'>". $datos2[$j]['sce070d_seccion'] . "</td>" .                             
                     "<td width='75px'>" . $acum . "%</td>" .
                     "<td width='75px'>" . $plan ."</td>" .        
                     "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                     "<td style=\"display:none;\" width='75px'>" . $datos2[$j]['sce070d_cod_asign'] . "</td>" .        
                     "<td style=\"display:none;\" width='75px'>" . $datos2[$j]['sce070d_seccion'] . "</td>" .  
                     "<td style=\"display:none;\" width='75px'>" . $carrera . "</td>" .  
                     "<td style=\"display:none;\" width='75px'>" . $datos2[$j]['sce070d_sede'] . "</td>" .        
                     "<td style=\"display:none;\" width='75px'>" . $datos2[$j]['sce070d_cedula_doc'] . "</td>" .        
                     "</tr>";

                    $j++;*/
                }      
               

               echo $tabla;        
            }    

            break;    
            
        case 4:   
                       
            
                $datos = ConsultarLapsosCargadosPlanificacion($nro);

                $combolapso = "<select name=\"cmb_lapsoconsulta\" id=\"cmb_lapsoconsulta\" class=\"Combobox\">".
                             "<OPTION  selected value=\"0\">Seleccione...</option>";
                               
                if ($nro > 0){	
                    $i=0;  
                    
                    while ($i<$nro) {
                        
                        $combolapso = $combolapso. "<OPTION  VALUE=" . $datos[$i]['eval001d_lapso_academico'] . ">" . $datos[$i]['eval001d_lapso_academico']  . "</OPTION>\n";
                        $i++;
                        
                    }    
                     $combolapso = $combolapso. "</SELECT>";
                     
                   
                }    
                 echo $combolapso;
            
            break;     
   
        case 5:   
                       
            if (isset($_POST['Sede']) && isset($_POST['Carrera']) && isset($_POST['LapsoAcademico']) && isset($_POST['Seccion']) && isset($_POST['Asignatura'])  && isset($_POST['Cedula']) ){
            
                $ceduladoc = $_POST['Cedula'];
                $lapsoacademico = $_POST['LapsoAcademico'];
                $sede = $_POST['Sede'];
                $carrera = $_POST['Carrera'];
                $seccion = $_POST['Seccion'];
                $asignatura = $_POST['Asignatura'];
                
                $datos = ConsultarPlanificacionDocente(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura);

                $j=0;  
               
                $_SESSION['dataplan'] = serialize($datos);
                $_SESSION['lendataplan'] = serialize($nro);
                
                echo 1;        
            }    

            break;               
                
            
                      
            
            
    }//fin switch
    
} 
   

               
