<?php
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require('../../../inc/fpdf.php');
require_once('../archivo/Variables.php'); 

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
    // Título
//    $this->Cell(0,7,'Listado de Aprobación de propuesta',0,1,'R');
    $this->Cell(0,7,'Listado de Asistencia a la Asamblea',0,1,'R');
	
//	$this->Cell(0,7,'Asamblea General de Padres y Representantes de fecha '.$Fecha_Asamblea_1ra,0,1,'R');
//	$this->Cell(0,7,'Asamblea General de Padres y Representantes de fecha '.$Fecha_Asamblea_2da,0,1,'R');
	$this->Cell(0,7,'Asamblea General de Padres y Representantes de fecha 7 de Junio de 2016',0,1,'R');

	

    $this->Cell(0,7,'Punto: Ajuste estructura de costos 2015-2016 y Matricula y Escolaridad para el año 2016-2017' ,0,1,'R');

   $this->Cell(0,7,' n ' ,1,1,'R');
	
	
	$this->Cell(12,7,'No.',1,0,'C');
	$this->Cell(76,7,'Alumno',1,0,'C');
	//$this->Cell(30,7,'Curso',1,0,'C');
	$this->Cell(40,7,'CI Rep',1,0,'C');
	$this->Cell(68,7,'Firma',1,0,'C');
    // Salto de línea
    $this->Ln(7);
	$this->Cell(0,0, '' ,'T',1);
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
$pdf->AddPage();


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


$sql = "SELECT * FROM Alumno , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar'  
		AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg'
		AND AlumnoXCurso.Status = 'Inscrito' 
		$add_SQL_5
		ORDER BY Alumno.Apellidos, Alumno.Apellidos2";
//echo $sql;		
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
//	AND AlumnoXCurso.CodigoCurso <= 42 
 
do{
	extract($row);
	$pdf->SetFont('Arial','',12);
	
	if($Creador_Anterior != $Creador){
	$pdf->Cell(0,0, '' ,'T',1);
	$i++;
	$ln = 7; }
	else{
	$ln = 4;	}
	
	
	
	$pdf->Cell(12,$ln, $i , 'L',0, 'R');
	$pdf->Cell(76,$ln, $Apellidos .' '. $Apellidos2 .' '. $Nombres .' '. substr($Nombres2,0,1).' '. $CodigoAlumno , 'L','L');
	$pdf->Cell(30,$ln, Curso($CodigoCurso) , 'LR','L');
	
	$pdf->SetFont('Arial','',9);
	
	if($Creador_Anterior != $Creador){
		
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
		
		}else {$ci_repre='';}
	
	$pdf->Cell(40,$ln, $ci_repre , 'LR' ,0, 'R' );
	$pdf->Cell(38,$ln, $CodigoFamilia  , 'LR' ,0, 'R' );
	//.': '.$PrincipalFamilia
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	
	$Creador_Anterior = strtolower($Creador);
}while ($row = mysql_fetch_assoc($RS));		  


$pdf->Output();
?>