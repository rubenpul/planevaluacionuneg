<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
        
    $opcion = $_POST['Opcion'];
    
    switch ($opcion){

        case 1:   
                       
                       
                $datos = unserialize($_SESSION['dataplan']);
                $lendatos = unserialize($_SESSION['lendataplan']);    
                
                $j=0;  
                     
                $tabla = "";
                while ($j<$lendatos){
                    
                    if($j % 2){
                        $tabla = $tabla . "<tr class=\"alt\">";
                    }
                    else{
                        $tabla = $tabla . "<tr>";   
                    }
                       
                    if (trim($datos[$j]['eval001d_status']) == '0'){
                        $status = "EVALUADO";
                    }
                    else{
                        $status = "POR EVALUAR";
                    }
                                       
                    
                     $tabla = $tabla . "<td width='100px'>". strtoupper(utf8_encode($datos[$j]['eval001d_producto'])) . "</td>" . 
                     "<td width='75px'>". strtoupper(utf8_encode($datos[$j]['eval001d_actividad'])) . "</td>" . 
                     "<td width='75px'>". strtoupper(utf8_encode($datos[$j]['eval001d_criterio'])) . "</td>" .                             
                     "<td width='75px'>" . strtoupper(utf8_encode($datos[$j]['eval003d_descripcion'])) . "</td>" .
                     "<td width='75px'>".  $datos[$j]['eval001d_ponderacion'] . "%</td>" .                             
                     "<td width='75px'>" . $datos[$j]['eval001d_sem_planificacion'] . "</td>" .
                     "<td width='75px'>" . $status . "</td>" .        
                     "</tr>";

                    $j++;
                }      
               
                echo $tabla;
                       
            

            break;               
                
            
                      
            
            
    }//fin switch
    
} 
   

               
