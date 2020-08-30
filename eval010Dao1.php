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

                        //consultar los docentes de la sede en el lapso actual    
                        $datos2 = Docentes_Sede($nro2,$lapso,$datos[$i]['sce025d_codigo_sede']);
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
                            $datos3 =GetAcumuladoEvaluacionDocenteDetallado($nro4,$datos2[$j]['sce070d_cedula_doc'],$lapso,$datos[$i]['sce025d_codigo_sede']);
                            $k=0;
                            while($k<$nro4){ // si ha hecho algun plan de evaluacion lo contabiliza
                                                             
                                $acum = 0;
                                $carrera = $datos3[$k]['eval001d_cod_carrera'];
                                $asignatura = $datos3[$k]['sce090d_nom_asign'];
                                $seccion = $datos3[$k]['eval001d_cod_seccion'];
                                
                                while ($k<$nro4 && $carrera == $datos3[$k]['eval001d_cod_carrera'] && $asignatura == $datos3[$k]['sce090d_nom_asign'] && $seccion == $datos3[$k]['eval001d_cod_seccion']){

                                   $acum += $datos3[$k]['eval001d_ponderacion'];
                                   $k++;
                                
                                }
                                
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
                                                        
                            }

                            $j++;
                       }             
                       $suma = $cantidadcumplio100 + $cantidadnocumplio50 + $cantidadnocumplio49 + $cantidadnocumplio0; 

                       if ($suma != $acumasig[0]['acumasig']){
                           $cantidadnocumplio0 = $cantidadnocumplio0 + ($acumasig[0]['acumasig'] -$suma);
                       }

                       if ($nro2 > 0){
                           $cantidadcumplio100 = round(($cantidadcumplio100 / $acumasig[0]['acumasig'] )*100,2);
                           $cantidadnocumplio50 = round(($cantidadnocumplio50 / $acumasig[0]['acumasig'])*100,2);
                           $cantidadnocumplio49 = round(($cantidadnocumplio49 / $acumasig[0]['acumasig'])*100,2);
                           $cantidadnocumplio0 = round(($cantidadnocumplio0 / $acumasig[0]['acumasig'])*100,2);


                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                             }
                             else{
                                 $tabla = $tabla . "<tr>";   
                             }                    

                              $tabla = $tabla .  "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['sce025d_descripcion']))) . "</td>" . 
                                "<td width='75px'>" . $cantidadcumplio100  .  "%</td>" .
                                "<td width='75px'>" . $cantidadnocumplio50 . "%</td>" .    
                                "<td width='75px'>" . $cantidadnocumplio49 . "%</td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0 . "%</td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Ver Carreras Sede\" class=\"VerCarrerasPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce025d_codigo_sede'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                                "</tr>";
                       }      
                       $i++;  
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
                $datos = Consultar_Carrera_Sede($nro,$sede);
                //$lapso = Consultar_Lapso("");
                                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        $nro2 = 0;
                        $datos2 = Docentes_Sede_Carrera($nro2,$sede,$datos[$i]['sce085d_cod_carr'],$lapso);
                        $acumasig = Asignaturas_Sede_Carrera($nro3,$sede,$datos[$i]['sce085d_cod_carr'],$lapso);
                        $j=0;  
                        $cantidadcumplio100 = 0;
                        $cantidadnocumplio50 = 0;
                        $cantidadnocumplio49 = 0;
                        $cantidadnocumplio0 = 0;

                        while ($j<$nro2){
                            $acum = 0;
                            $datos3 =GetAcumuladoEvaluacionDocenteCarrera($nro4,$datos2[$j]['sce070d_cedula_doc'],$datos[$i]['sce085d_cod_carr'],$lapso,$_POST['Sede']);
                            
                            $k=0;
                            
                            while($k<$nro4){ // si ha hecho algun plan de evaluacion lo contabiliza
                                
                                                          
                                $acum = 0;
                                $asignatura = $datos3[$k]['sce090d_nom_asign'];
                                $seccion = $datos3[$k]['eval001d_cod_seccion'];
                                
                                while ($k<$nro4 && $asignatura == $datos3[$k]['sce090d_nom_asign'] &&  $seccion == $datos3[$k]['eval001d_cod_seccion']){

                                   $acum += $datos3[$k]['eval001d_ponderacion'];
                                   $k++;
                                }
                                
                                                               
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
                               
                            }
                            $j++;
        
                       }

                       $suma = $cantidadcumplio100 + $cantidadnocumplio50 + $cantidadnocumplio49 + $cantidadnocumplio0; 
                   
                       if ($suma != $acumasig[0]['acumasig']){
                            $cantidadnocumplio0 = $cantidadnocumplio0 + ($acumasig[0]['acumasig'] -$suma);
                       }
                   
                       if ($nro2 > 0){
                           $cantidadcumplio100 = round(($cantidadcumplio100 * 100 ) / $acumasig[0]['acumasig'],2);
                           $cantidadnocumplio50 = round(($cantidadnocumplio50 *100 ) / $acumasig[0]['acumasig'],2);
                           $cantidadnocumplio49 = round(($cantidadnocumplio49 *100) / $acumasig[0]['acumasig'] ,2);
                           $cantidadnocumplio0 = round(($cantidadnocumplio0 *100) / $acumasig[0]['acumasig'],2);

                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                             }
                             else{
                                 $tabla = $tabla . "<tr>";   
                             }                            

                            
                             $tabla = $tabla . "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['sce080d_nom_carr']))) . "</td>" . 
                                "<td width='75px'>" . $cantidadcumplio100 .  "%</td>" .
                                "<td width='75px'>" . $cantidadnocumplio50 . "%</td>" .    
                                "<td width='75px'>" . $cantidadnocumplio49 . "%</td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0 . "%</td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/teacher.png\" title=\"Ver Docentes\" class=\"VerDocentesPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $sede . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce085d_cod_carr'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                                "</tr>";
                        }      
                        $i++;  
                    }    
                }		            

                echo $tabla;        
            }    

            break;    

        case 3: //DOCENTE
               
            if (isset($_POST['Sede']) && isset($_POST['Carrera'])){
            
                //$lapso = Consultar_Lapso("");
                
                $datos2 = Docentes_Sede_Carrera_Asignatura($nro2,$sede,$carrera,$lapso);

                $j=0;  
               
                while ($j<$nro2){
                    $acum = 0;
                    $datos3 =GetAcumuladoEvaluacionDocenteAsignatura($nro,$datos2[$j]['sce070d_cedula_doc'],$datos2[$j]['sce070d_cod_asign'],$datos2[$j]['sce070d_seccion'],$datos2[$j]['sce070d_sede'],$lapso);
                    
                    if($j % 2){
                        $tabla = $tabla . "<tr class=\"alt\">";
                    }
                    else{
                        $tabla = $tabla . "<tr>";   
                    }
                       
                    $k=0;
                    $acum = 0;
                    while ($k<$nro){
                    
                       $acum += $datos3[$k]['eval001d_ponderacion'];
                       $k++;
                    }
                    
                    
                     $tabla = $tabla . "<td width='300px'>". $datos2[$j]['sce070d_cedula_doc'] .  " " . strtoupper(utf8_encode(trim($datos2[$j]['nombre']))) . "</td>" . 
                     "<td width='75px'>". strtoupper(utf8_encode(trim($datos2[$j]['sce090d_nom_asign']))) . "</td>" . 
                    "<td width='75px'>". $datos2[$j]['sce070d_seccion'] . "</td>" .                             
                     "<td width='75px'>" . $acum . "%</td>" .
                     "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                     "</tr>";

                    $j++;
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
            
            
            
    }//fin switch
    
} 
   

               
