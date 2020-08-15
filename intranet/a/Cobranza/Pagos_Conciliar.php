<?php
$MM_authorizedUsers = "99,91,95,90";
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
$TituloPantalla ="Pagos Conciliar";
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

//$TituloPantalla ="Archivos Banco";
//$Alumno = new Alumno($CodigoAlumno);

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
if($_GET['Oculto'] == 1){
		$Oculto = 1;
	}
else{
		$Oculto = 0;
	}

if($_GET['SWValidado'] == 1){
	$add_sql = " AND ContableMov.SWValidado = ". $_GET['SWValidado'];}
else{
	$add_sql = " AND ContableMov.SWValidado = '0'";}

if (isset($_POST['Fecha_'])) {
	$Fecha_ = $_POST['Fecha_'];
	header("Location: Pagos_Conciliar.php?Fecha_=$Fecha_");
}

elseif (isset($_GET['Fecha_']) and $_GET['Fecha_'] == "todo") {
	$Fecha_ = $_GET['Fecha_'];
	//$add_sql = "  AND ContableMov.Fecha >= '2019-11-01' AND ContableMov.Fecha <= '2019-11-31' ";
	$Oculto = 0;
	}
elseif (isset($_GET['Fecha_'])) {
	$Fecha_ = $_GET['Fecha_'];
	$add_sql = " AND ContableMov.Fecha = '$Fecha_'";
	}
else {
	$Fecha_ = date('Y-m-d');
	$add_sql = " AND ContableMov.Fecha = '$Fecha_'";
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
						

//echo "<br><br><br><br>".$query_RS_x_Validar;
						
$RS_x_Validar = mysql_query($query_RS_x_Validar, $bd) or die(mysql_error());
$row_RS_x_Validar = mysql_fetch_assoc($RS_x_Validar);
$totalRows_RS_x_Validar = mysql_num_rows($RS_x_Validar);


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>

<div class="container-fluid">
	<div class="row">
	


<table width="100%" border="0" align="center">
  
  <tr>
    <td colspan="2" align="center"><table width="100%" border="0" align="center">
        <tr>
          <td><table width="100%" border="0" class="table table-striped table-hover">
              <tr>
                <td colspan="12" ><a href="Pagos_Conciliar.php"><img src="../../img/Reload.png" width="31" height="27" border="0"></a> | <a href="Pagos_Conciliar.php?Oculto=1">Ocultos</a> | <a href="Conciliar_Tarj.php">Tarjetas</a> | 
                
 <form id="form1" name="form1" method="post" action="">
      <label> <a href="../index.php"><img src="../../../../img/home.png" width="25" height="27" border="0" /></a> Fecha:
      </label>
      <label><input name="Fecha_" type="date" value="<?php echo $Fecha_ ?>" onchange="form.submit();" />
        <input type="submit" name="button" id="button" value="Buscar" />
      </label>
 | <a href="Pagos_Conciliar.php?Fecha_=todo">todo</a>
 </form>               
                
                </td>
                <td colspan="4" ><?php if (1==2){ ?><form name="form" id="form">
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
              <td align="center" class="TituloLeftWindow">Pend
                <div align="center">Monto</div></td>
              <td align="center" class="TituloLeftWindow"><div align="center">Tipo</div>                Banco</td>
              <td align="center" class="TituloLeftWindow">Fecha</td>
              <td colspan="2" align="center" class="TituloLeftWindow">Referencia</td>
              <td align="center" class="TituloLeftWindow">&nbsp;</td>
              <td colspan="4" align="center" class="TituloLeftWindow"><?php if ( $_GET[SWValidado] == 0 and 1==2) { ?>
                    <a href="Pagos_Conciliar.php?AutoConcilia=1&amp;SWValidado=0">Auto-Concilia</a>
                <?php } ?></td>
              </tr>
<?php $No=1; $In="In"; 


if ($totalRows_RS_x_Validar > 0)
do { 
	$CodigoAlumno = $row_RS_x_Validar['CodigoAlumno'];
	$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);

	$ContableMov = new ContableMov($Codigo);



	$Fecha = strtotime($row_RS_x_Validar['FechaIngreso']);
	if($FeahcAnterior != date('d-m-Y', $Fecha)){
		?>
		<tr>
			<td colspan="16" ><label><?php 
			echo DiaSemana( date('N', $Fecha)).' '.date('d-m-Y', $Fecha);
			$Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_x_Validar['FechaIngreso']);
			echo " (". round(($Dif/(3600*24))+1 ,0) .")";?></label></td>
		</tr>
		<?php 
	}
	$FeahcAnterior = date('d-m-Y', $Fecha); ?>
    
    
    <!--div id="Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"-->
    
    
    <?  
	/*
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
		*/
	
	
	?>
    <!--div id="Hide_Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"-->
	<tr>
	  <td rowspan="3" align="right" ><?php echo $No; ?>&nbsp;</td>
	  <td rowspan="3" align="center" ><?php 
	  
	  if ( $row_RS_x_Validar['CodigoRecibo'] < 1 or $MM_Username=="piero") { ?>
  <iframe src="Procesa.php?bot_EliminarMov=1&Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>" seamless width="25" height="25" frameborder="0" ></iframe>
  <?php }

	  
	  
	  
		
		 ?></td>
	  <td rowspan="3" nowrap ><a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_x_Validar['CodigoClave']; ?>" target="_blank"><img src="../../../i/coins_in_hand.png" width="16" height="16" />&nbsp;<?php 
	   echo $Alumno->NombreApellido();
	   ?></a>
	    
	    <?
		if (strpos($ListaCodigos , $CodigoAlumno ) > 0){
			echo " dup ";
			}
		$ListaCodigos .= " $CodigoAlumno ";	
		?>
	    
	    </td>
	  <td rowspan="3" nowrap ><?= $AnoEscolar. "<br>".$Alumno->Status($AnoEscolar); ?></td>
	  <td align="center" ><a href="../PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_x_Validar['CodigoAlumno']; ?>"><img src="../../../i/participation_rate.png" width="16" height="16" /><br />
	    <?php echo $row_RS_x_Validar['CodigoAlumno']; ?></a></td>
	  <td align="right" class="ReciboRenglonMini" ><?php echo Fnum($row_RS_x_Validar['Deuda_Actual']); ?><br>	    &nbsp;<strong><?php echo Fnum($row_RS_x_Validar['MontoHaber']); ?></strong></td>
	  <td align="center" nowrap="nowrap" ><?php 
	  	 if($row_RS_x_Validar['Tipo']==1) {
			echo "->B";} 
		 elseif($row_RS_x_Validar['Tipo']==2) {
			 echo "B->B";} 
		  else{
			  echo $row_RS_x_Validar['Tipo'];}	 
			  ?>
	    <br>
	    <?php echo substr($row_RS_x_Validar['BancoOrigen'],0,5); ?> <img src="../../../img/<?php echo $row_RS_x_Validar['Nombre']; ?>.jpg" width="16" height="16"  /> <br></td>
	  <td align="center" nowrap="nowrap" ><?php 
        
		echo DiaSemana( date('N', strtotime($row_RS_x_Validar['Fecha'])));
		
        echo date(' d-m', strtotime($row_RS_x_Validar['Fecha']));  
        
        $Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_x_Validar['Fecha']);
		
		if(round($Dif/(3600*24) ,0) > 0)
        	echo "<br>(-".round($Dif/(3600*24) ,0).")";
        
        ?></td>
	  <td >	  <!--div align="right"-->
	    <a href="Contable_Modifica.php?Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>" target="_blank">. 
	      Editar&nbsp;</a> <? 
		  
		  if( Dif_Tiempo($row_RS_x_Validar['FechaContableModifica']) < 800)
		 	 echo Dif_Tiempo($row_RS_x_Validar['FechaContableModifica']);
		  
		  ?><?php
        
        if( $row_RS_del_Banco['MontoHaber'] > 0 and $row_RS_del_Banco['MontoHaber'] != $row_RS_x_Validar['MontoHaber'] ){
			echo '<br>';
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
	  <td><?php echo substr($row_RS_x_Validar['RegistradoPor'], 0 , 5 ); ?> : 
	    <?php echo substr($row_RS_x_Validar['FechaIngreso'], 11 , 5 ); ?>        </td>
	  <td colspan="3"><?= $row_RS_x_Validar['Observ'] ?></td>
	  <td align="right" ><?php echo $No ?></td>
	  </tr>
	<tr>
	  <td colspan="11" align="center" ><? //if ($MM_Username == 'piero'){ ?>
	    <iframe src="Contable_Modifica_mini.php?Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>" height="25" width="100%" seamless scrolling="no" frameborder="0"></iframe>
	    <? //} ?>	    </td>
	  </tr>
	<tr>
	  <td colspan="5" align="left" ><a href="../Email/index.php?CodigoAlumno=<?= $Alumno->Codigo(); ?>&CodigoPago=<?= $row_RS_x_Validar['Codigo']; ?>&Email=Pagos_a_Provincial" target="_blank">Email Pago a Prov</a>
	    <?  
	  echo DDMM($row_RS_x_Validar['FechaSolicitud']); 
	  ?>	    </td>
	  <td >      
	  <td >      
	  <td colspan="4" align="right" ><?php 
		//echo $row_RS_x_Validar['Referencia'] .' > '. $row_RS_del_Banco['Referencia'].'<br>';
		//if($row_RS_x_Validar['Referencia'] == $row_RS_del_Banco['Referencia'] and $row_RS_x_Validar['Referencia'] > 0){
		//if($valido){ ?>
        <div id="Hide_Pago_Cod_<?php echo $row_RS_x_Validar['Codigo']; ?>"> 
            <iframe src="HidePago.php?Codigo=<?php echo $row_RS_x_Validar['Codigo']; ?>" seamless width="40" height="30" scrolling="no" frameborder="0"></iframe>
        </div>
        <?php //} ?>	</tr>
	<!--/div-->
    
	<?php 
	$No +=1; 
	
} while ($row_RS_x_Validar = mysql_fetch_assoc($RS_x_Validar)); ?>





          </table></td>
        </tr>
    </table></td>
  </tr>
</table>


	</div>	
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>