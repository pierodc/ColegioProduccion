<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rpdf.php'); 
	
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);
$AlumnoXCurso = new AlumnoXCurso();

$Alumnos = $AlumnoXCurso->view($_id_Curso);
$pdf = new FPDF("P", 'mm', 'Letter');

echo "_CodigoCurso $_CodigoCurso";
	

while ($row = $Alumnos->fetch_assoc()) {
	echo "while";
	extract($row);
	$Alumno->id = $CodigoAlumno;
			
		//ENCABEZADO
		$pdf->SetFont('Arial','B',14);
		$pdf->AddPage();
			
		$pdf->SetY( 30 );
		$pdf->Image('/img/solcolegio.jpg', 10, 5, 0, 16);
		$pdf->Image('/img/NombreCol.jpg' , 30, 5, 0, 12);
		$pdf->SetY( 22 );
		
		$pdf->Cell(35 , $Ln , $TituloPag.'' , 0 , 0 , 'L'); 
		
		
		
		// No lista
			$pdf->Cell(6 , $Ln , ++$i , $borde , 0 , 'R'); 	
			
	
		// Codigo Alumno
			$pdf->Cell(12 , $Ln , $Alumno->id , $borde , 0 , 'R'); 
		
		$pdf->Cell($AnchoNombre , $Ln , $Alumno->NombreApellido , $borde , 0 , 'L'); // Nombres del alumno
	
	
}

$pdf->Output();
		


?>