<?php
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require('../../../inc/fpdf.php');
require_once('../archivo/Variables.php'); 



// Creación del objeto de la clase heredada
$pdf = new FPDF('P', 'mm', 'Letter');


if(isset($_GET['Todo'])){
	$add_SQL_5 = " AND Curso.NivelCurso <= '45' ";}
else{
	$add_SQL_5 = " AND Curso.NivelCurso <= '45' ";}


$sql = "SELECT * FROM Alumno , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar'  
		AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg'
		AND AlumnoXCurso.Status = 'Inscrito' 
		$add_SQL_5
		ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2 ";
		
		
//echo $sql;		
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
$CursoAnterio = 00;

do{
	extract($row);

if($CursoAnterio != $CodigoCurso or $i==25){

	$pdf->AddPage();


    // Logo
    $pdf->Image('../../../img/Logo2012.jpg', 10, 5, 0, 20);
	$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
    // Arial bold 15
    $pdf->SetFont('Arial','B',12);
    // Movernos a la derecha
    $pdf->Cell(80);
    // Título
    $pdf->Cell(0,7,'Listado de Aprobación de la propuesta' ,0,1,'R');
//    $pdf->Cell(0,7,'Listado de Asistencia' ,0,1,'R');
	
//	$pdf->Cell(0,7,'Asamblea General de Padres y Representantes de fecha '.$Fecha_Asamblea_1ra,0,1,'R');
//	$pdf->Cell(0,7,'Asamblea General de Padres y Representantes de fecha '.$Fecha_Asamblea_2da,0,1,'R');
	$pdf->Cell(0,7,'Asamblea General de Padres y Representantes de fecha 14 de Julio de 2015',0,1,'R');//.$Fecha_Asamblea_2da

    $pdf->Cell(0,5,'Punto único: matrículas y mensualidades para el año escolar '.$AnoEscolarProx ,0,1,'R');
	$pdf->Cell(50,7, "" , 0,0,"L");
//	$pdf->Cell(50,7, Curso($CodigoCurso) , 0,0,"L");
    $pdf->Cell(145,7,'Firmo en señal de Aprobación' ,0,1,'R');


	
	$pdf->Cell(8,7,'No',1,0,'C');
	$pdf->Cell(76,7,'Alumno',1,0,'C');
	//$pdf->Cell(30,7,'Curso',1,0,'C');
	$pdf->Cell(40,7,'CI Rep',1,0,'C');
	$pdf->Cell(73,7,'Firma',1,0,'C');
	//$pdf->Cell(15,7,'Prop',1,0,'C');
    // Salto de línea
    $pdf->Ln(7);
	$pdf->Cell(0,0, '' ,'T',1);
	
if($CursoAnterio != $CodigoCurso )
	$i=0;
 
}

	$pdf->SetFont('Arial','',12);
	
	
	$ln = 8; 
	
	
	
	$pdf->Cell(8,$ln, ++$i , 1,0, 'R');
//	$pdf->Cell(76,$ln, $Apellidos .' '. $Apellidos2 .' '. $Nombres .' '. substr($Nombres2,0,1).' ('. $CodigoAlumno.")" , 1,'L');
	$pdf->Cell(76,$ln, "" , 1,'L');
	//$pdf->Cell(30,$ln, Curso($CodigoCurso) , 'LR','L');
	
	$pdf->SetFont('Arial','',9);
	
	//if($Creador_Anterior != $Creador){
		
		$query_RS_Representates = "SELECT * FROM Representante WHERE Creador = '$Creador' AND Nexo = 'Padre'"; 
		$query_RS_Representates = "SELECT * FROM RepresentanteXAlumno, Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = 'Padre'
									AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
		
		//echo $query_RS_Representates;
		$RS_Representates = mysql_query($query_RS_Representates, $bd) or die(mysql_error());
		$row_RS_Representates = mysql_fetch_assoc($RS_Representates);
		$ci_papa = $row_RS_Representates['Cedula'];
		//ucwords(strtolower($row_RS_Representates['Apellidos']." ".$row_RS_Representates['Nombres']))."<br>"; 
		
		$query_RS_Representates = "SELECT * FROM Representante WHERE Creador = '$Creador' AND Nexo = 'Madre'";  
		$query_RS_Representates = "SELECT * FROM RepresentanteXAlumno, Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = 'Madre'
									AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
		//// // echo $query_RS_Representates;
		$RS_Representates = mysql_query($query_RS_Representates, $bd) or die(mysql_error());
		$row_RS_Representates = mysql_fetch_assoc($RS_Representates);
		$ci_mama = $row_RS_Representates['Cedula'];
		//// // echo ucwords(strtolower($row_RS_Representates['Apellidos']." ".$row_RS_Representates['Nombres'])).""; 
		
		$ci_repre = $ci_papa.' / '.$ci_mama;
		
		//}else {$ci_repre='';}
	
//	$pdf->Cell(40,$ln, $ci_repre , 1 ,0, 'R' );
	$pdf->Cell(40,$ln, "" , 1 ,0, 'R' );
	$pdf->Cell(73,$ln, ""  , 1 ,0, 'R' );
	//$pdf->Cell(15,$ln, ""  , 1 ,0, 'R' );
	//.': '.$PrincipalFamilia
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	
	$CursoAnterio = $CodigoCurso;
}while ($row = mysql_fetch_assoc($RS));		  


$pdf->Output();
?>