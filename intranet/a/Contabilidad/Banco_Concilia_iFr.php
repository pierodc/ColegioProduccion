<?php 
$MM_authorizedUsers = "91";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

if ((isset($_POST["Codigo"]))) {
	
	
	if($_POST["Cuenta123"] > ""){ // Contable
		$Cuenta = explode("::",$_POST["Cuenta123"]);
		$Fecha = $_POST["Fecha"];
		
		
		if($_POST["CodigoContabilidad"] == ""){
			$sql = "INSERT INTO Contabilidad
					(Fecha, Cuenta1, Cuenta11, Cuenta111, Descripcion, Monto, MM_Username_db, CodigoMovBanco)
					VALUES
					('$Fecha','$Cuenta[0]','$Cuenta[1]','$Cuenta[2]','".$_POST['Descripcion']."','".abs($_POST['Monto'])."',
					'$MM_Username','".$_GET['Codigo']."' )";
			$mysqli->query($sql);
			$insert_id = $mysqli->insert_id;
			$add_Cod_Contable = ", CodigoContable = '$insert_id'";}
		else{
			$sql = "UPDATE Contabilidad SET
					Fecha = '$Fecha',
					Cuenta1 = '$Cuenta[0]',
					Cuenta11 = '$Cuenta[1]',
					Cuenta111 = '$Cuenta[2]',
					Descripcion = '".$_POST['Descripcion']."',
					Monto = '".abs($_POST['Monto'])."',
					MM_Username_db = '$MM_Username',
					CodigoMovBanco = '".$_GET['Codigo']."'
					WHERE
					Codigo = '".$_POST['CodigoContabilidad']."'";
			$mysqli->query($sql); }
			//echo $sql;			
		
	}
	

	$updateSQL = sprintf("UPDATE Contable_Imp_Todo 
						SET Descripcion = %s 
						$add_Cod_Contable
						WHERE Codigo= %s ",
					   GetSQLValueString($_POST['Descripcion'], "text"),
					   GetSQLValueString($_GET['Codigo'], "int"));
	$RS = $mysqli->query($updateSQL);
	//echo "<br>".$updateSQL;

	
	header("Location: ".$php_self."?Saved=1&import=".$_GET['import']."&Codigo=".$_GET['Codigo']);
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body><?php 

$sql = "SELECT * 
		FROM  Contable_Imp_Todo 
		WHERE Codigo =  '".$_GET['Codigo']."'";
$RS_ = $mysqli->query($sql);
$row_ = $RS_->fetch_assoc();
extract($row_);

?><form id="form1" name="form1" method="post" action=""><table border="0" cellpadding="0" width="100%">


<tr <?php if($_GET['Saved']=='1') echo ' bgcolor="#FFFFCC"'; ?> >
<? if($_GET['import']!='1'){ ?>
  <td align="center" nowrap="nowrap"  ><?php echo DDMMAAAA($Fecha); ?>
  <input type="hidden" name="Fecha" value="<?php echo $Fecha; ?>" /></td>
  <td align="center" nowrap="nowrap"  ><?php echo $Tipo; ?></td>
  <td align="center" nowrap="nowrap"  ><?php echo $Referencia; ?></td>
<? } ?>
  <td nowrap="nowrap"  >
  <input name="Descripcion" type="text" class="FondoCampoInput" id="Descripcion" value="<?php 
    $Alerta = '';
    if($ChNum > '000000' and (
    $Tipo == 'RT' or
    $Tipo == 'CH' or
    $Tipo == 'CA' )){
        $sql = "SELECT * 
                FROM Cheque 
                WHERE NumCheque =  '".$ChNum."'
                AND Cuenta = '".$CodigoCuenta."' ";
				
		$RS_cheque = $mysqli->query($sql);
		$row_cheque = $RS_cheque->fetch_assoc();
        echo $row_cheque['FavorDe'].' / '.$row_cheque['ConceptoDe'];
        }
    elseif($Descripcion == "PAGO A PROVEEDORES EN LINEA"){
        
        
        $MontoDebe = $MontoDebe*1;
        $sql = "SELECT * 
                FROM Empleado 
                WHERE MontoUltimoPago =  '".$MontoDebe."'
                AND FormaDePago = 'T'
                AND SW_activo = '1' 
                ORDER BY NumCuenta , NumCuentaA ";

		$RS_Empleado = $mysqli->query($sql);
		$row_Empleado = $RS_Empleado->fetch_assoc();
        do{
            echo $row_Empleado['Apellidos'].' '.$row_Empleado['Nombres']." *";
        }while($row_Empleado = $RS_Empleado->fetch_assoc());
        $Alerta = '*';
        
        }	
    else{
        echo $Descripcion;}
    
    
     ?>" size="50" 
	 <?php if($ChNum > '0'){ 
	 //echo 'disabled="disabled"';
	 } ?>   /><?php echo $Alerta; ?><?php echo $ChNum; ?></td>

<? if($_GET['import']!='1'){ ?>     
  <td nowrap="nowrap"  ><?php echo $CodigoContable; //Descr Cuenta contable  ?>
  <input type="hidden" name="CodigoContabilidad" value="<?php echo $CodigoContable; ?>" />
    <select name="Cuenta123" id="Cuenta123" >
  <option value="" selected="selected">Seleccione...</option>
    <?php 
	
	if($CodigoContable > ""){
		$sql = "SELECT * FROM Contabilidad WHERE
				Codigo = $CodigoContable";
		$RS = $mysqli->query($sql);
		$row = $RS->fetch_assoc();
		$Mov_Cuenta1   = $row['Cuenta1'];
		$Mov_Cuenta11  = $row['Cuenta11'];
		$Mov_Cuenta111 = $row['Cuenta111'];
		
		
		}
	
$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
// Cuenta 1
while ($row = $RS->fetch_assoc()) {
	extract($row);
	$sql_Cuenta1 = "SELECT * FROM Contabilidad 
					WHERE Cuenta1 = '$Cuenta1'
					GROUP BY Cuenta11 
					ORDER BY Cuenta11";
	$RS_Cuenta1 = $mysqli->query($sql_Cuenta1);	
	// Cuenta 2
	while($row_Cuenta1 = $RS_Cuenta1->fetch_assoc()){
		$sql_Cuenta11 = "SELECT * FROM Contabilidad 
						WHERE Cuenta11 = '".$row_Cuenta1['Cuenta11']."'
						GROUP BY Cuenta111 
						ORDER BY Cuenta111";
		$RS_Cuenta11 = $mysqli->query($sql_Cuenta11);
		// Cuenta 3
		while($row_Cuenta11 = $RS_Cuenta11->fetch_assoc()){
			if($Cuenta1Anterior <> $Cuenta1){
				echo "<option value=\"\"></option>";
				echo "<option value=\"$Cuenta1::\">-- $Cuenta1</option>";}
				
			echo '<option value="'.
					$Cuenta1.'::'.$row_Cuenta1['Cuenta11'].'::'.$row_Cuenta11['Cuenta111'].'::'.'" ';
			
			if($Mov_Cuenta1 == $Cuenta1 and $Mov_Cuenta11 == $row_Cuenta1['Cuenta11'] and $Mov_Cuenta111 == $row_Cuenta11['Cuenta111'] and $Mov_Cuenta1 > "" ){
				echo ' selected="selected" ';
				}
					
			echo '>'.
					'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$row_Cuenta1['Cuenta11'].' -->> '.$row_Cuenta11['Cuenta111'].
					"</option>\r\n"; 
					
					
			$Cuenta1Anterior = $Cuenta1;		
		}
	}
 } 
 ?>
</select>
  </td>
  <td width="70" align="right"  nowrap="nowrap" ><?php 
    echo Fnum($MontoDebe).'&nbsp;';  ?>
    <input type="hidden" name="Monto" value="<?php echo $MontoDebe; ?>" />
  </td>
    <td align="right"  nowrap="nowrap" ><?php 
    echo Fnum($MontoHaber).'&nbsp;'; ?>
    </td>
<? } ?>    
    <td width="10" align="right"  nowrap="nowrap"><input name="Codigo" type="hidden" value="<?php echo $Codigo  ?>" size="8" />
      <input type="submit" name="button" id="button" onclick="this.disabled=true;this.value='...';this.form.submit();"  value="G" /></td>
</tr>
<tr>
<? if($_GET['import']!='1'){ ?>
  <td><img src="../../../img/b.gif" width="80" height="1" /></td>
  <td><img src="../../../img/b.gif" width="20" height="1" /></td>
  <td><img src="../../../img/b.gif" width="100" height="1" /></td>
<? }?>
  <td><img src="../../../img/b.gif" width="250" height="1" /></td>
<? if($_GET['import']!='1'){ ?> 
  <td><img src="../../../img/b.gif" width="200" height="1" /></td>
  <td><img src="../../../img/b.gif" width="80" height="1" /></td>
  <td><img src="../../../img/b.gif" width="80" height="1" /></td>
  <td><img src="../../../img/b.gif" width="20" height="1" /></td>
<? }?>
</tr>
</table>
</form></body>
</html>