<?php 
//echo "SISTEMA EN MANTENIMIENTO";
//exit;

if(isset($_GET["AnoEscolar"]))
	$AnoEscolar = $_GET["AnoEscolar"];

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/Classes.php'); 

//$hostname_bd = "localhost";
//$database_bd = "colegio_db";
//$username_bd = "colegio_colegio";
//$password_bd = "kepler";
//$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());

//print_r($_COOKIE);

date_default_timezone_set('America/Caracas');
$php_self = $_SERVER['PHP_SELF'];
$raiz = $_SERVER['DOCUMENT_ROOT'];
$ToRoot = $_SERVER['DOCUMENT_ROOT'];

if (isset($_COOKIE['PantallaCompleta'])){
  $SW_PantallaCompleta = $_COOKIE['PantallaCompleta'];// true; // PAntalla completa
}
else{
  $SW_PantallaCompleta = 1;
}



function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}



// Definimos la función cURL    leerHTML
function leerHTML($url) {
	$ch = curl_init($url); // Inicia sesión cURL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
	$info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
	curl_close($ch); // Cierra sesión cURL
	return $info; // Devuelve la información de la función
}

function cambio_BCV(){
	
	$sitioweb = leerHTML("http://www.bcv.org.ve/");  // Ejecuta la función curl escrapeando el sitio web https://devcode.la and regresa el valor a la variable $sitioweb

	$inicio = strpos($sitioweb , "<strong>" , strpos($sitioweb , "Bs/USD")) + 8;	
	$fin = strpos($sitioweb , "</strong>" , strpos($sitioweb , "Bs/USD"));	
	$largo = $fin - $inicio;

	$txt = substr($sitioweb,$inicio,$largo);	
	return $txt;
	
	
}






function Reconv ($BsF){
	return $BsF;	
	/*if ($BsF > 100000 or $BsF == 100)
		return round($BsF/100000 , 2);
	else
		return $BsF;*/	
	}

function IVA_base($Monto,$porc){
	return round( ( ( $Monto / (1.12))) , 2);
	}
function IVA_inc($Monto,$porc){
	$porc = round($porc/100,2);
	return round( ( ( $Monto / (1.12)) * (1 + $porc)) , 2);
	}
function IVA($Monto , $porc){
	$porc = $porc / 100 ;
	//echo "zzz $Monto , $porc zzz ";
	return round( ( ( $Monto / 1.12) *  $porc) , 2);
	}

function enCode ($txt){
	return htmlentities( $txt );
	}

function deCode ($txt){
	return html_entity_decode( $txt , ENT_COMPAT , 'ISO-8859-1'); // 
	}

function deCodeUTF ($txt){
	return html_entity_decode( $txt , ENT_COMPAT , 'UTF-8'); // ISO-8859-1
	}
	
	
function Banco ($Cod){
	if( $Cod == 1)  
		return " Mercantil ";  
	elseif( $Cod == 2) 
		return " Provincial ";
	elseif( $Cod == 99) 
		return " Otro ";
	else 
		return "<b> BANCO  ??</b>"; 
	}

$ProxAno = "";
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")>0)
	$_iPhone = false;
else
	$_iPhone = false;

if (isset($_GET['AnoEscolar'])){
	$AnoEscolar = $_GET['AnoEscolar'];
	}

if ($SWreinscripcion){
	$ProxAno = "ProxAno";
}

$MesNum = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
$MesNom = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');


$ReferenciaMesAno_array = array(
0=>'08-'.$Ano1,
1=>'09-'.$Ano1,
2=>'10-'.$Ano1,
3=>'11-'.$Ano1,
4=>'12-'.$Ano1,
5=>'01-'.$Ano2,
6=>'02-'.$Ano2,
7=>'03-'.$Ano2,
8=>'04-'.$Ano2,
9=>'05-'.$Ano2,
10=>'06-'.$Ano2,
11=>'07-'.$Ano2,
12=>'08-'.$Ano2,
13=>'09-'.$Ano2,
14=>'10-'.$Ano2);

if (isset($_GET['Mes']))
	$Mes = $_GET['Mes'];
else
	$Mes = date('m');
	
if (isset($_GET['Ano']))
	$Ano = $_GET['Ano'];
else
	$Ano = date('Y');

$Fecha_Inicio_Mes = $Ano .'-'.$Mes.'-01';
$Fecha_Fin_Mes = $Ano .'-'.$Mes.'-31';

if (isset($_GET['CodigoPropietario'])){
	$sql = "SELECT * FROM Alumno WHERE CodigoClave ='".$_GET['CodigoPropietario']."'";
	//echo $sql;
	$RS = $mysqli->query($sql);
	if ($row = $RS->fetch_assoc()){
		$CodigoAlumno = $row['CodigoAlumno'];
		}

	
	}
	

$Sec_01_13 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13');


function Nexo ($Nexo){
	$Nexo = strtolower($Nexo);
	
	switch ($Nexo) {
	
		case "":
			$Nexo = "Alumno";
			break;
		case "ci":
			$Nexo = "Cédula Alumno";
			break;
		case "p":
			$Nexo = "Papá";
			break;
		case "pci":
			$Nexo = "Cédula Papá";
			break;
		case "m":
			$Nexo = "Mamá";
			break;
		case "mci":
			$Nexo = "Cédula Mamá";
			break;
		case "a1":
			$Nexo = "Autorizado 1";
			break;
		case "a2":
			$Nexo = "Autorizado 2";
			break;
		case "a3":
			$Nexo = "Autorizado 3";
			break;
		
	}		 
	return $Nexo ;
}


function Signo($num){
	if ($num > 0)  return  1;
	if ($num == 0) return  0;
	if ($num < 0)  return -1;
}

function FormaDePago($Forma){
	if ($Forma == 2){return "Transferencia";}
	if ($Forma == 3){return "Cheque";}
	if ($Forma == 4){return "Efectivo";}
	if ($Forma == 5){return "Ajuste";}
	if ($Forma == 6){return "T. Debito";}
	if ($Forma == 7){return "T. Credito";}
	if ($Forma == 8){return "Zelle";}
	if ($Forma == 9){return "Cash Dollares";}
	if ($Forma == 10){return "Cash Euro";}
}

function Acceso($Acceso_US,$Requerido_Pag){
	$resultado = false;
	$Acceso_US = explode(';',$Acceso_US);
	foreach($Acceso_US as $Acceso){
		if ($Acceso > ""){
			if (substr_count($Requerido_Pag , $Acceso)){
				$resultado = true;}
			if ($Acceso == 'all'){
				$resultado = true;}
		}
	}
	return $resultado;
}

function NoAcentos($txt){
	$txt = str_replace( "á", "a",$txt);
	$txt = str_replace( "é", "e",$txt);
	$txt = str_replace( "í", "i",$txt);
	$txt = str_replace( "ó", "o",$txt);
	$txt = str_replace( "ú", "u",$txt);
	$txt = str_replace( "ñ", "n",$txt);
	$txt = str_replace( "Ñ", "n",$txt);
	return $txt;
}

function TelLimpia($Telefono){
	
	$Telefono = str_replace ('.','',$Telefono);
	$Telefono = str_replace ('(','',$Telefono);
	$Telefono = str_replace (')','',$Telefono);
	$Telefono = str_replace (',','',$Telefono);
	$Telefono = str_replace ('-','',$Telefono);
	$Telefono = str_replace (' ','',$Telefono);
	$Telefono = str_replace ('/04',' . 04',$Telefono);
	$Telefono = str_replace ('/','',$Telefono);
	
	return $Telefono;
	
	}

function Whatsapp($Telefono , $Mensaje = ""){
	$Telefono = TelLimpia($Telefono);
	$Telefono = substr($Telefono,1,100);
	
	$Mensaje = str_replace(" ","%20",$Mensaje);
	
	echo "<a href=\"https://wa.me/58$Telefono?text=$Mensaje\" target=\"_blank\"> <img src=\"/i/whatsapp.png\"> </a>";
	
	//return $Whatsapp;
}
function TelFormat($Telefono){
	$Telefono = TelLimpia($Telefono);
	$Telefono = "(".substr($Telefono,0,4).") ".substr($Telefono,4,3)."-".substr($Telefono,7,2)."-".substr($Telefono,9,2);
	return $Telefono;
	}

function ProveedorNombre($Codigo){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$sql = "SELECT * FROM Proveedor WHERE Codigo = '$Codigo'";
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	if ($Codigo>'')
		echo $row['Nombre'];
	
	}
 


function ActulizaEdoCuentaDolar($CodigoAlumno ){  //, $CambioDolar
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	
	$Variable = new Variable();
	$Var_Name = 'Cambio_Dolar';
	$CambioDolar = $Variable->view($Var_Name);

	
	$sql_busca_Dolares = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoAlumno
										AND SWCancelado = '0' 
										AND MontoDebe_Dolares > 0";
	//echo $sql_busca_Dolares;
	$RS_busca_Dolares = $mysqli->query($sql_busca_Dolares);
	$totalRows_RS_busca_Dolares = $RS_busca_Dolares->num_rows;

	if( $totalRows_RS_busca_Dolares > 0 )	{								
	while($row_busca_Dolares = $RS_busca_Dolares->fetch_assoc()){
		$MontoDebe_Dolares = round(($row_busca_Dolares['MontoDebe_Dolares'] - $row_busca_Dolares['MontoAbono_Dolares']) * $CambioDolar ,2);
		$sql_Upt_Dolares = "UPDATE ContableMov 
							SET MontoDebe = '$MontoDebe_Dolares' 
							WHERE Codigo = '".$row_busca_Dolares['Codigo']."'";
		$mysqli->query($sql_Upt_Dolares);	
		$saldo += $MontoDebe_Dolares;
		}
	$sql = "UPDATE Alumno 
		SET Deuda_Actual='".$saldo."' 
		WHERE CodigoAlumno = ".$CodigoAlumno;
	//echo "saldosaldo ".$sql ."<br>";
	$mysqli->query($sql);			  
	return $saldo;
	$saldo = 0;
		
	}
	
}
	
	
function ListaFondo($sw , $Verde){
	// echo $sw=ListaFondo($sw,$Verde); 
	if ($Verde) 
		echo " class=\"ListadoPar12Verde\"";
	elseif ($sw){
		echo " class=\"ListadoPar\"";}
	else	{ 
		echo " class=\"ListadoInPar\"";}
		
	if ($sw){
		$sw = false;}
	else	{ 
		$sw = true;}
	return $sw;
}

function FondoListado($sw , $Verde){
	// echo $sw=ListaFondo($sw,$Verde); 
	if ($Verde) 
		echo " ListadoVerde";
	elseif ($sw){
		echo " ListadoPar";}
	else	{ 
		echo " ListadoInPar";}
	if ($sw){
		$sw = false;}
	else	{ 
		$sw = true;}
	return $sw;	
	
}


function eko($eko){
	echo $eko.'<br>';
}

function LetraPeq($pdf){
	$pdf->SetFont('courier','',8);
	$pdf->SetTextColor(0 , 0, 200);
	$Ln=$Ln1;}

function LetraGde($pdf){
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0);
	$Ln=$Ln2;}

function LetraGdeBlk($pdf){
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0);
	$Ln=$Ln2;}

function LetraTit($pdf){ 
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(0);}

function T_Tit ($text){
	$text = str_replace(' ,',',',$text);
return ucwords(strtolower( str_replace('  ',' ',$text) ));}

function F_bd_hum($fecha){
	return substr($fecha,8,2).'-'.substr($fecha,5,2).'-'.substr($fecha,0,4);
}

function F_hum_bd($fecha){
	if (strpos($fecha, ' '))
		$separador = ' ';
	if (strpos($fecha, '-'))
		$separador = '-';
	if (strpos($fecha, '.'))
		$separador = '.';
	if (strpos($fecha, '/'))
		$separador = '/';
	$fecha1 = explode($separador , $fecha);
	$dd   = substr('0'.$fecha1[0] , -2);
	$mm   = substr('0'.$fecha1[1] , -2);
	$aaaa = substr('20'.$fecha1[2] , -4);
	return $aaaa.'-'.$mm.'-'.$dd;
}


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  //$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  //$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// SQL generico Alumno INICIO
$add_SQL = '';
if (isset($_GET['CodigoCurso'])) { 
	$colname .= $_GET['CodigoCurso'];
	$add_SQL = sprintf(' AND AlumnoXCurso.CodigoCurso = %s ', GetSQLValueString($colname, "int"));
										  
	if ($_GET['CodigoCurso']=='Pre'		) $add_SQL .= ' AND Curso.NivelCurso >=11 AND Curso.NivelCurso <=14 ' ;
	if ($_GET['CodigoCurso']=='Pri'		) $add_SQL .= ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=26 ' ;
	if ($_GET['CodigoCurso']=='Pri123'	) $add_SQL .= ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=23 ' ;
	if ($_GET['CodigoCurso']=='Pri456'	) $add_SQL .= ' AND Curso.NivelCurso >=24 AND Curso.NivelCurso <=26 ' ;
	if ($_GET['CodigoCurso']=='Bach'		) $add_SQL .= ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=45 ' ;
	if ($_GET['CodigoCurso']=='Bach123'	) $add_SQL .= ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=33 ' ;
	if ($_GET['CodigoCurso']=='Bach45' or $CodigoCurso=='Bach45' ) $add_SQL .= ' AND Curso.NivelCurso >=44 AND Curso.NivelCurso <=45 ' ;
}

if (isset($_POST['CodigoCurso'])		) $add_SQL .= " AND AlumnoXCurso.CodigoCurso ='".$_POST['CodigoCurso']."' " ;


if (isset($_GET['CodigoAlumno'])) { $colname = $_GET['CodigoAlumno'];
									  $add_SQL .= sprintf(' AND AlumnoXCurso.CodigoAlumno = %s ', GetSQLValueString($colname, "int"));}

if (isset($_GET['Lapso']))
if ( strrpos($_GET['Lapso'] , "mp") > 0) 
									  $add_SQL .= " AND AlumnoXCurso.Tipo_Inscripcion  = 'Mp' " ;
	else
									  $add_SQL .= " AND AlumnoXCurso.Tipo_Inscripcion  <> 'Mp' " ;


if (isset($_GET['CodigoClave']))  { 
		$colname = $_GET['CodigoClave'];
		$add_SQL .= sprintf(' AND Alumno.CodigoClave = %s ', GetSQLValueString($colname, "text"));}

if (isset($_GET['CodigoPropietario']))  { 
		$colname = $_GET['CodigoPropietario'];
		$add_SQL .= sprintf(' AND Alumno.CodigoClave = %s ', GetSQLValueString($colname, "text"));}

if (isset($_GET['Orden'])){
if ($_GET['Orden']=='Cedula' or $_POST['Orden']=='Cedula' or $Orden == 'Cedula') 
		$add_SQL .= ' ORDER BY Alumno.Cedula_int ';
	elseif (isset($_GET['Desde']))
		$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	elseif (isset($_GET['ApellidosNombres']))
		$add_SQL .= ' ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	else
		$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
}
else {
	$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	}


if (isset($_GET['LIMIT'])) {
		$add_SQL .= ' LIMIT ' . $_GET['LIMIT']. ' , 1 '; }
									  
if (isset($_GET['Desde']) and isset($_GET['Cantidad'])) {
		$add_SQL .= ' LIMIT ' . $_GET['Desde']. ' , ' . $_GET['Cantidad']. ' '; }
	

$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Alumno , Curso
					WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
					AND AlumnoXCurso.Ano = '$AnoEscolar' 
					AND AlumnoXCurso.Status = 'Inscrito'
					$add_SQL ";
//echo $query_RS_Alumno;					
// SQL generico Alumno FIN 954 817 42 44

function Mes_Ano ($Mes_Ano){
	
	$Mes = substr($Mes_Ano , 0, 2);
	switch ($Mes) {
		case "01":
			$Mes = "Ene" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "02":
			$Mes = "Feb" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "03":
			$Mes = "Mar" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "04":
			$Mes = "Abr" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "05":
			$Mes = "May" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "06":
			$Mes = "Jun" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "07":
			$Mes = "Jul" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "08":
			$Mes = "Ago" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "09":
			$Mes = "Sep" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "10":
			$Mes = "Oct" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "11":
			$Mes = "Nov" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "12":
			$Mes = "Dic" . " 20". substr($Mes_Ano , 3, 2);
			break;
		case "In":
			$Mes = $Mes_Ano;
			break;
	}		 
	
	return $Mes ;

}

function DiaN ($Fecha){
	return substr($Fecha , 8, 2);
}

function MesN ($Fecha){
	return substr($Fecha , 5, 2);
}

function AnoN ($Fecha){
	return substr($Fecha , 0, 4);
}


function Mes ($Mes){
	
	switch ($Mes) {
		case "01":
			$Mes = "Enero";
			break;
		case "02":
			$Mes = "Febrero";
			break;
		case "03":
			$Mes = "Marzo";
			break;
		case "04":
			$Mes = "Abril";
			break;
		case "05":
			$Mes = "Mayo";
			break;
		case "06":
			$Mes = "Junio";
			break;
		case "07":
			$Mes = "Julio";
			break;
		case "08":
			$Mes = "Agosto";
			break;
		case "09":
			$Mes = "Septiembre";
			break;
		case "10":
			$Mes = "Octubre";
			break;
		case "11":
			$Mes = "Noviembre";
			break;
		case "12":
			$Mes = "Diciembre";
			break;
		case "13":
			$Mes = "Utilidades";
			break;
		case "In":
			$Mes = $Mes_Ano;
			break;
	}		 
	return $Mes ;
}



function MesProx($Mes) {
switch ($Mes) {
    case "01":
        return "02";
    case "02":
        return "03";
    case "03":
        return "04";
    case "04":
        return "05";
    case "05":
        return "06";
    case "06":
        return "07";
    case "07":
        return "08";
    case "08":
        return "09";
    case "09":
        return "10";
    case "10":
        return "11";
    case "11":
        return "12";
    case "12":
        return "01";
}}
function MesAnte($Mes) {
switch ($Mes) {
    case "01":
        return "12";
    case "02":
        return "01";
    case "03":
        return "02";
    case "04":
        return "03";
    case "05":
        return "04";
    case "06":
        return "05";
    case "07":
        return "06";
    case "08":
        return "07";
    case "09":
        return "08";
    case "10":
        return "09";
    case "11":
        return "10";
    case "12":
        return "11";
}}
function AnoProx($Mes, $Ano) {
switch ($Mes) {
    case "01":
    case "02":
    case "03":
    case "04":
    case "05":
    case "06":
    case "07":
    case "08":
    case "09":
    case "10":
    case "11":
        return $Ano;
    case "12":
        return $Ano+1;
}}
function AnoAnte($Mes, $Ano) {
switch ($Mes) {
    case "01":
        return $Ano-1;
    case "02":
    case "03":
    case "04":
    case "05":
    case "06":
    case "07":
    case "08":
    case "09":
    case "10":
    case "11":
    case "12":
        return $Ano;
}}


function AnoMesAnte($Mes, $Ano) {
	return AnoAnte($Mes, $Ano) . MesAnte($Mes);
}
function AnoMesProx($Mes, $Ano) {
	return AnoProx($Mes, $Ano) . MesProx($Mes);
}

function Ir_a_AnoMes($actMes, $actAno, $addVars) {

	if ($actMes=='')
		$actMes = date('m');
	if ($actAno=='')
		$actAno = date('Y');
	
	echo '<table><tr><td nowrap="nowrap">';
	
	echo '<a href="'.$_SERVER['PHP_SELF'].'?Ano='.AnoAnte($actMes, $actAno).'&Mes='.MesAnte($actMes, $actAno). $addVars.
	'"><img src="http://www.colegiosanfrancisco.com/i/control_rewind_blue.png" width="32" height="32" border=0 /></a>';
	
	echo '</td><td  nowrap="nowrap" ><b> Mes:'.$actMes.'  Año:'.$actAno.' </b></td><td nowrap="nowrap">';
	
	echo '<a href="'.$_SERVER['PHP_SELF'].'?Ano='.AnoProx($actMes, $actAno).'&Mes='.MesProx($actMes, $actAno). $addVars.
	'"><img src="http://www.colegiosanfrancisco.com/i/control_fastforward_blue.png" width="32" height="32" border=0 /></a>';
	
	echo '</td>
	</tr>
	</table>';	
} 

function Ir_a_Dia($actFecha, $addVars) {

	if ($actFecha=='')
		$actFecha = date('Y-m-d');
	
	$Ano = substr($actFecha,0,4)*1;
	$Mes = substr($actFecha,5,2)*1;
	$Dia = substr($actFecha,8,2)*1;
		
	$DiaAnte = mktime (1, 0, 0, $Mes, $Dia-1, $Ano);
	$DiaSig  = mktime (1, 0, 0, $Mes, $Dia+1, $Ano);
	$DiaAnte = date('Y-m-d',$DiaAnte);
	$DiaSig  = date('Y-m-d',$DiaSig);
	
	echo '<form id="form1" name="form1" method="post" action=""><table><tr><td nowrap="nowrap">';
	
	echo '<a href="'.$_SERVER['PHP_SELF'].'?Fecha='.$DiaAnte.
	'"><img src="http://www.colegiosanfrancisco.com/i/control_rewind_blue.png" width="32" height="32" border=0 /></a>';
	
	echo '</td><td  nowrap="nowrap" ><b>
	<input name="Fecha" type="date" id="textfield" value="'.$actFecha.'"  onchange="form.submit();"/>
	</b></td><td nowrap="nowrap">';
	
	echo '<a href="'.$_SERVER['PHP_SELF'].'?Fecha='.$DiaSig.
	'"><img src="http://www.colegiosanfrancisco.com/i/control_fastforward_blue.png" width="32" height="32" border=0 /></a>';
	
	echo '</td>
	</tr>
	</table></form>';	
} 

function Repre($CodigoAlumno,$Nexo){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";

	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


	$sql = "SELECT * FROM RepresentanteXAlumno, Representante
			WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
			AND RepresentanteXAlumno.CodigoAlumno = '$CodigoAlumno'
			AND RepresentanteXAlumno.Nexo = '$Nexo'";	
	$RS = $mysqli->query($sql);
	if ($row = $RS->fetch_assoc())
		return $row;
	
	}



function DiasLaborables ($FechaEnMesObj , $DiasHabilesSemana){
	$FechaObjetivo = mktime(0, 0, 0, MesN($FechaEnMesObj) , 1, AnoN($FechaEnMesObj)); 
	$FechaInicio = mktime(0, 0, 0, date("m",$FechaObjetivo), 1, date("Y",$FechaObjetivo));
	$FechaFin	 = mktime(0, 0, 0, date("m",$FechaObjetivo)+1, 0, date("Y",$FechaObjetivo));
	$DiasLaborables=0;
	
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$query_RS_ = "SELECT * FROM Calendario WHERE Fecha >= '".date('Y-m-d',$FechaInicio)."' AND  Fecha <= '".date('Y-m-d',$FechaFin)."'";
	$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
	$row_RS_ = mysql_fetch_assoc($RS_);
	
	$Fecha_aux = $FechaInicio;	
	
		if (mysql_num_rows($RS_)>0)
		do {
			$Fecha_aux = mktime(0, 0, 0, MesN($row_RS_['Fecha']), DiaN($row_RS_['Fecha']), AnoN($row_RS_['Fecha']));
			if ( strpos( ' '.$DiasHabilesSemana , date('w',$Fecha_aux) ) ){
			$DiasLaborables--; }
		}while($row_RS_ = mysql_fetch_assoc($RS_));	
			
		$Fecha_aux = $FechaInicio;	
		do{
			if ( strpos( ' '.$DiasHabilesSemana , date('w',$Fecha_aux) ) ){
				$DiasLaborables++; }
			$Fecha_aux = mktime(0, 0, 0, date("m",$Fecha_aux), date("d",$Fecha_aux)+1, date("Y",$Fecha_aux));
		}while ($Fecha_aux <= $FechaFin);
	
	return $DiasLaborables;
}



function Promedia ($n1,$n2,$n3) {
	$Cuenta = ($n1>0?1:0)+($n2>0?1:0)+($n3>0?1:0);
	$Cuenta = ($Cuenta==0?1:$Cuenta);
	$Suma = $n1+$n2+$n3;
	$Promedio = round($Suma/$Cuenta,0);
	return substr("00".$Promedio , -2);
}	  


function Fnum($num){
	$num = floatval($num);
	if ($num<>0)
		return number_format($num, 2, ',', '.');
}

function Redondea($num){
	$num = floatval($num);
	if ($num<>0)
		return number_format($num, 0, ',', '.');
}

function Format($num){
	$num = floatval($num);
	return number_format($num, 2, ',', '.');
}

function Fnum_dec($num){
	$aux=$num-intval($num);
	if ($num<>0)
		if ( $aux == 0 )
			return number_format($num, 0, ',', '.');
		else
			return number_format($num, 2, ',', '.');
}


function Fnum_Letras($num){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
		//mysql_select_db($database_bd, $bd);
	
	$entero   = intval($num);
	
	$millones = intval($num/1000000);
	
	
	
	
	$miles    = intval(($entero - $millones*1000000)/1000);
	
	
	$centenas = intval(($entero - $miles*1000 - $millones*1000000)/100);
	$unidades = $entero - $miles*1000 - $centenas*100 - $millones*1000000 ;
	
	$centimos = round(100 * ($num - $entero) ,0);   //  round(($num - $miles*1000 - $centenas*100 - $unidades)*100 , 0);
/*
	echo $num . " = ent :" . $entero . 
				" /millones:" . $millones . 
				" /miles:" . $miles . 
				" /centenas:" . $centenas . 
				" /unidades:" . $unidades . 
				" /centimos:" . $centimos ."<br>" ;


*/

	if ($millones > 0){
	
		$query_RS_ = "SELECT * FROM NumerosEnLetras WHERE Numero = $millones"; 
		$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
		$row_RS_ = mysql_fetch_assoc($RS_);
		$letras .= $row_RS_['enLetras']. " millones ";
	}
	
	
	if ($miles > 0){
		
		if ($miles > 100){
			//echo substr(Fnum_Letras($miles) , 0 , strlen(Fnum_Letras($miles))-10 );
			$letras .= substr(Fnum_Letras($miles) , 0 , strlen(Fnum_Letras($miles))-10 ). " mil ";
			}
		else{
		
		$query_RS_ = "SELECT * FROM NumerosEnLetras WHERE Numero = $miles"; 
		$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
		$row_RS_ = mysql_fetch_assoc($RS_);
		$letras .= $row_RS_['enLetras']. " mil ";}
	}
	
	
	if ($centenas > 0){
		$query_RS_ = "SELECT * FROM NumerosEnLetras WHERE Numero = ". $centenas*100; 
		$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
		$row_RS_ = mysql_fetch_assoc($RS_);
		$letras .= $row_RS_['enLetras'];
	}
	
	
	if ($centenas==1 and $unidades>0){$letras = $letras . "to ";}else{$letras = $letras . " ";}
	
	if ($unidades > 0){
		$query_RS_ = "SELECT * FROM NumerosEnLetras WHERE Numero = $unidades"; 
		$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
		$row_RS_ = mysql_fetch_assoc($RS_);
		$letras .= $row_RS_['enLetras']. " ";
	}
	
	$letras .= "Bolívares";
	
	
	if ($centimos > 0){
		$query_RS_ = "SELECT * FROM NumerosEnLetras WHERE Numero = '$centimos'"; 
		$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
		$row_RS_ = mysql_fetch_assoc($RS_);
		if ($row_RS_['enLetras']>'')
			$centimos = $row_RS_['enLetras'];
		else
			$centimos = 'cero';
		$letras .= " con ".$centimos . " céntimos ";
	} 
	//echo "<br>".$letras;
	return $letras;
}











function DDMMAAAA ($fecha){
	if ($fecha != '0000-00-00' )
	return substr($fecha, 8, 2).'-'.substr($fecha, 5, 2).'-'.substr($fecha,0,4) ; 

}

function DDMMAA ($fecha){
	if ($fecha != '0000-00-00' )
	return substr($fecha, 8, 2).'/'.substr($fecha, 5, 2).'/'.substr($fecha,2,2) ; 

}



function DMA ($fecha){
	if ($fecha != '0000-00-00' )
	return substr($fecha, 8, 2).''.substr($fecha, 5, 2).''.substr($fecha,0,4) ; 
}
function DMA_lph ($fecha){
	if ($fecha != '0000-00-00' ){
		$Dia = substr($fecha, 8, 2);
		if ($Dia<10)
			$Dia = 10;
		return $Dia.''.substr($fecha, 5, 2).''.substr($fecha,0,4) ; }
}


function DDMM ($fecha){
	if ($fecha != '0000-00-00' )
	return substr($fecha, 8, 2).'-'.substr($fecha, 5, 2); 

}

function DDMMMMAAAA ($fecha){
	if ($fecha != '0000-00-00' )
		return substr($fecha, 8, 2).' de '.mes(substr($fecha, 5, 2)).' de '.substr($fecha,0,4) ; 

}

function DMAtoAMD ($fecha){ 
	return substr($fecha,6,4).'-'.substr($fecha, 3, 2).'-'.substr($fecha, 0, 2) ; 
}

function DMtoAMD ($fecha){ 
	return date('Y').'-'.substr($fecha, 3, 2).'-'.substr($fecha, 0, 2) ; 
}


function DiaSemana ($_ddd){

	switch ($_ddd) {
		case 0:
			$_ddd = "Dom";
			break;
		case 1:
			$_ddd = "Lun";
			break;
		case 2:
			$_ddd = "Mar";
			break;
		case 3:
			$_ddd = "Mie";
			break;
		case 4:
			$_ddd = "Jue";
			break;
		case 5:
			$_ddd = "Vie";
			break;
		case 6:
			$_ddd = "Sab";
			break;
		case 7:
			$_ddd = "Dom";
			break;
	}
	
	$TimeStam = $_ddd;
	return $TimeStam;
}



function dddDDMMAAAA ($fecha){

	$_ano = substr($fecha,0,4);
	$_mes = substr($fecha,5,2);
	$_dia = substr($fecha,8,2);
	$_ddd =  date("w", mktime(0, 0, 0, $_mes, $_dia, $_ano));
	
	$_ddd = DiaSemana($_ddd); 
	/*
	{
		case 0:
			$_ddd = "Dom";
			break;
		case 1:
			$_ddd = "Lun";
			break;
		case 2:
			$_ddd = "Mar";
			break;
		case 3:
			$_ddd = "Mie";
			break;
		case 4:
			$_ddd = "Jue";
			break;
		case 5:
			$_ddd = "Vie";
			break;
		case 6:
			$_ddd = "Sab";
			break;
	}*/
	
	$TimeStam = $_ddd. ' '. date("d-m-Y", mktime(0, 0, 0, $_mes, $_dia, $_ano));
	return $TimeStam;
}

function DDMMMM ($fecha){

	$_ano = substr($fecha,0,4);
	$_mes = substr($fecha,5,2);
	$_dia = substr($fecha,8,2);
	$_ddd =  date("w", mktime(0, 0, 0, $_mes, $_dia, $_ano));
	
	$_ddd = DiaSemana($_ddd); 
	/*
	
	switch ($_ddd) {
		case 0:
			$_ddd = "Dom";
			break;
		case 1:
			$_ddd = "Lun";
			break;
		case 2:
			$_ddd = "Mar";
			break;
		case 3:
			$_ddd = "Mie";
			break;
		case 4:
			$_ddd = "Jue";
			break;
		case 5:
			$_ddd = "Vie";
			break;
		case 6:
			$_ddd = "Sab";
			break;
	}*/
	
	$TimeStam = date("d-M", mktime(0, 0, 0, $_mes, $_dia, $_ano));
	return $TimeStam;
}




function MMDDAAAA ($aaaa_mm_dd){
	return substr($aaaa_mm_dd, 5, 2).'-'.substr($aaaa_mm_dd, 8, 2).'-'.substr($aaaa_mm_dd,0,4) ; 
}

function Edad($aaaa_mm_dd){

	$anos  = date('Y') - (int)substr($aaaa_mm_dd, 0, 4);
	$meses = date('m') - (int)substr($aaaa_mm_dd, 5, 2);
	$dias  = date('d') - (int)substr($aaaa_mm_dd, 8, 2);

	if ( $meses < 0 ){
		$Edad = $anos-1 . "";
		} elseif ( $meses > 0 ){
			$Edad = $anos . "";
			} elseif ( $meses ==0 ){
				$Edad = $anos . "";
				}
	return $Edad ;
}

function Edad_Dif ($aaaa_mm_dd, $aaaa_mm_dd_obj){
	
	$ano_obj  = substr($aaaa_mm_dd_obj, 0, 4);
	$mes_obj  = substr($aaaa_mm_dd_obj, 5, 2);
	$dia_obj  = substr($aaaa_mm_dd_obj, 8, 2);

	$anos  = $ano_obj - (int)substr($aaaa_mm_dd, 0, 4);
	$meses = $mes_obj - (int)substr($aaaa_mm_dd, 5, 2);
	$dias  = $dia_obj - (int)substr($aaaa_mm_dd, 8, 2);

	if ( $meses < 0 ){
		$meses = 12 + $meses;
		$Edad = $anos-1  ."a ". $meses ."m";
		} elseif ( $meses > 0 ){
			$Edad = $anos ."a ". $meses ."m";
			} elseif ( $meses ==0 ){
				$Edad = $anos . "a";
				}
	return $Edad;
}

function Fecha_Dif ($fecha, $fecha_obj){
	$ano_obj  = substr($fecha_obj, 0, 4);
	$mes_obj  = substr($fecha_obj, 5, 2);
	$dia_obj  = substr($fecha_obj, 8, 2);

	$anos_dif  = $ano_obj - substr($fecha, 0, 4);
	$meses_dif = $mes_obj - substr($fecha, 5, 2);
	$dias_dif  = $dia_obj - substr($fecha, 8, 2);

	if ( $meses_dif < 0 ){
		$Edad = $anos_dif-1 . "";
		} elseif ( $meses_dif > 0 ){
			$Edad = $anos_dif . "";
			} elseif ( $meses_dif ==0 ){
				$Edad = $anos_dif . "";
				}
		$Edad .= 'a '.$meses_dif.'m '.$dias_dif.'d ';		
	return $Edad ;
}


function Dif_Tiempo ($fecha  ){
	
	$fecha_obj = date('Y-m-d H:i');
	
	$ano_obj  = substr($fecha_obj, 0, 4);
	$mes_obj  = substr($fecha_obj, 5, 2);
	$dia_obj  = substr($fecha_obj, 8, 2);
	$HH_obj   = substr($fecha_obj, 11, 2);
	$MM_obj   = substr($fecha_obj, 14, 2);

	$Time_obj = mktime($HH_obj, $MM_obj, 0, $mes_obj, $dia_obj, $ano_obj);
	//echo $Time_obj . "<br>";
	
	$ano_  = substr($fecha, 0, 4);
	$mes_  = substr($fecha, 5, 2);
	$dia_  = substr($fecha, 8, 2);
	$HH_   = substr($fecha, 11, 2);
	$MM_   = substr($fecha, 14, 2);

	$Time = mktime($HH_, $MM_, 0, $mes_, $dia_, $ano_);
	//echo $Time . "<br>";
	
	$Dif = ($Time_obj - $Time) / 60;
	
	//echo $Dif . "<br>";
			
	return $Dif; // en minutos
}



function Dias_Dif ($Fecha_ini , $Fecha_fin){
	$ano_ini  = substr($Fecha_ini, 0, 4);
	$mes_ini  = substr($Fecha_ini, 5, 2);
	$dia_ini  = substr($Fecha_ini, 8, 2);
	$Fecha_ini = mktime(0,0,0,$mes_ini,$dia_ini,$ano_ini);

	$ano_fin  = substr($Fecha_fin, 0, 4);
	$mes_fin  = substr($Fecha_fin, 5, 2);
	$dia_fin  = substr($Fecha_fin, 8, 2);
	$Fecha_fin = mktime(0,0,0,$mes_fin,$dia_fin,$ano_fin);
	
	return ($Fecha_fin - $Fecha_ini)/(3600*24) ;
	
	}

function Fecha_Meses_Laborados($fecha, $fecha_obj){
	
	$ano_obj    = substr($fecha_obj, 0, 4); 
	$mes_obj    = substr($fecha_obj, 5, 2); 
	$dia_obj    = substr($fecha_obj, 8, 2); 
	
	$ano_fecha  = substr($fecha, 0, 4);
	$mes_fecha  = substr($fecha, 5, 2); 
	$dia_fecha  = substr($fecha, 8, 2);
	
	$dif_Dias   = $dia_obj - $dia_fecha;
	$dif_Meses  = $mes_obj - $mes_fecha;
	$dif_Anos   = $ano_obj - $ano_fecha;
	
	if ($dif_Meses<0) {
		$dif_Meses = $dif_Meses + 12;
		$dif_Anos--; }
	
	if ($dif_Dias<0) {
		$dif_Dias = $dif_Dias + 30;
		$dif_Meses--; }
	
	return round( $dif_Anos + $dif_Meses/12 + $dif_Dias/360 , 2);

}

function DiaS($i){
switch ($i) {
    case 1:
        return "Lun";
        break;
    case 2:
        return "Mar";
        break;
    case 3:
        return "Mié";
        break;
    case 4:
        return "Jue";
        break;
    case 5:
        return "Vie";
        break;
    case 6:
        return "Sáb";
        break;
    case 7:
        return "Dom";
        break;
	}	
}

function Fecha($Nombre, $actual) { 
$dia=substr($actual, 8, 2);
$mes=substr($actual, 5, 2);
$ano=substr($actual, 0, 4);

echo " <select name=\"FD_". $Nombre."\" class=\"TextosSimples\" id=\"select2\"   onchange=\"". $Nombre .".value=FY_". $Nombre .".value+'-'+FM_". $Nombre .".value+'-'+FD_". $Nombre .".value\">
";
echo "<option value=\"00\" >dd</option>
";


for ($i = 1; $i <= 31; $i++) {
	$j = substr("0".$i , -2);
    echo "<option value=\"" . $j ."\"";
	if ($dia==$j){echo ' SELECTED ';}
	echo " >".$j."</option>
"; }

echo "</select>
";




echo " <select name=\"FM_". $Nombre."\" class=\"TextosSimples\" id=\"FnacM\"   onchange=\"". $Nombre .".value=FY_". $Nombre .".value+'-'+FM_". $Nombre .".value+'-'+FD_". $Nombre .".value\">
";
echo "<option value=\"00\" >mm</option>
";

for ($i = 1; $i <= 12; $i++) {
	$j = substr("0".$i , -2);
    echo "<option value=\"" . $j ."\"";
	if ($mes==$j){echo ' SELECTED ';}
	echo " >".$j."</option>
"; }


echo "</select>
";


echo " <select name=\"FY_". $Nombre."\" class=\"TextosSimples\" id=\"FnacM\"   onchange=\"". $Nombre .".value=FY_". $Nombre .".value+'-'+FM_". $Nombre .".value+'-'+FD_". $Nombre .".value\">
";
echo "<option value=\"0000\" >yyyy</option>
";

	$min = 1940;
	$max = date('Y')-1;
	
	$i = $max;
	do {
	echo "<option value='".$i."'";
	if ($ano==$i)echo "SELECTED";
	echo ">".$i."</option>\n";
	$i -= 1 ;
	} while ($i > $min);
	

echo "</select>
";	
	}




function FechaFutura($Nombre, $actual) { 
$dia = substr($actual, 8, 2);
$mes = substr($actual, 5, 2);
$ano = substr($actual, 0, 4);

$onChange = "class=\"TextosSimples\"  onchange=\"Fecha.value=FY_Fecha.value+'-'+FM_Fecha.value+'-'+FD_Fecha.value\" ";

echo '<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<span id="diaxx">';


echo '<select name="FD_'.$Nombre.'" id="FD_'.$Nombre.'" '; echo $onChange; echo ' >';

for ($i = 0; $i <= 31; $i++) {
	$dd = substr("0".$i,-2);
	echo '<option value="'.$dd.'"';
	if ($dia == $dd){
		echo'SELECTED';}
	echo " >$dd</option>
	";
}

echo "</select>";
echo '<span class="selectInvalidMsg">*</span>  <span class="selectRequiredMsg">*</span></span><span id="mesxx">';


echo '<select name="FM_'.$Nombre.'" id="FM_'.$Nombre.'" '; echo $onChange; echo ' >';


for ($i = 0; $i <= 12; $i++) {
	$mm = substr("0".$i,-2);
	echo '<option value="'.$mm.'"';
	if ($mes == $mm){
		echo ' SELECTED';}
	echo " >$mm</option>
	";
}
echo "</select>";



echo '<span class="selectInvalidMsg">*</span>  <span class="selectRequiredMsg">*</span></span><span id="a&ntilde;oxx">';


echo '<select name="FY_'.$Nombre.'" id="FY_'.$Nombre.'" '; echo $onChange; echo ' >';

$anoInic = $ano - 3;
$anoFin = $ano + 3;

for ($i = $anoInic; $i <= $anoFin; $i++) {
	$aa = $i;
	echo '<option value="'.$aa.'"';
	if ($ano == $aa){
		echo ' SELECTED';}
	echo " >$aa</option>
	";
}



echo "</select>";
echo '
    
<span class="selectInvalidMsg">*</span><span class="selectRequiredMsg">*</span><span class="selectRequiredMsg">*</span></span>
<script type="text/javascript">
<!--
var spryselect1diaxx = new Spry.Widget.ValidationSelect("diaxx", {invalidValue:"00", validateOn:["blur", "change"]});
var spryselect2mesxx = new Spry.Widget.ValidationSelect("mesxx", {invalidValue:"00", validateOn:["blur", "change"]});
var spryselect3añoxx = new Spry.Widget.ValidationSelect("añoxx", {invalidValue:"0000", validateOn:["blur", "change"]});
//-->
</script>
';

}
  
function Titulo($aux) { 
	echo ucwords(strtolower(trim($aux)));  
}
  
function Titulo_Mm($aux) { 
	return ucwords(strtolower(trim($aux)));  
}
  

function MenuCurso( $actual = 0 , $extraScript="" ) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


	//$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	//mysql_select_db($database_bd, $bd);
	$query_RS_Cur = "SELECT * FROM Curso 
					WHERE SW_activo=1 
					ORDER BY NivelMencion ASC, NivelCurso ASC, Curso, Seccion";
	/*$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);*/
	
	$RS_Cur = $mysqli->query($query_RS_Cur);
	$row_RS_Cur = $RS_Cur->fetch_assoc();
	$totalRows_RS_Cur = $RS_Cur->num_rows;

	
	$Disp_SW_CupoDisp = false;

	if ($extraScript == "SW_CupoDisp"){
		$extraScript = "";
		$Disp_SW_CupoDisp = true;
		}
		
	
	echo "<select name=\"CodigoCurso\" $extraScript ><option value=\"\">Seleccione...</option>";
	 do { 
	 
		 if (($row_RS_Cur['SW_CupoDisp'] and $Disp_SW_CupoDisp) or !$Disp_SW_CupoDisp) {
		 
			 if ($NivelMencionAnterior != $row_RS_Cur['NivelMencion'] and $row_RS_Cur['NivelMencion']<>4){
				echo "<option value=\"\" >_______</option><option value=\"\" >";
				
				if ($row_RS_Cur['NivelMencion'] == "1")
					echo " -- PREESCOLAR --";
				elseif ($row_RS_Cur['NivelMencion'] == "2")
					echo " -- PRIMARIA --";
				elseif ($row_RS_Cur['NivelMencion'] == "3")
					echo " -- BACHILLERATO --";
					
				echo "</option>
				";}
			 echo "<option value=\"".$row_RS_Cur['CodigoCurso']. "\" ";
			 if (!(strcmp($row_RS_Cur['CodigoCurso'] , $actual ))) 
				echo "SELECTED";
			 echo ">";
			 
			 if (!strcmp($row_RS_Cur['CodigoCurso'] , $actual )){
			 		echo $row_RS_Cur['NombreCompleto'];}
			 else {
				 	echo $row_RS_Cur['NombreCorto']."&nbsp;".$row_RS_Cur['Seccion'];}
			 
			 if ($Disp_SW_CupoDisp and !$row_RS_Cur['SW_CupoDisp']) 
				echo "   -->> NO HAY DISPONIBILIDAD";
			 echo "</option>
			 ";
			 $NivelMencionAnterior = $row_RS_Cur['NivelMencion'];
	 		 $NivelCursoAnterior = $row_RS_Cur['NivelCurso'];
		 }
	 
	} while ($row_RS_Cur = $RS_Cur->fetch_assoc() );//$row_RS_Cur = mysql_fetch_assoc($RS_Cur)
	
	echo "</select>";
} 


function MenuCurso2($actual = 0 ,$extraScript="") { 
	/*$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
*/

	//$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	//mysql_select_db($database_bd, $bd);
	$query_RS_Cur = "SELECT * FROM Curso 
					WHERE SW_activo=1 
					ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
	/*$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);*/
	
	$RS_Cur = $mysqli->query($query_RS_Cur);
	$row_RS_Cur = $RS_Cur->fetch_assoc();
	$totalRows_RS_Cur = $RS_Cur->num_rows;

	
	$Disp_SW_CupoDisp = false;

	if ($extraScript == "SW_CupoDisp"){
		$extraScript = "";
		$Disp_SW_CupoDisp = true;
		}
		
	
	echo "<select name=\"CodigoCurso\" $extraScript ><option value=\"\">Seleccione...</option>";
	 do { 
	 
		 if (($row_RS_Cur['SW_CupoDisp'] and $Disp_SW_CupoDisp) or !$Disp_SW_CupoDisp) {
		 
			 if ($NivelMencionAnterior != $row_RS_Cur['NivelMencion'] and $row_RS_Cur['NivelMencion']<>4){
				echo "<option value=\"\" >_______</option><option value=\"\" >";
				
				if ($row_RS_Cur['NivelMencion'] == "1")
					echo "PREESCOLAR";
				elseif ($row_RS_Cur['NivelMencion'] == "2")
					echo "PRIMARIA";
				elseif ($row_RS_Cur['NivelMencion'] == "3")
					echo "BACHILLERATO";
					
				echo "</option>
				";}
			 echo "<option value=\"".$row_RS_Cur['CodigoCurso']. "\" ";
			 if (!(strcmp($row_RS_Cur['CodigoCurso'] , $actual ))) 
				echo "SELECTED";
			 echo ">";
			 
			 if (!strcmp($row_RS_Cur['CodigoCurso'] , $actual )){
			 		echo $row_RS_Cur['NombreCompleto'];}
			 else {
				 	echo $row_RS_Cur['NombreCorto']."&nbsp;".$row_RS_Cur['Seccion'];}
			 
			 if ($Disp_SW_CupoDisp and !$row_RS_Cur['SW_CupoDisp']) 
				echo "   -->> NO HAY DISPONIBILIDAD";
			 echo "</option>
			 ";
			 $NivelMencionAnterior = $row_RS_Cur['NivelMencion'];
	 		 $NivelCursoAnterior = $row_RS_Cur['NivelCurso'];
		 }
	 
	} while ($row_RS_Cur = $RS_Cur->fetch_assoc() );//$row_RS_Cur = mysql_fetch_assoc($RS_Cur)
	
	echo "</select>";
} 




function Ir_a_Curso($actual = 0 , $extraOpcion = "" , $MM_UserGroup ="" , $MM_Username="") {
echo '	
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
';
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

	//$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	//mysql_select_db($database_bd, $bd);
	//$Docente = false;
	if ($MM_UserGroup == "docente"){
		$query_RS_Cur = "SELECT * FROM Curso 
						WHERE SW_activo=1 
						AND (Cedula_Prof_Guia LIKE '%$MM_Username%'
						OR   Cedula_Prof_Aux  LIKE '%$MM_Username%'
						OR   Cedula_Prof_Esp  LIKE '%$MM_Username%')
						ORDER BY NivelMencion, NivelCurso , Curso, Seccion";
		//$Docente = true;
		}
	else{
		$query_RS_Cur = "SELECT * FROM Curso 
						 WHERE SW_activo=1 
						 ORDER BY NivelMencion , NivelCurso , Curso, Seccion";}
	//echo $MM_UserGroup.$query_RS_Cur;					 
	
	
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$RS = $mysqli->query($query_RS_Cur);
	$row_RS_Cur = $RS->fetch_assoc();
	
	$txt= '
	<select name="CodigoCurso"  onchange="MM_jumpMenu(\'parent\',this,0)" >
	<option value="">Seleccione...</option>';
	do { 
	
		if ($NivelMencionAnterior != $row_RS_Cur['NivelMencion']){ // Separador en blanco
			$txt.= '<option value="'.$extraOpcion.'" > </option>
		';}
		
		$txt.= '<option value="'.$extraOpcion.$row_RS_Cur['CodigoCurso']. '" '; // Opcion base
		if (!(strcmp($row_RS_Cur['CodigoCurso'] , $actual ))) // Seleccionar actual
			$txt.= "SELECTED"; 
		$txt.= ">";
		$txt.= $row_RS_Cur['NombreCompleto']."</option> 
		"; //Etiqueta Opcion
		$NivelMencionAnterior = $row_RS_Cur['NivelMencion'];
		
		$CodigosCursos[++$i] = $row_RS_Cur['CodigoCurso'];
		if ($row_RS_Cur['CodigoCurso'] == $actual) //Marca en matriz del curso actual 
			$KesimoActual = $i; 
		
	} while ($row_RS_Cur = $RS->fetch_assoc());
	$txt.= "</select>.";

	
	
	
echo '<table>
<tr>
<td>';
	
	if ($KesimoActual > 1){
		echo '<a href="'.$extraOpcion.$CodigosCursos[$KesimoActual-1].
			'"><img src="http://www.colegiosanfrancisco.com/i/control_rewind_blue.png" width="32" height="32" border=0 /></a>';}
	else
		echo '<img src="http://www.colegiosanfrancisco.com/i/control_rewind.png" width="32" height="32" border=0 />';
	
	echo '</td><td>'.$txt.'</td><td>';
	
	if ($KesimoActual < $i){
		echo '<a href="'.$extraOpcion.$CodigosCursos[$KesimoActual+1].
			'"><img src="http://www.colegiosanfrancisco.com/i/control_fastforward_blue.png" width="32" height="32" border=0 /></a>';}
	else
		echo '<img src="http://www.colegiosanfrancisco.com/i/control_fastforward.png" width="32" height="32" border=0 />';


echo '</td>
</tr>
</table>';	
	
} 



function Boton_Cursos( $actual = 0 ) {
	
	$php_self = $_SERVER['PHP_SELF'] . "?id_Curso=";
	
	echo '	
	<script type="text/javascript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
	  if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>
	';
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$sql = "SELECT * FROM Curso 
			 WHERE SW_activo = 1 
			 ORDER BY NivelMencion , NivelCurso , Curso, Seccion";
	
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	//$NivelMencionAnterior = $NivelMencion;
	
	$txt= '
	<select name="CodigoCurso"  onchange="MM_jumpMenu(\'parent\',this,0)" >
	<option value="">Seleccione...</option>';
	do {
		$i++;
		extract($row);
	
		if ($NivelMencionAnterior != $NivelMencion){ // Separador en blanco
			$txt.= '<option value="" > </option>
		';}
		
		$txt.= '<option value="'.$php_self.$CodigoCurso. '" '; // Opcion base
		if (!(strcmp($CodigoCurso , $actual ))) // Seleccionar actual
			$txt .= " SELECTED "; 
		$txt .= ">" . $NombreCompleto ."</option> 
		"; //Etiqueta Opcion
		
		if ($CodigoCurso == $actual) //Marca en matriz del curso actual 
			$KesimoActual = $i; 
		
		$CodigosCursos[$i] = $CodigoCurso;
		$NivelMencionAnterior = $NivelMencion;
	}	while ($row = $RS->fetch_assoc()) ;
	$txt .= "</select>";

	
	
	
echo '<table class="sombra" width="10">
<caption class="RTitulo">Curso</caption>
<tr><td>';
	
	if ($KesimoActual > 1){
		echo '<a href="'.$php_self.$CodigosCursos[$KesimoActual-1].
			'"><img src="/i/control_rewind_blue.png" width="32" height="32" border=0 /></a>';}
	else
		echo '<img src="/i/control_rewind.png" width="32" height="32" border=0 />';
	
	echo '</td><td>';
	echo $txt; // incorpora el select
	echo '</td><td>'; 
	
	if ($KesimoActual < $i){
		echo '<a href="'.$php_self.$CodigosCursos[$KesimoActual+1].
			'"><img src="http://www.colegiosanfrancisco.com/i/control_fastforward_blue.png" width="32" height="32" border=0 /></a>';}
	else
		echo '<img src="http://www.colegiosanfrancisco.com/i/control_fastforward.png" width="32" height="32" border=0 />';


echo '</td>
</tr>
</table>';
	
} 





function SelectMenuCurso($NombreSelect,$actual,$extraScript) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$query_RS_Cur = "SELECT * FROM Curso WHERE SW_activo = 1 ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
	$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
	
	echo "<select name=\"".$NombreSelect."\" $extraScript ><option value=\"0\">Seleccione...</option>";
	 do { 
	 
		 if ($NivelMencionAnterior != $row_RS_Cur['NivelMencion']){
			echo "<option value=\"0\" > </option>
			";}
		 echo "<option value=\"".$row_RS_Cur['CodigoCurso']. "\" ";
		 if (!(strcmp($row_RS_Cur['CodigoCurso'] , $actual ))) 
			echo "SELECTED";
		 echo ">";
		 echo $row_RS_Cur['NombreCompleto']."</option>
		 ";
		 $NivelMencionAnterior = $row_RS_Cur['NivelMencion'];
	 
	} while ($row_RS_Cur = mysql_fetch_assoc($RS_Cur));
	
	echo "</select>";
} 

function NombreCurso($codigo, $cursoProxAno) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	
	mysql_select_db($database_bd, $bd);
	if ($codigo ==0) {$codigo = $cursoProxAno;}
	if ($codigo == "" ) {$codigo = "0";}
	//echo $codigo;
	
	$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = $codigo "; //echo $query_RS_Cur;
	$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
	
	echo $row_RS_Cur['NombreCompleto'];
	
}

function NombreNivelCurso($NivelCurso) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	
	$sql = "SELECT * FROM Curso 
			WHERE NivelCurso >= '$NivelCurso'";
	$RS_Cur = mysql_query($sql, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
	if ($totalRows_RS_Cur)
		return $row_RS_Cur['Curso']."º ".$row_RS_Cur['NombrePlanDeEstudio'];
	else
		return "";
}

function NivelCurso($CodigoCurso) {
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	
	$sql = "SELECT * FROM Curso 
			WHERE CodigoCurso = '$CodigoCurso'";
	//echo $sql;
	$RS_Cur = mysql_query($sql, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
	if ($totalRows_RS_Cur)
		return $row_RS_Cur['NivelCurso'];
	else
		return "";
}



function Curso($codigo) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

	//$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	//mysql_select_db($database_bd, $bd);
	
	$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = '$codigo' "; //echo $query_RS_Cur;
	
	$RS_Cur = $mysqli->query($query_RS_Cur);
	$row_RS_Cur = $RS_Cur->fetch_assoc();
	$totalRows_RS_Cur = $RS_Cur->num_rows;

	
	/*
	$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);*/
	if ($totalRows_RS_Cur)
		return $row_RS_Cur['NombreCompleto'];
	else
		return "0";
}

function CodigoCursoProx($codigo) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	
	
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	
	$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = $codigo "; //echo $query_RS_Cur;
	
	$RS_Cur = $mysqli->query($query_RS_Cur);
	$row_RS_Cur = $RS_Cur->fetch_assoc();
	/*

	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	
	$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);*/
	
	return $row_RS_Cur['CodigoCursoProxAno'];
}


function CursoConstancia($codigo) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	
	mysql_select_db($database_bd, $bd);
	
	$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = $codigo "; //echo $query_RS_Cur;
	$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
	$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
	$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
	
	$NombreCursoConstancia = substr($row_RS_Cur['NombreCompleto'] , 0 , 3).'.';
	
	if ($row_RS_Cur['NivelCurso'] <= "14")
		$NombreCursoConstancia .=  " Grupo de Educación Inicial";
	elseif ($row_RS_Cur['NivelCurso'] == "14")
		$NombreCursoConstancia =  "Preparatorio";
	elseif ($row_RS_Cur['NivelCurso'] <= "26")
		$NombreCursoConstancia .=  " Grado de Educación Primaria";
	else
		$NombreCursoConstancia .=  " Año de Educación Media General";
	
	return $NombreCursoConstancia;

}


function CursoSeccion($codigo) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	
	mysql_select_db($database_bd, $bd);
	if ($codigo>0){
		$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = '$codigo' "; //echo $query_RS_Cur;
		$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
		$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
		$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
		
		return $row_RS_Cur['Curso'].' '.substr($row_RS_Cur['NombreNivel'],0,3).' '.$row_RS_Cur['Seccion'];
	}
}

function CurSec($codigo) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	
	mysql_select_db($database_bd, $bd);
	if ($codigo>0){
		$query_RS_Cur = "SELECT * FROM Curso WHERE CodigoCurso = '$codigo' "; //echo $query_RS_Cur;
		$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
		$row_RS_Cur = mysql_fetch_assoc($RS_Cur);
		$totalRows_RS_Cur = mysql_num_rows($RS_Cur);
		
		return $row_RS_Cur['Curso'].' '.$row_RS_Cur['Seccion'];
	}
}







function MenuEmpleado ($Codigo=0, $Destino, $Sort = "Cargo" ){ 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	
	if($Sort == "Cargo")
		$Sql_sort = " ORDER BY TipoEmpleado, TipoDocente, Apellidos, Nombres" ;
	else
		$Sql_sort = " ORDER BY Apellidos, Nombres" ;
	$sql = "SELECT * FROM Empleado 
			WHERE SW_activo = 1 
			$Sql_sort";
	//echo $sql;
	$RS = $mysqli->query($sql);
	$i = 1;
	while ($row = $RS->fetch_assoc()) {
		
		$Lista[$i]["Codigo"] = $row['CodigoEmpleado'];
		$Lista[$i]["Ape"] = $row['Apellidos'];
		$Lista[$i]["Nom"] = $row['Nombres'];
			
		
		
		if (!(strcmp($row['CodigoEmpleado'], $Codigo))) {
				$Lista[$i]["selected"] = "selected=\"selected\""; 
				$Emp_ant = $Lista_Anterior;
				$Emp_Actual = $i;
		}
				
		$i++;
	}
	

	
	echo '
		<script type="text/javascript">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ //v3.0
		  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
		  if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>

	<form name="form" id="form">';
	  
		
	if( $Emp_Actual > 1 ){ // anterior
		echo '<a href="'. $Destino . '&CodigoEmpleado='. $Lista[$Emp_Actual-1]["Codigo"] .'"  >';
		echo '<img src="/i/control_rewind_blue.png" width="32" height="32" border=0 />';
		echo '</a>'; 
	}
	else{
		echo '<img src="/i/control_rewind.png" width="32" height="32" border=0 />';
	}
	
	echo '<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu(\'parent\',this,0)">
		<option value="0">Seleccione...</option>
		';
	echo "\r\n";
	
	foreach($Lista as $Emp){
		echo '<option value="'. $Destino . '&CodigoEmpleado='. $Emp["Codigo"] .'" '. $Emp["selected"].' >'; 
		echo $Emp["Ape"]." ".$Emp["Nom"];
		echo "</option>\r\n";
	}
	echo "</select>";
	
	if( $Emp_Actual < $i-1 ){ // siguiente
		echo '<a href="'. $Destino . '&CodigoEmpleado='. $Lista[$Emp_Actual+1]["Codigo"] .'"  >';
		echo '<img src="/i/control_fastforward_blue.png" width="32" height="32" border=0 />';
		echo '</a>'; 
	}
	else{
		echo '<img src="/i/control_fastforward.png" width="32" height="32" border=0 />';
	}
	
	echo "</form>"; 
	
}









function EmpleadoCI($cedula) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedula."' OR CodigoEmpleado = '".$cedula."' "; 
	//echo $query_RS_Cur;
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	//echo $sql;
	if ($row_RS_ = mysql_fetch_assoc($RS_))
		return $row_RS_['Apellidos'].' '.$row_RS_['Nombres'];
}

function Empleado_ApellidoNombre($cedula) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedula."' OR CodigoEmpleado = '".$cedula."' "; 
	//echo $query_RS_Cur;
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	//echo $sql;
	if ($row_RS_ = mysql_fetch_assoc($RS_))
		return $row_RS_['Apellidos'].' '.substr($row_RS_['Apellidos2'],0,1)." ".$row_RS_['Nombres'].' '.substr($row_RS_['Nombres2'],0,1);
}




function DocenteGuia($CodigoCurso) { 
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());
	mysql_select_db($database_bd, $bd);
	$sql = "SELECT * FROM Curso WHERE CodigoCurso = '".$CodigoCurso."' "; //echo $sql;
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_RS_ = mysql_fetch_assoc($RS_);
	$cedula = explode(',',$row_RS_['Cedula_Prof_Guia'].',');
	$cedulaAUX = explode(',',$row_RS_['Cedula_Prof_Aux'].',');
	
	
	if ($cedula[0]>''){
		$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedula[0]."' "; //echo $sql;
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		if ($row_RS_ = mysql_fetch_assoc($RS_))
			$Docente[0] = $row_RS_['Nombres'].' '.$row_RS_['Apellidos']; }
	
	if ($cedula[1]>''){
		$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedula[1]."' "; //echo $sql;
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		if ($row_RS_ = mysql_fetch_assoc($RS_))
			$Docente[1] = $row_RS_['Nombres'].' '.$row_RS_['Apellidos']; }
	
	if ($cedula[2]>''){
		$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedula[2]."' "; //echo $sql;
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		if ($row_RS_ = mysql_fetch_assoc($RS_))
			$Docente[1] = $Docente[1] . ', ' . $row_RS_['Nombres'].' '.$row_RS_['Apellidos']; }

	if ($cedulaAUX[0]>''){
		$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedulaAUX[0]."' "; //echo $sql;
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		if ($row_RS_ = mysql_fetch_assoc($RS_))
			$Docente[3] = $row_RS_['Nombres'].' '.$row_RS_['Apellidos']; }
	
	if ($cedulaAUX[1]>''){
		$sql = "SELECT * FROM Empleado WHERE Cedula = '".$cedulaAUX[1]."' "; //echo $sql;
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		if ($row_RS_ = mysql_fetch_assoc($RS_))
			$Docente[4] = ' / '.$row_RS_['Nombres'].' '.$row_RS_['Apellidos']; }
	

	
	return $Docente;
	
	
}



function CursoAlumno($CodigoAlumno, $Ano) { 
$hostname_bd = "localhost";
$database_bd = "colegio_db"; 
$username_bd = "colegio_colegio";
$password_bd = "kepler1971";
$bd = mysql_pconnect($hostname_bd, $username_bd, $password_bd) or die(mysql_error());

mysql_select_db($database_bd, $bd);

$query_RS_Cur = "SELECT * FROM AlumnoXCurso WHERE CodigoAlumno = '$CodigoAlumno' AND Ano = '$Ano' "; //echo $query_RS_Cur;
$RS_Cur = mysql_query($query_RS_Cur, $bd) or die(mysql_error());
$row_RS_Cur = mysql_fetch_assoc($RS_Cur);

if ($row_RS_Cur['CodigoCurso']>0)
return Curso($row_RS_Cur['CodigoCurso']);

}



	  
function Resumen2 ($ReferenciaMesAno, $CodigoPropietario, $database_bd, $bd, $SWAgostoFraccionado, $MontoMensualidad, $BB , $SW_Montos = false) {	

$ReferenciaMesAno2 = str_replace("-"," ",$ReferenciaMesAno);

$hostname_bd = "localhost";
$database_bd = "colegio_db";
$username_bd = "colegio_colegio";
$password_bd = "kepler1971";
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$query_RS_Mov_Mes = "SELECT * FROM ContableMov 
					WHERE  ContableMov.CodigoPropietario = $CodigoPropietario 
					AND (ReferenciaMesAno = '$ReferenciaMesAno' OR ReferenciaMesAno = '$ReferenciaMesAno2')
					AND Descripcion NOT LIKE '%ABONO%'
					ORDER BY Codigo ASC"; 
$RS_Mov_Mes = $mysqli->query($query_RS_Mov_Mes);
//echo $query_RS_Mov_Mes;
	
//echo "Resumen2";

	if ( $RS_Mov_Mes ) {
		$totalM=0;
	echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" >";
		while ($row_RS_Mov_Mes = $RS_Mov_Mes->fetch_assoc()) {
			if($row_RS_Mov_Mes['Descripcion'] > "" and $row_RS_Mov_Mes['MontoDebe'] > 0){ 
			
			echo "<tr><td nowrap >";
			if ( $row_RS_Mov_Mes["Referencia"] == $_GET['CodigoRelacionado'] 
						and isset($_GET['CodigoRelacionado']) ){
				echo '<font color=orange size="+1">';}
				
			elseif ( $row_RS_Mov_Mes["Referencia"] == $_GET['CodigoAsignacion'] 
						and isset($_GET['CodigoRelacionado'])){
				echo '<font color=green size="+1">';}
				
			elseif ($row_RS_Mov_Mes["SWCancelado"] == 1 ) { //or $row_RS_Mov_Mes["MontoDebe"] < 1 
				echo "<font color=#0000BB>";} 	
						
			else {
				echo "<font color=#FF0000>";}
			
			//echo "<spam title='".$row_RS_Mov_Mes['Descripcion']."'>";
			
			//if ($SW_Montos)
			//	echo substr($row_RS_Mov_Mes['Descripcion'],0,5).'';
			//else	
			if ($row_RS_Mov_Mes['Descripcion']=='Escolaridad')
				echo 'e';
				elseif ($row_RS_Mov_Mes['Descripcion']=='Actividades Extracurriculares')
					echo 'a';
					else {
						$palabras = str_word_count($row_RS_Mov_Mes['Descripcion'],1);
						echo substr($palabras[0],0,3)." ".substr($palabras[1],0,3)." "
							.substr($palabras[2],0,3)." ".substr($palabras[3],0,3)." "
							.substr($palabras[4],0,3)."";
						}		
			echo "</td>"; //.</font></spam>
			
			$SumatoriaMes += $row_RS_Mov_Mes['MontoDebe'];
			
			if ($SW_Montos){
				echo "<td align=\"right\">";
				if ($row_RS_Mov_Mes["SWCancelado"] == 1 ) { echo "<font color=#0000BB>";} 
				else { echo "<font color=#FF0000>";}
				echo $row_RS_Mov_Mes['MontoDebe'];
			}
			if ($row_RS_Mov_Mes["SWCancelado"] == 1 ) {
				echo  "</b> " . substr($row_RS_Mov_Mes["FechaRecibo"],8,2)."".substr($row_RS_Mov_Mes["FechaRecibo"],5,2);} 
			
			echo "</td></tr>";
			
			$totalM = $totalM+$row_RS_Mov_Mes["MontoDebe"];		
			if (!$row_RS_Mov_Mes["SWCancelado"]){
				$SaldoPend += $row_RS_Mov_Mes["MontoDebe"] - $row_RS_Mov_Mes["MontoAbono"];
			}
		}
	}
	//if($SumatoriaMes>0)
	//echo "<tr><td nowrap colspan=\"2\" align=\"right\" >Tot ".Fnum($SumatoriaMes).'</td></tr>';	
	if($SaldoPend>0)
		echo "<tr><td nowrap colspan=\"2\" align=\"right\">Pend ".Fnum($SaldoPend).'</td></tr>';	
	
	echo "</table>";
	
	} 

/*
echo Fnum($SaldoPend);
//echo '.';
if ($SaldoPend>0){
    //echo "<br>11<br>";
	return 1; }
else
	return 0.0001 * $RS_Mov_Mes->num_rows;
*/
return "";	
	
	
}

function Nt($Nota) {
	if ($Nota == 'i' or $Nota == 'I')
		return 'I';
	elseif ($Nota > 0 ) {
		$Nota = "00".$Nota;
		return substr($Nota, -2); }
	else
		return '';
}

function Nota($Nota) {
if ($Nota=='i' or $Nota=='I') $Nota = strtoupper($Nota);
if ($Nota > 0 and $Nota <= 20) {
$Nota = substr("0".$Nota , -2);}
if ($Nota =='' or $Nota =='00') {
$Nota = '*';}
return $Nota;
}


function MenuCursos ($CodigoCurso, $Destino ,$database_bd, $bd){ 
mysql_select_db($database_bd, $bd);
$query_RS_Cursos = "SELECT * FROM Curso WHERE SW_activo = '1' ORDER BY NivelMencion, Curso, Seccion ASC";
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);

echo '
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
 
';


echo '
<form name="form" id="form">
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu(\'parent\',this,0)">
    <option value="0">Seleccione...</option>
    ';

$Anterior = -1; $Anterior_OK = false; $Siguiente = '';
do {   

	echo '<option value="'.$Destino."?CodigoCurso=".$row_RS_Cursos['CodigoCurso'].'"'; 

	if ($Siguiente == 0){ 
		$Siguiente = $row_RS_Cursos['CodigoCurso']; }
	if ($Siguiente == -1){ 
		$Siguiente = 0; }
	
	if (!(strcmp($row_RS_Cursos['CodigoCurso'], $CodigoCurso))) {
		echo "selected=\"selected\""; $Anterior_OK = true; }
	else { 
		if ( !$Anterior_OK ) {
			$Anterior = $row_RS_Cursos['CodigoCurso']; 
			$Siguiente = -1; } } 

	echo '>';
	echo $row_RS_Cursos['NombreCompleto'].'</option>';
    
} while ($row_RS_Cursos = mysql_fetch_assoc($RS_Cursos));
  $rows = mysql_num_rows($RS_Cursos);
  if ($rows > 0) {
      mysql_data_seek($RS_Cursos, 0);
	  $row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
  }

echo '</select>..
</form>'; 

mysql_free_result($RS_Cursos);


//if ($Anterior>0){echo "<a href=";}

//echo $Anterior . ' ' . $Siguiente;
}



function dateDif ($startDate, $endDate) 
        { 
            $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
			
            //if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
            //    return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
			
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months < 0)  { 
                $months += 12; 
                //$years--; 
            } 
            //if ($years < 0) 
            //    return false; 
            
			
			
            // Calculate the days 
						$endDay = date('z', $endDate); 
            			$startDay = date('z', $startDate); 
						
                      //  $offsets = array(); 
                      //  if ($years > 0) 
                      //      $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                      //  if ($months > 0) 
                      //      $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                      //  $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDay - $startDay + (365*$years);
						
						 
                        //$days = date('z', $days);    
                        
            return $days; 
        } 


function coma_punto($num){
	if (strpos($num , ".") and strpos($num , ",")){
		$num = str_replace('.','',$num);
		}
	return str_replace(',','.',$num);		
	}
	
function Campo($Nombre,$Tipo,$Valor,$Largo=8,$extra=""){
		
	if ($Tipo=='' or $Tipo=='t') 
	  $Tipo='text';
	
	if ($Tipo=='h' ) 
	  $Tipo='hidden';
	
	if ($Tipo=='d' ) 
	  $Tipo='Date';
	
	if ($Tipo=='n' ) 
	  $Tipo='number';
	
	if ($Tipo=='ht') {
	  $Tipo='hidden'; 
	  echo $Valor;
	  }
	
	if ($Largo < 1) 
	  $Largo=8;
	
	echo '
	<input name="'.$Nombre.'" id="'.$Nombre.'" type="'.$Tipo.'" value="'.$Valor.'" size="'.$Largo.'" '.$extra.' />';

}

function Boton_Submit(){
	
	echo '<input type="hidden" name="time" id="time" value="'.time().'" />';
	echo '<input type="submit" value="submit"  onClick="this.disabled=true;this.form.submit();" />';
}
function selected($a,$b){
	if ($a==$b)
		echo ' selected="selected" ';
}

function php_self(){
	echo $_SERVER['PHP_SELF'];
}


function sinAcento($cadena){
	$cadena = str_replace('á','a',$cadena);
	$cadena = str_replace('é','e',$cadena);
	$cadena = str_replace('í','i',$cadena);
	$cadena = str_replace('ó','o',$cadena);
	$cadena = str_replace('ú','u',$cadena);
	$cadena = str_replace('ñ','n',$cadena);
	$cadena = str_replace('Á','A',$cadena);
	$cadena = str_replace('É','E',$cadena);
	$cadena = str_replace('Í','I',$cadena);
	$cadena = str_replace('Ó','O',$cadena);
	$cadena = str_replace('Ú','U',$cadena);
	$cadena = str_replace('Ñ','N',$cadena);
	$cadena = str_replace("'"," ",$cadena);
	$cadena = str_replace(","," ",$cadena);
	return $cadena;
}

function FaltaDato($CodigoAlumno,$dato){
	if ($CodigoAlumno > ' ' and $dato=='')
		return 1;
	else
		return 0;
			
	}
	
function Usuario(){
	$MM_Username  = $_COOKIE['MM_Username'];
	$MM_UserGroup = $_COOKIE['MM_UserGroup'];
	
	echo "<span class=\"Boton\">".$MM_Username." ". $MM_UserGroup." |
	 <a href=\"http://www.colegiosanfrancisco.com/LogOut.php\">Salir</a></span>";
	}	
	
function DiasBonoVacacional ($FechaIngreso , $FechaObjAntiguedad){
	
	$AnosLaborados  = Fecha_Meses_Laborados($FechaIngreso , $FechaObjAntiguedad);
	if ($AnosLaborados < 1) {
		$FactorBaseBono = $AnosLaborados; 
		$AnosLaborados = 0;}

	elseif ($AnosLaborados <= 15) {
		$AnosLaborados =  floor($AnosLaborados);
		$FactorBaseBono = 1;}
		
	elseif ($AnosLaborados > 15) {
		$AnosLaborados =  15;
		$FactorBaseBono = 1;}
	
	$DiasBonoVacacional = $FactorBaseBono * 15 + $AnosLaborados ; // hasta 15+15
	return $DiasBonoVacacional;
	
	}

	
function SueldoIntDia($FechaIngreso , $FechaObjAntiguedad , $SueldoBase){

	$DiasBonoVacacional = DiasBonoVacacional($FechaIngreso , $FechaObjAntiguedad);
	$SueldoDiario = round($SueldoBase/15 , 2);
	$MontoBono = round($DiasBonoVacacional*$SueldoDiario , 2);
	$SueldoIntDia = round( ($SueldoDiario * 30 * 14 + $MontoBono) / 365 , 2 ); // 14 meses
	
	return $SueldoIntDia;
	
	}

function Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,$Campo,$Valor) {
	if ($Valor < 1){$Valor = 0;}
echo "<iframe width=\"20\" height=\"20\" src=\"http://www.colegiosanfrancisco.com/inc/onoff.php?ClaveCampo=$ClaveCampo&ClaveValor=$ClaveValor&Tabla=$Tabla&Campo=$Campo&Valor=$Valor\" frameborder=\"0\" id=\"SWframe\"   scrolling=\"no\" seamless  ></iframe>
"; }
	
function Frame_Asistencia ($id_Alumno, $id_Asistencia = 0) {
echo "<iframe width=\"32\" height=\"32\" src=\"/inc/plantilla/asistencia.php?CodigoAlumno=$id_Alumno&id_Asistencia=$id_Asistencia\" frameborder=\"0\" id=\"SWframe\"   scrolling=\"no\" seamless  ></iframe>
"; }
	

function Variable_OnOff ($Nombre) {
echo "<iframe width=\"20\" height=\"20\" src=\"http://www.colegiosanfrancisco.com/inc/On-Off.php?Nombre=$Nombre\" frameborder=\"0\" id=\"SWframe\"  scrolling=\"no\" seamless  ></iframe>
"; }
	

function Var_Edit ($Var_Name) {
echo "<iframe width=\"100\" height=\"25\" src=\"http://www.colegiosanfrancisco.com/inc/Var_Edit.php?Var_Name=".$Var_Name."\" frameborder=\"0\" scrolling=\"no\" seamless ></iframe>
"; }
	
function Campo_Edit ($Tabla,$Codigo,$Campo) {
echo "<iframe width=\"100\" height=\"35\" src=\"http://www.colegiosanfrancisco.com/inc/Cell_Edit.php?Tabla=".$Tabla."&Codigo=".$Codigo."&Campo=".$Campo."\" frameborder=\"0\" scrolling=\"no\" seamless ></iframe>
"; }
	

function Campo_Edit_Empleado ($Tabla,$Codigo,$Campo) {
echo "<iframe width=\"100\" height=\"35\" src=\"http://www.colegiosanfrancisco.com/inc/Cell_Edit_Empleado.php?Tabla=".$Tabla."&Codigo=".$Codigo."&Campo=".$Campo."\" frameborder=\"0\" scrolling=\"no\" seamless ></iframe>
"; }
	



function Reticula($pdf){
	$delta = 10;
	$Alto = 25;
	//$Alto = 33;
	$Ancho = 21; 
	$pdf->SetFont('Arial','',6);
		$pdf->SetDrawColor(250,250,0);
	$pdf->SetTextColor(150,150,0);
	$pdf->SetLineWidth(0.05);
	
	$x_i = $y_i = 0;
	// Horizontal
	$iMax = $Alto;
	for($i = 0 ; $i <= $iMax ; $i++){
		$Xo = $x_i;
		$Xf = $x_i + $Ancho * $delta;
		$Yo = $y_i + $i * $delta;
		$Yf = $y_i + $i * $delta;	
	$pdf->SetDrawColor(0,150,0);
		$pdf->Line($Xo,$Yo,$Xf,$Yf);
		$pdf->SetDrawColor(210);
		$pdf->Line($Xo,$Yo+5,$Xf,$Yf+5);
		$pdf->SetDrawColor(245);
		$pdf->Line($Xo,$Yo+1,$Xf,$Yf+1);
		$pdf->Line($Xo,$Yo+2,$Xf,$Yf+2);
		$pdf->Line($Xo,$Yo+3,$Xf,$Yf+3);
		$pdf->Line($Xo,$Yo+4,$Xf,$Yf+4);
		$pdf->Line($Xo,$Yo+6,$Xf,$Yf+6);
		$pdf->Line($Xo,$Yo+7,$Xf,$Yf+7);
		$pdf->Line($Xo,$Yo+8,$Xf,$Yf+8);
		$pdf->Line($Xo,$Yo+9,$Xf,$Yf+9);
		
		for($j = 0 ; $j <= $Ancho ; $j++){
			$pdf->SetXY($Xo+$j*$delta,$Yo);
			$dispX = round($Xo+$j*$delta , 0);
			$dispY = round($Yo , 0);
			$pdf->Cell(8 , 2.5 , $dispX.",".$dispY , 0 , 0 , 'L'); 
		}
	}
	
	// Vertical
	$iMax = $Ancho;
	for($i = 0 ; $i <= $iMax ; $i++){
		$Xo = $x_i + $i * $delta;
		$Xf = $x_i + $i * $delta;
		$Yo = $y_i;
		$Yf = $y_i + $Alto * $delta;	
	$pdf->SetDrawColor(0,150,0);
		$pdf->Line($Xo,$Yo,$Xf,$Yf);
		$pdf->SetDrawColor(210);
		$pdf->Line($Xo+5,$Yo,$Xf+5,$Yf);
		$pdf->SetDrawColor(245);
		$pdf->Line($Xo+1,$Yo,$Xf+1,$Yf);
		$pdf->Line($Xo+2,$Yo,$Xf+2,$Yf);
		$pdf->Line($Xo+3,$Yo,$Xf+3,$Yf);
		$pdf->Line($Xo+4,$Yo,$Xf+4,$Yf);
		$pdf->Line($Xo+6,$Yo,$Xf+6,$Yf);
		$pdf->Line($Xo+7,$Yo,$Xf+7,$Yf);
		$pdf->Line($Xo+8,$Yo,$Xf+8,$Yf);
		$pdf->Line($Xo+9,$Yo,$Xf+9,$Yf);
	}
	$pdf->SetDrawColor(0);
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(255);
	$pdf->SetLineWidth(0.2);
}

function TieneAcceso($Acceso_US,$Requerido){
	if (strpos('  '.$Acceso_US,$Requerido) > 0 )
		return true;
	else
		return false;
	
	}

function Entidad($Entidad){
	switch ($Entidad) {
		case "Am":
			$Entidad_Larga = "Amazonas" ;
			break;
		case "An":
			$Entidad_Larga = "Anzoátegui" ;
			break;
		case "Ap":
			$Entidad_Larga = "Apure" ;
			break;
		case "Ar":
			$Entidad_Larga = "Aragua" ;
			break;
		case "Ba":
			$Entidad_Larga = "Barinas" ;
			break;
		case "Bo":
			$Entidad_Larga = "Bolívar" ;
			break;
		case "Ca":
			$Entidad_Larga = "Carabobo" ;
			break;
		case "Co":
			$Entidad_Larga = "Cojedes" ;
			break;
		case "DA":
			$Entidad_Larga = "Amacuro" ;
			break;
		case "DC":
			$Entidad_Larga = "Distrito Capital" ;
			break;
		case "DF":
			$Entidad_Larga = "Distrito Federal" ;
			break;
		case "Fa":
			$Entidad_Larga = "Falcón" ;
			break;
		case "Gu":
			$Entidad_Larga = "Guarico" ;
			break;
		case "La":
			$Entidad_Larga = "Lara" ;
			break;
		case "Me":
			$Entidad_Larga = "Merida" ;
			break;
		case "Mi":
			$Entidad_Larga = "Miranda" ;
			break;
		case "Mo":
			$Entidad_Larga = "Monagas" ;
			break;
		case "NE":
			$Entidad_Larga = "Nueva Esparta" ;
			break;
		case "Po":
			$Entidad_Larga = "Portuguesa" ;
			break;
		case "Su":
			$Entidad_Larga = "Sucre" ;
			break;
		case "Ta":
			$Entidad_Larga = "Táchira" ;
			break;
		case "Tr":
			$Entidad_Larga = "Trujillo" ;
			break;
		case "Va":
			$Entidad_Larga = "Vargas" ;
			break;
		case "Ya":
			$Entidad_Larga = "Yaracuy" ;
			break;
		case "Zu":
			$Entidad_Larga = "Zulia" ;
			break;
		case "Ex":
			$Entidad_Larga = "-->>" ;
			break;
	    default:
			$Entidad_Larga = "???" ;
	
	}
	return $Entidad_Larga;
	}


function RutaFoto ($Codigo,$Medida){
	$Ano = date('Y');
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	$Ruta = $raiz.'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.'.jpg';
	$Ruta = $raiz.'/f/'.$Ano.'/'.$Codigo.'.jpg';
	
	
	if (file_exists($Ruta)){
		return $Ruta;}
	else{
		$Ano--;	
		$Ruta = $raiz.'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.'.jpg';
		$Ruta = $raiz.'/f/'.$Ano.'/'.$Codigo.'.jpg';
		if (file_exists($Ruta)){
			return $Ruta;}
		else{
			$Ano--;	
			$Ruta = $raiz.'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.'.jpg';
			$Ruta = $raiz.'/f/'.$Ano.'/'.$Codigo.'.jpg';
			if (file_exists($Ruta)){
				return $Ruta;}
			else{
				$Ano--;	
	
			}
		}
	}
}

function Foto ($Codigo,$Nexo,$Medida,$HoL){
	$Ano = date('Y');
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	for ($i = 1; $i <= 10; $i++){
		$Ruta = $raiz.'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.$Nexo;
		
		if (file_exists($Ruta.'.jpg')){
			$LaRutaEs = $Ruta.'.jpg';
			break;}
		if (file_exists($Ruta.'.jpeg')){
			$LaRutaEs = $Ruta.'.jpg';
			break;}
		if (file_exists($Ruta.'.JPEG')){
			$LaRutaEs = $Ruta.'.JPEG';
			break;}
		if (file_exists($Ruta.'.JPG')){
			$LaRutaEs = $Ruta.'.JPG';
			break;}
		
		$Ano--;	 
		$i++; 	 
	} // END for
	
	$Ruta = $raiz.'/f/solicitando/'.$Codigo.$Nexo.'.jpg';
	if (file_exists($Ruta)){
			$LaRutaEs = str_replace($raiz,"http://".$_SERVER['SERVER_NAME'],$Ruta);
			}
		
	
	if ($HoL == "H")
		$LaRutaEs = str_replace($raiz,"http://".$_SERVER['SERVER_NAME'],$LaRutaEs);	
	
	return $LaRutaEs;
	
}

function RutaFotoURL ($Codigo,$Medida){
	$Ano = date('Y');
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	$Ruta = $raiz.'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.'.jpg';
	if (file_exists($Ruta)){
		return "http://".$_SERVER['SERVER_NAME'].'/f/'.$Ano.'/'.$Medida.'/'.$Codigo.'.jpg';}
	}
	

function CodigoPropietario($CodigoAlumno){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$sql = "SELECT * FROM Alumno WHERE CodigoAlumno = $CodigoAlumno";
	//echo $sql;
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	return $row['CodigoClave'];	
	}

function CodigoAlumno($CodigoAlumno){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$sql = "SELECT * FROM Alumno WHERE CodigoClave = '$CodigoAlumno'";
	//echo $sql;
	$RS = $mysqli->query($sql);
	if($row = $RS->fetch_assoc())
		return $row['CodigoAlumno'];	
	}


function Status($CodigoAlumno, $AnoEscolar){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$sql = "SELECT * FROM AlumnoXCurso WHERE CodigoAlumno = $CodigoAlumno AND Ano = '$AnoEscolar'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	return $row['Status'];	
	}


if (isset($_GET['CodigoPropietario'])) {
	$CodigoPropietario = $_GET['CodigoPropietario'];
	$sql = sprintf("SELECT * FROM Alumno WHERE CodigoClave = %s", GetSQLValueString($CodigoPropietario, "text"));
	//echo $sql;
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	$CodigoAlumno = $row['CodigoAlumno'];
	//echo $CodigoAlumno;
}	
	

 
 function Cardinal ($num){
	 if($num == '1' )
		return 'PRIMERO';
	elseif($num == '2' )
		return 'SEGUNDO';
	elseif($num == '3' )
		return 'TERCERO';
	elseif($num == '4' )
		return 'CUARTO';
	elseif($num == '5' )
		return 'QUINTO';
	 }
 
 function Nota_Letra ($Nota){
	if($Nota >= '19' and $Nota <= '20')
		return 'A';
	elseif($Nota >= '16' and $Nota <= '18')
		return 'B';
	elseif($Nota >= '13' and $Nota <= '15')
		return 'C';
	elseif($Nota >= '10' and $Nota <= '12')
		return 'D';
	elseif($Nota >= '01' and $Nota <= '09')
		return 'D';
	elseif($Nota == '*')
		return '*';
	}

// 1 Devuelve -> 01
function oi($i){ return substr('0'.$i,-2);}


function on_off($sw){
	if ($sw < 1){
		return 1;
	}
	else{
		return 0;
	}
	
}


function Matriz_tabla($Resultado){
	
echo "<table>";
echo "<caption>Resultados</caption>";
echo "<tr>";
	echo "<th>";
	echo " ";
	echo "</th>";
	
foreach($Resultado as $clave => $valor){	
	foreach($valor as $clave1 => $valor1){
		echo "<th>";
		echo $clave1=="porc"?"%":$clave1;
		echo "</th>";
	}
	break;
}
	
echo "</tr>";
foreach($Resultado as $clave => $valor){
	echo "<tr><td>";
	echo $clave;
	echo "</td>";
	foreach($valor as $clave1 => $valor1){
		echo "<td>";
		echo $valor1;
		echo "</td>";
	}
	echo "</tr>";
	}
echo "</table>";
	
	}

function ($a="",$b="",$c="",$d="",$e=""){
	
	if($a > "")
		$Cuenta++;
	if($b > "")
		$Cuenta++;
	if($c > "")
		$Cuenta++;
	if($d > "")
		$Cuenta++;
	if($e > "")
		$Cuenta++;
	
	$Suma = $a+$b+$c+$d+$e;
	
	if($Cuenta > 0)
		return ($Suma/$Cuenta);
	
	}


?>