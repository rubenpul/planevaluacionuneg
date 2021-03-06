/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                                -->
<!-- REALIZADO POR: Ruben Pulido                                                              -->
<!-- NOMBRE: eval001C.php                                                                          -->  
<!-- DESCRIPCION: Controlador de Eventos de la pagina de eval001.php. Creaci�n del plan de evaluacion-->
<!-- ******************************************************************************************* -->*/

 
$(document).ready(function () {
    
    var Sesion = $('#p_Sesion').text();
    var Cedula = $('#p_Cedula').text();
    
    
    var instrumento;
    var acumulado;
    var lapsovigencia;
    var codcarr;
    var codasign;
    var codsede;
    var codsedeaux;
    var lapsovigenciaaux;
    var lapsoacademico;
    var seccion;
    var bloqueosalvar = false;
    var copiar =false;
    var desasignatura;
    var descarrera;
    var dessede;
    
    DatosInstrumentos();
    DatosDocente();
    
    function reset () {
			$("#toggleCSS").attr("href", "alertify.js-0.3.11/themes/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false,
				buttonFocus   : "ok"
			});
    }
    
    $("#td_excel").click(function(){
       
      
      $("#Report").submit();
      
               
    });
    
    
    /*function mensaje_confirmar(mensaje){
        var confirmar;
        reset();
	alertify.confirm(mensaje, function (e) {
            if (e) {
                confirmar = true;
                alert(confirmar);
            } else {
                confirmar = false;
	    }
        });
        alert(confirmar);
	return confirmar;		
    }*/
    
    
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
       
       $("#div_referencia").css("display", "none");
       $("#div_PlanEvaluacion").css("display", "none");
       $("#div_Acciones").css("display", "none");
        
       if (valor == "LAPSO"){
          
           if ($("#cmb_lapsoconsulta").val() != 0){
                //DATOS DOCENTE LAPSO ACTIVO
                  $.ajax({

                      datatype: 'json',
                      type: 'POST',
                      url: 'eval001Dao.php?'+ Sesion,
                      data:{Cedula:Cedula,LapsoAcademico:$("#cmb_lapsoconsulta").val(),Opcion:16}

                  }).success(function(data){
                      $('#table_ofertadocente tbody').empty(); 
                      $('#table_ofertadocente tbody').append(data);
                      $('.ImagenIndicador').hide();
                        
                  });               
           }
           else{
            reset();
            alertify.alert("SELECCIONE EL LAPSO ACAD�MICO A CONSULTAR");
            return false;   
           
           }
           
       } 
       else{
            if (valor == "LAPSOACTUAL"){
                //DATOS DOCENTE LAPSO ACTIVO
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval001Dao.php?'+ Sesion,
                    data:{Cedula:Cedula,Opcion:4}

                }).success(function(data){
                    $('#table_ofertadocente tbody').empty(); 
                    $('#table_ofertadocente tbody').append(data);
                    $('.ImagenIndicador').hide();
                });                
            }
            else{
                //DATOS DOCENTE LAPSO CIVA
                 $.ajax({

                     datatype: 'json',
                     type: 'POST',
                     url: 'eval001Dao.php?'+ Sesion,
                     data:{Cedula:Cedula,Opcion:17}

                 }).success(function(data){
                     $('#table_ofertadocente tbody').empty(); 
                     $('#table_ofertadocente tbody').append(data);
                     $('.ImagenIndicador').hide();

                 });                         
            }     
       }
      
       
   }); 
    
    
    
    //GUARDAR TODA LA EVALUACION
    $("#a_GuardarTodaEvaluacion").click(function(){
       
        var arrayProducto = [];
        var arrayActividad = [];
        var arrayCriterio = [];
        var arrayInstrumento = [];
        var arrayEvaluacion = [];
        var arraySemana = [];
        var arrayID = [];
        var str;
        var i;
        var idproductos;
       
                $("#preloader").css("display", "block");
                
        //if (!$(this).prop('disabled')){
        //        $(this).prop('disabled', true);
                
                //actualizar el acumulado
                $("#lbl_acumevaluacion").text('0');
                acumulado = 0;

                $('input[name^="pesoevaluacion"]').each(function() {

                    if ($(this).val()!= ''){

                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                    }
                    $("#lbl_acumevaluacion").text(acumulado);



                });

                if (acumulado > 0 && acumulado < 100){
                    $("#lbl_acumevaluacion").css("color", "black");
                }
                else{
                    if (acumulado > 100){
                        $("#lbl_acumevaluacion").css("color", "red");
                    }
                    else{
                        $("#lbl_acumevaluacion").css("color", "green");
                    }
                }


                if (acumulado > 0 && acumulado <= 100){ //si el acumulado de evaluacion es menor al 100% se procede a almacenar en la bd

                        $('textarea[name^="producto"]').each(function() {

                            arrayProducto.push($(this).val());
                        });

                        $('textarea[name^="actividad"]').each(function() {
                            arrayActividad.push($(this).val());
                        });

                        $('textarea[name^="criterio"]').each(function() {
                            arrayCriterio.push($(this).val());
                        });

                        $('select[name^="cmb_instrumento"]').each(function() {
                            arrayInstrumento.push($(this).val());
                        });

                        $('input[name^="pesoevaluacion"]').each(function() {
                             arrayEvaluacion.push($(this).val());
                        });

                        $('input[name^="semanaevaluar"]').each(function() {
                             arraySemana.push($(this).val());
                        });
                        
                         
                        $('input[name^="idbd"]').each(function() {
                             arrayID.push($(this).val());
                             
                             
                        });

                        seccion = $("#lbl_seccion").text();
                        lapsovigencia = $("#lbl_lapsovigencia").text();
                        codcarr = $("#lbl_codcarr").text();
                        codasign = $("#lbl_codasign").text();
                        codsede = $("#lbl_codsede").text();
                        lapsoacademico = $("#lbl_lapsoacademicosys").text();
                        
                                                
                        $.ajax({

                            datatype: 'json',
                            type: 'POST',
                            url: 'eval001Dao.php?'+ Sesion,
                            data:{IdEval:arrayID,Producto:arrayProducto,Actividad:arrayActividad,Instrumento:arrayInstrumento,Criterio:arrayCriterio,Evaluacion:arrayEvaluacion,Semana:arraySemana,Cedula:Cedula,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,Opcion:5},

                        

                        success: function(data){

                            $('#preloader').css("display", "none");

                            str = data.split("!!");

                            if (data != 0){
                                
                                reset();
                                alertify.alert("EVALUACI�N ACTUALIZADA SATISFACTORIAMENTE");

                                i=1;  
                                idproductos= 0;   
                                $('input[name^="idbd"]').each(function() {
                                    if (i < str.length){  
                                        $(this).val(str[i]);
                                        
                                         if (idproductos == 0){
                                            idproductos = str[i];
                                         }
                                         else{
                                            idproductos = idproductos + "," + str[i];
                                         }
                                    }  
                                    i++;
                                }); 

                                acumulado = 0;
                                $('input[name^="pesoevaluacion"]').each(function() {

                                    if ($(this).val()!= ''){

                                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                                    }

                                });

                               //GENERAR PLAN DE EVALUACION

                                $.ajax({

                                    datatype: 'json',
                                    type: 'POST',
                                    url: 'eval001Dao.php?'+ Sesion,
                                    data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,IdProductosDef:idproductos,Opcion:18}

                                }).success(function(data){


                                     $('#Datos').val(data);
                                      
                                     $("#a_ExportarExcel").css("display", "block");
                                });  
                                

                            }
                            else{
                               
                                alertify.alert("FALTAN DATOS POR INGRESAR EN LA EVALUACI�N");
                               
                                acumulado = 0;

                            }
                                                        
                            $("#lbl_acumevaluacion").text(acumulado);
                            
                            if (parseInt(acumulado) >= 100){
                                $("#a_AgregarEvaluacion").css("display", "none");
                            }

                        }               

                      });
                }
                else{
                    
                    $("#preloader").css("display", "none");
                    alertify.alert("REVISAR PONDERACI�NES DEL PLAN DE EVALUACI�N.");
                    
                }
        //}
        //else{
           
        //}
     });
    
    

    //BORRAR UNA SOLA EVALUACION BASE
    $("#table_planevaluacion").on('click', '.BorrarEvaluacionBase', function () {
        var confirmar;                  
        var ideva;
        var nro;
        var i;
        var plancontrolexcel=0;
       
               
        ideva= $(this).closest('tr').find('input[id="idbd"]').val();
        nro =  $(this).closest('tr').find("td").eq(0).html();
        
        if (ideva > 0){
            
            confirmar = confirm("EST� SEGURO BORRAR LA EVALUACI�N?");

            if (confirmar){
                $("#preloader").css("display", "block");
                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval001Dao.php?'+ Sesion,
                    data:{Opcion:8,IdEval:ideva}

                }).success(function(data){

                        ideva = data;

                        if (ideva != 0){
                            $("#preloader").css("display", "none");
                            alertify.success("BORRADA EVALUACI�N SATISFACTORIAMENTE");



                            i=1;    
                            $('textarea[name^="producto"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }  
                                i++;
                            }); 

                            i=1;    
                            $('textarea[name^="actividad"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }  
                                i++;
                            }); 

                            i=1;    
                            $('textarea[name^="criterio"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }  
                                i++;
                            }); 

                            i=1;    
                            $('input[name^="semanaevaluar"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }  
                                i++;
                            }); 

                            i=1;  
                            $("#lbl_acumevaluacion").text('');
                            acumulado = 0;
                            $('input[name^="pesoevaluacion"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }
                                else{
                                    if ($(this).val() != ''){
                                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                                    }
                                }
                                i++;
                            }); 
                            $("#lbl_acumevaluacion").text(acumulado);
                           
                            if (acumulado > 0 && acumulado < 100){
                                $("#lbl_acumevaluacion").css("color", "black");
                                $("#a_AgregarEvaluacion").css("display", "block");
                            }
                            else{
                                if (acumulado > 100){
                                    $("#lbl_acumevaluacion").css("color", "red");
                                    $("#a_AgregarEvaluacion").css("display", "none");
                                }
                                else{
                                    $("#lbl_acumevaluacion").css("color", "green");
                                    $("#a_AgregarEvaluacion").css("display", "none");
                                }
                            }
                            

                            i=1;    
                            $('input[name^="idbd"]').each(function() {
                                if (i == nro){  
                                    $(this).val('0');
                                }  
                                i++;
                            }); 

                            i=1;    
                            $('select[name^="cmb_instrumento"]').each(function() {
                                if (i == nro){  
                                    $(this).val('');
                                }  
                                i++;
                            }); 

                        }
                        else{
                            
                            alertify.alert("NO SE EFECTU� LA ACTUALIZACI�N");
                        }
                });
               
             


            }
        }
        else{
             reset();
             alertify.alert("NO SE EFECTU� LA ACTUALIZACI�N. ESTA EVALUACI�N NO EST� GUARDADA EN LA BASE DE DATOS");
         
        }
        
        
        $('input[name^="idbd"]').each(function() {
            if($(this).val() != 0) {
                plancontrolexcel = 1;
            }   
            
        }); 
        
        if (plancontrolexcel == 0){
            $("#a_ExportarExcel").css("display", "none");
        }
        
        
            
    });
          
    
    //BORRAR UNA SOLA EVALUACION
    $("#table_planevaluacion").on('click', '.BorrarEvaluacion', function () {
                        
        var ideva;
        var confirmar;
            
                
        ideva= $(this).closest('tr').find('input[id="idbd"]').val();
         
        confirmar = confirm("EST� SEGURO BORRAR LA EVALUACI�N?");
                            
        if (confirmar){
            $("#preloader").css("display", "block");
            $(this).closest('tr').remove();

            Actualizar_contador();

            if (ideva > 0){


                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval001Dao.php?'+ Sesion,
                    data:{Opcion:8,IdEval:ideva}

                }).success(function(data){

                        ideva = data;

                        if (ideva != 0){

                            alertify.success("BORRADA EVALUACI�N SATISFACTORIAMENTE");

                        }
                        else{

                            alertify.error("NO SE EFECTU� LA ACTUALIZACI�N");
                        }
                        
                        $("#preloader").css("display", "none");
                });
            }    
            else{

            } 


            $("#lbl_acumevaluacion").text('');
              acumulado = 0;
              $('input[name^="pesoevaluacion"]').each(function() {
                 if ($(this).val() != ''){
                    acumulado = parseInt(acumulado) + parseInt($(this).val());
                 }
              }); 
            $("#lbl_acumevaluacion").text(acumulado);

            if (acumulado > 0 && acumulado < 100){
                $("#lbl_acumevaluacion").css("color", "black");
                $("#a_AgregarEvaluacion").css("display", "block");
                
            }
            else{
                if (acumulado > 100){
                    $("#lbl_acumevaluacion").css("color", "red");
                     $("#a_AgregarEvaluacion").css("display", "none");
                }
                else{
                    $("#lbl_acumevaluacion").css("color", "green");
                    $("#a_AgregarEvaluacion").css("display", "none");
                }
            }

        }
        else{
            
             alertify.error("NO SE EFECTU� LA ACTUALIZACI�N");
        }
 
        
    });
    
    //GUARDAR UNA SOLA EVALUACION
    $("#table_planevaluacion").on('click', '.GuardarEvaluacion', function () {

       var arrayProducto = [];
        var arrayActividad = [];
        var arrayCriterio = [];
        var arrayInstrumento = [];
        var arrayEvaluacion = [];
        var arraySemana = [];
        var arrayID = [];
        var str;
        var i;
       
       
        if (!$(this).prop('disabled')){
                $(this).prop('disabled', true);
                
                //actualizar el acumulado
                $("#lbl_acumevaluacion").text('0');
                acumulado = 0;

                $('input[name^="pesoevaluacion"]').each(function() {

                    if ($(this).val()!= ''){

                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                    }
                    $("#lbl_acumevaluacion").text(acumulado);



                });

                if (acumulado > 0 && acumulado < 100){
                    $("#lbl_acumevaluacion").css("color", "black");
                }
                else{
                    if (acumulado > 100){
                        $("#lbl_acumevaluacion").css("color", "red");
                    }
                    else{
                        $("#lbl_acumevaluacion").css("color", "green");
                    }
                }


                if (acumulado > 0 && acumulado <= 100){ //si el acumulado de evaluacion es menor al 100% se procede a almacenar en la bd

                        $('textarea[name^="producto"]').each(function() {

                            arrayProducto.push($(this).val());
                        });

                        $('textarea[name^="actividad"]').each(function() {
                            arrayActividad.push($(this).val());
                        });

                        $('textarea[name^="criterio"]').each(function() {
                            arrayCriterio.push($(this).val());
                        });

                        $('select[name^="cmb_instrumento"]').each(function() {
                            arrayInstrumento.push($(this).val());
                        });

                        $('input[name^="pesoevaluacion"]').each(function() {
                             arrayEvaluacion.push($(this).val());
                        });

                        $('input[name^="semanaevaluar"]').each(function() {
                             arraySemana.push($(this).val());
                        });

                        $('input[name^="idbd"]').each(function() {
                             arrayID.push($(this).val());
                        });

                        seccion = $("#lbl_seccion").text();
                        lapsovigencia = $("#lbl_lapsovigencia").text();
                        codcarr = $("#lbl_codcarr").text();
                        codasign = $("#lbl_codasign").text();
                        codsede = $("#lbl_codsede").text();
                        lapsoacademico = $("#lbl_lapsoacademicosys").text();
                        
                                                
                        $.ajax({

                            datatype: 'json',
                            type: 'POST',
                            url: 'eval001Dao.php?'+ Sesion,
                            data:{IdEval:arrayID,Producto:arrayProducto,Actividad:arrayActividad,Instrumento:arrayInstrumento,Criterio:arrayCriterio,Evaluacion:arrayEvaluacion,Semana:arraySemana,Cedula:Cedula,Carrera:codcarr,Asignatura:codasign,Seccion:seccion,Sede:codsede,LapsoAcademico:lapsoacademico,LapsoVigencia:lapsovigencia,Opcion:5},

                        beforeSend: function(){
                          $(".se-pre-con").fadeOut("slow");                                  
                        },    

                        success: function(data){

                            $('#preloader').css("display", "none");

                            str = data.split("!!");

                            if (data != 0){
                                
                                reset();
                                alertify.alert("EVALUACI�N ACTUALIZADA SATISFACTORIAMENTE");

                                i=1;    
                                $('input[name^="idbd"]').each(function() {
                                    if (i < str.length){  
                                        $(this).val(str[i]);
                                    }  
                                    i++;
                                }); 

                                acumulado = 0;
                                $('input[name^="pesoevaluacion"]').each(function() {

                                    if ($(this).val()!= ''){

                                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                                    }

                                });

                                $('#td_pdf').css("display", "block");
                                $(this).prop('disabled', false);
                                //$("#a_GuardarTodaEvaluacion").prop('disabled', false);

                            }
                            else{

                                reset();
                                alertify.alert("FALTAN DATOS POR INGRESAR EN LA EVALUACI�N");
                                 $(this).prop('disabled', false);
                                //$("#a_GuardarTodaEvaluacion").prop('disabled', false);
                                acumulado = 0;

                            }

                            $("#lbl_acumevaluacion").text(acumulado);

                            if (parseInt(acumulado) >= 100){
                                $("#a_AgregarEvaluacion").css("display", "none");
                            }
                            
                        }               

                      });
                }
                else{
                    reset();
                    alertify.alert("REVISAR PONDERACI�NES DEL PLAN DE EVALUACI�N.");
                     $(this).prop('disabled', false);
                    //$("#a_GuardarTodaEvaluacion").prop('disabled', false);
                }
        }
        else{
           
        }

        
    });
    
      
    
    //AGREGAR UNA EVALUACION EN LA TABLA HTML
    $("#a_AgregarEvaluacion").click(function(){
        AgregarFilasPlan();
	
    });
    
    function AgregarFilasPlan(){
        var clonarfila;
        var valor;       
              
        clonarfila = '<tr>';
        clonarfila += '<td></td>';
        clonarfila += '<td width="200px"><textarea rows="10" cols="20"  name="producto[]" id="producto" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="actividad[]" id="actividad" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="criterio[]" id="criterio" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px">' + instrumento ;
        clonarfila += '</td>';
        clonarfila += '<td width="110px"><input name=\"pesoevaluacion[]\" id=\"pesoevaluacion\" maxlength=\"2\" size=\"1\" class=\"EvaluarPonderacion\" required></input><b>1%-25%</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><input name=\"semanaevaluar[]\" id=\"semanaevaluar\" maxlength=\"2\" size=\"1\" class=\"EvaluarSemana\" required></input><b>(1-16)</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><a href="#"><img src="../imagenes/savedatabase.png" title="Salvar Evaluaci�n" id="a_SalvarEvaluacion" class="GuardarEvaluacion" height="30" width="30"></a>';
        clonarfila += '<br><br><a href="#"><img src="../imagenes/eliminar.png" title="Borrar Evaluaci�n" class="BorrarEvaluacion" height="30" width="30"></a>';
        clonarfila += '</td>';
        clonarfila += '<td style=display:none;>';
        clonarfila += '<input name=\"idbd[]\" id=\"idbd\" maxlength=\"2\" size=\"1\"  value=\"0\"></input>';
        clonarfila += '</td>';
        clonarfila += '</tr>';
        
        $('#table_planevaluacion tbody').append(clonarfila);
        
        Actualizar_contador();
             
    }
    
    function AgregarFilasPlanBloqueado(){
        var clonarfila;
        var valor;       
              
        clonarfila = '<tr>';
        clonarfila += '<td></td>';
        clonarfila += '<td width="200px"><textarea rows="10" cols="20"  name="producto[]" id="producto" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="actividad[]" id="actividad" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="criterio[]" id="criterio" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px">' + instrumento ;
        clonarfila += '</td>';
        clonarfila += '<td width="110px"><input name=\"pesoevaluacion[]\" id=\"pesoevaluacion\" maxlength=\"2\" size=\"1\" class=\"EvaluarPonderacion\" required></input><b>1%-25%</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><input name=\"semanaevaluar[]\" id=\"semanaevaluar\" maxlength=\"2\" size=\"1\" class=\"EvaluarSemana\" required></input><b>(1-16)</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"></a>';
        clonarfila += '</td>';
        clonarfila += '<td style=display:none;>';
        clonarfila += '<input name=\"idbd[]\" id=\"idbd\" maxlength=\"2\" size=\"1\"  value=\"0\"></input>';
        clonarfila += '</td>';
        clonarfila += '</tr>';
        
        $('#table_planevaluacion tbody').append(clonarfila);
        
        Actualizar_contador();
             
    }
    
    function AgregarFilasPlanBase(){
        var clonarfila;
        var valor;       
              
        clonarfila = '<tr>';
        clonarfila += '<td></td>';
        clonarfila += '<td width="200px"><textarea rows="10" cols="20"  name="producto[]" id="producto" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="actividad[]" id="actividad" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="criterio[]" id="criterio" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px">' + instrumento ;
        clonarfila += '</td>';
        clonarfila += '<td width="110px"><input name=\"pesoevaluacion[]\" id=\"pesoevaluacion\" maxlength=\"2\" size=\"1\" class=\"EvaluarPonderacion\" required></input><b>1%-25%</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><input name=\"semanaevaluar[]\" id=\"semanaevaluar\" maxlength=\"2\" size=\"1\" class=\"EvaluarSemana\" required></input><b>(1-16)</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><a href="#"><img src="../imagenes/savedatabase.png" title="Salvar Evaluaci�n" id="a_SalvarEvaluacion" class="GuardarEvaluacion" height="30" width="30"></a>';
        clonarfila += '<br><br><a href="#"><img src="../imagenes/eraser.png" title="Borrar Evaluaci�n" class="BorrarEvaluacionBase" height="30" width="30"></a>';
        clonarfila += '</td>';
        clonarfila += '<td style=display:none;>';
        clonarfila += '<input name=\"idbd[]\" id=\"idbd\" maxlength=\"2\" size=\"1\"  value=\"0\"></input>';
        clonarfila += '</td>';
        clonarfila += '</tr>';
        
        $('#table_planevaluacion tbody').append(clonarfila);
        
        Actualizar_contador();
             
    }
    
    function AgregarFilasPlanBaseBloqueado(){
        var clonarfila;
        var valor;       
              
        clonarfila = '<tr>';
        clonarfila += '<td></td>';
        clonarfila += '<td width="200px"><textarea rows="10" cols="20"  name="producto[]" id="producto" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="actividad[]" id="actividad" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px"><textarea rows="10" cols="20" name="criterio[]" id="criterio" border:1px solid blue; required></textarea>';
        clonarfila += '</td>';
        clonarfila += '<td width="150px">' + instrumento ;
        clonarfila += '</td>';
        clonarfila += '<td width="110px"><input name=\"pesoevaluacion[]\" id=\"pesoevaluacion\" maxlength=\"2\" size=\"1\" class=\"EvaluarPonderacion\" required></input><b>1%-25%</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px"><input name=\"semanaevaluar[]\" id=\"semanaevaluar\" maxlength=\"2\" size=\"1\" class=\"EvaluarSemana\" required></input><b>(1-16)</b>';
        clonarfila += '</td>';
        clonarfila += '<td width="80px">';
        clonarfila += '</td>';
        clonarfila += '<td style=display:none;>';
        clonarfila += '<input name=\"idbd[]\" id=\"idbd\" maxlength=\"2\" size=\"1\"  value=\"0\"></input>';
        clonarfila += '</td>';
        clonarfila += '</tr>';
        
        $('#table_planevaluacion tbody').append(clonarfila);
        
        Actualizar_contador();
             
    }
    
    
    
    
    //ACTUALIZA EL CONTADOR DEL NUMERO DE EVALUACIONES DEL DOCENTE
    function Actualizar_contador(){
       var contador =0;
       
       $('#table_planevaluacion tr').each(function(index, element){
           if (contador != 0){
                $(element).find("td").eq(0).html(contador);
                contador += 1;
           }
           else{
               contador = 1;
           }
           
        });
        
        
    }
    
    //VALIDAR DATOS DE LA PONDERACION QUE SEA NUMERICO Y QUE ESTE EN RANGO 1%-25%
    $("#table_planevaluacion").on('keyup', '.EvaluarPonderacion', function () {
                                  
            this.value = (this.value + '').replace(/[^0-9]/g, '');  
            
            
            if (this.value != ""){
                if (this.value < 1 || this.value >25){
                    this.value = "";
                    reset();
                    alertify.alert("LA PONDERACI�N DE LA EVALUACI�N ES MIN 1%- M�X 25%");
                }
            }      
    });
    
    //VALIDAR DATOS DE LA SEMANA QUE SEA NUMERICO Y QUE ESTE EN RANGO 1-16
    $("#table_planevaluacion").on('keyup', '.EvaluarSemana', function () {
                                
            this.value = (this.value + '').replace(/[^0-9]/g, '');  
            
            if (this.value != ""){
                if (this.value < 1 || this.value >16){
                    this.value = "";
                    reset();
                    alertify.alert("LA SEMANA DE LA EVALUACI�N ES MIN 1 - M�X 16");
                }
            }      
    });
    
    
    //VALIDAR DATOS DEL PRODUCTO SEAN ALFANUMERICOS
    $("#table_planevaluacion").on('keyup', '.EvaluarProducto', function (event) {
        
        if (event.which != 32){
            this.value = (this.value + '').replace(/[^0-9a-zA-Z������������.]/g, ' ');  
        }    
                
               
    });
    
    
    //LLENAR EL COMBOBOX DE LOS INSTRUMENTOS
    function DatosInstrumentos(){
        
                
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval001Dao.php?'+ Sesion,
                data:{Opcion:2}

                }).success(function(data){
                    instrumento = data;
                    
                }
            );
                
    } 
    
  
       
    function DatosDocente(){
       
        
       //DATOS DOCENTE HISTORICO LAPSOS
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval001Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Opcion:15}

        }).success(function(data){
              
            $('#cmb_lapsoconsulta').html(data);
            
              
        });      
        
        //DATOS DOCENTE LAPSO ACTIVO
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval001Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Opcion:4}

        }).success(function(data){
            
            $('#table_ofertadocente tbody').append(data);
            $('.ImagenIndicador').hide();
              
        });
        
      
    }
    
    
    function DatosLapsoPlan(codasign){
        //DATOS LAPSO CARGADOS DOCENTE
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval001Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Asignatura:codasign,Opcion:9}

        }).success(function(data){
          
            if(data != 0){
                $('#cmb_lapso').html(data);
                $('#cmb_unidad').html('');
                $('#cmb_carrera').html('');
                $('#cmb_seccion').html('');
                $("#div_referencia").css("display", "block");
            }
            else{
                $('#cmb_lapso').html('');
                $('#cmb_unidad').html('');
                $('#cmb_carrera').html('');
                $('#cmb_seccion').html('');
                $("#div_referencia").css("display", "none");
            }                          
        });
    }  

   $("#cmb_lapso").change(function(){
         codasign = $("#lbl_codasign").text();       
       if ($('#cmb_lapso').val() != '0'){
           lapsoacademico = $('#cmb_lapso').val();
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval001Dao.php?'+ Sesion,
                data:{Cedula:Cedula,LapsoAcademico:lapsoacademico,Asignatura:codasign,Opcion:10}

            }).success(function(data){
                $('#cmb_unidad').html(data);
                $('#cmb_carrera').html('');
                $('#cmb_seccion').html('');
            });           
       }
       else{
           $('#cmb_unidad').html('');
           $('#cmb_carrera').html('');
           $('#cmb_seccion').html('');
       }
       
   }); 

   $("#cmb_unidad").change(function(){
       
      
       if ($('#cmb_lapso').val() != '0' && $('#cmb_unidad').val() != '0'){
           lapsoacademico = $('#cmb_lapso').val();
           codasign = $('#cmb_unidad').val();
           
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval001Dao.php?'+ Sesion,
                data:{Cedula:Cedula,LapsoAcademico:lapsoacademico,Asignatura:codasign,Opcion:11}

            }).success(function(data){
                $('#cmb_carrera').html(data);
                $('#cmb_seccion').html('');
            });           
       }
       else{
           $('#cmb_carrera').html('');
           $('#cmb_seccion').html('');
       }
       
   });    
   
   
   $("#cmb_carrera").change(function(){
       
      
       if ($('#cmb_lapso').val() != '0' && $('#cmb_unidad').val() != '0' && $('#cmb_carrera').val() != '0'){
           lapsoacademico = $('#cmb_lapso').val();
           codasign = $('#cmb_unidad').val();
           codcarr = $('#cmb_carrera').val();
           
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval001Dao.php?'+ Sesion,
                data:{Cedula:Cedula,LapsoAcademico:lapsoacademico,Asignatura:codasign,Carrera:codcarr,Opcion:12}

            }).success(function(data){
                $('#cmb_seccion').html(data);
            });  
       }
       else{
          $('#cmb_seccion').html('');
       }
       
   });  
   
   $("#cmb_seccion").change(function(){
           
       if ($('#cmb_lapso').val() != '0' && $('#cmb_unidad').val() != '0' && $('#cmb_carrera').val() != '0' && $('#cmb_seccion').val() != '0'){
           lapsoacademico = $('#cmb_lapso').val();
           codasign = $('#cmb_unidad').val();
           codcarr = $('#cmb_carrera').val();
           seccion = $('#cmb_seccion').val();
           codsedeaux = $("#lbl_codsede").text();
           lapsovigenciaaux = $('#lbl_lapsovigencia').html();
                         
            $.ajax({//sede

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval001Dao.php?'+ Sesion,
                 data:{Cedula:Cedula,LapsoAcademico:lapsoacademico,Asignatura:codasign,Carrera:codcarr,Seccion:seccion,Opcion:13}

             }).success(function(data){
                 $('#lbl_codsede').html(data);
             }); 

             $.ajax({//lapsovigencia

                 datatype: 'json',
                 type: 'POST',
                 url: 'eval001Dao.php?'+ Sesion,
                 data:{Cedula:Cedula,LapsoAcademico:lapsoacademico,Asignatura:codasign,Carrera:codcarr,Seccion:seccion,Opcion:14}

             }).success(function(data){
                $('#lbl_lapsovigencia').html(data);
             }); 
                 


            if (seccion != $("#lbl_seccion").text() || codcarr != $("#lbl_codcarr").text() || codasign != $("#lbl_codasign").text() || lapsoacademico != $("#lbl_lapsoacademico").text()){
               copiar = true;          
            }     
            else{
               copiar = false;
            }
            
	         
       }
       else{
          $('#cmb_seccion').html('');
          /*$('#lbl_codsede').html('');
          $('#lbl_lapsovigencia').html('');*/
          copiar = false;
       }
       
   });  
  
 
    
    //VISUALIZAR PLAN DE EVALUACION
    $("#table_ofertadocente").on('click', '.GenerarPlanEvaluacion', function () {
        var oferta;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var sede;
        var lapsoacademico;
        var lapsoacademicosys;
        var seccion;
        var str;
        var i;
        var j;
        var arrProducto = [];
        var arrActividad = [];
        var arrCriterio = [];
        var arrInstrumento = [];
        var arrSemana = [];
        var arrEvaluacion = [];
        var arrID = [];
        var arrPonderacion = [];
        var arrStatus = [];
        var clonarfilas;
        var blocksave = 1;
        
        var idproductos;
        
        $('.ImagenIndicador').hide();
        
        $("#preloader").css("display", "block");
        //obtener datos de la oferta
        $(this).closest('tr').each(function(index, element){
                              
                oferta =   $(element).find("td").eq(1).html() + " - " +  $(element).find("td").eq(11).html() + " - SECCI�N " + $(element).find("td").eq(2).html();
                
                seccion = $(element).find("td").eq(2).html();
                lapsovigencia = $(element).find("td").eq(4).html();
                codcarr = $(element).find("td").eq(5).html();
                codasign = $(element).find("td").eq(6).html();
                codsede = $(element).find("td").eq(7).html();
                lapsoacademico = $(element).find("td").eq(8).html();
                lapsoacademicosys = $(element).find("td").eq(13).html();
                sede = $(element).find("td").eq(10).html();
                $(this).find("td").children('img').show();
                desasignatura = $(element).find("td").eq(11).html();
                descarrera = $(element).find("td").eq(1).html();
                
        });    
        
        $("#lbl_ofertadocente").text(oferta);
        $("#lbl_sede").text(sede);

        $("#lbl_seccion").text(seccion)
        $("#lbl_lapsovigencia").text(lapsovigencia);
        $("#lbl_codcarr").text(codcarr);
        $("#lbl_codasign").text(codasign);
        $("#lbl_codsede").text(codsede);
        $("#lbl_lapsoacademico").text(lapsoacademico);
        $("#lbl_lapsoacademicosys").text(lapsoacademicosys);

        $("#div_PlanEvaluacion").css("display", "block");
        $("#div_Acciones").css("display", "block");
       
        
        //REINICIAR LA TABLA DE PLAN DE EVALUACION
        $("#table_planevaluacion tbody").empty();

        

        $("#lbl_acumevaluacion").text('');
        
       
       

        //BUSCA DATOS DEL PLAN DE EVALUACION DE LA ASIGNATURA  EN LA BD 
        $.ajax({

            datatype: 'json',
            type: 'POST',
            url: 'eval001Dao.php?'+ Sesion,
            data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademicosys,Opcion:7}

        }).success(function(data){

           str = data.split("!!");
           i=0;


           if (str.length > 1){ // SI EXISTEN DATOS DE LA PLANIFICACION SE VISUALIZA

               while(i < str.length){ // SE CONVIERTE LOS DATOS EN ARREGLOS,CADA DATO DONDE CORRESPONDA

                    arrID.push(str[i]);
                    i++;
                    arrProducto.push(str[i]);
                    i++;
                    arrActividad.push(str[i]);
                    i++;
                    arrCriterio.push(str[i]);
                    i++;
                    arrInstrumento.push(str[i]);
                    i++;
                    arrPonderacion.push(str[i]);
                    i++;
                    arrSemana.push(str[i]);
                    i++;
                    arrStatus.push(str[i]);
                    i++;

               }

               if (arrStatus[0] == 0){
                  AgregarFilasPlanBaseBloqueado();
                  
               }
               else{
                  AgregarFilasPlanBase();
                  blocksave = 0;
               }

               if (arrStatus[1] == 0){
                  AgregarFilasPlanBaseBloqueado();
               }
               else{
                  AgregarFilasPlanBase();
                  blocksave = 0;
               }

               if (arrStatus[2] == 0){
                  AgregarFilasPlanBaseBloqueado();
               }
               else{
                  AgregarFilasPlanBase();
                  blocksave = 0;
               }

               if (arrStatus[3] == 0){
                  AgregarFilasPlanBaseBloqueado();
               }
               else{
                  AgregarFilasPlanBase();
                  blocksave = 0;
               }
       


               //VERIFICAR SI EXCEDE DE 4 EVALUACIONES PARA CLONAR FILAS
               j=4;
               if(arrID.length>4){
                   
                   clonarfilas = arrID.length -4;
                   i=0;
                   while(i<clonarfilas){
                       if (arrStatus[j] == 0){
                            AgregarFilasPlanBloqueado();
                       }
                       else{
                            AgregarFilasPlan();
                       } 
                       j++;
                       i++;
                   }
                   
               }
               
               //SE INCORPORA CADA UNO DE LOS ARREGLOS EN LOS COMPONENTES HTML QUE CORRESPONDA

               i=0;    
               
               $('textarea[name^="producto"]').each(function() {
                    if (i < arrProducto.length){  
                        $(this).val(arrProducto[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                        
                    }  
                    i++;
               }); 

               i=0;    
               $('textarea[name^="actividad"]').each(function() {
                    if (i < arrActividad.length){  
                        $(this).val(arrActividad[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                    }  
                    i++;
               }); 

               i=0;    
               $('textarea[name^="criterio"]').each(function() {
                    if (i < arrCriterio.length){  
                        $(this).val(arrCriterio[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                    }  
                    i++;
               }); 

               i=0;    
               $('input[name^="pesoevaluacion"]').each(function() {
                    if (i < arrPonderacion.length){  
                        $(this).val(arrPonderacion[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                    }  
                    i++;
               }); 

               i=0;    
               $('input[name^="semanaevaluar"]').each(function() {
                    if (i < arrSemana.length){  
                        $(this).val(arrSemana[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                    }  
                    i++;
               }); 

               i=0;    
               $('select[name^="cmb_instrumento"]').each(function() {
                    if (i < arrInstrumento.length){  
                        $(this).val(arrInstrumento[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                    }  
                    i++;
               }); 


               i=0;   
               idproductos= 0;
               $('input[name^="idbd"]').each(function() {
                    if (i < arrID.length){  
                        $(this).val(arrID[i]);
                        if (arrStatus[i] == 0){
                            $(this).prop("disabled", true);
                        }
                        
                        if (idproductos == 0){
                            idproductos = arrID[i];
                        }
                        else{
                            idproductos = idproductos + "," + arrID[i];
                            
                        }
                        
                    }  
                    i++;
               }); 

               //SE ACTUALIZA EL TOTAL ACUMULADO

               $("#lbl_acumevaluacion").text('');
                acumulado = 0;

                $('input[name^="pesoevaluacion"]').each(function() {

                    if ($(this).val()!= ''){

                        acumulado = parseInt(acumulado) + parseInt($(this).val());
                    }


                });
                

                $("#lbl_acumevaluacion").text(acumulado);
        
                if (acumulado >= 0 && acumulado < 100){
                    $("#lbl_acumevaluacion").css("color", "black");
                   
                    //SI ESTA CERRADA LA EVALUACION NO PUEDE INGRESAR NOTAS
                    
                     //BUSCA DATOS DEL PLAN DE EVALUACION DE LA ASIGNATURA  EN LA BD 
                    $.ajax({

                        datatype: 'json',
                        type: 'POST',
                        url: 'eval001Dao.php?'+ Sesion,
                        data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademicosys,Opcion:7}

                    }).success(function(data){
                        
                        if(data == 1 || data == 2){
                   
                            $("#a_AgregarEvaluacion").css("display", "block");
                        }
                        else{
                            $("#a_AgregarEvaluacion").css("display", "none");
                        }
                    
                    });
                            
                }
                else{
                    if (acumulado > 100){
                        $("#lbl_acumevaluacion").css("color", "red");
                        $("#a_AgregarEvaluacion").css("display", "none");
                    }
                    else{
                        $("#lbl_acumevaluacion").css("color", "green");
                        $("#a_AgregarEvaluacion").css("display", "none");
                    }
                }

                if (blocksave == 0){
                    $("#a_GuardarTodaEvaluacion").css("display", "block");
                }
                else{
                    $("#a_GuardarTodaEvaluacion").css("display", "none");
                }

                $('#td_pdf').css("display", "block");
                $("#div_referencia").css("display", "none");
                
                           
                
                //GENERAR PLAN DE EVALUACION

                $.ajax({

                    datatype: 'json',
                    type: 'POST',
                    url: 'eval001Dao.php?'+ Sesion,
                    data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademicosys,IdProductosDef:idproductos,Opcion:18}

                }).success(function(data){
                   
                   
                     $('#Datos').val(data);
                     $('#DesCarrera').val(descarrera);
                     $('#CodAsignatura').val(codasign);
                     $('#DesAsignatura').val(desasignatura);   
                     $('#DesSede').val(sede); 
                     $('#DesSeccion').val(seccion); 
                     $('#DesLapsoVigencia').val(lapsovigencia);
                     $('#DesLapsoAcad').val(lapsoacademico);
                     $('#CedulaDocente').val(Cedula);  
                     $("#a_ExportarExcel").css("display", "block");
                });  
                
                
           }
           else{
                AgregarFilasPlanBase();
                AgregarFilasPlanBase();
                AgregarFilasPlanBase();
                AgregarFilasPlanBase();
                DatosLapsoPlan(codasign);
                $('#DesCarrera').val(descarrera);
                $('#CodAsignatura').val(codasign);
                $('#DesAsignatura').val(desasignatura);   
                $('#DesSede').val(sede); 
                $('#DesSeccion').val(seccion); 
                $('#DesLapsoVigencia').val(lapsovigencia);
                $('#DesLapsoAcad').val(lapsoacademico);
                $('#CedulaDocente').val(Cedula);
                $("#a_AgregarEvaluacion").css("display", "block");
                $("#a_GuardarTodaEvaluacion").css("display", "block");
                $("#a_ExportarExcel").css("display", "none");
           }
           $("#preloader").css("display", "none");
        });
        
        
    
        
          
    });


    //VISUALIZAR PLAN DE EVALUACION
    $("#bot_buscar").click(function(){
        //var oferta;
        var lapsovigencia;
        var codcarr;
        var codasign;
        var codsede;
        var lapsoacademico;
        var seccion;
        var str;
        var i;
        var j;
        var arrProducto = [];
        var arrActividad = [];
        var arrCriterio = [];
        var arrInstrumento = [];
        var arrSemana = [];
        var arrID = [];
        var arrPonderacion = [];
        var arrStatus = [];
        var clonarfilas;

	 $("#preloader").css("display", "block");
        
        //if (copiar || codsedeaux != $("#lbl_codsede").text()){
            
            //obtener datos de la oferta
           // $(this).closest('tr').each(function(index, element){

            //        oferta =   $("#cmb_carrera :selected").text() + " - " +  $("#cmb_unidad :selected").text() + " - SECCI�N " + $("#cmb_seccion").val();
                    seccion = $("#cmb_seccion").val();
                    lapsovigencia = $("#lbl_lapsovigencia").text();
                    codcarr = $("#cmb_carrera").val();
                    codasign = $("#cmb_unidad").val();
                    codsede = $("#lbl_codsede").text();
                    lapsoacademico = $("#cmb_lapso").val();
			
                    if (codcarr == '00'){
			codcarr = '0';
		    }    
                    
            //});           

            //REINICIAR LA TABLA DE PLAN DE EVALUACION
            $("#table_planevaluacion tbody").empty();


            $("#lbl_acumevaluacion").text('');
            
            $("#lbl_codsede").text(codsedeaux);
            $("#lbl_lapsovigencia").text(lapsovigenciaaux);

           
            //BUSCA DATOS DEL PLAN DE EVALUACION DE LA ASIGNATURA  EN LA BD 
            $.ajax({

                datatype: 'json',
                type: 'POST',
                url: 'eval001Dao.php?'+ Sesion,
                data:{Cedula:Cedula,Seccion:seccion,LapsoVigencia:lapsovigencia,Carrera:codcarr,Asignatura:codasign,Sede:codsede,LapsoAcademico:lapsoacademico,Opcion:7}

            }).success(function(data){

               str = data.split("!!");
               i=0;


               if (str.length > 1){ // SI EXISTEN DATOS DE LA PLANIFICACION SE VISUALIZA

                   while(i < str.length){ // SE CONVIERTE LOS DATOS EN ARREGLOS,CADA DATO DONDE CORRESPONDA

                        arrID.push(str[i]);
                        i++;
                        arrProducto.push(str[i]);
                        i++;
                        arrActividad.push(str[i]);
                        i++;
                        arrCriterio.push(str[i]);
                        i++;
                        arrInstrumento.push(str[i]);
                        i++;
                        arrPonderacion.push(str[i]);
                        i++;
                        arrSemana.push(str[i]);
                        i++;
                        arrStatus.push(str[i]);
                        i++;

                   }


                    AgregarFilasPlanBase();

                    AgregarFilasPlanBase();

                    AgregarFilasPlanBase();

                    AgregarFilasPlanBase();




                   //VERIFICAR SI EXCEDE DE 4 EVALUACIONES PARA CLONAR FILAS

                   if(arrID.length>4){

                       clonarfilas = arrID.length -4;
                       i=0;
                       while(i<clonarfilas){
                           AgregarFilasPlan();

                           i++;
                       }

                   }

                   //SE INCORPORA CADA UNO DE LOS ARREGLOS EN LOS COMPONENTES HTML QUE CORRESPONDA

                   i=0;    

                   $('textarea[name^="producto"]').each(function() {
                        if (i < arrProducto.length){  
                            $(this).val(arrProducto[i]);

                        }  
                        i++;
                   }); 

                   i=0;    
                   $('textarea[name^="actividad"]').each(function() {
                        if (i < arrActividad.length){  
                            $(this).val(arrActividad[i]);

                        }  
                        i++;
                   }); 

                   i=0;    
                   $('textarea[name^="criterio"]').each(function() {
                        if (i < arrCriterio.length){  
                            $(this).val(arrCriterio[i]);

                        }  
                        i++;
                   }); 

                   i=0;    
                   $('input[name^="pesoevaluacion"]').each(function() {
                        if (i < arrPonderacion.length){  
                            $(this).val(arrPonderacion[i]);

                        }  
                        i++;
                   }); 

                   i=0;    
                   $('input[name^="semanaevaluar"]').each(function() {
                        if (i < arrSemana.length){  
                            $(this).val(arrSemana[i]);

                        }  
                        i++;
                   }); 

                   i=0;    
                   $('select[name^="cmb_instrumento"]').each(function() {
                        if (i < arrInstrumento.length){  
                            $(this).val(arrInstrumento[i]);

                        }  
                        i++;
                   }); 


                   i=0;    
                   $('input[name^="idbd"]').each(function() {
                        if (i < arrID.length){  
                            $(this).val(0);

                        }  
                        i++;
                   }); 

                   //SE ACTUALIZA EL TOTAL ACUMULADO

                   $("#lbl_acumevaluacion").text('');
                    acumulado = 0;

                    $('input[name^="pesoevaluacion"]').each(function() {

                        if ($(this).val()!= ''){

                            acumulado = parseInt(acumulado) + parseInt($(this).val());
                        }


                    });


                    $("#lbl_acumevaluacion").text(acumulado);

                    if (acumulado > 0 && acumulado < 100){
                        $("#lbl_acumevaluacion").css("color", "black");
                        $("#a_AgregarEvaluacion").css("display", "block");
                    }
                    else{
                        if (acumulado > 100){
                            $("#lbl_acumevaluacion").css("color", "red");
                            $("#a_AgregarEvaluacion").css("display", "none");
                        }
                        else{
                            $("#lbl_acumevaluacion").css("color", "green");
                            $("#a_AgregarEvaluacion").css("display", "none");
                        }
                    }

                    
               }
               else{
                   //SI NO HAY DATOS DE PLANIFICACI�N

               }
               $("#preloader").css("display", "none");
            });
      
        //}
          
    });    
    
    
});
