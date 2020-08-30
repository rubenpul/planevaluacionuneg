<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
    
    $opcion = $_POST['Opcion'];
    $departamento = $_POST['Departamento'];
    $area = $_POST['Area'];
    $plan = $_POST['Plan'];
    $semestre = $_POST['Semestre'];
    
    switch ($opcion){
        case 1: //DEPARTAMENTO
               
                $nro=0;
                $datos = Consultar_departamento($nro);
                $combo = "<select class=\"txtNormal\" name=\"cmb_departamento\" name=\"cmb_departamento\">\n".
                             "<option  selected value=\"00\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<option  value=" . trim($datos[$i]['cod_departamento']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_departamento'])))  . "</option>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</select>";
                
                echo $combo;
                
                break;
                
        case 2: //DETALLE UNIDAD CURRICULAR
            
            if (isset($_POST['Departamento']) && isset($_POST['Area'])){
 
                $nro=0;
                $datos =  Consultar_docentes_departamento($nro,$departamento,$area);
                $tabla = "";
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {

                        if($i % 2){
                            $tabla = $tabla . "<tr class=\"alt\">";
                        }
                        else{
                            $tabla = $tabla . "<tr>";   
                        }
                        $tabla = $tabla . "<td width=\"100px\">". trim($datos[$i]["sce070d_cedula_doc"]) . "</td>".
                        "<td width=\"300px\">". strtoupper(utf8_encode(trim($datos[$i]["nombre"]))) . "</td>". 
                        "<td width=\"150px\">" . cargarcombo_condiciondocente($datos[$i]["cod_condicion"]) . "</td>".        
                        "<td style=\"display:none;\"><input type=\"text\" name=\"cedula[]\" id=\"cedula\" maxlength=\"1\" size=\"1\" class=\"Cedula\" value = \"" . trim($datos[$i]["sce070d_cedula_doc"]) . "\"></input></td>".
                        "<td style=\"display:none;\"><input type=\"text\" name=\"coddepartamento[]\" id=\"coddepartamento\" maxlength=\"1\" size=\"1\" class=\"Cedula\" value = \"" . trim($datos[$i]["cod_departamento"]) . "\"></input></td>".
                        "<td style=\"display:none;\"><input type=\"text\" name=\"codarea[]\" id=\"codarea\" maxlength=\"1\" size=\"1\" class=\"Cedula\" value = \"" . trim($datos[$i]["cod_area_dpto"]) . "\"></input></td>".
                        "</tr>";                         
                                   
                        $i++;
                    }    
                }		            

                $tabla = $tabla . "</tbody></table>";
                echo $tabla;
                
                break;
            }
            
               
         case 3: //ACTUALIZAR
                    
            
                if(isset($_POST['Condicion'])  && isset($_POST['Area']) && isset($_POST['Departamento'])  && isset($_POST['Cedula'])){
                     
                    $i=0;
                                        
                    while ($i< count($_POST['Cedula'])){
                        $coddepartamento = $_POST['Departamento'][$i]; 
                        $codarea = $_POST['Area'][$i]; 
                        $codcondicion = $_POST['Condicion'][$i];
                        $cedula = $_POST['Cedula'][$i];
                        if (trim($codcondicion) != "0"){
                            ActualizarCondicion($cedula,$coddepartamento,$codarea,$codcondicion); 
                        }
                        $i++;
                    }
                    
                    echo 1;
                 
                }   
                else{
                    echo 0;
                }    
                break;     
            
            case 4: //AREA
               
                $nro=0;
                $datos = Consultar_area(&$nro,$departamento);
                $combo = "<select class=\"txtNormal\" name=\"cmb_area\" name=\"cmb_area\">\n".
                             "<option  selected value=\"00\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<option  value=" . trim($datos[$i]['cod_area_dpto']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_area'])))  . "</option>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</select>";
                
                echo $combo;
                
                break;    
                
                
        
    }//fin switch
} 
   

               
