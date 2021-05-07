<?php
$MM_authorizedUsers = "91,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Asignacion (NivelCurso, Orden, Descripcion, Periodo, Monto, Monto_Dolares, Num_Cuotas, CodigoRelacionado, MesAno) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
  
                       GetSQLValueString($_POST['NivelCurso'], "text"),
                       GetSQLValueString($_POST['Orden'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Periodo'], "text"),
                       GetSQLValueString($_POST['Monto'], "double"),
                       GetSQLValueString($_POST['Monto_Dolares'], "double"),
					   
                       GetSQLValueString($_POST['Num_Cuotas'], "int"),
                       GetSQLValueString($_POST['CodigoRelacionado'], "int"),
                       GetSQLValueString($_POST['ReferenciaMesAno'], "text"));//ReferenciaMesAno
echo $insertSQL;
  //mysql_select_db($database_bd, $bd);
	
  $Result1 = $mysqli->query($insertSQL); // mysql_query($insertSQL, $bd) or die(mysql_error());
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Asignacion SET SWActiva=%s, Orden=%s, Descripcion=%s, NivelCurso=%s, Periodo=%s, Monto=%s, Monto_Dolares=%s, Num_Cuotas=%s, 
  						Mod_Fecha=NOW(),	Mod_Por=%s , SWiva=%s , CodigoRelacionado=%s,
						MesAno=%s
  						WHERE Codigo=%s",
                       GetSQLValueString(isset($_POST['SWActiva']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Orden'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['NivelCurso'], "text"),
                       GetSQLValueString($_POST['Periodo'], "text"),
                       GetSQLValueString($_POST['Monto'], "double"),
                       GetSQLValueString($_POST['Monto_Dolares'], "double"),
					   
                       GetSQLValueString($_POST['Num_Cuotas'], "int"),
                       GetSQLValueString($MM_Username, "text"),
					   GetSQLValueString(isset($_POST['SWiva']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['CodigoRelacionado'], "int"),
                       GetSQLValueString($_POST['ReferenciaMesAno'], "text"),
                       
                       GetSQLValueString($_POST['Codigo'], "int"));
					   
					   
					   
echo $updateSQL;
  //mysql_select_db($database_bd, $bd);
  $Result1 = $mysqli->query($updateSQL); // mysql_query($updateSQL, $bd) or die(mysql_error());
}
if (isset($_POST["MM_update_Precio"])) {
  $updateSQL = sprintf("UPDATE Asignacion SET Monto=%s WHERE Descripcion=%s",
                       GetSQLValueString($_POST['Monto'], "double"),
                       GetSQLValueString($_POST['Descripcion'], "text")
					   );

 // mysql_select_db($database_bd, $bd);
  $Result1 = $mysqli->query($updateSQL); // mysql_query($updateSQL, $bd) or die(mysql_error());
}
$add_sql = "";
if (isset($_GET['Editar']))      { $add_sql = " AND Codigo=".$_GET['Codigo']; }

if (isset($_GET['CodigoCurso'])) { 
	$query_RS_Cursos = "SELECT * FROM Curso WHERE CodigoCurso = '".$_GET['CodigoCurso']."' ";
	$RS_Cursos = $mysqli->query($query_RS_Cursos); //
	$row_RS_Cursos = $RS_Cursos->fetch_assoc();
	
	//$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
	//$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
//echo $query_RS_Cursos;
	$add_sql = " AND (NivelCurso LIKE '%".$row_RS_Cursos['NivelCurso']."%' OR NivelCurso = '00')"; 
	}

if (isset($_GET['Descripcion'])) { $add_sql = " AND Descripcion='".$_GET['Descripcion']."'" ; }
//mysql_select_db($database_bd, $bd);
$query_RS_Asignaciones = "SELECT * FROM Asignacion 
							WHERE Asignacion.SWActiva = 1 
							".$add_sql." 
							ORDER BY Periodo, Orden, NivelCurso, Descripcion "; 
//echo $query_RS_Asignaciones;
$RS_Asignaciones = $mysqli->query($query_RS_Asignaciones); //
$row_RS_Asignaciones = $RS_Asignaciones->fetch_assoc();
$totalRows_RS_Asignaciones = $RS_Asignaciones->num_rows;
/*
$RS_Asignaciones = mysql_query($query_RS_Asignaciones, $bd) or die(mysql_error());
$row_RS_Asignaciones = mysql_fetch_assoc($RS_Asignaciones);
$totalRows_RS_Asignaciones = mysql_num_rows($RS_Asignaciones);
*/

$colname_RS_Asignacion = "-1";
if (isset($_GET['Codigo'])) {
  $colname_RS_Asignacion = $_GET['Codigo'];
}
$query_RS_Asignacion = sprintf("SELECT * FROM Asignacion WHERE Codigo = %s", GetSQLValueString($colname_RS_Asignacion, "int"));
$RS_Asignacion = $mysqli->query($query_RS_Asignacion); //
$row_RS_Asignacion = $RS_Asignacion->fetch_assoc();
$totalRows_RS_Asignacion = $RS_Asignacion->num_rows;
/*
$RS_Asignacion = mysql_query($query_RS_Asignacion, $bd) or die(mysql_error());
$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion);
$totalRows_RS_Asignacion = mysql_num_rows($RS_Asignacion);
*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #0000FF}
-->
</style>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Asignaciones";
	require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table width="90%" border="0" align="center">
        <tr>
          <td><table width="100%" border="0">
              <tr>
                <td width="50%" valign="top"><table width="100%" border="0">
                    <tr>
                      <td colspan="4">
                        <?php 
$CodigoCurso = $_GET['CodigoCurso'];			
$Destino = "Asignaciones.php";		  
//MenuCursos ($CodigoCurso, $Destino ,$database_bd, $bd) ?>&nbsp;
                      </td>
                      <td colspan="2">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="3" align="right"><?php if (isset($_GET['CodigoCurso']) or isset($_GET['Descripcion']) or isset($_GET['Codigo'])) {?>
                          <a href="Asignaciones.php" class="style1">ver todos</a>
                          <?php } ?></td>
                    </tr>
                    <?php 
		  $total = 0;

		  
		  do { 
		  
		  if($PeriodoAnte <> $row_RS_Asignaciones['Periodo']){
		  
		  ?>
                      <tr>
      <td colspan="10" align="center" class="NombreCampoTITULO"><?php 
    if($row_RS_Asignaciones['Periodo'] == "I")
        echo "Inscripción";
    elseif($row_RS_Asignaciones['Periodo'] == "E")
        echo "Eventual";
    elseif($row_RS_Asignaciones['Periodo'] == "MF")
        echo "Mensual Fijo";
    elseif($row_RS_Asignaciones['Periodo'] == "M")
        echo "Mensual";
    elseif($row_RS_Asignaciones['Periodo'] == "X")
        echo "Extraordinario";
     ?>&nbsp;</td>
                      </tr>
	                <tr>
                      <td align="center" class="TituloLeftWindow">Nivel</td>
                      <td align="center" class="TituloLeftWindow">Codigo</td>
                      <td class="TituloLeftWindow">&nbsp;</td>
                      <td class="TituloLeftWindow">Descripci&oacute;n</td>
                      <td class="TituloLeftWindow">$</td>
                      <td class="TituloLeftWindow">Bs</td>
                      <td class="TituloLeftWindow">iva</td>
                      <td class="TituloLeftWindow">&nbsp;</td>
                      <td class="TituloLeftWindow">&nbsp;</td>
                      <td class="TituloLeftWindow">&nbsp;</td>
                    </tr>
<?php } ?>
                      <tr>
                      <td align="left" class="FondoCampo">
                        <?php if( $row_RS_Asignaciones['NivelCurso'] == '00')
					  			echo 'Todos';
							else
								echo $row_RS_Asignaciones['NivelCurso']; ?></td>
                      <td align="left" nowrap="nowrap" class="FondoCampo"><?php echo $row_RS_Asignaciones['Codigo'] ?> -&gt; <?php echo $row_RS_Asignaciones['CodigoRelacionado'] ?></td>
                      <td class="FondoCampo"><?php echo $row_RS_Asignaciones['Orden'] ?></td>
                      <td class="FondoCampo"><?php echo $row_RS_Asignaciones['Descripcion'] ?> (<?php echo $row_RS_Asignaciones['Num_Cuotas'] ?>)</td>
                      <td align="right" class="FondoCampo"><?php echo Fnum($row_RS_Asignaciones['Monto_Dolares']); ?></td>
                      <td align="right" class="FondoCampo"><?php 
					  if ($row_RS_Asignaciones['Monto_Dolares'] > 0 and $row_RS_Asignaciones['Monto'] == 0){
						    $Monto_aux = round($row_RS_Asignaciones['Monto_Dolares'] * (float)$Cambio_Dolar, 2);
						  }
					  else{
							$Monto_aux = round($row_RS_Asignaciones['Monto'] , 2);
						  }  
					  echo Fnum($Monto_aux); $total+=$Monto_aux ; ?></td>
                      <td align="right" class="FondoCampo"><?php echo $row_RS_Asignaciones['SWiva']; ?></td>
                      <td align="right" class="FondoCampo"><?php echo $row_RS_Asignaciones['MesAno']; ?></td>
                      <td align="right" class="FondoCampo"><?php echo $row_RS_Asignaciones['Num_Cuotas']; ?></td>
                      <td align="right" class="FondoCampo"><a href="Asignaciones.php?Editar=1&amp;Codigo=<?php echo $row_RS_Asignaciones['Codigo']; ?>" target="_blank"><img src="../../../img/b_edit.png" width="16" height="16" border="0" /></a></td>
                    </tr>
                    <?php 
					
$PeriodoAnte = $row_RS_Asignaciones['Periodo'];		
$row_RS_Asignaciones = $RS_Asignaciones->fetch_assoc();			

if($PeriodoAnte <> $row_RS_Asignaciones['Periodo']) {?>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="2" align="right"><?php echo Fnum($total); $total=0; ?>&nbsp;</td>
                      <td align="right">&nbsp;</td>
                    </tr>
<?php 	}		
					} while ($row_RS_Asignaciones ); ?>
                    
                </table></td>
              </tr><tr>
                <td valign="top"><form action="<?php echo "Asignaciones.php"; if (isset($_GET['Codigo'])) echo "?Editar=1&Codigo=".$_GET['Codigo']; ?>" method="POST" name="form1" id="form1">
                    <table width="100%" align="center">
                      <tr valign="baseline">
                        <td align="left" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">Nivel</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">Cod Rel</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">orden</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo"><input type="hidden" name="Codigo" value="<?php echo $row_RS_Asignacion['Codigo'] ?>" />
Descripcion</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">$</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">Bs</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">iva</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">Periodo</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">Mes de</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo"># Cuot</td>
                        <td align="left" nowrap="nowrap" class="NombreCampo">SWActiva</td>
                      </tr>
                      <tr valign="baseline">
                        <td align="left" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input name="NivelCurso" type="text" value="<?php echo $row_RS_Asignacion['NivelCurso']; ?>" size="30" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="CodigoRelacionado" value="<?php echo $row_RS_Asignacion['CodigoRelacionado']; ?>" size="5" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="Orden" value="<?php echo $row_RS_Asignacion['Orden']; ?>" size="5" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="Descripcion" value="<?php echo $row_RS_Asignacion['Descripcion']; ?>" size="30" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo">
                        <input name="Monto_Dolares" type="text" value="<?php echo $row_RS_Asignacion['Monto_Dolares'] ?>" size="10" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input name="Monto2" type="text" value="<?php echo $row_RS_Asignacion['Monto'] ?>" size="10" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input name="SWiva" type="checkbox" value="1" <?php if($_POST['SWiva']==1 or $row_RS_Asignacion['SWiva']==1 ) { echo "checked";} ?> /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><select name="Periodo" class="TextosSimples">
  <?php  if(isset($_GET['Editar'])){$aux = $row_RS_Asignacion['Periodo'];}else{ $aux = $_POST['Periodo'];} ?>
  <option value="0" <?php if (!(strcmp("0", $aux))) {echo "SELECTED";} ?>>Seleccione</option>
  <option value="I" <?php if (!(strcmp("I", $aux))) {echo "SELECTED";} ?>>Inscripci&oacute;n</option>
  <option value="M" <?php if (!(strcmp("M", $aux))) {echo "SELECTED";} ?>>Mensual</option>
  <option value="MF" <?php if (!(strcmp("MF", $aux))) {echo "SELECTED";} ?>>Mensual Fijo</option>
  <option value="A" <?php if (!(strcmp("A", $aux))) {echo "SELECTED";} ?>>Anual</option>
  <option value="E" <?php if (!(strcmp("E", $aux))) {echo "SELECTED";} ?>>Eventual</option>
  <option value="X" <?php if (!(strcmp("X", $aux))) {echo "SELECTED";} ?>>Extra</option>
</select></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><select name="ReferenciaMesAno" id="ReferenciaMesAno" class="TextosSimples">
                          <option value="0">Seleccione...</option>
                          <option value="Ins 19">Ins 19</option>
                          <?php 
							
		
							
foreach($ReferenciaMesAno_array as $ReferenciaMesAno){
	echo "<option value=\"$ReferenciaMesAno\"";
		
	if($_POST['ReferenciaMesAno'] == $ReferenciaMesAno or $row_RS_Asignacion['MesAno'] == $ReferenciaMesAno){
		echo " selected=\"selected\"";
	}
	
	echo " >$ReferenciaMesAno </option>";
}
?>
                        </select></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="Num_Cuotas" value="<?php echo $row_RS_Asignacion['Num_Cuotas']; ?>" size="5" /></td>
                        <td align="left" nowrap="nowrap" class="FondoCampo"><input name="SWActiva" type="checkbox" value="1" <?php if($_POST['SWActiva']==1 or $row_RS_Asignacion['SWActiva']==1 or !isset($_POST['SWActiva'])) { echo "checked";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td colspan="8" align="right" nowrap="nowrap"><?php if (isset($_GET['Editar'])) { ?>
                        <input type="hidden" name="MM_update" value="form1" />
                            <?php } else {?>
                            <input type="hidden" name="MM_insert" value="form1" /><?php } ?>
                        <td colspan="4"><input type="submit" value="Guardar" /></td>
                      </tr>
                    </table>
                </form>
                <p>&nbsp;</p>
                <form action="<?php echo "Asignaciones.php"; if (isset($_GET['Codigo'])) echo "?Editar=1&Codigo=".$_GET['Codigo']; ?>" method="POST" name="form1" id="form1">
                    <table width="250" align="center">
                      <tr valign="baseline">
                        <td colspan="2" nowrap="nowrap" class="subtitle">Actualiza precio en masa</td>
                      </tr>
                      
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap" class="NombreCampo">Descripcion</td>
                        <td class="FondoCampo"><span id="sprytextfield1">
                          <input type="text" name="Descripcion" class="TextosSimples" value="<?php echo $_GET['Descripcion']; ?>" size="15" />
                          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap" class="NombreCampo">Monto</td>
                        <td class="FondoCampo"><span id="sprytextfield2">
                          <input name="Monto" class="TextosSimples" type="text" value="<?php echo $row_RS_Asignacion['Monto']; ?>" size="15" />
                          <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">
                          
                        <input type="hidden" name="MM_update_Precio" value="form1" />
                        <td><input type="submit" value="Actializar" /></td>
                      </tr>
                    </table>
                  </form>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>