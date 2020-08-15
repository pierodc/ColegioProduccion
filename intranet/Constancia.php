<?php 
//$MM_authorizedUsers = "";
//require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('a/archivo/Variables.php'); 
require_once('../inc/rutinas.php'); 

require_once('../inc/fpdf.php'); 

$ConstanciaDe = $_GET['ConstanciaDe'];

$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoClave'])) {
  $colname_RS_Alumno = $_GET['CodigoClave'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoClave = %s", GetSQLValueString($colname_RS_Alumno, "text"));
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
extract($row_RS_Alumno);

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '$CodigoAlumno' 
		AND Ano = '$AnoEscolarAnte'
		AND Status = 'Inscrito'";
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_Ante = mysql_fetch_assoc($RS_);
if($row_Ante)
	$CursoAnte = CursoConstancia($row_Ante['CodigoCurso']);

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '$CodigoAlumno' 
		AND Ano = '$AnoEscolarProx'
		AND (Status = 'Inscrito' OR Status = 'Aceptado')";
//echo $sql;		
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_Prox = mysql_fetch_assoc($RS_);
if($row_Prox)
	$CursoProx = CursoConstancia($row_Prox['CodigoCurso']);

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '$CodigoAlumno' 
		AND Ano = '$AnoEscolar'
		AND Status = 'Inscrito'";
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_Actual = mysql_fetch_assoc($RS_);
if($row_Actual)
	$CursoActual = CursoConstancia($row_Actual['CodigoCurso']);


$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(25, 0 ,20);
$borde=0;
$Ln = 8;

$pdf->Image('../img/solcolegio.jpg', 10, 10, 0, 25);

$pdf->SetFont('Arial','I',14);
$pdf->Ln(1); 
$pdf->Cell(170 , 7.5 , 'Colegio' , $borde , 1 , 'C'); 

$pdf->SetFont('Arial','i',27);
$pdf->Cell(170 , 9 , 'San Francisco de Asís' , $borde , 1 , 'C'); 

$pdf->SetFont('Arial','B',9);
$pdf->Cell(170 , 3.5 , 'Inscrito en el MPPE con el Código No. S0934D1507' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , 'Teléfonos/Fax: (0212) 283.25.75 / 283.62.79 / 284.05.20' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , '7ma. Transversal, entre 4ta y 5ta Ave., Los Palos Grandes' , $borde , 1 , 'C'); 
$pdf->Cell(170 , 3.5 , 'www.ColegioSanFrancisco.com  |  colegio@ColegioSanFrancisco.com' , $borde , 1 , 'C'); 

$pdf->Line( 10 , 43 , 210 , 43);

$pdf->SetY( 50 );


$pdf->SetFont('Times','B',16);
$pdf->Cell(170 , $Ln , 'CONSTANCIA' , $borde , 1 , 'C'); 
$pdf->Ln($Ln);
$pdf->SetFont('Times','',14);

if($Sexo == "F"){
	$ETQ_inscrito = "inscrita";
	$ETQ_Portador = "Portadora";
	$ETQ_elAlumno = "la alumna";
	$ETQ_retirado = "retirada";}
else{
	$ETQ_inscrito = "inscrito";
	$ETQ_Portador = "Portador";
	$ETQ_elAlumno = "el alumno";
	$ETQ_retirado = "retirado";}

$pdf->MultiCell(170 , $Ln , "     Quien suscribe, Lic. Vita María Di Campo C., portadora de la cédula de identidad No.V-6.973.243, en su carácter de Directora del Colegio San Francisco de Asís, por medio de la presente hace constar que $ETQ_elAlumno:" , $borde , 'J'); 
	 
$pdf->Ln($Ln/2);
	 
$Alumno = $Nombres." ".$Nombres2." ".$Apellidos." ".$Apellidos2;
$pdf->SetFont('Times','B',16);
$pdf->Cell(170 , $Ln , $Alumno , $borde , 1 , 'C'); 
$pdf->SetFont('Times','',14);


if($Cedula_int>40000000)
	$pdf->Cell(170 , $Ln , "$ETQ_Portador de la cédula escolar No.".$CedulaLetra.'-'.$Cedula_int , $borde , 1 , 'C'); 
else
	$pdf->Cell(170 , $Ln , "$ETQ_Portador de la cédula de identidad No.".$CedulaLetra.'-'.$Cedula_int , $borde , 1 , 'C'); 

$pdf->Ln($Ln/2);


if($ConstanciaDe == "InscritoActual" and $row_Actual){
	$pdf->Cell(170 , $Ln , "     Está $ETQ_inscrito en este plantel cursando el:" , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoActual , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolar , $borde , 1 , 'C');  $pdf->Ln($Ln/2); }

if($ConstanciaDe == "Inscrito" and $row_Prox){
	$pdf->Cell(170 , $Ln , "     Está $ETQ_inscrito en este plantel para cursar el:" , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoProx , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolarProx , $borde , 1 , 'C');  $pdf->Ln($Ln/2); }

if($ConstanciaDe == "PreInscrito" and $row_Prox){
	$pdf->Cell(170 , $Ln , "     Está pre".$ETQ_inscrito." en este plantel para cursar el:" , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoProx , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolarProx , $borde , 1 , 'C');  $pdf->Ln($Ln/2); }

if($ConstanciaDe == "Estudio" and $row_Actual){
	$pdf->Cell(170 , $Ln , '     Estudia en este plantel cursando el:' , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoActual , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolar , $borde , 1 , 'C');  $pdf->Ln($Ln/2); 
	}

if($ConstanciaDe == "BuenaConducta" and $row_Actual){
	$pdf->Cell(170 , $Ln , '     Estudia en este plantel cursando el:' , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoActual , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolar , $borde , 1 , 'C');  $pdf->Ln($Ln/2); 
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     Presentando en todo momento: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , 'Buena Conducta' , $borde , 1 , 'C');  $pdf->Ln($Ln/2); 
	}

if($ConstanciaDe == "Retiro" and $row_Ante){
	$pdf->Cell(170 , $Ln , '     Estudió en este plantel cursando el:' , $borde ,1, 'J');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $CursoActual , $borde , 1 , 'C');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , '     En el año escolar: ' , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , $AnoEscolar , $borde , 1 , 'C');  $pdf->Ln($Ln/2); 
	$pdf->SetFont('Times','',14);
	$pdf->Cell(170 , $Ln , "     Ha sido $ETQ_retirado por su representante" , $borde , 1 , 'L');  $pdf->Ln($Ln/2);
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(170 , $Ln , 'Voluntariamente' , $borde , 1 , 'C');  $pdf->Ln($Ln/2); 
	}





$pdf->SetFont('Times','',14);
$pdf->MultiCell(170 , $Ln , '     Constancia que se expide a petición de la parte interesada en Caracas, el '. date("d").' de '. Mes(date('m')) .' de '.date("Y").'.' , $borde , 'J'); 
//$pdf->MultiCell(170 , $Ln , '     Sin más que agregar y quedando a su disposición para verificar la presente, se despide' , $borde , 'J'); 
//$pdf->Cell(170 , $Ln , '     Atentamente,' , $borde , 1 , 'L'); 
$pdf->Ln($Ln*3);
$pdf->Cell(170 , $Ln , 'Lic. Vita M. Di Campo C.' , $borde , 1 , 'C'); 
$pdf->Cell(170 , $Ln , 'Directora' , $borde , 1 , 'C'); 


$pdf->SetY(250);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0 , 5 , 'VMDCC / '.$MM_Iniciales ,0,0,'L');


$pdf->Output();


mysql_free_result($RS_Alumno);
?>
