/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: eval002.php                                                                          -->  
<!-- DESCRIPCION: Controlador de Eventos de la pagina de eval002.php. Creaci�n de plantilla asistencia-->
<!-- ******************************************************************************************* -->*/


   //ACTUALIZA LA PAGINA PARA MOSTRAR LOS DATOS DE LOS ESTUDIANTES SI ES UNO O DOS PARA 
    //LA PROPUESTA DE TRABAJO DE GRADO
    
$(document).ready(function () {
    
       
    var Sesion = $('#p_Sesion').text();
    var Cedula = $('#p_Cedula').text();
    
    var start = new Date($('#fechaactual').val());
    var end;
    var diff;
    
    DatosDocente();

  
     
    $("#bot_buscarlapso").click(function(){
       var valor;
             
       valor = $('input:radio[name=radio_lapso]:checked').val();
       
       $("#a_116").css("display", "none");
       $("#a_1732").css("display", "none");
       $("#a_3348").css("display", "none");
                
       $("#div_EncuentroDocente").css("display", "none");
                
       $("#td_pdf").css("display", "none");
                
       $("#td_guardar").css("display", "none"); 
       
       $("#div_Nroencuentros").css("display", "none");
              
       if (valor == "LAPSOACTUAL"){
                //DATOS DOCENTE LAPSO ACTIVO
            DatosDocente();           
        }
        else{
            //DATOS DOCENTE LAPSO CIVA
             $.ajax({

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval002Dao.php?'+ Sesion,
                 data:{Cedula:Cedula,Opcion:11}

             }).success(function(data){
                 $('#table_ofertadocente tbody').empty(); 
                 $('#table_ofertadocente tbody').append(data);
                 $('.ImagenIndicador').hide();
             });                         
        }     
   
   });     
    
      
     //GUARDAR TODA LAS ASISTENCIAS
    $("#a_GuardarAsistencia").click(function(){
        
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var asignatura;
        var sede;
        var carrera;
        var docente;
        var semestre;
        var encuentro;
       
        var arrayHeaderEncuentro = [];
        var arrayFechasEncuentro = [];
        var arrayEncuentro1 = [];
        var arrayEncuentro2 = [];
        var arrayEncuentro3 = [];
        var arrayEncuentro4 = [];
        var arrayEncuentro5 = [];
        var arrayEncuentro6 = [];
        var arrayEncuentro7 = [];
        var arrayEncuentro8 = [];
        var arrayEncuentro9 = [];
        var arrayEncuentroA10 = [];
        var arrayEncuentroA11 = [];
        var arrayEncuentroA12 = [];
        var arrayEncuentroA13 = [];
        var arrayEncuentroA14 = [];
        var arrayEncuentroA15 = [];
        var arrayEncuentroA16 = [];
        var arrayCedula = [];
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademico").text();
        carrera = $("#lbl_carrera").text();
        asignatura = $("#lbl_asignatura").text();
        sede = $("#lbl_sede").text();
        docente = $("#lbl_docente").text();
        semestre = $("#lbl_semestre").text();
        encuentro = $("#cmb_encuentro").val();
        
         $("#preloader").css("display", "block");
       
        $('#table_detalleasistencia tr').each(function(index, element){

            if (index == 2){
                for (var i=0; i<16; i++) {
                    arrayHeaderEncuentro.push($(element).find("th").eq(i+1).html());
                    
                }    
            }
           
        });   
        
        
       arrayFechasEncuentro.push($("#txt_fechaencuentro1").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro2").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro3").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro4").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro5").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro6").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro7").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro8").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro9").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro10").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro11").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro12").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro13").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro14").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro15").val());
       arrayFechasEncuentro.push($("#txt_fechaencuentro16").val());
       
             
       $('input[name^="cedula"]').each(function() {
             arrayCedula.push($(this).val());
       }); 
      
       $('input[name^="encuentro1"]').each(function() {
             arrayEncuentro1.push($(this).is(':checked'));
       }); 
       
       $('input[name^="encuentro2"]').each(function() {
             arrayEncuentro2.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro3"]').each(function() {
             arrayEncuentro3.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro4"]').each(function() {
             arrayEncuentro4.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro5"]').each(function() {
             arrayEncuentro5.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro6"]').each(function() {
             arrayEncuentro6.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro7"]').each(function() {
             arrayEncuentro7.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro8"]').each(function() {
             arrayEncuentro8.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentro9"]').each(function() {
             arrayEncuentro9.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentroA10"]').each(function() {
             arrayEncuentroA10.push($(this).is(':checked'));
       });
        
       $('input[name^="encuentroA11"]').each(function() {
             arrayEncuentroA11.push($(this).is(':checked'));
       });

       $('input[name^="encuentroA12"]').each(function() {
             arrayEncuentroA12.push($(this).is(':checked'));
       });

       $('input[name^="encuentroA13"]').each(function() {
             arrayEncuentroA13.push($(this).is(':checked'));
       });

       $('input[name^="encuentroA14"]').each(function() {
             arrayEncuentroA14.push($(this).is(':checked'));
       });
       
       $('input[name^="encuentroA15"]').each(function() {
             arrayEncuentroA15.push($(this).is(':checked'));
       });       

       $('input[name^="encuentroA16"]').each(function() {
             arrayEncuentroA16.push($(this).is(':checked'));
       });
       
             
       
       $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{NroEncuentro:encuentro,FechaEncuentro:arrayFechasEncuentro,IdEncuentro:arrayHeaderEncuentro,CedulaAsistencia:arrayCedula,Encuentro1:arrayEncuentro1,Encuentro2:arrayEncuentro2,Encuentro3:arrayEncuentro3,Encuentro4:arrayEncuentro4,Encuentro5:arrayEncuentro5,Encuentro6:arrayEncuentro6,Encuentro7:arrayEncuentro7,Encuentro8:arrayEncuentro8,Encuentro9:arrayEncuentro9,EncuentroA10:arrayEncuentroA10,EncuentroA11:arrayEncuentroA11,EncuentroA12:arrayEncuentroA12,EncuentroA13:arrayEncuentroA13,EncuentroA14:arrayEncuentroA14,EncuentroA15:arrayEncuentroA15,EncuentroA16:arrayEncuentroA16,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Encuentro:116,Opcion:8}
           
        }).success(function(data){
           
            if(data == 1){
               alert("GUARDADO LAS ASISTENCIAS SATISFACTORIAMENTE");
                       
            } 
           $("#preloader").css("display", "none");
        });
        
        
        
        $("#preloader").css("display", "none");
        
     });
   
   
   
 
     //VISUALIZAR ENCUENTROS DEL PLAN DE EVALUACION
    $("#table_sesiones").on('click', '.VisualizarAsistencia116', function () {
        var contador = 0;
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var asignatura;
        var sede;
        var carrera;
        var docente;
        var semestre;
        var arrayEncuentro = [];
        var str;
        
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademico").text();
        carrera = $("#lbl_carrera").text();
        asignatura = $("#lbl_asignatura").text();
        sede = $("#lbl_sede").text();
        docente = $("#lbl_docente").text();
        semestre = $("#lbl_semestre").text();
        
                   
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{StartEval:1,EndEval:16,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Encuentro:116,Opcion:7}

        }).success(function(data){
            
            $("#table_detalleasistencia tbody").empty();
        
            $("#table_detalleasistencia tbody").append(data);

            $("#table_detalleasistencia").css("display", "block");
            
            $("#td_pdf").html("<a href=\"visor_report.php?" + Sesion + "&codreporte=116&Cedula=" + Cedula + "&Seccion=" + seccion + "&LapsoVigencia=" + lapsovigencia + "&Carrera=" + codcarr + "&Asignatura=" + codasign + "&Sede=" + codsede + "&LapsoAcademico=" + lapsoacademico + "&DesCarrera=" + carrera + "&DesAsignatura=" + asignatura + "&DesSede=" + sede + "&DesDocente=" + docente + "&DesSemestre=" + semestre + "\"><img title=\"Exportar a PDF plantilla de Asistencias\" src=\"../imagenes/pdf.png\" alt=\"Exportar Plantilla de Asistencias\" height=\"30\" width=\"30\" id=\"exportarplantillaasistencias\" /></a>");
                   
            $("#td_pdf").css("display", "block");
            
            $("#td_guardar").css("display", "block");
            
            $("#div_EncuentroDocente").css("display", "block");

        });

        $('#table_detalleasistencia tr').each(function(index, element){
            if (index == 2){
                for (var i=0; i<16; i++) {
                    $(element).find("th").eq(i+1).html(i+1);
                    arrayEncuentro.push($(element).find("th").eq(i+1).html());
                }

            }

         });   

 
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{Encuentro: arrayEncuentro,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:9}

        }).success(function(data){

            str = data.split("!!");

            MostrarEncuentrosValidados(str);

        });
                
        
    }); 
    
    
        //VISUALIZAR ENCUENTROS DEL PLAN DE EVALUACION
    $("#table_sesiones").on('click', '.VisualizarAsistencia1732', function () {
         var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var asignatura;
        var sede;
        var carrera;
        var docente;
        var semestre;
        var arrayEncuentro = [];
        var str;
        var contador = 0;
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademico").text();
        carrera = $("#lbl_carrera").text();
        asignatura = $("#lbl_asignatura").text();
        sede = $("#lbl_sede").text();
        docente = $("#lbl_docente").text();
        semestre = $("#lbl_semestre").text();
                
              
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{StartEval:17,EndEval:32,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Encuentro:1732,Opcion:7}

        }).success(function(data){
            
            
            $("#table_detalleasistencia tbody").empty();
            
            $("#table_detalleasistencia tbody").append(data);

            $("#table_detalleasistencia").css("display", "block");
            
            $("#td_pdf").html("<a href=\"visor_report.php?" + Sesion + "&codreporte=1732&Cedula=" + Cedula + "&Seccion=" + seccion + "&LapsoVigencia=" + lapsovigencia + "&Carrera=" + codcarr + "&Asignatura=" + codasign + "&Sede=" + codsede + "&LapsoAcademico=" + lapsoacademico + "&DesCarrera=" + carrera + "&DesAsignatura=" + asignatura + "&DesSede=" + sede + "&DesDocente=" + docente + "&DesSemestre=" + semestre + "\"><img title=\"Exportar a PDF plantilla de Asistencias\" src=\"../imagenes/pdf.png\" alt=\"Exportar Plantilla de Asistencias\" height=\"30\" width=\"30\" id=\"exportarplantillaasistencias\" /></a>");
                    
            $("#td_pdf").css("display", "block");
            
            $("#td_guardar").css("display", "block");
            
            $("#div_EncuentroDocente").css("display", "block");
            
        });

        $('#table_detalleasistencia tr').each(function(index, element){
            if (index == 2){
                for (var i=0; i<16; i++) {
                    $(element).find("th").eq(i+1).html(i+17);
                    arrayEncuentro.push($(element).find("th").eq(i+1).html());
                }
            }

         });   
     
          
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{Encuentro: arrayEncuentro,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:9}

        }).success(function(data){

            str = data.split("!!");

            MostrarEncuentrosValidados(str);

        });         
     
        
    }); 
    
        //VISUALIZAR ENCUENTROS DEL PLAN DE EVALUACION
    $("#table_sesiones").on('click', '.VisualizarAsistencia3348', function () {
        var sesiones
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var asignatura;
        var sede;
        var carrera;
        var docente;
        var semestre;
        var arrayEncuentro = [];
        var contador = 0;
        var str;
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademico").text();
        carrera = $("#lbl_carrera").text();
        asignatura = $("#lbl_asignatura").text();
        sede = $("#lbl_sede").text();
        docente = $("#lbl_docente").text();
        semestre = $("#lbl_semestre").text();
                
              
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{StartEval:33,EndEval:48,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Encuentro:3348,Opcion:7}

        }).success(function(data){
            
            $("#table_detalleasistencia tbody").empty();
            
            $("#table_detalleasistencia tbody").append(data);

            $("#table_detalleasistencia").css("display", "block");
            
            $("#td_pdf").html("<a href=\"visor_report.php?" + Sesion + "&codreporte=3348&Cedula=" + Cedula + "&Seccion=" + seccion + "&LapsoVigencia=" + lapsovigencia + "&Carrera=" + codcarr + "&Asignatura=" + codasign + "&Sede=" + codsede + "&LapsoAcademico=" + lapsoacademico + "&DesCarrera=" + carrera + "&DesAsignatura=" + asignatura + "&DesSede=" + sede + "&DesDocente=" + docente + "&DesSemestre=" + semestre + "\"><img title=\"Exportar a PDF plantilla de Asistencias\" src=\"../imagenes/pdf.png\" alt=\"Exportar Plantilla de Asistencias\" height=\"30\" width=\"30\" id=\"exportarplantillaasistencias\" /></a>");
                      
            $("#td_pdf").css("display", "block");
            
            $("#td_guardar").css("display", "block");
            
            $("#div_EncuentroDocente").css("display", "block");
            
        });

        $('#table_detalleasistencia tr').each(function(index, element){
            if (index == 2){
                for (var i=0; i<16; i++) {
                    $(element).find("th").eq(i+1).html(i+33);
                    arrayEncuentro.push($(element).find("th").eq(i+1).html());
                }

            }

         });   
     
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{Encuentro: arrayEncuentro,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:9}

        }).success(function(data){

            str = data.split("!!");

            MostrarEncuentrosValidados(str);
        
        });
         
     
        
    }); 
    
    
    
     //CALCULAR NRO DE SESIONES DE CLASES DEL DOCENTE
    $("#cmb_encuentro").change(function(){
        var encuentros;
        var sesiones;
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var asignatura;
        var sede;
        var carrera;
        var docente;
        var semestre;
        var arrayEncuentro = [];
        var str;
        var valor;
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademico").text();
        carrera = $("#lbl_carrera").text();
        asignatura = $("#lbl_asignatura").text();
        sede = $("#lbl_sede").text();
        docente = $("#lbl_docente").text();
        semestre = $("#lbl_semestre").text();
        valor = $('input:radio[name=radio_lapso]:checked').val();
        
        if (valor == 'LAPSOACTUAL'){
            encuentros = $("#cmb_encuentro").val();
                        
            sesiones = parseInt(encuentros) * 16;
        
            $("#lbl_nrosesionesclases").text("SESIONES DE CLASES " + sesiones);
        }
        else{
            
            encuentros = 4;
                              
            $("#lbl_nrosesionesclases").text('');
                
        }
        
        switch(parseInt(encuentros)) {
            
            case 0:
                $("#a_116").css("display", "none");
                $("#a_1732").css("display", "none");
                $("#a_3348").css("display", "none");
                
                $("#div_EncuentroDocente").css("display", "none");
                
                $("#td_pdf").css("display", "none");
                
                $("#td_guardar").css("display", "none");
                 
             break;    
            case 1:
                $("#a_116").css("display", "none");
                $("#a_1732").css("display", "none");
                $("#a_3348").css("display", "none");
                
               
                
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval002Dao.php?'+ Sesion,
                    data:{StartEval:1,EndEval:16,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:7}

                }).success(function(data){

                    $("#table_detalleasistencia tbody").empty();
                    
                    $("#table_detalleasistencia tbody").append(data);
                    
                    $("#table_detalleasistencia").css("display", "block");
                    
                    $("#td_pdf").html("<a href=\"visor_report.php?" + Sesion + "&codreporte=116&Cedula=" + Cedula + "&Seccion=" + seccion + "&LapsoVigencia=" + lapsovigencia + "&Carrera=" + codcarr + "&Asignatura=" + codasign + "&Sede=" + codsede + "&LapsoAcademico=" + lapsoacademico + "&DesCarrera=" + carrera + "&DesAsignatura=" + asignatura + "&DesSede=" + sede + "&DesDocente=" + docente + "&DesSemestre=" + semestre + "\"><img title=\"Exportar a PDF plantilla de Asistencias\" src=\"../imagenes/pdf.png\" alt=\"Exportar Plantilla de Asistencias\" height=\"30\" width=\"30\" id=\"exportarplantillaasistencias\" /></a>");
                                     
                    $("#td_pdf").css("display", "block");
                    
                    $("#td_guardar").css("display", "block");
                    
                    $("#div_EncuentroDocente").css("display", "block");
                    
                   
                });

                $('#table_detalleasistencia tr').each(function(index, element){
                    if (index == 2){
                        for (var i=0; i<16; i++) {
                            $(element).find("th").eq(i+1).html(i+1);
                            arrayEncuentro.push($(element).find("th").eq(i+1).html());
                        }
                        
                    }
                   
                 });  
                                  
                                 
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval002Dao.php?'+ Sesion,
                    data:{Encuentro: arrayEncuentro,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:9}

                }).success(function(data){
                    
                    str = data.split("!!");
                    
                    
                    MostrarEncuentrosValidados(str);
                    
                             
                   
                });
                 
                 
                 
                 
           
             break;
            case 2:
                $("#a_116").css("display", "block");
                $("#a_1732").css("display", "block");
                $("#a_3348").css("display", "none");
                

                $("#td_pdf").css("display", "none");
                
                $("#td_guardar").css("display", "none");
                
                $("#table_detalleasistencia").css("display", "none");
                
                $("#div_EncuentroDocente").css("display", "none");

            break;
            case 3:
                $("#a_116").css("display", "block");
                $("#a_1732").css("display", "block");
                $("#a_3348").css("display", "block");
                
                $("#td_pdf").css("display", "none");
                
                $("#td_guardar").css("display", "none");
                
                $("#table_detalleasistencia").css("display", "none");
                
                $("#div_EncuentroDocente").css("display", "none");
                
            break;

            case 4:
                $("#a_116").css("display", "none");
                $("#a_1732").css("display", "none");
                $("#a_3348").css("display", "none");
                
                    
                
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval002Dao.php?'+ Sesion,
                    data:{StartEval:1,EndEval:16,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:7}

                }).success(function(data){

                    $("#table_detalleasistencia tbody").empty();
                    
                    $("#table_detalleasistencia tbody").append(data);
                    
                    $("#table_detalleasistencia").css("display", "block");
                    
                    $("#td_pdf").html("<a href=\"visor_report.php?" + Sesion + "&codreporte=116&Cedula=" + Cedula + "&Seccion=" + seccion + "&LapsoVigencia=" + lapsovigencia + "&Carrera=" + codcarr + "&Asignatura=" + codasign + "&Sede=" + codsede + "&LapsoAcademico=" + lapsoacademico + "&DesCarrera=" + carrera + "&DesAsignatura=" + asignatura + "&DesSede=" + sede + "&DesDocente=" + docente + "&DesSemestre=" + semestre + "\"><img title=\"Exportar a PDF plantilla de Asistencias\" src=\"../imagenes/pdf.png\" alt=\"Exportar Plantilla de Asistencias\" height=\"30\" width=\"30\" id=\"exportarplantillaasistencias\" /></a>");
                                     
                    $("#td_pdf").css("display", "block");
                    
                    $("#td_guardar").css("display", "block");
                    
                    $("#div_EncuentroDocente").css("display", "block");
                    
                   
                });

                $('#table_detalleasistencia tr').each(function(index, element){
                    if (index == 2){
                        for (var i=0; i<16; i++) {
                            $(element).find("th").eq(i+1).html(i+1);
                            arrayEncuentro.push($(element).find("th").eq(i+1).html());
                        }
                        
                    }
                   
                 });  
                                  
                                 
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval002Dao.php?'+ Sesion,
                    data:{Encuentro: arrayEncuentro,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:9}

                }).success(function(data){
                    
                    str = data.split("!!");
                    
                    
                    MostrarEncuentrosValidados(str);
                    
                             
                   
                });
                
           
             break;            
            
            
        } 
    }); 

    
    function InicializarFechasValidadas(){
        
       $("#txt_fechaencuentro1").val('');
       $("#txt_fechaencuentro2").val('');
       $("#txt_fechaencuentro3").val('');
       $("#txt_fechaencuentro4").val('');
       $("#txt_fechaencuentro5").val('');
       $("#txt_fechaencuentro6").val('');
       $("#txt_fechaencuentro7").val('');
       $("#txt_fechaencuentro8").val('');
       $("#txt_fechaencuentro9").val('');
       $("#txt_fechaencuentro10").val('');
       $("#txt_fechaencuentro11").val('');
       $("#txt_fechaencuentro12").val('');
       $("#txt_fechaencuentro13").val('');
       $("#txt_fechaencuentro14").val('');
       $("#txt_fechaencuentro15").val('');
       $("#txt_fechaencuentro16").val('');
        
    }


    function MostrarEncuentrosValidados(str){
        
        InicializarFechasValidadas();
        
        if (str[0] != 0){
            $("#txt_fechaencuentro1").val(str[0]);
            $("#img_Encuentro1").hide();
            $("#img_Encuentro1Asig").show(); 
            $('#img_Encuentro1Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro1").show();
            $("#img_Encuentro1Asig").hide(); 
        }

        if (str[1] != 0){
            $("#txt_fechaencuentro2").val(str[1]);
            $("#img_Encuentro2").hide();
            $("#img_Encuentro2Asig").show(); 
            $('#img_Encuentro2Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro2").show();
            $("#img_Encuentro2Asig").hide(); 
        }

        if (str[2] != 0){
            $("#txt_fechaencuentro3").val(str[2]);
            $("#img_Encuentro3").hide();
            $("#img_Encuentro3Asig").show(); 
            $('#img_Encuentro3Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro3").show();
            $("#img_Encuentro3Asig").hide(); 
        }


        if (str[3] != 0){
            $("#txt_fechaencuentro4").val(str[3]);
            $("#img_Encuentro4").hide();
            $("#img_Encuentro4Asig").show(); 
            $('#img_Encuentro4Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro4").show();
            $("#img_Encuentro4Asig").hide(); 
        }

        if (str[4] != 0){
            $("#txt_fechaencuentro5").val(str[4]);
            $("#img_Encuentro5").hide();
            $("#img_Encuentro5Asig").show(); 
            $('#img_Encuentro5Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro5").show();
            $("#img_Encuentro5Asig").hide(); 
        } 

        if (str[5] != 0){
            $("#txt_fechaencuentro6").val(str[5]);
            $("#img_Encuentro6").hide();
            $("#img_Encuentro6Asig").show(); 
            $('#img_Encuentro6Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro6").show();
            $("#img_Encuentro6Asig").hide(); 
        } 

        if (str[6] != 0){
            $("#txt_fechaencuentro7").val(str[6]);
            $("#img_Encuentro7").hide();
            $("#img_Encuentro7Asig").show(); 
            $('#img_Encuentro7Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro7").show();
            $("#img_Encuentro7Asig").hide(); 
        } 

        if (str[7] != 0){
            $("#txt_fechaencuentro8").val(str[7]);
            $("#img_Encuentro8").hide();
            $("#img_Encuentro8Asig").show(); 
            $('#img_Encuentro8Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro8").show();
            $("#img_Encuentro8Asig").hide(); 
        }

        if (str[8] != 0){
            $("#txt_fechaencuentro9").val(str[8]);
            $("#img_Encuentro9").hide();
            $("#img_Encuentro9Asig").show(); 
            $('#img_Encuentro9Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro9").show();
            $("#img_Encuentro9Asig").hide(); 
        }

        if (str[9] != 0){
            $("#txt_fechaencuentro10").val(str[9]);
            $("#img_Encuentro10").hide();
            $("#img_Encuentro10Asig").show(); 
            $('#img_Encuentro10Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro10").show();
            $("#img_Encuentro10Asig").hide(); 
        }

        if (str[10] != 0){
            $("#txt_fechaencuentro11").val(str[10]);
            $("#img_Encuentro11").hide();
            $("#img_Encuentro11Asig").show(); 
            $('#img_Encuentro11Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro11").show();
            $("#img_Encuentro11Asig").hide(); 
        }

        if (str[11] != 0){
            $("#txt_fechaencuentro12").val(str[11]);
            $("#img_Encuentro12").hide();
            $("#img_Encuentro12Asig").show(); 
            $('#img_Encuentro12Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro12").show();
            $("#img_Encuentro12Asig").hide(); 
        }

        if (str[12] != 0){
            $("#txt_fechaencuentro13").val(str[12]);
            $("#img_Encuentro13").hide();
            $("#img_Encuentro13Asig").show(); 
            $('#img_Encuentro13Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro13").show();
            $("#img_Encuentro13Asig").hide(); 
        }

        if (str[13] != 0){
            $("#txt_fechaencuentro14").val(str[13]);
            $("#img_Encuentro14").hide();
            $("#img_Encuentro14Asig").show(); 
            $('#img_Encuentro14Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro14").show();
            $("#img_Encuentro14Asig").hide(); 
        }

        if (str[14] != 0){
            $("#txt_fechaencuentro15").val(str[14]);
            $("#img_Encuentro15").hide();
            $("#img_Encuentro15Asig").show(); 
            $('#img_Encuentro15Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro15").show();
            $("#img_Encuentro15Asig").hide(); 
        }

        if (str[15] != 0){
            $("#txt_fechaencuentro16").val(str[15]);
            $("#img_Encuentro16").hide();
            $("#img_Encuentro16Asig").show(); 
            $('#img_Encuentro16Asig').prop('title', 'Asistencia Asignada al Encuentro ');
        }
        else{
            $("#img_Encuentro16").show();
            $("#img_Encuentro16Asig").hide(); 
        }   
           
    }
    
          
    function DatosDocente(){
        //DATOS DOCENTE
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval002Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Opcion:4}

        }).success(function(data){
            $('#table_ofertadocente tbody').empty(); 
            $('#table_ofertadocente tbody').append(data);
            $('.ImagenIndicador').hide();
            
              
        });
    }
    
    //VISUALIZAR PLAN DE EVALUACION
    $("#table_ofertadocente").on('click', '.GenerarAsistencia', function () {
        var oferta;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var seccion;
        var str;
        var i;
        var valor;
        
        
         $('.ImagenIndicador').hide();
         
         $(this).closest('tr').each(function(index, element){
           
                         
                               
                oferta =   $(element).find("td").eq(1).html() + " - " +  $(element).find("td").eq(14).html() + " - SECCI�N " + $(element).find("td").eq(2).html();
                
                seccion = $(element).find("td").eq(2).html();
                lapsovigencia = $(element).find("td").eq(4).html();
                codcarr = $(element).find("td").eq(5).html();
                codasign = $(element).find("td").eq(6).html();
                codsede = $(element).find("td").eq(7).html();
                lapsoacademico = $(element).find("td").eq(8).html();
                $(this).find("td").children('img').show();
                               
                $("#lbl_ofertadocente").text(oferta);
                
                $("#lbl_seccion").text(seccion)
                $("#lbl_lapsovigencia").text(lapsovigencia);
                $("#lbl_codcarr").text(codcarr);
                $("#lbl_codasign").text(codasign);
                $("#lbl_codsede").text(codsede);
                $("#lbl_lapsoacademico").text(lapsoacademico);
                $("#lbl_lapsoacademico").text(lapsoacademico);
                $("#lbl_carrera").text($(element).find("td").eq(1).html());
                $("#lbl_asignatura").text($(element).find("td").eq(0).html());
                $("#lbl_sede").text($(element).find("td").eq(10).html());
                $("#lbl_docente").text($(element).find("td").eq(11).html());
                $("#lbl_semestre").text($(element).find("td").eq(12).html());
       
                $("#div_Nroencuentros").css("display", "block");
               
                $("#cmb_encuentro").val('0');

                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval002Dao.php?'+ Sesion,
                    data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:10}

                }).success(function(data){
                    
                    valor = $('input:radio[name=radio_lapso]:checked').val();
                    
                    if (valor == "LAPSOACTUAL"){
                        $("#lbl_textoencuentro").css("display", "block");
                        if (data != ""){
                            $("#cmb_encuentro").val(data);  
                            $("#cmb_encuentro").trigger('change');
                        }
                        else{
                            $("#cmb_encuentro").val('0');  
                        }
                    }
                    else{
                        $("#lbl_textoencuentro").css("display", "none");
                        $("#cmb_encuentro").val('0');
                        $("#cmb_encuentro").trigger('change');
                        $("#cmb_encuentro").css("display", "none");
                        
                    }
                   
                });             
             
               
                $("#div_EncuentroDocente").css("display", "none");
                
                $("#a_116").css("display", "none");
                $("#a_1732").css("display", "none");
                $("#a_3348").css("display", "none");
                
        });                          
           
            
            
    });
    
    
    ///// SETEO DE LAS FECHA DE ASISTENCIA DEL DOCENTE
    $("#table_detalleasistencia").on('click', '#img_Encuentro1', function () {
       $("#img_Encuentro1").hide();
       $("#img_Encuentro1Asig").show();
       $("#txt_fechaencuentro1").hide();
       $('#txt_fechaencuentro1').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro1Asig', function () {
       $("#img_Encuentro1").show();
       $("#img_Encuentro1Asig").hide();
       $('#txt_fechaencuentro1').val('');
       
       $('input[name^="encuentro1"]').each(function() {
             $(this).prop("disabled",false);
       });
         
    });

    ///ENCUENTRO 2
    $("#table_detalleasistencia").on('click', '#img_Encuentro2', function () {
       $("#img_Encuentro2").hide();
       $("#img_Encuentro2Asig").show();
       $("#txt_fechaencuentro2").hide();
       $('#txt_fechaencuentro2').val($('#fechaactual').val());
         
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro2Asig', function () {
       $("#img_Encuentro2").show();
       $("#img_Encuentro2Asig").hide();
       $('#txt_fechaencuentro2').val('');
       
       $('input[name^="encuentro2"]').each(function() {
             $(this).prop("disabled",false);
       });
    });

    ///ENCUENTRO 3
    $("#table_detalleasistencia").on('click', '#img_Encuentro3', function () {
       $("#img_Encuentro3").hide();
       $("#img_Encuentro3Asig").show();
       $("#txt_fechaencuentro3").hide();
       $('#txt_fechaencuentro3').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro3Asig', function () {
       $("#img_Encuentro3").show();
       $("#img_Encuentro3Asig").hide();
       $('#txt_fechaencuentro3').val('');
       
       $('input[name^="encuentro3"]').each(function() {
             $(this).prop("disabled",false);
       });       
    });
    
    ///ENCUENTRO 4
    $("#table_detalleasistencia").on('click', '#img_Encuentro4', function () {
       $("#img_Encuentro4").hide();
       $("#img_Encuentro4Asig").show();
       $("#txt_fechaencuentro4").hide();
       $('#txt_fechaencuentro4').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro4Asig', function () {
       $("#img_Encuentro4").show();
       $("#img_Encuentro4Asig").hide();
       $('#txt_fechaencuentro4').val('');
       
       $('input[name^="encuentro4"]').each(function() {
             $(this).prop("disabled",false);
       });       
    });

    ///ENCUENTRO 5
   $("#table_detalleasistencia").on('click', '#img_Encuentro5', function () {
       $("#img_Encuentro5").hide();
       $("#img_Encuentro5Asig").show();
       $("#txt_fechaencuentro5").hide();
       $('#txt_fechaencuentro5').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro5Asig', function () {
       $("#img_Encuentro5").show();
       $("#img_Encuentro5Asig").hide();
       $('#txt_fechaencuentro5').val('');

       $('input[name^="encuentro5"]').each(function() {
             $(this).prop("disabled",false);
       });
    });


    ///ENCUENTRO 6
    $("#table_detalleasistencia").on('click', '#img_Encuentro6', function () {
       $("#img_Encuentro6").hide();
       $("#img_Encuentro6Asig").show();
       $("#txt_fechaencuentro6").hide();
       $('#txt_fechaencuentro6').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro6Asig', function () {
       $("#img_Encuentro6").show();
       $("#img_Encuentro6Asig").hide();
       $('#txt_fechaencuentro6').val('');
       
       $('input[name^="encuentro6"]').each(function() {
             $(this).prop("disabled",false);
       });       
    });
    
    ///ENCUENTRO 7
    $("#table_detalleasistencia").on('click', '#img_Encuentro7', function () {
       $("#img_Encuentro7").hide();
       $("#img_Encuentro7Asig").show();
       $("#txt_fechaencuentro7").hide();
       $('#txt_fechaencuentro7').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro7Asig', function () {
       $("#img_Encuentro7").show();
       $("#img_Encuentro7Asig").hide();
       $('#txt_fechaencuentro7').val('');
       
       $('input[name^="encuentro7"]').each(function() {
             $(this).prop("disabled",false);
       });       
    });
    
    ///ENCUENTRO 8
    $("#table_detalleasistencia").on('click', '#img_Encuentro8', function () {
       $("#img_Encuentro8").hide();
       $("#img_Encuentro8Asig").show();
       $("#txt_fechaencuentro8").hide();
       $('#txt_fechaencuentro8').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro8Asig', function () {
       $("#img_Encuentro8").show();
       $("#img_Encuentro8Asig").hide();
       $('#txt_fechaencuentro8').val('');

       $('input[name^="encuentro8"]').each(function() {
             $(this).prop("disabled",false);
       });        
    });
    
    
    ///ENCUENTRO 9
     $("#table_detalleasistencia").on('click', '#img_Encuentro9', function () {
       $("#img_Encuentro9").hide();
       $("#img_Encuentro9Asig").show();
       $("#txt_fechaencuentro9").hide();
       $('#txt_fechaencuentro9').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro9Asig', function () {
       $("#img_Encuentro9").show();
       $("#img_Encuentro9Asig").hide();
       $('#txt_fechaencuentro9').val('');

       $('input[name^="encuentro9"]').each(function() {
             $(this).prop("disabled",false);
       });         
       
    });
    
    
    ///ENCUENTRO 10
      $("#table_detalleasistencia").on('click', '#img_Encuentro10', function () {
       $("#img_Encuentro10").hide();
       $("#img_Encuentro10Asig").show();
       $("#txt_fechaencuentro10").hide();
       $('#txt_fechaencuentro10').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro10Asig', function () {
       $("#img_Encuentro10").show();
       $("#img_Encuentro10Asig").hide();
       $('#txt_fechaencuentro10').val('');
       
       $('input[name^="encuentro10"]').each(function() {
             $(this).prop("disabled",false);
       });       
    });   
    
    
    ///ENCUENTRO 11
     $("#table_detalleasistencia").on('click', '#img_Encuentro11', function () {
       $("#img_Encuentro11").hide();
       $("#img_Encuentro11Asig").show();
       $("#txt_fechaencuentro11").hide();
       $('#txt_fechaencuentro11').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro11Asig', function () {
       $("#img_Encuentro11").show();
       $("#img_Encuentro11Asig").hide();
       $('#txt_fechaencuentro11').val('');

       $('input[name^="encuentro11"]').each(function() {
             $(this).prop("disabled",false);
       });        
    });   
    
    
    ///ENCUENTRO 12
    $("#table_detalleasistencia").on('click', '#img_Encuentro12', function () {
       $("#img_Encuentro12").hide();
       $("#img_Encuentro12Asig").show();
       $("#txt_fechaencuentro12").hide();
       $('#txt_fechaencuentro12').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro12Asig', function () {
       $("#img_Encuentro12").show();
       $("#img_Encuentro12Asig").hide();
       $('#txt_fechaencuentro12').val('');

       $('input[name^="encuentro12"]').each(function() {
             $(this).prop("disabled",false);
       });            
    });   
    
    
    
    ///ENCUENTRO 13
    $("#table_detalleasistencia").on('click', '#img_Encuentro13', function () {
       $("#img_Encuentro13").hide();
       $("#img_Encuentro13Asig").show();
       $("#txt_fechaencuentro13").hide();
       $('#txt_fechaencuentro13').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro13Asig', function () {
       $("#img_Encuentro13").show();
       $("#img_Encuentro13Asig").hide();
       $('#txt_fechaencuentro13').val('');
       
       $('input[name^="encuentro13"]').each(function() {
             $(this).prop("disabled",false);
       });           
    });  
    
    
    
    ///ENCUENTRO 14
    $("#table_detalleasistencia").on('click', '#img_Encuentro14', function () {
       $("#img_Encuentro14").hide();
       $("#img_Encuentro14Asig").show();
       $("#txt_fechaencuentro14").hide();
       $('#txt_fechaencuentro14').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro14Asig', function () {
       $("#img_Encuentro14").show();
       $("#img_Encuentro14Asig").hide();
       $('#txt_fechaencuentro14').val('');
       
       $('input[name^="encuentro14"]').each(function() {
             $(this).prop("disabled",false);
       });           
    }); 
    
    
    ///ENCUENTRO 15
    $("#table_detalleasistencia").on('click', '#img_Encuentro15', function () {
       $("#img_Encuentro15").hide();
       $("#img_Encuentro15Asig").show();
       $("#txt_fechaencuentro15").hide();
       $('#txt_fechaencuentro15').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro15Asig', function () {
       $("#img_Encuentro15").show();
       $("#img_Encuentro15Asig").hide();
       $('#txt_fechaencuentro15').val('');
       
       $('input[name^="encuentro15"]').each(function() {
             $(this).prop("disabled",false);
       });           
    }); 
    
    
    ///ENCUENTRO 16
     $("#table_detalleasistencia").on('click', '#img_Encuentro16', function () {
       $("#img_Encuentro16").hide();
       $("#img_Encuentro16Asig").show();
       $("#txt_fechaencuentro16").hide();
       $('#txt_fechaencuentro16').val($('#fechaactual').val());
    });
    
      
        
    $("#table_detalleasistencia").on('click', '#img_Encuentro16Asig', function () {
       $("#img_Encuentro16").show();
       $("#img_Encuentro16Asig").hide();
       $('#txt_fechaencuentro16').val('');
       
       $('input[name^="encuentro16"]').each(function() {
             $(this).prop("disabled",false);
       });           
    }); 
    
    ///////////////////////////////////////////////////////////////////////////////
    
    $("#table_detalleasistencia").on('click', '.Asistencia01', function () {
       $("#img_Encuentro1").hide();
       $("#img_Encuentro1Asig").show();
       $("#txt_fechaencuentro1").hide();
       $('#txt_fechaencuentro1').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia02', function () {
    
        $("#img_Encuentro2").hide();
       $("#img_Encuentro2Asig").show();
       $("#txt_fechaencuentro2").hide();
       $('#txt_fechaencuentro2').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia03', function () {
    
       $("#img_Encuentro3").hide();
       $("#img_Encuentro3Asig").show();
       $("#txt_fechaencuentro3").hide();
       $('#txt_fechaencuentro3').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia04', function () {
    
       $("#img_Encuentro4").hide();
       $("#img_Encuentro4Asig").show();
       $("#txt_fechaencuentro4").hide();
       $('#txt_fechaencuentro4').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia05', function () {
    
       $("#img_Encuentro5").hide();
       $("#img_Encuentro5Asig").show();
       $("#txt_fechaencuentro5").hide();
       $('#txt_fechaencuentro5').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia06', function () {
    
       $("#img_Encuentro6").hide();
       $("#img_Encuentro6Asig").show();
       $("#txt_fechaencuentro6").hide();
       $('#txt_fechaencuentro6').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia07', function () {
    
       $("#img_Encuentro7").hide();
       $("#img_Encuentro7Asig").show();
       $("#txt_fechaencuentro7").hide();
       $('#txt_fechaencuentro7').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia08', function () {
    
       $("#img_Encuentro8").hide();
       $("#img_Encuentro8Asig").show();
       $("#txt_fechaencuentro8").hide();
       $('#txt_fechaencuentro8').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia09', function () {
    
       $("#img_Encuentro9").hide();
       $("#img_Encuentro9Asig").show();
       $("#txt_fechaencuentro9").hide();
       $('#txt_fechaencuentro9').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia10', function () {
    
       $("#img_Encuentro10").hide();
       $("#img_Encuentro10Asig").show();
       $("#txt_fechaencuentro10").hide();
       $('#txt_fechaencuentro10').val($('#fechaactual').val());
    });
     $("#table_detalleasistencia").on('click', '.Asistencia11', function () {
    
       $("#img_Encuentro11").hide();
       $("#img_Encuentro11Asig").show();
       $("#txt_fechaencuentro11").hide();
       $('#txt_fechaencuentro11').val($('#fechaactual').val());
    });
     $("#table_detalleasistencia").on('click', '.Asistencia12', function () {
    
       $("#img_Encuentro12").hide();
       $("#img_Encuentro12Asig").show();
       $("#txt_fechaencuentro12").hide();
       $('#txt_fechaencuentro12').val($('#fechaactual').val());
    });
     $("#table_detalleasistencia").on('click', '.Asistencia13', function () {
    
       $("#img_Encuentro13").hide();
       $("#img_Encuentro13Asig").show();
       $("#txt_fechaencuentro13").hide();
       $('#txt_fechaencuentro13').val($('#fechaactual').val());
    });
     $("#table_detalleasistencia").on('click', '.Asistencia14', function () {
    
       $("#img_Encuentro14").hide();
       $("#img_Encuentro14Asig").show();
       $("#txt_fechaencuentro14").hide();
       $('#txt_fechaencuentro14').val($('#fechaactual').val());
    });
     $("#table_detalleasistencia").on('click', '.Asistencia15', function () {
    
       $("#img_Encuentro15").hide();
       $("#img_Encuentro15Asig").show();
       $("#txt_fechaencuentro15").hide();
       $('#txt_fechaencuentro15').val($('#fechaactual').val());
    });
    $("#table_detalleasistencia").on('click', '.Asistencia16', function () {
    
       $("#img_Encuentro16").hide();
       $("#img_Encuentro16Asig").show();
       $("#txt_fechaencuentro16").hide();
       $('#txt_fechaencuentro16').val($('#fechaactual').val());
    });
});
    