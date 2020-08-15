<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "TituloPantalla";

$sql = "SELECT * FROM ContableMov 
		WHERE CodigoCuenta = 5 
		GROUP BY Referencia
		ORDER BY Fecha DESC , Referencia";
/*$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	$MovMax++;
	extract($row);
	$Mov[$MovMax][Referencia] = $Referencia;
    $Mov[$MovMax][Monto] = $MontoHaber;
}*/

/*
if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
 onclick="this.disabled=true;this.form.submit();"
 
 <a href="delete.php?id=$res[id]"  onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a>
 
 
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
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
    <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="90%" border="0">
        <tr>
          <td class="NombreCampo">Titulo</td>
          <td class="NombreCampo">Referencia Usada</td>
          <td class="NombreCampo">Cuenta</td>
          <td class="NombreCampo">Tipo</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">Referencia Punto Venta</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">En Banco</td>
          <td class="NombreCampo">Dif</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<?php 
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	if( $FechaAnterior <> $Fecha){	
?>
<tr>
  <td class="NombreCampo" colspan="11"><?= DDMMAAAA($Fecha) ?></td>
</tr>
<? } ?>

<?  

	$sql_Banco = "SELECT * FROM Contable_Imp_Todo 
				WHERE CodigoCuenta = 5 
				AND Referencia = '$Referencia'";
	$RS_Banco = $mysqli->query($sql_Banco);	
	$row_Banco = $RS_Banco->fetch_assoc();		
	$MontoEnBanco = $row_Banco['MontoHaber'];



if ($ReferenciaAnterior <> $Referencia){
	
	$sql_aux = "SELECT SUM(MontoHaber) as TotalCobrado FROM ContableMov 
				WHERE CodigoCuenta = 5 
				AND Referencia LIKE '$Referencia'";
	$RS_aux = $mysqli->query($sql_aux);	
	$row_aux = $RS_aux->fetch_assoc();	
	$TotalCobrado = $row_aux['TotalCobrado'];
	//echo "<pre>";	
	//var_dump($row_aux);
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td><a href="Estado_de_Cuenta_Alumno.php?CodigoAlumno=<?= $CodigoPropietario ?>" target="_blank"><?= $CodigoPropietario ?></a></td>
  <td><?= $Referencia ?>&nbsp;</td>
  <td><?= $CodigoCuenta ?>&nbsp;</td>
  <td><?= $Tipo ?>&nbsp;</td>
  <td>&nbsp; </td>
  <td align="right"><?= Fnum($TotalCobrado) ?>&nbsp;</td>
  <td><?= $row_Banco['Descripcion'] ?>&nbsp;</td>
  
  <td align="right"><? 
	echo Fnum($MontoEnBanco);
   ?></td>
  <td align="right"><? 
  	echo Fnum($MontoEnBanco - $TotalCobrado)
	 ?></td>
  
  
  
  <td align="right"><?= $RegistradoPor ?>&nbsp;</td>
  <td align="right"><a href="../delete.php?id=$res[id]" onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a></td>
</tr>
<?php 	
}
	$FechaAnterior = $Fecha;
	$ReferenciaAnterior = $Referencia;
} ?>
    </table>&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>