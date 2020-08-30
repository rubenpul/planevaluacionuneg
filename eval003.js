/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: EVAL003.php                                                                          -->  
<!-- DESCRIPCION: CONTROLADOR REPORTE DE ASISTENCIA GESTION                                    	-->
<!-- ******************************************************************************************* -->*/

$(document).ready(function () {
        
        var Carrera;
        var Semestre;
        var Plan;
        var Sesion = $('#Sesion').text();
        
      
        Carreras();
        
       
     
        //LLENA EL COMBO DE LAS CARRERAS    
        function Carreras(){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval003Dao.php?'+ Sesion,
                data:{Opcion:1}

                }).success(function(data){
                     $('#cmb_carrera').html(data);
                }
            );
                
        }
        
        //AL CAMBIAR CARRERA SE TRAE EL PLAN DE ESTUDIOS 
        $("#cmb_carrera").change(function(){
            if ($("#cmb_carrera").val() != '00'){
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval003Dao.php?'+ Sesion,
                    data:{Carrera:$("#cmb_carrera").val(),Opcion:4}

                    }).success(function(data){
                         $('#cmb_plan').html(data);
                    }
                );
            }    
            else{
                
                $('#cmb_plan').html('');
            }    
            
        });
        
        //BOTON DE CONSULTA DADO UNA CARRERA
        $("#bot_consultar").click(function(){
            
            Carrera = $("#cmb_carrera").val();
            Semestre = $("#cmb_semestre").val();
            Plan = $("#cmb_plan").val();
             
            if ($("#cmb_carrera").val() != '00'){
            
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval003Dao.php?'+ Sesion,
                    data:{Carrera:Carrera,Semestre:Semestre,Plan:Plan,Opcion:2}

                    }).success(function(data){
                        
                        $('#table_unidadcurricular tbody').empty();
                        $('#table_unidadcurricular tbody').append(data);
                        $("#div_unidadcurricular").css("display", "block");
                        $("#table_unidadcurricular").css("display", "block");
                        $("#div_Acciones").css("display", "block");
                    }
                );  
            } 
            else{
                
                $('#table_unidadcurricular tbody').empty();
                $("#div_unidadcurricular").css("display", "none");
                $("#table_unidadcurricular").css("display", "none");
                $("#div_Acciones").css("display", "none");
                
            }
        }); 
        
        //BOTON DE ACTUALIZAR LOS HAD
        $("#actualizarHAD").click(function(){
            
            var arrayHad = [];
            var arrayCodigo = [];
            var arraySemestre = [];
            var arrayCarrera = [];
            
            $('input[name^="had"]').each(function() {
                arrayHad.push($(this).val());
            });
            
            $('input[name^="codigo"]').each(function() {
                arrayCodigo.push($(this).val());
            });

            $('input[name^="semestre"]').each(function() {
                arraySemestre.push($(this).val());
            });

            $('input[name^="carrera"]').each(function() {
                arrayCarrera.push($(this).val());
            });
             
            if ($("#cmb_carrera").val() != '00'){
            
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval003Dao.php?'+ Sesion,
                    data:{Had:arrayHad,Codigo:arrayCodigo,Carrera:arrayCarrera,Semestre:arraySemestre,Opcion:3}

                    }).success(function(data){
                                           
                       if (data == 1){
                            alert("ACTUALIZADO DATOS DE HAD");
                        }
                        else{
                            alert("NO SE ACTUALIZARON LOS DATOS DE HAD");
                        
                        }
                        
                    }
                );  
            } 
            else{
                
                alert("SELECCIONAR UN PROYECTO DE CARRERA PARA ACTUALIZAR");
                
                $('#table_unidadcurricular tbody').empty();
                $("#div_unidadcurricular").css("display", "none");
                $("#table_unidadcurricular").css("display", "none");
                $("#div_Acciones").css("display", "none");
                
            }
        }); 
        
        
    //VALIDAR DATOS DE HAD QUE SEA NUMERICO 
    $("#table_unidadcurricular").on('keyup', '.HorasDocente', function () {
                                
            this.value = (this.value + '').replace(/[^0-9]/g, '');  
            
            if (this.value != ""){
                /*if (this.value < 1 || this.value >16){
                    this.value = "";
                    alert("LA SEMANA DE LA EVALUACIÓN ES MIN 1 - MÁX 16");
                }*/
            }    
            else{
                
            }
    });
          
        
        
        
       
 });        
       
 

