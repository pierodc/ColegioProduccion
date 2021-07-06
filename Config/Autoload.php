<?
//require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");

//date_default_timezone_set('UTC');
date_default_timezone_set('America/Caracas');

session_start();
$_Session_id = session_id();
$_IP = $_SERVER['REMOTE_ADDR'];


$MM_Username = ""; 


require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 

require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Connection.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Usuario.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Alumno.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Empleado.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Empleado_Pago.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/AlumnoXCurso.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Representante.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Curso.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Var.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Recibo.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/ContableMov.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Compra.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Rif.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Inventario.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/ShopCart.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Banco.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Caja.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Observaciones.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Consulta.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Models/Seniat.php");



require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Genericas.php');


require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/GetVar.php'); // GET Vars > id_Alumno id_Curso > set cookie

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 




?>