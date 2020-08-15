<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rotation.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 


if (isset($_GET['test'])) { 
	$test=true;} 
else {
	$test=false;}

if (isset($_GET['CodigoAlumno'])) { 
	$sql_CodigoAlumno = " AND AlumnoXCurso.CodigoAlumno = '".$_GET['CodigoAlumno']."' ";}


$array_Mat["Mat"] = array("","CL","IN","MA","EN","HV","EF","GG","EA","EF","ET","IT","***","***","***");
$array_Mat["Materia"] = array("","Castellano","Inglés","Matemáticas","Estudios de la Naturaleza","Historia de Venezuela",
								"Educ. Familiar y Ciudadana","Geografía General","Educación Artística",
								"Educación Física","Educación para el Trabajo","Italiano",
								"***","***","***");

$array_Mat["CI"] = array("","15432897","12071337","3250116","4587661","13030852","5217757",
						"5530083","5217757","17459932","12470147","16379628","***","***","***");




$CodigoCurso_URL = "0";
if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso_URL = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);}

if (isset($_GET['AnoEscolar'])) {
	$AnoEscolar = $_GET['AnoEscolar'];}
	
$Ano1 = substr($AnoEscolar,0,4);
$Ano2 = substr($AnoEscolar,-4);



//Tipo Planilla
if ($_GET['TipoEvaluacion'] == "Revision"){
	$Tipo_Inscripcion = "Rv";
	$Planilla = "Revision";
	$Tipo_Evaluacion = 'Revisión';
	$Lapso = "Revision";
	}
else{
	$Tipo_Inscripcion = "Rg";
	$Planilla = "Resumen";
	$Tipo_Evaluacion = 'Resumen Final';
	$Lapso = "Def_Ministerio";
	}
	
$Ano_Escolar = $_GET['AnoEscolar'];
				
//Fecha Planilla  
if($Planilla == 'Resumen'){
	$MesAno = 'Julio '.$Ano2;}
elseif ($Planilla == 'Revision')
	$MesAno = $Fecha_Resumen_Final_Revision;
  
// Cursos
if($CodigoCurso_URL == 0) { 
	$CodigoCurso_ini = 35; 
	$CodigoCurso_fin = 45; }
else { 
	$CodigoCurso_ini = $CodigoCurso_URL;
	$CodigoCurso_fin = $CodigoCurso_URL; }
 
$borde=1;
$Ln = 4.0;
$w = 5.5;
$Mats = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
$Alum = array('01','02','03','04','05','06','07','08','09','10','11','12','13');


class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    $this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    $this->Rotate(0);
}
}


$pdf=new PDF('P', 'mm', 'Legal');
$pdf->SetFillColor(255);
			

// Para cada CURSO
for($CodigoCurso = $CodigoCurso_ini; $CodigoCurso <= $CodigoCurso_fin ; $CodigoCurso++){ 
	
	// MATERIAS 
	if($Tipo_Evaluacion=='Materia Pendiente') 
		$CodigoCurso_aux = $CodigoCurso; // Materias del nivel anterior al actual
	else 
		$CodigoCurso_aux = $CodigoCurso;   // Materias del curso actual

		
	$sql="SELECT * FROM Curso 
					WHERE CodigoCurso = ".$CodigoCurso_aux;
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_mat = mysql_fetch_assoc($RS);
	$Grado = $row_mat['CodigoMaterias'];
	$sql_base = "SELECT * FROM Notas_Certificadas 
							WHERE CodigoAlumno = 1 
							AND Grado = '$Grado'
							ORDER BY Orden";
	$RSnotas_base = mysql_query($sql_base, $bd) or die(mysql_error());
	$row_notas_base = mysql_fetch_assoc($RSnotas_base);
	unset($NotaCertificada);
	$k=0;
	do{ $k++;
		$NotaCertificada[$k][Orden]   = $row_notas_base['Orden'];
		$NotaCertificada[$k][Materia] = $row_notas_base['Materia'];
		$NotaCertificada[$k][TE] 	  = $row_notas_base['TE'];
		$NotaCertificada[$k][Mes] 	  = $row_notas_base['Mes'];
	}while($row_notas_base = mysql_fetch_assoc($RSnotas_base));



	$sql="SELECT * FROM Curso, CursoMaterias 
			WHERE CONCAT( Curso.CodigoMaterias , 'n' ) = CursoMaterias.CodigoMaterias
			AND Curso.CodigoCurso = ".$CodigoCurso_aux;
	
	/*$sql2="SELECT * FROM Curso, CursoMaterias 
			WHERE Curso.CodigoMaterias = CursoMaterias.CodigoMaterias
			AND Curso.CodigoCurso = ".$CodigoCurso_aux;		*/	
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_mat = mysql_fetch_assoc($RS);




	// llena Matriz materias y profesores
	$sql_Materias = "SELECT * FROM Notas_Certificadas 
								WHERE CodigoAlumno = '1'  
								AND Grado = '".$Grado."n'
								AND Orden < 20
								ORDER BY Orden"; 
	$RS_Materias = $mysqli->query($sql_Materias);
	$i = 0;
	for ($i = 1; $i <= 15;$i++){
		$Materia[$i] = "* * *";
		$Mat[$i] = "*";
	}
	
	$i = 0;
	$Pos_Orientacion = 0;
	$Num_Materias = 0;
	while ($row = $RS_Materias->fetch_assoc()) {
		$Materia[++$i] = $row[Materia];
		$Mat[$i] = $row[Mat];
		$Formula[$i] =  explode('-', $row[NotaOrigen]);
				
		if ($row[Materia] == "Orientación y Convivencia"){
			$Pos_Orientacion = $i;
			}
		
		$sql_Prof = "SELECT * FROM Empleado WHERE Cedula = '". $row[CiProf]."'";
		$Recordset_Prof = $mysqli->query($sql_Prof);
		$row_ = $Recordset_Prof->fetch_assoc();
		
		$Nom_Comp_Prof = $row_['Apellidos'].' ';
		$Nom_Comp_Prof.= substr($row_['Apellido2'],0,1)>""?substr($row_['Apellido2'],0,1).'. ':"";
		$Nom_Comp_Prof.= $row_['Nombres'].' ';
		$Nom_Comp_Prof.= substr($row_['Nombre2'],0,1)>""?substr($row_['Nombre2'],0,1).'.':"";
		
		//$Nom_Comp_Prof = $row_['Apellidos'].' '.substr($row_['Apellido2'],0,1).' '.$row_['Nombres'].' '.substr($row_['Nombre2'],0,1);
	
		if ($Materia[$i] > "* * *"){
			$Profesor_nom[$i] 	= $Nom_Comp_Prof;
			$Profesor_ci[$i] 	= $row_['CedulaLetra'].' '.$row_['Cedula'];
		}
	}
	$Num_Materias = $i;
	
	//$row_ = $RS_Materias->fetch_assoc();
	

	
	
	
	
	if($Grado == "V"){
		$sql_Prof = "SELECT * FROM Empleado WHERE Cedula = '3250116'";
		}
	elseif($Grado == "8"){
		$sql_Prof = "SELECT * FROM Empleado WHERE Cedula = '7884498'";
		}
	elseif($Grado == "9"){
		$sql_Prof = "SELECT * FROM Empleado WHERE Cedula = '7884498'";
		}
	else{
		$sql_Prof = "SELECT * FROM Empleado WHERE Cedula = '12470147'";
		}
	
	
	
	
	
	
	$Recordset_Prof = $mysqli->query($sql_Prof);
	$row_ = $Recordset_Prof->fetch_assoc();
	
	
	
	//$Nom_Comp_Prof = $row_['Apellidos'].' '.substr($row_['Apellido2'],0,1).' '.$row_['Nombres'].' '.substr($row_['Nombre2'],0,1);
	
	$Nom_Comp_Prof = $row_['Apellidos'];
	$Nom_Comp_Prof.= substr($row_['Apellido2'],0,1)>""?' '.substr($row_['Apellido2'],0,1).'. ':"";
	$Nom_Comp_Prof.= $row_['Nombres'];
	$Nom_Comp_Prof.= substr($row_['Nombre2'],0,1)>""?' '.substr($row_['Nombre2'],0,1).'.':"";
	
	
	$Profesor_nom[$i+1] 	= $Nom_Comp_Prof;
	$Profesor_ci[$i+1] 	= $row_['CedulaLetra'].' '.$row_['Cedula'];
	$Materia[$i+1] = "Participación en Grupos";
	$Mat[$i+1] = "PG";
		
	




	// ALUMNOS
	$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
									WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
									AND AlumnoXCurso.CodigoCurso = '%s' 
									AND AlumnoXCurso.Ano = '%s' 
									AND AlumnoXCurso.Status = 'Inscrito' 
									AND AlumnoXCurso.Tipo_Inscripcion = '%s' 
									AND AlumnoXCurso.Planilla = '%s'
									$sql_CodigoAlumno
									GROUP BY Alumno.Cedula_int
									ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC
									", 
									$CodigoCurso, $AnoEscolar, $Tipo_Inscripcion ,$Planilla);
	
	//echo $query_RS_Alumnos ."<br>";
	echo $test?$query_RS_Alumnos.'<br>':'';
	$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	$num_Alum_Seccion = $totalRows_RS_Alumnos;


foreach(array(1,2) as $grupo){
	
	
	
	
	if($grupo == 1){  // AND Alumno.CedulaLetra <> 'P' 
		$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
										WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
										AND AlumnoXCurso.CodigoCurso = '%s' 
										AND AlumnoXCurso.Ano = '%s' 
										AND AlumnoXCurso.Status = 'Inscrito' 
										AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp' 
										AND AlumnoXCurso.Planilla = '%s' 
										$sql_CodigoAlumno
										GROUP BY Alumno.Cedula_int 
										ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC ", 
										$CodigoCurso, $AnoEscolar ,$Planilla);
		$startRow_RS_Alumno = 0;
		$maxRows_RS_Alumno  = 35;
		$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
		echo $test?$query_limit_RS_Alumno.'<br>':'';
		$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
		$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
		$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	}
	
	
	/*
	else{
		$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
										WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
										AND AlumnoXCurso.CodigoCurso = '%s' 
										AND AlumnoXCurso.Ano = '%s' 
										AND AlumnoXCurso.Status = 'Inscrito' 
										AND AlumnoXCurso.Tipo_Inscripcion = '%s' 
										AND AlumnoXCurso.Planilla = '%s'
										AND Alumno.CedulaLetra = 'P' 
										$sql_CodigoAlumno
										GROUP BY Alumno.Cedula_int
										ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC ", 
										$CodigoCurso, $AnoEscolar, $Tipo_Inscripcion ,$Planilla);
		$startRow_RS_Alumno = 0;
		$maxRows_RS_Alumno  = 35;
		$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
		echo $test?$query_limit_RS_Alumno.'<br>':'';
		$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
		$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
		$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
		}
*/


	
	if($totalRows_RS_Alumnos > 0){
		do{ // Para cada PAGINA
			for($wi=0 ; $wi<15 ; $wi++) { // Inicializa contadores
				$Inasistentes[$wi] = $Inscritos[$wi] = $Aprobados[$wi] = $Aplazados[$wi] = 0;
				 }
			$Obs_pais=' ';
				
			$pdf->AddPage();
			$pdf->SetMargins(5,5,5);
			$pdf->SetFont('Arial','',10);
			
			// ENCABEZADO
			$pdf->Image('../../../../img/LogoME2018.jpg', 5, 5, 90, 0);
			$pdf->SetY( 9.2 ); 
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'RESUMEN FINAL DEL RENDIMIENTO ESTUDIANTIL' , 'B' , 1 , 'C');
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'Código del Formato: EMG' , '' , 1 , 'C');
			
			$NombrePlanDeEstudio = $row_mat['NombrePlanDeEstudio'];
			//$NombrePlanDeEstudio = "BACHILLER";
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , '  ' , 0 , 1 , 'C');
			//$pdf->Cell(100  , $Ln , ' Código del Formato: RR-DEA-04-03 ' , 0 , 1 , 'C');
			$pdf->Cell(100); $pdf->Cell(30  , $Ln , 'I.   Año Escolar: ' , 0 , 0 , 'L');
							 $pdf->Cell(40  , $Ln , ' '.$AnoEscolar  , 'B' , 0 , 'L');
							 //$pdf->Cell(18  , $Ln , 'CÓDIGO:  ' , 0 , 0 , 'L');
							 //$pdf->Cell(27  , $Ln , '31059'  , 'B' , 1 , 'L'); //$row_mat['CodigoPlanDeEstudio']
							 $pdf->Ln();
			$pdf->Cell(100); $pdf->Cell(28  , $Ln , 'Tipo Evaluación: ' , 0 , 0 , 'L');
							 $pdf->Cell(35  , $Ln , $Tipo_Evaluacion , 'B' , 0 , 'L');
							 $pdf->Cell(20  , $Ln , ' Mes y Año:' , 0 , 0 , 'L');
							 $pdf->Cell(20  , $Ln , ' '. $MesAno , 'B' , 1 , 'L');
			
			
			$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 1 , 'L');
			$pdf->Cell(30  , $Ln , 'Código del Plantel: ' , 0 , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' S0934D1507 ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
			$pdf->Cell(80  , $Ln , ' U.E. Colegio San Francisco de Asís ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' 7 ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Dirección: ' , 0 , 0 , 'L');
			$pdf->Cell(116  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Teléfono: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' (0212)2832575/2856933 ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
			$pdf->Cell(46.25  , $Ln , ' Chacao ' , 'B' , 0 , 'L');
			$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' Estado Miranda ' , 'B' , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
			$pdf->Cell(35  , $Ln , ' Miranda ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Director(a): ' , 0 , 0 , 'L');
			$pdf->Cell(116.25  , $Ln , ' ' . ucwords( $Director_Nombre ) , 'B' , 0 , 'L');
			$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L');
			$pdf->Cell(55  , $Ln , ' '. $Director_CI , 'B' , 1 , 'L');
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(132  , $Ln , 'III. Identificación del Estudiante: ' , 1 , 0 , 'L');
			$pdf->Cell(75  , $Ln , 'IV. Resumen Final del Rendimiento: ' , 1 , 0 , 'L');
			$pdf->Ln();
			
			
			
			
			
			// encabezado tabla superior		
			$pdf->Cell(5  , $Ln*5 , 'No' , $borde , 0 , 'C'); //Linea 1 (201,25 mm)
			
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->SetXY($x,$y+$Ln*2);
			$pdf->MultiCell( 15 , $Ln , "Cédula de Identidad" , 0 , "C"  );
			$pdf->SetXY($x+15,$y);
			
			$pdf->Cell(32 , $Ln*5 , 'Apellidos'  , 1 , 0 , 'C',1);
			$pdf->Cell(31 , $Ln*5 , 'Nombres'  , 1 , 0 , 'C',1);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->MultiCell(22 , $Ln*2.5 , "Lugar de Nacimiento"  ,  1 , 'C');
			$pdf->SetXY($x+22,$y);
			$pdf->Cell(5  , $Ln*5 , 'EF'  , 1 , 0 , 'C',1);
			
			
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->RotatedText($x+3.5,$y+$Ln*4,'Sexo',90);
			$pdf->Cell(5  , $Ln*5 , ''  , 1 , 0 , 'C',0);
			
 
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->MultiCell(17 , $Ln , "Fecha de Nacimiento"  ,  1 , 'C');
			$pdf->SetXY($x+17,$y);
			
			$pdf->Cell($Num_Materias *$w , $Ln*2 , 'ÁREAS DE FORMACIÓN'  , $borde , 0 , 'C'); //Linea 1
			
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(75 - ( ($Num_Materias) * $w)  , $Ln*3 , ''  , 1 , 0 , 'C',1);
			
			$pdf->SetXY($x,$y);
			
			if ( $Grado == "V" ){
				$pdf->SetFont('Arial','',4);
				$entreLinea = $Ln*.5;}
			elseif ( $Grado == "IV" ){
				$pdf->SetFont('Arial','',5);
				$entreLinea = $Ln*.6;}
			else{
				$pdf->SetFont('Arial','',7);
				$entreLinea = $Ln*.75;}
			
			
			
			$pdf->MultiCell( 75 - ( ($Num_Materias) * $w) , $entreLinea , "Participación en grupos de Creación, Recreación y Producción" , 0 , "C");
			
			
			//$pdf->SetDrawColor(0);
			//$pdf->Rect($x,$y, 25 + ( 11 - $Num_Materias )*5 , $ln*2 , 1);
			
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY($x,$y);
			
			
			
			$pdf->Ln($Ln*2);
			$pdf->Cell(110);
			$pdf->Cell(5);
			$pdf->Cell(5 , $Ln*3 , 'Día'  , 1 , 0 , 'C');
			$pdf->Cell(5 , $Ln*3 , 'Mes'  , 1 , 0 , 'C');
			$pdf->Cell(7 , $Ln*3 , 'Año'  , 1 , 0 , 'C');
			$pdf->Cell($Num_Materias *$w  , $Ln , 'ÁREA COMÚN'  , 1 , 0 , 'C');
			
			$pdf->Ln($Ln);
			
			
			
			$pdf->Cell(132);
			$pdf->SetFont('Arial','',9);
			for($i = 1; $i <= $Num_Materias+1 ; $i++)
				$pdf->Cell($w , $Ln , $i  , 1 , 0 , 'C');
				
			$pdf->Cell(75 - ( ($Num_Materias+1) *$w)  , $Ln*2 , 'Grupo'  , 1 , 0 , 'C');
			
			
			$pdf->Ln($Ln);
			
			
			
			// Encabezado Materias
			$pdf->Cell(132);
			$pdf->SetFont('Arial','',7);
			for($i = 1; $i <= $Num_Materias; $i++)
				$pdf->Cell($w , $Ln , $Mat[$i] , 1 , 0 , 'C'); //.$Num_Materias
			$pdf->Cell($w , $Ln , "PG" , 1 , 0 , 'C');
			
			$pdf->SetFont('Arial','',8);
			
			$pdf->Ln($Ln);
			
			// FIN Encabezado*/
			
			
			
			
			
			
			
			
			
			
			
			
			$RS_Alumnos = $mysqli->query($query_limit_RS_Alumno);
			$Num_Alumnos = $RS_Alumnos->num_rows;
			
			//mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
			//echo $query_limit_RS_Alumno ."<br><br><br>";
			$apro = $aplz = $inas = 0;
			$pdf->SetFont('Arial','',8);
			
			for ($i = 1 ; $i <= 35 ; $i++){
			//foreach ($Alum as $i){
				$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();
				// mysql_fetch_assoc($RS_Alumnos);
			
				
				// No.
				$pdf->Cell(5 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
				// Cedula
				$Cedula = strtoupper($row_RS_Alumnos['CedulaLetra'])." ".$row_RS_Alumnos['Cedula'];
				
				if(strlen($Cedula) > 9)
					$pdf->SetFont('Arial','',7);
				
				if($Cedula=='')	{
					$relleno = '';
					$TripleAst = ' * * * '; } 
				else {
					$relleno = '*';
					$TripleAst = ''; }
				
				$pdf->Cell(15 , $Ln , $TripleAst.$Cedula , $borde , 0 , 'C'); // Cedula
				
			
			
			
			
			
			
				
				if($row_RS_Alumnos['Apellidos']=='')
					$Apellidos = ' * * * ';
				else{
					$Apellidos = $row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'];
					$num_Alum_Pagina++;
				}
				
				$pdf->SetFont('Arial','',9);
				if( strlen($Apellidos) >= 17 )
					$pdf->SetFont('Arial','',8);
				
				$pdf->Cell(32 , $Ln , $Apellidos , $borde , 0 , 'L',1); 
				
				
				
				
				
				
				$Nombres = $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'];
				
				$pdf->SetFont('Arial','',9);
				if( strlen($Nombres) >= 17 )
					$pdf->SetFont('Arial','',8);
				
				$pdf->Cell(31 , $Ln , $Nombres , $borde , 0 , 'L', 1); 
				
				
				
				
				
				
				
				
				
				
				
				
				$Localidad = $row_RS_Alumnos['Localidad'];
				
				$pdf->SetFont('Arial','',8);
				
				if( strlen($Localidad) >= 13 )
					$pdf->SetFont('Arial','',7);// SAN CRISTOBAL
				
				if( strlen($Localidad) >= 16 )
					$pdf->SetFont('Arial','',6);// LEONCIO MARTINEZ
					
				if( strlen($Localidad) >= 15 )
					$pdf->SetFont('Arial','',5);// LEONCIO MARTINEZ
					
				$pdf->Cell(22 , $Ln , strtoupper($Localidad) , $borde , 0 , 'L', 1); 
				$pdf->SetFont('Arial','',8);
				
				
				
				
				if($row_RS_Alumnos['EntidadCorta'] == 'Dc' or $row_RS_Alumnos['EntidadCorta'] == 'Df')
					$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
				else
					$EntidadCorta = $row_RS_Alumnos['EntidadCorta'];
				
				$pdf->Cell(5 , $Ln , $EntidadCorta , $borde , 0 , 'C',1); 
				
				if($row_RS_Alumnos['EntidadCorta']=='Ex') 
					$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
				
				if($row_RS_Alumnos['Datos_Observaciones_Planilla'] > '' ) 
					$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['Datos_Observaciones_Planilla'].', ';
	
				
				$pdf->Cell(5 , $Ln , $row_RS_Alumnos['Sexo'] , $borde , 0 , 'C',1); 
				
				
				$pdf->Cell(5 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C',1); 
				$pdf->Cell(5 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C',1); 
				$pdf->Cell(7 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 0,4) , $borde , 0 , 'C',1); 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/*
			
				$sql_Notas_Certificadas = "SELECT * FROM Notas_Certificadas 
											WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'  
											AND Grado = '".$Grado."'
											AND Orden < 20
											ORDER BY Orden"; 
											//echo $sql_Notas_Certificadas.' 11<br>';
				$RS_Notas_Certificadas = $mysqli->query($sql_Notas_Certificadas);


				

				// Llena Notas Viejas
				$Sumatoria_Notas = 0;
				$Cuenta_Notas = 0;
				for ($NotaX = 1 ; $NotaX <= 12 ; $NotaX++) {
					$row_Notas_Certificadas = $RS_Notas_Certificadas->fetch_assoc();
					if( $row_Notas_Certificadas['Nota'] > "")
						$Nota_Vieja[$NotaX] = $row_Notas_Certificadas['Nota'];
				}
				
				
				// Calcula notas nuevas
				for ($k = 1 ; $k <= 12 ; $k++) {
					$Cuenta = 0;
					$Suma_Nota = $Nota_Vieja[$Formula[$k][0]] 
								 + $Nota_Vieja[$Formula[$k][1]] 
								 + $Nota_Vieja[$Formula[$k][2]];
					if ($Nota_Vieja[$Formula[$k][0]] >= 10 and $Nota_Vieja[$Formula[$k][0]] <= 20)
						$Cuenta++; 
					if ($Nota_Vieja[$Formula[$k][1]] >= 10 and $Nota_Vieja[$Formula[$k][1]] <= 20)
						$Cuenta++; 
					if ($Nota_Vieja[$Formula[$k][2]] >= 10 and $Nota_Vieja[$Formula[$k][2]] <= 20)
						$Cuenta++; 
					
					if ($Cuenta > 0){
						$Nota_Nueva[$k] = round($Suma_Nota/$Cuenta , 0);
					}		
					
					if ( $k != $Pos_Orientacion and $Nota_Nueva[$k] >= 10){
						$Sumatoria_Notas += $Nota_Nueva[$k];
						$Cuenta_Notas++;
						}
				}
				
				if($Cuenta_Notas > 0)
					$Nota_Nueva[$Pos_Orientacion] = round( $Sumatoria_Notas / $Cuenta_Notas , 0);
				
				
				*/
				
				
				$sql_Notas_Certificadas = "SELECT * FROM Nota 
											WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."' AND 
											Lapso = '$Lapso' AND 
											Ano_Escolar = '$Ano_Escolar'"; 
											//echo $sql_Notas_Certificadas.' 11<br>';
											
				$RS_Notas_Certificadas = $mysqli->query($sql_Notas_Certificadas);
				$N_ = $RS_Notas_Certificadas->fetch_assoc(); 
				
				unset( $Nota_Nueva );
				unset( $j );
			
				foreach ($Mats as $nXX){
					$Nota_Nueva[++$j] = $N_['n'.$nXX];
					echo $N_[$nXX] ."";
					}	
				
				
				// Imprime Notas
				$pdf->SetFont('Arial','',9);
				for ($j = 1 ; $j <= $Num_Materias-1 ; $j++) {
					
					if ( $i <= $Num_Alumnos ){
						
						$pdf->Cell($w , $Ln ,  $Nota_Nueva[$j]."" , $borde , 0 , 'C'); 	
						
						
						// Contadores
						$aux_Nota = $Nota_Nueva[$j];
						if(	(   $aux_Nota > 0 or $aux_Nota > ""  ) 
								and $aux_Nota != 'N' 
								and $aux_Nota != 'n' 
								and $aux_Nota != "*") 
								
							$Inscritos[$j]++;
						
							
						if($aux_Nota >= 10 and $aux_Nota <= 20 )
							$Aprobados[$j]++;
							
						if($aux_Nota>0 and $aux_Nota < 10)
							$Aplazados[$j]++; 
								
						if($aux_Nota=='I' or $aux_Nota=='i') 
							$Inasistentes[$j]++; 
						// FIN Contadores
						
					}
					else{
						$pdf->Cell($w , $Ln ,  "" , $borde , 0 , 'C'); 
					}
						
				}
				
				
				$pdf->Cell($w , $Ln ,  Nota_Letra($Nota_Nueva[12])."" , $borde , 0 , 'C');  // Nota de OC
				if ( $Nota_Nueva[12] > "*" ) {
					$Inscritos[$Num_Materias]++;
					$Aprobados[$Num_Materias]++;
				}		
				
				$GrupoG = "";
				$Nota12 = "";
				if($row_RS_Alumnos['CodigoAlumno'] > ""){
					
					/*
					$sql = "SELECT * FROM Nota WHERE 
							CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."' AND 
							Ano_Escolar LIKE '2017-2018' 
							AND Lapso LIKE 'Def'";
					$RS_Notas_Def = $mysqli->query($sql);
					$row_Notas_Def = $RS_Notas_Def->fetch_assoc();
					*/
					if ($Grado == "7") {
						$GrupoG = "Form. Int. del Adolesc.";
						//$Nota12 = Promedia($row_Notas_Def['n10'],$row_Notas_Def['n11'],"");
						}
					elseif ($Grado == "8") {
						$GrupoG = "Tec. Bas. Adm. I";
						//$Nota12 = Promedia($row_Notas_Def['n09'],$row_Notas_Def['n10'],"");
						}
					elseif ($Grado == "9") {
						$GrupoG = "Tec. Bas. Adm. II";
						$Nota12 = Promedia($row_Notas_Def['n10'],$row_Notas_Def['n11'],"");
						}
					elseif ($Grado == "IV") {
						$GrupoG = "Dis. y Creac.";
						//$Nota12 = Promedia($row_Notas_Def['n11'],$row_Notas_Def['n12'],"");
						}
					elseif ($Grado == "V") {
						$GrupoG = "Electr.";
						//$Nota12 = Promedia($row_Notas_Def['n06'],"","");
						}
						
						
					//$Nota12 = $Nota_Nueva[13];	
					
					
					}
				
				
				
				$pdf->Cell($w , $Ln ,  Nota_Letra($Nota_Nueva[13]) , $borde , 0 , 'C'); // Grupo de parti
				
				
				
				if ($Grado == "7" or $Grado == "9" or $Grado == "IV" or $Grado == "V")
					$pdf->SetFont('Arial','',6);
				$pdf->Cell(75 - ( ($Num_Materias+1) *$w) , $Ln ,  $GrupoG , $borde , 0 , 'C'); 
				$pdf->SetFont('Arial','',8);	
				
				
				$aux_Nota = $Nota_Nueva[$Num_Materias+1];
				if ( $Nota_Nueva[13] > "*" ) {
					$Inscritos[$Num_Materias+1]++;
					$Aprobados[$Num_Materias+1]++;
				}
				
				
				$pdf->Ln($Ln);
			}
			
			
			
			
			
			
			
			
			
			
			
			
			 
			// totales
			$tipo_tot = array('Inscritos', 'Inasistentes', 'Aprobados', 'No Aprobados','No Cursantes');
			$pdf->Cell(52 , $Ln*5 , 'Total de Áreas de Formación' , 0 , 0 , 'C');
			foreach($tipo_tot as $tipo){
				
				$pdf->Cell(80 , $Ln , $tipo , $borde , 0 , 'C'); 
				
				for  ($i = 1; $i <= $Num_Materias + 1 ; $i++){
				
					if($Mat[$i]=='***'){
						$Inasistentes[$i] = $Inscritos[$i] = $Aprobados[$i] = $Aplazados[$i] = '***';}

					if($tipo == 'Inscritos') 	$pdf->Cell($w , $Ln , $Inscritos[$i] , $borde , 0 , 'C'); 
					if($tipo == 'Inasistentes') 	$pdf->Cell($w , $Ln , $Inasistentes[$i] , $borde , 0 , 'C'); 
					if($tipo == 'Aprobados') 	$pdf->Cell($w , $Ln , $Aprobados[$i] , $borde , 0 , 'C'); 
					if($tipo == 'No Aprobados') 	$pdf->Cell($w , $Ln , $Aplazados[$i] , $borde , 0 , 'C'); 
					if($tipo == 'No Cursantes') 	$pdf->Cell($w , $Ln , $Aplazados[$i] , $borde , 0 , 'C'); 
				
				} 
				$pdf->Cell(75 - ( ($Num_Materias+1) * $w) , $Ln , "" , $borde , 0 , 'C'); 
				
				$j=0;
					
				$pdf->Ln($Ln);
				$pdf->Cell(52);
			}
			$pdf->SetX(5);
			
			
			
		
				
			// PROFESORES
			$pdf->Cell(62 , $Ln , 'V. Profesor por Área:' , $borde , 0 , 'L'); 
			$pdf->Cell(36 , $Ln*2 , 'Apellidos y Nombres' , 1 , 0 , 'C'); 
			$pdf->Cell(29 , $Ln*2 , 'Cédula de Identidad' , $borde , 0 , 'C'); 
			$pdf->Cell(25 , $Ln*2 , 'Firma' , $borde , 0 , 'C');
			
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			
			
			$pdf->Ln($Ln);
			$pdf->Cell(5 , $Ln , 'No' , $borde , 0 , 'C'); 
			$pdf->Cell(57 , $Ln , 'Área de Formación' , 1 , 0 , 'C'); 
			
			$pdf->Ln();
			
			
			// Profesores	
			for  ($i = 1; $i <= 12 ; $i++){
				$pdf->Cell(5 , $Ln , $i  , $borde , 0 , 'C'); 
				
				if (strlen($Materia[$i]) > 33 )
					$pdf->SetFont('Arial','',8);
				else
					$pdf->SetFont('Arial','',8);
			
				
				$pdf->Cell(7 , $Ln , $Mat[$i] , $borde , 0 , 'C'); 
				$pdf->Cell(50 , $Ln , $Materia[$i] , $borde , 0 , 'L'); 
				$pdf->SetFont('Arial','',8);
				
				
				$pdf->Cell(36 , $Ln , $Profesor_nom[$i] , $borde , 0 , 'L'); 
				$pdf->Cell(29 , $Ln , $Profesor_ci[$i] , $borde , 0 , 'L'); 
				if($Inscritos[$i] == 0 )
					$Profesor_firma[$i] = ' * * * ';
				
				if($i <= 12)
					$Profesor_firma[$i] = '  ';
				else
					$Profesor_firma[$i] = ' * * * ';	
					
				$pdf->Cell(25 , $Ln , $Profesor_firma[$i] , $borde , 0 , 'C');
				$pdf->Ln($Ln);
			}
			
			$x2 = $pdf->GetX();
			$y2 = $pdf->GetY();
			
			
			
			
			
			// VI. Identificación del Curso
			$pdf->SetXY($x,$y);
			
			$pdf->Cell(55 , $Ln , 'VI. Identificación del Curso:' , $borde , 1 , 'L' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , 'PLAN DE ESTUDIO:' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , 'EDUCACIÓN MEDIA GENERAL' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , 'CÓDIGO:' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , '31059' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , 'AÑO CURSADO' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , Cardinal($row_mat['Curso']) , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , 'SECCIÓN' , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->Cell(55 , $Ln , $row_mat['Seccion'] , $borde , 1 , 'C' ); 
			
			$pdf->SetX($x);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(27.5 , $Ln*2 , 'No DE ESTUDIANTES' , 'TLR' , 0 , 'C' ); 
			$pdf->Cell(27.5 , $Ln*2 , 'No DE ESTUDIANTES' , 'TLR' , 1 , 'C' ); 
				
			$pdf->SetX($x);
			$pdf->Cell(27.5 , $Ln*2 , 'POR SECCIÓN' , 'BLR' , 0 , 'C' ); 
			$pdf->Cell(27.5 , $Ln*2 , 'EN ESTA PÁGINA' , 'BLR' , 1 , 'C' ); 
			$pdf->SetFont('Arial','',8);
			
			$pdf->SetX($x);
			$pdf->Cell(27.5 , $Ln , $num_Alum_Seccion , 1 , 0 , 'C' ); 
			$pdf->Cell(27.5 , $Ln , $num_Alum_Pagina , 1 , 1 , 'C' ); //$num_Alum_Pag
			
			$num_Alum_Pagina = 0;
			
			
			
			
			$pdf->SetXY($x2,$y2);
			$pdf->Ln();
			
			$Obs_pais = substr($Obs_pais, 0, -2);
			$pdf->MultiCell(207 , $Ln , 'VI.  Observaciones: '.$Obs_pais , 'TLR' , 'L');
			$pdf->MultiCell(207 , $Ln , '' , 'BLR' , 'L');
			
			$pdf->Ln(2);
			
			$Fecha_Remision = "28/07/" . $Ano2;
			
			$coorX = $pdf->GetX();
			$coorY = $pdf->GetY();
			$pdf->Cell(50 , $Ln , 'VII. Fecha de Remisión:  '.$Fecha_Remision , $borde , 0 , 'L');
			$pdf->Cell(53.5 , $Ln*3 , 'SELLO DEL' , 'LRT' , 0 , 'C');
			$pdf->Ln($Ln);
			
			$pdf->Cell(50 , $Ln , 'Director(a)' , $borde , 1 , 'C');
			$pdf->Cell(50 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
			
			$pdf->Cell(50 , $Ln , '  ' . $Director_Nombre , $borde , 0 , 'L');
			$pdf->Cell(53.5 , $Ln*4 , 'PLANTEL' , 'LRB' , 0 , 'C');
			$pdf->Ln($Ln);
			
			$pdf->Cell(50 , $Ln , 'Número de C.I.:' , $borde , 1 , 'L');
			$pdf->Cell(50 , $Ln , '  V '. $Director_CI , $borde , 1 , 'L');
			$pdf->Cell(50 , $Ln , 'Firma:' , $borde , 1 , 'L');
			
				
			
			
			$pdf->SetXY($coorX,$coorY);
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , 'VIII. Fecha de Recepción:  ' , $borde , 0 , 'L');// $Fecha_Remision
			$pdf->Cell(53.5 , $Ln*3 , 'SELLO DE LA ZONA' , 'LRT' , 0 , 'C');
			$pdf->Ln($Ln);
			
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , 'Funcionario Receptor' , $borde , 1 , 'C');
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
			
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , '' , $borde , 0 , 'L');
			$pdf->Cell(53.5 , $Ln*4 , 'EDUCATIVA' , 'LRB' , 0 , 'C');
			$pdf->Ln($Ln);
			
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , 'Número de C.I.:' , $borde , 1 , 'L');
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , '  ' , $borde , 1 , 'L');
			$pdf->SetX(108.5);
			$pdf->Cell(50 , $Ln , 'Firma:' , $borde , 1 , 'L');
			
			
			
			
			
			
			$startRow_RS_Alumno = $startRow_RS_Alumno + $maxRows_RS_Alumno;
			$maxRows_RS_Alumno  = 13;
			$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
			$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
			$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
			$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
			
			
			
			
			
		} while($totalRows_RS_Alumnos > 0);
	}// seccion vacia  if($totalRows_RS_Alumnos>0
	}
}
$pdf->Output();


?>