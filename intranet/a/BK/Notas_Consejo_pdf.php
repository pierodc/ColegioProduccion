<?php 
require_once('../../../Connections/bd.php');
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/notas.php'); 
require_once('../../../inc/fpdf.php'); 
require_once('../../../inc/rpdf.php'); 
$Lapsos = array('1','2','3');
$Evaluaciones = array('70','30','Def');
mysql_select_db($database_bd, $bd);

class PDF extends RPDF
{
	//Cabecera de página
	function Header() {

		$this->Image('../../../img/solcolegio.jpg', 8, 5, 0, 14);
		$this->Image('../../../img/NombreCol.jpg' , 25, 5, 0, 10);
		
		$linea=5;
		$this->Ln(5);
	
		$this->SetFont('Times','B',14);
		$this->Cell(250,$linea, '' ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		$this->Cell(250,$linea, $titulo ,0,1,'R'); 
		
	}
	
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-10);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,5,'Pág. '.$this->PageNo(),0,0,'R');
		
		$Fecha = date('d ').Mes( date('m') ).date(' Y').'  ->  '.date('g:ia');
		$this->SetXY(10,-10);
		$this->Cell(0,5,''.$Fecha,0,0,'L');
	}
}


$pdf=new PDF('L', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$borde=1;

if (isset($_GET['CodigoCurso'])) {
	$add_sql = " CodigoCurso = '".$_GET['CodigoCurso']."' "; }
elseif (isset($_GET['NivelCurso'])) {
	$add_sql = " NivelCurso = '".$_GET['NivelCurso']."' "; }
else{
	$add_sql = " NivelCurso ='31'" ; }

$sql_Curso = "SELECT * FROM Curso WHERE $add_sql ORDER BY NivelMencion, Curso, Seccion";
$RS_Curso = mysql_query($sql_Curso, $bd) or die(mysql_error());
$row_Curso = mysql_fetch_assoc($RS_Curso);


do{
$CodigoMaterias = $row_Curso['CodigoMaterias'];	
$CodigoCurso = 	$row_Curso['CodigoCurso'];
$NombreCompleto = 	$row_Curso['NombreCompleto'];
$sql="SELECT * FROM Alumno, AlumnoXCurso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = '$CodigoCurso'
		AND AlumnoXCurso.Ano = '$AnoEscolar'
		AND AlumnoXCurso.Tipo_Inscripcion  <> 'Mp'
		AND AlumnoXCurso.Status  = 'Inscrito'
		ORDER BY Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);

$i=0;
if($row)
do {
	$Ln = 5.90;
	extract($row);
	$TituloPag = $NombreCompleto;
	
	$i++;
	if($i==1 or $i==8 or $i==15 or $i==22 or $i==29 or $i==36){ //ENCABEZADO
	//function Encabezado(){
		$pdf->SetFont('Arial','B',14);
		$pdf->AddPage();
		$AnchoDisponible = 260;
			
//		$pdf->SetY( 30 );
//		$pdf->Image('../../../img/solcolegio.jpg', 8, 5, 0, 14);
//		$pdf->Image('../../../img/NombreCol.jpg' , 25, 5, 0, 10);
		$pdf->SetY( 22 );
		$pdf->Cell(39 , $Ln , $TituloPag , 0 , 0 , 'L'); 
		
		foreach($Lapsos as $Lapso){ // Titulo del lapso
			$Lapso = explode(';' , $Lapso);
		if ($Lapso[0] == $_POST['Notas']) 
		$pdf->Cell(39 , $Ln , $Lapso[1] , 0 , 0 , 'R');} 
		
		$pdf->Ln();
		
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetY( 30 );
		//$i=1;
		$pdf->SetFont('Arial','',10);
		
		//$pdf->Cell(8 , $Ln , $sql , 0 , 1 , 'R'); // IMPRIMIR SQL
		 
		$pdf->Cell(10 , $Ln , 'No' , $borde , 0 , 'C');
		$pdf->Cell(28 , $Ln , 'Apell., Nomb.' , $borde , 0 , 'L');   
		$AnchoDisponible-=58;
		$pdf->Cell(15);
		$AnchoDisponible-=15;
		$_x = $pdf->GetX();
		
		$mm = $AnchoDisponible/13;
		
		$pdf->Cell($mm/1.5);
		
		
		$pdf->SetFont('Arial','',8);
	
		for ($j = 1; $j <= 12; $j++) {  // para materias
			foreach($Evaluaciones as $Evaluacion){
				$pdf->Cell($mm/3 , $Ln , $Evaluacion , $borde , 0 , 'C');
			}
		$pdf->Cell(1);
		}
		$pdf->SetFont('Arial','',10);
					

		//$pdf->Ln($Ln);




		
		$sql2 = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$CodigoMaterias."n'";
		$RS2 = mysql_query($sql2, $bd) or die(mysql_error());
		$row2 = mysql_fetch_assoc($RS2);
		
		$pdf->SetXY($_x, 24-$Ln*3.5 );
		
		$pdf->Cell($mm/1.5);
		for ($j = 1; $j <= 12; $j++){ // Casillas en blanco para materias
			$pdf->Cell($mm , $Ln*4.5 , '' , $borde , 0 , 'C');
			$pdf->Cell(1);}
		
		$_x = $_x + $mm/2 + 2 + $mm/1.5;

		//$pdf->Cell();
		for ($j = 1; $j <= 12; $j++) { // Materias
			$pdf->TextWithDirection($_x , 28 , $row2['Materia'.substr("0".$j, -2).''] , 'U' ); 
			$_x = $_x + $mm + 1; }
		
		
		$pdf->SetY( 30 );
		$pdf->Ln($Ln);
		$_x_add=1;
		
	
		
	} //ENCABEZADO FIN

	
	
	
	
	
	$Ln = 15;

	// No lista
	$pdf->Cell(10 , $Ln/2 , $i.')' , 'TLR' , 0 , 'C'); 			
	
	
	// Apellidos del alumno
	$Alumno  = trim($Apellidos.' '.substr($Apellidos2,0,1). ',');
	$pdf->Cell(28 , $Ln/2 , $Alumno , 'TLR' , 0 , 'L'); 
	$_y_Foto = $pdf->GetY();
	$_x_Foto = $pdf->GetX();
	$pdf->Ln($Ln/2);
	
	
	// Codigo Alumno
	$pdf->Cell(10 , $Ln/2 , $CodigoAlumno , 'BLR' , 0 , 'R'); 

	// Nombres del alumno
	$Alumno  = trim($Nombres.' '.substr($Nombres2,0,1));
	//$pdf->Cell(18);
	$pdf->Cell(28 , $Ln/2 , $Alumno , 'BLR' , 0 , 'R'); 
	
	// Foto del Alummno
	$Foto = '../../../'.$AnoEscolar.'/' .$CodigoAlumno. '.jpg';
	if(file_exists($Foto))
		$pdf->Image($Foto , $_x_Foto, $_y_Foto, 15, 0);
	else{
		$Foto = '../../../'.$AnoEscolarAnte.'/' .$CodigoAlumno. '.jpg';
		if(file_exists($Foto))
			$pdf->Image($Foto , $_x_Foto, $_y_Foto, 15, 0);
		}


	$pdf->SetY($_y_Foto);
	$pdf->SetX($_x_Foto);
	$pdf->Cell(15);

	$_x_ = $pdf->GetX();
	$_y_ = $pdf->GetY();

	$Notas[Definitiva] = 0;
	$Notas[PromediaDefinitiva] = 0;

  //Matrices de notas (rows)
  foreach($Lapsos as $Lapso)
  		foreach($Evaluaciones as $Evaluacion){
			$sql_notas = "SELECT * FROM Nota 
							WHERE CodigoAlumno = '$CodigoAlumno' 
							AND Ano_Escolar = '$AnoEscolar' 
							AND Lapso = '$Lapso-$Evaluacion'";
			$RS_Notas = mysql_query($sql_notas, $bd) or die(mysql_error());
			$row_notas = mysql_fetch_assoc($RS_Notas);
			$Notas[$Lapso.'-'.$Evaluacion] = $row_notas;
		}

			$sql_notas = "SELECT * FROM Nota 
						WHERE CodigoAlumno = '$CodigoAlumno' 
						AND Ano_Escolar = '$AnoEscolar' 
						AND Lapso = 'Def'";
			$RS_Notas = mysql_query($sql_notas, $bd) or die(mysql_error());
			$row_notas = mysql_fetch_assoc($RS_Notas);
			$Notas[Def] = $row_notas;

	// Imprimir NOTAS Lapsos
	foreach($Lapsos as $Lapso){ // Para cada lapso
		$pdf->Cell($mm/1.5 , $Ln/3 , $Lapso.'' , $borde , 0 , 'C', 1);
		for ($j = 1; $j <= 12; $j++) { // para materias 
			$id = 'n'.substr('00'.$j,-2);	
				foreach($Evaluaciones as $Evaluacion){
					$nota = $Notas[$Lapso.'-'.$Evaluacion][$id] ;
					if($nota<10)
						$pdf->SetTextColor(255,0,0);
					if($nota=='I')
						$pdf->SetTextColor(0,150,150);
					$pdf->Cell($mm/3 , $Ln/3 , Nt($nota) , $borde , 0 , 'C', 1);
					$pdf->SetTextColor(0);
				}
			// Separador materia
			$pdf->Cell(1);
			}
		$pdf->Ln($Ln/3);
		$pdf->Cell(78);
		$pdf->SetX($_x_);
	}

	// imprimir DEFINITIVA
	$pdf->Cell($mm/1.5 , $Ln/3 , 'Def' , $borde , 0 , 'C', 1);
	$Cant_Aplazadas_Alumno = 0;
	for ($j = 1; $j <= 12; $j++) { // para materias 
		$pdf->SetFont('Arial','B',10);
		$id = 'n'.substr('00'.$j,-2);	
			foreach($Evaluaciones as $Evaluacion){
				if($Evaluacion=='Def')
					$nota = $Notas[Def][$id];
				else
					$nota = '';	
				if($nota<10)
					$pdf->SetTextColor(255,0,0);

				$Suma_Def_Lapsos = ($Notas['1-Def'][$id] + $Notas['2-Def'][$id] + $Notas['3-Def'][$id])*1;

				if($Evaluacion=='70' and $Suma_Def_Lapsos>=26 and $Suma_Def_Lapsos<=28 and $Notas['3-Def'][$id]>0){
					$nota = $Suma_Def_Lapsos . '>';
					}
				else {
					}


				if($Evaluacion=='70'){
					$ancho = ($mm/3)*2;
					$alinear = 'R';
					$pdf->SetFont('Arial','',8);}
				else {
					$ancho = $mm/3;
					$alinear = 'C';
					$pdf->SetFont('Arial','B',10);}
					
				if($Suma_Def_Lapsos==28 and $Evaluacion=='Def' and $Notas['3-Def'][$id]>0){
					$pdf->SetFillColor(255,255,0);}
				
				if($Evaluacion=='70' or  $Evaluacion=='Def'){		
					$pdf->Cell($ancho , $Ln/3 , $nota , $borde , 0 , $alinear, 1);}
				
				$nota=$nota*1;
				if($nota >= 1 and $nota <= 9 ){
					$Cant_Aplazadas_Alumno++;
					$Aplazados[$j]++;
					}
				if($nota >= 10 and $nota <= 20 ){
					$Aprobados[$j]++;
					}
					
				$pdf->SetTextColor(0);
				$pdf->SetFillColor(255);

			}
		// Separador materia
		$pdf->Cell(1);
		}
	
	if($Cant_Aplazadas_Alumno > 0)
		$pdf->Cell($mm , $Ln/3 , 'Aplaz '.$Cant_Aplazadas_Alumno , 'LB' , 0 , 'L', 1);
	
	$pdf->Ln($Ln/3);
	$pdf->Cell(78);
	$pdf->SetX($_x_);
	$pdf->SetFont('Arial','',10);

	
	
	$pdf->Ln(1);
	
	$TituloAnterior = $TituloPag;
	
	if($row = mysql_fetch_assoc($RS)) 
		extract($row);
	
	 $TituloPag = $NombreCompleto;
	
	// Cambio de curso (totales)
	if($TituloAnterior != $TituloPag  or !$row){ 
		if($Aprobados[1]>0 or $Aprobados[3]>0 or $Aprobados[5]>0 or $Aprobados[7]>0 or $Aplazados[1]>0){
			
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(0,0,255);
			$pdf->Cell(19 , $Ln*2/3 +1 , ' Aprobados ' , 'TBL' , 0 , 'R',1); 
			$pdf->SetTextColor(255,0,0);
			$pdf->Cell(19 , $Ln*2/3 +1 , ' Aplazados ' , 'TB' , 0 , 'L',1); 
			$pdf->SetTextColor(0);
			$pdf->Cell(15+($mm/1.5)  , $Ln/3 , 'cantidad (#)' , 'TBR' , 0 , 'R',1); 
			
			for ($j = 1; $j <= 12; $j++) {	
				$pdf->SetTextColor(0,0,255);
				$pdf->Cell($mm/2 , $Ln/3 , $Aprobados[$j] , 'TBL' , 0 , 'L',1); 
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell($mm/2 , $Ln/3 , $Aplazados[$j] , 'TBR' , 0 , 'R',1); 
				$pdf->SetTextColor(0);
				// Separador materia
				$pdf->Cell(1);
			}

			
			//$pdf->Cell($mm , $Ln/1.5 ,  ''  , $borde , 0 , 'R',1); 
			$pdf->Ln($Ln/3 +1);
			
			$pdf->Cell(38); 
			$pdf->SetTextColor(0);
			$pdf->Cell(15+($mm/1.5) , $Ln/3 , 'porcentaje (%)' , 'TBR' , 0 , 'R',1); 
			
			for ($j = 1; $j <= 12; $j++) {	
				if($Aprobados[$j] > 0){
					$_Porcent_Aprob = round($Aprobados[$j]*100/($Aprobados[$j]+$Aplazados[$j]) , 0);
					$_Porcent_Aplaz = round(100-$_Porcent_Aprob , 0);} 
				else { 
					$_Porcent_Aprob=$_Porcent_Aplaz=''; }
				
				if($_Porcent_Aplaz == 0){ 
					$ancho = $mm; }
				else{
					$ancho = $mm/2;}
				
				$pdf->SetTextColor(0,0,255);
				if($_Porcent_Aprob==100) {
					$_Porcent_Aprob = '100%';
					$bordes = 1;}
				else
					$bordes = 'TBL';
				$pdf->Cell($ancho , $Ln/3 ,  $_Porcent_Aprob   , $bordes , 0 , 'L',1); 
				
				if($_Porcent_Aplaz != 0){ 
					$pdf->SetTextColor(255,0,0);
					$pdf->Cell($ancho , $Ln/3 ,  $_Porcent_Aplaz  , 'TBR' , 0 , 'R',1); }
				$pdf->SetTextColor(0);
				// Separador materia
				$pdf->Cell(1);

				
			}
		}
		
		unset($Aprobados);
		unset($Aplazados);
		
	/*
		// Pie de página al final del curso
		if($_POST['Orientacion']=='P')
		$pdf->SetY( 257 );
		else
		$pdf->SetY( 190 );
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(50 , 2 , date('d').' '. Mes(date('m')) .' '. date('Y') , 0 , 0 , 'L');
		$pdf->Cell(100 , 2 , 'Pág.'.++$Pag , 0 , 0 , 'C');
		$pdf->Cell(50 , 2 , $TituloAnterior , 0 , 0 , 'R');
		$pdf->SetFont('Arial','',10);*/
		
	}
	
} while ($row);

}while($row_Curso = mysql_fetch_assoc($RS_Curso));

$pdf->Output();


?>