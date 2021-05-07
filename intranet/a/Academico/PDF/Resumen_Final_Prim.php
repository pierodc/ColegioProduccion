<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../intranet/a/archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 
if (isset($_GET['test'])) {
$test=true;} else {
$test=false;}

//function oi($i){ return substr('0'.$i,-2);}

// Para usar esta rutina, la tabla AlumnosXCurso debe contener los alumnos inscritos en cada seccion 
// AlumnosXCurso.php llena esta tabla
// $_GET['TipoEvaluacion']=='MatPen'   -->>> Materia Pendiente
// $_GET['CodigoCurso']=''  -->>> todos los cursos
// CrearSiguiente=1 para crear siguiente planilla
// test para ver sql

$CodigoCurso_URL = "0";
mysql_select_db($database_bd, $bd);

if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso_URL = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);}

if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = (get_magic_quotes_gpc()) ? $_GET['AnoEscolar'] : addslashes($_GET['AnoEscolar']);}

$MesAno = 'Julio '.substr($AnoEscolar,-4);  
  
$borde=1;

$pdf=new FPDF('P', 'mm', 'Legal');

/*
if($CodigoCurso_URL == 0) { $CodigoCurso_ini = 23; $CodigoCurso_fin=34; }
else { 
$CodigoCurso_ini = $CodigoCurso_URL;
$CodigoCurso_fin = $CodigoCurso_URL; }
*/

$sql="SELECT * FROM Curso  WHERE NivelMencion = '2' ORDER BY Curso, Seccion";
$RS_Curso = mysql_query($sql, $bd) or die(mysql_error());
$row_Curso = mysql_fetch_assoc($RS_Curso);
//echo $sql.'<br>';

do{
$CodigoCurso = $row_Curso['CodigoCurso'];


//for($CodigoCurso = $CodigoCurso_ini; $CodigoCurso<=$CodigoCurso_fin ; $CodigoCurso++){
	

// materias
$sql="SELECT * FROM Curso  WHERE CodigoCurso = ".$CodigoCurso;
//echo $sql.'<br>';
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row_mat = mysql_fetch_assoc($RS);

$Status = 'Inscrito';
$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
								WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
								AND AlumnoXCurso.CodigoCurso = '%s' 
								AND AlumnoXCurso.Ano = '%s' 
								AND AlumnoXCurso.Status = '%s' 
								ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC", $CodigoCurso, $AnoEscolar, $Status);// ,
echo $test?$query_RS_Alumnos.'<br>':'';
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
$num_Alum_Seccion = $totalRows_RS_Alumnos;

$startRow_RS_Alumno =0;
$maxRows_RS_Alumno  =20;
$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);

if($totalRows_RS_Alumnos>0){
do{
	
		$Obs_pais=' ';
	
	
$pdf->AddPage();
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','',11);
$pdf->SetFillColor(255,255,0);
$Ln = 4.6;
$tot_A=$tot_B=$tot_C=$tot_D=$tot_E=0;


$pdf->Image('../../../../img/LogoME2.jpg', 5, 5, 0, 17);
$pdf->SetY( 3 );
$pdf->Ln($Ln);
$pdf->Cell(115); $pdf->Cell(70  , $Ln , 'RESUMEN FINAL DE LA EVALUACIÓN' , 'B' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(100); $pdf->Cell(100  , $Ln , '' , 0 , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(100); $pdf->Cell(100  , $Ln , '  ' , 0 , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(60);  $pdf->Cell(33  , $Ln , 'Plan de Estudio: ' , 0 , 0 , 'L');
				 $pdf->Cell(65  , $Ln , ' '.$row_mat['NombrePlanDeEstudio']  , 'B' , 0 , 'L');
				 $pdf->Cell(15  , $Ln , 'CÓD:  ' , 0 , 0 , 'L');
				 $pdf->Cell(33  , $Ln , ' '. $row_mat['CodigoPlanDeEstudio'] , 'B' , 0 , 'L');
$pdf->Ln($Ln);
$pdf->Cell(60);  $pdf->Cell(30  , $Ln , 'I.   Año Escolar: ' , 0 , 0 , 'L');
				 $pdf->Cell(25  , $Ln , ' '. $AnoEscolar , 'B' , 0 , 'L');
				 $pdf->Cell(56  , $Ln , '  Mes y Año de la Evaluación:' , 0 , 0 , 'L');
				 $pdf->Cell(35  , $Ln , ' '. $MesAno , 'B' , 0 , 'L');
$pdf->Ln($Ln);


$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Cód.DEA: ' , 0 , 0 , 'L');
$pdf->Cell(30  , $Ln , $Colegio_Codigo , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
$pdf->Cell(106  , $Ln , $Colegio_Nombre , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
$pdf->Cell(10  , $Ln , $Colegio_Dtto_Escolar , 'B' , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Dirección: ' , 0 , 0 , 'L');
$pdf->Cell(121  , $Ln , $Colegio_Direccion , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Teléfono: ' , 0 , 0 , 'L');
$pdf->Cell(45  , $Ln , $Colegio_Telefono , 'B' , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
$pdf->Cell(46  , $Ln , $Colegio_Municipio , 'B' , 0 , 'L');
$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
$pdf->Cell(50  , $Ln , $Colegio_Ent_Federal , 'B' , 0 , 'L');
$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
$pdf->Cell(35  , $Ln , $Colegio_Zona_Educativa , 'B' , 0 , 'L');
$pdf->Ln($Ln);
	
	
	
$pdf->Cell(13  , $Ln , 'Grado: ' , 0 , 0 , 'L');
$pdf->Cell(13  , $Ln , '  '.$row_mat['Curso'] , 'B' , 0 , 'L');
$pdf->Cell(19  , $Ln , ' Sección: ' , 0 , 0 , 'L');
$pdf->Cell(13  , $Ln , '  '.$row_mat['Seccion'] , 'B' , 0 , 'L');
$pdf->Cell(60  , $Ln , ' No. de Estudiantes de la Sección: ' , 0 , 0 , 'L');
$pdf->Cell(14  , $Ln , ' '.$num_Alum_Seccion , 'B' , 0 , 'L');
$pdf->Cell(60  , $Ln , ' No. de Estudiantes en esta Pág.: ' , 0 , 0 , 'L');
$pdf->Cell(14  , $Ln , '  '.$totalRows_RS_Alumnos , 'B' , 0 , 'L');
$pdf->Ln($Ln);



$pdf->Cell(100  , $Ln , 'IV.   Resumen Final de la Evaluación: ' , 0 , 0 , 'L');
$pdf->Ln($Ln);
$Ln = 4.4;


$pdf->SetFont('Arial','',9);

	//$pdf->Cell(90);
	//$pdf->Cell(116  , $Ln ,' Tabla de Conversión: A (19-20)   B (16-18)   C (13-15)   D (10-12)   E (01-09)'  , 1 , 0 , 'L'); 
$pdf->SetFont('Arial','',10);
	
	//$pdf->Ln($Ln);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
 




// ALUMNOS
$num_Alum_Pag=0;
$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);

	//$pdf->Cell(7  , $Ln * 0.5 ,''  , 'TLR' , 0 , 'C'); 
	//$pdf->Cell(38.5 , $Ln * 0.5 , '' , 'TLR' , 0 , 'C'); 
	//$pdf->Cell(44.5 , $Ln * 0.5 , '' , 'TL' , 0 , 'C'); 
	//$pdf->Ln($Ln* 0.5);
	
	$pdf->Cell(7  , $Ln*2 ,'No'  , 'TLR' , 0 , 'C'); 
	$pdf->Cell(38.5 , $Ln , 'Cédula de Identidad' , 'TLR' , 0 , 'C'); 
	$pdf->Cell(62.1 , $Ln*2 , 'Lugar de Nacimiento' , 'TLR' , 0 , 'C'); 
	$pdf->Cell(7 , $Ln*2 , 'E F' , $borde , 0 , 'C'); 
	
	
	$pdf->Cell(9 , $Ln*2 ,  'Sexo', $borde , 0 , 'C'); 
	$pdf->Cell(26 , $Ln ,  'Fecha de Nac.', $borde , 0 , 'C'); 
	$pdf->Cell(56.4 , $Ln ,  'Resultados de la Evaluación', $borde , 0 , 'C'); 
	//$pdf->Cell(9.4 , $Ln , '' , 'TLR' , 0 , 'C'); 
	$pdf->Ln($Ln);
	
	$pdf->Cell(7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Cell(38.5  , $Ln  ,'o Cédula Escolar'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(78.1  , $Ln  ,''  , 0 , 0 , 'C'); 
	
	$pdf->Cell(8 , $Ln , 'Día'  , $borde , 0 , 'C'); 
	$pdf->Cell(8 , $Ln , 'Mes'  , $borde , 0 , 'C'); 
	$pdf->Cell(10 , $Ln , 'Año'  , $borde , 0 , 'C'); 

	$pdf->Cell(11.28 , $Ln , 'A'  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , 'B'  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , 'C'  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , 'D'  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , 'E'  , $borde , 0 , 'C'); 
	//$pdf->Cell(9.4 , $Ln , '' , 'LRB', 0 , 'C'); 
	
	$pdf->Ln($Ln);

	
	
for ($i=1 ; $i<=20 ; $i++){
	
	
	$sql="SELECT * FROM Nota 
			WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
			AND Ano_Escolar = '".$AnoEscolar."' 
			AND Lapso='Def_Ministerio' ";  
	$RS_notas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RS_notas);

	$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];
		
	$pdf->Cell(7  , $Ln , substr('0'.$i , -2)  , $borde , 0 , 'C'); 
	if($row_RS_Alumnos['CodigoAlumno'] > '')
		$CedulaAlumno = $row_RS_Alumnos['CedulaLetra']." ".$row_RS_Alumnos['Cedula'];
	else
		$CedulaAlumno = '* * *';
	$pdf->Cell(38.5 , $Ln , $CedulaAlumno , $borde , 0 , 'C', FaltaDato($CodigoAlumno,$row_RS_Alumnos['Cedula'])); 
	$pdf->Cell(62.1 , $Ln , strtoupper($row_RS_Alumnos['Localidad']) , $borde , 0 , 'L', FaltaDato($CodigoAlumno,$row_RS_Alumnos['Localidad'])); 
	
	if($row_RS_Alumnos['EntidadCorta'] == 'Dc' or $row_RS_Alumnos['EntidadCorta'] == 'Df')
		$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
	else
		$EntidadCorta = $row_RS_Alumnos['EntidadCorta'];
		
	$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
		
	$pdf->Cell(7 , $Ln , strtoupper($EntidadCorta) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,$row_RS_Alumnos['EntidadCorta'])); 
	
	if($row_RS_Alumnos['EntidadCorta']=='Ex' or $row_RS_Alumnos['EntidadCorta']=='EX') 
			$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
	
	if($row_RS_Alumnos['Datos_Observaciones_Planilla'] > '' ) 
			$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['Datos_Observaciones_Planilla'].', ';
	
	
	
	$pdf->Cell(9 , $Ln ,  $row_RS_Alumnos['Sexo'], $borde , 0 , 'C', FaltaDato($CodigoAlumno,$row_RS_Alumnos['Apellidos'])); 
	
	$pdf->Cell(8 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 
	$pdf->Cell(8 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 
	$pdf->Cell(10 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 0,4) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 


$query_RS_Nota_Al = "SELECT * FROM Nota 
					WHERE CodigoAlumno = '". $row_RS_Alumnos['CodigoAlumno']."' 
					AND Lapso= 'Def_Ministerio' 
					AND Ano_Escolar='".$AnoEscolar."'";
$RS_Nota_Al = mysql_query($query_RS_Nota_Al, $bd) or die(mysql_error());
$row_RS_Nota_Al = mysql_fetch_assoc($RS_Nota_Al);
//echo $query_RS_Nota_Al;
$nota = $row_RS_Nota_Al['n01'];
$A=$B=$C=$D=$E='';
if(($nota > 0 and $nota < 10  ) or $nota == "E") 	{ $E='X'; $tot_E=$tot_E+1; } 
if(($nota>=10 and $nota <= 12 ) or $nota == "D") 	{ $D='X'; $tot_D=$tot_D+1; } 
if(($nota>=13 and $nota <= 15 ) or $nota == "C") 	{ $C='X'; $tot_C=$tot_C+1; } 
if(($nota>=16 and $nota <= 18 ) or $nota == "B") 	{ $B='X'; $tot_B=$tot_B+1; } 
if(($nota>=19 and $nota <= 20 ) or $nota == "A") 	{ $A='X'; $tot_A=$tot_A+1; } 

	$pdf->Cell(11.28 , $Ln , $A  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , $B  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , $C  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , $D  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln , $E  , $borde , 0 , 'C'); 
$nota = '';// substr('0'.$nota, -2);
	//$pdf->Cell(9.4 , $Ln , $nota , $borde , 0 , 'C'); 
	
	$pdf->Ln($Ln);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
}

	$pdf->Cell(130);
	$pdf->Cell(19.6  , $Ln*1.5 , 'TOTALES' , 0 , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln*1.5 , $tot_A  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln*1.5 , $tot_B  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln*1.5 , $tot_C  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln*1.5 , $tot_D  , $borde , 0 , 'C'); 
	$pdf->Cell(11.28 , $Ln*1.5 , $tot_E  , $borde , 0 , 'C'); 
	//$pdf->Cell(9.4 , $Ln*1.5 , '' , $borde , 0 , 'C'); 
	$pdf->Ln($Ln*1.5);


	$pdf->Cell(7  , $Ln , 'No' , $borde , 0 , 'C'); 
	$pdf->Cell(100 , $Ln , '    Apellidos' , $borde , 0 , 'L'); 
	$pdf->Cell(99 , $Ln , '    Nombres' , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);


$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
for ($i=1 ; $i<=20 ; $i++){
	$pdf->Cell(7  , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
	
	if($row_RS_Alumnos['Apellidos']=='')	{
		$TripleAst = ' * * * '; } 
	else {
		$TripleAst = ''; }
	
	$pdf->Cell(100 , $Ln , $TripleAst.$row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'] , $borde , 0 , 'L' ); 
	$pdf->Cell(99 , $Ln , $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'] , $borde , 0 , 'L'); 
	
	$pdf->Ln($Ln);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
}

	$pdf->Cell(107 , $Ln , 'Apellidos y Nombres del(la) Docente' , 'TLR' , 0 , 'L'); 
	$pdf->Cell(40 , $Ln , 'Número de C.I.' , 'TLR' , 0 , 'L'); 
	$pdf->Cell(59 , $Ln , 'Firma' , 'TLR' , 0 , 'L'); 
	$pdf->Ln($Ln);

$sql_maestra = "SELECT * FROM Empleado WHERE Cedula = '".$row_mat['Cedula_Prof_Guia']."'";
$RS_maestra = mysql_query($sql_maestra, $bd) or die(mysql_error());
$row_maestra = mysql_fetch_assoc($RS_maestra);
	
	
	$pdf->Cell(107 , $Ln , '  '.$row_maestra['Apellidos']. ' ' .$row_maestra['Nombres'] , 'BLR' , 0 , 'L', FaltaDato(1,$row_maestra['Apellidos'])); 
	$pdf->Cell(40 , $Ln , '  '.$row_maestra['CedulaLetra'].' '.$row_maestra['Cedula'] , 'BLR' , 0 , 'L', FaltaDato(1,$row_maestra['Cedula'])); 
	$pdf->Cell(59 , $Ln , '  ' , 'BLR' , 0 , 'L'); 
	$pdf->Ln($Ln);


$Obs_pais = substr($Obs_pais, 0, -2);
$pdf->MultiCell(206 , $Ln , 'VI.  Observaciones: '.$Obs_pais , 'TLR' , 'L');
$pdf->MultiCell(206 , $Ln , '' , 'BLR' , 'L');

$pdf->Ln(2);
$coorX = $pdf->GetX();
$coorY = $pdf->GetY();
$pdf->Cell(101 , $Ln , 'VII. Fecha de Remisión:  '.$Fecha_Remision , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln , 'Director(a)' , $borde , 0 , 'C');
$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(52 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln*2 , $Director_Nombre , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln , 'Número de C.I.:' , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'SELLO DEL' , 'LR' , 1 , 'C');
$pdf->Cell(52 , $Ln*2 , $Director_CI , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'PLANTEL' , 'LR' , 1 , 'C');
$pdf->Cell(52); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(52 , $Ln , 'Firma:' , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln*2 , '' , $borde , 1 , 'C');

$pdf->SetXY($coorX,$coorY);
$pdf->Cell(105); $pdf->Cell(101 , $Ln , 'VIII. Fecha de Recepción:' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Funcionario Receptor' , $borde , 0 , 'C');
$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln*2 , '  ' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Número de C.I.:' , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'SELLO DE LA ZONA' , 'LR' , 1 , 'C');
$pdf->Cell(105); $pdf->Cell(52 , $Ln*2 , '  ' , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'EDUCATIVA' , 'LR' , 1 , 'C');
$pdf->Cell(105); $pdf->Cell(52); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Firma:' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln*2 , '' , $borde , 1 , 'C');


$startRow_RS_Alumno = $startRow_RS_Alumno + $maxRows_RS_Alumno;
$maxRows_RS_Alumno  = 13;
$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);



} while($totalRows_RS_Alumnos>0);
}// seccion vacia  if($totalRows_RS_Alumnos>0
//}
}while($row_Curso = mysql_fetch_assoc($RS_Curso));


$pdf->Output();


?>