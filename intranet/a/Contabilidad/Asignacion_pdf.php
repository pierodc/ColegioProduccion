<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');



$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 5;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->Ln(15);
//Reticula($pdf);
//$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,15,5);

$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
$pdf->SetFont('Arial','',12);

// Ejecuta $sql y While
$CodigoAsignacion = $_GET['CodigoAsignacion'];
$sql = "SELECT * FROM ContableMov, Alumno, AlumnoXCurso, Curso
			WHERE ContableMov.CodigoPropietario = Alumno.CodigoAlumno 
			AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno
			AND ContableMov.Referencia = '$CodigoAsignacion' 
			AND ContableMov.MontoDebe > 0
			AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
			GROUP BY Alumno.CodigoAlumno 
			ORDER BY Alumno.Apellidos, Alumno.Apellidos2 ";

//echo $sql;
$RS = $mysqli->query($sql);

$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);

while ($row = $RS->fetch_assoc()) {
	extract($row);
	
	$Alumno->id = $CodigoAlumno;
	$pdf->Cell(10 , $Ln , ++$No . " " , $borde , 0 , 'R'); 
	$pdf->Cell(12 , $Ln , $Alumno->id  , $borde , 0 , 'R'); 
	$pdf->Cell(90 , $Ln , $Alumno->ApellidosNombres() , $borde , 0 , 'L'); 
	
	
	
	
	
	$query_ = "SELECT * FROM ContableMov 
				WHERE CodigoPropietario = '".$Alumno->id."' 
				AND Referencia = '$CodigoAsignacion'";
	$RS_ = $mysqli->query($query_);

	if($row_RS_ = $RS_->fetch_assoc()){

		$txt = "";
		if ($row_RS_['SWCancelado'] == "1"){
			$txt = "pago";
			}
		else{
			$txt = Fnum($row_RS_['MontoDebe']);
		}

		$pdf->Cell(90 , $Ln , $txt , $borde , 0 , 'L'); 



	}

	
	
	$pdf->Ln($Ln);
}




//$pdf->Image('../../../img/SelloCol.jpg',145,108,0,18);
	





$pdf->Output();
?>