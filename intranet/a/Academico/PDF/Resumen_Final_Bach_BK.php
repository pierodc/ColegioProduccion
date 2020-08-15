<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../intranet/a/archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

if (isset($_GET['test'])) { 
$test=true;} else {
$test=false;}

if (isset($_GET['CodigoAlumno'])) { 
	$sql_CodigoAlumno = " AND AlumnoXCurso.CodigoAlumno = '".$_GET['CodigoAlumno']."' ";}


//function oi($i){ return substr('0'.$i,-2);}

// Para usar esta rutina, la tabla AlumnosXCurso debe contener los alumnos inscritos en cada seccion 
// $_GET['TipoEvaluacion']=='MatPen'   -->>> Materia Pendiente
// $_GET['CodigoCurso']=''  -->>> todos los cursos
// CrearSiguiente=1 para crear siguiente planilla
// test para ver sql

$CodigoCurso_URL = "0";
if (isset($_GET['CodigoCurso'])) {
  $CodigoCurso_URL = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);}

if (isset($_GET['AnoEscolar'])) {
	$AnoEscolar = $_GET['AnoEscolar'];}
	
$Ano1 = substr($AnoEscolar,0,4);
$Ano2 = substr($AnoEscolar,-4);

//Tipo Planilla
if (isset($_GET['TipoEvaluacion'])) {
		if     ( $_GET['TipoEvaluacion']=='MatPendiente') 	{ 
					$Tipo_Evaluacion = 'Materia Pendiente'; 
					$Tipo_Inscripcion = "Mp";
					$Planilla = 'MatPendiente'.$_GET['Momento'];}  
		elseif ( $_GET['TipoEvaluacion']=='Revision')		{ 
					$Fecha_Remision = $Fecha_Remision_Revision;
					$Tipo_Evaluacion = 'Revisi髇';
					$Tipo_Inscripcion = "Rv";
					$Planilla = "Revision";} 
		elseif ( $_GET['TipoEvaluacion']=='Equivalencia')		{ 
					$Tipo_Evaluacion = 'Equivalencia';
					$Tipo_Inscripcion = "Eq";
					$Planilla = "Equivalencia";} 
	}
	else { //si no se asigna $_GET['TipoEvaluacion'] ... se asume Resumen Final
					$Tipo_Evaluacion = 'Resumen Final';
					$Tipo_Inscripcion = "Rg";
					$Planilla = "Resumen";}
					
//Fecha Planilla  
if($Tipo_Evaluacion=='Resumen Final'){
	$MesAno = 'Julio '.$Ano2;}
elseif ($Tipo_Evaluacion=='Revisi髇')
	$MesAno = $Fecha_Resumen_Final_Revision;
elseif ($Tipo_Evaluacion=='Equivalencia')
	$MesAno = 'Marzo '.$Ano2;
elseif ($Tipo_Evaluacion=='Materia Pendiente')
	 if    ( $_GET['Momento']=='M01' ){				$MesAno = $Mes_1er_momento.' '.$Ano2;}
	 elseif( $_GET['Momento']=='M02' ){				$MesAno = $Mes_2do_momento.' '.$Ano2;}
	 elseif( $_GET['Momento']=='M03' ){				$MesAno = $Mes_3er_momento.' '.$Ano2;}
	 elseif( $_GET['Momento']=='M04' ){				$MesAno = $Mes_4to_momento.' '.$Ano2;}
  
// Cursos
if($CodigoCurso_URL == 0) { 
	$CodigoCurso_ini = 35; 
	$CodigoCurso_fin = 45; }
else { 
	$CodigoCurso_ini = $CodigoCurso_URL;
	$CodigoCurso_fin = $CodigoCurso_URL; }
 
$borde=1;
$Ln = 4.2;
$Mats = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
$Alum = array('01','02','03','04','05','06','07','08','09','10','11','12','13');

$pdf=new FPDF('P', 'mm', 'Legal');

$array_Mat["Mat"] = array("","CL","IN","MA","EN","HV","EF","GG","EA","EF","ET","IT","***","***","***");
$array_Mat["Materia"] = array("","Castellano","Ingl閟","Matem醫icas","Estudios de la Naturaleza","Historia de Venezuela",
								"Educ. Familiar y Ciudadana","Geograf韆 General","Educaci髇 Art韘tica",
								"Educaci髇 F韘ica","Educaci髇 para el Trabajo","Italiano",
								"***","***","***");

$array_Mat["CI"] = array("","15432897","12071337","3250116","4587661","13030852","5217757",
						"5530083","5217757","17459932","12470147","16379628","***","***","***");

$array_Mat["ET"][1] = array("Computacion","4");
$array_Mat["ET"][2] = array("Nociones B醩icas de Oficina","4");
$array_Mat["ET"][3] = array("","");
$array_Mat["ET"][4] = array("","");



// Si Resumen Final ... Elimina Revision
if($Tipo_Evaluacion=='Resumen Final' ){
	$Lapso = 'Def'; $LapsoRev='Def';
	$sql="DELETE FROM AlumnoXCurso WHERE Tipo_Inscripcion='Rv' AND Ano='".$AnoEscolar."' ";
	echo $test?$sql.'<br>':'';
	//$RS_ = mysql_query($sql, $bd) or die(mysql_error()); 
	}


if($Tipo_Evaluacion=='Revisi髇'){
	$Lapso = 'Revision'; $LapsoRev='Revision';
	$sql="DELETE FROM AlumnoXCurso 
			WHERE Tipo_Inscripcion='Mp' 
			AND Ano = '".$AnoEscolarProx."' 
			AND Planilla = 'MatPendienteM01'";
	echo $test?$sql.'<br>':'';
	//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	}
elseif($Tipo_Evaluacion=='Equivalencia'){
	$Lapso = 'Equivalencia'; $LapsoRev='Equivalencia';
	}
elseif($Tipo_Evaluacion=='Materia Pendiente')
		if ($_GET['Momento']=='M01') {
			$Lapso = '1mp';	$LapsoRev='1mp';
			$sql="DELETE FROM AlumnoXCurso WHERE Tipo_Inscripcion='Mp' AND Planilla = 'MatPendienteM02' AND Ano='".$AnoEscolar."'";
			echo $test?$sql.'<br>':'';
			//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			}
		elseif ($_GET['Momento']=='M02') {
			$Lapso = '2mp';	$LapsoRev='2mp';
			$sql="DELETE FROM AlumnoXCurso WHERE Tipo_Inscripcion='Mp' AND Planilla = 'MatPendienteM03' AND Ano='".$AnoEscolar."' ";
			echo $test?$sql.'<br>':'';
			//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			}
		elseif ($_GET['Momento']=='M03') {
			$Lapso = '3mp';	$LapsoRev='3mp';
			$sql="DELETE FROM AlumnoXCurso WHERE Tipo_Inscripcion='Mp' AND Planilla = 'MatPendienteM04' AND Ano='".$AnoEscolar."' ";
			echo $test?$sql.'<br>':'';
			//$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			}
		elseif ($_GET['Momento']=='M04') {
			$Lapso = '4mp';	$LapsoRev='4mp';}
	

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
	
	$sql2="SELECT * FROM Curso, CursoMaterias 
			WHERE Curso.CodigoMaterias = CursoMaterias.CodigoMaterias
			AND Curso.CodigoCurso = ".$CodigoCurso_aux;			
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_mat = mysql_fetch_assoc($RS);


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
	echo $test?$query_RS_Alumnos.'<br>':'';
	$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	$num_Alum_Seccion = $totalRows_RS_Alumnos;


foreach(array(1,2) as $grupo){
	
	
	
	
	if($grupo == 1){
		$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
										WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
										AND AlumnoXCurso.CodigoCurso = '%s' 
										AND AlumnoXCurso.Ano = '%s' 
										AND AlumnoXCurso.Status = 'Inscrito' 
										AND AlumnoXCurso.Tipo_Inscripcion = '%s' 
										AND AlumnoXCurso.Planilla = '%s' 
										AND Alumno.CedulaLetra <> 'P' 
										$sql_CodigoAlumno
										GROUP BY Alumno.Cedula_int 
										ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC ", 
										$CodigoCurso, $AnoEscolar, $Tipo_Inscripcion ,$Planilla);
		$startRow_RS_Alumno = 0;
		$maxRows_RS_Alumno  = 13;
		$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
		echo $test?$query_limit_RS_Alumno.'<br>':'';
		$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
		$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
		$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
	}
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
		$maxRows_RS_Alumno  = 13;
		$query_limit_RS_Alumno = sprintf("%s LIMIT %d, %d", $query_RS_Alumnos, $startRow_RS_Alumno, $maxRows_RS_Alumno);
		echo $test?$query_limit_RS_Alumno.'<br>':'';
		$RS_Alumnos = mysql_query($query_limit_RS_Alumno, $bd) or die(mysql_error());
		$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
		$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
		}



	
	if($totalRows_RS_Alumnos > 0){
		do{ // Para cada PAGINA
			for($w=0 ; $w<15 ; $w++) { // Inicializa contadores
				$Inasistentes[$w] = $Inscritos[$w] = $Aprobados[$w] = $Aplazados[$w] = 0;
				 }
			$Obs_pais=' ';
				
			$pdf->AddPage();
			$pdf->SetMargins(5,5,5);
			$pdf->SetFont('Arial','',10);
			
			// ENCABEZADO
			$pdf->Image('../../../../img/LogoME2.jpg', 5, 5, 0, 17);
			$pdf->SetY( 9.2 ); 
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , 'RESUMEN FINAL DEL RENDIMIENTO ESTUDIANTIL' , 'B' , 1 , 'C');
			
			$NombrePlanDeEstudio = $row_mat['NombrePlanDeEstudio'];
			//$NombrePlanDeEstudio = "BACHILLER";
			$pdf->Cell(100); $pdf->Cell(100  , $Ln , ' C骴igo del Formato: RR-DEA-04-03 ' , 0 , 1 , 'C');
			$pdf->Cell(70);  $pdf->Cell(35  , $Ln , 'PLAN DE ESTUDIO: ' , 0 , 0 , 'L');
							 $pdf->Cell(50  , $Ln , ' '.$NombrePlanDeEstudio  , 'B' , 0 , 'L');
							 $pdf->Cell(18  , $Ln , 'C覦IGO:  ' , 0 , 0 , 'L');
							 $pdf->Cell(27  , $Ln , ' '. $row_mat['CodigoPlanDeEstudio'] , 'B' , 1 , 'L');
			$pdf->Cell(70);  $pdf->Cell(28  , $Ln , 'I.   A駉 Escolar: ' , 0 , 0 , 'L');
							 $pdf->Cell(25  , $Ln , ' '. $AnoEscolar , 'B' , 0 , 'L');
							 $pdf->Cell(47  , $Ln , ' Mes y A駉 de la Evaluaci髇:' , 0 , 0 , 'L');
							 $pdf->Cell(30  , $Ln , ' '. $MesAno , 'B' , 1 , 'L');
			
			
			$pdf->Cell(50  , $Ln , 'II.    Datos del Plantel' , 0 , 1 , 'L');
			$pdf->Cell(20  , $Ln , 'C骴.DEA: ' , 0 , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' S0934D1507 ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Nombre: ' , 0 , 0 , 'L');
			$pdf->Cell(101.25  , $Ln , ' U.E. Colegio San Francisco de As韘 ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Dtto.Esc.: ' , 0 , 0 , 'L');
			$pdf->Cell(10  , $Ln , ' 7 ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Direcci髇: ' , 0 , 0 , 'L');
			$pdf->Cell(116.25  , $Ln , ' 7ma. transv. entre 4ta y 5ta Av. Los Palos Grandes ' , 'B' , 0 , 'L');
			$pdf->Cell(20  , $Ln , ' Tel閒ono: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' 283.25.75 ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Municipio: ' , 0 , 0 , 'L');
			$pdf->Cell(46.25  , $Ln , ' Chacao ' , 'B' , 0 , 'L');
			$pdf->Cell(25  , $Ln , ' Ent. Federal: ' , 0 , 0 , 'L');
			$pdf->Cell(45  , $Ln , ' Estado Miranda ' , 'B' , 0 , 'L');
			$pdf->Cell(30  , $Ln , ' Zona Educativa: ' , 0 , 0 , 'L');
			$pdf->Cell(35  , $Ln , ' Miranda ' , 'B' , 1 , 'L');
			
			$pdf->Cell(20  , $Ln , 'Director(a): ' , 0 , 0 , 'L');
			$pdf->Cell(116.25  , $Ln , ' Vita Mar韆 Di Campo ' , 'B' , 0 , 'L');
			$pdf->Cell(10  , $Ln , ' C.I.: ' , 0 , 0 , 'L');
			$pdf->Cell(55  , $Ln , ' 6973243 ' , 'B' , 1 , 'L');
			
			$pdf->Cell(100  , $Ln , 'III.   Resumen Final del Rendimiento ' , 0 , 1 , 'L');
			
			// encabezado tabla superior		
			$pdf->Cell(7  , $Ln*3 , 'No' , $borde , 0 , 'C'); //Linea 1 (201,25 mm)
			$pdf->Cell(33 , $Ln*1.5 , 'C閐ula de'  , 'T' , 0 , 'C'); //Linea 1
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
			
			
				// llena Matriz materias y profesores
				$k=1;
				for ($i = 1; $i <= 15;$i++){ 
					
					if($row_mat['Ma'.oi($i)] <> $row_mat['Ma'.oi($i-1)] 
						or $row_mat['Ma'.oi($i)]==''){ // Materia distinta a la anterior y no en blanco
						$j++;
						$Mat[$j] = $row_mat['Ma'.oi($i)]>''?$row_mat['Ma'.oi($i)]:'***';
					
					if($row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i+1)] 
						and $row_mat['Ma'.oi($i)]>''){// Materia distinta a la siguiente y no en blanco
						$Materia[$j] = 'Educaci髇 para el Trabajo';
						$num_Materias++;}
					else {
						$Materia[$j] = $row_mat['Materia'.oi($i)]>''?$row_mat['Materia'.oi($i)]:' * * * '; }
				
						$sql_Prof = "SELECT * FROM Empleado WHERE CodigoEmpleado = '". $row_mat['Profesor'.oi($i)]."'";
						$Recordset_Prof = mysql_query($sql_Prof, $bd) or die(mysql_error());
						$row_ = mysql_fetch_assoc($Recordset_Prof);
						$Nom_Comp_Prof = $row_['Apellidos'].' '.substr($row_['Apellido2'],0,1).' '.$row_['Nombres'].' '.substr($row_['Nombre2'],0,1);
						$Profesor_nom[$j] 	= $row_mat['Materia'.oi($i)]>''?$Nom_Comp_Prof:' * * * ';
						$Profesor_ci[$j] 	= $row_mat['Materia'.oi($i)]>''?$row_['CedulaLetra'].'-'.$row_['Cedula']:' * * * ';
						$Profesor_firma[$j] = $row_mat['Materia'.oi($i)]>''?'':' * * * ';}
					
						if($row_mat['Ma'.oi($i)]>'' and $row_mat['Ma'.oi($i)]<>'ET')
							$num_Materias++;
					
						// Llena materias Ed para el trab
						if($row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i+1)] or $row_mat['Ma'.oi($i)]==$row_mat['Ma'.oi($i-1)]){
							$edTrab[$k++] = $row_mat['Materia'.oi($i)];}
					}
			
			
			// encabezado materias
			$pdf->Cell(40);
			for  ($i = 1; $i <= 14;$i++){
				$pdf->Cell(8.75 , $Ln , $array_Mat["Mat"][$i] , $borde , 0 , 'C'); } 
			$pdf->Cell(7.75 , $Ln , '1' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '2' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '3' , $borde , 0 , 'C'); 
			$pdf->Cell(7.75 , $Ln , '4' , $borde , 0 , 'C'); 
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(7.75    , $Ln , 'men' , 0 , 1 , 'C'); 
			$pdf->SetFont('Arial','',10);
			// FIN Encabezado
			
			
			//NOTAS para cada Alumno
			foreach ($Alum as $i){
				
				// No.
				$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 

				// Cedula
				$Cedula = strtoupper($row_RS_Alumnos['CedulaLetra']).$row_RS_Alumnos['Cedula'];
				if($Cedula=='')	{
					$relleno = '';
					$TripleAst = ' * * * '; } 
				else {
					$relleno = '*';
					$TripleAst = ''; }
				$pdf->Cell(33 , $Ln , $TripleAst.$Cedula , $borde , 0 , 'C'); // Cedula

				// Busca Notas de 1 Alumno
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
		
			if($Tipo_Evaluacion == 'Revisi髇'){
				$sql_Nota_Def="SELECT * FROM Nota 
						WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
						AND Ano_Escolar = '".$AnoEscolar."' 
						AND Lapso='Revision' ";  
				$RS_Nota_Def = mysql_query($sql_Nota_Def, $bd) or die(mysql_error());
				$row_Nota_Def = mysql_fetch_assoc($RS_Nota_Def);}
			
			$apro=$aplz=$inas=0;
			$resumen=0;
			$aplz_materias = '';
			$Rellena=0;
			$j = 1;
			$iCert = 1;
			$NumET = 0;
			for  ($i = 1; $i <= 14;$i++){ // para cada materia
					
					if($Mat[$i]=='ET'){
						$et1 = $row_notas_Rev['n'.oi($i)]  >''?$row_notas_Rev['n'.oi($i)]   : $row_notas['n'.oi($i)];
						$et2 = $row_notas_Rev['n'.oi($i+1)]>''?$row_notas_Rev['n'.oi($i+1)] : $row_notas['n'.oi($i+1)];
						$aux = round(($et1 + $et2)/2 , 0);
						$NumET++;
						if($row_notas_Rev['n'.oi($i)]=='N') 
							$aux_Nota='N';
						else 
							$aux_Nota = Nota($aux);
					}
					else{
						if($row_notas_Rev['n' . oi($i)]>''){
							$aux_Nota = Nota($row_notas_Rev['n'.oi($i)]);}
						else{
							$aux_Nota = Nota($row_notas['n'.oi($i)]);}
						}
					
					
					if($Tipo_Evaluacion == 'Revisi髇' and $aux_Nota=='N'){
						$aux_Nota_Def = $row_Nota_Def['n'.oi($i)]*1;
						if($aux_Nota_Def<9.45)
							$aux_Nota='';
						}
							
							
					if($Cedula=='') 
						$aux_Nota='';
					
					$pdf->Cell(8.75 , $Ln ,  $aux_Nota , $borde , 0 , 'C'); 
					
					
					// Llena nota certificada
					if($Tipo_Evaluacion == 'Resumen Final') 
						$TE = 'F';
					if($Tipo_Evaluacion == 'Revisi髇') 
						$TE = 'R';
						
					if($row_RS_Alumnos['CodigoAlumno']>0 and $NotaCertificada[$iCert][Mes]!='ET' and ($Mat[$i]!='ET' or ( $Mat[$i]=='ET' and $NumET == 1 ))){ 
					


						// Busca la Notas_Certificadas Actual
						$sql_certificadas = "SELECT * FROM Notas_Certificadas 
											WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
											AND Grado = '".$Grado."' 
											AND Orden = '".$iCert."'";  
						$RS_notas_certificadas = mysql_query($sql_certificadas, $bd) or die(mysql_error());
						$row_notas_certificadas = mysql_fetch_assoc($RS_notas_certificadas);
						
						
						//if( !($row_notas_certificadas['Nota'] >= 10 and $row_notas_certificadas['Nota'] <= 20) 
						//	or ($Tipo_Evaluacion == 'Revision' and ($row_notas_certificadas['Nota'] >= 10 and $row_notas_certificadas['Nota'] <= 20))){
						
						if($Tipo_Evaluacion == 'Resumen Final' or $Tipo_Evaluacion == 'Revisi髇' or ($aux_Nota >= 10 and $aux_Nota <= 20)){
					
					
							if($aux_Nota>=10 and $aux_Nota<=20){
					
								// Eliminar UNA Notas_Certificada 
								$sql_certificadas = "DELETE FROM Notas_Certificadas 
													 WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
													 AND Grado = '".$Grado."' 
													 AND Orden = '".$iCert."'";  
								$RS_notas_certificadas = mysql_query($sql_certificadas, $bd) or die(mysql_error());
								//$row_notas_certificadas = mysql_fetch_assoc($RS_notas_certificadas);
							}
							
							
							// Agregar UNA Notas_Certificada
							if($aux_Nota>=10 and $aux_Nota<=20){
								$CertNota = $aux_Nota;
								$CertTE = $TE;
								$CertMes = '07';
								$CertAno = $Ano2;
								$CertPlantel = '1';
								}
							elseif($Tipo_Evaluacion == 'Resumen Final'){
								$CertNota = 'P';
								$CertTE = '*';
								$CertMes = '*';
								$CertAno = '*';
								$CertPlantel = '*';
								}
							$Materia_NotaCertificada = "";	
								
								
							if(($aux_Nota>=10 and $aux_Nota<=20) or $Tipo_Evaluacion == 'Resumen Final'){	
								$sql_certificadas = "INSERT INTO Notas_Certificadas 
													(CodigoAlumno, Grado, Orden, Materia, Nota, TE, Mes, Ano, Plantel)  
													VALUES
													('".$row_RS_Alumnos['CodigoAlumno']."' ,
													'".$Grado."' ,
													'".$iCert."',
													'".$NotaCertificada[$iCert][Materia]."',
													'$CertNota',
													'$CertTE',
													'$CertMes',
													'$CertAno',
													'$CertPlantel')";
								//echo $sql_certificadas.'<br>';	
								$RS_notas_certificadas = mysql_query($sql_certificadas, $bd);
							}
									




						}

							
							
							
					}// FIN ... Llena nota certificada
					$iCert++;

					//mysql_free_result($RS_notas_certificadas);	
					
					$Num_Casilla++;

					
					// Actuliza contadores
					if($aux_Nota=='I' or $aux_Nota=='i') { 
							$Inasistentes[$j]+=1; 
							$inas+=1; 
							$aux_Nota=strtoupper($aux_Nota); 
							$aplz_materias = $aplz_materias . ';' .$i. ';';}
							
					if($aux_Nota=='n') { 
							$aux_Nota=strtoupper($aux_Nota); }
							
					if(($aux_Nota>0 or $aux_Nota>'') and $aux_Nota!='N' and $aux_Nota!='n' and $aux_Nota!='*') 
							$Inscritos[$j] += 1;
					
					if($aux_Nota>=10 and $aux_Nota <= 20)  { 
							$Aprobados[$j] += 1;
							$apro+=1; }
					
					if($aux_Nota>0 and $aux_Nota < 10)     { 
							$Aplazados[$j] += 1; 	
							$aplz+=1; 
							$aplz_materias = $aplz_materias . ';' .$i. ';'; }
				
					if($Mat[$i]=='ET'){ 
						$i++; $Rellena++; }
	
					/*if($Mat[$i-1]=='ET'){ 
						$iCert--; }
					*/
						
					$j++;
				} // fin para cada materia
					
					if($Rellena>0){
						$pdf->Cell(8.75 , $Ln ,  $relleno , $borde , 0 , 'C'); 
						$Num_Casilla++;
					}
				
				if($et1>=10) $aux = 'X'; elseif ($et1>0) $aux = '-'; else $aux = $relleno;
				$pdf->Cell(7.75 , $Ln , $aux , $borde , 0 , 'C'); 
				if($et2>=10) $aux = 'X'; elseif ($et2>0) $aux = '-'; else $aux = $relleno;
				$pdf->Cell(7.75 , $Ln , $aux , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , $relleno , $borde , 0 , 'C'); 
				$pdf->Cell(7.75 , $Ln , $relleno , $borde , 0 , 'C'); 
				
				if($et1>=10){ // Agrega Nota Certificada ET 1
						$sql_certificadas = "DELETE FROM Notas_Certificadas 
											WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
											AND Grado = '".$Grado."' 
											AND Orden = '20'";  
						$RS_notas_certificadas = mysql_query($sql_certificadas, $bd) or die(mysql_error());
						$sql_certificadas = "INSERT INTO Notas_Certificadas 
											(CodigoAlumno, Grado, Orden, Materia, Nota, Mes)  
											VALUES
											('".$row_RS_Alumnos['CodigoAlumno']."' ,
											'".$Grado."' ,
											'20',
											'".$NotaCertificada[12][Materia]."',
											'4',
											'ET')";
						$RS_notas_certificadas = mysql_query($sql_certificadas, $bd);
					}
				
				if($et1>=10){ // Agrega Nota Certificada ET 2
						$sql_certificadas = "DELETE FROM Notas_Certificadas 
											WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
											AND Grado = '".$Grado."' 
											AND Orden = '21'";  
						$RS_notas_certificadas = mysql_query($sql_certificadas, $bd) or die(mysql_error());
						$sql_certificadas = "INSERT INTO Notas_Certificadas 
											(CodigoAlumno, Grado, Orden, Materia, Nota, Mes)  
											VALUES
											('".$row_RS_Alumnos['CodigoAlumno']."' ,
											'".$Grado."' ,
											'21',
											'".$NotaCertificada[13][Materia]."',
											'4',
											'ET')";
						$RS_notas_certificadas = mysql_query($sql_certificadas, $bd);
					}
				
				
				$total_mats = ($apro+$aplz+$inas)*1;
				$mitad_mas_una = round(($total_mats/2)+1,0)*1;
				$inas=$inas*1;  $aplz=$aplz*1;  $apro=$apro*1;
				if($inas > 0)
				//	$resumen = '5';
				//elseif($aplz > $mitad_mas_una)
					$resumen = '4';
				elseif($aplz > 1) //  and $aplz <= $mitad_mas_una
					$resumen = '3';
				elseif($aplz == 1)
					$resumen = '2';
				elseif($aplz == 0 and $apro > 0)
					$resumen = '1';
				elseif($inas==0 and $aplz==0 and $apro==0)
					$resumen = '';
				
				$Cant_Materias_Rep = $inas + $aplz;
				//$resumen = $apro;
			
			
			
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Resumen Final'){ // Reprob贸 Resumen Final
				$sql="INSERT INTO AlumnoXCurso 
					(CodigoAlumno, Ano, Tipo_Inscripcion , Status, Planilla, CodigoCurso, Materias_Cursa) 
			VALUES 	( '".$row_RS_Alumnos['CodigoAlumno']."' , '".$AnoEscolar."', 'Rv', 'Inscrito', 'Revision', $CodigoCurso, '$aplz_materias')";
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
			
			if( $Cant_Materias_Rep > '1' and $Tipo_Evaluacion=='Revisi髇' ){ // Reprob贸 mas de 1 - Repite A帽o
				$sql="UPDATE AlumnoXCurso SET
						CodigoCurso = '".$row_RS_Alumnos['CodigoCurso']."' 
						WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
						AND Ano = '$AnoEscolarProx'";
				echo $test?$sql.'<br>':'';
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}

			if( $Cant_Materias_Rep == '1' and $Tipo_Evaluacion=='Revisi髇' ){ // Reprob贸 1 - Lleva Materia Pendiente
			$CodigoCursoMatPendiente = $CodigoCurso_aux3-1;
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status, Tipo_Inscripcion, Planilla, Materias_Cursa) 
						VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."', $CodigoCursoMatPendiente , '".$AnoEscolarProx."', 'Inscrito', 'Mp', 'MatPendienteM01', '$aplz_materias')";
				echo $test?$sql.'<br>':'';
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Materia Pendiente' and $_GET['Momento']=='M01'){ // Reprob贸 Mat Pendiente Momt 01
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status, Tipo_Inscripcion, Planilla, Materias_Cursa) 
						VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."', $CodigoCurso_aux3 , '".$AnoEscolar."', 'Inscrito', 'Mp', 'MatPendienteM02', '$aplz_materias')";
				echo $test?$sql.'<br>':'';
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Materia Pendiente' and $_GET['Momento']=='M02'){ // Reprob贸 Mat Pendiente Momt 01
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status, Tipo_Inscripcion, Planilla, Materias_Cursa) 
						VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."', $CodigoCurso_aux3 , '".$AnoEscolar."', 'Inscrito', 'Mp', 'MatPendienteM03', '$aplz_materias')";
				echo $test?$sql.'<br>':'';
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			if( $resumen > '1' and $Tipo_Evaluacion=='Materia Pendiente' and $_GET['Momento']=='M03'){ // Reprob贸 Mat Pendiente Momt 01
				$sql="INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status, Tipo_Inscripcion, Planilla, Materias_Cursa) 
						VALUES ( '".$row_RS_Alumnos['CodigoAlumno']."', $CodigoCurso_aux3 , '".$AnoEscolar."', 'Inscrito', 'Mp', 'MatPendienteM04', '$aplz_materias')";
				echo $test?$sql.'<br>':'';
				$RS_ = mysql_query($sql, $bd) or die(mysql_error());
				}
			
			
			if($CodigoCurso==43 or $CodigoCurso==44){
				
				if( $Tipo_Evaluacion=='Resumen Final'){ // Se gradua
					if($resumen=='1')		
						$Fecha_Aux = "Julio".$Ano2;
					else
						$Fecha_Aux = "";
 					$sql = "UPDATE AlumnoXCurso Set FechaGrado = '$Fecha_Aux' 
							WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
							AND Ano='".$AnoEscolar."' 
							AND Status='Inscrito'
							AND Tipo_Inscripcion='Rg'";
				}
					
				if( $Tipo_Evaluacion=='Revisi髇'){ // Se gradua Revision
					if($resumen=='1')		
						$Fecha_Aux = "Julio".$Ano2."R";
					else
						$Fecha_Aux = "";
					$sql = "UPDATE AlumnoXCurso Set FechaGrado = '$Fecha_Aux' 
							WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
							AND Ano='".$AnoEscolar."' 
							AND Status='Inscrito' 
							AND Tipo_Inscripcion='Rv'";
				}
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
			
			if($Mat[$i]=='***'){
				$Inasistentes[$i] = $Inscritos[$i] = $Aprobados[$i] = $Aplazados[$i] = '***';}
				
			if($tipo == 'INSCR') 	$pdf->Cell(8.75 , $Ln , $Inscritos[$i] , $borde , 0 , 'C'); 
			if($tipo == 'INAS') 	$pdf->Cell(8.75 , $Ln , $Inasistentes[$i] , $borde , 0 , 'C'); 
			if($tipo == 'APRO') 	$pdf->Cell(8.75 , $Ln , $Aprobados[$i] , $borde , 0 , 'C'); 
			if($tipo == 'APLAZ') 	$pdf->Cell(8.75 , $Ln , $Aplazados[$i] , $borde , 0 , 'C'); 
			
			} 
			
			
			$j=0;
				if($tipo=='INSCR'){
				$pdf->Cell(38.75 , $Ln*2 , 'Tipo de Evaluaci髇' , $borde , 0 , 'C');  }
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
				
				if($row_RS_Alumnos['EntidadCorta'] == 'Dc' or $row_RS_Alumnos['EntidadCorta'] == 'Df')
					$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);
				else
					$EntidadCorta = strtoupper($row_RS_Alumnos['EntidadCorta']);

				
				$pdf->Cell(7.75 , $Ln , $EntidadCorta , $borde , 0 , 'C'); 
				if($row_RS_Alumnos['EntidadCorta']=='Ex') $Obs_pais = $Obs_pais . $i.'.'.$row_RS_Alumnos['LocalidadPais'].', ';
				
				$pdf->Cell(6.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 8,2) , $borde , 0 , 'C'); 
				$pdf->Cell(6.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 5,2) , $borde , 0 , 'C'); 
				$pdf->Cell(9.75 , $Ln , substr( $row_RS_Alumnos['FechaNac'] , 0,4) , $borde , 0 , 'C'); 
			
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
				if ($array_Mat["CI"][$i] <> "***")
					$Cedula = "V-".$array_Mat["CI"][$i];
				else
					$Cedula = "";
					
				$pdf->Cell(7 , $Ln , substr('0'.$i , -2) , $borde , 0 , 'C'); 
				$pdf->Cell(55 , $Ln , $array_Mat["Materia"][$i] , $borde , 0 , 'L'); 
				$pdf->Cell(49 , $Ln , Empleado_ApellidoNombre($array_Mat["CI"][$i]) , $borde , 0 , 'L'); 
				$pdf->Cell(25 , $Ln , $Cedula , $borde , 0 , 'R'); 
				if($Inscritos[$i]==0)$Profesor_firma[$i]=' * * * ';
				$pdf->Cell(25 , $Ln , $Profesor_firma[$i] , $borde , 0 , 'C');
				$pdf->Ln($Ln);
			}
			
			
			$pdf->SetXY($coorX,$coorY);
			$pdf->Cell(40.25 , $Ln*2 , 'Identificaci髇 del' , 'TLR' , 1 , 'C');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'Curso' , 'BLR' , 1 , 'C');
			$pdf->SetFont('Arial','',9);
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'MENCI覰:' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $row_mat['Mencion'].'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , '' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'GRADO o A袿:' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $row_mat['Curso'].'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'SECCI覰:' , $borde , 1 , 'L');
			if($Tipo_Evaluacion == 'Materia Pendiente' or $Tipo_Evaluacion == 'Equivalencia') $seccion='*'; else $seccion = $row_mat['Seccion'];
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $seccion.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'N贛ERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA P罣INA' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Pag.'  ' , $borde , 1 , 'R');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'N贛ERO DE ALUMNOS' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , 'EN ESTA SECCI覰' , $borde , 1 , 'L');
			$pdf->SetX($coorX); $pdf->Cell(40.25 , $Ln , $num_Alum_Seccion.'  ' , $borde , 1 , 'R');
			
			$pdf->Cell(201.25 , $Ln , 'V.  Programas cursados en Educaci髇 Para El Trabajo / Horas - Alumnos Semanales de C/Uno' , $borde , 1 , 'L');
			//ET 1
			$pdf->Cell(7 , $Ln , '1.' , $borde , 0 , 'C');
			$pdf->Cell(83.5 , $Ln , $array_Mat["ET"][1][0] , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , $array_Mat["ET"][1][1] , $borde , 0 , 'L');
			
			//ET 3
			$pdf->Cell(7 , $Ln , '3.' , $borde , 0 , 'C');
			$pdf->Cell(83.75 , $Ln , '  ' , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , '  ' , $borde , 1 , 'L');
			
			//ET 2
			$pdf->Cell(7 , $Ln , '2.' , $borde , 0 , 'C');
			$pdf->Cell(83.5 , $Ln , $array_Mat["ET"][2][0] , $borde , 0 , 'L');
			$pdf->Cell(10 , $Ln , $array_Mat["ET"][2][1] , $borde , 0 , 'L');
			
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
			$pdf->Cell(98 , $Ln , 'VII. Fecha de Remisi髇:  '.$Fecha_Remision , $borde , 1 , 'L');
			$pdf->Cell(49 , $Ln , 'Director(a)' , $borde , 0 , 'C');
			$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
			$pdf->Ln($Ln);
			$pdf->Cell(49 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
			$pdf->Cell(49 , $Ln*2 , '  Vita Mar韆 Di Campo' , $borde , 1 , 'L');
			$pdf->Cell(49 , $Ln , 'N鷐ero de C.I.:' , $borde , 0 , 'L');
			$pdf->Cell(49 , $Ln , 'SELLO DEL' , 'LR' , 1 , 'C');
			$pdf->Cell(49 , $Ln*2 , '  6973243' , $borde , 0 , 'L');
			$pdf->Cell(49 , $Ln , 'PLANTEL' , 'LR' , 1 , 'C');
			$pdf->Cell(49); $pdf->Cell(49 , $Ln*4 , '' , 'BLR' , 0 , 'C');
			$pdf->Ln($Ln);
			$pdf->Cell(49 , $Ln , 'Firma:' , $borde , 1 , 'L');
			$pdf->Cell(49 , $Ln*2 , '' , $borde , 1 , 'C');
			
			$pdf->SetXY($coorX,$coorY);
			$pdf->Cell(103.25); $pdf->Cell(98 , $Ln , 'VIII. Fecha de Recepci髇:' , $borde , 1 , 'L');
			$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Funcionario Receptor' , $borde , 0 , 'C');
			$pdf->Cell(49 , $Ln*4 , '' , 'TLR' , 0 , 'C');
			$pdf->Ln($Ln);
			$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'Apellidos y Nombres:' , $borde , 1 , 'L');
			$pdf->Cell(103.25); $pdf->Cell(49 , $Ln*2 , '  ' , $borde , 1 , 'L');
			$pdf->Cell(103.25); $pdf->Cell(49 , $Ln , 'N鷐ero de C.I.:' , $borde , 0 , 'L');
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
			
			
			/*
			if($totalRows_RS_Alumnos == 0){ // Alumnos con Cedula Escolar
				$query_RS_Alumnos = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
									WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
									AND AlumnoXCurso.CodigoCurso = '%s' 
									AND AlumnoXCurso.Ano = '%s' 
									AND AlumnoXCurso.Status = 'Inscrito' 
									AND AlumnoXCurso.Tipo_Inscripcion = '%s' 
									AND AlumnoXCurso.Planilla = '%s'
									AND Alumno.Cedula_int > 50000000
									GROUP BY Alumno.Cedula_int
									ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC
									", 
									$CodigoCurso, $AnoEscolar, $Tipo_Inscripcion ,$Planilla);
				$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
				$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
				$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
			}
			*/
			
			
			
		} while($totalRows_RS_Alumnos > 0);
	}// seccion vacia  if($totalRows_RS_Alumnos>0
	}
}
$pdf->Output();


?>