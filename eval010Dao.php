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
                        //$datos2 = Docentes_Sede($nro2,$lapso,$datos[$i]['sce025d_codigo_sede']);
                        //la cantidad de asignaturas ofertadas en la sede
                        $acumsecciones = Asignaturas_secciones($nro3,$datos[$i]['sce025d_codigo_sede'],$lapso);
                        
                        if ($acumsecciones[0]['acumasig'] > 0){
                                           
                            //obtiene el acumulado por cada sede de la tabla resumen
                            $datos3 =GetAcumuladoSede($nro4,$lapso,$datos[$i]['sce025d_codigo_sede']);

                            $cantidadcumplio100div = round(($datos3[0]['eval006d_completado'] / $acumsecciones[0]['acumasig'] )*100,2);
                            $cantidadnocumplio50div = round(($datos3[0]['eval006d_mayor50'] / $acumsecciones[0]['acumasig'])*100,2);
                            $cantidadnocumplio49div = round(($datos3[0]['eval006d_menor50'] / $acumsecciones[0]['acumasig'])*100,2);
                            $cantidadnocumplio0div = round(($datos3[0]['eval006d_sinavance'] / $acumsecciones[0]['acumasig'])*100,2);

                            if($i % 2){
                                 $tabla = $tabla . "<tr class=\"alt\">";
                            }
                            else{
                                 $tabla = $tabla . "<tr>";   
                            }                    

                            $tabla = $tabla .  "<td width='300px'>". strtoupper(utf8_encode(trim($datos3[0]['eval006d_nombresede']))) . " (". $acumsecciones[0]['acumasig'] . ")</td>" . 

                                "<td width='75px'>" . $cantidadcumplio100div . "% (". $datos3[0]['eval006d_completado'] . ")</td>" .
                                "<td width='75px'>" . $cantidadnocumplio50div . "% (". $datos3[0]['eval006d_mayor50'] . ")</td>" .    
                                "<td width='75px'>" . $cantidadnocumplio49div . "% (". $datos3[0]['eval006d_menor50'] . ")</td>" .        
                                "<td width='75px'>" . $cantidadnocumplio0div . "% (". $datos3[0]['eval006d_sinavance'] . ")</td>" .            
                                "<td width='75px'><a href=\"#\"><img src=\"../imagenes/buscarproducto.png\" title=\"Ver Carreras Sede\" class=\"VerCarrerasPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                                "<td style=\"display:none;\" width='75px'>" . $datos[$i]['sce025d_codigo_sede'] . "</td>" .
                                "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
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
                                                
                        $acumcarrera = Secciones_Sede_Carrera($nro3,$sede,$datos[$i]['eval006d_codcarr'],$lapso);
                        
                        $datos3 =GetAcumuladoCarrera($nro4,$datos[$i]['eval006d_codcarr'],$lapso,$_POST['Sede']);
                            
                        $cantidadcumplio100div = round(($datos3[0]['eval006d_completado'] / $acumcarrera[0]['acumasig'] )*100,2);
                        $cantidadnocumplio50div = round(($datos3[0]['eval006d_mayor50'] / $acumcarrera[0]['acumasig'])*100,2);
                        $cantidadnocumplio49div = round(($datos3[0]['eval006d_menor50'] / $acumcarrera[0]['acumasig'])*100,2);
                        $cantidadnocumplio0div = round(($datos3[0]['eval006d_sinavance'] / $acumcarrera[0]['acumasig'])*100,2);

                        if($i % 2){
                             $tabla = $tabla . "<tr class=\"alt\">";
                         }
                         else{
                             $tabla = $tabla . "<tr>";   
                         }                            


                        $tabla = $tabla . "<td width='300px'>". strtoupper(utf8_encode(trim($datos[$i]['eval006d_nombrecarr']))) . " (". $acumcarrera[0]['acumasig'] . ")</td>" . 
                           "<td width='75px'>" . $cantidadcumplio100div . "% (". $datos3[0]['eval006d_completado'] . ")</td>" .
                           "<td width='75px'>" . $cantidadnocumplio50div . "% (". $datos3[0]['eval006d_mayor50'] . ")</td>" .    
                           "<td width='75px'>" . $cantidadnocumplio49div . "% (". $datos3[0]['eval006d_menor50'] . ")</td>" .        
                           "<td width='75px'>" . $cantidadnocumplio0div . "% (". $datos3[0]['eval006d_sinavance'] . ")</td>" .            

                           "<td width='75px'><a href=\"#\"><img src=\"../imagenes/teacher.png\" title=\"Ver Docentes\" class=\"VerDocentesPlanificacion\" height=\"30\" width=\"30\"></a></td>" .    
                           "<td style=\"display:none;\" width='75px'>" . $sede . "</td>" .
                           "<td style=\"display:none;\" width='75px'>" . $datos[$i]['eval006d_codcarr'] . "</td>" .
                           "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                           "</tr>";
                        
                             $i++;  
                            
                    }      
                       
                }    
                
                echo $tabla;        
            }    

            break;    

        case 3: //DOCENTE
               
            if (isset($_POST['Sede']) && isset($_POST['Carrera'])){
            
        
                $j=0;  
               
                $datos3 =GetAcumuladoEvaluacionDocenteAsignatura($nro,$_POST['Sede'],$_POST['Carrera'],$lapso);
                    
                while ($j<$nro){

                    if($j % 2){
                        $tabla = $tabla . "<tr class=\"alt\">";
                    }
                    else{
                        $tabla = $tabla . "<tr>";   
                    }

                    if (trim($datos3[$j]['eval006d_ponderacion']) == ""){
                        $ponderacion = 0;
                    }
                    else{
                        $ponderacion = $datos3[$j]['eval006d_ponderacion'];
                    }

                     $tabla = $tabla . "<td width='300px'>". $datos3[$j]['eval006d_ceduladoc'] .  " " . strtoupper(utf8_encode(trim($datos3[$j]['eval006d_nombredoc']))) . "</td>" . 
                     "<td width='300px'>". strtoupper(utf8_encode(trim($datos3[$j]['eval006d_codasign'] . "-" .$datos3[$j]['eval006d_nombreasign']))) . "</td>" . 
                    "<td width='75px'>". $datos3[$j]['eval006d_seccion'] . "</td>" .                             
                     "<td width='75px'>" . $ponderacion . "%</td>" .
                     "<td style=\"display:none;\" width='75px'>" . $lapso . "</td>" .
                     "</tr>";

                    $j++;
                
                }
                         
                echo $tabla;        
            }    

            break;    
            
        case 4:   
                       
            
                $datos = ConsultarFechaHoraReporte();
            
                                                    
            
                echo trim($datos[0]['eval006d_fechahora']);
        
               
            
            break;     
            
            
            
    }//fin switch
    
} 
   

               
