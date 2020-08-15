<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 
if (isset($_GET['test'])) {
$test=true;} else {
$test=false;}

function oi($i){ return substr('0'.$i,-2);}

// Para usar esta rutina, la tabla AlumnosXCurso debe contener los alumnos inscritos en cada seccion 
// AlumnosXCurso.php llena esta tabla
// $_GET['TipoEvaluacion']=='MatPen'   -->>> Materia Pendiente
// $_GET['CodigoCurso']=''  -->>> todos los cursos
// CrearSiguiente=1 para crear siguiente planilla
// test para ver sql

$CodigoCurso_URL = "0";

if (isset($_GET['AnoEscolar'])) {
  $AnoEscolar = (get_magic_quotes_gpc()) ? $_GET['AnoEscolar'] : addslashes($_GET['AnoEscolar']);}


if (isset($_GET['TipoEvaluacion'])) {
		if     ( $_GET['TipoEvaluacion']=='MatPendiente') 	{ 
					$Tipo_Evaluacion = 'Materia Pendiente'; }  
		elseif ( $_GET['TipoEvaluacion']=='Revision')		{ 
					$Tipo_Evaluacion = 'Revisión';} }
	else { 
					$Tipo_Evaluacion = 'Resumen Final';}


  
if($Tipo_Evaluacion=='Resumen Final' or $Tipo_Evaluacion=='Revisión'){
$MesAno = 'Julio '.substr($AnoEscolar,-4);}
else {
$MesAno = $_GET['Mes']." $Ano2";}
  
  
$borde=1;
$Ln = 4.2;
$Alum = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15');

$pdf=new FPDF('P', 'mm', 'Legal');

	$CodigoCurso_ini = 43; 
	$CodigoCurso_fin = 44; 

if(  	$Tipo_Evaluacion == 'Resumen Final') { 
	$Status = 'Inscrito';
	$Tipo_Inscripcion = "Rg";
	$Planilla = "Resumen"; }
elseif ( $Tipo_Evaluacion == 'Revisión') { 
	$Status = 'Inscrito';
	$Tipo_Inscripcion = "Rv";
	$Planilla = "Revision";  }
elseif ( $Tipo_Evaluacion == 'Materia Pendiente') { 
	$Status = 'Inscrito';
	$Tipo_Inscripcion = "Mp";
	$Planilla = 'MatPendiente'.$_GET['Momento']; }


mysql_select_db($database_bd, $bd);



// Para cada CodCurso desde 43 a 44
for($CodigoCurso = $CodigoCurso_ini; $CodigoCurso <= $CodigoCurso_fin ; $CodigoCurso++){ 
	
	// materias
	if($Tipo_Evaluacion=='Materia Pendiente') 
		$CodigoCurso_aux = $CodigoCurso-2; 
	else 
		$CodigoCurso_aux = $CodigoCurso;
		
		
	$sql="SELECT * FROM Curso, CursoMaterias 
			WHERE Curso.CodigoMaterias = CursoMaterias.CodigoMaterias 
			AND Curso.CodigoCurso = ".$CodigoCurso_aux;
			
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_mat = mysql_fetch_assoc($RS);
	
	$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
									WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
									AND AlumnoXCurso.CodigoCurso = '%s' 
									AND AlumnoXCurso.Ano = '%s' 
									AND AlumnoXCurso.Status = '%s' 
									AND AlumnoXCurso.Tipo_Inscripcion = '%s' 
									AND AlumnoXCurso.Planilla = '%s' 
									ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC", 
									$CodigoCurso, $AnoEscolar, $Status, $Tipo_Inscripcion ,$Planilla);
									
	echo $test?$query_RS_Alumnos.'<br>':'';
	
	$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	$num_Alum_Seccion = $totalRows_RS_Alumnos;
	
	$startRow_RS_Alumno =0;
	$maxRows_RS_Alumno  =15;
	$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
	echo $test?$query_limit_RS_Alumno.'<br>':'';
	$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	
	if($totalRows_RS_Alumnos>0){
		do{ // Para cada Alumno
			for($w=0 ; $w<15 ; $w++) { // Inicializa contadores de Inasistentes , Aprobados, etc
				$Inasistentes[$w]=0;
				$Inscritos[$w]	 =0;
				$Aprobados[$w]	 =0;
				$Aplazados[$w]	 =0; }
			$Obs_pais=' ';
				
				
			$pdf->AddPage();
			$pdf->SetMargins(5,5,5);
			$pdf->SetFont('Arial','',10);
			
			// Encabezado Página
			$pdf->Image('../../../img/LogoME.jpg', 5, 5, 0, 17);
			$pdf->SetY( 5 ); 
			$pdf->Ln($Ln);
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'RESUMEN FINAL DEL RENDIMIENTO ESTUDIANTIL' , 'B' , 0 , 'C');
			$pdf->Ln($Ln);
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , ' Código del Formato: RR-DEA-04-03 ' , 0 , 0 , 'C');
			$pdf->Ln($Ln);
			$pdf->Cell(70);  $pdf->Cell(35  , $Ln , 'PLAN DE ESTUDIO: ' , 0 , 0 , 'L');
							 $pdf->Cell(50  , $Ln , ' '.$row_mat['NombrePlanDeEstudio']  , 'B' , 0 , 'L');
							 $pdf->Cell(18  , $Ln , 'CÓDIGO:  ' , 0 , 0 , 'L');
							 $pdf->Cell(27  , $Ln , ' '. $row_mat['CodigoPlanDeEstudio'] , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			$pdf->Cell(70);  $pdf->Cell(28  , $Ln , 'I.   Año Escolar: ' , 0 , 0 , 'L');
							 $pdf->Cell(25  , $Ln , ' '. $AnoEscolar , 'B' , 0 , 'L');
							 $pdf->Cell(47  , $Ln , ' Mes y Año de la Evaluación:' , 0 , 0 , 'L');
							 $pdf->Cell(30  , $Ln , ' '. $MesAno , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			
			
			$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 0 , 'L');
			$pdf->Ln($Ln);
			
			$pdf->Cell(20  , $Ln , 'Cód.DEA: ' , 0 , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' S0934D1507 ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
			$pdf->Cell(101.25  , $Ln , ' U.E. Colegio San Francisco de Asís ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
			$pdf->Cell(10  , $Ln , ' 7 ' , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			
			$pdf->Cell(20  , $Ln , 'Dirección: ' , 0 , 0 , 'L');
			$pdf->Cell(116.25  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Teléfono: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' 283.25.75 ' , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			
			$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
			$pdf->Cell(46.25  , $Ln , ' Chacao ' , 'B' , 0 , 'L');
			$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' Estado Miranda ' , 'B' , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
			$pdf->Cell(35  , $Ln , ' Miranda ' , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			
			$pdf->Cell(20  , $Ln , 'Director(a): ' , 0 , 0 , 'L');
			$pdf->Cell(116.25  , $Ln , ' Vita María Di Campo ' , 'B' , 0 , 'L');
			$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L');
			$pdf->Cell(55  , $Ln , ' 6973243 ' , 'B' , 0 , 'L');
			$pdf->Ln($Ln);
			
			$pdf->Cell(100  , $Ln , 'III.   Resumen Final del Rendimiento ' , 0 , 0 , 'L');
			$pdf->Ln($Ln);
			
			// encabezado de los alumnos		
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
			$pdf->Cell(7.75  , $Ln , 'Resu'  , 0 , 0 , 'C'); //Linea 1
			$pdf->SetFont('Arial','',10);
			
			// materias
			$k=1;
			for ($i = 1; $i <= 15;$i++){
				
				if($row_mat['Ma'.oi($i)]<>$row_mat['Ma'.oi($i-1)] or $row_mat['Ma'.oi($i)]==''){ // Materia distinta a la anterior y no en blanco
				$j++;
				$Mat[$j] = $row_mat['Ma'.oi($i)]>''?$row_mat['Ma'.oi($i)]:'***';
				
				if($row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i+1)] and $row_mat['Ma'.oi($i)]>''){// Materia distinta a la siguiente y no en blanco
				$Materia[$j] = 'Educación para el Trabajo';
				$num_Materias++;}
				else {
				$Materia[$j] = $row_mat['Materia'.oi($i)]>''?$row_mat['Materia'.oi($i)]:' * * * '; }
			
				$sql_Prof = "SELECT * FROM Empleado WHERE CodigoEmpleado = '". $row_mat['Profesor'.oi($i)]."'";
				$Recordset_Prof = mysql_query($sql_Prof, $bd) or die(mysql_error());
				$row_ = mysql_fetch_assoc($Recordset_Prof);
				$Profesor_nom[$j] 	= $row_mat['Materia'.oi($i)]>''?$row_['Apellidos'].' '.$row_['Nombres']:' * * * ';
				$Profesor_ci[$j] 	= $row_mat['Materia'.oi($i)]>''?$row_['CedulaLetra'].'-'.$row_['Cedula']:' * * * ';
				$Profesor_firma[$j] = $row_mat['Materia'.oi($i)]>''?'':' * * * ';}
				
				if($row_mat['Ma'.oi($i)]>'' and $row_mat['Ma'.oi($i)]<>'ET')
				$num_Materias++;
				
				// Llena materias Ed para el trab
				if($row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i+1)] or $row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i-1)]){
				$edTrab[$k++] = $row_mat['Materia'.oi($i)];}
				}
			
			$pdf->Ln($Ln);
			
			$pdf->Cell(40);
			
			for  ($i = 1; $i <= 14;$i++){
				$pdf->Cell(8.75 , $Ln , $Mat[$i] , $borde , 0 , 'C'); } 
			$pdf->Cell(7.75 , $Ln , '1' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '2' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '3' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '4' , $borde , 0 , 'C'); 
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(7.75    , $Ln , 'men' , 0 , 0 , 'C'); 
			$pdf->SetFont('Arial','',10);
			
			$pdf->Ln($Ln);
			// FIN Encabezado
			
			
			//NOTAS  
			foreach ($Alum as $i){
				
				
				// No.
				$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 

				// Cedula
				$Cedula = $row_RS_Alumnos['CedulaLetra'].$row_RS_Alumnos['Cedula'];
				if($Cedula=='')	{
					$relleno = '';
					$TripleAst = ' * * * '; } 
				else {
					$relleno = '*';
					$TripleAst = ''; }
				
				
				$pdf->Cell(33 , $Ln , $TripleAst.$Cedula , $borde , 0 , 'C'); // Cedula

			
			
				$sql="SELECT * FROM Nota 
						WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
						AND Ano_Escolar = '".$AnoEscolar."' 
						AND Lapso='".$Lapso."' ";  
				$RS_notas = mysql_query($sql, $bd) or die(mysql_error());
				$row_notas = mysql_fetch_assoc($RS_notas);
			
				$sql_Rev="SELECT * FROM Nota 
						WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
						AND Ano_Escolar = '".$AnoEscolar."' 
						AND Lapso='".$LapsoRev."' ";  
				$RS_notas_Rev = mysql_query($sql_Rev, $bd) or die(mysql_error());
				$row_notas_Rev = mysql_fetch_assoc($RS_notas_Rev);
			
			if($Tipo_Evaluacion == 'Revisión'){
				$sql_Nota_Def="SELECT * FROM Nota 
						WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
						AND Ano_Escolar = '".$AnoEscolar."' 
						AND Lapso='Revision' ";  
				$RS_Nota_Def = mysql_query($sql_Nota_Def, $bd) or die(mysql_error());
				$row_Nota_Def = mysql_fetch_assoc($RS_Nota_Def);}
			
			
			$j=1;
			$resumen=0;
			$apro=0;
			$aplz=0;
			$inas=0;
			$Rellena=0;
			for  ($i = 1; $i <= 14;$i++){
				
					if($Mat[$i]=='ET' ){
						$et1 = $row_notas_Rev['n' . oi($i)]  >''?$row_notas_Rev['n' . oi($i)]   : $row_notas['n' . oi($i)];
						$et2 = $row_notas_Rev['n' . oi($i+1)]>''?$row_notas_Rev['n' . oi($i+1)] : $row_notas['n' . oi($i+1)];
						$aux = round(($et1 + $et2)/2 , 0);
						if($row_notas_Rev['n' . oi($i)]=='N') 
							$aux_Nota='N';
						else 
							$aux_Nota = Nota($aux);
					}
					else{
						if($row_notas_Rev['n' . oi($i)]>''){
							$aux_Nota = Nota($row_notas_Rev['n' . oi($i)]);}
						else{
							$aux_Nota = Nota($row_notas['n' . oi($i)]);}}
					
						if($Tipo_Evaluacion == 'Revisión' and $aux_Nota=='N'){
							$aux_Nota_Def = $row_Nota_Def['n' . oi($i)]*1;
							if($aux_Nota_Def<9.45)
								$aux_Nota='';
								//$aux_Nota=$aux_Nota_Def;
							}
							
							
					if($Cedula=='') $aux_Nota='';
					$pdf->Cell(8.75 , $Ln ,  $aux_Nota , $borde , 0 , 'C'); 
					$Num_Casilla++;
					
					if($aux_Nota=='I') $resumen=4;
					
					$Inasistentes[$j]=$Inasistentes[$j]*1;
					$Inscritos[$j]=$Inscritos[$j]*1;
					$Aprobados[$j]=$Aprobados[$j]*1;
					$Aplazados[$j]=$Aplazados[$j]*1;
					
					if($aux_Nota=='I' or $aux_Nota=='i') { $Inasistentes[$j]+=1; $inas+=1; $aux_Nota=strtoupper($aux_Nota); }
					if($aux_Nota=='n') { $aux_Nota=strtoupper($aux_Nota); }
					if(($aux_Nota>0 or $aux_Nota>'') and $aux_Nota!='N' and $aux_Nota!='n' and $aux_Nota!='*') $Inscritos[$j]+=1;
					if($aux_Nota>=10 and $aux_Nota<=20)  { $Aprobados[$j]+=1; 	$apro+=1; }
					if($aux_Nota>0 and $aux_Nota<10)     { $Aplazados[$j]+=1; 	$aplz+=1; }
				
					if($Mat[$j]=='***'){
					$Inasistentes[$j]='***';
					$Inscritos[$j]='***';
					$Aprobados[$j]='***';
					$Aplazados[$j]='***';}
			
					if($Mat[$i]=='ET'){$i++; $Rellena++; }
				$j++;
				}
					if($Rellena>0){
					$pdf->Cell(8.75 , $Ln ,  $relleno , $borde , 0 , 'C'); 
					$Num_Casilla++;
					if($Mat[$j]=='***'){
					$Inasistentes[$j]='***';
					$Inscritos[$j]='***';
					$Aprobados[$j]='***';
					$Aplazados[$j]='***';}
					}
				
				
				if($et1>=10) $aux = 'X'; elseif ($et1>0) $aux = '-'; else $aux = $relleno;
				$pdf->Cell(7.75 , $Ln , $aux , $borde , 0 , 'C'); 
				if($et2>=10) $aux = 'X'; elseif ($et2>0) $aux = '-'; else $aux = $relleno;
				$pdf->Cell(7.75 , $Ln , $aux , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , $relleno , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , $relleno , $borde , 0 , 'C'); 
				
				
				$total_mats = ($apro+$aplz+$inas)*1;
				$mitad_mas_una = round(($total_mats/2)+1,0)*1;
				$inas=$inas*1;  $aplz=$aplz*1;  $apro=$apro*1;
				if($inas>0)
				$resumen = '5';
				elseif($aplz > $mitad_mas_una)
				$resumen = '4';
				elseif($aplz > 1  and $aplz <= $mitad_mas_una)
				$resumen = '3';
				elseif($aplz==1)
				$resumen = '2';
				elseif($aplz==0 and $apro>0)
				$resumen = '1';
				elseif($inas==0 and $aplz==0 and $apro==0)
				$resumen = '';
				//$resumen = $apro;
			
			
			
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Resumen Final'){ // Reprobó Resumen Final
				$sql="INSERT INTO AlumnoXCurso 
					(CodigoAlumno							, Ano 			   , Tipo_Inscripcion , Status    , Planilla  , CodigoCurso ) 
			VALUES 	( '".$row_RS_Alumnos['CodigoAlumno']."' , '".$AnoEscolar."', 'Rv'             , 'Inscrito', 'Revision', $CodigoCurso)";
				echo $test?$sql.'<br>':'';
			//if($CrearSiguiente)	
				$RS_ = mysql_query($sql, $bd) or die(mysql_error()); 
				}
			
			$CodigoCurso_aux1 = round($CodigoCurso/2 , 0) ;
			$CodigoCurso_aux2 = $CodigoCurso/2;
			
			if($CodigoCurso_aux1 != $CodigoCurso_aux2)
				$CodigoCurso_aux3 = $CodigoCurso+1;
				else
				$CodigoCurso_aux3 = $CodigoCurso;
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Revisión' ){ // Reprobó Revision
				//$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, Status, CodigoCurso) VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."' , '".$AnoEscolar."', 'MatPendienteEnero', $CodigoCurso_aux3)";
				//echo $test?$sql.'<br>':'';
			//if($CrearSiguiente)	
				//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Materia Pendiente' and $_GET['Mes']=='Enero'){ // Reprobó Mat Pendiente ENERO
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, Status, CodigoCurso) VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."' , '".$AnoEscolar."', 'MatPendienteMarzo', $CodigoCurso_aux3)";
				echo $test?$sql.'<br>':'';
			//if($CrearSiguiente)	
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Materia Pendiente' and $_GET['Mes']=='Marzo'){ // Reprobó Mat Pendiente MARZO
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, Status, CodigoCurso) VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."' , '".$AnoEscolar."', 'MatPendienteJunio', $CodigoCurso_aux3)";
				echo $test?$sql.'<br>':'';
			//if($CrearSiguiente)	
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
				
				
				
			if(($CodigoCurso==43 or $CodigoCurso==44) and $resumen=='1' and $Tipo_Evaluacion=='Resumen Final'){ // Se gradua
				$sql = "UPDATE AlumnoXCurso Set FechaGrado = 'Julio".$Ano2."' WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' AND Ano='".$AnoEscolar."' AND Status='Inscrito'";
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			}
				
			if(($CodigoCurso==43 or $CodigoCurso==44) and $resumen=='1' and $Tipo_Evaluacion=='Revisión'){ // Se gradua Revision
				$sql = "UPDATE AlumnoXCurso Set FechaGrado = 'Julio".$Ano2."R' WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' AND Ano='".$AnoEscolar."' AND Status='Inscrito'";
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			}
				
				$pdf->Cell(7.75 , $Ln , $resumen , $borde , 0 , 'C'); 
			
				$pdf->Ln($Ln);
				$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
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
			$pdf->Ln($Ln);}
			
			
			
			
			// ALUMNOS
			$num_Alum_Pag=0;
			$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
			$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
				$pdf->Cell(7  , $Ln , 'No' , $borde , 0 , 'C'); 
				$pdf->Cell(55 , $Ln , 'Apellidos' , $borde , 0 , 'C'); 
				$pdf->Cell(55 , $Ln , 'Nombres' , $borde , 0 , 'C'); 
				$pdf->Cell(53.25 , $Ln , 'Lugar de Nacimiento' , $borde , 0 , 'L'); 
				$pdf->Cell(7.75 , $Ln , 'E F' , $borde , 0 , 'C'); 
				
				$pdf->Cell(23.25 , $Ln , 'Fecha de Nac' , $borde , 0 , 'C'); 
			
				$pdf->Ln($Ln);
			for ($i=1 ; $i<=13 ; $i++){
				if($row_RS_Alumnos['Apellidos']>'') 
					$num_Alum_Pag++;
				$pdf->Cell(7  , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
				if($row_RS_Alumnos['Apellidos']=='')
					$Apellidos = ' * * * ';
				else
					$Apellidos = $row_RS_Alumnos['Apellidos'].' '.$row_RS_Alumnos['Apellidos2'];
				$pdf->Cell(55 , $Ln , $Apellidos , $borde , 0 , 'L'); 
				$pdf->Cell(55 , $Ln , $row_RS_Alumnos['Nombres'].' '.$row_RS_Alumnos['Nombres2'] , $borde , 0 , 'L'); 
				$pdf->Cell(53.25 , $Ln , $row_RS_Alumnos['Localidad'] , $borde , 0 , 'L'); 
				$pdf->Cell(7.75 , $Ln , $row_RS_Alumnos['EntidadCorta'] , $borde , 0 , 'C'); 
				if($row_RS_Alumnos['EntidadCorta']=='Ex') $Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
				
				$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 2,2) , $borde , 0 , 'C'); 
			
				$pdf->Ln($Ln);
				$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
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
				$pdf->Cell(55 , $Ln , $Materia[$i] , $borde , 0 , 'L'); 
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
			if($Tipo_Evaluacion == 'Materia Pendiente') $seccion='*'; else $seccion = $row_mat['Seccion'];
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $seccion.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA PÁGINA' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Pag.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'NÚMERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA SECCIÓN' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Seccion.'  ' , $borde , 1 , 'R');
			
			$pdf->Cell(201.25 , $Ln , 'V.  Programas cursados en Educación Para El Trabajo / Horas - Alumnos Semanales de C/Uno' , $borde , 1 , 'L');
			//ET 1
			$pdf->Cell(7 , $Ln , '1.' , $borde , 0 , 'C');
			$pdf->Cell(83.5 , $Ln , $edTrab[1] , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , $row_mat['Ed_T1_Hr'] , $borde , 0 , 'L');
			
			//ET 3
			$pdf->Cell(7 , $Ln , '3.' , $borde , 0 , 'C');
			$pdf->Cell(83.75 , $Ln , '  ' , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , '  ' , $borde , 1 , 'L');
			
			//ET 2
			$pdf->Cell(7 , $Ln , '2.' , $borde , 0 , 'C');
			$pdf->Cell(83.5 , $Ln , $edTrab[2] , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , $row_mat['Ed_T2_Hr'] , $borde , 0 , 'L');
			
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
			$pdf->Cell(98 , $Ln , 'VII. Fecha de Remisión:  '.$FechaRemision , $borde , 1 , 'L');
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
			
			
			$startRow_RS_Alumno = $startRow_RS_Alumno + $maxRows_RS_Alumno;
			$maxRows_RS_Alumno  = 13;
			$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
			$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
			$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
			$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
			
			
			
		} while($totalRows_RS_Alumnos>0);
	}// seccion vacia  if($totalRows_RS_Alumnos>0
}
$pdf->Output();


?>