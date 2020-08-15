<?php 
$MM_authorizedUsers = "99,91,secreAcad,AsistDireccion,Contable";
$TituloPagina   = "RRHH"; // <title>
$TituloPantalla = "RRHH"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

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

/*/ Guarda Forma
if(isset($_POST['Guardar'])){
	foreach ($_POST as $clave => $valor){
		if($clave != 'Guardar' and $clave != 'CodigoEmpleado' ){
			$Vars .= $clave.',';
			$Vals .= $_POST[$clave].',';
			
			$ValorAux = $_POST[$clave];
			if(substr($clave,0,5) == "Fecha" and $ValorAux == "")
				$ValorAux = '0000-00-00';
				
			$sql_update .= " ".$clave."='".$ValorAux."',";
			}
	}
		
	if(strlen($sql_update) > 10)
		$sql_update = "UPDATE Empleado SET ".$sql_update." WHERE CodigoEmpleado = '".$_POST['CodigoEmpleado']."'";
	$sql_update = str_replace(', WHERE',' WHERE',$sql_update);		

	if(true or Acceso($Acceso_US,"EditaEmpleado")){	
		echo '<pre>';
		//print_r($_POST);
		echo '</pre>';
		//echo 'sql_update = '.$sql_update.'<br>';
		echo $mysqli->query($sql_update);}
}
*/
// FIN Guarda Forma
	
	
	
	
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

        
       <table class="center">
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
        <?php 
		
//$Desde = $_GET['Limit']; 
//$Hasta = $Desde + $CantEmpPantalla;
//$i=1;

 while ($row_RS_Empleados = $RS_Empleados->fetch_assoc()) { 
//echo "<tr><td>$i<td><td>$Desde<td><td>$Hasta<td><tr>";		

//	if($i >= $Desde and $i <= $Hasta ) {
	/*	
		//extract ($row_RS_Empleados);
		 $class = ' class="';
		 if($_GET['Linea'] == $i+1) {
			 $class .= "FondoCampoVerde"; }
		 elseif($par){
			 $class .= "ListadoPar12"; 
			 $par = false;}
			 	else {
					$class .= "ListadoPar12"; 
					$par=true; } 
					$class .= '" ';
		*/ 
		
		 ?>

</table>


<table  class="center">
         <caption><?php echo ++$i ?>)
		<a href="Ficha_Datos.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>" target="_blank" >
		<?php echo $row_RS_Empleados[Apellidos] ." ". $row_RS_Empleados[Apellido2] .", ". $row_RS_Empleados[Nombres] ." ". $row_RS_Empleados[Nombre2]; ?></a></caption>
         
         
<tr>
  <td ><img src="../../../i/b.png" width="150" height="1" alt=""/><br><a name="<?php echo $i ?>" id="Linea2"></a>
    <?php if ($Dsp['Foto']) { 
	
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	$Ruta = $raiz.'/FotoEmp/150/'.$row_RS_Empleados[CodigoEmpleado].'.jpg';
	if(file_exists($Ruta)){
	
	?>
    <a href="../../a/Sube_Foto.php?Tipo=Empleado150&Codigo=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Cedula=<?php echo $row_RS_Empleados[Cedula] ?>" target="_blank"><img src="../../../FotoEmp/150/<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>.jpg" width="150"height="150" border="0" /></a>  
	<?php }else{ ?>
    <a href="../Sube_Foto.php?Tipo=Empleado300&Codigo=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Cedula=<?= $row_RS_Empleados[Cedula] ?>"><img src="../../../i/user_add.png" width="32" height="32" alt=""/></a>
    <?php } }
	?><br /> 
    <?
	if ($Dsp['Cedula']) { 
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	$Ruta = $raiz.'/intranet/a/archivo/ci/'.$row_RS_Empleados[Cedula].'.jpg';
	if(file_exists($Ruta)){
	?>
   <a href="../archivo/ci/<?= $row_RS_Empleados[Cedula] ?>.jpg" target="_blank"><img src="../../../i/vcard.png" width="32" height="32" alt=""/></a>
    <?php }else{ ?>
    <a href="../Sube_Foto.php?Tipo=EmpleadoCedula600&Cedula=<?= $row_RS_Empleados[Cedula] ?>"><img src="../../../i/vcard_add.png" width="32" height="32" alt=""/></a><?php }
	} ?></td>
  
  
<td><iframe src="iFr_ListaEmpleado.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>" width="1200" height="300" frameborder="0" seamless></iframe></td>    

	
  
  
  
  
<?php if(TieneAcceso($Acceso_US,"Sueldo")) { ?>  
 
          <td align="right" nowrap="nowrap">
              <p><a href="Ficha_PagoDeduc.php?BC=1&CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>" target="_blank" >BC</a> <br>
                  
                  <a href="Ficha_PagoDeduc.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>" target="_blank" >Pagos</a>
                  
                  
                  <a href="PDF/Recibo_Pago.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>&amp;Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>" target="_blank">Recibo N&oacute;m</a><br />
                  <a href="PDF/Recibo_Pago_Vacaciones.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado]; ?>" target="_blank">Recibo Vacaciones</a><br />
                  
                  <a href="PDF/Recibo_Utilidades.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Util=1&Agui=1" target="_blank"> Recibo Utilid/Aguin</a><br />
                  <a href="PDF/Recibo_Utilidades.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Util=1" target="_blank">Utilid</a><br />
                  <a href="PDF/Recibo_Utilidades.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Agui=1" target="_blank">Aguin</a><br />
                  <a href="PDF/Recibo_Utilidades.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>&Bono=1" target="_blank">Bono Prod</a><br />
                  
                  <br />
                  
                  <a href="ListaRetroactivo.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>" target="_blank">Retroactivo</a><br />
              </p>
              <p><a href="PDF/Carnet.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>" target="_blank">Carnet</a></p>
              <p><a href="../Contabilidad/Gastos.php?Rif=<?php echo $row_RS_Empleados[Cedula] ?>&Nombre=<?php echo $row_RS_Empleados[Apellidos].' '.$row_RS_Empleados[Nombres] ?>" target="_blank">Recibo Particular</a> </p>
              <p><a href="PDF/Constancia.php?CodigoEmpleado=<?php echo $row_RS_Empleados[CodigoEmpleado] ?>" target="_blank">Cosntancia Trab</a></p></td>
        </tr>
<?php } ?>        

  </table>
      
           
           
           
           
           
           
           
           
           
           
           
           
           
            </td>
          </tr>
          <?php 
//	}
//	$i=$i+1;
}  ?>
        
        
        
        <tr>
            <td colspan="2" align="left" nowrap class="FondoCampo">
<form action="<?php echo $php_self; ?>?Linea=<?php echo ++$i ?>#<?php echo $i ?>" method="post" name="form2" id="form2">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><input type="hidden" name="SW_activo" value="1"   />
                                      Crear Empleado</td>
                                    <td nowrap="nowrap">
                                    C.I.
                                      <input type="text" name="Cedula" value="" size="10" />
                                      Apellidos
                                      <input type="text" name="Apellidos" value="" size="10" />
                                      <input type="text" name="Apellido2" value="" size="10" id="Apellido2" />
                                      Nombres:
                                      <input type="text" name="Nombres" value="" size="10" />
                                      <input type="text" name="Nombre2" value="" size="10" id="Nombre2" />
<input type="submit" value="Crear" /></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td nowrap="nowrap"><input type="hidden" name="CodigoEmpleado" value="" />
                                      <input type="hidden" name="MM_insert" value="form2" /></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
          </form>       </td>
          </tr>
    </table>
           
           
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>