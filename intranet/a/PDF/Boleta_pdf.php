<?php 
require_once('../../../Connections/bd.php');  
require_once('../archivo/Variables.php');  
require_once('../../../inc/rutinas.php');  
require_once('../../../inc/notas.php');  
require_once('../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);
// $query_RS_Alumno = $query_RS_Alumno.' LIMIT 18,18'; // LIMIT   desde,cantidad
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);

$CodigoCurso = "-1";
if (isset($row_RS_Alumno['CodigoCurso'])) {
  $CodigoCurso = $row_RS_Alumno['CodigoCurso'];
}

$query_RS_Curso = "SELECT * FROM Curso WHERE CodigoCurso = ".$CodigoCurso; 
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);

/*
function Inas($Inas){
	$Inas=$Inas*1;
	if($Inas==0)$Inas='';
	return $Inas;}
*/

$linea = 4.5;
$tipologia = 'Arial';
$pdf=new FPDF('P', 'mm', 'Letter');
$SW_NewPage = true;

do {
	$pdf->AddPage();
	$pdf->SetMargins(11,5,20);
	$pdf->Image('../../../img/solcolegio.jpg',10,10,0,20);
	
	$NumMp=0;
	$fotoNew = '../../../'.$AnoEscolar.'/150/'.$row_RS_Alumno['CodigoAlumno'].'.jpg';
	$fotoOld = '../../../'.$AnoEscolarAnte.'/'.$row_RS_Alumno['CodigoAlumno'].'.jpg';
	if(file_exists($fotoNew)){
		$foto = $fotoNew;}
	else{
		$foto = $fotoOld;}

	$pdf->Image('../../../img/NombreCol_az.jpg' , 35, 8, 0, 12);

	$pdf->Ln();
	$pdf->SetFont('Times','B',14);
	$pdf->Cell(163,$linea,' BOLETA de CALIFICACIONES',0,1,'R'); 
	$pdf->Cell(163,$linea, 'Año Escolar: '.$AnoEscolar ,0,1,'R'); 
	

	$pdf->Ln($linea-1);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(27,$linea,'',0,0,'C'); 	
	$Nombre = 'Alumno: '.
				$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].' '.
				$row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].
				'  ('. $row_RS_Alumno['CodigoAlumno'].')';
	$pdf->Cell(135,$linea+1.5, $Nombre  ,1,1,'L'); 
	
	$pdf->Cell(27,$linea,'',0,0,'C'); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(135,$linea, 'Curso: '. $row_RS_Curso['NombreCompleto'] ,'LRB',1,'L'); 
	
	$pdf->Ln(1.5);
	
	// LLENA MATRIZ notas Trimestres
	foreach (array(1, 2, 3) as $_Lapso) { // cada LAPSO
		foreach (array('-70','-30','-Def','-BConduc','i','mp') as $_Eval) { // Cada Evaluacion
			
			$query_Nota = "SELECT * FROM Nota 
							WHERE CodigoAlumno = ". $row_RS_Alumno['CodigoAlumno']." 
							AND Lapso= '$_Lapso"."$_Eval' 
							AND Ano_Escolar='$AnoEscolar'";
							
			$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
			$_row_Nota = mysql_fetch_assoc($_Nota);
			$_totalRows = mysql_num_rows($_Nota);
			
			if($_totalRows == 0 and $_Eval=='-30'){
				//echo $query_Nota.'<br>';
				$query_Nota = "SELECT * FROM Nota 
								WHERE CodigoAlumno = ". $row_RS_Alumno['CodigoAlumno']." 
								AND Lapso= '$_Lapso"."-70' 
								AND Ano_Escolar='$AnoEscolar'";
				$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
				$_row_Nota = mysql_fetch_assoc($_Nota);
				$_totalRows = mysql_num_rows($_Nota);
				}
			

			if($_totalRows > 0)
			foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Cada Materia
				$Matriz[$_Lapso][$_Eval][$fila_x] = Nota($_row_Nota['n'.$fila_x]);
				
				if($_row_Nota['n'.$fila_x] > '' and $_row_Nota['n'.$fila_x] <> '*' and $_Eval == 'mp'){
					$Matriz[$_Lapso][mp] = $_row_Nota['n'.$fila_x];
					$Matriz[$_Lapso][mp]['n'.$fila_x] = $_row_Nota['n'.$fila_x];
					}
					
				if( $_row_Nota['n'.$fila_x] > 0 and $_Eval == '-Def' ) { 
					$Matriz[$_Lapso][promedio][suma] += $_row_Nota['n'.$fila_x]; 
					$Matriz[$_Lapso][promedio][cuenta]++;
//					$Matriz[definitiva][cuenta][$fila_x]++;
//					$Matriz[definitiva][suma][$fila_x] = $_row_Nota['n'.$fila_x];
					}
				if($_Eval=='-Def') 
					$Matriz[$_Lapso][Pos][$fila_x] = Posicion ($database_bd, $bd, 'n'.$fila_x, $_row_Nota['n'.$fila_x], $CodigoCurso, $_Lapso."-Def", $AnoEscolar);
				if($_Eval=='i'){ 
					$Matriz[definitiva][i][$fila_x]+=$_row_Nota['n'.$fila_x]; }
			}
		}
	}
	
	
				// Llema Matriz de las definitivas del año
				$query_Nota = "SELECT * FROM Nota 
								WHERE CodigoAlumno = '". $row_RS_Alumno['CodigoAlumno']."' 
								AND Lapso= 'Def' 
								AND Ano_Escolar='$AnoEscolar'";
				$_Nota = mysql_query($query_Nota, $bd) or die(mysql_error());
				$_row_Nota = mysql_fetch_assoc($_Nota);
				$_totalRows = mysql_num_rows($_Nota);
				
				if($_totalRows == 1 or date('m') == '06' or date('m') == '07' or date('m') == '08')
				foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Cada Materia
					$Matriz[definitiva][$fila_x] = $_row_Nota['n'.$fila_x];
					if( $_row_Nota['n'.$fila_x] > 0 ){
						$Matriz[definitiva][promedio][suma] += $_row_Nota['n'.$fila_x]; 
						$Matriz[definitiva][promedio][cuenta]++;}
						$Matriz[definitiva][Pos][$fila_x] = Posicion ($database_bd, $bd, 'n'.$fila_x, $_row_Nota['n'.$fila_x], $CodigoCurso, "Def", $AnoEscolar);


				}
	
	
	
	// llena matriz con materias
	$query_RS_Curso = "SELECT * FROM Curso, CursoMaterias 
						WHERE Curso.CodigoMaterias = CursoMaterias.CodigoMaterias 
						AND Curso.CodigoCurso = ".$row_RS_Alumno['CodigoCurso'];
	$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
	$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
	foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) {
		$Matriz[materia][$fila_x] = $row_RS_Curso['Materia'.$fila_x];
	}
	
	
	
	// Imprime encabezados columnas
	$pdf->Cell(50);
	foreach (array('1er ', '2do ', '3er ') as $nom) { // Titulo Trimestre
		$pdf->Cell(40,$linea, $nom.'Lapso' ,1,0,'C'); 		
	}
	$pdf->Cell(24,$linea, 'Final' ,1,0,'C'); 		
	$pdf->Ln();
	
	$pdf->Cell(50,$linea, 'Asignaturas' ,0,0,'C');
	
	$pdf->SetFont($tipologia,'',9);
	foreach (array('1er ', '2do ', '3er ') as $nom) { // Titulo Evaluaciones de cada Trim
		foreach (array('70%','30%','Def','Pos','I') as $eva) {
			$pdf->Cell(8,$linea, $eva ,1,0,'C'); 		
	}	} 
	
	foreach (array('Def','Pos','I') as $eva) {       // Titulo Evaluaciones FINAL
			$pdf->Cell(8,$linea, $eva ,1,0,'C'); 		
	}$pdf->Ln();
	
	foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Nota Evaluaciones
		$pdf->SetFont($tipologia, 'B' , 10);
		$pdf->Cell(50,$linea, $Matriz[materia][$fila_x] ,1,0,'L'); // Materia
		foreach (array(1, 2, 3) as $_Lapso) {
			foreach (array('-70','-30','-Def','Pos','i') as $_Eval) {
				$BConduc='';
				if($_Eval=="-Def") {
					$b='B';
					if($Matriz[$_Lapso]['-BConduc'][$fila_x]==1) $BConduc = '•';
					if($Matriz[$_Lapso]['-BConduc'][$fila_x]> 1) $BConduc = ':';
				
					} 
				else $b=''; 
				$pdf->SetFont($tipologia, $b , 11); // Definitiva en Bold
				
				$nota_aux = $Matriz[$_Lapso][$_Eval][$fila_x];
	
				if(($nota_aux=='i' or $nota_aux=='I') or $nota_aux>0 and $nota_aux<10 and $_Eval!='Pos' and $_Eval!='i')
					$pdf->SetTextColor(255,0,0);
				if($nota_aux=='*')
					$pdf->SetTextColor(150);
				if($_Eval == 'i' and $nota_aux > 0) $nota_aux = $nota_aux * 1;
				
				$pdf->Cell(8,$linea, $BConduc.$nota_aux ,1,0,'C'); 	
			
				$pdf->SetTextColor(0);
					
			}
		} 
	
	
		if($Matriz[definitiva][$fila_x]>0)
			$Definitiva = $Matriz[definitiva][$fila_x];
		else 
			$Definitiva = '';
		if($Definitiva>0 and $Definitiva<10) 
			$pdf->SetTextColor(255,0,0);
			$pdf->SetFont($tipologia, 'B' , 12);
		if($Definitiva=='')
			$pdf->SetTextColor(150);
		
		// Definitiva
		$pdf->Cell(8,$linea, Nota($Definitiva) ,1,0,'C'); 
		
		// Posicion final
		$pdf->SetTextColor(0);
		$pdf->SetFont($tipologia, '' , 10);
		$pdf->Cell(8,$linea, $Matriz[definitiva][Pos][$fila_x] ,1,0,'C');	
		
		
		// Inasistencias final
		$pdf->Cell(8,$linea, $Matriz[definitiva][i][$fila_x] ,1,0,'C'); 
		$pdf->Ln();
	}
	
	
	
	$pdf->Cell(50,$linea, 'Promedio' ,1,0,'C');
	foreach (array('1', '2', '3') as $_Lapso) { // Promedios Lapsos
			if($Matriz[$_Lapso][promedio][cuenta]>0){
				$aux = $Matriz[$_Lapso][promedio][suma].' / ';
				$aux .= $Matriz[$_Lapso][promedio][cuenta].' = ';
				$aux .= round($Matriz[$_Lapso][promedio][suma]/$Matriz[$_Lapso][promedio][cuenta],2);}
				else {$aux='';}
			$pdf->Cell(40,$linea, $aux ,1,0,'C'); 		
	}
	
				if($Matriz[definitiva][promedio][cuenta] > 0){ // Promedio final
					$aux = $Matriz[definitiva][promedio][suma].'/';
					$aux .= $Matriz[definitiva][promedio][cuenta].'= ';
					$aux .= round($Matriz[definitiva][promedio][suma] / $Matriz[definitiva][promedio][cuenta],2);}
				else {$aux='';}
			$pdf->Cell(24,$linea, $aux ,1,0,'C'); 		

	
		
	//$pdf->Cell(24,$linea, '' ,1,0,'C'); 		
	$pdf->Ln();
	
	// Materia Pendiente
	$sqlMatPend = "SELECT * FROM AlumnoXCurso
					WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'
					AND Ano = '$AnoEscolar'
					AND Tipo_Inscripcion = 'Mp'";	
	$RS_MatPend = mysql_query($sqlMatPend, $bd) or die(mysql_error());
	$row_RS_MatPend = mysql_fetch_assoc($RS_MatPend);
				
	if($row_RS_MatPend){ 
		$posX = $pdf->GetX();
		$posY = $pdf->GetY();
		$pdf->Cell(25,$linea, 'Mat.Pendiente' ,1,0,'L'); 
		$pdf->Cell(8.3,$linea, 'M1' ,1,0,'C'); 	
		$pdf->Cell(8.3,$linea, 'M2' ,1,0,'C'); 	
		$pdf->Cell(8.4,$linea, 'M3' ,1,1,'C'); 	
		$Materias_Cursa = explode(';',$row_RS_MatPend['Materias_Cursa']);		
		
		
			// llena matriz con materias Anterior
			$CodigoCurso = $row_RS_Alumno['CodigoCurso'];
			
			if($CodigoCurso == 35 or $CodigoCurso == 36)
				$CodigoCurso_aux = '7';
			elseif($CodigoCurso == 37 or $CodigoCurso == 38)
				$CodigoCurso_aux = '8';
			elseif($CodigoCurso == 39 or $CodigoCurso == 40)
				$CodigoCurso_aux = '9';
			elseif($CodigoCurso == 41 or $CodigoCurso == 42)
				$CodigoCurso_aux = 'IV';
			elseif($CodigoCurso == 43 or $CodigoCurso == 44)
				$CodigoCurso_aux = 'V';
			
			$query_RS_CursoAnterior =  "SELECT * FROM CursoMaterias 
										WHERE CodigoMateriaPendiente = '".$CodigoCurso_aux."'";
			$RS_CursoAnterior = mysql_query($query_RS_CursoAnterior, $bd) or die(mysql_error());
			$row_RS_CursoAnterior = mysql_fetch_assoc($RS_CursoAnterior);
			
		$fila_x = 'Materia0'.$Materias_Cursa[1];
		$row_RS_Curso[$fila_x];
		$texto = $row_RS_CursoAnterior[$fila_x];
		
		$pdf->Cell(25,$linea, $texto ,1,0,'L'); 
		
		$NotaM1 = str_replace('*','',$Matriz[1][mp]);
		$NotaM2 = str_replace('*','',$Matriz[2][mp]);
		$NotaM3 = str_replace('*','',$Matriz[3][mp]);
		$NotaM1 = str_replace(' ','',$NotaM1);
		$NotaM2 = str_replace(' ','',$NotaM2);
		$NotaM3 = str_replace(' ','',$NotaM3);
			
		$pdf->Cell(8.3,$linea, $NotaM1 ,1,0,'C'); 	
		$pdf->Cell(8.3,$linea, $NotaM2 ,1,0,'C'); 	
		$pdf->Cell(8.4,$linea, $NotaM3 ,1,0,'C'); 	
		
		
		
		
		//if($Matriz[1][mp][n01]>'')
		
		/*
		//$texto = $Materias_Cursa[0].': '.$Matriz[1][mp][0].' '.$Matriz[2][mp][0].' '.$Matriz[3][mp][0];
		if($Materias_Cursa[1]>''){
	//		$texto = $Materias_Cursa[1].': '.$Matriz[1][mp][1].' '.$Matriz[2][mp][1].' '.$Matriz[3][mp][1];
			$texto = $Materias_Cursa[1].': '.$Matriz[1][mp].' '.$Matriz[2][mp].' '.$Matriz[3][mp];
			$pdf->Cell(50,$linea, $texto ,1,1,'L'); }
		*/
		$pdf->SetXY($posX,$posY);	
	}

	$pdf->Cell(50);
	
	
	if($Matriz[definitiva][promedio][cuenta] > 0)
		$aux = round($Matriz[definitiva][promedio][suma] / $Matriz[definitiva][promedio][cuenta],0);
	$pdf->SetFont($tipologia,'',8);	
	$pdf->Cell(15,$linea, 'Leyenda:' ,0,0,'L'); 	
	$pdf->Cell(65,$linea, 'I = Inasistencias (horas)' ,0,0,'L'); 		
		
	$pdf->SetFont($tipologia,'B',14);	
	$pdf->Cell(40,$linea*1.5, 'Promedio Final ' ,0,0,'R'); 		
	$pdf->Cell(24,$linea*1.5, $aux ,1,0,'C'); 		

	$pdf->Ln($linea);

	$pdf->SetFont($tipologia,'',8);	
	$pdf->Cell(65);
	$pdf->Cell(130,$linea*.8, '• = 1 punto otorgado en Consejo de Docentes' ,0,1,'L'); 		
	$pdf->Cell(65);
	$pdf->Cell(130,$linea*.8, ': = 2 puntos otorgados en Consejo de Docentes' ,0,1,'L'); 		

	$pdf->Ln($linea*.5);
	
	
	
	
	
	
	
	
				 
	$pdf->Ln(7);	
	$pdf->SetFont($tipologia,'',12);	
	$pdf->Cell(195,$linea, 'Docente Guía: _____________________________ ' ,0,0,'R'); 
	$pdf->Ln();	
	$pdf->SetFont($tipologia,'',10);			 
	$pdf->Cell(195,$linea, 'Caracas, '.date('d-m-Y') ,0,0,'R'); 		// PIE FINAL 
				 
				 
	$pdf->Image('../../../img/SelloCol.jpg',145,108,0,18);
	
	
	unset($Matriz);	
	
	if (file_exists($foto)) {
		$pdf->Image($foto,180,8,0,25);}

		
	} while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); 
		
	
$pdf->Output();
mysql_free_result($RS_Alumno);

mysql_free_result($RS_Curso);
?>
