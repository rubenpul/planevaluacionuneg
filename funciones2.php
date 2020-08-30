<?php

function formatearFecha($fecha){
	$fecha=implode("/", array_reverse(explode("-", $fecha)));
	return $fecha;
}


function GetAcumuladoPlanificacionDocenteCarrera (&$nro,$cedula,$carrera,$lapso){
    
    $select = "sce090d_nom_asign,eval001d_cod_seccion,sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d,sce2000.sce090d";
    $where = "sce090d_cod_asign = CAST(eval001d_cod_asignatura AS VARCHAR) AND eval001d_cod_carrera = '" . $carrera . "' AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

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

function GetAcumuladoPlanificacionDocenteAsignatura (&$nro,$cedula,$asignatura,$seccion,$lapso){
    
    $select = "sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d";
    $where = "eval001d_cod_seccion = '" . $seccion . "' AND eval001d_cod_asignatura = '" . $asignatura . "' AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

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



      
function Docentes_Sede_Carrera_Asignatura(&$nro,$sede,$carrera,$lapso){
    
      $select = "sce070d_cedula_doc,nombre,sce070d_cod_asign,sce090d_nom_asign,sce070d_seccion";
      $from = "sce2000.sce070d,sce2000.sce090d,sce2000.sce058d";
      $where = "cedula = sce070d_cedula_doc AND sce070d_cod_asign = sce090d_cod_asign AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
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
      $where = "sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
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
      $where = "sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
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
    
      $select = "sce070d_cedula_doc,nombre";
      $from = "sce2000.sce070d,sce2000.sce058d";
      $where = "sce070d_cedula_doc = cedula  AND sce070d_lapso = '" . $lapso . "' AND sce070d_cod_carr = '" . $carrera . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
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





function Consultar_Carrera_Sede(&$nro,$sede){
    
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


function GetAcumuladoPlanificacionDocenteDetallado (&$nro,$cedula,$lapso){
    
    $select = "sce090d_nom_asign,eval001d_cod_seccion,sum(eval001d_ponderacion) as acum";
    $from = "sce2000.eval001d,sce2000.sce090d";
    $where = "sce090d_cod_asign = CAST(eval001d_cod_asignatura AS VARCHAR) AND eval001d_cedula_docente = '" . $cedula . "' AND eval001d_lapso_academico = '" . $lapso . "'";

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



function Docentes_Sede(&$nro,$lapso,$sede){
    
      $select = "sce070d_cedula_doc";
      $from = "sce2000.sce070d";
      $where = "sce070d_lapso = '" . $lapso . "' AND sce070d_sede = '" . $sede . "' AND sce070d_cedula_doc <> 'n/a' AND sce070d_cedula_doc <> ''";
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
   
    $select = "DISTINCT eval002d_cedula_est,primer_apellido,primer_nombre,eval002d_nota,eval002d_no_asistio";
    $from = "sce2000.sce049d,sce2000.eval002d";
          
    $where = "eval002d_cedula_est = cedula ".
             "AND eval002d_id_evaluacion = '" . $ideval . "' ".
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' ".
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = '" . $asignatura . "' ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
                 
    $groupby="";
    $orderby="primer_apellido ASC ";
        
    $nro=0;
    $rs =Consultar($nro,$from,$select,$where,$groupby,$orderby);
                
    if ($nro > 0){	
         return $rs;
    }
    else{
        return 0;
    }
    
    
}


function GuardarPonderacion($msg,$ideval,$cedula,$expediente,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia,$poderacion,$definitiva,$abandono,$asistio,$cedulaDocente,$nroacta,$semana,$fecha_proceso,$fecha_act,$cedulaDocenteact,$estatus,$fechaevaluacion){

    BorrarNotas($ideval,$cedula,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia);
    
    $s_campos=$s_campos . "eval002d_id_evaluacion,eval002d_cedula_est,eval002d_expediente_est,eval002d_cod_carr,eval002d_cod_asignatura,eval002d_cod_sede,
        eval002d_seccion,eval002d_lapsoacademico,eval002d_lapsovigencia,eval002d_nota,eval002d_definitiva,eval002d_abandono,eval002d_no_asistio,
    eval002d_responsable,eval002d_nroacta,eval002d_sem_aplicacion,eval002d_fecha_registro,eval002d_fecha_ua,eval002d_resp_ua,eval002d_estatus,eval002d_fechaevaluacion";

    $s_valores= $s_valores . "" . $ideval . ",'" . $cedula . "'," .$expediente. ",'" .$carrera. "'," .$asignatura. ",'" . 
            $sede. "','" .$seccion. "','" .$lapsoacademico. "','" .$lapsovigencia. "'," .$poderacion. "," . 
            $definitiva . ",'" .$abandono. "','" .$asistio. "','" .$cedulaDocente. "','" .$nroacta. "','" .
            $semana. "','" .$fecha_proceso. "','" .$fecha_act . "','" . $cedulaDocenteact . "','" . $estatus . "','" . $fechaevaluacion . "'";

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


function GetNotaDefinitiva($cedulaest,$ceduladoc,$carrera,$asignatura,$sede,$seccion,$lapsoacademico,$lapsovigencia){
    
    //consultar sumatoria nota
    
    $select = "SUM(eval002d_nota) as nota";
    $from = "eval002d";
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
    
    $nro=0;
    $datos =Consultar($nro,$from,$select,$where,$groupby,$orderby);
    
    if ($nro > 0){
        
        $notadefinitiva = trim($datos[0]['nota']);
       
    }
    else{
            
        $notadefinitiva = 0; 
    }
       
    
    //actualizar nota definitiva
    $tabla = "sce2000.eval002d";
    $campos_set="eval002d_definitiva";
    $set = $notadefinitiva;
    $where = "eval002d_cedula_est = '". $cedulaest . "' " .
             "AND eval002d_lapsoacademico = '" . $lapsoacademico . "' ".
             "AND eval002d_cod_sede = '" . $sede . "' ". 
             "AND eval002d_cod_carr = '" . $carrera . "' " . " " .
             "AND eval002d_seccion = '" . $seccion . "' ".
             "AND eval002d_cod_asignatura = " . $asignatura . " ".
             "AND eval002d_lapsovigencia = '" . $lapsovigencia . "' ";
      
    $msg = Ejecutar(2,$tabla,$campos_set,$set,$where);


 
}

function GetExpedienteEstudiante($cedula)
{
  $exp="";
  // begin Recordset
  $nro=0;
  $where = "sce050d_status in ('0','10','6','8') and sce050d_cedula='" . $cedula . "'";
  $rs =  Consultar($nro,"sce050d","sce050d_nro_expediente",$where,"","",0,0,$enlace); 
  // end Recordset
  if ($nro > 0) 
         $exp = trim($rs[0]['sce050d_nro_expediente']);
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
    else{
               
       $fechaevaluacion = 0; 
    }
        
    return $fechaevaluacion;
}

function ConsultarStatusEvaluacion($id_evaluacion){
    $estatus = "";
    
    $select = "eval002d_estatus";
    $from = "eval002d";
    $where = "eval002d_id_evaluacion = '" . $id_evaluacion . "' ";
    
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
            $ruta = "<img src=\"../imagenes/agregar_evaluacion.png\" title=\"Agregar Evaluaci&oacute;n\" class=\"AgregarEvaluacion\" height=\"30\" width=\"30\">"; 
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
    
    $select = "DISTINCT sce070d_cedula_doc,nombre,cod_condicion,sce2000.sce058d.cod_departamento,sce058d.cod_area_dpto";
    $from = "sce2000.sce070d,sce2000.sce058d,sce2000.sce057d";
    $where = "sce070d_lapso = '201801' and sce2000.sce058d.cod_departamento ='" . $departamento . "' ".
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
    
    
    $select = "sce070d_cedula_doc,nombre,sce080d_nom_carr,sce070d_cod_asign,sce090d_nom_asign,".
           "sce110d_semestre,sce070d_seccion,sce160d.desc_condicion,sce110d_had,sce070d_lapso_vigencia,".
           "sce070d_cod_carr,sce070d_cod_asign,sce070d_sede,sce070d_lapso";
    $from = "sce2000.sce070d,sce2000.sce080d,sce2000.sce090d,sce2000.sce160d,sce2000.sce058d,sce2000.sce110d";
    $where = "sce070d_lapso = '201801' and sce070d_cod_carr ='" . $carrera . "'" . $semestre . " " . $condicion .  " " .
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

function GuardarAsistenciaEstudiante($sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$ceduladoc,$cedulaest,$asist,$fecha_encuentro,$fecharegistro,$encuentro,$fecha_ua,$resp_ua){

    $asistencia = ConsultarId_Asistencia($asist);
    
   
    $s_campos=$s_campos . "eval005d_cod_sede, eval005d_cod_carrera, eval005d_cod_seccion, eval005d_cod_asignatura,
    eval005d_lapso_academico, eval005d_lapso_vigencia, eval005d_cedula_estudiante, eval005d_cedula_docente, eval005d_asistencia, eval005d_fecha_encuentro, eval005d_fecha_registro,
    eval005d_id_encuentro, eval005d_fecha_ua, eval005d_resp_ua";

    $s_valores= $s_valores. "" . "'" . $sede. "','" .$carrera. "','" .$seccion. "'," .$asignatura. ",'" .$lapsoacademico. "','" .$lapsovigencia. "','" .$cedulaest. "','" .$ceduladoc. "'," .$asistencia. ",'" . $fecha_encuentro . "','" . $fecharegistro. "'," .$encuentro. ",'" .$fecha_ua. "','" .$resp_ua. "'";

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
   
    $select = "sce020d_cedula,primer_apellido,primer_nombre";
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
    $orderby="primer_apellido ASC;";
        
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
   
    $select = "eval001d_id_evaluacion,eval001d_producto,eval001d_actividad,eval001d_criterio,eval001d_instrumento,eval001d_ponderacion,eval001d_sem_planificacion";
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


function GuardarEvaluacion(&$msg,$id_evaluacion,$sede,$carrera,$seccion,$asignatura,$lapsoacademico,$lapsovigencia,$cedulaDocente,$producto,$actividad,$criterio,$instrumento,$evaluacion,$fecha_proceso,$status,$semana,$fecha_proceso,$cedulaDocente,$ideval){

  if($ideval == 0){

      $s_campos=$s_campos . "eval001d_id_evaluacion, eval001d_cod_sede, eval001d_cod_carrera, eval001d_cod_seccion, eval001d_cod_asignatura,
    eval001d_lapso_academico, eval001d_lapso_vigencia, eval001d_cedula_docente, eval001d_producto, eval001d_actividad,
    eval001d_criterio, eval001d_instrumento, eval001d_ponderacion, eval001d_fecha_registro, eval001d_status, eval001d_sem_planificacion,
    eval001d_fecha_ua,eval001d_resp_ua";
  
    $s_valores=$s_valores . "" . $id_evaluacion . ",'" . $sede. "','" .$carrera. "','" .$seccion. "'," .$asignatura. ",'" .$lapsoacademico. "','" .$lapsovigencia. "','" .$cedulaDocente. "','" .$producto. "','" .$actividad. "','" .$criterio. "'," .$instrumento. "," .$evaluacion. ",'" .$fecha_proceso. "'," .$status. ",'" .$semana. "','" .$fecha_proceso. "','" .$cedulaDocente . "'";
      
      
      
    $msg = Ejecutar(1,"eval001d",$s_campos,$s_valores,"");
  }
  else{

    $s_campos=$s_campos . "eval001d_producto, eval001d_actividad,eval001d_criterio, 
        eval001d_instrumento,eval001d_ponderacion,eval001d_status, eval001d_sem_planificacion,
        eval001d_fecha_ua,eval001d_resp_ua";

    $s_valores=$s_valores . "'" .$producto. "','" .$actividad. "','" .$criterio. "'," .$instrumento. "," .$evaluacion. "," .$status. ",'" .$semana. "','" .$fecha_proceso. "','" .$cedulaDocente . "'";

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


function Consultar_Lapso($cedulaDocente){
               
    $select="lapso_activo as lapso";
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
    
   $select="sce080d_nom_carr,sce090d_nom_asign,sce070d_seccion,sce070d_lapso_vigencia,sce070d_cod_carr,sce070d_cod_asign,sce070d_sede,sce070d_lapso,sce070d_cedula_doc,sce025d_descripcion,nombre,sce110d_semestre";
   $from = "sce2000.sce070d,sce2000.sce080d,sce2000.sce090d,sce2000.sce025d,sce2000.sce058d,sce2000.sce110d";
   $where="sce070d_cedula_doc = '" . $docente . "' AND sce070d_lapso = '" . $lapso . "' AND sce110d_lapso_vigencia = sce070d_lapso_vigencia AND sce110d_cod_asign = sce070d_cod_asign AND sce110d_cod_carr = sce070d_cod_carr AND sce070d_cedula_doc = cedula AND sce025d_codigo_sede = sce070d_sede AND sce080d_cod_carr = sce070d_cod_carr AND sce090d_cod_asign = sce070d_cod_asign " .
   
   "UNION ".

   "select DISTINCT ' ' AS sce080d_nom_carr,sce090d_nom_asign,sce070d_seccion,sce070d_lapso_vigencia,'0' as cod_carr,sce070d_cod_asign,sce070d_sede,sce070d_lapso,sce070d_cedula_doc,sce025d_descripcion,nombre,sce110d_semestre " .
   "from sce2000.sce070d,sce2000.sce090d,sce2000.sce025d,sce2000.sce058d,sce2000.sce110d ".
   "where sce070d_cedula_doc = '" . $docente . "' " .
   "AND sce070d_lapso = '" . $lapso . "' " .
   "AND sce070d_cod_carr IN('AUTO','PART','PID') " .
   "AND sce110d_lapso_vigencia = sce070d_lapso_vigencia " .
   "AND sce110d_cod_asign = sce070d_cod_asign " .
   "AND sce070d_cedula_doc = cedula " .
   "AND sce025d_codigo_sede = sce070d_sede " .
   "AND sce090d_cod_asign = sce070d_cod_asign";

           
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

