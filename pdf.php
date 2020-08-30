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
        var $nombreSemestre;
	var $subTitulo;
	var $constancia;
	var $primeraPagina = 0;

	
	// Cabecera de página
	function Header()
	{
		if ($this->primeraPagina == 1)
		{
			$this->Image('../imagenes/logoUNEG.png',100,10,18,18,'PNG','');
		}
		else
		{
			if ($this->primeraPagina == 2)
			{  
			        $this->SetFont('Arial','',9);
					$vfecha = getdate ();
					$this->Image('../imagenes/logoUNEG.png',20,10,18,18,'PNG','');
					$this->Text(40,14,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA');
					$this->Text(40,18,'COORDINACIÓN GENERAL DE PREGRADO');
					$this->Text(40,22,'ASISTENCIA DOCENTE');
					$this->SetFont('Arial','B',10);
					$this->Text(40,30,$this->nombreReporte);
					 $this->SetFont('Arial','',9);
					$this->Text(160,14,'NTG: TG-' . $this->AnoPropuesta . '-' . $this->CodPropuesta ,0,'R');
					$this->Text(160,18,'ACUERDO N°:_______________' ,0,'R');
					//$this->Text(150,40,'Ciudad Guayana,' . $vfecha['mday'] . ' de ' . GetMonth($vfecha['mon']) . ' ' . $vfecha['year'] ,0,'R');
					/*$this->Ln(5);
					$this->Cell(80);
					$this->Cell(30,10,$this->nombreReporte,0,0,'C');
					if (strlen($this->subTitulo)>0)
					{
						$this->Ln(3);
						$this->Cell(80);
						$this->Cell(30,10,$this->subTitulo,0,0,'C');
					}*/
			}else{
			if ($this->primeraPagina == 3)
			{  
			        $this->SetFont('Arial','',9);
					$vfecha = getdate ();
					$this->Image('../imagenes/logoUNEG.png',20,10,18,18,'PNG','');
					$this->Text(40,14,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA');
					$this->Text(40,18,'COORDINACIÓN GENERAL DE PREGRADO');
					$this->Text(40,22,'COMISIONES DE TRABAJO DE GRADO');
					$this->SetFont('Arial','B',10);
					$this->Text(40,30,$this->nombreReporte);
					 $this->SetFont('Arial','',9);
					$this->Text(160,14,'FECHA: ' . $this->fecha ,0,'R');
					$this->Text(160,18,'ACUERDO N°:_______________' ,0,'R');
					//$this->Text(150,40,'Ciudad Guayana,' . $vfecha['mday'] . ' de ' . GetMonth($vfecha['mon']) . ' ' . $vfecha['year'] ,0,'R');
					/*$this->Ln(5);
					$this->Cell(80);
					$this->Cell(30,10,$this->nombreReporte,0,0,'C');
					if (strlen($this->subTitulo)>0)
					{
						$this->Ln(3);
						$this->Cell(80);
						$this->Cell(30,10,$this->subTitulo,0,0,'C');
					}*/
			}
			else
			{
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
			   }
		}
		
		$this->Ln(5);		
	}
	
	// Pie de página
	function Footer()
	{
		
	if ($this->tipofooter == 1)
		{
		}
		/*	else
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}*/
		
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
	}
        
	function setSubtitulo($sub){
		$this->subTitulo = $sub;
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
