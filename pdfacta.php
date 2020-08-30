<?php
require('fpdf.php');

class PDF extends FPDF
{
	var $nombreReporte;
        var $nombreCarrera;
        var $nombreAsignatura;
        var $nombreSede;
        var $nombreSeccion;
        var $nombreDocente;
        var $cedulaDocente;
        var $nombreSemestre;
        var $subTitulo;
	var $subTitulo1;
        var $subTitulo2;
        var $subTitulo3;
	var $constancia;
	var $primeraPagina;
        var $nombreDocenteSolo;

	
	// Cabecera de página
	function Header()
	{
		
            if ($this->primeraPagina == 1){
                $this->SetFont('Arial','B',8);
                $vfecha = getdate ();
                $this->Image('../imagenes/logoUNEG.png',10,5,12,10,'PNG','');
                $this->Text(25,9,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA');
                $this->Text(25,13,'COORDINACIÓN GENERAL DE PREGRADO');
                $this->Text(25,17,'SEDE ' . $this->nombreSede);
                $this->Text(25,21,'PROYECTO DE CARRERA ' . $this->nombreCarrera);
                $this->Text(25,25,'UNIDAD CURRICULAR ' . $this->nombreAsignatura . '  SEMESTRE ' . $this->nombreSemestre . '  SECCIÓN ' . $this->nombreSeccion) ;
                $this->Text(25,29,'DOCENTE ' . $this->nombreDocente);
                $this->Text(180,9,'FECHA: ' . $vfecha['mday'] . '/' . $vfecha['mon'] . '/' . $vfecha['year'],0,'R');
                $this->Text(180,13,'PÁGINA: ' . $this->PageNo(),0,'R');
                $this->Ln(22);
                $this->Cell(80);

                $this->Cell(30,10,$this->nombreReporte,0,0,'C');


                if (strlen($this->subTitulo)>0){
                        $this->Ln(3);
                        $this->Cell(80);
                        $this->Cell(30,10,$this->subTitulo,0,0,'C');
                }
			
		
		
			
            }
            else{
                if ($this->primeraPagina == 2){
                    $this->SetFont('Arial','B',8);
                    $vfecha = getdate ();
                    $this->Image('../imagenes/logoUNEG.png',10,5,12,10,'PNG','');
                    $this->Text(25,9,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA');
                    $this->Text(25,13,'SECRETARÍA');
                    $this->Text(25,17,'COORDINACIÓN DE ADMISIÓN Y CONTROL DE ESTUDIOS');
                    $this->Text(25,21,'SEDE ' . $this->nombreSede);
                    $this->Text(25,25,'PROYECTO DE CARRERA ' . $this->nombreCarrera);
                    $this->Text(25,29,'UNIDAD CURRICULAR ' . $this->nombreAsignatura . '  SEMESTRE ' . $this->nombreSemestre . '  SECCIÓN ' . $this->nombreSeccion) ;
                    $this->Text(25,33,'DOCENTE ' . $this->nombreDocente);
                    $this->Text(180,9,'FECHA: ' . $vfecha['mday'] . '/' . $vfecha['mon'] . '/' . $vfecha['year'],0,'R');
                    $this->Text(180,13,'PÁGINA: ' . $this->PageNo(),0,'R');
                    $this->Ln(22);
                    $this->Cell(80);

                    $this->Cell(30,10,$this->nombreReporte,0,0,'C');


                    if (strlen($this->subTitulo)>0){
                            $this->Ln(3);
                            $this->Cell(80);
                            $this->Cell(30,10,$this->subTitulo,0,0,'C');
                    }


                    //Salto de línea
                    $this->Ln(15);
		
                    $this->Cell(10,10,'RG',1,0,'C');
                    $this->Cell(20,10,'CÉDULA',1,0,'C');
                    $this->Cell(85,10,'APELLIDOS Y NOMBRES',1,0,'C');
                    $this->Cell(40,5,'NOTA DEFINITIVA',1,0,'C');
                    $this->Cell(20,10,'NO ASISTIÓ',1,0,'C');
                    $this->Cell(20,10,'ABANDONÓ',1,0,'C');
                    $this->Ln(5);
                    $this->Cell(115);
                    $this->Cell(20,5,'EN NÚMERO',1,0,'C');
                    $this->Cell(20,5,'EN LETRAS',1,1,'C');	                    
                }
                else{
                    if ($this->primeraPagina == 3){
                        $this->SetFont('Arial','B',8);
                        $vfecha = getdate ();
                        $this->Image('../imagenes/logoUNEG.png',10,5,12,10,'PNG','');
                        $this->Text(25,9,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA');
                        //$this->Text(25,13,'SECRETARÍA');
                        //$this->Text(25,17,'COORDINACIÓN DE ADMISIÓN Y CONTROL DE ESTUDIOS');
                        $this->Text(25,13 ,'SEDE ' . $this->nombreSede);
                        $this->Text(25,17 ,'PROYECTO DE CARRERA ' . $this->nombreCarrera);
                        $this->Text(25, 21 ,'UNIDAD CURRICULAR ' . $this->nombreAsignatura . '  SEMESTRE ' . $this->nombreSemestre . '  SECCIÓN ' . $this->nombreSeccion) ;
                        $this->Text(25, 25 ,'DOCENTE ' . $this->nombreDocente);
                        $this->Text(180,9,'FECHA: ' . $vfecha['mday'] . '/' . $vfecha['mon'] . '/' . $vfecha['year'] ,0,'R');
                        $this->Text(180,13,'HORA: ' . $vfecha['hours'] . ":" . $vfecha['minutes'] ,0,'R');
                        $this->Text(180,17,'PÁGINA: ' . $this->PageNo(),0,'R');
                        $this->Ln(22);
                        $this->Cell(80);

                        $this->Cell(30,10,$this->nombreReporte,0,0,'C');


                        if (strlen($this->subTitulo1)>0){
                                $this->SetFont('Arial','B',6);
                                $this->Ln(3);
                                $this->Cell(80);
                                $this->Cell(30,10,$this->subTitulo1,0,0,'C');
                        }
                        
                        if (strlen($this->subTitulo2)>0){
                                $this->Ln(3);
                                $this->Cell(80);
                                $this->Cell(30,10,$this->subTitulo2,0,0,'C');
                        }
                        
                        if (strlen($this->subTitulo3)>0){
                                $this->Ln(3);
                                $this->Cell(80);
                                $this->Cell(30,10,$this->subTitulo3,0,0,'C');
                        }

                        //Salto de línea
                        $this->Ln(13);
                        $this->SetFont('Arial','B',8);
                        $this->Cell(10,10,'RG',1,0,'C');
                        $this->Cell(20,10,'CÉDULA',1,0,'C');
                        $this->Cell(85,10,'APELLIDOS Y NOMBRES',1,0,'C');
                        $this->Cell(40,5,'NOTA PRODUCTO',1,0,'C');
                        $this->Cell(20,10,'NO ASISTIÓ',1,0,'C');
                        
                        $this->Ln(5);
                        $this->Cell(115);
                        $this->Cell(20,5,'EN NÚMERO',1,0,'C');
                        $this->Cell(20,5,'EN LETRAS',1,1,'C');	                    
                    } 
                    
                }
                
            }
	}
	
	// Pie de página
	function Footer()
	{
		
		//Posición: a 2,5 cm del final
		$this->SetY(-25);
		//Arial italic 8
		$this->SetFont('Arial','B',8);
		//Número de página
		$this->Cell(95,5,'PROFESOR',1,0,'L');
		$this->Cell(30,5,'CI',1,0,'C');
		$this->Cell(40,5,'FIRMA',1,0,'C');
		$this->Cell(30,5,'FECHA',1,0,'C');
		//$this->Cell(0,10,'Pág '.$this->PageNo().'/{nb}',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',8);
		$this->Cell(95,8,$this->nombreDocenteSolo,1,0,'L');
		$this->Cell(30,8,$this->cedulaDocente,1,0,'C');
		$this->Cell(40,8,'',1,0,'C');
		$this->Cell(30,8,'',1,0,'C');
		
	}
	
	
	function setNombreReporte($nombre){
		$this->nombreReporte = $nombre;
	}
        function setNombreCarrera($nombre){
		$this->nombreCarrera = $nombre;
	}
	function setNombreSede($nombre){
		$this->nombreSede = $nombre;
	}
        function setNombreAsignatura($nombre){
            $this->nombreAsignatura = $nombre;
	}

        function setSeccion($nombre){
            $this->nombreSeccion = $nombre;
	}
        
        function setSemestre($nombre){
            $this->nombreSemestre = $nombre;
	}
        
        function setDocente($cedula, $nombre){
            $this->nombreDocente = $cedula . " - " . $nombre;
            $this->cedulaDocente = $cedula;
            $this->nombreDocenteSolo = $nombre;
	}
        
        function setSubtitulo($sub){
		$this->subTitulo = $sub;
	}
        
	function setSubtitulo1($sub){
		$this->subTitulo1 = $sub;
	}
	
        function setSubtitulo2($sub){
		$this->subTitulo2 = $sub;
	}
        
        function setSubtitulo3($sub){
		$this->subTitulo3 = $sub;
	}
        
	function setPrimeraPagina($pag){
		$this->primeraPagina = $pag;
	}
	function setFecha($fecha){
		$this->fecha = $fecha;
	}
	
	function bold($val){
        $this->SetFont('Arial','B',8);
        return $this->Text($this->getX()+(strlen($val)/2),$this->getY(),$val);
    }
	
	function normal($val){
        $this->SetFont('Arial','',8);
        return $this->Text($this->getX()+(strlen($val)/2),$this->getY(),$val);
    }
	
	function pie_pagina_comunicacion($w=160,$base=250)   
	{   
		$fuente_ant=$this->FontFamily;
		$estilo_fuente_ant=$this->FontStyle;
		$tam_fuente_ant=$this->FontSizePt;	
		$this->SetFont("Times",'',10);
		$this->SetY($base);
		$this->Cell($w,0,"_______________________________________________________ UNEG La Universidad del Siglo XXI",0,0,"C",0);
		$this->SetY($base+5);
		$this->Cell($w,0,"Edificio General de Seguros, Avenida Las Américas. Puerto Ordaz, Estado Bolívar - Venezuela",0,0,"C",0);	
		$this->SetFont($fuente_ant,$estilo_fuente_ant,$tam_fuente_ant);
	}
	
	function ImprimirTexto($texto,$letra='Times',$tam=12,$align="J",$interl=5,$incluir_ln=true,$negrilla="0")
	{    
		//Times 12
		if ($negrilla == "0")
		{
		$this->SetFont($letra,'',$tam);
		}
		else
		{
	    $this->SetFont($letra,'B',$tam);
		}
		//Imprimimos el texto justificado
		$this->MultiCell(0,$interl,$texto,0,$align);
		//Salto de línea
		if ($incluir_ln)
		 $this->Ln();
	}
	
        
        ///AGREGADO POR RPULIDO
        
function SetWidths($w) 
{ 
    //Set the array of column widths 
    $this->widths=$w; 
} 

function SetAligns($a) 
{ 
    //Set the array of column alignments 
    $this->aligns=$a; 
} 

function fill($f)
{
	//juego de arreglos de relleno
	$this->fill=$f;
}

        
        

}
?>
