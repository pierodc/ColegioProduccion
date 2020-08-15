<?php 
/*  $ArchivoDe == 
	'Nomina' 
	'AdelantoFide' 
	'BonoAlimentacion' 
	'LPH' 
*/
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php'); 

$ArchivoDe = $_GET['ArchivoDe'];

if($ArchivoDe == 'Nomina')				 $TituloPantalla = "Nomina de Pago";
elseif($ArchivoDe == 'AdelantoFide')	 $TituloPantalla = "Adelanto Fideicomiso";
elseif($ArchivoDe == 'BonoAlimentacion') $TituloPantalla = "Bono Alimentación";
elseif($ArchivoDe == 'LPH')				 $TituloPantalla = "Ley Politica Hab - FAOV";

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);




 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php  require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="900" border="0" cellpadding="5">
      <tr>
        <td colspan="6" align="left" ><table width="100%" border="0">
          <tr>
            <td align="left"><?php 
		$addVars = "&ArchivoDe=".$_GET['ArchivoDe'];
		Ir_a_AnoMes($Mes, $Ano, $addVars);
 ?>&nbsp;</td>
            <td align="center"><?php if($ArchivoDe == 'AdelantoFide'){
?>
              <a href="Procesa.php?EliminaAdelantosFideicomiso=1" target="_blank"><img src="../../i/folder_error.png" width="32" height="32" /><br />
Archivo Procesado</a>
              <?php }?></td>
            <td align="center">&nbsp;</td>
            <td align="center"><?php 
			
			if($ArchivoDe == 'Nomina')
				$Destino = "Empleado_Nomina";
			if($ArchivoDe == 'AdelantoFide')
				$Destino = "";
			if($ArchivoDe == 'BonoAlimentacion')
				$Destino = "Empleado_Nomina_BonoAlim";
			if($ArchivoDe == 'LPH')
				$Destino = "";
			
			?><a href="Lista/<?php echo $Destino ?>.php?Mes=<?php echo $Mes ?>&Ano=<?php echo $Ano ?>&Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>" target="_blank"><img src="../../i/Xerox.png" width="43" height="48" /><br />
              Imprimir</a></td>
            <td align="center"><a href="archivo/Genera_Archivo.php?<?php echo "Archivo=txt&Mes=$Mes&Ano=$Ano&ArchivoDe=$ArchivoDe"; ?>" target="_blank" ><img src="../../i/column_tree.png" width="32" height="32" /><img src="../../i/arrow_right.png" width="32" height="32" /><img src="../../i/file_extension_txt.png" width="32" height="32" /><br />
Generar TXT </a></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="2" align="left" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td align="right" >&nbsp;</td>
        <td align="center" >&nbsp;</td>
        <td align="center" >&nbsp;</td>
        </tr>
        
      <tr>
        <td align="center" class="NombreCampo">No</td>
        <td align="center" class="NombreCampo">Cedula</td>
        <td align="center" class="NombreCampo">Empleado</td>
        <td align="center" class="NombreCampo">Monto</td>
        <td align="center" class="NombreCampo">Fecha Ingreso</td>
        <td align="center" class="NombreCampo">Fecha Egreso</td>
      </tr>
<?php 


if($ArchivoDe == 'Nomina'){

	$query_RS_Empleados = "SELECT * FROM Empleado 
							WHERE SW_activo = 1 
							AND FormaDePago = 'T' 
							AND MontoUltimoPago > 0
							ORDER BY Apellidos, Nombres";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
		
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			
			$Pago = Fnum(round($row_Empleados['MontoUltimoPago'] , 2));
			echo $Pago;
			
			$Total += $row_Empleados['MontoUltimoPago'];
			
			?></td>
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
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
			<td align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			$Monto = round(abs($row_Empleados['Monto']) , 2);
			echo Fnum($Monto);
			?></td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
		  </tr>
	<?php 
	}
}




if($ArchivoDe == 'BonoAlimentacion'){
	$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_activo=1 
							AND SW_cestaT='1' 
							ORDER BY PaginaCT, Apellidos, Nombres ASC";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{
	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td align="right">&nbsp;<?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
			<td>&nbsp;<?php echo $Empleado; ?></td>
			<td align="right">&nbsp;<?php 
			$DiasLaborables = DiasLaborables( $aaaa_mm_dd_obj , $row_Empleados['DiasSemana']);
			$DiasBono = $DiasLaborables - $row_Empleados['DiasInasistencia'];
			$Bono = round($DiasBono * $row_Empleados['MontoCestaT'] + $row_Empleados['BonifAdicCT'],2);
	
			echo Fnum(round($Bono*1 , 2));
			
			
			 ?></td>
			</tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
}



if($ArchivoDe == 'LPH'){
		
	$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
							SW_lph = '1' AND
							FechaIngreso < '$Ano-$Mes-31' AND 
							(FechaEgreso = '0000-00-00' OR 
							(FechaEgreso >= '$Ano-$Mes-01' AND FechaEgreso < '$Ano-$Mes-31' )  ) AND
							FechaEgreso <> '1950-01-01'
							ORDER BY Apellidos, Nombres ASC";
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	if($row_Empleados = $RS_Empleados->fetch_assoc()){
		do{

	$Empleado =  T_Tit(sinAcento( $row_Empleados['Apellidos'].' '.$row_Empleados['Apellido2'].', '.$row_Empleados['Nombres'].' '.$row_Empleados['Nombre2']));
			
	?>      
		  <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
			<td align="right"><?php echo ++$No ?></td>
			<td align="right"><?php echo strtoupper($row_Empleados['CedulaLetra']).'-'.$row_Empleados['Cedula']; ?></td>
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
			
			?></td>
			<td align="center">&nbsp;<?php echo DDMMAAAA($row_Empleados['FechaIngreso']) ?></td>
			<td align="center">&nbsp;<?php if($row_Empleados['FechaEgreso'] <> '0000-00-00')
								echo DDMMAAAA($row_Empleados['FechaEgreso']); ?></td>
		  </tr>
	<?php 
		}while($row_Empleados = $RS_Empleados->fetch_assoc());
	}
	


}


?>      
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>