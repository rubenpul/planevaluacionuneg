/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: EVAL003.php                                                                          -->  
<!-- DESCRIPCION: CONTROLADOR REPORTE REGISTRO DE EVALUACION - CGP                                   	-->
<!-- ******************************************************************************************* -->*/

$(document).ready(function () {
                   
             
        var Sesion = $('#p_Sesion').text();
                
        DatosPlanDocente();
        
        function DatosPlanDocente(){
            
           
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval011Dao.php?'+ Sesion,
                data:{Opcion:1}

                }).success(function(data){
                   
                    $('#table_planevaluacion tbody').empty();
                    $('#table_planevaluacion tbody').append(data);
                                      
                }
            );
            
            
           
            
                       
        }
     
    
 });        
       
 

