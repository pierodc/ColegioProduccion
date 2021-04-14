<?php 
$MM_authorizedUsers = "91,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$Factor_Bono = 100;
$Factor_Bono = round($Factor_Bono /100 ,2);


$Variable = new Variable();
$CuentaPagoNomina = $Variable->view("CuentaPagoNomina");


if(isset($_GET['Blanquea'])){
	$query = "UPDATE Empleado SET 
			  ".$_GET['Blanquea']." = 0,
			  ".$_GET['Blanquea']."_deduc = 0";
	//echo $query;
	$mysqli->query($query);
	header("Location: ".$php_self."?ArchivoDe=".$_GET['ArchivoDe']);
	}

$ArchivoDe = $_GET['ArchivoDe'];

if($ArchivoDe == 'Nomina')				 	$TituloPantalla = "Nomina de Pago";
elseif($ArchivoDe == 'Pago_extra')	 	 	$TituloPantalla = "Pago_extra";
elseif($ArchivoDe == 'Pago_extra2')	 	 	$TituloPantalla = "Pago_extra2";
elseif($ArchivoDe == 'AdelantoFide')	 		$TituloPantalla = "Adelanto Fideicomiso";
elseif($ArchivoDe == 'IncorporaFide')	 	$TituloPantalla = "Incorpora Fideicomiso";
elseif($ArchivoDe == 'IncrementoFide')	 	$TituloPantalla = "Incremento Fideicomiso";
elseif($ArchivoDe == 'IncrementoFideAnual')	$TituloPantalla = "Incremento Fideicomiso Anual";
elseif($ArchivoDe == 'BonoAlimentacion') 	$TituloPantalla = "Bono Alimentaci?n";
elseif($ArchivoDe == 'BonoAlimentacionExtra') 	$TituloPantalla = "Bono Alimentaci?n Extra";
elseif($ArchivoDe == 'BonoAlimentacionEmision') 	$TituloPantalla = "Bono Alimentaci?n Emision";

elseif($ArchivoDe == 'LPH')				 	$TituloPantalla = "Ley Politica Hab - FAOV";
elseif($ArchivoDe == 'IVSS1312')		 		$TituloPantalla = "IVSS 13-12";

// Conectar

if (isset($_POST['RegistraCodigoQuincena']))  {
	$sql = "DELETE FROM Empleado_Pago WHERE Codigo_Quincena = '".$_POST['RegistraCodigoQuincena']."'";
	//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$mysqli->query($sql);
	}

function RegistraPago ($Codigo_Quincena,$Concepto,$Monto,$CodigoEmpleado){
	$sql = "INSERT INTO Empleado_Pago (Codigo_Quincena,Concepto,Monto,Codigo_Empleado)
			VALUES ('$Codigo_Quincena','$Concepto','$Monto','$CodigoEmpleado')";
	include('../../../Connections/bd.php'); 
	$mysqli->query($sql);
	//echo $sql;
	}

if (isset($_GET['AplicaBono']) or isset($_GET['CalculaDifQuincenas']) or isset($_GET['bonopagado'])){ 
	$sql = "UPDATE Empleado SET Pago_extra = ''";
	$mysqli->query($sql);
	
	$Bono_Base = $Variable->view('Base');
	
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
								WHERE SW_activo = 1 
								AND FormaDePago = 'T' 
								AND NumCuenta > '0000' 
								AND NumCuentaA > '0000'";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		
		
		if (isset($_GET['AplicaBono'])){
			if ($_GET['AplicaBono'] == 'BonoIgualitario'){
				$val = $Variable->view('BonoIgualitario');
			}
			else{
				$Horas = $row_Empleados['HrAcad']+$row_Empleados['HrAdmi'];
				if ($Horas > 0){
					$Factor = round ( $Horas  / 40 , 2);
					}
				else{
					$Factor = 1;
					}
				
				$Bono_Tabla = $Variable->view($row_Empleados[TipoDocente]."");
				$Bono_Base = $Variable->view("Base");
				$val = $Bono_Base * $Bono_Tabla * $Factor;
				
				//$val = $Variable->view($row_Empleados['TipoDocente']) * $Factor * $row_Empleados['SW_PagoBono'];
			}
		}
		
		if (isset($_GET['CalculaDifQuincenas'])){
			
			 $sql = "SELECT * FROM Empleado_Pago 
					 WHERE Codigo_Empleado = '".$row_Empleados[CodigoEmpleado]."'
					 AND ( Codigo_Quincena = '".$Variable->view("Compara_Q_1")."' 
					 OR Codigo_Quincena = '".$Variable->view("Compara_Q_2")."' )
					 AND Concepto = '+SueldoBase'
					 ORDER BY Codigo_Quincena ";
			 $RS_Pagos = $mysqli->query($sql);
			 $row_Pagos = $RS_Pagos->fetch_assoc();
		
			 $Monto1 = $row_Pagos['Monto'];
			 $row_Pagos = $RS_Pagos->fetch_assoc();
			 $Monto2 = $row_Pagos['Monto'];
			 $val = max(round(($Monto2-$Monto1),2),0); 
		}
		
		
		if (isset($_GET['bonopagado'])){
			
			 $sql = "SELECT * FROM Empleado_Pago 
					 WHERE Codigo_Empleado = '".$row_Empleados[CodigoEmpleado]."'
					 AND Codigo_Quincena = '2019 01 Beneficio Adicional Alimentacion' 
					 ORDER BY Codigo_Quincena ";
			 $RS_Pagos = $mysqli->query($sql);
			 $row_Pagos = $RS_Pagos->fetch_assoc();
		
			 $Monto1 = $row_Pagos['Monto']+20000;
			 $bonopagado = max(round(($Monto1),2),0); 
		}
		
		
		$sql = "UPDATE Empleado SET Pago_extra = '$val' WHERE CodigoEmpleado = '".$row_Empleados['CodigoEmpleado']."'";
		
		//$sql = "UPDATE Empleado SET Pago_extra_deduc = '$Monto1' WHERE CodigoEmpleado = '".$row_Empleados['CodigoEmpleado']."'";
		
		
		$mysqli->query($sql);
		//echo $sql."<br>";
	}
}

if (isset($_GET['Borra'])){ 
	$sql = "UPDATE Empleado SET ".$_GET['ArchivoDe']." = '' 
			WHERE CodigoEmpleado = '".$_GET['CodigoEmpleado']."'";
	$mysqli->query($sql);	
}
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

 <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Cobranza/common.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><?php echo $TituloPantalla; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<div class="container-fluid">
  <div class="row">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/TitAdmin.php'); ?>
  </div>

  <div class="row">
    <div class="col-lg-12">
 
 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php  require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="5">
      <tr>
        <td colspan="8" align="left" ><table width="100%" border="0">
          <tr>
            <td rowspan="2" align="left"><?php 
		$addVars = "&ArchivoDe=".$_GET['ArchivoDe'];
		Ir_a_AnoMes($Mes, $Ano, $addVars);
 ?>&nbsp;</td>
            <td rowspan="2" align="center"><?php if($ArchivoDe == 'AdelantoFide'){
?>
              <p><a href="../Procesa.php?EliminaAdelantosFideicomiso=1" target="_blank"><img src="../../../i/folder_error.png" width="32" height="32" /><br />
                Archivo Procesado</a>  </p>
                <?php }?>
            
              <? if($ArchivoDe == 'Pago_extra' or $ArchivoDe == 'Pago_extra_dolares' or $ArchivoDe == 'Pago_extra2') { ?>
              <p><a href="Archivos_txt.php?ArchivoDe=<?= $ArchivoDe ?>&Blanquea=<?= $ArchivoDe ?>">Blanquea <?= $ArchivoDe ?></a> </p>
              <? } ?></td>
            <td align="left"><form id="form1" name="form1" method="post" action="">
              Cod quincena: 
                  <input name="RegistraCodigoQuincena" type="text" id="RegistraCodigoQuincena" value="<?= $_POST['RegistraCodigoQuincena'] ?>" size="35" />
                  <br />
                  Concepto: 
                  <input name="Concepto" type="text" id="Concepto" value="<?= $_POST['Concepto'] ?>" size="35" />
                  <br />
<input type="submit" name="submit" id="submit" value="Submit" />
            </form></td>
            <td rowspan="2" align="center"><?php 
			
			if($ArchivoDe == 'Nomina')
				$Destino = "Nomina_Pago";
			if($ArchivoDe == 'AdelantoFide')
				$Destino = "";
			if($ArchivoDe == 'IncrementoFide')
				$Destino = "Nomina_Fideicomiso";
			if($ArchivoDe == 'IncrementoFideAnual')
				$Destino = "Nomina_Fideicomiso_Anual";
			if($ArchivoDe == 'BonoAlimentacion')
				$Destino = "Nomina_BonoAlim";
			if($ArchivoDe == 'LPH')
				$Destino = "";
			
			?><a href="PDF/<?php echo $Destino ?>.php?Mes=<?php echo $Mes ?>&Ano=<?php echo $Ano ?>&Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>" target="_blank"><img src="../../../i/Xerox.png" width="43" height="48" /><br />
              Imprimir N&oacute;mina</a>
              <?php if($Destino == "Nomina_Pago") { ?>
              <br><br><a href="PDF/Recibo_Pago.php?Quincena=<?php if(date('d')<=20) echo '1ra'; else echo '2da'; ?>" target="_blank">Imprimir Recibos</a>
              <?php } ?>
              </td>
            <td rowspan="2" align="center"><a href="Genera_Archivo.php?<?php echo "Archivo=txt&Mes=$Mes&Ano=$Ano&ArchivoDe=$ArchivoDe"; ?>" target="_blank" ><img src="../../../i/column_tree.png" width="32" height="32" /><img src="../../../i/arrow_right.png" width="32" height="32" /><img src="../../../i/file_extension_txt.png" width="32" height="32" /><br />
Generar TXT Mercantil <b><?php echo Mes($Mes); ?></b></a><br />
<a href="Genera_Archivo.php?<?php echo "Archivo=txt&Mes=$Mes&Ano=$Ano&ArchivoDe=CestaTicket"; ?>">Generar TXT Cesta Ticket Accord</a></td>
          </tr>
          <tr>
            <td align="left"><? Variable_OnOff ("CuentaPagoNomina"); ?> Pago por cuenta Nomina 
            | <a href="Archivos_txt.php?ArchivoDe=Pago_extra&AplicaBono=1">Asigna Bono</a>
            | <a href="Archivos_txt.php?ArchivoDe=Pago_extra&AplicaBono=BonoIgualitario">Asigna Bono Igualitario</a>
            <br> <a href="Archivos_txt.php?ArchivoDe=Pago_extra&CalculaDifQuincenas=1">Cal Dif <?= $Variable->view("Compara_Q_1") .'->'. $Variable->view("Compara_Q_2") ;?></a>
            
            </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="3" align="left" >&nbsp;</td>
        <td width="50" align="center" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td align="right" >&nbsp;</td>
        <td align="center" >&nbsp;</td>
        <td align="center" >&nbsp;</td>
        </tr>
        
      <tr>
        <td align="center" class="NombreCampo">No</td>
        <td colspan="2" align="center" class="NombreCampo">Cedula</td>
        <td width="50" align="center" class="NombreCampo">&nbsp;</td>
        <td align="center" class="NombreCampo">Empleado</td>
        <td align="center" class="NombreCampo">Monto</td>
        <td align="center" class="NombreCampo">Fecha Ingreso</td>
        <td align="center" class="NombreCampo">Fecha Egreso</td>
      </tr>
<?php 


if($ArchivoDe == 'Pago_extra' or $ArchivoDe == 'Pago_extra2' or $ArchivoDe == 'Pago_extra_dolares' ){

	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND NumCuenta > '0000' 
							AND NumCuentaA > '0000'
							ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";
	
	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";
							//
	
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
		
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td align="right"> n: <?php 
			if ($CuentaPagoNomina)
				echo $row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta'];
			else
				echo $row_Empleados['NumCuentaB'];
			
			 ?></td>
           
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
            <td align="left">
				<?php echo $row_Empleados['TipoEmpleado'].'. '.$row_Empleados['TipoDocente'].'. '.$row_Empleados['HrAcad']; ?></td>
            
            <td align="left">&nbsp;........</td>
          
			<td align="right"><a href="<? 
			echo $php_self."?ArchivoDe=".$_GET['ArchivoDe'].
			"&CodigoEmpleado=" . $row_Empleados['CodigoEmpleado'].
			"&Borra=1";  ?>">x</a>&nbsp;<?php 
			
			$Pago = round($row_Empleados[$ArchivoDe]*$Factor_Bono , 2);
			 
			Campo_Edit_Empleado ("Empleado",$row_Empleados['CodigoEmpleado'],$_GET['ArchivoDe']); 
			
			echo Fnum($Pago);
			
			if($row_Empleados[$ArchivoDe.'_deduc'] <> 0){
				echo " -(". Fnum(round($row_Empleados[$ArchivoDe.'_deduc'] , 2)).")=";
				$Pago = round(($row_Empleados[$ArchivoDe]*$Factor_Bono)-$row_Empleados[$ArchivoDe.'_deduc'] , 2);
				if ($Pago < 0)
					echo " < ";
				echo Fnum($Pago);
				if ($Pago < 0)
					echo " > ";
			
			
			
			}
			
			if($ArchivoDe == "Pago_extra_dolares"){
				echo " (BsS ".Fnum($Pago * $Cambio_Paralelo).")";
				$Pago = round($Pago * $Cambio_Paralelo , 2);
			}
			else
				echo " ($ ".Fnum($Pago / $Cambio_Paralelo).")";
			
			if (isset($_POST['RegistraCodigoQuincena']) and $_POST['RegistraCodigoQuincena']>""){
				RegistraPago ($_POST['RegistraCodigoQuincena'],$_POST['Concepto'],$Pago,$row_Empleados['CodigoEmpleado']);
			}
			
			$Total += $Pago;
			
			if ($Pago > 0){
				$TotalArchivo += $Pago;
				$Conteo_Pagos++;
			}
			
			
			?></td>
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}



if($ArchivoDe == 'Nomina'){

	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND MontoUltimoPago > 0
							ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
		
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td>&nbsp;<?php echo $row_Empleados['FormaDePago']." ".$row_Empleados['NumCuentaA'].$row_Empleados['NumCuenta']; ?></td>
			<td align="right">&nbsp;<?php 
			
			$Pago = Fnum(round($row_Empleados['MontoUltimoPago'] , 2));
			echo $Pago;
			
			$Total += $row_Empleados['MontoUltimoPago'];
			
			$TotalArchivo += $row_Empleados['MontoUltimoPago'];
			
			?></td>
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}





if($ArchivoDe == 'IncorporaFide'){

	$sql = "SELECT * FROM Empleado
			WHERE SW_Activo = '1'
			AND SW_Antiguedad_Inc = '1'
			AND NumCuenta > ''
			AND NumCuentaA > ''
			ORDER BY Empleado.Apellidos,Empleado.Nombres";
	echo $sql;
	$RS_Empleados = $mysqli->query($sql);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '
									 .$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));




			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			//echo Fnum($Monto);

			//$TotalArchivo += $Monto;

			?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
			<td align="left"><?php 
			
			//echo "SueldoBase : ".$SueldoBase."<br>";
			//echo "SueldoDiario : ".$SueldoDiario."<br>";
			//echo "FechaObjAntiguedad : ".$FechaObjAntiguedad."<br>";
			
			//echo "AnosLaborados : ".$AnosLaborados."<br>";
			//echo "FactorBaseBono : ".$FactorBaseBono."<br>";
			//echo "DiasBono : ".$DiasBono."<br>";
			//echo "MontoBono : ".$MontoBono."<br>";
			//echo "SueldoIntDia : ".$SueldoIntDia."<br>";
			//echo "MontoFideicomiso : ".$MontoFideicomiso."<br>";
			
			
			?></td>
		  </tr>
	<?php 
	}
}




if($ArchivoDe == 'IncrementoFide'){

	$sql = "SELECT * FROM Empleado_Pago, Empleado
			WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
			AND Empleado.SW_activo = '1'
			AND Empleado.SW_Antiguedad = '1'
			AND Empleado_Pago.Concepto = '+Fideicomiso'
			AND Empleado_Pago.Codigo_Quincena = '$Ano $Mes'
			ORDER BY Empleado.Apellidos,Empleado.Nombres";
	echo $sql;
	$RS_Empleados = $mysqli->query($sql);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			$Monto = round(abs($row_Empleados['Monto']) , 2);
			echo Fnum($Monto);
			$TotalArchivo += $Monto;

			?></td>
		  </tr>
	<?php 
	}
}



if($ArchivoDe == 'IncrementoFideAnual'){
$Mes = '07';
//$Ano = '2016';
$Ano = $_GET['Ano'];
$FechaObjAntiguedad = $Ano.'-09-30'; //Para calculo de antiguedad

	$sql = "SELECT * FROM Empleado 
			WHERE SW_Antiguedad=1 
			AND SW_activo=1 
			ORDER BY Apellidos, Nombres  ASC";
			
	//echo $sql."<br>";
	$RS_Empleados = $mysqli->query($sql);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
		
		
		extract($row_Empleados);
	
		$sql_Sueldo = "SELECT * FROM Empleado_Pago
						WHERE Codigo_Empleado = '$CodigoEmpleado'
						AND Codigo_Quincena = '".$Ano." 09 5'
						AND Concepto = '+Fideicomiso Anual'";
		//echo $sql_Sueldo."<br>";
	
		$RS_Sueldo = $mysqli->query($sql_Sueldo);
		$row_Sueldo = $RS_Sueldo->fetch_assoc();
		$SueldoBase = $row_Sueldo['Monto'];
		//echo $SueldoBase;
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			$Monto = round(abs($SueldoBase) , 2);
			echo Fnum($Monto);
			$TotalArchivo += $Monto;

			?></td>
		  </tr>
	<?php 
	}
}




if($ArchivoDe == 'AdelantoFide'){

	$sql = "SELECT * FROM Empleado_Pago, Empleado
			WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
			AND Status='PP'";
	$RS_Empleados = $mysqli->query($sql);
	while($row_Empleados = $RS_Empleados->fetch_assoc()){
		$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			$Monto = round(abs($row_Empleados['Monto']) , 2);
			echo Fnum($Monto);
			$TotalArchivo += $Monto;

			?></td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
		  </tr>
	<?php 
	}
}




if($ArchivoDe == 'BonoAlimentacion'){
	$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';
        $query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_cestaT='1' AND
				(SW_activo = '1' OR
				(FechaEgreso <= '".date('Y')."-$Mes-31' AND FechaEgreso >= '".date('Y')."-$Mes-1'))
				ORDER BY PaginaCT, Apellidos, Nombres ASC";
	//echo $query_RS_Empleados;						
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right">&nbsp;<?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
	
	$DiasXSemana = strlen($row_Empleados['DiasSemana']);
	$DiasInasistencia = $row_Empleados['DiasInasistencia'];
	$DiasXDescontar = round($DiasInasistencia * 1.4 , 2);
	$DiasXPagar = ( $DiasXSemana * 1.4 ) / 7 * $CT_DiasMes - $DiasXDescontar;
	$MontoCestaT = round( $UnidadTributaria * $CT_PorcentajeDia/100 , 2);
	$TotBono = round($DiasXPagar * $MontoCestaT + $row_Empleados['BonifAdicCT'],2);


			echo Fnum($TotBono);
			
			$TotalArchivo += $TotBono;
			
			
			 ?></td>
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}


if($ArchivoDe == 'BonoAlimentacionExtra'){
	$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_activo = '1' 
							AND SW_cestaT='1' 
							AND MontoCestaT_extra > 0
							ORDER BY Apellidos, Nombres ASC";
	echo $query_RS_Empleados;						
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right">&nbsp;<?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
			$MontoCestaT = $row_Empleados['MontoCestaT_extra'];
	
			echo Fnum(round($MontoCestaT*1 , 2));
			$TotalArchivo += $MontoCestaT;
			
			
			 ?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
             
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}


if($ArchivoDe == 'BonoAlimentacionEmision'){
	$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_activo = '1' 
							AND SW_CestaTnew='1' 
							ORDER BY Apellidos, Nombres ASC";
	echo $query_RS_Empleados;						
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right">&nbsp;<?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
			$MontoCestaT = $row_Empleados['MontoCestaT_extra'];
	
			//echo Fnum(round($MontoCestaT*1 , 2));
			$TotalArchivo += $MontoCestaT;
			
			
			 ?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
             
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}



if($ArchivoDe == 'LPH'){

$MesAnte = MesAnte($Mes);
$AnoAnte = AnoAnte($Mes,$Ano);	
		
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
							
							//FechaIngreso <= '$Ano-$Mes-31' AND 
		echo $query_RS_Empleados;				
						
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{

	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
			$sql_Sueldo = "SELECT * FROM Empleado_Pago
							WHERE Codigo_Empleado  = '".$row_Empleados['CodigoEmpleado']."'  AND
							(Codigo_Quincena = '$Ano $Mes 2' OR Codigo_Quincena = '$Ano $Mes 1') AND
							Concepto = '+SueldoBase'
							ORDER BY Codigo_Quincena DESC";
			//echo $sql_Sueldo;				
			$RS_Sueldo = $mysqli->query($sql_Sueldo);
			if($row_Sueldo = $RS_Sueldo->fetch_assoc() and $row_Sueldo['Monto']>0)
				$SueldoBase = round($row_Sueldo['Monto']*1 , 2); 
			else 
				$SueldoBase = 900 ;
			
			echo Fnum($SueldoBase);
			$TotalArchivo += (($SueldoBase*2)*0.03);
			
			?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
			<td align="center">&nbsp;<?php if($row_Empleados['FechaEgreso'] > "0000-00-00")
								echo DDMMAAAA($row_Empleados['FechaEgreso']); ?></td>
		  </tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}





if($ArchivoDe == 'IVSS1312'){
		
	$PrimerLunes = date("Y-m-d" , strtotime("last Monday" , mktime(12,0,0,$Mes,1,$Ano)));	
	$UltimoDomingo = date("Y-m-d" , strtotime("last Sunday" , mktime(12,0,0,$Mes*1+1,1,$Ano)));	
		
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_ivss = '1' AND
							FechaEgreso <= '$UltimoDomingo' AND
							(FechaEgreso >= '$PrimerLunes' OR FechaEgreso = '0000-00-00') AND
							FechaEgreso <> '1950-01-01'
							ORDER BY Apellidos, Nombres ASC";//	
//	echo $query_RS_Empleados;						
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{

	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?>&nbsp;<?php //echo $row_Empleados['CodigoEmpleado'] ?></td>
			<td colspan="2" align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td width="50" align="center"><a href="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_Empleados['CodigoEmpleado'] ?>" target="Movs">Ver</a></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
			$sql_Sueldo = "SELECT * FROM Empleado_Pago
							WHERE Codigo_Empleado  = '".$row_Empleados['CodigoEmpleado']."'  AND
							(Codigo_Quincena = '$Ano $Mes 2' OR Codigo_Quincena = '$Ano $Mes 1') AND
							Concepto = '+SueldoBase'";
			$RS_Sueldo = $mysqli->query($sql_Sueldo);
			if($row_Sueldo = $RS_Sueldo->fetch_assoc())
				$SueldoBase = Fnum(round($row_Sueldo['Monto']*1 , 2)); 
			else 
				$SueldoBase = Fnum(round($row_Empleados['SueldoBase'] , 2));
			
			echo $SueldoBase;
			$TotalArchivo += $SueldoBase;

			?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
			<td align="center">&nbsp;<?php if($row_Empleados['FechaEgreso'] <> '0000-00-00')
								echo DDMMAAAA($row_Empleados['FechaEgreso']).$row_Empleados['FechaEgreso']; ?></td>
		  </tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
	


}


?>      
      <tr>
        <td colspan="3">&nbsp;</td>
        <td width="50" align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><?php echo "(" . $Conteo_Pagos .")  ". Fnum($TotalArchivo); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><iframe src="" align="right" width="100%" name="Movs" height="500" frameborder="0" ></iframe></td>
  </tr>
</table>


		</div>
	</div>
</div>


<?php echo $query_RS_Empleado;	 ?>
<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>