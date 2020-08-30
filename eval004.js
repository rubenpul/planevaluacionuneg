/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: EVAL004.php                                                                          -->  
<!-- DESCRIPCION: CONTROLADOR REPORTE DE ASISTENCIA GESTION                                    	-->
<!-- ******************************************************************************************* -->*/

$(document).ready(function () {
        
        var Carrera;
        var Semestre;
        var Condicion;
        var Sesion = $('#Sesion').text();
        
      
        Carreras();
        CondicionDocente();

        //LLENA EL COMBO DE LAS CONDICIONES DOCENTE    
        function CondicionDocente(){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval004Dao.php?'+ Sesion,
                data:{Opcion:3}

                }).success(function(data){
                     $('#cmb_condicion').html(data);
                }
            );
                
        }
    
        //LLENA EL COMBO DE LAS CARRERAS    
        function Carreras(){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval004Dao.php?'+ Sesion,
                data:{Opcion:1}

                }).success(function(data){
                     $('#cmb_carrera').html(data);
                }
            );
                
        }
        
        //BOTON DE CONSULTA DADO UNA CARRERA
        $("#bot_consultar").click(function(){
            
            Carrera = $("#cmb_carrera").val();
            Semestre = $("#cmb_semestre").val();
            Condicion = $("#cmb_condicion").val();
             
            if ($("#cmb_carrera").val() != '00'){
            
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval004Dao.php?'+ Sesion,
                    data:{Carrera:Carrera,Semestre:Semestre,Condicion:Condicion,Opcion:2}

                    }).success(function(data){
                        
                        $('#table_resumenasistencia tbody').empty();
                        $('#table_resumenasistencia tbody').append(data);
                        $("#div_asistencia").css("display", "block");
                        $("#table_resumenasistencia").css("display", "block");
                        $("#div_Acciones").css("display", "block");
                    }
                ); 
        
        
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval004Dao.php?'+ Sesion,
                    data:{Carrera:Carrera,Semestre:Semestre,Condicion:Condicion,Opcion:4}

                    }).success(function(data){
                      
                        $("#datos_export_excel").val(data);
                       
                        
                    }
                ); 
        
                
            } 
            else{
                alert("Seleccione un Proyecto de Carrera");
                $('#table_resumenasistencia tbody').empty();
                $("#div_asistencia").css("display", "none");
                $("#table_resumenasistencia").css("display", "none");
                $("#div_Acciones").css("display", "none");
                
            }
        }); 
        
    
    
       //BOTON DE CONSULTA DADO UNA CARRERA
        $("#cmb_carrera").change(function(){
            
              $('#table_resumenasistencia tbody').empty();
              $("#div_asistencia").css("display", "none");
              $("#table_resumenasistencia").css("display", "none");
              $("#div_Acciones").css("display", "none");
                    
        }); 
        
       //BOTON DE CONSULTA DADO UNA CARRERA
        $("#cmb_semestre").change(function(){
            
              $('#table_resumenasistencia tbody').empty();
              $("#div_asistencia").css("display", "none");
              $("#table_resumenasistencia").css("display", "none");
              $("#div_Acciones").css("display", "none");
                    
        }); 
        
        
              //BOTON DE CONSULTA DADO UNA CARRERA
        $("#cmb_condicion").change(function(){
            
              $('#table_resumenasistencia tbody').empty();
              $("#div_asistencia").css("display", "none");
              $("#table_resumenasistencia").css("display", "none");
              $("#div_Acciones").css("display", "none");
                    
        }); 
    
    
          
        
        
        
       
 });        
       
 

