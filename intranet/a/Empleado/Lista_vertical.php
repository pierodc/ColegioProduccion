<?php 
$MM_authorizedUsers = "99,91,secreAcad,AsistDireccion,Contable";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$SwListaActiva = $_COOKIE['SwListaActiva'];

// Seteo rango de registro display
if(isset($_GET['Orden']))
	$Orden = $_GET['Orden'];
elseif($_COOKIE['Orden'] > '')
	$Orden = $_COOKIE['Orden'];
else
	$Orden = "";

if(isset($_GET['TipoEmpleado']))
	$TipoEmpleado = $_GET['TipoEmpleado'];
elseif($_COOKIE['TipoEmpleado'] > '')
	$TipoEmpleado = $_COOKIE['TipoEmpleado'];
else
	$TipoEmpleado = "";

if(isset($_GET['TipoDocente']))
	$TipoDocente = $_GET['TipoDocente'];
elseif($_COOKIE['TipoDocente'] > '')
	$TipoDocente = $_COOKIE['TipoDocente'];
else
	$TipoDocente = "";

if(isset($_GET['CantEmpPantalla']))
	$CantEmpPantalla = $_GET['CantEmpPantalla'];
elseif($_COOKIE['CantEmpPantalla'] > 0)
	$CantEmpPantalla = $_COOKIE['CantEmpPantalla'];
else
	$CantEmpPantalla = 200;

if(isset($_GET['Limit']))
	$Limit = $_GET['Limit'];
elseif($_COOKIE['Limit'] > 0)
	$Limit = $_COOKIE['Limit'];
else
	$Limit = 0;
	
	
if(isset($_POST['Buscar'])){
	$Orden = "";
	$TipoEmpleado = "";
	$TipoDocente = "";
	$CantEmpPantalla = 5;
	$Limit = 0;
	}	
	
	
setcookie("Limit",$Limit,time()+86000000);
setcookie("CantEmpPantalla",$CantEmpPantalla,time()+86000000);
setcookie("TipoEmpleado",$TipoEmpleado,time()+86000000);
setcookie("TipoDocente",$TipoDocente,time()+86000000);
setcookie("Orden",$Orden,time()+86000000);
if( isset($_GET['CantEmpPantalla']) or 
	isset($_GET['Limit']) or 
	isset($_GET['TipoEmpleado']) or
	isset($_GET['TipoDocente']) or
	isset($_GET['Orden']))
		header("Location: ".$_SERVER ['PHP_SELF']);
// FIN Seteo 


// Menu Navegacion
$Region_Pantalla = array('SW_Activo','Sueldo','BonoAlim','Fecha','Fideicomiso','Horario','Cargo','Mensaje','Foto','Cedula','Contacto','Asistencia');


if(isset($_GET['SwListaInActiva']) or isset($_GET['SwListaActiva']) ){
	if(isset($_GET['SwListaActiva'])){ // Boton Activar
		$SwListaActiva = $SwListaActiva . ' ' . $_GET['SwListaActiva']; }
	if(isset($_GET['SwListaInActiva'])){ // Boton Desactivar
		$SwListaActiva = str_replace($_GET['SwListaInActiva'],'',$SwListaActiva); }
	header("Location: ".$php_self); } 

if($SwListaActiva == '')
	$SwListaActiva = ' SW_Activo Cargo Foto ';

setcookie("SwListaActiva",$SwListaActiva,time()+86000000);

unset($Dsp);
foreach($Region_Pantalla as $Region){
	if(strpos($SwListaActiva, $Region))	
		$Dsp[$Region] = true; }
// FIN Menu Navegacion

	
// CREA Nuevo	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$sql = sprintf("INSERT INTO Empleado SET Cedula=%s, Apellidos=%s, Apellido2=%s, Nombres=%s, Nombre2=%s, FechaIngreso=%s",
									   GetSQLValueString($_POST['Cedula'], "text"),
									   GetSQLValueString($_POST['Apellidos'], "text"),
									   GetSQLValueString($_POST['Apellido2'], "text"),
									   GetSQLValueString($_POST['Nombres'], "text"),
									   GetSQLValueString($_POST['Nombre2'], "text"),
									   GetSQLValueString(date("Y-m-d"), "text"));
	//echo $sql;								   
	$mysqli->query($sql);
	$mysqli->query("UPDATE Empleado SET md5 = MD5(CodigoEmpleado)");  
  
}
// FIN CREA Nuevo	



if(isset($_POST['Buscar'])){
	$aux = explode(" ",strtolower( $_POST['Buscar']));// echo "1: ". $aux[0]. " 2: ". $aux[1];


	$add_Busqueda = "LOWER(CONCAT_WS(' ',Nombres,Nombre2,Apellidos,Apellido2,Cedula )) LIKE '%$aux[0]%' ";
	if($aux[1]!=""){ $add_Busqueda .= " AND LOWER(CONCAT_WS(' ',Nombres,Nombre2,Apellidos,Apellido2 )) LIKE '%$aux[1]%' "; }
	
	
						   
	if(isset($_POST['SW_activo']))
			$add_Busqueda .= " AND SW_activo = '1' ";
	}
else {	
	$add_Busqueda =  " SW_activo = '1' ";	}
	

if($TipoEmpleado > "")
	$add_Busqueda .= " AND TipoEmpleado = '$TipoEmpleado' ";

if($TipoDocente > "")
	$add_Busqueda .= " AND TipoDocente = '$TipoDocente' ";


if($Orden > "")
	$add_Orden = " $Orden ";
else
	$add_Orden = " Apellidos, Nombres ";



$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE $add_Busqueda 
						ORDER BY $add_Orden
						LIMIT $Limit , $CantEmpPantalla";
echo $query_RS_Empleados;
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
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
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
        <tr>
            <td colspan="2" class="navLink">Campos: 
            <a href="Lista.php?SwLista<?php if($Dsp['SW_Activo']) echo 'In'; ?>Activa=SW_Activo"<?php     if($Dsp['SW_Activo'])  echo ' class="navLinkAct"'; ?>>Activo en</a> | 
            <?php if(Acceso($Acceso_US,"Sueldo")){ ?>
            <a href="Lista.php?SwLista<?php if($Dsp['Sueldo'])  echo 'In'; ?>Activa=Sueldo"<?php       if($Dsp['Sueldo'])  echo ' class="navLinkAct"'; ?>>Sueldo</a> | 
			<?php }
			if(Acceso($Acceso_US,"CestaTicket")){ ?>
            <a href="Lista.php?SwLista<?php if($Dsp['BonoAlim'])  echo 'In'; ?>Activa=BonoAlim"<?php       if($Dsp['BonoAlim'])  echo ' class="navLinkAct"'; ?>>Bono Alimentacion</a> | 
            <?php } ?>
            <a href="Lista.php?SwLista<?php if($Dsp['Fecha'])   echo 'In'; ?>Activa=Fecha"<?php        if($Dsp['Fecha'])   echo ' class="navLinkAct"'; ?>>Fecha Ing/Egr</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Fideicomiso'])   echo 'In'; ?>Activa=Fideicomiso"<?php        if($Dsp['Fideicomiso'])   echo ' class="navLinkAct"'; ?>>Fideicomiso</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Horario']) echo 'In'; ?>Activa=Horario"<?php 	   if($Dsp['Horario']) echo ' class="navLinkAct"'; ?>>Horario</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Cargo']) 	 echo 'In'; ?>Activa=Cargo"<?php       if($Dsp['Cargo'])   echo ' class="navLinkAct"'; ?>>Cargo</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Mensaje'])  echo 'In'; ?>Activa=Mensaje"<?php if($Dsp['Mensaje']) echo ' class="navLinkAct"'; ?>>Mensaje Marca T</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Foto']) 	 echo 'In'; ?>Activa=Foto"<?php if($Dsp['Foto']) echo ' class="navLinkAct"'; ?>>Foto</a> | 
            <a href="Lista.php?SwLista<?php if($Dsp['Cedula']) 	 echo 'In'; ?>Activa=Cedula"<?php if($Dsp['Cedula']) echo ' class="navLinkAct"'; ?>>C&eacute;dula</a> | 
        <a href="Lista.php?SwLista<?php if($Dsp['Contacto']) 	 echo 'In'; ?>Activa=Contacto"<?php if($Dsp['Contacto']) echo ' class="navLinkAct"'; ?>>Contacto</a> | 
        <a href="Lista.php?SwLista<?php if($Dsp['Asistencia']) 	 echo 'In'; ?>Activa=Asistencia"<?php if($Dsp['Asistencia']) echo ' class="navLinkAct"'; ?>>Asistencia</a> |</tr>
        <tr>
          <td colspan="2" class="navLink">Reporte: 
          <?php if(TieneAcceso($Acceso_US,"Sueldo")) {?>
          <a href="PDF/Deducciones_Abonos.php?AnoMes=<?php 
		  echo date('Ym');
		  echo "&Q=";
		  if(date('d') > 20)
			echo "2";
				else
			echo "1";
		  ?>" target="_blank">Desc/Abo en la Quincena</a>
          
          | <a href="PDF/Empleado_ivss_xls.php" target="_blank">Reporte IVSS</a>
<?php } ?>
        </tr>
        <tr>
          <td width="50%" valign="top" nowrap="nowrap"><form id="form3" name="form3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
            <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar'] ?>" />
            <input name="SW_activo" type="checkbox" id="checkbox2" checked="checked" /> activo
<input type="submit" name="button" id="button" value="Buscar" />
          </form></td>
          <td width="50%" align="right" valign="top" nowrap="nowrap">
          <a href="<?php echo $_SERVER ['PHP_SELF'] ?>?Limit=<?php echo '0'; ?>">Primero</a> | 
          <a href="<?php echo $_SERVER ['PHP_SELF'] ?>?Limit=<?php if($_GET['Limit']>$CantEmpPantalla) echo $_GET['Limit']-$CantEmpPantalla; else echo '1'; ?>">Anterior</a> |
          
          <?php do{ 
		  $ActualLimit = $k*$CantEmpPantalla+1;
		  if($_GET['Limit'] == $ActualLimit) echo ' <b>'. $ActualLimit .' </b>  ';
		  else{
		  ?><a href="<?php echo $_SERVER ['PHP_SELF'] ?>?Limit=<?php echo $k*$CantEmpPantalla;  ?>"><?php 
		  	$kj = $k*$CantEmpPantalla; 
			echo $kj; 
			//echo $Emp[$kj][Apellidos];
			?></a>
          <?php }
		  $k++;
		  }while($k*$CantEmpPantalla <= 100); ?>
          
          <a href="<?php echo $_SERVER ['PHP_SELF'] ?>?Limit=<?php  echo $_GET['Limit']+$CantEmpPantalla+1; ?>">Siguiente</a> | 
          <a href="<?php echo $_SERVER ['PHP_SELF'] ?>?Limit=<?php  echo $totalRows_RS_Empleados-$CantEmpPantalla; ?>">Ultimo</a></td>
        </tr>
        <tr>
          <td colspan="2" align="right" nowrap="nowrap"><form id="form1" name="form1" method="post" action="">Visualizar
              <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                <option value="Lista.php">Cantidad</option>
                <option value="Lista.php?CantEmpPantalla=3" <?php 
				if($CantEmpPantalla == 3) echo ' selected="selected"';?>>3</option>
                <option value="Lista.php?CantEmpPantalla=5" <?php 
				if($CantEmpPantalla == 5) echo ' selected="selected"';?>>5</option>
                <option value="Lista.php?CantEmpPantalla=10" <?php 
				if($CantEmpPantalla == 10) echo ' selected="selected"';?>>10</option>
                <option value="Lista.php?CantEmpPantalla=20" <?php 
				if($CantEmpPantalla == 20) echo ' selected="selected"';?>>20</option>
                <option value="Lista.php?CantEmpPantalla=50" <?php 
				if($CantEmpPantalla == 50) echo ' selected="selected"';?>>50</option>
                <option value="Lista.php?CantEmpPantalla=200" <?php 
				if($CantEmpPantalla == 200) echo ' selected="selected"';?>>Todos</option>
              </select>
               
              Tipo Empleado
              <select name="TipoEmpleado" id="TipoEmpleado" onchange="MM_jumpMenu('parent',this,0)">
                <option value="Lista.php?TipoEmpleado=">Todos</option>
                <?php 
					// Ejecuta $sql
					$sql = "SELECT * FROM Empleado
							WHERE SW_activo = '1'
							GROUP BY TipoEmpleado
							ORDER BY TipoEmpleado,TipoDocente";
					
					// TipoEmpleado
					$RS = $mysqli->query($sql);
					while ($row = $RS->fetch_assoc()) {
						echo '<option value="Lista.php?TipoEmpleado='.$row['TipoEmpleado'].'&TipoDocente='.'"';
						if($row['TipoEmpleado'] == $TipoEmpleado)
							echo ' selected="selected"';
						echo '>'.$row['TipoEmpleado'].'</option>'."\r\n";


							//Tipo Docente
							$sql2 = "SELECT * FROM Empleado
									WHERE SW_activo = '1'
									AND TipoEmpleado = '".$row['TipoEmpleado']."'
									GROUP BY TipoDocente
									ORDER BY TipoDocente";
						
							$RS2 = $mysqli->query($sql2);
							while ($row2 = $RS2->fetch_assoc()) {
								echo '<option value="Lista.php?TipoEmpleado='.$row['TipoEmpleado'].'&TipoDocente='.$row2['TipoDocente'].'"';
								if($row['TipoEmpleado'] == $TipoEmpleado and $row2['TipoDocente'] == $TipoDocente)
									echo ' selected="selected"';
								echo '>'.$row['TipoEmpleado'].' -> '.$row2['TipoDocente'].'</option>'."\r\n";
							}
						
						
					}
					?>
              </select>
              
              Orden
              <select name="Orden" id="Orden" onchange="MM_jumpMenu('parent',this,0)">
                <option value="Lista.php?Orden=Apellidos,Nombres" <?php 
				if($Orden == "Apellidos,Nombres") echo ' selected="selected"';
				?>>Apellido,Nombre</option>
                <option value="Lista.php?Orden=Nombres,Apellidos" <?php 
				if($Orden == "Nombres,Apellidos") echo ' selected="selected"';
				?>>Nombre,Apellido</option>
                <option value="Lista.php?Orden=TipoEmpleado,TipoDocente" <?php 
				if($Orden == "TipoEmpleado,TipoDocente,Apellidos,Nombres") echo ' selected="selected"';
				?>>TipoEmpleado</option>
                <option value="Lista.php?Orden=FechaIngreso ASC" <?php 
				if($Orden == "FechaIngreso ASC") echo ' selected="selected"';
				?>>Fecha Ingreso 1980 -> hoy</option>
                <option value="Lista.php?Orden=FechaIngreso DESC" <?php 
				if($Orden == "FechaIngreso DESC") echo ' selected="selected"';
				?>>Fecha Ingreso hoy -> 1980</option>
              </select>
          </form></td>
        </tr>
<?php while ($row_RS_Empleados = $RS_Empleados->fetch_assoc()) {  ?>
<tr>
<td colspan="2" align="left" nowrap bgcolor="#FFFFFF" >
<iframe src="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&vertical=1" width="100%" height="40" frameborder="0" seamless="seamless"></iframe>
</td>
</tr> <?php 
}
?>
    </table></td>
  </tr>
</table>


<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>


</body>
</html>