<?php 
$MM_authorizedUsers = "";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

require_once('../../inc/fpdf.php');

class PDF extends FPDF
{
	//Cabecera de p�gina
	function Header() {
		}
	//Pie de p�gina
	function Footer() {
			// Posici�n: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// N�mero de p�gina
		   // $this->Cell(0,10,'Pag '.$this->PageNo(),0,0,'R');
		}
}


$Cedula = $_POST['Cedula'];

$CedulaPC = $_COOKIE["CedulaPC"];
if($CedulaPC == ""){
	setcookie("CedulaPC",$_POST['Cedula'],time()+3600000);
	$CedulaPC = $_POST['Cedula'];
}

$CodigoQuincena = $_POST['QuincenaCompleta'];
//echo $CodigoQuincena;
$CodigoQuincena = explode("-",$CodigoQuincena);

$Ano = $CodigoQuincena[0];
$Mes = substr("0".$CodigoQuincena[1] , -2);
$Quincena = $CodigoQuincena[2];


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


$linea = 6.2;
$tipologia = 'Arial';


$pdf=new PDF('P', 'mm', 'Letter');

$pdf->SetAutoPageBreak(0);
$pdf->SetMargins(12,10,10);
$pdf->SetFont('Arial','',10);

 
$sql = "SELECT * FROM Empleado 
		WHERE SW_activo=1 
		AND Cedula = '$Cedula' ";
						
$RS = $mysqli->query($sql);
$row_RS_Empleados = $RS->fetch_assoc();
$Conteo = $RS->num_rows;
						


$pdf->AddPage();
$pdf->Image('../../img/solcolegio.jpg',10,10,0,20);


$linea=5;
$pdf->Ln(3.5);
$pdf->SetFont('Times','',12);
$pdf->Cell(20,$linea); $pdf->Cell(60,$linea,' COLEGIO ',0,1,'C'); 

$pdf->SetFont('Times','B',16);
$pdf->Cell(20,$linea); $pdf->Cell(60,$linea,' San Francisco de As�s, c.a. ',0,0,'C');  

$pdf->SetFont('Times','B',14);
$pdf->Cell(115,$linea, 'RECIBO N�MINA DE PAGO' ,0,1,'R'); 

$pdf->SetFont('Times','',9);
$pdf->Cell(20); $pdf->Cell(60,$linea,' RIF: J-00137023-4 ',0,0,'C'); 

$pdf->SetFont('Times','B',12);
$titulo = 'correspondiente a la '.$Quincena.' quincena del mes de '.Mes($Mes).' de '.$Ano;
$pdf->Cell(115,$linea, $titulo ,0,0,'R'); 
$pdf->Ln(8);
$linea=6.5;

$pdf->SetFont('Arial','',10);	
$pdf->Cell(20,$linea,'C�dula',1,0,'C');
$pdf->Cell(125,$linea,'Apellidos y Nombre',1,0,'L');
$pdf->Cell(50,$linea,'Cargo',1,1,'R');
 

 
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(20,$linea, Fnum_dec($row_RS_Empleados['Cedula']) ,1,0,'R');
  $pdf->Cell(125,$linea, $row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Apellido2'].', '. $row_RS_Empleados['Nombres'].' '. $row_RS_Empleados['Nombre2'] ,'LRTB',0,'L');
  
  
//  $pdf->Cell(20,$linea,   ,'TBL',0,'L');
  $Horas = '';
  if($row_RS_Empleados['BsHrAcad']>0){ $Horas = 'Ac:'.$row_RS_Empleados['HrAcad'].' ';}
  if($row_RS_Empleados['BsHrAdmi']>0){ $Horas .= '/ Ad:'.$row_RS_Empleados['HrAdmi'].'';}
  $pdf->SetFont('Arial','',9);
  $pdf->Cell( 50,$linea,  $row_RS_Empleados['CargoCorto'] ,'TBLR',1,'R'); //.' ( '.$Horas.' )'
  $pdf->SetFont('Arial','',10);
  //$pdf->Cell(25,$linea, DDMMAAAA($row_RS_Empleados['FechaIngreso']) ,1,1,'R');

  $pdf->SetFont('Arial','',10);
  $linea = 5; 
  //Encabezado
  $pdf->Cell(145,$linea, 'Concepto' ,1,0,'C');
  $pdf->Cell(25,$linea, 'Deducciones' ,1,0,'C');
  $pdf->Cell(25,$linea, 'Asignaciones' ,1,1,'C');
 
 
 
$sql = "SELECT * FROM Empleado_Pago 
		WHERE Codigo_Empleado = '".$row_RS_Empleados['CodigoEmpleado']."' 
		AND Codigo_Quincena = '$Ano $Mes $Quincena' 
		ORDER BY Concepto ASC ";
//echo $sql;		
$RS = $mysqli->query($sql);
while($row = $RS->fetch_assoc()){
	
		if(substr($row['Concepto'],0,1) == '+'){
			$MontoDeduccion = '';
			$MontoAsignacion = $row['Monto']; }
		if(substr($row['Concepto'],0,1) == '-'){
			$MontoDeduccion = $row['Monto'];
			$MontoAsignacion = ''; }

		$Concepto = $row['Concepto'];
		switch ($row['Concepto']) {
			case "+SueldoBase":
				$Concepto = "Sueldo Base";
				break;
			case "-ivss":
				$Concepto = "Seguro Social";
				break;
			case "-lph":
				$Concepto = "Ley Politica Habitacional - FAOV";
				break;
			case "-spf":
				$Concepto = "Seguro paro forzoso";
				break;
			case "-islr":
				$Concepto = "ISRL seg�n ARI";
				break;
		}


		 
			
		$pdf->Cell(145,$linea, $Concepto ,'LR',0,'L');
		$pdf->Cell(25,$linea, Fnum(-$MontoDeduccion) ,'LR',0,'R');
		$pdf->Cell(25,$linea, Fnum($MontoAsignacion) ,'LR',1,'R');
	
		$TotalRecibo = $TotalRecibo + $MontoAsignacion + $MontoDeduccion;
	
	}



 /*
  $pdf->Cell(145,$linea, 'Sueldo Base' ,'TLR',0,'L');
  $pdf->Cell(25,$linea, '' ,'LR',0,'C');
  $pdf->Cell(25,$linea, Fnum($row_RS_Empleados['SueldoBase']) ,'LR',1,'R');

  $pdf->SetFont('Arial','',9);
  $linea = 4; 
 
  $pdf->Cell(145,$linea, 'Seguro Social (4%)' ,'LR',0,'L');
  $pdf->Cell(25,$linea, Fnum($ivss) ,'LR',0,'R');
  $pdf->Cell(25,$linea, '' ,'LR',1,'C');
  
  $pdf->Cell(145,$linea, 'Ley Pol�tica Hab. (1%)' ,'LR',0,'L');
  $pdf->Cell(25,$linea, Fnum($lph) ,'LR',0,'R');
  $pdf->Cell(25,$linea, '' ,'LR',1,'C');
  
  $pdf->Cell(145,$linea, 'Seguro Paro Forzoso (0,5%)' ,'LR',0,'L');
  $pdf->Cell(25,$linea, Fnum($spf) ,'LR',0,'R');
  $pdf->Cell(25,$linea, '' ,'LR',1,'C');
  
  $pdf->SetFont('Arial','',10);
  */
  $linea = 5; 





  $Quin = substr($Quincena,0,1);
  
  $sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
			AND Mes='".$Mes."' 
			AND Ano='".$Ano."' 
			AND Quincena='".$Quin."'  
			AND Tipo <> 'AQ' ";
//echo $sql;
$Result = mysql_query($sql, $bd) or die(mysql_error());
$row_Result = mysql_fetch_assoc($Result);
$totalRows_Result = mysql_num_rows($Result);
$deducciones = round($deducciones,2);
if($totalRows_Result > 0){
	do{
		$Monto = round($row_Result['Monto'],2);	
		$Tipo = $row_Result['Tipo'] ; 
		$Desc ='';
		if($Tipo == 'PR') {
			$Desc = 'Prestamo Bs.'.Fnum($Monto).' ';
			$Monto = $Monto;}
		if($Tipo == 'PP') 
			$Desc = 'Pago a cuenta de prestamo ';
		if($Tipo == 'AU') 
			$Desc = 'Ausencia(s) ';
		if($Tipo == 'DE') 
			$Desc = 'Deducci�n ';
		if($Tipo == 'AQ') 
			$Desc = 'Adelanto de Quincena ';
		if($Tipo == 'BO') 
			$Desc = 'Bonificaci�n ';
		if($Tipo == 'RE') 
			$Desc = 'Reintegro ';
		if($Tipo == 'PA') 
			$Desc = 'Pago ';
		 
		if(	$Tipo == 'PP' or $Tipo == 'AU' or $Tipo == 'DE' or $Tipo == 'AQ' ){ 
		    $pdf->Cell(145,$linea,''. $Desc . $row_Result['Descripcion'] ,'LR',0,'L');
		    $pdf->Cell(25,$linea, Fnum($Monto) ,'LR',0,'R');
		    $pdf->Cell(25,$linea, '' ,'LR',1,'C');
		    $deducciones += $Monto;	}
		else{
		    $pdf->Cell(145,$linea, $Desc . $row_Result['Descripcion'] ,'LR',0,'L');
		    $pdf->Cell(25,$linea, '' ,'LR',0,'R');
		    $pdf->Cell(25,$linea, Fnum($Monto) ,'LR',1,'R');
		    $deducciones -= $Monto;	}
		
	} while ($row_Result = mysql_fetch_assoc($Result)); }

// ADELANTO DE QUINCENA
$sql = "SELECT * FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
		AND Mes='".$Mes."' 
		AND Ano='".$Ano."' 
		AND Quincena='".$Quin."'  
		AND Tipo = 'AQ' ";
$Result = mysql_query($sql, $bd) or die(mysql_error());
$row_Result = mysql_fetch_assoc($Result);
$totalRows_Result = mysql_num_rows($Result);

if($totalRows_Result>0){
	$pdf->Cell(145,$linea, 'Adelanto '.$row_Result['Descripcion'] ,'LR',0,'L');
	$pdf->Cell(25,$linea, Fnum($row_Result['Monto']) ,'LR',0,'R');
	$pdf->Cell(25,$linea, '' ,'LR',1,'R');
	$deducciones += round($row_Result['Monto'],2);	
}

//$neto = round(round($row_RS_Empleados['SueldoBase'] - $ivss - $lph - $spf ,2) - $deducciones ,2); 
 
$TotalRecibo = $TotalRecibo - $deducciones;
  
  $pdf->SetFont('Arial','B',12);
  //$pdf->Cell(18,$linea, Fnum($deducciones) ,1,0,'R');
  $linea=7;
  $pdf->Cell(170,$linea, 'Total' ,'T',0,'R');
  //$pdf->Cell(25,$linea, '' ,1,0,'R');
  $pdf->Cell(25,$linea, Format($TotalRecibo) ,1,0,'R');
  $TotalRecibo="";
  $pdf->SetX(12);
  $pdf->Ln(1);

 
 // $pdf->Cell(25,$linea, Format($neto) ,1,1,'R');
if($neto>0){
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(195,4, 'La cantidad de: '.Fnum_Letras($neto) ,0,1,'L');}








/*
	// AUSENCIAS
	$sql = "SELECT * FROM Empleado_EntradaSalida 
			WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
			AND Obs='Aus' 
			AND Fecha>='$FechaInicial'
			AND Fecha<='$FechaFinal'
		 ";
		 //echo $sql;
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	if($totalRows_Result>0){
		$pdf->Cell(50,$linea*.7 , 'Ausencias '.Mes($Mes).' '.date('Y').' : ' ,0,0,'L');
		do{
			$pdf->Cell(15,$linea*.7, DDMM($row_Result['Fecha']).' ' ,1,0,'C');
		}while($row_Result = mysql_fetch_assoc($Result));
    	$pdf->Ln($linea*.7);
	}
	// AUSENCIAS
*/

  $pdf->SetFont('Arial','B',12);
  //$pdf->Ln(2);
  $pdf->Cell(60,$linea, 'Forma de Pago: ' ,0,1,'L');
  
  $pdf->SetFont('Arial','',10);

$linea = 5;

if($row_RS_Empleados['FormaDePago'] == 'T'){
  //$pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(30,$linea, 'Transferencia Banco Mercantil a la cuenta num: '.$row_RS_Empleados['NumCuentaA'].$row_RS_Empleados['NumCuenta'] ,0,0,'L');
}

if($row_RS_Empleados['FormaDePago'] == 'E'){
  $pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(30,$linea, 'Efectivo ' ,0,0,'L');
}

if($row_RS_Empleados['FormaDePago'] == 'C'){
  $pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(50,$linea, 'Cheque Banco:__________________ N�m:__________________ ' ,0,1,'L');
}

  $pdf->Ln(14);
  $pdf->Cell(60,$linea, 'Firma Empleado Conforme: _______________________________________________ C.I.: _____________________ ' ,0,0,'L');


/*
$Nombre = $row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Apellido2'].' '.$row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Nombre2'];

if($impar){
	$pdf->SetY(1);
	// Arial italic 8
	$pdf->SetFont('Arial','I',8);
	// N�mero de p�gina
	$pdf->Cell(0,10,$Nombre,0,0,'L');

	$pdf->SetY(-15);
	// Arial italic 8
	$pdf->SetFont('Arial','I',8);
	// N�mero de p�gina
	$pdf->Cell(0,10,'Pag '. ++$PagNum,0,0,'R');

	}
	*/


$PagAnterior = $row_RS_Empleados['Pagina']; 


// Email

/*
if($row_RS_Empleados['Email'] > "" and false){
	$html = implode('', file('../Email_Pago.php'));
	
	$html = str_replace('#Nombre#',$row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Nombre2'].' '.$row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Apellido2'],$html);
	$html = str_replace('#CodEmp#',$row_RS_Empleados['md5'],$html);
	
	//echo $html;
	//echo $row_RS_Empleados['Email'];
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= 'From: Colegio San Francisco de As�s <piero@colegiosanfrancisco.com>' . "\r\n";

	//mail('piero@dicampo.com', 'Recibo de Pago', $html, $cabeceras); 
}
	*/


//Fin Email
/*
	$pdf->AddPage();
	$pdf->SetY(15);
	// Arial italic 8
	$pdf->SetFont('Arial','B',14);
	// N�mero de p�gina
	$pdf->Cell(0,10,$Nombre,0,0,'L');

	$pdf->SetY(150);
	// Arial italic 8
	$pdf->SetFont('Arial','B',14);
	// N�mero de p�gina
	$pdf->Cell(0,10,$Nombre,0,0,'L');
*/


	
	//$pdf->SetFont('Arial','',8);
	//$pdf->Cell(115, 4, 'SubTot: '.Fnum($SubTotNominaBase),0,1,'R');
	//$pdf->Cell(115, 4, 'Total: '.Fnum($TotNominaBase),0,0,'R');


$Emp = $row_RS_Empleados['Apellidos'].', '. $row_RS_Empleados['Nombres'];	

$asunto = 'Recibo Pago '.$CedulaPC;
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>' . "\r\n";
$cabeceras .= 'To: Giampiero Di Campo <piero@sanfrancisco.e12.ve>' . "\r\n";
$para = ' Giampiero Di Campo <piero@sanfrancisco.e12.ve>';
	
$txt .= "<teble>";	
		
$txt .= "<tr><td>"."Emp" ."</td><td>". $Emp."</td></tr>\r\n";	
$txt .= "<tr><td>"."Emp" ."</td><td>". $CodigoQuincena."</td></tr>\r\n";	
$txt .= "<tr><td>"."CI" ."</td><td>". $row_RS_Empleados['Cedula']."</td></tr>\r\n";	
$txt .= "<tr><td>Fecha " ."</td><td>". date("d m Y H:i:s")."</td></tr>\r\n";	
$txt .= "<tr><td>Desde IP: " ."</td><td>". $_SERVER['REMOTE_ADDR']."</td></tr>\r\n";
$txt .= "<tr><td>CedulaPC: " ."</td><td>". $CedulaPC."</td></tr>\r\n";
	
	
	
$txt .= "</teble>";		
			
			
mail($para, $asunto, $txt, $cabeceras);


$pdf->Output();

?>
