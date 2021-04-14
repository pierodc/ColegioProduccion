<?php 
$MM_authorizedUsers = "2,91,secre";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 



$ImpresoPor = $MM_Username;

//mysql_select_db($database_bd, $bd);

$colname_RS_Alumno = "1";
if (isset($_GET['CodigoAlumno'])) {
  $colname_RS_Alumno =  $_GET['CodigoAlumno'] ;
}

$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoClave = '%s' ", $colname_RS_Alumno);

$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
//$Conteo = $RS_Alumno->num_rows;

//$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
//$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$MM_Username = $row_RS_Alumno['Creador'];
$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];

$query_Solvente = "SELECT * FROM ContableMov
					WHERE CodigoPropietario = '$CodigoAlumno'
					AND ReferenciaMesAno = '$MesAnoParaSolvencia'
					AND SWCancelado = '0'
					AND MontoDebe > 0";
//echo $query_Solvente;		
$RS_Solvente = $mysqli->query($query_Solvente);
;


//$RS_Solvente = mysql_query($query_Solvente, $bd) or die(mysql_error());
if($row_Solvente = $RS_Solvente->fetch_assoc()){
		$Solvente = false;}
else{	$Solvente = true;}
//$Solvente = true;
extract($row_RS_Alumno);


$hoy_dia=date ('d');
$hoy_mes=Mes(date ('m'));
$hoy_ano=date ('Y');



$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='$CodigoAlumno' 
		AND Ano='".$AnoEscolarProx."' ";
//echo $sql;
$RS_sql = $mysqli->query($sql);
$row_RS = $RS_sql->fetch_assoc();
$totalRows_RS = $RS_sql->num_rows;


//$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
//$row_RS = mysql_fetch_assoc($RS_sql);
//$totalRows_RS = mysql_num_rows($RS_sql);


if($row_RS['Status'] == 'Solicitando' or $row_RS['Status'] == 'Retirado'){
  //echo  'Solicitando';
  header("Location: PlanillaSolicitaCupo_pdf.php?CodigoAlumno=". $_GET['CodigoAlumno']); 
  exit;
}
else{
	// REVISAR PROCESO ALUMNOS ATUALES
	//header("Location: index.php"); 
	//exit;
	}

//if($AnoEscolar != $AnoEscolarProx ){
$sql_AlumnoXCurso = "SELECT * FROM AlumnoXCurso WHERE 
					CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' AND 
					Ano = '$AnoEscolarProx'";
//echo $sql_AlumnoXCurso."<br>";	

$RS_AlumnoXCurso = $mysqli->query($sql_AlumnoXCurso);
$row_RS_AlumnoXCurso = $RS_AlumnoXCurso->fetch_assoc();
$totalRows_RS = $RS_AlumnoXCurso->num_rows;


//$RS_AlumnoXCurso = mysql_query($sql_AlumnoXCurso, $bd) or die(mysql_error());
//$totalRows_RS = mysql_num_rows($RS_AlumnoXCurso);
//$row_RS_AlumnoXCurso = mysql_fetch_assoc($RS_AlumnoXCurso);
//echo $totalRows_RS ."<br>";


// No existe renglon AlumnoXCurso (Crear)
if($totalRows_RS == 0) { 
	$sql = "SELECT * FROM AlumnoXCurso WHERE 
			CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
			AND (Ano = '$AnoEscolar' OR Ano = '$AnoEscolarAnte')
			AND Status = 'Inscrito'
			AND SeRetira = '0'
			ORDER BY Ano DESC";
		//echo $sql."<br>";		
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();

	
	//$RS = mysql_query($sql, $bd) or die(mysql_error());
	//$row = mysql_fetch_assoc($RS);
	//echo $row['CodigoCurso']."<br>";
	
	if($row){ // Inscrito Actual Crear Prox
		$sql = "INSERT AlumnoXCurso SET 
				CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' ,
				Ano = '$AnoEscolarProx' ,
				Status = 'Aceptado',
				CodigoCurso = '".CodigoCursoProx($row['CodigoCurso'])."'";
		//echo $sql."<br>";		
		$mysqli->query($sql);//mysql_query($sql, $bd) or die(mysql_error());		
		}
	$sql_AlumnoXCurso = "SELECT * FROM AlumnoXCurso WHERE 
						CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' AND 
						Ano = '$AnoEscolarProx'";
	
	$RS_AlumnoXCurso = $mysqli->query($sql_AlumnoXCurso);//mysql_query($sql_AlumnoXCurso, $bd) or die(mysql_error());
	$row_RS_AlumnoXCurso = $RS_AlumnoXCurso->fetch_assoc();
}



// Cambia planilla impresa 
$query = "UPDATE AlumnoXCurso SET 
			Fecha_Planilla_Imp = '".date('Y-m-d')."'
			WHERE CodigoAlumno = '$CodigoAlumno'
			AND Ano = '".$AnoEscolarProx."'";
$mysqli->query($sql);//mysql_query($query, $bd) or die(mysql_error());

$sql_Curso_Alum = "SELECT * FROM Curso WHERE 
					CodigoCurso = '".$row_RS_AlumnoXCurso['CodigoCurso']."' ";
$RS_Curso_al = $mysqli->query($sql_Curso_Alum);//mysql_query($sql_Curso_Alum, $bd) or die(mysql_error());
$row_RS_Curso_al = $RS_Curso_al->fetch_assoc();


/*
$Deuda_Actual_SQL = "SELECT * FROM ContableMov 
					 WHERE CodigoPropietario = '".$row_RS_Alumno['CodigoAlumno']."'
					 AND ReferenciaMesAno = 'Ins 17'";
$RS_Deuda_Actual = mysql_query($Deuda_Actual_SQL, $bd) or die(mysql_error());
$Deuda_Actual = $row_RS_Alumno['Deuda_Actual'];
if($row_Deuda_Actual = mysql_fetch_assoc($RS_Deuda_Actual)){
	$Deuda_Actual = 0;}
*/

/*
class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    $this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    $this->Rotate(0);
}
}
*/



$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(0,0,200);
$pdf->SetTextColor(0);


$pdf->AddPage();
$pdf->SetFont('Times','',14);
//$pdf->Text(160,18,'Actualizó: '.DDMMAAAA($row_RS_Alumno['Datos_Revisado_Fecha']),10);
//$pdf->AddPage();


$borde=1;
$Ln = 4.25;
$Ln1 = 3;
$borde1='TLR';
$Ln2 = 3.3;
$borde2='BLR';

$linea=5;
$Sp='  ';

$pdf->Image('../img/solcolegio.jpg',10,5,0,15);
$pdf->Image('../img/NombreCol.jpg',30,5,0,12);

//echo $Deuda_Actual;
//
if($ImpresoPor =="piero" or $ImpresoPor =="mary" or $Solvente){
	$pdf->SetFont('Times','',16);
	$pdf->Cell(70); $pdf->Cell(70 , $linea , 'Planilla de Inscripción' ,0,1,'C'); 
	$pdf->Cell(70); 
	$pdf->Cell(70 , $linea , 'Año Escolar '.$AnoEscolarProx ,0,0,'C');

	$query = "UPDATE AlumnoXCurso SET 
				Fecha_Planilla_Imp_OK = '".date('Y-m-d')."'
				WHERE CodigoAlumno = '$CodigoAlumno'
				AND Ano = '".$AnoEscolarProx."'";
	$mysqli->query($query);//mysql_query($query, $bd) or die(mysql_error());
}
else {
	$pdf->Cell(70); 
	}
$pdf->Cell(60 , $linea , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] ,0,1,'R'); 

if($row_RS_Alumno['SWInsCondicional']==1){  
	$pdf->SetFont('Times','',14);
	//$pdf->Cell(0);
	$pdf->Cell(100,$linea, 'Firma Coordinadora: ' ,1,0,'L'); 
	} 
else {
	$pdf->Cell(100);}


$pdf->SetFont('Times','',9);
if($ImpresoPor != $MM_Username)
	$NotaImpresoPor = "(".$ImpresoPor.") ";
$pdf->Cell(100,$linea, $NotaImpresoPor.'Usuario: '.$MM_Username ,0,1,'R'); 


//Planilla de 
if($row_RS_Alumno['SWinscrito'] == '1'){
//echo "Reinscripción";  
}else{
//echo "Inscripción";
} 
 
 
          
//Foto_Repre/ $row_RS_Alumno['CodigoAlumno']; m.jpg" class="TextosSimples">Foto<br>
           
//LetraPeq($pdf);
//$pdf->Cell(50 , $Ln2 , $_SESSION['MM_Username'] , 0 , 0 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(150 , $Ln2+$Ln1 , 'Curso al que solicita inscripción' , 0 , 0 , 'R'); 
LetraTit($pdf);
$pdf->Cell(50 , $Ln2+$Ln1 , $row_RS_Curso_al['NombreCompleto'] , 1 , 0 , 'C'); 

$pdf->Ln(3);
LetraTit($pdf);
if($row_RS_Alumno['Sexo']=="F")	
	$pdf->Cell(170 , 5 , 'Datos de la Alumna' , 0 , 1 , 'L'); 
else
	$pdf->Cell(170 , 5 , 'Datos del Alumno' , 0 , 1 , 'L'); 
//$pdf->Ln($Ln2);
$CoorY=$pdf->GetY()+1;

LetraPeq($pdf);
$pdf->Cell(30 , $Ln1 , 'Cédula' , $borde1 , 0 , 'L'); 
$pdf->Cell(65 , $Ln1 , 'Nombres' , $borde1 , 0 , 'L'); 
$pdf->Cell(65 , $Ln1 , 'Apellidos' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , ($Ln2+$Ln1)*6+$Ln1*2 , 'Foto Actualizada' , 1 , 0 , 'C',1); 
$pdf->Ln($Ln1);


$fotoNew = '../'.$AnoEscolar.'/'.$CodigoAlumno.'.jpg';
$fotoOld = '../'.$AnoEscolarAnte.'/'.$CodigoAlumno.'.jpg';
if(file_exists($fotoNew)){
	$foto = $fotoNew;}
else{
	$foto = $fotoOld;}

if(file_exists($foto)){           
  //$pdf->Image($foto, 181, $CoorY, 0, ($Ln2+$Ln1)*7-2  );
  }

LetraGde($pdf);
$pdf->Cell(30 , $Ln2 , $Sp.$row_RS_Alumno['CedulaLetra'].'-'.$row_RS_Alumno['Cedula'] , $borde2 , 0 , 'L'); 
$pdf->Cell(65 , $Ln2 , $Sp.$row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'] , $borde2 , 0 , 'L'); 
$pdf->Cell(65 , $Ln2 , $Sp.$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'] , $borde2 , 1 , 'L'); 

//
if($MM_UserGroup == 91 or $Solvente){


LetraPeq($pdf);
$pdf->Cell(30 , $Ln1 , 'Fecha de Nac.' , $borde1 , 0 , 'L'); 
$pdf->Cell(62 , $Ln1 , 'Localidad, Ciudad o Municipio' , $borde1 , 0 , 'L'); 
$pdf->Cell(52 , $Ln1 , 'Entidad o Estado' , $borde1 , 0 , 'L'); 
$pdf->Cell(16 , $Ln1 , 'Sexo' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(30 , $Ln2 , $Sp.DDMMAAAA($row_RS_Alumno['FechaNac']) , $borde2 , 0 , 'L'); 
$pdf->Cell(62 , $Ln2 , $Sp.$row_RS_Alumno['Localidad'] , $borde2 , 0 , 'L'); 
$pdf->Cell(52 , $Ln2 , $Sp.$row_RS_Alumno['Entidad'] , $borde2 , 0 , 'L'); 
$pdf->Cell(16 , $Ln2 , $Sp.$row_RS_Alumno['Sexo'] , $borde2 , 1 , 'L'); 


LetraPeq($pdf);
$pdf->Cell(60 , $Ln1 , 'Clinica Donde Nació' , $borde1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln1 , 'Nacionalidad' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , '' , $borde1 , 1 , 'L'); 


LetraGde($pdf);
$pdf->Cell(60 , $Ln2 , $Sp.$row_RS_Alumno['ClinicaDeNac'] , $borde2 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , $Sp.$row_RS_Alumno['Nacionalidad'] , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , '' , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(20 , $Ln1 , 'Información de contacto' , 0 , 1 , 'L'); 
$pdf->Cell(160 , $Ln1 , 'En caso de emergencia llamar a' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $Sp.$row_RS_Alumno['PerEmergencia'].' ('.$row_RS_Alumno['PerEmerNexo'].') '.$row_RS_Alumno['PerEmerTel'] , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(50 , $Ln1 , 'Teléfono Hab' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln1 , 'Teléfono Cel' , $borde1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln1 , 'Email alumno' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(50 , $Ln2 , $Sp.$row_RS_Alumno['TelHab'] , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2 , $Sp.$row_RS_Alumno['TelCel'] , $borde2 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , $Sp.$row_RS_Alumno['Email1'] , $borde2 , 1 , 'L'); 


LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$Direccion= ucwords(strtolower($row_RS_Alumno['Direccion'].' '.
			$row_RS_Alumno['Urbanizacion'].' '.
			$row_RS_Alumno['Ciudad'].' '.
			$row_RS_Alumno['CodPostal']));
$pdf->Cell(160 , $Ln2, $Direccion , $borde2 ,1, 'L'); 



LetraPeq($pdf);
$pdf->Cell(20 , $Ln1 , 'Información Médica' , 0 , 1 , 'L'); 

$pdf->Cell(20 , $Ln1 , 'Peso' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln1 , 'Vacunas' , $borde1 , 0 , 'L'); 
$pdf->Cell(100 , $Ln1 , 'Enfermedades' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(20 , $Ln2 , $Sp.$row_RS_Alumno['Peso'] , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2 , $Sp.$row_RS_Alumno['Vacunas'] , $borde2 , 0 , 'L'); 
$pdf->Cell(100 , $Ln2 , $Sp.$row_RS_Alumno['Enfermedades'] , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(100 , $Ln1 , 'Alergico a' , $borde1 , 0 , 'L'); 
$pdf->Cell(100 , $Ln1 , 'Tratamiento Médico' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(100 , $Ln2 , $Sp.$row_RS_Alumno['AlergicoA'] , $borde2 , 0 , 'L'); 
$pdf->Cell(100 , $Ln2 , $Sp.$row_RS_Alumno['TratamientoMed'] , $borde2 , 1 , 'L'); 


LetraPeq($pdf);
$pdf->Cell(200 , $Ln1 , 'Colegio de Procedencia (Ciudad)' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(200 , $Ln2 , $row_RS_Alumno['ColegioProcedencia'].' ('.$row_RS_Alumno['CiudadColProc'].')' , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(200 , $Ln1 , 'Observaciones' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(200 , $Ln2 , $row_RS_Alumno['Observaciones'] , $borde2 , 1 , 'L'); 



/// PADRES
$Padres = array('Padre','Madre');
foreach($Padres as $Padre) {
	$i=$i+1;
$CoorY=$pdf->GetY()+1;	
$query_RS_Padre = sprintf("SELECT * FROM Representante WHERE Creador = '%s' AND Nexo = '$Padre'", $MM_Username);

$query_RS_Padre = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Padre'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'";


$RS_Padre = $mysqli->query($query_RS_Padre);//mysql_query($query_RS_Padre, $bd) or die(mysql_error());
$row_RS_Padre = $RS_Padre->fetch_assoc();


LetraTit($pdf);
$pdf->Cell(85 , $Ln2+$Ln1 , 'Datos del '.$Padre , 0 , 0 , 'L'); 
if(strpos('s',"  ".$row_RS_Padre['SWrepre']) >= 0) {
	$Repre = 'SI'; 
    } else $Repre = 'NO';

	$rep_Cedula[$i] 		= $row_RS_Padre['Cedula'];
	$rep_Nombres[$i] 		= T_Tit($Sp.$row_RS_Padre['Nombres']).' '.T_Tit($row_RS_Padre['Apellidos']);
	$rep_EdoCivil[$i] 		= $row_RS_Padre['EdoCivil'];
	$rep_Nacionalidad[$i] 	= $row_RS_Padre['Nacionalidad'];

LetraGde($pdf);
$pdf->Cell(5 , $Ln2+$Ln1 , $row_RS_Padre['CodigoRepresentante'] , 0 , 0 , 'R'); 
LetraTit($pdf);
$pdf->Cell(70 , $Ln2+$Ln1 , 'Representante:  '.$Repre , 0 , 0 , 'R'); 
LetraGde($pdf);
$pdf->Cell(40 , ($Ln2+$Ln1)*7 , 'Foto Actualizada' , 1 , 0 , 'C',1); 
$pdf->Ln($Ln2+$Ln1);

LetraPeq($pdf);
$pdf->Cell(20 , $Ln1 , 'Nexo' , $borde1 , 0 , 'L'); 
$pdf->Cell(25 , $Ln1 , 'Cédula' , $borde1 , 0 , 'L'); 
$pdf->Cell(70 , $Ln1 , 'Nombres y Apellidos' , $borde1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln1 , 'Edo Civil' , $borde1 , 0 , 'L'); 
$pdf->Cell(25 , $Ln1 , 'Nacionalidad' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(20 , $Ln2 , T_Tit($row_RS_Padre['Nexo']) , $borde2 , 0 , 'C'); 
$pdf->Cell(25 , $Ln2 , $row_RS_Padre['Cedula'] , $borde2 , 0 , 'C'); 
$pdf->Cell(70 , $Ln2 , T_Tit($Sp.$row_RS_Padre['Nombres']).', '.T_Tit($row_RS_Padre['Apellidos']) , $borde2 , 0 , 'L'); 
$pdf->Cell(20 , $Ln2 , T_Tit($row_RS_Padre['EdoCivil']) , $borde2 , 0 , 'C'); 
$pdf->Cell(25 , $Ln2 , $Sp. T_Tit($row_RS_Padre['Nacionalidad']) , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(25 , $Ln1 , 'Lugar de Nac.' , $borde1 , 0 , 'L'); 
$pdf->Cell(135 , $Ln1 , 'Teléfonos' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(25 , $Ln2 , T_Tit($row_RS_Padre['LugarNac']) , $borde2 , 0 , 'L'); 
$Telefonos= 'Hab: '.$row_RS_Padre['TelHab'] .
			' Cel: '. $row_RS_Padre['TelCel'].
			' Tr: '.$row_RS_Padre['TelTra'];
$pdf->Cell(135 , $Ln2 , $Sp.$Telefonos , $borde2 , 1 , 'L',true); 

LetraPeq($pdf);
$pdf->Cell(65 , $Ln1 , 'Ocupación / Profesión' , 'TL' , 0 , 'L'); 
$pdf->Cell(95 , $Ln1 , 'Empresa / Actividad Empresa' , 'TR' , 1 , 'R'); 

LetraGde($pdf);
$pdf->Cell(65 , $Ln2 , T_Tit($row_RS_Padre['Ocupacion']) .'/'. T_Tit($row_RS_Padre['Profesion']) , 'BL' , 0 , 'L'); 
$pdf->Cell(95 , $Ln2 , T_Tit($row_RS_Padre['Empresa']) .'/'. T_Tit($row_RS_Padre['ActividadEmpresa']) , 'BR' , 1 , 'R'); 



LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Email' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $row_RS_Padre['Email1'].' '.$row_RS_Padre['Email2'] , $borde2 , 1 , 'L');
 
LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$Direccion= T_Tit($row_RS_Padre['Direccion'].' '.
			$row_RS_Padre['Urbanizacion'].' '.
			$row_RS_Padre['Ciudad'].' '.
			$row_RS_Padre['CodPostal']);
$pdf->Cell(160 , $Ln2, $Sp.$Direccion , $borde2 ,1, 'L'); 

LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección del Trabajo' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $Sp.$row_RS_Padre['DireccionTra'] , $borde2 , 1 , 'L'); 
$CoorY2=$pdf->GetY();
$CoodX =$pdf->GetX();



//$Foto = 'Foto_Repre/'. $row_RS_Alumno['CodigoAlumno']. strtolower(substr($Padre,0,1)) .'.jpg'; 
//if(file_exists($Foto)){           
//  $pdf->Image($Foto, 171, $CoorY, 0, ($Ln2+$Ln1)*7-2 );}
//else{
	$Ruta = Foto($row_RS_Alumno['CodigoAlumno'],strtolower(substr($Padre,0,1)) , 300 , "L");
	if(file_exists($Ruta)){           
	  $pdf->Image($Ruta, 171, $CoorY, 0, ($Ln2+$Ln1)*7-2 );}
//	} 
  
  

  
}// FOR EACH PADRES


$Nexo = 'Autorizado'; 
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'";
$RS_Autorizado = $mysqli->query($query_RS_Rp);
$row_RS_Autorizado = $RS_Autorizado->fetch_assoc();
$totalrow_RS_Autorizado = $RS_Autorizado->num_rows;
						
//$RS_Autorizado = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
//$row_RS_Autorizado = mysql_fetch_assoc($RS_Autorizado);
//$totalrow_RS_Autorizado = mysql_num_rows($RS_Autorizado);

$CoodX = 131;

if($totalrow_RS_Autorizado>0){
	LetraTit($pdf);
	$pdf->Cell(80 , $Ln1+$Ln2 , 'Personas Autorizadas' , 0 , 0 , 'L'); 
	$CoorY=$pdf->GetY()+1;
	$CoodX=$pdf->GetX()+1;
	
	LetraGde($pdf);
	$pdf->Cell(40 , ($Ln2+$Ln1)*6+$Ln1*2 , 'Foto Actualizada' , 1 , 0 , 'C',1); 
	$pdf->Cell(40 , ($Ln2+$Ln1)*6+$Ln1*2 , 'Foto Actualizada' , 1 , 0 , 'C',1); 
	$pdf->Cell(40 , ($Ln2+$Ln1)*6+$Ln1*2 , 'Foto Actualizada' , 1 , 0 , 'C',1); 
	$pdf->Ln($Ln1+$Ln2);
	
	$i=0;
	do{
		$Foto = 'Foto_Repre/'. $row_RS_Alumno['CodigoAlumno'].'a'. ++$i .'.jpg'; 
		if(file_exists($Foto)){    
		  $pdf->Image($Foto, $CoodX, $CoorY, 0, ($Ln2+$Ln1)*7-2 );}
		  $CoodX=$CoodX+40;
		  
		$Aut  = T_Tit($row_RS_Autorizado['Nombres']).' '.T_Tit($row_RS_Autorizado['Apellidos']).'->'.T_Tit($row_RS_Autorizado['Ocupacion']);
		$pdf->Cell(78 , $Ln2+1 , $Sp. $Aut , $borde1 , 1 , 'L'); 
		
		$Aut ='';
		if($row_RS_Autorizado['TelCel']>'')
			$Aut .= ' Cel:'.$row_RS_Autorizado['TelCel'];
		/*if($row_RS_Autorizado['TelTra']>'')
			$Aut .= ' Tr:'.$row_RS_Autorizado['TelTra'];
		if($row_RS_Autorizado['TelHab']>'')
			$Aut .= ' Hab:'.$row_RS_Autorizado['TelHab']; */
		$pdf->Cell(78 , $Ln2 , $Sp. $Aut , $borde2 , 1 , 'R');
	
	} while ($row_RS_Autorizado = $RS_Autorizado->fetch_assoc());
}


if($totalrow_RS_Autorizado>0){
	$pdf->SetY($CoorY+($Ln2+$Ln1)*6+$Ln1*2);}

$abuelos = array('Abuelo Paterno', 'Abuela Paterna', 'Abuelo Materno', 'Abuela Materna');
$pdf->Ln(2);
LetraGdeBlk($pdf);
$pdf->Cell(60 , $Ln1+1 , 'Abuelos: Apellidos y Nombres' , $borde , 0 , 'L',1); 
$pdf->Cell(40 , $Ln1+1 , 'Lugar de Nac.' , $borde , 0 , 'L',1); 
$pdf->Cell(8 , $Ln1+1 , 'Vive' , $borde , 0 , 'C',1); 
$pdf->Cell(92 , $Ln1+1 , 'Firmo como constancia de que los datos aquí' , 0 , 1 , 'C'); 

LetraGde($pdf);
foreach ($abuelos as $abu) {
	$query_RS_Abu = sprintf("SELECT * FROM Abuelos WHERE Creador = '$MM_Username' AND Nexo = '$abu'", $MM_Username);
	$RS_Abu = $mysqli->query($query_RS_Abu);
	$row_RS_Abu = $RS_Abu->fetch_assoc();
	//$Conteo = $RS->num_rows;
	
	
	//$RS_Abu = mysql_query($query_RS_Abu, $bd) or die(mysql_error());
	//$row_RS_Abu = mysql_fetch_assoc($RS_Abu);
	
	$pdf->Cell(60 , $Ln1+1 , T_Tit($row_RS_Abu['Apellidos']).' '.T_Tit($row_RS_Abu['Nombres']) , $borde , 0 , 'L'); 
	$pdf->Cell(40 , $Ln1+1 , T_Tit($row_RS_Abu['LugarDeNacimiento']).' ('.T_Tit($row_RS_Abu['PaisDeNacimiento']).')' , $borde , 0 , 'L'); 
	$pdf->Cell(8 , $Ln1+1 , $row_RS_Abu['Vive'] , $borde , 0 , 'C'); 
	
	if($abu == 'Abuelo Paterno')
	$pdf->Cell(92 , $Ln1+1 , 'suministrados son ciertos' , 0 , 0 , 'C'); 
	
	if($abu == 'Abuela Paterna'){
	$pdf->Cell(2); $pdf->Cell(90 , ($Ln1+1)*3 , '' , 1 , 0 , 'L'); }
	
	$pdf->Ln($Ln1+1);

}

if($row_RS_Curso_al['NivelCurso']>="26")
	require_once('PlanillaInscripcion_ActaCom.php'); 

require_once('PlanillaInscripcion_Contrato.php'); 




// REQUISITOS QUE DEBE TRAER

$pdf->AddPage();

LetraTit($pdf);
$pdf->Cell(200 , 5 , 'Requisitos que debe traer' , 0 , 1 , 'C'); 
LetraGde($pdf);
$pdf->Cell(200 , 5 , '(Traer esta hoja junto con todos los requisitos)' , 0 , 1 , 'C'); 


$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='".$CodigoAlumno."' 
		AND Ano='".$AnoEscolarAnte."' 
		AND Status = 'Inscrito'";
$RS_sql = $mysqli->query($sql);
$row_RS = $RS_sql->fetch_assoc();
	
	
//$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
//$row_RS = mysql_fetch_assoc($RS_sql);

//echo $sql;

if($row_RS['CodigoAlumno']>''){// ALUMNO REINSCRITO
	$pdf->Cell(200 , 5 , 'REINSCRIPCIÓN DE ALUMNOS' , 0 , 1 , 'C'); 
	LetraGde($pdf); 
	$pdf->Cell(200 , 5 , '' , 0 , 1 , 'C'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Planilla de Inscripción firmada por ambos padres.' , 0 , 1 , 'L'); 
	if($row_RS_Curso_al['NivelCurso']>="26"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Acta de Compromiso firmada por el alumno y un Representante.' , 0 , 1 , 'L'); }
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto del alumno ACTUALIZADA. (pegar en la planilla)' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto de padre y madre ACTUALIZADA. (pegar en la planilla)' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto de personas autorizadas ACTUALIZADA. (pegar en la planilla)' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopia de la cédula de identidad del alumno si la obtuvo recientemente.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Depósito en efectivo o transferencia por el monto indicado en circular. (registrar en la página web)' , 0 , 1 , 'L'); 


	}
else{ // ALUMNOS NUEVOS
	$pdf->Cell(200 , 5 , 'ALUMNOS NUEVOS' , 0 , 1 , 'C'); 
	LetraGde($pdf); 
	$pdf->Cell(200 , 5 , 'Requisitos que debe traer junto a la planilla' , 0 , 1 , 'C'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Planilla de Inscripción firmada por ambos padres.' , 0 , 1 , 'L'); 
	
	// a partir de 6to grado
	if($row_RS_Curso_al['NivelCurso']>="26"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Acta de Compromiso firmada por el alumno y un Representante.' , 0 , 1 , 'L'); }
	
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Tres fotos del alumno (pegar una en la planilla).' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto de padre y madre (pegar en la planilla).' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto de personas autorizadas (pegar en la planilla).' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Dos fotocopias de la partida de nacimiento.' , 0 , 1 , 'L'); 
	
	// a partir de 4to grado
	if($row_RS_Curso_al['NivelCurso']>="24"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Dos fotocopias de la cédula de identidad del alumno.' , 0 , 1 , 'L'); }
	
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopias de la cédula de identidad de ambos padres.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopias de la cédula de identidad de personas autorizadas.' , 0 , 1 , 'L'); 
	
	// Hasta 1er grado
	if($row_RS_Curso_al['NivelCurso']<="21"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopia de constancia de vacunas recibidas.' , 0 , 1 , 'L'); }

	// Hasta 4to grado
	if($row_RS_Curso_al['NivelCurso']<="24"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopia fe de bautismo.' , 0 , 1 , 'L'); }
	
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , "Transferencia por Bs.".Fnum($Costo_Reserva_Cupo)." Para formar parte de la inscripción (registrar en la página web)." , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , "Transferencia por Bs.".Fnum($Costo_Cuota_Familia)." Cuota Familiar (registrar en la página web)." , 0 , 1 , 'L'); 
	$pdf->Cell(180 , 5 , '' , 0 , 1 , 'L'); 
	$pdf->Cell(200 , 5 , 'Requisitos que debe traer al finalizar el año escolar actual' , 0 , 1 , 'C'); 
	
	// Hasta 6to grado
	if($row_RS_Curso_al['NivelCurso']<="26"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Fotocopia de la boleta actualizada.' , 0 , 1 , 'L'); }

	// a partir de 1er grado
	if($row_RS_Curso_al['NivelCurso']>="14" and $row_RS_Curso_al['NivelCurso']<="26"){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Certificado de promoción.' , 0 , 1 , 'L'); }
	
	// a partir de 3er grado
	if($row_RS_Curso_al['NivelCurso']>="31" ){
		$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Original y copia de las notas certificadas sellada por la Zona Educativa si no pertenece al Edo Miranda.' , 0 , 1 , 'L'); }
	
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Constancia emitida por el plantel anterior de egreso del SIGEME.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Histórico del sistema SIGEME con la identificación del alumno.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Carta de Buena Conducta.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Solvencia de pago del colegio anterior.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Carta de retiro del colegio anterior.' , 0 , 1 , 'L'); 
	$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Constancia de cédula escolar en caso de no tener Cédula de Identidad.' , 0 , 1 , 'L'); 
	
}	
$pdf->Cell(180 , 5 , '' , 0 , 1 , 'L'); 

LetraTit($pdf);
$pdf->Cell(200 , $Ln2 , 'Nota' , 0 , 1 , 'C'); 

LetraGde($pdf);
$pdf->MultiCell(200, 5 ,"
Alumnos Nuevos: Una vez de ser notificado por el colegio, el tiempo para formalizar la inscripción y consignar los recaudos arriba señalados es de 5 días consecutivos. Luego de esta fecha se liberará el cupo.

Todos: El pago será abonado al nuevo año escolar como inscripción, gastos anexos y mensualidades según los costos que sean pautados para el nuevo año escolar.

",0,'J');




$pdf->SetFont('Arial','B',10);
$pdf->Cell(200 , 5 , 'Transferencias desde cualquier banco' , 0 , 1 , 'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(200 , 5 , 'Banco Provincial' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , 'Cuenta Corriente No: 0108 0013 7801 0000 4268' , 0 , 1 , 'L');

$pdf->Cell(200 , 5 , ' ' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , 'De: Colegio San Francisco de Asís ' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , 'Rif: J-00137023-4 ' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , ' ' , 0 , 1 , 'L');

LetraGde($pdf);

$pdf->MultiCell(200, 5 ,"

Documentos Recibidos por:____________________________________


 ",0,'J');





$pdf->AddPage();
LetraGdeBlk($pdf);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(20);
$pdf->Cell(195 , 8 , 'Acuse de recibo de:' , 0 , 1 , 'C'); 
$pdf->Cell(195 , 8 , 'Planilla de Inscripción y demás recaudos' , 0 , 1 , 'C'); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(195 , 5 , '(Favor entregar junto con la planilla, completando los espacios de/los comprobante(s) de pago)' , 0 , 1 , 'C'); 

$pdf->Ln();
$pdf->SetFont('Arial','',12);

$pdf->Cell(195 , 10 , 'Por medio de la presente se hace constar la recepción de Planilla de Inscripción del alumno:' , 0 , 1 , 'L'); 

$pdf->Cell(195 , 5 , 'Nombres y Apellidos: ' , 0 , 1 , 'C'); 
$pdf->SetFont('Arial','B',14);
$pdf->Cell(195 , 10 , $Sp.$row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].', '.$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].' ('.$row_RS_Alumno['CodigoAlumno'].')' , 1 , 1 , 'C'); 

$pdf->Ln();

$pdf->SetFont('Arial','',12);
$pdf->Cell(195 , 5 , "Solicitando su inscripción para el año escolar $AnoEscolarProx, en el curso: " , 0 , 1 , 'C'); 
$pdf->SetFont('Arial','B',14);
$pdf->Cell(195 , 10 , $row_RS_Curso_al['NombreCompleto'] , 1 , 0 , 'C'); 

$pdf->Ln();
$pdf->SetFont('Arial','',12);

$pdf->Ln();
$pdf->Cell(195 , 8 , 'Junto con comprobante de pago de preinscripción:' , 0 , 1 , 'L'); 

$pdf->Cell(30 , 8 , 'Depósito' , 1 , 0 , 'R'); 
$pdf->Cell(8 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Cell(2 , 8 , '' , 0 , 0 , 'L'); 
$pdf->Cell(30 , 8 , 'Transferencia' , 1 , 0 , 'R'); 
$pdf->Cell(8 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Cell(2 , 8 , '' , 0 , 0 , 'L'); 
$pdf->Cell(30 , 8 , 'Recibo de caja' , 1 , 0 , 'R'); 
$pdf->Cell(8 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Cell(32 , 8 , 'Firma/sello Caja:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Ln();
$pdf->Ln(2);
$pdf->Cell(20 , 8 , 'Banco:' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , 8 , 'Número:' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 8 , '' , 1 , 1 , 'L'); 

$pdf->Cell(20 , 8 , 'Fecha:' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 8 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , 8 , 'Monto:' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 8 , '' , 1 , 1 , 'L'); 



$pdf->Ln();
$pdf->Cell(195 , 8 , "---- v ---- ESPACIO PARA LLENAR PERSONAL DEL COLEGIO ---- v ----" , 0 , 1 , 'C'); 
$pdf->Cell(195 , 8 , "Recibido por:" , 0 , 1 , 'L'); 
$pdf->Cell(50 , 10 , 'Nombre y Apellido:' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 10 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , 10 , 'Fecha:' , 1 , 0 , 'R'); 
$pdf->Cell(50 , 10 , '' , 1 , 1 , 'L'); 

$pdf->Cell(50 , 15 , 'Firma' , 1 , 0 , 'R'); 
$pdf->Cell(80 , 15 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , 15 , 'Sello' , 1 , 0 , 'R'); 
$pdf->Cell(50 , 15, '' , 1 , 1 , 'L'); 
$pdf->Cell(195 , 8 , 'El comprobante de pago legal se emitirá a la brevedad posible.' , 0 , 1 , 'L'); 








}
else
{
	
	
	

if($MM_UserGroup != 91 and !$Solvente){
	$pdf->Ln(80);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(195 , 15 , "Para poder iniciar el proceso de inscripción del nuevo año ".$AnoEscolarProx , 0 , 1 , 'C'); 
	$pdf->Cell(195 , 15 , "en necesario cancelar la totalidad del año escolar actual" , 0 , 1 , 'C'); 
	
	$pdf->Cell(195 , 15 , 'Monto Pendiente '.Fnum($Deuda_Actual).'' , 0 , 1 , 'C');}
}

//$pdf->Ln();





//$pdf->MultiCell(200, 5 ," Por medio de la presente se hace constar la recepción de:",0,'J');



$pdf->SetFont('Arial','',9);





$pdf->Output();

/*
mysql_free_result($RS_Alumnos);

mysql_free_result($RS_Representante);

mysql_free_result($RS_Padre);

mysql_free_result($RS_Madre);

mysql_free_result($RS_Autorizado);

mysql_free_result($RS_AbuelaPaterna);

mysql_free_result($RS_AbueloPaterno);

mysql_free_result($RS_AbueloMaterno);

mysql_free_result($RS_AbuelaMaterna);

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Curso);*/
?>