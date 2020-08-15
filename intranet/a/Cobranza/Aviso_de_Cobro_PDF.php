<?php require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php');
require_once('../../inc/fpdf.php');

$pdf=new FPDF();
$pdf=new FPDF('P','mm','Letter');


$colname_RS_CodigoCurso = "-1";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_CodigoCurso = $_GET['CodigoCurso'];
}
if($colname_RS_CodigoCurso>0){
$addSQL = sprintf(' AND AlumnoXCurso.CodigoCurso = %s ', GetSQLValueString($colname_RS_CodigoCurso, "int"));}

mysql_select_db($database_bd, $bd);
$query_RS_Alumno1 = "SELECT * FROM Alumno, AlumnoXCurso WHERE 
					Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
					".$addSQL." AND 
					AlumnoXCurso.Ano = '$AnoEscolar' 
					ORDER BY Apellidos, Apellidos2, Nombres, Nombres2 ASC";
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

/*
if(1==2){
	mysql_select_db($database_bd, $bd);
	$query_RS_Repre = "SELECT * FROM Representante WHERE Creador = '".$row_RS_Alumno['Creador']."' AND SWrepre LIKE '%%s%%'";
	$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
	$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
	$totalRows_RS_Repre = mysql_num_rows($RS_Repre);
	
	$cabeceras .= 'To: ';
	do {
	$cabeceras .= $row_RS_Repre['Nombres'].' '.$row_RS_Repre['Apellidos']. ' <'.$row_RS_Repre['Email1'].'>, ';
	$destinatarios .= $row_RS_Repre['Email1'].'<br>';
	//echo $row_RS_Repre['Email1']. '<br>';
	} while ($row_RS_Repre = mysql_fetch_assoc($RS_Repre)); 
	$cabeceras .= "\r\n";
}
*/


do {
	
	if($row_RS_Alumno['Deuda_Actual'] > 10){

		$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
		
		$query_Pendiente = sprintf("SELECT * FROM ContableMov, Alumno WHERE 
									ContableMov.CodigoPropietario = %s AND 
									Alumno.CodigoAlumno=ContableMov.CodigoPropietario AND 
									SWCancelado = '0' 
									ORDER BY MontoHaber DESC, ContableMov.Fecha ASC, Codigo ASC", GetSQLValueString($CodigoAlumno, "int")); 
									//echo $query_Pendiente.'<br>';
		$Pendiente = mysql_query($query_Pendiente, $bd) or die(mysql_error());
		$row_Pendiente = mysql_fetch_assoc($Pendiente);
		$totalRows_Pendiente = mysql_num_rows($Pendiente);
		$PendienteMes = 0;
		$PendienteMes = $row_Pendiente['MontoDebe'] - $row_Pendiente['MontoHaber'] - $row_Pendiente['MontoAbono'];
	
		
		$pdf->AddPage();
		$pdf->Image('../../img/solcolegio.jpg', 10, 5, 0, 16);
		$pdf->Image('../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$pdf->SetFont('Arial','B',14);
		
		$pdf->Cell(0,16,'Aviso de Cobro',0,1,'C');
		
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(80,6,'Estimado Sr. Representante del Alumno: ',0,0,'L');
		
		$pdf->SetFont('Arial','B',12);
		
		$aux_text = $row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.
					$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2'].' ('.$row_RS_Alumno['CodigoAlumno'].') ';
		$pdf->Cell(100,6,$aux_text,0,1,'L');
		
		
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(20,6,'Curso: ',0,0,'L');
		
		$pdf->SetFont('Arial','B',12);
		$aux_text= Curso($row_RS_Alumno['CodigoCurso']);
		$pdf->Cell(100,6,$aux_text,0,1,'L');
		
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(190,6,  'Nuestros registros indican que para la fecha: '. date('d-m-Y')   ,0,1,'L');
		$pdf->Cell(190,6,  'Ud. tiene una deuda con el Colegio según le indicamos a continuación:'   ,0,1,'L');
		
		
		
		$pdf->Cell(120,6, 'Descripción'   ,1,0,'C');
		$pdf->Cell(30 ,6, 'Período'   ,1,0,'C');
		$pdf->Cell(40 ,6, 'Monto Pendiente'   ,1,1,'C');
		
		
		
		
		
		do {  
		
			$PendienteMes = $row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono'];
			
			if ($PendienteMes>0) {
			
				$pdf->Cell(120,6, $row_Pendiente['Descripcion']   ,1,0,'L');
				$pdf->Cell(30 ,6, Mes_Ano( $row_Pendiente['ReferenciaMesAno'])   ,1,0,'C');
				
				
				if($row_Pendiente['SWValidado']=='1'){ 
					$saldo=$saldo+$row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono'];  
					$aux = Fnum($row_Pendiente['MontoDebe']-$row_Pendiente['MontoHaber']-$row_Pendiente['MontoAbono']);
				} 
					
				$pdf->Cell(40 ,6, $aux   ,1,1,'R');
			}
		} while ($row_Pendiente = mysql_fetch_assoc($Pendiente)); 
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(190 ,6, 'Saldo '. Fnum($saldo)  ,1,1,'R');
		
		$pdf->SetFont('Arial','',11);
		
		$pdf->Cell(190 ,6, 'Le agradecemos hacer efectivo su compromiso con el Colegio dentro de los primeros 5 días de cada mes'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Le recordamos los números de cuenta del Colegio'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Banco Mercantil 0105-0079-66-8079-03718-3 (Transferencias sólo desde Mercantil)'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Banco Provincial 0108-0013-7801-0000-4268 (Transferencias desde otros bancos)'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Favor enviar comprobante de pago por este correo caja@sanfrancisco.e12.ve'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Se despide'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'Atentamente'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'La Administración'  ,0,1,'L');
		$pdf->Cell(190 ,6, 'P.D. Si considera que hay algún error le pedimos disculpas y le agradecemos hacernos llegar sus comentarios.'  ,0,1,'L');
		$pdf->Cell(190 ,6, ++$Pag  ,0,1,'L');
		
		
		$saldo=0;
	}
} while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); 


mysql_free_result($RS_Alumno);

mysql_free_result($Pendiente);

$pdf->Output();

?>
