<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/notas.php'); 
require_once('../../../../inc/fpdf.php'); 
if (isset($_GET['test'])) {
$test=true;} else {
$test=false;}
$borde=0;

header("Content-Type: text/html;charset=utf-8");

$CodigoCurso_URL = "0";
 
$Ln = 4.2;

$pdf=new FPDF('P', 'mm', 'Legal');

$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
					WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
					AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
					AND AlumnoXCurso.CodigoAlumno = '$_GET[CodigoAlumno]' 
					GROUP BY Alumno.CodigoAlumno";

$query_RS_Alumno = "SELECT * FROM Alumno
					WHERE CodigoAlumno = '$_GET[CodigoAlumno]' ";

$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
$num_Alum_Seccion = $totalRows_RS_Alumnos;
$PlanDeEstudio = explode(':',$row_RS_Alumnos['PlanDeEstudio']); 

/*
echo $row_RS_Alumnos['PlanDeEstudio'].'<br>';
$PlanDeEstudio = explode(':',$row_RS_Alumnos['PlanDeEstudio']); 
echo $PlanDeEstudio[0].'<br>';
echo $PlanDeEstudio[1].'<br>';
$PlanDeEstudioPag1 = explode(';',$PlanDeEstudio[0]); 
$PlanDeEstudioPag2 = explode(';',$PlanDeEstudio[1]); 
echo $PlanDeEstudioPag1[1].'<br>';
echo $PlanDeEstudioPag1[2].'<br>';
echo $PlanDeEstudioPag1[3].'<br>';
*/



do{
$ColegioNotasCert = '';
$PagNum = 0;	
$EdTrabOrden = 0;
$IndiceAcademico = 0;
$IndiceAcademicoFactor = 0;
unset($Plantel);
extract($row_RS_Alumnos);

if($ColegioNotasCert=='')
	$ColegioNotasCert = '1;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:2;1;U.E. Col San Fco. de Asís;Los Palos Grandes;MI:';
$Colegios_Observaciones = explode(':|',$ColegioNotasCert); 
$Colegios 				= explode(':',$Colegios_Observaciones[0]); 
$Observaciones 			= explode('|',$Colegios_Observaciones[1]); 
foreach($Colegios as $Colegio) {
	$Cole  = explode(';',$Colegio); 
	$Plantel[$Cole[0]][$Cole[1]][Nombre] = $Cole[2];
	$Plantel[$Cole[0]][$Cole[1]][Localidad] = $Cole[3];
	$Plantel[$Cole[0]][$Cole[1]][EF] = $Cole[4];
}

$Pagina = array(array('7','8','9'), array('IV','V',''));
foreach($Pagina as $CodigoMaterias){
$PagNum++;
foreach($CodigoMaterias as $CodigoMateria){
	$sql = "SELECT * FROM Notas_Certificadas 
			WHERE CodigoAlumno = $CodigoAlumno 
			AND Grado = '$CodigoMateria'
			ORDER BY Grado, Orden"; 
			//echo $sql;
	$RSnotas = mysql_query($sql, $bd) or die(mysql_error());
	$row_notas = mysql_fetch_assoc($RSnotas);
	
	do{	
		if($row_notas['Mes']!='ET')
			$Renglon[$CodigoMateria][$row_notas['Orden']] =	$row_notas;	
			
		elseif($row_notas['Mes']=='ET'){
			$EdTrabOrden++;
			if($row_notas['Grado'] > 6) 
				$GradoET = $row_notas['Grado']-6;
								
			$EdTrab[$EdTrabOrden]['Grado']   = $GradoET;
			$EdTrab[$EdTrabOrden]['Materia'] = $row_notas['Materia'];
			$EdTrab[$EdTrabOrden]['Horas']   = $row_notas['Nota'];	}

	} while ($row_notas = mysql_fetch_assoc($RSnotas));
}
			$EdTrabOrden++;
			$EdTrab[$EdTrabOrden]['Grado']   = '*';
			$EdTrab[$EdTrabOrden]['Materia'] = '* * *';
			$EdTrab[$EdTrabOrden]['Horas']   = '*';

if($PagNum == 2) unset($EdTrab);

$pdf->AddPage();
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','',10);

// Encabezado Página
$pdf->Image('../../../../img/LogoME2.jpg', 5, 5, 100, 20);
$pdf->SetY( 5 ); 
$pdf->Ln($Ln);
$pdf->Cell(125); $pdf->Cell(70  , $Ln , 'CERTIFICACIÓN DE CALIFICACIONES' , 'B' , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(125); $pdf->Cell(70  , $Ln , ' Código del Formato: RR-DEA-03-03 ' , 0 , 0 , 'C');
$pdf->Ln($Ln);

$PlanDeEstudio12 = explode(':',$PlanDeEstudio); 
$PlanDeEstudioPag1 = explode(';',$PlanDeEstudio12[0]); 
$PlanDeEstudioPag2 = explode(';',$PlanDeEstudio12[1]); 

// 2;Educación Media General;31018;Ciencias

if($PagNum == 1) {
	$CodigoPlanDeEstudio = $PlanDeEstudioPag1[2];
	$NombrePlanDeEstudio = $PlanDeEstudioPag1[1];
	$Mencion = $PlanDeEstudioPag1[3];
	}
else {
	$CodigoPlanDeEstudio = $PlanDeEstudioPag2[2];
	$NombrePlanDeEstudio = $PlanDeEstudioPag2[1];
	//$NombrePlanDeEstudio = "BACHILLER";
	$Mencion = $PlanDeEstudioPag2[3];
	}
	
	
	
//echo $NombrePlanDeEstudio;
	
if($NombrePlanDeEstudio == "III Etapa de Educación Básica")	{
	$GradosP1 = "789";
	}
if($NombrePlanDeEstudio == "Media Diversificada y Profesional" or $NombrePlanDeEstudio == "Ciclo Diversificado")	{
	$GradosP2 = "12";
	}
	
$pdf->Cell(100);  $pdf->Cell(35  , $Ln , 'PLAN DE ESTUDIO: ' , 0 , 0 , 'L');
				 $pdf->Cell(70  , $Ln , ' '.$NombrePlanDeEstudio  , 'B' , 1 , 'L');
$pdf->Cell(100);	 $pdf->Cell(46  , $Ln , 'Código del Plan de Estudio:  ' , 0 , 0 , 'L');
				 $pdf->Cell(59  , $Ln , ' '.$CodigoPlanDeEstudio , 'B' , 1 , 'L');
$pdf->Cell(100);  $pdf->Cell(17  , $Ln , 'Mención: ' , 0 , 0 , 'L');
				 $pdf->Cell(88  , $Ln , ' '. $Mencion , 'B' , 0 , 'L');
				// $pdf->Cell(47  , $Ln , ' Mes y Año de la Evaluación:' , 0 , 0 , 'L');
				// $pdf->Cell(30  , $Ln , ' '. $MesAno , 'B' , 0 , 'L');
$pdf->Ln($Ln);
			
			
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->Cell(20  , $Ln , 'Cód.DEA: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30  , $Ln , ' S0934D1507 ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Nombre: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(101  , $Ln , $Colegio_Nombre , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(10  , $Ln , ' 7 ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Dirección: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(116  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Teléfono: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(45  , $Ln , ' 283.25.75 ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Municipio: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(46  , $Ln , ' Chacao ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(45  , $Ln , ' Estado Miranda ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35  , $Ln , ' Miranda ' , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(50  , $Ln , 'III.    Datos de Identificación del Alumno:' , 0 , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30  , $Ln , 'Céd. Identidad: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(68  , $Ln , $CedulaLetra.$Cedula  ,$borde, 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40  , $Ln , ' Fecha de Nacimiento: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(40  , $Ln , DDMMAAAA($FechaNac)  , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , 'Apellidos: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(78  , $Ln , $Apellidos.' '.$Apellidos2  , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20  , $Ln , ' Nombres: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(83  , $Ln , $Nombres.' '.$Nombres2 , $borde , 0 , 'L');
$pdf->Ln($Ln);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(38  , $Ln , 'Lugar de Nacimiento: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(60  , $Ln , $Localidad , $borde , 0 , 'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35  , $Ln , ' Ent. Federal o País: ' , $borde , 0 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(55  , $Ln , $Entidad.$LocalidadPais , $borde , 0 , 'L');
$pdf->Ln($Ln*2);
/*				$pdf->Cell(7  , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
	$pdf->Cell(55 , $Ln , $row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'] , $borde , 0 , 'L'); 
	$pdf->Cell(55 , $Ln , $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'] , $borde , 0 , 'L'); 
	$pdf->Cell(53.25 , $Ln , $row_RS_Alumnos['Localidad'] , $borde , 0 , 'L'); 
	$pdf->Cell(7.75 , $Ln , $row_RS_Alumnos['EntidadCorta'] , $borde , 0 , 'C'); 
	if($row_RS_Alumnos['EntidadCorta']=='Ex') $Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
	
	$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C'); 
	$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C'); 
	$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 2,2) , $borde , 0 , 'C'); 
*/	

$pdf->SetFont('Arial','B',10);
$pdf->Cell(101  , $Ln , 'IV.   Planteles donde cursó estos estudios: ' , 1 , 0 , 'L');
$pdf->Cell(7    , $Ln , 'Nº' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , 'Nombre del Plantel' , 1 , 0 , 'C');
$pdf->Cell(32   , $Ln , 'Localidad' , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , 'E.F.' , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , 'Nº' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , 'Nombre del Plantel' , 1 , 0 , 'C');
$pdf->Cell(32   , $Ln , 'Localidad' , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , 'E.F.' , 1 , 0 , 'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(7    , $Ln , '3' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][3][Nombre] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][3][Localidad] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][3][EF] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , '1' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][1][Nombre] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][1][Localidad] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][1][EF] , 1 , 0 , 'C');
$pdf->Cell(7    , $Ln , '4' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][4][Nombre] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][4][Localidad] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][4][EF] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Cell(7    , $Ln , '2' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][2][Nombre] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][2][Localidad] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][2][EF] , 1 , 0 , 'C');
$pdf->Cell(7    , $Ln , '5' , 1 , 0 , 'C');
$pdf->Cell(52   , $Ln , $Plantel[$PagNum][5][Nombre] , 1 , 0 , 'L');
$pdf->Cell(32   , $Ln , $Plantel[$PagNum][5][Localidad] , 1 , 0 , 'C');
$pdf->Cell(10   , $Ln , $Plantel[$PagNum][5][EF] , 1 , 0 , 'C');
$pdf->Ln($Ln);

$pdf->Ln($Ln);
$coorY = $pdf->GetY();
// FIN Encabezado

$pdf->SetFont('Arial','B',10);
$pdf->Cell(155 , $Ln , 'V. Pensum de Estudio:' , 1 , 1 , 'L');

foreach($CodigoMaterias as $CodigoMateria){
	
	if($CodigoMateria=='IV' and $GradosP2 == "12")    	$Grado = '1er año';
	elseif($CodigoMateria=='V' and $GradosP2 == "12") 	$Grado = '2do año';
	elseif($CodigoMateria=='7' and $GradosP1 == "789") 	$Grado = '7mo grado';
	elseif($CodigoMateria=='8' and $GradosP1 == "789") 	$Grado = '8vo grado';
	elseif($CodigoMateria=='9' and $GradosP1 == "789") 	$Grado = '9no grado';
	elseif($CodigoMateria=='7') 						$Grado = '1er año';
	elseif($CodigoMateria=='8') 						$Grado = '2do año';
	elseif($CodigoMateria=='9') 						$Grado = '3er año';
	elseif($CodigoMateria=='IV') 						$Grado = '4to año';
	elseif($CodigoMateria=='V') 						$Grado = '5to año';
	elseif($CodigoMateria=='')  $Grado = '';
	
	$pdf->SetFont('Arial','B',10);
	
	$pdf->Cell(58 , $Ln , 'Año o Grado: '.$Grado .'', 1 , 0 , 'L');
	$pdf->Cell(44 , $Ln , 'Calificación' , 1 , 0 , 'C');
	$pdf->Cell(11 , $Ln*2 , 'T-E' , 1 , 0 , 'C');
	$pdf->Cell(25 , $Ln , 'Fecha' , 1 , 0 , 'C');
	$pdf->Cell(17, $Ln , 'Plantel' , 'TLR' , 0 , 'C');
	$pdf->Ln($Ln);
	
	$pdf->Cell(58 , $Ln , 'Asignaturas' , 1 , 0 , 'C');
	$pdf->Cell(13 , $Ln , 'En Nº' , 1 , 0 , 'C');
	$pdf->Cell(31 , $Ln , 'En letras' , 1 , 0 , 'C');
	$pdf->Cell(11);
	$pdf->Cell(10, $Ln , 'Mes' , '1' , 0 , 'C');
	$pdf->Cell(15, $Ln , 'Año' , '1' , 0 , 'C');
	$pdf->Cell(17, $Ln , 'Nº' , 'BLR' , 0 , 'C');
	$pdf->Ln($Ln);
	
	$pdf->SetFont('Arial','',10);
	for ($i_mat=1 ; $i_mat<=13 ; $i_mat++){
		
		$pdf->Cell(58 , $Ln , $Renglon[$CodigoMateria][$i_mat][Materia] , 1 , 0 , 'L');
		
		if( $Renglon[$CodigoMateria][$i_mat][Nota]<' ' or 
			$Renglon[$CodigoMateria][$i_mat][Nota]=='*' )	{
				
					$Renglon[$CodigoMateria][$i_mat][Nota]='*';
					$Renglon[$CodigoMateria][$i_mat][TE]='*';
					$Renglon[$CodigoMateria][$i_mat][Mes]='*';
					$Renglon[$CodigoMateria][$i_mat][Ano]='*';
					$Renglon[$CodigoMateria][$i_mat][Plantel]='*';
			
			}else{
				if($Renglon[$CodigoMateria][$i_mat][Nota] >= '10' 
						and $Renglon[$CodigoMateria][$i_mat][Nota] <= '20' 
						and $Renglon[$CodigoMateria][$i_mat][Materia]>''){
					$IndiceAcademico += $Renglon[$CodigoMateria][$i_mat][Nota];	
					$IndiceAcademicoFactor++;	}
			}
		
		
		$NotaRenglon = $Renglon[$CodigoMateria][$i_mat][Nota];
		if($Renglon[$CodigoMateria][$i_mat][Materia] > ''){
			if($NotaRenglon >= '01' and $NotaRenglon <= '09')
				$NotaRenglon = "P";
			$pdf->Cell(13 , $Ln , $NotaRenglon , 1 , 0 , 'C');}
		else
			$pdf->Cell(13 , $Ln , '*' , 1 , 0 , 'C');
				
		
		
		
		if($Renglon[$CodigoMateria][$i_mat][Nota]<>'Ex'){
			if($Renglon[$CodigoMateria][$i_mat][Materia] > ''){
				$pdf->Cell(31 , $Ln , EnLetras($NotaRenglon) , 1 , 0 , 'C');}
			else
				$pdf->Cell(31 , $Ln , '*' , 1 , 0 , 'C');
			
			$TE_Renglon = $Renglon[$CodigoMateria][$i_mat][TE];
			if($NotaRenglon == 'P')
				$TE_Renglon = '*';
			$pdf->Cell(11 , $Ln , $TE_Renglon , 1 , 0 , 'C');

			$pdf->Cell(10 , $Ln , $Renglon[$CodigoMateria][$i_mat][Mes] , 1 , 0 , 'C');
			$pdf->Cell(15 , $Ln , $Renglon[$CodigoMateria][$i_mat][Ano] , 1 , 0 , 'C');
			$pdf->Cell(17 , $Ln , $Renglon[$CodigoMateria][$i_mat][Plantel] , 1 , 0 , 'C'); }
		else {
			$pdf->Cell(31 , $Ln , 'Exonerada' , 1 , 0 , 'C');
			$pdf->Cell(53 , $Ln , 'Según Art.134 R.G.L.O.E.' , 1 , 0 , 'C');
			}
		$pdf->Ln($Ln);
}}
			

$coorX = 157+5;

$pdf->SetY($coorY);

$pdf->SetFont('Arial','B',10);
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "VI. PLANTEL" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Apellidos y Nombres" , 'TLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "del Director(a):" , 'BLR' , 1 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , $Director_Nombre , 1 , 1 , 'R');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Número de C.I.:" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , $Director_CI , 1 , 1 , 'R');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Firma:" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*2 , "" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*4 , "" , 'TLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "SELLO DEL" , 'LR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "PLANTEL" , 'LR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*5 , "" , 'BLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*1.5 , "Para efecto de su validéz" , 'TLR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*1.5 , "a nivel estadal." , 'LRb' , 1 , 'C');
//$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "ggg" , 'BLR' , 0 , 'C');
			
$pdf->SetFont('Arial','B',10);
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "VII. ZONA EDUCATIVA" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Apellidos y Nombres" , 'TLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "del Director(a):" , 'BLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "" , 1 , 1 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Número de C.I.:" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Firma:" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*2 , "" , 1 , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*4 , "" , 'TLR' , 1 , 'L');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "SELLO DE LA" , 'LR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "ZONA EDUCATIVA" , 'LR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln*5 , "" , 'BLR' , 1 , 'L');
$pdf->SetFont('Arial','', 6);
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "Para efecto de su validéz a nivel nacional" , 'TLR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "e internacional y cuando se trate de estudios" , 'LR' , 1 , 'C');
$pdf->SetX($coorX); $pdf->Cell(45 , $Ln , "libres o equivalencia sin escolaridad" , 'BLR' , 1 , 'C');
			



$pdf->SetFont('Arial','',10);
			
			
			$coorX = $pdf->GetX();
			$coorY = $pdf->GetY();
			$pdf->Cell(201.25 , $Ln , 'VIII.  Programas cursados en Educación Para El Trabajo / Horas - Alumnos Semanales de C/Uno' , $borde , 1 , 'L');
			

			for($i=1 ; $i<=10 ; $i++){
					if($EdTrab[$i]['Grado'] == '1' and $GradosP1 == "789") 	$EdTrab[$i]['Grado'] = '7';
				elseif($EdTrab[$i]['Grado'] == '2' and $GradosP1 == "789") 	$EdTrab[$i]['Grado'] = '8';
				elseif($EdTrab[$i]['Grado'] == '3' and $GradosP1 == "789") 	$EdTrab[$i]['Grado'] = '9';
		
			}
			
			
			for($i=1 ; $i<=5 ; $i++){
				//ET $i
				$pdf->Cell(10 , $Ln , $EdTrab[$i]['Grado'] , 1 , 0 , 'C');
				$pdf->Cell(81 , $Ln , $EdTrab[$i]['Materia'] , 1 , 0 , 'L');
				$pdf->Cell(10 , $Ln , $EdTrab[$i]['Horas'] , 1 , 0 , 'C');
				
				//ET $i+5
				$pdf->Cell(10 , $Ln , $EdTrab[$i+5]['Grado'] , 1 , 0 , 'C');
				$pdf->Cell(81 , $Ln , $EdTrab[$i+5]['Materia'] , 1 , 0 , 'L');
				$pdf->Cell(10 , $Ln , $EdTrab[$i+5]['Horas'] , 1 , 1 , 'C');
			}
						
			
			$Obs_pais = substr($Obs_pais, 0, -2);
			//$pdf->Cell(35 , $Ln ,  , '',0 , 'L');
			
			if(isset($_GET['Promedia']))				
				if($PagNum==1){
					$Obs = 'Índice académico: '. round($IndiceAcademico/$IndiceAcademicoFactor,2).' puntos. ';
				}
				elseif($PagNum==2){
					$Obs = 'Índice académico desde 1er año: '. round($IndiceAcademico/$IndiceAcademicoFactor,2).' puntos. ';
				}
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			
			$pdf->MultiCell(202 , $Ln , 'VIII.  Observaciones: ' . $Obs . $Observaciones[$PagNum-1] , 'B', 'L');
			$pdf->SetXY($x,$y);
			$pdf->Cell(202 , $Ln , '', 1 , 1, 'L');
			$pdf->Cell(202 , $Ln , '', 1 , 1, 'L');
			$pdf->Cell(202 , $Ln , '', 1 , 1, 'L');
			$pdf->Cell(202 , $Ln , '', 1 , 1, 'L');
			
			$pdf->Cell(55 , $Ln , 'IX.  Lugar y Fecha de expedición: ' , '',0 , 'L');
			$pdf->Cell(147 , $Ln , '  Los Palos Grandes, '.date('d').' de '. Mes(date('m')).' de '.date('Y') ,'B',1, 'L');

			$pdf->SetFont('Arial','', 8);
			$pdf->Cell(20 , $Ln , 'Timbre Fiscal: ' , '',0 , 'L');
			$pdf->SetFont('Arial','', 6);
			$pdf->Cell(180 , $Ln , 'Este Documento no tiene validez si no se le colocan en la parte posterior timbres fiscales por 30% de la U.T.' , '',0 , 'L');
			
			
// DORSO
$pdf->AddPage();
$pdf->SetY(20);

$pdf->SetFont('Arial','B', 14);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Verificado por:' , '',1 , 'L');
$pdf->SetFont('Arial','', 12);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Omaira J. Fernández G.' , '',1 , 'L');
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.5.223.338' , '',1 , 'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B', 12);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Revisado por:' , '',1 , 'L');
$pdf->SetFont('Arial','', 12);

$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Lic. Angela J. Reale H.' , '',1 , 'L');
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.5.220.494' , '',1 , 'L');
//$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Lic. Ronald E. Rincón P.' , '',1 , 'L');
//$pdf->SetX(15); $pdf->Cell(20 , 6 , 'C.I.14.018.534' , '',1 , 'L');

$pdf->Ln(6);
$pdf->SetX(15); $pdf->Cell(20 , 6 , 'Caracas, ' .date(d).' de '.Mes(date(m)).' de '.date(Y) , '',1 , 'L');
		
		
}

}while($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos));
$pdf->Output();


?>
