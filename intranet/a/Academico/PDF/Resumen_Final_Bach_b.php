<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../intranet/a/archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 
require_once('Belandria.php'); 

//function oi($i){ return substr('0'.$i,-2);}


if (isset($_GET['test'])) { 
	$test=true;} 
else {
	$test=false;}

	
$borde = 1;
$Ln = 4.2;
$Mats = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
$Alum = array('01','02','03','04','05','06','07','08','09','10','11','12','13');

$pdf=new FPDF('P', 'mm', 'Legal');
$pdf->SetFillColor(255);
			


	
			$Obs_pais=' ';
				
			$pdf->AddPage();
			$pdf->SetMargins(5,5,5);
			$pdf->SetFont('Arial','',10);
			
			// ENCABEZADO
			$pdf->Image('../../../../img/LogoME2018.jpg', 5, 5, 90, 0);
			$pdf->SetY( 9.2 ); 
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'RESUMEN FINAL DEL RENDIMIENTO ESTUDIANTIL' , 'B' , 1 , 'C');
			
			$NombrePlanDeEstudio = $Dato['Plan'];
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , '  ' , 0 , 1 , 'C');
			
			$pdf->Cell(70);  $pdf->Cell(35  , $Ln , 'PLAN DE ESTUDIO: ' , 0 , 0 , 'L');
							 $pdf->Cell(50  , $Ln , ' '.$NombrePlanDeEstudio  , 'B' , 0 , 'L');
							 $pdf->Cell(18  , $Ln , 'CÓDIGO:  ' , 0 , 0 , 'L');
							 $pdf->Cell(27  , $Ln , '31059'  , 'B' , 1 , 'L'); //$row_mat['CodigoPlanDeEstudio']
			$pdf->Cell(70);  $pdf->Cell(28  , $Ln , 'I.   Año Escolar: ' , 0 , 0 , 'L');
							 $pdf->Cell(25  , $Ln , ' '. $Dato['Ano'] , 'B' , 0 , 'L');
							 $pdf->Cell(47  , $Ln , ' Mes y Año de la Evaluación:' , 0 , 0 , 'L');
							 $pdf->Cell(30  , $Ln , ' '. $Dato['MesAno'] , 'B' , 1 , 'L');
			
			
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
			
			
			
			
			
			$pdf->SetFont('Arial','',8);
			
			// encabezado tabla superior		
			$pdf->Cell(5  , $Ln*4 , 'No' , $borde , 0 , 'C'); //Linea 1 (201,25 mm)
			$pdf->Cell(17 , $Ln*2 , 'Cédula de'  , 'TLR' , 0 , 'C'); //Linea 1
			$pdf->Cell(30 , $Ln*4 , 'Apellidos'  , 1 , 0 , 'C',1);
			$pdf->Cell(30 , $Ln*4 , 'Nombres'  , 1 , 0 , 'C',1);
			$pdf->Cell(18 , $Ln*4 , 'L de Nac'  , 1 , 0 , 'C',1);
			$pdf->Cell(5  , $Ln*4 , 'EF'  , 1 , 0 , 'C',1);
			$pdf->Cell(5  , $Ln*4 , 'S'  , 1 , 0 , 'C',1);
			$pdf->Cell(17  , $Ln*2 , 'F de Nac'  , 1 , 0 , 'C',1);
			
			
			
			
			
			$pdf->Cell(55 , $Ln*2 , 'Áreas de Formación'  , $borde , 0 , 'C'); //Linea 1
			//$pdf->Cell(31  , $Ln , 'Prog. Aprobados'  , 'TLR' , 0 , 'C'); //Linea 1
			//$pdf->Cell(7  , $Ln*3 , ''  , $borde , 0 , 'C');
			$pdf->Ln($Ln);
			
			
			
			$pdf->Cell(5);
			$pdf->Cell(17 , $Ln*2 , 'Identidad'  , 'LR' , 0 , 'C');
			$pdf->Cell(94);
			
			
			$pdf->Ln($Ln);
			$pdf->Cell(110);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(5 , $Ln*2 , 'Día'  , 1 , 0 , 'C');
			$pdf->Cell(5 , $Ln*2 , 'Mes'  , 1 , 0 , 'C');
			$pdf->Cell(7 , $Ln*2 , 'Año'  , 1 , 0 , 'C');
			$pdf->Cell(55 , $Ln , 'Área Común'  , 1 , 0 , 'C');
			$pdf->SetFont('Arial','',10);
			
			
			
			
			$pdf->Ln($Ln);
			
			$pdf->Ln($Ln);
			
			
			
			
			
			
			
			
			
			$apro=$aplz=$inas=0;
			$pdf->SetFont('Arial','',8);
			
			for ($i = 1 ; $i <= 35 ; $i++){
			//foreach ($Alum as $i){
				
				
				// No.
				$pdf->Cell(5 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
				// Cedula
				$Cedula = strtoupper($row_RS_Alumnos['CedulaLetra']).$row_RS_Alumnos['Cedula'];
				if($Cedula=='')	{
					$relleno = '';
					$TripleAst = ' * * * '; } 
				else {
					$relleno = '*';
					$TripleAst = ''; }
				$pdf->Cell(17 , $Ln , $TripleAst.$Cedula , $borde , 0 , 'C'); // Cedula

			
			
				if($row_RS_Alumnos['Apellidos']=='')
					$Apellidos = ' * * * ';
				else
					$Apellidos = $row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'];
				$pdf->Cell(30 , $Ln , $Apellidos , $borde , 0 , 'L',1); 
				$pdf->Cell(30 , $Ln , $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'] , $borde , 0 , 'L', 1); 
				$pdf->Cell(18 , $Ln , $row_RS_Alumnos['Localidad'] , $borde , 0 , 'L',1); 
				
				if($row_RS_Alumnos['EntidadCorta'] == 'Dc' or $row_RS_Alumnos['EntidadCorta'] == 'Df')
					$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
				else
					$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);

				
				$pdf->Cell(5 , $Ln , $EntidadCorta , $borde , 0 , 'C',1); 
				if($row_RS_Alumnos['EntidadCorta']=='Ex') $Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
				
				$pdf->Cell(5 , $Ln , $row_RS_Alumnos['Sexo'] , $borde , 0 , 'C',1); 
				
				
				$pdf->Cell(5 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C',1); 
				$pdf->Cell(5 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C',1); 
				$pdf->Cell(7 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 0,4) , $borde , 0 , 'C',1); 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			

				for ($NotaX = 1 ; $NotaX <=12 ; $NotaX++) {
					
					if( $row_Notas_Certificadas['Nota'] > "")
						$aux_Nota = $row_Notas_Certificadas['Nota'];
					else 
						$aux_Nota = "*";
					
					
					$pdf->Cell(5 , $Ln ,  $aux_Nota , $borde , 0 , 'C'); 
					
					
					if(($aux_Nota>0 or $aux_Nota>'') and $aux_Nota!='N' and $aux_Nota!='n' and $aux_Nota!='*') 
						$Inscritos[$NotaX]++;
					
					if($aux_Nota >= 10 and $aux_Nota <= 20 )
						$Aprobados[$NotaX]++;
						
					if($aux_Nota>0 and $aux_Nota < 10)
						$Aplazados[$NotaX]++; 	
						
					if($aux_Nota=='I' or $aux_Nota=='i') 
						$Inasistentes[$NotaX]++; 
							
					
					
				}
				$pdf->Cell(20 , $Ln ,  "" , $borde , 0 , 'C'); 
					
				//for ($NotaX = 1 ; $NotaX <=5 ; $NotaX++) 
				//	$pdf->Cell(7.75 , $Ln , "*" , $borde , 0 , 'C');
			
				
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
				
				if($Mat[$i]=='***'){
					$Inasistentes[$i] = $Inscritos[$i] = $Aprobados[$i] = $Aplazados[$i] = '***';}
					
				if($tipo == 'INSCR') 	$pdf->Cell(8.75 , $Ln , $Inscritos[$i] , $borde , 0 , 'C'); 
				if($tipo == 'INAS') 	$pdf->Cell(8.75 , $Ln , $Inasistentes[$i] , $borde , 0 , 'C'); 
				if($tipo == 'APRO') 	$pdf->Cell(8.75 , $Ln , $Aprobados[$i] , $borde , 0 , 'C'); 
				if($tipo == 'APLAZ') 	$pdf->Cell(8.75 , $Ln , $Aplazados[$i] , $borde , 0 , 'C'); 
				
				} 
				
				
				$j=0;
					if($tipo=='INSCR'){
					$pdf->Cell(38.75 , $Ln*2 , 'Tipo de Evaluación' , $borde , 0 , 'C');  }
					if($tipo=='APRO'){
					$pdf->Cell(38.75 , $Ln , $Tipo_Evaluacion , $borde , 0 , 'C');  }
					if($tipo=='APLAZ'){
					$pdf->Cell(38.75 , $Ln , '' , $borde , 0 , 'C');  }
				$pdf->Ln($Ln);
			}
			
			
			
			
			$pdf->Ln($Ln);
				
			// PROFESORES
			$pdf->Cell(7 , $Ln*2 , 'No' , $borde , 0 , 'C'); 
			$pdf->Cell(55 , $Ln*2 , 'Asignatura' , $borde , 0 , 'C'); 
			
			//$pdf->MultiCell(49 , $Ln , 'Apellidos y Nombres del Profesor' , 0 , 'C'); 
			
			$pdf->Cell(49 , $Ln , 'Apellidos y Nombres del' , 0 , 0 , 'C'); 
			
			$pdf->Cell(25 , $Ln*2 , 'C.I.' , $borde , 0 , 'C'); 
			
			$pdf->Cell(25 , $Ln*2 , 'Firma' , $borde , 0 , 'C');
			$coorX = $pdf->GetX();
			$coorY = $pdf->GetY();
			$pdf->Ln($Ln);
			$pdf->Cell(62);
			$pdf->Cell(49 , $Ln , 'Profesor' , 0 , 0 , 'C'); 
			$pdf->Ln($Ln);
			
			for  ($i = 1; $i <= 12;$i++){
				$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
				
				if (strlen($Materia[$i]) > 33 )
					$pdf->SetFont('Arial','',8);
				else
					$pdf->SetFont('Arial','',10);
			
				
				$pdf->Cell(55 , $Ln , $Materia[$i] , $borde , 0 , 'L'); 
				$pdf->SetFont('Arial','',10);
			
				
				
				$pdf->Cell(49 , $Ln , $Profesor_nom[$i] , $borde , 0 , 'L'); 
				$pdf->Cell(25 , $Ln , $Profesor_ci[$i] , $borde , 0 , 'R'); 
				if($Inscritos[$i]==0)$Profesor_firma[$i]=' * * * ';
				$pdf->Cell(25 , $Ln , $Profesor_firma[$i] , $borde , 0 , 'C');
				$pdf->Ln($Ln);
			}
			
			
			$pdf->SetXY($coorX,$coorY);
			$pdf->Cell(40.25 , $Ln*2 , 'Identificación del' , 'TLR' , 1 , 'C');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'Curso' , 'BLR' , 1 , 'C');
			$pdf->SetFont('Arial','',9);
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'MENCIÓN:' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $row_mat['Mencion'].'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , '' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'GRADO o AÑO:' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $row_mat['Curso'].'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'SECCIÓN:' , $borde , 1 , 'L');
			if($Tipo_Evaluacion == 'Materia Pendiente' or $Tipo_Evaluacion == 'Equivalencia') $seccion='*'; else $seccion = $row_mat['Seccion'];
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $seccion.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA PÁGINA' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Pag.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA SECCIÓN' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Seccion.'  ' , $borde , 1 , 'R');
			
			
			$pdf->Ln();
			
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