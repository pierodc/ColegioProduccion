<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bd_bk = "localhost";
$database_bd_bk = "colegio_BK";
$username_bd_bk = "colegio_colegio";
$password_bd_bk = "kepler";
$bd_bk = mysql_pconnect($hostname_bd_bk, $username_bd_bk, $password_bd_bk) or trigger_error(mysql_error(),E_USER_ERROR); 
?>