<?php 
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
//initialize the session
//if (!isset($_SESSION)) {
  //session_start();
//}

require_once('Connections/bd.php'); 
date_default_timezone_set('America/Caracas');
$MM_Username ='';
//print_r($_COOKIE);

//$MM_Username;$MM_UserGroup;$MM_Iniciales;$Privilegios;$Acceso_US;
		
function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 

// *** Validate request to login to this site.

if (isset($_COOKIE["CookieLocal"]))
	$CookieLocal = $_COOKIE['CookieLocal'];

if (isset($_COOKIE["MM_Username"]))
	if($_COOKIE['MM_Username'] > ''){
		$MM_Username  = $_COOKIE['MM_Username'];
		$MM_UserGroup = $_COOKIE['MM_UserGroup'];
		$MM_Iniciales = $_COOKIE['MM_Iniciales'];
		$Privilegios  = $_COOKIE['Privilegios'];
		if(isset($_COOKIE['Acceso_US']))
			$Acceso_US    = $_COOKIE['Acceso_US'];
		$Codigo_US    = $_COOKIE['Codigo_US'];
	}


if (isset($_POST['Usuario'])) {
  $MM_Username = $_POST['Usuario'];
	$_SESSION['Usuario']= $MM_Username;
  $password = $_POST['Clave'];
  $MM_redirectLoginFailed = $_SERVER['PHP_SELF']."?error=login";
  $MM_redirecttoReferrer = false;
  //mysql_select_db($database_bd, $bd);
  	
  $LoginRS__query = "SELECT Codigo, Usuario, Clave, Privilegios, Iniciales 
  								FROM Usuario 
								WHERE Usuario='$MM_Username' AND Clave='$password'"; 
  //echo  $LoginRS__query;
//  $LoginRS = mysql_query($LoginRS__query, $bd) or die(mysql_error());
//  $row_Login = mysql_fetch_assoc($LoginRS);
$LoginRS = $mysqli->query($LoginRS__query);
$row_Login = $LoginRS->fetch_assoc();
$loginFoundUser = $LoginRS->num_rows;
  

  $Privilegios = $row_Login['Privilegios'];
  $Codigo_US = $row_Login['Codigo'];
	
	
	
	$MM_redirectLoginSuccess = "http://www.colegiosanfrancisco.com/intranet/a/index.php";
	if($row_Login['Privilegios'] == '2')
 		$MM_redirectLoginSuccess = "http://www.colegiosanfrancisco.com/intranet/index.php";
	if($row_Login['Privilegios'] == 'docente' or $row_Login['Privilegios'] == 'Coordinador' )
		$MM_redirectLoginSuccess = "http://www.colegiosanfrancisco.com/Docente/index.php";
	
	if($MM_Username == $password)
		$MM_redirectLoginSuccess = "http://www.colegiosanfrancisco.com/CambioClave.php?Error=Cambiar";
	
	//echo $MM_redirectLoginSuccess;
 // $loginFoundUser = mysql_num_rows($LoginRS);
  
  
  if ($loginFoundUser) {
	  	//echo "Login ok";
		$MM_UserGroup  = mysqli_result($LoginRS,0,'Privilegios');
		$MM_Iniciales  = mysqli_result($LoginRS,0,'Iniciales');
	
		//$MM_UserGroup = $LoginRS->result(0,'Privilegios');
		//$MM_Iniciales = $LoginRS->result(0,'Iniciales');
		
		
		
		$sql_Trace = "INSERT INTO Usuario_Logs (CodigoUsuario, Usuario, Computador, IP, Session_id) VALUES 
						('".$Codigo_US."' ,'".$MM_Username."' , '". $_SERVER['HTTP_USER_AGENT'] ."' ,
						 '". $_IP ."', '$_Session_id' )";
		//echo $sql_Trace;
		$LoginRS = $mysqli->query($sql_Trace);
		$Usuario_Logs_Codigo = $mysqli->insert_id;
		//$LoginRS = mysql_query($sql_Trace, $bd) or die(mysql_error());
		//$Usuario_Logs_Codigo = mysql_insert_id();
		
		//ok
		$sql = "SELECT * FROM Usuario_Grupo
				WHERE NombrePrivilegios = '$MM_UserGroup'";
		$RS = $mysqli->query($sql);
		if($row = $RS->fetch_assoc()){
			$Acceso_US = $row['Acceso'];
		}
		

		
		$_SESSION['MM_Username'] = $MM_Username;
		$_SESSION['MM_UserGroup'] = $MM_UserGroup;
		$_SESSION['MM_Iniciales'] = $MM_Iniciales;
		$_SESSION['UltimaAccion'] = time();
		$_SESSION['Privilegios'] = $MM_UserGroup;
		$_SESSION['Codigo_US'] = $Codigo_US;

		
		setcookie("MM_Username", $MM_Username, time()+3600 ,"/");
		setcookie("MM_UserGroup", $MM_UserGroup, time()+3600 ,"/");
		setcookie("MM_Iniciales", $MM_Iniciales, time()+3600 ,"/");
		setcookie("Usuario_Logs_Codigo", $Usuario_Logs_Codigo, time()+3600 ,"/");
		setcookie("Privilegios", $MM_UserGroup, time()+3600 ,"/");
		setcookie("Acceso_US", $Acceso_US, time()+3600 ,"/");
		setcookie("Codigo_US", $Codigo_US, time()+3600 ,"/");
		
		
//echo "LOGIN";	

		if($CookieLocal == "")
			$CookieLocal = $MM_Username;
		setcookie("CookieLocal", $CookieLocal, time()+3600*24*60 ,"/");
		$mysqli->query("UPDATE Usuario SET CookieLocal = '$CookieLocal' WHERE Usuario = '$MM_Username'");


		header("Location: " . $MM_redirectLoginSuccess ); }
  else {
	    header("Location: ". $MM_redirectLoginFailed ); }
}
else{
	if($_GET['LogOut'] == 1){
		$MM_Username  = $MM_UserGroup = $MM_Iniciales = $Privilegios = $Acceso_US = "";
		setcookie("MM_Username", $MM_Username, time()-1 ,"/");
		setcookie("MM_UserGroup", $MM_UserGroup, time()-1 ,"/");
		setcookie("MM_Iniciales", $MM_Iniciales, time()-1 ,"/");
		setcookie("Privilegios", $Privilegios, time()-1 ,"/");
		setcookie("Acceso_US", $Acceso_US, time()-1 ,"/");
		setcookie("Codigo_US", $Codigo_US, time()-1 ,"/");
		session_unset();   
		session_destroy();   
		session_write_close();
		
		header("Location: http://www.colegiosanfrancisco.com/");
		}
	else{
		setcookie("MM_Username", $MM_Username, time()+3600 ,"/");
		setcookie("MM_UserGroup", $MM_UserGroup, time()+3600 ,"/");
		setcookie("MM_Iniciales", $MM_Iniciales, time()+3600 ,"/");
		setcookie("Privilegios", $Privilegios, time()+3600 ,"/");
		setcookie("Acceso_US", $Acceso_US, time()+3600 ,"/");
		setcookie("Codigo_US", $Codigo_US, time()+3600 ,"/");
		setcookie("CookieLocal", $CookieLocal, time()+3600*24*60 ,"/");
	
	}
}



// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}



$MM_restrictGoTo = "http://www.colegiosanfrancisco.com/index.php";
if (!$MM_authorizedUsers=='' and !((isset($_COOKIE['MM_Username'])) && 
     (isAuthorized("",$MM_authorizedUsers, $_COOKIE['MM_Username'], $_COOKIE['MM_UserGroup'])))) {   
	//echo '9 '.session_id().' '.$_COOKIE['MM_Username'].$_COOKIE['MM_UserGroup'].$MM_restrictGoTo.'<br>';
	$MM_qsChar = "?";
	$MM_referrer = $_SERVER['PHP_SELF'];
	if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
	$MM_referrer .= "?" . $QUERY_STRING;
	$MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	@header("Location: ". $MM_restrictGoTo);   
	exit;
}


if (isset($_SESSION["UltimaAccion"]))
	$TiempoInactivo = time() - $_SESSION['UltimaAccion'];

//if (isset($_SESSION["UltimaAccion"]))
//	if($TiempoInactivo > 900 and $_SESSION['UltimaAccion'] > 0 )
//		header("Location: http://www.colegiosanfrancisco.com/LogOut.php");
	
if($MM_Username > '')
	  $_SESSION['UltimaAccion'] = time();

$No_trace = 0;
$No_trace = strpos($_SERVER['QUERY_STRING'] , "Procesa.php")+
			strpos($_SERVER['QUERY_STRING'] , "iFr");
//and $MM_UserGroup <> "2"isset($_SESSION["Ultima_Ruta"]) and isset($row_Login)


if (true or $MM_Username > "" and $No_trace > 0) 
if(true or $row_Login['Privilegios'] != '2' and $_SESSION['Ultima_Ruta'] != $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']){
		$_SESSION['Ultima_Ruta'] = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		
		/*$sql_Trace = "INSERT INTO Usuario_Logs 
					(CodigoUsuario, Usuario, Computador, IP, Ruta) VALUES 
					('".$Codigo_US."' ,'".$MM_Username."' ,
					 '". $_SERVER['HTTP_USER_AGENT'] ."' ,
					 '". $_SERVER['REMOTE_ADDR']."' ,
					  '". $_SERVER['PHP_SELF'] .'?'.$_SERVER['QUERY_STRING'] ."' )";*/
		//echo "tc";
		//$LoginRS = mysql_query($sql_Trace, $bd) or die(mysql_error());
		$sql_Trace = "INSERT INTO Usuario_Logs 
					(CodigoUsuario, Usuario, Computador, IP, Ruta, QueryStr) 
					VALUES 
					('" . $Codigo_US . "' ,
					 '" . $MM_Username . "' ,
					 '" . $_SERVER['HTTP_USER_AGENT'] . "' ,
					 '" . $_SERVER['REMOTE_ADDR'] . "' ,
					 '" . $_SERVER['PHP_SELF'] . "' ,
					 '" . $_SERVER['QUERY_STRING'] . "' )";
		//echo $sql_Trace;	
		//if($MM_Username <> "piero")
			if(!$SW_omite_trace)
				$mysqli->query($sql_Trace);

}

//print_r($_COOKIE);


?>