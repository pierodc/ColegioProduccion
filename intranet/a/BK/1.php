<?php

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

/*
mysql_select_db($database_bd, $bd);
$query = "SELECT * FROM Nota 
			WHERE Lapso = 'Def' 
			AND ( ( CodigoCurso >= 35 AND CodigoCurso <= 40 ) OR CodigoCurso = 46 OR CodigoCurso = 48 )
			ORDER BY CodigoAlumno, Ano_Escolar ";
$RS_ = mysql_query($query, $bd) or die(mysql_error());
$row_ = mysql_fetch_assoc($RS_);
$totalRows_RS_ = mysql_num_rows($RS_);
*/

$líneas = file('archivo/Variables.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Recorre nuestro array, muestra el código fuente HTML como tal
// y muestra tambíen los números de línea.

// Otro ejemplo, vamos a escribir una página web en una cadena. Vea también file_get_contents().
//$html = implode('', file('http://www.example.com/'));

// Usando el parámetro opcional banderas a partir de PHP 5
//$recortes = file('fichero.txt');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 
<title>Administraci&oacute;n SFDA</title>
</head>
<body>
<?php 	


/*
$sqlINSERT = "INSERT INTO Notas_Certificadas (CodigoAlumno, Grado, Orden, Nota, TE, Mes, Ano, Materia, Plantel) VALUES <br>";
do{
	extract($row_);
	
	if($CodigoAlumnoAnterior != $CodigoAlumno)
		$sqlINSERT .= " <br>";
	$CodigoAlumnoAnterior = $CodigoAlumno;
	
	if( $CodigoCurso == 35 or $CodigoCurso == 36 or $CodigoCurso == 46 ) $Grado = '7';
	if( $CodigoCurso == 37 or $CodigoCurso == 38 or $CodigoCurso == 48 ) $Grado = '8';
	if( $CodigoCurso == 39 or $CodigoCurso == 40 ) $Grado = '9';
	if( $CodigoCurso == 41 or $CodigoCurso == 42 ) $Grado = 'IV';
	if( $CodigoCurso == 43 or $CodigoCurso == 44 ) $Grado = 'V';
	
	$sqlBusca = "SELECT * FROM Notas_Certificadas
				 WHERE CodigoAlumno = '$CodigoAlumno'
				 AND Grado = '$Grado'
				 AND Mes = 'ET'";
				 
	$RS_Busca = mysql_query($sqlBusca, $bd) or die(mysql_error());
	$row_Busca = mysql_fetch_assoc($RS_Busca);
	$totalRows_RS_Busca = mysql_num_rows($RS_Busca);
	
	if($totalRows_RS_Busca == 0){
	
		$query_RS_Materias = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$Grado."'";
		$RS_Materias = mysql_query($query_RS_Materias, $bd) or die(mysql_error());
		$row_RS_Materias = mysql_fetch_assoc($RS_Materias);
		
		foreach (array('10', '11') as $fila_x) {
			
			if($row_['n'.$fila_x]>'00'){
				
				if(($Grado==7 or $Grado==8 or $Grado==9)){
					
					$sqlINSERT .= " <br>('$CodigoAlumno', ";
					$sqlINSERT .= " '$Grado', ";
					$Orden =  ($fila_x*1)+10;
					$sqlINSERT .= " '". $Orden ."', ";
					$sqlINSERT .= " '4', ";
					$sqlINSERT .= " '', ";
					$sqlINSERT .= " 'ET', ";
					$sqlINSERT .= " '', ";
					$sqlINSERT .= " '".$row_RS_Materias['Materia'.$fila_x]."', ";
					$sqlINSERT .= " ''),";
					
					
				}
				
					
			}
		}
	}
	
	
} while($row_ = mysql_fetch_assoc($RS_));

$sqlINSERT = substr($sqlINSERT, 0, strlen($sqlINSERT)-1);
//$sqlINSERT = str_replace('<br>','',$sqlINSERT);
//echo mysql_query($sqlINSERT, $bd);

echo 'sqlINSERT = '.$sqlINSERT;	
	*/
	?>
<form id="form1" name="form1" method="post" action="">
<table width="600" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php 

foreach ($líneas as $num_línea => $línea) {
    //echo "Línea #<b>{$num_línea}</b> : " . htmlspecialchars($línea) . "<br />\n";
	$Var = explode(" = ",$línea);

?>
  <tr>
    <td><?php echo $Var[0]; ?>&nbsp;</td>
    <td><input type="text" name="<?php echo $Var[0]; ?>" id="textfield" value="<?php echo $Var[1]; ?>" /></td>
  </tr>
  
<?php } ?>  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>

</html>
