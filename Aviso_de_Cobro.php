<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$_var = new Variable();
$Cambio_Dolar_Hoy = $_var->view('Cambio_Dolar');

//echo $Cambio_Dolar_Hoy;

/*
echo "<pre>";
var_dump($_POST);
echo "</pre>";
*/

$Alumno = new Alumno($CodigoAlumno);

$sql_Trace = "INSERT INTO Usuario_Logs 
			(CodigoUsuario, Usuario, Computador, IP, Ruta, QueryStr) 
			VALUES 
			('0000' ,
			 '" . $CodigoAlumno . "' ,
			 '" . $_SERVER['HTTP_USER_AGENT'] . "' ,
			 '" . $_SERVER['REMOTE_ADDR'] . "' ,
			 '" . $_SERVER['PHP_SELF'] . "' ,
			 '" . $_SERVER['QUERY_STRING'] . "' )";
		//echo $sql_Trace;
		//$LoginRS = mysql_query($sql_Trace, $bd) or die(mysql_error());
		$mysqli->query($sql_Trace);

// RECIBE FORMULARIO
if (isset($_POST['Tipo'])){
	// UBICA REF DUPLICADA
	$query_RS_Busca_Referencia = sprintf("SELECT * FROM ContableMov 
										  WHERE Referencia = %s 
										  AND Tipo = %s 
										  AND MontoHaber = %s", 
										  GetSQLValueString($_POST['Referencia'], "int"),
										  GetSQLValueString($_POST['Tipo'], "text"),
										  GetSQLValueString($_POST['Monto'], "double"));
	$RS_Busca_Referencia = $mysqli->query($query_RS_Busca_Referencia);
	$totalRows_RS_Busca_Referencia = $RS_Busca_Referencia->num_rows;
	
	/*$mensaje = "";
	if ($_GET[mensaje]=='duplicado') {
		$mensaje = "El instrumento de pago ya fue utilizado. El pago no se registr&oacute;";
	}*/
	
	if ($totalRows_RS_Busca_Referencia > 0 ) { // REFERENCIA DUPLICADA 
		$mensaje = "El instrumento de pago ya fue utilizado<br>El pago NO se registr&oacute;";
		$ColorMensaje = "danger";//success
		//$retorna = $_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."";
		//header("Location: ".$retorna); 
}// FIN UBICA REF DUPLICADA
else{

	if ($_POST["Email_Pago"] > "") {
		$sql = "UPDATE Alumno SET Email_Pago = '".$_POST["Email_Pago"]."'
				WHERE CodigoAlumno = '$CodigoAlumno'";
		$mysqli->query($sql);		
	}
	$Fecha = $_POST['F_Ano'].'-'.$_POST['F_Mes'].'-'.$_POST['F_Dia'];
	
	$RegistradoPor = "ww " . $MM_Username;
	
	$MontoHaber_Dolares = round($_POST['Monto'] / $Cambio_Dolar_Hoy , 2);
	
	$insertSQL = sprintf("INSERT INTO ContableMov 
	( CodigoPropietario, Tipo, CodigoCuenta, BancoOrigen, CiRifEmisor,
	  Referencia, ReferenciaOriginal, Fecha, MontoHaber, Descripcion,
	  RegistradoPor, Observaciones, FacturaCia, Email_Pago, Whatsapp,
	  CodigoReciboCliente, Cambio_Dolar, MontoHaber_Dolares, SW_Moneda) 
	VALUES (%s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, %s, %s, %s)",
	
	GetSQLValueString($CodigoAlumno, "text"),
	GetSQLValueString($_POST['Tipo'], "text"),
	GetSQLValueString($_POST['CodigoCuenta'], "text"),
	GetSQLValueString($_POST['BancoOrigen'], "text"),
	GetSQLValueString($_POST['CiRifEmisor'], "text"),
	
	GetSQLValueString($_POST['Referencia']*1, "text"),
	GetSQLValueString($_POST['Referencia']*1, "text"),
	GetSQLValueString($Fecha , "date"),
	GetSQLValueString(coma_punto($_POST['Monto']), "double"),
	GetSQLValueString("Abono a cuenta", "text"),
	
	GetSQLValueString($RegistradoPor, "text"),
	GetSQLValueString($_POST['Observaciones'], "text"),
	GetSQLValueString($_POST['FacturaCia'], "text"),
	GetSQLValueString($_POST['Email_Pago'], "text"),
	GetSQLValueString($_POST['Whatsapp'], "text"),
	GetSQLValueString($_POST['CodigoReciboCliente'], "text"),
	GetSQLValueString($_POST['Cambio_Dolar'], "text"),
	GetSQLValueString($MontoHaber_Dolares, "text"),
	GetSQLValueString("B", "text"));
	
	
	
	
	$mysqli->query($insertSQL);
	$mensaje = "Pago registrado<br>Deber&aacute; ser verificado por la administraci&oacute;n";
	$ColorMensaje = "success";//
	//echo $insertSQL;	
	}
} 
// FIN RECIBE FORMULARIO



$sql_busca_Dolares = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoAlumno
									AND SWCancelado = '0' 
									AND MontoDebe_Dolares > 0";
$RS_busca_Dolares = $mysqli->query($sql_busca_Dolares);
$totalRows_RS_busca_Dolares = $RS_busca_Dolares->num_rows;

if( $totalRows_RS_busca_Dolares > 0 )									
while($row_busca_Dolares = $RS_busca_Dolares->fetch_assoc()){
	$MontoDebe_Dolares = round(($row_busca_Dolares['MontoDebe_Dolares'] - $row_busca_Dolares['MontoAbono_Dolares']) * $Cambio_Dolar_Hoy ,2);
	$sql_Upt_Dolares = "UPDATE ContableMov 
						SET MontoDebe = '$MontoDebe_Dolares' 
						WHERE Codigo = '".$row_busca_Dolares['Codigo']."'";
	$mysqli->query($sql_Upt_Dolares);			
	}







// Conceptos pendiente
$query_Pendiente = "SELECT * FROM ContableMov 
					WHERE CodigoPropietario = '$CodigoAlumno' 
					AND SWCancelado = '0' 
					AND MontoDebe > 0
					ORDER BY Fecha ASC, Codigo ASC"; //echo $query_Pendiente;
$Pendiente = $mysqli->query($query_Pendiente);
if ($Pendiente->num_rows){
	while ($row_Pendiente = $Pendiente->fetch_assoc()){
		extract($row_Pendiente);
		$MontoBasePendiente = $MontoDebe - $MontoAbono; 
		$MontoIVA = round($SWiva  * $MontoBasePendiente * $P_IVA_1 / 100 , 2);
		$TotalPendiente = $MontoBasePendiente + $MontoIVA;	
		$DeudaMes[$row_Pendiente['ReferenciaMesAno']] += $TotalPendiente;
		$DetalleMes[$row_Pendiente['ReferenciaMesAno']][] = $row_Pendiente;
	}
}


// PAGOS PENDIENTE DE PROCESAR
$query_Pagos = "SELECT * FROM ContableMov 
					WHERE CodigoPropietario = '$CodigoAlumno' 
					AND SWCancelado = '0' 
					AND MontoHaber > 0
					ORDER BY Fecha ASC, Codigo ASC"; //echo $query_Pendiente;
$Pagos = $mysqli->query($query_Pagos);
if ($Pagos->num_rows){
	while ($row_Pagos = $Pagos->fetch_assoc()){
		$DetallePagos[] = $row_Pagos;
	}
}




?><!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <!--meta charset="utf-8"-->
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script language="javascript" type="text/javascript">
    //*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    
	function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    function ValDecimal(Control){
        Control.value = Control.value.replace(/[^0-9,]+/g,'');
		return Control;
    }
    
	//*** Fin del Codigo para Validar que sea un campo Numerico

</script>

  
 <!-- Latest compiled and minified CSS >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"-->

<!-- Optional theme >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"-->

<!-- Latest compiled and minified JavaScript >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script-->



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="common.css">
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AUTOFILL -->
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<style>
.dropdown-menu {
	position:relative;
	width:100%;
	top: 0px !important;
    left: 0px !important;
}
</style>
<!-- AUTOFILL -->




<!--meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /-->
<title><?php echo $row_RS_Alumno['Nombres'] ." ". $row_RS_Alumno['Apellidos']; ?></title>




</head>
<body>


<div class="container-fluid">
<? if ($mensaje>""){ ?>

	<div class="row">
		<div class="col-md-12">
			<div class="page-header text-center bg-<?= $ColorMensaje ?> ">
				<h1>
					<? echo $mensaje; ?> 
				</h1>
			</div>
		</div>
	</div>

<? } ?>
<? 
if ($Pagos->num_rows){
?>

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>
					Pagos Por Procesar 
				</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>
							Fecha
						</th>
						<th>
							<div align="right">Monto</div>
						</th>
					</tr>
				</thead>
				<tbody>
<? 
foreach ($DetallePagos as $Detalle){
?>                
					<tr class="warning">
						<td>
							<? echo DDMMAAAA($Detalle['Fecha']); ?>
						</td>
						<td align="right">
							<? echo Fnum($Detalle['MontoHaber']); ?>
						</td>
					</tr>
<?
}
?>
				</tbody>
			</table>
		</div>
	</div>




<? } ?>


	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>
				Aviso de Cobro </h1>
				<h1>Esperamos esten muy bien y resguardados en casa. En el colegio estamos haciendo nuestro mayor esfuerzo para poder cumplir con el soporte de los docentes y demas personal, sin embargo no es posible cumplir a cabalidad sin el aporte de los padres.<br>
				  <small>Alumno:<br><?php echo $Alumno->NombreApellido(); ?></small>
			  </h1>
			</div>
		</div>
	</div>

	<div class="row">
        <div class="col-md-12">
            <h2 class="text-primary">
                Pendiente
            </h2>
             
 
            <p>Estimado Sr Representante, le recordamos que debe cancelar la mensualidad dentro de lo <strong>primeros cinco dias de cada mes</strong>.</p>
            <p>Evite hacer cola en caja, Cancele y registre su pago con tiempo para poder ser procesado en 24 a 48 horas.</p>
            <p>Si Ud. ya realiz&oacute; el pago de la siguiente relaci&oacute;n por favor haga caso omiso a la misma.</p>
            <p>Nuestros registros indican que para la fecha:
              <?= date('d-m-Y') ?>
Ud. tiene una deuda con el Colegio seg&uacute;n le indicamos a continuaci&oacute;n: </p>
        </div>
    </div>    
    <div class="row">
		<div class="col-md-12">
			<div class="panel-group" id="panel-<?= 0 ?>">
<?
foreach ($DeudaMes as $MesAno => $Deuda){
?>              
				<div class="panel panel-default">
					<div class="panel-heading">
                    	 <div class="text-left">
                         <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-<?= 0 ?>" href="#panel-element-<?= ++$PanelNo ?>">
						 <?php echo "  ".Mes_Ano($MesAno) ;  ?></a>
                         </div>
                         
                         <div class="text-center">
                         
						 <?php  echo Fnum($Deuda / $Cambio_Dolar_Hoy); ?>
                         
                        
                        </div>
						
                         
                         <div class="text-right">
                         <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-<?= 0 ?>" href="#panel-element-<?= $PanelNo ?>">
						 <?php  echo Fnum($Deuda); ?>
                         
                         
                         <span class="glyphicon glyphicon-eye-open" ></span></a>
                        </div>
						
					</div>
					<div id="panel-element-<?= $PanelNo ?>" class="panel-collapse collapse">
						<div class="panel-body">
							<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>
							Descripción
						</th>
						<th>
							<div align="right">s</div>
						</th><th>
							<div align="right">Monto</div>
						</th>
					</tr>
				</thead>
				<tbody>
<?
foreach ($DetalleMes[$MesAno] as $Detalle){
		$MontoBasePendiente = $Detalle['MontoDebe'] - $Detalle['MontoAbono'];
		$MontoIVA = round($Detalle['SWiva']  * $MontoBasePendiente * round($P_IVA_2 / 100 , 2) , 2);
		$MontoAbonado = $Detalle['MontoAbono'] + $MontoIVA; 
		$TotalPendiente = $MontoBasePendiente + $MontoIVA;
?>                
					<tr>
						<td>
							<?php echo $Detalle['Descripcion'] ?>
						</td>
                        
						<td align="right">
							<?php echo Fnum($TotalPendiente / $Cambio_Dolar_Hoy) ?>
						</td>
                        
						<td align="right">
                        <?
                        if ($Detalle['MontoAbono'] > 0) {
								echo "(Abono: ".Fnum($MontoAbonado) ." )";
							}
						?>
							<?php echo Fnum($TotalPendiente) ?>
						</td>
					</tr>
<?
$TotalDeuda += $TotalPendiente;
	}
       ?>                    
				</tbody>
			</table>
						</div>
					</div>
				</div>
                
 <? } ?>               
			</div>
			
		</div>
	</div>
    <div class="row">
		<div class="col-md-12">
			<h3 class="text-right">
				<? echo "Total " . Fnum($TotalDeuda); ?>  
			</h3>
		</div>
	</div>
        
<div class="row">
        <div class="col-md-12">
            <p>
            Le agradecemos hacer efectivo su pago con el Colegio dentro de los primeros 5 días de cada mes
            </p>
            <p>
            Le recordamos los números de cuenta del Colegio<br>
            Banco Mercantil (<strong>sólo desde Mercantil</strong>) 0105-0079-6680-7903-7183 <br>
            Banco Provincial 0108-0013-7801-0000-4268</p>
            <p>RIF: J 00 13 70 23 4 . Colegio San Francisco de Asis</p>
            
        </div>
    </div>    

<hr>
           
<div class="row">
    <div class="col-md-12">
        <h2 class="text-primary">
            Forma de Pago
        </h2>
        <p>
            Agradecemos indicar todos los detalles para facilitar el proceso de conciliar su pago y posterior facturación.
        </p>
    </div>
</div>
            
<div class="row">
    <div class="col-md-12">
        <form role="form" autocomplete="off" method="POST" action="">
        
            
            <div class="form-group">
            <label for="exampleFormControlSelect1">Tipo pago</label>
            <select class="form-control" name="Tipo" id="exampleFormControlSelect1" required>
              <option value="0">Seleccione...</option>
              <option value="2">Transferencia</option>
              <option value="1">Deposito</option>
            </select>
            <small id="emailHelp" class="form-text text-muted">Depósito o Transferencia</small>
            </div>
            
            <div class="form-group">
            <label for="exampleFormControlSelect1">En el Banco</label>
            <select class="form-control" name="CodigoCuenta" id="exampleFormControlSelect1" required >
              <option value="0">Seleccione...</option>
              <option value="1">Mercantil</option>
              <option value="2">Provincial</option>
			  <option value="99">Otro</option>              
            </select>
            <small id="emailHelp" class="form-text text-muted">Cuenta receptora del pago</small>
            </div>
            
            <div class="form-group">
                <label for="BancoOrigen">
                    Desde el Banco
                </label>
                <input type="text" class="form-control typeahead twitter-typeahead" data-provide="typeahead" name="BancoOrigen" id="BancoOrigen" placeholder="Nombre de su banco" />
            </div>
			
            <div class="form-group">
                <label for="exampleInputEmail1">
                    Cédula o RIF de su cuenta
                </label>
                <input type="tel" class="form-control" name="CiRifEmisor" id="exampleInputEmail1" placeholder="Cédula o RIF del titular de su cuenta" required onKeyUp="return ValNumero(this);"  />
                <small id="emailHelp" class="form-text text-muted">Solo números</small>
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">
                    Referencia
                </label>
                <input type="tel" class="form-control" name="Referencia" id="exampleInputEmail1" placeholder="No. referencia bancaria" required onKeyUp="return ValNumero(this);"  />
            </div>
            
            <div class="form-row">
            <label for="exampleFormControlSelect1">Fecha del pago</label>
            </div>   
            
            <div class="form-row">
            	<div class="col-xs-4">
          		<!--div class="form-row">
                  <div class="form-group col-xs-4"-->
                  <label for="exampleFormControlSelect1">Dia</label>
                    <select class="form-control" name="F_Dia" id="exampleFormControlSelect1" required>
                      <option></option>
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                    </select>
                </div>
                <div class="col-xs-4">
          		<!--div class="form-group col-xs-4"-->
                 <label for="exampleFormControlSelect1">Mes</label>
                    <select class="form-control" name="F_Mes" id="exampleFormControlSelect1" required>
                      <option></option>
                      <option value="01" selected>Enero</option>
                      <option value="02" >Febrero</option>
                      <option value="03" >Marzo</option>
                      <option value="04" >Abril</option>
                      <option value="05" >Mayo</option>
                      <option value="06" >Junio</option>
                      <option value="07" >Julio</option>
                      <option value="08" >Agosto</option>
                      <option value="09" >Septiembre</option>
                      <option value="10" >Octubre</option>
                      <option value="11" >Noviembre</option>
                      <option value="12" >Diciembre</option>
                    </select>
                </div>
                <div class="col-xs-4">
          		<!--div class="form-group col-xs-4"-->
                  <label for="exampleFormControlSelect1">Año</label>
                    <select class="form-control small" name="F_Ano" id="exampleFormControlSelect1" required>
                      <option><?= date('Y')-1 ?></option>
                      <option selected><?= date('Y') ?></option>
                      <option><?= date('Y')+1 ?></option>
                    </select>
                </div>
              </div>
  
  			<div class="form-group">
                <label for="exampleInputEmail1">
                    Monto
                </label>
                <input type="text" class="form-control" name="Monto" id="Monto" placeholder="0,00" required onKeyUp="return ValDecimal(this);"  />
            </div>
            
            
            <div class="form-group">
                <label for="exampleInputEmail1">
                    IMPORTANTE: indique los conceptos que est&aacute; cancelando con este pago</label>
                <input type="text" class="form-control" name="Observaciones" required id="exampleInputEmail1" placeholder="indique los conceptos que est&aacute; cancelando" />
            </div>
            
            
            <div class="form-group">
            <label for="CodigoReciboCliente">Facturar a nombre de</label>
            <select class="form-control" name="CodigoReciboCliente" id="CodigoReciboCliente"  >
              <option value="0">Seleccione...</option>
              <?php 
				$sql = "SELECT * FROM ReciboCliente
						WHERE CodigoAlumno = '$CodigoAlumno'";
				$RS = $mysqli->query($sql);
				if ($RS->num_rows){
					while ($row = $RS->fetch_assoc()){
						extract($row);
						echo "<option value=\"$Codigo\"";
						echo ">$Nombre</option>";
					} 
				}  ?>
            </select>
            </div>
            
            
           <div class="form-group">
                <label for="exampleInputEmail1">
                    ¿Factura a nombre de Compañía?
                </label>
                <input type="text" class="form-control" name="FacturaCia" id="exampleInputEmail1" placeholder="Indique detalles para la facturación" />
            </div>
            
            
            <div class="form-group">
                <label for="exampleInputEmail1">
                    Email
                </label>
                <input type="email" class="form-control" name="Email_Pago" id="exampleInputEmail1" />
                <small id="emailHelp" class="form-text text-muted">Para ser notificado</small>
            </div>
            
            <div class="form-group">
                <label for="exampleInputEmail1">
                    Cel WhatsApp
                </label>
                
                <input type="hidden" name="Cambio_Dolar" value="<? echo $Cambio_Dolar_Hoy ?>" size="15"  />
                
                <input type="tel" class="form-control" name="Whatsapp" id="exampleInputEmail1" placeholder="Para poder contactarle en caso de alguna duda" onKeyUp="return ValNumero(this);"  />
            </div>
           
            
            <button type="submit" class="btn btn-primary btn-lg">
                Enviar
            </button>
        </form>
    </div>
</div>
    
<hr>
     
<div class="row">
    <div class="col-md-12">
        <h2 class="text-primary">
            Desglose asignaciones mensuales
        </h2>
    </div>
    <div class="col-md-12">
        <table  class="table table-condensed table-striped">
  <tbody>
    <tr>
      <th scope="col">Concepto</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col" align="right">Monto</th>
    </tr>
<? 
$query_RS_AsignacionesXAlumno = "
		SELECT * FROM AsignacionXAlumno, Asignacion 
		WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
		AND AsignacionXAlumno.Ano_Escolar = '$AnoEscolar'
		AND AsignacionXAlumno.CodigoAlumno = '".$CodigoAlumno. "' 
		ORDER BY Orden";
		//echo $query_RS_AsignacionesXAlumno;
$RS_AsignacionesXAlumno = $mysqli->query($query_RS_AsignacionesXAlumno);

while ($row_RS_AsignacionesXAlumno = $RS_AsignacionesXAlumno->fetch_assoc()) { 
	$subtotal = $row_RS_AsignacionesXAlumno['Monto'] - $row_RS_AsignacionesXAlumno['Descuento'] - 
				($row_RS_AsignacionesXAlumno['Monto'] * ($row_RS_AsignacionesXAlumno['DescuentoPorciento'] / 100));
	$SumaMensualidad += $subtotal;
			  

 ?>    
    <tr>
      <th scope="row">&nbsp;<?php echo $row_RS_AsignacionesXAlumno['Descripcion']; ?></th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;<? if ($row_RS_AsignacionesXAlumno['Descuento'] > 0) {echo $row_RS_AsignacionesXAlumno['Monto'] . " - " . $row_RS_AsignacionesXAlumno['Descuento'];} ?></td>
      <td>&nbsp;<? if ($row_RS_AsignacionesXAlumno['DescuentoPorciento'] > 0) {echo $row_RS_AsignacionesXAlumno['Monto'] . " - (".$row_RS_AsignacionesXAlumno['DescuentoPorciento']."%)";} ?></td>
      <td align="right">&nbsp;<?php echo Fnum($subtotal); ?></td>
    </tr>
<? } ?>    
<tr>
<th scope="row">&nbsp;</th>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right">Total Mensual</td>
<td align="right">&nbsp;<?= Fnum($SumaMensualidad); ?></td>
</tr>

  </tbody>
</table>
    </div>
</div>      

            
</div>

           
   


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS >
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script-->
 
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	var data = 
	[{"name":"Banesco"},{"name":"Mercantil"},{"name":"Provincial"},{"name":"BOD"},{"name":"Del Caribe"},
	{"name":"Banco Nacional de Credito BNC"},{"name":"Venezuela"},{"name":"Venezolano de Credito"},{"name":"Banco Occidental de Descuento BOD"},{"name":"Del Caribe"},
	{"name":"100% Banco"},{"name":"Caroní"},{"name":"Fondo Común"},{"name":"Industrial de Vzla"},{"name":"Plaza"},
	{"name":"Banfanb"},{"name":"Banplus"},{"name":"del Tesoro"},{"name":"Exterior"},{"name":"Sodexo Pass Venezuela"},
	{"name":"Todoticket Banesco"}
	];
	
	var $input = $(".typeahead");
	
	$input.typeahead({
	  source: data,
	  autoSelect: true
	});
});
</script>