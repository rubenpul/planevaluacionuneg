/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: EVAL003.php                                                                          -->  
<!-- DESCRIPCION: CONTROLADOR REPORTE REGISTRO DE EVALUACION - CGP                                   	-->
<!-- ******************************************************************************************* -->*/

$(document).ready(function () {
        
             
        var Sesion = $('#p_Sesion').text();
        var sede; 
        var codsede;
        var lapsoacademico;
        
        Sedes("");
        
        FechaHoraReporte();
        
        function FechaHoraReporte(){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval010Dao.php?'+ Sesion,
                data:{Opcion:4}

                }).success(function(data){
                    //alert(data);
                    $('#lbl_fechareporte').text("Fecha Reporte: " + data); 
                   
                    
                }
            );     
            
            
        }

        $("input[name=radio_lapso]").change(function () {	
            var lapso = $(this).val();
        
            if(lapso.trim() == "LAPSO"){
                $("#cmb_lapsoconsulta").prop("disabled",false);
            }
            else{
                $("#cmb_lapsoconsulta").val('0');
                $("#cmb_lapsoconsulta").prop("disabled",true);
            }
        });
     
        $("#bot_buscarlapso").click(function(){
            var valor;
             
            valor = $('input:radio[name=radio_lapso]:checked').val();
       
            $("#div_carrera").css("display", "none"); 
            $("#div_docente").css("display", "none");
            $("#lbl_consulta").text(''); 
            $("#lbl_consulta_2").text(''); 
        
        
            if (valor == "LAPSO"){
          
                if ($("#cmb_lapsoconsulta").val() != 0){
                        //DATOS DOCENTE LAPSO ACTIVO
                    Sedes($("#cmb_lapsoconsulta").val());    
                                  
                }
                else{
                    alert("SELECCIONE EL LAPSO ACADÉMICO A CONSULTAR");
                }
           
            } 
            else{
                 if (valor == "LAPSOACTUAL"){
                    Sedes("");          
                 }
                 else{
                     
                     Sedes("CIVA");                            
                 }     
            }
        }); 
    
        
        //LLENA EL %DE AVANCE DE LAS SEDES EN LA PLANIFICACION
        function Sedes(Lapso){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval010Dao.php?'+ Sesion,
                data:{Opcion:1,LapsoAcademico:Lapso}

                }).success(function(data){
                    //alert(data);
                    $('#table_sedes tbody').empty(); 
                    $('#table_sedes tbody').html(data);
                    
                }
            );
    
        
                
        }
   
        
        $("#table_sedes").on('click', '.VerCarrerasPlanificacion', function () {
    
           
            var consulta;
            
            //obtener datos de la sede
            $(this).closest('tr').each(function(index, element){
                              
                codsede =   $(element).find("td").eq(6).html();
                consulta =  "PROYECTOS DE CARRERA SEDE " + $(element).find("td").eq(0).html();
                sede = $(element).find("td").eq(0).html();
                lapsoacademico = $(element).find("td").eq(7).html();
            });    
            
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval010Dao.php?'+ Sesion,
                data:{Opcion:2,Sede:codsede,LapsoAcademico:lapsoacademico}

                }).success(function(data){
                    $("#table_carrera tbody").empty();
                    
                    $('#table_carrera tbody').html(data);
                    $("#div_carrera").css("display", "block"); 
                    $("#div_docente").css("display", "none"); 
                    $("#lbl_consulta").text(consulta); 
                    $("#lbl_consulta_2").text(''); 
                }
            );
        });

    
        $("#table_carrera").on('click', '.VerDocentesPlanificacion', function () {
    
            var codcarrera;
            var consulta;
            
            //obtener datos de la sede
            $(this).closest('tr').each(function(index, element){
                              
                codsede =   $(element).find("td").eq(6).html();
                codcarrera = $(element).find("td").eq(7).html();
                lapsoacademico = $(element).find("td").eq(8).html();
                consulta =  "DOCENTES SEDE " + sede + " PROYECTO DE CARRERA " + $(element).find("td").eq(0).html();
            });    
            
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval010Dao.php?'+ Sesion,
                data:{Opcion:3,Sede:codsede,Carrera:codcarrera,LapsoAcademico:lapsoacademico}

                }).success(function(data){
                    $("#table_docente tbody").empty();
                    $('#table_docente tbody').html(data);
                    $("#div_docente").css("display", "block"); 
                    $("#lbl_consulta_2").text(consulta); 
                }
            );
            
            
            
        });
    
    
 });        
       
 

