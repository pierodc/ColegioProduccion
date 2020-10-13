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

//echo "_CodigoCurso $_id_Curso";
//ENCABEZADO
		
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$Ln = 8;
$pdf->SetY( 30 );
$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/Sol.png', 10, 5, 0, 16);
$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 22 );

$pdf->Cell(35 , $Ln , Curso($_id_Curso) , 0 , 0 , 'L'); 
$pdf->Ln();

$pdf->SetFont('Arial','', 12);
$borde = 1;

$pdf->Cell(8 , $Ln , "No" , $borde , 0 , 'R'); 	
$pdf->Cell(14 , $Ln , "Cod" , $borde , 0 , 'C');
$pdf->Cell(50 , $Ln , "Alumno" , $borde , 0 , 'L');
for ($k = 1; $k <= 14; $k++)
	$pdf->Cell(9 , $Ln , " " , $borde , 0 , 'L');
$pdf->Ln();

while ($row = $Alumnos->fetch_assoc()) {
	//echo "while";
	extract($row);
	$Alumno->id = $CodigoAlumno;
	// No lista
		$pdf->Cell(8 , $Ln , ++$i , $borde , 0 , 'R'); 	


	// Codigo Alumno
	$pdf->Cell(14 , $Ln , $Alumno->id , $borde , 0 , 'R'); 

	$pdf->Cell(50 , $Ln , $Alumno->NombreApellido() , $borde , 0 , 'L'); // Nombres del alumno
	
	for ($k = 1; $k <= 14; $k++)
		$pdf->Cell(9 , $Ln , " " , $borde , 0 , 'L');
	
	$pdf->Ln();
}

$pdf->Output();
		


?>