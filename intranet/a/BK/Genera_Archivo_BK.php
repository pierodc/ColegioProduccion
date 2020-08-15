<?php 
/*  $ArchivoDe == 
	'Nomina' 
	'AdelantoFide' 
	'BonoAlimentacion' 
	'LPH' 
*/

$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 
require_once('../../../inc/fpdf.php');
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 


$Lote = "0007";
$DiaAbono = "14";


$swP = true; // true para produccion
function Chk($swP,$Io,$txt){
	if($swP){print $txt;}
	else{
		$If = $Io + strlen($txt)-1;
		print '    '.$Io.'-'.$If.' -> '.strlen($txt).' : ';
		print $txt;
		print "\r\n";
		}
	return strlen($txt)+$Io;
}

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$ArchivoDe = $_GET['ArchivoDe'];
$NombreArchivo = $ArchivoDe.'_'.date('Y').'_'.date('m').'_'.date('d').'_'.$Lote.'.txt';

if($ArchivoDe == 'LPH')
	$NombreArchivo = "N03210013702340204594$Mes$Ano.txt";


header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$NombreArchivo); 
header('Pragma: public'); 


if($ArchivoDe == 'Nomina'){ // Archivo Nomina de Pago
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND MontoUltimoPago > 0
							ORDER BY Pagina, Apellidos, Nombres"; // AND CodigoEmpleado = 9
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Totaliza y cuenta
		$MontoTotal += $row_Empleados['MontoUltimoPago'];
		$nEmp++;
	}

	if(date('d') <= '15')	$Descripcion = "1ra ";
	else					$Descripcion = "2da ";
	$Descripcion = $Descripcion.Mes(date('m'))." ".date('Y');
	$Descripcion = substr($Descripcion.'2               ' , 0 , 20);
	
	$MontoTotal = round($MontoTotal*100 , 0);
	$nEmp = substr('00000'.$nEmp , -5);
	
	// Encabezado
	if(false){
		$MontoTotal = substr('000000000000000'.$MontoTotal , -15);
		print "00800089J0001370234";
		print $Descripcion; // Descripcion
		print "000000000000001105";
		print "VEF8079037183"; 
		print $MontoTotal; //Monto Total
		print $nEmp; //Num Empleados
		print date('Ym'.$DiaAbono); // Fecha
		print "\r\n";
	}

	if(true){
		$Io = 1;
		$Io = Chk($swP,$Io, "1BAMRVECA    00000000000".$Lote."NOMIN"); //33     0000-LOTEXXX-NOMIN
		//$Io = Chk($swP,$Io, "0000000891"); // CESTA TICKET
		$Io = Chk($swP,$Io, "0000000222"); // NOMINA
		$Io = Chk($swP,$Io, "J000000001370234");//59
		$Io = Chk($swP,$Io, substr('00000000'.$nEmp , -8));// 
		$Io = Chk($swP,$Io, substr('00000000000000000'.$MontoTotal , -17));//
		$Io = Chk($swP,$Io, date('Ym'.$DiaAbono));
		$Io = Chk($swP,$Io, "01050079668079037183");
		$Io = Chk($swP,$Io, "0000000");//7
		$Io = Chk($swP,$Io, "00000000");//8
		$Io = Chk($swP,$Io, "0000"); //4
		$Io = Chk($swP,$Io, "00000000"); //8
		$Io = Chk($swP,$Io, 
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
	 	"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000");
		print "\r\n"; 
	}
	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Renglones
		
		
		$Monto = round($row_Empleados['MontoUltimoPago']*100 , 0);
			
		if(true){// SISTEMA NUEVO
			$Io = 1;
			$Io = Chk($swP,$Io, "2");
			$Io = Chk($swP,$Io, $row_Empleados['CedulaLetra']);
			$Io = Chk($swP,$Io, substr('00000000000000000'.$row_Empleados['Cedula'],-15));
			$Io = Chk($swP,$Io,  "1");
			$Io = Chk($swP,$Io,  "000000000000");
			$Io = Chk($swP,$Io,  "                              ");
			$Io = Chk($swP,$Io,  $row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta']);
			$Io = Chk($swP,$Io,  substr('00000000000000000'.$Monto,-17));
			$Io = Chk($swP,$Io,  substr('                 '.$row_Empleados['Cedula'],-16));
			$Io = Chk($swP,$Io,  "0000000222");
			$Io = Chk($swP,$Io,  "000");
			$Io = Chk($swP,$Io,  substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60));
			$Io = Chk($swP,$Io,  "000000000000000");
			$Io = Chk($swP,$Io,  substr($row_Empleados['Email']."                                                            ",0,50));
			$Io = Chk($swP,$Io,  "0000");
			$Io = Chk($swP,$Io,  substr('                                                                                         ',0,30));
			
			$Io = Chk($swP,$Io,  substr('Pago Quincena                                                                                                                                    ',0,80));
			$Io = Chk($swP,$Io,  "00000000000000000000000000000000000");
			print "\r\n";
		
	}// SISTEMA NUEVO
		
		
		if(false){// SISTEMA VIEJO
			print '01'.$row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-10);
			print substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60);
			print '1105'.$row_Empleados['NumCuenta'];
			$Monto = '000000000000000'.$Monto;
			print substr($Monto,-15);
			print substr($Monto,-15);
			print "\r\n"; //Datos Empleados
		}
	}
} // Nomina



if($ArchivoDe == 'Pago_extra'){ // Archivo Nomina Pago Extra
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND Pago_extra > 0
							ORDER BY Apellidos, Nombres";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Totaliza y cuenta
		$MontoTotal += $row_Empleados['Pago_extra']-$row_Empleados['Pago_extra_deduc'];
		$nEmp++;
	}

	$Descripcion = "Pago_extra ";
	$Descripcion = $Descripcion.Mes(date('m'))." ".date('Y');
	$Descripcion = substr($Descripcion.'               ' , 0 , 20);
	
	$MontoTotal = round($MontoTotal*100 , 0);
	$MontoTotal = substr('000000000000000'.$MontoTotal , -15);
	$nEmp = substr('00000'.$nEmp , -5);
	
	// Encabezado
	print "00800089J0001370234";
	print $Descripcion; // Descripcion
	print "000000000000001105";
	print "VEF8079037183"; 
	print $MontoTotal; //Monto Total
	print $nEmp; //Num Empleados
	print date('Ymd'); // Fecha
	print "\r\n";
	
	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Renglones
		print '01'.$row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-10);
		print substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60);
		print '1105'.$row_Empleados['NumCuenta'];
		$Monto = round(($row_Empleados['Pago_extra'] - $row_Empleados['Pago_extra_deduc'])*100 , 0);
		$Monto = '000000000000000'.$Monto;
		print substr($Monto,-15);
		print substr($Monto,-15);
		print "\r\n"; //Datos Empleados
	}
} // Nomina Pago Extra


if($ArchivoDe == 'Pago_extra2'){ // Archivo Nomina Pago Extra
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND Pago_extra2 > 0
							ORDER BY Apellidos, Nombres";
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND NumCuenta > '0000' 
							AND NumCuentaA > '0000'
							AND Pago_extra2 > 0
							ORDER BY Apellidos, Nombres";
	
	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Totaliza y cuenta
		$MontoTotal += $row_Empleados['Pago_extra2'] - $row_Empleados['Pago_extra2_deduc'];
		$nEmp++;
	}

	$Descripcion = "Pago_extra2 ";
	$Descripcion = $Descripcion.Mes(date('m'))." ".date('Y');
	$Descripcion = substr($Descripcion.'               ' , 0 , 20);
	
	$MontoTotal = round($MontoTotal*100 , 0);
	$MontoTotal = substr('000000000000000'.$MontoTotal , -15);
	$nEmp = substr('00000'.$nEmp , -8);
	
	$Fecho = Mes(date('m'))." ".date('Y');;
	// Encabezado
	$nEmp = substr('00000'.$nEmp , -5);
	if(false){
		print "00800089J0001370234";
		print $Descripcion; // Descripcion
		print "000000000000001105";
		print "VEF8079037183"; 
		print $MontoTotal; //Monto Total
		print $nEmp; //Num Empleados
		print date('Ymd'); // Fecha
		print "\r\n";
	}


	if(true){
		$Io = 1;
		$Io = Chk($swP,$Io, "1BAMRVECA    00000000000".$Lote."NOMIN"); //33       0000-LOTEXXX-NOMIN
		$Io = Chk($swP,$Io, "0000000891");
		$Io = Chk($swP,$Io, "J000000001370234");//59
		$Io = Chk($swP,$Io, substr('00000000'.$nEmp , -8));// 
		$Io = Chk($swP,$Io, substr('00000000000000000'.$MontoTotal , -17));//
		$Io = Chk($swP,$Io, date('Ym'.$DiaAbono));
		$Io = Chk($swP,$Io, "01050079668079037183");
		$Io = Chk($swP,$Io, "0000000");//7
		$Io = Chk($swP,$Io, "00000000");//8
		$Io = Chk($swP,$Io, "0000"); //4
		$Io = Chk($swP,$Io, "00000000"); //8
		$Io = Chk($swP,$Io, 
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
	 	"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000");
		print "\r\n"; 
	}

	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ // Renglones
		$Monto = round(($row_Empleados['Pago_extra2'] - $row_Empleados['Pago_extra2_deduc'])*100 , 0);
		//
		
		if(true){// SISTEMA NUEVO
			$Io = 1;
			$Io = Chk($swP,$Io, "2");
			$Io = Chk($swP,$Io, $row_Empleados['CedulaLetra']);
			$Io = Chk($swP,$Io, substr('00000000000000000'.$row_Empleados['Cedula'],-15));
			$Io = Chk($swP,$Io,  "1");
			$Io = Chk($swP,$Io,  "000000000000");
			$Io = Chk($swP,$Io,  "                              ");
			$Io = Chk($swP,$Io,  $row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta']);
			$Io = Chk($swP,$Io,  substr('00000000000000000'.$Monto,-17));
			$Io = Chk($swP,$Io,  substr('                 '.$row_Empleados['Cedula'],-16));
			$Io = Chk($swP,$Io,  "0000000891");
			
			
			$Io = Chk($swP,$Io,  "000");
			$Io = Chk($swP,$Io,  substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60));
			$Io = Chk($swP,$Io,  "000000000000000");
			$Io = Chk($swP,$Io,  substr($row_Empleados['Email']."                                                            ",0,50));
			$Io = Chk($swP,$Io,  "0000");
			$Io = Chk($swP,$Io,  substr('                                                                                         ',0,30));
			
			
			
			
			$Io = Chk($swP,$Io,  substr('Bono Alimentacion                                                                         ',0,80));
			$Io = Chk($swP,$Io,  "00000000000000000000000000000000000");
			print "\r\n";
		
	}// SISTEMA NUEVO
	
		if(false){ // SISTEMA VIEJO
			print '01'.$row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-10);
			print substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60);
			print '1105'.$row_Empleados['NumCuenta'];
			$Monto = '000000000000000'.$Monto;
			print substr($Monto,-15);
			print substr($Monto,-15);
			print "\r\n"; //Datos Empleados
		}// SISTEMA VIEJO
		
	}
} // Nomina Pago Extra




elseif($ArchivoDe == 'IncorporaFide'){ // Archivo Adelanto Fideicomiso

	$sql = "SELECT * FROM Empleado
			WHERE SW_Activo = '1'
			AND SW_Antiguedad_Inc = '1'
			AND NumCuenta > ''
			AND NumCuentaA > ''
			ORDER BY Empleado.Apellidos,Empleado.Nombres";
	$RS_Empleados = $mysqli->query($sql);

//02 1059876 V 021131329 PALENCIA B SCARLE N           26022016 1767009941 0200001370234 0000000000100
//02 1059876 V 015836038 HIDALGO C LUISANA             26022016 1079587675 0200001370234 0000000000100

	if($row_Empleados = $RS_Empleados->fetch_assoc())
		do{
			print '02';
			print '1059876';
			print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
			print substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                            ',0,30);
			print date('dmY');
			print $row_Empleados['NumCuenta'];
			print '02000013702340000000000000';
			
			
			if($row_Empleados = $RS_Empleados->fetch_assoc())
				print "\r\n"; //Datos Empleados
		} while ($row_Empleados);
}







elseif($ArchivoDe == 'IncrementoFide'){ // Archivo Adelanto Fideicomiso

	$sql = "SELECT * FROM Empleado_Pago, Empleado
			WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
			AND Empleado.SW_activo = '1'
			AND Empleado.SW_Antiguedad = '1'
			AND Empleado_Pago.Concepto = '+Fideicomiso'
			AND Empleado_Pago.Codigo_Quincena = '$Ano $Mes'
			ORDER BY Empleado.Apellidos,Empleado.Nombres";
	$RS_Empleados = $mysqli->query($sql);

//0124062014 1059876 V010863540 00000000933225

	if($row_Empleados = $RS_Empleados->fetch_assoc())
		do{
			print '01';
			print date('dmY'); // Fecha
			print '1059876';
			print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
			$Monto = round(abs($row_Empleados['Monto'])*100 , 0);
			$Monto = '000000000000000'.$Monto;
			print substr($Monto,-14);
			//print '200';
			//print $row_Empleados['NumCuenta'];
			//print '0000';
			if($row_Empleados = $RS_Empleados->fetch_assoc())
				print "\r\n"; //Datos Empleados
		}while($row_Empleados);
}




elseif($ArchivoDe == 'IncrementoFideAnual'){ // Archivo Adelanto Fideicomiso
$Mes = '07';
//$Ano = '2015';
$Ano = $_GET['Ano'];

$FechaObjAntiguedad = $Ano.'-09-30'; //Para calculo de antiguedad

			
	$sql = "SELECT * FROM Empleado 
			WHERE SW_Antiguedad=1 
			AND SW_activo=1 
			ORDER BY Apellidos, Nombres  ASC";
	$RS_Empleados = $mysqli->query($sql);

//0124062014 1059876 V010863540 00000000933225

	if($row_Empleados = $RS_Empleados->fetch_assoc())
		do{
			
			extract($row_Empleados);
		
			$sql_Sueldo = "SELECT * FROM Empleado_Pago
							WHERE Codigo_Empleado = '$CodigoEmpleado'
							AND Codigo_Quincena = '$Ano 09 5'
							AND Concepto = '+Fideicomiso Anual'";
		        $RS_Sueldo = $mysqli->query($sql_Sueldo);
		        $row_Sueldo = $RS_Sueldo->fetch_assoc();
		        $SueldoBase = $row_Sueldo['Monto'];
		        //echo $SueldoBase;
			
			
			// MONTO FIDEICOMISO
			$Monto = round(abs($SueldoBase) , 2);
			//echo $Monto;
			
			$Monto = round(abs($Monto)*100 , 0);
		
			if($Monto > 0){
				print '01';
				print date('dmY'); // Fecha
				print '1059876';
				print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
				$Monto = '000000000000000'.$Monto;
				print substr($Monto,-14);
				//print '200';
				//print $row_Empleados['NumCuenta'];
				//print '0000';
			}
				if($row_Empleados = $RS_Empleados->fetch_assoc() and $Monto > 0){
					print "\r\n"; //Datos Empleados
				}
				
				
			//
		}while($row_Empleados);
}







elseif($ArchivoDe == 'AdelantoFide'){ // Archivo Adelanto Fideicomiso

	$sql = "SELECT * FROM Empleado_Pago, Empleado
			WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
			AND Status='PP'";
	$RS_Empleados = $mysqli->query($sql);
	if($row_Empleados = $RS_Empleados->fetch_assoc())
		do{
			print '05';
			print date('dmY'); // Fecha
			print '1059876';
			print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
			$Monto = round(abs($row_Empleados['Monto'])*100 , 0);
			$Monto = '000000000000000'.$Monto;
			print substr($Monto,-14);
			print '200';
			print $row_Empleados['NumCuenta'];
			print '0000';
			if($row_Empleados = $RS_Empleados->fetch_assoc())
				print "\r\n"; //Datos Empleados
		}while($row_Empleados);
}


elseif($ArchivoDe == 'BonoAlimentacion'){ // Archivo Bono Alimentacion
	$aaaa_mm_dd_obj = "$Ano-$Mes-01";

        $query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_cestaT='1' AND
				(SW_activo = '1' OR
				(FechaEgreso <= '".date('Y')."-$Mes-31' AND FechaEgreso >= '".date('Y')."-$Mes-1'))
				ORDER BY PaginaCT, Apellidos, Nombres ASC";
	//echo $query_RS_Empleados;
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){

//CSFDA002

	$DiasXSemana = strlen($row_Empleados['DiasSemana']);
	$DiasInasistencia = $row_Empleados['DiasInasistencia'];
	$DiasXDescontar = round($DiasInasistencia * 1.4 , 2);
	$DiasXPagar = ( $DiasXSemana * 1.4 ) / 7 * $CT_DiasMes - $DiasXDescontar;
	$MontoCestaT = round( $UnidadTributaria * $CT_PorcentajeDia/100 , 2);
	$Bono = round($DiasXPagar * $MontoCestaT + $row_Empleados['BonifAdicCT'],2);

	
		$MontoTotal += $Bono;
		
		if($Bono > 0)
			$nEmp++;
	}
	$MontoTotal = round($MontoTotal*100 , 0);
	$MontoTotal = substr('00000000000000000000'.$MontoTotal , -18);
	
	$nEmp = substr('00000'.$nEmp , -5);
	
	$NumLote = $Ano.''.$Mes.date('d');
	
	//0 12013101 J-00137023-4   00094 2 20120131 000000000003446064
	print "0";
	print $NumLote;
//	print "20150430";
	print "J-00137023-4   ";
	print $nEmp; //Num Empleados
	print "2"; 
	print date('Ymd'); // Fecha
	print $MontoTotal; //Monto Total
	
	//2120131016817759        000000000000038912
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	$row_Empleados = $RS_Empleados->fetch_assoc();
	do{
			
			$DiasXSemana = strlen($row_Empleados['DiasSemana']);
			$DiasInasistencia = $row_Empleados['DiasInasistencia'];
			$DiasXDescontar = round($DiasInasistencia * 1.4 , 2);
			$DiasXPagar = ( $DiasXSemana * 1.4 ) / 7 * $CT_DiasMes - $DiasXDescontar;
			$MontoCestaT = round( $UnidadTributaria * $CT_PorcentajeDia/100 , 2);
			$Bono = round($DiasXPagar * $MontoCestaT + $row_Empleados['BonifAdicCT'],2);

		$Monto = round($Bono*100 , 0);
		$Monto = '000000000000000'.$Monto;
	
		
		if($Bono > 0){
			print "\r\n"; //Datos Empleados
			print '2';
//	print "20150430";
			print $NumLote;
			print substr($row_Empleados['Cedula'].'                    ',0,15);
			print substr($Monto,-18);
			}
	
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
		

}

elseif($ArchivoDe == 'BonoAlimentacionEmision'){ // Archivo Bono Alimentacion Emision

	$aaaa_mm_dd_obj = "$Ano-$Mes-01";

	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
						   SW_CestaTnew ='1' AND
						   SW_activo = '1' 
						   ORDER BY PaginaCT, Apellidos, Nombres ASC";
	//echo $query_RS_Empleados;
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		$nEmp++;
	}
	
	$MontoTotal = substr('00000000000000000000' , -18);
	
	$nEmp = substr('00000'.$nEmp , -5);
	
	$NumLote = $Ano.''.$Mes.date('d');
	
	//0 12013101 J-00137023-4   00094 2 20120131 000000000003446064
	print "0";
	print $NumLote;
//	print "20150430";
	print "J-00137023-4   ";
	print $nEmp; //Num Empleados
	print "1";  // Emision
	print date('Ymd'); // Fecha
	print $MontoTotal; //Monto Total
	
	//2120131016817759        000000000000038912
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	$row_Empleados = $RS_Empleados->fetch_assoc();
	do{
			
		$Monto = '0                           ';
	
		
			print "\r\n"; //Datos Empleados
			print '1'; // Emision
			print $NumLote;
			print substr($row_Empleados['Cedula']."               ",0,15);
			print substr($row_Empleados['Apellidos']."                                     ",0,15);
			print substr($row_Empleados['Nombres']."                                     ",0,15);
			
			
			print substr($Monto,0,15);
			
	
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
		

}



elseif($ArchivoDe == 'BonoAlimentacionExtra'){ // Archivo Bono Alimentacion

	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_activo = '1' 
							AND SW_cestaT='1' 
							AND MontoCestaT_extra > 0
							ORDER BY Apellidos, Nombres ASC";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){

//CSFDA002
			
		$MontoCestaT = $row_Empleados['MontoCestaT_extra'];
		$Bono = round($MontoCestaT ,2);
		$MontoTotal += $MontoCestaT;
		
		$nEmp++;
	}
	$MontoTotal = round($MontoTotal*100 , 0);
	$MontoTotal = substr('00000000000000000000'.$MontoTotal , -18);
	
	$nEmp = substr('00000'.$nEmp , -5);
	
	$NumLote = $Ano.''.$Mes.'01';
	
	//0 12013101 J-00137023-4   00094 2 20120131 000000000003446064
	print "0";
	print $NumLote;
	print "J-00137023-4   ";
	print $nEmp; //Num Empleados
	print "2"; 
	print date('Ymd'); // Fecha
	print $MontoTotal; //Monto Total
	print "\r\n";
	
	//2120131016817759        000000000000038912
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	$row_Empleados = $RS_Empleados->fetch_assoc();
	do{
		print '2';
		print $NumLote;
		print substr($row_Empleados['Cedula'].'                    ',0,15);
		
		$MontoCestaT = $row_Empleados['MontoCestaT_extra'];
		$Bono = round($MontoCestaT ,2);
	
		$Monto = round($Bono*100 , 0);
		$Monto = '000000000000000'.$Monto;
		print substr($Monto,-18);
		
		if($row_Empleados = $RS_Empleados->fetch_assoc())
			print "\r\n"; //Datos Empleados
		}while($row_Empleados);

}




elseif($ArchivoDe == 'LPH'){ // Archivo Ley Politica Habitacional - Banavih - FAOV

$MesAnte = MesAnte($Mes);
$AnoAnte = AnoAnte($Mes,$Ano);	
		
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_lph = '1' AND
							FechaIngreso < '$Ano-$Mes-31' AND 
							(FechaEgreso = '0000-00-00' OR 
							(FechaEgreso >= '$AnoAnte-$MesAnte-01' AND FechaEgreso <= '$AnoAnte-$MesAnte-31' )  ) AND
							FechaEgreso <> '1950-01-01'
							ORDER BY Apellidos, Nombres ASC";
	
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_lph = '1' AND
							FechaIngreso <= '$Ano-$Mes-31' AND 
							(FechaEgreso = '0000-00-00' OR 
							(FechaEgreso <= '$Ano-$Mes-31' AND FechaEgreso >= '$AnoAnte-$MesAnte-01') ) 
							ORDER BY Apellidos, Nombres ASC"; //
							
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
			// V,14154778,NEREIDA,JULIANA,GARCIA,NOGUERA,327030,11062005,
			print strtoupper($row_Empleados['CedulaLetra']).','.$row_Empleados['Cedula'].',';
			print strtoupper(NoAcentos($row_Empleados['Nombres'].','.$row_Empleados['Nombre2']).',');
			print strtoupper(NoAcentos($row_Empleados['Apellidos'].','.$row_Empleados['Apellido2']).',');
			
			$sql_Sueldo = "SELECT * FROM Empleado_Pago
							WHERE Codigo_Empleado  = '".$row_Empleados['CodigoEmpleado']."'  AND
							(Codigo_Quincena = '$Ano $Mes 2' OR Codigo_Quincena = '$Ano $Mes 1') AND
							Concepto = '+SueldoBase'";
			$RS_Sueldo = $mysqli->query($sql_Sueldo);
			
			if($row_Sueldo = $RS_Sueldo->fetch_assoc())
				$SueldoBase = round($row_Sueldo['Monto']*200 , 0);
			else 
				$SueldoBase = round($row_Empleados['SueldoBase']*200 , 0);
				
			print $SueldoBase.',';
			
			print DMA_lph($row_Empleados['FechaIngreso']).',';
			
			if($row_Empleados['FechaEgreso'] < "$Ano-$Mes-01")
				print DMA_lph($row_Empleados['FechaEgreso']);
			print "\r\n"; 
			
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}




elseif($ArchivoDe == 'IVSS1312'){ // Archivo Ley Politica Habitacional - Banavih - FAOV

	$PrimerLunes = date("Y-m-d" , strtotime("last Monday" , mktime(12,0,0,$Mes,1,$Ano)));	
	$UltimoDomingo = date("Y-m-d" , strtotime("last Sunday" , mktime(12,0,0,$Mes*1+1,1,$Ano)));	
		
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_ivss = '1' AND
							FechaEgreso <= '$UltimoDomingo' AND
							(FechaEgreso >= '$PrimerLunes' OR FechaEgreso = '0000-00-00') AND
							FechaEgreso <> '1950-01-01'
							ORDER BY Apellidos, Nombres ASC";//	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
?><table><?php
		do{
?><tr>
    <td><?= strtoupper(NoAcentos($row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2']).' ').strtoupper(NoAcentos($row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']).',') ?>&nbsp;</td>
    <td>V</td>
    <td>E</td>
    <td>CI</td>
    <td>FN DD</td>
    <td>FN MM</td>
    <td>FN AA</td>
    <td>F</td>
    <td>M</td>
    <td>Dir</td>
    <td>No IVSS</td>
    <td>Fi DD</td>
    <td>Fi MM</td>
    <td>Fi AA</td>
    <td>Fr DD</td>
    <td>Fr MM</td>
    <td>Fr AA</td>
    <td>S Dia</td>
    <td>S Sem</td>
    <td>S Men</td>
    <td>Cot Tr</td>
    <td>Apor SEm Tr</td>
    <td>Tot</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Ocupacion</td>
    <td>otro</td>
  </tr>
<?php
			print strtoupper($row_Empleados['CedulaLetra']).','.$row_Empleados['Cedula'].',';
			
			$sql_Sueldo = "SELECT * FROM Empleado_Pago
							WHERE Codigo_Empleado  = '".$row_Empleados['CodigoEmpleado']."'  AND
							(Codigo_Quincena = '$Ano $Mes 2' OR Codigo_Quincena = '$Ano $Mes 1') AND
							Concepto = '+SueldoBase'";
			$RS_Sueldo = $mysqli->query($sql_Sueldo);
			
			if($row_Sueldo = $RS_Sueldo->fetch_assoc())
				$SueldoBase = round($row_Sueldo['Monto']*200 , 0);
			else 
				$SueldoBase = round($row_Empleados['SueldoBase']*200 , 0);
				
			print $SueldoBase.',';
			
			print DMA_lph($row_Empleados['FechaIngreso']).',';
			
			if($row_Empleados['FechaEgreso'] <> '0000-00-00')
				print DMA_lph($row_Empleados['FechaEgreso']);
			print "\r\n"; 
			
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
?></table>
<?php 			// V,14154778,NEREIDA,JULIANA,GARCIA,NOGUERA,327030,11062005,
	}
}



?>