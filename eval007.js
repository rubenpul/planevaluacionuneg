/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: EVAL003.php                                                                          -->  
<!-- DESCRIPCION: CONTROLADOR REPORTE DE ASISTENCIA GESTION                                    	-->
<!-- ******************************************************************************************* -->*/

$(document).ready(function () {
        
        var Departamento;
        var Area;
       
        var Sesion = $('#Sesion').text();
        
      
        Departamentos();
               
     
        //LLENA EL COMBO DE DEPARTAMENTO
        function Departamentos(){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval007Dao.php?'+ Sesion,
                data:{Opcion:1}

                }).success(function(data){
                     $('#cmb_departamento').html(data);
                }
            );
                
        }
        
               //LLENA EL COMBO DE DEPARTAMENTO
        function Areas(Departamento){
            
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval007Dao.php?'+ Sesion,
                data:{Departamento: Departamento,Opcion:4}

                }).success(function(data){
                     $('#cmb_area').html(data);
                }
            );
                
        }
        
         
        $("#cmb_departamento").change(function(){
            
            $('#table_condiciondocente tbody').empty();
            $("#div_condiciondocente").css("display", "none");
            $("#table_condiciondocente").css("display", "none");
            $("#div_Acciones").css("display", "none");
            
            Departamento = $("#cmb_departamento").val();
                        
            if ($("#cmb_departamento").val() != '00'){
            
                Areas($("#cmb_departamento").val());
                
            } 
            else{
                
               
                
            }
        }); 
        
        
                
        //BOTON DE CONSULTA DADO UNA CARRERA
        $("#bot_consultar").click(function(){
            
            Departamento = $("#cmb_departamento").val();
            Area = $("#cmb_area").val();
                        
            if ($("#cmb_departamento").val() != '00'){
            
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval007Dao.php?'+ Sesion,
                    data:{Departamento:Departamento,Area:Area,Opcion:2}

                    }).success(function(data){
                        
                        $('#table_condiciondocente tbody').empty();
                        $('#table_condiciondocente tbody').append(data);
                        $("#div_condiciondocente").css("display", "block");
                        $("#table_condiciondocente").css("display", "block");
                        $("#div_Acciones").css("display", "block");
                    }
                );  
            } 
            else{
                
                $('#table_condiciondocente tbody').empty();
                $("#div_condiciondocente").css("display", "none");
                $("#table_condiciondocente").css("display", "none");
                $("#div_Acciones").css("display", "none");
                
            }
        }); 
        
        //BOTON DE ACTUALIZAR LOS HAD
        $("#actualizarTCD").click(function(){
            
            var arrayCondicion = [];
            var arrayCodDepart = [];
            var arrayCodArea = [];
            var arrayCedula = [];
            
            $('select[name^="cmb_condicion"]').each(function() {
                arrayCondicion.push($(this).val());
            });
            
            $('input[name^="coddepartamento"]').each(function() {
                arrayCodDepart.push($(this).val());
            });

            $('input[name^="codarea"]').each(function() {
                arrayCodArea.push($(this).val());
            });

            $('input[name^="cedula"]').each(function() {
                arrayCedula.push($(this).val());
            });
             
                       
            if ($("#cmb_departamento").val() != '00'){
            
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval007Dao.php?'+ Sesion,
                    data:{Cedula:arrayCedula,Condicion:arrayCondicion,Departamento:arrayCodDepart,Area:arrayCodArea,Opcion:3}

                    }).success(function(data){
                                           
                       if (data == 1){
                            alert("ACTUALIZADO DATOS DE LOS DOCENTES");
                        }
                        else{
                            alert("NO SE ACTUALIZARON LOS DATOS DE LOS DOCENTES");
                        
                        }
                        
                    }
                );  
            } 
            else{
                
                alert("SELECCIONAR UN PROYECTO DE CARRERA PARA ACTUALIZAR");
                
                $('#table_condiciondocente tbody').empty();
                $("#div_condiciondocente").css("display", "none");
                $("#table_condiciondocente").css("display", "none");
                $("#div_Acciones").css("display", "none");
                
            }
        }); 
        
        
        
        
       
 });        
       
 

