<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 


$TituloPantalla = "TituloPantalla";




/*
$Variable = new Variable();
$Variable->view("nombrevar");
$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);
$Compra = new Compra(["Codigo" => 1]);


if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
 onclick="this.disabled=true;this.form.submit();"
 
 <a href="delete.php?id=$res[id]"  onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a>
 
 
// Ejecuta $sql

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }

<input type="submit" name="Boton" id="Boton" value="Valor" onclick="this.disabled=true;this.form.submit();" />

*/
 
 
 $RS = $mysqli->query($query_RS_Alumno);

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
    <tr>
    <td align="left" valign="top"><?php 
   //$actual = $_GET['CodigoCurso'];
   //$extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   //Ir_a_Curso($actual,$extraOpcion); ?></td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="90%" border="0">
        <tr>
          <td class="NombreCampo">Titulo</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<?php 


$RS = $mysqli->query($query_RS_Alumno);
while ($row = $RS->fetch_assoc()) {
	extract($row);

	//extract($row_Nota);
	
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right">
  <?
  
$query_RS_Nota_Al = "SELECT * FROM Nota WHERE 
						CodigoAlumno = '". $CodigoAlumno."' AND 
						Lapso= 'Def' AND 
						Ano_Escolar='2019-2020'";
$RS_Nota = $mysqli->query($query_RS_Nota_Al);
echo $query_RS_Nota_Al ." 11 <br>";
$row_Nota = $RS_Nota->fetch_assoc(); 
unset($Nota_);
$i = -4;
foreach ($row_Nota as $Clave => $Nota){
	echo $Clave ."( $i )= ". $Nota . "<br>" ;
	$Nota_[$i++] = $Nota;
	
}

$Nota_[2] = round( (($Nota_[2]+$Nota_[3])/2) , 0);
$Nota_[3] = $Nota_[4];
$Nota_[4] = $Nota_[5];
$Nota_[5] = $Nota_[6];
$Nota_[6] = $Nota_[7];
$Nota_[7] = $Nota_[8];

$CodigoCurso = 	$row_Nota['CodigoCurso'];
	
if($CodigoCurso == 35 or $CodigoCurso == 36){ // 7mo
	//$Nota_[12] = $Nota_[12];
	$Nota_[13] = round( (($Nota_[9] + $Nota_[10] + $Nota_[11])/3) , 0);
	$Nota_[8] = "";
	$Nota_[9] = "";
	$Nota_[10] = "";
	$Nota_[11] = "";
	}
elseif($CodigoCurso == 37 or $CodigoCurso == 38){ // 8vo
	//$Nota_[12] = $Nota_[11];
	$Nota_[13] = round( (($Nota_[9] + $Nota_[10])/2) , 0);
	$Nota_[8] = "";
	$Nota_[9] = "";
	$Nota_[10] = "";
	$Nota_[11] = "";
	}
elseif($CodigoCurso == 39 or $CodigoCurso == 40){ // 9no
	//$Nota_[12] = $Nota_[12];
	$Nota_[13] = round( (($Nota_[10] + $Nota_[11])/2) , 0);
	$Nota_[8] = $Nota_[9];
	$Nota_[9] = "";
	$Nota_[10] = "";
	$Nota_[11] = "";
	}
elseif($CodigoCurso == 41 or $CodigoCurso == 42){ // 4to
	//$Nota_[12] = $Nota_[12];
	$Nota_[13] = $Nota_[11];
	$Nota_[8] = $Nota_[9];
	$Nota_[9] = $Nota_[10];
	$Nota_[10] = "";
	$Nota_[11] = "";
	}
elseif($CodigoCurso == 43 or $CodigoCurso == 44){ // 5to
	//$Nota_[12] = $Nota_[12];
	$Nota_[13] = $Nota_[5];
	$Nota_[8] = $Nota_[9];
	$Nota_[9] = $Nota_[10];
	$Nota_[10] = $Nota_[11];
	}
	

$Conteo = 0;
$Suma = 0;
for ($i = 1; $i <= 10; $i++) {
	if($Nota_[$i] > ""){
		$Suma += $Nota_[$i];
		$Conteo++;
	}
}
$Nota_[12] = round( $Suma/$Conteo , 0);



$sql_ = "DELETE FROM Nota WHERE CodigoAlumno = '". $CodigoAlumno."' AND 
						Lapso = 'Def_Ministerio' AND 
						Ano_Escolar = '2019-2020'";
$mysqli->query($sql_);						
echo $sql_ ."<br><br>";
$i = 0;				
$sql_ = "INSERT INTO Nota (CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13, Promedio)
VALUES ('$CodigoAlumno', '$CodigoCurso', '2019-2020', 'Def_Ministerio', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'".$Nota_[++$i]."', 
		'')
";
$mysqli->query($sql_);
echo $sql_ ."<br><br>";				

print_r($row_Nota);


// INSERT "Def_Ministerio"   
   
  ?>
  
  </td>
</tr>
<?php 	
	}
?>
    </table>&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>