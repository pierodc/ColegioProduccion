<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
//require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

require_once('../../../inc/fpdf.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 5;

$pdf=new FPDF('P', 'mm', 'Legal');
$pdf->AddPage();

$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
$pdf->Image('../../../img/NombreCol.jpg' , 70, 5, 70, 0);

$pdf->SetY( 30 );
$pdf->SetFont('Arial','',12);

if(isset($_GET['Codigo'])){
	$sql = "SELECT * FROM Contrato
			WHERE Codigo = '".$_GET['Codigo']."'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
}

$TextoContrato = $Texto.' ';
$NumEtiquetas = substr_count($TextoContrato,"#");
$Texto_Ini = 0;
for ($i = 1; $i <= $NumEtiquetas; $i++) {
	$Texto_Fin = strpos($TextoContrato,"#",$Texto_Ini);
	$Etiqueta_Ini = strpos($TextoContrato,"#",$Texto_Fin);
	$Etiqueta_Fin = strpos($TextoContrato,"#",$Etiqueta_Ini);
	//$pdf->Write($Ln,$i.substr($TextoContrato,$Texto_Ini,$Texto_Fin-$Texto_Ini));
	$array_TextoContrato[$i] = substr($TextoContrato,$Texto_Ini,$Texto_Fin-$Texto_Ini);
	$Texto_Ini = $Etiqueta_Fin+1;
}

//$pdf->Write($Ln,$i.substr($TextoContrato,$Texto_Ini,$Texto_Fin-$Texto_Ini));
$array_TextoContrato[$i] = substr($TextoContrato,$Texto_Ini , $Texto_Fin-$Texto_Ini);




$sql = "SELECT * FROM Empleado
		WHERE CodigoEmpleado = '".$_GET['CodigoEmpleado']."'";

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);

$array_TextoContrato["Nombre"] = $Nombres.' '.$Nombre2.' '.$Apellidos.' '.$Apellido2;
$array_TextoContrato["Cedula"] = $CedulaLetra.'-'.$Cedula;

$SueldoBase = $SueldoBase * 2;
$array_TextoContrato["SueldoMonto"] = Fnum($SueldoBase);
$array_TextoContrato["SueldoLetras"] = Fnum_Letras($SueldoBase);
$array_TextoContrato["AnoEscolar"] = $AnoEscolar;
$array_TextoContrato["Fecha_Fin_Ano_Escolar"] = $Fecha_Fin_Ano_Escolar;
$array_TextoContrato["FechaIngreso"] = DDMMAAAA($FechaIngreso);
$array_TextoContrato["Funciones"] = $Funciones;
$array_TextoContrato["HorarioTrab"] = $HorarioTrab;

$DiasTrabajando = dateDif(date('Y-m-d'),$FechaIngreso);

if($DiasTrabajando < 365)
	$FechaEgreso = $Fecha_Fin_Ano_Escolar;

if($FechaEgreso > '1950-01-01')
	$array_TextoContrato["FechaEgreso"] = " hasta el día ".DDMMAAAA($FechaEgreso);
else
	$array_TextoContrato["FechaEgreso"] = " por tiempo indeterminado ";


//$HrSem = $HrAcad + $HrAdmi;
$array_TextoContrato["HrAcad"] = $HrAcad;
$array_TextoContrato["HrAdmi"] = $HrAdmi;
$array_TextoContrato["Asignaturas"] = $Asignaturas;

$FechaContrato = "2014-09-16";
if($FechaIngreso > $FechaContrato){
	$FechaContrato = $FechaIngreso;
	}
$FechaContrato = DiaN($FechaContrato).' días del mes de '.Mes(MesN($FechaContrato)).' del año '.AnoN($FechaContrato);
$array_TextoContrato["FechaContrato"] = $FechaContrato;


/*
$Texto = str_replace("#Nombre#",$Nombres.' '.$Nombre2.' '.$Apellidos.' '.$Apellido2,$Texto);
$Texto = str_replace("#Cedula#",$CedulaLetra.'-'.$Cedula,$Texto);
$SueldoBase = $SueldoBase * 2;
$Texto = str_replace("#SueldoMonto#",Fnum($SueldoBase),$Texto);
$Texto = str_replace("#SueldoLetras#",Fnum_Letras($SueldoBase),$Texto);
$Texto = str_replace("#AnoEscolar#",$AnoEscolar,$Texto);
$Texto = str_replace("#Fecha_Fin_Ano_Escolar#",$Fecha_Fin_Ano_Escolar,$Texto);
$Texto = str_replace("#FechaIngreso#",DDMMAAAA($FechaIngreso),$Texto);
$Texto = str_replace("#HrSem#",$HrSem,$Texto);
$Texto = str_replace("#Asignaturas#",$Asignaturas,$Texto);

$FechaContrato = "2014-09-16";
if($FechaIngreso > $FechaContrato){
	$FechaContrato = $FechaIngreso;
	}

$FechaContrato = DiaN($FechaContrato).' del mes de '.Mes(MesN($FechaContrato)).' del año '.AnoN($FechaContrato);
$Texto = str_replace("#FechaContrato#",$FechaContrato,$Texto);
$pdf->MultiCell(190 , $Ln , $Texto , $borde , 'J'); 
*/


for ($i = 1; $i <= $NumEtiquetas; $i++) {
	$pdf->SetFont('Arial','',12);
	$pdf->Write($Ln,$array_TextoContrato[$i]);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write($Ln,$array_TextoContrato[$array_TextoContrato[$i+1]]);
	$i++;
}
$pdf->SetFont('Arial','',12);
$pdf->Write($Ln,$array_TextoContrato[$i]);
$pdf->SetFont('Arial','B',12);
$pdf->Write($Ln,$array_TextoContrato[$array_TextoContrato[$i+1]]);

$pdf->Ln(25);
$Firman = explode(",",$Firman);

foreach($Firman as $Firma){
	$pdf->Cell(90 , $Ln , $Firma , "T", 0 , 'C'); 
	$pdf->Cell(10);
	}



$pdf->Output();
?>