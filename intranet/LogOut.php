<?php
setcookie("MM_Username", '', 0 ,'/intranet/');
setcookie("MM_UserGroup", '', 0 ,'/intranet/');
setcookie("MM_Iniciales", '', 0 ,'/intranet/');
setcookie("Privilegios", '', 0 ,'/intranet/');
setcookie("Acceso_US", '', 0 ,'/intranet/'); // 3600 = 1 hora

setcookie("Usuario_Logs_Codigo", $Usuario_Logs_Codigo, 0 ,'/intranet/');

require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 

// *** Logout the current user.
if (!isset($_SESSION)) {
  session_start();
}

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$sql = "UPDATE Usuario_Logs 
		SET Fecha_LogOut = NOW()
		WHERE  Codigo = '".$_COOKIE['Usuario_Logs_Codigo']."'
		";
$mysqli->query($sql);

unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['MM_Iniciales']);
unset($_SESSION['Usuario_Logs_Codigo']);
unset($_SESSION['Privilegios']);
unset($_SESSION['Privilegios']);
unset($_SESSION['Acceso_US']);
unset($_SESSION['PrevUrl']);
unset($_SESSION['UltimaAccion']);

$logoutGoTo = "index.php";
header("Location: $logoutGoTo");
?>