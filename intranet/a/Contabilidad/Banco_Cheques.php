<?php 
$MM_authorizedUsers = "91,admin,contable";
require_once('../../../inc/Login_check.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

mysql_select_db($database_bd, $bd);


// Activa Inspeccion
$Insp = false ;
/*
$editFormAction = "Banco_Cheques.php?Cuenta=".$_GET['Cuenta']."&NumChequera=".$_GET['NumChequera']."&Linea=".$_GET['Linea'];

if ((isset($_POST["MM_update"]))) {
	if($_POST['FavorDe']=='nulo' or $_POST['FavorDe']=='NULO'){
		$Monto = 0;}
	else {
		$Monto = $_POST['Monto'];}
	
  $updateSQL = sprintf("UPDATE Cheque SET Fecha=%s, FavorDe=%s, ConceptoDe=%s, Monto=%s WHERE Codigo=%s",
                       GetSQLValueString(DMtoAMD($_POST['Fecha']), "date"),
                       GetSQLValueString($_POST['FavorDe'], "text"),
                       GetSQLValueString($_POST['ConceptoDe'], "text"),
                       GetSQLValueString(coma_punto($_POST['Monto']), "double"),
                       GetSQLValueString($_POST['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());

header("Location: ".$editFormAction);

}*/

if(isset($_GET['Cuenta']) and isset($_GET['NumChequera'])){
	$sql = "SELECT * 
			FROM Cheque 
			WHERE Cuenta = '".$_GET['Cuenta']."'
			AND NumChequera = '".$_GET['NumChequera']."'
			ORDER BY NumCheque";	
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS_);
	$totalRows_ = mysql_num_rows($RS_);
}

if( isset($_POST['Buscar']) ){
	$sql = "SELECT * 
			FROM Cheque 
			WHERE FavorDe LIKE '%".$_POST['Buscar']."%'
			OR ConceptoDe LIKE '%".$_POST['Buscar']."%'
			ORDER BY NumCheque DESC";	
	echo $sql;		
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS_);
	$totalRows_ = mysql_num_rows($RS_);
}





include_once("../../../inc/analyticstracking.php") 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Chequeras</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
function ValidaForma() {
form1.BotonRecibo.disabled=true; 
form1.submit(); 
return false;
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

<style type="text/css">
a:link {
	color: #0000FF;
	text-decoration: none;
}
</style>

<style type="text/css">
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
</style>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="100%" border="0" align="center">
  <tr>
    <td><?php 
	$TituloPantalla ="Cheques";
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="left"><a href="Banco_Concilia.php">Egresos Banco</a> | <a href="Banco_Cheques.php">Chequeras</a> | <a href="Banco_Cheques_Crear.php">Crear Chequera</a></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td colspan="2" align="center">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
              <td colspan="2" align="left" nowrap="nowrap" class="subtitle">Cheques</td>
          </tr>
          <tr valign="baseline">
              <td width="50%" align="left" nowrap="nowrap" ><form name="form" id="form">
                <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                  <option value="<?php echo php_self() ?>">Banco...</option>
                  <option value="<?php echo php_self() ?>?Cuenta=1" <?php selected($_GET['Cuenta'],1); ?>>Mercantil</option>
                  <option value="<?php echo php_self() ?>?Cuenta=2" <?php selected($_GET['Cuenta'],2); ?>>Provincial</option>
                </select>
				<?php if ($_GET['Cuenta']>0){ ?>
                <select name="jumpMenu2" id="jumpMenu2" onchange="MM_jumpMenu('parent',this,0)">
                  <option value="<?php echo php_self() ?>?Cuenta=<?php echo $_GET['Cuenta'] ?>">Chequera...</option>
<?php 
$sql = "SELECT * FROM Cheque 
			WHERE Cuenta = '".$_GET['Cuenta']."'
			ORDER BY NumChequera DESC, NumCheque";
$_RS = mysql_query($sql, $bd) or die(mysql_error());
$NumChequera_Ante = '';

while($_row_RS = mysql_fetch_assoc($_RS)){
	
	//if($NumChequera_Ante != $_row_RS['NumChequera']){
		$NumChequera = $_row_RS['NumChequera'];
		$NumCheque_Inicial = $_row_RS['NumCheque'];
	//}
	
	
	
	if($NumChequera_Ante != $_row_RS['NumChequera']){
		
		echo '<option value="'.php_self().'?Cuenta='.$_row_RS['Cuenta'].'&NumChequera='.$NumChequera.'" ';
		selected($_GET['NumChequera'],$NumChequera); 
		echo '>';
		echo $NumChequera.' --> '.$NumCheque_Inicial.' '.$NumCheque_Final.'</option>';
	}
	
	
	
$NumChequera_Ante = $_row_RS['NumChequera'];
//$NumCheque_Final = $_row_RS['NumCheque'];

} ?>                
                </select>
              </form><?php } ?></td>
              <td width="50%" align="right" nowrap="nowrap" ><form action="" method="post">Buscar
                <input type="text" name="Buscar" id="Buscar" />
              <input name="submit" type="submit" id="submit" value="submit" /></form></td>
          </tr>
            <?php 
			if(isset($_GET['Cuenta']) and isset($_GET['NumChequera']))
			do{ 
			extract($row_);
			?>
            <tr>
              <td colspan="2"  <?php $sw=ListaFondo($sw,$Verde); ?>>
<iframe src="Banco_Cheques_iFr.php?No=<?php echo ++$No ?>&Codigo=<?php echo $Codigo ?>" width="100%" height="27" frameborder="0" scrolling="no"></iframe>
              </td>
            </tr>
            <?php } while($row_ = mysql_fetch_assoc($RS_)); ?>
            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap">&nbsp; </td>
            </tr>
            <tr valign="baseline">
              <td colspan="2"  align="right" nowrap="nowrap">                    </td>
          </tr>
        </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>
