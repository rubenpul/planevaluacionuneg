/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: eval001C.php                                                                          -->  
<!-- DESCRIPCION: Controlador de Eventos de la pagina de eval001.php. Creación del plan de evaluacion-->
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
   
    
    DatosDocente();
 
  
 
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
        
        
        
        
        if($("#radio_general").prop('checked')){
            acta = 1;
        }
        else{
            acta = 2;
        }
               
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval012Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdActa:acta,IdProductosDef:idproductos,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesNroEstIns:nroestudianteinscrito,DesNroEstCur:nroestudiantecursante,DesTotalEvaluado:totalevaluado,DesNroAprob:nroaprob,DesPorcenAprob:porcenaprob,DesNroReprob:nroreprob,DesPorcenReprob:porcenreprob,DesMedia:media,DesNotaMax:notamax,DesNotaMin:notamin,DesDesvtip:desvtip,DesVarianza:varianza,Opcion:11}

        }).success(function(data){
            $("#div_tablaActa").empty();

            $("#div_tablaActa").html(data);
      
        });  
        
    }
    //VISUALIZAR PLAN DE EVALUACION
    $("#table_ponderacion").on('click', '.ActualizarNotaCerrada', function () {
                 
       //obtener datos ponderacion estudiante
    
                              
        ponderacionold = $(this).closest('tr').find('input[id="nota"]').val();
        
        $(this).closest('tr').find('input[id="nota"]').prop('disabled', false);                
        $(this).closest('tr').find('input[id="asistencia"]').prop('disabled', false);                
        
        $(this).closest('tr').find('input[id="actualizarnotacerrada"]').prop('disabled', true);
        $(this).closest('tr').find('input[id="guardarnotacerrada"]').prop('disabled', false);
        
        
        
    });
    
    

    //GUARDAR UNA NOTA APROBADA
    $("#table_ponderacion").on('click', '.GuardarNotaCerrada', function () {
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
        var nopase=1;
        
        seccion= $("#lbl_seccion").text()
        lapsovigencia = $("#lbl_lapsovigencia").text();
        codcarr = $("#lbl_codcarr").text();
        codasign = $("#lbl_codasign").text();
        codsede = $("#lbl_codsede").text();
        lapsoacademico = $("#lbl_lapsoacademicosis").text();
        fechaevaluacion = $("#fechaactual").val();    
        semestre = $("#lbl_semestre").text();
        
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
                     url: 'eval012Dao.php?'+ Sesion,
                     data:{Ponderacion:ponderacion,Cedula:Cedula,IdEval:ideval,CedulaEst:cedula,Ponderacion:nuevaponderacion,Asistencia:nuevaasistencia,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,FechaEvaluacion:fechaevaluacion,NotaAprobada:1,PonderacionOld:ponderacionold,Justificacion:justificacion,IdProductosDef:idproductos,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:productosave,Opcion:10}

                  }).success(function(data){

                                    
                    if (data == 1){
                        alertify.success("EVALUACIÓN ACTUALIZADA SATISFACTORIAMENTE");
                        ponderacionold = nuevaponderacion;
                    }
                    else{
                        nopase = 0;
                        alertify.alert("FALTAN DATOS POR INGRESAR EN LA EVALUACIÓN");
                    }
                    $("#preloader").css("display", "none");
                }); 
                
                if (nopase==1){
                    $(this).closest('tr').each(function(index, element){
                              
                       
                        $(this).find("td").children('img').show();
            
                    }); 
                }
                              
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
                alertify.alert("NO SE REALIZÓ LA ACTUALIZACIÓN. LA NOTA ACTUAL ES IGUAL A LA NOTA ANTERIOR");
            }
            $("#preloader").css("display", "none");
        }
        
        
        
        
        
        
    });
    
     
 
    
    
    //OFERTA DOCENTE EN EL LAPSO ACTUAL          
    function DatosDocente(){
        
         
        
        //DATOS DOCENTE
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval012Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Opcion:1}

        }).success(function(data){
           
            $('#table_ofertadocente tbody').append(data);
            $('.ImagenIndicador').hide();
            $("#div_Estadistica").css("display", "none");
             $("#div_actanotas").css("display", "none"); 
        });
    }
    
     
    
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
        var acta = false;
        var totalevaluado = 0;
        var nroestudiantecursante = 0;
        var nroestudianteinscrito = 0;
        var str;

        
         $('.ImagenIndicador').hide();
         
         $("#preloader").css("display", "block");
        
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                          
            oferta =   $(element).find("td").eq(1).html() + " - " +  $(element).find("td").eq(13).html() + " - SECCIÓN " + $(element).find("td").eq(2).html();

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
         
        //DATOS PRODUCTOS
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval012Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademicosis,LapsoVigencia:lapsovigencia,Opcion:2}

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
                  
                    
                   if ($(element).find("td").eq(6).html() == '3' || $(element).find("td").eq(6).html() == '4'){
                       acta = true;
                   }
                    
               }
               
               /*if ($(element).find("td").eq(9).html() == ""){
                    acta = false;               
               }
               else{*/
                    
                   if ($(element).find("td").eq(9).html() >=0 && $(element).find("td").eq(9).html() <=16){
                        totalevaluado = totalevaluado + parseFloat($(element).find("td").eq(2).html());               
                      
                        if ($(element).find("td").eq(6).html() == 1 || $(element).find("td").eq(6).html() == 2){
                           $("#div_Reiniciar").css("display", "block");
                        }
                   }    
                  
                   
               //}
               
               
            });  
            
            idproductos= 0;
            if (totalponderacion <= 100){
                
                //NRO DE ESTUDIANTES OBJETADOS
                               
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval012Dao.php?'+ Sesion,
                    data:{Cedula:Cedula,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademicosis,LapsoVigencia:lapsovigencia,Opcion:16}

                }).success(function(data){

                    $("#lbl_nroestobjetar").text("NÚMERO DE ESTUDIANTES OBJETADOS " + data + "/5");
                    
                }); 
              
                
                
                
                cantidad = $('#table_producto tr ').length -2;
                
                //VERIFICA SI EVALUO EL 100% PARA DESBLOQUEAR EL ACTA
                if (acta && totalponderacion == 100){
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
                        url: 'eval012Dao.php?'+ Sesion,
                        data:{Cedula:Cedula,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademicosis,LapsoVigencia:lapsovigencia,TotalEvaluado:totalevaluado,TotalEstudiante:nroestudiantecursante,Opcion:13}

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
                alertify.alert("REVISAR EL PLAN DE EVALUACIÓN DE " + oferta + ", ACTUALMENTE TIENE " + totalponderacion + "%");
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
    
     
   //VISUALIZAR LAS NOTAS APROBADAS
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
                         
        
        
        $("#lbl_oferta").text($("#lbl_ofertadocente").text());
        $("#lbl_productoaevaluar").text("PRODUCTO O EVIDENCIA:" + " " + producto);
        $("#lbl_ponderacion").text("PONDERACIÓN: " + ponderacion + "%");

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

         $("#cmb_semevaluacion").val(semana);

         $("#cmb_semevaluacion").prop("disabled", true);

         $.ajax({

             datatype: 'json',
             type: 'POST',
             url: 'eval012Dao.php?'+ Sesion,
             data:{Ponderacion:ponderacion,Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdEval:ideval,DesCarrera:descarr,DesAsignatura:desasign,DesSemestre:semestre,DesProducto:producto,Opcion:6}

         }).success(function(data){

             $("#div_Nota tbody").empty();
             $("#div_Nota tbody").empty();

             $("#div_Nota tbody").append(data);

             $("#lbl_porcentaje").text('[1% - ' + ponderacion + '%]');

             notas = true;



         });      


        $("#div_Nota").css("display", "block");
        $("#div_Acciones").css("display", "none");
        $("#div_ActaEvaluacion").css("display", "block")
        $("#div_Productos").css("display", "none");
        //$("#div_escala").css("display", "none");
        $("#div_Acta").css("display", "none"); 
        $("#div_Reiniciar").css("display", "none");
              
       
        
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
                    alertify.error("LA PONDERACIÓN DE LA EVALUACIÓN ES MIN 1% - MÁX " + ponderacion.trim() + "%");
                }
                else{
                    
                    if (this.value != '00' &&  this.value != ',' && this.value != '.' && this.value.substring(1) != ',,' && this.value.substring(1) != '..' && this.value.substring(1) != ',.' && this.value.substring(1) != '.,' && this.value.substring(3) != ',' && this.value.substring(3) != '.'){
                        $(this).closest('tr').find('input[id="notabd"]').val(this.value.trim().replace(',', '.'));
                        notas = true;
                    }
                    else{
                        $(this).closest('tr').find('input[id="notabd"]').val('');
                        this.value = "";
                        alertify.error("FORMATO NO VÁLIDO");
                    }
                }
            } 
            else{
                 $(this).closest('tr').find('input[id="notabd"]').val('');
            }
           
                    
        }
           
    });
        
 });
