<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);

if (isset($_GET['CodigoAlumno']))  
	$query_RS_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' ";
else{
	if($_GET['Revision']=='1')		
		$Fecha_Aux = "Julio20".$Ano2."R";
	else
		$Fecha_Aux = "Julio20".$Ano2;

	//$Fecha_Aux ='';

	$query_RS_Alumno = sprintf("SELECT * FROM AlumnoXCurso, Alumno 
								WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
								AND AlumnoXCurso.Ano = '%s' 
								AND AlumnoXCurso.Status = 'Inscrito'  
								AND (AlumnoXCurso.CodigoCurso = '43' OR AlumnoXCurso.CodigoCurso = '44') 
								ORDER BY AlumnoXCurso.CodigoCurso, Alumno.Apellidos, Alumno.Apellidos2",   $AnoEscolar );
								
								
								
								// AlumnoXCurso.CodigoCurso ASC, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC
								
								
	/*
								AND AlumnoXCurso.FechaGrado = '$Fecha_Aux' 
	$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Alumno 
						WHERE AlumnoXCurso.FechaGrado = '$Fecha_Aux' 
						AND AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
						AND AlumnoXCurso.Tipo_Inscripcion = 'Rg' 
						ORDER BY AlumnoXCurso.CodigoCurso, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC";
	
	echo $query_RS_Alumno;	
	*/
								
								
								
							
								}

								
//echo $query_RS_Alumno;								
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);

//echo $query_RS_Alumno;

$pdf=new FPDF('L', 'mm', 'Letter');

$borde = 0;
$Ln = 5.00;
function Titulo_($texto){ 
return mb_strtoupper($texto, 'iso-8859-1' );
//return $texto;
}


do {

$pdf->AddPage();

$x = $Titulo_x;
$pdf->SetY( $Titulo_y ); //65 



$pdf->SetFont('Helvetica','B',12);

$pdf->Cell(60+$x); $pdf->Cell(150 , $Ln , Titulo_('Unidad Educativa Privada Colegio San Francisco de Asís') , $borde , 1 , 'L'); 
$pdf->Cell(24+$x); $pdf->Cell(164 , $Ln , 'S0934D1507' , $borde , 1 , 'L'); 
$pdf->Cell(28+$x); $pdf->Cell(20 , $Ln , $Titulo_Bach , $borde , 1 , 'L'); 
$pdf->Cell(70+$x); $pdf->Cell(150 , $Ln , '31059' , $borde , 1 , 'L'); 

$Alumno = 	$row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.
			$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'];
			
$pdf->Cell(43+$x); $pdf->Cell(97 , $Ln , Titulo_($Alumno ) , $borde , 1 , 'L'); 

//$pdf->Cell(65+$x); $pdf->Cell(50 , $Ln , 'P-'.$row_RS_Alumno['Cedula'] , $borde , 1 , 'L'); 
$pdf->Cell(65+$x); $pdf->Cell(50 , $Ln , $row_RS_Alumno['CedulaLetra'].''.$row_RS_Alumno['Cedula'] , $borde , 1 , 'L'); 

$NacidoEn = "";

if($row_RS_Alumno['EntidadCorta']=='Ex')
	$NacidoEn .= " ".$row_RS_Alumno['LocalidadPais'];
else
	$NacidoEn .= " ".$row_RS_Alumno['Entidad'];

//$NacidoEn = str_replace("ESTADO","",$NacidoEn);

$NacidoEn .= ' ' . $row_RS_Alumno['Localidad'];
$NacidoEn = str_replace("Estado ","",$NacidoEn);
$pdf->Cell(38+$x); $pdf->Cell(110 , $Ln , Titulo_($NacidoEn) , $borde , 1 , 'L'); 

$FechaNac =  DiaN($row_RS_Alumno['FechaNac']).' de '.Mes(MesN($row_RS_Alumno['FechaNac'])).' de '.AnoN($row_RS_Alumno['FechaNac']);
$pdf->Cell(28+$x); $pdf->Cell(70 , $Ln , Titulo_($FechaNac) , $borde , 1 , 'L'); 

$pdf->Cell(100 , $Ln , '' , $borde , 1 , 'L'); 

if($_GET['Revision']=='1')  $FechaGrado = $Fecha_Tit_Bach_Revision; else $FechaGrado = $Fecha_Tit_Bach;

//$pdf->Cell(70+$x); $pdf->Cell(100 , $Ln , Titulo_('Chacao, '.$DiaGrado.' de Julio de '.date('Y')) , $borde , 1 , 'L'); 
$pdf->Cell(70+$x); $pdf->Cell(100 , $Ln , $FechaGrado , $borde , 1 , 'L'); 

//$pdf->Cell(40+$x); $pdf->Cell(100 , $Ln , '2012' , $borde , 1 , 'L'); 
$pdf->Cell(40+$x); $pdf->Cell(100 , $Ln , substr($Fecha_Tit_Bach,-4) , $borde , 1 , 'L'); 

$pdf->Ln($Ln*4.2);
$pdf->Cell(21+$x); $pdf->Cell(80 , $Ln , $Director_Nombre , $borde , 1 , 'L'); 

$pdf->Cell(13+$x); 
$pdf->Cell(82 , $Ln , $Director_CI , $borde , 0 , 'L'); 
$pdf->Cell(89 , $Ln , $Prof_Revisor_Nombre , $borde , 0 , 'L'); 
$pdf->Cell(94 , $Ln , $Supervisor_Nombre , $borde , 1 , 'L'); 

$pdf->Cell(88+$x); 
$pdf->Cell(90 , $Ln , $Prof_Revisor_CI , $borde , 0 , 'L'); 
$pdf->Cell(95 , $Ln , $Supervisor_CI , $borde , 1 , 'L'); 


}  while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); 


$pdf->Output();


?>