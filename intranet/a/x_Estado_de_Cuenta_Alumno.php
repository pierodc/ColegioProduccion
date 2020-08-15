<?php 
$MM_authorizedUsers = "99,91,95,90,Contable";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php'); 
require_once('../../inc/rutinas.php'); 
require_once('archivo/Variables_Privadas.php');

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Activa Inspeccion
$Insp = false ;


// Activa Renglon Resumen
if(isset($_GET['Resumen2'])) {
	setcookie('Resumen2',$_GET['Resumen2'],0);
	header("Location: ".$auxPag."?CodigoPropietario=".$_GET['CodigoPropietario']);
	}




//$MM_Username = $_COOKIE['MM_Username'];

// Cambia Inscribir 
/*if (isset($_GET['Inscribir']) and $_GET['Inscribir']==1) {
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Inscrito'
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";
		$rs = mysql_query($query, $bd) or die(mysql_error()); 
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']);}
*/
// fin Cambia PreInscribir

// Cambia Retirar 
/*if (isset($_GET['Retirar']) and $_GET['Retirar']==1) {
		mysql_select_db($database_bd, $bd);
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Aceptado'
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";
		$rs = mysql_query($query, $bd) or die(mysql_error()); 
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']);}
*/
// fin Cambia Retirar


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
		header("Location: ListaAlumnos.php?CodigoBuscar=".$_POST['Buscar']); exit;}

} 

// LLamado sin Codigo Clave, con Codigo Alumno
if ($CodidoBuscando > 0){
	$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = ".$CodidoBuscando;
	$RS_sql = $mysqli->query($sql);
	$row_RS_sql = $RS_sql->fetch_assoc();
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$row_RS_sql['CodigoClave']); }

// Apuntador misma pagina
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']); }






// Agrega Pago
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	$_SESSION['Referencia'] = $_POST['Referencia'];
					
	$insertSQL = sprintf("INSERT INTO ContableMov (Observaciones, CodigoCuenta, CodigoPropietario, CodigoReciboCliente, Tipo, Fecha, Referencia, ReferenciaOriginal, ReferenciaBanco, Descripcion, MontoDebe, MontoHaber, RegistradoPor, MontoDocOriginal) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($_POST['CodigoCuenta'], "int"),
                       GetSQLValueString($_POST['CodigoPropietario'], "int"),
                       GetSQLValueString($_POST['CodigoReciboCliente'], "text"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['ReferenciaBanco'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString(coma_punto($_POST['MontoDebe']), "double"),
                       GetSQLValueString(coma_punto($_POST['MontoHaber']), "double"),
		       GetSQLValueString($_POST['RegistradoPor'], "text"),
		       GetSQLValueString($_POST['MontoDocOriginal'], "double"));
//echo $insertSQL;
	$mysqli->query($insertSQL);
	$mensaje = "";
}
// FIN Agrega Pago






if ((isset($_POST["Divide_Pago"])) && ($_POST["Divide_Pago"] == "Divide_Pago")) {

//echo "Divide_Pago<br>";
      $sql = "SELECT * FROM ContableMov WHERE Codigo = '".$_POST["Codigo"]."'";
//echo $sql."<br>";
      $RS_sql_Aux = $mysqli->query($sql);
      $RS = $RS_sql_Aux->fetch_assoc();
      if($RS['MontoHaber'] > $_POST["Monto_divide"]){
            //echo "modifica e inserta<br>";
            $MontoOriginal = $RS['MontoHaber'];
            $NuevoMonto = $RS['MontoHaber'] - $_POST["Monto_divide"];
            $NuevoPago = $_POST["Monto_divide"];
            $sql_Update = "UPDATE ContableMov SET MontoHaber = '$NuevoMonto' WHERE Codigo = '".$_POST["Codigo"]."'";
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
		       GetSQLValueString($MM_Username, "text"),
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
	
	/*	
	if($totalRows_RS >= 1){
		$sql = "UPDATE AlumnoXCurso SET 
				CodigoCurso = '$CodigoCurso' ,
				Status_por = '$MM_Username' 
				WHERE CodigoAlumno = '$CodigoAlumno'
				AND Ano='$Ano'"; }
	else{
		$sql = sprintf("INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, CodigoCurso ) VALUES (%s, %s, %s)",
						   GetSQLValueString($_POST['CodigoAlumno'], "text"),
						   GetSQLValueString($_POST['Ano'], "text"),
						   GetSQLValueString($_POST['CodigoCurso'], "text")); 
		}		
	   */
	   
	   $sql2 = "INSERT INTO AlumnoXCurso 
	 				(CodigoAlumno, Status, Ano, CodigoCurso, Materias_Cursa, Tipo_Inscripcion, Status_por )
				VALUES 
					('$CodigoAlumno','$Status','$Ano','$CodigoCurso','$Materias_Cursa',
					'$Tipo_Inscripcion','$MM_Username')";				   
	   $mysqli->query($sql2);
		 
		//echo $sql1.'<br>'.$sql2.'<br>';				   
		
		
		 //$mysqli->query($sql);
 
 
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
	
/*
// Cambia SWAgostoFraccionado
if (isset($_GET['SWAgostoFraccionado'])) {
	$colname_RS_Alumnos = (get_magic_quotes_gpc()) ? $_GET['CodigoPropietario'] : addslashes($_GET['CodigoPropietario']);
	$sqlAux = sprintf("UPDATE Alumno SET SWAgostoFraccionado = '".$_GET['SWAgostoFraccionado']."' 
									WHERE CodigoClave = '%s'", $colname_RS_Alumnos);
	echo $Insp ?  $query_RS_Alumnos." (4)<br>" : "";
	$mysqli->query($sqlAux);
} // fin Cambia SWAgostoFraccionado
*/


//var_dump($POST);
// Agrega una Actividad eventual
if (isset($_POST['Actividad']) and isset($_POST['CodigoAsignacion3'])) {
	//echo "CodigoAsignacion3";
	
	$sqlAux = "SELECT * FROM Asignacion WHERE Codigo = '".$_POST['CodigoAsignacion3']."'";
	$RS_sql = $mysqli->query($sqlAux);
	$row_RS_sql = $RS_sql->fetch_assoc();
	$MontoDebe = $row_RS_sql['Monto'];
	$Descripcion = $row_RS_sql['Descripcion'];

	if($_POST['EventualMonto'] > 0){
		$MontoDebe = $_POST['EventualMonto'];
		}

	if($_POST['ReferenciaMesAno'] <> "0"){
		$FechaValor = "20". substr($_POST['ReferenciaMesAno'] , 3,2) ."-". substr($_POST['ReferenciaMesAno'] , 0,2) ."-01"; }
	else{
		$FechaValor = $_POST['FechaActividad']; }	

	$sqlAux = "INSERT INTO ContableMov 
		(CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, Descripcion, MontoDebe, ReferenciaMesAno) ";
	
	
	$sqlAux.= "( SELECT $CodigoAlumno, '$FechaValor', NOW(), '$FechaValor', 1, '".$_COOKIE['MM_Username']."', ";
	$sqlAux.= "'".$_POST['CodigoAsignacion3']."', '$Descripcion ".$_POST['EventualDescripcion']."', '$MontoDebe' ,'".$_POST['ReferenciaMesAno']."'  ";
	$sqlAux.= ") ";
	$sqlAux.= ""; echo $Insp ?  $sql." (5)<br>" : "";
	
	//$mysqli->query($sqlAux);
	
}

// Agrega una Factura Eventual
if (isset($_POST['EventualDescripcion'])) {
	$sqlAux = "INSERT INTO ContableMov 
	   (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, ReferenciaMesAno, Referencia, Descripcion, MontoDebe, SWiva) ";
	
	
	
	$sqlAux.= " VALUES ($CodigoAlumno,  '".$_POST['FechaEventual']."', NOW(),  '".$_POST['FechaEventual']."', 1, '".$_COOKIE['MM_Username']."', ";
	$sqlAux.= "'".$_POST['EventualReferencia']."' , '".$_POST['EventualDescripcion']."', '".$_POST['EventualDescripcion']."'  , ";
	$sqlAux.= "'".$_POST['EventualMonto']."','".$_POST['SWiva']."' )";
	echo $Insp ?  $sql." (8)<br>" : "";
	
	
	//$mysqli->query($sqlAux);
}




// NUEVO Agrega Factura
if (isset($_POST['AgregaFactura'])) {
	
	if($_POST['ReferenciaMesAno'] <> "0"){
		$FechaValor = "20". substr($_POST['ReferenciaMesAno'] , 3,2) ."-". substr($_POST['ReferenciaMesAno'] , 0,2) ."-02"; }
	else{
		$FechaValor = $_POST['FechaActividad']; }	

	
	if($_POST['CodigoAsignacion3'] > 0){
		$sqlAux = "SELECT * FROM Asignacion WHERE Codigo = '".$_POST['CodigoAsignacion3']."'";
		$RS_sql = $mysqli->query($sqlAux);
		$row_RS_sql = $RS_sql->fetch_assoc();
		$MontoDebe = $row_RS_sql['Monto'];
		$Descripcion = $row_RS_sql['Descripcion'];
		$Referencia = $_POST['CodigoAsignacion3'];
	}else{
		$MontoDebe = $_POST['Monto'];
		$Descripcion = $_POST['Descripcion'];
		$Referencia = $_POST['Referencia'];
		}
	
	
	
	$sqlAux = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, ";
	$sqlAux.= "ReferenciaMesAno, Referencia, Descripcion, MontoDebe, SWiva) ";
	
	$sqlAux.= " VALUES ($CodigoAlumno,  '$FechaValor', NOW(),  '$FechaValor', 1, '$MM_Username', ";
	$sqlAux.= " '".$_POST['ReferenciaMesAno']."',  '$Referencia', '$Descripcion' , '$MontoDebe', '".$_POST['SWiva']."')";
	
	
	
	
	echo $sqlAux;
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
									ContableMov.MontoDebe > 0
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
								AND ContableMov.MontoHaber > 0 
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



/*
// Asignaciones X Alumno
$query_RS_AsignacionesXAlumno = "
		SELECT  AsignacionXAlumno.*, Asignacion.*, AsignacionXAlumno.Codigo as CodAsi 
		FROM AsignacionXAlumno, Asignacion 
		WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
		AND Ano_Escolar = '$AnoEscolar' 
		AND CodigoAlumno = '".$CodigoAlumno. "' 
		ORDER BY Ano_Escolar, Orden";
echo $Insp ?  $query_RS_AsignacionesXAlumno." (13)<br>" : "";
$RS_AsignacionesXAlumno = $mysqli->query($query_RS_AsignacionesXAlumno);
$row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc();
$totalRows_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->num_rows;

// Calcula el monto de la mansualidad
$Mensualidad = 0;
$AnoEscolar_total='';
do {
	if ($AnoEscolar_total != $row_RS_AsignacionesXAlumno['Ano_Escolar']){
		$AnoEscolar_total  = $row_RS_AsignacionesXAlumno['Ano_Escolar'];
		$Mensualidad = 0;}
	$Mensualidad += $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'];
}  while ($row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc()); 

*/



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
	
if ((isset($_GET['Recibo'])) and ($_GET['Recibo'] == "0")) { // Cambiar OR por AND para produccion

	$query_RS_ContableMovAUX = sprintf("SELECT * FROM ContableMov, Alumno WHERE 
										Alumno.CodigoClave = '".$_GET['CodigoPropietario']."' AND 
										Alumno.CodigoAlumno = ContableMov.CodigoPropietario AND 
										ContableMov.SWCancelado = 0 AND 
										ContableMov.MontoDebe > 0 
										ORDER BY ContableMov.Fecha ASC, Codigo ASC", 
										GetSQLValueString($colname_RS_ContableMov, "text")); 
//echo $query_RS_ContableMovAUX;
	$RS_ContableMov = $mysqli->query($query_RS_ContableMovAUX);
	$row_RS_ContableMov = $RS_ContableMov->fetch_assoc();

	// Crear Registro de RECIBO
	$sql = "INSERT INTO Recibo 
			(CodigoPropietario, FechaCreacion, Fecha, FechaRecibo, Por) 
			VALUES 
			(".$row_RS_Alumno['CodAlu']." , NOW() , NOW() , NOW(), '".$_COOKIE['MM_Username']."')"; 
//echo $sql. "<br>";
	$mysqli->query($sql);
    $CodigoRecibo = $mysqli->insert_id;
		
	// Busca el registro Contable del pago
	$sql = "SELECT * FROM ContableMov 
			WHERE Codigo = ".$_GET['Codigo']; 
//echo $sql. "<br>";
	$RS_sql = $mysqli->query($sql);
	$row_sql = $RS_sql->fetch_assoc();
	$MontoDisponible = round($row_sql['MontoHaber'] , 2);
	
	// Asigna Numero de recibo al Mov de pago
	$sql = "UPDATE ContableMov SET SWCancelado='1', CodigoRecibo = ".$CodigoRecibo." 
			WHERE Codigo = ".$_GET['Codigo']; 
//echo $sql. "<br>";
	$mysqli->query($sql);

		do { // Asigna Codigo de recibo a cada MOVimiento a cancelar
		if( $MontoDisponible > 0  and $row_RS_ContableMov['SWCancelado'] == 0 ) { 
			$MontoPendiente = round($row_RS_ContableMov['MontoDebe'] - $row_RS_ContableMov['MontoAbono'] ,2);
			// existen fondos para otro pago y Mov esta pendiente
			if( $MontoDisponible >= $MontoPendiente ) { // existe fondo para pago total
				$sql = "UPDATE ContableMov 
						SET CodigoRecibo = ".$CodigoRecibo." , 
						SWCancelado = '1' 
						WHERE Codigo = ".$row_RS_ContableMov['Codigo']; //echo $sql. "<br>";
				$mysqli->query($sql);
				} // fin existe fondo para pago total
			else 
				{ // existe fondo para pago parcial
				$sql = "UPDATE ContableMov 
						SET MontoAbono = MontoAbono+".$MontoDisponible." 
						WHERE Codigo = ".$row_RS_ContableMov['Codigo']; //echo $sql;
				$mysqli->query($sql);
				$sql = "INSERT INTO ContableMov 
						(SWCancelado, CodigoRecibo, MontoDebe,  CodigoCuenta, CodigoPropietario, Fecha, FechaIngreso, FechaValor, Referencia, ReferenciaMesAno, Descripcion, SWValidado, RegistradoPor) 
						VALUES 
						('1', ".$CodigoRecibo.", ".$MontoDisponible.", 0, ".$row_RS_ContableMov['CodigoPropietario'].", '".$row_RS_ContableMov['Fecha']."', '".$row_RS_ContableMov['FechaIngreso']."', '".$row_RS_ContableMov['FechaValor']."', '".$row_RS_ContableMov['Referencia']."', ' ', 'ABONO ".$row_RS_ContableMov['Descripcion']." ".$row_RS_ContableMov['ReferenciaMesAno']."', '".$row_RS_ContableMov['SWValidado']."', 'auto')";
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
	       
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."&ImprimirRecibo=".$CodigoRecibo);
}

	       
//include_once("../../inc/analyticstracking.php") 


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title><?php echo $row_RS_Alumno['Nombres']; ?> <?php echo $row_RS_Alumno['Apellidos']; ?> <?php echo $row_RS_Alumno['Apellidos2']; ?> (<?php echo $row_RS_Alumno['CodigoAlumno']; ?>)</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="http://www.colegiosanfrancisco.com/img/SFA.png" type="image/png" />

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
function ValidaForma() {
form1.BotonRecibo.disabled=true; 
form1.submit(); 
return false;
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
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body <?php //if(isset($_GET['ImprimirRecibo'])){ echo "onload=window.open(\"../Recibo.php?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$_GET['ImprimirRecibo']."\")";}  ?>>
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="2"><?php   
	$TituloPantalla ="Estado de Cuenta";
	require_once('TitAdmin.php'); ?></td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" nowrap="nowrap">
    
    
    
      <table width="100%" border="0">
        <tr><?php 
		
/*$fotoNew = '../../'.$AnoEscolar.'/150/'.$CodigoAlumno.'.jpg';
$fotoOld = '../../'.$AnoEscolarAnte.'/'.$CodigoAlumno.'.jpg';
if(file_exists($fotoNew)){
	$foto = $fotoNew;}
else{
	$foto = $fotoOld;}
*/
		?>
        <td width="15%" align="center" valign="top"><img src="<?php echo Foto($row_RS_Alumno['CodigoAlumno'],"",150,"H") ?>" width="150" height="150"  border="0" /></td>
          
          
  <?php 
  $Familia = array('p','m','a1','a2','a3');
    
     foreach($Familia as $id){

		?>  
		<td align="center" valign="top"><?php 
		
		$Ruta = RutaFoto($row_RS_Alumno['CodigoAlumno'].$id , 300);
		if(file_exists($Ruta)){           
			$Ruta = RutaFotoURL($row_RS_Alumno['CodigoAlumno'].$id , 300);
			?><img src="<?php echo $Ruta ?>" alt="" height="150" border="0" /><?php 
		}
	
		
		
		$Ruta = '../Foto_Repre/'. $row_RS_Alumno['CodigoAlumno'].$id.'.jpg';
		$Actualizar = 'Actualizar';
		
		if (!file_exists($Ruta)) { 
			$Ruta = '../Foto_Repre/x_'. $row_RS_Alumno['CodigoAlumno'].$id.'.jpg';
			$Actualizar = 'Solicitada';
		}
		
		if(file_exists($Ruta)){
			?><img src="<?php echo $Ruta ?>" alt="" height="150" border="0" />
            
            <br />
			
            <a href="Procesa.php?ActualizaFoto=1&Foto=<?php echo $row_RS_Alumno['CodigoAlumno'].$id.'.jpg' ?>" target="_blank"><?php echo $Actualizar ?></a>
			
			<?php } ?>
			
            
          </td><?php 
		
    
    } 
  ?>        
 
 
  </tr>       
  <tr align="center" valign="top">        
       <td><a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" target="_blank"><?php echo $row_RS_Alumno['Nombres']; ?> <?php echo $row_RS_Alumno['Nombres2']; ?><br />
          <?php echo $row_RS_Alumno['Apellidos']; ?> <?php echo $row_RS_Alumno['Apellidos2']; ?></a></td>   
       <td>&nbsp;<?php 
		  $Repre = Repre($row_RS_Alumno['CodigoAlumno'] , "Padre");
		  //echo "<div title=\"".$Repre['TelCel']."\">";
		  echo Titulo_Mm($Repre['Nombres']).'<br>'.Titulo_Mm($Repre['Apellidos']);
		 // echo "</div>";
		  ?></td>   
       <td>&nbsp;<?php 
		  $Repre = Repre($row_RS_Alumno['CodigoAlumno'] , "Madre");
		  //echo "<div title=\"".$Repre['TelCel']."\">";
		  echo Titulo_Mm($Repre['Nombres']).'<br>'.Titulo_Mm($Repre['Apellidos']);
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
        </tr>
  </table>
      <table width="100%">
      <tr>
        <td width="2%"><a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>"><img src="http://www.colegiosanfrancisco.com/img/Reload.png" width="31" height="27" border="0" align="absmiddle" /></a></td>
        <td width="3%"><span class="RTitulo"><a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" target="_blank"><?php echo $row_RS_Alumno['CodigoAlumno']; ?></a></span></td>
        <td></td>
        <td align="center"><iframe src="sms_caja.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" width="600" height="50" frameborder="0"></iframe></td>
        <td align="right"><form id="form4" name="form4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input name="Buscar" type="text" id="Buscar" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" size="15" onfocus="this.value=''" />
          <input type="submit" name="button2" id="button2" value="Buscar" />
          </label>
        </form>    </td>
        </tr>
  </table>
    <div align="left"></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center">    <table width="100%" border="0">
  <tr>
    <td colspan="7">
 <?php include "Cobranza/ResumenMeses.php";?></td>
  </tr>
  <tr>
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
    <td align="left" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td colspan="-2" align="right" nowrap>&nbsp;</td>
  </tr>
  <tr>
    <td width="7%" nowrap="nowrap">Curso</td>
    <td width="6%" nowrap="nowrap">Actual</td>
    <td width="6%" nowrap="nowrap"><?php echo $AnoEscolar.':'; ?>&nbsp;</td>
   
<td width="24%" align="left" nowrap="nowrap"><form id="form6" name="form6" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
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
<td width="37%" align="left" nowrap="nowrap"><?php 
if($MM_UserGroup == 91 or $MM_UserGroup == 95)
if($AnoEscolar == $AnoEscolarProx)
if($SWinscrito_Actual){

?>
  <a href="Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>">Retira
  <?php 
	  
}else{
	
	$sql="SELECT * FROM Curso WHERE CodigoCurso='".$CodigoCurso."'";
	//echo $sql;
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	$CodigoCursoProxAno = $row_['CodigoCursoProxAno'];
	$NivelCurso = $row_['NivelCurso'];
	
	?>
   <?php echo $AnoEscolar ?></a><a href="Procesa.php?<?php echo 'Inscribir=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolar; ?>" target="_blank">Inscribir <?php echo $AnoEscolar ?></a>
  <?php } ?></td>
      
      
      
      
    <td width="16%" align="center" nowrap="nowrap">
 <?php 
$_sql = "SELECT * FROM ContableMov 
 		 WHERE CodigoPropietario = $CodigoAlumno 
		 AND ReferenciaMesAno = 'Ins ".date("y")."' 
		 AND Descripcion = 'Matrícula' ";
		 
$_RS = $mysqli->query($_sql);
$_row_RS = $_RS->fetch_assoc();
$_totalRows = $_RS->num_rows;

if($_totalRows==0 ){

 ?><a href="Agrega_Fact_Inscripcion.php?CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank">Fac.Ins.</a>
        <?php } ?>
        
        </td>
    <td width="4%" colspan="-2" align="right" nowrap>&nbsp;</td>
  </tr>
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
    <td align="left" nowrap="nowrap"><?php 
if($MM_UserGroup == 91)	
if($AnoEscolar != $AnoEscolarProx )
if($SWinscrito_Prox){

?>
      <a href="Procesa.php?<?php echo 'Retirar=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Retirar <?php echo $AnoEscolarProx ?></a>
      <?php 
	  
}else{
	
	$sql="SELECT * FROM Curso WHERE CodigoCurso='".$row_RS_Alumno['CodigoCurso']."'";
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	$CodigoCursoProxAno = $row_['CodigoCursoProxAno'];
	$NivelCurso = $row_['NivelCurso'];
	
	if($row_Curso_Prox['Status'] == "Aceptado" and $row_RS_Alumno['Deuda_Actual'] <1 ){
	?>
      <a href="Procesa.php?<?php echo 'Inscribir=1&CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&AnoEscolar='.$AnoEscolarProx; ?>" target="_blank">Inscribir <?php echo $AnoEscolarProx ?></a>
      <?php }}
	  
	   ?></td>
    <td colspan="2" align="right" nowrap="nowrap">Mercantil <?php echo round((time()-$FechaBanco["merc"]) / 3600 , 2 ) ?><br>Provincial <?php echo round((time()-$FechaBanco["prov"]) / 3600 , 2 ) ?>
    
    

    
    
    
    </td>
    </tr>
  <tr>
    <td colspan="7" align="center">
    
    
    
               
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="subtitle">&nbsp;Agregar Factura</td></tr>
        
        
   <? /*       
  <tr>
    <td><form id="form7" name="form7" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
     
     
      <table width="200" border="0" align="right">
        <tr>
          <td nowrap="nowrap" class="NombreCampo">Agosto Fraccionado:</td>
          <td nowrap="nowrap" class="FondoCampo"><?php if($row_RS_Alumno['SWAgostoFraccionado']) {echo "SI";}else{echo "NO";} ?>
            <span style="font-weight: bold">(<a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&amp;SWAgostoFraccionado=<?php if($row_RS_Alumno['SWAgostoFraccionado']) {echo "0";}else{echo "1";} ?>">Cambiar</a>)</span></td>
        </tr>
      </table>
    
    
    </form></td>
  </tr>
  
 */ ?>
  
  
  <tr>
    <td><form id="form5" name="form5" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
      
      
      <table border="0" width="100%">
        <tr>
          <td rowspan="2" nowrap="nowrap" class="NombreCampo">Fecha:</td>
          <td rowspan="2" nowrap="nowrap" class="FondoCampo"><input name="FechaActividad" type="date" value="<?php echo date('Y-m-d') ?>" /></td>
        <td rowspan="2" nowrap="nowrap" class="NombreCampo"> Eventual: Descripci&oacute;n:</td>
          <td width="38%" nowrap="nowrap" class="FondoCampo" ><span id="sprytextfield3">
            <label>
              <input name="Descripcion" type="text" id="Descripcion" size="20" />
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
	
	if($SelecProx or $ReferenciaMesAno == date("m-y"))
		echo " selected=\"selected\"";
	
	if($_POST['ReferenciaMesAno'] == $ReferenciaMesAno){
		$SelecProx = true;}
	else {
		$SelecProx = false;}
		
	
	echo " >$ReferenciaMesAno</option>";
}
?>
</select></td>

                
                
          <td width="4%" rowspan="2" class="NombreCampo">IVA</td>
          <td width="5%" rowspan="2" class="FondoCampo"><label>
            <input name="SWiva" type="checkbox" id="SWiva" value="1" />
          </label></td>
          <td width="9%" rowspan="2" class="NombreCampo">Monto</td>
          <td width="16%" rowspan="2" class="FondoCampo" ><span id="sprytextfield4">
            <label>
              <input name="Monto" type="text" id="Monto" size="15" />
              </label>
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          <td width="14%" rowspan="2" class="FondoCampo"><label>
            <input type="submit" name="button3" id="button3" value="Agregar" onclick="this.disabled=true;this.form.submit();"  />
          </label></td>
        </tr>
        <tr>
          <td nowrap="nowrap" class="FondoCampo" ><select name="CodigoAsignacion3" id="CodigoAsignacion3">
            <option value="">Seleccione...</option>
            <?php
			
$query_RS_Asignaciones_Curso = "SELECT * FROM Asignacion 
								WHERE (Periodo = 'E' or Periodo = 'X')
								AND SWActiva = 1 
								AND (NivelCurso < '10' OR NivelCurso LIKE '%".$NivelCursoActual."%') 
								ORDER BY Periodo, Orden, Descripcion";
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
$totalRows_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->num_rows;

do {  
?>
            <option value="<?php echo $row_RS_Asignaciones_Curso['Codigo']?>" <?php if($_POST['CodigoAsignacion3'] == $row_RS_Asignaciones_Curso['Codigo']) echo ' selected="selected" '; ?> ><?php echo $row_RS_Asignaciones_Curso['Descripcion']?> --> <?php echo $row_RS_Asignaciones_Curso['Monto']?></option>
            <?php
} while ($row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc());
  
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
?>
          </select></td>
        </tr>
      </table>
      
      
    </form></td>
  </tr>
</table>



    
    
    </td>
  </tr>
</table>
     
     <?php include("Cobranza/Pendiente.php"); ?>
     
        </div>
      </div>
      
 
 
 

 
      
      
<?php include("Cobranza/PagosProcesando.php"); ?>



<div id="CollapsiblePanel1" class="CollapsiblePanel">
        <div class="subtitle" tabindex="0">
          <div align="left">&nbsp;Registrar Pago</div>
        </div>
        <div class="CollapsiblePanelContent">
          <form action="<?php echo $editFormAction; ?>#Pendiente" method="post" name="form1" id="form1"><table width="100%" border="0" align="center" bordercolor="#333333">
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Forma de Pago</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><span id="spryselect3">
                <label>
                <select name="Tipo" id="Tipo">
                  <option>Seleccione...</option>
                  <option value="1">Deposito</option>
                  <option value="2">Transferencia</option>
                  <option value="3">Cheque</option>
                  <option value="4">Efectivo</option>
                  <option value="5">Ajuste</option>   
                  <option value="6">T. Debito</option>  
                  <option value="7">T. Credito</option>                  
                </select>
                </label>
                <span class="selectRequiredMsg">*</span></span>
                <span onclick="document.form1.Tipo.selectedIndex=4">- efec -</span> | 
                <span onclick="document.form1.Tipo.selectedIndex=3">- Che -</span> | 
                <span onclick="document.form1.Tipo.selectedIndex=1">- Dep -</span> | 
                <span onclick="document.form1.Tipo.selectedIndex=2">- Tr - </span> | 
                <span onclick="document.form1.Tipo.selectedIndex=6">- Debito - </span> | 
                <span onclick="document.form1.Tipo.selectedIndex=7">- Credito - </span></td>
              <td class="NombreCampo">
<?php // Busca los movimientos hijos del recibo
$CodigoRecibo = $row_Recibos['CodigoRecibo'];
$query_Recibos_Hijos = "SELECT * FROM ContableMov 
						WHERE CodigoRecibo = '$CodigoRecibo' 
						ORDER BY MontoHaber DESC, Fecha ASC, Codigo ASC";//echo $query_Recibos;
$Recibos_Hijos = $mysqli->query($query_Recibos_Hijos);
$row_Recibos_Hijos = $Recibos_Hijos->fetch_assoc();

if($row_Recibos_Hijos['CodigoReciboCliente']==0 and $row_RS_Alumno['Fac_Rif']==""){
	echo "Seleccione Facturar a:<br>";
}
else{


	$sql = "SELECT MAX(Fac_Num_Control) AS NumControlMax FROM Recibo";
	$RS_aux = $mysqli->query($sql);
	$row_aux = $RS_aux->fetch_assoc();
	$NumeroControlProx = $row_aux['NumControlMax']+1;

?><a href="Contabilidad/PDF/Factura.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>" target="_blank">Factura <?php echo $NumeroControlProx ?></a><?php } ?> 
                
                Fecha</td>
              <td class="FondoCampo"><input name="Fecha" type="date" id="FechaNac" value="<?php echo date('Y-m-d') ?>" />
                  <?php //FechaFutura('Fecha', date('Y-m-00')) ?>
                  <span onclick="document.form1.FD_Fecha2.selectedIndex=<?php echo date('d')*1 ?>"> <-- hoy</span></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Pagado en</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><span id="spryselect1">
                <label>
                <select name="CodigoCuenta" id="CodigoCuenta">
                  <option value="10">Caja</option>
                  <option value="1">Mercantil</option>
                  <option value="2">Provincial</option>
                  <?php  if ($_COOKIE['MM_UserGroup']=='99'){  ?>
                  <option value="3">Venezuela</option>
                  <option value="4">V. de Cred.</option>
                  <?php } ?>
                </select>
                </label>
                <span class="selectRequiredMsg">*</span></span> <span onclick="document.form1.CodigoCuenta.selectedIndex=1">- Mercantil -</span> | <span onclick="document.form1.CodigoCuenta.selectedIndex=2">- Provincial -</span></td>
              <td class="NombreCampo">Referencia</td>
              <td class="FondoCampo"><span id="sprytextfield2">
              <input type="text" name="Referencia" value="" size="15" onfocus="this.value=<?php echo $_SESSION['Referencia'] ?>" />
              <span class="textfieldRequiredMsg">Inv&aacute;lido</span><span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Cheque Banco</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><label>
                <input name="ReferenciaBanco" type="text" id="ReferenciaBanco" size="20" />
              </label></td>
              <td class="NombreCampo">Monto</td>
              <td class="FondoCampo"><span id="MontoHaber">
                <span id="sprytextfield1">
                <input type="text" name="MontoHaber" value="" size="15"  onfocus="this.value=<?php echo $MontoRestante; ?>"  />
                <br />
                <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldInvalidFormatMsg">Formato Invalido, use el punto (.) como decimal</span><span class="textfieldMinValueMsg">Requerido</span><span class="textfieldMaxValueMsg">Monto es mayor a la deuda</span></span> (Pendiente: BsF <?php $MontoPendiente = $saldo*1; echo Fnum($MontoPendiente); ?>)</span></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Observaciones</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><input name="Observaciones" type="text" id="Observaciones" size="20" /></td>
              <td class="NombreCampo">Monto Documento</td>
              <td class="FondoCampo"><input name="MontoDocOriginal" type="text" id="MontoDocOriginal" size="15" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Facturar a:</td>
              <td align="left" nowrap="nowrap" class="FondoCampo">
                <select name="CodigoReciboCliente" id="select">
                <?php 
				$sql = "SELECT * FROM ReciboCliente
						WHERE CodigoAlumno = '$CodigoAlumno'";
				$RS = $mysqli->query($sql);
				$row = $RS->fetch_assoc();
				$totalRows = $RS->num_rows;
				if($totalRows >= 1){
				?><option value="0">Seleccione...</option>
                  <?php }
				do{
					extract($row);
					echo "<option value=\"$Codigo\">$Nombre</option>";
				} while($row = $RS->fetch_assoc());
				
				  ?>
                </select>
(<a href="Recibo_Crea_Cliente.php?CodigoAlumno=<?php echo $CodigoAlumno ?>&CodigoPropietario=<?php echo $_GET['CodigoPropietario'] ?>">crea Nombre</a>)
<input type="hidden" name="CodigoPropietario" value="<?php echo $CodigoAlumno; ?>" />
                <input type="hidden" name="RegistradoPor" value="<?php echo $MM_Username; ?>" />
                <input type="hidden" name="Descripcion" value="Abono a cuenta" />
                <input type="hidden" name="MontoDebe" value="" />
                <input type="hidden" name="FechaIngreso" value="<?php echo date('Y-m-d h:i:s'); ?>" />
                <input type="hidden" name="MM_insert" value="form1" /></td>
              <td colspan="2" align="right" class="FondoCampo"><input type="submit" value="Guardar" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap">                    </td>
              </tr>
          </table>
          </form>
        </div>
      </div>
















<? /*
               
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="subtitle">&nbsp;Agregar Factura</td></tr>
  <tr>
    <td><form id="form7" name="form7" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
     
     
      <table width="200" border="0" align="right">
        <tr>
          <td nowrap="nowrap" class="NombreCampo">Agosto Fraccionado:</td>
          <td nowrap="nowrap" class="FondoCampo"><?php if($row_RS_Alumno['SWAgostoFraccionado']) {echo "SI";}else{echo "NO";} ?>
            <span style="font-weight: bold">(<a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&amp;SWAgostoFraccionado=<?php if($row_RS_Alumno['SWAgostoFraccionado']) {echo "0";}else{echo "1";} ?>">Cambiar</a>)</span></td>
        </tr>
      </table>
    
    
    </form></td>
  </tr>
  <tr>
    <td><form id="form5" name="form5" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
      
      
      <table border="0" width="100%">
        <tr>
          <td nowrap="nowrap" class="NombreCampo">Fecha:</td>
          <td nowrap="nowrap" class="FondoCampo"><input name="FechaActividad" type="date" value="<?php echo date('Y-m-d') ?>" /></td>
        <td nowrap="nowrap" class="NombreCampo"> Actividad:<br /></td>
          <td nowrap="nowrap" class="FondoCampo"><select name="CodigoAsignacion3" id="CodigoAsignacion3">
            <option value="">Seleccione...</option>
            <?php
			
$query_RS_Asignaciones_Curso = "SELECT * FROM Asignacion 
								WHERE Periodo = 'E' 
								AND SWActiva = 1 
								AND (NivelCurso < '10' OR NivelCurso LIKE '%".$NivelCurso."%') 
								ORDER BY Orden, Descripcion";
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
$totalRows_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->num_rows;

do {  
?>
<option value="<?php echo $row_RS_Asignaciones_Curso['Codigo']?>" <?php if($_POST['CodigoAsignacion3'] == $row_RS_Asignaciones_Curso['Codigo']) echo ' selected="selected" '; ?> ><?php echo $row_RS_Asignaciones_Curso['Descripcion']?> --> <?php echo $row_RS_Asignaciones_Curso['Monto']?></option>
            <?php
} while ($row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc());
  
$RS_Asignaciones_Curso = $mysqli->query($query_RS_Asignaciones_Curso);
$row_RS_Asignaciones_Curso = $RS_Asignaciones_Curso->fetch_assoc();
?>
          </select></td>          
          <td nowrap="nowrap" class="NombreCampo"> Eventual: Descripci&oacute;n:</td>
          <td width="38%" nowrap="nowrap" class="FondoCampo" ><span id="sprytextfield3">
            <label>
              <input name="Descripcion" type="text" id="Descripcion" size="20" />
              </label>
            <span class="textfieldRequiredMsg">A value is required.</span></span>
                Cod
                  <input name="Referencia" type="text" id="Referencia" size="6" />
                  <input type="hidden" name="AgregaFactura" value="1" id="textfield" />
                </td>
                

 <td nowrap="nowrap" class="NombreCampo">Mensualidad</td>
          <td nowrap="nowrap" class="FondoCampo"><select name="ReferenciaMesAno" id="ReferenciaMesAno">
<option value="0">Seleccione...</option>
<?php 
foreach($ReferenciaMesAno_array as $ReferenciaMesAno){
	echo "<option value=\"$ReferenciaMesAno\"";
	
	if($SelecProx or $ReferenciaMesAno == date("m-y"))
		echo " selected=\"selected\"";
	
	if($_POST['ReferenciaMesAno'] == $ReferenciaMesAno){
		$SelecProx = true;}
	else {
		$SelecProx = false;}
		
	
	echo " >$ReferenciaMesAno</option>";
}
?>
</select></td>

                
                
          <td width="4%" class="NombreCampo">IVA</td>
          <td width="5%" class="FondoCampo"><label>
            <input name="SWiva" type="checkbox" id="SWiva" value="1" />
          </label></td>
          <td width="9%" class="NombreCampo">Monto</td>
          <td width="16%" class="FondoCampo" ><span id="sprytextfield4">
            <label>
              <input name="Monto" type="text" id="Monto" size="15" />
              </label>
            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          <td width="14%" class="FondoCampo"><label>
            <input type="submit" name="button3" id="button3" value="Agregar" />
          </label></td>
        </tr>
      </table>
      
      
    </form></td>
  </tr>
</table>

*/ ?>

<?php // ?>


<p>&nbsp; </p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td class="subtitle">Asignaciones</td>
  </tr>
  <tr>
    <td><iframe src="Cobranza/Asignaciones_EdoCuenta.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" width="100%"></iframe></td>
  </tr>
</table>
<p>&nbsp;</p>




<?php // ?><p><a href="Historial_de_Pagos.php?CodigoPropietario=<?php echo $row_RS_Alumno['CodigoClave'] ?>&CodigoAlumno=<?php echo $row_RS_Alumno['CodigoAlumno'] ?>" target="_blank">Ver Historial de Pagos</a></p>
<?php if (1==1){ ?>
      <div id="CollapsiblePanel4" class="CollapsiblePanel">
        <div class="subtitle" tabindex="0">
          <div align="left">&nbsp;Historial de Pagos</div>
</div>
        <div class="CollapsiblePanelContent">
          <table width="100%" border="0">
            <tr>
              <td class="NombreCampo"><span class="subtitle">
                <?php
// Busca todos los recibos
$query_Recibos = "SELECT * FROM Recibo 
					WHERE CodigoPropietario = $CodigoAlumno 
					ORDER BY CodigoRecibo DESC";

$Recibos = $mysqli->query($query_Recibos);
$row_Recibos = $Recibos->fetch_assoc();
$totalRows_Recibos = $Recibos->num_rows;

?>
              </span></td>
              <td class="NombreCampo"><div align="left">Fecha</div></td>
              <td colspan="2" class="NombreCampo"><div align="left">Descripci&oacute;n</div></td>
              <td class="NombreCampo"><div align="center">Ref</div></td>
              <td width="100" align="center" class="NombreCampo"><div align="right">Pago</div></td>
              <td width="100" align="center" class="NombreCampo"><div align="right">Abonado</div></td>
              <td width="49" align="center" class="NombreCampo"><div align="right">Cargos</div></td>
              <td width="49" align="center" class="NombreCampo"><div align="center">Por</div></td>
            </tr>
            <?php if ($totalRows_Recibos > 0){ ?>
            
            
            <?php  $saldo=0; $Par = true; $Despliega = 2; ?>
 <?php do { // RECIBOS ?>
             <tr>
              <td colspan="9" bgcolor="#0033FF"><img src="../../img/b.gif" width="1" height="1" /></td>
            </tr>
		
        
        
        	<tr >
              <?php //if ($Par) {$In = "In"; $Par=false;}else{$In = ""; $Par=true;} ?>
              <td colspan="2" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><b><?php echo DDMMAAAA($row_Recibos['Fecha']); ?></b></td>
              <td colspan="2" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>">Recibo <?php echo $row_Recibos['CodigoRecibo']; ?></td>
              <td class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><b><b>

<?php // Busca los movimientos hijos del recibo
$CodigoRecibo = $row_Recibos['CodigoRecibo'];
$query_Recibos_Hijos = "SELECT * FROM ContableMov 
						WHERE CodigoRecibo = '$CodigoRecibo' 
						ORDER BY MontoHaber DESC, Fecha ASC, Codigo ASC";
//echo $query_Recibos_Hijos;
$Recibos_Hijos = $mysqli->query($query_Recibos_Hijos);
$row_Recibos_Hijos = $Recibos_Hijos->fetch_assoc();
$totalRows_Recibos_Hijos = $Recibos_Hijos->num_rows;

 
if($row_Recibos_Hijos['CodigoReciboCliente'] < 1 and $row_Recibos['NumeroFactura']==0){
	echo "Seleccione Facturar a:";
	}

else
	if($totalRows_Recibos_Hijos>0){
		$sql = "SELECT MAX(NumeroFactura) AS NumFacMax FROM Recibo";
		
		$RS_aux = $mysqli->query($sql);
		$row_aux = $RS_aux->fetch_assoc();
		
		$NumFacMax = $row_aux['NumFacMax'];
		
		$NumeroFactura = $row_Recibos['NumeroFactura']*1;
		
		if ($row_Recibos['NumeroFactura']==0 or $NumeroFactura==$NumFacMax ){ 
			?>
			<a href="Contabilidad/PDF/Factura.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>"  onclick="this.disabled=true;" target="_blank"><img src="../../i/cash_register_2.png" width="32" height="32" /> Facturar</a>
			<?php }  } 
			
		if($row_Recibos['NumeroFactura'] > 0){
			echo "Factura No. ".$row_Recibos['NumeroFactura']; }
		if($row_Recibos['Fac_Num_Control'] > 0){
			echo "<br>Control No. ".$row_Recibos['Fac_Num_Control']; }
				
				?>
		</td>
<td colspan="2" align="right" nowrap="nowrap" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>">&nbsp;</td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><a href="../Recibo.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>" target="_blank">imprimir<br />
              Recibo </a></td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><?php echo substr($row_Recibos['Por'],0,5); ?></td>
            </tr> 



<?php do { // Hijos del Recibo ?>
            
                      
            <tr >
              <?php if ($Par) {$In = "In"; $Par=false;}else{$In = ""; $Par=true;} ?>
              <td class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><div align="center">
               <?php 
if ( $MM_Username=="piero") { ?>

<iframe src="Procesa.php?bot_EliminarMov=1&Codigo=<?php echo $row_Recibos_Hijos['Codigo']; ?>" seamless="seamless" width="17" height="17" frameborder="0" ></iframe>
<?php } ?>
              </div></td>
              <td class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><?php echo $row_Recibos_Hijos['MontoHaber']>0? date('d-m-Y', strtotime($row_Recibos_Hijos['FechaIngreso'])):'';  ?></td>
              <td class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>">

<?php if ($row_Recibos_Hijos['Descripcion'] == "Abono a cuenta"){ ?>

<?php if ($row_Recibos['NumeroFactura']==0) { ?>
              
<form id="form3" name="form3" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
      <br />
      Facturar a:<br>
      <input name="Codigo" type="hidden" value="<?php echo $row_Recibos_Hijos['Codigo']; ?>" />
      <input name="CambiaNombreFactura" type="hidden" value="1" />
      <select name="CodigoReciboCliente" id="CodigoReciboCliente"><?php 
				$sql = "SELECT * FROM ReciboCliente
						WHERE CodigoAlumno = '$CodigoAlumno'";
				$RS = $mysqli->query($sql);
				$row = $RS->fetch_assoc();
				$totalRows = $RS->num_rows;
				if($totalRows >= 1){
				?>
        <option value="0" <?php if($row_Recibos_Hijos['CodigoReciboCliente']==0) 
					echo 'selected="selected"'; ?>>Seleccione...</option>
        <?php }
				do{
					extract($row);
					echo "<option value=\"$Codigo\"";
					if($row_Recibos_Hijos['CodigoReciboCliente']==$row['Codigo']) 
					echo ' selected="selected" ';
					echo ">$Nombre</option>";
				} while($row = $RS->fetch_assoc());
				
				  ?>
      </select>
      <input type="submit" name="BotonRecibo2" id="BotonRecibo2" value="Guardar" onclick="this.disabled=true;this.form.submit();" />
      </form>
                          
    <?php } 
	else { echo "PAGO"; }
	?>                      
    <?php }else{?>                      
<b><?php echo $row_Recibos_Hijos['Descripcion'] ?></b>
    <?php } ?>          
              
              
              </td>
              <td class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>" nowrap="nowrap"><b><?php 
			  
			  if ($row_Recibos_Hijos['ReferenciaMesAno']!=0)
			  	echo Mes_Ano($row_Recibos_Hijos['ReferenciaMesAno']); 
			  
			  ?></b></td>
              <td class="<?php 
				$MontoBancoAux='';
					// Ubica si esta en banco
					$query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo WHERE Referencia = '".$row_Recibos_Hijos['Referencia']."'";
					
					$RS_del_Banco = $mysqli->query($query_RS_del_Banco);
					$row_RS_del_Banco = $RS_del_Banco->fetch_assoc();
					$totalRows_RS_del_Banco = $RS_del_Banco->num_rows;

					if($row_Recibos_Hijos['MontoHaber']<=$row_RS_del_Banco['MontoHaber'] and $row_Recibos_Hijos['MontoHaber']>0) {
						
					if($row_Recibos_Hijos['MontoHaber']==$row_RS_del_Banco['MontoHaber']){	
					echo "FondoCampoVerde"; }
					elseif($row_Recibos_Hijos['MontoHaber']<=$row_RS_del_Banco['MontoHaber']){	
					echo "FondoCampoAmarillo"; 
					$MontoBancoAux=$row_RS_del_Banco['MontoHaber'];
					}
					
					 } 
					elseif ($row_Recibos_Hijos['MontoHaber']>0){ 
					
					if( $row_Recibos_Hijos['Tipo']==3) {
					echo "FondoCampoAzul";}
					elseif($row_Recibos_Hijos['Tipo']==4) {
					echo "FondoCampoNaranja";}
					elseif($row_Recibos_Hijos['MontoHaber']>0){
					echo "FondoCampoRojo"; }
					
					 } else{
					echo 'Listado' . $In . 'Par';
					}
				
				
				
				?>"><div align="center"><b><?php 
				if($row_Recibos_Hijos['MontoHaber']>0){
				
				if( $row_Recibos_Hijos['Tipo']==1) echo "Dep: "; 
				if( $row_Recibos_Hijos['Tipo']==2) echo "Tr: "; 
				if( $row_Recibos_Hijos['Tipo']==3) echo "Ch: "; 
				if( $row_Recibos_Hijos['Tipo']==4) echo "Efec: "; 
				if( $row_Recibos_Hijos['Tipo']==5) echo "Aju: ";
				echo ' '; 
				echo $row_Recibos_Hijos['ReferenciaBanco'].' ';
				echo $row_Recibos_Hijos['Referencia'].' '; 
				echo FNum($MontoBancoAux);
				
				if($row_Recibos_Hijos['ReferenciaOriginal']<> $row_Recibos_Hijos['Referencia']  ) echo '<br>Ref. Orig. '. $row_Recibos_Hijos['ReferenciaOriginal'] ;
				
				
				}
				
				if(!$row_Recibos_Hijos['Referencia']==$row_Recibos_Hijos['ReferenciaOriginal']){
					echo ' [Orig: '.$row_Recibos_Hijos['ReferenciaOriginal'].']';}
				
				?></b></div></td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><b>
                <?php if($row_Recibos_Hijos['MontoHaber']>0) {echo $row_Recibos_Hijos['MontoHaber'];} ?>
              </b></td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><b>
                <?php if($row_Recibos_Hijos['SWValidado']>0  AND $row_Recibos_Hijos['MontoAbono']>0) {echo $row_Recibos_Hijos['MontoAbono'];} ?>
              </b></td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><b>
                <?php if($row_Recibos_Hijos['SWValidado']>0) {$auxMonto = $row_Recibos_Hijos['MontoDebe']-$row_Recibos_Hijos['MontoAbono']; echo Fnum($auxMonto);} ?>
              </b></td>
              <td align="right" class="Listado<?php echo $In; ?>Par<?php echo $Azul ?>"><div align="center"> <?php echo substr($row_Recibos_Hijos['RegistradoPor'],0,5); ?></div></td>
            </tr>


            
			
			
			  
   <?php			  
			  
			  } while ($row_Recibos_Hijos = $Recibos_Hijos->fetch_assoc()); // Hijos del Recibo
			 $Despliega=$Despliega-1;
			 if( $Despliega==0 )  break;
			 
	     } while ($row_Recibos = $Recibos->fetch_assoc()); 
              
              
 } // fin SI Existen recibos if ($totalRows_Recibos>0) ?>
          </table>
        </div>
      </div>
  <?php } ?>
  <?php // ?>
      
      <p>&nbsp; </p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td class="subtitle">Observaciones</td>
  </tr>
  <tr>
    <td><iframe src="Cobranza/Observacion_EdoCuenta.php?CodigoAlumno=<?php echo $CodigoAlumno ?>" width="100%"></iframe></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

  </td>
  </tr>
</table>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur", "change"], isRequired:false});
//-->
</script>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<script>
$(document).ready(function() {
	$("#ActualizaPendientes").on("click",function(e){
	    e.preventDefault();
		$("#Pendiente").load("Pendiente.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>");
	});

});
</script>