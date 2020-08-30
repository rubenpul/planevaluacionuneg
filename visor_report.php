<?php
/*
<!-- UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA                                            -->
<!-- REALIZADO POR: Ing. RUBEN PULIDO                                                      -->                                                 -->
<!-- NOMBRE: visor_report.php                                                                -->
<!-- DESCRIPCION: CONFIGURACION PARA EJECUCION DE REPORTES                                  -->
<!-- *************************************************************************************** -->
*/
//define('FPDF_FONTPATH','font/');
require_once('pdfacta.php');

//error_reporting(E_ALL);

//Connect to your database
require_once('../webconfig/parametros.php');
require_once('../webconfig/setup.php');
require_once('../funciones/acceso_preg.php');
require_once('funciones.php');

$codreporte=$_GET['codreporte'];

switch ($codreporte){
    
      case '0':
            $i=0;
            $resultado = "";
         
            $idacta = unserialize($_SESSION['idacta']);
            $datos = unserialize($_SESSION['dataacta']);
            $nro = unserialize($_SESSION['lendataacta']);            
            
            $semestre = unserialize($_SESSION['dessemestre']); 
            $desasignatura = unserialize($_SESSION['desasign']);
            $descarrera = unserialize($_SESSION['descarr']);
            $seccion = unserialize($_SESSION['desseccion']);
            $dessede = unserialize($_SESSION['dessede']);
            $cedula = unserialize($_SESSION['ceduladoc']);
            $docente = unserialize($_SESSION['docente']);
           
                       
            
            $pdf = new PDF("P", "mm", "Letter");
            $pdf->setNombreReporte("ACTA DE EVALUACIÓN");
            $pdf->setNombreCarrera($descarrera);
            $pdf->setNombreAsignatura($desasignatura);
            $pdf->setNombreSede($dessede);
            $pdf->setSeccion($seccion);
            $pdf->setSemestre($semestre);
            $pdf->setDocente($cedula,$docente);
            $pdf->setSubtitulo("ACTA Nro. " . $datos[0]['eval002d_nroacta']);
            $pdf->SetFillColor(220, 220, 220);
            $pdf->setPrimeraPagina(2);
            $pdf->AddPage();            
                          
                        
            for($i=0;$i<$nro;$i++){
                
                $resultado =  $datos[$i]['primer_apellido'] . " " . $datos[$i]['segundo_apellido'] . ", " . $datos[$i]['primer_nombre'] . " " . $datos[$i]['segundo_nombre'] ;
                
                $pdf->Cell(10,8,$i+1,1,0,'C');
		$pdf->Cell(20,8,$datos[$i]['eval002d_cedula_est'],1,0,'C');
		$pdf->Cell(85,8,$resultado,1,0,'L');
		
		$pdf->Cell(20,8,trim($datos[$i]['eval002d_nota110']),1,0,'C');
		$pdf->Cell(20,8,trim(NumeroLetras(trim($datos[$i]['eval002d_nota110']))),1,0,'C');
		
		$pdf->Cell(20,8,$asistio,1,0,'C');
		$pdf->Cell(20,8,$abandono,1,0,'C');
		$pdf->Ln(8);
                               
            }
            $pdf->Ln(8);
            
            $pdf->Cell(40,8,"Estadísticas Sección",0,0,'C');
            
            $pdf->Ln(8);
            
            $pdf->Cell(40,8,"Nro de Estudiantes Inscritos",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNroEstIns']),1,0,'C');
            $pdf->Cell(40,8,"Nro de Estudiantes Cursantes",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNroEstCur']),1,0,'C');
            $pdf->Cell(40,8,"Nro Estudiantes Aprobados",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNroAprob']),1,0,'C');
            
            $pdf->Ln(8);
            
            $pdf->Cell(40,8,"% Aprobados",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesPorcenAprob']) . "%",1,0,'C');
            $pdf->Cell(40,8,"Nro de Estudiantes Reprobados",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNroReprob']),1,0,'C');
            $pdf->Cell(40,8,"% Reprobados",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesPorcenReprob']). "%",1,0,'C');

            $pdf->Ln(8);
            
            $pdf->Cell(40,8,"Media Aritmética",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesMedia']),1,0,'C');
            $pdf->Cell(40,8,"Desviación Típica",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesDesvtip']),1,0,'C');
            $pdf->Cell(40,8,"Varianza",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesVarianza']),1,0,'C');

            $pdf->Ln(8);
            
            $pdf->Cell(40,8,"Calificación Máxima",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNotaMax']),1,0,'C');
            $pdf->Cell(40,8,"Calificación Mínima",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesNotaMin']),1,0,'C');
            $pdf->Cell(40,8,"% Evaluado",1,0,'C');
            $pdf->Cell(20,8,unserialize($_SESSION['DesTotalEvaluado']),1,0,'C');
            
            
                       
            
            
            $pdf->Output($desasignatura."_".$seccion."_".$cedula.".pdf",'D');         
                   
    
           break;

    case '1':
            $i=0;
            $resultado = "";
         
            $idacta = unserialize($_SESSION['idacta']);
            $datos = unserialize($_SESSION['dataacta']);
            $nro = unserialize($_SESSION['lendataacta']);            
            
            $ponderacion = unserialize($_SESSION['ponderacion']); 
            $semestre = unserialize($_SESSION['dessemestre']); 
            $desasignatura = unserialize($_SESSION['desasign']);
            $descarrera = unserialize($_SESSION['descarr']);
            $seccion = unserialize($_SESSION['desseccion']);
            $dessede = unserialize($_SESSION['dessede']);
            $cedula = unserialize($_SESSION['ceduladoc']);
            $docente = unserialize($_SESSION['docente']);
            $producto = unserialize($_SESSION['desproducto']);
           
 
// Divido el string de nombre de personas por los espacios
            $lenproducto = explode(" ", $producto);
 
            

            //$codigo = crypt($cedula,'rap');
            $pdf = new PDF("P", "mm", "Letter");
            $pdf->setNombreReporte("EVALUACIÓN DE PRODUCTO O EVIDENCIA. PONDERACIÓN: " . $ponderacion . "%");
            $pdf->setNombreCarrera($descarrera);
            $pdf->setNombreAsignatura($desasignatura);
            $pdf->setNombreSede($dessede);
            $pdf->setSeccion($seccion);
            $pdf->setSemestre($semestre);
            $pdf->setDocente($cedula,$docente);
                        
            $subtitulo1="";
            $i=0;
            while($i<20 && $i < count($lenproducto)){
                $subtitulo1 = $subtitulo1 . " " . $lenproducto[$i];
                $i++;
            }
            $pdf->setSubtitulo1($subtitulo1);
                        
            $subtitulo2="";
            if ($i<40 && $i < count($lenproducto)){
                
                while($i<40 && $i < count($lenproducto)){
                    $subtitulo2 = $subtitulo2 . " " . $lenproducto[$i];
                    $i++;
                }
            }
            $pdf->setSubtitulo2($subtitulo2);
            
            $subtitulo3="";
            if ($i>=40 && $i < count($lenproducto)){
                
                while($i < count($lenproducto)){
                    $subtitulo3 = $subtitulo3 . " " . $lenproducto[$i];
                    $i++;
                }
            }
            $pdf->setSubtitulo3($subtitulo3);
            
            $pdf->SetFillColor(220, 220, 220);
            $pdf->setPrimeraPagina(3);
            $pdf->AddPage();            
                          
                        
            for($i=0;$i<$nro;$i++){
                
                $resultado =  $datos[$i]['primer_apellido'] . " " . $datos[$i]['segundo_apellido'] . ", " . $datos[$i]['primer_nombre'] . " " . $datos[$i]['segundo_nombre'] ;
                
                $pdf->Cell(10,8,$i+1,1,0,'C');
		$pdf->Cell(20,8,$datos[$i]['eval002d_cedula_est'],1,0,'C');
		$pdf->Cell(85,8,$resultado,1,0,'L');
		
                if ($datos[$i]['eval002d_no_asistio'] == 0){
                    $pdf->Cell(20,8,'',1,0,'C');
                    $pdf->Cell(20,8,'',1,0,'C');
		    $pdf->Cell(20,8,'X',1,0,'C');
                }
                else{
                    $pdf->Cell(20,8,trim($datos[$i]['eval002d_nota']),1,0,'C');
                    $pdf->Cell(20,8,trim(NumeroLetras(trim($datos[$i]['eval002d_nota']))),1,0,'C');                    
                    $pdf->Cell(20,8,'',1,0,'C');
                }
	
		$pdf->Ln(8);
                               
            }
                       
            $pdf->Output($desasignatura."_".$seccion."_".$cedula.".pdf",'D');         
                   
    
           break;           
           
      case '116':
        if(isset($_GET['Cedula']) && isset($_GET['Carrera']) && isset($_GET['Asignatura']) && isset($_GET['Seccion']) && isset($_GET['Sede']) && isset($_GET['LapsoAcademico']) && isset($_GET['LapsoVigencia']) ){  

            $carrera = $_GET['Carrera']; 
            $asignatura = $_GET['Asignatura']; 
            $sede = $_GET['Sede'];
            $seccion = $_GET['Seccion'];
            $lapsoacademico = Consultar_Lapso($cedulaDocente);
            $lapsovigencia = $_GET['LapsoVigencia'];
            $descarrera = $_GET['DesCarrera']; 
            $desasignatura = $_GET['DesAsignatura']; 
            $dessede = $_GET['DesSede']; 
            $docente = $_GET['DesDocente']; 
            $semestre = $_GET['DesSemestre']; 
            
            $pdf = new PDF("P", "mm", "Letter");
            $pdf->setNombreReporte("REGISTRO DE ASISTENCIAS");
            $pdf->setNombreCarrera($descarrera);
            $pdf->setNombreAsignatura($desasignatura);
            $pdf->setNombreSede($dessede);
            $pdf->setSeccion($seccion);
            $pdf->setSemestre($semestre);
            $pdf->setDocente($_GET['Cedula'],$docente);
            $pdf->setSubtitulo("SESIONES DE CLASES 1-16");
            $pdf->SetFillColor(220, 220, 220);
            $pdf->setPrimeraPagina(1);
            $pdf->AddPage();
            
            $pdf->Ln();
          
            $header = array('NOMBRES Y APELLIDOS','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16');
                    // Anchuras de las columnas
            $w = array(60,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8);
            // Cabeceras

            for($i=0;$i<count($header);$i++){
                $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
            }     
                    
            $datos = ConsultarEstudiantes($nro,$lapsoacademico[0]['lapso'],$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                          
            $resultado = "";
           
            $pdf->Ln();
            
            for($i=0;$i<$nro;$i++){
                
                $resultado = $datos[$i]['sce020d_cedula'] . " " . $datos[$i]['primer_apellido'] . " " . $datos[$i]['primer_nombre'];
                
                $pdf->Cell($w[0],6,$resultado,1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            for($i=$nro;$i<30;$i++){
             
                $pdf->Cell($w[0],6,'',1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            
            $pdf->Ln(9);
            $pdf->MultiCell(0, 5, '_______________________             _________________________', 0, 'C');
            $pdf->MultiCell(0, 5, '                Firma Profesor                           (Solo para ser usado por la Coordinación)', 0, 'C');		
            
            
            
            $pdf->Output($desasignatura."_".$seccion."_".$_GET['Cedula'].".pdf",'D');
     }        
     break;    
     
     case '1732':
        if(isset($_GET['Cedula']) && isset($_GET['Carrera']) && isset($_GET['Asignatura']) && isset($_GET['Seccion']) && isset($_GET['Sede']) && isset($_GET['LapsoAcademico']) && isset($_GET['LapsoVigencia']) ){  

            $carrera = $_GET['Carrera']; 
            $asignatura = $_GET['Asignatura']; 
            $sede = $_GET['Sede'];
            $seccion = $_GET['Seccion'];
            $lapsoacademico = Consultar_Lapso($cedulaDocente);
            $lapsovigencia = $_GET['LapsoVigencia'];
            $descarrera = $_GET['DesCarrera']; 
            $desasignatura = $_GET['DesAsignatura']; 
            $dessede = $_GET['DesSede']; 
            $docente = $_GET['DesDocente']; 
            $semestre = $_GET['DesSemestre']; 
            
            $pdf = new PDF("P", "mm", "Letter");
            $pdf->setNombreReporte("REGISTRO DE ASISTENCIAS");
            $pdf->setNombreCarrera($descarrera);
            $pdf->setNombreAsignatura($desasignatura);
            $pdf->setNombreSede($dessede);
            $pdf->setSeccion($seccion);
            $pdf->setSemestre($semestre);
            $pdf->setDocente($_GET['Cedula'],$docente);
            $pdf->setSubtitulo("SESIONES DE CLASES 17-33");
            $pdf->SetFillColor(220, 220, 220);
            $pdf->AddPage();
            
            $pdf->Ln();
          
            $header = array('NOMBRES Y APELLIDOS','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32');
                    // Anchuras de las columnas
            $w = array(60,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8);
            // Cabeceras

            for($i=0;$i<count($header);$i++){
                $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
            }     
                    
            $datos = ConsultarEstudiantes($nro,$lapsoacademico[0]['lapso'],$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                          
            $resultado = "";
           
            $pdf->Ln();
            
            for($i=0;$i<$nro;$i++){
                
                $resultado = $datos[$i]['sce020d_cedula'] . " " . $datos[$i]['primer_apellido'] . " " . $datos[$i]['primer_nombre'];
                
                $pdf->Cell($w[0],6,$resultado,1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            for($i=$nro;$i<30;$i++){
             
                $pdf->Cell($w[0],6,'',1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            
            $pdf->Ln(9);
            $pdf->MultiCell(0, 5, '_______________________             _________________________', 0, 'C');
            $pdf->MultiCell(0, 5, '                Firma Profesor                           (Solo para ser usado por la Coordinación)', 0, 'C');		
            
            
            
            $pdf->Output($desasignatura."_".$seccion."_".$_GET['Cedula'].".pdf",'D');
     }        
     break;    
     
     
     case '3348':
        if(isset($_GET['Cedula']) && isset($_GET['Carrera']) && isset($_GET['Asignatura']) && isset($_GET['Seccion']) && isset($_GET['Sede']) && isset($_GET['LapsoAcademico']) && isset($_GET['LapsoVigencia']) ){  

            $carrera = $_GET['Carrera']; 
            $asignatura = $_GET['Asignatura']; 
            $sede = $_GET['Sede'];
            $seccion = $_GET['Seccion'];
            $lapsoacademico = Consultar_Lapso($cedulaDocente);
            $lapsovigencia = $_GET['LapsoVigencia'];
            $descarrera = $_GET['DesCarrera']; 
            $desasignatura = $_GET['DesAsignatura']; 
            $dessede = $_GET['DesSede']; 
            $docente = $_GET['DesDocente']; 
            $semestre = $_GET['DesSemestre']; 
            
            $pdf = new PDF("P", "mm", "Letter");
            $pdf->setNombreReporte("REGISTRO DE ASISTENCIAS");
            $pdf->setNombreCarrera($descarrera);
            $pdf->setNombreAsignatura($desasignatura);
            $pdf->setNombreSede($dessede);
            $pdf->setSeccion($seccion);
            $pdf->setSemestre($semestre);
            $pdf->setDocente($_GET['Cedula'],$docente);
            $pdf->setSubtitulo("SESIONES DE CLASES 33-48");
            $pdf->SetFillColor(220, 220, 220);
            $pdf->AddPage();
            
            $pdf->Ln();
          
            $header = array('NOMBRES Y APELLIDOS','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48');
                    // Anchuras de las columnas
            $w = array(60,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8);
            // Cabeceras

            for($i=0;$i<count($header);$i++){
                $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
            }     
                    
            $datos = ConsultarEstudiantes($nro,$lapsoacademico[0]['lapso'],$sede,$carrera,$seccion,$asignatura,$lapsovigencia);
                          
            $resultado = "";
           
            $pdf->Ln();
            
            for($i=0;$i<$nro;$i++){
                
                $resultado = $datos[$i]['sce020d_cedula'] . " " . $datos[$i]['primer_apellido'] . " " . $datos[$i]['primer_nombre'];
                
                $pdf->Cell($w[0],6,$resultado,1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            for($i=$nro;$i<30;$i++){
             
                $pdf->Cell($w[0],6,'',1);
                $pdf->Cell($w[1],6,'',1);
                $pdf->Cell($w[2],6,'',1);
                $pdf->Cell($w[3],6,'',1);
                $pdf->Cell($w[4],6,'',1);
                $pdf->Cell($w[5],6,'',1);
                $pdf->Cell($w[6],6,'',1);
                $pdf->Cell($w[7],6,'',1);
                $pdf->Cell($w[8],6,'',1);
                $pdf->Cell($w[9],6,'',1);
                $pdf->Cell($w[10],6,'',1);
                $pdf->Cell($w[11],6,'',1);
                $pdf->Cell($w[12],6,'',1);
                $pdf->Cell($w[13],6,'',1);
                $pdf->Cell($w[14],6,'',1);
                $pdf->Cell($w[15],6,'',1);
                $pdf->Cell($w[16],6,'',1);                

                $pdf->Ln();
                
            }
            
            
            $pdf->Ln(9);
            $pdf->MultiCell(0, 5, '_______________________             _________________________', 0, 'C');
            $pdf->MultiCell(0, 5, '                Firma Profesor                           (Solo para ser usado por la Coordinación)', 0, 'C');		
            
            
            
            $pdf->Output($desasignatura."_".$seccion."_".$_GET['Cedula'].".pdf",'D');
            
     }        
     break;    

}     
          