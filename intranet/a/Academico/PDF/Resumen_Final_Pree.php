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

if (isset($_GET['CodigoCurso']) and $_GET['CodigoCurso']>0) {
  $CodigoCurso_URL = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);}

if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = (get_magic_quotes_gpc()) ? $_GET['AnoEscolar'] : addslashes($_GET['AnoEscolar']);}

$MesAno = 'Julio '.substr($AnoEscolar,-4);  
  
$borde=1;

$pdf=new FPDF('P', 'mm', 'Legal');
/*
if($CodigoCurso_URL == 0) { $CodigoCurso_ini = 15; $CodigoCurso_fin=22; }
else { 
$CodigoCurso_ini = $CodigoCurso_URL;
$CodigoCurso_fin = $CodigoCurso_URL; }
*/


$sql="SELECT * FROM Curso  WHERE NivelMencion = '1' ORDER BY NivelCurso, Curso, Seccion";
$RS_Curso = mysql_query($sql, $bd) or die(mysql_error());
$row_Curso = mysql_fetch_assoc($RS_Curso);


do{
$CodigoCurso = $row_Curso['CodigoCurso'];

//for($CodigoCurso = $CodigoCurso_ini; $CodigoCurso<=$CodigoCurso_fin ; $CodigoCurso++){

// materias
$sql="SELECT * FROM Curso  WHERE CodigoCurso = ".$CodigoCurso;
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row_mat = mysql_fetch_assoc($RS);


$Status = 'Inscrito';
$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
								WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
								AND AlumnoXCurso.CodigoCurso = '%s' 
								AND AlumnoXCurso.Ano = '%s' 
								AND AlumnoXCurso.Status = '%s' 
								ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC", $CodigoCurso, $AnoEscolar, $Status);
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
$pdf->SetMargins(7,5,7);
$pdf->SetFont('Arial','',11);
$pdf->SetFillColor(255,255,150);
$Ln = 4.4;
$tot_A=$tot_B=$tot_C=$tot_D=$tot_E=$tot_F=0;


$pdf->Image('../../../../img/LogoME2.jpg', 5, 5, 0, 17);
$pdf->SetY( 5 );
$pdf->Ln($Ln);
$pdf->Cell(115); $pdf->Cell(70  , $Ln , 'MATR�CULA FINAL EDUCACI�N INICIAL' , 'B' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(100); $pdf->Cell(100  , $Ln , '(Maternal y Preescolar)' , 0 , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(100); $pdf->Cell(100  , $Ln , ' C�digo del Formato: RR-DEA-04-03 ' , 0 , 0 , 'C');
$pdf->Ln($Ln);
/*$pdf->Cell(60);  $pdf->Cell(33  , $Ln , 'Plan de Estudio: ' , 0 , 0 , 'L');
				 $pdf->Cell(65  , $Ln , ' '.$row_mat['NombrePlanDeEstudio'].'          C�digo: '.$row_mat['CodigoPlanDeEstudio']  , 'B' , 0 , 'L');
				 //$pdf->Cell(15  , $Ln , 'C�D:  ' , 0 , 0 , 'L');
				 //$pdf->Cell(33  , $Ln , ' '. $row_mat['CodigoPlanDeEstudio'] , 'B' , 0 , 'L');
*/
$pdf->Cell(60);  $pdf->Cell(33  , $Ln , 'Plan de Estudio: ' , 0 , 0 , 'L');
				 $pdf->Cell(65  , $Ln , ' '.$row_mat['NombrePlanDeEstudio']  , 'B' , 0 , 'L');
				 $pdf->Cell(15  , $Ln , 'C�D:  ' , 0 , 0 , 'L');
				 $pdf->Cell(33  , $Ln , ' '. $row_mat['CodigoPlanDeEstudio'] , 'B' , 0 , 'L');

				 
				 
$pdf->Ln($Ln);
$pdf->Cell(60);  $pdf->Cell(30  , $Ln , 'I.   A�o Escolar: ' , 0 , 0 , 'L');
				 $pdf->Cell(25  , $Ln , ' '. $AnoEscolar , 'B' , 0 , 'L');
				 $pdf->Cell(56  , $Ln , '  Mes y A�o Matr�cula Final:' , 0 , 0 , 'L');
				 $pdf->Cell(35  , $Ln , ' '. $MesAno , 'B' , 0 , 'L');
$pdf->Ln($Ln);


$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'C�d.DEA: ' , 0 , 0 , 'L');
$pdf->Cell(30  , $Ln , $Colegio_Codigo , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
$pdf->Cell(106  , $Ln , $Colegio_Nombre , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
$pdf->Cell(10  , $Ln , $Colegio_Dtto_Escolar , 'B' , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Direcci�n: ' , 0 , 0 , 'L');
$pdf->Cell(121  , $Ln , $Colegio_Direccion , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Tel�fono: ' , 0 , 0 , 'L');
$pdf->Cell(45  , $Ln , $Colegio_Telefono , 'B' , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
$pdf->Cell(46  , $Ln , $Colegio_Municipio , 'B' , 0 , 'L');
$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
$pdf->Cell(50  , $Ln , $Colegio_Ent_Federal , 'B' , 0 , 'L');
$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
$pdf->Cell(35  , $Ln , $Colegio_Zona_Educativa , 'B' , 0 , 'L');
$pdf->Ln($Ln);
	
	
	
	

$pdf->Cell(50  , $Ln , 'III.    Identificaci�n del Curso:' , 0 , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(23  , $Ln , 'Grado o A�o: ' , 0 , 0 , 'L');
$pdf->Cell(20  , $Ln , '  '.$row_mat['Curso'] , 'B' , 0 , 'L');
$pdf->Cell(16  , $Ln , ' Secci�n: ' , 0 , 0 , 'L');
$pdf->Cell(8   , $Ln , '  '.$row_mat['Seccion'] , 'B' , 0 , 'L');
$pdf->Cell(55  , $Ln , ' No. de Alumnos de la Secci�n: ' , 0 , 0 , 'L');
$pdf->Cell(14  , $Ln , ' '.$num_Alum_Seccion , 'B' , 0 , 'L');
$pdf->Cell(55  , $Ln , ' No. de Alumnos en esta P�g.: ' , 0 , 0 , 'L');
$pdf->Cell(14  , $Ln , '  '.$totalRows_RS_Alumnos , 'B' , 0 , 'L');
$pdf->Ln($Ln);



$pdf->Cell(100  , $Ln , 'IV.   Matr�cula Final del Rendimiento: ' , 0 , 0 , 'L');
$pdf->Ln($Ln);
$Ln = 4.4;



    //$pdf->SetFont('Arial','',9);
	//$pdf->Cell(90);
	//$pdf->Cell(116  , $Ln ,' Tabla de Conversi�n: A (19-20)   B (16-18)   C (13-15)   D (10-12)   E (01-09)'  , 1 , 0 , 'L'); 


    $pdf->SetFont('Arial','',10);
	//$pdf->Ln($Ln*0.5);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
 





	//$pdf->Cell(7  , $Ln * 0.5 ,''  , 'TLR' , 0 , 'C'); 
	//$pdf->Cell(38.5 , $Ln * 0.5 , '' , 'TLR' , 0 , 'C'); 
	//$pdf->Cell(44.5 , $Ln * 0.5 , '' , 'TL' , 0 , 'C'); 
	//$pdf->Ln($Ln* 0.5);
	
	
	// ENCABEZADO
	// Linea 1
	$pdf->Cell(7  , $Ln*4 ,'No'  , 'LRT' , 0 , 'C'); 
	$pdf->Cell(38.5 , $Ln*4 , '' , 'LRT' , 0 , 'C'); 
	$pdf->Cell(52.7 , $Ln*4 , 'Lugar de Nacimiento' , 'LRT' , 0 , 'C'); 
	$pdf->Cell(7 , $Ln*4 , 'E F' , 'LRT' , 0 , 'C'); 
	$pdf->Cell(9 , $Ln*4 ,  'Sexo', 'LRT' , 0 , 'C'); 
	$pdf->Cell(26 , $Ln*3 ,  'Fecha de Nac.', 'LRT' , 0 , 'C'); 
	$pdf->Cell(28.2 , $Ln ,  'Edad', 'LRT' , 0 , 'C'); 
	$pdf->Cell(28.2 , $Ln ,  'Edad', 'LRT' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '' , 'TLR' , 0 , 'C'); 
	$pdf->Ln($Ln);
	
	// Linea 2
	$pdf->Cell(7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Cell(38.5 , $Ln , 'C�dula de Identidad' , '' , 0 , 'C'); 
	$pdf->Cell(94.7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Cell(28.2 , $Ln ,  'Maternal', 'LRB' , 0 , 'C'); 
	$pdf->Cell(28.2 , $Ln ,  'Preescolar', 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln ,  'Ing', 'LR' , 0 , 'C'); 
	$pdf->Ln($Ln);

	
	// Linea 3
	$pdf->Cell(7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Cell(38.5  , $Ln  ,'o C�dula Escolar'  , '' , 0 , 'C'); 
	$pdf->Cell(94.7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '0 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '1 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '2 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '3 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '4 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '5 A'  , 'LR' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*2 , 'B'  , 'LRB' , 0 , 'C'); 
	$pdf->Ln($Ln);
	
	// Linea 4
	$pdf->Cell(114.2  , $Ln  ,''  , 0 , 0 , 'C'); 
	
	$pdf->Cell(8 , $Ln , 'D�a'  , $borde , 0 , 'C'); 
	$pdf->Cell(8 , $Ln , 'Mes'  , $borde , 0 , 'C'); 
	$pdf->Cell(10 , $Ln , 'A�o'  , $borde , 0 , 'C'); 


	$pdf->Cell(9.4 , $Ln , '11 M'  , 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '11 M'  , 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '11 M'  , 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '11 M'  , 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '11 M'  , 'LRB' , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , 'o +' , 'LRB', 0 , 'C'); 
	
	$pdf->Cell(7  , $Ln  ,''  , 0 , 0 , 'C'); 
	$pdf->Ln($Ln);
	
// ALUMNOS
$num_Alum_Pag=0;
$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);

	
	
for ($i=1 ; $i<=20 ; $i++){
	
	
	$sql="SELECT * FROM Nota 
	WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
	AND Ano_Escolar = '".$AnoEscolar."' 
	AND Lapso='Def' ";  
	$RS_notas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RS_notas);

	
	$pdf->Cell(7  , $Ln , substr('0'.$i , -2)  , $borde , 0 , 'C'); 
	
	if($row_RS_Alumnos['Apellidos']=='')	{
		$TripleAst = ' * * * '; } 
	else {
		$TripleAst = ''; }
	
	$pdf->Cell(38.5 , $Ln , $TripleAst.$row_RS_Alumnos['CedulaLetra']." ".$row_RS_Alumnos['Cedula'] , $borde , 0 , 'C', FaltaDato($CodigoAlumno,$row_RS_Alumnos['Cedula'])); 
	$pdf->Cell(52.7 , $Ln , strtoupper($row_RS_Alumnos['Localidad']) , $borde , 0 , 'L', FaltaDato($CodigoAlumno,$row_RS_Alumnos['Localidad'])); 
	
	
	if($row_RS_Alumnos['EntidadCorta'] == 'Dc' or $row_RS_Alumnos['EntidadCorta'] == 'Df')
		$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
	else
		$EntidadCorta = $row_RS_Alumnos['EntidadCorta'];
		
	$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);	
		
	$pdf->Cell(7 , $Ln , strtoupper($EntidadCorta) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,$row_RS_Alumnos['EntidadCorta'])); 
	
	if($row_RS_Alumnos['EntidadCorta']=='Ex') 
		$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
	
	if($row_RS_Alumnos['Datos_Observaciones_Planilla'] > '' ) 
		$Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['Datos_Observaciones_Planilla'].', ';
	
	
	$pdf->Cell(9 , $Ln ,  $row_RS_Alumnos['Sexo'], $borde , 0 , 'C'); 
	
	$pdf->Cell(8 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 
	$pdf->Cell(8 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 
	$pdf->Cell(10 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 0,4) , $borde , 0 , 'C', FaltaDato($CodigoAlumno,substr( $row_RS_Alumnos['FechaNac'] , 8,2))); 


$query_RS_Nota_Al = "SELECT * FROM Nota WHERE CodigoAlumno = '". $row_RS_Alumnos['CodigoAlumno']."' AND Lapso= 'Def' AND Ano_Escolar='".$AnoEscolar."'";
$RS_Nota_Al = mysql_query($query_RS_Nota_Al, $bd) or die(mysql_error());
$row_RS_Nota_Al = mysql_fetch_assoc($RS_Nota_Al);

$nota = $row_RS_Nota_Al['n01'];
$A=$B=$C=$D=$E=$F='';

$Ano2 = substr($AnoEscolar,5,4);

$Edad = Edad_Dif($row_RS_Alumnos['FechaNac'] , $Ano2.'-07-31');
//$Edad = Edad_Dif($row_RS_Alumnos['FechaNac'] , '2011-07-31');

if( $Edad < 1 ) 		{ $A='X'; $tot_A=$tot_A+1; } 
elseif( $Edad < 2 ) 	{ $B='X'; $tot_B=$tot_B+1; } 
elseif( $Edad < 3 ) 	{ $C='X'; $tot_C=$tot_C+1; } 
elseif( $Edad < 4 ) 	{ $D='X'; $tot_D=$tot_D+1; } 
elseif( $Edad < 5 ) 	{ $E='X'; $tot_E=$tot_E+1; } 
elseif( $Edad < 20 ) 	{ $F='X'; $tot_F=$tot_F+1; } 

	$pdf->Cell(9.4 , $Ln , $A  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , $B  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , $C  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , $D  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , $E  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , $F  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln , '*' , $borde , 0 , 'C'); 
	
	$pdf->Ln($Ln);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
}

	$pdf->Cell(120.6);
	$pdf->Cell(19.6  , $Ln*1.5 , 'TOTALES' , 0 , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_A  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_B  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_C  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_D  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_E  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , $tot_F  , $borde , 0 , 'C'); 
	$pdf->Cell(9.4 , $Ln*1.5 , '' , $borde , 0 , 'C'); 
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

	$pdf->Cell(100 , $Ln , $TripleAst.$row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'] , $borde , 0 , 'L'); 
	$pdf->Cell(99 , $Ln , $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'] , $borde , 0 , 'L'); 
	
	$pdf->Ln($Ln);
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
}

	$pdf->Cell(107 , $Ln , 'Apellidos y Nombres del(la) Docente' , 'TLR' , 0 , 'L'); 
	$pdf->Cell(40 , $Ln , 'N�mero de C.I.' , 'TLR' , 0 , 'L'); 
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
$pdf->Cell(101 , $Ln , 'VII. Fecha de Remisi�n:  '.$Fecha_Remision , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln , 'Director(a)' , $borde , 0 , 'C');
$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(52 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln*2 , $Director_Nombre , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln , 'N�mero de C.I.:' , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'SELLO DEL' , 'LR' , 1 , 'C');
$pdf->Cell(52 , $Ln*2 , $Director_CI , $borde , 0 , 'L');
$pdf->Cell(49 , $Ln , 'PLANTEL' , 'LR' , 1 , 'C');
$pdf->Cell(52); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(52 , $Ln , 'Firma:' , $borde , 1 , 'L');
$pdf->Cell(52 , $Ln*2 , '' , $borde , 1 , 'C');

$pdf->SetXY($coorX,$coorY);
$pdf->Cell(105); $pdf->Cell(101 , $Ln , 'VIII. Fecha de Recepci�n:' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Funcionario Receptor' , $borde , 0 , 'C');
$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln*2 , '  ' , $borde , 1 , 'L');
$pdf->Cell(105); $pdf->Cell(52 , $Ln , 'N�mero de C.I.:' , $borde , 0 , 'L');
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