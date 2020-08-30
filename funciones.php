<?php


function ConsultarEvaluacionDocente(&$nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "MAX(eval002d_estatus) as estatus";
    $from = "sce2000.eval002d";
    $where = "eval002d_responsable = '" . $cedulaDocente . "' " . 
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".  
             "AND eval002d_cod_sede = '" . $sede . "' ".
             "AND eval002d_cod_carr = '" . $carrera . "' ".
             "AND eval002d_seccion= '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
    $groupby="";
    $orderby="";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function GetStatusCarga(){
    $select="realizando_cierre as habilitado";
    $from = "sce2000.sce999d";
    $where="";
    $groupby="";
    $orderby="";

    $nro=0;
    $habilitado = Consultar($nro,$from,$select,$where,$groupby,$orderby);

    
    return $habilitado;
    
}


function ConsultarMaxObjecion(&$nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
 
    $select = "DISTINCT eval002d_cedula_est";
    $from = "sce2000.eval002d";
    $where = "eval002d_cod_sede = '" . $sede . "' " .
             "AND eval002d_cod_carr = '" . $carrera . "' " . 
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
	     "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " .
	     "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
             "AND eval002d_responsable = '" . $cedulaDocente . "' ".
	     "AND eval002d_objecion = 1";

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }    
    
}


function ConsultarFechaHoraReporte(){
 
    $select = "MAX(eval006d_fechahora) AS eval006d_fechahora";
    $from = "sce2000.eval006d";
    $where = "";

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }    
    
}

function BorrarRegistroPlanAsignaturaDocente($ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    
    //CONSULTAR SI HAY NOTAS CARGADAS
    
    $select = "eval002d_nota110 ";
    $from = "sce2000.eval002d ";
    $where = "eval002d_responsable = '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede ='" . $sede . "' ".
          "AND eval002d_cod_carr ='" . $carrera . "' ".
          "AND eval002d_seccion = '" .  $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " " .
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,"","");
                
    if ($nro > 0){	
         return 0; //HAY NOTAS CARGADAS. NO SE PUEDE BORRAR EL PLAN
    }
    else{
          //borrado del plan de evaluacion
        $tabla ="sce2000.eval001d";

        $where = "eval001d_cedula_docente =  '" . $ceduladoc . "' " .
          "AND eval001d_lapso_academico = '" . $lapsoacademico . "' " .
          "AND eval001d_cod_sede = '" . $sede . "' ".
          "AND eval001d_cod_carrera =   '" . $carrera . "' ".
          "AND eval001d_cod_seccion = '" . $seccion . "' ".
          "AND eval001d_cod_asignatura = " . $asignatura . " ".
          "AND eval001d_lapso_vigencia = '" . $lapsovigencia . "' ";
    
        Ejecutar(3,$tabla,"","",$where);
        return 1;
    }
    
    
    
    
}


function BorrarRegistroNotasAsignaturaDocente($ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    
    //borrado de las notas registradas
    $tabla ="sce2000.eval002d";

    $where = "eval002d_responsable =  '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede = '" . $sede . "' ".
          "AND eval002d_cod_carr =   '" . $carrera . "' ".
          "AND eval002d_seccion = '" . $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " ".
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
    
    Ejecutar(3,$tabla,"","",$where);
    
   
    //DESBLOQUEO DEL PLAN DE EVALUACION
    
    $tabla = "sce2000.eval001d";
    $campos_set="eval001d_status";
    $set = '1';
    $where = "eval001d_cedula_docente =  '" . $ceduladoc . "' " .
          "AND eval001d_lapso_academico = '" . $lapsoacademico . "' " .
          "AND eval001d_cod_sede = '" . $sede . "' ".
          "AND eval001d_cod_carrera =   '" . $carrera . "' ".
          "AND eval001d_cod_seccion = '" . $seccion . "' ".
          "AND eval001d_cod_asignatura = " . $asignatura . " ".
          "AND eval001d_lapso_vigencia = '" . $lapsovigencia . "' ";
      
    Ejecutar(2,$tabla,$campos_set,$set,$where);
    
    
}


function ConsultarEstudiantesConNotas(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    //2019
 
    $select = "DISTINCT eval002d_cedula_est,eval002d_nota110 ";
    $from = "sce2000.eval002d ";
    $where = "eval002d_responsable = '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede ='" . $sede . "' ".
          "AND eval002d_cod_carr ='" . $carrera . "' ".
          "AND eval002d_seccion = '" .  $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " " .
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ".
          "AND eval002d_nota110 > 0"  ;
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}

function ConsultarEstudiantesNotas(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    //2019
 
    $select = "DISTINCT eval002d_cedula_est,eval002d_nota110 ";
    $from = "sce2000.eval002d ";
    $where = "eval002d_responsable = '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede ='" . $sede . "' ".
          "AND eval002d_cod_carr ='" . $carrera . "' ".
          "AND eval002d_seccion = '" .  $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " " .
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "'";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}


function ConsultarEstudiantesNotasPromedioMaxMin(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    //2019
 
    $select = "DISTINCT AVG(eval002d_nota110) AS promedio, MAX(eval002d_nota110) AS maxnota, MIN(eval002d_nota110) AS minnota ";
    $from = "sce2000.eval002d ";
    $where = "eval002d_responsable = '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede ='" . $sede . "' ".
          "AND eval002d_cod_carr ='" . $carrera . "' ".
          "AND eval002d_seccion = '" .  $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " " .
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ".
          "AND eval002d_nota110 > 0";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}

function ConsultarEstudiantesAprob(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$minaprob){
    //2019
 
    $groupby="";
    $orderby="";
    
    $select = "DISTINCT eval002d_cedula_est ";
    $from = "sce2000.eval002d ";
    $where = "eval002d_responsable = '" . $ceduladoc . "' " .
          "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' " .
          "AND eval002d_cod_sede ='" . $sede . "' ".
          "AND eval002d_cod_carr ='" . $carrera . "' ".
          "AND eval002d_seccion = '" .  $seccion . "' ".
          "AND eval002d_cod_asignatura = " . $asignatura . " " .
          "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " .
          "AND eval002d_nota110 >= " . $minaprob;
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}


function ConsultarSemanaEvaluacion($id_evaluacion){
    //2019
    $semevaluacion = "";
    
    $select = "eval002d_Sem_Aplicacion";
    $from = "eval002d";
    $where = "eval002d_id_evaluacion = '" . $id_evaluacion . "' ";
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
       $semevaluacion = trim($datos[0]['eval002d_Sem_Aplicacion']);
       
    }
    
        
    return $semevaluacion;
}


function Consultar_Asig_Lapso_Docente_2(&$nro,$lapso,$docente){
   //2019
    
   $select = "DISTINCT sce080d_nom_carr,sce090d_nom_asign,eval001d_cod_seccion,eval001d_lapso_vigencia,eval001d_cod_carrera,eval001d_cod_asignatura,eval001d_cod_sede, eval001d_lapso_academico as lapso ,eval001d_cedula_docente,sce025d_descripcion,nombre,sce110d_semestre ";
   $from = "sce2000.eval001d,sce2000.sce080d,sce2000.sce090d,sce2000.sce025d,sce2000.sce058d,sce2000.sce110d ";
   $where = "eval001d_cedula_docente = '" . $docente . "'
		AND eval001d_lapso_academico = '" . $lapso . "'
		AND eval001d_lapso_vigencia  =  sce110d_lapso_vigencia
		AND CAST(eval001d_cod_asignatura AS VARCHAR)  =  sce110d_cod_asign
		AND eval001d_cod_carrera  =  sce110d_cod_carr
		AND eval001d_cedula_docente = cedula 
		AND eval001d_cod_sede  =  sce025d_codigo_sede
		AND eval001d_cod_carrera  =  sce080d_cod_carr
		AND CAST(eval001d_cod_asignatura AS VARCHAR)  =  sce090d_cod_asign";
		
    $orderby = "sce090d_nom_asign,sce080d_nom_carr,eval001d_cod_seccion";
           
   $groupby="";
   
   $nro=0;
   $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
   if ($nro > 0){	
        return $rs;
   }
   else{
       return 0;
   }
  
}



function NumeroLetras($numero){   
   switch ($numero){
      case '0':
         $numero = "-";
		 break;
      case '1':
         $numero = "UNO";
		 break;
      case '2':
         $numero = "DOS";
		 break;
      case '3':
         $numero = "TRES";
		 break;
      case '4':
         $numero = "CUATRO";
		 break;
      case '5':
         $numero = "CINCO";
		 break;
      case '6':
         $numero = "SEIS";
		 break;
      case '7':
         $numero = "SIETE";
		 break;
      case '8':
         $numero = "OCHO";
		 break;
      case '9':
         $numero = "NUEVE";
		 break;
      case '10':
         $numero = "DIEZ";
		 break;
      case '11':
         $numero = "ONCE";
		 break;
      case '12':
         $numero = "DOCE";
		 break;
      case '13':
         $numero = "TRECE";
		 break;
      case '14':
         $numero = "CATORCE";
		 break;
      case '15':
         $numero = "QUINCE";
		 break;
      case '16':
         $numero = "DIECISÉIS";
		 break;
      case '17':
         $numero = "DIECISIETE";
		 break;
      case '18':
         $numero = "DIECIOCHO";
		 break;
      case '19':
         $numero = "DIECINUEVE";
		 break;
      case '20':
         $numero = "VEINTE";
		 break;
      case '21':
         $numero = "VEINTIUNO";
		 break; 
      case '22':
         $numero = "VEINTIDÓS";
		 break; 
      case '23':
         $numero = "VEINTITRES";
		 break;            
      case '24':
         $numero = "VEINTICUATRO";
		 break;       
      case '25':
         $numero = "VEINTICINCO";
		 break;       
       
   }
   return($numero);   
}


function GetNameDocente($cedula_docente){
  $name="";
  // begin Recordset
  $nro=0;
  $rs =  Consultar($nro,"sce058d","nombre","cedula = '" . $cedula_docente . "'"); 
  // end Recordset
  if ($nro > 0){
     $name = trim($rs[0]['nombre']);
  }
  $rs=0;
  return $name;
}

function GetNombreSede($cod_sede){
  $name="";
  // begin Recordset
  $nro=0;
  $rs =  Consultar($nro,"sce025d","Distinct sce025d_descripcion","sce025d_codigo_sede = '" . $cod_sede . "'"); 
  // end Recordset
  if ($nro > 0) 
     $name = trim($rs[0]['sce025d_descripcion']);		
  $rs=0;	   
  return $name;
}


function ConsultarPlanificacionDocente(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura){
    
    
    $select = "eval001d_producto,eval001d_actividad,eval001d_criterio,eval003d_descripcion,eval001d_ponderacion,eval001d_sem_planificacion,eval001d_status";
    $from  = "sce2000.eval001d,sce2000.eval003d";
    $where = "eval001d_instrumento = eval003d_id_instrumento ".
          "AND eval001d_cedula_docente =  '" . $ceduladoc . "' " .
          "AND eval001d_lapso_academico = '" . $lapsoacademico . "' " .
          "AND eval001d_cod_sede = '" . $sede . "' ".
          "AND eval001d_cod_carrera =   '" . $carrera . "' ".
          "AND eval001d_cod_seccion = '" . $seccion . "' ".
          "AND eval001d_cod_asignatura = " . $asignatura;
    $groupby="";
    $orderby="cast(eval001d_sem_planificacion as int)";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
}


function GetAcumuladoCarrera_Plan (&$nro,$carrera,$lapso,$sede){
    
    $select = "eval008d_nombrecarr,sum(eval008d_completado) as eval008d_completado,sum(eval008d_mayor50) as eval008d_mayor50,sum(eval008d_menor50) as eval008d_menor50,sum(eval008d_sinavance) as eval008d_sinavance";
    $from = "sce2000.eval008d";
    $where = "eval008d_codsede = '" . $sede . "' AND eval008d_codcarr = '" . $carrera . "' AND eval008d_lapso = '" . $lapso . "'";

    $groupby = "eval008d_nombrecarr";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function GetAcumuladoCarrera (&$nro,$carrera,$lapso,$sede){
    
    $select = "eval006d_nombrecarr,sum(eval006d_completado) as eval006d_completado,sum(eval006d_mayor50) as eval006d_mayor50,sum(eval006d_menor50) as eval006d_menor50,sum(eval006d_sinavance) as eval006d_sinavance";
    $from = "sce2000.eval006d";
    $where = "eval006d_codsede = '" . $sede . "' AND eval006d_codcarr = '" . $carrera . "' AND eval006d_lapso = '" . $lapso . "'";

    $groupby = "eval006d_nombrecarr";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function GetAcumuladoEvaluacionDocenteAsignatura_Plan (&$nro,$sede,$carrera,$lapso){
    
    $select = "eval008d_ceduladoc,eval008d_nombredoc,eval008d_codasign,eval008d_nombreasign,eval008d_seccion,eval008d_ponderacion ";
    $from = "sce2000.eval008d";
    $where = "eval008d_codsede = '" . $sede . "' AND eval008d_codcarr = '" . $carrera . "' AND eval008d_lapso = '" . $lapso . "'";

    $groupby = "";
    $orderby = "eval008d_nombredoc,eval008d_nombreasign,eval008d_seccion"; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}



function GetAcumuladoEvaluacionDocenteAsignatura (&$nro,$sede,$carrera,$lapso){
    
    $select = "eval006d_ceduladoc,eval006d_nombredoc,eval006d_codasign,eval006d_nombreasign,eval006d_seccion,eval006d_ponderacion ";
    $from = "sce2000.eval006d";
    $where = "eval006d_codsede = '" . $sede . "' AND eval006d_codcarr = '" . $carrera . "' AND eval006d_lapso = '" . $lapso . "'";

    $groupby = "";
    $orderby = "eval006d_nombredoc,eval006d_nombreasign,eval006d_seccion"; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function GetAcumuladoSede_plan (&$nro,$lapso,$sede){
    
    $select = "eval008d_nombresede,sum(eval008d_completado) as eval008d_completado,sum(eval008d_mayor50) as eval008d_mayor50,sum(eval008d_menor50) as eval008d_menor50,sum(eval008d_sinavance) as eval008d_sinavance";
    $from = "sce2000.eval008d";
    $where = "eval008d_codsede = '" . $sede . "'" . " AND eval008d_lapso = '" . $lapso . "'";

    $groupby = "eval008d_nombresede";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function GetAcumuladoSede (&$nro,$lapso,$sede){
    
    $select = "eval006d_nombresede,sum(eval006d_completado) as eval006d_completado,sum(eval006d_mayor50) as eval006d_mayor50,sum(eval006d_menor50) as eval006d_menor50,sum(eval006d_sinavance) as eval006d_sinavance";
    $from = "sce2000.eval006d";
    $where = "eval006d_codsede = '" . $sede . "'" . " AND eval006d_lapso = '" . $lapso . "'";

    $groupby = "eval006d_nombresede";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function ConsultarLapsosCargadosPlanificacion(&$nro){
    
    
    $select = "DISTINCT eval001d_lapso_academico ";
    $from = "sce2000.eval001d ";
    
    $orderby = "eval001d_lapso_academico";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}


function ConsultarProductosActa(&$nro,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$idproductosdef){
   
    $select = "DISTINCT eval002d_id_evaluacion,eval001d_producto,eval001d_ponderacion,eval001d_sem_planificacion";
    $from = "sce2000.eval002d,sce2000.eval001d";

    $where = "eval001d_id_evaluacion = eval002d_id_evaluacion " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' ".
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " .  
             "AND eval002d_id_evaluacion IN(". $idproductosdef . ")";

    $groupby="";
    $orderby="cast(eval001d_sem_planificacion as int),eval002d_id_evaluacion ASC ";        
     
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}

function ConsultarEstudiantesActa(&$nro,$idacta,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia,$idproductosdef){
   
    
    if ($idacta == 1){
        $select = "DISTINCT eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_definitiva,eval002d_nota110,eval002d_nroacta ";
        $from = "sce2000.sce049d,sce2000.eval002d";

        $where = "eval002d_cedula_est = cedula ".
                 "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                 "AND eval002d_cod_sede = '" . $sede . "' ". 
                 "AND eval002d_cod_carr = '" . $carrera . "' ".
                 "AND eval002d_seccion = '" . $seccion . "' ".
                 "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                 "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";

        $groupby="";
        $orderby="primer_apellido,segundo_apellido,primer_nombre,segundo_nombre ASC ";
    }
    else{
        $select = "eval002d_id_evaluacion,eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_nota,eval002d_definitiva,eval002d_nota110,eval002d_nroacta ";
        $from = "sce2000.sce049d,sce2000.eval002d,sce2000.eval001d";

        $where = "eval001d_id_evaluacion = eval002d_id_evaluacion ".
                 "AND eval002d_cedula_est = cedula ".
                 "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                 "AND eval002d_cod_sede = '" . $sede . "' ". 
                 "AND eval002d_cod_carr = '" . $carrera . "' ".
                 "AND eval002d_seccion = '" . $seccion . "' ".
                 "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                 "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " . 
                 "AND eval002d_id_evaluacion IN(". $idproductosdef . ")";

        $groupby="";
        $orderby="primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,cast(eval001d_sem_planificacion as int),eval002d_id_evaluacion ASC ";        
        
    }
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function ConsultarLapsosCargadosEvaDocente(&$nro,$ceduladoc){
    
    
    $select = "DISTINCT replace(sce016d_alias_largo,'-','') as lapsofront, eval002d_lapsoacademico ";
    $from = "sce2000.eval002d,sce2000.eval001d, sce2000.sce016d ";
    $where = "eval001d_cedula_docente = '" . $ceduladoc . "' ".
            "AND eval001d_id_evaluacion = eval002d_id_evaluacion " . 
            "AND  eval001d_lapso_academico = sce016d_lapso_acad " .
            "AND  eval002d_lapsoacademico = sce016d_lapso_acad ";
    $orderby = "CAST(eval002d_lapsoacademico as int)";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}


function ConsultarLapsoCIVA(&$nro){
    
    
    $select = "DISTINCT REPLACE(sce016d_alias,' ','') as lapso ";
    $from = "sce2000.sce016d ";
    $where = "sce016d_anno = datepart(year, getdate()) AND left(sce016d_alias,4)='CIVA'";
    $groupby = "";
    $orderby = "";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}
 
 

function ConsultarLapsosCargadosDocente(&$nro,$ceduladoc){
 
    $select = "DISTINCT replace(sce016d_alias_largo,'-','') as lapsofront, eval001d_lapso_academico as lapsoback ";
    $from = "sce2000.eval001d,sce2000.sce016d ";
    $where = "eval001d_lapso_academico = sce016d_lapso_acad AND eval001d_cedula_docente = '" . $ceduladoc . "'";
    $orderby = "eval001d_lapso_academico";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
}


function ConsultarProductosAprobadoDocente(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    
    
    $select = "eval001d_id_evaluacion,eval001d_producto,eval001d_ponderacion,eval001d_sem_planificacion";
    $from  = "sce2000.eval001d";
    $where = "eval001d_cedula_docente =  '" . $ceduladoc . "' " .
          "AND eval001d_lapso_academico = '" . $lapsoacademico . "' " .
          "AND eval001d_cod_sede = '" . $sede . "' ".
          "AND eval001d_cod_carrera =   '" . $carrera . "' ".
          "AND eval001d_cod_seccion = '" . $seccion . "' ".
          "AND eval001d_cod_asignatura = " . $asignatura . " ".
          "AND eval001d_lapso_vigencia = '" . $lapsovigencia . "' " .
          "AND eval001d_status = 2";
    $groupby="";
    $orderby="cast(eval001d_sem_planificacion as int)";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
}



function ConsultarLapsoUnidadCarreraSeccionSedePlan(&$nro,$cedula,$lapso,$asignatura,$carrera,$seccion){

    $select = "DISTINCT eval001d_cod_sede";
    $from = "sce2000.eval001d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' " .
             "AND eval001d_lapso_academico = '" . $lapso . "' " .
             "AND eval001d_cod_asignatura = '" . $asignatura . "' " .
             "AND eval001d_cod_seccion = '" . $seccion . "' " .
             "AND eval001d_cod_carrera = " . $carrera;

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function ConsultarLapsoUnidadCarreraSeccionSedeVigenciaPlan(&$nro,$cedula,$lapso,$asignatura,$carrera,$seccion){

    $select = "DISTINCT eval001d_lapso_vigencia";
    $from = "sce2000.eval001d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' " .
             "AND eval001d_lapso_academico = '" . $lapso . "' " .
             "AND eval001d_cod_asignatura = '" . $asignatura . "' " .
             "AND eval001d_cod_seccion = '" . $seccion . "' " .
             "AND eval001d_cod_carrera = " . $carrera;

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}



function ConsultarLapsoUnidadCarreraSeccionPlan(&$nro,$cedula,$lapso,$asignatura,$carrera){

    $select = "DISTINCT eval001d_cod_seccion";
    $from = "sce2000.eval001d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' " .
             "AND eval001d_lapso_academico = '" . $lapso . "' " .
             "AND eval001d_cod_asignatura = '" . $asignatura . "' " .
             "AND eval001d_cod_carrera = " . $carrera;

    $groupby = "";
    $orderby = "eval001d_cod_seccion"; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function ConsultarLapsoUnidadCarreraPlan(&$nro,$cedula,$lapso,$asignatura){

     
    
    $select = "DISTINCT eval001d_cod_carrera,sce080d_nom_carr";
    $from = "sce2000.eval001d,sce2000.sce080d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' " .
             "AND eval001d_lapso_academico = '" . $lapso . "' " .
             "AND eval001d_cod_asignatura = '" . $asignatura . "' " .
             "AND sce080d_cod_carr = eval001d_cod_carrera";

    $groupby = "";
    $orderby = "sce080d_nom_carr"; 
    
   
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function ConsultarLapsoUnidadPlan(&$nro,$cedula,$lapso,$asignatura){

    $select = "DISTINCT eval001d_cod_asignatura,cast(eval001d_cod_asignatura as varchar) + '-' + sce090d_nom_asign as  sce090d_nom_asign";
    $from = "sce2000.eval001d,sce2000.sce090d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' " .
             "AND eval001d_lapso_academico = '" . $lapso . "' " .
             /*"AND eval001d_cod_asignatura = " . $asignatura . " ".*/
             "AND sce090d_cod_asign = CAST(eval001d_cod_asignatura AS VARCHAR)";

    $groupby = "";
    $orderby = "sce090d_nom_asign"; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function ConsultarLapsoPlan(&$nro,$cedula,$asignatura){
    
    $select = "DISTINCT replace(sce016d_alias_largo,'-','') as lapsofront, eval001d_lapso_academico ";
    $from = "sce2000.eval001d,sce2000.sce016d ";
    $where = "eval001d_lapso_academico = sce016d_lapso_acad AND eval001d_cedula_docente = '" . $cedula . "' ";
             
    $groupby = "";
    $orderby = "eval001d_lapso_academico"; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function ConsultarNroEncuentro(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "MAX(eval005d_encuentro) as encuentro";
    $from = "sce2000.eval005d";
    $where = "eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " ".
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' ";
                 
    $groupby="";
    $orderby="";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function formatearFecha($fecha){
	$fecha=implode("/", array_reverse(explode("-", $fecha)));
	return $fecha;
}


function GetAcumuladoPlanificacionDocenteCarrera (&$nro,$cedula,$carrera,$lapso,$sede){
    
    $select = "sce090d_nom_asign,eval001d_cod_seccion,sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d,sce2000.sce090d";
    $where = "eval001d_status <> 9 AND sce090d_cod_asign = CAST(eval001d_cod_asignatura AS VARCHAR) AND eval001d_cod_sede = '" . $sede . "' AND eval001d_cod_carrera = '" . $carrera . "' AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

    $groupby = "sce090d_nom_asign,eval001d_cod_seccion";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}

function GetAcumuladoPlanificacionDocenteAsignatura (&$nro,$cedula,$asignatura,$seccion,$sede,$lapso){
    
    $select = "sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d";
    $where = "eval001d_cod_sede = '" . $sede . "' AND eval001d_cod_seccion = '" . $seccion . "' AND eval001d_cod_asignatura = '" . $asignatura . "' AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}



function Docentes_Sede_Carrera_Asignatura_Plan(&$nro,$sede,$carrera,$lapso){
    
      $select = "sce070d_cedula_doc,nombre,sce070d_cod_asign,sce090d_nom_asign,sce070d_seccion,sce070d_sede";
      $from = "sce2000.sce070d,sce2000.sce090d,sce2000.sce058d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND cedula = sce070d_cedula_doc AND sce070d_cod_asign = sce090d_cod_asign AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
      $groupby = "";
      $orderby = "nombre,sce070d_cod_asign,sce070d_seccion"; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

      
function Docentes_Sede_Carrera_Asignatura(&$nro,$sede,$carrera,$lapso){
    
    
      $select="DISTINCT eval006d_codcarr,eval006d_nombrecarr";
     $from = "eval006d";
     $where="eval006d_codsede = '" . $sede . "'";
     $groupby="";
     $orderby="eval006d_nombrecarr";
    
    
      $select = "eval006d_ceduladoc,nombre,sce070d_cod_asign,sce090d_nom_asign,sce070d_seccion,sce070d_sede";
      $from = "eval006d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND cedula = sce070d_cedula_doc AND sce070d_cod_asign = sce090d_cod_asign AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
      $groupby = "";
      $orderby = "nombre,sce070d_cod_asign,sce070d_seccion"; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}


function Secciones_Sede_Carrera_Plan(&$nro,$sede,$carrera,$lapso){
           
    
      $select = "COUNT(eval008d_codasign) as acumasig";
      $from = "sce2000.eval008d";
      $where = "eval008d_lapso = '" . $lapso . "' AND eval008d_codcarr = '" . $carrera . "' AND eval008d_codsede = '" . $sede . "'";
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}


function Secciones_Sede_Carrera(&$nro,$sede,$carrera,$lapso){
           
    
      $select = "COUNT(eval006d_codasign) as acumasig";
      $from = "sce2000.eval006d";
      $where = "eval006d_lapso = '" . $lapso . "' AND eval006d_codcarr = '" . $carrera . "' AND eval006d_codsede = '" . $sede . "'";
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

function Asignaturas_Sede(&$nro,$sede,$lapso){
    
        
    
      $select = "COUNT(sce070d_cod_asign) as acumasig";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}



function Asignaturas_secciones_plan(&$nro,$sede,$lapso){
    
        
    
      /*$select = "COUNT(sce070d_cod_asign) as acumasig";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";*/
      
      $select = "COUNT(eval008d_codasign) as acumasig";
      $from = "sce2000.eval008d";
      $where = "eval008d_lapso = '" . $lapso . "' AND eval008d_codsede = '" . $sede . "'";
      
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

function Asignaturas_secciones(&$nro,$sede,$lapso){
    
        
    
      /*$select = "COUNT(sce070d_cod_asign) as acumasig";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";*/
      
      $select = "COUNT(eval006d_codasign) as acumasig";
      $from = "sce2000.eval006d";
      $where = "eval006d_lapso = '" . $lapso . "' AND eval006d_codsede = '" . $sede . "'";
      
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}


function Asignaturas_Sede_Carrera(&$nro,$sede,$carrera,$lapso){
           
    
      $select = "COUNT(sce070d_cod_asign) as acumasig";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

function Docentes_Sede_Carrera(&$nro,$sede,$carrera,$lapso){
    
      $select = "DISTINCT sce070d_cedula_doc,nombre";
      $from = "sce2000.sce070d,sce2000.sce058d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_cedula_doc = cedula  AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

function Consultar_Carrera_Sede_Plan(&$nro,$sede){
    
     $select="DISTINCT sce085d_cod_carr, sce080d_nom_carr";
     $from = "sce080d,sce085d";
     $where="sce080d_cod_carr = sce085d_cod_carr AND sce085d_cod_sede = '" . $sede . "'";
     $groupby="";
     $orderby="sce080d_nom_carr";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }
    
}


function Consultar_Carrera_Sede_Plan2(&$nro,$sede){
    
     $select="DISTINCT eval008d_codcarr,eval008d_nombrecarr";
     $from = "eval008d";
     $where="eval008d_codsede = '" . $sede . "'";
     $groupby="";
     $orderby="eval008d_nombrecarr";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }
    
}


function Consultar_Carrera_Sede(&$nro,$sede){
    
     $select="DISTINCT eval006d_codcarr,eval006d_nombrecarr";
     $from = "eval006d";
     $where="eval006d_codsede = '" . $sede . "'";
     $groupby="";
     $orderby="eval006d_nombrecarr";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }
    
}


function GetAcumuladoPlanificacionDocenteDetallado (&$nro,$cedula,$lapso,$sede){
    
    $select = "sce090d_nom_asign,eval001d_cod_seccion,sum(eval001d_ponderacion) as acum,eval001d_cod_carrera,eval001d_cod_sede";
    $from = "sce2000.eval001d,sce2000.sce090d";
    $where = "eval001d_status <> 9 AND sce090d_cod_asign = CAST(eval001d_cod_asignatura AS VARCHAR) AND eval001d_cod_sede = '" . $sede . "'" . " AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

    $groupby = "sce090d_nom_asign,eval001d_cod_seccion,eval001d_cod_carrera,eval001d_cod_sede";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function GetAcumuladoPlanificacionDocente ($cedula,$lapso){
    
    $select = "sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d";
    $where = "eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

    $groupby = "";
    $orderby = ""; 
      
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        return $datos;
       
    }
    else{
              
        return 0;
    }
    
}


function Docentes_Sede_Plan(&$nro,$lapso,$sede){
    
      $select = "DISTINCT sce070d_cedula_doc";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";

    
      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}


function Docentes_Sede(&$nro,$lapso,$sede){
    
      /*$select = "DISTINCT sce070d_cedula_doc";
      $from = "sce2000.sce070d";
      $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";*/

      $select = "DISTINCT eval006d_ceduladoc";
      $from = "sce2000.eval006d";
      $where = "eval006d_lapso = '" . $lapso . "' AND eval006d_codsede = '" . $sede . "'";

      $groupby = "";
      $orderby = ""; 
      
      $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
      if ($nro > 0){
        
            return $datos;
       
      }
      else{
               
            return 0;
      }
      
      
}

function Consultar_Sede(&$nro){
       
    $select = "sce025d_codigo_sede,sce025d_descripcion";
    $from = "sce2000.sce025d";
    $where = "";
    $groupby = "";
    $orderby = "sce025d_descripcion";       
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
       return $datos;
       
    }
    else{
               
       return 0;
    }
        
   
}



function ActualizarStatusPlanEvaluacion($ideval){
   
    $tabla = "sce2000.eval001d";
    $campos_set="eval001d_status";
    $set = '0';
    $where = "eval001d_id_evaluacion = '". $ideval . "'";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
    
}

function ActualizarStatusEvaluacion($ideval){

   
    $tabla = "sce2000.eval002d";
    $campos_set="eval002d_estatus";
    $set = '2';
    $where = "eval002d_id_evaluacion = '". $ideval . "'";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
    
}

function AsistenciaEstudianteEvaluacion($asistio,$tipo){
    
    if($tipo == 1){
        
        if ($asistio == '1'){
            $asistio = "";
        }
        else{
            $asistio = "disabled";
        }
    }
    
    if($tipo == 2){
        if ($asistio == '1'){
            $asistio = "checked";
        }
        else{
            $asistio = "unchecked";
        }
            
    }
    
    return $asistio;
    
}

function ConsultarEstudiantesPonderacion(&$nro,$ideval,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    
if($carrera != '0'){  // si no es unidad curricular de desarrollo humano
    
    $select = "eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_nota,CAST(eval002d_no_asistio AS INT),eval002d_objecion ". 
              "FROM( ".
              "select DISTINCT eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_nota,eval002d_no_asistio,eval002d_objecion";
    $from = "sce2000.sce049d,sce2000.eval002d";
    $where = "eval002d_cedula_est = cedula ".
                "AND eval002d_id_evaluacion = '" . $ideval . "' ".
                "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                "AND eval002d_cod_sede = '" . $sede . "' ". 
                "AND eval002d_cod_carr = '" . $carrera . "' ".
                "AND eval002d_seccion = '" . $seccion . "' ".
                "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " .

             "UNION ".

             "select sce020d_cedula AS eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre, 0 AS eval002d_nota,0 as eval002d_no_asistio,0 as eval002d_objecion " .
             "from sce2000.sce020d,sce2000.sce049d " .
             "where  sce020d_lapso = '" . $lapsoacademico . "' ".
             "AND sce020d_cod_sede = '" . $sede . "' ".
             "AND sce020d_cod_carr = '" . $carrera . "' ".
             "AND sce020d_seccion = '" . $seccion . "' ".
             "AND sce020d_cod_asign = '" . $asignatura . "' ".
             "AND sce020d_lapso_vigencia = '" . $lapsovigencia . "' " .
             "AND sce020d_cedula = cedula ".
             "AND sce020d_cedula NOT IN (select eval002d_cedula_est ".
                                         "from sce2000.sce049d,sce2000.eval002d ".
                                         "where eval002d_cedula_est = cedula ".
                                                    "AND eval002d_id_evaluacion = '" . $ideval . "' ".
                                                    "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                                                    "AND eval002d_cod_sede = '" . $sede . "' ". 
                                                    "AND eval002d_cod_carr = '" . $carrera . "' ".
                                                    "AND eval002d_seccion = '" . $seccion . "' ".
                                                    "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                                                    "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' )".
                                          ") AS CONSULTA ";
    $orderby="primer_apellido,segundo_apellido,primer_nombre,segundo_nombre ASC ";
    
}
else{
    
    $select = "eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_nota,CAST(eval002d_no_asistio AS INT),eval002d_objecion ". 
              "FROM( ".
              "select DISTINCT eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,eval002d_nota,eval002d_no_asistio,eval002d_objecion";
    $from = "sce2000.sce049d,sce2000.eval002d";
    $where = "eval002d_cedula_est = cedula ".
                "AND eval002d_id_evaluacion = '" . $ideval . "' ".
                "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                "AND eval002d_cod_sede = '" . $sede . "' ". 
                "AND eval002d_cod_carr = '" . $carrera . "' ".
                "AND eval002d_seccion = '" . $seccion . "' ".
                "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " .

             "UNION ".

             "select sce020d_cedula AS eval002d_cedula_est,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre, 0 AS eval002d_nota,0 as eval002d_no_asistio,0 as eval002d_objecion " .
             "from sce2000.sce020d,sce2000.sce049d " .
             "where  sce020d_lapso = '" . $lapsoacademico . "' ".
             "AND sce020d_cod_sede = '" . $sede . "' ".
             //"AND sce020d_cod_carr = '" . $carrera . "' ".
             "AND sce020d_seccion = '" . $seccion . "' ".
             "AND sce020d_cod_asign = '" . $asignatura . "' ".
             "AND sce020d_lapso_vigencia = '" . $lapsovigencia . "' " .
             "AND sce020d_cedula = cedula ".
             "AND sce020d_cedula NOT IN (select eval002d_cedula_est ".
                                         "from sce2000.sce049d,sce2000.eval002d ".
                                         "where eval002d_cedula_est = cedula ".
                                                    "AND eval002d_id_evaluacion = '" . $ideval . "' ".
                                                    "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
                                                    "AND eval002d_cod_sede = '" . $sede . "' ". 
                                                    "AND eval002d_cod_carr = '" . $carrera . "' ".
                                                    "AND eval002d_seccion = '" . $seccion . "' ".
                                                    "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
                                                    "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' )".
                                          ") AS CONSULTA ";
    $orderby="primer_apellido,segundo_apellido,primer_nombre,segundo_nombre ASC ";
    
}
    
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}

function GuardarPonderacionObjetada($msg,$ideval,$cedula,$expediente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$poderacion,$definitiva,$abandono,$asistio,$cedulaDocente,$nroacta,$semana,$fecha_proceso,$fecha_act,$cedulaDocenteact,$estatus,$fechaevaluacion,$justificacion){

    BorrarNotas($ideval,$cedula,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia);
    
    $s_campos=$s_campos . "eval002d_id_evaluacion,eval002d_cedula_est,eval002d_expediente_est,eval002d_cod_carr,eval002d_cod_asignatura,eval002d_cod_sede,
        eval002d_seccion,eval002d_lapsoacademico,eval002d_lapsovigencia,eval002d_nota,eval002d_definitiva,eval002d_abandono,eval002d_no_asistio,
    eval002d_responsable,eval002d_nroacta,eval002d_sem_aplicacion,eval002d_fecha_registro,eval002d_fecha_ua,eval002d_resp_ua,eval002d_estatus,eval002d_fechaevaluacion,eval002d_justificacion,eval002d_objecion";

    $s_valores= $s_valores . "" . $ideval . ",'" . $cedula . "'," .$expediente. ",'" .$carrera. "'," .$asignatura. ",'" . 
            $sede. "','" .$seccion. "','" .$lapsoacademico. "','" .$lapsovigencia. "'," .$poderacion. "," . 
            $definitiva . ",'" .$abandono. "','" .$asistio. "','" .$cedulaDocente. "','" .$nroacta. "','" .
            $semana. "','" .$fecha_proceso. "','" .$fecha_act . "','" . $cedulaDocenteact . "','" . $estatus . "','" . $fechaevaluacion . "','" . $justificacion . "',1";

    $msg = Ejecutar(1,"eval002d",$s_campos,$s_valores,"");
 
 
  return $msg;
}


function GuardarPonderacion($msg,$ideval,$cedula,$expediente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$poderacion,$definitiva,$abandono,$asistio,$cedulaDocente,$nroacta,$semana,$fecha_proceso,$fecha_act,$cedulaDocenteact,$estatus,$fechaevaluacion,$justificacion){

    BorrarNotas($ideval,$cedula,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia);
    
    $s_campos=$s_campos . "eval002d_id_evaluacion,eval002d_cedula_est,eval002d_expediente_est,eval002d_cod_carr,eval002d_cod_asignatura,eval002d_cod_sede,
        eval002d_seccion,eval002d_lapsoacademico,eval002d_lapsovigencia,eval002d_nota,eval002d_definitiva,eval002d_abandono,eval002d_no_asistio,
    eval002d_responsable,eval002d_nroacta,eval002d_sem_aplicacion,eval002d_fecha_registro,eval002d_fecha_ua,eval002d_resp_ua,eval002d_estatus,eval002d_fechaevaluacion,eval002d_justificacion,eval002d_objecion";

    $s_valores= $s_valores . "" . $ideval . ",'" . $cedula . "'," .$expediente. ",'" .$carrera. "'," .$asignatura. ",'" . 
            $sede. "','" .$seccion. "','" .$lapsoacademico. "','" .$lapsovigencia. "'," .$poderacion. "," . 
            $definitiva . ",'" .$abandono. "','" .$asistio. "','" .$cedulaDocente. "','" .$nroacta. "','" .
            $semana. "','" .$fecha_proceso. "','" .$fecha_act . "','" . $cedulaDocenteact . "','" . $estatus . "','" . $fechaevaluacion . "','" . $justificacion . "',0";

    $msg = Ejecutar(1,"eval002d",$s_campos,$s_valores,"");
 
 
  return $msg;
}

function BorrarNotas($ideval,$cedulaest,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia){
    
    $tabla ="eval002d";

    $where = "eval002d_id_evaluacion = " . $ideval . " " .
             "AND eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";

    $msg = Ejecutar(3,$tabla,"","",$where);
     
 
}        

function GetNumeroActa($cedulaDocente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico){

    //actualizar nota definitiva
    $tabla = "sce2000.eval002d";
    $campos_set="eval002d_nroacta";
    $set = $lapsoacademico . $sede . $carrera. $asignatura . $seccion . time(); 
    $where = "eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura;
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);    
    
    return $set;
}

function GetNotaDefinitivaObjetada($cedulaest,$ceduladoc,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$idproductosdef){
    
    //consultar sumatoria nota
    
    $select = "SUM(eval002d_nota) as nota";
    $from = "eval002d";
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " . 
             "AND eval002d_id_evaluacion in(". $idproductosdef . ")";
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        $notadefinitiva = trim($datos[0]['nota']);
       
    }
    else{
            
        $notadefinitiva = 0; 
    }
       
    $notadefinitivabase10 = round($notadefinitiva/10,0);
    
    //actualizar nota definitiva
    $tabla = "sce2000.eval002d";
    $campos_set="eval002d_definitiva,eval002d_nota110,eval002d_objecion";
    $set = $notadefinitiva .",". $notadefinitivabase10 . ",1";
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
    
 
}


function GetNotaDefinitiva($cedulaest,$ceduladoc,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$idproductosdef){
    
    //consultar sumatoria nota
    
    $select = "SUM(eval002d_nota) as nota";
    $from = "eval002d";
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' " . 
             "AND eval002d_id_evaluacion in(". $idproductosdef . ")";
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        $notadefinitiva = trim($datos[0]['nota']);
       
    }
    else{
            
        $notadefinitiva = 0; 
    }
       
    $notadefinitivabase10 = round($notadefinitiva/10,0);
    
    //actualizar nota definitiva
    $tabla = "sce2000.eval002d";
    $campos_set="eval002d_definitiva,eval002d_nota110";
    $set = $notadefinitiva .",". $notadefinitivabase10;
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
    
 
}

function GetExpedienteEstudiante($cedula,$lapsoacademico,$carrera){
  $exp="";
  // begin Recordset
  $nro=0;
  $where = "sce020d_cedula ='" . $cedula . "' AND sce020d_cod_carr = '" . $carrera . "' AND sce020d_lapso = '" . $lapsoacademico . "' ";
  $rs =  Consultar($nro,"sce020d","DISTINCT sce020d_nro_expediente",$where,"","",0,0,$enlace); 
  // end Recordset
  if ($nro > 0) 
         $exp = trim($rs[0]['sce020d_nro_expediente']);
  else
         $exp = -1;	 		
  $rs=0;	   
  return $exp;
}

function ConsultarFechaEvaluacion($id_evaluacion){
    $fechaevaluacion = "";
    
    $select = "eval002d_fechaevaluacion";
    $from = "eval002d";
    $where = "eval002d_id_evaluacion = '" . $id_evaluacion . "' ";
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
       $fechaevaluacion = trim($datos[0]['eval002d_fechaevaluacion']);
       
    }
    
        
    return $fechaevaluacion;
}

function ConsultarStatusEvaluacion($id_evaluacion){
    $estatus = "";
    
    $select = "eval002d_estatus";
    $from = "eval002d";
    $where = "eval002d_id_evaluacion = '" . $id_evaluacion . "' ";
    $orderby = "eval002d_estatus";
            
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        $estatus = trim($datos[0]['eval002d_estatus']);
       
    }
    else{
        
        
        
       $estatus = 0; 
    }
        
   return $estatus;
    
}


function GetObjecion($objecion){
    $ruta = "";
    
    if ($objecion == '1'){
         $ruta = "<img id=\"Imagen\" name=\"Imagen[]\" src=\"../imagenes/check.png\" title=\"Estudiante Objetado\" height=\"30\" width=\"30\" class=\"ImagenObjetado\">";
    } 
    else{
         $ruta = "<img style=\"display:none;\" id=\"Imagen\" name=\"Imagen[]\" src=\"../imagenes/check.png\" title=\"Estudiante Objetado\" height=\"30\" width=\"30\" class=\"ImagenObjetado\">";
    }

    return $ruta;
    
}

function AgregarRutaEvaluacion($estatus){
    $ruta = "";
    
    if ($estatus == '1'){
         $ruta = "<img src=\"../imagenes/evaluacion_revision.png\" title=\"Evaluaci&oacute;n Transcrita\" class=\"TranscritaEvaluacion\" height=\"30\" width=\"30\">";
    } 
    else{
        if ($estatus == '2'){
            $ruta = "<img src=\"../imagenes/evaluacion_done.png\" title=\"Evaluaci&oacute;n Aprobada\" class=\"AprobadaEvaluacion\" height=\"30\" width=\"30\">";
        }
        else{
             if (($estatus == '3') || ($estatus == '4')){
                $ruta = "<img src=\"../imagenes/evaluacion_cerrada.png\" title=\"Evaluaci&oacute;n Cerrada CACE\" class=\"CerradaEvaluacion\" height=\"30\" width=\"30\">"; 
             }
             else{
                $ruta = "<img src=\"../imagenes/agregar_evaluacion.png\" title=\"Agregar Evaluaci&oacute;n\" class=\"AgregarEvaluacion\" height=\"30\" width=\"30\">"; 
             }
             
        }
    }    
   
    return $ruta;
    
}

function cargarcombo_area($cod_departamento,$cod_area){    
    $nro=0;
    $datos = Consultar_area($nro,$cod_departamento);
    $comboarea = "<select class=\"txtNormal\" name=\"cmb_area[]\" name=\"cmb_area\">\n".
                     "<option  value=\"00\">Seleccione...</option>\n";

    if ($nro > 0){	
        $i=0;                 
        while ($i<$nro) {
            if ($cod_area == trim($datos[$i]['cod_area_dpto'])){
                $comboarea = $comboarea. "<option selected value=" . trim($datos[$i]['cod_area_dpto']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_area'])))  . "</option>\n";
            } 
            else{
                $comboarea = $comboarea. "<option value=" . trim($datos[$i]['cod_area_dpto']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_area'])))  . "</option>\n";
            }
            $i++;

        }    
    }		            

    $comboarea = $comboarea. "</select>";

    return $comboarea;
}            


function Consultar_area(&$nro,$cod_departamento){
    
     $select="distinct cod_area_dpto,desc_area";
     $from = "sce059d";
     $where="cod_departamento = " . $cod_departamento;
     $groupby="";
     $orderby="cod_area_dpto ASC";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }    
    
}

function ActualizarCondicion($cedula,$coddepartamento,$codarea,$codcondicion){
    
    $tabla = "sce058d";
    $campos_set="cod_departamento,cod_area_dpto,cod_condicion";
    $set = $coddepartamento . "," . $codarea . "," . $codcondicion;
    $where = "cedula = '" . $cedula . "'";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
              
}



function cargarcombo_condiciondocente($cod_condicion){    
    $nro=0;
    $datos = Consultar_condiciondocente($nro);
    $combocondicion = "<select class=\"txtNormal\" name=\"cmb_condicion[]\" name=\"cmb_condicion\">\n".
                     "<option  value=\"0\">Seleccione...</option>\n";

    if ($nro > 0){	
        $i=0;                 
        while ($i<$nro) {
            if ($cod_condicion == trim($datos[$i]['cod_condicion'])){
                $combocondicion = $combocondicion. "<option selected value=" . trim($datos[$i]['cod_condicion']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_condicion'])))  . "</option>\n";
            } 
            else{
                $combocondicion = $combocondicion. "<option value=" . trim($datos[$i]['cod_condicion']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_condicion'])))  . "</option>\n";
            }
            $i++;

        }    
    }		            

    $combocondicion = $combocondicion. "</select>";

    return $combocondicion;
}            


function Consultar_condiciondocente(&$nro){
    
     $select="distinct cod_condicion,desc_condicion";
     $from = "sce160d";
     $where="";
     $groupby="";
     $orderby="cod_condicion ASC";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }    
    
}

function cargarcombo_departamento($cod_departamento){    
    $nro=0;
    $datos = Consultar_departamento($nro);
    $combodepart = "<select class=\"txtNormal\" name=\"cmb_departamento[]\" name=\"cmb_departamento\">\n".
                     "<option  value=\"00\">Seleccione...</option>\n";

    if ($nro > 0){	
        $i=0;                 
        while ($i<$nro) {
            if ($cod_departamento == trim($datos[$i]['cod_departamento'])){
                $combodepart = $combodepart. "<option selected value=" . trim($datos[$i]['cod_departamento']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_departamento'])))  . "</option>\n";
            } 
            else{
                $combodepart = $combodepart. "<option value=" . trim($datos[$i]['cod_departamento']) . ">" . strtoupper(utf8_encode(trim($datos[$i]['desc_departamento'])))  . "</option>\n";
            }
            $i++;

        }    
    }		            

    $combodepart = $combodepart. "</select>";

    return $combodepart;
}            


function Consultar_departamento(&$nro){
    
     $select="distinct cod_departamento,desc_departamento";
     $from = "sce057d";
     $where="";
     $groupby="";
     $orderby="cod_departamento ASC";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }    
    
}

function Consultar_docentes_departamento(&$nro,$departamento,$area){
    
    if($area == "00"){
        $area = " ";
    }
    else{
        $area = "AND sce058d.cod_area_dpto = '" . $area . "' ";
    }
    
    $lapso = Consultar_Lapso(1);
    
    $select = "DISTINCT sce070d_cedula_doc,nombre,cod_condicion,sce2000.sce058d.cod_departamento,sce058d.cod_area_dpto";
    $from = "sce2000.sce070d,sce2000.sce058d,sce2000.sce057d";
    $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" . $lapso . "' and sce2000.sce058d.cod_departamento ='" . $departamento . "' ".
            $area .
            "AND nombre not like '%ASIGNADO%' ".
            "AND sce2000.sce057d.cod_departamento = sce2000.sce058d.cod_departamento ".
            "AND sce070d_cedula_doc = cedula ";
    $orderby = "nombre ASC";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}



function ConsultarProductosDocente(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
    
    
    $select = "eval001d_id_evaluacion,eval001d_producto,eval001d_ponderacion,eval001d_sem_planificacion";
    $from  = "sce2000.eval001d";
    $where = "eval001d_cedula_docente =  '" . $ceduladoc . "' " .
          "AND eval001d_lapso_academico = '" . $lapsoacademico . "' " .
          "AND eval001d_cod_sede = '" . $sede . "' ".
          "AND eval001d_cod_carrera =   '" . $carrera . "' ".
          "AND eval001d_cod_seccion = '" . $seccion . "' ".
          "AND eval001d_cod_asignatura = " . $asignatura . " ".
          "AND eval001d_lapso_vigencia = '" . $lapsovigencia . "' ";
    $groupby="";
    $orderby="cast(eval001d_sem_planificacion as int)";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
}


function ConsultarUltFechaVerificada(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "DISTINCT eval005d_fecha_registro";
    $from = "sce2000.eval005d";
    $where = "eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " ".
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' "; 
    $groupby="";
    $orderby="";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
     
}


function Consultar_plan_carrera(&$nro,$carrera){
    
    $select = "DISTINCT sce110d_cod_plan";
    $from = "sce2000.sce110d";
    $where = "sce110d_cod_carr = '". $carrera . "'"; 
    $groupby="";
    $orderby="sce110d_cod_plan ASC";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}

function ConsultarAsistVerificada(&$nro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "DISTINCT eval005d_id_encuentro,eval005d_fecha_encuentro";
    $from = "sce2000.eval005d";
    $where = "eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " ".
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' "; 
    $groupby="";
    $orderby="eval005d_id_encuentro ASC;";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
     
}


function Consultar_had_docente(&$nro,$carrera,$semestre,$condicion){
   
    if ($semestre == 0){
        $semestre = " ";
    }
    else{
        $semestre = " AND sce110d_semestre = " . $semestre . " ";
    }
    
    if ($condicion == 0){
        $condicion = " ";
    }
    else{
        $condicion = " AND sce160d.cod_condicion = " . $condicion . " ";
    }
    
    
    $lapso = Consultar_Lapso(1);
    
    $select = "sce070d_cedula_doc,nombre,sce080d_nom_carr,sce070d_cod_asign,sce090d_nom_asign,".
           "sce110d_semestre,sce070d_seccion,sce160d.desc_condicion,sce110d_had,sce070d_lapso_vigencia,".
           "sce070d_cod_carr,sce070d_cod_asign,sce070d_sede,sce070d_lapso";
    $from = "sce2000.sce070d,sce2000.sce080d,sce2000.sce090d,sce2000.sce160d,sce2000.sce058d,sce2000.sce110d";
    $where = "sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_lapso = '" .  $lapso . "' and sce070d_cod_carr ='" . $carrera . "'" . $semestre . " " . $condicion .  " " .
            "AND nombre not like '%ASIGNADO%' " .
            "AND sce110d_lapso_vigencia = sce070d_lapso_vigencia AND sce110d_cod_asign = sce070d_cod_asign ".
            "AND sce110d_cod_carr = sce070d_cod_carr AND sce070d_cedula_doc = cedula AND sce058d.cod_condicion = sce160d.cod_condicion ".
            "AND sce080d_cod_carr = sce070d_cod_carr AND sce090d_cod_asign = sce070d_cod_asign";
    
    $groupby = "";
    $orderby = "nombre ASC";
    
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
        return $rs;
    }
    else{
        return 0;
    } 
      
}


function ActualizarHAD($codcarrera,$codasignatura,$had){
    
    $tabla = "sce110d";
    $campos_set="sce110d_had";
    $set = $had;
    $where = "sce110d_cod_carr = '" . $codcarrera . "' AND sce110d_cod_asign = '" . $codasignatura . "'";
  
    
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);
              
}


function Consultar_asig_carrera(&$nro,$carrera,$semestre,$plan){
    
    //sce090d_tipo_asign not in('D','E','A','C')  D= pid E=Pasantia y TG A=desarrollo Humano C=SERVICIO COMUNITARIO
    //excluir ppi sce110d_cod_asign <> '999999'
    //no sea descripcion electiva  sce110d_cod_asign not LIKE '%l%' 
    
     if ($semestre == 0){
         
         $semestre = " ";
     }
     else{
         
         $semestre = " AND sce110d_semestre = " . $semestre . " ";
     }
     
     if ($plan == 0){
         
         $plan = " ";
     }
     else{
         
         $plan = " AND sce110d_cod_plan = " . $plan . " ";
     }
     
    
     $select="sce090d_alias_cod_asign,sce090d_nom_asign,sce090d_uc,sce110d_semestre,sce110d_had,sce110d_cod_asign";
     $from = "sce2000.sce110d,sce2000.sce090d,sce2000.sce100d";
     $where="sce110d_estatus = 'A' AND sce110d_cod_asign = sce090d_cod_asign AND sce110d_lapso_vigencia = sce090d_lapso_vigencia ".
     "AND sce090d_cod_carr = sce110d_cod_carr  AND sce100d_cod_plan = sce110d_cod_plan AND sce100d_cod_carr = sce110d_cod_carr ".
     "AND sce110d_cod_carr = '" . $carrera . "'" . $semestre . $plan ."  AND sce090d_tipo_asign not in('D','E','A','C','P')  AND sce110d_cod_asign not LIKE '%l%' " .
     "AND sce110d_cod_asign <> '999999' AND sce110d_lapso_vigencia = sce100d_lapso AND sce100d_status = 'A'";
     
     $groupby="";
     $orderby="sce110d_semestre,sce090d_nom_asign ASC";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }
    
    
}

function Consultar_Condicion(&$nro){
     $select="DISTINCT cod_condicion, desc_condicion";
     $from = "sce160d";
     $where="";
     $groupby="";
     $orderby="";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }    
    
}


function Consultar_carreras(&$nro){
    
     $select="distinct sce080d_cod_carr, sce080d_nom_carr";
     $from = "sce080d";
     $where="";
     $groupby="";
     $orderby="sce080d_nom_carr ASC";
    
     $nro=0;
     $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
     if ($nro > 0){	
         return $rs;
     }
     else{
        return 0;
     }
    
}

function BorrarEvaluacion($ideval){
    $s_campos="";

    $s_valores="";

    $where = "eval001d_id_evaluacion = ". $ideval;

    $msg = Ejecutar(3,"eval001d",$s_campos,$s_valores,$where);
    
    
    
}




function ConvertirAsist($asist){
    
    if ($asist == 1){
        
        return 'checked';
    }

    if ($asist == 0){
        
        return 'unchecked';
    }

    
}

function ConsultarId_Asistencia($asist){
    
    if ($asist == 'true'){
        
        return 1;
    }
    if ($asist == 'false'){
        
        return 0;
    }
    if (strtoupper(trim($asist)) == 'A'){
        
        return 1;
    }
    if (strtoupper(trim($asist)) == 'I'){
        
        return 0;
    }
    if (strtoupper(trim($asist)) == 'J'){
        
        return 2;
    }
        
    return -2;
    
}

function GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$ceduladoc,$cedulaest,$asist,$fecha_encuentro,$fecharegistro,$encuentro,$fecha_ua,$resp_ua,$nroencuentro){

    $asistencia = ConsultarId_Asistencia($asist);
    
   
    $s_campos=$s_campos . "eval005d_cod_sede, eval005d_cod_carrera, eval005d_cod_seccion, eval005d_cod_asignatura,
    eval005d_lapso_academico, eval005d_lapso_vigencia, eval005d_cedula_estudiante, eval005d_cedula_docente, eval005d_asistencia, eval005d_fecha_encuentro, eval005d_fecha_registro,
    eval005d_id_encuentro, eval005d_fecha_ua, eval005d_resp_ua,eval005d_encuentro";

    $s_valores = $s_valores. "" . "'" . $sede. "','" .$carrera. "','" .$seccion. "'," .$asignatura. ",'" .$lapsoacademico. "','" .$lapsovigencia. "','" .$cedulaest. "','" .$ceduladoc. "'," .$asistencia. ",'" . $fecha_encuentro . "','" . $fecharegistro. "'," .$encuentro. ",'" .$fecha_ua. "','" .$resp_ua. "'," . $nroencuentro;

    $msg = Ejecutar(1,"eval005d",$s_campos,$s_valores,"");
    
    
}


function BorrarAsistencia($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$ceduladoc,$startEval,$endEval){

    $s_campos="";

    $s_valores="";
    
    
    $where = "eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " " .
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' " .
             "AND eval005d_id_encuentro BETWEEN " . $startEval . " AND " . $endEval;

    $msg = Ejecutar(3,"eval005d",$s_campos,$s_valores,$where);
       
    
}

function ConsultarAsistEst(&$nro,$encuentro,$cedulaest,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "eval005d_asistencia,eval005d_id_encuentro";
    $from = "sce2000.eval005d";
    $where = "eval005d_id_encuentro = " . $encuentro . " ".
             "AND eval005d_cedula_estudiante = '". $cedulaest . "' ".
             "AND eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " ".
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' "; 
    $groupby="";
    $orderby="eval005d_id_encuentro ASC;";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}



function ConsultarEstudiantes(&$nro,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "sce020d_cedula,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre ";
    $from = "sce2000.sce020d,sce2000.sce049d";
    
    if ($carrera == 0){
        $carrera = "";
    }
    else{
        $carrera = "AND sce020d_cod_carr = '" . $carrera . "' ";
    }
    
    $where = "sce020d_cedula = cedula ".
             "AND sce020d_lapso = '" . $lapsoacademico . "' ".
             "AND sce020d_cod_sede = '" . $sede . "' ". 
              $carrera . " " .
             "AND sce020d_seccion = '" . $seccion . "' ".
             "AND sce020d_cod_asign = '" . $asignatura . "' ".
             "AND sce020d_lapso_vigencia = '" . $lapsovigencia . "' ";
                 
    $groupby="";
    $orderby="primer_apellido,segundo_apellido,primer_nombre,segundo_nombre ASC;";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function ConsultarPlanDocente(&$nro,$cedulaDocente,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "eval001d_id_evaluacion,eval001d_producto,eval001d_actividad,eval001d_criterio,eval001d_instrumento,eval001d_ponderacion,eval001d_sem_planificacion,eval001d_status";
    $from = "sce2000.eval001d";
    $where = "eval001d_cedula_docente = '" . $cedulaDocente . "' " . 
             "AND eval001d_lapso_academico = '" . $lapsoacademico . "' ".  
             "AND eval001d_cod_sede = '" . $sede . "' ".
             "AND eval001d_cod_carrera = '" . $carrera . "' ".
             "AND eval001d_cod_seccion= '" . $seccion . "' ".
             "AND eval001d_cod_asignatura = '" . $asignatura . "' ".
             "AND eval001d_lapso_vigencia = '" . $lapsovigencia . "' ";
    $groupby="";
    $orderby="cast(eval001d_sem_planificacion as int)";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function GuardarEvaluacion(&$msg,$id_evaluacion,$sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$producto,$actividad,$criterio,$instrumento,$evaluacion,$fecha_proceso,$status,$semana,$fecha_proceso,$cedulaAct,$ideval){

  if($ideval == 0){

      $s_campos=$s_campos . "eval001d_id_evaluacion, eval001d_cod_sede, eval001d_cod_carrera, eval001d_cod_seccion, eval001d_cod_asignatura,
    eval001d_lapso_academico, eval001d_lapso_vigencia, eval001d_cedula_docente, eval001d_producto, eval001d_actividad,
    eval001d_criterio, eval001d_instrumento, eval001d_ponderacion, eval001d_fecha_registro, eval001d_status, eval001d_sem_planificacion,
    eval001d_fecha_ua,eval001d_resp_ua";
  
    $s_valores=$s_valores . "" . $id_evaluacion . ",'" . $sede. "','" .$carrera. "','" .$seccion. "'," .$asignatura. ",'" .$lapsoacademico. "','" .$lapsovigencia. "','" .$cedulaDocente. "','" .$producto. "','" .$actividad. "','" .$criterio. "'," .$instrumento. "," .$evaluacion. ",'" .$fecha_proceso. "'," .$status. ",'" .$semana. "','" .$fecha_proceso. "','" .$cedulaAct . "'";
      
      
      
    $msg = Ejecutar(1,"eval001d",$s_campos,$s_valores,"");
  }
  else{

    $s_campos=$s_campos . "eval001d_producto, eval001d_actividad,eval001d_criterio, 
        eval001d_instrumento,eval001d_ponderacion,eval001d_sem_planificacion,
        eval001d_fecha_ua,eval001d_resp_ua";

    $s_valores=$s_valores . "'" .$producto. "','" .$actividad. "','" .$criterio. "'," .$instrumento. "," .$evaluacion. ",'" .$semana. "','" .$fecha_proceso. "','" .$cedulaAct . "'";

    $where  = "eval001d_id_evaluacion = '" . $ideval . "'";

    $msg = Ejecutar(2,"eval001d",$s_campos,$s_valores,$where);
  }
  
   return $msg;
}



function GetMaxCodEvaluacion(){
  $nroeval="";
  // begin Recordset
  $nro=0;
  $rs =  Consultar($nro,"eval001d","MAX(eval001d_id_evaluacion) as maxeval",""); 
  // end Recordset
  if ($nro > 0){
     $nroeval = trim($rs[0]['maxeval']);
  }
  $rs=0;	   
  return $nroeval;
}


function Consultar_Lapso_Objecion($cedulaDocente){
           //2019    
    //$select="lapso_activo as lapso";
    $select="'201803' as lapso";
    $from = "sce2000.sce999d";
    $where="";
    $groupby="";
    $orderby="";

    $nro=0;
    $lapso = Consultar($nro,$from,$select,$where,$groupby,$orderby);

    
    return $lapso;
    
    
        
    
}


function Consultar_Lapso($cedulaDocente){
           //2019    
    $select="lapso_activo as lapso";
    //$select="'201901' as lapso";
    $from = "sce2000.sce999d";
    $where="";
    $groupby="";
    $orderby="";

    $nro=0;
    $lapso = Consultar($nro,$from,$select,$where,$groupby,$orderby);

    
    return $lapso;
    
    
        
    
}


function Consultar_Asig_Lapso_Docente(&$nro,$lapso,$docente){
    //mejorar....
    //2019
   $select="sce080d_nom_carr,sce090d_nom_asign,sce070d_seccion,sce070d_lapso_vigencia,sce070d_cod_carr,sce070d_cod_asign,sce070d_sede,replace(sce016d_alias_largo,'-','') as lapso,sce070d_cedula_doc,sce025d_descripcion,nombre,sce110d_semestre,sce070d_lapso as lapso_sys ";
   $from = "sce2000.sce070d,sce2000.sce080d,sce2000.sce090d,sce2000.sce025d,sce2000.sce058d,sce2000.sce110d,sce2000.sce016d ";
   $where="sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_cedula_doc = '" . $docente . "' AND sce070d_lapso = '" . $lapso . "' AND  sce070d_lapso = sce016d_lapso_acad AND sce110d_lapso_vigencia = sce070d_lapso_vigencia AND sce110d_cod_asign = sce070d_cod_asign AND sce110d_cod_carr = sce070d_cod_carr AND sce070d_cedula_doc = cedula AND sce025d_codigo_sede = sce070d_sede AND sce080d_cod_carr = sce070d_cod_carr AND sce090d_cod_asign = sce070d_cod_asign AND  sce070d_lapso = sce016d_lapso_acad  " .
   
   "UNION ".

   "select DISTINCT ' ' AS sce080d_nom_carr,sce090d_nom_asign,sce070d_seccion,sce070d_lapso_vigencia,'AUTO' as cod_carr,sce070d_cod_asign,sce070d_sede,replace(sce016d_alias_largo,'-','') as lapso,sce070d_cedula_doc,sce025d_descripcion,nombre,sce110d_semestre,sce070d_lapso as lapso_sys " .
   "from sce2000.sce070d,sce2000.sce090d,sce2000.sce025d,sce2000.sce058d,sce2000.sce110d,sce2000.sce016d ".
   "where sce070d_estatus = 'A' AND (sce070d_nro_incritos > 0 OR sce070d_nro_estudiante_nuevo_ing > 0) AND sce070d_cedula_doc = '" . $docente . "' " .
   "AND sce070d_lapso = '" . $lapso . "' " .
   "AND sce070d_cod_carr IN('AUTO','PART','PID') " .
   "AND sce110d_lapso_vigencia = sce070d_lapso_vigencia " .
   "AND sce110d_cod_asign = sce070d_cod_asign " .
   "AND sce070d_cedula_doc = cedula " .
   "AND sce025d_codigo_sede = sce070d_sede " .
   "AND sce090d_cod_asign = sce070d_cod_asign " . 
   "AND  sce070d_lapso = sce016d_lapso_acad";

           
   $groupby="";
   $orderby="sce090d_nom_asign,sce080d_nom_carr,sce070d_seccion";

   $nro=0;
   $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
   if ($nro > 0){	
        return $rs;
   }
   else{
       return 0;
   }
  
}


         
function ConsultarFechaEncuentro(&$nro,$encuentro,$ceduladoc,$lapsoacademico,$sede,$carrera,$seccion,$asignatura,$lapsovigencia){
   
    $select = "eval005d_fecha_encuentro";
    $from = "sce2000.eval005d";
    $where = "eval005d_id_encuentro = ". $encuentro ." ".
             "AND eval005d_cedula_docente = '". $ceduladoc . "' ".
             "AND eval005d_lapso_academico = '" . $lapsoacademico . "' ".
             "AND eval005d_cod_sede = '" . $sede . "' ". 
             "AND eval005d_cod_carrera = '" . $carrera . "' ".  
             "AND eval005d_cod_seccion = '" . $seccion . "' ".
             "AND eval005d_cod_asignatura = " . $asignatura . " ".
             "AND eval005d_lapso_vigencia = '" . $lapsovigencia . "' ";
                 
    $groupby="";
    $orderby="";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}

