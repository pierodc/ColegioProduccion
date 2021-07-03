<?php 
$MM_authorizedUsers = "";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once('../inc/fpdf.php'); 


//mysql_select_db($database_bd, $bd);

$colname_RS_Alumno = "1";
if (isset($_GET['CodigoAlumno'])) {
  $colname_RS_Alumno = $_GET['CodigoAlumno'] ;
}

$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoClave = '%s' ", $colname_RS_Alumno);
$RS_Alumno = $mysqli->query($query_RS_Alumno); //
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
//$Conteo = $RS_Alumno->num_rows;


//$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
//$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$MM_Username = $row_RS_Alumno['Creador'];
$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];


extract($row_RS_Alumno);

// Cambia planilla impresa 
//mysql_select_db($database_bd, $bd);
$query = "UPDATE Alumno SET 
			Fecha_Planilla_Impresa = '".date('Y-m-d')."',
			SW_Planilla_Impresa = '1'  
			WHERE CodigoClave = $CodigoAlumno";
$rs = $mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());
// fin Cambia  planilla impresa


/*
$colname_RS_Curso = "0";
if (isset($row_RS_Alumno['CodigoCurso'])) {
  $colname_RS_Curso = (get_magic_quotes_gpc()) ? $row_RS_Alumno['CodigoCursoProxAno'] : addslashes($row_RS_Alumno['CodigoCursoProxAno']);
}
$query_RS_Curso = sprintf("SELECT * FROM Curso WHERE CodigoCurso = %s", $colname_RS_Curso);
$RS_Curso = mysql_query($query_RS_Curso, $bd) or die(mysql_error());
$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
$totalRows_RS_Curso = mysql_num_rows($RS_Curso);
*/

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
		AND Ano='".$AnoEscolarProx."' ";
$RS_sql = $mysqli->query($sql); //
$row_RS = $RS_sql->fetch_assoc();
$totalRows_RS = $RS_sql->num_rows;


//$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
//$row_RS = mysql_fetch_assoc($RS_sql);
//$totalRows_RS = mysql_num_rows($RS_sql);

/*
if($row_RS['Status'] == 'Solicitando'){
  header("Location: PlanillaSolicitaCupo_pdf.php?CodigoAlumno=". $_GET['CodigoAlumno']); 
  exit;
}
*/

//if($AnoEscolar != $AnoEscolarProx ){
$sql_AlumnoXCurso = "SELECT * FROM AlumnoXCurso WHERE 
					CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' AND 
					Ano = '$AnoEscolarProx'
					
					";

$RS_AlumnoXCurso = $mysqli->query($sql_AlumnoXCurso); //
$row_RS_AlumnoXCurso = $RS_AlumnoXCurso->fetch_assoc();


//$RS_AlumnoXCurso = mysql_query($sql_AlumnoXCurso, $bd) or die(mysql_error());
//$row_RS_AlumnoXCurso = mysql_fetch_assoc($RS_AlumnoXCurso);

$sql_Curso_Alum = "SELECT * FROM Curso WHERE 
					CodigoCurso = '".$row_RS_AlumnoXCurso['CodigoCurso']."' ";
$RS_Curso_al = $mysqli->query($sql_Curso_Alum); //
$row_RS_Curso_al = $RS_Curso_al->fetch_assoc();
/*
$RS_Curso_al = mysql_query($sql_Curso_Alum, $bd) or die(mysql_error());
$row_RS_Curso_al = mysql_fetch_assoc($RS_Curso_al);

*/


$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(0,0,200);
$pdf->SetTextColor(0);
$pdf->AddPage();


$borde=1;
$Ln = 4;
$Ln1 = 2.8;
$borde1='TLR';
$Ln2 = 3.3;
$borde2='BLR';

$linea=5;
$Sp='  ';

$pdf->Image('../img/solcolegio.jpg',10,5,0,15);
$pdf->Image('../img/NombreCol.jpg',30,5,0,12);



$pdf->SetFont('Times','B',16);
$pdf->Cell(90); $pdf->Cell(50 , $linea , 'Planilla de Solicitud de Cupo' ,0,1,'C'); 
$pdf->Cell(90); 
$pdf->Cell(50 , $linea , 'Año Escolar '.$AnoEscolarProx ,0,0,'C');

$pdf->Cell(60 , $linea , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] ,0,1,'R'); 

if($row_RS_Alumno['SWInsCondicional']==1){  
	$pdf->SetFont('Times','B',14);
	//$pdf->Cell(0);
	$pdf->Cell(100,$linea, 'Firma Coordinadora: ' ,1,0,'L'); 
	} else {
$pdf->Cell(100);}


$pdf->SetFont('Times','',9);
$pdf->Cell(100,$linea, 'Usuario: '.$MM_Username ,0,1,'R'); 


//            Planilla de 
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
$pdf->Cell(170 , 5 , 'Datos del Alumno' , 0 , 1 , 'L'); 
//$pdf->Ln($Ln2);
$CoorY=$pdf->GetY()+1;

LetraPeq($pdf);
$pdf->Cell(30 , $Ln1 , 'Cédula' , $borde1 , 0 , 'L'); 
$pdf->Cell(65 , $Ln1 , 'Nombres' , $borde1 , 0 , 'L'); 
$pdf->Cell(65 , $Ln1 , 'Apellidos' , $borde1 , 0 , 'L'); 
$H_foto = ($Ln2+$Ln1)*6 + $Ln1*2;
$pdf->Cell(40 , $H_foto , 'Foto' , 1 , 0 , 'C',1); 
$pdf->Ln($Ln1);

$fotoNew = '../'.$AnoEscolar.'/'.$CodigoAlumno.'.jpg';
$fotoOld = '../'.$AnoEscolarAnte.'/'.$CodigoAlumno.'.jpg';
if(file_exists($fotoNew)){
	$foto = $fotoNew;}
else{
	$foto = $fotoOld;}

if(file_exists($foto)){           
  $pdf->Image($foto, 171, $CoorY, 0, ($Ln2+$Ln1)*7-2  );}

LetraGde($pdf);
$pdf->Cell(30 , $Ln2 , $Sp.$row_RS_Alumno['CedulaLetra'].'-'.$row_RS_Alumno['Cedula'] , $borde2 , 0 , 'L'); 
$pdf->Cell(65 , $Ln2 , $Sp.$row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'] , $borde2 , 0 , 'L'); 
$pdf->Cell(65 , $Ln2 , $Sp.$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'] , $borde2 , 1 , 'L'); 




LetraPeq($pdf);
$pdf->Cell(30 , $Ln1 , 'Fecha de Nac.' , $borde1 , 0 , 'L'); 
$pdf->Cell(57 , $Ln1 , 'Localidad, Ciudad o Municipio' , $borde1 , 0 , 'L'); 
$pdf->Cell(57 , $Ln1 , 'Entidad o Estado' , $borde1 , 0 , 'L'); 
$pdf->Cell(16 , $Ln1 , 'Sexo' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(30 , $Ln2 , $Sp.DDMMAAAA($row_RS_Alumno['FechaNac']) .' ('.Edad($row_RS_Alumno['FechaNac']).')' , $borde2 , 0 , 'L'); 
$pdf->Cell(57 , $Ln2 , $Sp.$row_RS_Alumno['Localidad'] , $borde2 , 0 , 'L'); 
$pdf->Cell(57 , $Ln2 , $Sp.$row_RS_Alumno['Entidad'] , $borde2 , 0 , 'L'); 
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



//Hermanos en el colegio
$sql_hnos = "SELECT * FROM AlumnoXCurso, Alumno
				WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
				AND AlumnoXCurso.CodigoAlumno <> '$CodigoAlumno'
				AND Alumno.Creador   = '$MM_Username'
				AND AlumnoXCurso.Ano = '$AnoEscolar' 
				AND AlumnoXCurso.Status = 'Inscrito' 
				";

$RS_sql_hnos = $mysqli->query($sql_hnos); //
$row_RS_hnos = $RS_sql_hnos->fetch_assoc();
$totalRows_RS_hnos = $RS_sql_hnos->num_rows;


/*
$RS_sql_hnos = 	mysql_query($sql_hnos, $bd) or die(mysql_error());
$row_RS_hnos = mysql_fetch_assoc($RS_sql_hnos);
$totalRows_RS_hnos = mysql_num_rows($RS_sql_hnos);*/
$hnos='';
if($totalRows_RS_hnos>0){
	do{
		$hnos .= Curso($row_RS_hnos['CodigoCurso']).' ('.$row_RS_hnos['CodigoAlumno'].') '.$row_RS_hnos['Apellidos'].' '.$row_RS_hnos['Nombres'].' ';
	}while($row_RS_hnos = $RS_sql_hnos->fetch_assoc());
	

	LetraPeq($pdf);
	$pdf->Cell(20 , $Ln1 , '' , 0 , 1 , 'L'); 
	$pdf->Cell(200 , $Ln1 , 'Hermanos en el colegio' , $borde1 , 1 , 'L'); 
	
	LetraGde($pdf);
	$pdf->Cell(200 , $Ln2, $hnos , $borde2 ,1, 'L'); 
}
//Hermanos en el colegio




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
$pdf->Cell(200 , $Ln2 , $row_RS_Alumno['ColegioProcedencia'].' ('.$row_RS_Alumno['CiudadColProc'].') Ret Por:'. $row_RS_Alumno['MotivoRetiroColProced'] , $borde2 , 1 , 'L'); 

LetraPeq($pdf);
$pdf->Cell(200 , $Ln1 , 'Observaciones' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(200 , $Ln2 , $row_RS_Alumno['Observaciones'] , $borde2 , 1 , 'L'); 



/// PADRES
$Padres = array('Padre','Madre');
foreach($Padres as $Padre) {
	$i=$i+1;
$CoorY=$pdf->GetY()+1;

$query_RS_Padre = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Padre'
					AND Representante.Creador = '$MM_Username'";
					
$query_RS_Padre = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Padre'
					AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'";


$RS_Padre = $mysqli->query($query_RS_Padre); //
$row_RS_Padre = $RS_Padre->fetch_assoc();	
	/*
$RS_Padre = mysql_query($query_RS_Padre, $bd) or die(mysql_error());
$row_RS_Padre = mysql_fetch_assoc($RS_Padre);
*/

LetraTit($pdf);
$pdf->Cell(85 , $Ln2+$Ln1 , 'Datos del '.$Padre , 0 , 0 , 'L'); 
if(strpos("s", "  ".$row_RS_Padre["SWrepre"] )>=0) {
	$Repre = 'SI'; 
    } else $Repre = 'NO';

	$rep_Cedula[$i] 		= $row_RS_Padre['Cedula'];
	$rep_Nombres[$i] 		= T_Tit($Sp.$row_RS_Padre['Nombres']).' '.T_Tit($row_RS_Padre['Apellidos']);
	$rep_EdoCivil[$i] 		= $row_RS_Padre['EdoCivil'];
	$rep_Nacionalidad[$i] 	= $row_RS_Padre['Nacionalidad'];


$pdf->Cell(75 , $Ln2+$Ln1 , 'Representante:  '.$Repre , 0 , 0 , 'R'); 
$pdf->Cell(40 , ($Ln2+$Ln1)*7 , 'Foto' , 1 , 0 , 'C',1); 
$pdf->Ln($Ln2+$Ln1);

LetraPeq($pdf);
$pdf->Cell(20 , $Ln1 , 'Nexo' , $borde1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln1 , 'Cédula' , $borde1 , 0 , 'L'); 
$pdf->Cell(70 , $Ln1 , 'Nombres y Apellidos' , $borde1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln1 , 'Edo Civil' , $borde1 , 0 , 'L'); 
$pdf->Cell(30 , $Ln1 , 'Nacionalidad' , $borde1 , 1 , 'L'); 

LetraGde($pdf);
$pdf->Cell(20 , $Ln2 , T_Tit($row_RS_Padre['Nexo']) , $borde2 , 0 , 'C'); 
$pdf->Cell(20 , $Ln2 , $row_RS_Padre['Cedula'] , $borde2 , 0 , 'C'); 
$pdf->Cell(70 , $Ln2 , T_Tit($Sp.$row_RS_Padre['Nombres']).', '.T_Tit($row_RS_Padre['Apellidos']) , $borde2 , 0 , 'L'); 
$pdf->Cell(20 , $Ln2 , T_Tit($row_RS_Padre['EdoCivil']) , $borde2 , 0 , 'C'); 
$pdf->Cell(30 , $Ln2 , $Sp. T_Tit($row_RS_Padre['Nacionalidad']) , $borde2 , 1 , 'L'); 

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
$pdf->Cell(80 , $Ln1 , 'Ocupación / Profesión' , 'TL' , 0 , 'L'); 
$pdf->Cell(80 , $Ln1 , 'Empresa / Actividad Empresa' , 'TR' , 1 , 'R'); 

LetraGde($pdf);
$pdf->Cell(80 , $Ln2 , T_Tit($row_RS_Padre['Ocupacion']) .'/'. T_Tit($row_RS_Padre['Profesion']) , 'BL' , 0 , 'L'); 
$pdf->Cell(80 , $Ln2 , T_Tit($row_RS_Padre['Empresa']) .$row_RS_Padre['TiempoEmpresa'].'/'. T_Tit($row_RS_Padre['ActividadEmpresa']) , 'BR' , 1 , 'R'); 



LetraPeq($pdf);
$pdf->Cell(40 , $Ln1 , '' , $borde1 , 0 , 'L'); 
$pdf->Cell(120 , $Ln1 , 'Email' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(40 , $Ln2 , $row_RS_Padre['CargoEmpresa'].' ('.$row_RS_Padre['Remuneracion'].' )' , $borde2 , 0 , 'L');
$pdf->Cell(120 , $Ln2 , $row_RS_Padre['Email1'].' '.$row_RS_Padre['Email2'] , $borde2 , 1 , 'L');
 
LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$Direccion = T_Tit( $row_RS_Padre['Direccion'].' '.
					$row_RS_Padre['Urbanizacion'].' '.
					$row_RS_Padre['Ciudad'].' '.
					$row_RS_Padre['CodPostal']);
$pdf->Cell(160 , $Ln2, $Sp.$Direccion , $borde2 ,1, 'L'); 

LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección del Trabajo' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $Sp.$row_RS_Padre['DireccionTra'] , $borde2 , 1 , 'L'); 


			
$Nexo = 'Conyuge '.$Padre; 
$query_RS_Rp = "SELECT * FROM RepresentanteXAlumno, Representante 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
					AND RepresentanteXAlumno.Nexo = '$Nexo'
					AND Representante.Creador = '$MM_Username'";
					//echo $query_RS_Rp;
	

$RS_Rp = $mysqli->query($query_RS_Rp); //
$row_RS_Rp = $RS_Rp->fetch_assoc();
$totalRows_RS_Rp = $RS_Rp->num_rows;
	/*
$RS_Rp = mysql_query($query_RS_Rp, $bd) or die(mysql_error());
$row_RS_Rp = mysql_fetch_assoc($RS_Rp);
$totalRows_RS_Rp = mysql_num_rows($RS_Rp);
*/
if ($totalRows_RS_Rp > 0) {
		LetraPeq($pdf);
		$pdf->Cell(160 , $Ln1 , $Nexo , $borde1 , 1 , 'L'); 
		LetraGde($pdf);
		$pdf->Cell(160 , $Ln2 , $Sp.T_Tit($Sp.$row_RS_Rp['Nombres']).', '.T_Tit($row_RS_Rp['Apellidos']) , $borde2 , 1 , 'L'); 
	}


$CoorY2=$pdf->GetY();
$CoodX =$pdf->GetX();
$Foto = 'Foto_Repre/'. $row_RS_Alumno['CodigoAlumno']. strtolower(substr($Padre,0,1)) .'.jpg'; 
if(file_exists($Foto)){           
  $pdf->Image($Foto, 181, $CoorY, 0, ($Ln2+$Ln1)*7-2 );}
 
}// FOR EACH PADRES



$abuelos = array('Abuelo Paterno', 'Abuela Paterna', 'Abuelo Materno', 'Abuela Materna');
$pdf->Ln(2);
LetraGdeBlk($pdf);
$pdf->Cell(60 , $Ln1+1 , 'Abuelos: Apellidos y Nombres' , $borde , 0 , 'L',1); 
$pdf->Cell(40 , $Ln1+1 , 'Lugar de Nac.' , $borde , 0 , 'L',1); 
$pdf->Cell(8 , $Ln1+1 , 'Vive' , $borde , 0 , 'C',1); 
$pdf->Cell(92 , $Ln1+1 , 'Firmo como constancia de que los datos aquí' , 0 , 1 , 'C'); 

LetraGde($pdf);
foreach ($abuelos as $abu) {
$query_RS_Abu = "SELECT * FROM RepresentanteXAlumno, Abuelos 
					WHERE RepresentanteXAlumno.CodigoRepresentante = Abuelos.CodigoAbuelo
					AND RepresentanteXAlumno.Nexo = '$abu'
					AND Abuelos.Creador = '$MM_Username'";

$RS_Abu = $mysqli->query($query_RS_Abu); //
$row_RS_Abu = $RS_Abu->fetch_assoc();	
	/*
$RS_Abu = mysql_query($query_RS_Abu, $bd) or die(mysql_error());
$row_RS_Abu = mysql_fetch_assoc($RS_Abu);
*/
$pdf->Cell(60 , $Ln1+1 , T_Tit($row_RS_Abu['Apellidos']).' '.T_Tit($row_RS_Abu['Nombres']) , $borde , 0 , 'L'); 
$pdf->Cell(40 , $Ln1+1 , T_Tit($row_RS_Abu['LugarDeNacimiento']).' ('.T_Tit($row_RS_Abu['PaisDeNacimiento']).')' , $borde , 0 , 'L'); 
$pdf->Cell(8 , $Ln1+1 , $row_RS_Abu['Vive'] , $borde , 0 , 'C'); 

if($abu == 'Abuelo Paterno')
$pdf->Cell(92 , $Ln1+1 , 'suministrados son ciertos' , 0 , 0 , 'C'); 

if($abu == 'Abuela Paterna'){
$pdf->Cell(2); $pdf->Cell(90 , ($Ln1+1)*3 , '' , 1 , 0 , 'L'); }

$pdf->Ln($Ln1+1);

}


//$pdf->Ln();
$pdf->Ln(3);
LetraTit($pdf);
$pdf->Cell(200 , 5 , 'Para uso del Colegio' , 0 , 1 , 'L'); 
//$pdf->Ln(3);

LetraPeq($pdf);
$pdf->Cell(80 , $Ln1 , 'Entrevistado por:' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'Asistio Padre:' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'Asistio Madre:' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'Fecha:' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(80 , $Ln2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , '' , $borde2 , 0 , 'C'); 
$pdf->Cell(40 , $Ln2 , '' , $borde2 , 0 , 'C'); 
$pdf->Cell(40 , $Ln2 , '/          /' , $borde2 , 1 , 'C'); 

LetraPeq($pdf);
$pdf->Cell(200 , $Ln1 , 'Observaciones:' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(200 , $Ln2*2 , '' , $borde2 , 1 , 'C'); 

/*LetraPeq($pdf);
$Espacio = 200/5;
$pdf->Cell($Espacio , $Ln1 , 'Boletín' , $borde1 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln1 , 'Notas Cert' , $borde1 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln1 , 'Buena Cond' , $borde1 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln1 , 'S Col Ante' , $borde1 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln1 , 'Rec Domicil' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell($Espacio , $Ln2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell($Espacio , $Ln2 , '' , $borde2 , 1 , 'L'); 
*/

LetraPeq($pdf);
$pdf->Cell(66 , $Ln1 , 'Pago Recibido fecha:' , $borde1 , 0 , 'L'); 
$pdf->Cell(66 , $Ln1 , 'Forma:' , $borde1 , 0 , 'L'); 
$pdf->Cell(68 , $Ln1 , 'Recibido por:' , $borde1 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(66 , $Ln2*2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(66 , $Ln2*2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(68 , $Ln2*2 , '' , $borde2 , 1 , 'L'); 




if(false){
$pdf->AddPage();

LetraTit($pdf);
$pdf->Cell(200 , 5 , 'Requisitos que debe traer' , 0 , 1 , 'C'); 

LetraGde($pdf);
$pdf->Cell(200 , 5 , '(Traer esta hoja junto con todos los requisitos)' , 0 , 1 , 'C'); 

LetraTit($pdf);
$pdf->Cell(180 , 5 , 'Preescolar o Primaria:' , 0 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Boletín de Calif. o informes últimos 3: Original:_____  Copia:_____ Grados:_____' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , "Informe de ''Niño Sano'' emitida por el pediatra." , 0 , 1 , 'L'); 
$pdf->Cell(180 , 5 , '' , 0 , 1 , 'L'); 
LetraTit($pdf);
$pdf->Cell(180 , 5 , 'Bachillerato:' , 0 , 1 , 'L'); 
LetraGde($pdf);
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Notas Certificadas: Original:_____  Copia:_____ Grados:_____' , 0 , 1 , 'L'); 
$pdf->Cell(180 , 5 , '' , 0 , 1 , 'L');
LetraTit($pdf);
$pdf->Cell(180 , 5 , 'Todos:' , 0 , 1 , 'L');
LetraGde($pdf); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Cartas: Buena Conducta: Original:________  Copia:________' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Solvencia de pago: (en caso de venir de un colegio privado):__________' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Una foto de ambos padres y del alumno.' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Notas del grado anterior y últimos lapsos curso actual.' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Constancia de trabajo con antiguedad y sueldo ambos padres: Madre:________ Padre:________' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Último recibo de pago: _______ Recibo de Luz:_______ Recibo de Teléfono:_______' , 0 , 1 , 'L'); 
//$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Debe traer cartuchera para presentar una evaluación diagnóstica.' , 0 , 1 , 'L'); 
//$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Cita otorgada para el día:___________________ hora:____________' , 0 , 1 , 'L'); 
$pdf->Cell(5,5,'',1,0); $pdf->Cell(180 , 5 , 'Deposito por Bs.'.Fnum($Costo_Proceso_Sol_Cupo).' en Banco Mercantil por concepto de Gastos Administrativos.' , 0 , 1 , 'L'); 

$pdf->Cell(180 , 5 , '' , 0 , 1 , 'L'); 

LetraTit($pdf);
$pdf->Cell(200 , $Ln2 , 'Instrucciones' , 0 , 1 , 'C'); 

LetraGde($pdf);
$pdf->MultiCell(200, 5 ,"
Debe estar atento a las convocatorias vía email para los proximos pasos a seguir.

",0,'J');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(200 , 5 , 'Banco Mercantil' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , 'Cuenta Corriente No: 0105 0079 6680 7903 7183' , 0 , 1 , 'L');
$pdf->Cell(200 , 5 , 'De: Colegio San Francisco de Asís ' , 0 , 1 , 'L');
LetraGde($pdf);

$pdf->MultiCell(200, 5 ,"(no podemos aceptar transferencias para este proceso, solo depósito) 


Documentos Recibidos por:____________________________________



Una vez que haya superado el proceso de ingreso se le notificará por teléfono, Ud. deberá dentro de los 10 días siguientes de ser notificado formalizar la reserva de cupo, de lo contrario se liberará el mismo.

 ",0,'J');




}


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