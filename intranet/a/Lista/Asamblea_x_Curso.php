<?php
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require('../../../inc/fpdf.php');
require_once('../archivo/Variables.php'); 

$Asist = $_GET['Asis'];

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
require('../archivo/Variables.php'); 
    // Logo
    $this->Image('../../../img/Logo2012.jpg', 10, 5, 0, 20);
	$this->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Cell(80);
 
 // AJUSTAR ESTAS 3 VARIABLES
 	
 	
 	if($_GET['Conv'] == 1){
		$Conv = "1ra";
		$Hora = "7:30am";
	}
	else{	
		$Conv = "2da";
		$Hora = "8:00am";
	}
	
	$FechaHora = "17 de Octubre de 2019 $Hora";		
		
	$Asist = $_GET['Asis'];
// FIN AJUSTAR	
	
	
	if ($Asist == 1){
		$ListaDe = "ASISTENCIA $Conv convocatoria";
		$FirmoSenalDe = "ASISTENCIA a la asamblea.";
		}
	else{
		$ListaDe = "Aprobación de propuesta $Conv convocatoria";
		$FirmoSenalDe = "APROBACIÓN de lo planteado en la asamblea.";
		}
	
	

	$this->Cell(0,7,"Listado de $ListaDe ",0,1,'R');
	$this->Cell(0,5,"Asamblea General de Padres y Representantes de fecha $FechaHora",0,1,'R');
    $this->SetFont('Arial','B',10);
	$this->Cell(0,5,"Punto: Matrícula y Escolaridad para el año escolar 2019-2020" ,0,1,'R');
	$this->SetFont('Arial','B',12);
    $this->Cell(0,5,"Firmo en señal de $FirmoSenalDe" ,0,1,'R');
	
	
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pág '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();

/*
if( $_GET['Todo']==1 ){ // Asigna numero a las familias Y ASigna '1' a PrincipalFamilia
	$sql="UPDATE Alumno SET CodigoFamilia = 0, PrincipalFamilia = 0 ";
	$RS = mysql_query($sql, $bd) or die(mysql_error());

	
	$sql="SELECT * FROM Alumno , AlumnoXCurso , Curso
			WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
			AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
			AND AlumnoXCurso.Ano = '$AnoEscolar' 
			AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg'
			AND AlumnoXCurso.Status = 'Inscrito'   
			ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Curso.NivelCurso DESC";
	//echo $sql.'<br>';		
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
		do{
			extract($row);
			//echo '<br>'.$CodigoAlumno.' '.$Creador.' '.$Apellidos.' '.$Apellidos2.'<br>';
//	 		$Creador_Anterior = strtolower($Creador_Anterior);	
//	 		$Creador = strtolower($Creador);	
			if($Creador_Anterior != $Creador){
				

				if($CodigoFamilia == 0){
					$sql_2="UPDATE Alumno SET PrincipalFamilia = '1' 
							WHERE CodigoAlumno = '".$CodigoAlumno."'
							AND PrincipalFamilia = '0'";
					$RS_2 = mysql_query($sql_2, $bd);
					//echo $sql_2.'<br>';		
					
					$sql_2="UPDATE Alumno SET CodigoFamilia = '". ++$SigienteFamilia ."' 
							WHERE Creador = '".$Creador."'
							AND CodigoFamilia = '0'";
					$RS_2 = mysql_query($sql_2, $bd);
					//echo $sql_2.'<br>';		
				}
			
				//$sql_2="UPDATE Alumno SET PrincipalFamilia = '1' WHERE CodigoAlumno = ".$CodigoAlumno;
				//$sql_2="UPDATE Alumno SET CodigoFamilia = '".$SigienteFamilia++."' WHERE Creador = '".$Creador."'";
				
			}
			$Creador_Anterior = strtolower($Creador);
		} while ($row = mysql_fetch_assoc($RS));
		
	
	$sql="UPDATE Alumno SET PrincipalFamilia = 0 ";
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	
	$sql="SELECT * FROM Alumno , AlumnoXCurso, Curso 
			WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
			AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
			AND AlumnoXCurso.Ano = '$AnoEscolar'  
			AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg'
			AND AlumnoXCurso.Status = 'Inscrito' 
			AND Curso.NivelCurso <= '45' 
			ORDER BY Alumno.CodigoFamilia, Curso.NivelCurso DESC";
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$CodigoFamiliaAnterior = 0;
	$Creador_Anterior = "";
	while ($row = mysql_fetch_assoc($RS)){
		extract($row);
		//echo $CodigoFamilia.'<br>';		
		if($Creador_Anterior != strtolower($Creador)){
			$sql_2="UPDATE Alumno SET PrincipalFamilia = '1' 
							WHERE CodigoAlumno = '".$CodigoAlumno."'";
			//echo $sql_2.' '.$CodigoFamilia.'<br>';		
			mysql_query($sql_2, $bd);
			}
		
		
		$Creador_Anterior = strtolower($Creador);
		
		//$CodigoFamiliaAnterior = $CodigoFamilia;
		}
		
		
}


if(isset($_GET['Todo'])){
	$add_SQL_5 = " AND Curso.NivelCurso <= '45' ";}
else{
	$add_SQL_5 = " AND Curso.NivelCurso <= '44' ";}
*/


$sql = "SELECT * FROM Alumno , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar'  
		AND AlumnoXCurso.Tipo_Inscripcion  <> 'Mp'
		AND AlumnoXCurso.Status = 'Inscrito' 
		$add_SQL_5
		ORDER BY Curso.NivelCurso, Curso.Curso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2 DESC";
//echo $sql;		
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
//	AND AlumnoXCurso.CodigoCurso <= 42 
$ln = 7;
do{
	
	
	extract($row);
	$pdf->SetFont('Arial','',12);
	if($CodigoCurso_ante != $CodigoCurso){
		$pdf->AddPage();
		$pdf->SetFillColor(255);
		$pdf->Cell(50,$ln, "Curso: ".Curso($CodigoCurso) , 0,'L');
		$pdf->Ln(7);
		$pdf->Cell(12,14,'No',1,0,'C',1);
		$pdf->Cell(60,14,'Alumno',1,0,'C',1);
		$pdf->Cell(35,14,'CI Rep',1,0,'C',1);
		if($Asist == 1){
			$pdf->Cell(86,14,'Firma',1,0,'C',1);
			$pdf->Ln(7);
		}
		else{
			
			$pdf->Cell(43,7,'Propuesta 1',"TLR",0,'C',1);
			$pdf->Cell(43,7,'Propuesta 2',"TLR",0,'C',1);
			$pdf->Ln(7);
			$pdf->Cell(107);
			$pdf->Cell(43,7,'45',"TLR",0,'C',1);
			$pdf->Cell(43,7,'40/48',"TLR",0,'C',1);
			// (Mensualidad BsS 47.000,99)
			}
		$pdf->Ln(7);

		$i = 0;		
	}

	$ln = 7; 
	
	$i++;
	$pdf->Cell(12,$ln, $i , 1,0, 'R');
	$pdf->Cell(60,$ln, $Apellidos .' '. $Apellidos2 .' '. $Nombres .' '. substr($Nombres2,0,1) , 1,'L',1);
	
	$pdf->SetFont('Arial','',9);
	
		
		
$query_RS_Representates = "SELECT * FROM RepresentanteXAlumno, Representante 
							WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
							AND RepresentanteXAlumno.Nexo = 'Padre'
							AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";

$RS_Representates = mysql_query($query_RS_Representates, $bd) or die(mysql_error());
$row_RS_Representates = mysql_fetch_assoc($RS_Representates);
$ci_papa = $row_RS_Representates['Cedula'];

		
$query_RS_Representates = "SELECT * FROM RepresentanteXAlumno, Representante 
							WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
							AND RepresentanteXAlumno.Nexo = 'Madre'
							AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
$RS_Representates = mysql_query($query_RS_Representates, $bd) or die(mysql_error());
$row_RS_Representates = mysql_fetch_assoc($RS_Representates);
$ci_mama = $row_RS_Representates['Cedula'];

$ci_repre = $ci_papa.' / '.$ci_mama;
		
	
	$pdf->Cell(35,$ln, $ci_repre , 1 ,0, 'R',1 );
	
	if($Asist == 1){
		$pdf->Cell(86,$ln, "" , 1 ,0, 'R',1 );
	}
	else{
		$pdf->Cell(43,$ln, "" , 1 ,0, 'R',1 );
		$pdf->Cell(43,$ln, "" , 1 ,0, 'R',1 );
		}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	
	$CodigoCurso_ante = $CodigoCurso;
}while ($row = mysql_fetch_assoc($RS));		  


$pdf->Output();
?>