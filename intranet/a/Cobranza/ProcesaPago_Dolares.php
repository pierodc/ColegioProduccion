<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 


// Procesar pago	
if (isset($_GET['Procesar_Codigo'])) { // Cambiar OR por AND para produccion

	// Busca ContableMov PAGO
	$query_RS_Pago = "SELECT * FROM ContableMov 
						WHERE Codigo = ".$_GET['Procesar_Codigo']."
						AND SWCancelado = '0'"; 
	//echo $query_RS_Pago. "<br>";	
	$RS_Pago = $mysqli->query($query_RS_Pago);
	$row_Pago = $RS_Pago->fetch_assoc();
	
	// Busca ContableMov PENDIENTE
	$query_RS_Pendiente = "SELECT * FROM ContableMov 
									WHERE CodigoPropietario = '". $row_Pago['CodigoPropietario'] ."' 
									AND SWCancelado = 0 
									AND ( MontoDebe_Dolares > 0)
									ORDER BY SW_Prioridad DESC, Fecha ASC, Codigo ASC"; 
	//echo $query_RS_Pendiente. "<br>";	
	$RS_Pendiente = $mysqli->query($query_RS_Pendiente);
	//$row_Pendiente = $RS_Pendiente->fetch_assoc();

	
	if ( $RS_Pago->num_rows > 0 and $RS_Pendiente->num_rows > 0 ) {
		
		$MontoDisponible = round( $row_Pago['MontoHaber_Dolares'] , 2);
		$P_IVA = $P_IVA_2;  // tomado de var de sistema
		
		
		// Crear Registro de RECIBO
		$sql = "INSERT INTO Recibo 
				(CodigoPropietario, P_IVA, Por) 
				VALUES 
				(".$row_Pago['CodigoPropietario']." ,  '$P_IVA', '".$_COOKIE['MM_Username']."')"; 
		//echo $sql. "<br>";	
		$mysqli->query($sql);
		$CodigoRecibo = $mysqli->insert_id;
		// FIN Crear Registro de RECIBO
		
		
		
		// Asigna Numero de recibo al PAGO
		$sql = "UPDATE ContableMov 
				SET SWCancelado = '1', 
				CodigoRecibo = ".$CodigoRecibo." ,
				ProcesadoPor = '".$MM_Username."',
				FechaCancelacion  = NOW()
				WHERE Codigo = ".$_GET['Procesar_Codigo']; 
		//echo $sql. "<br>";	
		$mysqli->query($sql);
		// FIN Asigna Numero de recibo al PAGO
	  
	
	
	
	
	
	
	
	
	
	
		while ($row_Pendiente = $RS_Pendiente->fetch_assoc()) { 
			
			//echo "<br><br>" . ++$i . "<br>";
			//echo "Monto Dis " . $MontoDisponible . "<br>";
					
			if( $MontoDisponible >= 0.05 and $row_Pendiente['SWCancelado'] == 0 ) { 
									
				$MontoPendiente = round(($row_Pendiente['MontoDebe_Dolares'] - $row_Pendiente['MontoAbono_Dolares']) , 2);
					
				$MontoIVA = round(  $MontoPendiente *
									(int)$row_Pendiente['SWiva'] * 
									$P_IVA / 100 , 2);
				
				$TotalPendiente = $MontoPendiente + $MontoIVA;
				
				
				//echo "Total Pendiente renglon ". $TotalPendiente . "<br>";
				
				
				
				
				// existen fondos para pago
				if( $MontoDisponible >= $TotalPendiente ) { 
					
					// fondo para PAGO TOTAL
					// Para reversar el recibo colocar en CERO CodigoRecibo y SWCancelado
					$sql = "UPDATE ContableMov 
							SET CodigoRecibo = ".$CodigoRecibo." , 
							SWCancelado = '1' ,
							P_IVA = '$P_IVA' ,
							ProcesadoPor = '".$MM_Username."',
							FechaCancelacion  = NOW()
							
							WHERE Codigo = ".$row_Pendiente['Codigo']; 
					//echo $sql. "<br>";
					$mysqli->query($sql);
					
					
					
					
				} // fin existe fondo para PAGO TOTAL
				
				
				
				else { // existe fondo para PAGO PARCIAL
					
					//echo "pago parcial <br>";
					
					if($row_Pendiente['SWiva']){
						$MontoDisponible_sin_IVA = round(	$MontoDisponible / 
															(1+($P_IVA/100)) ,2);
					}
					else{
						$MontoDisponible_sin_IVA = $MontoDisponible;
					}
						
					
					
						// suma el monto abono (sin iva) al registro madre
						// Para reversar el recibo restar a Abono fraccion de monto 
						$sql = "UPDATE ContableMov 
								SET MontoAbono_Dolares = MontoAbono_Dolares+".$MontoDisponible_sin_IVA." ,
								ProcesadoPor = '".$MM_Username."',
								FechaCancelacion  = NOW()
								WHERE Codigo = ".$row_Pendiente['Codigo']; 
						//echo $sql. "<br>";
						$mysqli->query($sql);





						// Crea Registro de abono
						// Para reversar el recibo elimina este registro 
						$sql = "INSERT INTO ContableMov 
								(SWCancelado, CodigoRecibo, 
								MontoDebe_Dolares, SWiva, 
								P_IVA, CodigoCuenta, 
								CodigoPropietario, Fecha, 
								FechaIngreso, FechaValor, 
								Referencia, ReferenciaMesAno, 
								Descripcion, SWValidado, RegistradoPor, 
								ProcesadoPor, FechaCancelacion) 

								VALUES 

								('1', ".$CodigoRecibo.", ".$MontoDisponible_sin_IVA.", '".$row_Pendiente['SWiva']."', '$P_IVA', 0,
								".$row_Pendiente['CodigoPropietario'].", '".$row_Pendiente['Fecha']."',
								'".$row_Pendiente['FechaIngreso']."', '".$row_Pendiente['FechaValor']."',
								'".$row_Pendiente['Referencia']."', '".$row_Pendiente['ReferenciaMesAno']."', 
								'ABONO ".$row_Pendiente['Descripcion']."', '1', 'auto',
								'".$MM_Username."', NOW())";
						//echo $sql. "<br>";		
						$mysqli->query($sql);
						//echo "fin pago parcial y break<br>";
						break;
					
					} // fin existe fondo para pago parcial
					
				$MontoDisponible = round($MontoDisponible - $TotalPendiente  , 2);	
				//echo "Monto Dis para el prox " . $MontoDisponible . "<br>";
					
			} // fin existen fondos para otro pago
			else {
				//echo "else if( MontoDisponible > 0 and row_Pendiente['SWCancelado'] == 0 ) { <br>";
				break;
			}
				
				
		}  
			
			
			
			
			
		/* Limpia registros en CERO	
		$sql = "UPDATE ContableMov
				SET SWCancelado = '1'
				WHERE MontoDebe > 0 
				AND MontoDebe = MontoAbono
				AND SWCancelado = '0'";
		$mysqli->query($sql);		
		*/
		
		
	}
	
	header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".CodigoPropietario($row_Pago['CodigoPropietario']));
}
// FIN Procesar pago
	
?>