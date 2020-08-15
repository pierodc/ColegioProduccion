<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

if (isset($_GET['CodigoEmpleado'])) {
  $colname_RS_Empleados = 'AND CodigoEmpleado = '.$_GET['CodigoEmpleado'];
}
$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activo = '1' $colname_RS_Empleados ORDER BY Apellidos, Nombres ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$borde=1;
$Ln = 8;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
$pdf->AddPage();
$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 30 );
$borde = 1;
//$Ln = 4.25;
$Ln1 = 3;
$borde1='TLR';
$Ln2 = 4.5;
$borde2='BLR';
$Sp='  ';



do { 

if($No==4){
	$pdf->AddPage();
	$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
	$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
	$pdf->SetY( 30 );
	$No=0;
}
extract($row_RS_Empleados);
  
$foto = '../../../FotoEmp/'.$CodigoEmpleado.'.jpg';
if(file_exists($foto)){           
  $pdf->Image($foto, 175, 32+($No*57.5), 25, 0 );}

/*LetraPeq($pdf);
$pdf->Cell(80 , $Ln1 , 'Apellidos' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln1 , 'Nombres' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);*/
LetraTit($pdf);
$pdf->Cell(70 , $Ln2+$Ln1 , $Sp.$Apellidos , 0 , 0 , 'L'); 
$pdf->Cell(70 , $Ln2+$Ln1 , $Sp.$Nombres , 0 , 0 , 'L'); 
LetraGde($pdf);
$pdf->Cell(20 , $Ln2+$Ln1 , $CodigoEmpleado , 0 , 0 , 'R'); 
$pdf->Ln($Ln2+$Ln1);

LetraPeq($pdf);
$pdf->Cell(40 , $Ln1 , 'Cedula' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'FechaNac' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'FechaIngreso' , $borde1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln1 , 'Sexo' , $borde1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln1 , 'EdoCivil' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(40 , $Ln2 , $CedulaLetra.'-'.$Cedula , $borde2 , 0 , 'C'); 
$pdf->Cell(40 , $Ln2 , DDMMAAAA($FechaNac) , $borde2 , 0 , 'C'); 
$pdf->Cell(40 , $Ln2 , DDMMAAAA($FechaIngreso) , $borde2 , 0 , 'C'); 
$pdf->Cell(20 , $Ln2 , $Sexo , $borde2 , 0 , 'C'); 
$pdf->Cell(20 , $Ln2 , $EdoCivil , $borde2 , 0 , 'C'); 
$pdf->Ln($Ln2);

LetraPeq($pdf);
$pdf->Cell(100 , $Ln1 , 'Email' , $borde1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln1 , 'NumCuenta' , $borde1 , 0 , 'C'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(100 , $Ln2 , $Email , $borde2 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , $NumCuentaA.' '.$NumCuenta , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);

LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Dirección' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $Dir1.' / '.$Dir2 , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);
$pdf->Cell(160 , $Ln2 , $Dir3.' '.$Dir4 , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);


LetraPeq($pdf);
$pdf->Cell(40 , $Ln1 , 'Telefono Hab.' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'Telefono Cel.' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'Telefono Otro' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'BB PIN' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(40 , $Ln2 , $TelefonoHab , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , $TelefonoCel , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , $TelefonoOtro , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , ' ' , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);


LetraPeq($pdf);
$pdf->Cell(160 , $Ln1 , 'Titulo' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(160 , $Ln2 , $Titulo , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);

LetraPeq($pdf);
$pdf->Cell(40 , $Ln1 , 'TipoEmpleado' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'TipoDocente' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'CargoLargo' , $borde1 , 0 , 'L'); 
$pdf->Cell(40 , $Ln1 , 'CargoCorto' , $borde1 , 0 , 'L'); 
$pdf->Ln($Ln1);
LetraGde($pdf);
$pdf->Cell(40 , $Ln2 , $TipoEmpleado , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , $TipoDocente , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , $CargoLargo , $borde2 , 0 , 'L'); 
$pdf->Cell(40 , $Ln2 , $CargoCorto , $borde2 , 0 , 'L'); 
$pdf->Ln($Ln2);




  $No++;
  $j++;
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados) and $j<100);  






$pdf->Output();


?>