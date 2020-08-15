<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 


$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_activo = '1'";
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$totalRows_RS_Empleados = $RS_Empleados->num_rows;



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
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
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Empleados";
	require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0" cellpadding="2">
        <?php 
 while ($row_RS_Empleados = $RS_Empleados->fetch_assoc()) { 
		
		/*
$sql  = "SueldoBase_1=".$row_RS_Empleados[SueldoBase_1]."\r\n";		
$sql .= "SueldoBase_2=".$row_RS_Empleados[SueldoBase_2]."\r\n";		
$sql .= "SueldoBase_3=".$row_RS_Empleados[SueldoBase_3]."\r\n";		
$sql .= "HrAcad=".$row_RS_Empleados[HrAcad]."x".$row_RS_Empleados[BsHrAcad]."\r\n";		
$sql .= "HrAdmi=".$row_RS_Empleados[HrAdmi]."x".$row_RS_Empleados[BsHrAdmi]."\r\n";		
		
		
$sql = "UPDATE Empleado 
		SET SueldoAnteriorDesglose = '$sql'
		WHERE CodigoEmpleado = '$row_RS_Empleados[CodigoEmpleado]'";
$mysqli->query($sql);		
*/


		
$sql  = "SueldoBase_1='".$row_RS_Empleados[SueldoBase_1_prox]."',";		
$sql .= "SueldoBase_2='".$row_RS_Empleados[SueldoBase_2_prox]."',";		
$sql .= "SueldoBase_3='".$row_RS_Empleados[SueldoBase_3_prox]."',";		
$sql .= "HrAcad='".$row_RS_Empleados[HrAcad_prox]."',";		
$sql .= "BsHrAcad='".$row_RS_Empleados[BsHrAcad_prox]."',";		
$sql .= "HrAdmi='".$row_RS_Empleados[HrAdmi_prox]."',";		
$sql .= "BsHrAdmi='".$row_RS_Empleados[BsHrAdmi_prox]."'";		
		
		
$sql = "UPDATE Empleado 
		SET $sql
		WHERE CodigoEmpleado = '$row_RS_Empleados[CodigoEmpleado]'";
$mysqli->query($sql);		



		 ?>
          
          <tr>
            <td width="50%" align="left" nowrap bgcolor="#FFFFFF" ><?php echo ++$i ?>) <?php echo $row_RS_Empleados[Apellidos]; ?>, <?php echo $row_RS_Empleados[Nombres]; ?>

            </td>
            <td width="50%" align="left" nowrap bgcolor="#FFFFFF" ><?php echo "<pre>".$sql."</pre>" ?></td>
          </tr>
          <?php }  ?>
        
        
        
    </table></td>
  </tr>
</table>


</body>
</html>