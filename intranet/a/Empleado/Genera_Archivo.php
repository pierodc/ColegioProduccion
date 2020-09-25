<?php 
$MM_authorizedUsers = "91,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 

//$Variable = new Variable();
//$Variable->view("Concepto_Pedido");


$Factor_Bono = 100;
$Factor_Bono = round($Factor_Bono /100 ,2);

$Concepto_Pedido = "Bono Alimentacion Marzo 2020";
	
$DiaAbono = date('d');
if( date("G") > 19 ){
	$DiaAbono += 1;
}
//$DiaAbono = "05";
$FechaAbono = date('Ym').$DiaAbono;
//$FechaAbono = date('Ym'.'15');

//$FechaAbono = "20180801";


// INICIO --- muestra en pantalla el TXT
$sw_produccion = true; // true para produccion
function Chk($sw_produccion,$Pos_ini,$txt){ // muestra en pantalla el TXT
	if($sw_produccion){print $txt;}
	else{
		$Pos_fin = $Pos_ini + strlen($txt)-1;
		print ''.$Pos_ini.'-'.$Pos_fin.' -> '.strlen($txt).' : ';
		print $txt;
		print "\r\n";
		}
	return strlen($txt)+$Pos_ini;
}
// FIN --- muestra en pantalla el TXT



$Variables = new Variable;
$Lote = substr("0000".$Variables->view("Lote_Nomina_Mercantil") , -4);

$CuentaPagoNomina = $Variables->view("CuentaPagoNomina");


$Lote_prox = substr("0000". $Variables->view("Lote_Nomina_Mercantil") + 1 , -4);
$Variables->edit("Lote_Nomina_Mercantil" , $Lote_prox);


$ArchivoDe = $_GET['ArchivoDe'];

if ($ArchivoDe == 'Nomina'){
	$TipoPago = "0000000222"; // Pago de Nómina
	}
elseif ($ArchivoDe == 'Pago_extra' or $ArchivoDe == 'Pago_extra2' or $ArchivoDe == 'Pago_extra_dolares'){
	$TipoPago = "0000000058"; // Otros Abonos al Personal y/o Contratados
	}

$NombreArchivo = $ArchivoDe.'_'.$FechaAbono.'_L'.$Lote.''.'.txt';	

if($ArchivoDe == 'LPH')
	$NombreArchivo = "N03210013702340204594$Mes$Ano.txt";

if($ArchivoDe == 'CestaTicket'){
	$FechaAbono = date('dmY');
	$NombreArchivo = "CT_71614_62_".$FechaAbono."_01.txt";
}

/*
0000000222 = Pago de Nómina,
0000000396 = honorarios Profesionales
0000000399 = Liquidación Prestaciones,
0000000424= Pago de Utilidades,
0000000740 = Pago de Vacaciones,
0000000741 = Viáticos y / o Viajes
0000000058 = Otros Abonos al Personal y/o Contratados,
0000000414 = Préstamo Caja de Ahorros,
0000000014 = Pago de Nóminas Jubilados
0000000891 = Cestaticket
*/







//$NombreArchivo = $ArchivoDe.'_'.date('Y').'_'.date('m').'_'.date('d').'.txt';

//header('Content-Type: application/octetstream'); 
header('Content-Type: text/plain'); 
header('Content-Disposition: attachment; filename='.$NombreArchivo); 
header('Pragma: public'); 



if( $ArchivoDe == 'CestaTicket')
	
	
	
{
	 $query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND NumCuenta > '0000' 
							AND NumCuentaA > '0000'
							ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ 
		$Monto = 0;
		
		if (($row_Empleados['Pago_extra']-$row_Empleados['Pago_extra_deduc']) > 0)
				$Monto = round(2*(($row_Empleados['Pago_extra']) - $row_Empleados['Pago_extra_deduc']) , 0);
		
		
		if($Monto  > 0){
				$Monto = str_replace(".",",",$Monto);
			
				if ($CuentaPagoNomina) {
					$CuentaReceptora = $row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta'];
					}
				else {
					$CuentaReceptora = $row_Empleados['NumCuentaB'];
					}

				print ( $row_Empleados['CedulaLetra'] . $row_Empleados['Cedula'] . ";" );
				print ( substr(NoAcentos($row_Empleados['Nombres']) ,0,20 ) . ";");
				print ( substr(NoAcentos($row_Empleados['Apellidos']) ,0,20 ) . ";");
				print ( DiaN($row_Empleados['FechaNac'])."/".MesN($row_Empleados['FechaNac'])."/".AnoN($row_Empleados['FechaNac']) . ";");
				print ( "293818;");//Punto de entrega
				print ( "71614;");//Codigo Cliente
				print ( "62;");//Producto
				print ( ";");
				print ( $Monto . ";");
				print ( date("d/m/Y").";");
				print ( $row_Empleados['Sexo'] . ";");
				print ( $row_Empleados['EdoCivil'] . ";");
			
				if($row_Empleados['Email'] == ""){
					$Email = "pierodc@dicampo.com";
				}
				else{
					$Email = $row_Empleados['Email'];
				}
				print ( $Email . ";");
			
				if($row_Empleados['TelefonoCel'] == ""){
					$TelefonoCel = "04143034444";
				}
				else{
					$TelefonoCel = $row_Empleados['TelefonoCel'];
				}
			
				print ( TelLimpia($TelefonoCel) . ";");
				
				if ($row_Empleados['PaisNacimiento'] == "Venezuela" ) {
					$PaisNacimiento = 1;
				}
				else {
					$PaisNacimiento = 52;
				}
			
				print ( $PaisNacimiento . ";");
				print ( $row_Empleados['CiudadNacimiento'] . ";");
				print ( $CuentaReceptora . ";");
				print ( ";");//ID CAtegoria
				print ( $Concepto_Pedido. ";");//Concepto pedido
				print "\r\n"; 




		}

	
	}
	
	
}

elseif( $ArchivoDe == 'Nomina' or
	$ArchivoDe == 'Pago_extra' or
	$ArchivoDe == 'Pago_extra2' or
	$ArchivoDe == 'Pago_extra_dolares'){

	 $query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND NumCuenta > '0000' 
							AND NumCuentaA > '0000'
							ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	// Totaliza y cuenta
	$NumCentimos = 0;
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ 
		
		if ($ArchivoDe == 'Nomina' and $row_Empleados['MontoUltimoPago'] > 0){
			// Para prueba de banco, desactivar para la proxima
			//$NumCentimos++;
			//$MontoTotal += ($NumCentimos/100) ;
			//
			$MontoTotal += $row_Empleados['MontoUltimoPago'];
			$nEmp++;
			 
			}
		
		if ($ArchivoDe == 'Pago_extra' and ($row_Empleados['Pago_extra'] - $row_Empleados['Pago_extra_deduc']) > 0){
			// Para prueba de banco, desactivar para la proxima
			//$NumCentimos++;
			//$MontoTotal += ($NumCentimos/100) ;
			//
			
			$MontoTotal += round(($row_Empleados['Pago_extra'] * $Factor_Bono)-$row_Empleados['Pago_extra_deduc'] , 2 );
			$nEmp++;
			 
			}
			
		if ($ArchivoDe == 'Pago_extra2' and $row_Empleados['Pago_extra2'] > 0){
			// Para prueba de banco, desactivar para la proxima
			//$NumCentimos++;
			//$MontoTotal += ($NumCentimos/100) ;
			//
			$MontoTotal += $row_Empleados['Pago_extra2']-$row_Empleados['Pago_extra2_deduc'] ;
			$nEmp++;
			 
			}
			
		if ($ArchivoDe == 'Pago_extra_dolares' and $row_Empleados['Pago_extra_dolares'] > 0){
			// Para prueba de banco, desactivar para la proxima
			//$NumCentimos++;
			//$MontoTotal += ($NumCentimos/100) ;
			//
			$MontoTotal += ($row_Empleados['Pago_extra_dolares']-$row_Empleados['Pago_extra_dolares_deduc'])*$Cambio_Paralelo ;
			$nEmp++;
			 
			}
			
		}
		
	$MontoTotal = round($MontoTotal*100,0);
	
	
// Encabezado
		$Pos_ini = 1;
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "1BAMRVECA    00000000000".$Lote."NOMIN"); 
		$Pos_ini = Chk($sw_produccion,$Pos_ini, $TipoPago); // NOMINA
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "J000000001370234");//59
		$Pos_ini = Chk($sw_produccion,$Pos_ini, substr('00000000'.$nEmp , -8));// 
		$Pos_ini = Chk($sw_produccion,$Pos_ini, substr('00000000000000000'.$MontoTotal , -17));//
		$Pos_ini = Chk($sw_produccion,$Pos_ini, date($FechaAbono));
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "01050079668079037183");
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "0000000");//7
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "00000000");//8
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "0000"); //4
		$Pos_ini = Chk($sw_produccion,$Pos_ini, "00000000"); //8
		$Pos_ini = Chk($sw_produccion,$Pos_ini, 
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
	 	"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000000000000000000000000000000000000000000".
		"00000000000");
		print "\r\n"; 

// Renglones
$NumCentimos = 0;
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){ 
		$Monto = 0;
		
		
		
		if ($ArchivoDe == 'Nomina' and $row_Empleados['MontoUltimoPago'] > 0)
			$Monto += round($row_Empleados['MontoUltimoPago']*100 , 0);
		
		if ($ArchivoDe == 'Pago_extra' and ($row_Empleados['Pago_extra']-$row_Empleados['Pago_extra_deduc']) > 0)
			$Monto = round((($row_Empleados['Pago_extra'])*$Factor_Bono - $row_Empleados['Pago_extra_deduc'])*100 , 0);
		
		if ($ArchivoDe == 'Pago_extra2' and ($row_Empleados['Pago_extra2']-$row_Empleados['Pago_extra2_deduc']) > 0)
			$Monto += round(($row_Empleados['Pago_extra2']-$row_Empleados['Pago_extra2_deduc'])*100 , 0);
		
		if ($ArchivoDe == 'Pago_extra_dolares' and ($row_Empleados['Pago_extra_dolares']-$row_Empleados['Pago_extra_dolares_deduc']) > 0)
			$Monto += round($Cambio_Paralelo*($row_Empleados['Pago_extra_dolares']-$row_Empleados['Pago_extra_dolares_deduc'])*100 , 0);
		
		
		if($Monto > 0){
			// Para prueba de banco, desactivar para la proxima
			// Para prueba de banco, desactivar para la proxima
			//$NumCentimos++;
			//$Monto += $NumCentimos ;
			// 
		
			$Pos_ini = 1;
			$Pos_ini = Chk($sw_produccion,$Pos_ini, "2");
			$Pos_ini = Chk($sw_produccion,$Pos_ini, $row_Empleados['CedulaLetra']);
			$Pos_ini = Chk($sw_produccion,$Pos_ini, substr('00000000000000000'.$row_Empleados['Cedula'],-15));
			
			if ($CuentaPagoNomina) {
				$CuentaReceptora = $row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta'];
				}
			else {
				$CuentaReceptora = $row_Empleados['NumCuentaB'];
				}
			
			if (substr($CuentaReceptora , 0 , 4) == "0105")
				$Pos_ini = Chk($sw_produccion,$Pos_ini,  "1");
			else
				$Pos_ini = Chk($sw_produccion,$Pos_ini,  "3");
			
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "000000000000");
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "                              ");
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  $CuentaReceptora );
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr('00000000000000000'.$Monto,-17));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr('                 '.$row_Empleados['Cedula'],-16));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  $TipoPago);
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "000");
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr(NoAcentos($row_Empleados['Apellidos']).' '.NoAcentos($row_Empleados['Nombres']).'                                                           ',0,60));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "000000000000000");
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr("x_".$row_Empleados['Email']."                                                            ",0,50));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "0000");
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr('                                                                                         ',0,30));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  substr('                                                                                                                                                       ',0,80));
			$Pos_ini = Chk($sw_produccion,$Pos_ini,  "00000000000000000000000000000000000");
			print "\r\n";
		}
	} // while renglones
	
	$NombreArchivo = $ArchivoDe.'_'.$FechaAbono.'_L'.$Lote.'.txt';	
}















elseif( $ArchivoDe != 'Nomina' or
		$ArchivoDe != 'Pago_extra' or
		$ArchivoDe != 'Pago_extra2'){




if($ArchivoDe == 'IncorporaFide'){ // Archivo Adelanto Fideicomiso

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
			print '02000013702340000000000100';
			
			
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
			
			$Monto = round(abs($row_Empleados['Monto'])*100 , 0);
			$Monto = '000000000000000'.$Monto;
			
			if ($Monto > 0){
				print '01';
				print date('dmY'); // Fecha
				print '1059876';
				print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
				print substr($Monto,-14);
				//print '200';
				//print $row_Empleados['NumCuenta'];
				//print '0000';
			}
			
			if( $row_Empleados = $RS_Empleados->fetch_assoc())
				if ($Monto > 0)
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

	$Bono=0;
	
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

		$Bono=0;
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
			print substr(NoAcentos($row_Empleados['Apellidos']."                                     "),0,15);
			print substr(NoAcentos($row_Empleados['Nombres']."                                     "),0,15);
			
			
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
?>
&nbsp;
<table><?php
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
	
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_lph = '1' 
							
							AND (FechaIngreso > '0000-00-00' 
									AND FechaIngreso <= '$Ano-$Mes-31')
							
							
							AND
							
							((FechaEgreso >= '$Ano-$Mes-01' 
							AND FechaEgreso <= '$Ano-$Mes-31' ) 
							OR FechaEgreso = '0000-00-00'
							)
							ORDER BY Apellidos, Nombres ASC"; 
	//echo $query_RS_Empleados;
							
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
							Concepto = '+SueldoBase'
							ORDER BY Codigo_Quincena DESC";
			$RS_Sueldo = $mysqli->query($sql_Sueldo);
			
			if($row_Sueldo = $RS_Sueldo->fetch_assoc())
				$SueldoBase = round($row_Sueldo['Monto']*200 , 0);
			else 
				$SueldoBase = 180000 ;
				
			//$SueldoBase = round($row_Empleados['SueldoBase']*200 , 0);
			
			//if ($SueldoBase > 3000 ){
			//	$SueldoBase = Reconv ($SueldoBase);
			//	}
			
			//$SueldoBase = 200000;
			$SueldoBase = round ( $SueldoBase ,0);
				
			print $SueldoBase.',';
			
			print DMA_lph($row_Empleados['FechaIngreso']).',';
			
			if($row_Empleados['FechaEgreso'] < "$Ano-$Mes-01")
				print DMA_lph($row_Empleados['FechaEgreso']);
			print "\r\n"; 
			
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
$NombreArchivo = "N03210013702340204594$Mes$Ano.txt";
}


}

?>