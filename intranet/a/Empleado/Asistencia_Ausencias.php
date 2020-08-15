<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "Ausencias por Procesar";


if(isset($_GET['BorraCT'])){
	$sql = "UPDATE Empleado
			SET DiasInasistencia = 0";
	echo $sql;			
	$mysqli->query($sql);
	}



if(isset($_POST['Consolida'])){
	$sql = "UPDATE Empleado_EntradaSalida
			SET SW_Consolidado = 1,
			QuincenaConsolidado = '".$_POST['Consolida']."'
			WHERE SW_Consolidado = '0'";
	echo $sql;			
	$mysqli->query($sql);
	}

/*
if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }

<input type="submit" name="Boton" id="Boton" value="Valor" onclick="this.disabled=true;this.form.submit();" />
*/
 
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="400" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="NombreCampo">Mes</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<?php 
$sql = "SELECT * FROM Empleado_EntradaSalida, Empleado
		WHERE Empleado_EntradaSalida.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Empleado.SW_activo = 1
		AND Obs <> 'Asist'
		AND Empleado_EntradaSalida.SW_Consolidado = 0
		AND Empleado_EntradaSalida.Registrado_Por <> 'Ph'
		ORDER BY Obs, Empleado.Apellidos, Empleado.Apellido2 ";
		//echo $sql;
		
		$MesSig = $Mes+1;
		$MesSig = substr("0".$MesSig,-2);
		$FechaInicio = $Ano."-".$Mes."-01";
		$FechaFin    = $Ano.".-".$MesSig."-01";
		
$sql = "SELECT * FROM Empleado_EntradaSalida, Empleado
		WHERE Empleado_EntradaSalida.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Empleado.SW_activo = 1
		AND Obs <> 'Asist'
		AND (Empleado_EntradaSalida.Fecha >= '$FechaInicio' AND Empleado_EntradaSalida.Fecha < '$FechaFin')
		AND Empleado_EntradaSalida.Registrado_Por <> 'Ph'
		ORDER BY Obs, Empleado.Apellidos, Empleado.Apellido2 ";
		//echo $sql;  // AND QuincenaConsolidado LIKE  '2016 10%'
		

$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td nowrap="nowrap"><?php echo ++$Ln; ?>&nbsp;&nbsp;</td>
  <td nowrap="nowrap"><?php if($Codigo_Empleado_ante != $Codigo_Empleado) 
  				$No = 0;
			echo ++$No. ") "; 
			?>&nbsp;</td>
  <td nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $Codigo_Empleado ?>&Tipo=AU" target="_blank">
    <?php 
  if($Codigo_Empleado_ante != $Codigo_Empleado)
  		echo $Apellidos.' '.$Apellido2.' '.$Nombres.' '.$Nombre2; 
  $Codigo_Empleado_ante = $Codigo_Empleado;
  
  ?></a></td>
  <td nowrap="nowrap"><?php echo $Obs; ?>&nbsp;</td>
  <td nowrap="nowrap"><?php echo DDMMAAAA($Fecha); ?>&nbsp;</td>
</tr>
<?php 	
	
} $Ln=0; ?>
    </table>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="400" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="NombreCampo"><p>Quincena</p></td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<?php 
$sql = "SELECT * FROM Empleado_EntradaSalida, Empleado
		WHERE Empleado_EntradaSalida.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Empleado.SW_activo = 1
		AND Obs <> 'Asist'
		AND Empleado_EntradaSalida.SW_Consolidado = 0
		AND (Empleado_EntradaSalida.Fecha >= '2016-10-14' AND Empleado_EntradaSalida.Fecha < '2016-11-01')
		AND Empleado_EntradaSalida.Registrado_Por <> 'Ph'
		ORDER BY Obs, Empleado.Apellidos, Empleado.Apellido2 ";
		//echo $sql;
$sql = "SELECT * FROM Empleado_EntradaSalida, Empleado
		WHERE Empleado_EntradaSalida.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Empleado.SW_activo = 1
		AND Obs <> 'Asist'
		AND (Empleado_EntradaSalida.Fecha >= '$FechaInicio' AND Empleado_EntradaSalida.Fecha < '$FechaFin')
		AND Empleado_EntradaSalida.Registrado_Por <> 'Ph'
		ORDER BY Obs, Empleado.Apellidos, Empleado.Apellido2 ";
			
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td nowrap="nowrap">&nbsp;<?php echo ++$Ln; ?> &nbsp;&nbsp;</td>
  <td nowrap="nowrap"><?php if($Codigo_Empleado_ante != $Codigo_Empleado) 
  				$No = 0;
			echo ++$No. ") "; 
			?>&nbsp;</td>
  <td nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $Codigo_Empleado ?>&Tipo=AU" target="_blank">
    <?php 
  if($Codigo_Empleado_ante != $Codigo_Empleado)
  		echo $Apellidos.' '.$Apellido2.' '.$Nombres.' '.$Nombre2; 
  $Codigo_Empleado_ante = $Codigo_Empleado;
  
  ?></a></td>
  <td nowrap="nowrap"><?php echo $Obs; ?>&nbsp;</td>
  <td nowrap="nowrap"><?php echo DDMMAAAA($Fecha); ?>&nbsp;</td>
</tr>
<?php 	
	
} ?>
    </table>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><form name="form1" method="post" action="">
      <p>
        <select name="Consolida" id="Consolida">
          <option value="0">Seleccione</option>
          <?php 
					if(!isset($_POST['QuincenaCompleta'])) {
					$QuincenaHoy = date('Y ').date('m') .' ';
						if (date('d')<=15) {
								$QuincenaHoy = $QuincenaHoy . '1';}
						else{
								$QuincenaHoy = $QuincenaHoy . '2';}	}				
					
					for ( $_Ano = $Ano1+2000; $_Ano <= $Ano2+2000; $_Ano++ ){
						for ( $_Mes = 1; $_Mes <= 12; $_Mes++ ){
							for ( $_Qui = 1; $_Qui <= 2; $_Qui++ ){
								$Mesde = Mes($_Mes);
								$_Mes = substr("0".$_Mes,-2);
						 		$_Quincena = $_Ano.' '.$_Mes.' '.$_Qui;
								echo '<option value="'.$_Quincena.'" ';
								if($Selected or $QuincenaHoy==$_Quincena){ echo ' selected="selected"'; $Selected=false; }
								echo '>'.$_Qui.'º '.$Mesde.' '.$_Ano.'</option>
								';
						 		if($_POST['QuincenaCompleta']==$_Quincena){ $Selected=true; }
						 
							}}}
					?>
        </select>
        <input name="submit" type="submit" id="submit" value="Consolidar" />
      </p>
      <p><a href="Asistencia_Ausencias.php?BorraCT=1">Borra CT</a></p>
      <p><a href="Asistencia_Ausencias.php?VerTodoMes=1">Ver todo el mes</a></p>
    </form>
</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>