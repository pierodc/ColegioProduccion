<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 4.25;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);

//$pdf->SetMargins(5,5,5);

$pdf->SetFont('Arial','',12);

// Ejecuta $sql y While
$sql = "SELECT * FROM Alumno, AlumnoXCurso, Curso
					  WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
					  AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
					  
					  AND AlumnoXCurso.Ano = '$AnoEscolarProx'
					  AND AlumnoXCurso.Status = 'Solicitando'
	
					  AND AlumnoXCurso.Status_Proceso_Ins <> 'No'
					  AND AlumnoXCurso.Status_Proceso_Ins <> 'Lista'
					  AND AlumnoXCurso.Status_Proceso_Ins <> 'Lista2'
					  
					  ORDER BY Curso.NivelCurso, Status_Proceso_Ins, Apellidos, Apellidos2, Nombres, Nombres2 ";

//$Curso
$sql = "SELECT * FROM Alumno, AlumnoXCurso, Curso
					  WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
					  AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
					  
					  AND AlumnoXCurso.Ano = '$AnoEscolarProx'
					  AND AlumnoXCurso.Status = 'Solicitando'

					  AND AlumnoXCurso.Status_Proceso_Ins <> 'No'
					  AND AlumnoXCurso.Status_Proceso_Ins <> 'Lista'
					  AND AlumnoXCurso.Status_Proceso_Ins <> 'Lista2'
					  
					  ORDER BY Curso.NivelCurso, Status_Proceso_Ins, Apellidos, Apellidos2, Nombres, Nombres2, Fecha_Registro ";


$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);

	if($NivelCursoAnte != $NivelCurso){
		$pdf->AddPage();
		$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		$pdf->SetY( 30 );
		$pdf->Cell(40 , $Ln , Curso($CodigoCurso) , 0 , 0 , 'L'); 
		$pdf->Ln($Ln);
		}
	
	if($Status_Proceso_InsAnte != $Status_Proceso_Ins){
		$pdf->Cell(40 , $Ln , $Status_Proceso_Ins , 0 , 0 , 'L'); 
		$pdf->Ln($Ln);
		$No=0;
	}
	
		
	if(substr($Creador,0,2) != "x_"){
		$NivelCursoAnte = $NivelCurso;
		$Status_Proceso_InsAnte = $Status_Proceso_Ins;
		$pdf->Cell(5);
		$pdf->Cell(8 , $Ln , ++$No  , $borde , 0 , 'R'); 
		$pdf->Cell(60 , $Ln , $Apellidos.' '.$Nombres  , $borde , 0 , 'L'); 
		$pdf->Cell(10 , $Ln , ""  , $borde , 0 , 'L'); 
		$pdf->Cell(10 , $Ln , ""  , $borde , 0 , 'L'); 
		$pdf->Cell(10 , $Ln , ""  , $borde , 0 , 'L'); 
		$pdf->Cell(10 , $Ln , ""  , $borde , 0 , 'L'); 
		$pdf->Cell(10 , $Ln , ""  , $borde , 0 , 'L'); 
		$pdf->Ln($Ln);
	}
	
}







$pdf->Output();
?>