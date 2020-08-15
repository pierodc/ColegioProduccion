<?php 
$Orden = 'Cedula';

require_once('../../../../Connections/bd.php');  
require_once('../../archivo/Variables.php');  
require_once('../../../../inc/rutinas.php');  
require_once('../../../../inc/fpdf.php'); 


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$Lin = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15');

$borde = 0;
$Ln = 4.25;

$pdf=new FPDF('P', 'mm', 'Legal');
$pdf->SetFillColor(255,255,255);

// Ejecuta $sql y While

$pdf->SetXY(10,60);	

if(isset($_GET['Ano']))	
	$Ano2 = $_GET['Ano'];

if($_GET['Revision']=='1')		
	$Fecha_Aux = " AND AlumnoXCurso.FechaGrado = '' ";
else
	$Fecha_Aux = " AND AlumnoXCurso.FechaGrado = 'Julio20".$Ano2."' ";
	
$CodigoCurso = $_GET['CodigoCurso'];

$sqlCurso = "SELECT * FROM Curso WHERE CodigoCurso = '$CodigoCurso'";
$RScurso = $mysqli->query($sqlCurso);
$rowCurso = $RScurso->fetch_assoc();
//AND AlumnoXCurso.FechaGrado = '$Fecha_Aux' 
if(isset($_GET['AnoEscolar'])){
	$AnoEscolar = $_GET['AnoEscolar'];
	}
$query_RS_Alumno = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
							WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
							AND AlumnoXCurso.NumeroTitulo > '5562382'
							AND AlumnoXCurso.Ano = '%s' 
							AND AlumnoXCurso.Status = 'Inscrito'  
							$Fecha_Aux
							AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
							
							ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2",   $AnoEscolar );
							
$query_RS_AlumnoX = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
							WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
							AND Alumno.CodigoAlumno <> 1954 AND Alumno.CodigoAlumno <> 2488
							AND AlumnoXCurso.NumeroTitulo > '5562382'
							AND AlumnoXCurso.Ano = '%s' 
							AND AlumnoXCurso.Status = 'Inscrito'  
							AND AlumnoXCurso.FechaGrado = '' 
							AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
							ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2",   $AnoEscolar );

// pinzon y asc
$query_RS_AlumnoX = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
							WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
							AND (Alumno.CodigoAlumno = 1954 OR Alumno.CodigoAlumno = 2488)
							AND AlumnoXCurso.NumeroTitulo > '5562382'
							AND AlumnoXCurso.Ano = '%s' 
							AND AlumnoXCurso.Status = 'Inscrito'  
							AND AlumnoXCurso.FechaGrado = '' 
							AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
							ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2",   $AnoEscolar );
	
$query_RS_AlumnoX = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
							WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
							AND AlumnoXCurso.NumeroTitulo > '5562382'
							AND AlumnoXCurso.Ano = '%s' 
							AND AlumnoXCurso.Status = 'Inscrito'  
							AND AlumnoXCurso.FechaGrado <> '' 
							AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
							ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2",   $AnoEscolar );
							
// sin leiva							
$query_RS_AlumnoX = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
							WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
							AND Alumno.CodigoAlumno <> 2022 
							AND AlumnoXCurso.NumeroTitulo > '5562382'
							AND AlumnoXCurso.Ano = '%s' 
							AND AlumnoXCurso.Status = 'Inscrito'  
							AND AlumnoXCurso.FechaGrado <> '' 
							AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
							ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2",   $AnoEscolar );
							
$query_RS_AlumnoX = "SELECT * FROM AlumnoXCurso, Alumno 
					WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					AND AlumnoXCurso.RegistroTitulo = '1'
					ORDER BY AlumnoXCurso.NumeroTitulo, AlumnoXCurso.CodigoCurso ASC, Alumno.Apellidos, 					
							 Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2";
							 
//echo $query_RS_Alumno;		
$RS = $mysqli->query($query_RS_Alumno);
/*
$Supervisor_Nombre = "Astrid  Angulo Istúriz";
$Supervisor_CI = "V-10516490";
*/

$AlumnosPorPag = 15;
$TotalAlumnosSeccion = $RS->num_rows;
$TotalAlumnos = $TotalAlumnosSeccion;
$AlumnosPag[1] = min(15,$TotalAlumnos);
$TotalAlumnos = $TotalAlumnos - 15;
$AlumnosPag[2] = min(15,$TotalAlumnos);
$TotalAlumnos = $TotalAlumnos - 15;
$AlumnosPag[3] = min(15,$TotalAlumnos);
$TotalAlumnos = $TotalAlumnos - 15;


while ($row = $RS->fetch_assoc()) {
	extract($row);
	$No++;
	
	// ENCABEZADO Y PIE
	if($No == 1){
		$pdf->AddPage();
		$PagNum++;//$AlumnosPag[$PagNum]
		$x_i = $pdf->GetX();
		$y_i = $pdf->GetY();
		//Reticula($pdf);
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(0);
		$pdf->SetLineWidth(0.2);
		
		// Encabezado Página
		$pdf->Image('../../../../img/LogoME2.jpg', 10, 5, 100, 20);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(135,10); $pdf->Cell(70  , $Ln , 'Hoja de Registro de Título' , 0 , 1 , 'C',1);
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(135,15); $pdf->Cell(37  , $Ln , 'I. Tipo de Registro: ' , 0 , 0 , 'L',1);
						 $pdf->Cell(33  , $Ln , "Título" , 'B' , 1 , 'L',0);
		$pdf->SetX(135); $pdf->Cell(37  , $Ln , 'Mes y Año de Egreso:  ' , 0 , 0 , 'L',1);
						 $pdf->Cell(33  , $Ln , "Julio ".date('Y') , 'B' , 1 , 'L',0);
		$pdf->SetX(135); $pdf->Cell(37  , $Ln , 'Fecha de Expedición: ' , 0 , 0 , 'L',1);
		$FechaPLanilla = $Fecha_Expedicion_Tit_Bach;
		if($_GET['Revision']=='1')		
			$FechaPLanilla = $Fecha_Expedicion_Tit_Bach_Rev;
						 $pdf->Cell(33  , $Ln , $FechaPLanilla , 'B' , 1 , 'L',0);
		
		$pdf->SetXY(10,27);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , $borde , 0 , 'L',1);
		$pdf->Ln($Ln);
		
		$pdf->Cell(35  , $Ln , 'Código del Plantel: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30  , $Ln , $Colegio_Codigo , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(20  , $Ln , ' Nombre: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(85  , $Ln , $Colegio_Nombre , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10  , $Ln , $Colegio_Dtto_Escolar , $borde , 0 , 'L',1);
		$pdf->Ln($Ln);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(20  , $Ln , 'Dirección: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(115  , $Ln , $Colegio_Direccion , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(20  , $Ln , ' Teléfono: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45  , $Ln , $Colegio_Telefono , $borde , 0 , 'L',1);
		$pdf->Ln($Ln);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(20  , $Ln , 'Municipio: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45  , $Ln , $Colegio_Municipio , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45  , $Ln , $Colegio_Ent_Federal , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35  , $Ln , $Colegio_Zona_Educativa , $borde , 0 , 'L',1);
		$pdf->Ln($Ln);
		
		
		if($_GET['Revision']=='1')		
			$X_Revision = "X";
		else
			$X_Resumen = "X";
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50  , $Ln , 'III.    Identificación de la Evaluación:' , $borde , 1 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30  , $Ln , 'Resumen Final: ' , $borde , 0 , 'L',1);
		$pdf->Cell($Ln  , $Ln , $X_Resumen , 1 , 0 , 'C',1);
		$pdf->Cell(5);
		$pdf->Cell(20  , $Ln , 'Revisión: ' , $borde , 0 , 'L',1);
		$pdf->Cell($Ln  , $Ln , $X_Revision , 1 , 0 , 'C',1);
		$pdf->Cell(5);
		$pdf->Cell(35  , $Ln , 'Materia Pendiente: ' , $borde , 0 , 'L',1);
		$pdf->Cell($Ln  , $Ln , '' , 1 , 0 , 'C',1);
		$pdf->Cell(5);
		$pdf->Cell(25  , $Ln , 'Extraordinaria: ' , $borde , 0 , 'L',1);
		$pdf->Cell($Ln  , $Ln , '' , 1 , 0 , 'C',1);
		$pdf->Cell(5);
		$pdf->Cell(10  , $Ln , 'Otra: ' , $borde , 0 , 'L',1);
		$pdf->Cell(38  , $Ln , '' , 'B' , 0 , 'C',1);
		$pdf->Ln($Ln);

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50  , $Ln , 'IV.    Datos del Título que se registra:' , $borde , 1 , 'L',0);
		
		$pdf->Cell(43  , $Ln , 'Nombre del Documento: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		
		
		$NombrePlanDeEstudio = 'EDUCACIÓN MEDIA GENERAL';//.$row_mat['NombrePlanDeEstudio'];
		//$NombrePlanDeEstudio = "BACHILLER";
			
		$pdf->Cell(77  , $Ln , $NombrePlanDeEstudio , 0 , 0 , 'L');

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(18  , $Ln , 'Mención: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25  , $Ln , 'CIENCIAS' , 0 , 0 , 'L');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(17  , $Ln , 'Código: ' , $borde , 0 , 'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15  , $Ln , ' 31018' , 0 , 0 , 'L');
		$pdf->Ln($Ln);

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(195  , $Ln , 'Número de alumnos de esta sección: '. $TotalAlumnosSeccion .'       Numero de alumnos en esta página: '. $AlumnosPag[$PagNum], 0 , 0 , 'L');
		$pdf->Ln($Ln);

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(195  , $Ln , 'V.    Nómina de Alumnos a los cuales se les otorga Título:' , 0 , 1 , 'L');
		//$pdf->Ln($Ln);
		$Yo_Alumnos = $pdf->GetY()+1;

		$pdf->SetFont('Arial','',10);
		$X_o = 10;
		$Y_o = 285;
		$Ancho = 98;
		$pdf->SetY($Y_o);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho , $Ln , 'VIII. Fecha de Remisión:'.$Fecha_Remision , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Director(a)' , 1 , 1 , 'C',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Apellidos y Nombres:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , ' '.$Director_Nombre , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Número de C.I.:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , ' '.$Director_CI , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Firma:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , '' , 1 , 0 , 'C',1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln); 	
		$pdf->Cell($Ancho/2, $Ln*10, '' , 1 , 0,'C', 1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln*5); 	
		$pdf->Cell($Ancho/2, $Ln, 'SELLO DEL' , 'LR' , 0,'C', 1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln*6); 	
		$pdf->Cell($Ancho/2, $Ln, 'PLANTEL' , 'LR' , 0,'C', 1);
		
		$X_o = 112;
		$Y_o = 285;
		$Ancho = 92.5;
		$pdf->SetY($Y_o);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho , $Ln , 'VIII. Fecha de Recepción:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Funcionario Receptor' , 1 , 1 , 'C',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Apellidos y Nombres:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , '  ' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Número de C.I.:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , '  ' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln , 'Firma:' , 1 , 1 , 'L',1);
		$pdf->SetX($X_o);	$pdf->Cell($Ancho/2 , $Ln*2 , '' , 1 , 0 , 'C',1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln); 	
		$pdf->Cell($Ancho/2, $Ln*10, '' , 1 , 0,'C', 1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln*5); 	
		$pdf->Cell($Ancho/2, $Ln, 'SELLO DE LA ZONA' , 'LR' , 0,'C', 1);
		$pdf->SetXY($X_o+$Ancho/2 , $Y_o+$Ln*6); 	
		$pdf->Cell($Ancho/2, $Ln, 'EDUCATIVA' , 'LR' , 0,'C', 1);
		
		$pdf->SetFont('Arial','',10);

		$pdf->SetXY(10,$Yo_Alumnos);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(8  , $Ln*2 , ' No ' , 1 , 0 , 'C',1);
		$pdf->Cell(35  , $Ln , ' Número del Título ' , 'LRT' , 0 , 'C',1);
		$pdf->Cell(35, $Ln , ' Cédula de ' , 'LRT' , 0 , 'C',1);
		$pdf->Cell(117  , $Ln*2 , ' Nombres y Apellidos ' , 1 , 0 , 'C',1);
		$pdf->Ln($Ln);
		$pdf->SetX(18);
		$pdf->Cell(35  , $Ln , ' o Certificado ' , 'LRB' , 0 , 'C',1);
		$pdf->Cell(35  , $Ln , ' Identidad ' , 'LRB' , 1 , 'C',1);

		foreach($Lin as $Line){
			$pdf->Cell(8 , $Ln , $Line , 1 , 0 , 'C', 1); 
			$pdf->Cell(35 , $Ln , '' , 1 , 0 , 'C', 1); 
			$pdf->Cell(35 , $Ln , '' , 1 , 0 , 'C', 1); 
			$pdf->Cell(117 , $Ln , '' , 1 , 1 , 'L', 1); 
			}


		$pdf->SetXY(10,$Yo_Alumnos+17*$Ln+1);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(8  , $Ln , ' No ' , 1 , 0 , 'C',1);
		$pdf->Cell(70  , $Ln , ' Lugar de Nacimiento ' , 1 , 0 , 'C',1);
		$pdf->Cell(8, $Ln , ' EF ' , 1 , 0 , 'C',1);
		$pdf->Cell(26  , $Ln , ' Fecha Nac. ' , 1 , 0 , 'C',1);
		$pdf->Cell(83  , $Ln , ' Observaciones ' , 1 , 1 , 'C',1);
	
		foreach($Lin as $Line){
			$pdf->Cell(8 , $Ln , $Line , 1 , 0 , 'C', 1); 
			$pdf->Cell(70 , $Ln , '' , 1 , 0 , 'C', 1); 
			$pdf->Cell(8 , $Ln , '' , 1 , 0 , 'C', 1); 
			$pdf->Cell(8 , $Ln , '' , 1 , 0 , 'L', 1); 
			$pdf->Cell(8 , $Ln , '' , 1 , 0 , 'L', 1); 
			$pdf->Cell(10 , $Ln , '' , 1 , 0 , 'L', 1); 
			$pdf->Cell(83 , $Ln , '' , 1 , 1 , 'L', 1); 
			}
	$Yo_Alumnos = $Yo_Alumnos + $Ln*2;

	$pdf->SetY($Yo_Alumnos+ $Ln*31 + 1);
	$pdf->Cell(112  , $Ln , ' TOTAL DE TÍTULOS O CERTIFICADOS APROBADOS: '.$AlumnosPag[$PagNum] , 1 , 0 , 'L',1);
	$pdf->Cell(42  , $Ln , ' Año: '.$rowCurso['Curso'] , 1 , 0 , 'L',1);
	$pdf->Cell(41  , $Ln , ' Sección: '.$rowCurso['Seccion'] , 1 , 1 , 'L',1);

	$pdf->SetFont('Arial','',10);
	$pdf->Ln($Ln);
	$pdf->Cell(50  , $Ln , 'VI.    Autoridades Educativas:' , 0 , 1 , 'L',0);
	$pdf->Ln($Ln);
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(45  , $Ln , 'DIRECTOR DEL PLANTEL: ' , 0 , 1 , 'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln($Ln);
	$pdf->Cell(35  , $Ln , 'Apellidos y Nombres: ' , 0 , 0 , 'L',1);
	$pdf->Cell(65  , $Ln , $Director_Nombre , 'B' , 0 , 'L',1);
	$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L',1);
	$pdf->Cell(25  , $Ln , $Director_CI , 'B' , 0 , 'L',1);
	$pdf->Cell(15  , $Ln , ' Firma: ' , 0 , 0 , 'L',1);
	$pdf->Cell(45  , $Ln , '' , 'B' , 1 , 'L',1);
	$pdf->Ln($Ln);
	
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(145  , $Ln , 'COORDINADOR DE CONTROL DE ESTUDIOS O REPRESENTANTE DEL CONSEJO DE DOCENTES: ' , 0 , 1 , 'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln($Ln);
	$pdf->Cell(35  , $Ln , 'Apellidos y Nombres: ' , 0 , 0 , 'L',1);
	$pdf->Cell(65  , $Ln , $Prof_Revisor_Nombre , 'B' , 0 , 'L',1);
	$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L',1);
	$pdf->Cell(25  , $Ln , $Prof_Revisor_CI , 'B' , 0 , 'L',1);
	$pdf->Cell(15  , $Ln , ' Firma: ' , 0 , 0 , 'L',1);
	$pdf->Cell(45  , $Ln , '' , 'B' , 1 , 'L',1);
	$pdf->Ln($Ln);
	
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(145  , $Ln , 'FUNCIONARIO DESIGNADO POR EL MINISTERIO DE PODER POPULAR PARA LA EDUCACIÓN: ' , 0 , 1 , 'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln($Ln);
	$pdf->Cell(35  , $Ln , 'Apellidos y Nombres: ' , 0 , 0 , 'L',1);
	$pdf->Cell(65  , $Ln , $Supervisor_Nombre , 'B' , 0 , 'L',1);
	$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L',1);
	$pdf->Cell(25  , $Ln , $Supervisor_CI , 'B' , 0 , 'L',1);
	$pdf->Cell(15  , $Ln , ' Firma: ' , 0 , 0 , 'L',1);
	$pdf->Cell(45  , $Ln , '' , 'B' , 1 , 'L',1);
	
	
	}




	// DATOS ALUMNOS
	$pdf->SetY($Yo_Alumnos);
	$pdf->Cell(8 , $Ln , '' , 0 , 0 , 'C'); 
	$pdf->Cell(35 , $Ln , ''.$NumeroTitulo , 0 , 0 , 'C'); 
	$pdf->Cell(35 , $Ln , $Cedula , 0 , 0 , 'C'); 
	$pdf->Cell(117 , $Ln , $Nombres .' '. $Nombres2 .' '. $Apellidos .' '. $Apellidos2 , 0 , 0 , 'L'); 
	
	$pdf->SetY($Yo_Alumnos + $Ln*16 + 1);
	$pdf->Cell(8 , $Ln , '' , 0 , 0 , 'C'); 
	
	if($row['EntidadCorta']=='Ex')
		$NacidoEn .= " ".$row['LocalidadPais'];
	else
		$NacidoEn .= " ".$row['Entidad'];
	//$NacidoEn = str_replace("ESTADO","",$NacidoEn);
	$NacidoEn .= ' - ' . $row['Localidad'];

	$pdf->Cell(70 , $Ln , $NacidoEn , 0 , 0 , 'C'); 
	$NacidoEn='';
	
	
	$pdf->Cell(8 , $Ln , $EntidadCorta , 0 , 0 , 'C'); 
	$pdf->Cell(8 , $Ln , DiaN($FechaNac) , 0 , 0 , 'C'); 
	$pdf->Cell(8 , $Ln , MesN($FechaNac) , 0 , 0 , 'C'); 
	$pdf->Cell(10 , $Ln , AnoN($FechaNac) , 0 , 0 , 'C'); 
	
	
	
	$pdf->Cell(83 , $Ln , $LocalidadPais , 0 , 0 , 'L'); 
	
	$Yo_Alumnos += $Ln;
	if($No == 15){
		$No = 0;
		}
		
}




//Reticula($pdf);

$pdf->Output();


?>