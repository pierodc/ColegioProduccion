<?php 

require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 
require_once('../../archivo/Variables.php'); 

if (isset($_POST['AnoEscolar'])) {


mysql_select_db($database_bd, $bd);
$CodigoCurso = "-1";
if (isset($_POST['CodigoCurso'])) {
  $CodigoCurso = (get_magic_quotes_gpc()) ? $_POST['CodigoCurso'] : addslashes($_POST['CodigoCurso']);
}
if (isset($_POST['AnoEscolar'])) {
  $AnoEscolar = (get_magic_quotes_gpc()) ? $_POST['AnoEscolar'] : addslashes($_POST['AnoEscolar']);
}
mysql_select_db($database_bd, $bd);

if ($_POST['Numero'] > " ") {
	$query_RS_Alumno = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
									WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
									AND AlumnoXCurso.CodigoCurso = '%s' 
									AND AlumnoXCurso.Ano = '%s' 
									AND AlumnoXCurso.Status = 'Inscrito' 
									ORDER BY Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC", $CodigoCurso, $AnoEscolar);
	$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
	$Numero = $_POST['Numero'];
}
elseif($_POST['NumCert'] > " ") {
	
	$CodigoAlumno = $_POST['CodigoAlumno'];
	$query_RS_Alumno = "SELECT * FROM Alumno 
						WHERE CodigoAlumno = '$CodigoAlumno'";
	$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
	$Numero = $_POST['NumCert']*1-1;
}

//echo $query_RS_Alumno;

$pdf=new FPDF('L', 'mm', 'Letter');

$borde=0;
$Ln = 4.6;
do {
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Image('../../../../img/escudonacional-grande.jpeg', 125, 5, 0, 35);
$pdf->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 30);

$Numero = $Numero*1+1;
$Numero = substr('0000000000'.$Numero,-8);

$pdf->Cell(260 , $Ln , 'CEP-'.$Numero , $borde , 1 , 'R'); 


$pdf->SetY( 43 );
$pdf->Cell(260 , $Ln , 'REPÚBLICA BOLIVARIANA DE VENEZUELA' , $borde , 1 , 'C'); 
$pdf->Cell(260 , $Ln , 'MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN' , $borde , 1 , 'C'); 
$pdf->Cell(260 , $Ln , 'Viceministerio de Participación y Apoyo Académico' , $borde , 1 , 'C'); 
$pdf->Cell(260 , $Ln , 'Dirección General de Registro y Control Académico' , $borde , 1 , 'C'); 

$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(22 , $Ln , 'PLANTEL: ' , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(150 , $Ln , 'Unidad Educativa Privada Colegio San Francisco de Asís' , $borde , 1 , 'L'); 

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20 , $Ln , 'CERTIFICADO DE EDUCACIÓN PRIMARIA' , $borde , 0 , 'L'); 

$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->Cell(33 , $Ln , 'que se otorga a: ' , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(97 , $Ln , $row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'] , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','',12);
$pdf->Cell(50 , $Ln , 'Cédula de Identidad No.: ' , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50 , $Ln , $row_RS_Alumno['CedulaLetra'].$row_RS_Alumno['Cedula'] , $borde , 0 , 'L'); 

$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->Cell(22 , $Ln , 'nacido en: ' , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',12);

if($row_RS_Alumno['Entidad'] == "-->>")
	$Entidad = $row_RS_Alumno['LocalidadPais'];
else
	$Entidad = $row_RS_Alumno['Entidad'];
$pdf->Cell(108 , $Ln , $row_RS_Alumno['Localidad'].' - '.$Entidad , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','',12);
$pdf->Cell(8 , $Ln , 'el: ' , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(70 , $Ln , DiaN($row_RS_Alumno['FechaNac']).' de '.Mes(MesN($row_RS_Alumno['FechaNac'])).' de '.AnoN($row_RS_Alumno['FechaNac']) , $borde , 0 , 'L'); 

$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->Cell(200 , $Ln , 'previo el cumplimiento de los requisitos exigidos por la Ley' , $borde , 0 , 'L'); 

$pdf->Ln(15);
$pdf->Cell(125);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100 , $Ln , $Fecha_Cert_Primaria , $borde , 0 , 'L'); 

$pdf->Ln(15);
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100 , $Ln , $Director_Nombre , $borde , 1 , 'C'); 
//$pdf->Cell(100 , $Ln , 'Firma del (la)' , $borde , 1 , 'C'); 
$pdf->Cell(100 , $Ln , 'Directora' , $borde , 0 , 'C'); 
$pdf->Cell(100 , $Ln , 'Docente' , $borde , 1 , 'C'); 
$pdf->Cell(200 , $Ln , 'Sello del Plantel' , $borde , 0 , 'C'); 

$pdf->SetFont('Arial','',12);
$pdf->Cell(30 , $Ln , 'Año Escolar de Egreso: ' , $borde , 0 , 'R'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30 , $Ln , $AnoEscolar , $borde , 0 , 'L'); 


$pdf->Image('../../../../img/LogoME.jpg', 220, 185, 40, 0);
$pdf->SetFont('Arial','',8);
//$pdf->SetY(-15);
//$pdf->Cell(20 , 3 , 'Ministerio del Poder Popular' , $borde , 1 , 'L'); 
//$pdf->Cell(20 , 3 , 'para la Educación' , $borde , 0 , 'L'); 

}  while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); 


$pdf->Output();

}
else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Certificado Primaria</title>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />

</head>

<body><form id="form10" name="form10" method="post" action="">
  <table width="500" border="0" align="center">
<tr>
                  <td colspan="4" class="subtitle">Certificado Primaria:</td>
                </tr>
                <tr>
                  <td align="right" class="NombreCampo">Grado</td>
                  <td class="FondoCampo"><select name="CodigoCurso" id="select">
                    <option value="0">Seleccione...</option>
                    <option value="33">6to Grado A</option>
                    <option value="34">6to Grado B</option>
                  </select></td>
                  <td align="right" class="NombreCampo">Cod Alumno</td>
                  <td class="FondoCampo"><input name="CodigoAlumno" type="text" id="CodigoAlumno" size="15" /></td>
                </tr>
                <tr>
                  <td align="right" class="NombreCampo">No. &uacute;ltimo entregado</td>
                  <td class="FondoCampo"><input name="Numero" type="text" id="Numero" size="15" /></td>
                  <td align="right" class="NombreCampo">Num Cert</td>
                  <td class="FondoCampo"><label for="CodigoAlumno"></label>
                  <input name="NumCert" type="text" id="NumCert" size="15" /></td>
                </tr>
                <tr>
                  <td colspan="2" align="right" class="NombreCampo">A&ntilde;o Escolar</td>
                  <td colspan="2" class="FondoCampo"><input name="AnoEscolar" type="text" id="AnoEscolar" value="<?php echo $AnoEscolar ?>" size="15" /></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td colspan="2"><input type="submit" name="button3" id="button3" value="Generar" /></td>
                </tr>
              </table>
</form>
</body>
</html><?php } ?>