/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: eval001C.php                                                                          -->  
<!-- DESCRIPCION: Controlador de Eventos de la pagina de eval001.php. Creaci�n del plan de evaluacion-->
<!-- ******************************************************************************************* -->*/


   //ACTUALIZA LA PAGINA PARA MOSTRAR LOS DATOS DE LOS ESTUDIANTES SI ES UNO O DOS PARA 
    //LA PROPUESTA DE TRABAJO DE GRADO
    
$(document).ready(function () {
    
    var Sesion = $('#p_Sesion').text();
    var Cedula = $('#p_Cedula').text();
    var ponderacion;
    var ponderacionold;
    var escalaactual = 0;
    var notas = false;
    var productoevaluar;
    var productosave;
    var semanaevaluar;
    var ponderacionevaluar;
    var idproductos;
    var descarr;
    var desasign;
    var id_evault;
    var id_evaprim;
    var id_oferta;
   
    
   // DatosDocente();
 
    //APROBAR LA ULTIMA EVALUACION
     $("#bot_reiniciarevaluacion").click(function(){
        var seccion;
        var lapsovigencia;
        var cod_carr;
        var cod_asign;
        var cod_sede;
        var lapsoacademico;
        var ceduladocente;
        
        seccion = $("#lbl_seccion").text();
        lapsovigencia = $("#lbl_lapsovigencia").text();
        cod_carr = $("#lbl_codcarr").text();
        cod_asign = $("#lbl_codasign").text();
        cod_sede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademicosis").text();
        ceduladocente = $("#lbl_ceduladocente").text();
       
        
                
        alertify.confirm("SE BORRAR�N TODAS LAS NOTAS REGISTRADAS. DESEA CONTINUAR?", function (e) {
            if (e){
                
                $("#preloader").css("display", "block");
                
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval013Dao.php?'+ Sesion,
                    data:{Cedula:ceduladocente,Carrera:cod_carr,Asignatura:cod_asign,Seccion:seccion,Sede:cod_sede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,Opcion:15}

                }).success(function(data){
         
                   if (data == 1){ 
                        alertify.success("Reiniciado el Registro de Notas Satisfactoriamente");    
                        
                        $('.GenerarProductos').click();
                   }      
                   else{
                       alertify.error("Error en Reiniciar el Registro de Notas");    
                   }
                   $("#div_actanotas").css("display", "none");
                   $("#div_Estadistica").css("display", "none");
                   $("#preloader").css("display", "none");
                });  
            }
            else {
                //
            }
	});
     });
 
 
    //APROBAR LA ULTIMA EVALUACION
     $("#bot_ok").click(function(){
         
        alertify.confirm("Desea Aprobar la �ltima evaluaci�n?", function (e) {
            if (e){
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval013Dao.php?'+ Sesion,
                    data:{IdEvaUlt:id_evault,Opcion:14}

                }).success(function(data){
         
                   if (data == 1){ 
                        alertify.success("Evaluaci�n Aprobada Satisfactoriamente");    
                        
                        $('.GenerarProductos').click();
                   }      
                   else{
                       alertify.error("Error en Aprobar la Evaluaci�n");    
                   }
                });  
            }
            else {
                //
            }
	});
     });
 
 
     //VER LAS ACTAS DE NOTAS 
    $("input[name=TipoActa]").change(function () {	
       
       VerNotas();
               
    });
    
    
    //VER ACTA DE NOTAS
    $("#bot_actanotas").click(function(){
        
        VerNotas();
       
               
    });
    
    
    function VerNotas(){
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var acta; 
        var semestre;
        var nroestudianteinscrito;
        var nroestudiantecursante;               
        var totalevaluado;
        var nroaprob;
        var porcenaprob;
        var nroreprob;
        var porcenreprob;
        var media;
        var notamax;
        var notamin; 
        var desvtip; 
        var varianza;         
        var ceduladocente;
        
        $("#div_tablaActa").empty();
        $("#div_Acta").css("display", "block"); 
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademicosis").text();
        semestre = $("#lbl_semestre").text();

        
        nroestudianteinscrito = $("#lbl_nroest").text();
        nroestudiantecursante = $("#lbl_nroestcur").text();               
        totalevaluado = $("#lbl_porcenevaluado").text();
        nroaprob = $("#lbl_nroaprob").text();
        porcenaprob = $("#lbl_porcenaprob").text();
        nroreprob = $("#lbl_nroreprob").text();
        porcenreprob = $("#lbl_porcenreprob").text();
        media = $("#lbl_media").text();
        notamax = $("#lbl_notamax").text();
        notamin = $("#lbl_notamin").text(); 
        desvtip = $("#lbl_desvtip").text(); 
        varianza = $("#lbl_varianza").text();         
        
        
        ceduladocente = $("#lbl_ceduladocente").text();
        
        if($("#radio_general").prop('checked')){
            acta = 1;
        }
        else{
            acta = 2;
        }
            
        $("#preloader").css("display", "block");
        
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval013Dao.php?'+ Sesion,
            data:{Cedula:ceduladocente,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdActa:acta,IdProductosDef:idproductos,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesNroEstIns:nroestudianteinscrito,DesNroEstCur:nroestudiantecursante,DesTotalEvaluado:totalevaluado,DesNroAprob:nroaprob,DesPorcenAprob:porcenaprob,DesNroReprob:nroreprob,DesPorcenReprob:porcenreprob,DesMedia:media,DesNotaMax:notamax,DesNotaMin:notamin,DesDesvtip:desvtip,DesVarianza:varianza,Opcion:11}

        }).success(function(data){
            

            $("#div_tablaActa").html(data);
            $("#preloader").css("display", "none");
      
        });  
        
    }
    //VISUALIZAR PLAN DE EVALUACION
    $("#table_ponderacion").on('click', '.ActualizarNotaAprob', function () {
                 
       //obtener datos ponderacion estudiante
    
                              
        ponderacionold = $(this).closest('tr').find('input[id="nota"]').val();
        
        $(this).closest('tr').find('input[id="nota"]').prop('disabled', false);                
        $(this).closest('tr').find('input[id="asistencia"]').prop('disabled', false);                
        
        $(this).closest('tr').find('input[id="actualizarnotaaprob"]').prop('disabled', true);
        $(this).closest('tr').find('input[id="guardarnotaaprob"]').prop('disabled', false);
        
        
        
    });
    
    

    //GUARDAR UNA NOTA APROBADA
    $("#table_ponderacion").on('click', '.GuardarNotaAprob', function () {
        var nombre;
        var nuevaponderacion;
        var nuevaasistencia;
        var cedula;
        var ideval;
        var seccion;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var fechaevaluacion;
        var justificacion;
        var wordCount;
        var semestre;
        var ceduladocente;
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademicosis").text();
        fechaevaluacion = $("#fechaactual").val();    
        semestre = $("#lbl_semestre").text();
        ceduladocente = $("#lbl_ceduladocente").text();
        
        
        $("#preloader").css("display", "block");
         
       //obtener datos ponderacion estudiante
       
        $(this).closest('tr').each(function(index, element){
                              
            nombre =   $(element).find("td").eq(1).html(); 
            nuevaponderacion = $(element).find('input[id="notabd"]').val();
            if ($(element).find('input[id="asistencia"]').is(':checked')){
                nuevaasistencia = 1;     
            }
            else{
                 nuevaasistencia = 0;   
            }
            
            cedula = $(element).find('input[id="cedula"]').val();
            ideval = $(element).find('input[id="ideval"]').val();
            
        });  

              
        if (parseFloat(nuevaponderacion) > parseFloat(ponderacionold)){

            justificacion = prompt("INDICAR LAS RAZONES PARA ACTUALIZAR LA NOTA DEL ESTUDIANTE " + nombre);

            wordCount = justificacion.trim().replace(/\s+/gi, ' ').split(' ').length;
            
            if (wordCount >= 1){
                          
                
                $.ajax({

                     datatype: 'json',
                     type: 'POST',
                     url: 'eval013Dao.php?'+ Sesion,
                     data:{Ponderacion:ponderacion,Cedula:ceduladocente,CedulaAct:Cedula,IdEval:ideval,CedulaEst:cedula,Ponderacion:nuevaponderacion,Asistencia:nuevaasistencia,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,FechaEvaluacion:fechaevaluacion,NotaAprobada:1,PonderacionOld:ponderacionold,Justificacion:justificacion,IdProductosDef:idproductos,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:productosave,Opcion:10}

                  }).success(function(data){

                                    
                    if (data == 1){
                        alertify.success("EVALUACI�N ACTUALIZADA SATISFACTORIAMENTE");
                        ponderacionold = nuevaponderacion;
                    }
                    else{
                        alertify.alert("FALTAN DATOS POR INGRESAR EN LA EVALUACI�N");
                    }
                    $("#preloader").css("display", "none");
                }); 
                
               
            }    
            else{
                $("#preloader").css("display", "none");
           
                alertify.alert("DEBE INDICAR MAS DETALLES DE LAS RAZONES PARA ACTUALIZAR LA NOTA DEL ESTUDIANTE " + nombre);
            }    
        }
        else{
            if (parseFloat(nuevaponderacion) < parseFloat(ponderacionold)){
                alertify.alert("SOLO SE PUEDE ACTUALIZAR POR ENCIMA DE LA NOTA ACTUAL (" + ponderacionold + ")");
            }
            else{
                alertify.alert("NO SE REALIZ� LA ACTUALIZACI�N. LA NOTA ACTUAL ES IGUAL A LA NOTA ANTERIOR");
            }
            $("#preloader").css("display", "none");
        }
        
        
    });
    
    //DESHABILITA EL COMBO DE CONSULTA EN CASO QUE SELECCIONE LAPSO ACTUAL
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
    
  
    //AL HACER CLIC EN CONSULTAR EN LAPSO O EN EL HISTORICO
    $("#bot_buscardocente").click(function(){
             
                   
       $("#div_referencia").css("display", "none");
       $('#table_producto tbody').empty();
       $("#div_Productos").css("display", "none"); 
       $("#div_Acciones").css("display", "none");
       $("#div_ActaEvaluacion").css("display", "block")
       $("#div_Acta").css("display", "none");
       $("#div_Nota").css("display", "none");
       $("#div_Estadistica").css("display", "none"); 
       $("#div_actanotas").css("display", "none"); 
       $("#div_ActaEvaluacion").css("display", "none");  
       $("#div_Reiniciar").css("display", "none");  
       
       $("#div_DatosDocente").css("display", "block"); 
       //if (valor == "LAPSO"){
          
           if ($("#txt_docente").val() != ""){
                  $("#lbl_ceduladocente").text($("#txt_docente").val()); 
                 
                  $.ajax({

                      datatype: 'json',
                      type: 'POST',
                      url: 'eval013Dao.php?'+ Sesion,
                      data:{Cedula:$("#lbl_ceduladocente").text(),Opcion:8}

                  }).success(function(data){
                      $('#table_ofertadocente tbody').empty(); 
                      $('#table_ofertadocente tbody').append(data);
                      $('.ImagenIndicador').hide();
                      
                  });               
           }
           else{
            alertify.alert("INTRODUZCA EL NRO DE C�DULA DEL DOCENTE A CONSULTAR");
           }
           
      
      
       
   }); 
      
     
    
    $("#table_ponderacion").on('click', '.ActualizarAsistencia', function () {
    
        if($(this).is(':checked')){
            $(this).closest('tr').find('input[id="notabd"]').val('');
            $(this).closest('tr').find('input[id="nota"]').val('');
            $(this).closest('tr').find('input[id="nota"]').prop('disabled', false);        
        }
        else{
            $(this).closest('tr').find('input[id="notabd"]').val('');
            $(this).closest('tr').find('input[id="nota"]').val('');
            $(this).closest('tr').find('input[id="nota"]').prop('disabled', true);
        }
        
       
    });
    
     
    
    //GUARDAR TODAS LAS PONDERACIONES DE LA EVALUACION
    $("#a_GuardarTodaPonderacion").click(function(){
        
        var arrayPonderacion = [];
        var arrayCedula = [];
        var arrayIdEvaluacion = [];
        var arrayAsistencia = [];
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var seccion;
        var fechaevaluacion;
        var semevaluacion;
        var apto = true;
        var status;
        var semestre;
        var ideval;
        var ceduladocente;
        
                $("#preloader").css("display", "block");
         
       
                
                fechaevaluacion = $("#fechaactual").val();
                semevaluacion = $("#cmb_semevaluacion").val();
                
                
                             
                if (semevaluacion != "0") {
                    
                   
                    
                    //if (validarfechaevaluacion(fechaevaluacion)){
                        $('input[name^="notabd"]').each(function() {
                            arrayPonderacion.push($(this).val());
                            if (parseFloat(ponderacion) < parseFloat($(this).val())){
                                apto = false;                         
                            }
                        });

                        $('input[name^="cedula"]').each(function() {  
                            arrayCedula.push($(this).val());
                        });

                        $('input[name^="ideval"]').each(function() {  
                            arrayIdEvaluacion.push($(this).val());
                            ideval = $(this).val();
                        });

                        $('input[name^="asistencia"]').each(function() {  
                            if($(this).is(':checked')){
                               arrayAsistencia.push(1);
                            }
                            else{
                               arrayAsistencia.push(0); 
                            }

                        });



                       seccion= $("#lbl_seccion").text()
                       lapsovigencia = $("#lbl_lapsovigencia").text();
                       codcarr = $("#lbl_codcarr").text();
                       codasign = $("#lbl_codasign").text();
                       codsede = $("#lbl_codsede").text();
                       lapsoacademico = $("#lbl_lapsoacademicosis").text();
                       semestre = $("#lbl_semestre").text();
                       ceduladocente = $("#lbl_ceduladocente").text();
                       
                       status = $("#lbl_status").text();

                       if (apto){
                           
                           
                           
                            $.ajax({

                                 datatype: 'json',
                                 type: 'POST',
                                 url: 'eval013Dao.php?'+ Sesion,
                                 data:{ValorNota:ponderacion,Cedula:ceduladocente,CedulaAct:Cedula,IdEval:arrayIdEvaluacion,CedulaEst:arrayCedula,Ponderacion:arrayPonderacion,Asistencia:arrayAsistencia,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,FechaEvaluacion:fechaevaluacion,SemEvaluacion:semevaluacion,IdProductosDef:idproductos,IdStatus:status,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:productosave,Opcion:4}

                              }).success(function(data){
                            
                                if (data == 1){
                                    alertify.success("EVALUACI�N ACTUALIZADA SATISFACTORIAMENTE");
                                    if(id_evault == ideval){
                                        $("#div_aprobar").css("display", "block");
                                    }               
                                    else{
                                        $("#div_aprobar").css("display", "none");
                                    }
                                }
                                else{
                                    alertify.alert("FALTAN DATOS POR INGRESAR EN LA EVALUACI�N");
                                }
                                $("#preloader").css("display", "none");
                               
                                $("#div_ActaEvaluacion").css("display", "block");
                            });        
                        }
                        else{
                            $("#preloader").css("display", "none");
                            alertify.alert("NO SE ACTUALIZ�. HAY PONDERACIONES MAYORES A " + ponderacion + "%");
                            
                        }
                                    
                }
                else{
                    $("#preloader").css("display", "none");            
                    alertify.alert("SELECCIONE LA SEMANA DE EVALUACI�N PARA GUARDAR.");
                   
                    
                }
        
    });
       
    //VISUALIZAR LOS PRODUCTOS AL HACER CLIC EN UNA OFERTA O ASIGNATURA
    $("#table_ofertadocente").on('click', '.GenerarProductos', function () {
        var oferta;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var lapsoacademicosis;
        var semestre;
        var seccion;
        var semana = false;
        var totalponderacion = 0; 
        var cantidad;
        var acta = true;
        var totalevaluado = 0;
        var nroestudiantecursante = 0;
        var nroestudianteinscrito = 0;
        var str;
        var ceduladocente;
        
        $('.ImagenIndicador').hide();
         
        $("#preloader").css("display", "block");
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                          
            oferta =   $(element).find("td").eq(1).html() + " - " +  $(element).find("td").eq(13).html() + " - SECCI�N " + $(element).find("td").eq(2).html();

            seccion = $(element).find("td").eq(2).html();
            lapsovigencia = $(element).find("td").eq(4).html();
            codcarr = $(element).find("td").eq(5).html();
            codasign = $(element).find("td").eq(6).html();
            codsede = $(element).find("td").eq(7).html();
            lapsoacademico = $(element).find("td").eq(8).html();
            lapsoacademicosis = $(element).find("td").eq(11).html();
            desasign = $(element).find("td").eq(0).html();
            descarr = $(element).find("td").eq(1).html();
            semestre = $(element).find("td").eq(12).html();
            id_oferta = $(element).find("td").eq(14).html();
           
           
            
            
             $(this).find("td").children('img').show();
        });    
        
        $("#lbl_ofertadocente").text(oferta);

        $("#lbl_seccion").text(seccion);
        $("#lbl_lapsovigencia").text(lapsovigencia);
        $("#lbl_codcarr").text(codcarr);
        $("#lbl_codasign").text(codasign);
        $("#lbl_codsede").text(codsede);
        $("#lbl_lapsoacademico").text(lapsoacademico);
        $("#lbl_lapsoacademicosis").text(lapsoacademicosis);
        $("#lbl_semestre").text(semestre);
        $("#div_aprobar").css("display", "none");
        $("#div_Reiniciar").css("display", "none");
        ceduladocente = $("#lbl_ceduladocente").text();
        
        //DATOS PRODUCTOS
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval013Dao.php?'+ Sesion,
            data:{Cedula:ceduladocente,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademicosis,LapsoVigencia:lapsovigencia,Opcion:2}

        }).success(function(data){
            $('#table_producto tbody').empty();
            $('#table_producto tbody').append(data);
            
            $('#table_producto tr ').each(function(index, element){
               
               
               if ($(element).find("td").eq(6).html() >= -1){
                    totalponderacion = totalponderacion + parseFloat($(element).find("td").eq(2).html());               
                    nroestudianteinscrito = $(element).find("td").eq(10).html();
                    nroestudiantecursante = $(element).find("td").eq(11).html();
                    id_evault = $(element).find("td").eq(5).html();
                    
                    if (index == 0){
                        id_evaprim = $(element).find("td").eq(5).html();
                        
                    }
               }
               
               
               
               if ($(element).find("td").eq(9).html() == ""){
                    acta = false;               
               }
               else{
                    
                   if ($(element).find("td").eq(9).html() >=0 && $(element).find("td").eq(9).html() <=16){
                        totalevaluado = totalevaluado + parseFloat($(element).find("td").eq(2).html());               
                      
                        if ($(element).find("td").eq(6).html() == 1 || $(element).find("td").eq(6).html() == 2){
                           $("#div_Reiniciar").css("display", "block");
                        }
                   }    
                  
                   
               }
               
               if ($(element).find("td").eq(6).html() == 1 || $(element).find("td").eq(6).html() == 2){
                   acta = false;
               }
               
               
            });  
            
            idproductos= 0;
            if (totalponderacion <= 100){
                cantidad = $('#table_producto tr ').length -2;
                
                //VERIFICA SI EVALUO EL 100% PARA DESBLOQUEAR EL ACTA Y QUE ESTE CERRADA POR CACE
                if (acta){
                    $("#exportarevaluacion").css("display", "block"); 
                } 
                else{
                    $("#exportarevaluacion").css("display", "none"); 
                }
                
                
                
                //ESTADISTICAS
                //NRO ESTUDIANTES INSCRITOS
                
                $("#lbl_nroest").text(nroestudianteinscrito);
                 
                //NRO ESTUDIANTES CURSANTES
                
                $("#lbl_nroestcur").text(nroestudiantecursante);               
                
                //TOTAL EVALUADO
                
                $("#lbl_porcenevaluado").text(totalevaluado.toString() + "%");
                 
                //ESTADISTICAS
                
                if (nroestudiantecursante > 0){
                    $.ajax({

                        datatype: 'json',
                        type: 'POST',
                        url: 'eval013Dao.php?'+ Sesion,
                        data:{Cedula:ceduladocente,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademicosis,LapsoVigencia:lapsovigencia,TotalEvaluado:totalevaluado,TotalEstudiante:nroestudiantecursante,Opcion:13}

                    }).success(function(data){


                        str = data.split("|");

                        $("#lbl_nroaprob").text(str[0]);
                        $("#lbl_porcenaprob").text(str[1]);
                        $("#lbl_nroreprob").text(str[2]);
                        $("#lbl_porcenreprob").text(str[3]);
                        $("#lbl_media").text(str[4]);
                        $("#lbl_notamax").text(str[5]);
                        $("#lbl_notamin").text(str[6]); 
                        $("#lbl_desvtip").text(str[7]); 
                        $("#lbl_varianza").text(str[8]); 

                        $("#div_Estadistica").css("display", "block"); 
                        $("#div_actanotas").css("display", "block"); 
                    }); 
                }
                else{
                    $("#div_Estadistica").css("display", "none");
                }
                
                $('#table_producto tr ').each(function(index, element){

                    if ($(element).find("td").eq(6).html() == 0){
                        if (!semana){
                            $(element).find("td").eq(6).html(-1); 
                            productoevaluar = $(element).find("td").eq(1).html(); 
                            ponderacionevaluar = $(element).find("td").eq(2).html(); 
                            semanaevaluar = $(element).find("td").eq(3).html();
                            semana = true;
                        }    
                    }    
                    
                                     
                    if (idproductos == 0){
                        idproductos = $(element).find("td").eq(5).html();
                    }
                    else{
                        if (index <= cantidad){
                            idproductos = idproductos + "," + $(element).find("td").eq(5).html();
                        }
                    }
                    

                });   
               
            }
            else{
                alertify.alert("REVISAR EL PLAN DE EVALUACI�N DE " + oferta + ", ACTUALMENTE TIENE " + totalponderacion + "%");
                $('#table_producto tbody').empty();
                $("#div_Productos").css("display", "none"); 
            }
           
             $("#preloader").css("display", "none");  
        });
       
        if (totalponderacion <= 100){     
            $("#div_Productos").css("display", "block"); 
        }    
        $("#div_Nota tbody").empty();
        $("#div_Nota").css("display", "none");
        $("#div_Acciones").css("display", "none")
        $("#div_ActaEvaluacion").css("display", "none")
        $("#div_Acta").css("display", "none");
        
        
        
          
    });
    
    //VISUALIZAR LAS NOTAS TRANSCRITAS
    $("#table_producto").on('click', '.TranscritaEvaluacion', function () {
        
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
        var producto;
        var status;
        var ideval;
        var fechaevaluacion;
        var semana;   
        var ceduladocente;
        
        $("#lbl_oferta").text($("#lbl_ofertadocente").text());
        $("#lbl_productoaevaluar").text(producto);
        $("#lbl_ponderacion").text(ponderacion);
        $("#div_Estadistica").css("display", "none");  
        $("#div_actanotas").css("display", "none"); 
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                              
                producto =   $(element).find("td").eq(1).html();
                productosave =   $(element).find("td").eq(1).html();
                ponderacion = $(element).find("td").eq(2).html();
                status = $(element).find("td").eq(6).html();
                ideval = $(element).find("td").eq(5).html();
                fechaevaluacion = $(element).find("td").eq(7).html();
                semana = $(element).find("td").eq(9).html();
        });    
        
            
        
        if(id_evault == ideval){
            $("#div_aprobar").css("display", "block");
        }
        else{
            $("#div_aprobar").css("display", "none");
        }
        
       if (status == 1){
        
            $("#lbl_oferta").text($("#lbl_ofertadocente").text());
            $("#lbl_productoaevaluar").text("PRODUCTO O EVIDENCIA:" + " " + producto);
            $("#lbl_ponderacion").text("PONDERACI�N: " + ponderacion + "%");

             $("#preloader").css("display", "block");

            //$("#date_fechaevaluacion").val(fechaevaluacion);

            //$("#date_fechaevaluacion").prop("disabled", false);
            
             seccion= $("#lbl_seccion").text()
             lapsovigencia = $("#lbl_lapsovigencia").text();
             codcarr = $("#lbl_codcarr").text();
             codasign = $("#lbl_codasign").text();
             codsede = $("#lbl_codsede").text();
             lapsoacademico = $("#lbl_lapsoacademicosis").text();
             carrera = $("#lbl_carrera").text();
             asignatura = $("#lbl_asignatura").text();
             sede = $("#lbl_sede").text();
             docente = $("#lbl_docente").text();
             semestre = $("#lbl_semestre").text();
             ceduladocente = $("#lbl_ceduladocente").text();
             
             $("#cmb_semevaluacion").val(semana);

             $("#cmb_semevaluacion").prop("disabled", false);


             $.ajax({

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval013Dao.php?'+ Sesion,
                 data:{Ponderacion:ponderacion,Cedula:ceduladocente,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdEval:ideval,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:producto,Opcion:5}

             }).success(function(data){
                 
                 $("#div_Nota tbody").empty();

                 $("#div_Nota tbody").append(data);

                 $("#lbl_porcentaje").text('[1% - ' + ponderacion + '%]');
                 
                 notas = true;
                 
                  $("#preloader").css("display", "none");

             });      


              $("#div_Nota").css("display", "block");
              $("#div_Acciones").css("display", "block");
              $("#div_ActaEvaluacion").css("display", "block")
              $("#div_Productos").css("display", "none");
              //$("#div_escala").css("display", "block");
              $("#div_Acta").css("display", "none"); 
              $("#div_Reiniciar").css("display", "none");
        }  
        else{
            
            alertify.alert("DEBE EVALUAR EL PRODUCTO "  + productoevaluar + " PONDERACI�N " + ponderacionevaluar + " SEMANA " + semanaevaluar);
            
        }
        
    });
    
   //VISUALIZAR LAS NOTAS APROBADAS
    $("#table_producto").on('click', '.AprobadaEvaluacion', function () {
        
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
        var producto;
        var status;
        var ideval;
        var fechaevaluacion;
        var semana;
        var ceduladocente;
        
        $("#lbl_oferta").text($("#lbl_ofertadocente").text());
        $("#lbl_productoaevaluar").text(producto);
        $("#lbl_ponderacion").text(ponderacion);
        $("#div_Estadistica").css("display", "none");  
        $("#div_aprobar").css("display", "none");
        $("#div_actanotas").css("display", "none"); 
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                              
                producto =   $(element).find("td").eq(1).html(); 
                productosave =   $(element).find("td").eq(1).html();
                ponderacion = $(element).find("td").eq(2).html();
                status = $(element).find("td").eq(6).html();
                ideval = $(element).find("td").eq(5).html();
                fechaevaluacion = $(element).find("td").eq(7).html();
                semana = $(element).find("td").eq(9).html();
        });    
        
                   
       if (status == 2){
        
            $("#lbl_oferta").text($("#lbl_ofertadocente").text());
            $("#lbl_productoaevaluar").text("PRODUCTO O EVIDENCIA:" + " " + producto);
            $("#lbl_ponderacion").text("PONDERACI�N: " + ponderacion + "%");

            $("#preloader").css("display", "block");
             
            //$("#date_fechaevaluacion").val(fechaevaluacion);
            
            //$("#date_fechaevaluacion").prop("disabled", true);

             seccion= $("#lbl_seccion").text()
             lapsovigencia = $("#lbl_lapsovigencia").text();
             codcarr = $("#lbl_codcarr").text();
             codasign = $("#lbl_codasign").text();
             codsede = $("#lbl_codsede").text();
             lapsoacademico = $("#lbl_lapsoacademicosis").text();
             carrera = $("#lbl_carrera").text();
             asignatura = $("#lbl_asignatura").text();
             sede = $("#lbl_sede").text();
             docente = $("#lbl_docente").text();
             semestre = $("#lbl_semestre").text();
             ceduladocente = $("#lbl_ceduladocente").text();

		
             
             $("#cmb_semevaluacion").val(semana);

             $("#cmb_semevaluacion").prop("disabled", true);

             $.ajax({

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval013Dao.php?'+ Sesion,
                 data:{Ponderacion:ponderacion,Cedula:ceduladocente,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdEval:ideval,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:producto,Opcion:6}

             }).success(function(data){

                 $("#div_Nota tbody").empty();
                 $("#div_Nota tbody").empty();

                 $("#div_Nota tbody").append(data);

                 $("#lbl_porcentaje").text('[1% - ' + ponderacion + '%]');
                 
                 notas = true;
                 
                 $("#preloader").css("display", "none");
                 
             });      


            $("#div_Nota").css("display", "block");
            $("#div_Acciones").css("display", "none");
            $("#div_ActaEvaluacion").css("display", "block")
            $("#div_Productos").css("display", "none");
            //$("#div_escala").css("display", "none");
            $("#div_Acta").css("display", "none"); 
            $("#div_Reiniciar").css("display", "none");
              
        }  
        else{
            
            alertify.alert("DEBE EVALUAR EL PRODUCTO "  + productoevaluar + " PONDERACI�N " + ponderacionevaluar + " SEMANA " + semanaevaluar);
            
        } 
        
    });
    
    
    
     //VISUALIZAR LAS NOTAS CERRADAS 
    $("#table_producto").on('click', '.CerradaEvaluacion', function () {
        
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
        var producto;
        var status;
        var ideval;
        var fechaevaluacion;
        var semana;
        var ceduladocente;     
        
        $("#lbl_oferta").text($("#lbl_ofertadocente").text());
        $("#lbl_productoaevaluar").text(producto);
        $("#lbl_ponderacion").text(ponderacion);
        $("#div_Estadistica").css("display", "none");  
        $("#div_aprobar").css("display", "none");
        $("#div_actanotas").css("display", "none"); 
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                              
                producto =   $(element).find("td").eq(1).html(); 
                
                ponderacion = $(element).find("td").eq(2).html();
                status = $(element).find("td").eq(6).html();
                ideval = $(element).find("td").eq(5).html();
                fechaevaluacion = $(element).find("td").eq(7).html();
                semana = $(element).find("td").eq(9).html(); 
        });    
        
                   
       if ((status == 3) || (status == 4)) {
        
            $("#lbl_oferta").text($("#lbl_ofertadocente").text());
            $("#lbl_productoaevaluar").text("PRODUCTO O EVIDENCIA:" + " " + producto);
            $("#lbl_ponderacion").text("PONDERACI�N: " + ponderacion + "%");

            //$("#date_fechaevaluacion").val(fechaevaluacion);
            
            //$("#date_fechaevaluacion").prop("disabled", true);
            
            $("#preloader").css("display", "block");

             seccion= $("#lbl_seccion").text()
             lapsovigencia = $("#lbl_lapsovigencia").text();
             codcarr = $("#lbl_codcarr").text();
             codasign = $("#lbl_codasign").text();
             codsede = $("#lbl_codsede").text();
             lapsoacademico = $("#lbl_lapsoacademicosis").text();
             carrera = $("#lbl_carrera").text();
             asignatura = $("#lbl_asignatura").text();
             sede = $("#lbl_sede").text();
             docente = $("#lbl_docente").text();
             semestre = $("#lbl_semestre").text();
             ceduladocente = $("#lbl_ceduladocente").text();
             
             $("#cmb_semevaluacion").val(semana);
              
             $("#cmb_semevaluacion").prop("disabled", true);
            

             $.ajax({

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval013Dao.php?'+ Sesion,
                 data:{Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdEval:ideval,Opcion:12}

             }).success(function(data){

                 $("#div_Nota tbody").empty();
                 $("#div_Nota tbody").empty();

                 $("#div_Nota tbody").append(data);

                 $("#lbl_porcentaje").text('[1% - ' + ponderacion + '%]');
                 
                 notas = true;
                 
                 $("#preloader").css("display", "none");
                 
             });      


            $("#div_Nota").css("display", "block");
            $("#div_Acciones").css("display", "none");
            $("#div_ActaEvaluacion").css("display", "block")
            $("#div_Productos").css("display", "none");
            //$("#div_escala").css("display", "none");
            $("#div_Acta").css("display", "none");   
            $("#div_Reiniciar").css("display", "none");  
        }  
        else{
            
            alertify.alert("DEBE EVALUAR EL PRODUCTO "  + productoevaluar + " PONDERACI�N " + ponderacionevaluar + " SEMANA " + semanaevaluar);
            
        } 
        
    });
    
     //AGREGAR NOTAS A LOS ESTUDIANTES DE UN PRODUCTO O EVIDENCIA
    $("#table_producto").on('click', '.AgregarEvaluacion', function () {
        
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
        var producto;
        var status;
        var ideval;
        var aprobar = false;
        //var aprobar2 = false;
        var id_evaluacionaprobar= -1;
        //var fechaevaluacion;
        //var ponderacion2;
        var ceduladocente;
       
        
        
        
        $("#lbl_oferta").text($("#lbl_ofertadocente").text());
        $("#lbl_productoaevaluar").text(producto);
        $("#lbl_ponderacion").text(ponderacion);
        $("#div_Estadistica").css("display", "none");  
        $("#div_aprobar").css("display", "none");
        $("#div_actanotas").css("display", "none"); 
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                              
                producto =   $(element).find("td").eq(1).html(); 
                productosave =   $(element).find("td").eq(1).html();
                ponderacion = $(element).find("td").eq(2).html();
                status = $(element).find("td").eq(6).html();
                ideval = $(element).find("td").eq(5).html();
        });    
        
                   
       if (status == -1){
           
            
            if (id_evaprim == ideval){
                alertify.alert("PARA ESTA VERSI�N SE REALIZARON LAS SIGUIENTES ACTUALIZACIONES: 1) LA ESCALA DE LA NOTA ES PORCENTUAL. PARA ESTE PRODUCTO O EVIDENCIA EL REGISTRO DE LA NOTA ES A PARTIR DE 1% (M�NIMO) AL  "  + ponderacion + "% (M�XIMO). 2) OPCI�N DE AGREGAR HASTA DOS DECIMALES EN EL REGISTRO DE NOTAS. 3) SE ACTUALIZ� LA FECHA DE EVALUACI�N POR SEMANA DE EVALUACI�N. 4) OPCI�N DE DESCARGAR EN FORMATO PDF LA EVALUACI�N DEL PRODUCTO O EVIDENCIA. 5) OPCI�N DE VISUALIZAR LA INFORMACI�N ESTAD�STICA DE LOS ESTUDIANTES CURSANTES EN LA UNIDAD CURRICULAR. 6) OPCI�N DE REINICIAR TODO EL REGISTRO DE NOTAS  6) OPCI�N DE DESCARGAR EL ACTA DE NOTAS DEFINITIVA UNA VEZ QUE SE HAGA EL CIERRE DE NOTAS POR PARTE DE LA COORDINACI�N DE INFORM�TICA Y ESTAD�STICA.");
                
            }
        
            $("#preloader").css("display", "block");
            
        
            $("#lbl_oferta").text($("#lbl_ofertadocente").text());
            $("#lbl_productoaevaluar").text("PRODUCTO O EVIDENCIA:" + " " + producto);
            $("#lbl_ponderacion").text("PONDERACI�N: " + ponderacion + "%");
            
            IdEvalUlt:id_evault
                    
            //$("#date_fechaevaluacion").val('');
            //$("#date_fechaevaluacion").prop("disabled", false);

             seccion= $("#lbl_seccion").text();
             lapsovigencia = $("#lbl_lapsovigencia").text();
             codcarr = $("#lbl_codcarr").text();
             codasign = $("#lbl_codasign").text();
             codsede = $("#lbl_codsede").text();
             lapsoacademico = $("#lbl_lapsoacademicosis").text();
             carrera = $("#lbl_carrera").text();
             asignatura = $("#lbl_asignatura").text();
             sede = $("#lbl_sede").text();
             docente = $("#lbl_docente").text();
             semestre = $("#lbl_semestre").text();
             ceduladocente = $("#lbl_ceduladocente").text();
            
             
             $("#cmb_semevaluacion").val('0');
             $("#cmb_semevaluacion").prop("disabled", false);
             
             //VERIFICA SI HAY NOTAS TRANSCRITAS PARA APROBAR
            $('#table_producto tr ').each(function(index, element){
                
                if ($(element).find("td").eq(6).html() == 1){ 
                    aprobar = true;
                    
                    if(aprobar){
                        id_evaluacionaprobar = $(element).find("td").eq(5).html();
                        
                    }    
                    
                }    
            
                
            }); 


            //if (id_evaluacionaprobar != -2){ // si no aprueba la evaluacion no podra agregar otra evaluacion
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval013Dao.php?'+ Sesion,
                    data:{Cedula:ceduladocente,CedulaAct:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdEval:ideval,IdEvalAprob:id_evaluacionaprobar,Opcion:3}

                }).success(function(data){

                    $("#div_Nota tbody").empty();

                    $("#div_Nota tbody").append(data);

                    $("#lbl_porcentaje").text('[1% - ' + ponderacion + '%]');

                    $("#preloader").css("display", "none");
                });      


               $("#div_Nota").css("display", "block");
               $("#div_Acciones").css("display", "block");
               $("#div_ActaEvaluacion").css("display", "none")
               $("#div_Productos").css("display", "none");
               //$("#div_escala").css("display", "block");
               $("#div_Acta").css("display", "none"); 
               $("#div_Reiniciar").css("display", "none");
            /*}
            else{
            
                alert("SE CANCEL� TRANSACCI�N");
            }*/
        }  
        else{
            
            alertify.alert("DEBE EVALUAR EL PRODUCTO "  + productoevaluar + " PONDERACI�N " + ponderacionevaluar + " SEMANA " + semanaevaluar);
            
        }
  
    });
    
   
    
     //VALIDAR LOS DATOS DE LA NOTA Y DE LA ESCALA
    $("#table_ponderacion").on('keyup', '.NotaEstudiante', function () {
        var nota;
       
        if($("#radio_porcentaje").prop('checked')){
            this.value = (this.value + '').replace(/[^0-9.,]/g, '');  
                  
            if (this.value.trim() != ""){
                
                if (parseFloat(this.value.trim().replace(',', '.')) > parseFloat(ponderacion.trim())){
                    $(this).closest('tr').find('input[id="notabd"]').val('');
                    this.value = "";
                    alertify.error("LA PONDERACI�N DE LA EVALUACI�N ES MIN 1% - M�X " + ponderacion.trim() + "%");
                }
                else{
                    
                    if (this.value != '00' &&  this.value != ',' && this.value != '.' && this.value.substring(1) != ',,' && this.value.substring(1) != '..' && this.value.substring(1) != ',.' && this.value.substring(1) != '.,' && this.value.substring(3) != ',' && this.value.substring(3) != '.'){
                        $(this).closest('tr').find('input[id="notabd"]').val(this.value.trim().replace(',', '.'));
                        notas = true;
                    }
                    else{
                        $(this).closest('tr').find('input[id="notabd"]').val('');
                        this.value = "";
                        alertify.error("FORMATO NO V�LIDO");
                    }
                }
            } 
            else{
                 $(this).closest('tr').find('input[id="notabd"]').val('');
            }
           
                    
        }
        
             
    });
    
    
    
     //VALIDAR LOS DATOS DE LA NOTA Y DE LA ESCALA
   /* $("#txt_docente").on('keyup', function () {
       
        this.value = (this.value + '').replace(/[^VvEe0-9.,]/g, '');  
                  
   
    });*/
    
     //VALIDAR LOS DATOS DE LA NOTA Y DE LA ESCALA
    $("#txt_docente").on('keyup', function (event) {
        
        var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		$('#bot_buscardocente').click();	
	}
       
        this.value = (this.value + '').replace(/[^VvEe0-9.,]/g, '');  
                  
   
    });
    
    
    /*$('#txt_docente').keypress(function(event){
	
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		alert('You pressed a "enter" key in textbox');	
	}
	
    });*/
 
        
        
 });






