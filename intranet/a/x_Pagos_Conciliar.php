<?php
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['Eliminar']))) {
  $deleteSQL = sprintf("DELETE FROM ContableMov WHERE Codigo=%s",
                       GetSQLValueString($_GET['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($deleteSQL, $bd) or die(mysql_error());

  $deleteGoTo = "Pagos_Conciliar.php?SWValidado=".$_GET['SWValidado'];
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
//    $deleteGoTo .= $_SERVER['QUERY_STRING'];
//  }
  header(sprintf("Location: %s", $deleteGoTo));
}

// Filtra lista
if($_GET['SWValidado']==1){
	$add_sql = " AND ContableMov.SWValidado = ". $_GET['SWValidado'];}
	else{
	$add_sql = " AND ContableMov.SWValidado = '0'";}

if($_GET['Oculto'] == 1){
		$Oculto = 1;
	}
else{
		$Oculto = 0;
	}
mysql_select_db($database_bd, $bd);
$query_RS_x_Validar = "SELECT ContableMov.*, Alumno.*, ContableCuenta.*, ContableMov.Observaciones AS Observ  
						FROM ContableMov, Alumno, ContableCuenta 
						WHERE ContableMov.CodigoPropietario = Alumno.CodigoAlumno 
						AND ContableMov.CodigoCuenta = ContableCuenta.CodigoCuenta 
						AND ContableMov.MontoHaber > 0 
						AND SW_Postergado = '$Oculto' 
						".$add_sql." 
						AND (ContableMov.CodigoCuenta=1 or ContableMov.CodigoCuenta=2) 
						AND CodigoRecibo=0 
						
						ORDER BY FechaIngreso DESC LIMIT 600"; //AND Alumno.Deuda_Actual > 1
$RS_x_Validar = mysql_query($query_RS_x_Validar, $bd) or die(mysql_error());
$row_RS_x_Validar = mysql_fetch_assoc($RS_x_Validar);
$totalRows_RS_x_Validar = mysql_num_rows($RS_x_Validar);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color:#069;
	text-decoration: none;
}
a:hover {
	color:#F00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td><?php 
	$TituloPantalla ="Pagos Conciliar";
	require_once('TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0" align="center">
        <tr>
          <td><table width="100%" border="0" class="table table-striped table-hover">
              <tr>
                <td colspan="15" ><a href="Pagos_Conciliar.php"><img src="../../img/Reload.png" width="31" height="27" border="0"></a> | <a href="Pagos_Conciliar.php?Oculto=1">Ocultos</a></td>
                <td colspan="3" ><?php if (1==2){ ?><form name="form" id="form">
                    <select name="Validar" id="Validar" onChange="MM_jumpMenu('parent',this,0)">
                      <option value="Pagos_Conciliar.php?SWValidado=0">Por Conciliar</option>
                      <option value="Pagos_Conciliar.php?SWValidado=1" <?php if ($_GET[SWValidado]==1) echo "SELECTED"; ?>>Conciliado</option>
                    </select>
                </form><?php } ?></td>
              </tr>
            <tr>
                <td align="center" class="TituloLeftWindow">No</td>
              <td align="center" class="TituloLeftWindow">&nbsp;</td>
              <td align="center" class="TituloLeftWindow">Alumno</td>
              <td align="center" class="TituloLeftWindow">&nbsp;</td>
              <td align="center" class="TituloLeftWindow">Codigo</td>
              <td align="center" class="TituloLeftWindow">Pend</td>
              <td align="center" class="TituloLeftWindow"><div align="center">Monto</div></td>
              <td colspan="2" align="center" class="TituloLeftWindow">Tipo</td>
              <td align="center" class="TituloLeftWindow">Banco</td>
              <td align="center" class="TituloLeftWindow">Fecha</td>
              <td colspan="2" align="center" class="TituloLeftWindow">Referencia</td>
              <td align="center" class="TituloLeftWindow">&nbsp;</td>
              <td colspan="3" align="center" class="TituloLeftWindow"><?php if ( $_GET[SWValidado] == 0 and 1==2) { ?>
                    <a href="Pagos_Conciliar.php?AutoConcilia=1&amp;SWValidado=0">Auto-Concilia</a>
                <?php } ?></td>
              </tr>
<?php $No=1; $In="In"; 


if ($totalRows_RS_x_Validar > 0)
do { 

	$Fecha = strtotime($row_RS_x_Validar['FechaIngreso']);
	if($FeahcAnterior != date('d-m-Y', $Fecha)){
		?>
		<tr>
			<td colspan="18" ><label><?php 
			echo DiaSemana( date('N', $Fecha)).' '.date('d-m-Y', $Fecha);
			$Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_x_Validar['FechaIngreso']);
			echo " (". round(($Dif/(3600*24))+1 ,0) .")";?></label></td>
		</tr>
		<?php 
	}
	$FeahcAnterior = date('d-m-Y', $Fecha); ?>
    
    
    <!--div id="Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"-->
    
    
    <?  
	
	    $CodigoAlumno = $row_RS_x_Validar['CodigoAlumno'];
		$sql_Status = "SELECT * FROM AlumnoXCurso
						WHERE Ano = '$AnoEscolar'
						AND CodigoAlumno = '$CodigoAlumno'";
		$RS_Status = $mysqli->query($sql_Status);
		$row_Status = $RS_Status->fetch_assoc();
	
		$StatusActual = $row_Status['Status'];
		
		$sql_Status = "SELECT * FROM AlumnoXCurso
						WHERE Ano = '$AnoEscolarProx'
						AND CodigoAlumno = '$CodigoAlumno'";
		$RS_Status = $mysqli->query($sql_Status);
		$row_Status = $RS_Status->fetch_assoc();
	
		$StatusProx = $row_Status['Status'];
		
	
	
	
	?>
    <!--div id="Hide_Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"-->
	<tr>
		<?php 
        $query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo WHERE Referencia = '".$row_RS_x_Validar['Referencia']."'";
        $RS_del_Banco = mysql_query($query_RS_del_Banco, $bd) or die(mysql_error());
        $row_RS_del_Banco = mysql_fetch_assoc($RS_del_Banco);
        $totalRows_RS_del_Banco = mysql_num_rows($RS_del_Banco);
        
        if( $In=="In"){ $In="";}else{ $In="In";}
        ?>
        <td align="right" ><?php echo $No; ?>&nbsp;</td>
        <!--td align="right" ><?php echo date('H:i',strtotime($row_RS_x_Validar['FechaIngreso'])); ?>&nbsp;</td-->
        <td align="center" ><?php if ($row_RS_x_Validar['CodigoRecibo']<1 or $_SESSION['MM_Username']=="piero"){ ?>
        <a href="Pagos_Conciliar.php?SWValidado=<?php echo $_GET['SWValidado']; ?>&Eliminar=1&Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>"><img src="../../img/b_drop.png" width="16" height="16" border="0" /></a><?php } ?></td>
        <td nowrap ><a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_x_Validar['CodigoClave']; ?>" target="_blank"><img src="../../i/coins_in_hand.png" width="16" height="16" />&nbsp;<?php echo $row_RS_x_Validar['Apellidos']." ".$row_RS_x_Validar['Apellidos2'].", ". $row_RS_x_Validar['Nombres']; ?></a></td>
        <td nowrap ><div <? if($StatusActual != "Inscrito") echo ' class="SW_Amarillo"';?>> &nbsp;<?php
		
		//if($StatusActual == "Inscrito")
			//echo substr($StatusActual,0,4) ;
		
		if($StatusActual != "Inscrito")
			echo substr($StatusProx,0,4) ; 
		
		 ?><!--/div--></td>
        <td align="center" ><a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_x_Validar['CodigoAlumno']; ?>"><img src="../../i/participation_rate.png" width="16" height="16" /><br />
          <?php echo $row_RS_x_Validar['CodigoAlumno']; ?></a></td>
        <td align="right" class="ReciboRenglonMini" ><?php echo Fnum($row_RS_x_Validar['Deuda_Actual']); ?>&nbsp;</td>
        <td align="right" ><strong><?php echo Fnum($row_RS_x_Validar['MontoHaber']); ?></strong></td>
        <td align="right" >&nbsp;<?php if($row_RS_x_Validar['Tipo']==1) {echo "Dep";} ?>
        </td>
        <td ><?php if($row_RS_x_Validar['Tipo']==2) {echo "Tran";}  ?>&nbsp;</td>
        <td align="center" ><img src="../../img/<?php echo $row_RS_x_Validar['Nombre']; ?>.jpg" width="16" height="16"  /></td>
        <td align="center" ><?php 
        
		echo DiaSemana( date('N', strtotime($row_RS_x_Validar['Fecha'])));
		
        echo date(' d-m', strtotime($row_RS_x_Validar['Fecha']));  
        
        $Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_x_Validar['Fecha']);
		
		if(round($Dif/(3600*24) ,0) > 0)
        	echo "<br>(-".round($Dif/(3600*24) ,0).")";
        
        ?></td>
        <td ><!--div align="right"-->
        <a href="Contable_Modifica.php?Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>" target="_blank">
        <?php 
		echo $row_RS_x_Validar['ReferenciaBanco']; 
		echo $row_RS_x_Validar['Referencia']; ?></a><br><?php
        
        if( $row_RS_del_Banco['MontoHaber'] > 0 and $row_RS_del_Banco['MontoHaber'] != $row_RS_x_Validar['MontoHaber'] ){
        echo $row_RS_del_Banco['MontoHaber']."<br>-".$row_RS_x_Validar['MontoHaber']."<br>=";
        echo $row_RS_del_Banco['MontoHaber']-$row_RS_x_Validar['MontoHaber'];} 
         
         
		 
		
		 
        ?><!--/div></td-->
        <td ><?php 
        
        if(strpos($row_RS_del_Banco['Descripcion'],"CH")>0){
        echo "Cheque";
        
        $Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_del_Banco['Fecha']);
        echo " (".$Dif/(3600*24).")";
        };
        
        ?>&nbsp;</td>
        <td><?php echo substr($row_RS_x_Validar['RegistradoPor'], 0 , 5 ); ?><br>
        <?php echo substr($row_RS_x_Validar['FechaIngreso'], 11 , 5 ); ?>
        </td>
        <td colspan="2" nowrap="nowrap">
          <?php 
		if($row_RS_x_Validar['Referencia'] == $row_RS_del_Banco['Referencia'] and $row_RS_x_Validar['Referencia'] > 0){
		//if($valido){ ?> 
         <div id="Hide_Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"> <a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_x_Validar['CodigoClave']; ?>" target="_blank" class="ListadoPar12Verde">Facturar</a>
                  
            <a href="#" id="X_Click_<?php echo $row_RS_x_Validar['Codigo']; ?>"  title="Click para ocultar">
              <img src="../../i/bullet_error.png" width="32" height="32" alt=""/>
            </a></div> <?php } ?> </td>
       
       
<script>
$(document).ready(function() {
	$("#X_Click_<?php echo $row_RS_x_Validar['Codigo'] ?>").on("click",function(e){
		e.preventDefault();
		$("#Hide_Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>").load("<?php echo "Contabilidad/HidePago.php?Codigo=".$row_RS_x_Validar['Codigo'] ?>");
	});
});
</script>        
        
        
        
        
        <td ><?php echo $No ?></td>
	</tr>
	<!--/div-->
    
	<?php 
	$No +=1; 
	
} while ($row_RS_x_Validar = mysql_fetch_assoc($RS_x_Validar)); ?>





          </table></td>
        </tr>
    </table></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($RS_x_Validar);

mysql_free_result($RS_del_Banco);

?>
