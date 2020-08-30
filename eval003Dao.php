<?php

//error_reporting(E_ALL);

require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');


if(isset($_POST['Opcion'])){
    
    $opcion = $_POST['Opcion'];
    $carrera = $_POST['Carrera'];
    $plan = $_POST['Plan'];
    $semestre = $_POST['Semestre'];
    
    switch ($opcion){
        case 1: //CARRERAS
               
                $nro=0;
                $datos = Consultar_carreras($nro);
                $combo = "<select class=\"txtNormal\" name=\"cmb_carrera\" name=\"cmb_carrera\">\n".
                             "<option  selected value=\"00\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<option  value=" . trim($datos[$i]['sce080d_cod_carr']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['sce080d_nom_carr'])))  . "</option>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</select>";
                
                echo $combo;
                
                break;
                
        case 2: //DETALLE UNIDAD CURRICULAR
            
            if (isset($_POST['Carrera']) && isset($_POST['Plan'])){
                            

                $nro=0;
                $datos =  Consultar_asig_carrera($nro,$carrera,$semestre,$plan);
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
                        
                        $tabla = $tabla . "<td align=\"center\">". trim($datos[$i]["sce090d_alias_cod_asign"]) . "</td>".
                        "<td width=\"300px\">". strtoupper(utf8_encode(trim($datos[$i]["sce090d_nom_asign"]))) . "</td>". 
                        "<td width=\"33px\" align=\"center\">".  trim($datos[$i]["sce090d_uc"]) . "</td> ".
                        "<td width=\"68px\" align=\"center\">" . trim($datos[$i]["sce110d_semestre"]) . "</td>".        
                        "<td width=\"30px\"><input type=\"text\" name=\"had[]\" id=\"had\" maxlength=\"3\" size=\"1\" class=\"HorasDocente\" value = \"" . $datos[$i]["sce110d_had"] . "\"></input></td>".                
                        "<td style=\"display:none;\"><input type=\"text\" name=\"codigo[]\" id=\"codigo\" maxlength=\"1\" size=\"1\" class=\"CodUni\" value = \"" . trim($datos[$i]["sce110d_cod_asign"]) . "\"></input></td>".                
                        "<td style=\"display:none;\"><input type=\"text\" name=\"semestre[]\" id=\"semestre\" maxlength=\"1\" size=\"1\" class=\"Sem\" value = \"" . trim($datos[$i]["sce110d_semestre"]) . "\"></input></td>".                
                        "<td style=\"display:none;\"><input type=\"text\" name=\"carrera[]\" id=\"carrera\" maxlength=\"1\" size=\"1\" class=\"Sem\" value = \"" . $carrera . "\"></input></td>".                
                        "</tr>";                         
                                   
                        $i++;
                        
                    }    
                }		            

                $tabla = $tabla . "</tbody></table>";
                echo $tabla;
                
                break;
            }
        
         case 3: //ACTUALIZAR
                    
            
                if(isset($_POST['Had'])  && isset($_POST['Codigo'])  && isset($_POST['Carrera']) && isset($_POST['Semestre'])){
                     
                    $i=0;
                                        
                    while ($i< count($_POST['Carrera'])){
                        $codcarrera = $_POST['Carrera'][$i];                     
                        $codasignatura = $_POST['Codigo'][$i];
                        $had = $_POST['Had'][$i];
                        if (trim($had) != ""){
                            ActualizarHAD($codcarrera,$codasignatura,$had); 
                        }
                        $i++;
                    }
                    
                    echo 1;
                 
                }   
                else{
                    echo 0;
                }    
                break;     
                
        case 4: //plan de estudios
            
                $nro=0;
                $datos =  Consultar_plan_carrera($nro,$carrera);
                $combo = "<select class=\"txtNormal\" name=\"cmb_plan\" name=\"cmb_plan\">\n".
                             "<option  selected value=\"00\">Seleccione...</option>\n";
                
                if ($nro > 0){	
                    $i=0;                 
                    while ($i<$nro) {
                        
                        $combo = $combo. "<option  value=" . trim($datos[$i]['sce110d_cod_plan']) . ">" . trim($datos[$i]['sce110d_cod_plan'])  . "</option>\n";
                        $i++;
                        
                    }    
                }		            

                $combo = $combo. "</select>";
                
                echo $combo;
                
                break; 
            
            
        break;
            
    }//fin switch
} 
   

               
