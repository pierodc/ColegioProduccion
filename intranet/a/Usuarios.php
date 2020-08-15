<?php 
$MM_authorizedUsers = "99,91,95";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 




$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE Usuario SET Usuario=%s, Clave=%s, Nombres=%s, Apellidos=%s, Telefonos=%s, Email=%s WHERE Codigo=%s",
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Telefonos'], "text"),
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());

  $updateGoTo = "Usuarios.php?g=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//Busca para editar
$colname_RS_Usuarios = "xx-1";
if (isset($_POST['UsuarioBuscar'])) {
  $colname_RS_Usuarios = $_POST['UsuarioBuscar'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Usuarios = sprintf("SELECT * FROM Usuario WHERE Usuario LIKE %s ORDER BY Usuario ASC", GetSQLValueString($colname_RS_Usuarios.'%', "text"));
//echo $query_RS_Usuarios;
$RS_Usuarios = mysql_query($query_RS_Usuarios, $bd) or die(mysql_error());
$row_RS_Usuarios = mysql_fetch_assoc($RS_Usuarios);
$totalRows_RS_Usuarios = mysql_num_rows($RS_Usuarios);

$colname_RS_Usuario = "-1";
if (isset($_GET['Codigo'])) {
  $colname_RS_Usuario = $_GET['Codigo'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Usuario = sprintf("SELECT * FROM Usuario WHERE Codigo = %s", GetSQLValueString($colname_RS_Usuario, "int"));
//echo $query_RS_Usuarios;
$RS_Usuario = mysql_query($query_RS_Usuario, $bd) or die(mysql_error());
$row_RS_Usuario = mysql_fetch_assoc($RS_Usuario);
$totalRows_RS_Usuario = mysql_num_rows($RS_Usuario);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
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
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php   
	$TituloPantalla ="Usuario";
	require_once('TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div align="center">
        <table width="95%"  border="0" align="center">
          <tr>
            <td width="50%" class="subtitle">Buscar</td>
            <td width="50%" class="subtitle"><?php if( $totalRows_RS_Usuario > 0 and !isset($_GET[g])) { ?>Usuario<?php } ?></td>
          </tr>
          <tr>
            <td valign="top" class="TextosSimples12"><form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <div align="center">
                Buscar 
                <input name="UsuarioBuscar" type="text" id="UsuarioBuscar">
                <input type="submit" name="Submit" value="Buscar">
                </div>
            </form><br>
              <?php if( $totalRows_RS_Usuarios > 0 ) { ?>
              <?php  do { ?>
              <a href="Usuarios.php?Codigo=<?php echo $row_RS_Usuarios['Codigo']; ?>"><?php echo $row_RS_Usuarios['Usuario']; ?></a> (
              <?php 
			  // Cantidad de Alumnos bajo este login
			  
			  	mysql_select_db($database_bd, $bd);
				$query_RS_NAlum = sprintf("SELECT * FROM Alumno WHERE Creador = '%s'", $row_RS_Usuarios['Usuario']);
				//echo $query_RS_NAlum;
				$RS_NAlum = mysql_query($query_RS_NAlum, $bd) or die(mysql_error());
				$row_RS_NAlum = mysql_fetch_assoc($RS_NAlum);
				$totalRows_RS_NAlum = mysql_num_rows($RS_NAlum);
				echo $totalRows_RS_NAlum;

			  ?>
)<br>
<br>
<?php } while ($row_RS_Usuarios = mysql_fetch_assoc($RS_Usuarios)); ?>
<?php } ?></td>
            <td valign="top" nowrap class="TextosSimples12"><?php if( $totalRows_RS_Usuario > 0) { ?>
			<form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
			  <table width="100%" border="0" align="center">
                
                <tr>
                  <td class="NombreCampo">
                    <input name="Codigo" type="hidden" id="Codigo" value="<?php if($row_RS_Usuario['Usuario']!='piero'){echo $row_RS_Usuario['Codigo'];} ?>">
                    Nombre                  </td>
                  <td class="FondoCampo"><input name="Nombres" type="text" id="Usuario3" value="<?php echo $row_RS_Usuario['Nombres']; ?>"></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Apellido</td>
                  <td class="FondoCampo"><input name="Apellidos" type="text" id="Usuario4" value="<?php echo $row_RS_Usuario['Apellidos']; ?>"></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Telefono</td>
                  <td class="FondoCampo"><input name="Telefonos" type="text" id="Usuario5" value="<?php echo $row_RS_Usuario['Telefonos']; ?>"></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Fecha Creaci&oacute;n</td>
                  <td class="FondoCampo"><?php echo $row_RS_Usuario['FechaCreacion']; ?></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Privilegios</td>
                  <td class="FondoCampo"><?php echo $row_RS_Usuario['Privilegios']; ?></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Email/Usuario</td>
                  <td class="FondoCampo"><input name="Usuario" type="text" id="Usuario" value="<?php echo $row_RS_Usuario['Usuario']; ?>"></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Clave</td>
                  <td class="FondoCampo">
                  <? if($MM_UserGroup = "91") $Tipo = "text"; else $Tipo = "password"; ?>
                  <input name="Clave" type="<?= $Tipo ?>" id="Clave" value="<?php if($row_RS_Usuario['Usuario']!='piero'){echo $row_RS_Usuario['Clave']; } ?>"></td>
                </tr>
                <tr>
                  <td class="NombreCampo">Alumnos</td>
                  <td class="FondoCampo"><?php 
			// Lista Alumnos Bajo este login
			  
			  	mysql_select_db($database_bd, $bd);
				$query_RS_Alumnos = sprintf("SELECT * FROM Alumno WHERE Creador = '%s'", $row_RS_Usuario['Usuario']);
				//echo $query_RS_Alumnos;
				$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
				$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
				$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);
				//echo $totalRows_RS_Alumnos;

			 do {
			      echo $row_RS_Alumnos['Nombres'].", ".$row_RS_Alumnos['Apellidos']."<br>";
              } while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); 
 mysql_free_result($RS_Alumnos);
?></td>
                </tr>
                <tr>
                  <td><div align="right"><a href="../../index.php?doLogout=true&amp;Login=<?php echo $row_RS_Usuario['Usuario']; ?>&amp;Psw=<?php if($row_RS_Usuario['Usuario']!='piero'){ echo $row_RS_Usuario['Clave'];} ?>" style="font-weight: bold">usar</a></div></td>
                  <td><input type="submit" name="Submit" value="Guardar"></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form2">
            </form>
            <?php if($MM_Username =='piero' and false){ ?>
			<table width="100%" border="0" cellpadding="3">
			  <tr>
			    <td colspan="6">Ingreso</td>
			    <td rowspan="2" align="center">Salio</td>
			    <td rowspan="2" align="center">Tiempo</td>
			    <td rowspan="2">&nbsp;</td>
			    </tr>
			  <tr>
			    <td align="center">No</td>
			    <td align="center">A&ntilde;o</td>
			    <td align="center">Mes</td>
			    <td align="center">D&iacute;a</td>
			    <td align="center">Hora</td>
			    <td>&nbsp;</td>
			    </tr>
			  <?php 
				$sql = "SELECT * FROM Usuario_Logs
								WHERE CodigoUsuario = ".$row_RS_Usuario['Codigo']."
								ORDER BY Fecha_Registro_LogIn DESC"; 
				$RS_Accesos = mysql_query($sql, $bd) or die(mysql_error());
				$row_RS_Accesos = mysql_fetch_assoc($RS_Accesos);
				do{
					$DateLogin  = strtotime($row_RS_Accesos['Fecha_Registro_LogIn']);
					
					$DateLogout = strtotime($row_RS_Accesos['Fecha_LogOut']);
					
					
					
				?><tr>
			    <td align="right" class="ListadoPar12">&nbsp;<?php echo ++$No; ?></td>
			    <td align="right" class="ListadoPar12">&nbsp;<?php if(date('Y',$DateLogin)!=$AnoAnte) echo date('Y',$DateLogin); ?></td>
			    <td align="right" class="ListadoPar12">&nbsp;<?php if(date('m',$DateLogin)!=$MesAnte) echo date('m',$DateLogin); ?></td>
			    <td align="right" class="ListadoPar12">&nbsp;<?php if(date('d',$DateLogin)!=$DiaAnte) echo date('d',$DateLogin); ?></td>
			    <td align="right" class="ListadoPar12">&nbsp;<?php echo date('g:i a',$DateLogin); ?></td>
			    <td class="ListadoPar12">&nbsp;</td>
			    <td align="center" class="ListadoPar12">&nbsp;<?php echo $DateLogout>0?date('g:i a',$DateLogout):''; ?></td>
			    <td align="right" class="ListadoPar12">&nbsp;<?php 
				
				$AnoAnte = date('Y',$DateLogin);
				$MesAnte = date('m',$DateLogin);
				$DiaAnte = date('d',$DateLogin);
				
				if($DateLogout>0){
					$TiempoHrLog  = floor(($DateLogout-$DateLogin)/3600 ); 
	
					$TiempoMinLog = floor((($DateLogout-$DateLogin) - $TiempoHrLog*3600)/60) ; 
					
					if($TiempoHrLog>0) 
						echo $TiempoHrLog.' hr ';
					
					if($TiempoMinLog>0 and $TiempoMinLog<61 or true) 
						echo $TiempoMinLog.' min';
				}
				?></td>
			    <td class="ListadoPar12">&nbsp;</td>
			    </tr><?php } while($row_RS_Accesos = mysql_fetch_assoc($RS_Accesos)); ?></table><?php }} // fin despliega si voy a modificar?></td>
          </tr>
          <tr>
            <td valign="top" class="TextosSimples12">&nbsp;</td>
            <td valign="top" nowrap class="TextosSimples12">&nbsp;</td>
          </tr>
         
        </table>
      </div></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
