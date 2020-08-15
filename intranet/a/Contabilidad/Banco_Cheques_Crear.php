<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
$MM_authorizedUsers = "91,admin,Contable";
require_once('../../../inc/Login_check.php'); 

mysql_select_db($database_bd, $bd);

if(isset($_POST['Cuenta'])) {
 
	if( $_POST['Cuenta'] > 0 and
		$_POST['NumChequera'] > 1 and true or
		(	substr($_POST['NumCheque'],-2) == "01" or 
			substr($_POST['NumCheque'],-2) == "26" or 
			substr($_POST['NumCheque'],-2) == "51" or 
			substr($_POST['NumCheque'],-2) == "76") and 
		( $_POST['Cantidad']==25 or $_POST['Cantidad']==50 ) ){
				
			$Cuenta 		= $_POST['Cuenta'];
			$NumChequera = $_POST['NumChequera'];
			$NumCheque 	= substr($_POST['NumCheque'] , -6);
			$Cantidad 	= $_POST['Cantidad'];
			
			$sql = "SELECT * FROM Cheque WHERE 
					Cuenta = '$Cuenta' AND (
					NumCheque = '$NumCheque' OR
					NumChequera = $NumChequera)";
					
			$RS_ = mysql_query($sql, $bd) or die(mysql_error());
			$totalRows_ = mysql_num_rows($RS_);
			
			if($totalRows_ > 0) {
				$ChequeraExiste = true;}
			else{
		
				$sql = "INSERT INTO Cheque (Cuenta, NumChequera, NumCheque) VALUES ";
				for ($i = 1; $i <= $Cantidad; $i++) {
					$sql .= " ('$Cuenta', '$NumChequera', '$NumCheque')";
					$NumCheque++;
					if($i < $Cantidad) 
						$sql .= " , ";
				}
			//echo $sql;
			mysql_query($sql, $bd) or die(mysql_error());
	}
		} else{
		
		$Error = "VERIFIQUE LA INFORMACION";
		}
}



$sql = "SELECT * 
		FROM Cheque 
		WHERE Cuenta = '1'
		ORDER BY NumChequera DESC, NumCheque DESC";
$RS_cheque = mysql_query($sql, $bd) or die(mysql_error());
$row_cheque = mysql_fetch_assoc($RS_cheque);
$NumCheque1 = $row_cheque['NumCheque']+1;
$NumChequera1 = $row_cheque['NumChequera']+1;

$sql = "SELECT * 
		FROM Cheque 
		WHERE Cuenta = '2'
		ORDER BY NumChequera DESC, NumCheque DESC";
$RS_cheque = mysql_query($sql, $bd) or die(mysql_error());
$row_cheque = mysql_fetch_assoc($RS_cheque);
$NumCheque2 = $row_cheque['NumCheque']+1;
$NumChequera2 = $row_cheque['NumChequera']+1;




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Crear Chequera</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style>
div { 
    display: none;
}
</style>
</head>
<?php 


?>
<body>
<form id="form1" name="form1" method="post" action="">
<table width="700" border="0" align="center">
<?php if($Error >""){ ?>
  <tr>
    <td colspan="2" align="center" class="MensajeDeError"><?php echo $Error; ?></td>
  </tr>
<?php } ?>  
  <tr>
    <td colspan="2" class="subtitle">Crear Chequera <?php if($ChequeraExiste) echo "LA CHEQUERA YA EXISTE"; ?></td>
    </tr>
  <tr>
    <td width="50%" align="right" class="NombreCampo">Cuenta</td>
    <td width="50%" class="FondoCampo">
      <select name="Cuenta" id="Cuenta" onChange="showHide(this)">
        <option value="-1">Seleccione...</option>
        <option value="1" <?php if($_POST['Cuenta']==1 )echo 'selected="selected" ';?>>Mercantil</option>
        <option value="2" <?php if($_POST['Cuenta']==2 )echo 'selected="selected" ';?>>Provincial</option>
        <option value="3" <?php if($_POST['Cuenta']==3 )echo 'selected="selected" ';?>>Ven de Cred</option>
      </select>
      </td>
  </tr>
  
 
    <tr>
      <td colspan="2" align="right">
    <!--div id="div1" >   
      <table width="100%" border="0" >
       
        <tr>
    <td width="50%" align="right" class="NombreCampo">No. Chequera</td>
    <td width="50%" class="FondoCampo">
    <input name="NumChequera" type="text" id="NumChequera" value="<?= $NumChequera1 ?>" size="5" />
    </td>
  </tr>
  <tr>
    <td width="200" align="right" class="NombreCampo">No. Cheque Inicial</td>
    <td class="FondoCampo">
    <input name="NumCheque" type="text" id="NumCheque" value="<?= $NumCheque1 ?>" size="15" />
    </td>
  </tr>
  <tr>
    <td width="200" align="right" class="NombreCampo">Cantidad Cheques</td>
    <td class="FondoCampo">
    <select name="Cantidad" id="select">
      <option value="0">Cantidad</option>
      <option value="25" selected="selected" >25</option>
      <option value="50" >50</option>
    </select>
    </td>
  </tr>
        
      </table>
   </div-->    
   
    <!--div id="div2"-->
    <table width="100%" border="0" >
     <tr>
    <td width="50%" align="right" class="NombreCampo">No. Chequera</td>
    <td width="50%" class="FondoCampo">
    <input name="NumChequera" type="text" id="NumChequera" value="" size="5" /> <?= $NumChequera1.' '.$NumChequera2 ?>
    </td>
  </tr>
  <tr>
    <td width="200" align="right" class="NombreCampo">No. Cheque Inicial</td>
    <td class="FondoCampo">
    <input name="NumCheque" type="text" id="NumCheque" value="" size="15" /> <?= $NumCheque1.' '.$NumCheque2; ?>
    </td>
  </tr>
  <tr>
    <td width="200" align="right" class="NombreCampo">Cantidad Cheques</td>
    <td class="FondoCampo">
    <select name="Cantidad" id="select">
      <option value="0">Cantidad</option>
      <option value="25" >25</option>
      <option value="50"  selected="selected">50</option>
    </select>
    </td>
  </tr> </table>
  <!--/div-->
  
   
      </td>
      </tr>
    
 
  
  
 
  
  <tr>
    <td width="200">&nbsp; </td>
    <td><input type="submit" name="button" id="button" value="Crear" /></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<table width="700" border="0" align="center">
  <tr>
    <td colspan="4" align="left" class="subtitle">Chequeras en circulaci&oacute;n</td>
  </tr>
  <tr >
    <td width="45%" align="center" class="NombreCampo" ><img src="../../../i/LogoMercantil.jpeg" width="186" height="48" /></td>
    <td width="10%" align="center">&nbsp;</td>
    <td width="45%" align="center" class="NombreCampo"><img src="../../../i/banco_provincial.gif" width="181" height="45" /></td>
  </tr>
 
  <tr >
    <td align="center" valign="top" ><table width="100%">
      <tbody>
        <tr>
          <td width="50%" align="center" class="NombreCampo">Chequera</td>
          <td width="50%" align="center" class="NombreCampo">1er Cheque</td>
        </tr>
<?php 
$sql = "SELECT * 
		FROM Cheque 
		WHERE Cuenta = '1'
		GROUP BY NumChequera 
		ORDER BY NumChequera, NumCheque 
		";
$RS_cheque = mysql_query($sql, $bd) or die(mysql_error());
$row_cheque = mysql_fetch_assoc($RS_cheque);
do{ 
extract($row_cheque); ?> 
        <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
 		  <td width="25%" align="center"><?php echo $NumChequera  ?></td>
   		  <td width="25%" align="center"><?php echo $NumCheque ?></td>
       </tr>
<?php }while($row_cheque = mysql_fetch_assoc($RS_cheque)); ?>
      </tbody>
    </table></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top" ><table width="100%">
      <tbody>
        <tr>
          <td width="50%" align="center" class="NombreCampo">Chequera</td>
          <td width="50%" align="center" class="NombreCampo">1er Cheque</td>
          </tr>
        <?php 
$sql = "SELECT * 
		FROM Cheque 
		WHERE Cuenta = '2'
		GROUP BY NumChequera 
		ORDER BY NumChequera, NumCheque 
		";
$RS_cheque = mysql_query($sql, $bd) or die(mysql_error());
$row_cheque = mysql_fetch_assoc($RS_cheque);
$sw=false;
do{ 
extract($row_cheque); ?>
        <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
          <td width="25%" align="center"><?php echo $NumChequera  ?></td>
          <td width="25%" align="center"><?php echo $NumCheque ?></td>
          </tr>
        <?php }while($row_cheque = mysql_fetch_assoc($RS_cheque)); ?>
        </tbody>
    </table></td>
  </tr>
 </table>
<script type="text/javascript">
 
function showHide(elem) {
    if(elem.selectedIndex != 0) {
         //hide the divs
         for(var i=0; i < divsO.length; i++) {
             divsO[i].style.display = 'none';
        }
        //unhide the selected div
        document.getElementById('div'+elem.value).style.display = 'block';
    }
}
 
window.onload=function() {
    //get the divs to show/hide
    divsO = document.getElementById("form1").getElementsByTagName('div');
         for(var i=0; i < divsO.length; i++) {
             divsO[i].style.display = 'none';
        }
}
</script>
</body>
</html>