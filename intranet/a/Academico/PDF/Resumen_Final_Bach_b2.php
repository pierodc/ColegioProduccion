<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../intranet/a/archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 
require_once('Belandria.php'); 

//function oi($i){ return substr('0'.$i,-2);}

$borde=1;
$Ln = 4.2;
$Mats = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
$Alum = array('01','02','03','04','05','06','07','08','09','10','11','12','13');

$pdf=new FPDF('P', 'mm', 'Legal');

$pdf->AddPage();
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','',10);

// ENCABEZADO
$pdf->Image('../../../../img/LogoME2.jpg', 5, 5, 0, 17);
$pdf->SetY( 9.2 ); 
$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'RESUMEN FINAL DEL RENDIMIENTO ESTUDIANTIL' , 'B' , 1 , 'C');
$pdf->Cell(100); $pdf->Cell(100  , $Ln , ' Código del Formato: RR-DEA-04-03 ' , 0 , 1 , 'C');
$pdf->Cell(70);  $pdf->Cell(35  , $Ln , 'PLAN DE ESTUDIO: ' , 0 , 0 , 'L');
$pdf->Cell(50  , $Ln , ' '.$Planilla['Plan']  , 'B' , 0 , 'L');
$pdf->Cell(18  , $Ln , 'CÓDIGO:  ' , 0 , 0 , 'L');
$pdf->Cell(27  , $Ln , ' '. $Planilla['Codigo'] , 'B' , 1 , 'L');
$pdf->Cell(70);  $pdf->Cell(28  , $Ln , 'I.   Año Escolar: ' , 0 , 0 , 'L');
$pdf->Cell(25  , $Ln , ' '. $Planilla['Ano'] , 'B' , 0 , 'L');
$pdf->Cell(47  , $Ln , ' Mes y Año de la Evaluación:' , 0 , 0 , 'L');
$pdf->Cell(30  , $Ln , ' '. $Planilla['MesAno'] , 'B' , 1 , 'L');


$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 1 , 'L');
$pdf->Cell(20  , $Ln , 'Cód.DEA: ' , 0 , 0 , 'L');
$pdf->Cell(30  , $Ln , ' S0934D1507 ' , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
$pdf->Cell(101.25  , $Ln , ' U.E. Colegio San Francisco de Asís ' , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
$pdf->Cell(10  , $Ln , ' 7 ' , 'B' , 1 , 'L');

$pdf->Cell(20  , $Ln , 'Dirección: ' , 0 , 0 , 'L');
$pdf->Cell(116.25  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , 'B' , 0 , 'L');
$pdf->Cell(20  , $Ln , ' Teléfono: ' , 0 , 0 , 'L');
$pdf->Cell(45  , $Ln , ' 283.25.75 ' , 'B' , 1 , 'L');

$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
$pdf->Cell(46.25  , $Ln , ' Chacao ' , 'B' , 0 , 'L');
$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
$pdf->Cell(45  , $Ln , ' Estado Miranda ' , 'B' , 0 , 'L');
$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
$pdf->Cell(35  , $Ln , ' Miranda ' , 'B' , 1 , 'L');

$pdf->Cell(20  , $Ln , 'Director(a): ' , 0 , 0 , 'L');
$pdf->Cell(116.25  , $Ln , ' Vita María Di Campo ' , 'B' , 0 , 'L');
$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L');
$pdf->Cell(55  , $Ln , ' 6973243 ' , 'B' , 1 , 'L');

$pdf->Cell(100  , $Ln , 'III.   Resumen Final del Rendimiento ' , 0 , 1 , 'L');

// encabezado tabla superior		
$pdf->Cell(7  , $Ln*3 , 'No' , $borde , 0 , 'C'); //Linea 1 (201,25 mm)
$pdf->Cell(33 , $Ln*1.5 , 'Cédula de'  , 'T' , 0 , 'C'); //Linea 1
$pdf->Cell(122.5 , $Ln , 'Calificaciones de las Asignaturas'  , $borde , 0 , 'C'); //Linea 1
$pdf->Cell(31  , $Ln , 'Prog. Aprobados'  , 'TLR' , 0 , 'C'); //Linea 1
$pdf->Cell(7.75  , $Ln*3 , ''  , $borde , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Cell(7);
$pdf->Cell(33 , $Ln*1.5 , 'Identidad'  , 0 , 0 , 'C');
foreach ($Mats as $i){
	$pdf->Cell(8.75 , $Ln , $i , $borde , 0 , 'C'); } 
	$pdf->Cell(31  , $Ln , 'Educ. Trab.'  , 'BLR' , 0 , 'C');
	$pdf->SetFont('Arial','',8);
$pdf->Cell(7.75  , $Ln , 'Resu'  , 0 , 1 , 'C'); //Linea 1
$pdf->SetFont('Arial','',10);


// encabezado materias
$pdf->Cell(40);
for  ($i = 1; $i <= 14;$i++){
	$pdf->Cell(8.75 , $Ln , $Planilla["M".$i] , $borde , 0 , 'C'); } 
	$pdf->Cell(7.75 , $Ln , '1' , $borde , 0 , 'C'); 
	$pdf->Cell(7.75 , $Ln , '2' , $borde , 0 , 'C'); 
	$pdf->Cell(7.75 , $Ln , '3' , $borde , 0 , 'C'); 
	$pdf->Cell(7.75 , $Ln , '4' , $borde , 0 , 'C'); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(7.75    , $Ln , 'men' , 0 , 1 , 'C'); 
	$pdf->SetFont('Arial','',10);
// FIN Encabezado


//NOTAS para cada Alumno
	for  ($NoAlum = 1 ; $NoAlum <= 13 ; $NoAlum++){

		// No.
		$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
	
		// Cedula
		$pdf->Cell(33 , $Ln , $Al[$NoAlum]['Cedula'] , $borde , 0 , 'C'); // Cedula
		
		for  ($j = 1; $j <= 14;$j++){ // para cada materia  NOTAS
			$pdf->Cell(8.75 , $Ln ,  $Al[$NoAlum]['N'.$j] , $borde , 0 , 'C'); 
		} // fin para cada materia
		
		$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]["E1"] , $borde , 0 , 'C'); 
		$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]["E2"] , $borde , 0 , 'C'); 
		$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]["E3"] , $borde , 0 , 'C'); 
		$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]["E4"] , $borde , 0 , 'C'); 
		$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]["R"] , $borde , 0 , 'C'); 
		
		$pdf->Ln($Ln);

	}

// totales
$tipo_tot = array('INSCR', 'INAS', 'APRO', 'APLAZ');
foreach($tipo_tot as $tipo){
	if($tipo=='INAS'){
		$pdf->Cell(21 , $Ln*2 , 'TOTALES' , 0 , 0 , 'C');}
	else{ 
		$pdf->Cell(21);}

	$pdf->Cell(19 , $Ln , ' '.$tipo , $borde , 0 , 'L'); 

	for  ($i = 1; $i <= 14;$i++){
		if($tipo == 'INSCR') 	$pdf->Cell(8.75 , $Ln , $Inscritos[$i] , $borde , 0 , 'C'); 
		if($tipo == 'INAS') 		$pdf->Cell(8.75 , $Ln , $Inasistentes[$i] , $borde , 0 , 'C'); 
		if($tipo == 'APRO') 		$pdf->Cell(8.75 , $Ln , $Aprobados[$i] , $borde , 0 , 'C'); 
		if($tipo == 'APLAZ') 	$pdf->Cell(8.75 , $Ln , $Aplazados[$i] , $borde , 0 , 'C'); 
	} 
	$j=0;
		if($tipo=='INSCR'){
			$pdf->Cell(38.75 , $Ln*2 , 'Tipo de Evaluación' , $borde , 0 , 'C');  }
			if($tipo=='APRO'){
				$pdf->Cell(38.75 , $Ln , $Planilla['Tipo_Evaluacion'] , $borde , 0 , 'C');  }
				if($tipo=='APLAZ'){
					$pdf->Cell(38.75 , $Ln , '' , $borde , 0 , 'C');  }
					$pdf->Ln($Ln);
		}




// ALUMNOS
							$pdf->Cell(7  , $Ln , 'No' , $borde , 0 , 'C'); 
							$pdf->Cell(55 , $Ln , 'Apellidos' , $borde , 0 , 'C'); 
							$pdf->Cell(55 , $Ln , 'Nombres' , $borde , 0 , 'C'); 
							$pdf->Cell(53.25 , $Ln , 'Lugar de Nacimiento' , $borde , 0 , 'L'); 
							$pdf->Cell(7.75 , $Ln , 'E F' , $borde , 0 , 'C'); 

							$pdf->Cell(23.25 , $Ln , 'Fecha de Nac' , $borde , 0 , 'C'); 

							$pdf->Ln($Ln);
							for ($NoAlum=1 ; $NoAlum<=13 ; $NoAlum++){
								if ($Al[$NoAlum]['Apellidos'] > '') 
									$num_Alum_Pag++;
								$pdf->Cell(7  , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
								if($Al[$NoAlum]['Apellidos'] == '')
									$Apellidos = ' * * * ';
								else
									$Apellidos = $Al[$NoAlum]['Apellidos'];
								$pdf->Cell(55 , $Ln , $Apellidos , $borde , 0 , 'L'); 
								$pdf->Cell(55 , $Ln , $Al[$NoAlum]['Nombres'] , $borde , 0 , 'L'); 
								$pdf->Cell(53.25 , $Ln , $Al[$NoAlum]['LugarNac'] , $borde , 0 , 'L'); 


								$pdf->Cell(7.75 , $Ln , $Al[$NoAlum]['EF'] , $borde , 0 , 'C'); 
								if($row_RS_Alumnos['EntidadCorta']=='Ex') $Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';

								$pdf->Cell(6.75 , $Ln , $Al[$NoAlum]['DD'] , $borde , 0 , 'C'); 
								$pdf->Cell(6.75 , $Ln , $Al[$NoAlum]['MM']  , $borde , 0 , 'C'); 
								$pdf->Cell(9.75 , $Ln , $Al[$NoAlum]['AAAA']  , $borde , 0 , 'C'); 

								$pdf->Ln($Ln);

							}


// PROFESORES
							$pdf->Cell(7 , $Ln*2 , 'No' , $borde , 0 , 'C'); 
							$pdf->Cell(55 , $Ln*2 , 'Asignatura' , $borde , 0 , 'C'); 
							$pdf->Cell(49 , $Ln , 'Apellidos y Nombres del' , 0 , 0 , 'C'); 
							$pdf->Cell(25 , $Ln*2 , 'C.I.' , $borde , 0 , 'C'); 
							$pdf->Cell(25 , $Ln*2 , 'Firma' , $borde , 0 , 'C');
							$coorX = $pdf->GetX();
							$coorY = $pdf->GetY();
							$pdf->Ln($Ln);
							$pdf->Cell(62);
							$pdf->Cell(49 , $Ln , 'Profesor' , 0 , 0 , 'C'); 
							$pdf->Ln($Ln);

							for  ($i = 1; $i <= 14;$i++){
								$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
								$pdf->Cell(55 , $Ln , $Planilla["Mat".$i] , $borde , 0 , 'L'); 
								$pdf->Cell(49 , $Ln , $Planilla["ProfMat".$i] , $borde , 0 , 'L'); 
								$pdf->Cell(25 , $Ln , $Planilla["ProfCIMat".$i] , $borde , 0 , 'R'); 
								if($Inscritos[$i]==0)$Profesor_firma[$i]=' * * * ';
								$pdf->Cell(25 , $Ln , $Profesor_firma[$i] , $borde , 0 , 'C');
								$pdf->Ln($Ln);
							}


							$pdf->SetXY($coorX,$coorY);
							$pdf->Cell(40.25 , $Ln*2 , 'Identificación del' , 'TLR' , 1 , 'C');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'Curso' , 'BLR' , 1 , 'C');
							$pdf->SetFont('Arial','',9);
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'MENCIÓN:' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $Planilla['Mencion'] , $borde , 1 , 'R');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , '' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'GRADO o AÑO:' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $Planilla['Grado'] , $borde , 1 , 'R');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'SECCIÓN:' , $borde , 1 , 'L');
							
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $Planilla['Seccion'] , $borde , 1 , 'R');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA PÁGINA' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , "1" , $borde , 1 , 'R');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA SECCIÓN' , $borde , 1 , 'L');
							$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , "1" , $borde , 1 , 'R');

							$pdf->Cell(201.25 , $Ln , 'V.  Programas cursados en Educación Para El Trabajo / Horas - Alumnos Semanales de C/Uno' , $borde , 1 , 'L');
//ET 1
							$pdf->Cell(7 , $Ln , '1.' , $borde , 0 , 'C');
							$pdf->Cell(83.5 , $Ln , $Planilla['ET1'] , $borde , 0 , 'L');
							$pdf->Cell(10 , $Ln , $Planilla['ET1HR'] , $borde , 0 , 'L');

//ET 3
							$pdf->Cell(7 , $Ln , '3.' , $borde , 0 , 'C');
							$pdf->Cell(83.75 , $Ln , '  ' , $borde , 0 , 'L');
							$pdf->Cell(10 , $Ln , '  ' , $borde , 1 , 'L');

//ET 2
							$pdf->Cell(7 , $Ln , '2.' , $borde , 0 , 'C');
							$pdf->Cell(83.5 , $Ln , $Planilla['ET2'] , $borde , 0 , 'L');
							$pdf->Cell(10 , $Ln , $Planilla['ET2HR'] , $borde , 0 , 'L');

//ET 4
							$pdf->Cell(7 , $Ln , '4.' , $borde , 0 , 'C');
							$pdf->Cell(83.75 , $Ln , '  ', $borde , 0 , 'L');
							$pdf->Cell(10 , $Ln , '  ' , $borde , 1 , 'L');

							$Obs_pais = substr($Obs_pais, 0, -2);
							$pdf->MultiCell(201.25 , $Ln , 'VI.  Observaciones: '.$Obs_pais , 'TLR' , 'L');
							$pdf->MultiCell(201.25 , $Ln , '' , 'BLR' , 'L');

							$pdf->Ln(2);
							$coorX = $pdf->GetX();
							$coorY = $pdf->GetY();
							$pdf->Cell(98 , $Ln , 'VII. Fecha de Remisión:  '.$Fecha_Remision , $borde , 1 , 'L');
							$pdf->Cell(49 , $Ln , 'Director(a)' , $borde , 0 , 'C');
							$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
							$pdf->Ln($Ln);
							$pdf->Cell(49 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
							$pdf->Cell(49 , $Ln*2 , '  Vita María Di Campo' , $borde , 1 , 'L');
							$pdf->Cell(49 , $Ln , 'Número de C.I.:' , $borde , 0 , 'L');
							$pdf->Cell(49 , $Ln , 'SELLO DEL' , 'LR' , 1 , 'C');
							$pdf->Cell(49 , $Ln*2 , '  6973243' , $borde , 0 , 'L');
							$pdf->Cell(49 , $Ln , 'PLANTEL' , 'LR' , 1 , 'C');
							$pdf->Cell(49); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
							$pdf->Ln($Ln);
							$pdf->Cell(49 , $Ln , 'Firma:' , $borde , 1 , 'L');
							$pdf->Cell(49 , $Ln*2 , '' , $borde , 1 , 'C');

							$pdf->SetXY($coorX,$coorY);
							$pdf->Cell(103.25); $pdf->Cell(98 , $Ln , 'VIII. Fecha de Recepción:' , $borde , 1 , 'L');
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Funcionario Receptor' , $borde , 0 , 'C');
							$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
							$pdf->Ln($Ln);
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln*2 , '  ' , $borde , 1 , 'L');
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Número de C.I.:' , $borde , 0 , 'L');
							$pdf->Cell(49 , $Ln , 'SELLO DE LA ZONA' , 'LR' , 1 , 'C');
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln*2 , '  ' , $borde , 0 , 'L');
							$pdf->Cell(49 , $Ln , 'EDUCATIVA' , 'LR' , 1 , 'C');
							$pdf->Cell(103.25); $pdf->Cell(49); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
							$pdf->Ln($Ln);
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Firma:' , $borde , 1 , 'L');
							$pdf->Cell(103.25); $pdf->Cell(49 , $Ln*2 , '' , $borde , 1 , 'C');








							$pdf->Output();


							?>