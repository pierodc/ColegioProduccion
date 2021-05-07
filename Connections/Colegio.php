<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Colegio = "localhost";
$database_Colegio = "colegio_db";
$username_Colegio = "colegio_colegio";
$password_Colegio = "colegio";
$Colegio = mysql_pconnect($hostname_Colegio, $username_Colegio, $password_Colegio) or die(mysql_error());
?>