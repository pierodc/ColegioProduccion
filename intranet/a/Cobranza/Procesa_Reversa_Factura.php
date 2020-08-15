<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 


// Procesar pago	
if (isset($_GET['Procesar_Codigo'])) { // Cambiar OR por AND para produccion

	$CodigoRecibo = $_GET['Procesar_Codigo'];
	
	// Busca ContableMov del recibo
	$query_RS_Movimientos = "SELECT * FROM ContableMov 
								WHERE CodigoRecibo = '$CodigoRecibo'"; 
	//echo $query_RS_Movimientos. "<br>";	
	$RS_Movimientos = $mysqli->query($query_RS_Movimientos);
	$row_Movimientos = $RS_Movimientos->fetch_assoc();
	
	
	if ( $RS_Movimientos->num_rows > 0 ) {
		
			
		/*/ Crear Registro de RECIBO
		$sql = "INSERT INTO Recibo 
				(CodigoPropietario, P_IVA, Por) 
				VALUES 
				(".$row_Pago['CodigoPropietario']." ,  '$P_IVA', '".$_COOKIE['MM_Username']."')"; 
		echo $sql. "<br>";	
		$mysqli->query($sql);
		$CodigoRecibo = $mysqli->insert_id;
		// FIN Crear Registro de RECIBO
		*/
		
		
		// Asigna Numero de recibo al PAGO
		$sql = "UPDATE ContableMov 
				SET SWCancelado = '0', 
				CodigoRecibo = '0' ,
				CodigoReciboCliente = '0'
				WHERE CodigoRecibo = '".$CodigoRecibo."'"; 
		//echo $sql. "<br>";	
		$mysqli->query($sql);
		// FIN Asigna Numero de recibo al PAGO
	  
	
	
	
	
	
	
	
	/*
		while ($row_Pendiente = $RS_Pendiente->fetch_assoc()) { 
			
			echo "<br><br>" . ++$i . "<br>";
			echo "Monto Dis " . $MontoDisponible . "<br>";
					
			if( $MontoDisponible >= 0.05 and $row_Pendiente['SWCancelado'] == 0 ) { 
									
				$MontoPendiente = round(($row_Pendiente['MontoDebe_Dolares'] - $row_Pendiente['MontoAbono_Dolares']) , 2);
					
				$MontoIVA = round(  $MontoPendiente *
									$row_Pendiente['SWiva'] * 
									$P_IVA / 100 , 2);
				
				$TotalPendiente = $MontoPendiente + $MontoIVA;
				
				
				echo "Total Pendiente renglon ". $TotalPendiente . "<br>";
				
				
				
				
				// existen fondos para pago
				if( $MontoDisponible >= $TotalPendiente ) { 
					
					// fondo para PAGO TOTAL
					// Para reversar el recibo colocar en CERO CodigoRecibo y SWCancelado
					$sql = "UPDATE ContableMov 
							SET CodigoRecibo = ".$CodigoRecibo." , 
							SWCancelado = '1' ,
							P_IVA = '$P_IVA' 
							WHERE Codigo = ".$row_Pendiente['Codigo']; 
					echo $sql. "<br>";
					$mysqli->query($sql);
					
					
					
					
				} // fin existe fondo para PAGO TOTAL
				
				
				
				else { // existe fondo para PAGO PARCIAL
					
					echo "pago parcial <br>";
					
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
								SET MontoAbono_Dolares = MontoAbono_Dolares+".$MontoDisponible_sin_IVA." 
								WHERE Codigo = ".$row_Pendiente['Codigo']; 
						echo $sql. "<br>";
						$mysqli->query($sql);





						// Crea Registro de abono
						// Para reversar el recibo elimina este registro 
						$sql = "INSERT INTO ContableMov 
								(SWCancelado, CodigoRecibo, MontoDebe_Dolares, SWiva, P_IVA, CodigoCuenta, 
								CodigoPropietario, Fecha, 
								FechaIngreso, FechaValor, 
								Referencia, ReferenciaMesAno, 
								Descripcion, SWValidado, RegistradoPor) 

								VALUES 

								('1', ".$CodigoRecibo.", ".$MontoDisponible_sin_IVA.", '".$row_Pendiente['SWiva']."', '$P_IVA', 0,
								".$row_Pendiente['CodigoPropietario'].", '".$row_Pendiente['Fecha']."',
								'".$row_Pendiente['FechaIngreso']."', '".$row_Pendiente['FechaValor']."',
								'".$row_Pendiente['Referencia']."', '".$row_Pendiente['ReferenciaMesAno']."', 
								'ABONO ".$row_Pendiente['Descripcion']."', '1', 'auto')";
						echo $sql. "<br>";		
						$mysqli->query($sql);
						echo "fin pago parcial y break<br>";
						break;
					
					} // fin existe fondo para pago parcial
					
				$MontoDisponible = round($MontoDisponible - $TotalPendiente  , 2);	
				echo "Monto Dis para el prox " . $MontoDisponible . "<br>";
					
			} // fin existen fondos para otro pago
			else {
				echo "else if( MontoDisponible > 0 and row_Pendiente['SWCancelado'] == 0 ) { <br>";
				break;
			}
				
				
		}  
			
			
			
			
		
		
	}
	*/
	
	}
	header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".CodigoPropietario($row_Movimientos['CodigoPropietario']));
}
// FIN Procesar pago
	
?>