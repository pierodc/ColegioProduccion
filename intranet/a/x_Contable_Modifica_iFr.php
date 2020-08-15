<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php'); 

$TituloPantalla = "TituloPantalla";

/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
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

echo $sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
?>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<table width="100%" border="0" cellpadding="3">
        <tr>
          <td colspan="5" class="NombreCampoBIG">Movimientos</td>
        </tr>
  <tr>
    <td nowrap="nowrap" class="NombreCampoBIG">Fecha</td>
    <td nowrap="nowrap" class="NombreCampoBIG">Ref</td>
    <td nowrap="nowrap" class="NombreCampoBIG">&nbsp;Descripci&oacute;n</td>
    <td align="right" nowrap="nowrap" class="NombreCampoBIG">&nbsp;Monto</td>
    <td align="right" nowrap="nowrap" class="NombreCampoBIG">Cod</td>
    </tr>
<?php 

if(isset($_GET['Descripcion'])){
	$sql = "SELECT * FROM Contable_Imp_Todo 
			WHERE Descripcion LIKE '%".$_GET['Descripcion']."%'
			ORDER BY Fecha DESC";}

if(isset($_GET['Referencia'])){
	$sql = "SELECT * FROM Contable_Imp_Todo 
			WHERE Referencia LIKE '%".$_GET['Referencia']."%'
			ORDER BY Fecha DESC";}

if(isset($_GET['MontoHaber'])){
	$sql = "SELECT * FROM Contable_Imp_Todo 
			WHERE MontoHaber >= '".floor($_GET['MontoHaber'])."'
			AND MontoHaber <= '".floor($_GET['MontoHaber']+1)."'
			ORDER BY Fecha DESC";}
//echo $sql;

$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	
	if(substr($Fecha,0,4) != $AnoAnte){
?>
        <tr>
          <td colspan="5" nowrap="nowrap" class="NombreCampoTITULO"><?php echo substr($Fecha,0,4); ?></td>
        </tr>
        <?php } ?>
        
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="center" nowrap="nowrap"><?php echo DDMMMM($Fecha); ?>&nbsp;</td>
          <td align="center" nowrap="nowrap"><?php echo $Referencia; ?></td>
          <td nowrap="nowrap"><?php //echo $Descripcion; 


        $Palabras_Omitir = "  TR/REC PAGOS A TERCEROS VIA INTERNET DEPOSITO ORDEN DE PAGO";
	$Palabras = str_word_count($Descripcion, 1, '0123456789/');
	foreach($Palabras as $Palabra){
            if(strpos($Palabras_Omitir,$Palabra)){
                echo $Palabra.' ';}
            else{
		echo '<a href="Contable_Modifica_iFr.php?CodigoAlumno='.$_GET['CodigoAlumno'].'&Descripcion='.$Palabra.'" target="Movs">';
		echo $Palabra.'</a> ';}

	}

			



?>&nbsp;</td>
          <td align="right" nowrap="nowrap"><?php 
		  	if($_GET['MontoHaber'] == $MontoHaber)
				echo "<b>";

		  echo Fnum($MontoHaber); ?>&nbsp;</td>
          <td align="right" nowrap="nowrap"><?php 

$sqlaux = "SELECT * FROM Contable_Imp_Todo, ContableMov 
		WHERE Contable_Imp_Todo.Referencia = ContableMov.Referencia 
		AND Contable_Imp_Todo.Codigo = '$Codigo'";		  
$RSaux = $mysqli->query($sqlaux);		  
if($rowaux = $RSaux->fetch_assoc()){
	if($_GET['CodigoAlumno'] == $rowaux['CodigoPropietario'])
		echo "<b>";
	echo $rowaux['CodigoPropietario'];
	
	}		  
		  ?>&nbsp;</td>
        </tr>
        
        
        
<?php
  $AnoAnte = substr($Fecha,0,4);

 } ?>
    </table>