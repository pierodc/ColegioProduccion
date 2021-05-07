<?php 
$MM_authorizedUsers = "docente,91";
require_once('../../inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once('../../Connections/bd.php');
require_once('../../intranet/a/archivo/Variables.php');
require_once('../../inc/rutinas.php'); 
require_once('../../inc/fpdf.php');

class PDF extends FPDF
{
	//Cabecera de página
	function Header() {
		}
	//Pie de página
	function Footer() {
			// Posición: a 1,5 cm del final
			$this->SetY(-30);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
		   // $this->Cell(0,10,'Pag '.$this->PageNo(),0,0,'R');
		}
}
$linea = 5;
$tipologia = 'Arial';
$Borde = 1;
$pdf=new PDF('P', 'mm', 'Letter');

$pdf->SetAutoPageBreak(1,10);
$pdf->SetMargins(10,10,20);


$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];
$Curso->Ano = $AnoEscolar;
$Listado = $Curso->ListaCurso();
$NivelCurso = $Curso->NivelCurso();

$pdf->AddPage();
$pdf->Image('../../img/solcolegio.jpg',10,10,0,40);
$pdf->Image('../../img/NombreCol_az.jpg',60, 20, 0, 20);
$pdf->SetXY(30,50);
$pdf->SetFont('Arial','',14);
$pdf->Cell(40,$linea*1.5, "Curso: " ,0,0,'R');
$pdf->Cell(100,$linea*1.5, $Curso->NombreCurso() ,"LB",1,'L');
$pdf->Ln(8);
 
foreach($Listado as $Alumno) 	{	
	$Alumno = new Alumno($Alumno['CodigoAlumno']);

	
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(40,$linea*1.5, "Alumno: " ,1,0,'R');
	$pdf->Cell(100,$linea*1.5, $Alumno->NombreApellido() ,1,1,'L');
	
	$query_Observaciones = "SELECT * FROM Observaciones 
							WHERE CodigoAlumno = $Alumno->id 
							AND Area = 'Boleta'
							AND Ano = '$AnoEscolar'
							ORDER BY Fecha DESC, Hora DESC";
	$Observaciones = $mysqli->query($query_Observaciones);
	if($row_Observaciones = $Observaciones->fetch_assoc()){
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(190,$linea*1.5, "Observaciones "  ,0,1,'L');
		$pdf->SetFont('Arial','',12);
		$pdf->write($linea, $row_Observaciones['Observacion']);
		
		}
	$pdf->Ln(8);

//break; // dev
}

// Cierra boleta
if($Cuenta_Lapso > 0){ 
	$Promedio_Lapso = round($Suma_Lapso/$Cuenta_Lapso,0);
	// Promedio del lapso $Promedio_Lapso; 	   
}


$pdf->Output();

?>
