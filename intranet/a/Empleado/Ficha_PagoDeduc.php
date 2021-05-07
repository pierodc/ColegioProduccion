<?php 
$MM_authorizedUsers = "91,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

//$Alumno = new Alumno($CodigoAlumno);



if(!TieneAcceso($Acceso_US,"Sueldo")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}

if(isset($_POST['Descripcion'])){
	setcookie("Descripcion",$_POST['Descripcion'],time()+1200);
	setcookie("Tipo",$_POST['Tipo'],time()+1200);
	setcookie("Monto",$_POST['Monto'],time()+1200);
	}
$Descripcion = $_COOKIE["Descripcion"];
$Tipo  = $_COOKIE["Tipo"];
$Monto = $_COOKIE["Monto"];


if(isset($_GET['BC']))
	$add_url = "&BC=1";


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING'].$add_url);
}

					  			


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2") and ($MM_UserGroup == 'Contable' or $MM_UserGroup == 91)) {
	
	$QuincenaCompleta = explode ('-' , $_POST['QuincenaCompleta']);
	$Ano      = $QuincenaCompleta[0];
	$Mes      = substr('0'.$QuincenaCompleta[1],-2);
	$Quincena = $QuincenaCompleta[2];
	
	
  	$insertSQL = sprintf("INSERT INTO Empleado_Deducciones (Codigo_Empleado, Tipo, Quincena, Mes, Ano, Descripcion, Monto, RegistradoPor) 
  						VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Codigo_Empleado'], "int"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($Quincena, "text"),
                       GetSQLValueString($Mes, "text"),
                       GetSQLValueString($Ano, "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString(coma_punto($_POST['Monto']), "double"),
                       GetSQLValueString($MM_Username, "text"));
	
	if(isset($_GET['BC'])){
		 	$CodigoQuincena = $Ano ." ". $Mes ." BC";
			$insertSQL = sprintf("INSERT INTO Empleado_Pago (Codigo_Empleado, Codigo_Quincena, Concepto, Monto, Obs, Registro_Por) 
							VALUES (%s, %s, %s, %s, %s, %s)",
						   	GetSQLValueString($_POST['Codigo_Empleado'], "int"),
							GetSQLValueString($CodigoQuincena, "text"),  
							GetSQLValueString("+BC", "text"),
							GetSQLValueString(coma_punto($_POST['Monto']), "double"), 
							GetSQLValueString($_POST['Descripcion'], "text"),
							GetSQLValueString($MM_Username, "text"));
	}
	
	
	//echo  "<br><br><br>sql:".$insertSQL;
	//mysql_select_db($database_bd, $bd);
	
	
$RS = $mysqli->query($insertSQL);

	//$Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());

}

if (isset($_GET['Elimina']) and !isset($_GET['BC']) and ($MM_UserGroup == 'Contable' or $MM_UserGroup == 91)) {
  $Elimina = $_GET['Elimina'];
  $CodigoEmpleado = $_GET['CodigoEmpleado']+10000;
  $sql = 'UPDATE Empleado_Deducciones Set Codigo_Empleado='.$CodigoEmpleado.', Registro_Por='.$MM_Username.' WHERE Codigo = '.$Elimina ;
  //echo "<br><br><br>" . $sql;
  $mysqli->query($sql);
//  $Result = mysql_query($sql, $bd) or die(mysql_error());
  $GoTo = $php_self."?CodigoEmpleado=".$_GET['CodigoEmpleado'].$add_url;
  header(sprintf("Location: %s", $GoTo));
}

if (isset($_GET['Elimina']) and isset($_GET['BC']) and ($MM_UserGroup == 'Contable' or $MM_UserGroup == 91)) {
  $Elimina = $_GET['Elimina'];
  $CodigoEmpleado = $_GET['CodigoEmpleado']+10000;
  $sql = 'UPDATE Empleado_Pago Set Codigo_Empleado='.$CodigoEmpleado.' WHERE Codigo = '.$Elimina ;
  //echo "<br><br><br>" . $sql;
  $mysqli->query($sql);
//  $Result = mysql_query($sql, $bd) or die(mysql_error());
  $GoTo = $php_self."?CodigoEmpleado=".$_GET['CodigoEmpleado'].$add_url;
  header(sprintf("Location: %s", $GoTo));
}


if (isset($_POST['Buscar'])) {
	$aux = explode(" ",strtolower( $_POST['Buscar']));
	$query_RS_Empleados = "SELECT * FROM Empleado 
								WHERE SW_Activo = 1 ";
	$query_RS_Empleados .= "AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[0]%'";
	if($aux[1]!=""){
		$query_RS_Empleados .= " AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[1]%'";
		}
	if($aux[2]!=""){
		$query_RS_Empleados .= " AND LOWER(CONCAT_WS(' ',Apellidos,Apellido2,Nombres,Nombre2)) LIKE '%$aux[2]%'";
		}

	
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$row_RS_Empleados = $RS_Empleados->fetch_assoc();
$totalRows_RS_Empleados = $RS_Empleados->num_rows;

/*
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
	$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
	//$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);*/
	
	header("Location: ".$php_self."?CodigoEmpleado=".$row_RS_Empleados["CodigoEmpleado"].$add_url);

	
}	


$colname_RS_Empleados = "-1";
if (isset($_GET['CodigoEmpleado'])) {
  $colname_RS_Empleados = $_GET['CodigoEmpleado'];
}
$query_RS_Empleados = sprintf("SELECT * FROM Empleado 
								WHERE CodigoEmpleado = %s 
								ORDER BY Apellidos ASC", 
								GetSQLValueString($colname_RS_Empleados, "int"));
										
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$row_RS_Empleados = $RS_Empleados->fetch_assoc();
$totalRows_RS_Empleados = $RS_Empleados->num_rows;
/*
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);*/
$Monto = $row_RS_Empleados['SueldoBase_3']*3;

$colname_RS_Empleados = $row_RS_Empleados["CodigoEmpleado"];

$query_RS_Empleados_Deduc = sprintf("SELECT * FROM Empleado_Deducciones 
											WHERE Codigo_Empleado = %s 
											AND (Tipo <> '50' AND Tipo <> '51') 
											ORDER BY Ano, Mes, Quincena", 
											GetSQLValueString($colname_RS_Empleados, "int"));
if(isset($_GET['Salario'])){
	$query_RS_Empleados_Deduc = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '$colname_RS_Empleados' 
								AND Concepto = '+SueldoBase'
								ORDER BY Codigo_Quincena";
 //echo $query_RS_Empleados_Deduc;
}
	
if(isset($_GET['Pagos'])){
	$query_RS_Empleados_Deduc = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '$colname_RS_Empleados' 
								AND Monto > 0
								ORDER BY Codigo_Quincena";
 //echo $query_RS_Empleados_Deduc;
}
if(isset($_GET['BC'])){
	$query_RS_Empleados_Deduc = "SELECT * FROM Empleado_Pago 
								WHERE Codigo_Empleado = '$colname_RS_Empleados' 
								AND Concepto = '+BC'
								ORDER BY Codigo_Quincena, Fecha_Registro";
 //echo $query_RS_Empleados_Deduc;
}
				
$RS_Empleados_Deduc = $mysqli->query($query_RS_Empleados_Deduc);
$row_RS_Empleados_Deduc = $RS_Empleados_Deduc->fetch_assoc();
$totalRows_RS_Empleados_Deduc = $RS_Empleados_Deduc->num_rows;
/*											
$RS_Empleados_Deduc = mysql_query($query_RS_Empleados_Deduc, $bd) or die(mysql_error());
$row_RS_Empleados_Deduc = mysql_fetch_assoc($RS_Empleados_Deduc);
$totalRows_RS_Empleados_Deduc = mysql_num_rows($RS_Empleados_Deduc);
*/


// Para calculo de dias de ausencia
$ivss = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_ivss'] * 0.04 ;
$lph  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_lph']  * 0.01 ; 
$spf  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_spf']  * 0.005 ;
$SueltoNeto = round($row_RS_Empleados['SueldoBase'] - $ivss - $lph - $spf,2) ; 
$SueldoDiario = round($SueltoNeto/15 , 2 );	



$TituloPantalla = $TituloPagina = "" . $row_RS_Empleados['Apellidos']." ".$row_RS_Empleados['Nombres'];



require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
   
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
   
 <div class="row">
	<div class="col-md-3">
<table class="sombra" >
<caption class="RTitulo">Empleado</caption>
<tbody>
<tr>
	<th colspan="5"><? 
		MenuEmpleado ($_GET['CodigoEmpleado'], $_SERVER['PHP_SELF']."?BC=1" , "Cargo"); //ApeNom  ?>
	</th>
</tr>
	
	
<tr>
	<th >No</th>
	<th colspan="4">Nombre</th>
</tr>
<?

if(false){		
$query = "SELECT * FROM Empleado 
			WHERE SW_activo = 1 
			ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres";			
$RS = $mysqli->query($query);
while ($row = $RS->fetch_assoc()) {

	$ListaEmpleado[$i][Nombre] = $row['Apellidos'].' '.$row['Nombres'];
	$ListaEmpleado[$i][Codigo] = $row['CodigoEmpleado'];
	$ListaEmpleado[$i][BC] = $row['BC'];
	$ListaEmpleado[$i][Pago_extra_dolares] = $row['Pago_extra_dolares'];
	$i++;
?>    
	<tr class="hover <? if($_GET["CodigoEmpleado"] == $row['CodigoEmpleado']) echo "seleccionado"; ?>">
	<td><? echo ++$No; ?></td>
	
	<td nowrap="nowrap"><a href="<?= $_SERVER['PHP_SELF']."?BC=1&CodigoEmpleado=".$row['CodigoEmpleado']; ?>"><? echo $row['Apellidos'].' '.$row['Nombres']; ?></a></td>
	<td nowrap="nowrap" align="right"><?
	if($MM_Username =="piero")
		echo $row['BC'] ?></td>
	<td nowrap="nowrap" align="right"><? 
	
	if($MM_Username =="piero")	
	  echo $row['Pago_extra_dolares'];
	$Total_por_pagar += $row['Pago_extra_dolares'];
		
		?></td>
	<td nowrap="nowrap" align="right"><? Frame_SW ('CodigoEmpleado',$row['CodigoEmpleado'],'Empleado','SW_aux',$row['SW_aux']);
 ?></td>
	</tr>
	
<? }
}
		?>  

  <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;<?= Fnum($Total_por_pagar) ?></td>
  	<td>&nbsp;</td>
  </tr>  
</tbody>
</table>
    </div>                  
    
	<div class="col-md-9">
        
<table class="sombra ancho centro">
  <tr>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"> <img src="../../../i/client_account_template.png" width="32" height="32" border="0" align="absmiddle" /> Ficha</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Asist.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/calendar_edit.png" width="32" height="32" border="0" align="absmiddle" />Asistencia</a></td>
    <td width="25%" nowrap="nowrap"><a href="Ficha_Fidei.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/sallary_deferrais.png" width="32" height="32" border="0" align="absmiddle" /> Fideicomiso</a></td>
    <td width="12%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos Deducciones</a></td>
   
   
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&Salario=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Salario</a></td>
    
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&Pagos=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> Pagos</a></td>
    
    <td width="13%" nowrap="nowrap"><a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $_GET['CodigoEmpleado'] ?>&BC=1"><img src="../../../i/coins_in_hand.png" width="32" height="32" border="0" align="absmiddle" /> BC</a></td>
    
     <td colspan="2" align="right" nowrap="nowrap"><form id="form3" name="form3" method="post" action="<?php $php_self; ?>">
            <input type="text" name="Buscar" id="Buscar" />
            <input type="submit" name="submit" id="submit" value="Buscar" class="button" />
          </form></td>
    
  </tr>
</table>


        
              
          
       
         
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
	 <table class="ancho centro">
<caption>Prestamos Devoluciones Deducciones BC</caption>
 
     <tr>
	 <td colspan="3">
	 </td>
	 <td colspan="7" valign="top">BC Mes: <?= Campo_Edit_Empleado ("Empleado",$row_RS_Empleados['CodigoEmpleado'],"BC"); ?></td>
	 <td colspan="3">Depositar: <?= Campo_Edit_Empleado ("Empleado",$row_RS_Empleados['CodigoEmpleado'],"Pago_extra_dolares"); ?>
		 Bs.<?= round($row_RS_Empleados['Pago_extra_dolares'] * $Cambio_Paralelo , 2) ?></td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
     </tr>
 
 
<tr>
  <td colspan="2" align="center" class="NombreCampo">Fecha</td>
  <td align="center" class="NombreCampo">Quincena  </td>
  <td align="center" class="NombreCampo">Tipo</td>
  <td align="center"  class="NombreCampo">Descipci&oacute;n</td>
  <td colspan="5" align="center" class="NombreCampo">D.Aus</td>
  <td colspan="2" align="center" class="NombreCampo">D. Reposo</td>
  <td align="center" class="NombreCampo">Monto</td>
  <td align="center" class="NombreCampo">&nbsp;</td>
  <td align="center" class="NombreCampo">&nbsp;</td>
</tr>


<tr>
  <td colspan="4" align="center" class="FondoCampo"><select name="QuincenaCompleta" id="QuincenaCompleta">
      <option value="0">Seleccione</option>
      <?php 
	$Selected=false; 
	if(!isset($_POST['QuincenaCompleta'])) {
	$QuincenaHoy = date('Y-').date('m')*1 .'-';
		if (date('d')<=15) {
				$QuincenaHoy = $QuincenaHoy . '1';}
		else{
				$QuincenaHoy = $QuincenaHoy . '2';}	}				

	for ( $_Ano = date('Y')-1; $_Ano <= date('Y')+1; $_Ano++ ){
		for ( $_Mes = 1; $_Mes <= 13; $_Mes++ ){
			for ( $_Qui = 1; $_Qui <= 2; $_Qui++ ){
				$Mesde = Mes($_Mes);
				$_Quincena = $_Ano.'-'.$_Mes.'-'.$_Qui;
				echo '<option value="'.$_Quincena.'" ';
				if($Selected or $QuincenaHoy==$_Quincena){ 
					echo ' selected="selected"'; $Selected=false; }

				echo '>'.$_Qui.'º '.$Mesde.' '.$_Ano.'</option>
				';
				if($_POST['QuincenaCompleta']==$_Quincena){ $Selected=true; }

			}}}
	?>
      </select>      <select name="Tipo" id="Tipo">
          <option value="0">Selecc..</option>
          <option value="AQ"<?php if ($_POST['Tipo']=='AQ' or $Tipo == 'AQ') echo ' selected="selected"'; ?>  name=Adelanto onmouseup="this.form.Monto.value=100;"  >(-) Adelanto Quincena</option>
          <option value="AU"<?php if ($_POST['Tipo']=='AU' or $_GET['Tipo']=="AU" or $Tipo == 'AU') echo ' selected="selected"'; ?>>(-) Ausencia</option>
          <option value="DE"<?php if ($_POST['Tipo']=='DE' or $Tipo == 'DE') echo ' selected="selected"'; ?>>(-) Deducción</option>
          <option value="PP"<?php if ($_POST['Tipo']=='PP' or $Tipo == 'PP') echo ' selected="selected"'; ?>>(-) Pago de prestamo</option>
          <option value="BO"<?php if ($_POST['Tipo']=='BO' or $Tipo == 'BO') echo ' selected="selected"'; ?> >(+) Bonificación</option>
          <option value="PR"<?php if ($_POST['Tipo']=='PR' or $Tipo == 'PR') echo ' selected="selected"'; ?>>(+) Prestamo</option>
          <option value="RE"<?php if ($_POST['Tipo']=='RE' or $Tipo == 'RE') echo ' selected="selected"'; ?> >(+) Reintegro</option>
          <option value="PA"<?php if ($_POST['Tipo']=='PA' or $Tipo == 'PA') echo ' selected="selected"'; ?> >(+) Pago</option>
          <option value="BC"<?php if ($_POST['Tipo']=='BC' or $Tipo == 'BC' or isset($_GET['BC'])) echo ' selected="selected"'; ?> >(+) BC</option>
          
      </select></td>
  <td align="center" class="FondoCampo"><label for="Tipo"></label>
      <?php if($_GET['Tipo']=="AU"){$Descripcion = $Dias_Aus;}
		else {$Descripcion = $_POST['Descripcion'];} 
		 ?>
      <input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion; ?>" size="25" onfocus="this.value='<?php echo $Descripcion; ?>'" /></td>
  <td colspan="5" align="center" class="FondoCampo"><input name="Dias" type="text" id="Dias" size="5" 
  onkeyup="this.form.Monto.value=this.form.Dias.value*<?php echo $SueldoDiario ?>"
  onfocus="this.form.Monto.value=<?php echo $SueldoDiario*$N_Dias ?>;
			this.value=<?php echo $N_Dias; ?>"
  <?php if($_GET['Tipo']=="AU") echo ' value="'.$N_Dias.'"'; ?>   /></td>
  <td colspan="2" align="center" class="FondoCampo"><input name="DiasR" type="text" id="DiasR" size="5" onkeyup="this.form.Monto.value=this.form.DiasR.value*<?php echo round($SueldoDiario*.6666 , 2) ?>" /></td>
  <td align="right" class="FondoCampo">
  <input name="Monto" type="text" id="Monto" required value="" >
  </td>
  <td align="center" class="FondoCampo"><input type="submit" name="button" id="button" value="G" class="button" />
   <input type="hidden" name="MM_insert" value="form2" />
	<input name="Codigo_Empleado" type="hidden" id="Codigo_Empleado" value="<?php echo $row_RS_Empleados['CodigoEmpleado']; ?>" /></td>
  <td align="center" class="FondoCampo">&nbsp;</td>
</tr>
<?php if ($totalRows_RS_Empleados_Deduc>0){ ?>



<tr  class="NombreCampo">
  <td colspan="4" align="center" class="NombreCampo">Quincena</td>
  <td class="NombreCampo">&nbsp;</td>
	  <td align="right" class="NombreCampo">Deduc</td>
	  <td align="right" class="NombreCampo">Pago</td>
	  <td colspan="3" align="right" class="NombreCampo">Suma Mes</td>
	  <td align="right" class="NombreCampo">Prest</td>
	  <td align="right" class="NombreCampo">Pago</td>
	  <td align="right" class="NombreCampo">Saldo</td>
	  <td align="center" class="NombreCampo">&nbsp;</td>
	  <td align="center" class="NombreCampo">&nbsp;</td>
	</tr>


<?php do { ?>
	<?php 

	/*if (date('d') <= 15) {
				$QuincenaHoy = '1';}
		else{
				$QuincenaHoy = '2';}




	if($row_RS_Empleados_Deduc['Mes'] == date('m') 
			and $row_RS_Empleados_Deduc['Ano'] == date('Y')
			and $row_RS_Empleados_Deduc['Quincena'] == $QuincenaHoy ) //
		$Verde = true; 
	else 
		$Verde = false;

*/


	if($AnoAnte != $row_RS_Empleados_Deduc['Ano']){
	?>
	<tr>
	  <td colspan="15" align="left" class="NombreCampoBIG" ><?php 
	  echo $row_RS_Empleados_Deduc['Ano']; ?></td>
	</tr><?php } ?>

	<? 

	$Verde = 0;
	if( substr( $row_RS_Empleados_Deduc['Codigo_Quincena'] ,5,2) == date('m')  
		and substr( $row_RS_Empleados_Deduc['Codigo_Quincena'] ,0,4) == date('Y')  ){
		$Verde = 1;
	}




			 ?>
	<tr  <?php 


  if(!isset($_GET['BC']) and $QuincenaAnte != $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes'])
		$sw = ListaFondo($sw,$Verde); 

	if(isset($_GET['BC']) and $QuincenaAnte != $row_RS_Empleados_Deduc['Codigo_Quincena'])	{
		$sw = ListaFondo($sw,$Verde); 
		$MontoBCmes = 0;

	}	



  ?>>
  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php echo substr($row_RS_Empleados_Deduc['RegistradoPor'].$row_RS_Empleados_Deduc['Registro_por'],0,5); ?></td>
  <td align="center" nowrap="nowrap" <?php ListaFondo($sw,$Verde); ?>><?php echo DDMM($row_RS_Empleados_Deduc['Fecha_Registro']); ?></td>
  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php 

  if($Quincena_Anterior != $row_RS_Empleados_Deduc['Codigo_Quincena'])
  if(!isset($_GET['BC']) and $QuincenaAnte != $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes']){
	  echo $row_RS_Empleados_Deduc['Quincena'].'&ordm; '; 
	  echo substr(Mes($row_RS_Empleados_Deduc['Mes']),0,3); 
	  echo "-"; 
	  echo substr($row_RS_Empleados_Deduc['Ano'],2,2); 
  }
	else {
		echo $row_RS_Empleados_Deduc['Codigo_Quincena'];
	  }

	$Quincena_Anterior = $row_RS_Empleados_Deduc['Codigo_Quincena'];

 ?></td>
  <td align="left" <?php ListaFondo($sw,$Verde); ?>><?php 

switch ($row_RS_Empleados_Deduc['Tipo']) {
case 'PR':
echo "Prestamo"; break;
case 'PP':
echo "Pago de prestamo"; break;
case 'AU':
echo "Ausencia"; break;
case 'DE':
echo "Otra Deducción"; break;
case 'AQ':
echo "Adelanto Quincena"; break;
case 'BO':
echo "Bonificación"; break;
case 'PA':
echo "Pago"; break;
case 'RE':
echo "Reintegro"; break;

}
  ?></td>
  <td <?php ListaFondo($sw,$Verde); ?>><?php 
  echo $row_RS_Empleados_Deduc['Descripcion']." "; 
  echo $row_RS_Empleados_Deduc['Concepto']; 
  echo ": ".$row_RS_Empleados_Deduc['Obs']; 

  ?></td>
  <td colspan="2" align="right" <?php ListaFondo($sw,$Verde); ?>><?php 


  if(isset($_GET['Salario']) or isset($_GET['Pagos']) ){
	  echo Fnum($row_RS_Empleados_Deduc['Monto']);
  }

  if ( $row_RS_Empleados_Deduc['Tipo']=='AU' or 
	   $row_RS_Empleados_Deduc['Tipo']=='DE' or 
	   $row_RS_Empleados_Deduc['Tipo']=='AQ') { 
			  echo '<span class="Rojo">'; 
			  echo "-".Fnum($row_RS_Empleados_Deduc['Monto']); 
			  echo '</span>'; 
  }

  if ( $row_RS_Empleados_Deduc['Tipo']=='BO' or 
	   $row_RS_Empleados_Deduc['Tipo']=='PA' or 
	   $row_RS_Empleados_Deduc['Tipo']=='RE') { 
			  echo '<span class="Azul">'; 
			  echo Fnum($row_RS_Empleados_Deduc['Monto']); 
			  echo '</span>'; 
  } 

	if(isset($_GET['BC'])){
	  echo Fnum($row_RS_Empleados_Deduc['Monto']);
	  $MontoBCmes += $row_RS_Empleados_Deduc['Monto'];
  }				

	if(substr($row_RS_Empleados_Deduc['Fecha_Registro'],0,10) == date('Y-m-d')){
	  echo " <b>" . $row_RS_Empleados_Deduc['Monto'] * $Cambio_Paralelo . "</b>";
		$PagoHoy += $row_RS_Empleados_Deduc['Monto'];
	}
	  ?></td>
  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
  <td align="right" <?php ListaFondo($sw,$Verde); ?>><?

			if ($Codigo_Quincena_Ante != $row_RS_Empleados_Deduc['Codigo_Quincena']){
				$SumaQuincena = $row_RS_Empleados_Deduc['Monto'];
			}
			else{
				$SumaQuincena += $row_RS_Empleados_Deduc['Monto'];
			}

			//echo Fnum($SumaQuincena);

			$Codigo_Quincena_Ante = $row_RS_Empleados_Deduc['Codigo_Quincena'];

			if($MontoBCmes == $row_RS_Empleados['BC'])
				echo "<b>";
			echo Fnum($MontoBCmes);



	  ?></td>
  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;</td>
  <td colspan="2" align="right" <?php ListaFondo($sw,$Verde); ?>><?php 
  if ( $row_RS_Empleados_Deduc['Tipo']=='PR') {
	  echo '<span class="Azul">'; 
	  echo Fnum($row_RS_Empleados_Deduc['Monto']);
	  $Pendiente +=$row_RS_Empleados_Deduc['Monto']; 
	  $Saldo  	 +=$row_RS_Empleados_Deduc['Monto'];
	  echo '</span>'; 
  } 

  elseif ( $row_RS_Empleados_Deduc['Tipo']=='PP') { 
	  echo '<span class="Rojo">'; 
	  echo "-".Fnum($row_RS_Empleados_Deduc['Monto']); 
	  $Pendiente -=$row_RS_Empleados_Deduc['Monto']; 
	  $Saldo  	 -=$row_RS_Empleados_Deduc['Monto'];
	  echo '</span>'; 
  } 




	  ?></td>
  <td align="right" <?php ListaFondo($sw,$Verde); ?>>&nbsp;<?php //echo Fnum($Saldo); 

  if( $row_RS_Empleados_Deduc['Tipo'] == 'PP' ){
	$sql = "UPDATE Empleado_Deducciones 
			SET Descripcion = 'Resta: ".Fnum($Saldo)."'
			WHERE Codigo = '".$row_RS_Empleados_Deduc['Codigo']."'";
	mysql_query($sql, $bd);
	//echo $sql;
	}

  //echo Fnum($row_RS_Empleados['BC']-$MontoBCmes) ;

	$Pendiente_BC -= $row_RS_Empleados['BC'];

  ?></td>
  <td align="center" <?php ListaFondo($sw,$Verde); ?>><?php 
		if (substr($row_RS_Empleados_Deduc['Fecha_Registro'],0,10) == date('Y-m-d') or $row_RS_Empleados_Deduc['Fecha_Registro']==date('Y-m-d') or $MM_Username=='piero' ){
				?><a href="<?php echo $php_self ?>?CodigoEmpleado=<?php echo $row_RS_Empleados['CodigoEmpleado'].$add_url; ?>&Elimina=<?php echo $row_RS_Empleados_Deduc['Codigo']; ?>"><img src="../../../i/bullet_delete.png" width="16" height="16" border="0" /></a><?php 
		} ?>&nbsp;</td>
  <td align="center" <?php ListaFondo($sw,$Verde); ?>>&nbsp;<?= $row_RS_Empleados_Deduc['RegistradoPor'] ?></td>
    </tr>
	<?php 

$AnoAnte = $row_RS_Empleados_Deduc['Ano'];



$QuincenaAnte = $row_RS_Empleados_Deduc['Quincena'].$row_RS_Empleados_Deduc['Mes'];
if(isset($_GET['BC']))		
	$QuincenaAnte = $row_RS_Empleados_Deduc['Codigo_Quincena'];

$Pendiente_BC += $row_RS_Empleados['BC'];
 } while ($row_RS_Empleados_Deduc = $RS_Empleados_Deduc->fetch_assoc() ); ?>


<tr>
  <td colspan="2" align="center" class="FondoCampo">&nbsp;</td>
	  <td align="center" class="FondoCampo">&nbsp;</td>
	  <td class="FondoCampo">&nbsp;</td>
	  <td class="FondoCampo">Pagado hoy<?
		  if($PagoHoy > 0){
			  
			  echo "Pagado hoy: <br>".$PagoHoy;
			   echo " Bss : ".$PagoHoy* $Cambio_Paralelo;
		  }
						   
		  
		  ?></td>
	  <td colspan="7" align="right" class="FondoCampo">Pendiente </td>
	  <td align="right" class="FondoCampo"><?php echo Fnum($Pendiente+$Pendiente_BC); ?></td>
	  <td align="center" class="FondoCampo">&nbsp;</td>
	  <td align="center" class="FondoCampo">&nbsp;</td>
	</tr>

<?php } ?>
</table>

</form>
      
        <table class="ancho centro">
        <caption>Observaciones</caption>
        	<tr>
        		<td>
               <iframe src="/inc/Observacion.php?Area=Empleado-BC&Codigo=<?php echo $row_RS_Empleados['CodigoEmpleado'] ?>" width="100%" frameborder="0"></iframe>
        		</td>
        	</tr>
        </table>
              
                    
              
               	
     </div>
 </div>
            
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>







