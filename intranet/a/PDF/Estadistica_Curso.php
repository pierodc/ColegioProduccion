<?php 
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_GET['AnoEscolar']))
	$AnoEscolar = $_GET['AnoEscolar'];

$sql = "SELECT * FROM Curso 
		WHERE SW_activo = '1'
		ORDER BY NivelCurso, Seccion";
$RS = $mysqli->query($sql);

//$RS->data_seek(0);

$TituloPag = "TituloPag";

$borde=1;
$Ln = 4.25;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255);
$pdf->SetDrawColor(0);
$pdf->SetTextColor(0);
$pdf->AddPage();
//$pdf->SetMargins(5,5,5);
$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 22 );
$pdf->SetFont('Arial','',10);
$pdf->Cell(50 , $Ln , $TituloPag , 0 , 1 , 'L'); 
$pdf->SetY( 30 );

$NivelMencionAnte = $row_Curso['NivelMencion'];

while ($row_Curso = $RS->fetch_assoc()) { // Para cada Curso
	$n_en_pag++;
	$NivelCurso = $row_Curso['NivelCurso'];
	$NombreNivel = $row_Curso['NombreCompleto'];
	
	//Cierre de Total_Nivel -> NivelMencion
	if(($n_en_pag == 10  
		or ($NivelMencionAnte != $row_Curso['NivelMencion']) and $NivelMencionAnte > '')
		or ($row_Curso['Curso'] == 4 and $row_Curso['Seccion'] == "A")){
		$n_en_pag=1;
		$pdf->Ln($Ln*2);
		if($NivelMencionAnte != $row_Curso['NivelMencion'] and $NivelMencionAnte > '')
			$pdf->Cell(60 , $Ln, "Total_Nivel: ".$Total_Nivel[$NivelMencionAnte] , 1 , 1 , 'L'); 
		//$pdf->Cell(60 , $Ln, "Sumatoria Global: ".$Total_Global_Alumnos , 1 , 0 , 'L'); 
		$pdf->AddPage();}
	
	
	// Separador doble linea "Nivel Curso"
	if($NivelCursoAnte != $row_Curso['NivelCurso'])	{
		$coodY2 = $pdf->GetY();
		$pdf->SetLineWidth(.7);
		//$pdf->Line(10,$coodY2,200,$coodY2);
		$pdf->Line(10,$coodY2+2,200,$coodY2+2);
		$pdf->SetLineWidth(.2);
		//		$pdf->Cell(190 , 1 , '' , 1 , 1 , 'C',1);
		$pdf->SetY($coodY2+2);
		}
	
	
	$NivelMencionAnte = $row_Curso['NivelMencion'];
	
	
	
	$pdf->SetFillColor(200);
		//$pdf->SetFillColor(255);
	
	$CodigoCurso = $row_Curso['CodigoCurso'];
	$NombreCurso = substr($row_Curso['NombreCompleto'],0,strlen($row_Curso['NombreCompleto'])-1);
	$Seccion = substr($row_Curso['NombreCompleto'], -1);

	$sql_Aula = "SELECT * FROM Aula 
					WHERE CodigoCurso = '".$row_Curso['CodigoCursoProxAno']."'";
	$RS_Aula = $mysqli->query($sql_Aula);
	$row_Aula = $RS_Aula->fetch_assoc();
	
	$Capacidad_Max = $row_Aula['Capacidad'];
	
	
	
	// Busca Los inscritos Actuales
	$sql = "SELECT * FROM AlumnoXCurso, Alumno
			  WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
			  AND AlumnoXCurso.CodigoCurso = '$CodigoCurso' 
			  AND AlumnoXCurso.Ano = '$AnoEscolar' 
			  AND AlumnoXCurso.Status = 'Inscrito'
			  AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'
			  ORDER BY Alumno.FechaNac";
	//echo $sql."<br>";		  
	$RS_Alumnos = $mysqli->query($sql);
	
	unset($total_M);
	unset($total_F);
	
	if($RS_Alumnos){
		$pdf->SetFont('Arial','B',12);
		$coodY2 = $pdf->GetY();
		$pdf->Line(10,$coodY2,200,$coodY2);
		
		$pdf->Cell(30 , $Ln*1.5 , $NombreCurso , 0 , 0 , 'L'); 
		$pdf->Cell(15 , $Ln*1.5 , $Seccion , 0 , 1 , 'C'); 
		
		$pdf->SetFont('Arial','',10);
		while ($row_Alumnos = $RS_Alumnos->fetch_assoc()){ // "pasea todo el colegio orden fecha nac"
			extract($row_Alumnos);
			
			// Busca Reinscrito X Alumno		
			$sql_Reins = "SELECT * FROM AlumnoXCurso , Curso
							WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
							AND AlumnoXCurso.CodigoAlumno = '$CodigoAlumno'
							AND AlumnoXCurso.Ano = '$AnoEscolarProx' 
							AND AlumnoXCurso.Status = 'Inscrito'
							AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'";
			//echo $sql_Reins.'<BR>';
			$RS_Alumnos_Reins = $mysqli->query($sql_Reins);
			$SW_Reins = $RS_Alumnos_Reins->num_rows;
			
			
			if ($SW_Reins)
				$total_Curso_Reins[$CodigoCurso]++;		
			
			$total_Curso[$CodigoCurso]++;
			
			if($row_Alumnos['CedulaLetra'] == "V" or $row_Alumnos['CedulaLetra'] == "v"){
				$Total_Cedula_V[$NivelCurso]++;}
			elseif($row_Alumnos['CedulaLetra'] == "E"){
				$Total_Cedula_E[$NivelCurso]++;}
			elseif($row_Alumnos['CedulaLetra'] == "C"){
				$Total_Cedula_E[$NivelCurso]++;}
			elseif($row_Alumnos['CedulaLetra'] == "P"){
				$Total_Cedula_E[$NivelCurso]++;}
			
			
			if($Sexo == 'M'){
				$total_M[0]++;
				$total_M[Edad($row_Alumnos['FechaNac'])]++;
				$Total_Global_Alumnos_Edad_M[Edad($row_Alumnos['FechaNac'])]++;
				$Total_Global_M++; 
				$Total_Sexo_M[$NivelCurso]++;}
			if($Sexo == 'F'){
				$total_F[0]++;
				$total_F[Edad($row_Alumnos['FechaNac'])]++;
				$Total_Global_Alumnos_Edad_F[Edad($row_Alumnos['FechaNac'])]++;
				$Total_Global_F++;
				$Total_Sexo_F[$NivelCurso]++; }
			
			$CursoNivelNombre[$NivelCurso] = Curso($CodigoCurso);;
			
			
			$Total_Global_Alumnos_Edad[Edad($row_Alumnos['FechaNac'])]++;
			
			if(Edad($row_Alumnos['FechaNac']) > 30)
				echo 'Error F. Nac' . $row_Alumnos['CodigoAlumno'];	
			$Total_Nivel[$row_Curso['NivelMencion']]++;	
			$Total_Global_Alumnos++;
		}
}



	// Busca Total Inscritos Prox Año	
	$sql_Prox = "SELECT * FROM AlumnoXCurso 
				  WHERE CodigoCurso = '$CodigoCurso' 
				  AND Ano = '$AnoEscolarProx' 
				  AND Status = 'Inscrito'
				  AND Tipo_Inscripcion <> 'Mp'";
	$RS_Alumnos_Prox = $mysqli->query($sql_Prox);
	$total_Curso_Prox[$CodigoCurso] = $RS_Alumnos_Prox->num_rows;
		
	while($row_Alumnos_Prox = $RS_Alumnos_Prox->fetch_assoc()){ 
		$sql_Ante = "SELECT * FROM AlumnoXCurso 
					  WHERE CodigoAlumno = '".$row_Alumnos_Prox['CodigoAlumno']."' 
					  AND Ano = '$AnoEscolar' 
					  AND Status = 'Inscrito'
					  AND Tipo_Inscripcion <> 'Mp'";
		$RS_Alumnos_Ante = $mysqli->query($sql_Ante);
		if($RS_Alumnos_Ante->num_rows > 0){
			$total_Alumnos_Ante[$CodigoCurso]++;
			}
		}
	// FIN Busca Total Inscritos Prox Año	


	// Busca Total SeRetira Prox Año	
	$sql_Prox = "SELECT * FROM AlumnoXCurso 
				  WHERE CodigoCurso = '$CodigoCurso' 
				  AND Ano = '$AnoEscolar' 
				  AND SeRetira = '1'
				  AND Tipo_Inscripcion <> 'Mp'";
	$RS_Alumnos_Prox = $mysqli->query($sql_Prox);
	$total_SeRetira[$CodigoCurso] = $RS_Alumnos_Prox->num_rows;




	$coodX = $pdf->GetX();
	$coodY = $pdf->GetY();
	$pdf->SetDrawColor(255);
	
	// TOTAL Salon
	$pdf->SetX(85);
	$pdf->SetFillColor(150,220,150);
	$pdf->Cell(8 , $Ln*2 , '' , 0 , 0 , 'R',0);
	$pdf->Cell(.1+$total_Curso[$CodigoCurso]*3 , $Ln*2 , '' , 1 , 0 , 'R' , 1);
	$pdf->Cell(8 , $Ln*2 , $total_Curso[$CodigoCurso] , 0 , 0 , 'C',0);

	// TOTAL Varones
	$pdf->SetDrawColor(0);
	$pdf->SetX(79);
	$pdf->Cell(8 , $Ln*2 , $AnoEscolar , 'R' , 0 , 'R' , 0);
	$pdf->SetDrawColor(255);
	$pdf->SetX(85);
	$pdf->SetFillColor(85,85,255);
	$pdf->Cell(8 , $Ln , 'M ' , 0 , 0 , 'R',0);
	$pdf->Cell(.1+$total_M[0]*3 , $Ln , '' , 1 , 0 , 'C',1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(6 , $Ln , $total_M[0] , 0 , 0 , 'C',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Ln($Ln);

	// TOTAL Hembras
	$pdf->SetX(85);
	$pdf->SetFillColor(255,85,85);
	$pdf->Cell(8 , $Ln , 'F ' , 0 , 0 , 'R',0);
	$pdf->Cell(.1+$total_F[0]*3 , $Ln , '' , 1 , 0 , 'C',1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(6 , $Ln , $total_F[0] , 0 , 0 , 'C',0);
	$pdf->SetFont('Arial','',10);
	if($total_Curso_Reins[$CodigoCurso] > 0 and false){
		$pdf->Ln($Ln);
		$pdf->SetX(85+8);
		$Nota = ' Reins: '.$total_Curso_Reins[$CodigoCurso]. ' Faltan: '.($total_Curso[$CodigoCurso]-$total_Curso_Reins[$CodigoCurso]);
		$pdf->Cell($total_Curso[$CodigoCurso]*3 , $Ln , $Nota .'', 1 , 0 , 'R' , 0);
		}
	$pdf->Ln($Ln);

	if($AnoEscolar <> $AnoEscolarProx){
		// Separa Graf Años
		$coodY2 = $pdf->GetY() +1 ;
		$pdf->SetDrawColor(0);
		$pdf->SetLineWidth(.3);
		$pdf->Line(65,$coodY2,190,$coodY2);
		$pdf->SetLineWidth(.2);
		
		// Capacidad Salon
		$pdf->SetY($coodY2+1);
		$pdf->SetX(85+8);
		$pdf->SetFillColor(255);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(.1+$Capacidad_Max*3 , $Ln , $Capacidad_Max-$total_Curso_Prox[$CodigoCurso] , 1 , 0 , 'R' , 0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(8 , $Ln , $Capacidad_Max , 0 , 0 , 'C' , 0);
		$pdf->SetDrawColor(255);
		
		$pdf->SetX(79);
		$pdf->SetFillColor(220,150,0);
		$pdf->SetDrawColor(0);
		$pdf->Cell(8 , $Ln , $AnoEscolarProx , 'R' , 0 , 'R' , 0);
		$pdf->SetX(85+8);
		$pdf->SetDrawColor(255);
		$pdf->SetFont('Arial','B',8);
		if($total_Curso_Prox[$CodigoCurso]>0)
			$pdf->Cell(.1+$total_Curso_Prox[$CodigoCurso]*3 , $Ln , ($total_Curso_Prox[$CodigoCurso]-$total_Alumnos_Ante[$CodigoCurso]) , 1 , 0 , 'R' , 1);
		$pdf->SetFont('Arial','',10);

		
		$pdf->SetX(85);
		$pdf->SetFillColor(220,220,0);
		$pdf->SetFillColor(150,220,150);
		$pdf->Cell(8 , $Ln , '' , 0 , 0 , 'C',0);
		$pdf->SetFont('Arial','B',8);
		if($total_Alumnos_Ante[$CodigoCurso]>0)
			$pdf->Cell((.1+$total_Alumnos_Ante[$CodigoCurso])*3 , $Ln , ($total_Alumnos_Ante[$CodigoCurso]) , 1 , 0 , 'R' , 1);
		$pdf->SetFont('Arial','',10);

	
		$total_Nuevos_Colegio += $total_Curso_Prox[$CodigoCurso]-$total_Alumnos_Ante[$CodigoCurso];
		$total_Reinscritos_Colegio += $total_Curso_Reins[$CodigoCurso];
		$total[$row_Curso['NivelCurso']]['AlumnosNuevos'] += $total_Curso_Prox[$CodigoCurso] - $total_Alumnos_Ante[$CodigoCurso];
		$total[$row_Curso['NivelCurso']]['AlumnosReinscritos'] += $total_Alumnos_Ante[$CodigoCurso];
		$total[$row_Curso['NivelCurso']]['NombreNivel'] = $NombreNivel;
		$total[$row_Curso['NivelCurso']]['AlumnosActuales'] += $total_Curso[$CodigoCurso];
		$total[$row_Curso['NivelCurso']]['Capacidad'] += $Capacidad_Max;
		$total[$row_Curso['NivelCurso']]['SeRetira'] += $total_SeRetira[$CodigoCurso];
		
		$total[$row_Curso['NivelCurso']]['Planilla_Imp'] += $total_Curso_Planilla_Imp[$CodigoCurso];
		

		$pdf->Ln($Ln);}


	$pdf->SetDrawColor(0);
	$pdf->SetXY($coodX,$coodY);
	$pdf->Cell(10 , $Ln , 'Edad' , 'BR' , 0 , 'C');
	$pdf->Cell(10 , $Ln , 'M' , 'BLR' , 0 , 'C');
	$pdf->Cell(10 , $Ln , 'F' , 'BLR' , 1 , 'C');
	for($i=1;$i<20;$i++){
	 	if ($total_M[$i]>0 or $total_F[$i]>0){
			$pdf->Cell(10 , $Ln , $i , 'TBR' , 0 , 'C');
			$pdf->Cell(10 , $Ln , $total_M[$i] , 1 , 0 , 'C');
			$pdf->Cell(10 , $Ln , $total_F[$i] , 1 , 1 , 'C');
		} 
	}
	$pdf->Cell(10 , $Ln , 'Total' , 'TBR' , 0 , 'C');
	$pdf->Cell(10 , $Ln , $total_M[0] , 1 , 0 , 'C');
	$pdf->Cell(10 , $Ln , $total_F[0] , 1 , 0 , 'C');
	$pdf->Cell(15 , $Ln , $total_Curso[$CodigoCurso] , 1 , 0 , 'C');
	$pdf->Ln($Ln);
	
	
	$NivelCursoAnte = $row_Curso['NivelCurso'];
	
	
} 





$pdf->AddPage();



$pdf->Ln($Ln*2);
$pdf->Cell(60 , $Ln, "Total_Nivel: " , 1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln, " ".$Total_Nivel[$NivelMencionAnte] , 1 , 1 , 'C'); 

$pdf->Ln(); 
$pdf->Cell(15 , $Ln, "Edad" , 'BR' , 0 , 'C'); 
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, "M" , 'BLR' , 0 , 'C'); 
$pdf->Cell(15 , $Ln, "F" , 'BLR' , 0 , 'C'); 
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, "Tot" , 'BLR' , 1 , 'C'); 
$pdf->Ln(.5); 
foreach ($Total_Global_Alumnos_Edad as $clave => $valor){
	$pdf->Cell(15 , $Ln, "$clave " , 'TBR' , 0 , 'C'); 
	$pdf->Cell(.5); 
	$pdf->Cell(15 , $Ln, " ".$Total_Global_Alumnos_Edad_M[$clave] , 1 , 0 , 'C'); 
	$pdf->Cell(15 , $Ln, " ".$Total_Global_Alumnos_Edad_F[$clave] , 1 , 0 , 'C'); 
	$pdf->Cell(.5); 
	$pdf->Cell(15 , $Ln, " ".$Total_Global_Alumnos_Edad[$clave] , 1 , 1 , 'C'); 
}
$pdf->Ln(.5); 
$pdf->Cell(15 , $Ln, "Total " , 'TBR' , 0 , 'C'); 
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, " ".$Total_Global_M , 1 , 0 , 'C'); 
$pdf->Cell(15 , $Ln, " ".$Total_Global_F , 1 , 0 , 'C'); 
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, " ".$Total_Global_Alumnos , 1 , 1 , 'C'); 



$pdf->Ln(); 
$pdf->Cell(20 , $Ln, "Nivel" , 'BR' , 0 , 'C'); 
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, "M" , 'BLR' , 0 , 'C'); 
$pdf->Cell(15 , $Ln, "F" , 'BLR' , 0 , 'C');  
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, "V" , 'BLR' , 0 , 'C'); 
$pdf->Cell(15 , $Ln, "E" , 'BLR' , 0 , 'C');  
$pdf->Cell(.5);
$pdf->Cell(15 , $Ln, "?" , 'BLR' , 0 , 'C'); 
$pdf->Ln(); 
$pdf->Ln(.5); 
foreach ($Total_Sexo_M as $clave => $valor){
	$pdf->Cell(20 , $Ln, substr($CursoNivelNombre[$clave],0,strlen($CursoNivelNombre[$clave])-1) , 'TBR' , 0 , 'L'); 
	$pdf->Cell(.5); 
	$pdf->Cell(15 , $Ln, " ".$Total_Sexo_M[$clave] , 1 , 0 , 'C'); 
	$pdf->Cell(15 , $Ln, " ".$Total_Sexo_F[$clave] , 1 , 0 , 'C'); 
	$pdf->Cell(.5); 
	$pdf->Cell(15 , $Ln, " ".$Total_Cedula_V[$clave] , 1 , 0 , 'C'); 
	$pdf->Cell(15 , $Ln, " ".$Total_Cedula_E[$clave] , 1 , 0 , 'C'); 
	$ux_1 = $Total_Sexo_M[$clave] + $Total_Sexo_F[$clave];
	$ux_2 = $Total_Cedula_V[$clave] + $Total_Cedula_E[$clave];

	if($ux_1 != $ux_2){
		$au_ = abs($ux_1 - $ux_2);
		$pdf->Cell(.5); 
		$pdf->Cell(15 , $Ln, " ! ".$au_ , 1 , 0 , 'C'); 
	}
	
	$pdf->Ln();
}






if($AnoEscolar != $AnoEscolarProx){
$pdf->AddPage();
$Ln = 5;


$sql = "SELECT * FROM Curso 
		WHERE SW_activo = '1'
		GROUP BY NivelCurso 
		ORDER BY NivelCurso";
$RS = $mysqli->query($sql);


$pdf->Cell(30 , $Ln , 'Curso ' , 1 , 0 , 'L');
	$pdf->Cell(1);
$pdf->Cell(12 , $Ln , 'Cap ' , 1 , 0 , 'C');
$pdf->Cell(12 , $Ln , 'Reinsc' , 1 , 0 , 'C');

$pdf->Cell(1);

$pdf->Cell(60/3 , $Ln , 'PorInscribir' , 'TBL' , 0 , 'C');
$pdf->Cell(60/3 , $Ln , '- SeRetira' , 'TB' , 0 , 'C');
$pdf->Cell(60/3 , $Ln , '+ Nuevos' , 'TBR' , 0 , 'C');

$pdf->Cell(1);
$pdf->Cell(12 , $Ln , 'Disp' , 1 , 0 , 'C');

$pdf->Cell(1);

//$pdf->Cell(20 , $Ln , 'Faltan' , 1 , 0 , 'C');


$pdf->Ln($Ln);

$NivelCursoAnte = '0';
while ($row_Curso = $RS->fetch_assoc()) { // Para cada Curso
	extract($row_Curso);
	//$pdf->Cell(50 , $Ln , 'Alumnos Reinscritos ' , 1 , 0 , 'L');
	$Largo = strlen($total[$row_Curso['NivelCurso']]['NombreNivel'] ) - 2;
	$pdf->Cell(30 , $Ln ,  substr($total[$row_Curso['NivelCurso']]['NombreNivel'] , 0, $Largo ) .' ' , 1 , 0 , 'R');
	$pdf->Cell(1);
	$pdf->Cell(12 , $Ln ,  $total[$row_Curso['NivelCurso']]['Capacidad']  , 1 , 0 , 'C');
	$pdf->Cell(12 , $Ln ,  $total[$row_Curso['NivelCurso']]['AlumnosReinscritos']  , 1 , 0 , 'C'); // Reinscritos

	$pdf->Cell(1);
	
	$FaltanPorInscribir = $total[$NivelCursoAnte]['AlumnosActuales'] - $total[$row_Curso['NivelCurso']]['AlumnosReinscritos'];
	
	$pdf->Cell(60/3 , $Ln ,  $FaltanPorInscribir  ,  'LTB' , 0 , 'C'); // Vienen
	$pdf->Cell(60/3 , $Ln ,  "- ".$total[$NivelCursoAnte]['SeRetira']  ,  'TB' , 0 , 'C'); // Vienen
	$pdf->Cell(60/3 , $Ln ,  "+ ".$total[$row_Curso['NivelCurso']]['AlumnosNuevos']  ,  'RTB' , 0 , 'C');


	$Disponible = $total[$row_Curso['NivelCurso']]['Capacidad'] - $total[$row_Curso['NivelCurso']]['AlumnosNuevos'] - $total[$NivelCursoAnte]['AlumnosActuales'] + $total[$row_Curso['NivelCurso']]['SeRetira'];
	
	$pdf->Cell(1);
	$pdf->Cell(12 , $Ln ,  $Disponible.'  '  , 1 , 0 , 'R');



	// Cuenta Aceptados Prox Ano
	$sql_Aceptados = "SELECT * FROM AlumnoXCurso  , Curso
						  WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
						  AND AlumnoXCurso.Ano = '$AnoEscolarProx' 
						  AND AlumnoXCurso.Status = 'Aceptado'
						  AND Curso.NivelCurso = '".$row_Curso['NivelCurso']."'
						  AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp'";
	$RS_Alumnos_Aceptados = $mysqli->query($sql_Aceptados);
	$Num_Aceptados = $RS_Alumnos_Aceptados->num_rows;


	
	$pdf->Cell(1);
	$pdf->Cell(12 , $Ln ,  $Num_Aceptados.'  '  , 1 , 0 , 'R');
	
	
	
	$pdf->Cell(1);
	
	//$pdf->Cell(20 , $Ln ,  $total[$NivelCursoAnte]['AlumnosActuales'] - $total[$NivelCursoAnte]['SeRetira'] - $total[$row_Curso['NivelCurso']]['AlumnosReinscritos']  , 1 , 0 , 'C');
	
//	$pdf->Cell(20 , $Ln ,  $total[$row_Curso['NivelCurso']]['AlumnosReinscritos']  , 1 , 0 , 'C');
	$pdf->Ln($Ln);
	$NivelCursoAnte = $row_Curso['NivelCurso'];
}
	$pdf->Ln(1);
$pdf->Cell(43 , $Ln , 'Sub Totales' , 1 , 0 , 'L');
$pdf->Cell(12 , $Ln ,  $total_Reinscritos_Colegio  , 1 , 0 , 'C');
$pdf->Cell(1+60*2/3);
$pdf->Cell(60/3 , $Ln ,  $total_Nuevos_Colegio  , 1 , 0 , 'C');
$pdf->Ln($Ln);
$pdf->Ln($Ln);
$pdf->Cell(43 , $Ln , 'Total General Colegio ' , 1 , 0 , 'L');
$TotalFGeneralColegio = $total_Reinscritos_Colegio + $total_Nuevos_Colegio;
$pdf->Cell(36 , $Ln ,  $total_Reinscritos_Colegio.'  +  '. $total_Nuevos_Colegio.'  =  '.$TotalFGeneralColegio , '1' , 0 , 'C');
$pdf->Ln($Ln*2);


}

$pdf->Output();


?>	
