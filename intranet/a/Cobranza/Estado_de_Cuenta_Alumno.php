<?php 
//echo "SISRTEMA EN MANTENIENTO";
//EXIT;
//var_dump($POST);
$MM_authorizedUsers = "99,91,95,90,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$Alumno = new Alumno($_GET["CodigoPropietario"], $AnoEscolar);
$Banco = new Banco();

$TituloPantalla = $Alumno->CodigoNombreApellido(); // Titulo contenido
$TituloPagina   = $Alumno->CodigoNombreApellido(); // <title>


// Conectar
//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$Ano1 = $AnoA = substr($AnoEscolar , 2 , 2);
$Ano2 = $AnoB = substr($AnoEscolar , 7 , 2);


// Activa Inspeccion
$Insp = false ;
$UltimoTipo = $_COOKIE['UltimoTipo'];
$UltimoBanco = $_COOKIE['UltimoBanco'];
setcookie("UltimoTipo",$UltimoTipo,0);
setcookie("UltimoBanco",$UltimoBanco,0);

$UltimoCodigoAsignacion3 = $_COOKIE['UltimoCodigoAsignacion3'];
setcookie("UltimoCodigoAsignacion3",$UltimoCodigoAsignacion3,0);

$UltimoMonto = $_COOKIE['UltimoMonto'];
setcookie("UltimoMonto",$UltimoMonto,0);


if(isset($_GET['CodigoAlumno'])) {
	$CodigoPropietario = CodigoPropietario($_GET['CodigoAlumno']);
	header("Location: ".$auxPag."?CodigoPropietario=".$CodigoPropietario );
	}

$Alumno = new Alumno($CodigoAlumno);
$_var = new Variable();

$Cambio_Dolar_Hoy = $_var->view('Cambio_Dolar');


// Activa Renglon Resumen
if(isset($_GET['Resumen2'])) {
	setcookie('Resumen2',$_GET['Resumen2'],0);
	header("Location: ".$auxPag."?CodigoPropietario=".$_GET['CodigoPropietario']);
	}



// Activa Modo baja transf
if (isset($_GET['PantallaCompleta'])) {
	setcookie('PantallaCompleta',$_GET['PantallaCompleta'],0);
	header("Location: ".$auxPag."?CodigoPropietario=".$_GET['CodigoPropietario']);
	}

if (isset($_COOKIE['PantallaCompleta'])){
  $SW_PantallaCompleta = $_COOKIE['PantallaCompleta'];// true; // PAntalla completa
}
else{
  $SW_PantallaCompleta = 1;
}



//Cambia Nombre Factura
if (isset($_POST['CambiaNombreFactura']) and $_POST['CambiaNombreFactura']==1) {
		$query = "UPDATE ContableMov 
					SET CodigoReciboCliente = '".$_POST['CodigoReciboCliente']."'
					WHERE Codigo = '".$_POST['Codigo']."' ";
		$RS = $mysqli->query($query);
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']);}
//




// buscando desde Edo de cuenta
$CodidoBuscando = 0;
if (isset($_POST['Buscar'])) {
	$_SESSION['Referencia'] = "";
	$aux = explode(" ", $_POST['Buscar']);// echo "1: ". $aux[0]. " 2: ". $aux[1];
	
	$CamposBuscar = " CONCAT_WS(' ', Nombres, Nombres2, Apellidos, Apellidos2, SMS_Caja )  ";
	
	$query_RS_Alumnos  = "SELECT * FROM Alumno WHERE Creador > ' ' ";
	$CodigoBuscar = intval($_POST['Buscar'])*1;
	//echo $CodidoBuscando;
	//echo $_POST['Buscar'];
	
	
	if($CodigoBuscar == $_POST['Buscar']){
		$query_RS_Alumnos .= " AND CodigoAlumno = '".$_POST['Buscar']."'";
		}
	else {
	
		$query_RS_Alumnos .= " AND ( ";
		$query_RS_Alumnos .= "$CamposBuscar LIKE '%%$aux[0]%%'";
		
		
		if($aux[1]!=""){
			$query_RS_Alumnos .= "$CamposBuscar LIKE '%%$aux[1]%%' ";}
		if($aux[2]!=""){
			$query_RS_Alumnos .= "$CamposBuscar LIKE '%%$aux[2]%%' ";}
		if($aux[3]!=""){
			$query_RS_Alumnos .= "$CamposBuscar LIKE '%%$aux[3]%%' ";}
		
		$query_RS_Alumnos .= ") OR CodigoAlumno = '$aux[0]' ORDER BY Apellidos ASC";
	}
	
	//echo $query_RS_Alumnos;
	
	
	$RS_Alumnos = $mysqli->query($query_RS_Alumnos);
	$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();
	$totalRows_RS_Alumnos = $RS_Alumnos->num_rows;
	
	//echo $totalRows_RS_Alumnos;
	if ($totalRows_RS_Alumnos == 1){  
	
			$CodidoBuscando = $row_RS_Alumnos['CodigoAlumno']; 
		 	$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];
	
		header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".$row_RS_Alumnos['CodigoClave']);
		 }
	else { 
		header("Location: ../ListaAlumnos.php?SWinscrito=1&CodigoBuscar=".$_POST['Buscar']); exit;}

} 





// LLamado sin Codigo Clave, con Codigo Alumno
if ($CodidoBuscando > 0){
	$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = ".$CodidoBuscando;
	$RS_sql = $mysqli->query($sql);
	$row_RS_sql = $RS_sql->fetch_assoc();
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$row_RS_sql['CodigoClave']); 
}



// Apuntador misma pagina
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']); 
}






// Agrega Pago
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	setcookie("UltimoTipo",$_POST["Tipo"],0);
	setcookie("UltimoBanco",$_POST["Tipo"],0);
	setcookie("UltimoMonto",$_POST["MontoHaber"],0);

	$_SESSION['Referencia'] = $_POST['Referencia'];
					
	$Tipo = $_POST['Tipo'];
	$CodigoCuenta = $_POST['CodigoCuenta'];
					
	if ($_POST['MontoHaber'] > 0) {
		$SW_Moneda = "B";
		}	
	elseif ($_POST['MontoHaber_Dolares'] > 0) {
		$SW_Moneda = "D";
		$CodigoCuenta = "7";
		$Tipo = "9";
		$MontoHaber_Dolares = $_POST['MontoHaber_Dolares'];
		}					
	elseif ($_POST['MontoHaber_Dolares_Zelle'] > 0) {
		$SW_Moneda = "D";
		$CodigoCuenta = "6";
		$Tipo = "8";
		$MontoHaber_Dolares = $_POST['MontoHaber_Dolares_Zelle'];
		}					
	
	
	$MontoHaber = coma_punto($_POST['MontoHaber']);			 
	if ($MontoHaber == ""){
		$MontoHaber = $MontoHaber * $_POST['Cambio_Dolar'];
		
	}					 
	
	
	
	
	
	$insertSQL = sprintf("INSERT INTO ContableMov (Observaciones, CodigoCuenta, CodigoPropietario, CodigoReciboCliente, Tipo, Fecha, Referencia, ReferenciaOriginal, ReferenciaBanco, Descripcion, MontoDebe_Dolares, MontoDebe, MontoHaber, MontoHaber_Dolares, Cambio_Dolar, RegistradoPor, MontoDocOriginal, SW_Moneda) 
	
	VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
    
						 
	                   GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($CodigoCuenta, "int"),
                       GetSQLValueString($_POST['CodigoPropietario'], "int"),
                       GetSQLValueString($_POST['CodigoReciboCliente'], "text"),
                       GetSQLValueString($Tipo, "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['ReferenciaBanco'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString(coma_punto($_POST['MontoDebe_Dolares']), "double"),
                       GetSQLValueString(coma_punto($_POST['MontoDebe']), "double"),
                       GetSQLValueString($MontoHaber, "double"),
                       GetSQLValueString(coma_punto($MontoHaber_Dolares), "double"),
                       GetSQLValueString(coma_punto($_POST['Cambio_Dolar']), "double"),
					   GetSQLValueString($_POST['RegistradoPor'], "text"),
					   GetSQLValueString($_POST['MontoDocOriginal'], "double"),
					   GetSQLValueString($SW_Moneda, "text"));
	//echo "<br><br><br><br><br>" . $insertSQL;
	$mysqli->query($insertSQL);
	$mensaje = "";
}
// FIN Agrega Pago





// Divide_Pago

if ((isset($_POST["Divide_Pago"])) && ($_POST["Divide_Pago"] == "Divide_Pago")) {

      $sql = "SELECT * FROM ContableMov WHERE Codigo = '".$_POST["Codigo"]."'";
//echo $sql."<br>";
      $RS_sql_Aux = $mysqli->query($sql);
      $RS = $RS_sql_Aux->fetch_assoc();
      if($RS['MontoHaber'] > $_POST["Monto_divide"]){
            //echo "modifica e inserta<br>";
            $MontoOriginal = $RS['MontoHaber'];
            $NuevoMonto = $RS['MontoHaber'] - $_POST["Monto_divide"];
            $NuevoPago = $_POST["Monto_divide"];
            $sql_Update = "UPDATE ContableMov 
						   SET MontoHaber = '$NuevoMonto' 
						   WHERE Codigo = '".$_POST["Codigo"]."'";
        //echo $sql_Update."<br>";
             $mysqli->query($sql_Update);

	$insertSQL = sprintf("INSERT INTO ContableMov (Observaciones, CodigoCuenta, CodigoPropietario, CodigoReciboCliente, Tipo, Fecha, Referencia, ReferenciaOriginal, ReferenciaBanco, Descripcion, MontoHaber, RegistradoPor, MontoDocOriginal) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($RS['Observaciones'], "text"),
                       GetSQLValueString($RS['CodigoCuenta'], "int"),
                       GetSQLValueString($RS['CodigoPropietario'], "int"),
                       GetSQLValueString($RS['CodigoReciboCliente'], "int"),
                       GetSQLValueString($RS['Tipo'], "text"),
                       GetSQLValueString($RS['Fecha'], "date"),
                       GetSQLValueString($RS['Referencia'], "text"),
                       GetSQLValueString($RS['Referencia'], "text"),
                       GetSQLValueString($RS['ReferenciaBanco'], "text"),
                       GetSQLValueString($RS['Descripcion'], "text"),
                       GetSQLValueString($NuevoPago, "double"),
					   GetSQLValueString(substr($MM_Username,0,5).' '.$RS['RegistradoPor'], "text"),
					   GetSQLValueString($MontoOriginal, "double"));
//echo $insertSQL."<br>";
  $mysqli->query($insertSQL);



      }
				
}








// Cambia CURSO 
if ($_POST['CambiarCurso'] == 1) {
	
	$CodigoAlumno = $_POST['CodigoAlumno'];
	$Ano = $_POST['Ano'];
	$CodigoCurso = $_POST['CodigoCurso'];
	$Status   = "Solicitando";
	
	$sql = "SELECT * FROM AlumnoXCurso 
			WHERE CodigoAlumno='$CodigoAlumno' 
			AND Ano='$Ano' ";
	$RS_sql = $mysqli->query($sql);
	$totalRows_RS = $RS_sql->num_rows;
	
	if($row = $RS_sql->fetch_assoc()){
		$Status   = $row['Status'];
		$Materias_Cursa   = $row['Materias_Cursa'];
		$Tipo_Inscripcion = $row['Tipo_Inscripcion'];
		$Codigo = $row['Codigo'];
		$sql1 = "UPDATE AlumnoXCurso SET 
				CodigoAlumno = '9999".$CodigoAlumno."' 
				WHERE Codigo = '$Codigo'";
		$mysqli->query($sql1);
		
	}
	
	   $sql2 = "INSERT INTO AlumnoXCurso 
	 				(CodigoAlumno, Status, Ano, CodigoCurso, Materias_Cursa, Tipo_Inscripcion, Status_por )
				VALUES 
					('$CodigoAlumno','$Status','$Ano','$CodigoCurso','$Materias_Cursa',
					'$Tipo_Inscripcion','$MM_Username')";				   
	   $mysqli->query($sql2);
		 
 
 }
// fin Cambia CURSO






// Busca alumno por codigo clave 

$sqlAux = "SELECT CodigoAlumno 
		   FROM Alumno 
		   WHERE CodigoClave = '".$_GET['CodigoPropietario']."'";
$RS_sql_Aux = $mysqli->query($sqlAux);
$Aux = $RS_sql_Aux->fetch_assoc();
$CodigoAlumno = $Aux['CodigoAlumno'];



$sqlAux = "SELECT CodigoCurso FROM AlumnoXCurso 
		   WHERE CodigoAlumno = '$CodigoAlumno' 
		   AND Ano = '$AnoEscolar'";
$RS_sql_Aux = $mysqli->query($sqlAux);
$Aux = $RS_sql_Aux->fetch_assoc();
$CodigoCurso  = $Aux['CodigoCurso'];
//echo $CodigoCurso;
//$CodigoCursoProxAno  = $Aux['CodigoCurso']; // AJUSTAR PARA ANO 2012-13

$sqlAux = "SELECT NivelCurso , CodigoCurso
			FROM Curso 
			WHERE CodigoCurso = '$CodigoCurso' ";
$RS_sql_Aux = $mysqli->query($sqlAux);
$Aux = $RS_sql_Aux->fetch_assoc();
$NivelCursoActual  = $Aux['NivelCurso'];
	
	
	







// NUEVO Agrega Factura
if (isset($_POST['AgregaFactura'])) {
	
	if($_POST['Descripcion'] > ""){
		$MontoDebe_Dolares = $_POST['MontoDebe_Dolares'];
		$MontoDebe = $_POST['Monto'];
		if($MontoDebe < 1 and $MontoDebe_Dolares > 0){
			$MontoDebe = round( $MontoDebe_Dolares * $Cambio_Dolar , 2) ;
			}
		
		$Descripcion = $_POST['Descripcion'];
		$Referencia = $_POST['Referencia'];
		
		if ($_POST['ReferenciaMesAno'] > "0")
			$ReferenciaMesAno = $_POST['ReferenciaMesAno'];
		else	
			$ReferenciaMesAno = "09-19";
		
		$Referencia = '0';
		$SWiva = $_POST['SWiva'];
		
		}
	else{
		$sqlAux = "SELECT * FROM Asignacion WHERE Codigo = '".$_POST['CodigoAsignacion3']."'";
		$RS_sql = $mysqli->query($sqlAux);
		$row_RS_sql = $RS_sql->fetch_assoc();
		
		$MontoDebe = $row_RS_sql['Monto'];
		$MontoDebe_Dolares = $row_RS_sql['Monto_Dolares'];
		
		if($MontoDebe < 1 and $MontoDebe_Dolares > 0){
			$MontoDebe = round( $MontoDebe_Dolares * $Cambio_Dolar , 2) ;
			}
		
		
		if( $_POST['MontoDebe_Dolares'] > 0 ){
			$MontoDebe_Dolares = $_POST['MontoDebe_Dolares'];
			$MontoDebe = round( $_POST['MontoDebe_Dolares'] * $Cambio_Dolar ,2);
		}
		
		if( $_POST['Monto'] > 0 )
			$MontoDebe = $_POST['Monto'];
			
			
		$Descripcion = $row_RS_sql['Descripcion'];
		$Fecha = $row_RS_sql['Fecha'];
		$Referencia = $_POST['CodigoAsignacion3'];
		
		$Descripcion = $row_RS_sql['Descripcion'];
		
		$SWiva = $row_RS_sql['SWiva'];
		
		if ($_POST['ReferenciaMesAno'] > "0")
			$ReferenciaMesAno = $_POST['ReferenciaMesAno'];
		elseif ($row_RS_sql['MesAno'] > "")	
			$ReferenciaMesAno = $row_RS_sql['MesAno'];
		else	
			$ReferenciaMesAno = "09-19";
	
		
		$UltimoCodigoAsignacion3 = $_POST['CodigoAsignacion3'];
		setcookie("UltimoCodigoAsignacion3",$UltimoCodigoAsignacion3,0);	
	}
	
	
	if ($row_RS_sql['Fecha'] > "0")
		$FechaValor = $row_RS_sql['Fecha'];
	else
		$FechaValor = "20". substr($ReferenciaMesAno , 3,2) ."-". substr($ReferenciaMesAno , 0,2) ."-02"; 
		
	
	
	$sqlAux = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, ";
	$sqlAux.= "ReferenciaMesAno, Referencia, Descripcion, MontoDebe_Dolares, Cambio_Dolar, MontoDebe, SWiva) ";
	
	$sqlAux.= " VALUES ($CodigoAlumno,  '$FechaValor', NOW(),  '$FechaValor', 1, '$MM_Username', ";
	$sqlAux.= " '$ReferenciaMesAno',  '$Referencia', '$Descripcion' , '$MontoDebe_Dolares','$Cambio_Dolar', '$MontoDebe', '$SWiva')";
	//echo "<br><br><br><br>".$sqlAux;
	 $mysqli->query($sqlAux);
	
}






// Movimientos PENDIENTE
$colname_RS_ContableMov = "-1";
if (isset($_GET['CodigoPropietario'])) {
  $colname_RS_ContableMov = $_GET['CodigoPropietario'];
}
$query_RS_ContableMov = sprintf("SELECT * FROM ContableMov, Alumno WHERE 
									Alumno.CodigoAlumno = ContableMov.CodigoPropietario AND 
									Alumno.CodigoAlumno = $CodigoAlumno AND 
									ContableMov.SWCancelado = '0' AND
									( ContableMov.MontoDebe > 0 or ContableMov.MontoDebe_Dolares > 0)
									ORDER BY MontoHaber DESC, ContableMov.Fecha ASC, ContableMov.Codigo ASC", GetSQLValueString($colname_RS_ContableMov, "text"));
echo $Insp ?  $query_RS_ContableMov." (8)<br>" : "";
$RS_ContableMov = $mysqli->query($query_RS_ContableMov);
$row_RS_ContableMov = $RS_ContableMov->fetch_assoc();
$totalRows_RS_ContableMov = $RS_ContableMov->num_rows;





// Movimientos de PAGOS
$colname_RS_Mov_Pagos = "-1";
if (isset($_GET['CodigoPropietario'])) {
  $colname_RS_Mov_Pagos = $_GET['CodigoPropietario'];
}
$query_RS_Mov_Pagos = sprintf("SELECT * FROM ContableMov, Alumno, ContableCuenta 
								WHERE ContableMov.CodigoCuenta = ContableCuenta.CodigoCuenta 
								AND Alumno.CodigoClave = %s 
								AND Alumno.CodigoAlumno = ContableMov.CodigoPropietario 
								AND (ContableMov.MontoHaber > 0 OR ContableMov.MontoHaber_Dolares > 0 )
								ORDER BY ContableMov.Fecha ASC, Codigo ASC", GetSQLValueString($colname_RS_Mov_Pagos, "text"));
echo $Insp ?  $query_RS_Mov_Pagos." (10)<br>" : "";
$RS_Mov_Pagos = $mysqli->query($query_RS_Mov_Pagos);
$row_RS_Mov_Pagos = $RS_Mov_Pagos->fetch_assoc();
$totalRows_RS_Mov_Pagos = $RS_Mov_Pagos->num_rows;






$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoPropietario'])) {
  $colname_RS_Alumno = $_GET['CodigoPropietario'];
}

$query_RS_Alumno = sprintf("SELECT Alumno.*, AlumnoXCurso.*, Alumno.CodigoAlumno as CodAlu 
							FROM Alumno , AlumnoXCurso
							WHERE CodigoClave = %s AND
							Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno AND
							AlumnoXCurso.Tipo_Inscripcion = 'Rg' ", GetSQLValueString($colname_RS_Alumno, "text"));
echo $Insp ?  $query_RS_Alumno." (12)<br>" : "";
$RS_Alumno = $mysqli->query($query_RS_Alumno);
$row_RS_Alumno = $RS_Alumno->fetch_assoc();
$totalRows_RS_Alumno = $RS_Alumno->num_rows;

//$CodigoAlumno=$row_RS_Alumno['CodAlu'];






// Crea Recibo
$DifTiempo = time() - $_SESSION['UltimaCarga'];

if ($DifTiempo < 0 ) {
	header("Location: ". $_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."&BotonRecibo=".$_POST['BotonRecibo']);
	exit;
//echo $_POST['BotonRecibo'];
}

if ($_POST['MM_insert'] != 'form1'){
	$_SESSION['UltimaCarga'] = time(); }
else{
	$_SESSION['UltimaCarga'] = 0; }









// Procesar pago	
if ((isset($_GET['Recibo'])) and ($_GET['Recibo'] == "0")) { // Cambiar OR por AND para produccion

	// Busca ContableMov PENDIENTE
	$query_RS_ContableMovAUX = "SELECT * FROM ContableMov 
									WHERE CodigoPropietario = '$CodigoAlumno' 
									AND SWCancelado = 0 
									AND ( MontoDebe > 0 )
									ORDER BY SW_Prioridad DESC, Fecha ASC, Codigo ASC"; 
	$RS_ContableMov = $mysqli->query($query_RS_ContableMovAUX);
	$row_RS_ContableMov = $RS_ContableMov->fetch_assoc();


	// Busca ContableMov PAGO
	$sql = "SELECT * FROM ContableMov 
			WHERE Codigo = ".$_GET['Codigo']."
			AND SWCancelado = '0'"; 
	$RS_sql = $mysqli->query($sql);
	$row_sql = $RS_sql->fetch_assoc();
	
	$MontoDisponible = $row_sql['MontoHaber'];
		
	$MontoDisponible = round($MontoDisponible , 2);
	
	
	if($RS_sql->num_rows > 0){
	
	
	$P_IVA = $P_IVA_2;
	
	// Crear Registro de RECIBO
	$sql = "INSERT INTO Recibo 
			(CodigoPropietario, FechaCreacion, Fecha, FechaRecibo, P_IVA, Por) 
			VALUES 
			(".$row_RS_Alumno['CodAlu']." , NOW() , NOW() , NOW(), '$P_IVA', '".$_COOKIE['MM_Username']."')"; 
	$mysqli->query($sql);
    $CodigoRecibo = $mysqli->insert_id;
	
	// Asigna Numero de recibo al ContableMov del PAGO
	$sql = "UPDATE ContableMov 
			SET SWCancelado = '1', 
			CodigoRecibo = ".$CodigoRecibo." 
			WHERE Codigo = ".$_GET['Codigo']; 
	$mysqli->query($sql);

		do { // Asigna Codigo de recibo a cada Movimiento a cancelar
		if( $MontoDisponible > 0  and $row_RS_ContableMov['SWCancelado'] == 0 ) { 
			
			/*
			if($Renglon[$Num_Renglones]['P_IVA'] > 0){
				$Abonos = $row_RS_Mov_Contable_debe['MontoAbono']/ (1+($Renglon[$Num_Renglones]['P_IVA']/100));}
			else
				$Abonos = $row_RS_Mov_Contable_debe['MontoAbono'];
			*/
			
			$MontoIVA = round(($row_RS_ContableMov['MontoDebe']-$row_RS_ContableMov['MontoAbono'])
								*$row_RS_ContableMov['SWiva']*$P_IVA/100 , 2);
			
			$MontoPendiente = round(($row_RS_ContableMov['MontoDebe']+$MontoIVA-$row_RS_ContableMov['MontoAbono']) ,2);
			
			// existen fondos para otro pago y Mov esta pendiente
			if( $MontoDisponible >= $MontoPendiente ) { 
				// existe fondo para PAGO TOTAL
				$sql = "UPDATE ContableMov 
						SET CodigoRecibo = ".$CodigoRecibo." , 
						SWCancelado = '1' ,
						P_IVA = '$P_IVA' 
						WHERE Codigo = ".$row_RS_ContableMov['Codigo']; //echo $sql. "<br>";
				$mysqli->query($sql);
				} // fin existe fondo para PAGO TOTAL
			else 
				{ // existe fondo para PAGO PARCIAL
				
				
				if($row_RS_ContableMov['SWiva']){
					$MontoDisponible_sin_IVA = round($MontoDisponible/(1+($P_IVA/100)) ,2);
					}
				else {$MontoDisponible_sin_IVA = $MontoDisponible;}
				
				
				
				
				$sql = "UPDATE ContableMov 
						SET MontoAbono = MontoAbono+".$MontoDisponible_sin_IVA." 
						WHERE Codigo = ".$row_RS_ContableMov['Codigo']; //echo $sql;
				$mysqli->query($sql);
				
				$sql = "INSERT INTO ContableMov 
						(SWCancelado, CodigoRecibo, MontoDebe, SWiva, P_IVA, CodigoCuenta, CodigoPropietario, Fecha, FechaIngreso, FechaValor, Referencia, ReferenciaMesAno, Descripcion, SWValidado, RegistradoPor) 
						VALUES 
						('1', ".$CodigoRecibo.", ".$MontoDisponible_sin_IVA.", '".$row_RS_ContableMov['SWiva']."', '$P_IVA', 0, ".$row_RS_ContableMov['CodigoPropietario'].", '".$row_RS_ContableMov['Fecha']."', '".$row_RS_ContableMov['FechaIngreso']."', '".$row_RS_ContableMov['FechaValor']."', '".$row_RS_ContableMov['Referencia']."', '".$row_RS_ContableMov['ReferenciaMesAno']."', 'ABONO ".$row_RS_ContableMov['Descripcion']."', '".$row_RS_ContableMov['SWValidado']."', 'auto')";
				//echo $sql;		
				$mysqli->query($sql);
				} // fin existe fondo para pago parcial
				
			$MontoDisponible = round($MontoDisponible - $MontoPendiente , 2);
		
		} // fin existen fondos para otro pago
		
        } while ($row_RS_ContableMov = $RS_ContableMov->fetch_assoc()); 
		
	$sql = "UPDATE ContableMov
			SET SWCancelado = '1'
			WHERE MontoDebe > 0 
			AND MontoDebe = MontoAbono
			AND SWCancelado = '0'";
	$mysqli->query($sql);		
	
	}
	
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."&ImprimirRecibo=".$CodigoRecibo);
}
// FIN Procesar pago
	       
//include_once("../../../inc/analyticstracking.php") 

$TituloPag = $row_RS_Alumno['CodigoAlumno'] ." ". $row_RS_Alumno['Nombres'] ." ". $row_RS_Alumno['Apellidos'] ." ". $row_RS_Alumno['Apellidos2']; 
$CodigoClave = $row_RS_Alumnos['CodigoClave'];

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





      <table class="sombra">
        <? if($SW_PantallaCompleta){ ?>
        <tr>
        <td width="15%" align="center" valign="top">
        <img src="<?php echo $Alumno->Foto("","h") ?>" width="150" height="150"  border="0" /></td>
          
          
<?php 
$Familia = array('p','m','a1','a2','a3');
foreach($Familia as $id){ ?>
    <td align="center" valign="top">
    <img src="<?php echo $Alumno->Foto($id,"h") ?>" alt="" height="150" border="0" />
    <!--a href="../Procesa.php?ActualizaFoto=1&amp;Foto=<?php 
		echo $row_RS_Alumno['CodigoAlumno'].$id.'.jpg' ?>" target="_blank"><?php //echo $Actualizar ?></a-->
    </td>
<?php } ?>        
 
  </tr>  
  		<? } ?>    
  <tr align="center" valign="top">        
       <td><a href="../PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" target="_blank"><?php echo $row_RS_Alumno['Nombres']; ?> <?php echo $row_RS_Alumno['Nombres2']; ?><br />
        <?php echo $row_RS_Alumno['Apellidos']; ?> <?php echo $row_RS_Alumno['Apellidos2']; ?></a></td>   
      
     <? if($SW_PantallaCompleta){ 
	  
	$Mensaje = "Estimado Sr. Representante, Le contacto de la administracion del colegio";
	
	  
	  ?> 
      <td>&nbsp;<?php 
		  $Repre = Repre($row_RS_Alumno['CodigoAlumno'] , "Padre");
		  //echo "<div title=\"".$Repre['TelCel']."\">";
		  echo Titulo_Mm($Repre['Nombres']).'<br>'.Titulo_Mm($Repre['Apellidos']);
		  echo "<br>";
		  echo Whatsapp($Repre['TelCel'],$Mensaje);
		 // echo "</div>";
		  ?></td>   
       <td>&nbsp;<?php 
		  $Repre = Repre($row_RS_Alumno['CodigoAlumno'] , "Madre");
		  //echo "<div title=\"".$Repre['TelCel']."\">";
		  echo Titulo_Mm($Repre['Nombres']).'<br>'.Titulo_Mm($Repre['Apellidos']);
		  echo "<br>";
		  echo Whatsapp($Repre['TelCel'],$Mensaje);
		  //echo "</div>";
		  ?></td>   
       <td>&nbsp;<?php 
		  $Repre = Repre($row_RS_Alumno['CodigoAlumno'] , "Autorizado");
		  //echo "<div title=\"".$Repre['TelCel']."\">";
		  echo Titulo_Mm($Repre['Nombres']).'<br>'.Titulo_Mm($Repre['Apellidos']);
		  //echo "</div>";
		  ?></td>   
       <td>&nbsp;</td>   
       <td>&nbsp;</td>  
       <? } ?> 
        </tr>
  </table>
    

      <table class="sombra">
      <tr>
        <td rowspan="2"><a href="<?= $php_self ?>?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>"><img src="http://www.colegiosanfrancisco.com/img/Reload.png" width="31" height="27" border="0" align="absmiddle" /></a></td>
        <td  rowspan="2"><span class="RTitulo"><a href="../PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" target="_blank"><?php echo $row_RS_Alumno['CodigoAlumno']; ?></a></span></td>
        <td rowspan="2"></td>
        <td rowspan="2" align="center"><iframe src="../sms_caja.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" width="600" height="50" frameborder="0"></iframe></td>
        <td align="right"><form id="form4" name="form4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input name="Buscar" type="text" id="Buscar" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" size="15" onfocus="this.value=''" />
          <input type="submit" name="button2" id="button2" value="Buscar" />
        </form>  
           </td>
        </tr>
      <tr>
          <td align="right"><? //echo cambio_BCV(); ?>Cambio BCV: <? $_var->form_edit("Cambio_Dolar"); ?></td>
      </tr>
      </table>



 <?php 
// if($SW_PantallaCompleta)
 	include "ResumenMeses.php";
 ?>


<table >

   
     <!--tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">Anterior</td>
    <td nowrap="nowrap">2015-2016</td>
    <td align="left" nowrap="nowrap"><?php 

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
		AND Ano='$AnoEscolarAnte'"; //echo $sql;
$RS_ = $mysqli->query($sql);
$row_Curso_Actual = $RS_->fetch_assoc();
echo Curso($row_Curso_Actual['CodigoCurso']);




	?></td>
    <td colspan="2" align="left" nowrap="nowrap">
      </td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td colspan="-2" align="right" nowrap>&nbsp;</td>
  </tr-->
  <tr>
    <td>Curso</td>
    <td>Actual</td>
    <td><?php echo $AnoEscolar.':'; ?>&nbsp;</td>
   
<td ><form id="form6" name="form6" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
  <?php 

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
		AND Ano='$AnoEscolar'"; //echo $sql;
$RS_ = $mysqli->query($sql);
$row_Curso_Actual = $RS_->fetch_assoc();

if( $row_Curso_Actual['Status'] =='Inscrito' ) 
	$SWinscrito_Actual = 1; 
else 
	$SWinscrito_Actual = 0;

if($row_Curso_Actual['CodigoCurso'] < '0'){
	$CodigoCursoActual = '0';
	$AnoActual = $AnoEscolar;
	
	
}else{
	$CodigoCursoActual = $row_Curso_Actual['CodigoCurso'];
	$AnoActual = $row_Curso_Actual['Ano'];
		
}


if($CodigoCursoActual <> ''){
	
	MenuCurso($CodigoCursoActual,''); 
	//echo "$AnoEscolar == $AnoEscolarProx";
	//if($AnoEscolar == $AnoEscolarProx){

	?>
	
	<input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" />
	<input name="Ano" type="hidden" id="Ano" value="<?php echo $AnoActual; ?>" />
	<input name="CambiarCurso" type="hidden" id="CambiarCurso" value="1" />
    <input type="submit" name="button4" id="button4" value="Cambiar" />
	
	<?php 
	//}
	echo ' '.$row_Curso_Actual['Status'].'';} ?>
	</form></td>
<td ><?php 
if($MM_UserGroup == 91 or $MM_UserGroup == 99 or $MM_UserGroup == 95)
if($AnoEscolar == $AnoEscolarProx)
if($SWinscrito_Actual){

?>
  <a href="../Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>">Retira
  <?php 
	  
}else{
	
	$sql="SELECT * FROM Curso WHERE CodigoCurso='".$CodigoCurso."'";
	//echo $sql;
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	$CodigoCursoProxAno = $row_['CodigoCursoProxAno'];
	$NivelCurso = $row_['NivelCurso'];
	
	?>
   <?php echo $AnoEscolar ?></a><a href="../Procesa.php?<?php echo 'Inscribir=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>" target="_blank">Inscribir <?php echo $AnoEscolar ?></a>
  <?php } ?></td>
<td ><?
    
$ClaveCampo = 'CodigoAlumno';
$ClaveValor = $CodigoAlumno;
$Tabla = 'Alumno';


Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_Factura_Empresa',$row_RS_Alumno['SW_Factura_Empresa']);
	
	
	?>
      Factura Empresa | 
      
      <? if ($_COOKIE['PantallaCompleta'] == 1){ ?>
     <a href="<?= $php_self ?>?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&PantallaCompleta=0" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-th"></span> Pantalla Reducida</a>
      <? }else{ ?>
      <a href="<?= $php_self ?>?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&PantallaCompleta=1" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-th"></span> Pantalla Completa</a>
	  <? } ?>
     </td>
      
      
      
      
    <td >
 <?php 
$_sql = "SELECT * FROM ContableMov 
 		 WHERE CodigoPropietario = $CodigoAlumno 
		 AND ReferenciaMesAno = 'Ins ".substr($AnoInscribiendo,2,2)."' 
		 AND Descripcion = 'Matrícula' ";
		 
$_RS = $mysqli->query($_sql);
$_row_RS = $_RS->fetch_assoc();
$_totalRows = $_RS->num_rows;

if($_totalRows==0 ){

 ?><a href="Agrega_Fact_Inscripcion.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank">Fac.Ins.</a>
        <?php } ?>
        
        </td>
    <td align="right" nowrap>Mercantil <?php echo round((time()-$FechaBanco["merc"]) / 3600 , 2 ) ?><br>Provincial <?php echo round((time()-$FechaBanco["prov"]) / 3600 , 2 ) ?>
        </td>
  </tr>
  <!--
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">Prox</td>
    <td nowrap="nowrap"><?php echo $AnoEscolarProx.':'; ?>&nbsp;</td>
    <td align="left" nowrap="nowrap">
    <?php 
	if($AnoEscolar != $AnoEscolarProx){

?><form id="form6" name="form6" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
      <?php 

$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
		AND Ano='$AnoEscolarProx'
		AND Tipo_Inscripcion = 'Rg'";
$RS_ = $mysqli->query($sql);
$row_Curso_Prox = $RS_->fetch_assoc();
$totalRows_RS_ = $RS_->num_rows;

if( $row_Curso_Prox['Status'] =='Inscrito' ) 
	$SWinscrito_Prox = 1; 
else 
	$SWinscrito_Prox = 0;

if($totalRows_RS_ > 0){
	
	MenuCurso($row_Curso_Prox['CodigoCurso'],''); 
?>
      
      <input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" />
      <input name="Ano" type="hidden" id="Ano" value="<?php echo $row_Curso_Prox['Ano']; ?>" />
      <input name="CambiarCurso" type="hidden" id="CambiarCurso" value="1" />
      <input type="submit" name="button4" id="button4" value="Cambiar" /><?php 	
	  echo ' '.$row_Curso_Prox['Status'].'';} ?>
    </form><?php } ?></td>
    <td colspan="2" align="left" nowrap="nowrap"><?php 
if($MM_UserGroup == 91 or $MM_UserGroup == 99)	
if($AnoEscolar != $AnoEscolarProx )
if($SWinscrito_Prox){

?>
      <a href="../Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Retirar <?php echo $AnoEscolarProx ?></a>
      <?php 
	  
}else{
	
	$sql="SELECT * FROM Curso WHERE CodigoCurso='".$row_RS_Alumno['CodigoCurso']."'";
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	$CodigoCursoProxAno = $row_['CodigoCursoProxAno'];
	$NivelCurso = $row_['NivelCurso'];
	
	if($row_Curso_Prox['Status'] == "Aceptado" and $row_RS_Alumno['Deuda_Actual'] <1 ){
	?>
      <a href="../Procesa.php?<?php echo 'Inscribir=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Inscribir <?php echo $AnoEscolarProx ?></a>
      <?php }}
	  
	   ?></td>
    <td colspan="2" align="right" nowrap="nowrap">
        
    </td>
    </tr>
  -->
   
 
</table>








 <form id="form5" name="form5" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">          
      <table>
      <caption>Agregar Factura</caption>
      
  
        <tr>
          <td rowspan="2" nowrap="nowrap" class="NombreCampo">Fecha:</td>
          <td rowspan="2" nowrap="nowrap" class="FondoCampo"><input name="FechaActividad" type="date" value="<?php echo date('Y-m-d') ?>" /></td>
        <td rowspan="2" nowrap="nowrap" class="NombreCampo"> Eventual: Descripci&oacute;n:</td>
          <td  nowrap="nowrap" class="FondoCampo" ><span id="sprytextfield3">
            <label>
              <input name="Descripcion" type="text" id="Descripcion" value="<? echo $_POST['Descripcion']!="Abono a cuenta"?$_POST['Descripcion']:""; ?>" size="20" />
              </label>
            <span class="textfieldRequiredMsg">A value is required.</span></span>
                Cod
                  <input name="Referencia" type="text" id="Referencia" size="6" />
                  <input type="hidden" name="AgregaFactura" value="1" id="textfield" />
                </td>
                

 <td rowspan="2" nowrap="nowrap" class="NombreCampo">Mensualidad</td>
          <td rowspan="2" nowrap="nowrap" class="FondoCampo"><select name="ReferenciaMesAno" id="ReferenciaMesAno">
<option value="0">Seleccione...</option>
<?php 
foreach($ReferenciaMesAno_array as $ReferenciaMesAno){
	echo "<option value=\"$ReferenciaMesAno\"";
	
	if($SelecProx ) //or $ReferenciaMesAno == date("m-y")
		echo " selected=\"selected\"";
	
	if($_POST['ReferenciaMesAno'] == $ReferenciaMesAno){
		$SelecProx = true;}
	else {
		$SelecProx = false;}
		
	
	echo " >$ReferenciaMesAno</option>";
}
?>
</select></td>

                
                
          <td  rowspan="2" class="NombreCampo">IVA</td>
          <td  rowspan="2" class="FondoCampo"><label>
            <input name="SWiva" type="checkbox" id="SWiva" value="1"   />
          </label></td>
          <td  rowspan="2" class="NombreCampo">Monto</td>
          <td  rowspan="2" align="right" nowrap="nowrap" class="FondoCampo" >
            Bs
              <input name="Monto" type="text" id="Monto" size="10" /><br>
              $<input name="MontoDebe_Dolares" type="text" id="MontoDebe_Dolares" size="10" />
            </td>
          <td  rowspan="2" class="FondoCampo"><label>
            <input type="submit" name="button3" id="button3" value="Agregar" onclick="this.disabled=true;this.form.submit();"  />
          </label></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="FondoCampo" >
            <?php
			
$query_RS_Asignaciones_Curso = "SELECT * FROM Asignacion 
								WHERE (Periodo = 'E' or Periodo = 'X')
								AND SWActiva = 1 
								AND (NivelCurso < '10' OR NivelCurso LIKE '%".$NivelCursoActual."%') 
								ORDER BY Periodo DESC, Orden, NivelCurso, Descripcion";
//echo $query_RS_Asignaciones_Curso;								
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
$totalRows_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->num_rows;
?>
<select name="CodigoAsignacion3" id="CodigoAsignacion3">
            <option value="">Seleccione...</option>
<?
do {  
?>
            <option value="<?php echo $row_RS_Asignaciones_Curso['Codigo']?>" <?php if($UltimoCodigoAsignacion3 == $row_RS_Asignaciones_Curso['Codigo']) echo ' selected="selected" '; ?> ><?php echo $row_RS_Asignaciones_Curso['Descripcion']?> --> <?php echo "(".$row_RS_Asignaciones_Curso['Monto_Dolares'].") ".$row_RS_Asignaciones_Curso['Monto']?> <?
            
			if ($row_RS_Asignaciones_Curso['MesAno'] > 0){
				
				echo "   ( ".Mes_Ano ($row_RS_Asignaciones_Curso['MesAno'])." )";
				
				}
			
			?></option>
            <?php
} while ($row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc());
  
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
?>
          </select></td>
        </tr>
</table>
 </form> 





           
             
                 
<?php include("Pendiente.php"); 
	
if ($MM_Username == "piero"){
	//include("PagosProcesando2.php"); 
}
	include("PagosProcesando.php"); 
	include("RegistrarPago.php"); ?>




 
   
     
 

 


<?php if($SW_PantallaCompleta){ // Observacion_EdoCuenta ?>
	 <iframe src="Observacion_EdoCuenta.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" width="80%" seamless frameborder="0"></iframe>
<? } ?>



<?php include("UltimosPagos.php"); ?>




<?php if($SW_PantallaCompleta){ // Asignacioens ?>
<iframe src="Asignaciones_EdoCuenta.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" width="80%" seamless frameborder="0"></iframe>
<?php } ?>

<p><a href="Historial_de_Pagos.php?CodigoPropietario=<?php echo $row_RS_Alumno['CodigoClave'] ?>&amp;CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank">Ver Historial de Pagos</a></p>
 
<p>&nbsp;<a href="http://www.colegiosanfrancisco.com/intranet/Pagos.php?CodigoPropietario=<?= $_GET['CodigoPropietario']; ?>" target="_blank">Vista Representante</a> | <a href="http://www.colegiosanfrancisco.com/Aviso_de_Cobro.php?CodigoPropietario=<?= $_GET['CodigoPropietario']; ?>" target="_blank">Aviso de cobro</a> | <a href="Observacion_EdoCuenta.php" target="_blank">Observaciones</a></p>
<p>&nbsp;</p>




		</div>
	</div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>