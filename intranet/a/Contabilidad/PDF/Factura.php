<?
$MM_authorizedUsers = "99,91";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');


//P_IVA_1
if ($Facturacion_Activa or $MM_Username == 'piero'){


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$borde = 0;
$Ln = 4.25;

$Pag = array('Original','Copia');

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();


// Busca ALUMNO
$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
					WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
					AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
					AND (AlumnoXCurso.Ano = '$AnoEscolar' OR AlumnoXCurso.Ano = '$AnoEscolarProx' )
					AND Alumno.CodigoClave = '".$_GET['CodigoClave']."'
					ORDER BY  AlumnoXCurso.Ano DESC ";
					
$query_RS_Alumno = "SELECT * FROM Alumno 
					WHERE CodigoClave = '".$_GET['CodigoClave']."' ";
$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
//echo $query_RS_Alumno;
extract($row_RS_Alumno);

// Busca RECIBO (seniat O no formal)
$Codigo_Recibo = "-1";
if (isset($_GET['Codigo'])) {
  $Codigo_Recibo = $_GET['Codigo'];
}
$query_RS_Recibo = sprintf("SELECT * FROM Recibo WHERE CodigoRecibo = %s", GetSQLValueString($Codigo_Recibo, "int"));
$RS_Recibo =  $mysqli->query($query_RS_Recibo);
$row_RS_Recibo = $RS_Recibo->fetch_assoc();

// Busca los CARGOS
$query_RS_Mov_Contable_debe = "SELECT * FROM ContableMov 
								WHERE CodigoPropietario = $CodigoAlumno 
								AND (MontoDebe > 0 OR MontoDebe_Dolares > 0 ) 
								AND CodigoRecibo = ".$_GET['Codigo']." 
								ORDER BY CodigoRecibo ASC, Fecha ASC, Codigo ASC"; 
$RS_Mov_Contable_debe =  $mysqli->query($query_RS_Mov_Contable_debe);


// Busca el PAGO
$query_RS_Mov_Contable_haber = "SELECT * FROM ContableMov, ContableCuenta 
								WHERE ContableMov.CodigoCuenta = ContableCuenta.CodigoCuenta 
								AND CodigoPropietario = $CodigoAlumno 
								AND (MontoHaber > 0 OR MontoHaber_Dolares > 0)
								AND CodigoRecibo = ".$_GET['Codigo'];
$RS_Mov_Contable_haber =  $mysqli->query($query_RS_Mov_Contable_haber);
$row_RS_Mov_Contable_haber = $RS_Mov_Contable_haber->fetch_assoc();

$Cambio_Dolar = $row_RS_Mov_Contable_haber['Cambio_Dolar'];

// DATOS CLIENTE	
if($row_RS_Mov_Contable_haber['CodigoReciboCliente'] > 0){
	$sql = "SELECT * FROM ReciboCliente
			WHERE Codigo = ".$row_RS_Mov_Contable_haber['CodigoReciboCliente'];
	//echo $sql;		
	$RS =  $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	$Fac_Rif = str_replace("'","",$row['RIF']);
	$Fac_Nombre = str_replace("'","",T_Tit($row['Nombre']));
	$Fac_Direccion = str_replace("'","",T_Tit(substr($row['Direccion'],0,40)));
	$Fac_Telefono = str_replace("'","",$row['Telefono']);
	}

	
	
$SW_Actualiza_Base = false;

	
	
// Registra datos del cliente en RECIBOS	
if($row_RS_Recibo['NumeroFactura'] == 0){
	//Busca Num Max de Factura
	$sql = "SELECT MAX(NumeroFactura) AS NumFacMax FROM Recibo";
	$query =  $mysqli->query($sql);
	$row_query = $query->fetch_assoc();
	$NumeroFacturaProx = $row_query['NumFacMax']+1;
	
	$sql = "SELECT MAX(Fac_Num_Control) AS NumControlMax FROM Recibo";
	$query =  $mysqli->query($sql);
	$row_query = $query->fetch_assoc();
	$NumeroControlProx = $row_query['NumControlMax']+1;
	
	$sql = "UPDATE Recibo SET 
			NumeroFactura = $NumeroFacturaProx, 
			Fac_Num_Control = $NumeroControlProx, 
			FechaImpFactura = NOW(), 
			Fecha = NOW(), 
			FacturaImpPor = '".$MM_Username."', 
			Fac_Rif = '$Fac_Rif', 
			Fac_Nombre = '$Fac_Nombre', 
			Fac_Direccion = '$Fac_Direccion', 
			Fac_Telefono = '$Fac_Telefono' 
			WHERE CodigoRecibo = $Codigo_Recibo";
	
	$query =  $mysqli->query($sql);
	$SW_Actualiza_Base = true;
	
	$sql_Factura_Control = "UPDATE Factura_Control 
							SET Factura_Numero = '$NumeroFacturaProx' , 
							RegistroPor = '$MM_Username', 
							FechaRegistro = NOW()
							WHERE Control_Numero = '$NumeroControlProx'";
	$mysqli->query($sql_Factura_Control);
	
	
	$RS_Recibo =  $mysqli->query($query_RS_Recibo);
	$row_RS_Recibo = $RS_Recibo->fetch_assoc();
}

$NumeroFactura = $row_RS_Recibo['NumeroFactura'];


 
$total=0;
	
// Llena Matriz factura	
while ($row_RS_Mov_Contable_debe = $RS_Mov_Contable_debe->fetch_assoc()) { 
	$Num_Renglones++;
	
	$Renglon[$Num_Renglones]['Descripcion'] = $row_RS_Mov_Contable_debe['Descripcion']; 
	$Renglon[$Num_Renglones]['ReferenciaMesAno'] = Mes_Ano ($row_RS_Mov_Contable_debe['ReferenciaMesAno']);  
	
	if($row_RS_Mov_Contable_debe['SWiva'] > 0)
		$Renglon[$Num_Renglones]['P_IVA'] = $P_IVA_1;
	else
		$Renglon[$Num_Renglones]['P_IVA'] = 0;	
	
	
	
	if($Renglon[$Num_Renglones]['P_IVA'] > 0){
	
		if($row_RS_Mov_Contable_debe['MontoAbono_Dolares'] > 0)
			$Abonos = ($row_RS_Mov_Contable_debe['MontoAbono_Dolares'] * $Cambio_Dolar ) / (1+($Renglon[$Num_Renglones]['P_IVA']/100));
		else
			$Abonos = $row_RS_Mov_Contable_debe['MontoAbono'] / (1+($Renglon[$Num_Renglones]['P_IVA']/100));
	
	}
	else{
		
		
		if($row_RS_Mov_Contable_debe['MontoAbono_Dolares'] > 0)
			$Abonos = $row_RS_Mov_Contable_debe['MontoAbono_Dolares'] * $Cambio_Dolar ;
		else
			$Abonos = $row_RS_Mov_Contable_debe['MontoAbono'];
	}
		
		
	if($row_RS_Mov_Contable_debe['MontoAbono_Dolares'] > 0)
		$Abonos = $row_RS_Mov_Contable_debe['MontoAbono_Dolares'] * $Cambio_Dolar ;
	else
		$Abonos = $row_RS_Mov_Contable_debe['MontoAbono'];
	
	
	if($row_RS_Mov_Contable_debe['MontoDebe_Dolares'] > 0)
		$Renglon_MontoNeto = round(($row_RS_Mov_Contable_debe['MontoDebe_Dolares'] * $Cambio_Dolar) - $Abonos , 2);
	else
		$Renglon_MontoNeto = round($row_RS_Mov_Contable_debe['MontoDebe'] - $Abonos , 2);
	
	
	$Renglon[$Num_Renglones]['Monto'] =  $Renglon_MontoNeto; 
	
	if($row_RS_Mov_Contable_debe['SWiva'] > 0){	
		$P_IVA_Factura = $P_IVA_1;
		$Factura_Total_MontoBaseImponible +=  $Renglon_MontoNeto; }
	else
		$Factura_Total_MontoBaseExcenta +=  $Renglon_MontoNeto; 

}
 

	
	
	
	
	
	
	
$NombreAlumno = T_Tit($row_RS_Alumno['Apellidos']." ".substr($row_RS_Alumno['Apellidos2'],0,1).", ".$row_RS_Alumno['Nombres']." ".substr($row_RS_Alumno['Nombres2'],0,1)); 
$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'] ;
	

$sql = "SELECT * FROM AlumnoXCurso
		WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."'
		AND (Ano = '$AnoEscolar' or Ano = '$AnoEscolarProx')
		ORDER BY Ano";
//echo $sql;
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();

$CursoAlumno  = Curso($row['CodigoCurso']); 




// IMPRIMIR

$Espacio_EntrePag = 140;

foreach ($Pag as $Pagina){
	$pdf->SetY( 30 + $No * $Espacio_EntrePag);
	

	$pdf->SetFont('Arial','',10);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20 , $Ln , 'Cliente:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(65 , $Ln , $Fac_Nombre , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20 , $Ln , 'Dirección:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(65 , $Ln , $Fac_Direccion , $borde , 0 , 'L'); 
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15 , $Ln , 'Fecha:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25 , $Ln , date('d-m-Y') , $borde , 0 , 'L'); 

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22 , $Ln , 'Factura No:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(35 , $Ln , $NumeroFactura , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20 , $Ln , 'Rif:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(25 , $Ln , $Fac_Rif , $borde , 0 , 'L'); 
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10 , $Ln , 'Tlf:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30 , $Ln , $Fac_Telefono , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);
	$pos_y = $pdf->GetY();
	
	
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20 , $Ln , 'Alumno:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(65 , $Ln , "$NombreAlumno ($CodigoAlumno)" , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);
	$Pos_x_FormaPago = $pdf->GetX();
	$Pos_y_FormaPago = $pdf->GetY();
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20 , $Ln , 'Curso:' , $borde , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(65 , $Ln , $CursoAlumno , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->SetY($pos_y);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(95);	
	$pdf->Cell(60 , $Ln , "Concepto" , $borde , 0 , 'L'); 
	$pdf->Cell(20 , $Ln , 'Mes' , $borde , 0 , 'C'); 
	$pdf->Cell(10 , $Ln , 'iva' , $borde , 0 , 'C'); 
	$pdf->Cell(20 , $Ln , 'Monto' , $borde , 0 , 'R'); 
	$pdf->Ln($Ln);
	
	if($Num_Renglones <= 10){
		$pdf->SetFont('Arial','',10);
		$LnRenglon = $Ln; }
	else{
		$pdf->SetFont('Arial','',7.5);
		$LnRenglon = $Ln*.7; }
	
	for ($i = 1; $i <= $Num_Renglones; $i++) {
		$pdf->SetX(95);
		
		if(strlen($Renglon[$i]['Descripcion']) > 35 ){
			$pdf->SetFont('Arial','',7.5);
			}
		
		$pdf->Cell(60 , $LnRenglon , $Renglon[$i]['Descripcion'] , $borde , 0 , 'L'); 
		
		if($Num_Renglones <= 10){
				$pdf->SetFont('Arial','',10);
				$LnRenglon = $Ln; }
			else{
				$pdf->SetFont('Arial','',7.5);
				$LnRenglon = $Ln*.7; }

		$pdf->Cell(20 , $LnRenglon , $Renglon[$i]['ReferenciaMesAno'] , $borde , 0 , 'C'); 
		$pdf->Cell(10 , $LnRenglon , Reconv( $Renglon[$i]['P_IVA'] ) , $borde , 0 , 'C'); 
		$pdf->Cell(20 , $LnRenglon , Format( Reconv( $Renglon[$i]['Monto'])) , $borde , 0 , 'R'); 		
		$pdf->Ln();
	} 
	 
	$Factura_Total_IVA = Reconv (round($Factura_Total_MontoBaseImponible * $P_IVA_Factura/100 , 2)); 
	$Factura_Total = Reconv (round($Factura_Total_IVA + $Factura_Total_MontoBaseImponible + $Factura_Total_MontoBaseExcenta , 2)); 
	$Factura_SubTotal = Reconv (round($Factura_Total_MontoBaseImponible + $Factura_Total_MontoBaseExcenta , 2)); 
	$Factura_Total_MontoBaseImponible = Reconv ($Factura_Total_MontoBaseImponible);
	$Factura_Total_MontoBaseExcenta = Reconv ($Factura_Total_MontoBaseExcenta);
	
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(95);	
	$pdf->Cell(35 , $Ln , "Base Exenta " , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , Format($Factura_Total_MontoBaseExcenta) , $borde , 0 , 'R'); 
	
	$pdf->Cell(35 , $Ln , "SubTotal " , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , Format($Factura_SubTotal) , $borde , 0 , 'R'); 
	$pdf->Ln($Ln);

	
	$pdf->SetX(95);	
	$pdf->Cell(35 , $Ln , "Base Imponible " , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , Format($Factura_Total_MontoBaseImponible) , $borde , 0 , 'R'); 
	
	$pdf->Cell(35 , $Ln , "IVA ".$P_IVA_Factura."% " , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , Format($Factura_Total_IVA) , $borde , 0 , 'R'); 
	$pdf->Ln($Ln);
	
	
	$pdf->SetX(95);	
	$pdf->Cell(90 , $Ln , "Total Factura " , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , Format($Factura_Total) , $borde , 0 , 'R'); 
	
	$pdf->SetXY(20 ,  $No * $Espacio_EntrePag + 115 );
	$pdf->Cell(60 , $Ln , "Firma " , 'T' , 0 , 'C'); 
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(125 , $Ln , "$Codigo_Recibo ".date('d-m-Y h:i a')." $MM_Username" , '' , 0 , 'R'); 
	$pdf->SetFont('Arial','',10);


	// FORMA DE PAGO
	$pdf->SetXY($Pos_x_FormaPago ,  $Pos_y_FormaPago+5 );
	$pdf->Ln($Ln);
	$pdf->Cell(30 , $Ln , "Forma de Pago:" , $borde , 0 , 'R'); 
	$pdf->Cell(20 , $Ln , "CONTADO" , $borde , 0 , 'R'); 
	$pdf->Ln($Ln);

	 //do { 
	
		 if ($row_RS_Mov_Contable_haber['Tipo']==1 or $row_RS_Mov_Contable_haber['Tipo']==2){ // Deposit Transferencia
			
			if($row_RS_Mov_Contable_haber['Tipo'] == 1)
				$FormaPago = "Deposito";
			if($row_RS_Mov_Contable_haber['Tipo'] == 2)
				$FormaPago = "Transferencia";
			
			if( $row_RS_Mov_Contable_haber['CodigoCuenta']==1){  
				$FormaPago_Banco = "Mercantil";}
			elseif ( $row_RS_Mov_Contable_haber['CodigoCuenta']==2){  
				$FormaPago_Banco = "Provincial";}
		 } 
	
		 if ($row_RS_Mov_Contable_haber['Tipo']==3){ 
			$FormaPago = "Cheque" ;
			$FormaPago_Banco = $row_RS_Mov_Contable_haber['ReferenciaBanco']; 
			} 
	 
		 if ($row_RS_Mov_Contable_haber['Tipo']==4){ // Efectivo
			$FormaPago = "Efectivo:" ; 
			} 
	
		$FormaPago_Numero = $row_RS_Mov_Contable_haber['Referencia'];
		$FormaPago_Monto = Fnum( Reconv ( $row_RS_Mov_Contable_haber['MontoHaber']));
		$FormaPago_Fecha = DDMMAAAA($row_RS_Mov_Contable_haber['Fecha']); 
	
	 //} while ($row_RS_Mov_Contable_haber = $RS_Mov_Contable_haber->fetch_assoc()); 

	$pdf->Cell(30 , $Ln , "Pago en:" , $borde , 0 , 'R'); 
	$pdf->Cell(65 , $Ln , $FormaPago , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->Cell(30 , $Ln , "Banco:" , $borde , 0 , 'R'); 
	$pdf->Cell(65 , $Ln , $FormaPago_Banco , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->Cell(30 , $Ln , "Número:" , $borde , 0 , 'R'); 
	$pdf->Cell(65 , $Ln , $FormaPago_Numero , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->Cell(30 , $Ln , "Fecha:" , $borde , 0 , 'R'); 
	$pdf->Cell(65 , $Ln , $FormaPago_Fecha , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);

	$pdf->Cell(30 , $Ln , "Monto:" , $borde , 0 , 'R'); 
	$pdf->Cell(65 , $Ln , $FormaPago_Monto , $borde , 0 , 'L'); 
	$pdf->Ln($Ln);



$No++;
}






//  $Factura_Total_MontoBaseImponible  $Factura_Total_MontoBaseExcenta  
//  $Factura_Total_IVA  $Factura_Total



 	  





 




if($SW_Actualiza_Base){
	$sql = "UPDATE Recibo SET 
				  Base_Imp = '$Factura_Total_MontoBaseImponible', 
				  Base_Exe = '$Factura_Total_MontoBaseExcenta', 
				  Monto_IVA = '$Factura_Total_IVA' , 
				  Total = '$Factura_Total',
				  P_IVA = '$P_IVA_Factura' 
				  WHERE CodigoRecibo = $Codigo_Recibo";
	$query =  $mysqli->query($sql);
}






$pdf->Output();



$totMontoBase = 0;
$totMontoBase = 0; 
$BaseExcenta = 0;
$BaseImponible = 0; 
$totMontoIVA = 0; 
$totMontoNeto = 0;   
}
else
echo "NO IMPRIMIR FACTURA HASTA NEUVO AVISO";

?>